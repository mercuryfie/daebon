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
            $stepInfo = $produce_m->Load_Instructions_Process($gicode);
            if (fn_ArrayCnt($stepInfo) === 0) {
                fn_Alert('존재하지 않는 공정입니다.');
            }else{
                $data_arr = [];
                foreach($stepInfo as $d){
                    $gicod = $d['fk_gicode'];
                    $prcode = $d['fk_prcode'];
                    if($d['status']==0){
                        $s_str = '다음공정대기중';
                    }else if($d['status']==1){
                        $s_str = '공정진행중';
                    }else if($d['status']==2){
                        $s_str = '공정완료';
                    }
                    $worker = fn_LoadInstructionsWorker($produce_m,$d['fk_gicode'],$d['fk_prcode']);
                    if($worker['start']['uid']==''){
                        $start = '';
                    }else{
                        $start = $worker['start']['name'].'['.$worker['start']['actdate'].']';
                    }
                    if($worker['end']['uid']==''){
                        $end = '';
                    }else{
                        $end = $worker['end']['name'].'['.$worker['end']['actdate'].']';
                    }

                    if($d['step_typ']=='P001'){
                        $end_p = ($d['output_material']=='') ? '0g' : $d['output_material'].'g';
                        $guess = $end_p;
                        $end =  ($d['end_weight']=='') ? '0g' : $d['end_weight'].'g';
                        $real = $end;
                    }else{
                        $start_p = ($d['input_material']=='') ? '0g' : $d['input_material'].'g';
                        $end_p = ($d['output_material']=='') ? '0g' : $d['output_material'].'g';
                        $guess = $start_p.' / '.$end_p;
                        $start = ($d['start_weight']=='') ? '0g' : $d['start_weight'].'g';
                        $end =  ($d['end_weight']=='') ? '0g' : $d['end_weight'].'g';
                        $real = $start.' / '.$end;
                    }




                    $t_arr = [
                        'indate' => fn_Short_Date($d['indate']),
                        'gicode' => $gicod,
                        'prcode' => $prcode,
                        'stepNum' => $d['stepNum'],
                        'step_name' => $d['step_name'],
                        'guess' => $guess,
                        'real' => $real,
                        'status' => $s_str,
                        'start' => $start,
                        'end' => $end
                    ];

                    array_push($data_arr,$t_arr);
                }
                $main_data = [
                    'gicode' => $gicode,
                    'prcode' => $prcode,
                    'info' => $data_arr
                ];
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



}