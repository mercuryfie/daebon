<?php

namespace App\Controllers;

use App\Libraries\Cafe24Api;
use App\Libraries\CoupangApi;
use App\Libraries\ElevenStreetApi;
use App\Libraries\KakaoApi;
use App\Libraries\LotteDeliveryApi;
use App\Libraries\LotteOnApi;
use App\Libraries\NaverApi;
use App\Libraries\EsmApi;
use App\Libraries\SsgAPI;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;


class ApiMarketController extends BaseController
{
    use ResponseTrait;

    /**
     * 롯데택배 송장번호 생성
     */
    public function Make_Delivery_Code()
    {
        $lotte = new LotteDeliveryApi();
        $deliarr = $lotte->Make_Delivery_Code();

        $commom_m = model('Common_m');
        $Cnt = $commom_m->Insert_Delivery_Code($deliarr);

        echo($Cnt);

    }

    public function Shop_Order_Delivery(){
        try {
            $sessinarr = $this->GetSessionData();
            $orcode = ($this->request->getPost('oid') == '') ? '' : $this->request->getPost('oid');
            if ($sessinarr['islogin'] == false) {
                $result = 'NoLogin';
                $data = [];
                $message = '로그인이 필요합니다.';
            } else if (!Check_Token($sessinarr)) {
                $result = 'Error002';
                $data = [];
                $message = '잘못된 토큰입니다.';
            } else if ($orcode == '') {
                $result = 'Error003';
                $data = [];
                $message = '필수 입력값이 누락되었습니다.';
            } else {
                $order_m = model('Order_m');
                $Rs = $order_m->Load_Order_Info($orcode);
                if (fn_ArrayCnt($Rs) <= 0) {
                    $result = 'error';
                    $data = [];
                    $message = '잘못된 접근입니다.';
                }else if($Rs[0]['gdstep']>1){
                    $result = 'error';
                    $data = [];
                    $message = '이미 배송 처리된 주문입니다.';
                }else{
                    $shoptyp = $Rs[0]['shoptyp'];
                    if ($shoptyp == 'type1') {
                        $pRs = $order_m->Load_Order_Product($orcode);
                        if(fn_ArrayCnt($pRs)<=0){
                            $result = 'error';
                            $data = [];
                            $message = '주문 상폼이 존재 하지 않습니다';
                        }else{
                            $addInfo = $pRs[0]['addInfo'];
                            $arr = $this->Change_Coupan_AddInfo($addInfo);


                            $result = 'error';
                            $data = [];
                            $message = '주문 상폼이 존재 하지 않습니다';


                        }
                    }
                }
            }
        }catch(\Exception $e){
            log_message('error', '[송장업로드 처리 실패 API Error] ' . $e->getMessage());
            $result = 'error';
            $data = [];
            $message = "주문확인 처리 실패 [ERROR={$e->getMessage()}";
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }

    public function Shop_Order_Confirm(){
        try {
            $sessinarr = $this->GetSessionData();
            $orcode = ($this->request->getPost('orcode') == '') ? '' : $this->request->getPost('orcode');
            if ($sessinarr['islogin'] == false) {
                $result = 'NoLogin';
                $data = [];
                $message = '로그인이 필요합니다.';
            } else if (!Check_Token($sessinarr)) {
                $result = 'Error002';
                $data = [];
                $message = '잘못된 토큰입니다.';
            } else if ($orcode == '') {
                $result = 'Error003';
                $data = [];
                $message = '필수 입력값이 누락되었습니다.';
            } else {
                $order_m = model('Order_m');
                $Rs = $order_m->Load_Order_Info($orcode);
                if(fn_ArrayCnt($Rs)<=0) {
                    $result = 'error';
                    $data = [];
                    $message = '잘못된 접근입니다.';
                }else if($Rs[0]['gdstep']>0){
                    $result = 'error';
                    $data = [];
                    $message = '이미 확인 처리된 주문입니다.';
                }else {
//                    $delivery_m = model('Delivery_m');
//                    $fields = ['a.fk_opcode'];
//                    $sRs = $delivery_m->Load_DeliveryPackageByOrCode($orcode,$fields);
//                    $opcode = (fn_ArrayCnt($sRs) > 0 ) ? $sRs['fk_opcode'] : '';

                    $shoptyp = $Rs[0]['shoptyp'];
                    if ($shoptyp == 'type1') {
                        $addInfoJson = $Rs[0]['addInfo'];
                        $addInfoArray = json_decode($addInfoJson, true);
                        $shipmentBoxIds = isset($addInfoArray['shipmentBoxIds']) ? [$addInfoArray['shipmentBoxIds']] : [];
                        $coupang = new CoupangApi();
                        $arr = $coupang->Put_Order_Confirm($shipmentBoxIds);
                        if($arr['code']==200){
                            if($arr['data']['responseCode']==1) {
                                $param = [
                                    'gdstep' => 2
                                ];
                                $Cnt = $order_m->Update_Order_Info($orcode, $param);

                                $result = 'ok';
                                $data = ['orcode' => $orcode];
                                $message = '';
                            }else{
                                $result = 'error';
                                $data = [
                                    'code'=> $arr['data']['responseCode'],
                                    'message' => $arr['data']['responseMessage']
                                ];
                                $message = $arr['data']['responseMessage'];
                            }
                        }else{
                            $result = 'error';
                            $data = [
                                'code' => $arr['code'],
                                'message' => $arr['message']
                            ];
                            $message = $arr['message'];
                        }
                    } else if (($shoptyp == 'type2') || ($shoptyp == 'type3')) {
                        $esm = new EsmApi();
                        $arr = $esm->putOrderConfirm($orcode);
                    } else if ($shoptyp == 'type4') {
                        $eleven = new ElevenStreetApi();
                        $arr = $eleven->confirmOrder($orcode);
                    } else if ($shoptyp == 'type5') {
                        $arr = [];
                    } else if ($shoptyp == 'type6') {
                        $arr = [];
                    } else if ($shoptyp == 'type8') {
                        $naver = new NaverApi();
                        $t_arr[] = $orcode;
                        $arr = $naver->putOrderConfirm($t_arr);
                    } else if ($shoptyp == 'type13') {
                        $lotte = new LotteOnApi();
                        $arr = $lotte->putOrderConfirm($orcode);
                    } else if ($shoptyp == 'type14') {
                        $ssg = new SsgAPI();
                        $arr = $ssg->putOrderConfirm($orcode);
                    }
                }
            }
        }catch(\Exception $e){
            log_message('error', '[주문확인 처리 실패 API Error] ' . $e->getMessage());
            $result = 'error';
            $data = [];
            $message = "주문확인 처리 실패 [ERROR={$e->getMessage()}";
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }

    public function Shop_Order_List()
    {
        $sessinarr = $this->GetSessionData();
        $shoptyp = ($this->request->getPost('styp') == '') ? '' : $this->request->getPost('styp');
        $NextToken = ($this->request->getPost('token') == '') ? '' : $this->request->getPost('token');
        if ($sessinarr['islogin'] == false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        } else if (!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        } else if ($shoptyp == '') {
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        } else {
            $order_m = model('Order_m');
            $missCnt = $order_m->Cnt_Order_Miss_ShopType($shoptyp);
            if ($missCnt > 0) {
                $result = 'Error101';
                $data = [];
                $message = "주문등록에서 누락된 주문건이 존재합니다.<br>누락건 처리후 다시 동기화해주세요.";
            } else {
                $maker_m = model('Market_m');
                $param = ['shoptyp' => $shoptyp];
                $Rs = $maker_m->getMallLog($param);

                if (fn_ArrayCnt($Rs) > 0) {
                    $s_date = fn_NowDateFormat(2,$Rs[0]['enddate']);
                } else {
                    $s_date = fn_PrevDateFormat(2,1);
                }
                $e_date = fn_NextDateFormat(2,1,$s_date);
                $c_date = fn_NowDateFormat(2);

                if ($e_date > $c_date) {
                    $result = 'OverFlow';
                    $data = [];
                    $message = '마지막 동기화 날짜가 오늘을 넘을수 없습니다.';
                }else {
                    $arr = [];
                    if ($shoptyp == 'type1') {
                        $arr = $this->Coupang_Order_List($shoptyp, $s_date, $e_date, $NextToken);
                    } else if (($shoptyp == 'type2') || ($shoptyp == 'type3')) {
                        $arr = $this->ESM_Order_List($shoptyp, $s_date, $e_date);
                    } else if ($shoptyp == 'type4') {
                        $arr = $this->Eleven_Order_List($shoptyp, $s_date,$e_date);
                    } else if ($shoptyp == 'type5') {
//                        $kakao = new KakaoApi();
//                        $arr = $kakao->getOrderList();
                        $result = 'NotUse';
                        $message = '현재 API 수정으로 인해 사용불가 입니다.';
                    } else if ($shoptyp == 'type6') {
//                        $startdate = date('Y-m-d', strtotime('-7 days', strtotime($s_date)));
//                        $enddate = fn_NowDateFormat(2);
//                        $cafe = new Cafe24Api();
//                        $data = $cafe->getOrders($startdate, $enddate);
//                        $result = 'ok';
//                        $message = '';
                        $result = 'NotUse';
                        $message = '현재 API 수정으로 인해 사용불가 입니다.';
                    } else if ($shoptyp == 'type8') {
                        $arr = $this->Naver_Order_List($shoptyp, $s_date,$e_date);
                    } else if ($shoptyp == 'type13') {
                        $arr = $this->LotteOn_Order_List($shoptyp, $s_date,$e_date);
                    } else if ($shoptyp == 'type14') {
                        $arr = $this->SSG_Order_List($shoptyp,$s_date,$e_date);
                    }

                    $indate = fn_NowDateFormat(1);
                    $data = [
                        'period' => $s_date . '~' . $e_date,
                        'indate' => $indate
                    ];
                    if (fn_ArrayCnt($arr) > 0) {
                        $result = $arr['result'];
                        $message = $arr['message'];

                        if ($result == 'ok') {
                            $r_status = 1;
                            $r_msg = '주문등록 완료';
                        } else if ($result == 'miss') {
                            $r_status = 2;
                            $r_msg = '누락주문 존재';
                        } else if ($result == 'nothing') {
                            $r_status = 3;
                            $r_msg = '주문내역없음';
                        } else if ($result == 'NotUse') {
                            $r_status = 4;
                            $r_msg = '현재 API 수정으로 인해 사용불가 입니다.';
                        } else {
                            $r_status = 4;
                            $r_msg = 'UnKnown Error';
                        }

                        $param1 = [
                            'fk_shoptyp' => $shoptyp,
                            'typ' => 1,
                            'content' => $r_msg,
                            'status' => $r_status,
                            'startdate' => $s_date,
                            'enddate' => $e_date,
                            'indate' => $indate
                        ];
                        $order_m->Insert_Order_API_MallLog($param1);
                    }
                }
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    private function SSG_Order_List($shoptyp,$s_date,$e_date){
        try {
            $Cnt = 0;
            $is_miss = 0;
            $startdate = fn_NowDateFormat(3, $s_date);
            $enddate = fn_NowDateFormat(3, $e_date);
            $ssg = new SsgAPI();
            $order = $ssg->getShppDirectionList($startdate, $enddate);
            if (is_array($order) && isset($order['result']) && $order['result']['resultCode'] == '00') {
                $data = $order['result']['shppDirections'] ?? [];
                if (!empty($data) && is_array($data[0])) {
                    $groupedOrders = [];
                    foreach ($data as $d) {
                        $items = $d['shppDirection'];
                        foreach ($items as $item) {
                            $orderNo = $item['ordNo'];
                            if (!isset($groupedOrders[$orderNo])) {
                                $groupedOrders[$orderNo] = [];
                            }
                            $goods = [
                                'prdNo' => $item['itemId'],
                                'price' => $item['sellprc'],
                                'pname' => $item['itemNm'],
                                'cnt' => $item['ordQty'],
                                'shppNo' => $item['shppNo'],
                                'shppSeq' => $item['shppSeq']
                            ];
                            $groupedOrders[$orderNo][] = $goods;
                        }
                    }

                    $ssglist = $data[0]['shppDirection'];
                    foreach ($ssglist as $d) {
                        if (($d['shppProgStatDtlCd'] ?? '') != '11') {
                            continue;
                        }

                        $order_m = model('Order_m');
                        $spcode = $d['ordNo'];
                        $orderdate = $d['ordCmplDts'];
                        $PayDate = $d['ordCmplDts'];
                        $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                        $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                        if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                            $tcnt = 0;
                            $tprice = 0;
                            $orcode = fnMake_Code(10);
                            $order_buyer_info = [
                                'fk_orcode' => $orcode,
                                'buy_name' => $d['ordpeNm'],
                                'buy_zipcode' => '',
                                'buy_address1' => '',
                                'buy_address2' => '',
                                'buy_phone' => $d['ordpeHpno'],
                                'buy_memo' => '',
                                'receive_name' => $d['rcptpeNm'],
                                'receive_zipcode' => $d['shpplocZipcd'],
                                'receive_address1' => $d['shpplocAddr'],
                                'receive_address2' => '',
                                'receive_phone' => $d['ordpeHpno'],
                                'receive_memo' => $d['ordMemoCntt']
                            ];
                            $order_m->Insert_Order_Buyer($order_buyer_info);

                            $order_products = [];
                            if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                                foreach ($groupedOrders[$spcode] as $f) {
                                    $productid = $f['prdNo'];
                                    $nRs = $order_m->Load_Order_ProductByMatch($productid);
                                    if (fn_ArrayCnt($nRs) <= 0) {
                                        if ($is_miss == 0) $is_miss = 1;
                                        $fk_pdcode = '';
                                    } else {
                                        $fk_pdcode = $nRs[0]['fk_pdcode'];
                                    }

                                    $gprice = $f['price'];
                                    $gcnt = $f['cnt'];
                                    $gtprice = $gprice * $gcnt;

                                    $addProductInfo = json_encode([
                                        'shppNo' => $f['shppNo'],
                                        'shppSeq' => $f['shppSeq']
                                    ],JSON_THROW_ON_ERROR);

                                    $t_arr = [
                                        'fk_orcode' => $orcode,
                                        'fk_pdcode' => $fk_pdcode,
                                        'sgcode' => $productid,
                                        'sgname' => $f['pname'],
                                        'gprice' => $gprice,
                                        'gcnt' => $gcnt,
                                        'addProductInfo' => $addProductInfo,
                                        'gtprice' => $gtprice,
                                        'paydate' => $PayDate
                                    ];

                                    $tprice = $tprice + $gtprice;
                                    $tcnt = $tcnt + $gcnt;

                                    $order_products[] = $t_arr;
                                }
                            }
                            if (fn_ArrayCnt($order_products) > 0) {
                                $order_m->Insert_Order_Product($order_products);
                            }

                            $t_info = [
                                'orcode' => $orcode,
                                'spcode' => $spcode,
                                'shoptyp' => $shoptyp,
                                'tprice' => $tprice,
                                'tcnt' => $tcnt,
                                'input_typ' => 1,
                                'orderdate' => $orderdate
                            ];

                            if ($is_miss == 1) {
                                $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                            } else {
                                $Cnt = $order_m->Insert_Order_Info($t_info);
                            }
                        }
                    }

                    if ($is_miss == 1) {
                        $result = 'miss';
                        $message = '누락된 주문이 존재합니다.';
                    } else if ($Cnt <= 0) {
                        $result = 'nothing';
                        $message = '';
                    } else {
                        $result = 'ok';
                        $message = '';
                    }
                } else {
                    $result = 'nothing';
                    $message = '';
                }
            } else {
                $result = 'error';
                $message = "SSG API 통신실패 : [{$order['result']['resultMessage']}]";
            }
        } catch (\Exception $e) {
            log_message('error', '[SSG API Error] ' . $e->getMessage());
            $result = 'error';
            $message = "SSG API 통신실패 : [{$e->getMessage()}]";
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function Naver_Order_List($shoptyp,$s_date,$e_date){
        $Cnt = 0;
        $is_miss = 0;

        $startdate = Time::parse($s_date, 'Asia/Seoul')->format('Y-m-d\TH:i:s.vP');
        $enddate = Time::parse($e_date, 'Asia/Seoul')->format('Y-m-d\TH:i:s.vP');

        $naver = new NaverApi();
        $orderIds = $naver->getChangedOrderIds($startdate, $enddate);
        $data = $naver->getParsedOrderDetails($orderIds);
        if (fn_ArrayCnt($data) > 0) {
            $groupedOrders = [];
            foreach ($data as $item) {
                $orderNo = $item['order_id'];
                if (!isset($groupedOrders[$orderNo])) {
                    $groupedOrders[$orderNo] = [];
                }
                $goods = [
                    'prdNo' => $item['productId'],
                    'price' => $item['price'],
                    'pname' => $item['product_name'],
                    'cnt' => $item['quantity']
                ];
                $groupedOrders[$orderNo][] = $goods;
            }

            foreach ($data as $d) {
                if (($d['status'] ?? '') !== 'PAYED') {
                    continue;
                }

                $order_m = model('Order_m');
                $spcode = $d['order_id'];
                $orderdate = $d['order_date'];
                $PayDate = $d['pay_data'];
                $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                    $tcnt = 0;
                    $tprice = 0;
                    $orcode = fnMake_Code(10);
                    $order_buyer_info = [
                        'fk_orcode' => $orcode,
                        'buy_name' => $d['ordererName'],
                        'buy_zipcode' => '',
                        'buy_address1' => '',
                        'buy_address2' => '',
                        'buy_phone' => $d['ordererTel'],
                        'buy_memo' => '',
                        'receive_name' => $d['buyer_name'],
                        'receive_zipcode' => $d['zipcode'],
                        'receive_address1' => $d['address1'],
                        'receive_address2' => $d['address1'],
                        'receive_phone' => $d['buyer_phone'],
                        'receive_memo' => $d['shippingMemo']
                    ];
                    $order_m->Insert_Order_Buyer($order_buyer_info);

                    $order_products = [];
                    if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                        foreach ($groupedOrders[$spcode] as $f) {
                            $productid = $f['prdNo'];
                            $nRs = $order_m->Load_Order_ProductByMatch($productid);
                            if (fn_ArrayCnt($nRs) <= 0) {
                                if ($is_miss == 0) $is_miss = 1;
                                $fk_pdcode = '';
                            } else {
                                $fk_pdcode = $nRs[0]['fk_pdcode'];
                            }

                            $gprice = $f['price'];
                            $gcnt = $f['cnt'];
                            $gtprice = $gprice * $gcnt;

                            $t_arr = [
                                'fk_orcode' => $orcode,
                                'fk_pdcode' => $fk_pdcode,
                                'sgcode' => $productid,
                                'sgname' => $f['pname'],
                                'gprice' => $gprice,
                                'gcnt' => $gcnt,
                                'gtprice' => $gtprice,
                                'paydate' => $PayDate
                            ];

                            $tprice = $tprice + $gtprice;
                            $tcnt = $tcnt + $gcnt;

                            $order_products[] = $t_arr;
                        }
                    }
                    if (fn_ArrayCnt($order_products) > 0) {
                        $order_m->Insert_Order_Product($order_products);
                    }

                    $t_info = [
                        'orcode' => $orcode,
                        'spcode' => $spcode,
                        'shoptyp' => $shoptyp,
                        'tprice' => $tprice,
                        'tcnt' => $tcnt,
                        'input_typ' => 1,
                        'orderdate' => $orderdate
                    ];

                    if ($is_miss == 1) {
                        $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                    } else {
                        $Cnt = $order_m->Insert_Order_Info($t_info);
                    }
                }
            }

            if ($is_miss == 1) {
                $result = 'miss';
                $message = '누락된 주문이 존재합니다.';
            } else if ($Cnt <= 0) {
                $result = 'nothing';
                $message = '';
            } else {
                $result = 'ok';
                $message = '';
            }
        } else {
            $result = 'nothing';
            $message = '';
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function Coupang_Order_List($shoptyp,$s_date,$e_date,$NextToken){
        $Cnt = 0;
        $is_miss = 0;
        $coupang = new CoupangApi();
        $startdate = $s_date . '%2B09:00';
        $enddate = $e_date . '%2B09:00';
        $order = $coupang->Get_Order_Period($startdate, $enddate, 'ACCEPT', $NextToken);
        if ((!empty($order)) && ($order['code'] == 200)) {
            $order_m = model('Order_m');
            foreach ($order['data'] as $d) {
                $spcode = $d['orderId'];
                $orderdate = $d['orderedAt'];
                $PayDate = $d['paidAt'];
                $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                    $tcnt = 0;
                    $tprice = 0;
                    $orcode = fnMake_Code(10);
                    $order_buyer_info = [
                        'fk_orcode' => $orcode,
                        'buy_name' => $d['orderer']['name'],
                        'buy_zipcode' => '',
                        'buy_address1' => '',
                        'buy_address2' => '',
                        'buy_phone' => $d['orderer']['safeNumber'],
                        'buy_memo' => '',
                        'receive_name' => $d['receiver']['name'],
                        'receive_zipcode' => $d['receiver']['postCode'],
                        'receive_address1' => $d['receiver']['addr1'],
                        'receive_address2' => $d['receiver']['addr2'],
                        'receive_phone' => $d['receiver']['safeNumber'],
                        'receive_memo' => $d['parcelPrintMessage'],
                    ];

                    $order_products = [];
                    foreach ($d['orderItems'] as $f) {
                        $productid = $f['vendorItemId'];
                        $nRs = $order_m->Load_Order_ProductByMatch($productid);
                        if (fn_ArrayCnt($nRs) <= 0) {
                            if ($is_miss == 0) $is_miss = 1;
                            $fk_pdcode = '';
                        } else {
                            $fk_pdcode = $nRs[0]['fk_pdcode'];
                        }

                        $t_arr = [
                            'fk_orcode' => $orcode,
                            'fk_pdcode' => $fk_pdcode,
                            'sgcode' => $productid,
                            'sgname' => $f['vendorItemName'],
                            'gprice' => $f['salesPrice']['units'],
                            'gcnt' => $f['shippingCount'],
                            'gtprice' => $f['salesPrice']['units'],
                            'paydate' => $PayDate
                        ];

                        $tprice = $tprice + $f['salesPrice']['units'];
                        $tcnt = $tcnt + $f['shippingCount'];

                        $order_products[] = $t_arr;
                    }

                    $addInfo = json_encode(['shipmentBoxIds' => $d['shipmentBoxId']],JSON_THROW_ON_ERROR);

                    $t_info = [
                        'orcode' => $orcode,
                        'spcode' => $spcode,
                        'shoptyp' => $shoptyp,
                        'tprice' => $tprice,
                        'tcnt' => $tcnt,
                        'addInfo' => $addInfo,
                        'input_typ' => 1,
                        'orderdate' => $orderdate
                    ];
                    $order_m->Insert_Order_Buyer($order_buyer_info);
                    $order_m->Insert_Order_Product($order_products);

                    if ($is_miss == 1) {
                        $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                    } else {
                        $Cnt = $order_m->Insert_Order_Info($t_info);
                    }
                }
            }

            if ($is_miss == 1) {
                $result = 'miss';
                $message = '누락된 주문이 존재합니다.';
            } else if ($Cnt <= 0) {
                $result = 'nothing';
                $message = '';
            } else {
                $result = 'ok';
                $message = '';
            }
        } else {
            $result = 'error';
            $message = '해당 쇼핑몰의 주문정보 없음';
        }
        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function ESM_Order_List($shoptyp,$s_date,$e_date){
        $Cnt = 0;
        $is_miss = 0;
        $site = ($shoptyp == 'type2') ? 'au' : 'gm';
        $esm = new EsmApi($site);
        $startdate = $s_date . ' 09:00';
        $enddate = $e_date . ' 09:00';
        $order = $esm->getOrderList($startdate, $enddate);
        if ((!empty($order)) && ($order['ResultCode'] == 0)) {
            $groupedOrders = [];
            foreach ($order['Data']['RequestOrders'] as $item) {
                $orderNo = $item['OrderNo'];
                if (!isset($groupedOrders[$orderNo])) {
                    $groupedOrders[$orderNo] = [];
                }
                $goods = [
                    'SiteGoodsNo' => $item['SiteGoodsNo'],
                    'SalePrice' => $item['SalePrice'],
                    'GoodsName' => $item['GoodsName'],
                    'ContrAmount' => $item['ContrAmount'],
                    'OrderAmount' => $item['OrderAmount'],
                    'AcntMoney' => $item['AcntMoney']
                ];

                $groupedOrders[$orderNo][] = $goods;
            }

            $order_m = model('Order_m');
            foreach ($order['Data']['RequestOrders'] as $d) {
                $spcode = $d['OrderNo'];
                $orderdate = $d['OrderDate'];
                $PayDate = $d['PayDate'];
                $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                    $tcnt = 0;
                    $tprice = 0;
                    $orcode = fnMake_Code(10);
                    $order_buyer_info = [
                        'fk_orcode' => $orcode,
                        'buy_name' => $d['BuyerName'],
                        'buy_zipcode' => '',
                        'buy_address1' => '',
                        'buy_address2' => '',
                        'buy_phone' => $d['BuyerMobileTel'],
                        'buy_memo' => '',
                        'receive_name' => $d['ReceiverName'],
                        'receive_zipcode' => $d['ZipCode'],
                        'receive_address1' => $d['DelFrontAddress'],
                        'receive_address2' => $d['DelBackAddress'],
                        'receive_phone' => $d['HpNo'],
                        'receive_memo' => $d['DelMemo'],
                    ];
                    $order_m->Insert_Order_Buyer($order_buyer_info);

                    $order_products = [];
                    if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                        foreach ($groupedOrders[$spcode] as $f) {
                            $productid = $f['SiteGoodsNo'];
                            $nRs = $order_m->Load_Order_ProductByMatch($productid);
                            if (fn_ArrayCnt($nRs) <= 0) {
                                if ($is_miss == 0) $is_miss = 1;
                                $fk_pdcode = '';
                            } else {
                                $fk_pdcode = $nRs[0]['fk_pdcode'];
                            }

                            $gprice = $f['SalePrice'];
                            $gtprice = $f['OrderAmount'];
                            $gcnt = $f['ContrAmount'];
                            $t_arr = [
                                'fk_orcode' => $orcode,
                                'fk_pdcode' => $fk_pdcode,
                                'sgcode' => $productid,
                                'sgname' => $f['GoodsName'],
                                'gprice' => $gprice,
                                'gcnt' => $gcnt,
                                'gtprice' => $gtprice,
                                'paydate' => $PayDate
                            ];

                            $tprice = $tprice + $gtprice;
                            $tcnt = $tcnt + $gcnt;

                            $order_products[] = $t_arr;
                        }
                    }
                    if (fn_ArrayCnt($order_products) > 0) {
                        $order_m->Insert_Order_Product($order_products);
                    }

                    $t_info = [
                        'orcode' => $orcode,
                        'spcode' => $spcode,
                        'shoptyp' => $shoptyp,
                        'tprice' => $tprice,
                        'tcnt' => $tcnt,
                        'input_typ' => 1,
                        'orderdate' => $orderdate
                    ];

                    if ($is_miss == 1) {
                        $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                    } else {
                        $Cnt = $order_m->Insert_Order_Info($t_info);
                    }
                }
            }

            if ($is_miss == 1) {
                $result = 'miss';
                $message = '누락된 주문이 존재합니다.';
            } else if ($Cnt <= 0) {
                $result = 'nothing';
                $message = '';
            } else {
                $result = 'ok';
                $message = '';
            }
        } else {
            $result = 'error';
            $message = '해당 쇼핑몰의 주문정보 없음';
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function Eleven_Order_List($shoptyp,$s_date,$e_date){
        $Cnt = 0;
        $is_miss = 0;

        $startdate = fn_NowDateFormat(3,$s_date) . '0900';
        $enddate = fn_NowDateFormat(3,$e_date) . '0900';
        $eleven = new ElevenStreetApi();
        $data = $eleven->getNewOrders($startdate, $enddate);
        if (fn_ArrayCnt($data['order']) > 0) {
            $groupedOrders = [];
            foreach ($data['order'] as $item) {
                $orderNo = $item['ordNo'];
                if (!isset($groupedOrders[$orderNo])) {
                    $groupedOrders[$orderNo] = [];
                }
                $goods = [
                    'prdNo' => $item['prdNo'],
                    'price' => $item['selPrc'],
                    'prdNm' => $item['prdNm'],
                    'cnt' => $item['ordQty'],
                    'ordPrdSeq' => $item['ordPrdSeq'],
                    'addPrdYn' => $item['addPrdYn'],
                    'addPrdNo' => $item['addPrdNo'],
                    'dlvNo' => $item['dlvNo'],
                ];
                $groupedOrders[$orderNo][] = $goods;
            }

            $order_m = model('Order_m');
            foreach ($data['order'] as $d) {
                $spcode = $d['ordNo'];
                $orderdate = $d['ordDt'];
                $PayDate = $d['ordStlEndDt'];
                $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                    $tcnt = 0;
                    $tprice = 0;
                    $orcode = fnMake_Code(10);
                    $order_buyer_info = [
                        'fk_orcode' => $orcode,
                        'buy_name' => $d['ordNm'],
                        'buy_zipcode' => $d['ordMailNo'],
                        'buy_address1' => $d['ordBaseAddr'],
                        'buy_address2' => $d['ordDtlsAddr'],
                        'buy_phone' => $d['ordPrtblTel'],
                        'buy_memo' => '',
                        'receive_name' => $d['rcvrNm'],
                        'receive_zipcode' => $d['rcvrMailNo'],
                        'receive_address1' => $d['rcvrBaseAddr'],
                        'receive_address2' => $d['rcvrDtlsAddr'],
                        'receive_phone' => $d['rcvrPrtblNo'],
                        'receive_memo' => ''
                    ];
                    $order_m->Insert_Order_Buyer($order_buyer_info);

                    $order_products = [];
                    if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                        foreach ($groupedOrders[$spcode] as $f) {
                            $productid = $f['prdNo'];
                            $nRs = $order_m->Load_Order_ProductByMatch($productid);
                            if (fn_ArrayCnt($nRs) <= 0) {
                                if ($is_miss == 0) $is_miss = 1;
                                $fk_pdcode = '';
                            } else {
                                $fk_pdcode = $nRs[0]['fk_pdcode'];
                            }

                            $gprice = $f['price'];
                            $gcnt = $f['cnt'];
                            $gtprice = $gprice * $gcnt;

                            $addProductInfo = json_encode([
                                'ordPrdSeq' => $f['ordPrdSeq'],
                                'addPrdYn' => $f['addPrdYn'],
                                'addPrdNo' => $f['addPrdNo'],
                                'dlvNo' => $f['dlvNo']
                            ],JSON_THROW_ON_ERROR);


                            $t_arr = [
                                'fk_orcode' => $orcode,
                                'fk_pdcode' => $fk_pdcode,
                                'sgcode' => $productid,
                                'sgname' => $f['prdNm'],
                                'gprice' => $gprice,
                                'gcnt' => $gcnt,
                                'gtprice' => $gtprice,
                                'paydate' => $PayDate,
                                'addProductInfo' => $addProductInfo
                            ];

                            $tprice = $tprice + $gtprice;
                            $tcnt = $tcnt + $gcnt;

                            $order_products[] = $t_arr;
                        }
                    }
                    if (fn_ArrayCnt($order_products) > 0) {
                        $order_m->Insert_Order_Product($order_products);
                    }

                    $t_info = [
                        'orcode' => $orcode,
                        'spcode' => $spcode,
                        'shoptyp' => $shoptyp,
                        'tprice' => $tprice,
                        'tcnt' => $tcnt,
                        'input_typ' => 1,
                        'orderdate' => $orderdate
                    ];

                    if ($is_miss == 1) {
                        $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                    } else {
                        $Cnt = $order_m->Insert_Order_Info($t_info);
                    }
                }
            }

            if ($is_miss == 1) {
                $result = 'miss';
                $message = '누락된 주문이 존재합니다.';
            } else if ($Cnt <= 0) {
                $result = 'nothing';
                $message = '';
            } else {
                $result = 'ok';
                $message = '';
            }
        } else {
            $result = 'nothing';
            $message = '';
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function LotteOn_Order_List($shoptyp,$s_date,$e_date){
        $Cnt = 0;
        $is_miss = 0;
        $startdate = fn_NowDateFormat(3,$s_date) . '090000';
        $enddate = fn_NowDateFormat(3,$e_date) . '090000';

        $lotte = new LotteOnApi();
        $data = $lotte->getOrderList($startdate, $enddate);
        print_r($data);
        if (isset($data['returnCode']) && $data['returnCode'] === '0000') {
            $deliveryList = $data['data']['deliveryOrderList'] ?? [];
            if (!empty($deliveryList) && count($deliveryList) > 0) {
                $groupedOrders = [];
                foreach ($deliveryList as $item) {
                    $orderNo = $item['odNo'];
                    if (!isset($groupedOrders[$orderNo])) {
                        $groupedOrders[$orderNo] = [];
                    }
                    $goods = [
                        'prdNo' => $item['spdNo'],
                        'price' => $item['slPrc'],
                        'pname' => $item['spdNm'],
                        'cnt' => $item['odQty']
                    ];
                    $groupedOrders[$orderNo][] = $goods;
                }

                $order_m = model('Order_m');
                foreach ($deliveryList as $d) {
                    $spcode = $d['odNo'];
                    $orderdate = $d['odCmptDttm'];
                    $PayDate = $d['odCmptDttm'];
                    $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                    $cRs = $order_m->Load_Order_InfoByMiss($spcode);
                    if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                        $tcnt = 0;
                        $tprice = 0;
                        $orcode = fnMake_Code(10);
                        $order_buyer_info = [
                            'fk_orcode' => $orcode,
                            'buy_name' => $d['odrNm'],
                            'buy_zipcode' => '',
                            'buy_address1' => '',
                            'buy_address2' => '',
                            'buy_phone' => $d['mphnNo'],
                            'buy_memo' => '',
                            'receive_name' => $d['dvpCustNm'],
                            'receive_zipcode' => $d['dvpZipNo'],
                            'receive_address1' => $d['dvpStnmZipAddr'],
                            'receive_address2' => $d['dvpStnmDtlAddr'],
                            'receive_phone' => $d['dvpMphnNo'],
                            'receive_memo' => $d['dvMsg']
                        ];
                        $order_m->Insert_Order_Buyer($order_buyer_info);

                        $order_products = [];
                        if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                            foreach ($groupedOrders[$spcode] as $f) {
                                $productid = $f['prdNo'];
                                $nRs = $order_m->Load_Order_ProductByMatch($productid);
                                if (fn_ArrayCnt($nRs) <= 0) {
                                    if ($is_miss == 0) $is_miss = 1;
                                    $fk_pdcode = '';
                                } else {
                                    $fk_pdcode = $nRs[0]['fk_pdcode'];
                                }

                                $gprice = $f['price'];
                                $gcnt = $f['cnt'];
                                $gtprice = $gprice * $gcnt;

                                $t_arr = [
                                    'fk_orcode' => $orcode,
                                    'fk_pdcode' => $fk_pdcode,
                                    'sgcode' => $productid,
                                    'sgname' => $f['pname'],
                                    'gprice' => $gprice,
                                    'gcnt' => $gcnt,
                                    'gtprice' => $gtprice,
                                    'paydate' => $PayDate
                                ];

                                $tprice = $tprice + $gtprice;
                                $tcnt = $tcnt + $gcnt;

                                $order_products[] = $t_arr;
                            }
                        }
                        if (fn_ArrayCnt($order_products) > 0) {
                            $order_m->Insert_Order_Product($order_products);
                        }

                        $t_info = [
                            'orcode' => $orcode,
                            'spcode' => $spcode,
                            'shoptyp' => $shoptyp,
                            'tprice' => $tprice,
                            'tcnt' => $tcnt,
                            'input_typ' => 1,
                            'orderdate' => $orderdate
                        ];

                        if ($is_miss == 1) {
                            $Cnt = $order_m->Insert_Order_Info_Miss($t_info);
                        } else {
                            $Cnt = $order_m->Insert_Order_Info($t_info);
                        }
                    }
                }

                if ($is_miss == 1) {
                    $result = 'miss';
                    $message = '누락된 주문이 존재합니다.';
                } else if ($Cnt <= 0) {
                    $result = 'nothing';
                    $message = '';
                } else {
                    $result = 'ok';
                    $message = '';
                }
            } else {
                $result = 'nothing';
                $message = '';
            }
        } else {
            $result = 'error';
            $message = $response['message'] ?? 'Error';
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function Change_Coupan_AddInfo($orcode){




        $data = json_decode($value, true);
        $resultIds = [];

        if (isset($data['shipmentBoxIds'])) {
            $ids = $data['shipmentBoxIds'];
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $resultIds[] = $id;
                }
            } else {
                $resultIds[] = $ids;
            }
        }
        return $resultIds;
    }


}




?>