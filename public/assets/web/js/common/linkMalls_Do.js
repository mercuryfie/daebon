
$(document).ready(function() {

    Make_Html('API');

    $('.datepicker').each(function(index, elem) {
        const fp = flatpickr(elem, {
            dateFormat: "Y-m-d",
            defaultDate: new Date(),
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

    $(document).on('click','button[name="btn_showlog"]',function(){
        let shoptype = $(this).data('typ');
        console.log(shoptype);
        go_linkMallsLogs(shoptype);
    });

    $('#btn_mall').on('click',function(){
        Make_Toast('API 테스트중입니다.');
    });

    $(document).on('click','button[name="btn_loadshop"]',async function(){
        let selectdate = $('#s_date').val();
        let shoptype = $(this).data('typ');
        console.log(shoptype);
        let message = await Load_Shop_Order_List(shoptype,selectdate);
        if(message!='') {
            Make_Toast(message);
        }

    });

});

async function Load_Shop_Order_List(styp,selectdate){
    let message = '';
    try {
        start_spinner();
        let dataarr = {styp:styp,selectdate:selectdate};
        let url = APIURL + '/Shop_Order_List';
        let result = await Load_API_Auth(url,dataarr);
        console.log(result);
        if (result.get('status') == 'NoLogin') {
            message = '로그인하세요.';
        }else if(result.get('status') == 'ok') {
            message = '주문정보 등록 완료 하였습니다.';
            $('#tp_'+ styp).find('#id1_' + styp).html(`<p class="status positive">정상</p>`);
            $('#tp_'+ styp).find('#id2_' + styp).html(result.get('data').period);
            $('#tp_'+ styp).find('#id3_' + styp).html(result.get('data').indate);
        }else if(result.get('status') == 'nothing') {
            message = '해당쇼핑몰의 주문정보가 없습니다.';
            $('#tp_'+ styp).find('#id1_' + styp).html(`<p class="status positive">정상</p>`);
            $('#tp_'+ styp).find('#id2_' + styp).html(result.get('data').period);
            $('#tp_'+ styp).find('#id3_' + styp).html(result.get('data').indate);
        }else if(result.get('status') == 'miss') {
            message = '주문정보 동기화에 누락된 주문이 존재합니다.';
            $('#tp_'+ styp).find('#id1_' + styp).html(`<button type="button" class="status missing" onclick="go_missingList('${styp}');">누락</button>`);
            $('#tp_'+ styp).find('#id2_' + styp).html(result.get('data').period);
            $('#tp_'+ styp).find('#id3_' + styp).html(result.get('data').indate);
        }else{
            Make_Toast(result.get('message'));
        }

        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return message;
}

async function Make_Html(skey){
    let arr = await Load_Data(skey);
    let html = '';
    if(arr.length > 0) {
        $.each(arr, function (index, el) {
            let status1 = '';
            if(el.period==''){
                status1 = '';
            }else if(el.status=='miss') {
                status1 = `<button type="button" class="status missing" onclick="go_missingList('${el.shoptyp}');">누락</button>`;
            }else {
                status1 = `<p class="status positive">정상</p>`;
            }

            html += `
                    <tr id="tp_${el.shoptyp}">
                        <td class="ltTbody">${el.shop_name}</td>
                        <td class="ltTbody">${el.shop_id}</td>
                        <td class="ltTbody">${el.method}</td>
                        <td class="ltTbody" id="id1_${el.shoptyp}">${status1}</td>
                        <td class="ltTbody" id="id2_${el.shoptyp}">${el.period}</td>
                        <td class="ltTbody" id="id3_${el.shoptyp}">${el.indate}</td>
                        <td class="ltTbody" >${el.memo}</td>
                        <td class="ltTbody">
                            <button type="button" class="btnType3" name="btn_showlog" data-typ="${el.shoptyp}">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                        </td>
                        <td class="ltTbody">
                            <button type="button" class="btnType3" name="btn_loadshop" data-typ="${el.shoptyp}">
                                <i class="fa-solid fa-link"></i>
                            </button>
                        </td>
                    </tr>
            `;
        });
        $('#tList').empty();
        $('#tList').append(html);
    }else{
        html = '<tr><td class="ltThead" colspan="9">검색된 데이터가 없습니다.</td></tr>';
        $('#tList').empty();
        $('#tList').append(html);
    }
}

async function Load_Data(skey){
    let data = {};
    try {
        start_spinner();
        let dataarr = {typ:skey};
        let url = APIURL + '/Load_Mall_List';
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
