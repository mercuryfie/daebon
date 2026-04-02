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
                }else if($Rs[0]['gdstep']>1){
                    $result = 'error';
                    $data = [];
                    $message = '이미 확인 처리된 주문입니다.';
                }else {
                    $shoptyp = $Rs[0]['shoptyp'];
                    $spcode = $Rs[0]['spcode'];
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
                        $site = ($shoptyp == 'type2') ? 'au' : 'gm';
                        $esm = new EsmApi($site);
                        $arr = $esm->putOrderConfirm($spcode);
                        if (isset($arr['ResultCode']) && $arr['ResultCode'] === 0) {
                            $result = 'ok';
                            $data = [];
                            $message = '';
                        }else{
                            $result = 'error';
                            $data = [];
                            $message = $arr['Message'];
                        }

                    } else if ($shoptyp == 'type4') {
                        $eleven = new ElevenStreetApi();
                        $arr = $eleven->confirmOrder($orcode);
                        $data  = [];
                        if (is_array($arr) && isset($arr['result']) && $arr['result'] === 'error') {
                            $result = 'error';
                            $message = "11번가 API 시스템/통신 실패: " . $arr['message'];
                            log_message('error', $message);
                        }
                        else {
                            $successCount = 0;
                            $errorCount = 0;
                            $errorMessages = [];

                            foreach ($arr as $sgcode => $response) {
                                if (isset($response['status']) && $response['status'] === 'error') {
                                    $errorCount++;
                                    $errorMessages[] = "[{$sgcode}] 파싱 실패: " . $response['message'];
                                    continue;
                                }

                                if (isset($response['result_code']) && (string)$response['result_code'] === '0') {
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errorCode = $response['result_code'] ?? '알수없음';
                                    $errorText = $response['result_text'] ?? '발주 처리 실패';
                                    $errorMessages[] = "[{$sgcode}] 발주 실패({$errorCode}): {$errorText}";
                                }
                            }
                            if ($errorCount > 0) {
                                $result = 'error';
                                $message = "11번가 발주 처리 중 일부/전체 실패:\n" . implode("\n", $errorMessages);
                            } else {
                                $param = ['gdstep' => 2];
                                $order_m->Update_Order_Info($orcode, $param);

                                $result = 'ok';
                                $data = ['orcode' => $orcode];
                                $message = "총 {$successCount}건이 정상적으로 발주 처리되었습니다.";
                            }
                        }
                    } else if ($shoptyp == 'type5') {
                        $arr = [];
                    } else if ($shoptyp == 'type6') {
                        $arr = [];
                    } else if ($shoptyp == 'type8') {
                        $fields = ['addProductInfo'];
                        $cRs = $order_m->Load_Order_Product($orcode);
                        if(fn_ArrayCnt($cRs)<=0){
                            $result = 'error';
                            $data = [];
                            $message = '존재하지 않는 주문정보입니다.';
                        }else{
                            foreach ($cRs as $r){
                                $t_arr[] = $r['addProductInfo'];
                            }
                            $naver = new NaverApi();
                            $arr = $naver->putOrderConfirm($t_arr);
                            $result = 'ok';
                            $data = [];
                            $message = '';
                        }
                    } else if ($shoptyp == 'type13') {
                        $lotte = new LotteOnApi();
                        $arr = $lotte->putOrderConfirm($orcode);
                        $data  = [];
                        if (!is_array($arr) || empty($arr)) {
                            $result = 'error';
                            $message = "LotteOn API 통신 실패 또는 응답이 올바르지 않습니다.";
                        } else {
                            $returnCode = $arr['returnCode'] ?? '';
                            $rsltCd = $arr['data']['rsltCd'] ?? '';
                            if ($returnCode === '0000' && $rsltCd === '0000') {
                                $param = ['gdstep' => 2];
                                $order_m->Update_Order_Info($orcode, $param);

                                $result = 'ok';
                                $data = ['orcode' => $orcode];
                                $message = '주문 확인 처리가 완료되었습니다.';
                            } else {
                                $fail_message = $arr['data']['rsltMsg'] ?? $arr['message'] ?? '알 수 없는 에러';
                                $result = 'error';
                                $message = "LotteOn 처리 실패: [{$returnCode}] " . $fail_message;
                            }
                        }
                    } else if ($shoptyp == 'type14') {
                        $ssg = new SsgAPI();
                        $arr = $ssg->putOrderConfirm($orcode);
                        $data  = [];

                        if (is_array($arr) && isset($arr['result']) && $arr['result'] === 'error') {
                            $result = 'error';
                            $message = "SSG API 통신 실패: " . $arr['message'];
                        }
                        else if (is_array($arr) && !empty($arr)) {
                            $is_all_success = true;
                            $fail_message = "";

                            foreach ($arr as $sgcode => $res) {
                                if (!isset($res['result']['resultCode']) || $res['result']['resultCode'] !== '00') {
                                    $is_all_success = false;
                                    $fail_message = $res['result']['resultDesc'] ?? "알 수 없는 에러";
                                    break;
                                }
                            }
                            if ($is_all_success) {
                                $param = ['gdstep' => 2];
                                $order_m->Update_Order_Info($orcode, $param);

                                $result = 'ok';
                                $data = ['orcode' => $orcode];
                                $message = '주문 확인 처리가 완료되었습니다.';
                            } else {
                                $result = 'error';
                                $message = "SSG 처리 실패: " . $fail_message;
                            }
                        }
                        else {
                            $result = 'error';
                            $message = "처리할 상품 정보가 없거나 API 응답이 올바르지 않습니다.";
                        }

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
        $selectDate = ($this->request->getPost('selectdate') == '') ? date('Y-m-d') : $this->request->getPost('selectdate');
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
                $arr = [];
                $s_date  = fn_PrevDateFormat(2,1,$selectDate);
                $e_date = $selectDate;
                if ($shoptyp == 'type1') {
                    //쿠팡은 전날 00시 부터 금일 00시 까지만 가지고온다.
                    $arr = $this->Coupang_Order_List($shoptyp, $s_date, $e_date, $NextToken);
                } else if (($shoptyp == 'type2') || ($shoptyp == 'type3')) {
                    //옥션 지마켓은 전날 16시 부터 금일 16시 까지만 가지고온다.
                    $s_date = $s_date . ' 16:00';
                    $e_date = $e_date . ' 16:00';
                    $arr = $this->ESM_Order_List($shoptyp, $s_date, $e_date);
                } else if ($shoptyp == 'type4') {
                    $s_date = fn_NowDateFormat(3,$s_date) . '1600';
                    $e_date = fn_NowDateFormat(3,$e_date) . '1600';
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
                    //네이버는 전날 16시 부터 금일 16시 까지만 가지고온다.
                    $s_timestamp = strtotime($selectDate . " 16:00:00 -1 day");
                    $s_date = date("Y-m-d\TH:i:s.000+09:00", $s_timestamp);
                    $e_date = date("Y-m-d\TH:i:s.000+09:00", $s_timestamp + 86400);
                    $arr = $this->Naver_Order_List($shoptyp, $s_date,$e_date);
                } else if ($shoptyp == 'type13') {
                    $s_date = fn_NowDateFormat(3,$s_date) . '160000';
                    $e_date = fn_NowDateFormat(3,$e_date) . '160000';
                    $arr = $this->LotteOn_Order_List($shoptyp, $s_date,$e_date);
                } else if ($shoptyp == 'type14') {
                    $arr = $this->SSG_Order_List($shoptyp,$s_date,$e_date);
                }
                $indate = fn_NowDateFormat(1);
                $data = [
                    'period' => substr($s_date, 0, 10) . '~' . substr($e_date, 0, 10),
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

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    private function SSG_Order_List($shoptyp, $s_date, $e_date)
    {
        try {
            $Cnt = 0;
            $is_miss = 0;
            $result = 'nothing';
            $message = '';

            $startdate = fn_NowDateFormat(3, $s_date);
            $enddate = fn_NowDateFormat(3, $e_date);

            $ssg = new SsgAPI();
            $order = $ssg->getShppDirectionList($startdate, $enddate);

            // 1. API 응답 체크
            if (is_array($order) && isset($order['result']) && $order['result']['resultCode'] == '00') {

                $data = $order['result']['shppDirections'] ?? [];

                if (!empty($data) && is_array($data)) {
                    $groupedOrders = [];
                    $order_m = model('Order_m');

                    // 2. 주문번호별 품목 그룹화 (shppDirection이 배열임을 고려)
                    foreach ($data as $d) {
                        $items = $d['shppDirection'] ?? [];
                        foreach ($items as $item) {
                            $orderNo = $item['ordNo'];
                            if (!isset($groupedOrders[$orderNo])) {
                                $groupedOrders[$orderNo] = [];
                            }
                            $groupedOrders[$orderNo][] = [
                                'prdNo'  => $item['itemId'],
                                'price'  => $item['sellprc'],
                                'pname'  => $item['itemNm'],
                                'cnt'    => $item['ordQty'],
                                'shppNo' => $item['shppNo'],
                                'shppSeq'=> $item['shppSeq'],
                                'raw'    => $item // 원본 데이터 참조용
                            ];
                        }
                    }

                    // 3. 그룹화된 주문 처리
                    foreach ($groupedOrders as $spcode => $products) {
                        // 대표 아이템 정보 (첫 번째 품목 기준)
                        $firstItem = $products[0]['raw'];

                        // 출고지시 상태(11)가 아니면 건너뜀
                        if (($firstItem['shppProgStatDtlCd'] ?? '') != '11') {
                            continue;
                        }

                        // 중복 체크
                        $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                        $cRs = $order_m->Load_Order_InfoByMiss($spcode);

                        if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                            $tcnt = 0;
                            $tprice = 0;
                            $orcode = fnMake_Code(10);
                            $current_order_miss = 0;

                            // 주문자/수령자 정보 등록
                            $order_buyer_info = [
                                'fk_orcode'        => $orcode,
                                'buy_name'         => $firstItem['ordpeNm'],
                                'buy_zipcode'      => '',
                                'buy_address1'     => $firstItem['ordpeRoadAddr'] ?? '',
                                'buy_address2'     => '',
                                'buy_phone'        => $firstItem['ordpeHpno'],
                                'buy_memo'         => '',
                                'receive_name'     => $firstItem['rcptpeNm'],
                                'receive_zipcode'  => $firstItem['shpplocZipcd'],
                                'receive_address1' => $firstItem['shpplocBascAddr'],
                                'receive_address2' => $firstItem['shpplocDtlAddr'],
                                'receive_phone'    => $firstItem['rcptpeHpno'],
                                'receive_memo'     => $firstItem['ordMemoCntt'] ?? ''
                            ];
                            $order_m->Insert_Order_Buyer($order_buyer_info);

                            // 품목별 루프
                            $order_products = [];
                            foreach ($products as $f) {
                                $productid = $f['prdNo'];

                                // 매칭 상품 확인
                                $nRs = $order_m->Load_Order_ProductByMatch($productid);
                                if (fn_ArrayCnt($nRs) <= 0) {
                                    $current_order_miss = 1;
                                    $is_miss = 1; // 전체 리턴값용
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
                                ], JSON_UNESCAPED_UNICODE);

                                $order_products[] = [
                                    'fk_orcode'      => $orcode,
                                    'fk_pdcode'      => $fk_pdcode,
                                    'sgcode'         => $productid,
                                    'sgname'         => $f['pname'],
                                    'gprice'         => $gprice,
                                    'gcnt'           => $gcnt,
                                    'addProductInfo' => $addProductInfo,
                                    'gtprice'        => $gtprice,
                                    'paydate'        => $firstItem['ordCmplDts']
                                ];

                                $tprice += $gtprice;
                                $tcnt += $gcnt;
                            }

                            if (!empty($order_products)) {
                                $order_m->Insert_Order_Product($order_products);
                            }

                            // 메인 주문 정보 등록
                            $t_info = [
                                'orcode'    => $orcode,
                                'spcode'    => $spcode,
                                'shoptyp'   => $shoptyp,
                                'tprice'    => $tprice,
                                'tcnt'      => $tcnt,
                                'input_typ' => 1,
                                'orderdate' => $firstItem['ordRcpDts']
                            ];

                            if ($current_order_miss == 1) {
                                $order_m->Insert_Order_Info_Miss($t_info);
                            } else {
                                $order_m->Insert_Order_Info($t_info);
                            }
                            $Cnt++;
                        }
                    }

                    // 결과 메시지 설정
                    if ($is_miss == 1) {
                        $result = 'miss';
                        $message = '누락된 매칭 상품이 존재하는 주문이 있습니다.';
                    } else if ($Cnt > 0) {
                        $result = 'ok';
                        $message = "총 {$Cnt}건의 주문을 가져왔습니다.";
                    } else {
                        $result = 'nothing';
                        $message = '새로 가져올 주문이 없습니다.';
                    }

                } else {
                    $result = 'nothing';
                    $message = '조회된 주문 데이터가 없습니다.';
                }
            } else {
                $err_msg = $order['result']['resultMessage'] ?? '알 수 없는 오류';
                $result = 'error';
                $message = "SSG API 통신실패 : [{$err_msg}]";
            }
        } catch (\Exception $e) {
            log_message('error', '[SSG API Error] ' . $e->getMessage());
            $result = 'error';
            $message = "시스템 오류 : [{$e->getMessage()}]";
        }

        return [
            'result' => $result,
            'message' => $message
        ];
    }

    private function SSG_Order_List11($shoptyp,$s_date,$e_date){
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
                        $item = $d['shppDirection'];
                        $orderNo = $item['ordNo'];
                        if (!isset($groupedOrders[$orderNo])) {
                            $groupedOrders[$orderNo] = [];
                        }
                        $goods = [
                            'prdNo' => $item['itemId'],
                            'price' => $item['sellprc'],
                            'pname' => $item['itemNm'],
                            'cnt'   => $item['ordQty'],
                            'shppNo'=> $item['shppNo'],
                            'shppSeq'=> $item['shppSeq']
                        ];
                        $groupedOrders[$orderNo][] = $goods;
                    }

                    foreach ($data as $d) {
                        $item = $d['shppDirection'];

                        if (($item['shppProgStatDtlCd'] ?? '') != '11') {
                            continue;
                        }

                        $order_m = model('Order_m');
                        $spcode = $item['ordNo']; // 주문번호
                        $orderdate = $item['ordRcpDts']; // 주문접수일시
                        $PayDate = $item['ordCmplDts'];  // 결제완료일시

                        $iRs = $order_m->Load_Order_InfoBySpcode($spcode);
                        $cRs = $order_m->Load_Order_InfoByMiss($spcode);

                        if ((fn_ArrayCnt($iRs) == 0) && (fn_ArrayCnt($cRs) == 0)) {
                            $tcnt = 0;
                            $tprice = 0;
                            $orcode = fnMake_Code(10);

                            $order_buyer_info = [
                                'fk_orcode'        => $orcode,
                                'buy_name'         => $item['ordpeNm'], // 주문자명
                                'buy_zipcode'      => '',
                                'buy_address1'     => $item['ordpeRoadAddr'] ?? '', // 주문자 주소
                                'buy_address2'     => '',
                                'buy_phone'        => $item['ordpeHpno'], // 주문자 휴대전화
                                'buy_memo'         => '',
                                'receive_name'     => $item['rcptpeNm'], // 수령자명
                                'receive_zipcode'  => $item['shpplocZipcd'], // 수령자 우편번호
                                'receive_address1' => $item['shpplocBascAddr'], // 수령자 기본주소
                                'receive_address2' => $item['shpplocDtlAddr'],  // 수령자 상세주소
                                'receive_phone'    => $item['rcptpeHpno'], // 수령자 휴대전화
                                'receive_memo'     => $item['ordMemoCntt'] ?? '' // 배송메모
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
                                    ], JSON_THROW_ON_ERROR);

                                    $t_arr = [
                                        'fk_orcode'      => $orcode,
                                        'fk_pdcode'      => $fk_pdcode,
                                        'sgcode'         => $productid,
                                        'sgname'         => $f['pname'],
                                        'gprice'         => $gprice,
                                        'gcnt'           => $gcnt,
                                        'addProductInfo' => $addProductInfo,
                                        'gtprice'        => $gtprice,
                                        'paydate'        => $PayDate
                                    ];

                                    $tprice += $gtprice;
                                    $tcnt += $gcnt;

                                    $order_products[] = $t_arr;
                                }
                            }

                            if (fn_ArrayCnt($order_products) > 0) {
                                $order_m->Insert_Order_Product($order_products);
                            }

                            $t_info = [
                                'orcode'    => $orcode,
                                'spcode'    => $spcode,
                                'shoptyp'   => $shoptyp,
                                'tprice'    => $tprice,
                                'tcnt'      => $tcnt,
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
                    'pOrderId' => $item['productOrderId'],
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
                        'receive_address2' => $d['address2'],
                        'receive_phone' => $d['buyer_phone'],
                        'receive_memo' => $d['shippingMemo']
                    ];
                    $order_m->Insert_Order_Buyer($order_buyer_info);

                    $order_products = [];
                    if (isset($groupedOrders[$spcode]) && is_array($groupedOrders[$spcode])) {
                        foreach ($groupedOrders[$spcode] as $f) {
                            $productid = $f['prdNo'];
                            $productOrderId = $f['pOrderId'];
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
                                'addProductInfo' => $productOrderId,
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

    //쿠팡은 하루치만 로딩됨
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
        $order = $esm->getOrderList($s_date, $e_date);
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

        $eleven = new ElevenStreetApi();
        $data = $eleven->getNewOrders($s_date, $e_date);
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

        $lotte = new LotteOnApi();
        $data = $lotte->getOrderList($s_date, $e_date);
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
                        'cnt' => $item['odQty'],
                        'odSeq' => $item['odSeq'],
                        'procSeq' => $item['procSeq']
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

                                $addProductInfo = json_encode([
                                    'odSeq' => $f['odSeq'],
                                    'procSeq' => $f['procSeq'],
                                    'sitmNo' => $f['sitmNo']
                                ], JSON_THROW_ON_ERROR);


                                $t_arr = [
                                    'fk_orcode' => $orcode,
                                    'fk_pdcode' => $fk_pdcode,
                                    'sgcode' => $productid,
                                    'sgname' => $f['pname'],
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