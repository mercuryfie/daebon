<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/userList_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright ">
    <div class="user_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                사용자 목록
            </p>
        </div>
        <div class="areaBox min80vh ">
            <div class="area area1 ">
<!--                <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="아이디 검색">-->
                <button type="button" class="btnType2" id="add_btn" name="add_btn" onclick="go_userRegister();">계정등록</button>

            </div>
            <div class="area area2">
                <table class="user_list_table">
                    <thead>
                        <tr>
                            <td>아이디</td>
                            <td>이름</td>
                            <td>권한</td>
                            <td class="narrow">수정</td>
                            <td class="narrow">pw초기화</td>
                            <td class="narrow">계정삭제</td>
                        </tr>
                    </thead>
                    <tbody id="ulist" name="ulist">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!--        <div style="height: 600px;">-->
<!---->
<!--        </div>-->
<!--        <div class="lastBox flexType6">-->
<!--            <button type="button" class="btnType1 mr10" onclick="go_productsList();">이전</button>-->
<!--            <button type="button" id="nextBtn" name="nextBtn" class="btnType2" onclick="go_manuEditor();">다음</button>-->
<!--        </div>-->
    </div>

</section>

<?= $this->endSection() ?>