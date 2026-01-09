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

    public function Load_Packing_Data()
    {
        $sessinarr = $this->GetSessionData();
        $search = $this->request->getPost('search') ?? [];
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
            $Rs = $order_m->Load_Packing_All($search);
            if(fn_ArrayCnt($Rs)<=0){
                $result = 'ok';
                $data = [];
                $message = '';
            }else{
                $p_arr = [];
                foreach ($Rs as $a) {
                    $opcode = $a['opcode'];
                    $info = $order_m->Load_Order_Package_Info_opcode($opcode);
                    if (fn_ArrayCnt($info) > 0) {
                        $t_Cnt = 0;
                        $short_name = '';
                        $short_cnt = 0;
                        $receive_name = '';
                        foreach ($info as $d) {
                            $orcode = $d['fk_orcode'];
                            $pRs = $order_m->Load_Order_Product($orcode);
                            if(fn_ArrayCnt($pRs) > 0){
                                foreach ($pRs as $f){
                                    if ($short_name == '') {
                                        $short_name = $f['pdname'];
                                    }
                                    $short_cnt++;
                                    $t_Cnt = $t_Cnt + $f['gcnt'];
                                }
                            }
                            if($receive_name=='') {
                                $bRs = $order_m->Load_Order_Info($orcode);
                                $receive_name = (fn_ArrayCnt($bRs) > 0) ? $bRs[0]['receive_name'] : '';
                            }
                        }
                    }
                    if (($short_cnt-1) > 0) {
                        $short_name = $short_name . "외 (" . ($short_cnt - 1) . ")건";
                    }
                    if($a['p_status']==0){
                        $worker = '';
                        $p_str = '포장전';
                    }else{
                        $member_m = model('Member_m');
                        $mRs = $member_m->Load_UserInfo_Uid($a['worker']);
                        $worker = (fn_ArrayCnt($mRs)>0) ? $mRs[0]['name'] : '';
                        if($a['p_status']==1){
                            $p_str = '포장중';
                        }else if($a['p_status']==2){
                            $p_str = '송장출력';
                        }else if($a['p_status']==3){
                            $p_str = '포장완료';
                        }
                    }

                    $t_arr = [
                        'opcode' => $opcode,
                        'sname' => $short_name,
                        'rname' => $receive_name,
                        'tcnt' => $t_Cnt,
                        'worker' => $worker,
                        'status' => $p_str,
                        'start' => ($a['startdate']==null) ? '' : $a['startdate'],
                        'end' => ($a['enddate']==null) ? '' : $a['enddate']
                    ];


                    $p_arr[] = $t_arr;
                }

                $i_arr = ['list' => $p_arr];
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


    public function Put_Package_Info()
    {
        $sessinarr = $this->GetSessionData();
        $codes = $this->request->getPost('codes') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($codes)===0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else {
            $bool = false;
            $order_m = model('Order_m');
            $Rs = $order_m->Load_Order_In_Info($codes);
            if (fn_ArrayCnt($Rs) > 0) {
                foreach ($Rs as $d) {
                    if ($d['orstep'] == 1) {
                        $bool = true;
                        break;
                    }
                }
            }
            if ($bool) {
                $result = 'Error003';
                $data = [];
                $message = '이미 처리된 주문이 있습니다.';
            } else {
                $newcode = fnMake_Code(14);
                $t_arr = [
                    'opcode' => $newcode
                ];
                $Cnt = $order_m->Insert_Order_delivery_Info2($t_arr);

                $package_info = [];
                foreach ($codes as $code) {
                    $d_arr = [
                        'fk_opcode' => $newcode,
                        'fk_orcode' => $code
                    ];

                    $package_info[] = $d_arr;
                }

                if (fn_ArrayCnt($package_info) > 0) {
                    $Cnt = $order_m->Insert_Order_Package_Info($package_info);
                }

                $param = ['orstep' => 1];
                $Cnt = $order_m->Update_Order_Info($codes, $param);

                $retval = [];
                foreach ($codes as $code) {
                    $p_arr = get_Order_Delivery_Info($order_m, $code);
                    $r_arr = [
                        'orcode' => $code,
                        'indate' => $p_arr['indate']
                    ];
                    $retval[] = $r_arr;
                }

                $i_arr = ['list' => $retval];
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

    public function Put_Delivery_Info()
    {
        $sessinarr = $this->GetSessionData();
        $codes = $this->request->getPost('codes') ?? [];
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($codes)===0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $bool = false;
            $order_m = model('Order_m');
            $Rs = $order_m->Load_Order_In_Info($codes);
            if(fn_ArrayCnt($Rs)>0){
                foreach ($Rs as $d){
                    if($d['orstep']==1){
                        $bool = true;
                        break;
                    }
                }
            }
            if($bool){
                $result = 'Error003';
                $data = [];
                $message = '이미 처리된 주문이 있습니다.';
            }else{
                $deli_info=[];
                $package_info = [];
                foreach ($codes as $code){
                    $newcode = fnMake_Code(14);
                    $t_arr = [
                        'opcode' =>$newcode
                    ];

                    $d_arr = [
                        'fk_opcode' => $newcode,
                        'fk_orcode' => $code
                    ];

                    $deli_info[] = $t_arr;
                    $package_info[] = $d_arr;
                }

                if(fn_ArrayCnt($deli_info)>0){
                    $Cnt = $order_m->Insert_Order_delivery_Info($deli_info);
                }

                if(fn_ArrayCnt($package_info) > 0){
                    $Cnt = $order_m->Insert_Order_Package_Info($package_info);
                }
                $param = ['orstep' =>1];
                $Cnt = $order_m->Update_Order_Info($codes,$param);

                $retval = [];
                foreach ($codes as $code){
                    $p_arr = get_Order_Delivery_Info($order_m,$code);
                    $r_arr = [
                        'orcode' => $code,
                        'indate' => $p_arr['indate']
                    ];
                    $retval[] = $r_arr;
                }

                $i_arr = ['list' => $retval];
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

    public function Load_Order_Info(){
        $sessinarr = $this->GetSessionData();
        $orcode  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($orcode==''){
            $result = 'Error003';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else {
            $order_m = model('Order_m');
            $cRs = $order_m->Load_Order_Info($orcode);
            if(fn_ArrayCnt($cRs)===0){
                $result = 'ok';
                $data = [];
                $message = '';
            }else{
                $d = $cRs[0];
                $a_arr = get_Order_Product_short_info($order_m,$orcode);
                $d_arr = get_Order_Delivery_Info($order_m,$d['orcode']);
                $info_arr = [
                    'seq' => $d['seq'],
                    'orcode' => $d['orcode'],
                    'spcode' => $d['spcode'],
                    'shoptyp' => $d['shoptyp'],
                    'shopstr' => getExCodeName($d['shoptyp']),
                    'tprice' => $d['tprice'],
                    'tcnt' => $d['tcnt'],
                    'sell_id' => $d['sell_id'],
                    'buy_id' => $d['buy_id'],
                    'orstep' => $d['orstep'],
                    'p_name' =>$a_arr['name'],
                    'pd_code' =>$a_arr['pdcode'],
                    'sg_code' =>$a_arr['sgcode'],
                    'input_str' => get_Order_Input_Type($d['input_typ']),
                    'deli_info' => $d_arr,
                    'buy_name' => $d['buy_name'],
                    'buy_zipcode' => $d['buy_zipcode'],
                    'buy_address1' => $d['buy_address1'],
                    'buy_address2' => $d['buy_address2'],
                    'buy_phone' => $d['buy_phone'],
                    'buy_memo' => $d['buy_memo'],
                    'receive_name' => $d['receive_name'],
                    'receive_zipcode' => $d['receive_zipcode'],
                    'receive_address1' => $d['receive_address1'],
                    'receive_address2' => $d['receive_address2'],
                    'receive_phone' => $d['receive_phone'],
                    'receive_memo' => $d['receive_memo'],
                    'orderdate' => $d['indate'],
                    'indate' => fn_Short_Date($d['indate'])
                ];

                $i_arr = [
                    'info' => $info_arr
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

                    $a_arr = get_Order_Product_short_info($order_m,$d['orcode']);
                    $d_arr = get_Order_Delivery_Info($order_m,$d['orcode']);
                    $t_arr = [
                        'seq' => $d['seq'],
                        'orcode' => $d['orcode'],
                        'spcode' => $d['spcode'],
                        'shoptyp' => $d['shoptyp'],
                        'shopstr' => getExCodeName($d['shoptyp']),
                        'tprice' => $d['tprice'],
                        'tcnt' => $d['tcnt'],
                        'sell_id' => $d['sell_id'],
                        'buy_id' => $d['buy_id'],
                        'orstep' => $d['orstep'],
                        'p_name' =>$a_arr['name'],
                        'pd_code' =>$a_arr['pdcode'],
                        'sg_code' =>$a_arr['sgcode'],
                        'input_str' => get_Order_Input_Type($d['input_typ']),
                        'deli_info' => $d_arr,
                        'buy_name' => $d['buy_name'],
                        'buy_zipcode' => $d['buy_zipcode'],
                        'buy_address1' => $d['buy_address1'],
                        'buy_address2' => $d['buy_address2'],
                        'buy_phone' => $d['buy_phone'],
                        'buy_memo' => $d['buy_memo'],
                        'receive_name' => $d['receive_name'],
                        'receive_zipcode' => $d['receive_zipcode'],
                        'receive_address1' => $d['receive_address1'],
                        'receive_address2' => $d['receive_address2'],
                        'receive_phone' => $d['receive_phone'],
                        'receive_memo' => $d['receive_memo'],
                        'orderdate' => $d['indate'],
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
                    'receive_name' => $param['r_bname'],
                    'receive_zipcode' => $param['r_zipcode'],
                    'receive_address1' => $param['r_address1'],
                    'receive_address2' => $param['r_address2'],
                    'receive_phone' => $param['r_bphone']
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
                                'sgcode' => '',
                                'gprice' => $cRs[0]['pdprice'],
                                'gcnt' => $d['pdcnt'],
                                'gtprice' => ($cRs[0]['pdprice'] * $d['pdcnt'])
                            ];

                            array_push($product_arr, $t_arr);
                        }
                    }
                }

                $orderdate = ($param['orderdate']=='') ? date('Y-m-d H:i') : $param['orderdate'];

                $info_arr = [
                    'orcode' => $orcode,
                    'spcode' => $spcode,
                    'sell_id' => $param['sell_id'],
                    'buy_id' => $param['buy_id'],
                    'shoptyp' => $param['shoptyp'],
                    'tprice' => $totalPrice,
                    'tcnt' => $totalCnt,
                    'orstep' => 0,
                    'input_typ' => 0,
                    'orderdate' =>$orderdate
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