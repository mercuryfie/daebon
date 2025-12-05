<?php namespace App\Libraries;

use Exception;

class EsmApi
{
    protected $baseUrl = 'https://sa2.esmplus.com';
    protected $masterId;
    protected $secretKey;
    protected $siteInfo;

    public function __construct(string $siteInfo)
    {
        if($siteInfo=='gm') {
            $this->masterId = 'kij4490';
            $this->secretKey = 'G_daeguyg';
            $this->siteInfo = 'G:daeguyg';
        }else if($siteInfo=='au') {
            $this->masterId = 'kij4490';
            $this->secretKey = 'A_kij4490000';
            $this->siteInfo = 'A:kij4490000';
        }


        if (!$this->masterId || !$this->secretKey || !$this->siteInfo) {
            throw new Exception('ESM 설정체크가 필요합니다. masterId, secretKey, siteInfo 값을 확인하세요.');
        }
    }

    protected function generateJwtToken(): string
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
            'ssi' => $this->siteInfo,
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function request(string $method, string $endpoint, array $data = []): ?array
    {
        $url = $this->baseUrl . $endpoint;
        $jwtToken = $this->generateJwtToken();

        $headers = [
            'Authorization: Bearer ' . $jwtToken,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', "EsmApi request error: {$error}");
            return null;
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', "EsmApi JSON decode error: " . json_last_error_msg());
            return null;
        }

        return $decoded;
    }

    // 주문확인 API 호출 예시
    public function orderCheck(string $orderNo, array $data = []): ?array
    {
        $endpoint = '/shipping/v1/Order/OrderCheck/' . urlencode($orderNo);
        return $this->request('POST', $endpoint, $data);
    }
}