$(document).ready(function () {
    $(document).on("keypress",'#userid , #passwd', function (key) {
        if (key.keyCode == 13) {
            Login_Check();
        }
    });

    $(document).on("click",'#btn_login', function (key) {
        Login_Check();
    });


    $('#spinnerBox').css('display','none');
});

function Login_Check(){
    let userid = $('#userid').val();
    let pwd = $('#passwd').val();
    if(userid ==''){
        Make_Toast('아이디를 입력하세요');
        $('#userid').focus();
    }else if(pwd ==''){
        Make_Toast('비밀번호를 입력하세요.');
        $('#passwd').focus();
    }else {
        let iskeep = ($('input:checkbox[name="autolg"]').is(":checked") == true) ? 1 : 0;
        let issave = ($('input:checkbox[name="saveid"]').is(":checked") == true) ? 1 : 0;

        Login_Do(userid,pwd,iskeep,issave);

    }
}

async function Login_Do(userid,pwd,iskeep,issave){
    try{
        start_spinner();
        let dataarr = {"userid": userid, "passwd": pwd,'iskeep' : iskeep,'issave' : issave};
        console.log(dataarr);
        let url = APIURL + "/login_do";
        let result = await Load_API(url,dataarr);
        if(result.get('status') == 'ok') {
            // let returl = $('#btn_login').data('rurl');
            // if(returl==''){
                $(location).attr('href','/');
            // }else{
            //     $(location).attr('href',returl);
            // }
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    }catch(error){
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}