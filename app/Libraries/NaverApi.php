<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class NaverApi
{
    protected CURLRequest $client;
    protected string $baseUrl = "https://api.commerce.naver.com/external";
    protected string $clientId;
    protected string $clientSecret;

    protected ?string $accessToken = null;

    protected string $shopType = 'type8';

    public function __construct()
    {
        $this->clientId = '7VPYEPaTX0uve6cGgHkCIq';
        $this->clientSecret = '$2a$04$oZuxOFEh1TtEZ0RoxQslfe';

        $this->client = Services::curlrequest([
            'timeout'     => 30,
            'http_errors' => false,
            'headers'     => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function sendRequest(string $method, string $path, array $params = [], bool $requireAuth = true): array
    {
        $url = $this->baseUrl . $path;
        $options = [];

        if ($requireAuth) {
            if ($this->accessToken === null) {
                $this->issueAccessToken();
            }
            if ($this->accessToken === null) {
                throw new Exception("Access Token이 설정되지 않았습니다. issueAccessToken() 실패.");
            }
            $options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        if (strtoupper($method) === 'GET') {
            $options['query'] = $params;
        } else {
            $options['json'] = $params;

            if (isset($params['grant_type'])) {
                unset($options['json']);
                $options['form_params'] = $params;
            }
        }

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (Exception $e) {
            log_message('error', "[NaverAPI] Request Failed: " . $e->getMessage());
            throw new Exception("API 호출 중 통신 오류가 발생했습니다.");
        }

        $statusCode = $response->getStatusCode();
        if($statusCode == 200) {
            $body = $response->getBody();
            $decoded = json_decode($body, true);
            put_Shop_Api_Log($this->shopType,'Success', $this->baseUrl, $path, $params, $method, (string)$response->getBody());
        }else{
            $errorMsg = $decoded['message'] ?? $decoded['error_description'] ?? 'UnKnown_Error';
            $errorCode = $decoded['code'] ?? $decoded['error'] ?? 'Unknown';
            $t_msg = ['response' =>"[NaverAPI] Error ({$statusCode}): {$errorCode} - {$errorMsg}"];
            $Cnt = put_Shop_Api_Log($this->shopType,'Error', $this->baseUrl, $path, $params, $method, json_encode($t_msg));
            log_message('error', "[NaverAPI] Error ($statusCode): $errorCode - $errorMsg");
            $decoded = [];
        }

        return $decoded;
    }

    public function issueAccessToken(): string
    {
        $timestamp = (int)(microtime(true) * 1000);
        $password = $this->clientId . "_" . $timestamp;
        $signature = base64_encode(crypt($password, $this->clientSecret));

        $params = [
            'client_id' => $this->clientId,
            'timestamp' => $timestamp,
            'grant_type' => 'client_credentials',
            'client_secret_sign' => $signature,
            'type' => 'SELF',
        ];

        $response = $this->sendRequest('POST', '/v1/oauth2/token', $params, false);

        if (isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            return $this->accessToken;
        }
        throw new Exception("토큰 발급 실패: 응답에 access_token이 없습니다.");
    }

    public function getChangedOrderIds(string $lastChangedFrom, string $lastChangedTo, string $status = 'PAYED'): array
    {
        $uri = "/v1/pay-order/seller/product-orders/last-changed-statuses";
        $params = [
            'lastChangedFrom' => $lastChangedFrom,
            'lastChangedTo'   => $lastChangedTo, // 기간 조회시 To 파라미터 필요할 수 있음
            'lastChangedType' => $status
        ];

        $response = $this->sendRequest('GET', $uri, $params);

        if (!empty($response['data']['lastChangeStatuses'])) {
            return array_column($response['data']['lastChangeStatuses'], 'productOrderId');
        }

        return [];
    }

    public function getParsedOrderDetails(array $productOrderIds): array
    {
        if (empty($productOrderIds)) {
            return [];
        }

        $allRawData = [];
        $parsedData = [];

        $chunks = array_chunk($productOrderIds, 50);

        foreach ($chunks as $chunkIds) {
            $details = $this->getOrderDetails($chunkIds); // 기존 함수 재사용

            if (!empty($details)) {
                $allRawData = array_merge($allRawData, $details);
            }

            usleep(100000);
        }

        foreach ($allRawData as $order) {
            if (!isset($order['productOrder'])) {
                continue;
            }

            $pOrder = $order['productOrder'];
            $delivery = $pOrder['shippingAddress'] ?? []; // 배송지 정보가 없을 수도 있음

            $parsedData[] = [
                'order_id'       => $pOrder['productOrderId'] ?? '',
                'order_date'     => $pOrder['orderDate'] ?? '',
                'status'         => $pOrder['productOrderStatus'] ?? '', // PAYED, DISPATCHED 등
                'buyer_name'     => $delivery['name'] ?? '',
                'buyer_phone'    => $delivery['tel1'] ?? '',
                'address'        => trim(($delivery['baseAddress'] ?? '') . ' ' . ($delivery['detailedAddress'] ?? '')),
                'zipcode'        => $delivery['zipCode'] ?? '',
                'productId'   => $pOrder['productId'] ?? '',
                'product_name'   => $pOrder['productName'] ?? '',
                'product_option' => $pOrder['productOption'] ?? '',
                'quantity'       => $pOrder['quantity'] ?? 0,
                'price'          => $pOrder['totalPaymentAmount'] ?? 0,
                'mall_id'        => $pOrder['mallId'] ?? '',
                'shippingMemo'        => $pOrder['shippingMemo'] ?? ''
            ];
        }

        return $parsedData;
    }


    public function getOrderDetails(array $productOrderIds): array
    {
        if (empty($productOrderIds)) {
            return [];
        }

        $uri = "/v1/pay-order/seller/product-orders/query";
        $params = [
            'productOrderIds' => $productOrderIds
        ];

        $response = $this->sendRequest('POST', $uri, $params);

        // 네이버 응답 구조: { data: [ ...상세정보... ] }
        return $response['data'] ?? [];
    }

}