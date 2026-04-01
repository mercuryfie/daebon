<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/userEditor_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>
<section class="merright ">
    <div class="user_edit_wrap">
        <div class="titleBox">
            <p class="headTitle">
                정보 수정
            </p>
        </div>
        <div class="areaBox  ">
            <div class="area area1 flexType2">
                <p class="must"></p>
                <p class="title">아이디</p>
                <input type="search" class="inputBorder mr10" placeholder="" id="userid" name="userid" data-uid="<?=$body['user']['uid'];?>" value="<?=$body['user']['userid'];?>" disabled>
            </div>
            <div class="area area2 flexType2">
                <p class="must"></p>
                <p class="title">이름</p>
                <input type="search" class="inputBorder " placeholder="" id="u_name" name="u_name" value="<?=$body['user']['name'];?>">
            </div>
            <div class="area area3 flexType2">
                <p class="must"></p>
                <p class="title">현재 비밀번호</p>
                <input type="password" class="inputBorder " placeholder="영문,숫자 4-12자리" id="pw_now" name="pw_now" value="">
            </div>
            <div class="area area3 flexType2">
                <p class="notmust"></p>
                <p class="title">새 비밀번호</p>
                <input type="password" class="inputBorder " placeholder="영문,숫자 4-12자리" id="pw_1" name="pw_1" value="">
            </div>
            <div class="area area4 flexType2">
                <p class="notmust"></p>
                <p class="title">새 비밀번호 확인</p>
                <input type="password" class="inputBorder " placeholder="영문,숫자 4-12자리" id="pw_2" name="pw_2" value="">
            </div>
            <div class="area area4 flexType2">
                <p class="must"></p>
                <p class="title">권한</p>
                <select name="grade" id="grade" class="inputBorder">
                    <?=$body['grade_option'];?>
<!--                    <option value="1101" >마스터</option>-->
<!--                    <option value="1102" selected>작업자 - 배송</option>-->
<!--                    <option value="1103" >작업자 - 생산</option>-->
                </select>
            </div>
            <!--            <div class="area area5 flexType2">-->
            <!--                <p class="notmust"></p>-->
            <!--                <p class="title">서명등록</p>-->
            <!--                <div id="thum_wrap" name="thum_wrap" class="thum_boxn4e mr10">-->
            <!--                    <label for="attachImg" class="photo-picker">-->
            <!--                        <input class="" type="file" name="attachImg" id="attachImg" multiple style="" data-ext="jpg,jpeg,png,gif" accept="image/jpeg, image/jpg, image/png, image/gif">-->
            <!--                        <i class="fa-solid fa-camera"></i>-->
            <!--                    </label>-->
            <!--                </div>-->
            <!--                <div id="thumbArea" name="thumbArea" class="thum_arange flexType2 mr10">-->
            <!--                </div> -->
            <!--            </div>-->
        </div>
        <div class="lastBox flexType5-1">
            <button type="button" id="" name="" class="btnType1 mr10" onclick="go_userList();">목록</button>
            <button type="button" id="submit_btn" name="submit_btn" class="btnType2" onclick="Mod_Account();">확인</button>
        </div>
    </div>

</section>

<?= $this->endSection() ?>