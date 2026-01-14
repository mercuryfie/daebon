$(document).on('click', '.copied', function (e) {
    e.stopPropagation();
    e.preventDefault();

    $(document).on("mousedown", "#goMainImg", function(e) {
        if (e.button === 1) { // middle click
            window.open("/main", "_blank");
            e.preventDefault(); // 기존 동작 방지
        }
    });

    $('button[name="refreshBtn"]').click(function () {
        location.reload();
    });

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

function formatDate(d) {
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${year}-${month}-${day}`;
}

function generateNewCode(typ) {

    if(typ==1) {
        let timeNow = new Date().toISOString().slice(0, 10).replace(/-/g, ''); // YYYYMMDD
        let rnd = Math.floor(Math.random() * 9000) + 1000; // 10000~99999
        return 'DBG' + timeNow + rnd;
    }else if(typ==2){
        let timeNow = new Date().toISOString().slice(0, 10).replace(/-/g, ''); // YYYYMMDD
        let rnd = Math.floor(Math.random() * 90000) + 10000; // 10000~99999
        return 'DR' + timeNow + rnd;
    }
}


function isEmptyData(data) {
    if (data === null || data === undefined) return true;
    if (typeof data === 'string') return data.trim() === '';
    if (Array.isArray(data)) return data.length === 0;
    if (typeof data === 'object') {
        return Object.keys(data).length === 0 ||
            (data.hasOwnProperty('info') && isEmptyData(data.info));
    }
    return false;
}


function fn_padNumber(num, targetLength) {
    return String(num).padStart(targetLength, '0');
}


function fn_IsEmpty(arr){
    let bool;
    if (!arr || (Array.isArray(arr) && arr.length === 0) || (typeof arr === 'object' && Object.keys(arr).length === 0)) {
        bool = true;
    } else {
        bool = false;
    }
    return bool;
}


async  function Upload_Excel(upload_key,upload_type,excel_typ){
    let fname = '';
    try {
        start_spinner();
        let url = APIURL + '/Upload_file';
        let param = {
            upload_key : upload_key,
            upload_type: upload_type
        };
        let result = await Load_FileUpload(url,upload_key,param);
        if (result.get('status') == 'ok') {
            let f_Url = result.get('data').url;
            let f_typ = excel_typ;
            let bool = await Insert_Excel(f_Url,f_typ);
            if(bool){
                location.reload();
            }
        }else{
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return fname;
}

async function Insert_Excel(location,inserttype){
    let bool = false;
    try {
        let dataarr = {"url" : location,"typ" : inserttype};
        let url = APIURL + '/Insert_Excel';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
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

function Load_FileUpload(url, fileInputId, extraData = {}) {
    return new Promise(function(resolve, reject) {
        console.log('call file upload api=' + url);

        const fileInput = $(`#${fileInputId}`)[0];
        const fileCount = fileInput.files.length;

        if (fileCount === 0) {
            let retMap = new Map();
            retMap.set('status', 'error');
            retMap.set('data', '');
            retMap.set('message', '파일을 선택해주세요.');
            reject(retMap);
            return;
        }

        const formData = new FormData();
        // 파일들 추가 (multiple 지원)
        for(let i = 0; i < fileCount; i++) {
            formData.append(fileInputId, fileInput.files[i]);
        }

        // 추가 데이터 넣기
        for (let key in extraData) {
            formData.append(key, extraData[key]);
        }

        let retMap = new Map();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,  // FormData라서 필수!
            contentType: false,  // FormData라서 필수!
            cache: false,
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
    stop_spinner();

    $('#spinnerBox').addClass('active');
    $('#spinner').addClass('active');

}

function stop_spinner(){
    $('#spinnerBox').removeClass('active');
    $('#spinner').removeClass('active');
}


function printWindow(id) {
    var printContent = document.getElementById(id).innerHTML;
    var printWindow = window.open('', '', 'width=800,height=600');
    var rnd = Math.floor(Math.random() * 10000);
    printWindow.document.write('<html><head><title>Print</title>');
    // 외부 CSS파일 링크 - 문법 오류 없이 닫기
    printWindow.document.write("<link rel='stylesheet' href='/assets/web/css/style.css?rnd=" + rnd + "' />");
    // 꼭 필요한 스타일 직접 삽입 (불안할 경우, 예: 테이블 border 등)
    // printWindow.document.write('<style>@media print { table, th, td { border:1px solid black !important; } }</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.focus();
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500); // 딜레이 충분히 주세요 (300~1000ms 권장)
    };
}

function Make_Toast(msg) {
    $('.toastBox').remove();

    const div = $(`<div class="toastBox">${msg}</div>`).css({
        'animation': 'toastSlideIn 0.3s ease-out',
        'white-space': 'pre-line',
        'word-wrap': 'break-word'
    });

    $('body').append(div);

    setTimeout(() => {
        div.css('animation', 'toastSlideOut 0.3s ease-in forwards')
            .delay(300).queue(() => div.remove());
    }, 3000);
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


function pop_AddDeliForm() {
    let orcode = $('#poporcode').val();
    let url = "/order/adddeliform?cd=" + orcode;
    let width = 720;

    let newWindow = window.open(url, "_blank",
        `width=${width},height=600,resizable=yes,scrollbars=no`
    );

    newWindow.onload = function() {
        setTimeout(() => {
            try {
                let docHeight = Math.max(
                    // newWindow.document.body.scrollHeight,
                    // newWindow.document.documentElement.scrollHeight,
                    newWindow.document.main.offsetHeight
                );

                newWindow.resizeTo(width, docHeight + 80);
                newWindow.scrollTo(0, 0);
            } catch(e) {
                console.log("새 창 높이 조절 불가", e);
            }
        }, 300);
    };
}



function pop_waybillForm() {
    let orcode = $('#poporcode').val();
    let url = "/order/waybill?cd=" + orcode;
    let width = 720;

    let newWindow = window.open(url, "_blank",
        `width=${width},height=600,resizable=yes,scrollbars=no`
    );

    newWindow.onload = function() {
        setTimeout(() => {
            try {
                let docHeight = Math.max(
                    // newWindow.document.body.scrollHeight,
                    // newWindow.document.documentElement.scrollHeight,
                    newWindow.document.main.offsetHeight
                );

                newWindow.resizeTo(width, docHeight + 80);
                newWindow.scrollTo(0, 0);
            } catch(e) {
                console.log("waybill 새 창 높이 조절 불가", e);
            }
        }, 300);
    };
}

function pop_waybillPacking(orcode,rtyp) {
    let url = "/packing/waybill?cd=" + orcode + "&cp=" + rtyp;
    let width = 720;

    let newWindow = window.open(url, "_blank",
        `width=${width},height=600,resizable=yes,scrollbars=no`
    );

    newWindow.onload = function() {
        setTimeout(() => {
            try {
                let docHeight = Math.max(
                    // newWindow.document.body.scrollHeight,
                    // newWindow.document.documentElement.scrollHeight,
                    newWindow.document.main.offsetHeight
                );

                newWindow.resizeTo(width, docHeight + 80);
                newWindow.scrollTo(0, 0);
            } catch(e) {
                console.log("waybill 새 창 높이 조절 불가", e);
            }
        }, 300);
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

function pop_qualityReportForm(url) {

    let width = 1400;
    let height = 780;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight );
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}


function pop_OrderRoastForm(url) {
    let width = 720;

    let newWindow = window.open(url, "_blank",
        `width=800,height=600,resizable=yes,scrollbars=no`
    );

    newWindow.onload = function() {
        setTimeout(() => {
            try {
                let docHeight = Math.max(
                    // newWindow.document.body.scrollHeight,
                    // newWindow.document.documentElement.scrollHeight,
                    newWindow.document.body.offsetHeight
                );

                newWindow.resizeTo(width, docHeight + 80);
                newWindow.scrollTo(0, 0);
            } catch(e) {
                console.log("waybill 새 창 높이 조절 불가", e);
            }
        }, 300);
    };
}



function print_WaybillForm(url) {
    let width = 720;

    let newWindow = window.open(url, "_blank",
        `width=800,height=600,resizable=yes,scrollbars=no`
    );

    newWindow.onload = function() {
        setTimeout(() => {
            try {
                let docHeight = Math.max(
                    // newWindow.document.body.scrollHeight,
                    // newWindow.document.documentElement.scrollHeight,
                    newWindow.document.body.offsetHeight
                );

                newWindow.resizeTo(width, docHeight + 80);
                newWindow.scrollTo(0, 0);
            } catch(e) {
                console.log("waybill 새 창 높이 조절 불가", e);
            }
        }, 300);
    };
}

function fnProcess_Arr() {
    return [
        {code: 'P001', typ: 1, gubun: 1, name: '원료입고', loss: '0'},
        {code: 'P002', typ: 1, gubun: 2, name: '파쇄', loss: '5'},
        {code: 'P003', typ: 1, gubun: 2, name: '로스팅', loss: '20'},
        {code: 'P004', typ: 1, gubun: 2, name: '이물제거', loss: '3'},
        {code: 'P005', typ: 2, gubun: 2, name: '삼각티백포장', loss: '0'},
        {code: 'P006', typ: 2, gubun: 2, name: '내포장', loss: '0'},
        {code: 'P007', typ: 2, gubun: 2, name: '외포장', loss: '0'},
    ];
}

function fnMake_Process_Type(cval) {
    let html = '';
    let t_arr = fnProcess_Arr();

    t_arr.forEach(function(d) {
        if (cval == d.code) {
            html += `<option value='${d.code}' selected data-type='${d.typ}'>${d.name}</option>`;
        } else {
            html += `<option value='${d.code}' data-type='${d.typ}'>${d.name}</option>`;
        }
    });

    return html;
}
