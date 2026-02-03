$(document).ready(function() {



});



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
            console.log('dawn1814', dataarr);
            let bool = await Mod_UserInfo(dataarr);
            if (bool == true) {
                Make_Toast('등록하였습니다');
                // go_userList();
            } else {
                Make_Toast('22등록에 실패했습니다.');
            }
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
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
            console.log('dawn1708',result);
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}

// async function Mod_Account(){
//     let uid = $('#userid').data('uid');
//     console.log('dawn1802', uid);
//     let arr = [];
//     try {
//
//         start_spinner();
//
//
//         let userid = $('#userid').val();
//         let u_name = $('#u_name').val();
//         let pw_1 = $('#pw_1').val();
//         let pw_2 = $('#pw_2').val();
//         let grade = $('#grade').val();
//
//         let dataarr = {"data" : data};
//         let url = APIURL + '/Mod_Material_Info';
//         let result = await Load_API_Auth(url,dataarr);
//         if (result.get('status') == 'NoLogin') {
//             go_login();
//         }else if(result.get('status') == 'ok') {
//             let data = result.get('data');
//             arr = (data && data.list) ? data.list : [];
//         }else{
//             Make_Toast(result.get('message') + "[" + result.get('status') + "]");
//         }
//         stop_spinner();
//     } catch (error) {
//         Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
//         stop_spinner();
//     }
//     return arr;
// }