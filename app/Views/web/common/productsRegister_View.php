<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productsRegister.js?rnd=<?=rand();?>"> </script>
<script src="<?=URL_COMMON_ASSETS?>/productsRegister_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright">
    <input type="hidden" name="stepCnt" id="stepCnt" value="1"/>
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                제품등록
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
                        <select name="category" id="category" class="inputType360">
                            <option value="">선택하세요.</option>
                            <?=$main['category'];?>
                        </select>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">제품명</p>
                        <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsName" id="goodsName">
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">기본수량</p>
                        <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsQuantity" id="goodsQuantity">
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">적정재고량</p>
                        <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsInventory" id="goodsInventory">
                    </div>
                    <div class="element flexType4 selectMetirialBox hide" >
                        <div class="cat flexType2">
                            <p class="must"></p>
                            <p class="title">재료선택</p>
                        </div>
                        <div class="data flexType4">
                            <div class="rightSelectorBox flexCol" name="materialBox">
                                <div class="rightSelector flexType4" name="oneMate">
                                    <select name="material_code" class="inputBorder mr10">
                                        <option value="">선택하세요.</option>
                                        <?= $main['material1']; ?>
                                    </select>
                                    <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" name="material_cnt">
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
                <div class="roasting_boxp9x " name="roastBox">
                    <div class="oneRoast elementBox products_boxc7m " name="oneRoast">
                        <input type="hidden" name="stepNum" value="1" />
                        <i class="fa-solid fa-xmark removeRoasting" name="removeThisRoast"></i>
                        <div class="goods_boxt6r  " name="" >

                            <div class="cover_boxh1t flexType2" name="">
                                <p class="must"></p>
                                <p class="ttl">공정타입</p>
                                <select name="ptype" class="inputType">
                                    <option value="">선택하세요.</option>
                                    <?=$main['process'];?>
                                </select>
                            </div>
                            <div class="cover_boxh1t flexType2">
                                <p class="must"></p>
                                <p class="ttl">공정 결과명</p>
                                <input type="search" class="inputType" name="processname" placeholder="공정 결과명">

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
                                        <input type="search" class="inputData" placeholder="예:1000" name="material_input"  >
                                        <p class="unit ml10" name="unit_input"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="outputIng_boxh4z flexType4">
                            <div class="left flexType2">
                                <p class="qoute"></p>
                                <p class="subTytle">산출</p>
                            </div>
                            <div class="right element element3 flexType2">
                                <p class="title">예상 산출량</p>
                                <input type="search" class="inputData" placeholder="예:1000" name="material_output"  >
                                <p class="unit ml10" name="unit_output"></p>
                            </div>
                        </div>

                        <div class=" goods_boxt66" name="coverBox">
                            <div class="cover_boxz7y  flexType4" name="oneCover">
                                <p class="ttl">부자재</p>
                                <div class="tBagBox" name="tBagBox">
                                    <div class="oneTBag flexType2" name="oneTBag">
                                        <select name="accessory" class="option option1">
                                            <option value="">선택하세요.</option>
                                            <?= $main['material2']; ?>
                                        </select>
                                        <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" name="accessory_cnt">
                                        <button type="button" class="btnType3 addBtn mr10" name="addCover">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="button" class="btnType3 removeBtn" name="removeCover">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="element flexType4 roasting_boxe3x">
                            <p class="ttl">공정방법</p>
                            <textarea class="mr10" name="step_memo"cols="" rows="" placeholder=""></textarea>

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