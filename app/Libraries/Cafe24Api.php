<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class Cafe24Api
{
    protected string $mallId;
    protected string $accessToken;
    protected string $apiVersion;
    protected string $baseUrl;
    protected string $shopType = 'type6';
    protected CURLRequest $client;

    public function __construct()
    {
        $this->mallId = 'daebon77';
        $this->accessToken = 'eaf19f45a0a79d964044c52368c88005e18a17e9';
        $this->apiVersion = '2024-06-01';

        $this->baseUrl = "https://{$this->mallId}.cafe24api.com/api/v2/";

        $this->client = Services::curlrequest([
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => "Bearer {$this->accessToken}",
                'X-Cafe24-Api-Version' => $this->apiVersion,
            ],
            'http_errors' => false,
            'timeout' => 30,
        ]);
    }

    /**
     * 주문 목록 조회 (GET)
     */
    public function getOrders($startdate,$enddate): array
    {
        $params = [
            'start_date' => $startdate,
            'end_date' => $enddate
        ];

        $endpoint = 'admin/orders';

        return $this->sendRequest('GET',$endpoint , $params);
    }

    /**
     * 주문 상세 조회 (GET)
     */
    public function getOrderDetail(string $orderId, array $embed = ['items', 'receivers', 'buyer']): array
    {
        $params = [];
        if (!empty($embed)) {
            $params['embed'] = implode(',', $embed);
        }

        return $this->sendRequest('GET', "admin/orders/{$orderId}", $params);
    }

    /**
     * (예시) 운송장 번호 등록 등 데이터를 보낼 때 (POST/PUT)
     * 필요할 때 이런 식으로 함수를 추가해서 쓰면 됩니다.
     */
    public function updateTrackingInfo(string $orderId, array $data): array
    {
        // 예: PUT /admin/orders/{order_id}/shipping-infos
        return $this->sendRequest('POST', "admin/orders/{$orderId}/shipping-infos", $data);
    }

    private function sendRequest(string $method, string $endpoint, array $params = []): array
    {
        try {
            $url = $this->baseUrl . $endpoint;
            $method = strtoupper($method); // 대문자 변환

            $options = [];

            if ($method === 'GET') {
                if (!empty($params)) {
                    $options['query'] = $params;
                }
            } else {
                if (!empty($params)) {
                    $options['json'] = $params;
                }
            }

            $response = $this->client->request($method, $url, $options);
            if($response->getStatusCode() == 200) {
                put_Shop_Api_Log($this->shopType, 'Success', $this->baseUrl, $endpoint, $params, $method, $response->getBody());
                return $this->parseResponse($response);
            }else{
                $data = $this->parseResponse($response);
                $message = "[Cafe24 API] ErrorCode='" . $data['error']['code'] . "';Msg='" . $data['error']['message']. "'";
                $t_msg = ['response' => $message];
                $Cnt = put_Shop_Api_Log($this->shopType,'Error',$this->baseUrl,$endpoint,$params,$method, json_encode($t_msg));
                return [];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error'   => 'Exception',
                'message' => $e->getMessage(),
                'status'  => 500
            ];
            $Cnt = put_Shop_Api_Log($this->shopType,'Error',$this->baseUrl,$endpoint,$params,$method,$e->getMessage());
        }
    }

    private function parseResponse($response): array
    {
        $statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody(), true);


        if ($statusCode >= 200 && $statusCode < 300) {
            return [
                'success' => true,
                'data'    => $body,
                'status'  => $statusCode
            ];
        }

        return [
            'success' => false,
            'error'   => $body['error'] ?? 'Unknown Error',
            'message' => $body['error']['message'] ?? 'API 호출 에러',
            'status'  => $statusCode
        ];
    }
}