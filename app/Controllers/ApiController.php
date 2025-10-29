<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiController extends BaseController
{
    use ResponseTrait;

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
            $produce_m = model('Produce_m');
            $mRs = $produce_m->Load_Produce_List_All($search);
            if(fn_ArrayCnt($mRs)>0){
                $m_arr = [];
                foreach ($mRs as $d) {
                    $t_arr = [
                        'seq' => $d['seq'],
                        'gcode' => $d['fk_gcode'],
                        'gname' => $d['gname'],
                        'category' => $d['category'],
                        'catestr' => fnGetProductNameByCode($d['category']),
                        'quantity' => $d['quantity'],
                        'step_now' => $d['step_now'],
                        'is_complete' => $d['is_complete'],
                        'step_cnt' => $d['Cnt']
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


    public function Add_Goods_Instructions()
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
        }else{
            $param = [
                'fk_gcode' => $code,
                'quantity' => $cnt
            ];

            $goods_m = model('Goods_m');
            $Cnt = $goods_m->Insert_Goods_Instructions($param);
            if($Cnt > 0){

                $i_arr = [
                    'seq' => $Cnt
                ];

                $result = 'ok';
                $data = $i_arr;
                $message = '';
            }else{
                $result = 'Error004';
                $data = [];
                $message = '지시서 발급에 실패 하였습니다. ';
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
                        'fk_mcode' => $d['code'],
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
                                    'stepNum' => $a['stepNum'],
                                    'fk_mcode' => $s['acode'],
                                    'capacity' => $s['acnt']
                                ];

                                array_push($step_marerial,$mt_arr);
                            }
                        }
                    }
                }
            }

            if(fn_ArrayCnt($step_marerial)<=0){
                $result = 'Error003';
                $data = [];
                $message = '데이터 등록에 실패 하였습니다.';
            }else{
                $goods_m = model('Goods_m');
                $Cnt = $goods_m->Insert_Goods_Step_Material($step_marerial);
                if(($Cnt<=0) || (fn_ArrayCnt($step_info) <= 0)){
                    $result = 'Error004';
                    $data = [];
                    $message = '데이터 등록에 실패 하였습니다.';
                }else{
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

                            $i_arr = [
                                'code' => $newcode
                            ];

                            $result = 'ok';
                            $data = $i_arr;
                            $message = '';
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


    public function Load_Goods_List()
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
            $material_m = model('Material_m');
            $mRs = $material_m->Load_Goods_List($search);
            if(fn_ArrayCnt($mRs)>0){
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
                $t_arr['mcode'] = $d['mcode'];
                $t_arr['typ'] = $d['typ'];
                $t_arr['typ_str'] = ($d['typ']==1) ? '원재료' : '부자재';
                $t_arr['mname'] = $d['mname'];
                $t_arr['fk_sucode'] = $d['fk_sucode'];
                $t_arr['fk_macode'] = $d['fk_macode'];
                $t_arr['uname'] = $d['unit_name'];

                $cRs = $material_m->Load_Material_statistics($d['mcode']);
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
                    'code' => $d['mcode'],
                    'typ' => $d['typ'],
                    'name' => $d['mname'],
                    'scode' => $d['fk_scode'],
                    'sname' => $d['fk_sname'],
                    'mcode' => $d['fk_mcode'],
                    'mname' => $d['fk_mname'],
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
            $NewCode = fnMake_Code(1,$material_m->Load_Material_MaxCode());
            $param = [
                'mcode' => $NewCode,
                'typ' => $data['typ'],
                'mname' => $data['mname'],
                'fk_sucode' => $data['supply'],
                'fk_macode' => $data['maker'],
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
                        'code' => $d['mcode'],
                        'typ' => $d['typ'],
                        'name' => $d['mname'],
                        'typ_str' => ($d['typ']==1) ? '원재료' : '부자재',
                        'scode' => $d['fk_sucode'],
                        'sname' => $d['fk_sname'],
                        'mcode' => $d['fk_macode'],
                        'mname' => $d['fk_mname'],
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
                    'mname' => $data['mname'],
                    'fk_scode' => $data['supply'],
                    'fk_mcode' => $data['maker'],
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
                            'code' => $d['mcode'],
                            'typ' => $d['typ'],
                            'name' => $d['mname'],
                            'typ_str' => ($d['typ']==1) ? '원재료' : '부자재',
                            'scode' => $d['fk_scode'],
                            'sname' => $d['fk_sname'],
                            'mcode' => $d['fk_mcode'],
                            'mname' => $d['fk_mname'],
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


}

