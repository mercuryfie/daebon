$(document).ready(function() {



});



async function Reset_Password(uid){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"uid" : uid};
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

async function Mod_Account() {
    // let title = '제조사등록';
    // let poptype = '1';
    // let poptext = '등록';
    // let bool = false;
    let uid = $('#userid').data('uid');

    try {
        let u_name = $('#u_name').val();
        let pw_now = $('#pw_now').val();
        let pw_1 = $('#pw_1').val();
        let pw_2 = $('#pw_2').val();
        let grade = $('#grade').val();

        if (pw_1 != pw_2) {
            Make_Toast('비밀번호가 일치하지 않습니다.');
            return;
        }

        if (u_name == '') {
            $('#u_name').focus();
            Make_Toast('성함을 입력하세요.');
        } else if (grade=='') {
            $('#grade').focus();
            Make_Toast('권한을 선택하세요.');
        } else {
            const dataarr = {
                uid: uid,
                u_name: u_name,
                pw_now: pw_now,
                pw_1: pw_1,
                pw_2: pw_2,
                grade: grade
            };

            let pw_check = await Cur_Pw_Check(uid,pw_now);
            let bool = await Mod_UserInfo(dataarr);
            if (pw_check == false) {
                Make_Toast('현재 비밀번호가 틀렸습니다.');
            } else if (bool == true) {
                Make_Toast('수정하였습니다');
                go_userList();
            } else {
                Make_Toast('수정에 실패했습니다.');
            }
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
}

async function Cur_Pw_Check(uid,pw_now) {
    let bool = false;

    try {
        start_spinner();
        let dataarr = {"uid" : uid, "pw_now" : pw_now};
        let url = APIURL + '/Check_CurPw';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'ok') {
            stop_spinner();
            bool = true;
        } else {
            stop_spinner();
            Make_Toast('현재 비밀번호가 틀렸습니다.');
            return false;
        }
    } catch (error) {
        stop_spinner();
        Make_Toast('현재 비밀번호가 틀렸습니다.');
        return false;
    }
    return bool;

}

async function Mod_UserInfo(data){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_UserInfo';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'ok') {
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
