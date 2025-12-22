$(function() {
    let code = $('#gicode').html();
    if(code!=''){
        Make_html(code);
    }

    $(document).on('keypress', '#in_code', function(e) {
        if (e.key === 'Enter') {
            $('#tList').empty();
            let code = $(this).val();
            if(code!=''){
                Make_html(code);
                $('#gicode').html(code);
                form_ini();
            }

        }
    });

    $(".under").click(function() {
        go_producingDetail();
    });

    form_ini();
});

function form_ini(){
    $('#in_code').val('');
    $('#in_code').focus();
}


async function Make_html(gicode){
    let data = await Data_Load(gicode);
    let tcnt = data.total;
    let arr = data.list;
    let html = '';
    let i = 0;
    if(tcnt>0){
        $.each(arr, function (index, el) {
            i++;
            html += `
                <tr>
                    <td class="ltTbody">${i}</td>
                    <td class="ltTbody under" onclick="go_productionDetail();">${el.prcode}</td>
                    <td class="ltTbody">${el.step_name}</td>
                    <td class="ltTbody">${el.input}g</td>
                    <td class="ltTbody">${el.output}g</td>
                    <td class="ltTbody under" onclick="go_productionDetail();">${getNameByProcess(el.status)}</td>
                    <td class="ltTbody"></td>

                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltTbody" colspan="7">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#tList').append(html);
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

