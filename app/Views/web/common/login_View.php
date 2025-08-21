<?= $this->extend('/web/template/layout_default') ?>
<?= $this->section('content') ?>


<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/login.js?rnd=--><?php //=rand();?><!--"></script>-->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/login_Do.js?rnd=--><?php //=rand();?><!--"></script>-->

<section class="login">
    <p class="title ttl1">로그인</p>
    <div class="inputcon">
        <input type="search" name="" id="" placeholder="  아이디" class="idinput">
    </div>
    <div class="inputcon">
        <input type="search" name="" id="" placeholder="  패스워드" class="idinput">
    </div>
    <button type="submit" id="btn_login" onclick="go_dashboard();" class="">로그인</button>
    <div class="autoLogin flexType1">
        <label for="" class="checkType flexType1">
            <input type="checkbox" name="saveid" id="saveid2" checked>
            <p class="text">아이디 저장</p>
        </label>
        <label for="" class="checkType flexType1">
        <input type="checkbox" name="autolg" id="autolg">
            <p class="text">자동 로그인</p>
        </label>
    </div>
</section> 

<?= $this->endSection() ?>


