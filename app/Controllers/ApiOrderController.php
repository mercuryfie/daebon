<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

use voku\helper\HtmlDomParser;

class ApiOrderController extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $Auth = [AUTH_MASTER, AUTH_PACKING];
        $this->Check_Auth($Auth);
    }

    public function Load_Order_Data(){
        $sessinarr = $this->GetSessionData();
        $search = $this->request->getPost('param') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else {
            $order_m = model('Order_m');
            $cRs = $order_m->Load_Order_All($search);
            if(fn_ArrayCnt($cRs)===0){
                $result = 'ok';
                $data = [];
                $message = '';
            }else{
                $info_arr = [];
                foreach ($cRs as $d){
                    $t_arr = [
                        'orcode' => $d['orcode'],
                        'spcode' => $d['spcode'],
                        'shoptyp' => $d['shoptyp'],
                        'tprice' => $d['tprice'],
                        'tcnt' => $d['tcnt'],
                        'orstep' => $d['orstep'],
                        'deltype' => $d['deltype'],
                        'buy_name' => $d['buy_name'],
                        'buy_zipcode' => $d['buy_zipcode'],
                        'buy_address1' => $d['buy_address1'],
                        'buy_address2' => $d['buy_address2'],
                        'buy_phone' => $d['buy_phone'],
                        'buy_memo' => $d['buy_memo'],
                        'indate' => fn_Short_Date($d['indate'])
                    ];

                    array_push($info_arr,$t_arr);
                }

                $i_arr = [
                    'list' => $info_arr,
                    'total' => fn_ArrayCnt($info_arr)
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }
        }
        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Insert_Order(){
        $sessinarr = $this->GetSessionData();
        $param = $this->request->getPost('param') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($param)===0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $order_m = model('Order_m');
            if($param['shoptyp']==='type0'){
                $orcode = $param['spcode'];
                $spcode = $param['spcode'];
            }else{
                $orcode = fnMake_Code(10);
                $spcode = $param['spcode'];
            }
            $iRs = $order_m->Load_Order_Info($orcode);
            if(fn_ArrayCnt($iRs)>0){
                $result = 'Error003';
                $data = [];
                $message = '이미 등록된 주문정보 입니다.';
            }else {
                $buyer_info = [
                    'fk_orcode' => $orcode,
                    'buy_name' => $param['bname'],
                    'buy_zipcode' => $param['zipcode'],
                    'buy_address1' => $param['address1'],
                    'buy_address2' => $param['address2'],
                    'buy_phone' => $param['bphone'],
                ];

                $totalPrice = 0;
                $totalCnt = 0;

                if (fn_ArrayCnt($param['product']) > 0) {
                    $product_m = model('Product_m');
                    $product_arr = [];
                    foreach ($param['product'] as $d) {

                        $cRs = $product_m->Load_Product_Info($d['pdcode']);
                        if (fn_ArrayCnt($cRs) > 0) {
                            $totalPrice += $cRs[0]['pdprice'] * $d['pdcnt'];
                            $totalCnt += $d['pdcnt'];

                            $t_arr = [
                                'fk_orcode' => $orcode,
                                'fk_pdcode' => $d['pdcode'],
                                'gprice' => $cRs[0]['pdprice'],
                                'gcnt' => $d['pdcnt'],
                                'gtprice' => ($cRs[0]['pdprice'] * $d['pdcnt'])
                            ];

                            array_push($product_arr, $t_arr);
                        }
                    }
                }

                $info_arr = [
                    'orcode' => $orcode,
                    'spcode' => $spcode,
                    'shoptyp' => $param['shoptyp'],
                    'tprice' => $totalPrice,
                    'tcnt' => $totalCnt,
                    'orstep' => 2
                ];
                $Cnt1 = $order_m->Insert_Order_Info($info_arr);
                $Cnt2 = $order_m->Insert_Order_Buyer($buyer_info);
                $Cnt3 = $order_m->Insert_Order_Product($product_arr);


                $i_arr = ['code' => $orcode];


                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


}