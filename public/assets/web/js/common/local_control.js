
function fn_PrnUnitType(params){
    let unit_typ = params['unit_type'];
    let inventory = params['inventory'];
    let t_cnt = params['t_cnt'];
    let unit_weight = params['unit_weight'];

    if(unit_typ=='kg'){
        let gtokg1 = inventory/1000;
        cnt_str1 = `${gtokg1} kg`;
        cnt_str2 = `${t_cnt} 개`
        let gtokg2 = unit_weight/1000;
        cnt_str3 = `${gtokg2} kg`;
    }else if(unit_typ=='g'){
        cnt_str1 = `${inventory} g`;
        cnt_str2 = `${t_cnt} 개`
        cnt_str3 = `${unit_weight} g`;
    }else if(unit_typ=='개'){
        cnt_str1 = `${inventory} 개`;
        cnt_str2 = `${t_cnt} 개`
        cnt_str3 = `${unit_weight} g`;
    }

    return {
        cnt_str1 : cnt_str1,
        cnt_str2 : cnt_str2,
        cnt_str3 : cnt_str3
    }
}


function fn_calculateNetWeight(weightStr, lossRateStr) {
    let weight = parseFloat(weightStr) || 0;
    let lossRate = parseFloat(lossRateStr) || 0;
    let remainingRate = 1 - (lossRate / 100);
    let netWeight = weight * remainingRate;

    // 숫자만 리턴 (g 제거)
    return netWeight % 1 === 0 ?
        Math.round(netWeight) :
        parseFloat(netWeight.toFixed(1));
}


function fnGetProcessNameByCode(code) {
    const products = fnProcess_Arr();

    const p = products.find(item => item.code === code); // 못 찾으면 undefined [web:24][web:31]
    if (!p) {
        return null;
    }

    return {
        name: p.name,
        typ: p.typ,
        gubun: p.gubun
    };
}

function fnGetProductNameByCode(code) {
    const product = productsArr.find(p => p.code === code);
    return product ? product.name : null;
}


function getNameByCode(code) {
    const arr = List_ExCode();
    return arr[code] || null;  // code가 없으면 null 반환
}

function List_ExCode(){
    const arr = {
        type0: '자체',
        type1: '쿠팡',
        type2: '옥션',
        type3: '지마켓'
    };
    return arr;
}

function opt_Excode(select){
    const arr = List_ExCode();
    let str = '';
    for (const key in arr) {
        if (arr.hasOwnProperty(key)) {
            const selected = (select === key) ? ' selected' : '';
            str += `<option value="${key}"${selected}>${arr[key]}</option>`;
        }
    }
    return str;
}

function convertToGram(weight) {
    if (!weight || weight.length < 4) return 0; // 유효성 체크
    const prefix = weight.substring(0, 3);
    const valueStr = weight.substring(3);
    const value = parseFloat(valueStr);

    if (isNaN(value)) return 0;
    if (prefix === "MEI") {
        return value / 1000;
    } else if (prefix === "MEJ") {
        return value;
    } else {
        return 0;
    }
}

function getNameByProcess(val){
    let status = ''
    if(val==0) {
        status = '준비중';
    }else if(val==1){
        status = '대기';
    }else if(val==2){
        status = '작업대기';
    }else if(val==3){
        status = '작업중';
    }else if(val==4) {
        status = '완료';
    }

    return status;
}

function Join_attr_string(arr, sep){
    return arr.filter(e => e).join(sep);
}

function go_main(grade) {
    let url = '';
    if(grade=='1101'){
        url = '/';
    }else if(grade=='1102'){
        url = '/packing';
    }else if(grade=='1103') {
        url = '/product';
    }
    $(location).attr("href", url);
}

function go_login() {
    var url = "/member/login";
    $(location).attr("href", url);
}

function go_logout(){
    var url = "/member/logout";
    $(location).attr("href", url);
}

function go_dashBoard() {
    var url = "/order/dashboard";
    $(location).attr("href", url);
}

function go_linkMalls() {
    var url = "/order/linkmalls";
    $(location).attr("href", url);
}

function go_missingList(styp) {
    var url = "/order/missinglist?sp=" + styp;
    $(location).attr("href", url);
}

function go_linkMallsLogs(code) {
    var url = "/order/linkmallslogs?cd=" + code;
    $(location).attr("href", url);
}

function go_orderList() {
    var url = "/order/orderlist";
    $(location).attr("href", url);
}

function go_orderRegister() {
    var url = "/order/orderregister";
    $(location).attr("href", url);
}

function go_deliList() {
    var url = "/order/deliverylist";
    $(location).attr("href", url);
}

function go_packingList() {
    var url = "/order/packinglist";
    $(location).attr("href", url);
}

function go_packingListStaff() {
    var url = "/packing";
    $(location).attr("href", url);
}

function go_packingStatus() {
    var url = "/order/packingstatus";
    $(location).attr("href", url);
}

function go_packingStatusStaff(opcode) {
    var url = "/packing/process?op=" + opcode;
    $(location).attr("href", url);
}

function go_goodsList() {
    var url = "/goods/goodslist";
    $(location).attr("href", url);
}

function go_goodsReg() {
    var url = "/goods/goodsreg";
    $(location).attr("href", url);
}

function go_goodsEdit(code) {
    var url = "/goods/goodsedit?cd=" + code ;
    $(location).attr("href", url);
}

function go_productsList() {
    var url = "/goods/productslist";
    $(location).attr("href", url);
}

function go_productsLog(code) {
    var url = "/goods/productslog?cd=" + code;
    $(location).attr("href", url);
}

function go_productsEditor(code) {
    var url = "/goods/productseditor?cd=" + code;
    $(location).attr("href", url);
}


// function go_manuRegister($mName) {
//     let url = "/goods/manuregister";
//     $(location).attr("href", url);
// }
//
// function go_manuEditor($mName) {
//     let url = "/goods/manueditor";
//     $(location).attr("href", url);
// }


function go_productionList() {
    let url = "/produce/productionlist";
    $(location).attr("href", url);
}

function go_productionListStaff() {
    let url = "/product";
    $(location).attr("href", url);
}

function go_halfList() {
    let url = "/product/halflist";
    $(location).attr("href", url);
}

function go_halfListLog() {
    let url = "/product/halflistlog";
    $(location).attr("href", url);
}

function go_productionStatus(code) {
    let url = "/produce/productionstatus?cd=" + code;
    $(location).attr("href", url);
}

function go_productionStatusStaff(code) {
    let url = "/product/status?cd=" + code;
    $(location).attr("href", url);
}

// function go_categoryList() {
//     let url = "/goods/categorylist";
//     $(location).attr("href", url);
// }
//
// function add_category2() {
//     $('#addCat2_wrap').css('display','block');
// }

function go_productionDetail(code) {
    let url = "/produce/productiondetail?cd=" + code;
    $(location).attr("href", url);
}

function go_productionDetailStaff(code) {
    let url = "/product/statusdetail?cd=" + code;
    $(location).attr("href", url);
}

function go_inOutMaterial() {
    let url = "/inout/material";
    $(location).attr("href", url);
}

function go_inOutMaterial_Log(mtcode) {
    let url = "/inout/materiallog?mt=" + mtcode;
    $(location).attr("href", url);
}

function go_inOutHalfProduct() {
    let url = "/inout/halfproduct";
    $(location).attr("href", url);
}

function go_materialList() {
    let url = "/goods/materiallist";
    $(location).attr("href", url);
}

function go_popBarcodeLayer() {
    let url = "/inout/popbarcodelayer";
    $(location).attr("href", url);
}

function go_popPrintBarcodeMaterial() {
    let url = "/inout/prn_barcode_material";
    $(location).attr("href", url);
}

function go_productsMasterReg(pdcode){
    let url = "/goods/productsmasterreg?cd=" + pdcode;
    $(location).attr("href", url);
}

function go_productsMasterList(){
    let url = "/goods/productsmasterlist";
    $(location).attr("href", url);
}

function go_otherInfo_Maker(){
    // alert('페이지 준비중입니다. ');
    let url = "/goods/otherinfo?tp=" + 1;
    $(location).attr("href", url);
}

function go_otherInfo_Supplier(){
    // alert('페이지 준비중입니다. ');
    let url = "/goods/otherinfo?tp=" + 2;
    $(location).attr("href", url);
}

// function go_productionDetail(code) {
//     let url = "/produce/productiondetail?cd=" + code;
//     $(location).attr("href", url);
// }

function go_qualityReport(){
    let url = "/report/quality";
    $(location).attr("href", url);
}

function go_orderReport(){
    let url = "/report/order";
    $(location).attr("href", url);
}

function go_workStatus(){
    let url = "/monitor/workstatus";
    $(location).attr("href", url);
}

function go_processStatus(){
    let url = "/monitor/processstatus";
    $(location).attr("href", url);
}

function go_userRegister(){
    let url = "/info/userregister";
    $(location).attr("href", url);
}

function go_userEditor(uid,grade){
    let url = "/info/usereditor?uid="+uid+"&grade="+grade;
    $(location).attr("href", url);
}

function go_userList(){
    let url = "/info/userlist";
    $(location).attr("href", url);
}

function go_noticeList(){
    let url = "/info/noticelist";
    $(location).attr("href", url);
}

function go_noticeRegister(){
    let url = "/info/noticeregister";
    $(location).attr("href", url);
}

function go_noticeEditor(bcode){
    let url = "/info/noticeeditor?cd="+bcode;
    $(location).attr("href", url);
}




// function pop_AddDeliForm() {
//     let url = "/order/addDeliForm";
//     $(location).attr("href", url);
// }