$(document).ready(function() {


    Load_Data();


    $(document).on('click','#btn_print',function(){
        printWindow('frnbody');
    });

});

function Load_NoticeInfo(bcode) {
    let $contentBox = $('#con_' + bcode);
    let $other = $("div[name='n_content_box']");

    if ($contentBox.is(':visible')) {
        // 보이면 slideUp
        $contentBox.slideUp(300);
    } else {
        // 안 보이면 내용 로드 후 slideDown
        // $other.hide();
        $contentBox.slideDown(300);
    }
}

async function Load_Data() {
    try {
        start_spinner();
        let dataarr = {};
        let url = APIURL + '/Load_NoticeList';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if (result.get('status') == 'ok') {
            let html = '';
            let data = result.get('data');
            // let tCnt = data.tCnt;
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            let num = 0;
            let fixCount = 0;

            arr.forEach(el => {
                if (el.is_Fix == 1) fixCount++;
            });

            arr.sort((a, b) => {
                return (b.is_Fix - a.is_Fix) || (a.regidate - b.regidate);
            });

            if (Cnt > 0) {
                $.each(arr, function (index, el) {

                    let d_num = num + 1 - fixCount;
                    let fix_css = el.is_Fix == 1 ? `<p class="type">공지</p>` : `${d_num}`;
                    let tr_bg = el.is_Fix == 1 ? `active` : ``;
                    num += 1;

                    html += ` 
                    <tr id="tr_${el.bcode}" onclick="Load_NoticeInfo('${el.bcode}');" class="${tr_bg}">
                        <td class="ltTbody col1" >${fix_css}</td>
                        <td class="ltTbody col2">
                            <a href="javascript:;" class="" onclick="">${el.bTitle}</a>
                            <div class="content_box" name="n_content_box" id="con_${el.bcode}">
                                ${el.bContent}
                                <div class="edit_box flexType5-1 mt10">
                                    <button type="button" class="btnType1 mr10" id="edit_${el.bcode}" name="btn_edit" onclick="go_noticeEditor('${el.bcode}');">수정</button>
                                    <button type="button" class="btnType1" id="del_${el.bcode}" name="btn_del" onclick="Del_Content('${el.bcode}');">삭제</button>
                                </div> 
                            </div>
                        </td>
                        <td class="ltTbody col1" data-bcode="${el.bcode}">${el.w_name}</td> 
                        <td class="ltTbody col2"> 
                            ${el.regidate} 
                        </td>  
                    </tr>
                    `;
                });
            } else {
                html = `
                    <tr>
                        <td class="ltTbody" colspan="4">데이터가 없습니다.</td> 
                    </tr>
                `;
            }

            $('#nList').empty();
            $('#nList').append(html);
            // $('#tcnt').html(number_format(data.tCnt));
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }

}


async function Mod_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_Material_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}


$(document).on('click','button[name="btn_del_user"]',async function(){
    let uid = $(this).data('uid');
    if(window.confirm('삭제하시겠습니까?')==true){
        let bool = await Del_User(uid);
        if(bool==true) {
            Make_Toast('삭제 하였습니다.');
            // $('#tr_' + uid).remove();
            location.reload();
        }
    }
});



async function Del_Content (bcode){
    if(window.confirm('삭제하시겠습니까?')==true){
        let bool = await Del_NoticeInfo(bcode);
        if(bool==true) {
            Make_Toast('삭제하였습니다.');
            location.reload();
        }
    }
}

async function Del_NoticeInfo (bcode){
    // let arr = [];
    // let bcode = ('#bcode').val();
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"bcode" : bcode};
        let url = APIURL + '/Del_NoticeInfo';
        let result = await Load_API_Auth(url,dataarr);
        let html = '';
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}