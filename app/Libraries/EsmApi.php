<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use Exception;

class EsmApi
{
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

        $this->client = Services::curlrequest([
            'timeout'     => 30,
            'verify'      => false,
            'http_errors' => false
        ]);
    }

    /**
     * 배송정보 등록
     */
    public function putDeliveryInfo(array $orInfo): array{
        $endpoint = "/shipping/v1/Delivery/ShippingInfo";
        return $this->request('POST', $endpoint, $orInfo);
    }

    /**
     * 주문 확인
     */
    public function putOrderConfirm(string $orderNo){
        $endpoint = "/shipping/v1/Order/OrderCheck/{$orderNo}";
        $param = [
            'SellerOrderNo' => '',
            'SellerItemNo' => ''
        ];

        return $this->request('POST', $endpoint, $param);
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
        //return $this->Sample_order();
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
            $fullUrl = $this->baseUrl . $endpoint;
            $response = $this->client->request($method, $fullUrl, $options);
            if ($response->getStatusCode() >= 400) {
                throw new Exception("HTTP Error " . $response->getStatusCode() . ": " . $response->getBody());
            }

            put_Shop_Api_Log($this->shopType,'Success',$this->baseUrl,$endpoint,$data,$method,$response->getBody());
            $decoded = json_decode($response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON Decode Error: " . json_last_error_msg());
            }
            return $decoded;
        } catch (\Exception $e) {
            log_message('error', '[ESM API Error] ' . $e->getMessage());
            put_Shop_Api_Log($this->shopType,'Error',$this->baseUrl,$endpoint,$data,$method,$e->getMessage());
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

    private function Sample_order()
    {
        $sample = '';
        if ($this->siteType == 'au') {
            $sample = '{
            "ResultCode":0,
            "Message":"",
            "Data":{
                "SiteType":1,
                "PageIndex":1,
                "PageSize":1000,
                "TotalCount":1,
                "SellerId":"test",
                "RequestOrders":[
                    {
                        "PayNo":1192803141,
                        "GroupNo":915317046,
                        "OrderNo":1589617617,
                        "OrderStatus":1,
                        "BranchCode":null,
                        "OrderDate":"2019-04-10T11:10:00",
                        "PayDate":"2019-04-10T11:10:00",
                        "OrderConfirmDate":null,
                        "TransDate":null,
                        "TransDueDate":"2019-04-15T23:59:59",
                        "TransCompleteDate":null,
                        "BuyDecisionDate":null,
                        "TransType":"B",
                        "GoodsNo":"",
                        "SiteGoodsNo":"E602156397",
                        "OutGoodsNo":"",
                        "GoodsName":"만두 1세트",
                        "SalePrice":"1000.0000",
                        "ContrAmount":1,
                        "OrderAmount":"1000.0000",
                        "AcntMoney":"800.0000",
                        "SellerDiscountPrice1":"200.0000",
                        "SellerDiscountPrice2":"0.0000",
                        "SellerDiscountPrice":"200.0000",
                        "DirectDiscountPrice":"0.0000",
                        "CostPrice":"670.0000",
                        "ShippingFee":"0.0000",
                        "DeliveryFeeCondition":"D",
                        "BackwoodsAddDeliveryFee":"0.0000",
                        "JejuAddDeliveryFee":"0.0000",
                        "SettlementPrice":"670.0000",
                        "OutsidePrice":"200.0000",
                        "ServiceFee":"130.0000",
                        "BasicServiceFee":"130.0000",
                        "SellerCashbackMoney":"0.0000",
                        "SinglePayDcAmnt":"0.0000",
                        "MultiBuyDcAmnt":"0.0000",
                        "GreatMembDcAmnt":"0.0000",
                        "OptSelPrice":null,
                        "OptAddPrice":null,
                        "BuyerName":"테스터",
                        "BuyerId":"abc**",
                        "BuyerMobileTel":"010-1234-5678",
                        "BuyerTel":"02-1111-2222",
                        "ReceiverName":"테스터",
                        "HpNo":"010-1234-5678",
                        "TelNo":"010-1234-5678",
                        "ZipCode":"06236",
                        "DelFrontAddress":"서울특별시 강남구 역삼동 804 역삼역",
                        "DelBackAddress":"강남지점",
                        "DelFullAddress":"서울특별시 강남구 역삼동 804 역삼역 강남지점",
                        "DelMemo":"",
                        "AllocationDate":null,
                        "DeliverySlotId":null,
                        "BranchPrice":null,
                        "ReplaceYn":null,
                        "TakbaeName":null,
                        "NoSongjang":null,
                        "OverseaTransYn":"N",
                        "InfoCin":"",
                        "GlobalSellerYn":"N",
                        "OutOrderNo":null,
                        "SKUNo":null,
                        "ItemOptionSelectList":[],
                        "ItemOptionAdditionList":[],
                        "FreeGift":null,
                        "FreeGiftCode":null,
                        "Bonus":null,
                        "BonusCode":null
                    },
                    {
                        "PayNo":1192803141,
                        "GroupNo":915317046,
                        "OrderNo":1589617617,
                        "OrderStatus":1,
                        "BranchCode":null,
                        "OrderDate":"2019-04-10T11:10:00",
                        "PayDate":"2019-04-10T11:10:00",
                        "OrderConfirmDate":null,
                        "TransDate":null,
                        "TransDueDate":"2019-04-15T23:59:59",
                        "TransCompleteDate":null,
                        "BuyDecisionDate":null,
                        "TransType":"B",
                        "GoodsNo":"",
                        "SiteGoodsNo":"E602153069",
                        "OutGoodsNo":"",
                        "GoodsName":"만두 1세트",
                        "SalePrice":"2200.0000",
                        "ContrAmount":1,
                        "OrderAmount":"2200.0000",
                        "AcntMoney":"800.0000",
                        "SellerDiscountPrice1":"200.0000",
                        "SellerDiscountPrice2":"0.0000",
                        "SellerDiscountPrice":"200.0000",
                        "DirectDiscountPrice":"0.0000",
                        "CostPrice":"670.0000",
                        "ShippingFee":"0.0000",
                        "DeliveryFeeCondition":"D",
                        "BackwoodsAddDeliveryFee":"0.0000",
                        "JejuAddDeliveryFee":"0.0000",
                        "SettlementPrice":"670.0000",
                        "OutsidePrice":"200.0000",
                        "ServiceFee":"130.0000",
                        "BasicServiceFee":"130.0000",
                        "SellerCashbackMoney":"0.0000",
                        "SinglePayDcAmnt":"0.0000",
                        "MultiBuyDcAmnt":"0.0000",
                        "GreatMembDcAmnt":"0.0000",
                        "OptSelPrice":null,
                        "OptAddPrice":null,
                        "BuyerName":"테스터",
                        "BuyerId":"abc**",
                        "BuyerMobileTel":"010-1234-5678",
                        "BuyerTel":"02-1111-2222",
                        "ReceiverName":"테스터",
                        "HpNo":"010-1234-5678",
                        "TelNo":"010-1234-5678",
                        "ZipCode":"06236",
                        "DelFrontAddress":"서울특별시 강남구 역삼동 804 역삼역",
                        "DelBackAddress":"강남지점",
                        "DelFullAddress":"서울특별시 강남구 역삼동 804 역삼역 강남지점",
                        "DelMemo":"",
                        "AllocationDate":null,
                        "DeliverySlotId":null,
                        "BranchPrice":null,
                        "ReplaceYn":null,
                        "TakbaeName":null,
                        "NoSongjang":null,
                        "OverseaTransYn":"N",
                        "InfoCin":"",
                        "GlobalSellerYn":"N",
                        "OutOrderNo":null,
                        "SKUNo":null,
                        "ItemOptionSelectList":[],
                        "ItemOptionAdditionList":[],
                        "FreeGift":null,
                        "FreeGiftCode":null,
                        "Bonus":null,
                        "BonusCode":null
                    }
                ]
            }
        }';
        } else if ($this->siteType == 'gm') {
            $sample = '{
            "ResultCode":0,
            "Message":"",
            "Data":{
                "SiteType":3,
                "PageIndex":1,
                "PageSize":1000,
                "TotalCount":1,
                "SellerId":"selleridtest",
                "RequestOrders":[
                    {
                        "OrderStatus":1,
                        "BranchCode":24,
                        "PayNo":4454223145,
                        "GroupNo":731875814,
                        "OrderNo":2946269058,
                        "OrderDate":"2019-04-10T17:45:39.727",
                        "PayDate":"2019-04-10T17:45:50.507",
                        "OrderConfirmDate":null,
                        "TransDate":null,
                        "TransDueDate":"2019-05-10T23:59:59",
                        "TransCompleteDate":null,
                        "BuyDecisionDate":null,
                        "TransType":"F",
                        "GoodsNo":null,
                        "SiteGoodsNo":"1496943317",
                        "OutGoodsNo":"1408425",
                        "GoodsName":"만두 420G",
                        "SalePrice":"3400.0000",
                        "ContrAmount":2,
                        "OrderAmount":"6800.0000",
                        "AcntMoney":"6800.0000",
                        "SellerDiscountPrice1":"0.0000",
                        "SellerDiscountPrice2":"0.0000",
                        "SellerDiscountPrice":"0.0000",
                        "DirectDiscountPrice":"0.0000",
                        "CostPrice":"6392.0000",
                        "ShippingFee":"0.0000",
                        "DeliveryFeeCondition":"M",
                        "BackwoodsAddDeliveryFee":"0.0000",
                        "JejuAddDeliveryFee":"0.0000",
                        "SettlementPrice":"6392.0000",
                        "OutsidePrice":"0.0000",
                        "ServiceFee":"408.0000",
                        "SellerCashbackMoney":"0.0000",
                        "SinglePayDcAmnt":null,
                        "MultiBuyDcAmnt":null,
                        "GreatMembDcAmnt":null,
                        "OptSelPrice":"0.0000",
                        "OptAddPrice":"0.0000",
                        "BuyerName":"테스터",
                        "BuyerId":"abc*******",
                        "BuyerMobileTel":"010-1234-5678",
                        "BuyerTel":"02-111-2222",
                        "ReceiverName":"테스터",
                        "HpNo":"010-1234-5678",
                        "TelNo":"010-1234-5678",
                        "ZipCode":"05812",
                        "DelFrontAddress":"서울특별시 송파구 충민로6길 14 (송파파인타운6단지)",
                        "DelBackAddress":"1000호",
                        "DelFullAddress":"서울특별시 송파구 충민로6길 14 (송파파인타운6단지) 1000호",
                        "DelMemo":"",
                        "AllocationStartDate":"2019-04-11T17:00:00",
                        "AllocationEndDate":"2019-04-11T19:00:00",
                        "DeliverySlotId":522547,
                        "BranchPrice":"0.0000",
                        "ReplaceYn":"Y",
                        "TakbaeName":"ABC",
                        "NoSongjang":null,
                        "OverseaTransYn":"N",
                        "GlobalSellerYn":"N",
                        "OutOrderNo":"101",
                        "InfoCin":null,
                        "InventoryNo":"",
                        "SKUNo":null,
                        "ItemOptionSelectList":[],
                        "ItemOptionAdditionList":[],
                        "FreeGift":null,
                        "FreeGiftCode":null,
                        "Bonus":null,
                        "BonusCode":null
                    }
                ]
            }
        }';
        }

        return json_decode($sample, true);
    }

}