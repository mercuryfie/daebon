<?php
namespace App\Libraries;

use CodeIgniter\HTTP\Client;

class LotteOnApi
{
    private $apiKey;
    private $sellerId;
    private $baseUrl = 'https://openapi.lotteon.com/v1';
    private $http;

    public function __construct(array $config = [])
    {
        $this->http = \Config\Services::curlrequest();
        $this->apiKey = '7a1cb8668fa0bd9ddeff0f041eca018f';
        $this->sellerId = '7a1cb8668fa0bd9ddeff0f041eca018f';
    }

    private function makeGetRequest(string $endpoint, array $query = [], array $headers = []): array
    {
        $defaultHeaders = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->http->request('GET', $this->baseUrl . $endpoint, [
            'headers' => array_merge($defaultHeaders, $headers),
            'query' => $query
        ]);

        if ($response->getStatusCode() !== 200) {
            $errorMsg = '롯데ON API 오류: ' . $response->getStatusCode() . ' - ' . $response->getBody();
            log_message('error', $errorMsg);
            throw new \RuntimeException($errorMsg);
        }

        $data = json_decode($response->getBody(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('JSON 파싱 실패: ' . $response->getBody());
        }

        return $data ?: [];
    }

    /**
     * 주문 목록 검색
     */
    public function searchOrders(string $startDttm = '', string $endDttm = '', array $params = []): array
    {
        $endpoint = '/getOrderList';
        $query = array_merge([
            'srchStartDttm' => $startDttm ?: date('Ymd000000', strtotime('-7 days')),
            'srchEndDttm' => $endDttm ?: date('YmdHis'),
            'sellerId' => $this->sellerId
        ], $params);

        return $this->makeGetRequest($endpoint, $query);
    }

    /**
     * 특정 주문 상세 조회
     */
    public function getOrderDetail(string $orderNo): array
    {
        $endpoint = '/getOrderDetail';
        $query = ['odNo' => $orderNo, 'sellerId' => $this->sellerId];

        return $this->makeGetRequest($endpoint, $query);
    }

    /**
     * 배송 상태 조회
     */
    public function getShippingStatus(string $orderNo): array
    {
        $endpoint = '/getShippingStatus';
        $query = ['odNo' => $orderNo, 'sellerId' => $this->sellerId];

        return $this->makeGetRequest($endpoint, $query);
    }

    private function makePostRequest(string $endpoint, array $data = [], array $headers = []): array
    {
        $defaultHeaders = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ];

        $response = $this->http->request('POST', $this->baseUrl . $endpoint, [
            'headers' => array_merge($defaultHeaders, $headers),
            'json' => $data
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('POST API 오류: ' . $response->getBody());
        }

        return json_decode($response->getBody(), true) ?: [];
    }
}
?>