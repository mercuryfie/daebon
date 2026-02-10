<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class GoodsController extends BaseController
{
    use ResponseTrait;
    protected $location = 2;

    public function __construct()
    {
        $Auth = [AUTH_MASTER];
        $this->Check_Auth($Auth);
    }

    public function instructionForm()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($code==''){
            fn_Alert('잘못된 접근입니다.');
        }else {
            $metaarr = [
                'h_title' => H_TITLE,
                'h_type' => 1
            ];

            $produce_m = model('Produce_m');
            $goods_m = model('Goods_m');
            $info_arr = [];

            $mRs = $goods_m->Load_Goods_Code($code);
            if (fn_ArrayCnt($mRs) <= 0) {
                fn_Alert('BOM을 먼저 등록하십시오.');
            }else{
                $d = $mRs[0];
                $info_arr = [
                    'gcode' => '',
                    'gname' => $d['gsname'],
                    'writer' => '관리자',
                    'category' => $d['category'],
                    'catestr' => fnGetProductNameByCode($d['category']),
                    'tquantity' => 0,
                    'inventory' => $d['inventory'],
                    'step_cnt' => $d['Cnt'],
                    'quantity' => $d['quantity'],
                    'step_now' => '대기',
                    'indate' => $d['indate'],
                ];

                $mtRs = $goods_m->Load_Goods_Material($code);
                $material_param = [];
                if (fn_ArrayCnt($mtRs) > 0) {
                    foreach ($mtRs as $d) {
                        $t_arr = [
                            'mcode' => $d['mtcode'],
                            'capacity' => $d['capacity'],
                            'mtname' => $d['mtname'],
                            'maker' => $d['fk_mkname'],
                            'supply' => $d['fk_suname']
                        ];

                        array_push($material_param, $t_arr);
                    }
                }

                $pRs = $goods_m->Load_Goods_Process($code);
                $step_info = [];
                if (fn_ArrayCnt($pRs) > 0) {
                    $fields = ['a.*', 'b.mname'];
                    foreach ($pRs as $a) {
                        $cRs = $goods_m->Load_Goods_Step_Material($a['fk_gcode'], $a['prcode']);
                        $step_material = '';
                        if (fn_ArrayCnt($cRs) > 0) {
                            foreach ($cRs as $f) {
                                if ($step_material == '') {
                                    $step_material = $f['mtname'] . ':' . $f['capacity'] . '개<br>';
                                } else {
                                    $step_material .= $f['mtname'] . ':' . $f['capacity'] . '개<br>';
                                }
                            }
                        }

                        $t_arr = fnGetProcessNameByCode($a['step_typ']);

                        $a_arr = [
                            'step_name' => $a['step_name'],
                            'step_num' => $a['stepNum'],
                            'input_material' => $a['input_material'],
                            'output_material' => $a['output_material'],
                            'p_method' => $a['p_method'],
                            'material' => $step_material
                        ];

                        array_push($step_info, $a_arr);
                    }
                }

                $main_data = [
                    'info_arr' => $info_arr,
                    'material_arr' => $material_param,
                    'step_arr' => $step_info
                ];


                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $main_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/include/pop_InstructionForm_View', $main_data);
            }
        }
    }

    public function materialList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else{

            $metaarr = [
                'h_title' => '원자재목록',
                'h_type' => 1
            ];

            $main_data = [
                'material' => fnMake_Material_Type(),
                'maker' => fnMake_Maker_option(),
                'supply' => fnMake_Supply_option(),
                'unit' => fnMake_Material_Unit()
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/materialList_View',$main_data);
        }
    }

    public function pop_AddMatirial()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '원자재등록',
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

            return view('web/include/pop_AddMatirial_View',$main_data);
        }
    }

    public function productsList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '제품목록',
                'h_type' => 1
            ];

            $main_data = [
                'category' => fnMake_Products_Type('')
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/productsList_View',$main_data);
        }
    }

    public function productsLog()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $gscode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');

            $metaarr = [
                'h_title' => '제품목록',
                'h_type' => 1
            ];

            $main_data = [
                'gscode' => $gscode
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/productsLog_View',$main_data);
        }
    }

    public function goodsList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '상품목록',
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

            return view('web/common/goodsList_View',$main_data);
        }
    }

    public function goodsReg()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '상품등록',
                'h_type' => 1
            ];

            $main_data = [
                'category' => fnMake_Products_Type(''),
                'material' => fnMake_Material_option('',2),
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

            return view('web/common/goodsRegister_View', $main_data);
        }
    }

    public function goodsEdit()
    {
        $sessinarr = $this->GetSessionData();
        $pdcode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($pdcode==''){
            fn_Alert('잘못된 접근입니다.');
        }else {
            $metaarr = [
                'h_title' => '상품수정',
                'h_type' => 1
            ];

            $main_data = [
                'category' => fnMake_Products_Type(''),
                'material' => fnMake_Material_option('',2),
                'excode' => opt_Excode(''),
                'pdcode' => $pdcode
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/goodsEdit_View', $main_data);
        }
    }


    public function productsMasterList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '제품BOM목록',
                'h_type' => 1
            ];

            $main_data = [
                'category' => fnMake_Products_Type('')
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/productsMasterList_View',$main_data);
        }
    }

    public function productsMasterReg()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');

        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '제품BOM등록',
                'h_type' => 1
            ];

            $produce_m = model('Produce_m');
            $goods_m=model('Goods_m');
            $info_arr = [];

            $mRs = $goods_m->Load_Goods_Each($code);
            if (fn_ArrayCnt($mRs) > 0) {
//                echo "f data: "; print_r($pRs);
                $d = $mRs[0];
                $info_arr = [
//                    echo "f data: "; print_r($pRs);
                    'seq' => $d['seq'],
                    'gscode' => $d['gscode'],
                    'gname' => $d['gsname'],
                    'category' => $d['category'],
                    'cat_str' => fnGetProductNameByCode($d['category']),
                    'unit_weight' => $d['unit_weight'],
                    'unit_str' => number_format($d['unit_weight']) . 'g',
                    'inventory' => $d['inventory'],
                    'inv_str' => number_format($d['inventory']) . '개',
                    'is_del' => $d['is_del'],
                    'moddate' => $d['moddate'],
                    'indate' => $d['indate'],
                ];
            }

            $mtRs = $goods_m->Load_Goods_Material($code);
            $material_param = [];
            if(fn_ArrayCnt($mtRs)>0){
                foreach ($mtRs as $d){
                    $t_arr = [
                        'mcode' => $d['mtcode'],
                        'capacity' => $d['capacity'],
                        'mname' => $d['mtname'],
                        'maker' => $d['fk_mkname'],
                        'supply' => $d['fk_suname']
                    ];

                    array_push($material_param,$t_arr);
                }
            }

            $main_data = [
                'info_arr' => $info_arr,
                'material_arr' => $material_param,
                'category' => fnMake_Process_Type(''),
                'material' => fnMake_Material_option('',2)
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/productsMasterReg_View',$main_data);
        }
    }



    public function otherInfo()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
//            $metaarr = [
//                'h_title' => '기타정보관리',
//                'h_type' => 1
//            ];

            $good_m = model('Goods_m');
//            $m_arr = $good_m->Load_Maker_All();



            $tp = $this->request->getGet('tp');

            if($tp == 1) {
                $h_title = '제조사관리';
                $view_name = 'web/common/otherInfo_Maker_View';
            } else if($tp == 2) {
                $h_title = '공급처관리';
                $view_name = 'web/common/otherInfo_Supplier_View';
            } else {
                $h_title = '제조사관리';
                $view_name = 'web/common/otherInfo_Maker_View';
            }

            $metaarr = [
                'h_title' => $h_title,
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

            return view($view_name, $main_data);
        }
    }


    public function productsEditor()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($code=='') {
            fn_Alert('잘못된 접근입니다.[Error101]');
        }else{
            $metaarr = [
                'h_title' => '제품 BOM 수정',
                'h_type' => 1
            ];

            $good_m = model('Goods_m');
            $gRs = $good_m->Load_Goods_Code($code);
            if(fn_ArrayCnt($gRs)<=0){
                fn_Alert('잘못된 접근입니다.[Error102]');
            }else{
                $goods_arr = [
                    'code' => $gRs[0]['gcode'],
                    'name' => $gRs[0]['gsname'],
                    'category' => $gRs[0]['category'],
                    'c_str' => fnGetProductNameByCode($gRs[0]['category']),
                    'cname' => fnGetProductNameByCode($gRs[0]['category']),
                    'quantity' => $gRs[0]['quantity'],
                    'inventory' => number_format($gRs[0]['inventory']),
                    'unitwight' => $gRs[0]['unit_weight']
                ];

                $pRs = $good_m->Load_Goods_Process($code);
                if(fn_ArrayCnt($gRs)<=0) {
                    fn_Alert('잘못된 접근입니다.[Error103]');
                }else{
                    $mRs = $good_m->Load_Goods_Material($code);
                    if(fn_ArrayCnt($mRs)<=0) {
                        fn_Alert('잘못된 접근입니다.[Error104]');
                    }else{
                        $material_arr = [];
                        foreach ($mRs as $c){
                            $c_arr = [
                                'mtcode' => $c['fk_mtcode'],
                                'mtname' => $c['mtname'],
                                'cnt' => $c['capacity']
                            ];

                            array_push($material_arr,$c_arr);
                        }

                        $process_arr = [];
                        foreach ($pRs as $d){
                            $material_step_arr = [];
                            $cRs = $good_m->Load_Goods_Step_Material($code,$d['prcode']);
                            if(fn_ArrayCnt($cRs)>0){
                                foreach ($cRs as $a){
                                    $m_arr = [
                                        'code' => $a['fk_mtcode'],
                                        'name' => $a['mtname'],
                                        'cnt' =>  $a['capacity']
                                    ];
                                    array_push($material_step_arr,$m_arr);
                                }
                            }

                            $step_info = fnGetProcessNameByCode($d['step_typ']);
                            $step_loss = (fn_ArrayCnt($step_info)>0) ? $step_info['loss'] : 0;

                            $t_arr = [
                                'gcode' => $d['fk_gcode'],
                                'prcode' => $d['prcode'],
                                'stepNum' => $d['stepNum'],
                                'step_typ' => $d['step_typ'],
                                'step_loss' =>$step_loss,
                                'step_name' => $d['step_name'],
                                'input_material' => $d['input_material'],
                                'output_material' => $d['output_material'],
                                'method' => $d['p_method'],
                                'material' => $material_step_arr
                            ];

                            array_push($process_arr,$t_arr);
                        }

                        $main_data = [
                            'code' => $code,
                            'goods_arr' => $goods_arr,
                            'process_arr' => $process_arr,
                            'material_arr' => $material_arr,
                            'category' => fnMake_Products_Type($goods_arr['category']),
                            'material1' => fnMake_Material_option('',1),
                            'material2' => fnMake_Material_option('',2),
                            'process' => fnMake_Process_Type('')
                        ];

                        $form = new Form;
                        $main_data = [
                            'meta' => $form->fnMake_Meta($metaarr),
                            'header' => $form->fnMake_Header($sessinarr),
                            'left' => $form->fnMake_Left(),
                            'body' => $main_data,
                            'footer' => $form->fnMake_Fooeter($sessinarr)
                        ];

                        return view('web/common/productsEditor_View', $main_data);
                    }
                }
            }
        }
    }




}