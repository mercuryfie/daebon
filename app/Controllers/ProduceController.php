<?php

namespace App\Controllers;

/*administrator*/

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
        $typ = ($this->request->getGet('tp') == '') ? 1 : $this->request->getGet('tp');
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
            $info_arr = fn_LoadInstructionsInfo($produce_m,$code);
            $material_param = fn_LoadInstructionsMaterial($produce_m,$code);
            $step_info = fn_LoadInstructionsProcess($produce_m,$code);

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

            return view('web/include/pop_InstructionForm2_View',$main_data);
        }
    }


    public function reportForm()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        $typ = ($this->request->getGet('tp') == '') ? 1 : $this->request->getGet('tp');
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
            $info_arr = fn_LoadInstructionsInfo($produce_m,$code);
            $material_param = fn_LoadInstructionsMaterial($produce_m,$code);
            $step_info = fn_LoadInstructionsProcess($produce_m,$code);

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

            return view('web/include/pop_Report_View',$main_data);
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

    public function productionDetail()
    {
        $sessinarr = $this->GetSessionData();
        $gicode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($gicode==''){
            fn_Alert('잘못된 접근입니다.');
        }else {
            $uid = $sessinarr['user']['uid'];

            $metaarr = [
                'h_title' => '생산현황 상세',
                'h_type' => 1
            ];

            $produce_m = model('Produce_m');
            $stepInfo = fn_GetInstructions_Step($produce_m,$gicode,$uid);


            if($stepInfo['prcode']==''){
                fn_Alert('잘못된 접근입니다.');
            }else if(fn_ArrayCnt($stepInfo['info'])<=0){
                fn_Alert('존재하지 않는 지시서입니다.');
            }else if(fn_ArrayCnt($stepInfo['data'])<=0){
                fn_Alert('존재하지 않는 공정입니다.');
            }else if($stepInfo['info']['is_complete']=='2'){
                fn_Alert('이미 완료된 지시서입니다.');
            }else if($stepInfo['data']['status']==2) {
                fn_Alert('이미 완료된 공정입니다.');
            }else{
                $nowprcode = $stepInfo['prcode'];
                $info = $stepInfo['info'];
                $process = $stepInfo['data'];

                if($process['p_type']['gubun']==1){//단일고정
                    $btn_name = $process['p_type']['name'].'완료';
                }else {//복합공정
                    if ($info['step_sub_now']==0) {
                        $btn_name = '작업시작';
                    } else if ($info['step_sub_now']==1) {
                        $btn_name = '작업완료';
                    }
                }

                $data = [
                    'g_name' => $info['gname'],
                    'step_now' => $info['step_now'],
                    'step_sub_now' => $info['step_sub_now'],
                    'p_name' => $process['step_name'],
                    'step_typ' => $process['step_typ'],
                    'input' => $process['input_material'],
                    'output' => $process['output_material'],
                    'semi_code' => $process['semi_code'],
                    'start_weight' => $process['start_weight'],
                    'end_weight' => $process['end_weight'],
                    'method' => $process['p_method'],
                    'status' => $process['status'],
                    'worker' => $process['worker_arr'],
                    'material' => $process['material'],
                    'gubun' => $process['p_type']['gubun'],
                    'btn_name' => $btn_name
                ];

                $left_data = [
                    'session' => $sessinarr,
                    'gicode' => $gicode,
                    'prcode' => $nowprcode
                ];

                $main_data = [
                    'gicode' => $gicode,
                    'prcode' => $nowprcode,
                    'info' => $data,
                    'material' => $process
                ];

                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left($left_data),
                    'body' => $main_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/common/productionDetail_View', $main_data);
            }
        }
    }



}