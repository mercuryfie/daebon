<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class EsmApi
{
    // baseUrl 끝에 '/'가 없도록 설정
    private string $baseUrl = 'https://sa2.esmplus.com';
    private string $masterId;
    private string $secretKey;
    private string $sellerInfo;
    private string $siteType;
    private string $shopType;
    private CURLRequest $client;

    public function __construct(string $siteType)
    {
        $this->siteType = $siteType;

        // ⚠️ 보안: 키 값 공백 제거
        if ($siteType === 'gm') {
            $this->masterId = trim('kij4490');
            $this->secretKey = trim('ZDUzYTYyOTUtMmE2Zi00YmVm');
            $this->sellerInfo = trim('G:daeguyg');
            $this->shopType = 'type3';
        } elseif ($siteType === 'au') {
            $this->masterId = trim('kij4490');
            $this->secretKey = trim('ZDUzYTYyOTUtMmE2Zi00YmVm');
            $this->sellerInfo = trim('A:kij4490000');
            $this->shopType = 'type2';
        } else {
            throw new Exception('지원하지 않는 사이트 타입입니다. (gm 또는 au 입력 필요)');
        }

        if (empty($this->masterId) || empty($this->secretKey) || empty($this->sellerInfo)) {
            throw new Exception('ESM API 설정 값이 누락되었습니다.');
        }

        // CI4 HTTP Client 초기화
        // base_uri 설정을 빼고, request시 직접 결합하는 방식을 사용합니다.
        $this->client = Services::curlrequest([
            'timeout'     => 30,
            'verify'      => false,
            'http_errors' => false
        ]);
    }

    /**
     * 발주 목록 조회
     */
    public function getOrderList(string $sdate, string $edate)
    {
        // 옥션: 1, 지마켓: 2
        $esmSiteType = ($this->siteType === 'au') ? 1 : 2;

        $param = [
            'siteType'        => $esmSiteType,
            'orderStatus'     => 1,
            'requestDateType' => 1,
            'requestDateFrom' => $sdate,
            'requestDateTo'   => $edate
        ];

        $endpoint = '/shipping/v1/Order/RequestOrders';

        return $this->request('POST', $endpoint, $param);
    }

    /**
     * 공통 API 요청 함수 (URL 수정됨)
     */
    private function request(string $method, string $endpoint, array $data = [])
    {
        $method = strtoupper($method);

        $jwtToken = $this->generateJwtToken();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwtToken,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ]
        ];

        // GET 요청: 쿼리 스트링 처리
        if ($method === 'GET' && !empty($data)) {
            $endpoint .= '?' . http_build_query($data);
        }
        // POST 요청: Body JSON 처리
        elseif (!empty($data)) {
            $options['json'] = $data;
        }

        try {
            // [핵심 수정] 도메인과 경로를 직접 합쳐서 전체 URL(Full URL) 생성
            // 결과: https://sa2.esmplus.com/shipping/v1/...
            $fullUrl = $this->baseUrl . $endpoint;

            // CURLRequest 요청 (전체 URL 사용)
            $response = $this->client->request($method, $fullUrl, $options);

            // 상태 코드 체크
            if ($response->getStatusCode() >= 400) {
                throw new Exception("HTTP Error " . $response->getStatusCode() . ": " . $response->getBody());
            }

            $Cnt = put_Shop_Api_Log($this->shopType,'Success',$this->baseUrl,$endpoint,$data,$method,$response->getBody());

            $decoded = json_decode($response->getBody(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON Decode Error: " . json_last_error_msg());
            }

            return $decoded;

        } catch (\Exception $e) {
            log_message('error', '[ESM API Error] ' . $e->getMessage());
            $Cnt = put_Shop_Api_Log($this->shopType,'Error',$this->baseUrl,$endpoint,$data,$method,$e->getMessage());
            throw new Exception("ESM Request Failed: " . $e->getMessage());
        }
    }

    /**
     * ESM JWT 토큰 생성
     */
    private function generateJwtToken(): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'kid' => $this->masterId,
        ];

        $payload = [
            'iss' => 'www.esmplus.com',
            'sub' => 'sell',
            'aud' => 'sa.esmplus.com',
            'iat' => time(),
            'ssi' => $this->sellerInfo,
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}