$(document).ready(function() {

    let search = $('#txt_search').val();
    Make_html(search)

    $('#txt_search').on('keyup', function(e) {
        if (e.keyCode === 13) { // 13은 엔터 키 코드
            $('#clist').empty();
            let search = $(this).val();
            Make_html(search)
        }
    });

    $('#btn_search').on('click',function(){
        $('#clist').empty();
        let search = $('#txt_search').val();
        Make_html(search)
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


});




async function Make_html(search){
    let arr = await Load_Data(search);
    console.log(arr);
    let html = '';
    if(arr.total > 0){
        $.each(arr.list, function (index, el) {
            html += `
                <tr>
                    <td class="ltTbody">${el.pscode}</td>
                    <td class="ltTbody">${el.fk_gicode}</td>
                    <td class="ltTbody">${el.step_name}</td>
                    <td class="ltTbody">${el.total_input}g</td>
                    <td class="ltTbody">${el.total_output}g</td>
                    <td class="ltTbody">${el.indate}</td>
                </tr>
            `;

        });
    }else{
        html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    $('#tcnt').html(arr.total);

}


async function Load_Data(skey){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"skey" : skey};
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


