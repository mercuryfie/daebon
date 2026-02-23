$(document).ready(function() {

    $('#txt_search').on('keyup', function(e) {
        if (e.keyCode === 13) { // 13은 엔터 키 코드
            $('#clist').empty();
            $('#cpage').data('page',1);
            Make_Html(Make_Search_Param())
        }
    });

    $('#btn_search').on('click',function(){
        $('#clist').empty();
        $('#cpage').data('page',1);
        Make_Html(Make_Search_Param())
    });


    $('#barcodeWrap #Xbtn, #barcodeWrap #Xbtn2').click(function () {
        $('#barcodeWrap').css('display','none');
    });

    $('#ipgoWrap #Xbtn, #ipgoWrap #Xbtn2').click(function () {
        $('#ipgoWrap').css('display','none');
    });

    $('#outWrap #Xbtn, #outWrap #Xbtn2').click(function () {
        $('#outWrap').css('display','none');
    });

    $("#supply").on("change", function() {
        if ($(this).val() === "bySelf") {
            $("#supply").hide();
            $("#suppCom").show().focus();
        } else {
            $("#suppCom").hide();
        }
    });

    $('#cpage').on('click',function(){
        $('#p_wrap').css('width','81vw');
        Make_Html(Make_Search_Param());
    });


    Make_Html(Make_Search_Param())

});

function Make_Search_Param(){
    let skey = $('#txt_search').val();
    let page = $('#cpage').data('page');

    let param = {
        skey : skey,
        page : page
    }
    return param;
}



async function Make_Html(data){
    let arr = await Load_Data(data);
    console.log(arr);
    let html = '';
    if(arr.total > 0){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltTbody">${el.gname}</td>
                    <td class="ltTbody">${el.pscode}</td>
                    <td class="ltTbody">${el.fk_gicode}</td>
                    <td class="ltTbody">${el.step_name}</td>
                    <td class="ltTbody">${el.total_input}g</td>
                    <td class="ltTbody">${el.total_output}g</td>
                    <td class="ltTbody">${el.indate}</td>
                    <td class="ltTbody"> 
                        <button type="button" class="btnType3 printBtn" name="btn_label" data-code="${el.fk_gicode}" onclick="">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </td>
                </tr>
            `;

        });
        $('#inout_half_wrap').css('height','600px');
        $('#cpage').data('page',(data.page+1));
    }else{
        Make_Toast('검색된 데이터가 없습니다.');
    }
    $('#clist').append(html);

    let nowcnt = $('#tcnt').html();
    if(nowcnt==='') nowcnt = 0;
    let newcnt = Number(nowcnt) + Number(arr.total);
    $('#tcnt').html(newcnt);

}


async function Load_Data(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"params" : data};
        let url = APIURL + '/Load_SemiProduct_Info';
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
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');

    } finally {
        stop_spinner();
    }
    return r_arr;
}






function pop_barcodeWindow() {
    let url = "/inout/popbarcodewindow";
    let width = 430;
    let height = 320;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 100);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}

function pop_barcodeLayer() {
    $('#barcodeWrap').css('display','block');
}

function pop_ipgoView() {
    $('#ipgoWrap').css('display','block');
}

function pop_chulgoView() {
    $('#outWrap').css('display','block');
}


