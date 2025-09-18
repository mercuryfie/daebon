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

function Load_API_Form(url,f_data){
    return new Promise(function(resolve, reject){
        console.log('call form api=' + url);
        let retMap = new Map();
        $.ajax({
            url: url,
            type : 'POST',
            data: f_data,
            dataType: "JSON",
            cache : false,
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
    let html = '<div class="spinnerBox" id="spinner">';
    html += '<img src="/assets/web/src/spinner.gif" alt="img" class="spinner"/>';
    html += '</div>';

    $('body').prepend(html);

}

function stop_spinner(){
    $('#spinner').remove();
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


function go_dashboard() {
    var url = "/order/dashBoard";
    $(location).attr("href", url);
}

function go_linkMalls() {
    var url = "/order/linkMalls";
    $(location).attr("href", url);
}

function go_orderInfo() {
    var url = "/order/orderInfo";
    $(location).attr("href", url);
}

function go_deliInfo() {
    var url = "/order/deliInfo";
    $(location).attr("href", url);
}

function go_packingInfo() {
    var url = "/order/packingInfo";
    $(location).attr("href", url);
}

function go_packingStatus() {
    var url = "/order/packingStatus";
    $(location).attr("href", url);
}

function go_goodsList() {
    var url = "/goods/goodsList";
    $(location).attr("href", url);
}

function go_goodsRegister() {
    var url = "/goods/goodsRegister";
    $(location).attr("href", url);
}

function go_productsList() {
    var url = "/goods/productsList";
    $(location).attr("href", url);
}

function go_matiRegister() {
    var url = "/goods/matiRegister";
    $(location).attr("href", url);
}

function go_manuRegister($mName) {
    let url = "/goods/manuRegister";
    $(location).attr("href", url);
}

function go_sangStatus() {
    let url = "/produce/sangStatus";
    $(location).attr("href", url);
}

function go_sangControl() {
    let url = "/produce/sangControl";
    $(location).attr("href", url);
}

function go_sangDetail() {
    let url = "/produce/sangDetail";
    $(location).attr("href", url);
}

function go_sangComplete() {
    let url = "/produce/sangComplete";
    $(location).attr("href", url);
}

function go_inOutStatus() {
    let url = "/inOut/inOutStatus";
    $(location).attr("href", url);
}

function go_atomList() {
    let url = "/inOut/atomList";
    $(location).attr("href", url);
}

function go_atomRegister() {
    let url = "/inOut/atomRegister";
    $(location).attr("href", url);
}

