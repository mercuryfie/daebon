$(document).on('click', '.copied', function (e) {
    e.stopPropagation();
    e.preventDefault();

    // 중복 실행 방지
    if ($(this).data('copied')) return;
    $(this).data('copied', true);
    setTimeout(() => $(this).removeData('copied'), 100);

    var text = $(this).closest('.titleBox').find('.orderNo').text().trim();
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function () {
            alert('copied!');
        }).catch(function () {
            dataCopy(text);
        });
    } else {
        dataCopy(text);
    }
});

function fn_IsEmpty(arr){
    let bool;
    if (!arr || (Array.isArray(arr) && arr.length === 0) || (typeof arr === 'object' && Object.keys(arr).length === 0)) {
        bool = true;
    } else {
        bool = false;
    }
    return bool;
}


function Load_API(url,dataarr){
    return new Promise(function(resolve, reject){
        console.log('call api=' + url);
        console.log(JSON.stringify(dataarr));
        let retMap = new Map();
        $.ajax({
            url: url,
            type: 'POST',
            dataType : "JSON",
            data: dataarr,
            success: function (response) {
                retMap.set('status',response.result);
                retMap.set('data',response.info);
                retMap.set('message',response.message);
                resolve(retMap);
            },
            error: function (request, status, error) {
                retMap.set('status','error');
                retMap.set('data','');
                retMap.set('message',error);
                reject(retMap);
            }
        });
    });
}

function Load_API_Auth(url, dataarr){
    return new Promise(function(resolve, reject){
        console.log('call api=' + url);
        console.log(JSON.stringify(dataarr));
        const token = $('#token').val();
        if(token==''){
            alert('보안처리에 실패 하였습니다.\n다시 시도 하여주세요.');
            $(location).attr("href", '/');
        }else {
            let retMap = new Map();
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: dataarr,
                beforeSend: function (xhr) {
                    if (token) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    }
                },
                success: function (response) {
                    retMap.set('status', response.result);
                    retMap.set('data', response.info);
                    retMap.set('message', response.message);
                    resolve(retMap);
                },
                error: function (request, status, error) {
                    retMap.set('status', 'error');
                    retMap.set('data', '');
                    retMap.set('message', error);
                    reject(retMap);
                }
            });
        }
    });
}


function Load_API_Form(url,f_data){
    return new Promise(function(resolve, reject){
        console.log('call form api=' + url);
        const token = $('#token').val();
        if(token==''){
            alert('보안처리에 실패 하였습니다.\n다시 시도 하여주세요.');
            $(location).attr("href", '/');
        }else {
            let retMap = new Map();
            $.ajax({
                url: url,
                type: 'POST',
                data: f_data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function (xhr) {
                    if (token) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    }
                },
                success: function (response) {
                    retMap.set('status', response.result);
                    retMap.set('data', response.info);
                    retMap.set('message', response.message);
                    resolve(retMap);
                },
                error: function (request, status, error) {
                    retMap.set('status', 'error');
                    retMap.set('data', '');
                    retMap.set('message', error);
                    reject(retMap);
                }
            });
        }
    });
}

function Load_API_File(url,f_data){
    return new Promise(function(resolve, reject){
        console.log('call file api=' + url);
        console.log(f_data);
        let retMap = new Map();
        $.ajax({
            url: url,
            type : 'POST',
            data: f_data,
            enctype		: 'multipart/form-data',
            processData : false,
            contentType : false,
            success: function (response) {
                retMap.set('status',response.result);
                retMap.set('data',response.info);
                retMap.set('message',response.message);
                resolve(retMap);
            },
            error: function (request, status, error) {
                retMap.set('status','error');
                retMap.set('data','');
                retMap.set('message',error);
                reject(retMap);
            }
        });
    });
}


function number_format(num){
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g,',');
}

function start_spinner() {
    $('#spinnerBox').addClass('active');
    $('#spinner').addClass('active');

}

function stop_spinner(){
    $('#spinnerBox').removeClass('active');
    $('#spinner').removeClass('active');
}

function printWindow(id) {
    var init_body = document.body.innerHTML;
    //인쇄하기 전 수행
    window.onbeforeprint = function () {
        document.body.innerHTML = document.getElementById(id).innerHTML;
    }
    //인쇄한 후 수행
    window.onafterprint = function () {
        document.body.innerHTML = init_body;
    }
    setTimeout(function(){window.print();}, 1000);
}


function Make_Toast(msg){
    const div = document.createElement('div');
    div.classList.add('toastBox');
    div.textContent = msg;
    document.body.appendChild(div);

    // 일정 시간이 지난 후 div 삭제
    setTimeout(() => {
        div.remove();  // div를 삭제
    }, 2000); // 3초 후에 삭제
}

function checkValidDate(value) {
    var result = true;
    try {
        var date = value.split("-");
        var y = parseInt(date[0], 10),
            m = parseInt(date[1], 10),
            d = parseInt(date[2], 10);

        var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
        result = dateRegex.test(d+'-'+m+'-'+y);
    } catch (err) {
        result = false;
    }
    return result;
}

function div_close(id,reload){
    if(reload==1){
        location.reload();
    }
    $('#' + id).hide();

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

function go_orderList() {
    var url = "/order/orderlist";
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

function go_productsList() {
    var url = "/goods/productslist";
    $(location).attr("href", url);
}

function go_productsReg() {
    var url = "/goods/productsreg";
    $(location).attr("href", url);
}

function go_productsEditor() {
    var url = "/goods/productseditor";
    $(location).attr("href", url);
}


function go_manuRegister($mName) {
    let url = "/goods/manuregister";
    $(location).attr("href", url);
}

function go_manuEditor($mName) {
    let url = "/goods/manueditor";
    $(location).attr("href", url);
}


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

function go_categoryList() {
    let url = "/goods/categorylist";
    $(location).attr("href", url);
}

function add_category2() {
    $('#addCat2_wrap').css('display','block');
}

function go_productionDetail() {
    let url = "/produce/productiondetail";
    $(location).attr("href", url);
}

function go_productionDetailMono() {
    let url = "/produce/productiondetailmono";
    $(location).attr("href", url);
}


function go_productionDetailStaff() {
    let url = "/product/statusDetail";
    $(location).attr("href", url);
}

function go_productionDetailMonoStaff() {
    let url = "/product/statusDetailMono";
    $(location).attr("href", url);
}

// function go_productionComplete() {
//     let url = "/produce/productioncomplete";
//     $(location).attr("href", url);
// }
//
// function go_productionComplete2() {
//     let url = "/produce/productioncomplete2";
//     $(location).attr("href", url);
// }

function go_inoutStatus() {
    let url = "/inout/inoutstatus";
    $(location).attr("href", url);
}

function go_materialList() {
    let url = "/inout/materiallist";
    $(location).attr("href", url);
}

function go_materialReg() {
    let url = "/inout/materialreg";
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


function go_productsMaster(){
    let url = "/goods/productsmaster";
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

function pop_AddDeliForm() {
    let url = "/order/adddeliform";
    let width = 720;
    let height = 980;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 450);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}


function pop_waybillForm() {
    let url = "/order/waybill";
    let width = 720;
    let height = 980;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 450);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}


function pop_waybillFormStaff() {
    let url = "/packing/waybillform";
    let width = 720;
    let height = 980;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 450);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}

function pop_OrderRoastForm(code) {
    let url = "/produce/instructionform?cd=" + code;
    let width = 920;
    let height = 880;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 220);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}
