
$(document).ready(function() {
    let param = '';
    let search = $('#skey').val();
    const data = {
        skey : search
    };
    Make_Html(data);

    $('#skey').on('keypress',async function(e){
        if (e.which === 13) {
            let skey = $(this).val();
            const data = {
                skey : skey
            };
            Make_Html(data);
        }
    });

    $('#btn_sch').on('click',function(){
        let skey = $('#skey').val();
        const data = {
            skey : skey
        };
        Make_Html(data);
    });

    $('#uploadExcel #Xbtn, #uploadExcel #Xbtn2').click(function () {
        $('#uploadExcel').css('display','none');
    });

    $('#addPQueue #Xbtn, #addPQueue #Xbtn2 #btn_delivery_close').click(function () {
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
                let gdstep_str = '';
                console.log(arr);
                $.each(arr, function(index, el) {
                    if(el.gdstep==1){
                        $('#ck_' + el.orcode).data('orstep',el.orstep);
                    }else{
                        $('#ck_' + el.orcode).remove();
                    }
                    $('#st_' + el.orcode).html(Return_gdstepName(el.gdstep));
                    $('#bu_' + el.orcode).html(`<button type="button" class="btnType3 " data-rttype="2" onclick="add_packingQueue('${el.orcode}');">지시완료</button>`);
                    $('#da_' + el.orcode).text(el.moddate);
                });
                Make_Toast('선택하신 주문의 포장지시를 완료 하였습니다.');
            }
        }
    });

    $('#btn_package').on('click',async function(){
        let checked = $('input[name="chkorder"]:checked');
        if (checked.length == 0) {
            Make_Toast('묶음포장 지시 하실 주문을 선택하세요');
        }else if (checked.length == 1) {
            Make_Toast('묶음포장 지시는 한 봉 이상 선택하세요');
        }else if(window.confirm('선택하신 주문을 묶음배송 하시겠습니까?')){
            let codes = $("input[name='chkorder']:checked").map(function() {
                return this.value;
            }).get();
            let tcnt = codes.length;
            if(tcnt > 0){
                let arr = await Put_Package(codes);
                console.log(arr);
                $.each(arr, function(index, item) {
                    $('#ck_' + item.orcode).data('orstep',1);
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
                    $('#ck_' + item.orcode).data('orstep',1);
                    $('#bu_' + item.orcode).html(`<button type="button" class="btnType3" data-rttype="3"  onclick="add_packingQueue('${item.orcode}');">지시완료</button>`);
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
        }else {
            let datas = [];
            let orstepSCount = 0;
            let orstepFCount = 0;
            checked.each(function () {
                let method = $(this).data('method');
                let orstep = $(this).data('orstep');
                if ((method !== 'API') || (orstep != 1)) {
                    orstepFCount++;
                } else {
                    let row = {
                        orcode: $(this).val()
                    };
                    datas.push(row);
                    orstepSCount++;
                }
            });

            if (orstepFCount > 0) {
                Make_Toast('선택하신 항목중에 주문확인처리가 불가능한 주문이 존재합니다.<br>[포장지시가 안되었거나, 쇼핑몰주문만 가능합니다.]')
            } else {
                let successCount = 0;
                let failCount = 0;

                for (const item of datas) {
                    let confirmedCode = await Put_Order_Confirm(item.orcode);
                    if (confirmedCode) {
                        $('#st_' + confirmedCode).text('주문확인');
                        successCount++;
                    } else {
                        failCount++;
                    }
                }
                if (failCount > 0) {
                    console.log(`${failCount}건의 처리에 실패했습니다.`);
                } else {
                    Make_Toast('주문 확인처리 완료 하였습니다.');
                    $('#cList').empty();
                    let search = $('#skey').val();
                    const params = {
                        skey: search
                    };
                    Make_Html(params);
                }
            }
        }
    });


    $(document).on('click','button[name="shop_orderconfirm"]',function(){

    });

    $("#total_check").on("click", function() {
        $("input[name='chkorder']").prop("checked", $(this).is(":checked"));
    });


});

async function Put_Order_Confirm(orcode){
    let data = '';
    try {
        start_spinner();
        let dataarr = {"orcode" : orcode};
        let url = APIURL + '/Shop_Order_Confirm';
        let result = await Load_API_Auth(url,dataarr);
        console.log(result);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').orcode;
        }else{
            Make_Toast( "주문확인 처리에 실패하였습니다.<br>[" + result.get('message') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}

async function Make_Html(params){
    let arr = await Load_Data(params);
    let html = '';
    console.log(arr);
    if(!fn_IsEmpty(arr)) {
        $.each(arr, function (index, el) {
            let subhtml1 = '';
            let subhtml2 = '';
            let cnxl_status = '';
            let cnxl_css = '';
            let cnxl_fn1 = '';
            let status_str = '';
            if(el.orstep==0) {
                subhtml2 = `<button type="button" class="btnType3 btn_gray" data-rttype="1" onclick="add_packingQueue('${el.orcode}');">지시대기</button>`;
            }else{
                subhtml2 = `<button type="button" class="btnType3 " data-rttype="2" onclick="add_packingQueue('${el.orcode}');">지시완료</button>`;
            }

            if(el.gdstep == 0) {
                subhtml1 = `<input type="checkbox" id="ck_${el.orcode}" name="chkorder" value="${el.orcode}" data-method="${el.shopmethod}" data-orstep="${el.orstep}">`;
                cnxl_status = `<button type="button" class="btnType3 fs14" value="${el.orcode}" onclick="Del_ThisOrder('${el.orcode}');">주문취소</button>`;
            }else if(el.gdstep == 1) {
                subhtml1 = `<input type="checkbox" id="ck_${el.orcode}" name="chkorder" value="${el.orcode}" data-method="${el.shopmethod}" data-orstep="${el.orstep}">`;
                cnxl_status = `<button type="button" class="btnType3 fs14" value="${el.orcode}" onclick="Del_ThisOrder('${el.orcode}');">주문취소</button>`;
            }else if(el.gdstep == 2) {
                cnxl_status = ``;
                subhtml1 = ``;
            }else if(el.gdstep == 3) {
                cnxl_status = ``;
            }


            if(el.is_cancel == 0) {
                cnxl_css = ``;
                cnxl_fn1 = `onclick="go_orderEditor('${el.orcode}','${el.shopmethod}','${el.is_cancel}');"`;
            }else{
                cnxl_css = `cxled_order`;
                cnxl_status = `<p class="data fs14">취소됨</p>`
                subhtml2 = `-`;
                cnxl_fn1 = `onclick="go_orderEditor('${el.orcode}','${el.shopmethod}','${el.is_cancel}');"`;
            }

            html +=`
                <tr class="${cnxl_css}" id="list_${el.orcode}">
                    <td class="ltTbody td40 fixedCol" >
                        <div class="inner40 flexCol2" >${subhtml1}</div>
                    </td>
                    <td class="ltTbody productNo fixedCol" name="packingStep"><div class="inner1 flexCol2"><p class="text" id="bu_${el.orcode}">${subhtml2}</p></div></td> 
                    <td class="ltTbody fixedCol " data-copy="copy"><div class="inner2 flexCol2"><p class="text">${el.orcode}</p><p class="text">${el.spcode}</p></div></td>
                    <td class="ltTbody scrollableCol "><div class="inner4 flexCol2 "><p class="text" id="st_${el.orcode}">${Return_gdstepName(el.gdstep)}</p></div></td>
                    <td class="ltTbody fixedCol "><div class="inner2 flexCol2 last_inner"><p class="text">${el.pd_code}</p><p class="text">${el.sg_code}</p></div></td>
                    <td class="ltTbody scrollableCol" ${cnxl_fn1}><div class="inner4 flexType1 g_name"><a href="javascript:;" class="text mr10" >${el.p_name}</a></div></td>
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2 fs14"><p class="text">${el.buy_name}</p><p class="text">${el.buy_phone}</p><p class="text">${el.receive_name}</p><p class="text">${el.receive_phone}</p></div></td>
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text">${el.tcnt} 팩</p><p class="text">${number_format(el.tprice)}원</p></div></td> 
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text">${el.orderdate}</p></div></td>
                    
                    <td class="ltTbody scrollableCol"><div class="inner4 flexCol2"><p class="text" id="da_${el.orcode}">${el.moddate}</p></div></td>    
                    <td class="ltTbody scrollableCol "><div class="inner4 flexCol2 "><p class="text">${el.shopstr}</p><p class="text">${el.sell_id}</p></div></div></td> 
                    <td class="ltTbody scrollableCol ">${cnxl_status}</td>
                </tr>
            `;
        });
        $('.order_list_tbl_wrap').css('width','81vw');
        $('.order_list_tbl').css('width','80vw');
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


async function Load_Data(params){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"skey" : params.skey};
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
            Make_Toast(result.get('message'));
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }finally {
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

function Return_gdstepName(gdstep){
    let gdstep_str = '';
    if(gdstep == 0) {
        gdstep_str = '등록완료';
    }else if(gdstep == 1) {
        gdstep_str = '지시완료';
    }else if(gdstep == 2) {
        gdstep_str = '확인완료';
    }else if(gdstep == 3) {
        gdstep_str = '배송시작';
    }

    return gdstep_str;

}