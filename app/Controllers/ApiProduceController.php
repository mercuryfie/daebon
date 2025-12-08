<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiProduceController extends BaseController
{
    use ResponseTrait;


    public function Search_Goods()
    {
        $sessinarr = $this->GetSessionData();
        $skey  = ($this->request->getPost('skey') == '') ? '' : $this->request->getPost('skey');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($skey==''){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else {
            $goods_m = model('Goods_m');
            $cRs = $goods_m->Search_Goods_Info($skey);
            if(fn_ArrayCnt($cRs)<=0){
                $result = 'ok';
                $data = [];
                $message = '';
            }else{
                $i_arr = [];
                foreach ($cRs as $d){
                    $t_arr =[
                        'gcode' => $d['gcode'],
                        'gname' => $d['gname']
                    ];
                    array_push($i_arr,$t_arr);
                }

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }



    public function Load_Instructions_Process()
    {
        $sessinarr = $this->GetSessionData();
        $gicode  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($gicode==''){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else{
            $produce_m=model('Produce_m');
            $pRs = $produce_m->Load_Instructions_Process($gicode);
            $step_info = [];
            if(fn_ArrayCnt($pRs)>0){
                foreach($pRs as $a){
                    $cRs = $produce_m->Load_Instructions_Step_Material($gicode,$a['fk_prcode']);

                    $status_str = '';
                    $step_material = '';
                    if(fn_ArrayCnt($cRs)>0){
                        foreach($cRs as $f){
                            if($step_material==''){
                                $step_material = $f['mtname'] . ':'. $f['capacity'].'개<br>';
                            }else{
                                $step_material .= $f['mtname'] . ':'. $f['capacity'].'개<br>';
                            }
                        }
                    }

                    if($a['status']==0){
                        $status_str = PROCESS_STEP1;
                    } else if ($a['status']==1) {
                        $status_str = PROCESS_STEP2;
                    } else {
                        $status_str = PROCESS_STEP3;
                    }

                    $t_arr = fnGetProcessNameByCode($a['step_typ']);

                    $a_arr = [
                        'prcode' => $a['fk_prcode'],
                        'indate' => $a['indate'],
                        'shortdate' => fn_Short_Date($a['indate']),
                        'step_name' => $a['step_name'],
                        'step_num' => $a['stepNum'],
                        'input' => $a['input_material'],
                        'output' => $a['output_material'],
                        'method' => $a['p_method'],
                        'worker' => $a['worker'],
                        'status' => $status_str,
                        'material' => $step_material
                    ];

                    array_push($step_info,$a_arr);
                }
            }

            $i_arr = [
                'tcnt' => fn_ArrayCnt($step_info),
                'list' => $step_info
            ];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }


    public function Process_Confirm()
    {
        $sessinarr = $this->GetSessionData();
        $data  = ($this->request->getPost('data') == '') ? [] : $this->request->getPost('data');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if(fn_ArrayCnt($data)<=0){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else{
            $uid = $sessinarr['user']['uid'];
            $gicode = $data['gicode'];
            $prcode = $data['prcode'];
            $gubun = $data['gubun'];
            $status = $data['status'];
            $weight = $data['weight'];
            $stepnow = $data['stepnow'];
            $stepsub = $data['stepsub'];

            $produce_m=model('Produce_m');
            $process = fn_LoadInstructionsSingleProcess($produce_m,$gicode,$prcode);
            if(fn_ArrayCnt($process)<=0){
                $result = 'Error006';
                $data = [];
                $message = '존재하지 않는 공정입니다.';
            }else if($process['status']==2){
                $result = 'Error007';
                $data = [];
                $message = '이미 완료된 공정입니다.';
            }else{
                $pscode = $process['semi_code'];
                if($gubun=='1'){//단일 공정
                    $param=['end_weight' => $weight,'status' => 2];
                    $Cnt = $produce_m->Update_Instructions_Process($gicode,$prcode,$param);
                    if($Cnt<=0){
                        $result = 'Error005';
                        $data = [];
                        $message = '공정 완료처리에 실패하였습니다.';
                    }else{
                        if($pscode!=''){
                            //사용반제품출고
                            fn_OutPut_SemiProduct($produce_m,$gicode,$prcode,$pscode);
                        }
                        $Cnt = fn_Input_ProcessWorker($produce_m,$gicode,$prcode,$uid,2);
                        if(fn_Check_CompleteProcess($produce_m,$gicode)){//전체완료다
                            $param = ['is_complete' => 2,'step_sub_now' => 2];
                            $Cnt = $produce_m->Update_Instructions_Info($gicode,$param);
                            //완제품입고
                            fn_Input_FinalProduct($produce_m,$gicode,$weight);

                            $result = 'ok';
                            $data = [];
                            $message = '';
                        }else{
                            //반제품입고
                            $r_arr = fn_Input_SemiProduct($produce_m,$gicode,$prcode,$weight);
                            $newpscode = $r_arr['pscode'];

                            $stepNew = $stepnow+1;
                            $nextprcode = fn_Load_Process_Code($produce_m,$gicode,$stepNew);

                            $param = ['semi_code' => $newpscode];
                            $Cnt = $produce_m->Update_Instructions_Process($gicode, $nextprcode, $param);
                            $param = ['step_now'=>$stepNew,'step_sub_now' => 0];
                            //$param = ['step_sub_now' => 2];
                            $Cnt = $produce_m->Update_Instructions_Info($gicode,$param);

                            $result = 'ok';
                            $data = [];
                            $message = '';
                        }
                    }
                }else{
                    if($stepsub==1){//복합공정 시작
                        if($pscode!=''){
                            //사용반제품출고
                            fn_OutPut_SemiProduct($produce_m,$gicode,$prcode,$pscode);
                        }
                        $param = ['step_sub_now' => 1];
                        $Cnt = $produce_m->Update_Instructions_Info($gicode,$param);
                        $Cnt = fn_Input_ProcessWorker($produce_m,$gicode,$prcode,$uid,1);
                        $param=['status' => 1,'start_weight' => $weight];
                        $Cnt = $produce_m->Update_Instructions_Process($gicode,$prcode,$param);
                        if($Cnt<=0){
                            $result = 'Error005';
                            $data = [];
                            $message = '공정 시작처리에 실패하였습니다.';
                        }else{
                            $result = 'ok';
                            $data = [];
                            $message = '';
                        }
                    }else if($stepsub==2){//복합공정 완료처리
                        $param=['end_weight' => $weight,'status' => 2];
                        $Cnt = $produce_m->Update_Instructions_Process($gicode,$prcode,$param);
                        if($Cnt<=0) {
                            $result = 'Error005';
                            $data = [];
                            $message = '공정 시작처리에 실패하였습니다.';
                        }else {
                            $Cnt = fn_Input_ProcessWorker($produce_m,$gicode,$prcode,$uid,2);
                            if(fn_Check_CompleteProcess($produce_m,$gicode)){//전체완료다
                                $param = ['is_complete' => 2,'step_sub_now' => 2];
                                $Cnt = $produce_m->Update_Instructions_Info($gicode, $param);
                                //완제품입고
                                fn_Input_FinalProduct($produce_m, $gicode, $weight);
                                $result = 'ok';
                                $data = [];
                                $message = '';
                            } else {
                                //반제품입고
                                $r_arr = fn_Input_SemiProduct($produce_m, $gicode, $prcode, $weight);
                                $newpscode = $r_arr['pscode'];

                                $stepNum = $stepnow+1;
                                $nextprcode = fn_Load_Process_Code($produce_m,$gicode,$stepNum);
                                $param = ['semi_code' => $newpscode];
                                $Cnt = $produce_m->Update_Instructions_Process($gicode, $nextprcode, $param);
                                $param = ['step_now'=>$stepNum,'step_sub_now' => 0];
                                $Cnt = $produce_m->Update_Instructions_Info($gicode,$param);

                                $result = 'ok';
                                $data = [];
                                $message = '';
                            }
                        }
                    }
                }
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


    public function Load_Instructions_NowStep()
    {
        $sessinarr = $this->GetSessionData();
        $gicode  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($gicode=='') {
            $result = 'Error003';
            $data = [];
            $message = '필수정보가 누락되었습니다.';
        }else{
            $uid = $sessinarr['user']['uid'];
            $produce_m=model('Produce_m');
            $nowprcode = fn_GetInstructions_Step_Act($produce_m,$gicode,$uid);
            if($nowprcode=='complete'){
                $result = 'Error004';
                $data = [];
                $message = '이미 종료된 작업입니다.';
            }else{
                $i_arr = [
                    'prcode' => $nowprcode
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);

    }


    public function Load_Instructions_Info()
    {
        $sessinarr = $this->GetSessionData();
        $search  = ($this->request->getPost('param') == '') ? [] : $this->request->getPost('param');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';

        }else{
            $stype = array_key_exists('stype', $search) ? $search['stype'] : '';
            $page = array_key_exists('page', $search) ? $search['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $param = [
                'limit' => $limit,
                'offset' => $offset,
                'stype' => $stype
            ];

            $produce_m=model('Produce_m');
            $iRs = $produce_m->Load_Instructions_List_All($param);
            $info_arr = [];
            if(fn_ArrayCnt($iRs)<=0){
                $i_arr = [
                    'tcnt' => 0,
                    'list' => ''
                ];
            }else{
                foreach ($iRs as $d){
                    $param = [
                        'iscomplete' => $d['is_complete'],
                        'gicode' => $d['gicode'],
                        'prcode' => $d['nowprcode'],
                        'stepnow' => $d['step_now']
                    ];
                    $p_arr = fn_Load_NowStep($produce_m,$param);

                    $t_arr = [
                        'gicode' => $d['gicode'],
                        'gcode' => $d['fk_gcode'],
                        'icnt' => $d['icnt'],
                        'gname' => $d['gname'],
                        'category' => $d['category'],
                        'catestr' => fnGetProductNameByCode($d['category']),
                        'quantity' => $d['quantity'],
                        'inventory' => $d['inventory'],
                        'iscomplete' => $d['is_complete'],
                        'indate' => $d['indate'],
                        'shortdate' => fn_Short_Date($d['indate']),
                        'processcnt' => $d['Cnt'],
                        'processname' => $p_arr['step'],
                        'processstr' => $p_arr['str'],
                        'worker' => $p_arr['worker'],
                        'stepnow' => $d['step_now'],
                        'stepNum' => $p_arr['stepNum']
                    ];

                    array_push($info_arr,$t_arr);
                }

                $i_arr = [
                    'tcnt' => fn_ArrayCnt($info_arr),
                    'list' => $info_arr
                ];
            }

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

}