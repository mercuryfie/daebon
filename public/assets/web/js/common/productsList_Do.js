$(document).ready(function() {
    let search = '';
    const data = {
        skey : search
    };
    Make_Html(data);

    $(document).on('click','button[name="btn_process"]',async function(){
        let quantity = $(this).closest('.flexType1').find('input[name="quantity"]').val();
        let code = $(this).closest('.flexType1').find('input[name="quantity"]').data('code');

        let bool = await Make_instructions(code,quantity);
        console.log(bool);
        if(bool==true){
            if(window.confirm('작업지시를 발급하였습니다\n생산목록으로 이동하시겠습니까?')==true){
                go_productionList();
            }else{
                location.reload();
            }
        }
    });
});

async function Make_instructions(code,cnt){
    let r_bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code,"cnt" : cnt};
        let url = APIURL + '/Add_Goods_Instructions';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            r_bool = (data.seq > 0) ? true : false;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_bool;
}



async function Make_Html(data){
    let arr = await Data_Load(data);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltTbody">
                        <input type="checkbox" name="goodsseq" id="goodsseq" value="${el.seq}">
                    </td>
                    <td class="ltTbody">${el.gcode}</td>
                    <td class="ltTbody ">
                        <a href="javascript:;" onclick="go_productsEditor('${el.gcode}');" class="goodsName">${el.gname}</a>
                    </td>
                    <td class="ltTbody">${el.quantity}</td>
                    <td class="ltTbody">${el.inventory}</td>
                    <td class="ltTbody">${el.avg.total}</td>
                    <td class="ltTbody">${el.avg.input}</td>
                    <td class="ltTbody">${el.avg.output}</td>
                    <td class="ltTbody">${el.avg.avg}</td>
                    <td class="ltTbody">${el.completecnt}</td>
                    <td class="ltTbody orderProduct">
                        <div class="flexType1">
                            <input type="search" name="quantity" class="countInput mr10" placeholder="수량(예:10)" data-code="${el.gcode}">
                            <button type="button" class="submitBtn1" name="btn_process">확인</button>
                        </div>
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
        let url = APIURL + '/Load_Goods_List';
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