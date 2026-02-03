$(document).ready(function() {
    $('#btn_dup').on('click',function(){

        let userid = $('#userid').val();
        let pw_2 = $('#pw_2').val();
        Dup_Id_Check(userid,pw_2);

    })
});

// let isDupChecked = false;
let lastCheckedUserId = '';

async function add_Account() {
    // let title = '제조사등록';
    // let poptype = '1';
    // let poptext = '등록';
    // let bool = false;
    let userid = $('#userid').val();
    let pw_2 = $('#pw_2').val();


    let dupResult = await Dup_Id_Check(userid, pw_2);
    if (dupResult == false ) {
        Make_Toast('아이디 중복확인을 먼저 해주세요.');
        return;
    } else if (userid != lastCheckedUserId) {
        Make_Toast('아이디 중복확인 다시 해주세요.');
        return;
    } else if (dupResult == true){
        try {
            let userid = $('#userid').val();
            let u_name = $('#u_name').val();
            let pw_1 = $('#pw_1').val();
            // let pw_2 = $('#pw_2').val();
            let grade = $('#grade').val();

            if (pw_1 !== pw_2) {
                Make_Toast('비밀번호가 일치하지 않습니다.');
            }

            if(userid==''){
                $('#userid').focus();
                Make_Toast('아이디를 입력하세요.');
            } else if (u_name == '') {
                $('#u_name').focus();
                Make_Toast('성함을 입력하세요.');
            } else if (pw_1 == '') {
                $('#pw_1').focus();
                Make_Toast('비밀번호를 입력하세요.');
            } else if (pw_2=='') {
                $('#pw_2').focus();
                Make_Toast('비밀번호 확인을 입력하세요.');
            } else if (grade=='') {
                $('#grade').focus();
                Make_Toast('권한을 선택하세요.');
            } else {
                const dataarr = {
                    userid: userid,
                    u_name: u_name,
                    pw_1: pw_1,
                    pw_2: pw_2,
                    grade: grade
                };
                let bool = await Add_UserInfo(dataarr);
                if (bool == true) {
                    // if (isOk) {
                    Make_Toast('등록하였습니다');
                    go_userList();
                } else {
                    Make_Toast('등록에 실패했습니다.');
                }
            }
        } catch (error) {
            Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        }
    } else {
        Make_Toast('오류가 발생하였습니다. ');

    }
}

function validateId(id) {
    const reg = /^[a-zA-Z0-9]{4,12}$/;
    return reg.test(id);
}

function validatePw(pw) {
    const reg = /^[a-zA-Z0-9]{4,12}$/;
    return reg.test(pw);
}

async function Dup_Id_Check(userid,pw_2) {
    // let isDupChecked = false;
    let bool = false;

    if (!validateId(userid)) {
        Make_Toast('아이디: 영문/숫자 4~12자 이내.');
        return false;
    }

    if (!validatePw(pw_2)) {
        Make_Toast('비밀번호: 영문/숫자 4~12자 이내.');
        return false;
    }

    try {
        start_spinner();
        let dataarr = {"userid" : userid};
        let url = APIURL + '/Check_UserId';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'ok') {
            stop_spinner();
            lastCheckedUserId = userid;
            Make_Toast('사용 가능한 아이디입니다.');
            bool = true;
        } else {
            stop_spinner();
            Make_Toast('이미 사용 중인 아이디입니다.');
            // isDupChecked = false;
            return false;
        }
    } catch (error) {
        stop_spinner();
        // isDupChecked = false;
        Make_Toast('중복 확인 중 오류가 발생했습니다.');
        return false;
    }
    return bool;

}

async function Add_UserInfo(data){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Add_UserInfo';
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
//
// async function Mod_Data(data,code){
//     let arr = [];
//     try {
//         start_spinner();
//         let dataarr = {"data" : data};
//         let url = APIURL + '/Mod_Maker_Info';
//         let result = await Load_API_Auth(url,dataarr);
//         let html = '';
//         if (result.get('status') == 'NoLogin') {
//             go_login();
//         }else if(result.get('status') == 'ok') {
//             let data = result.get('data');
//             arr = (data && data.list) ? data.list : [];
//             $('#addMakerWrap').css('display','none');
//
//             Make_Toast('등록되었습니다. ');
//         }else{
//             Make_Toast(result.get('message') + "[" + result.get('status') + "]");
//         }
//         stop_spinner();
//     } catch (error) {
//         Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
//         stop_spinner();
//     }
//     return arr;
// }
//
// async function Del_Data(code){
//     let bool = false;
//     try {
//         start_spinner();
//         let dataarr = {"code" : code};
//         let url = APIURL + '/Del_Maker_Info';
//         let result = await Load_API_Auth(url,dataarr);
//         if (result.get('status') == 'NoLogin') {
//             go_login();
//         }else if(result.get('status') == 'ok') {
//             bool = true;
//         }else{
//             Make_Toast(result.get('message') + "[" + result.get('status') + "]");
//         }
//         stop_spinner();
//     } catch (error) {
//         Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
//         stop_spinner();
//     }
//     return bool;
// }