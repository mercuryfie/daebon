<?php
namespace App\Libraries;

use CodeIgniter\HTTP\CurlRequest;

class KakaoApi
{
    private $apiKey;
    private $baseUrl;
    private $http;

    public function __construct($apiKey = null, $env = 'prod')
    {
        $this->apiKey = '7a1cb8668fa0bd9ddeff0f041eca018f';
        $this->baseUrl = $env === 'test' ?
            'https://test-api.shopping.naver.com' :
            'https://api.shopping.naver.com'; // 실제 베이스URL 확인 필요 [web:14]
        $this->http = service('curlrequest');
    }

    /**
     * 공통 인증 헤더 생성
     */
    private function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'KakaoAK ' . $this->apiKey,
            'Content-Type'  => 'application/json;charset=UTF-8'
        ];
    }

    /**
     * GET 요청
     */
    public function getOrderList(string $endpoint, array $params = []): array
    {
        $url = $this->baseUrl . $endpoint;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $response = $this->http->get($url, [
            'headers' => $this->getAuthHeaders()
        ]);

        return $this->parseResponse($response);
    }

    /**
     * POST 요청
     */
    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->http->post($this->baseUrl . $endpoint, [
            'headers' => $this->getAuthHeaders(),
            'json'    => $data
        ]);

        return $this->parseResponse($response);
    }

    /**
     * PUT 요청
     */
    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->http->put($this->baseUrl . $endpoint, [
            'headers' => $this->getAuthHeaders(),
            'json'    => $data
        ]);

        return $this->parseResponse($response);
    }

    /**
     * 응답 파싱
     */
    private function parseResponse($response): array
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        if ($statusCode >= 200 && $statusCode < 300) {
            return [
                'success' => true,
                'data'    => json_decode($body, true) ?: [],
                'status'  => $statusCode
            ];
        }

        return [
            'success'  => false,
            'error'    => json_decode($body, true) ?: ['message' => $body],
            'status'   => $statusCode
        ];
    }
}