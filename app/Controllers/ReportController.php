<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class ReportController extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $Auth = [AUTH_MASTER];
        $this->Check_Auth($Auth);
    }


    public function qualityReport()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '품질보고서',
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

            return view('web/common/qualityReportList_View', $main_data);
        }
    }

    public function qualityReportForm()
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

            return view('web/include/pop_QualityReport_View',$main_data);
        }
    }


    public function qualityReport3()
    {
        $sessinarr = $this->GetSessionData();
        $gicode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        $nowcode  = ($this->request->getGet('nd') == '') ? '' : $this->request->getGet('nd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($gicode==''){
            fn_Alert('잘못된 접근입니다.');
        }else {
            $metaarr = [
                'h_title' => '생산현황 상세',
                'h_type' => 1
            ];

            $produce_m = model('Produce_m');
            $info = fn_LoadInstructionsInfo($produce_m,$gicode);
            if(fn_ArrayCnt($info)<=0){
                fn_Alert('존재하지 않는 지시서입니다.');
            }else {
                $nowchcode = $info['step_now'];
                $process = fn_LoadInstructionsSingleProcess($produce_m,$gicode,$nowcode);
                if(fn_ArrayCnt($process)<=0){
                    fn_Alert('존재하지 않는 공정입니다.');
                }else {

                    if($process['status']=='0'){
                        $worker = [
                            'name' => '',
                            'actdate' => ''
                        ];
                    }else if($process['status']=='1'){
                        $worker = [
                            'name' => $process['worker']['start']['name'],
                            'actdate' => $process['worker']['start']['actdate']
                        ];
                    }else if($process['status']=='2'){
                        $worker = [
                            'name' => $process['worker']['end']['name'],
                            'actdate' => $process['worker']['end']['actdate']
                        ];
                    }

                    $p_arr = fnGetProcessNameByCode($process['step_typ']);
                    if($p_arr['gubun']==1){
                        $btn_name = $p_arr['name'] . '완료';
                    }else{
                        $btn_name = '시작';
                    }

                    $isnow = ($nowchcode==$nowcode) ? 'yes' : 'no';

                    $data = [
                        'g_name' => $info['gname'],
                        'p_name' => $process['step_name'],
                        'step_typ' => $process['step_typ'],
                        'input' => $process['input_material'],
                        'output' => $process['output_material'],
                        'after' => $process['after_material'],
                        'method' => $process['p_method'],
                        'status' => $process['status'],
                        'worker' => $worker,
                        'material' => $process['material'],
                        'step_val' => $p_arr,
                        'btn_name' => $btn_name,
                        'nowstep' => $nowchcode
                    ];

                    $left_data = [
                        'session' => $sessinarr,
                        'gicode' => $gicode,
                        'nowstep' => $nowchcode,
                        'nowcode' => $nowcode
                    ];

                    $main_data = [
                        'gicode' => $gicode,
                        'prcode' => $nowchcode,
                        'isnow' => $isnow,
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

    public function qualityReport2()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '품질보고서',
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

            return view('web/common/qualityReport_View',$main_data);
        }
    }

    public function orderReport()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '주문보고서',
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

            return view('web/common/orderReport_View',$main_data);
        }
    }

}