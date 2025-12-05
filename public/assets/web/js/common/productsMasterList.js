$(document).ready(function() {
    let skey = '';
    Make_Html(skey);

    $(document).on('click','button[name="btn_process"]',async function(){
        let quantity = $(this).closest('.flexType1').find('input[name="quantity"]').val();
        let code = $(this).closest('.flexType1').find('input[name="quantity"]').data('code');

        let bool = await Make_instructions(code,quantity);
        console.log(bool);
        if(bool==true){
            if(window.confirm('작업지시를 발급하였습니다\n생산목록으로 이동하시겠습니까?')==true){
                go_productionList();
            }else{
                $(this).closest('.flexType1').find('input[name="quantity"]').val('');
                location.reload();
            }
        }
    });

    $(document).on('click','button[name="btn_print"]',function(){
        let code = $(this).data('code');
        let url = "/goods/instructionform?cd=" + code;
        pop_OrderRoastForm(url);
    });

    $(document).on('keydown','input[name="quantity"]',function(e){
        if (e.key === "Enter") {
            e.preventDefault(); // 폼 전송 방지
            $(this).closest('.flexType1').find('button[name="btn_process"]').trigger('click');
        }

    });

    $('#btn_search').on('click', function () {
        doSearch();
    });

    $('#txt_search').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doSearch();
        }
    });

});

function doSearch() {
    let skey = $('#txt_search').val();
    $('#clist').empty();
    Make_Html(skey);
}

async function Make_instructions(code,cnt){
    let r_bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code,"cnt" : cnt};
        let url = APIURL + '/Add_Instructions';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            r_bool = (data.gicode !='') ? true : false;
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

async function Make_Html(skey){
    let arr = await Data_Load(skey);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltTbody"> <a href="javascript:;" class="goodsName underline2">${el.gcode}</a></td> 
                    <td class="ltTbody ">
                        <a href="javascript:;" onclick="go_productsEditor('${el.gcode}');" class="goodsName underline2 ">${el.gname}</a>
                    </td>
                    <td class="ltTbody">${number_format(el.quantity)}개</td>
                    <td class="ltTbody">${number_format(el.completecnt)}건</td>  
                    <td class="ltTbody">${number_format(el.quantity)}단계</td> 
                    <td class="ltTbody orderProduct">
                        <div class="flexType1">
                            <input type="search" name="quantity" class="countInput mr10" placeholder="수량(예:10)" data-code="${el.gcode}">
                            <button type="button" class="submitBtn1" name="btn_process">확인</button>
                        </div>
                    </td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 printBtn" name="btn_print" data-code="${el.gcode}">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 trashBtn" id="del_${arr.seq}" name="btn_del"  data-code="${el.mtcode}"> 
                            <i class="fa-solid fa-trash"></i>
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


async function Data_Load(skey){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"search" : skey};
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


