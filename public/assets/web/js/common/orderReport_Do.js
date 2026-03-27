$(document).ready(function(){
    Make_Html();
});


async function Make_Html(){
    let arr = await Load_Data();
    console.log(arr);
    let html = '';
    if(!fn_IsEmpty(arr)) {
        let firstDate = Object.keys(arr)[0];
        let mall_keys = Object.keys(arr[firstDate]); // ['type0', 'type1', 'type2'...]
        $.each(arr, function (date, shops) {
            html += '<tr>';
            html += `  <td>${date}</td>`;
            $.each(mall_keys, function (i, key) {
                let val = shops[key] || 0;
                html += `  <td>${val}건</td>`;
            });
            html += '</tr>';
        });

        $('#tList').append(html);
    }
}


async function Load_Data(){
    let data = {};
    try {
        start_spinner();
        let dataarr = {};
        let url = APIURL + '/Load_Report_Order';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    } finally {
        stop_spinner();
    }
    return data;
}