$(document).ready(function () {
    $('#userid , #passwd').on("keypress", function (key) {
        if (key.keyCode == 13) {
            Login_Do();
        }
    });
});


function Login_Do(){
    var userid = $('#userid').val();
    var pwd = $('#passwd').val();
    if(userid ==''){
        alert('아이디를 입력하세요');
        $('#userid').focus();
    }else if(pwd ==''){
        alert('비밀번호를 입력하세요.');
        $('#passwd').focus();
    }else{
        var iskeep = 0;
        if($('input:checkbox[name="autolg"]').is(":checked") == true){
            iskeep = 1;
        }

        var issave = 0;
        if($('input:checkbox[name="saveid"]').is(":checked") == true){
            issave = 1;
        }

        $.ajax({
            url: "/Member/Login_Do",
            type: 'POST',
            dataType: 'json',
            data: {"userid": userid, "passwd": pwd,'iskeep' : iskeep,'issave' : issave},
            success: function (data) {
                if (data.result == 'ok') {
                    let returl = g_GetLoginCookie();
                    if(returl==''){
                        $(location).attr('href','/');
                    }else{
                        $(location).attr('href',returl);
                    }
                }else if(data.result=='type101'){
                    alert('잘못된 접근입니다.');
                }else if(data.result=='type102'){
                    alert('존재하지 않는 아이디 입니다.');
                }else if(data.result=='type103'){
                    alert('입력된 아이디의 비밀번호가 틀렸습니다.');
                }else if(data.result=='type104'){
                    alert('로그인 회원정보의 암호화에 실패하였습니다. 다시 시도 하여 주세요.');
                }else{
                    alert('Error : [' + data.message + ']');
                }
            },
            error: function (xhr, status, error) {
                alert("에러발생");
                //alert(data);
            }
        });
    }

}