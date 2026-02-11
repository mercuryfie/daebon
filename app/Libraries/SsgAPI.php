<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class SsgAPI
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $apiVersion = '1';
    protected string $shopType = 'type14';

    protected CURLRequest $client;


    public function __construct()
    {
        // 보안을 위해 API 키는 .env 파일 등에 관리하는 것을 추천합니다.
        $this->apiKey = '9e2fee85-529e-4483-ba12-ed6b57aa46d1';
        $this->baseUrl = 'https://eapi.ssgadm.com';

        $this->client = Services::curlrequest([
            'headers'  => [
                'Authorization' => $this->apiKey,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
            'timeout'  => 30,
            'http_errors' => false,
        ]);
    }

    public function sendRequest(string $method, string $path, array $params = [])
    {
        $method = strtoupper($method);
        $options = [];

        if (!empty($params)) {
            if ($method === 'GET') {
                $options['query'] = $params;
            } else {
                // CI4의 'json' 옵션은 내부적으로 json_encode 및 Content-Type 설정을 수행합니다.
                $options['json'] = $params;
            }
        }

        try {
            $response = $this->client->request($method, $path, $options);
            $body = $response->getBody();
            $result = json_decode($body, true);

            if (isset($result['resultCode']) && $result['resultCode'] !== 'SUCCESS') {
                $errorMsg = $result['resultDesc'] ?? $result['resultMessage'] ?? '알 수 없는 오류';

                put_Shop_Api_Log($this->shopType, 'Error', $this->baseUrl, $path, $params, $method, json_encode($errorMsg));

                throw new Exception("SSG API 응답 실패: " . $errorMsg);
            }

            put_Shop_Api_Log($this->shopType, 'Success', $this->baseUrl, $path, $params, $method, $body);

            return $result;

        } catch (Exception $e) {
            put_Shop_Api_Log($this->shopType, 'Error', $this->baseUrl, $path, $params, $method,$e->getMessage());
            log_message('error', '[SsgAPI] Request Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 배송지시 목록 조회
     */
    public function getShppDirectionList(string $startDate, string $endDate)
    {
        $path = $this->baseUrl . "/api/pd/{$this->apiVersion}/listShppDirection.ssg";
        $params = [
            'requestShppDirection' => [
                'perdType'   => "01",
                'perdStrDts' => $startDate,
                'perdEndDts' => $endDate
            ]
        ];

        return $this->sendRequest('POST', $path, $params);
    }

    public function putOrderConfirm(string $orcode)
    {
        try {
            $order_m = model('Order_m');
            $Rs = $order_m->Load_Order_Product($orcode);
            if (fn_ArrayCnt($Rs) <= 0) return '';
            $results = [];
            foreach ($Rs as $d) {
                $sgcode = $d['sgcode'];
                if (empty($d['addProductInfo'])) continue;
                $Info = json_decode($d['addProductInfo'], true, 512, JSON_THROW_ON_ERROR);

                $path = "/api/pd/{$this->apiVersion}/updateOrderSubjectManage.ssg";
                $params = [
                    'requestOrderSubjectManage' => [
                        'shppNo' => $Info['shppNo'],
                        'shppSeq' => $Info['shppSeq']
                    ]
                ];
                $results[$sgcode] = $this->sendRequest('POST', $path, $params);
            }
            return $results;
        } catch (\Exception $e) {
            log_message('error', '[confirmOrder 전체 에러] ' . $e->getMessage());
            return ['result' => 'error', 'message' => $e->getMessage()];
        }
    }



}