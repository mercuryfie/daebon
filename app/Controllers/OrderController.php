<?php

namespace App\Controllers;

use App\Libraries\Form;
use App\Libraries\LotteDeliveryApi;
use CodeIgniter\API\ResponseTrait;

class OrderController extends BaseController
{
    use ResponseTrait;
    protected $location = 1;

    public function __construct()
    {
        $Auth = [AUTH_MASTER];
        $this->Check_Auth($Auth);
    }


    public function main()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => H_TITLE,
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

            return view('web/common/main_View',$main_data);
        }
    }

    public function dashBoard()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => H_TITLE,
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

            return view('web/common/dashBoard_View',$main_data);
        }
    }

    public function linkMalls()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '쇼핑몰연동',
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

            return view('web/common/linkMalls_View',$main_data);
        }
    }

    public function linkMallsLogs()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
            if($code==''){
                fn_Alert('잘못된 접근입니다.');
            }else {
                $metaarr = [
                    'h_title' => '쇼핑몰연동-로그보기',
                    'h_type' => 1
                ];

                $main_data = [
                    'code' => $code
                ];

                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $main_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/common/linkMallsLogs_View', $main_data);
            }
        }
    }


    public function orderList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '주문목록',
                'h_type' => 1
            ];

            $main_data = [
                'optcode' => opt_Excode('')
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/orderList_View',$main_data);
        }
    }


    public function orderRegister()
    {
        $sessinarr = $this->GetSessionData();
        $pdcode = ($this->request->getPost('code')=='') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '주문목록',
                'h_type' => 1
            ];

            $main_data = [
                'excode' => opt_Excode('')
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/orderRegister_View',$main_data);
        }
    }

    public function deliveryList()
    {

        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '배송목록',
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

            return view('web/common/deliList_View',$main_data);
        }
    }


    public function packingList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '포장발송목록',
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

            return view('web/common/packingList_View', $main_data);
        }
    }


    public function packinglistStaff()
    {

        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '포장발송목록',
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

            return view('web/common/packinglistStaff_View',$main_data);
        }
    }

    public function packingStatus()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '포장발송현황',
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

            return view('web/common/packingStatus_View', $main_data);
        }
    }


    public function addDeliForm()
    {
        $sessinarr = $this->GetSessionData();
        $orcode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($orcode==''){
            fn_AlertClose('잘못된 접근입니다.');
        }else {
            $metaarr = [
                'h_title' => H_TITLE,
                'h_type' => 1
            ];

            $order_m = model('Order_m');
            $info = $order_m->Load_Order_Info($orcode);
            $product = $order_m->Load_Order_Product($orcode);

            $main_data = [
                'orcode' => $orcode,
                'info' => $info[0],
                'product' => $product
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/include/pop_AddDeliForm_View',$main_data);
        }
    }


    public function orderRoastForm()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => H_TITLE,
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

            return view('web/include/pop_OrderRoastForm_View',$main_data);
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
