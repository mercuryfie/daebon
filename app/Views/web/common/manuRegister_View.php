<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/manuRegister_Do.js?rnd=<?=rand();?>"> </script>

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
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <p class="title">제품정보</p>
                <div class="right flexType1">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="area5 area_box2qd ">
                <div class="elementBox el_boxc8s">
                    <div class="el flexType2">
                        <p class="must"></p>
                        <p class="title">대분류</p>
                        <select name="" id="" class="inputType360">
                            <option value="">원물볶음차</option>
                            <option value="">원물볶음차</option>
                            <option value="">원물볶음차</option>
                        </select>
                    </div>
                    <div class="el flexType2 cat2">
                        <p class="must"></p>
                        <p class="title">중분류</p>
                        <select name="" id="" class="inputType360 mr10">
                            <option value="">생강</option>
                            <option value="">생강</option>
                            <option value="">생강</option>
                        </select>
                        <button type="button" class="btnType3" name="" onclick="add_category2();">추가</button>
                    </div>
                    <div class="el flexType2">
                        <p class="must"></p>
                        <p class="title">상품명</p>
                        <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
                    </div>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <div class="flexType2 cream">
                    <p class="title mr10">제품 BOM / 공정 입력</p>
                </div>
                <div class="right flexType1">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="area5 area_box2qd proc_boxf9n">
                <div class="roasting_boxp9x" name="roasting_boxp9x">
                    <div class="elementBox products_boxc7m" name="oneRoasting">
                        <i class="fa-solid fa-xmark removeRoasting" onclick="removeRoasting(this);"></i>
                        <div class="goods_boxt6r  " name="" >
                            <div class="cover_boxh1t flexType2">
                                <p class="must"></p>
                                <p class="ttl">공정 결과명</p>
                                <input type="search" class="inputType" name="" id="" placeholder="공정 결과명">

                            </div>
                            <div class="cover_boxh1t flexType2" name="">
                                <p class="must"></p>
                                <p class="ttl">공정타입</p>
                                <select name="" id="" class="inputType">
                                    <option value="">계량</option>
                                    <option value="">세척</option>
                                    <option value="">건조</option>
                                    <option value="">이물검사</option>
                                    <option value="">파쇄(조분쇄)</option>
                                    <option value="">로스팅</option>
                                    <option value="">전동진동채(이물제거)</option>
                                    <option value="">삼각티백/내외포장</option>
                                    <option value="">금속이물탐지</option>
                                    <option value="">외포장</option>
                                    <option value="">보관/출고</option>
                                </select>
                            </div>
                        </div>
                        <div class="inputIng_boxn7g">
                            <div class="inputIng_boxn88 flexType4">
                                <div class="left flexType2">
                                    <p class="qoute"></p>
                                    <p class="subTytle">투입</p>
                                </div>
                                <div class="right">
                                    <div class="element element2 flexType4">
                                        <p class="title">투입 재료명</p>
                                        <input type="search" class="inputData" placeholder="우엉차" name="metirialName" readonly >
                                    </div>
                                    <div class="element element3 flexType4">
                                        <p class="title">총 투입량</p>
                                        <input type="search" class="inputData" placeholder="1000" name=""  >
                                        <p class="unit ml10">g</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="outputIng_boxh4z flexType4">
                            <div class="left flexType2">
                                <p class="qoute"></p>
                                <p class="subTytle">산출</p>
                            </div>
<!--                            <div class="element element2 flexType2">-->
<!--                                <p class="title">공정 결과명</p>-->
<!--                                <input type="search" class="inputData" placeholder="계량 완료" name="manufacturingName" >-->
<!--                            </div>-->
                            <div class="right element element3 flexType2">
                                <p class="title">예상 산출량</p>
                                <input type="search" class="inputData" placeholder="1000" name=""  >
                                <p class="unit ml10">g</p>
                            </div>
                        </div>

                        <div class=" goods_boxt66" name="coverBox" id="" >
                            <div class="cover_boxz7y  flexType4" name="oneCover" id="">
                                <p class="ttl">부자재</p>
                                <div class="tBogBox" name="tBagBox">
                                    <div class="oneTBag" name="oneTBag">
                                        <select name="" id="" class="option option1">
                                            <option value="">부자재1</option>
                                            <option value="">부자재2</option>
                                            <option value="">부자재3</option>
                                        </select>
                                        <select name="" id="" class="option option2">
                                            <option value="">부자재 상세3</option>
                                            <option value="">부자재 상세4</option>
                                            <option value="">부자재 상세5</option>
                                        </select>
                                        <select name="" id="" class="option option3">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                        </select>
                                        <i class="fa-solid fa-xmark mr10" onclick="removeTBag(this);"></i>

                                    </div>
                                </div>
                                <button type="button" class="addBtn" name="addCover" onclick="add_TBag('this');">부자재 추가</button>
                            </div>
                        </div>
                        <div class="element flexType4 roasting_boxe3x">
                            <p class="ttl">공정방법</p>
                            <textarea class="mr10" name="" id="" cols="" rows="" placeholder="밀폐 다층식 3D 진동체 분말여과기를 이용하여 이물을 제거하는 과정"></textarea>

                        </div>

                    </div>

                </div>
                <div class="cover_boxz7y flexType4">
                    <p class="ttl"></p>
                    <button type="button" class="btnType1" name="addRoasting" onclick="add_manuBox(this);">공정추가</button>

                </div>
            </div>
            
        </div>
        <div class="lastBox flexType6">
            <button type="button" class="btnType1 mr10" onclick="go_productsReg();">이전</button>
            <button type="button" id="nextBtn" name="nextBtn" class="btnType2">확인</button>
        </div>
    </div>
    </div>

</section>

<?= $this->include('/web/include/pop_AddCategory2_View'); ?>
<?= $this->endSection() ?>