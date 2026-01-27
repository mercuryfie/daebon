<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class LotteOnApi
{
    protected CURLRequest $client;
    // 롯데온 OpenAPI 실제 호출 도메인
    protected string $baseUrl = "https://openapi.lotteon.com/v1/openapi";

    // 롯데온 판매자센터에서 발급받은 OpenAPI 인증키 (유효기간 1년)
    protected string $apiKey;

    protected string $shopType = 'type13';

    public function __construct()
    {
        // .env 등에서 키 관리 권장
        $this->apiKey = '5d5b2cb498f3d20001665f4eea2006a8989244d7b49e6afc8117d981';

        $this->client = Services::curlrequest([
            'timeout'     => 30,
            'http_errors' => false,
            'headers'     => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => "application/json",
                'Accept-Language' =>'ko',
                'X-Timezone' => 'GMT+09:00',
                'Content-Type' => 'application/json'
            ],
        ]);
    }

    /**
     * API 호출 공통 함수 (NaverApi 구조 유지)
     */
    protected function sendRequest(string $method, string $path, array $params = []): array
    {
        $url = $this->baseUrl . (str_starts_with($path, '/') ? $path : '/' . $path);

        $options = [];

        if (strtoupper($method) === 'GET') {
            $options['query'] = $params;
        } else {
            $options['json'] = $params;

            // x-www-form-urlencoded가 필요한 특수 상황 대비
            if (isset($params['grant_type'])) {
                unset($options['json']);
                $options['form_params'] = $params;
            }
        }

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (Exception $e) {
            log_message('error', "[LotteOnAPI] Request Failed: " . $e->getMessage());
            throw new Exception("API 호출 중 통신 오류가 발생했습니다.");
        }

        $statusCode = $response->getStatusCode();
        $body = (string)$response->getBody();
        $decoded = json_decode($body, true);

        // 롯데온 성공 기준: HTTP 200 이면서 returnCode가 '0000'
        $returnCode = $decoded['returnCode'] ?? 'Unknown';

        if ($statusCode == 200 && $returnCode === '0000') {
            put_Shop_Api_Log($this->shopType, 'Success', $this->baseUrl, $path, $params, $method, $body);
        } else {
            $errorMsg = $decoded['message'] ?? $decoded['returnMessage'] ?? 'Unknown_Error';
            $t_msg = ['response' => "[LotteOnAPI] Error ({$statusCode}): {$returnCode} - {$errorMsg}"];

            put_Shop_Api_Log($this->shopType, 'Error', $this->baseUrl, $path, $params, $method, json_encode($t_msg));
            log_message('error', "[LotteOnAPI] Error ($statusCode): $returnCode - $errorMsg");

            $decoded = []; // 에러 시 빈 배열 반환
        }

        return $decoded ?? [];
    }

    /**
     * [API No. 209] 출고/회수지시(주문정보) 조회
     * 문서: https://api.lotteon.com/apiService/?apiNo=209
     */
    public function getOrderList(string $startDate, string $endDate): array
    {
        // 209번 API의 실제 경로
        $uri = "/delivery/v1/SellerDeliveryOrdersSearch";

        $params = [
            'srchStrtDt' => $startDate,
            'srchEndDt'  => $startDate,
            'odPrgsStepCd'    => 11,
            'odTypCd'         => 10
        ];

        return $this->sendRequest('POST', $uri, $params);
    }

    /**
     * 조회된 주문 정보를 내부 포맷으로 파싱
     */
    public function getParsedOrderDetails(array $rawOrderList): array
    {
        if (empty($rawOrderList)) {
            return [];
        }

        $parsedData = [];

        foreach ($rawOrderList as $order) {
            // API 209번 응답 필드 매핑
            // rcvNm(수령인), ordNo(주문번호), trNo(추적번호=주문순번 비슷), etc.

            $parsedData[] = [
                'order_id'       => $order['ordNo'] ?? '',            // 주문번호
                'order_seq'      => $order['trNo'] ?? $order['ordSeq'] ?? '', // 거래번호/순번
                'order_date'     => $order['ordDt'] ?? '',            // 주문일자
                'status'         => $order['dstStsCd'] ?? '',         // 배송/주문상태코드

                // 구매자/수령인 정보
                'buyer_name'     => $order['ordNm'] ?? '',            // 주문자명
                'buyer_phone'    => $order['ordTel'] ?? '',           // 주문자 전화번호
                'receiver_name'  => $order['rcvNm'] ?? '',            // 수령인명
                'receiver_phone' => $order['rcvMoblNo'] ?? $order['rcvTel'] ?? '', // 수령인 핸드폰

                // 주소 정보
                'zipcode'        => $order['rcvZipNo'] ?? '',         // 우편번호
                'address'        => trim(($order['rcvAddr'] ?? '') . ' ' . ($order['rcvDtlAddr'] ?? '')),

                // 상품 정보
                'product_id'     => $order['prdNo'] ?? '',            // 상품번호
                'product_name'   => $order['prdNm'] ?? '',            // 상품명
                'product_option' => $order['slctPrdOptNm'] ?? '',     // 선택옵션명
                'quantity'       => $order['ordQty'] ?? 0,            // 주문수량
                'price'          => $order['salePrc'] ?? 0,           // 판매가
                'pay_price'      => $order['pymAmt'] ?? 0,            // 결제금액

                // 기타
                'shippingMemo'   => $order['dlvMsg'] ?? '',           // 배송메시지
                'mall_id'        => $this->shopType
            ];
        }

        return $parsedData;
    }
}