<?php
namespace App\Libraries;


use DOMDocument;
use DOMXPath;

class ElevenStreetApi
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = '1816a67090dc70019eb7c183b27198e4';
    }

    private function Connect_API($apiurl)
    {
        $client = service('curlrequest', [
            'timeout' => 30,
            'http_errors' => false,
            'headers' => ['OpenApiKey' => $this->apiKey]
        ]);

        $response = $client->get($apiurl);
        if ($response->getStatusCode() == 200) {
            $retval['status'] = 'ok';
            $retval['data'] = $response;
            $retval['message'] = 'success';
        } else if ($response->getStatusCode() != 200) {
            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            log_message('error', '11st API 오류: ' . $response->getStatusCode() . ' - ' . $response->getBody());
            $retval['status'] = 'error';
            $retval['data'] = '';
            $retval['message'] = $xml->resultMessag;
        }
        return $retval;
    }

    public function Eleven_Get_Order_Delivery($ordNo){
        $apiurl = "https://api.11st.co.kr/rest/claimservice/orderlistalladdr/$ordNo";
        $info  = $this->Connect_API($apiurl);
        if ($info['status'] === 'ok') {
            $response = $info['data'];
            $dom = new DOMDocument();
            $dom->loadXML($response->getBody(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            $xpath->registerNamespace('ns2', 'http://skt.tmall.business.openapi.spring.service.client.domain/');

            $orderNodes = $xpath->query('//ns2:order');
            foreach ($orderNodes as $orderNode) {
                $order = [
                    'dlvNo' => $xpath->query('.//dlvNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'ordNo' => $xpath->query('.//ordNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'prdNo' => $xpath->query('.//prdNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'prdNm' => $xpath->query('.//prdNm', $orderNode)->item(0)?->nodeValue ?? '',
                    'ordPrdStat' => $xpath->query('.//ordPrdStat', $orderNode)->item(0)?->nodeValue ?? '',
                    'ordQty' => $xpath->query('.//ordQty', $orderNode)->item(0)?->nodeValue ?? '',
                    'sellerId' => $xpath->query('.//sellerId', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrMailNo' => $xpath->query('.//rcvrMailNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrBaseAddr' => $xpath->query('.//rcvrBaseAddr', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrDtlsAddr' => $xpath->query('.//rcvrDtlsAddr', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrNm' => $xpath->query('.//rcvrNm', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrPrtblNo' => $xpath->query('.//rcvrPrtblNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'rcvrTlphn' => $xpath->query('.//rcvrTlphn', $orderNode)->item(0)?->nodeValue ?? '',
                    'ordPrdStatNm' => $xpath->query('.//ordPrdStatNm', $orderNode)->item(0)?->nodeValue ?? '',
                    'dlvEtprsCd' => $xpath->query('.//dlvEtprsCd', $orderNode)->item(0)?->nodeValue ?? '',
                    'invcNo' => $xpath->query('.//invcNo', $orderNode)->item(0)?->nodeValue ?? '',
                    'sndEndDt' => $xpath->query('.//sndEndDt', $orderNode)->item(0)?->nodeValue ?? '',
                ];
                $orders[] = $order;
            }

            $status = 'ok';
            $data = $orders;
            $message = '';
        }else{
            $status = 'error';
            $data = [];
            $message = $info['message'];
        }

        $result['status'] = $status;
        $result['data'] = $data;
        $result['message'] = $message;

        return $result;
    }

    public function Eleven_Set_Delivery($sendDt,$dlvMthdCd,$dlvEtprsCd,$invcNo,$dlvNo,$partDlvYn,$ordNo,$ordPrdSeq){
        $params = [$sendDt,$dlvMthdCd,$dlvEtprsCd,$invcNo,$dlvNo,$partDlvYn,$ordNo,$ordPrdSeq];
        $path = implode('/', $params);
        $apiurl = "https://api.11st.co.kr/rest/ordservices/reqdelivery/{$path}";
        $info  = $this->Connect_API($apiurl);
        if ($info['status'] === 'ok') {
            $response = $info['data'];
            $dom = new DOMDocument();
            $dom->loadXML($response->getBody(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            $xpath->registerNamespace('ns2', 'http://skt.tmall.business.openapi.spring.service.client.domain/');
        }else{
            $status = 'error';
            $data = [];
            $message = $info['message'];
        }

        $result['status'] = $status;
        $result['data'] = $data;
        $result['message'] = $message;

        return $result;
    }

    public function Eleven_Get_Order_Info_Period($startTime,$endTime){
        $apiurl = "https://api.11st.co.kr/rest/ordservices/complete/{$startTime}/{$endTime}";
        $info  = $this->Connect_API($apiurl);
        if ($info['status'] === 'ok') {
            $response = $info['data'];
            $dom = new DOMDocument();
            $dom->loadXML($response->getBody(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($dom);
            $xpath->registerNamespace('ns2', 'http://skt.tmall.business.openapi.spring.service.client.domain/');

            $t_arr =[];
            $Nodes = $xpath->query('//ns2:order');

            if ($Nodes->length === 0) {
                // 주문 없음 처리 (result_code 확인)
                $resultCode = $xpath->query('//ns2:result_code')->item(0)?->nodeValue ?? '';
                $resultText = $xpath->query('//ns2:result_text')->item(0)?->nodeValue ?? '';

                $status = $resultCode;
                $data = [];
                $message = $resultText;
            }else {
                foreach ($Nodes as $d) {
                    $arr = [
                        'addPrdNo' => $xpath->query('.//addPrdNo', $d)->item(0)?->nodeValue ?? '',
                        'addPrdYn' => $xpath->query('.//addPrdYn', $d)->item(1)?->nodeValue ?? '',
                        'bndlDlvSeq' => $xpath->query('.//bndlDlvSeq', $d)->item(2)?->nodeValue ?? '',
                        'bndlDlvYN' => $xpath->query('.//bndlDlvYN', $d)->item(3)?->nodeValue ?? '',
                        'dlvCst' => $xpath->query('.//dlvCst', $d)->item(4)?->nodeValue ?? '',
                        'dlvCstType' => $xpath->query('.//dlvCstType', $d)->item(5)?->nodeValue ?? '',
                        'bmDlvCst' => $xpath->query('.//bmDlvCst', $d)->item(6)?->nodeValue ?? '',
                        'bmDlvCstType' => $xpath->query('.//bmDlvCstType', $d)->item(7)?->nodeValue ?? '',
                        'dlvNo' => $xpath->query('.//dlvNo', $d)->item(8)?->nodeValue ?? '',
                        'gblDlvYn' => $xpath->query('.//gblDlvYn', $d)->item(9)?->nodeValue ?? '',
                        'giftCd/' => $xpath->query('.//giftCd/', $d)->item(10)?->nodeValue ?? '',
                        'memID' => $xpath->query('.//memID', $d)->item(11)?->nodeValue ?? '',
                        'memNo' => $xpath->query('.//memNo', $d)->item(12)?->nodeValue ?? '',
                        'ordAmt' => $xpath->query('.//ordAmt', $d)->item(13)?->nodeValue ?? '',
                        'ordBaseAddr' => $xpath->query('.//ordBaseAddr', $d)->item(14)?->nodeValue ?? '',
                        'ordDlvReqCont' => $xpath->query('.//ordDlvReqCont', $d)->item(15)?->nodeValue ?? '',
                        'ordDt' => $xpath->query('.//ordDt', $d)->item(16)?->nodeValue ?? '',
                        'ordDtlsAddr' => $xpath->query('.//ordDtlsAddr', $d)->item(17)?->nodeValue ?? '',
                        'ordMailNo' => $xpath->query('.//ordMailNo', $d)->item(18)?->nodeValue ?? '',
                        'ordNm' => $xpath->query('.//ordNm', $d)->item(19)?->nodeValue ?? '',
                        'ordNo' => $xpath->query('.//ordNo', $d)->item(20)?->nodeValue ?? '',
                        'ordOptWonStl' => $xpath->query('.//ordOptWonStl', $d)->item(21)?->nodeValue ?? '',
                        'ordPayAmt' => $xpath->query('.//ordPayAmt', $d)->item(22)?->nodeValue ?? '',
                        'ordPrdSeq' => $xpath->query('.//ordPrdSeq', $d)->item(23)?->nodeValue ?? '',
                        'ordPrtblTel' => $xpath->query('.//ordPrtblTel', $d)->item(24)?->nodeValue ?? '',
                        'ordQty' => $xpath->query('.//ordQty', $d)->item(25)?->nodeValue ?? '',
                        'ordStlEndDt' => $xpath->query('.//ordStlEndDt', $d)->item(26)?->nodeValue ?? '',
                        'ordTlphnNo' => $xpath->query('.//ordTlphnNo', $d)->item(27)?->nodeValue ?? '',
                        'prdNm' => $xpath->query('.//prdNm', $d)->item(28)?->nodeValue ?? '',
                        'prdNo' => $xpath->query('.//prdNo', $d)->item(29)?->nodeValue ?? '',
                        'prdStckNo' => $xpath->query('.//prdStckNo', $d)->item(30)?->nodeValue ?? '',
                        'rcvrBaseAddr' => $xpath->query('.//rcvrBaseAddr', $d)->item(31)?->nodeValue ?? '',
                        'rcvrDtlsAddr' => $xpath->query('.//rcvrDtlsAddr', $d)->item(32)?->nodeValue ?? '',
                        'rcvrMailNo' => $xpath->query('.//rcvrMailNo', $d)->item(33)?->nodeValue ?? '',
                        'rcvrMailNoSeq' => $xpath->query('.//rcvrMailNoSeq', $d)->item(34)?->nodeValue ?? '',
                        'rcvrNm' => $xpath->query('.//rcvrNm', $d)->item(35)?->nodeValue ?? '',
                        'rcvrPrtblNo' => $xpath->query('.//rcvrPrtblNo', $d)->item(36)?->nodeValue ?? '',
                        'rcvrTlphn' => $xpath->query('.//rcvrTlphn', $d)->item(37)?->nodeValue ?? '',
                        'selPrc' => $xpath->query('.//selPrc', $d)->item(38)?->nodeValue ?? '',
                        'sellerDscPrc' => $xpath->query('.//sellerDscPrc', $d)->item(39)?->nodeValue ?? '',
                        'sellerPrdCd' => $xpath->query('.//sellerPrdCd', $d)->item(40)?->nodeValue ?? '',
                        'slctPrdOptNm' => $xpath->query('.//slctPrdOptNm', $d)->item(41)?->nodeValue ?? '',
                        'tmallDscPrc' => $xpath->query('.//tmallDscPrc', $d)->item(42)?->nodeValue ?? '',
                        'gifeser' => $xpath->query('.//gifeser', $d)->item(43)?->nodeValue ?? '',
                        'typeAdd' => $xpath->query('.//typeAdd', $d)->item(44)?->nodeValue ?? '',
                        'typeBilNo/' => $xpath->query('.//typeBilNo/', $d)->item(45)?->nodeValue ?? '',
                        'lstTmallDscPrc' => $xpath->query('.//lstTmallDscPrc', $d)->item(46)?->nodeValue ?? '',
                        'lstSellerDscPrc' => $xpath->query('.//lstSellerDscPrc', $d)->item(47)?->nodeValue ?? '',
                        'referSeq' => $xpath->query('.//referSeq', $d)->item(48)?->nodeValue ?? '',
                        'sellerStockCd' => $xpath->query('.//sellerStockCd', $d)->item(49)?->nodeValue ?? '',
                        'appmtDdDlvDy' => $xpath->query('.//appmtDdDlvDy', $d)->item(50)?->nodeValue ?? '',
                        'engNm' => $xpath->query('.//engNm', $d)->item(51)?->nodeValue ?? '',
                        'psnCscUniqNo' => $xpath->query('.//psnCscUniqNo', $d)->item(52)?->nodeValue ?? '',
                        'dlvSndDue' => $xpath->query('.//dlvSndDue', $d)->item(53)?->nodeValue ?? '',
                        'delaySendDt' => $xpath->query('.//delaySendDt', $d)->item(54)?->nodeValue ?? '',
                        'visitDlvYn/' => $xpath->query('.//visitDlvYn/', $d)->item(55)?->nodeValue ?? '',
                        'sendGiftYn' => $xpath->query('.//sendGiftYn', $d)->item(56)?->nodeValue ?? '',
                        'sendClfCd' => $xpath->query('.//sendClfCd', $d)->item(57)?->nodeValue ?? '',
                    ];
                    $t_arr[] = $arr;
                }

                $status = 'ok';
                $data = $t_arr;
                $message = '';
            }
        }else{
            $status = 'error';
            $data = [];
            $message = $info['message'];
        }

        $result['status'] = $status;
        $result['data'] = $data;
        $result['message'] = $message;

        return $result;

    }





}