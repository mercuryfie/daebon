<?php

function fnGetProcessNameByCode($code) {
    $products = fnProcess_Arr();
    foreach ($products as $p) {
        if ($p['code'] === $code) {
            $arr = [
                'name' => $p['name'],
                'typ' => $p['typ']
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
        ['code' => 'P001', 'name' => '계량' , 'typ' => 1],
        ['code' => 'P002', 'name' => '세척' , 'typ' => 1],
        ['code' => 'P003', 'name' => '건초' , 'typ' => 1],
        ['code' => 'P003', 'name' => '이물검사' , 'typ' => 1],
        ['code' => 'P003', 'name' => '파쇄(조분쇄)' , 'typ' => 1],
        ['code' => 'P003', 'name' => '로스팅' , 'typ' => 1],
        ['code' => 'P003', 'name' => '전동진동채(이물제거)' , 'typ' => 1],
        ['code' => 'P003', 'name' => '삼각티백/내외포장' , 'typ' => 2],
        ['code' => 'P003', 'name' => '금속이물탐지' , 'typ' => 1],
        ['code' => 'P003', 'name' => '외포장' , 'typ' => 2],
        ['code' => 'P003', 'name' => '보관/출고' , 'typ' => 1]
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
            if ($cval == $d['mcode']) {
                $html .= "<option value='{$d['mcode']}' selected>{$d['mname']}</option>";
            } else {
                $html .= "<option value='{$d['mcode']}'>{$d['mname']}</option>";
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
    }else if($typ==2){
        $timeNow = date("Ymd");
        $rnd = mt_rand(10000, 99999);
        $newCode = 'MB'. $timeNow.$rnd;
    }

    return $newCode;
}

function fnMake_Material_Type($cval){
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

function fnMake_Material_Unit($cval){
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

function fnMake_Maker_option($cval)
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

function fnMake_Supply_option($cval)
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
        ['url' => '/inout/materiallist','name' => '원자재목록', 'link' => 'go_materialList();'],
        ['url' => '/goods/productslist','name' => '제품목록', 'link' => 'go_productsList();'],
        ['url' => '/goods/goodslist','name' => '상품목록', 'link' => 'go_goodsList();'],
        ['url' => '/goods/productsmaster','name' => '제품 마스터관리', 'link' => 'go_productsMaster();'],
        ['url' => '/goods/goodsetc','name' => '기타정보관리', 'link' => 'go_goodsETC();'],
    ];

    static $menus3 = [
        ['url' => '/produce/productionlist','name' => '생산목록', 'link' => 'go_productionList();'],
    ];

    static $menus4 = [
        ['url' => '/inout/inoutstatus','name' => '입출고관리', 'link' => 'go_inoutStatus();'],
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

