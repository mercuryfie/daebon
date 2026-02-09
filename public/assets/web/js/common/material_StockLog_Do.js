$(document).ready(function() {
    const mtcode = $('#mtcode').val();
    Make_Html(mtcode);

    $('#btn_showlist').on('click',function(){
        go_inOutMaterial();
    });

});

async function Make_Html(code){
    try {
        const arr = await Load_Data(code);
        console.log(arr);
        let html = '';
        if (arr.tcnt > 0) {
            $.each(arr.list, function (index, el) {
                html += `
                    <tr>
                        <td class="ltTbody">${el.total} ${el.unit}</td>
                        <td class="ltTbody">${el.m_input} ${el.unit}</td>
                        <td class="ltTbody">${el.m_output} ${el.unit}</td>
                        <td class="ltTbody">${el.reason}</td>
                        <td class="ltTbody">${el.memo}</td>
                        <td class="ltTbody">${el.indate}</td>
                    </tr>
                `;
            });
            $('#stockname').text(arr.mtname);
            $('#tList').empty();
            $('#tList').append(html);
        } else {
            html = '<tr><td class="ltThead" colspan="9">검색된 데이터가 없습니다.</td></tr>';
            $('#tList').empty();
            $('#tList').append(html);
        }
    }catch (error){
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
}

async function  Load_Data(code){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"mtcode": code};
        let url = APIURL + '/get_Material_Stock_Log';
        let result = await Load_API_Auth(url, dataarr);
        console.log(result);

        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = {
                mtname : result.get('data').mtname,
                list : result.get('data').list,
                tcnt : result.get('data').tcnt
            };
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

