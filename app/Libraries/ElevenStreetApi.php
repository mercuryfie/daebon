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
        $path = "/ordservices/complete/{$startTime}/{$endTime}";
        $res = $this->callApi('GET', $path, []);

        if (!isset($res['order'])) {
            $res['order'] = [];
        }
        return $res;
    }


    /**
     * 발주 확인 처리 (상품 준비중 처리)
     */
    public function confirmOrder(string $orcode)
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
                $path = "/ordservices/reqpackaging/{$sgcode}/{$Info['ordPrdSeq']}/{$Info['addPrdYn']}/{$Info['addPrdNo']}/{$Info['dlvNo']}";
                $results[$sgcode] = $this->callApi('GET', $path, "");
            }
            return $results;
        } catch (\Exception $e) {
            log_message('error', '[confirmOrder 전체 에러] ' . $e->getMessage());
            return ['result' => 'error', 'message' => $e->getMessage()];
        }
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
        $result = json_decode($json, true);

        if (isset($result['order']) && isset($result['order']['ordNo'])) {
            $result['order'] = [$result['order']];
        }
        return $result;
    }

    private function Sample_order(){
        $sample = '
        <?xml version="1.0" encoding="euc-kr" standalone="yes"?>
            <ns2:orders>
              <ns2:order>
                <addPrdNo>0</addPrdNo>
                <addPrdYn>N</addPrdYn>
                <bndlDlvSeq>4506571</bndlDlvSeq>
                <bndlDlvYN>Y</bndlDlvYN>
                <custGrdNm/>
                <lstDlvCst>0</lstDlvCst>
                <dlvCstType>03</dlvCstType>
                <bmDlvCst>4500</bmDlvCst>
                <bmDlvCstType>04</bmDlvCstType>
                <dlvNo>40860365</dlvNo>
                <gblDlvYn>N</gblDlvYn>
                <giftCd/>
                <memID>test11st</memID>
                <memNo>1111111</memNo>
                <ordAmt>19000</ordAmt>
                <ordPayAmtPerSeq>19000</ordPayAmtPerSeq>
                <ordBaseAddr>충북 청주시 상당구 용암동</ordBaseAddr>
                <ordDlvReqCont>null</ordDlvReqCont>
                <ordDt>2010-01-10 04:07:11</ordDt>
                <ordDtlsAddr>00번지</ordDtlsAddr>
                <ordMailNo>360100</ordMailNo>
                <ordNm>홍길동</ordNm>
                <ordNo>201001108318120</ordNo>
                <ordOptWonStl>0</ordOptWonStl>
                <ordPayAmt>16310</ordPayAmt>
                <ordPrdSeq>1</ordPrdSeq>
                <ordPrtblTel>010-9999-9999</ordPrtblTel>
                <ordQty>1</ordQty>
                <ordStlEndDt>2010-01-12 16:20:59</ordStlEndDt>
                <ordTlphnNo>070-9999-9999</ordTlphnNo>
                <plcodrCnfDt>null</plcodrCnfDt>
                <prdNm>셔링 브이넥 니트 티셔츠</prdNm>
                <prdNo>29370295</prdNo>
                <prdStckNo>999999999</prdStckNo>
                <rcvrBaseAddr>충북 청주시 상당구 용암동</rcvrBaseAddr>
                <rcvrDtlsAddr>00번지 8809호</rcvrDtlsAddr>
                <rcvrMailNo>360100</rcvrMailNo>
                <rcvrMailNoSeq>011</rcvrMailNoSeq>
                <rcvrNm>홍길동</rcvrNm>
                <rcvrPrtblNo>010-9999-9999</rcvrPrtblNo>
                <rcvrTlphn>070-9999-9999</rcvrTlphn>
                <selPrc>19000</selPrc>
                <sellerDscPrc>2280</sellerDscPrc>
                <sellerDscPrcPerSeq>2280</sellerDscPrcPerSeq>
                <sellerPrdCd>000000000133275</sellerPrdCd>
                <slctPrdOptNm>사이즈/색상:사이즈 - S(66)/색상 - 아이보리 [0000346774]-1개</slctPrdOptNm>
                <tmallDscPrc>410</tmallDscPrc>
                <tmallDscPrcPerSeq>410</tmallDscPrcPerSeq>
                <stlPlnAmt>19000</stlPlnAmt>
                <gifeser>1</gifeser>
                <typeAdd>01</typeAdd>
                <typeBilNo/>
                <lstTmallDscPrc>0</lstTmallDscPrc>
                <lstSellerDscPrc>0</lstSellerDscPrc>
                <ordCnQty>0</ordCnQty>
                <dlvMthdCd>01</dlvMthdCd>
                <dlvEtprsCd>00007</dlvEtprsCd>
                <invcNo>1234567890</invcNo>
                <sndEndDt>2015-01-12 16:36:14</sndEndDt>
                <referSeq>455221112</referSeq>
                <sellerStockCd>43434232</sellerStockCd>
                <appmtDdDlvDy>20170420</appmtDdDlvDy>
                <appmtEltRefuseYn/>
                <appmtselStockCd/>
                <engNm>CHULSU KIM</engNm>
                <psnCscUniqNo>P000000000000</psnCscUniqNo>
                <visitDlvYn/>
                <sendGiftYn>Y</sendGiftYn>
              </ns2:order>
              <ns2:order>
                <addPrdNo>0</addPrdNo>
                <addPrdYn>N</addPrdYn>
                <bndlDlvSeq>4506571</bndlDlvSeq>
                <bndlDlvYN>Y</bndlDlvYN>
                <custGrdNm/>
                <lstDlvCst>0</lstDlvCst>
                <dlvCstType>03</dlvCstType>
                <bmDlvCst>4500</bmDlvCst>
                <bmDlvCstType>04</bmDlvCstType>
                <dlvNo>40860365</dlvNo>
                <gblDlvYn>N</gblDlvYn>
                <giftCd/>
                <memID>test11st</memID>
                <memNo>1111111</memNo>
                <ordAmt>19000</ordAmt>
                <ordPayAmtPerSeq>19000</ordPayAmtPerSeq>
                <ordBaseAddr>충북 청주시 상당구 용암동</ordBaseAddr>
                <ordDlvReqCont>null</ordDlvReqCont>
                <ordDt>2010-01-10 04:07:11</ordDt>
                <ordDtlsAddr>00번지</ordDtlsAddr>
                <ordMailNo>360100</ordMailNo>
                <ordNm>홍길동</ordNm>
                <ordNo>201001108318120</ordNo>
                <ordOptWonStl>0</ordOptWonStl>
                <ordPayAmt>16310</ordPayAmt>
                <ordPrdSeq>1</ordPrdSeq>
                <ordPrtblTel>010-9999-9999</ordPrtblTel>
                <ordQty>1</ordQty>
                <ordStlEndDt>2010-01-12 16:20:59</ordStlEndDt>
                <ordTlphnNo>070-9999-9999</ordTlphnNo>
                <plcodrCnfDt>null</plcodrCnfDt>
                <prdNm>셔링 브이넥 니트 티셔츠</prdNm>
                <prdNo>29370295</prdNo>
                <prdStckNo>999999999</prdStckNo>
                <rcvrBaseAddr>충북 청주시 상당구 용암동</rcvrBaseAddr>
                <rcvrDtlsAddr>00번지 8809호</rcvrDtlsAddr>
                <rcvrMailNo>360100</rcvrMailNo>
                <rcvrMailNoSeq>011</rcvrMailNoSeq>
                <rcvrNm>홍길동</rcvrNm>
                <rcvrPrtblNo>010-9999-9999</rcvrPrtblNo>
                <rcvrTlphn>070-9999-9999</rcvrTlphn>
                <selPrc>9000</selPrc>
                <sellerDscPrc>2280</sellerDscPrc>
                <sellerDscPrcPerSeq>2280</sellerDscPrcPerSeq>
                <sellerPrdCd>000000000133275</sellerPrdCd>
                <slctPrdOptNm>사이즈/색상:사이즈 - S(66)/색상 - 아이보리 [0000346774]-1개</slctPrdOptNm>
                <tmallDscPrc>410</tmallDscPrc>
                <tmallDscPrcPerSeq>410</tmallDscPrcPerSeq>
                <stlPlnAmt>19000</stlPlnAmt>
                <gifeser>1</gifeser>
                <typeAdd>01</typeAdd>
                <typeBilNo/>
                <lstTmallDscPrc>0</lstTmallDscPrc>
                <lstSellerDscPrc>0</lstSellerDscPrc>
                <ordCnQty>0</ordCnQty>
                <dlvMthdCd>01</dlvMthdCd>
                <dlvEtprsCd>00007</dlvEtprsCd>
                <invcNo>1234567890</invcNo>
                <sndEndDt>2015-01-12 16:36:14</sndEndDt>
                <referSeq>455221112</referSeq>
                <sellerStockCd>43434232</sellerStockCd>
                <appmtDdDlvDy>20170420</appmtDdDlvDy>
                <appmtEltRefuseYn/>
                <appmtselStockCd/>
                <engNm>CHULSU KIM</engNm>
                <psnCscUniqNo>P000000000000</psnCscUniqNo>
                <visitDlvYn/>
                <sendGiftYn>Y</sendGiftYn>
              </ns2:order>
            </ns2:orders>
        ';

        return $sample;
    }

}