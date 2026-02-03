$(document).ready(function() {
    let stype = $('#stype').val();
    Make_Html(stype);

    $(document).on('click','button[name="btn_matching"]',async function(){
        let sgcode = $(this).data('sgcode');
        let orcode = $(this).data('orcode');

    });

});

async function process_miss(sgcode,orcode){
    let bool =false;
    try {
        start_spinner();
        let dataarr = {sgcode : sgcode,orcode:orcode};
        let url = APIURL + '/Put_Order_Miss';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if (result.get('status') == 'nothing') {
            Make_Toast('검색된 정보 없습니다.');
        } else if (result.get('status') == 'ok') {
            data = result.get('data');
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;

}


async function Make_Html(styp){
    let arr = await Load_Data(styp);
    console.log(arr);
    let html = '';
    $('#sname').html(arr.sname);
    if(arr.list.length > 0) {
        $.each(arr.list, function (index, el) {
            let btn_miss = '';
            if(el.pdcode==''){
                btn_miss = `
                    <button type="button" class="btnType3 match_btn" name="btn_matching" data-sgcode="${el.sgcode}" data-orcode="${el.orcode}">
                        <i class="fa-solid fa-link"></i>
                    </button>
                `;
            }else{
                btn_miss ='처리완료';
            }

            html += `
                <tr class="more_tr">
                    <td class="ltThead ">${el.orcode}</td>
                    <td class="ltThead">${el.spcode}</td>
                    <td class="ltThead">${el.sgname}</td>
                    <td class="ltThead">${el.miss}</td>
                    <td class="ltThead">${el.buy_name}</td>
                    <td class="ltThead">${el.orderdate}</td>
                    <td class="ltThead">${el.indate}</td>
                    <td class="ltThead ">${btn_miss}</td>
                </tr>
            `;
        });
        $('#mList').empty();
        $('#mList').append(html);
    }else{
        html = '<tr><td class="ltThead" colspan="8">검색된 데이터가 없습니다.</td></tr>';
        $('#mList').empty();
        $('#mList').append(html);
    }
}


async function Load_Data(stype) {
    let data = {};
    try {
        start_spinner();
        let dataarr = {styp : stype};
        let url = APIURL + '/Load_Order_Miss';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if (result.get('status') == 'nothing') {
            Make_Toast('검색된 정보 없습니다.');
        } else if (result.get('status') == 'ok') {
            data = result.get('data');
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}
