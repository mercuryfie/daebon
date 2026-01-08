<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Client;

class Cafe24Api
{
    private $mallId;
    private $accessToken;
    private $baseUrl;
    private $http;

    public function __construct(array $config = [])
    {
        $this->http = \Config\Services::curlrequest();
        $this->mallId = 'daebon77';
        $this->accessToken = 'eaf19f45a0a79d964044c52368c88005e18a17e9';
        $this->baseUrl = "https://{$this->mallId}.cafe24api.com/api/v2/admin";
    }

    /**
     * 공통 GET 요청
     */
    private function makeGetRequest(string $endpoint, array $query = []): array
    {
        $response = $this->http->request('GET', $this->baseUrl . $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json'
            ],
            'query' => $query
        ]);

        if ($response->getStatusCode() !== 200) {
            $errorMsg = '카페24 API 오류: ' . $response->getStatusCode() . ' - ' . $response->getBody();
            log_message('error', $errorMsg);
            throw new \RuntimeException($errorMsg);
        }

        $data = json_decode($response->getBody(), true);
        return $data ?: [];
    }

    /**
     * 주문 목록 검색 (기본: 최근 20건)
     * @see https://developers.cafe24.com/docs/api/admin/#Retrieve-orders
     * @param array $params limit, status, shop_no 등 [web:135]
     * @return array
     */
    public function searchOrders(array $params = []): array
    {
        $endpoint = '/orders';
        $query = array_merge([
            'limit' => 20,
            'offset' => 0
            // 'status' => 'order', 'ready', 'complete' 등
        ], $params);

        return $this->makeGetRequest($endpoint, $query);
    }

    /**
     * 특정 주문 상세 조회
     * @param string $orderId 주문번호
     * @return array
     */
    public function getOrderDetail(string $orderId): array
    {
        $endpoint = "/orders/{$orderId}";
        return $this->makeGetRequest($endpoint);
    }

    /**
     * 주문 상태 변경 (배송완료 등)
     * @param string $orderId
     * @param array $data 업데이트 데이터
     * @return array
     */
    public function updateOrderStatus(string $orderId, array $data): array
    {
        $response = $this->http->request('PUT', $this->baseUrl . "/orders/{$orderId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => $data
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('주문 업데이트 실패: ' . $response->getBody());
        }

        return json_decode($response->getBody(), true) ?: [];
    }

    /**
     * 상품 목록 조회 (보너스)
     */
    public function getProducts(array $params = []): array
    {
        $endpoint = '/products';
        return $this->makeGetRequest($endpoint, $params);
    }
}
?>