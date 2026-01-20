$(document).ready(function() {

    let search = '';
    // const data = {
    //     skey : search
    // };

    Load_Data();

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

    $(document).on('click','button[name="btn_pw_reset"]',async function(){
        let uid = $(this).data('uid');
        if(window.confirm('비밀번호를 초기화하시겠습니까?')==true){
            let bool = await Reset_Password(uid);
            if(bool==true) {
                Make_Toast('초기화하였습니다.');
                location.reload();
            }
        }
    });


});


async function Load_Data() {
    try {
        start_spinner();
        let dataarr = {};
        // let fkey = data.fkey;
        let url = APIURL + '/Load_UserList';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if (result.get('status') == 'ok') {
            let html = '';
            let data = result.get('data');
            // let tCnt = data.tCnt;
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            console.log('dawn1801', arr);
            if (Cnt > 0) {
                $.each(arr, function (index, el) {
                    html += `
                    <tr id="tr_${el.uid}">
                        <td class="ltTbody col1" data-uid="${el.uid}">${el.userid}</td>
                        <td class="ltTbody col2">
                            <a href="javascript:;" class="" onclick="mod_UserInfo('${el.uid}');">${el.name}</a>
                        </td>
                        <td class="ltTbody col1" data-uid="${el.uid}">${el.grade}</td> 
                        <td class="ltTbody col2"> 
                            <button type="button" class="btnType3 ref_btn" name="btn_pw_reset" data-uid="${el.uid}">
                                <i class="fa-solid fa-rotate-right" name=""></i>
                            </button> 
                        </td> 
                        <td class="ltTbody col6">
                            <button type="button" class="btnType3 trashBtn" id="del_${el.uid}" name="btn_del_user" data-uid="${el.uid}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
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

            $('#ulist').empty();
            $('#ulist').append(html);
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

async function Del_User(uid){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"uid" : uid};
        let url = APIURL + '/Del_UserInfo';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}


async function Reset_Password(uid){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"uid" : uid};
        console.log('dawn1121',dataarr);
        let url = APIURL + '/Reset_Password';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
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