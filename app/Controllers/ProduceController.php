<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class ProduceController extends BaseController
{

    use ResponseTrait;

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
            $mRs = $produce_m->Load_Produce_List_Code($code);
            $info_arr = [];
            if(fn_ArrayCnt($mRs)>0){
                $d = $mRs[0];
                $info_arr = [
                    'gcode' => $d['fk_gcode'],
                    'gname' => $d['gname'],
                    'writer' => '관리자',
                    'category' => $d['category'],
                    'catestr' => fnGetProductNameByCode($d['category']),
                    'tquantity' => $d['tquan'],
                    'inventory' => $d['inventory'],
                    'step_cnt' => $d['Cnt'],
                    'quantity' => $d['quantity'],
                    'step_now' => $d['step_now'],
                    'indate' => $d['indate'],

                ];
            }

            $goods_m=model('Goods_m');
            $mtRs = $goods_m->Load_Goods_Material($code);
            $material_param = [];
            if(fn_ArrayCnt($mtRs)>0){
                foreach ($mtRs as $d){
                    $t_arr = [
                        'mcode' => $d['mcode'],
                        'capacity' => $d['capacity'],
                        'mname' => $d['mname'],
                        'maker' => $d['fk_mname'],
                        'supply' => $d['fk_sname']
                    ];

                    array_push($material_param,$t_arr);
                }
            }

            $pRs = $goods_m->Load_Goods_Process($code);
            $step_info = [];
            if(fn_ArrayCnt($pRs)>0){
                $fields = ['a.*','b.mname'];
                foreach($pRs as $a){
                    $cRs = $goods_m->Load_Goods_Step_Material($a['fk_gcode'],$a['stepNum']);
                    $step_material = '';
                    if(fn_ArrayCnt($cRs)>0){
                        foreach($cRs as $f){
                            if($step_material==''){
                                $step_material = $f['mname'] . ':'. $f['capacity'].'개<br>';
                            }else{
                                $step_material .= $f['mname'] . ':'. $f['capacity'].'개<br>';
                            }
                        }
                    }

                    $t_arr = fnGetProcessNameByCode($a['step_typ']);

                    $a_arr = [
                        'step_name' => $a['step_name'],
                        'step_num' => $a['stepNum'],
                        'input' => $a['input_material'],
                        'output' => $a['output_material'],
                        'method' => $a['p_method'],
                        'material' => $step_material
                    ];

                    array_push($step_info,$a_arr);
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

            return view('web/include/pop_OrderRoastForm_View',$main_data);
        }
    }


    public function productionStatus()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '생산현황',
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

            return view('web/common/productionStatus_View', $main_data);
        }
    }

    public function productionlist()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '생산목록',
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

            return view('web/common/productionList_View', $main_data);
        }
    }


    public function productionListStaff()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '생산목록',
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

            return view('web/common/productionListStaff_View', $main_data);
        }
    }

    public function productionDetail()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '생산현황상세',
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

            return view('web/common/productionDetail_View', $main_data);
        }
    }

    public function productionDetailMono()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '원자재 목록',
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

            return view('web/common/productionDetailMono_View', $main_data);
        }
    }

    public function productionComplete()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '원자재 목록',
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

            return view('web/common/productionComplete_View', $main_data);
        }
    }

    public function productionComplete2()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '원자재 목록',
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

            return view('web/common/productionComplete2_View', $main_data);
        }
    }

}