<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/qualityReport_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright ">
    <div class="user_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                사용자 목록
            </p>
        </div>
        <div class="areaBox  ">
            <div class="area area1">
                <table class="user_reg_table">
                    <thead>
                        <tr>
                            <td>아이디</td>
                            <td>권한</td>
                            <td>pw초기화</td>
                            <td>계정삭제</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1-1</td>
                            <td>1-2</td>
                            <td>
                                <button type="button" class="btnType3 remove_btn" id="" name="btn_del"  data-code="">
                                    <i class="fa-solid fa-rotate-right" name="fairy"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btnType3 remove_btn" id="" name="btn_del"  data-code="">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1-1</td>
                            <td>1-2</td>
                            <td>
                                <button type="button" class="btnType3 remove_btn" id="" name="btn_del"  data-code="">
                                    <i class="fa-solid fa-rotate-right" name="fairy"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btnType3 remove_btn" id="" name="btn_del"  data-code="">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>

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