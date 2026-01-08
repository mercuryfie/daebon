<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class ProductController extends BaseController
{

    use ResponseTrait;

    public function __construct()
    {
        $Auth = [AUTH_PRODUCT,AUTH_MASTER];
        $this->Check_Auth($Auth);
    }

    public function main()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '생산목록-작업자',
                'h_type' => 1
            ];

            $left_data = [
                'session' => $sessinarr,
                'gicode' => ''
            ];
            $main_data = [];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Staff_Left($left_data),
                'main' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/production/productionListStaff_View', $main_data);
        }
    }

    public function statusDetail()
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
                'h_title' => '생산현황 상세-작업자',
                'h_type' => 1
            ];

            $produce_m = model('Produce_m');
            $data = $this->fn_SetInstructions_Step($produce_m,$gicode,$uid);
            if($data['status']=='') {
                fn_Alert('잘못된 접근입니다.');
            }else if($data['status']=='error'){
                fn_Alert('존재하지 않는 지시서 입니다.');
            }else if($data['status']=='ok'){
                $info = $data['info'];
                $process = $data['process'];
                $nowprcode = $data['prcode'];

                $p_type = $process['p_type'];
                if($p_type['gubun']==1){//단일고정
                    //$btn_name = $process['p_type']['name'].'완료';
                    $b_type = 2;
                }else {//복합공정
                    if(($info['step_sub_now']==0) && ($info['is_complete']==0)) {
                        //$btn_name = $process['p_type']['name'] . ' 측정';
                        $b_type = 0;
                    }else if (($info['step_sub_now']==1) && ($info['is_complete']==0)) {
                        //$btn_name = $process['p_type']['name'] . ' 시작';
                        $b_type = 1;
                    } else if (($info['step_sub_now']==1) && ($info['is_complete']==1)) {
                        //$btn_name = $process['p_type']['name']. ' 완료';
                        $b_type = 2;
                    } else if ($info['step_sub_now']==2) {
                        //$btn_name = '작업완료';
                        $b_type = 3;
                    }
                }

                $data = [
                    'g_name' => $info['gname'],
                    'step_now' => $info['step_now'],
                    'step_sub_now' => $info['step_sub_now'],
                    'unit_weight' => $info['unit_weight'],
                    'p_name' => $process['step_name'],
                    'step_typ' => $process['step_typ'],
                    'input' => $process['input_material'],
                    'output' => $process['output_material'],
                    'semi_code' => $process['semi_code'],
                    'start_weight' => $process['start_weight'],
                    'end_weight' => $process['end_weight'],
                    'method' => $process['p_method'],
                    'status' => $process['status'],
                    'worker' => $process['worker'],
                    'material' => $process['material'],
                    'ptype' => $p_type,
                    'btype' => $b_type
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
                    'left' => $form->fnMake_Staff_Left($left_data),
                    'body' => $main_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/production/productionDetailStaff_View', $main_data);
            }
        }
    }



}