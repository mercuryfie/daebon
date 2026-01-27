<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class ElevenStreetApi
{
    private $client;
    private string  $apiKey;
    private string  $baseUrl = 'https://api.11st.co.kr/rest';
    private string $shopType = 'type4';

    public function __construct()
    {
        $this->apiKey = '1816a67090dc70019eb7c183b27198e4';
        $this->client = Services::curlrequest([
            'timeout'     => 30,
            'http_errors' => false
        ]);
    }

    private function callApi(string $method, string $path, array $options = [])
    {
        $url = $this->baseUrl . $path;
        $defaultHeaders = [
            'OpenApiKey'   => $this->apiKey,
            'Content-Type' => 'text/xml; charset=utf-8',
            'Accept'       => 'text/xml'
        ];
        $options['headers'] = array_merge($defaultHeaders, $options['headers'] ?? []);

        try {
            $response = $this->client->request($method, $url, $options);
            $Cnt = put_Shop_Api_Log($this->shopType,'Success',$this->baseUrl,$path,$options,$method,$this->parseResponse($response->getBody()));
            return $this->parseResponse($response->getBody());
        } catch (Exception $e) {
            log_message('error', '[11st API Error] ' . $e->getMessage());
            $Cnt = put_Shop_Api_Log($this->shopType,'Error',$this->baseUrl,$path,$options,$method,$e->getMessage());
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
                'code'    => $e->getCode()
            ];
        }
    }

    /**
     * 신규 발주(결제완료) 목록 조회
     */
    public function getNewOrders($startTime, $endTime)
    {
        // 1. 경로 설정 (기존 코드 유지)
        $path = "/ordservices/complete/{$startTime}/{$endTime}";
        return $this->callApi('GET', $path, []);
    }


    /**
     * 발주 확인 처리 (상품 준비중 처리)
     */
    public function confirmOrder(array $ordPrdCnSeqList)
    {
        $path = '/ordservices/reqsupport/postService';

        // XML 본문 생성
        $xmlBody = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlBody .= '<ClientRequest>';
        foreach ($ordPrdCnSeqList as $seq) {
            $xmlBody .= '<ordPrdCnSeq>' . $seq . '</ordPrdCnSeq>';
        }
        $xmlBody .= '</ClientRequest>';

        // 공통 함수 호출 (POST)
        return $this->callApi('POST', $path, [
            'body' => $xmlBody
        ]);
    }

    /**
     * 배송 정보 입력 (발송 처리)
     */
    public function sendShippingInfo($ordCode, $deliveryMethod, $courierCode, $invoiceNo)
    {
        $path = '/ordservices/packaging/postService';

        $xmlBody = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlBody .= '<ClientRequest>';
        $xmlBody .= '<ordCode>' . $ordCode . '</ordCode>';
        $xmlBody .= '<dlvMthdCd>' . $deliveryMethod . '</dlvMthdCd>';
        $xmlBody .= '<dlvEtprsCd>' . $courierCode . '</dlvEtprsCd>';
        $xmlBody .= '<invcNo>' . $invoiceNo . '</invcNo>';
        $xmlBody .= '</ClientRequest>';

        // 공통 함수 호출 (POST)
        return $this->callApi('POST', $path, [
            'body' => $xmlBody
        ]);
    }


    private function parseResponse($body)
    {
        if (empty($body)) {
            return ['status' => 'error', 'message' => 'Empty Response'];
        }
        $detectedEnc = mb_detect_encoding($body, ['UTF-8', 'EUC-KR', 'CP949'], true);

        if ($detectedEnc !== 'UTF-8') {
            $body = mb_convert_encoding($body, 'UTF-8', 'CP949');
        }

        $body = preg_replace('/<\?xml.*?\?>/i', '', $body);
        $body = trim($body);
        $body = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" . $body;

        $body = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$3", $body);

        $xml = simplexml_load_string($body, "SimpleXMLElement", LIBXML_NOCDATA | LIBXML_NOBLANKS);

        if ($xml === false) {
            log_message('error', '[XML Parse Fail] Data: ' . substr($body, 0, 200) . '...');
            foreach(libxml_get_errors() as $error) {
                log_message('error', $error->message);
            }
            libxml_clear_errors();

            return ['status' => 'error', 'message' => 'XML Parsing Failed'];
        }

        $json = json_encode($xml);
        return json_decode($json, true);
    }
}