<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productsRegister_Do.js?rnd=<?=rand();?>"> </script>

<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                입출고 관리 / 원자재 등록
            </p>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <p class="title">제품정보</p>
                <div class="right flexType1">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="area5 area_box2qd ">
                <div class="elementBox ">
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">대분류</p>
                        <select name="" id="" class="inputType360">
                            <option value="">원재료</option>
                            <option value="">부자재</option>
                        </select>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">이름</p>
                        <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">제조사</p>
                        <select name="" id="" class="inputType360">
                            <option value="">a</option>
                            <option value="">a</option>
                        </select>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">공급사</p>
                        <select name="" id="" class="inputType360">
                            <option value="">a</option>
                            <option value="">a</option>
                        </select>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">입출고 단위</p>
                        <select name="" id="" class="inputType360">
                            <option value="">kg</option>
                            <option value="">g</option>
                            <option value="">개</option>
                            <option value="">Box</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="lastBox flexType6">
            <button type="button" class="btnType1 mr10">취소</button>
            <button type="button" id="submitBtn" name="submitBtn" class="btnType2" >확인</button>
        </div>
    </div>
    </div>

</section>

<?= $this->endSection() ?>