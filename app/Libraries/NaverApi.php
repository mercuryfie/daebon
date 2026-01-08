<?php
// app/Libraries/NaverCommerceApi.php
namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;

class NaverApi
{
    private $baseUrl = 'https://api.commerce.naver.com/external/v1';
    private $accessToken = null;
    private $tokenExpires = 0;
    private $request;

    public function __construct()
    {
        $this->clientId = '7VPYEPaTX0uve6cGgHkCIq';
        $this->clientSecret = '$2a$04$oZuxOFEh1TtEZ0RoxQslfe';
        $this->request = service('curlrequest');
    }

    private function getAccessToken()
    {
        if ($this->accessToken && time() < $this->tokenExpires - 300) {
            return $this->accessToken;
        }
        $timestamp = (int)(microtime(true) * 1000);
        $password = $this->clientId . '_' . $timestamp;
        $signature = crypt($password, $this->clientSecret);
        $signature = base64_encode($signature);

        $data = [
            'client_id' => $this->clientId,
            'timestamp' => (string)$timestamp,
            'client_secret_sign' => $signature,
            'type' => 'SELF',
            'grant_type' => 'client_credentials'
        ];

        $response = $this->request->post($this->baseUrl . '/oauth2/token', [
            'form_params' => $data,
            'verify' => false,
            'timeout' => 30,
            'http_errors' => false
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Token Error: ' . $response->getBody());
        }

        $result = json_decode($response->getBody(), true);
        $this->accessToken = $result['access_token'];
        $this->tokenExpires = time() + ($result['expires_in'] ?? 3600);
        return $this->accessToken;
    }

    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
            'X-Naver-Client-Id' => $this->clientId,
            'X-Naver-Client-Secret' => $this->clientSecret
        ];
    }

    private function makeRequest($method, $endpoint, $options = [])
    {

        $url = $this->baseUrl . $endpoint;
        $response = $this->request->$method($url, [
            'headers' => $this->getHeaders(),
            'timeout' => 30,     // GW.TIMEOUT.01 방지
            'http_errors' => false
        ]);

        $status = $response->getStatusCode();
        $body = $response->getBody();

        if ($status === 400) {
            log_message('error', '400 Bad Request Details: ' . $body);
            throw new \Exception("400 Bad Request: " . $body);
        }

        //토큰 재발급
        if ($status === 401 && strpos($body, 'GW.AUTHN') !== false) {
            $this->accessToken = null;
            $this->getAccessToken();
        }

        if ($status !== 200) {
            throw new \Exception("API Error {$status}: {$body}");
        }

        return json_decode($body, true);
    }

    public function getOrders($params = [])
    {
        $query = http_build_query($params);
        return $this->makeRequest('get', '/pay-order/seller/orders?' . $query);
    }

    public function getOrdersAll($params = [])
    {
        $query = http_build_query($params);
        return $this->makeRequest('get', '/pay-order/seller/product-orders/last-changed-statuses?' . $query);
    }

}