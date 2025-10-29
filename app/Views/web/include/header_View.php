
<header>
    <div class="headerwrap">
        <img src="/assets/web/src/logo_daebon2.png" alt="img" onclick="go_dashboard();"
             class="logoImg">
        <div class="loginBox flexType5 ">
<!--            --><?php //print_r($)?>
        <?if($header['islogin']==false){?>
            <a href="javascript://" class="text text1" onclick="go_login();">로그인</a>
        <?}else{?>
            <div class="flexType2">
                <p class="">--님, 반갑습니다. </p>
                <a href="javascript://" class="text text1" onclick="go_logout();">로그아웃</a>
        <?}?>
            <a href="javascript:;" class="text text2">도움말</a>
            </div>
        </div>
    </div>
</header>