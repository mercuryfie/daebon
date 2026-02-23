$(document).ready(function() {

    $('#xBtn').click(function () {
        window.close();
    });

    $(document).on('click','button[name="prnRoastForm"]',function() {
        let code = $(this).data('code');
        pop_OrderRoastForm(code);
    });

    $(document).on('click','tr[name="view_detail"]',function(){
        let code = $(this).data('code');

    });

    $(document).on('click','button[name="vwReport"]',function() {
        let code = $('#gicode').data('cd');
        let url = "/report/q_form?cd=" + code;
        pop_qualityReportForm(url);
    });

    let gicode = $('#gicode').val();
    Make_Html(gicode);

});


async function Make_Html(code){
    let arr = await Data_Load(code);
    console.log(arr);
    let html = '';
    let stepnow = $('#stepnow').val();
    if(!fn_IsEmpty(arr.list)){
        let icnt = arr.icnt;
        $.each(arr.list, function (index, el) {
            let method = fnGetProcessNameByCode(el.step_typ);
            let gubun = method['gubun'];
            let guess ='';
            let t_str = '';
            let real = '-';
            let status = '-';
            let worker = '-';
            if(gubun==1){
                guess = number_format(el.input*icnt) + 'g';
                t_str = number_format(el.end) + 'g';
            }else{
                guess = number_format(el.input*icnt) + 'g / ' + number_format(el.output*icnt);
                t_str = number_format(el.start) + 'g / ' + number_format(el.end);
            }
            if(Number(stepnow) >= Number(el.step_num)){
                status = el.status;
                worker = el.worker;
                real = t_str;
            }

            html += `
                <tr class="" data-nd="${el.prcode}"> 
                    <td class="ltTbody numbering">${el.step_num}</td>
                    <td class="ltTbody  ">${el.step_name}</td>  
                    <td class="ltTbody  ">${guess}</td>
                    <td class="ltTbody  ">${real}</td>
                    <td class="ltTbody  ">${status}</td>    
                    <td class="ltTbody  ">${worker}</td>  
                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#tList').append(html);
    // $('#tcnt').html(arr.total);
}



async function Data_Load(code){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Load_Instructions_Process';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let arr = (data && data.list) ? data.list : [];
            let tcnt = (data && data.tcnt) ? data.tcnt : 0;
            let icnt = (data && data.icnt) ? data.icnt : 0;
            r_arr = {
                list : arr,
                total : tcnt,
                icnt : icnt
            };
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }finally {
        stop_spinner();
    }
    return r_arr;
}
