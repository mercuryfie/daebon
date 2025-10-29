$(document).ready(function() {
    let search = '';
    const data = {
        skey : search
    };
    Make_Html(data);

    $('#order_wrapdek #Xbtn, #order_wrapdek #Xbtn2').click(function () {
        $('#order_wrapdek').css('display','none');
    });

    $(document).on('click','button[name="view_production"]',function(){
        let code = $(this).data('code');
        go_productionStatus(code);
    });

    $(document).on('click','button[name="prnRoastForm"]',function() {
        let code = $(this).data('code');
        pop_OrderRoastForm(code);
    });

});

async function Make_Html(data){
    let arr = await Data_Load(data);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltTbody">
                        <input type="checkbox" name="chk_seq" value="${el.seq}">
                    </td>
                    <td class="ltTbody">2025.01.01</td>
                    <td class="ltTbody">${el.gname}</td>
                    <td class="ltTbody">${el.gcode}</td>
                    <td class="ltTbody">${el.quantity}</td>
                    <td class="ltTbody">${el.step_cnt}</td>
                    <td class="ltTbody">${el.step_now}</td>
                        <td class="ltTbody">
                        <button type="button" class="btnType3 statusBtn" name="view_production" data-code="${el.gcode}" >현황보기</button>
                    </td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 statusBtn statusStandby" name="prnRoastForm" data-code="${el.gcode}">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    $('#tcnt').html(arr.total);
}



async function Data_Load(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"param" : data};
        let url = APIURL + '/Load_Produce_List';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            tcnt = (data && data.tcnt) ? data.tcnt : 0;
            r_arr = {
                list : arr,
                total : tcnt
            };
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_arr;
}



function pop_OrderForm() {
    $('#order_wrapdek').css('display','block');
}