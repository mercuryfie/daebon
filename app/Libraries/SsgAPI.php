<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class SsgAPI
{
    protected string $baseUrl;

    protected string $apiKey;
    protected $apiVersion = '1';
    protected CURLRequest $client;

    public function __construct()
    {
        $this->apiKey = '9e2fee85-529e-4483-ba12-ed6b57aa46d1';

        if(ENVIRONMENT=='production'){
            $this->baseUrl = 'http://eapi.ssgadm.com';
        }else{
            $this->baseUrl = 'http://qa-eapi.ssgadm.com';
        }

        // CURLRequest 초기화
        $this->client = Services::curlrequest([
            'headers'  => [
                'Authorization' => $this->apiKey, // SSG API 인증키
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
            'timeout'  => 30,
            'http_errors' => false,
        ]);
    }

    /**
     * @param string $method HTTP 메서드 (GET, POST)
     * @param string $path API 엔드포인트 경로 (예: /item/v1/getItemList.ssg)
     * @param array $params 요청 파라미터 (GET은 쿼리스트링, POST는 JSON Body)
     * @return array|object 응답 데이터
     * @throws Exception
     */
    public function sendRequest(string $method, string $path, array $params = [])
    {
        $method = strtoupper($method);
        $options = [];

        // 파라미터 설정
        if (!empty($params)) {
            if ($method === 'GET') {
                $options['query'] = $params;
            } else {
                $options['json'] = $params; // JSON 형식으로 전송
            }
        }

        try {
            $response = $this->client->request($method, $path, $options);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            // JSON 디코딩
            $result = json_decode($body, true);

            // API 에러 처리
            if ($statusCode >= 400) {
                // SSG API 응답 구조에 맞춰 에러 메시지 추출
                $errorMessage = $result['resultMessage'] ?? $result['resultDesc'] ?? 'Unknown Error';
                throw new Exception("SSG API Error ({$statusCode}): " . $errorMessage);
            }

            return $result;

        } catch (\Exception $e) {
            log_message('error', '[SsgApiClient] Request Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getShppDirectionList(string $startDate, string $endDate)
    {
        $endpoint = $this->baseUrl .  "/api/pd/{$this->apiVersion}/listShppDirection.ssg";
        $params = [
            'perdType' =>"01",
            'perdStrDts' => $startDate,
            'perdEndDts' => $endDate
        ];

        return $this->sendRequest('POST', $endpoint, $params);
        //return [];
    }



    /**
     * 사용 예시: 상품 목록 조회
     */
    public function getItemList(string $version = 'v1', array $searchParams = [])
    {
        // 내부 호출 메서드명도 sendRequest로 변경
        return $this->sendRequest('GET', "/item/{$version}/getItemList.ssg", $searchParams);
    }
}