<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/matiRegister_Do.js?rnd=<?=rand();?>"> </script>

<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                기준정보관리 / 제품등록
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
                <p class="title">제품 BOM</p>
                <div class="right flexType1">
                    <i class="fa-solid fa-angle-down"></i>
                </div>
            </div>
            <div class="area5 area_box2qd proc_boxf9n">
                <div class="elementBox">
                    <p class="subTitle">공정 입력</p>
                </div>
                <div class="elementBox products_boxc7m">
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">공정 결과명</p>
                        <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="manufacturingName" >
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">투입 재료명</p>
                        <input type="search" class="inputType360" placeholder="우엉차" name="metirialName" readonly >
                    </div>
                    <div class="goods_boxt6r" name="roastingBox" >
                        <div class="cover_boxh1t element flexType2" name="oneRoasting">
                            <p class="must"></p>
                            <p class="title">공정명</p>
                            <select name="" id="" class="inputType360">
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
                    <div class="element addBox">
                        <button type="button" class="btnType1 addBtn" name="addRoasting">공정추가</button>
                    </div>

                    <div class=" goods_boxt6r" name="tBagBox" id="" >
                        <div class="cover_boxz7y element flexType2" name="oneTbag" id="">
                            <p class="must"></p>
                            <p class="title">부자재</p>
                            <select name="" id="" class="option option1">
                                <option value="">부자재</option>
                                <option value="">부자재</option>
                                <option value="">부자재</option>
                            </select>
                            <select name="" id="" class="option option2">
                                <option value="">부자재 상세</option>
                                <option value="">부자재 상세</option>
                                <option value="">부자재 상세</option>
                            </select>
                            <select name="" id="" class="option option3">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="element addBox">
                        <button type="button" class="btnType1 addBtn" name="addTbag">부자재 추가</button>

                    </div>
                    <div class="element flexType2 roasting_boxe3x">
                        <p class="notmust"></p>
                        <p class="title">공정방법</p>
                        <textarea name="" id="" cols="" rows="" placeholder="밀폐 다층식 3D 진동체 분말여과기를 이용하여 이물을 제거하는 과정"></textarea>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="lastBox flexType6">
            <button type="button" class="btnType1 mr10" onclick="go_matiRegister();">이전</button>
            <button type="button" id="nextBtn" name="nextBtn" class="btnType2">확인</button>
        </div>
    </div>
    </div>

</section>

<?= $this->endSection() ?>