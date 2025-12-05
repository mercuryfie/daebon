<?php

function getOrderStatusName($step) {
    switch($step) {
        case 0:
            return '미확인';
        case 1:
            return '결제확인중';
        case 2:
            return '제품확인';
        case 3:
            return '배송준비';
        case 4:
            return '배송시작';
        case 5:
            return '배송완료';
        case 6:
            return '취소';
        case 7:
            return '반품시작';
        case 8:
            return '반품완료';
        case 9:
            return '교환시작';
        case 10:
            return '교환완료';
        default:
            return '';
    }
}


function List_ExCode() {
    return [
        'type0' => '자체',
        'type1' => '쿠팡',
        'type2' => '옥션',
        'type3' => '지마켓'
    ];
}

function opt_Excode($select) {
    $arr = List_ExCode();
    $str = '';
    foreach ($arr as $key => $value) {
        $selected = ($select === $key) ? ' selected' : '';
        $str .= "<option value=\"{$key}\" {$selected}>{$value}</option>";
    }
    return $str;
}


function fn_Load_Process_Code($model,$gicode,$stepNum){
    $aRs = $model->Load_Instructions_NowProcess($gicode, $stepNum);
    if(fn_ArrayCnt($aRs)>0){
        $prcode = $aRs[0]['fk_prcode'];
    }else{
        $prcode = $aRs[0]['fk_prcode'];
    }
    return $prcode;
}


function fn_Check_CompleteProcess($model,$gicode){
    $totalCnt = $model->Cnt_Instructions_Process(1, $gicode);
    $endCnt = $model->Cnt_Instructions_Process(3, $gicode);

    if ($totalCnt > $endCnt) {
        $bool = false;
    } else {
        $bool = true;
    }

    return $bool;
}


//반제품 입고처리
function fn_Input_SemiProduct($model,$gicode,$prcode,$weight){
    $pscode = fnMake_Code(7);
    $semi = [
        'pscode' => $pscode,
        'fk_gicode' => $gicode,
        'fk_prcode' => $prcode,
        'm_input' => $weight,
        'm_output' => 0
    ];
    $Cnt = $model->Insert_SemiProduct($semi);

    $r_arr =[
        'pscode' => $pscode,
        'cnt' => $Cnt
    ];
    return $r_arr;
}

function fn_OutPut_SemiProduct($model,$gicode,$prcode,$pscode){
    $cRs = $model->Load_SemiProduct_Info($pscode,1);
    if(fn_ArrayCnt($cRs)<=0){
        $Cnt = 0;
        $pscode = '';
    }else {
        $weight = $cRs[0]['m_input'];
        $semi = [
            'pscode' => $pscode,
            'fk_gicode' => $gicode,
            'fk_prcode' => $prcode,
            'm_input' => 0,
            'm_output' => $weight
        ];
        $Cnt = $model->Insert_SemiProduct($semi);
    }

    $r_arr =[
        'pscode' => $pscode,
        'cnt' => $Cnt
    ];
    return $r_arr;
}


function fn_Input_FinalProduct($model,$gicode,$weight){
    $gdcode = fnMake_Code(8);
    $param = [
        'gdcode' => $gdcode,
        'fk_gicode' => $gicode,
        'g_input' => $weight,
        'g_output' => 0
    ];
    $Cnt = $model->Insert_FinalProduct($param);

    $r_arr =[
        'gdcode' => $gdcode,
        'cnt' => $Cnt
    ];
    return $r_arr;
}

function fn_Input_ProcessWorker($model,$gicode,$prcode,$uid,$wtyp){
    $param = [
        'fk_gicode' => $gicode,
        'fk_prcode' => $prcode,
        'uid' => $uid,
        'typ' => $wtyp
    ];
    $Cnt = $model->Insert_Instructions_Worker($param);

    return $Cnt;
}

function fn_GetInstructions_NowStep($model,$gicode){
    $nowprcode = '';
    $cRs = $model->Load_Instructions_Info($gicode);
    if(fn_ArrayCnt($cRs)>0){
        if($cRs[0]['is_complete']==2){
            $nowprcode = 'complete';
        }else {
            $stepNum = $cRs[0]['step_now'];
            $pRs = $model->Load_Instructions_NowProcess($gicode, $stepNum);
            if (fn_ArrayCnt($pRs) > 0) {
                $nowprcode = $pRs[0]['fk_prcode'];
            }
        }
    }
    return $nowprcode;
}

function fn_GetInstructions_Step($model,$gicode,$workeruid){
    $nowprcode = '';
    $data = [];
    $cRs = $model->Load_Instructions_Info($gicode);
    if(fn_ArrayCnt($cRs)>0) {
        $iscomplete = $cRs[0]['is_complete'];
        $stepnow = $cRs[0]['step_now'];
        $stepsubnow = $cRs[0]['step_sub_now'];
        if ($iscomplete==2) {//완료됨
            $nowprcode = 'complete';
        }else if($stepnow == 0) {//시작안함
            $aRs = $model->Load_Instructions_NowProcess($gicode, 1);
            if (fn_ArrayCnt($aRs) > 0) {
                $nowprcode = $aRs[0]['fk_prcode'];
                $Cnt = fn_Input_ProcessWorker($model, $gicode, $nowprcode, $workeruid, 1);
                $param = ['status' => 1];
                $Cnt = $model->Update_Instructions_Process($gicode, $nowprcode, $param);
                $param = ['is_complete' => 1, 'step_now' => 1, 'step_sub_now' => 0];
                $Cnt = $model->Update_Instructions_Info($gicode, $param);
                $data = $aRs[0];
            }
        }else{
            if ($stepsubnow == 0) {
                $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                if (fn_ArrayCnt($aRs) > 0) {
                    $nowprcode = $aRs[0]['fk_prcode'];
                    $data = $aRs[0];
                }
            }else if ($stepsubnow == 1) {
                $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                if (fn_ArrayCnt($aRs) > 0) {
                    $nowprcode = $aRs[0]['fk_prcode'];
                    $data = $aRs[0];
                }
            }else if ($stepsubnow == 2) {//시작했는데 종료됬음
                $stepnow = $stepnow + 1;
                $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                if (fn_ArrayCnt($aRs) > 0) {
                    $nowprcode = $aRs[0]['fk_prcode'];
                    $Cnt = fn_Input_ProcessWorker($model, $gicode, $nowprcode, $workeruid, 1);
                    $param = ['status' => 1];
                    $Cnt = $model->Update_Instructions_Process($gicode, $nowprcode, $param);
                    $param = ['step_now' => $stepnow, 'step_sub_now' => 0];
                    $Cnt = $model->Update_Instructions_Info($gicode, $param);
                    $data = $aRs[0];
                }
            }
        }
    }

    if(fn_ArrayCnt($cRs)>0){
        if(($nowprcode!='') || ($nowprcode!='complete')) {
            $w_arr = fn_LoadInstructionsWorker($model, $gicode, $nowprcode);
            if ($data['status'] == '0') {
                $worker = [
                    'name' => '',
                    'actdate' => ''
                ];
            }else if ($data['status'] == '1') {
                $worker = [
                    'name' => $w_arr['start']['name'],
                    'actdate' => $w_arr['start']['actdate']
                ];
            } else if ($data['status'] == '2') {
                $worker = [
                    'name' => $w_arr['end']['name'],
                    'actdate' => $w_arr['end']['actdate']
                ];
            }
            $data['worker_arr'] = $worker;
            $p_arr = fnGetProcessNameByCode($data['step_typ']);
            $data['p_type'] = $p_arr;
        }else{
            $data['worker_arr'] = [];
            $data['p_type'] = [];
        }



        $info = $cRs[0];

        $mRs = $model->Load_Instructions_Step_Material($gicode,$stepnow);
        $step_material = [];
        if(fn_ArrayCnt($mRs)>0){
            foreach($mRs as $f){
                $t_arr = [
                    'mtname' => $f['mtname'],
                    'capacity' => $f['capacity']
                ];
                array_push($step_material,$t_arr);
            }

            $data['material'] = $step_material;
        }else{
            $data['material'] = [];
        }



    }

    $r_arr = [
        'prcode' =>$nowprcode,
        'info' => $info,
        'data' => $data
    ];

    return $r_arr;
}

function fn_getPrcodeByStepNum(array $step_info, $stepNum) {
    foreach ($step_info as $item) {
        if (isset($item['stepNum']) && $item['stepNum'] == $stepNum) {
            return isset($item['prcode']) ? $item['prcode'] : null;
        }
    }
    return null;
}

function fn_Load_NowStep($model,$param){
    $iscomplete = $param['iscomplete'];
    $gicode = $param['gicode'];
    $nowprcode = $param['prcode'];
    $stepnow = $param['stepnow'];

    $prcode = '';
    $stepNum = '';
    $p_step = '';
    $p_str = '';
    $worker = '';

    if($iscomplete==2){
        $prcode = '';
        $p_step = '-';
        $p_str = '완료';
        $worker = '';
        $stepNum = '';
    }else if($stepnow>0){
        $cRs = $model->Load_Instructions_Process_Info($gicode, $nowprcode);
        if(fn_ArrayCnt($cRs)>0){
            $a = $cRs[0];
            $prcode = $a['fk_prcode'];
            if($a['status']==0) {
                $p_step = $a['step_name'];
                $stepNum = $a['stepNum'];
                $p_str = '공정대기중';
                $worker = '';
            }else if($a['status']==1){
                $p_step = $a['step_name'];;
                $stepNum = $a['stepNum'];
                $p_str = '공정진행중';
                $worker = $a['worker'];
            }else if($a['status']==2) {
                $p_step = $a['step_name'];;
                $stepNum = $a['stepNum'];
                $p_str = '공정대기중';
                $worker = $a['worker'];
            }
        }
    }else{
        $cRs = $model->Load_Instructions_NowProcess($gicode,1);
        if (fn_ArrayCnt($cRs) > 0) {
            $a = $cRs[0];
            $prcode = $a['fk_prcode'];
            if ($a['status'] == 0) {
                $p_step = $a['step_name'];
                $stepNum = $a['stepNum'];
                $p_str = '공정대기중';
                $worker = '';
            } else if ($a['status'] == 1) {
                $p_step = $a['step_name'];;
                $stepNum = $a['stepNum'];
                $p_str = '공정진행중';
                $worker = $a['worker'];
            } else if ($a['status'] == 2) {
                $p_step = $a['step_name'];;
                $stepNum = $a['stepNum'];
                $p_str = '공정대기중';
                $worker = $a['worker'];
            }
        }
    }
    $r_arr = [
        'prcode'=> $prcode,
        'stepNum'=> $stepNum,
        'step' => $p_step,
        'str' => $p_str,
        'worker' => $worker

    ];

    return $r_arr;
}



function fn_LoadInstructionsWorker($model,$gicode,$prcode){
    $retarr = [];
    $start_arr = [];
    $pRs = $model->Load_Instructions_Worker($gicode,$prcode,1);
    if(fn_ArrayCnt($pRs)>0){
        $start_arr = [
            'uid' => $pRs[0]['uid'],
            'name' => $pRs[0]['name'],
            'actdate' => $pRs[0]['actdate']
        ];
    }else{
        $start_arr = [
            'uid' => '',
            'name' => '',
            'actdate' => ''
        ];
    }

    $end_arr = [];
    $rRs = $model->Load_Instructions_Worker($gicode,$prcode,2);
    if(fn_ArrayCnt($rRs)>0){
        $end_arr = [
            'uid' => $pRs[0]['uid'],
            'name' => $pRs[0]['name'],
            'actdate' => $pRs[0]['actdate']
        ];
    }else{
        $end_arr = [
            'uid' => '',
            'name' => '',
            'actdate' => ''
        ];
    }

    $retarr = [
        'start' => $start_arr,
        'end' => $end_arr
    ];
    return $retarr;
}


function fn_LoadInstructionsSingleProcess($model,$gicode,$prcode){
    $retarr = [];
    $pRs = $model->Load_Instructions_Process_Info($gicode,$prcode);
    if(fn_ArrayCnt($pRs)>0){
        $d = $pRs[0];
        $cRs = $model->Load_Instructions_Step_Material($gicode,$d['stepNum']);
        $step_material = [];
        if(fn_ArrayCnt($cRs)>0){
            foreach($cRs as $f){
                $t_arr = [
                    'mtname' => $f['mtname'],
                    'capacity' => $f['capacity']
                ];
                array_push($step_material,$t_arr);
            }
        }

        $retarr = [
            'fk_gicode' => $d['fk_gicode'],
            'fk_prcode' => $d['fk_prcode'],
            'fk_gcode' => $d['fk_gcode'],
            'stepNum' => $d['stepNum'],
            'step_typ' => $d['step_typ'],
            'step_name' => $d['step_name'],
            'input_material' => $d['input_material'],
            'output_material' => $d['output_material'],
            'semi_code' => $d['semi_code'],
            'start_weight' => $d['start_weight'],
            'end_weight' => $d['end_weight'],
            'p_method' => $d['p_method'],
            'status' => $d['status'],
            'indate' => $d['indate'],
            'shortdate' => fn_Short_Date($d['indate']),
            'material' => $step_material,
            'worker' => fn_LoadInstructionsWorker($model,$gicode,$prcode)
        ];
    }
    return $retarr;
}


function fn_LoadInstructionsProcess($model,$gicode){
    $retarr = [];
    $pRs = $model->Load_Instructions_Process($gicode);
    if(fn_ArrayCnt($pRs)>0){
        foreach($pRs as $d){
            $cRs = $model->Load_Instructions_Step_Material($gicode,$d['stepNum']);
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

            $a_arr = [
                'fk_gicode' => $d['fk_gicode'],
                'fk_prcode' => $d['fk_prcode'],
                'fk_gcode' => $d['fk_gcode'],
                'stepNum' => $d['stepNum'],
                'step_typ' => $d['step_typ'],
                'step_name' => $d['step_name'],
                'input_material' => $d['input_material'],
                'output_material' => $d['output_material'],
                'semi_code' => $d['semi_code'],
                'start_weight' => $d['start_weight'],
                'end_weight' => $d['end_weight'],
                'p_method' => $d['p_method'],
                'status' => $d['status'],
                'indate' => $d['indate'],
                'shortdate' => fn_Short_Date($d['indate']),
                'material' => $step_material,
                'worker' => fn_LoadInstructionsWorker($model,$gicode,$d['fk_prcode'])
            ];

            array_push($retarr,$a_arr);
        }
    }
    return $retarr;
}

function fn_LoadInstructionsMaterial($model,$code){
    $retarr = [];
    $mtRs = $model->Load_Instructions_Material($code);
    if(fn_ArrayCnt($mtRs)>0){
        foreach ($mtRs as $d){
            $t_arr = [
                'fk_gicode' => $d['fk_gicode'],
                'fk_gcode' => $d['fk_gcode'],
                'fk_mtcode' => $d['fk_mtcode'],
                'capacity' => $d['capacity'],
                'mtname' => $d['mtname'],
                'maker' => $d['fk_mkname'],
                'supply' => $d['fk_suname']
            ];

            array_push($retarr,$t_arr);
        }
    }
    return $retarr;
}

function fn_LoadInstructionsInfo($model,$gicode){
    $retarr = [];
    $pRs = $model->Load_Instructions_Info($gicode);
    if(fn_ArrayCnt($pRs)>0){
        $d = $pRs[0];
        $param = [
            'iscomplete' => $d['is_complete'],
            'gicode' => $d['gicode'],
            'prcode' => $d['nowprcode'],
            'stepnow' => $d['step_now']
        ];
        $p_arr = fn_Load_NowStep($model,$param);

        $retarr = [
            'gicode' => $d['gicode'],
            'fk_gcode' => $d['fk_gcode'],
            'gname' => $d['gname'],
            'writer' => '관리자',
            'category' => $d['category'],
            'catestr' => fnGetProductNameByCode($d['category']),
            'icnt' => $d['icnt'],
            'quantity' => $d['quantity'],
            'inventory' => $d['inventory'],
            'step_cnt' => $d['Cnt'],
            'step_now' => $d['step_now'],
            'indate' => $d['indate'],
            'processname' => $p_arr['step'],
            'processstr' => $p_arr['str']
        ];


    }
    return $retarr;
}


function fnGetProcessNameByCode($code) {
    $products = fnProcess_Arr();
    foreach ($products as $p) {
        if ($p['code'] === $code) {
            $arr = [
                'name' => $p['name'],
                'typ' => $p['typ'],
                'gubun' => $p['gubun']
            ];

            return $arr;
        }
    }
    return null;
}


function fnMake_Process_Type($cval){
    $html = '';
    $t_arr = fnProcess_Arr();

    foreach ($t_arr as $d) {
        if ($cval == $d['code']) {
            $html .= "<option value='{$d['code']}' selected data-type='{$d['typ']}'>{$d['name']}</option>";
        } else {
            $html .= "<option value='{$d['code']}' data-type='{$d['typ']}'>{$d['name']}</option>";
        }
    }
    return $html;
}

function fnProcess_Arr(){
    $t_arr = [
        ['code' => 'P001', 'name' => '계량' , 'typ' => 1, 'gubun'=> 1],
        ['code' => 'P002', 'name' => '세척' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P003', 'name' => '건조' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P004', 'name' => '이물검사' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P005', 'name' => '파쇄(조분쇄)' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P006', 'name' => '로스팅' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P007', 'name' => '전동진동채(이물제거)' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P008', 'name' => '삼각티백/내외포장' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P009', 'name' => '금속이물탐지' , 'typ' => 1, 'gubun'=> 2],
        ['code' => 'P010', 'name' => '외포장' , 'typ' => 1, 'gubun'=> 2]
    ];

    return $t_arr;
}


function fnMake_Material_option($cval,$typ)
{
    $html = '';
    $material_m = model('Material_m');
    $cRs = $material_m->Load_MaterialList_Type($typ);
    if(fn_ArrayCnt($cRs)>0) {
        foreach ($cRs as $d) {
            if ($cval == $d['mtcode']) {
                $html .= "<option value='{$d['mtcode']}' selected>{$d['mtname']}</option>";
            } else {
                $html .= "<option value='{$d['mtcode']}'>{$d['mtname']}</option>";
            }
        }
    }else{
        $html = '';
    }
    return $html;
}

function fnGetProductNameByCode($code) {
    $products = fnProducts_Arr();
    foreach ($products as $p) {
        if ($p['code'] === $code) {
            return $p['name'];
        }
    }
    return null;
}

function fnProducts_Arr(){
    $t_arr = [
        ['code' => 'A001', 'name' => '원물볶음차'],
        ['code' => 'A002', 'name' => '삼각티백차'],
        ['code' => 'A003', 'name' => '연고농장 삼각티백차'],
        ['code' => 'A004', 'name' => '티플레이스'],
    ];

    return $t_arr;
}

function fnMake_Products_Type($cval){
    $html = '';
    $t_arr = fnProducts_Arr();

    foreach ($t_arr as $d) {
        if ($cval == $d['code']) {
            $html .= "<option value='{$d['code']}' selected>{$d['name']}</option>";
        } else {
            $html .= "<option value='{$d['code']}'>{$d['name']}</option>";
        }
    }
    return $html;
}


function fnMake_Code($typ,$max=''){
    $newCode = '';
    if($typ==1){
        if($max=='') {
            $newCode = 'MA001';
        }else{
            $prefix = 'MA';
            $numberPart = substr($max, strlen($prefix));
            $incrementedNumber = str_pad((int)$numberPart + 1, strlen($numberPart), '0', STR_PAD_LEFT);
            $newCode = $prefix . $incrementedNumber;
        }
    }else if($typ==2){//BOM 코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DB'. $timeNow.$rnd;
    }else if($typ==3){//원자재코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'MT'. $timeNow.$rnd;
    }else if($typ==4){//공정코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DP'. $timeNow.$rnd;
    }else if($typ==5){//지시서코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DI'. $timeNow.$rnd;
    }else if($typ==6){//지시서공정코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DIP'. $timeNow.$rnd;
    }else if($typ==7){//반제품코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DSI'. $timeNow.$rnd;
    }else if($typ==8){//완제품코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DG'. $timeNow.$rnd;
    }else if($typ==9){//상품코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(1000, 9999);
        $newCode = 'DBG'. $timeNow.$rnd;
    }else if($typ==10){//주문코드
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'DR'. $timeNow.$rnd;
    }

    return $newCode;
}

function fnMake_Material_Type($cval=''){
    $html = '';
    $t_arr = [
        ['typ' => '1', 'name' => '원자재'],
        ['typ' => '2', 'name' => '부자재']
    ];

    foreach ($t_arr as $d) {
        if ($cval == $d['typ']) {
            $html .= "<option value='{$d['typ']}' selected>{$d['name']}</option>";
        } else {
            $html .= "<option value='{$d['typ']}'>{$d['name']}</option>";
        }
    }
    return $html;
}

function fnMake_Material_Unit($cval=''){
    $html = '';
    $t_arr = [
        ['typ' => 'g', 'name' => 'g'],
        ['typ' => 'box', 'name' => 'box'],
        ['typ' => 'ea', 'name' => 'ea'],
        ['typ' => '파우치', 'name' => '파우치'],
        ['typ' => '티백', 'name' => '티백']
    ];

    foreach ($t_arr as $d) {
        if ($cval == $d['typ']) {
            $html .= "<option value='{$d['typ']}' selected>{$d['name']}</option>";
        } else {
            $html .= "<option value='{$d['typ']}'>{$d['name']}</option>";
        }
    }
    return $html;
}

function fnMake_Maker_option($cval='')
{
    $html = '';
    $common_m = model('Common_m');
    $cRs = $common_m->Load_Maker();
    if(fn_ArrayCnt($cRs)>0) {
        foreach ($cRs as $d) {
            if ($cval == $d['code']) {
                $html .= "<option value='{$d['code']}' selected>{$d['name']}</option>";
            } else {
                $html .= "<option value='{$d['code']}'>{$d['name']}</option>";
            }
        }
    }else{
        $html = '';
    }
    return $html;
}

function fnMake_Supply_option($cval='')
{
    $html = '';
    $common_m = model('Common_m');
    $cRs = $common_m->Load_Supply();
    if(fn_ArrayCnt($cRs)>0) {
        foreach ($cRs as $d) {
            if ($cval == $d['code']) {
                $html .= "<option value='{$d['code']}' selected>{$d['name']}</option>";
            } else {
                $html .= "<option value='{$d['code']}'>{$d['name']}</option>";
            }
        }
    }else{
        $html = '';
    }
    return $html;
}

function fnMake_HignMenu_name($location) {
    static $menuMap = [
        '1' => '주문관리',
        '2' => '기준정보관리',
        '3' => '생산 관리',
        '4' => '입출고관리',
        '5' => '품질 관리',
        '6' => '모니터링',
        '7' => '사용자관리'
    ];

    return $menuMap[$location] ?? '';
}

function fnMake_Menu_name() {
    static $menus1 = [
        ['url' => '/order/linkmalls','name' => '쇼핑몰연동', 'link' => 'go_linkMalls();'],
        ['url' => '/order/orderlist','name' => '주문목록', 'link' => 'go_orderList();'],
        ['url' => '/order/packinglist','name' => '포장목록', 'link' => 'go_packingList();'],
        ['url' => '/order/deliverylist','name' => '배송목록', 'link' => 'go_deliList();'],
    ];

    static $menus2 = [
        ['url' => '/goods/materiallist','name' => '원자재목록', 'link' => 'go_materialList();'],
        ['url' => '/goods/productslist','name' => '제품목록', 'link' => 'go_productsList();'],
        ['url' => '/goods/goodslist','name' => '상품목록', 'link' => 'go_goodsList();'],
        ['url' => '/goods/productsmasterlist','name' => '제품BOM목록', 'link' => 'go_productsMasterList();'],
        
        ['url' => '/goods/goodsetc','name' => '기타정보관리', 'link' => 'go_goodsETC();'],
    ];

    static $menus3 = [
        ['url' => '/produce/productionlist','name' => '생산목록', 'link' => 'go_productionList();'],
    ];

    static $menus4 = [
        ['url' => '/inout/material','name' => '입출고관리 (원재료)', 'link' => 'go_inOutMaterial();'],
        ['url' => '/inout/halfproduct','name' => '입출고관리 (반제품)', 'link' => 'go_inOutHalfProduct();'],
    ];

    static $menus5 = [
        ['url' => '/report/quality','name' => '품질보고서', 'link' => 'go_qualityReport();'],
        ['url' => '/report/order','name' => '주문보고서', 'link' => 'go_orderReport();'],
    ];

    static $menus6 = [
        ['url' => '/monitor/workstatus','name' => '작업진행현황', 'link' => 'go_workStatus();'],
        ['url' => '/monitor/processstatus','name' => '공정별진행현황', 'link' => 'go_processStatus();'],
    ];
    static $menus7 = [
        ['url' => '/info/user','name' => '사용자정보', 'link' => 'go_userInfo();'],
        ['url' => '/info/notice','name' => '공지사항', 'link' => 'go_notice();']
    ];

    $menu = [
        'menu1' => $menus1,
        'menu2' => $menus2,
        'menu3' => $menus3,
        'menu4' => $menus4,
        'menu5' => $menus5,
        'menu6' => $menus6,
        'menu7' => $menus7
    ];

    return $menu;

}

