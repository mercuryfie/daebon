
<header>
    <div class="headerwrap">
        <a href="/" target="_blank" onclick="go_main(); return false;">
            <img src="/assets/web/src/logo_black.png" alt="img" id="" onclick="" onmousedown=""
                 class="logoImg">
        </a>

        <div class="loginBox flexType5 ">
        <?if($header['islogin']==false){?>
            <a href="javascript://" class="text text1" onclick="go_login();">로그인</a>
        <?}else{?>
            <div class="flexType2">
                <p class=""><?=$header['name']?>님 반갑습니다. </p>
                <a href="javascript://" class="text text1" onclick="go_logout();">로그아웃</a>
        <?}?>
            <a href="javascript:;" class="text text2">도움말</a>
            </div>
        </div>
    </div>
</header>