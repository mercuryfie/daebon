<?php

namespace App\Controllers;

use App\Libraries\Form;
use App\Libraries\LotteDeliveryApi;
use CodeIgniter\API\ResponseTrait;

class PackingController extends BaseController
{

    use ResponseTrait;

    public function __construct()
    {
        $Auth = [AUTH_PACKING,AUTH_MASTER];
        $this->Check_Auth($Auth);
    }

    public function main()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '포장목록',
                'h_type' => 1
            ];

            $main_data = [];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'main' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/packing/packingListStaff_View', $main_data);
        }
    }


    public function productsList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '포장목록',
                'h_type' => 1
            ];

            $main_data = [];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'main' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/packing/todayProductsList_View', $main_data);
        }
    }


    public function packingProcess()
    {
        $sessinarr = $this->GetSessionData();
        $opcode  = ($this->request->getGet('op') == '') ? '' : $this->request->getGet('op');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($opcode==''){
            fn_Alert('잘못된 접근입니다.');
        }else {
            $metaarr = [
                'h_title' => '포장',
                'h_type' => 1
            ];


            $order_m = model('Order_m');
            $info = $order_m->Load_Order_Delivery_Info($opcode);
            $status = (fn_ArrayCnt($info)>0) ? $info[0]['p_status'] : '0';
            if($status==0){
                $param = [
                    'worker' => $sessinarr['user']['uid'],
                    'startdate' => date('Y-m-d H:i'),
                    'p_status' => 1
                ];

                $Cnt = $order_m->Update_Order_Delivery_Info($opcode,$param);
            }
            $package = $order_m->Load_Order_Package_Info_opcode($opcode);
            if(fn_ArrayCnt($package)==0) {
                fn_Alert('존재하지 않는 포장지시 입니다 ');
            }else {
                $orcode_arr = [];
                $product_arr = [];
                $f_orcode = '';
                $tCnt = 0;
                foreach ($package as $d) {
                    $orcode = $d['fk_orcode'];
                    if($f_orcode==''){
                        $f_orcode = $orcode;
                    }
                    $orcode_arr[] = $orcode;
                    $pRs = $order_m->Load_Order_Product($orcode);
                    if (fn_ArrayCnt($pRs) > 0) {
                        foreach ($pRs as $product) {  // 내부 루프
                            $product_arr[] = $product; // 직접 push
                            $tCnt = $tCnt + $product['gcnt'];
                        }
                    }
                }

                if(fn_ArrayCnt($orcode_arr) > 1){
                    $order_str = implode(",\n", $orcode_arr) . '(묶음배송)';
                }else{
                    $order_str = implode(',', $orcode_arr);
                }
                $order = $order_m->Load_Order_Info($f_orcode);

                $deli_m = model('Delivery_m');
                $image =[];
                $iRs = $deli_m->get_Delivery_Image($opcode);
                if(fn_ArrayCnt($iRs)>0){
                    foreach ($iRs as $d){
                        $url = '/uploads/packing/' .  date('Ymd', strtotime($d['indate'])) .'/' . $d['fname'];
                        $image[] = $url;
                    }
                }

                $ret_data = [
                    'opcode' => $opcode,
                    'info' => $info[0],
                    'order_str' => $order_str,
                    'product' => $product_arr,
                    'image' => $image,
                    'order' => $order[0],
                    'tCnt' => $tCnt
                ];

                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $ret_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/packing/packingStatusStaff_View', $main_data);
            }
        }
    }

    public function waybill()
    {
        $sessinarr = $this->GetSessionData();
        $orcode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        $chkPrint = ($this->request->getGet('cp') == '') ? '' : $this->request->getGet('cp');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($orcode==''){
            fn_AlertClose('잘못된 접근입니다.');
        }else {
            if($chkPrint=='New'){
                $retyp = 1;
            }else{
                $order_m = model('Order_m');
                $retval = get_Delivery_ConfirmByOrcode($order_m,$orcode);
                if(fn_ArrayCnt($retval)<=0){

                }else {
                    $delicode = $retval['deli_code'];
                }
                $retyp = ($delicode=='') ? 1 : 2;
            }

            $lotte = new LotteDeliveryApi();
            $data = $lotte->Get_Delivery_Info($orcode, $retyp);
            if ($data['result'] != 'ok') {
                fn_AlertClose('Error : ' . $data['message']);
            } else {
                $metaarr = [
                    'h_title' => H_TITLE,
                    'h_type' => 1
                ];

                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $data['info'],
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/include/pop_WaybillForm_View', $main_data);
            }
        }
    }


}