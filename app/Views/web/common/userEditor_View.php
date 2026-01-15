<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/qualityReport_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright ">
    <div class="user_wrap">
        <div class="titleBox">
            <p class="headTitle">
                사용자 등록
            </p>
        </div>
    </div>
    <div class="areaBox  ">
        <div class="area5  ">
            <div class="element flexType2">
                <p class="must"></p>
                <p class="title">상품명</p>
                <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
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