<?= $this->extend('/web/template/layout_workpage') ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/userRegister_Do.js?rnd=<?=rand();?>"></script>
<script>
</script>

<section class="merright user_reg_contents">
    <div class="user_reg_wrap">
        <div class="titleBox">
            <p class="headTitle">
                사용자 등록
            </p>
        </div>
        <div class="areaBox min70vh ">
            <div class="area area1 flexType2">
                <p class="must"></p>
                <p class="title">아이디</p>
                <input type="search" class="inputBorder mr10" placeholder="영문,숫자 4-12자리" id="userid" name="userid">
                <button type="button" class="btnType3" id="btn_dup" name="btn_dup">중복확인</button>
            </div>
            <div class="area area2 flexType2">
                <p class="must"></p>
                <p class="title">이름</p>
                <input type="search" class="inputBorder " placeholder="" id="u_name" name="u_name">
            </div>
            <div class="area area3 flexType2">
                <p class="must"></p>
                <p class="title">비밀번호</p>
                <input type="password" class="inputBorder " placeholder="영문,숫자 4-12자리" id="pw_1" name="pw_1">
            </div>
            <div class="area area4 flexType2">
                <p class="must"></p>
                <p class="title">비밀번호 확인</p>
                <input type="password" class="inputBorder " placeholder="영문,숫자 4-12자리" id="pw_2" name="pw_2">
            </div>
            <div class="area area4 flexType2">
                <p class="must"></p>
                <p class="title">권한</p>
                <select name="grade" id="grade" class="inputBorder">
                    <option value="1101" >마스터</option>
                    <option value="1102" selected>작업자 - 배송</option>
                    <option value="1103" >작업자 - 생산</option>
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
            <button type="button" id="submit_btn" name="submit_btn" class="btnType1 mr10" onclick="go_userList();">목록</button>
            <button type="button" id="submit_btn" name="submit_btn" class="btnType2" onclick="add_Account();">확인</button>
        </div>
    </div>
<!--        <div style="height: 600px;">-->
<!---->
<!--        </div>-->
<!--    </div>-->

</section>

<?= $this->endSection() ?>