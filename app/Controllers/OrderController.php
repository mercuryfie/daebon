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

            $limit = 10;
            $material_html = '';
            $material_m =model('Material_m');
            $mCnt = $material_m->Cnt_Material_All(1);
            $mMax = ($mCnt > 0) ? ceil($mCnt / $limit) : 1;
            for ($i = 1; $i <= $mMax; $i++) {
                $material_html .= "<div class='pages' data-page='{$i}'></div>";
            }

            $product_html = '';
            $product_m = model('Product_m');
            $pCnt = $product_m->Cnt_Product_All();
            $pMax = ($pCnt > 0) ? ceil($pCnt / $limit) : 1;
            for ($i = 1; $i <= $pMax; $i++) {
                $product_html .= "<div class='pages' data-page='{$i}'></div>";
            }

            $main_data = [
                'material_html' => $material_html,
                'product_html' => $product_html
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
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

    public function missingList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $shoptype  = ($this->request->getGet('sp') == '') ? '' : $this->request->getGet('sp');
            $metaarr = [
                'h_title' => '누락목록',
                'h_type' => 1
            ];

            $main_data = ['styp' => $shoptype];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/missingList_View',$main_data);
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
                'optcode' => opt_Excode('','EXCEL')
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

    public function orderEditor()
    {
        $sessinarr = $this->GetSessionData();
        $orcode  = ($this->request->getGet('od') == '') ? '' : $this->request->getGet('od');
//        var_dump($orcode);
//        exit();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '주문목록',
                'h_type' => 1
            ];

            $order_m = model('Order_m');
            $Rs = $order_m->Load_Order_Info($orcode);
            $p_arr = $order_m->Load_Order_ByOrcode($orcode);

            $main_data = [
                'info' => $Rs,
                'p_arr' => $p_arr,
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

            return view('web/common/orderEditor_View',$main_data);
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

            return view('web/common/deliveryList_View',$main_data);
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
                $delivery_m = model('Delivery_m');
                $fields =['a.fk_opcode as opcode','b.deli_step','b.deli_code','b.deli_prn_date','b.deli_end_date','c.addInfo','c.tcnt','c.shoptyp','c.shopmethod','c.spcode','d.addProductInfo','d.sgcode'];
                $dRs = $delivery_m->Load_DeliveryPackageByOrCode($orcode,$fields);
                if(fn_ArrayCnt($dRs)<=0){
                    fn_AlertClose('잘못된 송장정보 입니다.');
                }else{
                    $result = fn_Put_Delivery_Info($dRs,$orcode);
                    $metaarr = [
                        'h_title' => H_TITLE,
                        'h_type' => 1
                    ];

                    $product = [];
                    $totalCnt = 0;
                    $fields=['fk_pdcode','sgcode','sgname','gprice','gcnt','shop_name'];
                    $sRs = $delivery_m->Load_Delivery_Product_Info($orcode,$fields);
                    if(fn_ArrayCnt($sRs)>0){
                        $i = 1;
                        foreach ($sRs as $f){
                            $t_arr = [
                                'num' => $i,
                                'sgname' => $f['sgname'],
                                'gcnt' => $f['gcnt'],
                                'spname' => $f['shop_name']
                            ];
                            $totalCnt = $totalCnt + $f['gcnt'];
                            $product[] = $t_arr;
                            $i++;
                        }
                    }


                    $main_data = [
                        'info' => $data['info'],
                        'product' =>$product,
                        'totalCnt' => $totalCnt
                    ];

                    $form = new Form;
                    $main_data = [
                        'meta' => $form->fnMake_Meta($metaarr),
                        'header' => $form->fnMake_Header($sessinarr),
                        'left' => $form->fnMake_Left(),
                        'body' => $main_data,
                        'footer' => $form->fnMake_Fooeter($sessinarr)
                    ];

                    return view('web/include/pop_WaybillForm_View', $main_data);
                }
            }
        }
    }





}
