<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class Cafe24Api
{
    protected string $mallId = 'daebon77';
    protected string $clientId = 'YOUR_CLIENT_ID';
    protected string $clientSecret = 'YOUR_CLIENT_SECRET';
    protected string $apiVersion = '2024-06-01';
    protected string $baseUrl;
    protected string $shopType = 'type6';

    protected $db;
    protected $tokenData; // DB에서 가져온 토큰 정보

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->baseUrl = "https://{$this->mallId}.cafe24api.com/api/v2/";

        // 1. DB에서 토큰 로드
        $this->loadTokenFromDb();
    }

    /**
     * DB에서 토큰 정보를 가져옴
     */
    private function loadTokenFromDb()
    {
        $this->tokenData = $this->db->table('shop_tokens')
            ->where('mall_id', $this->mallId)
            ->get()
            ->getRowArray();
    }

    /**
     * HTTP 클라이언트 생성 (최신 토큰 주입)
     */
    private function getClient()
    {
        return Services::curlrequest([
            'headers' => [
                'Content-Type'         => 'application/json',
                'Authorization'        => "Bearer " . $this->tokenData['access_token'],
                'X-Cafe24-Api-Version' => $this->apiVersion,
            ],
            'http_errors' => false,
        ]);
    }

    /**
     * 토큰 자동 갱신 및 DB 저장
     */
    private function refreshAccessToken()
    {
        $url = "https://{$this->mallId}.cafe24api.com/api/v2/oauth/token";
        $auth = base64_encode($this->clientId . ':' . $this->clientSecret);

        $response = Services::curlrequest()->request('POST', $url, [
            'headers' => [
                'Authorization' => "Basic {$auth}",
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $this->tokenData['refresh_token'],
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['access_token'])) {
            // DB 업데이트
            $this->db->table('shop_tokens')->where('mall_id', $this->mallId)->update([
                'access_token'  => $result['access_token'],
                'refresh_token' => $result['refresh_token'], // 갱신 시 refresh_token도 새로 올 수 있음
                'updated_at'    => date('Y-m-d H:i:s')
            ]);

            // 현재 객체의 토큰 정보 갱신
            $this->loadTokenFromDb();
            return true;
        }

        return false;
    }

    /**
     * 공통 요청 함수 (401 발생 시 자동 재시도 로직 포함)
     */
    private function sendRequest(string $method, string $endpoint, array $params = [], bool $isRetry = false): array
    {
        if (!$this->tokenData) {
            return ['success' => false, 'message' => 'DB에 토큰 정보가 없습니다.'];
        }

        $client = $this->getClient();
        $options = ($method === 'GET') ? ['query' => $params] : ['json' => $params];

        $response = $client->request($method, $this->baseUrl . $endpoint, $options);
        $status = $response->getStatusCode();

        // 1. 토큰 만료(401) 시 자동 갱신 로직
        if ($status == 401 && !$isRetry) {
            if ($this->refreshAccessToken()) {
                // 토큰 갱신 성공 후 딱 한 번만 다시 요청(Recursive call)
                return $this->sendRequest($method, $endpoint, $params, true);
            }
        }

        // 2. 결과 처리
        $body = json_decode($response->getBody(), true);
        if ($status >= 200 && $status < 300) {
            put_Shop_Api_Log($this->shopType, 'Success', $this->baseUrl, $endpoint, $params, $method, $response->getBody());
            return ['success' => true, 'data' => $body, 'status' => $status];
        }

        put_Shop_Api_Log($this->shopType, 'Error', $this->baseUrl, $endpoint, $params, $method, $response->getBody());
        return ['success' => false, 'message' => $body['error']['message'] ?? 'API Error', 'status' => $status];
    }

    // --- API 메서드들 ---

    public function getOrders($startdate, $enddate)
    {
        return $this->sendRequest('GET', 'admin/orders', [
            'start_date' => $startdate,
            'end_date'   => $enddate
        ]);
    }
}