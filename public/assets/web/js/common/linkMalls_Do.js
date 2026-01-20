
$(document).ready(function() {

    Make_Html('API');

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

    $(document).on('click','button[name="btn_showlog"]',function(){
        let shoptype = $(this).data('typ');
        console.log(shoptype);
        go_linkMallsLogs(shoptype);
    });

    $('#btn_mall').on('click',function(){
        Make_Toast('API 테스트중입니다.');
    });

    $(document).on('click','button[name="btn_loadshop"]',async function(){
        let shoptype = $(this).data('typ');
        console.log(shoptype);
        let arr = await Load_Shop_Order_List(shoptype);
        console.log(arr);
    });




});

async function Load_Shop_Order_List(styp){
    let data = {};
    try {
        start_spinner();
        let dataarr = {styp:styp};
        let url = APIURL + '/Shop_Opder_List';
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

async function Make_Html(skey){
    let arr = await Load_Data(skey);

    console.log(arr);
    let html = '';
    if(arr.length > 0) {
        $.each(arr, function (index, el) {
            let indate1 = '';
            let status1 = '';
            let indate2 = '';
            let status2 = '';
            if(el.method=='API'){
                indate1 = el.order['indate'];
                if(el.order['status']=='ok'){
                    status1 =`<p class="status positive">정상</p>`;
                }else{
                    status1 =`<button type="button" class="status missing" onclick="go_missingList();">누락</button>`;
                }

                indate2 = el.claim['indate'];
                if(el.claim['status']=='ok'){
                    status2 =`<p class="status positive">정상</p>`;
                }else{
                    status2 =`<p class="status negative">오류</p>`;
                }
            }

            html += `
                    <tr>
                        <td class="ltTbody">${el.shop_name}</td>
                        <td class="ltTbody">${el.shop_id}</td>
                        <td class="ltTbody">${el.method}</td>
                        <td class="ltTbody">${indate1}</td>
                        <td class="ltTbody">${status1}</td>
                        <td class="ltTbody">${indate2}</td>
                        <td class="ltTbody">${status2}</td>
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
