<?= $this->extend('/web/template/layout_default') ?>
<?= $this->section('content') ?>

<script src="<?=ASSETS_URL?>/js/common/login.js?rnd=<?=rand();?>"></script>
<script src="<?=ASSETS_URL?>/js/common/login_Do.js?rnd=<?=rand();?>"></script>

<section class="login">
    <p class="title ttl1">로그인</p>
    <div class="inputcon">
        <input type="text" name="userid" id="userid" placeholder="  아이디" class="idinput" value="<?=$main['saveid'];?>"/>
    </div>
    <div class="inputcon">
        <input type="password" name="passwd" id="passwd" placeholder="패스워드" class="idinput" />
    </div>
    <div class="dd">
        <button type="submit" id="btn_login" name="btn_login" class="btnType2" data-rurl="<?= $main['rec_url']; ?>">로그인</button>

    </div>
    <div class="autoLogin flexType1">
        <label for="saveid" class="checkType flexType1">
            <?if($main['saveid']==''){?>
                <input type="checkbox" name="saveid" id="saveid">
            <?}else{?>
                <input type="checkbox" name="saveid" id="saveid" checked>
            <?}?>
            <p class="text">아이디 저장</p>
        </label>
        <label for="autolg" class="checkType flexType1">
            <?if($main['keeplogin']==''){?>
                <input type="checkbox" name="autolg" id="autolg">
            <?}else{?>
                <input type="checkbox" name="autolg" id="autolg" checked>
            <?}?>
            <p class="text">자동 로그인</p>
        </label>
    </div>
</section>
<?= $this->endSection() ?>


