<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ApiController extends BaseController
{
    use ResponseTrait;

    public function Load_Mall_Log_List()
    {
        $code  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($code==''){
            $result = 'Error003';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else{
            $common_m = model('Common_m');
            $Rs = $common_m->Load_Mall_Log_All($code);
            if(fn_ArrayCnt($Rs)>0){
                $list = [];
                $tname = '';
                foreach ($Rs as $d){
                    if($d['typ']==1){
                        $tname = '주문수집';
                    }else if($d['typ']==2){
                        $tname = '클레임수집';
                    }
                    $content = ($d['content']=='') ? $content = 'API Token 인증 오류' : $d['content'];

                    $t_arr = [
                        'shoptyp' => $d['fk_shoptyp'],
                        'shop_name' => $d['sname'],
                        'status' => $d['status'],
                        'indate' =>$d['indate'],
                        'content' => $content
                    ];

                    $list[] = $t_arr;
                }

                $data = ['list' => $list];
                $result = 'ok';
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

    public function Load_Mall_List()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else{
            $common_m = model('Common_m');
            $Rs = $common_m->Load_Mall_List();
            if(fn_ArrayCnt($Rs)>0){
                $list = [];
                foreach ($Rs as $d){
                    $t_arr = [
                        'shoptyp' => $d['shoptyp'],
                        'shop_name' => $d['shop_name'],
                        'method' => $d['method'],
                        'shop_id' => $d['shop_id']
                    ];

                    $typ1 = $common_m->Load_Mall_Log($d['shoptyp'],1);
                    if(fn_ArrayCnt($typ1)>0){
                        $arr1 = [
                            'typ' => '주문수집',
                            'status' => $typ1[0]['status'],
                            'indate' => $typ1[0]['indate']
                        ];
                    }else{
                        $arr1 = ['typ'=>'','status'=>'','indate'=>''];
                    }

                    $typ1 = $common_m->Load_Mall_Log($d['shoptyp'],2);
                    if(fn_ArrayCnt($typ1)>0){
                        $arr2 = [
                            'typ' => '크레임수집',
                            'status' => $typ1[0]['status'],
                            'indate' => $typ1[0]['indate']
                        ];
                    }else{
                        $arr2 = ['typ'=>'','status'=>'','indate'=>''];
                    }

                    $t_arr['order'] = $arr1;
                    $t_arr['claim'] = $arr2;

                    $list[] = $t_arr;
                }

                $data = ['list' => $list];
                $result = 'ok';
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
                'quantity' => $info['quantity']
            ];

            $material_param = [];
            if(fn_ArrayCnt($info['material']) > 0){
                foreach($info['material'] as $d){
                    $mp_arr= [
                        'fk_gcode' => $gcode,
                        'fk_mtcode' => $d['gcode'],
                        'capacity' => $d['gcnt']
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
                    'gname' => $d['gsname'],
                    'category' => $d['category'],
                    'quantity' => $d['quantity'],
                    'inventory' => $d['inventory'],
                    'unit_weight' => $d['unit_weight']
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
            $newcode = fnMake_Code(11);
            $info_param = [
                'gcode' => $newcode,
                'fk_gscode' => $info['gscode'],
                'quantity' => $info['quantity']
            ];

            $material_param = [];
            if(fn_ArrayCnt($info['material']) > 0){
                foreach($info['material'] as $d){
                    $mp_arr= [
                        'fk_gcode' => $newcode,
                        'fk_mtcode' => $d['gcode'],
                        'capacity' => $d['gcnt']
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
                if(($Cnt<=0) || (fn_ArrayCnt($info_param) <= 0)){
                    $result = 'Error006';
                    $data = [];
                    $message = '데이터 등록에 실패 하였습니다.';
                }else{
                    $Cnt = $goods_m->Insert_Goods_Info($info_param);

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

    public function Delete_Goods(){
        $sessinarr = $this->GetSessionData();
        $code = ($this->request->getPost('code')=='') ?'':$this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($code===''){
            $result = 'Error003';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else{
            $goods_m = model('Goods_m');
            $Cnt = $goods_m->Delete_ProductDefault_Info($code);
            if($Cnt > 0){
                $result = 'ok';
                $data = [];
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

    public function Edit_Goods(){
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
            $gscode = $data['gscode'];
            $param = [
                'gsname' => $data['gsname'],
                'category' => $data['category'],
                'inventory' => $data['inventory'],
                'unit_weight' => $data['unit_weight'],
                't_cnt' => $data['t_cnt']
            ];
            $goods_m = model('Goods_m');
            $Cnt = $goods_m->Update_ProductDefault_Info($gscode,$param);
            if($Cnt > 0){
                $result = 'ok';
                $data = [];
                $message = '';
            }else{
                $result = 'Error004';
                $data = [];
                $message = '수정에 실패 하였습니다.';
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
                'gscode' =>$newCode,
                'gsname' => $data['gsname'],
                'category' => $data['category'],
                'inventory' => $data['inventory'],
                'unit_weight' => $data['unit_weight'],
                't_cnt' => $data['t_cnt']
            ];


            $goods_m = model('Goods_m');
            $NewSeq = $goods_m->Insert_ProductDefault_Info($param);
            if($NewSeq > 0){
                if($data['category']=='A001'){
                    $unitname = 'g';
                }else if($data['category']=='A002'){
                    $unitname = 'ea';
                }else if($data['category']=='A003'){
                    $unitname = 'g';
                }

                $param['unit_name'] =  $unitname;
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

    public function Delete_Goods_List()
    {
        $sessinarr = $this->GetSessionData();
        $code  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($code==''){
            $result = 'Error003';
            $data = [];
            $message = '잘못된 접근입니다.';
        }else{
            $good_m = model('Goods_m');
            $dRs = $good_m->Delete_Goods_Data($code);
            if($dRs[0]['status']===0){
                $result = 'Error004';
                $data = [];
                $message = 'BOM 삭제에 실패 하였습니다.';
            }else{
                $i_arr = ['id' => $code];

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
                        'gname' => $d['gsname'],
                        'category' => $d['category'],
                        'c_str' => fnGetProductNameByCode($d['category']),
                        'quantity' => $d['quantity'],
                        'inventory' => $d['inventory'],
                        'completecnt' => $material_m->Cnt_Goods_InstructionsBygCode($d['gcode'],0),
                        'stepCnt' => $d['Cnt'],
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

    public function Load_Product()
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
            $mRs = $good_m->Load_Goods_Default($search);
            if(fn_ArrayCnt($mRs)>0){
                $material_m = model('Material_m');
                $m_arr = [];
                foreach ($mRs as $d) {

                    $cRs = $material_m->Load_Goods_statistics($d['gscode'],0);
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

                    if($d['category']=='A001'){
                        $unitname = 'g';
                    }else if($d['category']=='A002'){
                        $unitname = 'ea';
                    }else if($d['category']=='A003'){
                        $unitname = 'g';
                    }


                    $t_arr = [
                        'seq' => $d['seq'],
                        'gscode' => $d['gscode'],
                        'gsname' => $d['gsname'],
                        'category' => $d['category'],
                        'c_str' => fnGetProductNameByCode($d['category']),
                        'unit_name' => $unitname,
                        'gcode' => $d['gcode'],
                        'inventory' => $d['inventory'],
                        'unit_weight' => $d['unit_weight'],
                        't_cnt' => $d['t_cnt'],
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


//    public function Delete_Products(){
//        $sessinarr = $this->GetSessionData();
//        $code = ($this->request->getPost('code')=='') ?'':$this->request->getPost('code');
//        if($sessinarr['islogin']==false) {
//            $result = 'NoLogin';
//            $data = [];
//            $message = '로그인이 필요합니다.';
//        }else if(!Check_Token($sessinarr)) {
//            $result = 'Error002';
//            $data = [];
//            $message = '잘못된 토큰입니다.';
//        }else if($code===''){
//            $result = 'Error003';
//            $data = [];
//            $message = '잘못된 접근입니다.';
//        }else{
//            $goods_m = model('Goods_m');
//            $Cnt = $goods_m->Delete_ProductDefault_Info($code);
//            if($Cnt > 0){
//                $result = 'ok';
//                $data = [];
//                $message = '';
//            }else{
//                $result = 'Error004';
//                $data = [];
//                $message = '등록에 실패 하였습니다.';
//            }
//        }
//
//        $return = [
//            'result' => $result,
//            'info' => $data,
//            'message' => $message
//        ];
//        return $this->respond($return);
//    }


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
                        'bname' => $d['bname'],
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
                            $cookie = [
                                'name' => CK_LOGINKEEP,
                                'value' => $userid,
                                'expire' => 2147483647,
                                'domain' => CK_DOMAIN,
                                'path' => '/',
                                'prefix' => ''
                            ];
                            set_cookie($cookie);

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
                            delete_cookie(CK_LOGINKEEP, CK_DOMAIN, '/');
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
                            delete_cookie(CK_IDSAVE, CK_DOMAIN, '/');
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

//        $data = $this->request->getJSON(true) ?: [];
//        $data  = ($this->request->getPost('data') == '') ? '' : $this->request->getPost('data');
        $data = $this->request->getPost('data') ?? [];

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

//            $skey = array_key_exists('skey', $data) ? $data['skey'] : 'bello';
//            $fkey = array_key_exists('fkey', $data) ? $data['fkey'] : 0;


            $skey = $data['skey'] ?? '';
            $fkey = $data['fkey'] ?? 0;
            echo $skey;
            echo 'hello'.$fkey;

            $material_m = model('Material_m');

//            $mRs = ($skey=='') ? $material_m->Load_MaterialList_All() : $material_m->Load_Material_Search($skey);
            if ($skey == '' && $fkey == 0) {
                $mRs = $material_m->Load_MaterialList_All();
            } else if ($skey != '') {
                $mRs = $material_m->Load_Material_Search($skey);
            } else if ($fkey != '') {
                $mRs = $material_m->Load_Material_Filter($fkey);
            }

            $m_arr = [];
            foreach ($mRs as $d){
                $t_arr['seq'] = $d['seq'];
                $t_arr['mtcode'] = $d['mtcode'];
                $t_arr['typ'] = $d['typ'];
                $t_arr['typ_str'] = ($d['typ']==1) ? '원재료' : '부자재';
                $t_arr['mtname'] = $d['mtname'];
                $t_arr['fk_sucode'] = $d['fk_sucode'];
                $t_arr['fk_mkcode'] = $d['fk_mkcode'];
                $t_arr['inventory'] = $d['inventory'];
                $t_arr['uname'] = $d['unit_name'];

                $cRs = $material_m->Load_Material_statistics($d['mtcode']);
                if(fn_ArrayCnt($cRs)>0){
                    $nowstock = $cRs[0]['t_input'] - $cRs[0]['t_output'];
                    $t_arr['t_in'] = $cRs[0]['t_input'];
                    $t_arr['t_out'] = $cRs[0]['t_output'];
                    $t_arr['stock'] = $nowstock;
                    $t_arr['avg'] = $cRs[0]['avg_m_output'];
                    $t_arr['s_status'] = ($nowstock < $d['inventory']) ? 1 : 0;
                }else{
                    $t_arr['t_in'] = 0;
                    $t_arr['t_out'] = 0;
                    $t_arr['stock'] = 0;
                    $t_arr['avg'] = 0 ;
                    $t_arr['s_status'] = 0;
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


    public function Load_Maker(){
        $param  = ($this->request->getPost('data') == '') ? [] : $this->request->getPost('data');

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
            $skey = array_key_exists('skey', $param) ? $param['skey'] : '';
            $page = array_key_exists('page', $param) ? $param['page'] : 1;
            $limit = 15;
            $offset = ($page - 1) * $limit;
            $param = [
                'skey' => $skey,
                'limit' => $limit,
                'offset' => $offset,
            ];

            $material_m = model('Material_m');
//            $mRs = $material_m->Load_Maker_All($param);
            $mRs = ($skey=='') ? $material_m->Load_Maker_All($param) : $material_m->Load_Maker_Search($param);
            $m_arr = [];
            foreach ($mRs as $d){
                $t_arr['seq'] = $d['seq'];
                $t_arr['code'] = $d['code'];
                $t_arr['name'] = $d['name'];
                $t_arr['location'] = $d['location'];
                array_push($m_arr,$t_arr);
            }

            $t_cnt = $material_m->Cnt_Maker_All();

            $i_arr = [
                'list' => $m_arr,
                'tCnt' => $t_cnt
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


    public function Load_Maker_Each(){
        $code  = ($this->request->getPost('code') == '') ? [] : $this->request->getPost('code');

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
            $mRs = $material_m->Load_Maker_Each($code);
            $m_arr = [];
            foreach ($mRs as $d){
                $t_arr['seq'] = $d['seq'];
                $t_arr['code'] = $d['code'];
                $t_arr['name'] = $d['name'];
                $t_arr['location'] = $d['location'];
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

    public function Add_Maker_Info(){
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
            $NewCode = fnMake_Code(12);
            $param = [
                'code' => $NewCode,
                'name' => $data['name'],
                'location' => $data['location'],
            ];
            $Cnt = $material_m->Insert_Maker_Info($param);
            if($Cnt > 0){
                $mRs = $material_m->Load_Maker_Each($NewCode);
                if(fn_ArrayCnt($mRs)<=0){
                    $result = 'Error003';
                    $data = [];
                    $message = '존재하지 않는 제조사 입니다. ';
                }else {
                    $d = $mRs[0];
                    $m_arr = [
                        'seq' => $d['seq'],
                        'code' => $d['code'],
                        'name' => $d['name'],
                        'location' => $d['location'],
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

    public function Mod_Maker_Info(){

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
            $code = $data['code'];

            $param = [
                'name' => $data['name'],
                'location' => $data['location'],
            ];

            $material_m = model('Material_m');
            $mRs = $material_m->Load_Maker_Each($code);
            if(fn_ArrayCnt($mRs)>0){
                $Cnt = $material_m->Update_Maker_Info($code,$param);
                if($Cnt > 0){
                    $mRs = $material_m->Load_Maker_Each($code);
                    if(fn_ArrayCnt($mRs)<=0){
                        $result = 'Error003';
                        $data = [];
                        $message = '존재하지 않는 원자재 입니다. ';
                    }else {
                        $d = $mRs[0];
                        $m_arr = [
                            'code' => $d['code'],
                            'name' => $d['name'],
                            'location' => $d['location'],
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
                $message = '존재하지 않는 제조사 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

    public function Del_Maker_Info(){
        $code  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        $sessinarr = $this->GetSessionData();
        if(fn_ArrayCnt($code)==''){
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
            $mRs = $material_m->Load_Maker_Each($code);
            if(fn_ArrayCnt($mRs)>0){
                $Cnt = $material_m->Delete_Maker($code);
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
                $message = '존재하지 않는 제조사 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


    public function Load_Supplier(){
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
            $mRs = ($skey=='') ? $material_m->Load_Supplier_All() : $material_m->Load_Supplier_Search($skey);
            $m_arr = [];
            foreach ($mRs as $d){
                $t_arr['seq'] = $d['seq'];
                $t_arr['code'] = $d['code'];
                $t_arr['name'] = $d['name'];
                $t_arr['location'] = $d['location'];
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

    public function Add_Supplier_Info(){
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
            $NewCode = fnMake_Code(12);
            $param = [
                'code' => $NewCode,
                'name' => $data['name'],
                'location' => $data['location'],
            ];
            $Cnt = $material_m->Insert_Supplier_Info($param);
            if($Cnt > 0){
                $mRs = $material_m->Load_Supplier_Each($NewCode);
                if(fn_ArrayCnt($mRs)<=0){
                    $result = 'Error003';
                    $data = [];
                    $message = '존재하지 않는 공급사 입니다. ';
                }else {
                    $d = $mRs[0];
                    $m_arr = [
                        'seq' => $d['seq'],
                        'code' => $d['code'],
                        'name' => $d['name'],
                        'location' => $d['location'],
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


    public function Mod_Supplier_Info(){
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
            $code = $data['code'];
            $material_m = model('Material_m');
            $mRs = $material_m->Load_Supplier_Each($code);
            if(fn_ArrayCnt($mRs)>0){
                $param = [
                    'name' => $data['name'],
                    'location' => $data['location'],
                ];

                $Cnt = $material_m->Update_Supplier_Info($code,$param);
                if($Cnt > 0){
                    $mRs = $material_m->Load_Supplier_Each($code);
                    if(fn_ArrayCnt($mRs)<=0){
                        $result = 'Error003';
                        $data = [];
                        $message = '존재하지 않는 공급사 입니다. ';
                    }else {
                        $d = $mRs[0];
                        $m_arr = [
                            'code' => $d['code'],
                            'name' => $d['name'],
                            'location' => $d['location'],
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
                $message = '존재하지 않는 공급사 입니다. ';
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }



    public function Del_Supplier_Info(){
        $code  = ($this->request->getPost('code') == '') ? '' : $this->request->getPost('code');
        $sessinarr = $this->GetSessionData();
        if(fn_ArrayCnt($code)==''){
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
            $mRs = $material_m->Load_Supplier_Each($code);
            if(fn_ArrayCnt($mRs)>0){
                $Cnt = $material_m->Delete_Supplier($code);
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
                $message = '존재하지 않는 제조사 입니다. ';
            }
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
                    'uname' => $d['unit_name'],
                    'inventory' => $d['inventory'],
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
                'inventory' => $data['inventory']
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
                        'inventory' => $d['inventory'],
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
                    'inventory' => $data['inventory']
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
                            'inventory' => $d['inventory'],
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

    public function Upload_Multi_File()
    {
        $u_type  = $this->request->getPost('upload_type') ?: '1'; // 1:img,2:packing,3:excel
        $u_key   = $this->request->getPost('upload_key') ?: 'files'; // input name
        $timeNow = date("Ymd");

        if ($u_type == 1) { // 이미지
            $dir = FCPATH ."uploads/goods/$timeNow";
            $dir2 = FCPATH ."uploads/goods/$timeNow";
        }else if ($u_type == 2) { //packing img
            $dir = FCPATH ."uploads/packing/$timeNow";
            $dir2 = FCPATH ."uploads/packing/$timeNow";
            $opcode = ($this->request->getPost('opcode')=='') ? '' : $this->request->getPost('opcode');
            $order_m = model('Order_m');
        } else if ($u_type == 3) { // 엑셀
            $dir = FCPATH ."uploads/excel/$timeNow";
            $dir2 = FCPATH ."uploads/excel/$timeNow";
        } else {
            return $this->respond(['result' => 'error', 'message' => '올바르지 않은 업로드 타입']);
        }

        $allow = 'jpg,jpeg,gif,png,xls,xlsx';
        $allowed_extensions = explode(',', $allow);
        $max_file_size = 5242880; // 5MB

        $files = $this->request->getFiles();
        $uploadedFiles = [];
        $errors = [];

        if (isset($files[$u_key]) && is_array($files[$u_key])) {
            foreach ($files[$u_key] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $filename = $file->getName();
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $size = $file->getSize();

                    // 유효성 검사
                    if (!in_array($ext, $allowed_extensions)) {
                        $errors[] = $filename . ': 확장자 불가';
                        continue;
                    }

                    if ($size > $max_file_size) {
                        $errors[] = $filename . ': 파일 크기 초과';
                        continue;
                    }

                    // 디렉토리 생성
                    $upload_dir = $dir . '/';
                    $upload_dir2 = $dir2 . '/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    // 고유 파일명 생성
                    helper('text');
                    $fileName = random_string('alnum', 16);
                    $path = $fileName . '.' . $ext;

                    if (move_uploaded_file($file->getTempName(), $upload_dir . $path)) {
                        $uploadedFiles[] = [
                            'fileName' => $fileName . '.' . $ext,
                            'url' => $upload_dir2 . $path,
                            'originalName' => $filename,
                            'size' => fn_Str_File_Sise($size)
                        ];

                        if($opcode!=''){
                            $param = [
                                'opcode' => $opcode,
                                'typ' => 1,
                                'fname' => $fileName . '.' . $ext
                            ];
                            $Cnt = $order_m->Insert_Order_delivery_file($opcode,$param);
                        }
                    } else {
                        $errors[] = $filename . ': 저장 실패';
                    }
                } else {
                    $errors[] = '파일 오류';
                }
            }
        } else {
            return $this->respond([
                'result' => 'error',
                'message' => '파일이 선택되지 않았습니다.'
            ]);
        }

        // 응답 생성
        if (empty($errors) && !empty($uploadedFiles)) {
            return $this->respond([
                'result' => 'ok',
                'info' => [
                    'uploaded' => count($uploadedFiles),
                    'total' => count($files[$u_key] ?? []),
                    'files' => $uploadedFiles
                ],
                'message' => ''
            ]);
        } else {
            return $this->respond([
                'result' => 'error',
                'info' => [
                    'uploaded' => count($uploadedFiles),
                    'total' => count($files[$u_key] ?? []),
                    'files' => $uploadedFiles
                ],
                'message' => implode('; ', $errors)
            ]);
        }
    }

    public function Upload_File()
    {

        $u_type  = ($this->request->getPost('upload_type') == '') ? '1' : $this->request->getPost('upload_type'); //1이면 img 3이면 exel파일
        $u_key  = ($this->request->getPost('upload_key') == '') ? '1' : $this->request->getPost('upload_key'); // input type
        $timeNow = date("Ymd");
        if($u_type==1) {//상품등록시 대표이미지
            $dir = FCPATH."uploads/goods/$timeNow";
            $dir2 = FCPATH."uploads/goods/$timeNow";
            $key = $u_key;
        }else if($u_type==3) {//상품등록시 대표이미지
            $dir = FCPATH."uploads/excel/$timeNow";
            $dir2 = FCPATH."uploads/excel/$timeNow";
            $key = $u_key;
        }

        $allow = 'jpg,jpeg,gif,png,xls,xlsx';
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

    public function Insert_Excel(){
        $sessinarr = $this->GetSessionData();
        $f_url  = ($this->request->getPost('url') == '') ? '1' : $this->request->getPost('url'); //
        $f_typ  = ($this->request->getPost('typ') == '') ? '1' : $this->request->getPost('typ'); // 원자재/제품/상품 구분
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if(($f_url=='') || ($f_typ=='')) {
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else{
            $filePath = './.' . $f_url;
            if (!is_file($filePath)) {
                $result = 'Error004';
                $data = [];
                $message = '파일이 존재하지 않습니다.';
            }else {

                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();
                if($f_typ==1) {//제조사 엑셀등록
                    $insert_arr = [];
                    foreach ($rows as $i => $row) {
                        $t_arr = [
                            'code' => fnMake_Code(12),
                            'name' => $row[1], // 이름
                            'location' => $row[2] // 값
                        ];
                        array_push($insert_arr, $t_arr);
                    }

                    if(fn_ArrayCnt($insert_arr)>0) {
                        $material_m = model('Material_m');
                        $Cnt = $material_m->Insert_Maker_All($insert_arr);
                        if ($Cnt > 0) {
                            $result = 'ok';
                            $data = ['t_Cnt' => $Cnt];
                            $message = '';
                        } else {
                            $result = 'Error005';
                            $data = [];
                            $message = '';
                        }
                    }else{
                        $result = 'Error006';
                        $data = [];
                        $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                    }

                } else if($f_typ==2) { //공급사엑셀등록
                    $insert_arr = [];
                    foreach ($rows as $i => $row) {
                        $t_arr = [
                            'code' => fnMake_Code(13),
                            'name' => $row[1],
                            'location' => $row[2]
                        ];
                        array_push($insert_arr,$t_arr);
                    }

                    if(fn_ArrayCnt($insert_arr)>0) {
                        $material_m = model('Material_m');
                        $Cnt = $material_m->Insert_Supplier_All($insert_arr);
                        if ($Cnt > 0) {
                            $result = 'ok';
                            $data = ['t_Cnt' => $Cnt];
                            $message = '';
                        } else {
                            $result = 'Error005';
                            $data = [];
                            $message = '';
                        }
                    }else{
                        $result = 'Error006';
                        $data = [];
                        $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                    }
                }else if($f_typ==3) {//원자재 액셀등록
                    $insert_arr = [];
                    foreach ($rows as $i => $row) {
                        $t_arr = [
                            'mtcode' => fnMake_Code(3),
                            'mtname' => $row[1],
                            'fk_mkcode' => $row[2],
                            'fk_sucode' => $row[3],
                            'inventory' => $row[4],
                            'unit_name' => $row[5],
                            'typ' => $row[6]
                        ];
                        array_push($insert_arr,$t_arr);
                    }

                    if(fn_ArrayCnt($insert_arr)>0) {
                        $material_m = model('Material_m');
                        $Cnt = $material_m->Insert_Material_All($insert_arr);
                        if ($Cnt > 0) {
                            $result = 'ok';
                            $data = ['t_Cnt' => $Cnt];
                            $message = '';
                        } else {
                            $result = 'Error005';
                            $data = [];
                            $message = '';
                        }
                    }else{
                        $result = 'Error006';
                        $data = [];
                        $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                    }
                } else if($f_typ==4) {//제품엑셀등록
                    $insert_arr = [];
                    foreach ($rows as $i => $row) {
                        if($row[1]!='') {
                            $t_arr = [
                                'gscode' => fnMake_Code(2),
                                'category' => $row[0],
                                'gsname' => $row[1],
                                'inventory' => $row[2],
                                'unit_weight' => $row[3],
                                't_cnt' => $row[4]
                            ];

                            $insert_arr[]= $t_arr;
                        }
                    }
                    if(fn_ArrayCnt($insert_arr)>0) {
                        $goods_m = model('Goods_m');
                        $Cnt = $goods_m->Insert_Goods_All($insert_arr);
                        if ($Cnt > 0) {
                            $result = 'ok';
                            $data = ['t_Cnt' => $Cnt];
                            $message = '';
                        } else {
                            $result = 'Error005';
                            $data = [];
                            $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                        }
                    }else{
                        $result = 'Error006';
                        $data = [];
                        $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                    }
                } else if($f_typ==5) {//상품엑셀등록
                    $insert_arr = [];
                    foreach ($rows as $i => $row) {
                        if($row[1]!='') {
                            $t_arr = [
                                'pdcode' => fnMake_Code(9),
                                'pdname' => $row[1],
                                'pdcategory' => $row[0],
                                'pdprice' => $row[3],
                                'pdweigth' => $row[2],
                                'content' => ''
                            ];

                            $insert_arr[] = $t_arr;
                        }
                    }
                    //print_r($insert_arr);
                    if(fn_ArrayCnt($insert_arr)>0) {
                        $product_m = model('Product_m');
                        $Cnt = $product_m->Insert_Product_All($insert_arr);
                        if ($Cnt > 0) {
                            $result = 'ok';
                            $data = ['t_Cnt' => $Cnt];
                            $message = '';
                        } else {
                            $result = 'Error005';
                            $data = [];
                            $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
                        }
                    }else{
                        $result = 'Error006';
                        $data = [];
                        $message = '업로드하신 엑셀파일에서 적용된 내용 없습니다.';
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



}

