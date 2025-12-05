
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

function go_main() {
    var url = "/";
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

function go_dashboard() {
    var url = "/order/dashboard";
    $(location).attr("href", url);
}

function go_linkMalls() {
    var url = "/order/linkmalls";
    $(location).attr("href", url);
}

function go_linkMallsLogs() {
    var url = "/order/linkmallslogs";
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

function go_packingStatusStaff() {
    var url = "/packing/status";
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

function go_popBarcodeWindow() {
    let url = "/inout/popbarcodewindow";
    $(location).attr("href", url);
}


function go_productsMasterReg(){
    let url = "/goods/productsmasterreg";
    $(location).attr("href", url);
}

function go_productsMasterList(){
    let url = "/goods/productsmasterlist";
    $(location).attr("href", url);
}

function go_goodsETC(){
    let url = "/goods/goodsetc";
    $(location).attr("href", url);
}

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

function go_userInfo(){
    let url = "/info/user";
    $(location).attr("href", url);
}

function go_notice(){
    let url = "/info/notice";
    $(location).attr("href", url);
}


// function pop_AddDeliForm() {
//     let url = "/order/addDeliForm";
//     $(location).attr("href", url);
// }