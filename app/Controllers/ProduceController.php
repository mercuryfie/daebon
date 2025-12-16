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


//    public function reportForm()
//    {
//        $sessinarr = $this->GetSessionData();
//        $code  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
//        $typ = ($this->request->getGet('tp') == '') ? 1 : $this->request->getGet('tp');
//        if($sessinarr['islogin']==false) {
//            return redirect()->to('/member/login');
//        }else if($code==''){
//            fn_Alert('잘못된 접근입니다.');
//        }else {
//            $metaarr = [
//                'h_title' => H_TITLE,
//                'h_type' => 1
//            ];
//
//            $produce_m = model('Produce_m');
//            $info_arr = fn_LoadInstructionsInfo($produce_m,$code);
//            $material_param = fn_LoadInstructionsMaterial($produce_m,$code);
//            $step_info = fn_LoadInstructionsProcess($produce_m,$code);
//
//            $main_data = [
//                'info_arr' => $info_arr,
//                'material_arr' => $material_param,
//                'step_arr' => $step_info
//            ];
//
//
//            $form = new Form;
//            $main_data = [
//                'meta' => $form->fnMake_Meta($metaarr),
//                'header' => $form->fnMake_Header($sessinarr),
//                'left' => $form->fnMake_Left(),
//                'body' => $main_data,
//                'footer' => $form->fnMake_Fooeter($sessinarr)
//            ];
//
//            return view('web/include/pop_QualityReport_View',$main_data);
//        }
//    }



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
            $info = $produce_m->Load_Instructions_Info($gicode);
            $stepnow = (fn_ArrayCnt($info)===0) ? '1' : $info[0]['step_now'];

            $main_data = ['gicode' => $gicode,'stepnow' => $stepnow];
            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'body' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/productionDetail_View', $main_data);
        }
    }

}