$(document).ready(function() {
    let search = '';
    const data = {
        skey : search
    };
    console.log(data);

    Make_Html(data);


});


async function Make_Html(data){
    let arr = await Data_Load(data);
    let html = '';
    if(!fn_IsEmpty(arr)){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltThead">${el.acode}</td>
                    <td class="ltThead">${el.aname}</td>
                    <td class="ltThead">${el.bcode}</td>
                    <td class="ltThead">${el.bname}</td>
                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltThead" colspan="4">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    $('#tcnt').html(arr.total);
}


async function Data_Load(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Load_Category_Info';
        let result = await Load_API_Auth(url,dataarr);

        console.log(result);


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