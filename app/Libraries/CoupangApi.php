<?php
namespace App\Libraries;

use CodeIgniter\HTTP\CurlRequest;

class CoupangApi
{
    protected $accessKey;
    protected $secretKey;
    protected $vendorid;
    protected $client;

    public function __construct()
    {
        $this->accessKey = 'a9adfe13-f559-42cf-bd61-48eef9af6028';
        $this->secretKey = 'eaf19f45a0a79d964044c52368c88005e18a17e9';
        $this->vendorid = 'A00061018';
        $this->host = 'https://api-gateway.coupang.com';
    }

    private function generateSignature(string $method, string $path, string $query)
    {
        $datetime = gmdate("ymd") . 'T' . gmdate("His") . 'Z';
        $message = $datetime . $method . $path . $query;
        $signature = hash_hmac('sha256', $message, $this->secretKey);

        $authorization = "CEA algorithm=HmacSHA256, access-key=" . $this->accessKey . ", signed-date=" . $datetime . ", signature=" . $signature;

        return $authorization;
    }


    private function api_request(string $method, string $path, string $query = '')
    {
        $authorization = $this->generateSignature($method, $path, $query);

        $url = $this->host . $path;
        if ($query !== '') {
            $url .= '?' . $query;
        }

//        echo "=== DEBUG INFO ===<br>";
//        echo "URL: " . $url . "<br><br>";
//        echo "Authorization: " . $authorization . "<br><br>";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "Authorization: ".$authorization
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        $result = curl_exec($curl);

        // HTTP 상태코드 확인
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

//        echo "HTTP Code: " . $httpCode . "<br>";
//        if ($error) echo "Curl Error: " . $error . "<br>";
//
//        echo "Raw Response: " . $result . "<br>";
//        echo "================<br><br>";

        return json_decode($result, true);
    }

    public function Get_Order_Period($sdate,$edate,$status,$max)
    {
        $v_id = $this->vendorid;
        $path = "/v2/providers/openapi/apis/api/v4/vendors/{$v_id}/ordersheets";  // v4

        $params = [
            'createdAtFrom' => $sdate,
            'createdAtTo'   => $edate,
            'status'        => $status,
            'maxPerPage'    => $max
        ];
        $query = http_build_query($params);  // 알파벳 순서로 정렬됨

        return $this->api_request('GET', $path, $query);
    }

    public function Get_Product_Info_Load($pid){
        $v_id = $this->vendorid;
        $path = "/v2/providers/seller_api/apis/api/v1/marketplace/seller-products/{$pid}";
        $params = [];
        $query = http_build_query($params);  // 알파벳 순서로 정렬됨

        return $this->api_request('GET', $path, $query);


    }


}