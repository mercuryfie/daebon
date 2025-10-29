<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/productsEditor.js?rnd=<?=rand();?>"> </script>
    <script src="<?=URL_COMMON_ASSETS?>/productsEditor_Do.js?rnd=<?=rand();?>"> </script>

    <!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="goods_boxx7z">
            <div class="titleBox">
                <p class="headTitle">
                    제품수정
                </p>
            </div>
            <div class="areaBox area_boxm9k ">
                <div class="outerBox flexType3">
                    <div class="left flexType2">
                        <p class="title mr10">제품 BOM</p>
                        <p class="title2">정보 입력</p>
                    </div>
                    <div class="right flexType1">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <div class="area5 area_box2qd ">
                    <div class="elementBox products_boxc6m">
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">상품분류</p>
                            <select name="" id="" class="inputType360">
                                <option value="">선택하세요.</option>
<!--                                --><?php //=$main['category'];?>
                            </select>
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">제품명</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="metirialName" >
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">기준수량</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="metirialName" >
                        </div>
                        <div class="element flexType2 selectMetirialBox hide" >
                            <div class="left flexType4">
                                <p class="must"></p>
                                <p class="title">재료선택</p>
                                <div class="rightSelectorBox flexCol" name="mateBox" id="materialBox" data-row="1">
                                    <div class="rightSelector flexType2" name="oneMate">
                                        <select name="" id="" class="inputBorder mr10">
                                            <option value="">선택하세요.</option>
<!--                                            --><?php //= $main['material']; ?>
                                        </select>
                                        <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000">
                                        <p class="unit mr10">g</p>
                                        <button type="button" class="btnType3 addBtn mr10" name="addMaterial">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="button" class="btnType3 removeBtn" name="removeMaterial" style="display: none;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxm9k ">

                <div class="outerBox flexType3">
                    <div class="left flexType2">
                        <p class="title mr10">제품 BOM</p>
                        <p class="title2">공정 입력</p>
                    </div>
                    <div class="right flexType1">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <div class="area5 area_box2qd proc_boxf9n">
                    <div class="roasting_boxp9x " name="roastBox" id="roast_box">
                        <div class="oneRoast elementBox products_boxc7m " name="oneRoast" id="one_roast">
                            <i class="fa-solid fa-xmark removeRoasting" name="removeThisRoast"></i>
                            <div class="goods_boxt6r  " name="" >

                                <div class="cover_boxh1t flexType2" name="">
                                    <p class="must"></p>
                                    <p class="ttl">공정타입</p>
                                    <select name="" id="" class="inputType">
                                        <option value="">선택하세요.</option>
<!--                                        --><?php //=$main['process'];?>
                                    </select>
                                </div>
                                <div class="cover_boxh1t flexType2">
                                    <p class="must"></p>
                                    <p class="ttl">공정 결과명</p>
                                    <input type="search" class="inputType" name="" id="" placeholder="공정 결과명">

                                </div>
                            </div>
                            <div class="inputIng_boxn7g">
                                <div class="inputIng_boxn88 flexType4">
                                    <div class="left flexType2">
                                        <p class="qoute"></p>
                                        <p class="subTytle">투입</p>
                                    </div>
                                    <div class="right">
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
                                    <div class="tBagBox" name="tBagBox" id="tBagCon">
                                        <div class="oneTBag flexType2" name="oneTBag" id="oneTBagCon">
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
                                            <!--                                        <i class="fa-solid fa-xmark mr10" onclick="removeTBag(this);"></i>-->

                                            <button type="button" class="btnType3 addBtn mr10" name="addCover">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btnType3 removeBtn" name="removeCover">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!--                                <button type="button" class="btnType3 addBtn mr10" name="addMaterial">-->
                                    <!--                                    <i class="fa-solid fa-plus"></i>-->
                                    <!--                                </button>-->
                                    <!--                                <button type="button" class="btnType3 removeBtn" name="removeMaterial" style="display: none;">-->
                                    <!--                                    <i class="fa-solid fa-trash"></i>-->
                                    <!--                                </button>-->
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
                        <button type="button" class="btnType1" name="addRoasting" >공정추가</button>

                    </div>
                </div>
            </div>
            <div class="lastBox flexType6">
                <button type="button" class="btnType1 mr10">취소</button>
                <button type="button" id="btn_confirm" name="btn_confirm" class="btnType2" >확인</button>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>