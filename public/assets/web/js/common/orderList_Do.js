
$(document).ready(function() {
    let param = '';
    let search = $('#skey').val();
    console.log('dawn',search);
    const data = {
        skey : search
    };
    Make_Html(data);

    $('#skey').on('keypress',async function(e){
        if (e.which === 13) {
            let skey = $(this).val();
            if(skey==''){
                Make_Toast('검색하실 상품명을 입력하세요.');
                $(this).focus();
            }else{
                const data = {
                    skey : skey
                };
                Make_Html(data);
            }
        }
    });

    $('#btn_sch').on('click',function(){
        if (e.which === 13) {
            let skey = $('#skey').val();
            if(skey==''){
                Make_Toast('검색하실 상품명을 입력하세요.');
                skey.focus();
            }else{
                const data = {
                    skey : skey
                };
                Make_Html(data);
            }
        }
    });

    $('#uploadExcel #Xbtn, #uploadExcel #Xbtn2').click(function () {
        $('#uploadExcel').css('display','none');
    });

    $('#addPQueue #Xbtn, #addPQueue #Xbtn2').click(function () {
        $('#addPQueue').css('display','none');
    });

    $('.period').click(function(e) {
        e.preventDefault();
        $('.period').removeClass('active');
        $(this).addClass('active');

        const today = new Date();
        let startDate = new Date();
        let endDate = new Date();

        const periodText = $(this).text();

        switch (periodText) {
            case '오늘':
                startDate = today;
                endDate = today;
                break;
            case '1주일':
                startDate = new Date(today);
                startDate.setDate(today.getDate() - 6);
                endDate = today;
                break;
            case '1개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 1);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            case '3개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 3);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            default:
                startDate = today;
                endDate = today;
        }

        $('#s_date').val(formatDate(startDate));
        $('#e_date').val(formatDate(endDate));

    });

    $('.datepicker').each(function(index, elem) {
        const fp = flatpickr(elem, {
            dateFormat: "Y-m-d",
            minDate: "2024-01-01",
            static: true,
            appendTo: elem.parentNode,
            onClose: function(selectedDates, dateStr, instance) {
                instance.element.blur();
            }
        });

        $('.calicon').eq(index).on('click', function(e) {
            e.preventDefault();
            fp.open();
        });
    });

    $('#btn_orderUpload').on('click',function(){
        Make_Toast('매칭된 상품코드가 없습니다. ');
    });

    $('#btn_ininstruct').on('click',async function(){
        let checked = $('input[name="chkorder"]:checked');
        if (checked.length == 0) {
            Make_Toast('배송 지시 하실 주문을 선택하세요');
        }else if(window.confirm('선택하신 주문을 배송지시 하시겠습니까?')){
            let codes = $("input[name='chkorder']:checked").map(function() {
                    return this.value;
            }).get();
            let tcnt = codes.length;
            if(tcnt > 0){
                let arr = await Put_Delivery(codes);
                console.log(arr);
                $.each(arr, function(index, item) {
                    $('#ck_' + item.orcode).html('');
                    $('#bu_' + item.orcode).html('<button type="button" class="btnType3">지시완료</button>');
                    $('#da_' + item.orcode).text(item.indate);
                });
            }
        }
    });

    $('#btn_package').on('click',async function(){
        let checked = $('input[name="chkorder"]:checked');
        if (checked.length == 0) {
            Make_Toast('묶음포장 지시 하실 주문을 선택하세요');
        }else if (checked.length == 1) {
            Make_Toast('묶음포장 지시는 한개이상 선택하세요');
        }else if(window.confirm('선택하신 주문을 묶음배송 하시겠습니까?')){
            let codes = $("input[name='chkorder']:checked").map(function() {
                return this.value;
            }).get();
            let tcnt = codes.length;
            if(tcnt > 0){
                let arr = await Put_Package(codes);
                console.log(arr);
                $.each(arr, function(index, item) {
                    $('#ck_' + item.orcode).html('');
                    $('#bu_' + item.orcode).html(`<button type="button" class="btnType3" data-rttype="2"  onclick="add_packingQueue('${item.orcode}');">지시완료</button>`);
                    $('#da_' + item.orcode).text(item.indate);
                });
            }
        }
    });

    $('#btn_delivery_prn').on('click',async function(){
        let orcode = $('#poporcode').val();
        if(orcode==''){
            Make_Toast('잘못된 접근입니다.');
        }else{
            let codes = [];
            codes.push(orcode);
            let tcnt = codes.length;
            if(tcnt > 0){
                let arr = await Put_Delivery2(codes);
                $.each(arr, function(index, item) {
                    $('#ck_' + item.orcode).html('');
                    $('#bu_' + item.orcode).html('<button type="button" class="btnType3">지시완료</button>');
                    $('#da_' + item.orcode).text(item.indate);
                });
                pop_waybillForm();
            }
        }
    });

    $('#btn_orderconfirm').on('click',async function(){
        let checked = $('input[name="chkorder"]:checked');
        if (checked.length == 0) {
            Make_Toast('쇼핑몰 주문확인 처리 하실 주문을 선택하세요.');
            return
        }
        let isCheck = true;
        let datas = [];
        checked.each(function (){
            let method = $(this).data('method');
            if (method !== 'API') {
                isCheck = false;
                datas = [];
                return false;
            }else{
                let row = {
                    orcode: $(this).val()
                };
                datas.push(row);
            }
        });
        if(!isCheck) return;
        for (const item of datas) {
            console.log(`${item.orcode} 처리 시작...`);
            //let resultData = await Put_Order_Confirm(item.orcode);
            //if (resultData && Object.keys(resultData).length > 0) {
            //    console.log(`${item.orcode} 처리 완료`);
            //}
        }
        Make_Toast('모든 주문 처리가 완료되었습니다.');
    });


});

async function Put_Order_Confirm(orcode){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"orcode" : orcode};
        let url = APIURL + '/Load_Order_Data';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Make_Html(data){
    let arr = await Load_Data(data);
    let html = '';
    console.log('dawn',arr);
    if(!fn_IsEmpty(arr)) {
        $.each(arr, function (index, el) {
            let subhtml1 = '';
            let subhtml2 = '';
            let cnxl_status = '';
            let cnxl_css = '';
            let cnxl_fn1 = '';
            if(el.orstep==0) {
                subhtml1 = `<input type="checkbox" name="chkorder" value="" data-method="${el.shopmethod}">`;
                subhtml2 = `<button type="button" class="btnType3 btn_gray" data-rttype="1" onclick="add_packingQueue('${el.orcode}');">지시대기</button>`;
            }else{
                subhtml1 = '-';
                subhtml2 = `<button type="button" class="btnType3 " data-rttype="2" onclick="add_packingQueue('${el.orcode}');">지시완료</button>`;
            }

            if(el.gdstep == 2) {
                cnxl_status = `<p class="data fs14">취소불가</p>`;
            }else {
                cnxl_status = `<button type="button" class="btnType3 fs14" value="${el.orcode}" onclick="Del_ThisOrder('${el.orcode}');">주문취소</button>`;
            }

            if(el.is_cancel == 0) {
                cnxl_css = ``;
                cnxl_fn1 = `onclick="go_orderEditor('${el.orcode}','${el.shopmethod}');"`;
            }else{
                cnxl_css = `cxled_order`;
                cnxl_status = `<p class="data fs14">취소됨</p>`
                subhtml2 = `-`;
                cnxl_fn1 = ``;
            }

            html +=`
                <tr class="${cnxl_css}" id="list_${el.orcode}">
                    <td class="ltTbody td40 fixedCol" >
                        <div class="inner40 flexCol2" id="ck_${el.orcode}">${subhtml1}</div>
                    </td>
                    <td class="ltTbody productNo fixedCol" name="packingStep"><div class="inner1 flexCol2"><p class="text" id="bu_${el.orcode}">${subhtml2}</p></div></td> 
                    <td class="ltTbody fixedCol underline2" data-copy="copy"><div class="inner2 flexCol2"><p class="text">${el.orcode}</p><p class="text">${el.spcode}</p></div></td>
                    <td class="ltTbody fixedCol underline2"><div class="inner2 flexCol2 last_inner"><p class="text">${el.pd_code}</p><p class="text">${el.sg_code}</p></div></td>
                    <td class="ltTbody scrollableCol" ${cnxl_fn1}><div class="inner4 flexType1 g_name"><a href="javascript:;" class="text mr10" >${el.p_name}</a></div></td>
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2 fs14"><p class="text">${el.buy_name}</p><p class="text">${el.buy_phone}</p><p class="text">${el.receive_name}</p><p class="text">${el.receive_phone}</p></div></td>
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text">${el.tcnt}개</p><p class="text">${number_format(el.tprice)}원</p></div></td> 
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text">${el.orderdate}</p></div></td>
                    
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text" id="da_${el.orcode}">${el.deli_info['indate']}</p></div></td>    
                    <td class="ltTbody scrollableCol "><div class="inner4 flexCol2 "><p class="text">${el.input_str}</p></div></td>
                    <td class="ltTbody scrollableCol "><div class="inner4 flexCol2 "><p class="text">${el.shopstr}</p><p class="text">${el.sell_id}</p></div></div></td> 
                    <td class="ltTbody scrollableCol ">${cnxl_status}
                        
                    </td> 
                </tr>
            `;
        });
        $('#cList').empty();
        $('#cList').append(html);
    }
}

function upload_Xlx() {
    $('#uploadExcel .area3').css('display','flex');
    $('#uploadExcel').css('display','block');
}

function template_Download(e) {
    e.preventDefault();  // 기본 onclick 막기
    window.location.href = '/path/to/your/template.xlsx';
}

async function add_packingQueue(orcode,typ) {
    let data= await Load_Delivery(orcode);
    if(isEmptyData(data)){
        Make_Toast('주문정보가 확인되지 않습니다.');
    }else{
        Packing_ini();

        $('#ordercode').text(data.orcode);
        $('#pname').text(data.p_name);
        $('#buyname').text(data.receive_name);
        $('#zipcode').text(data.receive_zipcode);
        $('#buyaddress1').text(data.receive_address1);
        $('#buyaddress2').text(data.receive_address2);
        $('#poporcode').val(data.orcode);

        $('#addPQueue').css('display','block');
    }
}

function Packing_ini(){
    $('#ordercode').text('');
    $('#pname').text('');
    $('#buyname').text('');
    $('#zipcode').text('');
    $('#buyaddress1').text('');
    $('#buyaddress2').text('');
    $('#poporcode').val('');
}


async function Load_Data(data){
    // let data = {};
    try {
        start_spinner();
        // let dataarr = {"search" : param};
        let url = APIURL + '/Load_Order_Data';
        let result = await Load_API_Auth(url,data);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Load_Delivery(orcode){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"code" : orcode};
        let url = APIURL + '/Load_Order_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').info;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Put_Delivery(codes){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"codes" : codes};
        let url = APIURL + '/Put_Delivery_Info';
        let result = await Load_API_Auth(url,dataarr);
        console.log(result);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'Error003') {
            alert(result.get('message'));
            location.reload();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Put_Delivery2(codes){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"codes" : codes};
        let url = APIURL + '/Put_Delivery_Info';
        let result = await Load_API_Auth(url,dataarr);
        console.log(result);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Put_Package(codes){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"codes" : codes};
        let url = APIURL + '/Put_Package_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

