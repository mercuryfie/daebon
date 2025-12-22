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
        $this->accessKey = 'ff1641d4-a674-40cb-8f63-56f65848d51b';
        $this->secretKey = 'fb90d9db328f5d6acb585f85c9565d75a4f2dac4';
        $this->vendorid = 'A01560779';
        $this->host = 'https://api-gateway.coupang.com';
        date_default_timezone_set("GMT");
    }

    private function generateSignature(string $method, string $path, string $query)
    {
        $datetime = gmdate("ymd") . 'T' . gmdate("His") . 'Z';
        $message = $datetime . $method . $path . $query;
        $signature = hash_hmac('sha256', $message, $this->secretKey);
        $authorization  = "CEA algorithm=HmacSHA256, access-key=".$this->accessKey.", signed-date=".$datetime.", signature=".$signature;
        return $authorization;
    }

    private function api_request(string $method, string $path, string $query = '')
    {
        $authorization = $this->generateSignature($method, $path, $query);

        $url = $this->host . $path;
        if ($query !== '') {
            $url .= '?' . $query;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:  application/json;charset=UTF-8", "Authorization:".$authorization));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }

    public function Get_Order_Period()
    {
        $v_id = $this->vendorid;
        $path = "/v2/providers/openapi/apis/api/v5/vendors/{$v_id}/ordersheets";
        $query = 'createdAtFrom=2025-11-05%2B09:00&createdAtTo=2025-11-07%2B09:00&maxPerPage=50&status=INSTRUCT';

        $body = $this->api_request('GET', $path, $query);

        return $body;
    }

    public function Get_Order_Info(string $shipmentBoxId){
        $path = "/v2/providers/openapi/apis/api/v5/vendors/{vendorId}/ordersheets/{$shipmentBoxId}";
        $query = '';

        $body = $this->api_request('GET', $path, $query);

        return $body;
    }

}