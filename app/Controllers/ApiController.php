<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiController extends BaseController
{
    use ResponseTrait;



    public function mod_Goods_Info(){
        $sessinarr = $this->GetSessionData();
        $info  = ($this->request->getPost('info') == '') ? [] : $this->request->getPost('info');
        $step  = ($this->request->getPost('step') == '') ? [] : $this->request->getPost('step');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if((fn_ArrayCnt($info)<=0) || (fn_ArrayCnt($step)<=0)){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else{
            $gcode = $info['gcode'];
            $info_parma = [
                'gname' => $info['name'],
                'category' => $info['category'],
                'quantity' => $info['quantity'],
                'inventory' => $info['inventory'],
            ];

            $material_param = [];
            if(fn_ArrayCnt($info['material']) > 0){
                foreach($info['material'] as $d){
                    $mp_arr= [
                        'fk_gcode' => $gcode,
                        'fk_mtcode' => $d['code'],
                        'capacity' => $d['cnt']
                    ];

                    array_push($material_param,$mp_arr);
                }
            }

            $step_info = [];
            $step_marerial = [];
            if(fn_ArrayCnt($step)>0){
                foreach ($step as $a){
                    $s_arr = [
                        'prcode' => $a['prcode'],
                        'fk_gcode' => $gcode,
                        'stepNum' => $a['stepNum'],
                        'step_typ' => $a['ptype'],
                        'step_name' => $a['pname'],
                        'input_material' => $a['minput'],
                        'output_material' => $a['moutput'],
                        'p_method' => $a['memo']
                    ];
                    array_push($step_info,$s_arr);

                    if(fn_ArrayCnt($a['accessory'])>0){
                        foreach($a['accessory'] as $s){
                            if($s['acode']!=''){
                                $mt_arr = [
                                    'fk_gcode' => $gcode,
                                    'fk_prcode' => $a['prcode'],
                                    'fk_mtcode' => $s['acode'],
                                    'capacity' => $s['acnt']
                                ];

                                array_push($step_marerial,$mt_arr);
                            }
                        }
                    }
                }
            }


            $goods_m = model('Goods_m');
            $pCnt = $goods_m->Delete_Goods_Process($gcode);
            $piCnt = $goods_m->Insert_Goods_Process($step_info);
            if(($pCnt<=0) || ($piCnt<=0) || (fn_ArrayCnt($step_info) <= 0)){
                echo('$pCnt='.$pCnt.'   $piCnt='.$piCnt.'  cnt='.n_ArrayCnt($step_info) );
                $result = 'Error005';
                $data = [];
                $message = '데이터 수정에 실패 하였습니다.';
            }else{
                $mCnt = $goods_m->Delete_Goods_Material($gcode);
                $miCnt = $goods_m->Insert_Goods_Material($material_param);
                if(($mCnt<=0) || ($miCnt<=0) || (fn_ArrayCnt($info_parma) <= 0)){
                    $result = 'Error006';
                    $data = [];
                    $message = '데이터 수정에 실패 하였습니다.';
                }else{
                    $Cnt = $goods_m->Update_Goods_Info($gcode,$info_parma);

                    $mgsCnt = $goods_m->Delete_Goods_Step_Material($gcode);
                    if(fn_ArrayCnt($step_marerial)>0){
                        $mgiCnt = $goods_m->Insert_Goods_Step_Material($step_marerial);
                    }


                    $i_arr = [
                        'code' => $gcode
                    ];

                    $result = 'ok';
                    $data = $i_arr;
                    $message = '';
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

    public function Load_Goods_Info()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getPost('code') == '') ? [] : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $good_m = model('Goods_m');
            $gRs = $good_m->Load_Goods_Code($code);
            if(fn_ArrayCnt($gRs)<=0){
                $result = 'Error003';
                $data = [];
                $message = '존재하지 않는 제품입니다.';
            }else{
                $goods_arr = [
                    'code' => $gRs[0]['gcode'],
                    'name' => $gRs[0]['gname'],
                    'cname' => fnGetProductNameByCode($gRs[0]['category']),
                    'quantity' => $gRs[0]['quantity'],
                    'inventory' => $gRs[0]['inventory']
                ];

                $pRs = $good_m->Load_Goods_Process($code);
                if(fn_ArrayCnt($gRs)<=0) {
                    $result = 'Error004';
                    $data = [];
                    $message = '작업 공정이 존재 하지 않습니다.';
                }else{
                    $mRs = $good_m->Load_Goods_Material($code);
                    if(fn_ArrayCnt($mRs)<=0) {
                        $result = 'Error005';
                        $data = [];
                        $message = '작업 재료가 존재하지 않습니다.';
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
                            $cRs = $good_m->Load_Goods_Step_Material($code,$d['fk_prcode']);
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

                            $t_arr = [
                                'gcode' => $d['fk_gcode'],
                                'prcode' => $d['prcode'],
                                'stepNum' => $d['stepNum'],
                                'step_typ' => $d['step_typ'],
                                'step_name' => $d['step_name'],
                                'input_material' => $d['input_material'],
                                'output_material' => $d['output_material'],
                                'method' => $d['p_method'],
                                'material' => $material_step_arr
                            ];

                            array_push($process_arr,$t_arr);
                        }


                        $i_arr = [
                            'goods' => $goods_arr,
                            'process' => $process_arr,
                            'material' => $material_arr
                        ];

                        $result = 'ok';
                        $data = $i_arr;
                        $message = '';
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

    public function Load_Produce_List()
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
            $produce_m = model('Produce_m');
            $mRs = $produce_m->Load_Instructions_List_All($stype);
            if(fn_ArrayCnt($mRs)>0){
                $m_arr = [];
                foreach ($mRs as $d) {
                    $p_arr =fn_NowStepLoad($produce_m,$d['gicode'],$d['is_complete'],$d['step_now']);

                    $t_arr = [
                        'seq' => $d['seq'],
                        'gicode' => $d['gicode'],
                        'gcode' => $d['fk_gcode'],
                        'gname' => $d['gname'],
                        'category' => $d['category'],
                        'catestr' => fnGetProductNameByCode($d['category']),
                        'quantity' => $d['quantity'],
                        'is_complete' => $d['is_complete'],
                        'step_cnt' => $d['Cnt'],
                        'indate' => fn_Short_Date($d['indate']),
                        'step_name' => $p_arr['step'],
                        'step_now' => $p_arr['prcode'],
                        'strep_str' => $p_arr['str']
                    ];

                    array_push($m_arr,$t_arr);
                }
                $i_arr = [
                    'list' => $m_arr,
                    'tcnt' => fn_ArrayCnt($m_arr)
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }else{
                $result = 'ok';
                $data = [];
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


    public function Add_Instructions()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        $cnt  = ($this->request->getPost('cnt') == '') ? '' : $this->request->getPost('cnt');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if(($code=='') || ($cnt =='')){
            $result = 'Error003';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else {
            $goods_m = model('Goods_m');
            $gicode = fnMake_Code(5);
            $iRs = $goods_m->Load_Goods_Code($code);
            $instructions = [];
            if (fn_ArrayCnt($iRs) > 0) {
                $d = $iRs[0];
                $instructions = [
                    'gicode' => $gicode,
                    'fk_gcode' => $code,
                    'icnt' => $cnt,
                    'gname' => $d['gname'],
                    'category' => $d['category'],
                    'quantity' => $d['quantity'],
                    'inventory' => $d['inventory']
                ];
            }

            $mRs = $goods_m->Load_Goods_Material($code);
            $material = [];
            if (fn_ArrayCnt($mRs) > 0) {
                foreach ($mRs as $c) {
                    $t_arr = [
                        'fk_gicode' => $gicode,
                        'fk_gcode' => $c['fk_gcode'],
                        'fk_mtcode' => $c['fk_mtcode'],
                        'capacity' => $c['capacity']
                    ];
                    array_push($material, $t_arr);
                }
            }

            $spRs = $goods_m->Load_Goods_Step_Material_Data($code);
            $stepMaterial = [];
            if (fn_ArrayCnt($spRs) > 0) {
                foreach ($spRs as $b) {
                    $t_arr = [
                        'fk_gicode' => $gicode,
                        'fk_gcode' => $b['fk_gcode'],
                        'fk_prcode' => $b['fk_prcode'],
                        'fk_mtcode' => $b['fk_mtcode'],
                        'capacity' => $b['capacity']
                    ];
                    array_push($stepMaterial, $t_arr);
                }
            }


            $pRs = $goods_m->Load_Goods_Process($code);
            $process = [];
            if (fn_ArrayCnt($pRs) > 0) {
                foreach ($pRs as $a) {
                    $t_arr = [
                        'fk_gicode' => $gicode,
                        'fk_prcode' => $a['prcode'],
                        'fk_gcode' => $a['fk_gcode'],
                        'stepNum' => $a['stepNum'],
                        'step_typ' => $a['step_typ'],
                        'step_name' => $a['step_name'],
                        'input_material' => $a['input_material'],
                        'output_material' => $a['output_material'],
                        'p_method' => $a['p_method']
                    ];
                    array_push($process, $t_arr);
                }
            }

            if(fn_ArrayCnt($instructions)<=0){
                $result = 'Error004';
                $data = [];
                $message = '작업지시서 정보 로드에 실패하였습니다.';
            }else{
                $cnt1 = $goods_m->Insert_Instructions($instructions);
                if($cnt1<=0){
                    $result = 'Error005';
                    $data = [];
                    $message = '작업지시서 발행에 실패 하였습니다.';
                }else{
                    if(fn_ArrayCnt($material)<=0){
                        $result = 'Error006';
                        $data = [];
                        $message = '원재료 정보 로드에 실패 하였습니다.';
                    }else{
                        $cnt2 = $goods_m->Insert_Instructions_Material($material);
                        if($cnt2<=0){
                            $result = 'Error007';
                            $data = [];
                            $message = '작업지시서 원재료 정보 등록에 실패하였습니다.';
                        }else{
                            if(fn_ArrayCnt($process)<=0){
                                $result = 'Error008';
                                $data = [];
                                $message = '작업지시서 공정정보 로드에 실패 하였습니다.';
                            }else{
                                $cnt3 = $goods_m->Insert_Instructions_Process($process);
                                if($cnt3<=0){
                                    $result = 'Error008';
                                    $data = [];
                                    $message = '작업지시서 공정정보 등록에 실패하였습니다.';
                                }else{
                                    if(fn_ArrayCnt($stepMaterial)>0) {
                                        $cnt4 = $goods_m->Insert_Instructions_Step_Material($stepMaterial);
                                    }

                                    $i_arr = [
                                        'gicode' => $gicode
                                    ];

                                    $result = 'ok';
                                    $data = $i_arr;
                                    $message = '';
                                }
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

    public function Add_Goods_Info()
    {
        $sessinarr = $this->GetSessionData();
        $info  = ($this->request->getPost('info') == '') ? [] : $this->request->getPost('info');
        $step  = ($this->request->getPost('step') == '') ? [] : $this->request->getPost('step');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if((fn_ArrayCnt($info)<=0) || (fn_ArrayCnt($step)<=0)){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else{
            $newcode = fnMake_Code(2);
            $info_parma = [
                'gcode' => $newcode,
                'gname' => $info['name'],
                'category' => $info['category'],
                'quantity' => $info['quantity'],
                'inventory' => $info['inventory'],
            ];

            $material_param = [];
            if(fn_ArrayCnt($info['material']) > 0){
                foreach($info['material'] as $d){
                    $mp_arr= [
                        'fk_gcode' => $newcode,
                        'fk_mtcode' => $d['code'],
                        'capacity' => $d['cnt']
                    ];

                    array_push($material_param,$mp_arr);
                }
            }

            $step_info = [];
            $step_marerial = [];
            if(fn_ArrayCnt($step)>0){
                foreach ($step as $a){
                    $prcode = fnMake_Code(4);
                    $s_arr = [
                        'prcode' => $prcode,
                        'fk_gcode' => $newcode,
                        'stepNum' => $a['stepNum'],
                        'step_typ' => $a['ptype'],
                        'step_name' => $a['pname'],
                        'input_material' => $a['minput'],
                        'output_material' => $a['moutput'],
                        'p_method' => $a['memo']
                    ];
                    array_push($step_info,$s_arr);

                    if(fn_ArrayCnt($a['accessory'])>0){
                        foreach($a['accessory'] as $s){
                            if($s['acode']!=''){
                                $mt_arr = [
                                    'fk_gcode' => $newcode,
                                    'fk_prcode' => $prcode,
                                    'fk_mtcode' => $s['acode'],
                                    'capacity' => $s['acnt']
                                ];

                                array_push($step_marerial,$mt_arr);
                            }
                        }
                    }
                }
            }


            $goods_m = model('Goods_m');
            $Cnt = $goods_m->Insert_Goods_Process($step_info);
            if(($Cnt<=0) || (fn_ArrayCnt($material_param) <= 0)){
                $result = 'Error005';
                $data = [];
                $message = '데이터 등록에 실패 하였습니다.';
            }else{
                $Cnt = $goods_m->Insert_Goods_Material($material_param);
                if(($Cnt<=0) || (fn_ArrayCnt($info_parma) <= 0)){
                    $result = 'Error006';
                    $data = [];
                    $message = '데이터 등록에 실패 하였습니다.';
                }else{
                    $Cnt = $goods_m->Insert_Goods_Info($info_parma);

                    if(fn_ArrayCnt($step_marerial)>0){
                        $Cnt = $goods_m->Insert_Goods_Step_Material($step_marerial);
                    }


                    $i_arr = [
                        'code' => $newcode
                    ];

                    $result = 'ok';
                    $data = $i_arr;
                    $message = '';
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

    public function Add_Goods(){
        $sessinarr = $this->GetSessionData();
        $data = $this->request->getPost('data') ?? [];
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
            $message = '잘못된 접근입니다.';
        }else{
            $newCode = fnMake_Code(2);
            $param = [
                'gcode' =>$newCode,
                'gname' => $data['gname'],
                'category' => $data['category'],
                'quantity' => $data['quantity'],
                'inventory' => $data['inventory']
            ];
            $goods_m = model('Goods_m');
            $NewSeq = $goods_m->Insert_Goods_Info($param);
            if($NewSeq > 0){
                $material_m = model('Material_m');
                $cRs = $material_m->Load_Goods_statistics($newCode,0);
                if(fn_ArrayCnt($cRs)>0){
                    $c_arr = [
                        'total' => ($cRs[0]['tg_input'] - $cRs[0]['tg_output']),
                        'input' => $cRs[0]['tg_input'],
                        'output' => $cRs[0]['tg_output'],
                        'avg'=>  $cRs[0]['avg_g_output']
                    ];
                }else{
                    $c_arr = [
                        'input' => 0,
                        'output' => 0,
                        'avg'=>  0
                    ];
                }
                $param['avg'] = $c_arr;
                $param['seq'] = $NewSeq;

                $i_arr = [
                    'list' => $param,

                ];


                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }else{
                $result = 'Error004';
                $data = [];
                $message = '등록에 실패 하였습니다.';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Load_Goods_List()
    {
        $sessinarr = $this->GetSessionData();
        $search  = ($this->request->getPost('search') == '') ? '' : $this->request->getPost('search');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $good_m = model('Goods_m');
            $mRs = $good_m->Load_Goods_List($search);
            if(fn_ArrayCnt($mRs)>0){
                $material_m = model('Material_m');
                $m_arr = [];
                foreach ($mRs as $d) {

                    $cRs = $material_m->Load_Goods_statistics($d['gcode'],0);
                    if(fn_ArrayCnt($cRs)>0){
                        $c_arr = [
                            'total' => ($cRs[0]['tg_input'] - $cRs[0]['tg_output']),
                            'input' => $cRs[0]['tg_input'],
                            'output' => $cRs[0]['tg_output'],
                            'avg'=>  $cRs[0]['avg_g_output']
                        ];
                    }else{
                        $c_arr = [
                            'input' => 0,
                            'output' => 0,
                            'avg'=>  0
                        ];
                    }

                    $t_arr = [
                        'seq' => $d['seq'],
                        'gcode' => $d['gcode'],
                        'gname' => $d['gname'],
                        'category' => $d['category'],
                        'c_str' => fnGetProductNameByCode($d['category']),
                        'quantity' => $d['quantity'],
                        'inventory' => $d['inventory'],
                        'completecnt' => $material_m->Cnt_Goods_InstructionsBygCode($d['gcode'],0),
                        'avg' => $c_arr

                    ];
                    array_push($m_arr,$t_arr);
                }
                $i_arr = [
                    'list' => $m_arr,
                    'tcnt' => fn_ArrayCnt($m_arr)
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }else{
                $result = 'ok';
                $data = [];
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


    public function Load_Category_Info()
    {
        $sessinarr = $this->GetSessionData();
        $data  = ($this->request->getPost('data') == '') ? [] : $this->request->getPost('data');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(fn_ArrayCnt($data)<=0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $search = $data['skey'];
            $common_m = model('Common_m');
            $mRs = $common_m->Load_Material_Info($search);
            if(fn_ArrayCnt($mRs)>0){
                $m_arr = [];
                foreach ($mRs as $d) {
                   $t_arr = [
                        'acode' => $d['acode'],
                        'aname' => $d['aname'],
                        'bcode' => $d['bcode'],
                        'bname' => $d['bname']
                    ];
                    array_push($m_arr,$t_arr);
                }
                $i_arr = [
                    'list' => $m_arr,
                    'tcnt' => fn_ArrayCnt($m_arr)
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }else{
                $result = 'ok';
                $data = [];
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

    public function Login_Do()
    {
        $userid = ($this->request->getPost('userid') == '') ? '' : $this->request->getPost('userid');
        $pwd = ($this->request->getPost('passwd') == '') ? '' : $this->request->getPost('passwd');
        $is_keep = ($this->request->getPost('iskeep') == '') ? 0 : $this->request->getPost('iskeep');
        $is_save = ($this->request->getPost('issave') == '') ? 0 : $this->request->getPost('issave');

        if (($userid == '') || ($pwd == '')) {
            $result = 'type101';
            $message = '필수항목 입력이 안되어 있습니다. ';
        } else {
            $Member_m = model('Member_m');
            $Cnt = $Member_m->Chk_Member_Userid($userid);
            if($Cnt<=0){
                $result = 'type102';
                $message = '존재하지 않는 아이디 입니다.';
            }else{
                $param = [
                    'userid' => $userid,
                    'passwd' => $pwd
                ];
                $uRs = $Member_m->Load_UserIDAPWD_Info($param);
                if (fn_ArrayCnt($uRs) <= 0) {
                    $result = 'type103';
                    $message = '입력된 아이디의 비밀번호가 틀렸습니다.';
                } else {
                    $auth = new Auth;
                    $LoginInfo = [
                        'uid' => $uRs[0]['uid'],
                        'userid' => $uRs[0]['userid'],
                        'grade' => $uRs[0]['grade'],
                        'name' => $uRs[0]['name'],
                        'token' => $auth->Make_Key($uRs[0]['token'])
                    ];
                    $security = $auth->Make_Key($LoginInfo);
                    if ($security == '') {
                        $result = 'type104';
                        $message = '로그인 회원정보의 암호화에 실패하였습니다. 다시 시도 하여 주세요.';
                    } else {
                        $session = service('session');
                        $session->set(SESSION_KEY, $security);
                        if ($is_keep == 1) {
                            delete_cookie('dj_Cstr');

                            $cookie = [
                                'name' => COOKIE_KEY,
                                'value' => $security,
                                'expire' => 86400 * 30,
                                'domain' => CK_DOMAIN,
                                'path' => '/',
                                'prefix' => ''
                            ];
                            set_cookie($cookie);
                        } else {
                            delete_cookie(COOKIE_KEY, CK_DOMAIN, '/');
                        }

                        if ($is_save == 1) {
                            $cookie = [
                                'name' => CK_IDSAVE,
                                'value' => $userid,
                                'expire' => 2147483647,
                                'domain' => CK_DOMAIN,
                                'path' => '/',
                                'prefix' => ''
                            ];
                            set_cookie($cookie);
                        } else {
                            delete_cookie(COOKIE_KEY, CK_DOMAIN, '/');
                        }

                        $result = 'ok';
                        $key = $security;
                        $message = 'success';
                    }
                }
            }
        }

        $return = [
            'result' => $result,
            'message' => $message
        ];
        return $this->respond($return);


    }


    public function Load_MaterialList(){
        $skey  = ($this->request->getPost('key') == '') ? '' : $this->request->getPost('key');

        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)){
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $material_m = model('Material_m');
            $mRs = ($skey=='') ? $material_m->Load_MaterialList_All() : $material_m->Load_Material_Search($skey);
            $m_arr = [];
            foreach ($mRs as $d){
                $t_arr['seq'] = $d['seq'];
                $t_arr['mtcode'] = $d['mtcode'];
                $t_arr['typ'] = $d['typ'];
                $t_arr['typ_str'] = ($d['typ']==1) ? '원재료' : '부자재';
                $t_arr['mtname'] = $d['mtname'];
                $t_arr['fk_sucode'] = $d['fk_sucode'];
                $t_arr['fk_mkcode'] = $d['fk_mkcode'];
                $t_arr['uname'] = $d['unit_name'];

                $cRs = $material_m->Load_Material_statistics($d['mtcode']);
                if(fn_ArrayCnt($cRs)>0){
                    $t_arr['t_in'] = $cRs[0]['t_input'];
                    $t_arr['t_out'] = $cRs[0]['t_output'];
                    $t_arr['stock'] = $cRs[0]['t_input'] - $cRs[0]['t_output'];
                    $t_arr['avg'] = $cRs[0]['avg_m_output'];
                }else{
                    $t_arr['t_in'] = 0;
                    $t_arr['t_out'] = 0;
                    $t_arr['stock'] = 0;
                    $t_arr['avg'] = 0 ;
                }
                array_push($m_arr,$t_arr);
            }

            $i_arr = [
                'list' => $m_arr,
                'tCnt' => fn_ArrayCnt($m_arr)
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

    public function Load_Material_Info(){
        $mcode  = ($this->request->getPost('code') == '') ? 1 : $this->request->getPost('code');
        $sessinarr = $this->GetSessionData();
        if($mcode==''){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $material_m = model('Material_m');
            $mRs = $material_m->Load_Material_Info($mcode);
            if(fn_ArrayCnt($mRs)<=0){
                $result = 'Error003';
                $data = [];
                $message = '존재하지 않는 원자재 입니다. ';
            }else{
                $d = $mRs[0];
                $m_arr = [
                    'code' => $d['mtcode'],
                    'typ' => $d['typ'],
                    'name' => $d['mtname'],
                    'scode' => $d['fk_sucode'],
                    'sname' => $d['fk_suname'],
                    'mcode' => $d['fk_mkcode'],
                    'mname' => $d['fk_mkname'],
                    'uname' => $d['unit_name']
                ];

                $i_arr = [
                    'list' => $m_arr
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

    public function Add_Material_Info(){
        $data  = ($this->request->getPost('data') == '') ? [] : $this->request->getPost('data');
        $sessinarr = $this->GetSessionData();
        if(fn_ArrayCnt($data)<=0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $material_m = model('Material_m');
            $NewCode = fnMake_Code(3);
            $param = [
                'mtcode' => $NewCode,
                'typ' => $data['typ'],
                'mtname' => $data['mname'],
                'fk_sucode' => $data['supply'],
                'fk_mkcode' => $data['maker'],
                'unit_name' => $data['unit'],
            ];
            $Cnt = $material_m->Insert_Material_Info($param);
            if($Cnt > 0){
                $mRs = $material_m->Load_Material_Info($NewCode);
                if(fn_ArrayCnt($mRs)<=0){
                    $result = 'Error003';
                    $data = [];
                    $message = '존재하지 않는 원자재 입니다. ';
                }else {
                    $d = $mRs[0];
                    $m_arr = [
                        'code' => $d['mtcode'],
                        'typ' => $d['typ'],
                        'name' => $d['mtname'],
                        'typ_str' => ($d['typ']==1) ? '원재료' : '부자재',
                        'scode' => $d['fk_sucode'],
                        'sname' => $d['fk_suname'],
                        'mcode' => $d['fk_mkcode'],
                        'mname' => $d['fk_mkname'],
                        'uname' => $d['unit_name'],
                        't_in' => 0,
                        't_out' => 0,
                        'stock' => 0,
                        'avg' => '0.0000'
                    ];

                    $i_arr = [
                        'list' => $m_arr
                    ];

                    $result = 'ok';
                    $data = $i_arr;
                    $message = '';
                }
            }else{
                $result = 'Error004';
                $data = [];
                $message = '존재하지 않는 원자재 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Mod_Material_Info(){
        $data  = ($this->request->getPost('data') == '') ? [] : $this->request->getPost('data');
        $sessinarr = $this->GetSessionData();
        if(fn_ArrayCnt($data)<=0){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $mcode = $data['mcode'];
            $material_m = model('Material_m');
            $mRs = $material_m->Load_Material_Info($mcode);
            if(fn_ArrayCnt($mRs)>0){
                $param = [
                    'typ' => $data['typ'],
                    'mtname' => $data['mname'],
                    'fk_sucode' => $data['supply'],
                    'fk_mkcode' => $data['maker'],
                    'unit_name' => $data['unit'],
                ];

                $Cnt = $material_m->Update_Material_Info($mcode,$param);
                if($Cnt > 0){
                    $mRs = $material_m->Load_Material_Info($mcode);
                    if(fn_ArrayCnt($mRs)<=0){
                        $result = 'Error003';
                        $data = [];
                        $message = '존재하지 않는 원자재 입니다. ';
                    }else {
                        $d = $mRs[0];
                        $m_arr = [
                            'code' => $d['mtcode'],
                            'typ' => $d['typ'],
                            'name' => $d['mtname'],
                            'typ_str' => ($d['typ']==1) ? '원재료' : '부자재',
                            'scode' => $d['fk_sucode'],
                            'sname' => $d['fk_suname'],
                            'mcode' => $d['fk_mkcode'],
                            'mname' => $d['fk_mkname'],
                            'uname' => $d['unit_name'],
                            't_in' => 0,
                            't_out' => 0,
                            'stock' => 0,
                            'avg' => '0.0000'
                        ];

                        $i_arr = [
                            'list' => $m_arr
                        ];

                        $result = 'ok';
                        $data = $i_arr;
                        $message = '';
                    }
                }else{
                    $result = 'Error004';
                    $data = [];
                    $message = '정보 수정에 실패하였습니다.';
                }
            }else{
                $result = 'Error005';
                $data = [];
                $message = '존재하지 않는 원자재 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Del_Material_Info(){
        $mcode  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        $sessinarr = $this->GetSessionData();
        if(fn_ArrayCnt($mcode)==''){
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $material_m = model('Material_m');
            $mRs = $material_m->Load_Material_Info($mcode);
            if(fn_ArrayCnt($mRs)>0){
                $param = [
                    'is_del' => 1
                ];
                $Cnt = $material_m->Update_Material_Info($mcode,$param);
                if($Cnt > 0){
                    $result = 'ok';
                    $data = [];
                    $message = '';
                }else{
                    $result = 'Error004';
                    $data = [];
                    $message = '정보 수정에 실패하였습니다.';
                }
            }else{
                $result = 'Error005';
                $data = [];
                $message = '존재하지 않는 원자재 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Upload_File()
    {

        $u_type  = ($this->request->getPost('upload_type') == '') ? '1' : $this->request->getPost('upload_type');
        $u_key  = ($this->request->getPost('upload_key') == '') ? '1' : $this->request->getPost('upload_key');
        $timeNow = date("Ymd");
        if($u_type==1) {//상품등록시 대표이미지
            $dir = "././assets/upload/goods/$timeNow";
            $dir2 = "/assets/upload/goods/$timeNow";
            $key = $u_key;
        }

        $allow = 'jpg,jpeg,gif,png';
        $allowed_extensions = explode(',', $allow);
        $file = $this->request->getFile($key);

        if ($file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $max_file_size = 5242880; // 5M
                $filename = $file->getName();
                $ext = substr($filename, strrpos($filename, '.') + 1);
                $size = $file->getSize();
                if (!in_array($ext, $allowed_extensions)) {
                    $uploaded = '0';
                    $message = ['message' => '업로드는 [' . $allow . '] 확장자만 가능합니다.'];
                } else if ($size >= $max_file_size) {
                    $uploaded = '0';
                    $message = ['message' => '업로드는 [' . fn_Str_File_Sise($max_file_size) . '] 까지만 가능합니다.'];
                } else {
                    $upload_dir = $dir . '/';
                    $upload_dir2 = $dir2 . '/';

                    if (is_dir($dir) != true) {
                        mkdir($dir, 0777, true);
                    }

                    helper('text');
                    $fileName = random_string('alnum', 16);
                    $path = $fileName . '.' . $ext;
                    if (move_uploaded_file($file->getTempName(), $upload_dir . $path)) {
                        $uploaded = 1;
                        $fname = $fileName. '.' . $ext;
                        $url = $upload_dir2 . $path;
                    } else {
                        $uploaded = '0';
                        $message = ['message' => '파일 업로드 정보 업데이트에 실패 하였습니다.(Error102)'];
                    }
                }
            } else {
                $uploaded = '0';
                $message = ['message' => '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error103)'];
            }
        } else {
            $uploaded = '0';
            $message = ['message' => '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error104)'];
        }

        if ($uploaded == '1') {
            $status = 'ok';
            $return = [
                'uploaded' => '1',
                'fileName' => $fname,
                'url' => $url
            ];
            $message = '';
        } else {
            $status = 'error';
            $return = [
                'uploaded' => '0',
                'fileName' => '',
                'url' => ''
            ];
            $msg = $message;
        }

        $ret_arr = [
            'result' => $status,
            'info' => $return,
            'message' => $message
        ];

        return $this->respond($ret_arr);

    }

    public function Upload_File_Editor()
    {
        $key = 'upload';
        $allow = 'jpg,jpeg,gif,png';
        $allowed_extensions = explode(',', $allow);
        $file = $this->request->getFile($key);

        if ($file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $max_file_size = 5242880; // 5M
                $filename = $file->getName();
                $ext = substr($filename, strrpos($filename, '.') + 1);
                $size = $file->getSize();
                if (!in_array($ext, $allowed_extensions)) {
                    $uploaded = '0';
                    $message = ['message' => '업로드는 [' . $allow . '] 확장자만 가능합니다.'];
                } else if ($size >= $max_file_size) {
                    $uploaded = '0';
                    $message = ['message' => '업로드는 [' . fn_Str_File_Sise($max_file_size) . '] 까지만 가능합니다.'];
                } else {
                    $timeNow = date("Ymd");
                    $dir = "././assets/upload/editor/$timeNow";
                    $dir2 = "/assets/upload/editor/$timeNow";
                    $upload_dir = $dir . '/';
                    $upload_dir2 = $dir2 . '/';

                    if (is_dir($dir) != true) {
                        mkdir($dir, 0777, true);
                    }

                    helper('text');
                    $fileName = random_string('alnum', 16);
                    $path = $fileName . '.' . $ext;
                    if (move_uploaded_file($file->getTempName(), $upload_dir . $path)) {
                        $uploaded = 1;
                        $fname = $fileName. '.' . $ext;
                        $url = $upload_dir2 . $path;
                    } else {
                        $uploaded = '0';
                        $message = ['message' => '파일 업로드 정보 업데이트에 실패 하였습니다.(Error102)'];
                    }
                }
            } else {
                $uploaded = '0';
                $message = ['message' => '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error103)'];
            }
        } else {
            $uploaded = '0';
            $message = ['message' => '파일이 선택되지 않았습니다. 다시 시도하여주세요.(Error104)'];
        }

        if ($uploaded == '1') {
            $return = [
                'uploaded' => '1',
                'fileName' => $fname,
                'url' => $url
            ];
        } else {
            $return = [
                'uploaded' => '0',
                'error' => $message
            ];
        }

        return $this->respond($return);

    }

}

