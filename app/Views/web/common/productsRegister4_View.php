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
                제품등록
            </p>
        </div>
        <div class="areaBox area_boxm9k mati_boxm9k">
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
                            <option value="">원물볶음차</option>
                            <option value="">원물볶음차</option>
                            <option value="">원물볶음차</option>
                        </select>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">중분류</p>
                        <select name="" id="" class="inputType360">
                            <option value="">생강</option>
                            <option value="">생강</option>
                            <option value="">생강</option>
                        </select>
                        <button type="button" class="btnType3" name="" onclick="add_category2();">추가</button>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">상품명</p>
                        <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
                    </div>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <div class="left flexType2">
                    <p class="title mr10">제품 BOM</p>
                    <p class="title2">재료 입력</p>
                </div>
                <div class="right flexType1">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="area5 area_box2qd ">
<!--                <div class="elementBox">-->
<!--                    <p class="subTitle">재료 입력</p>-->
<!--                </div>-->
                <div class="elementBox products_boxc6m">
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">재료 결과명</p>
                        <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="metirialName" >
                    </div>
                    <div class="hi" name="matiBox">
                        <div class="element flexType2 selectMetirialBox" name="oneMati">
                            <div class="left flexType2">
                                <p class="must"></p>
                                <p class="title">재료 선택</p>
                                <select name="" id="" class="inputBorder mr10">
                                    <option value="">우엉1</option>
                                    <option value="">우엉2</option>
                                    <option value="">우엉3</option>
                                </select>
                                <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" >
                                <p class="unit mr10">g</p>
                            </div>
                            <button type="button" class="inputBorder removeBtn" name="removeMati" onclick="removeMati(this);">제거</button>
                        </div>
                        <div class="element flexType2 selectMetirialBox" name="oneMati">
                            <div class="left flexType2">
                                <p class="notmust"></p>
                                <p class="title">재료 선택</p>
                                <select name="" id="" class="inputBorder mr10">
                                    <option value="">우엉1</option>
                                    <option value="">우엉2</option>
                                    <option value="">우엉3</option>
                                </select>
                                <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" >
                                <p class="unit mr10">g</p>
                            </div>
                            <button type="button" class="inputBorder removeBtn" name="removeMati" onclick="removeMati(this);">제거</button>
                        </div>
                        <div class="element flexType2 selectMetirialBox" name="oneMati">
                            <div class="left flexType2">
                                <p class="notmust"></p>
                                <p class="title">재료 선택</p>
                                <select name="" id="" class="inputBorder mr10">
                                    <option value="">우엉1</option>
                                    <option value="">우엉2</option>
                                    <option value="">우엉3</option>
                                </select>
                                <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" >
                                <p class="unit mr10">g</p>
                            </div>
                            <button type="button" class="inputBorder removeBtn" name="removeMati" onclick="removeMati(this);">제거</button>
                        </div>
                    </div>
                    <div class="element addBox">
                        <button type="button" class="btnType1" name="addMati" onclick="add_matiBox(this);">재료추가</button>

                    </div>
                </div>
            </div>
            
        </div>
        <div class="lastBox flexType6">
            <button type="button" class="btnType1 mr10">취소</button>
            <button type="button" id="nextBtn" name="nextBtn" class="btnType2" onclick="go_manuRegister();">다음</button>
        </div>
    </div>

</section>

<?= $this->include('/web/include/pop_AddCategory2_View'); ?>
<?= $this->endSection() ?>