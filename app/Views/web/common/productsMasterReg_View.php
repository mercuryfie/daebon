<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<!-- js ----------------------------  -->
<?php //print_r($body)?>
<script src="<?=URL_COMMON_ASSETS?>/productsMasterReg_Do.js?rnd=<?=rand();?>"> </script>
<section class="merright">
    <input type="hidden" name="stepCnt" id="stepCnt" value="1"/>
    <input type="hidden" name="gscode" id="gscode" value=""/>
    <input type="hidden" name="gname" id="gname" value=""/>
    <div class="mas_box23f">
        <div class="titleBox">
            <p class="headTitle">
                제품BOM등록
            </p>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3 ">
                <div class="left flexType2">
                    <p class="title mr10">제품정보</p>
                </div>
                <div class="right flexType1">
                    <button type="button" class="btnType3 foldBtn"><i class="fa-solid fa-angle-down"></i></button>
                </div>
            </div>
            <div class="area5 area_box2qd ">
                <div class="elementBox products_boxc6m">
                    <div class="element element1 flexType2">
                        <p class="must"></p>
                        <p class="title">제품명</p>
                        <span class="data" name="txt_gname" id="txt_gname" data-code="<?= $body['info_arr']['gscode']?>"><?= $body['info_arr']['gname']?></span>
<!--                        <div class="searchBox searchProducts_box291 area_box2qd">-->
<!--                            <div class="copyArea copyArea1 flexType3">-->
<!--                                <input type="search" class="copySearch" id="txt_search" name="txt_search" placeholder="제품코드 또는 제품명 입력후 엔터" onfocus="">-->
<!--                                <button class="copyDropdown" type="button" id="btn_search" name="btn_search"> <i class="fas fa-caret-down"></i></button>-->
<!--                            </div>-->
<!--                            <div class="copyArea copyArea2  mr10 flexCol" id="glist" name="glist">-->
<!--                            </div>-->
<!--                        </div>-->

                    </div>
                    <div class="element element2 flexType2">
                        <p class="notmust"></p>
                        <p class="title">분류</p>
                        <span class="data" name="txt_category" id="txt_category" data-ct="<?= $body['info_arr']['category']?>"><?= $body['info_arr']['cat_str']?></span>
                    </div>
                    <div class="element element3 flexType2">
                        <p class="notmust"></p>
                        <p class="title">적정 재고량</p>
                        <span class="data" name="txt_inventory" id="txt_inventory"><?= $body['info_arr']['inv_str']?></span>
                    </div>
                    <div class="element element4 flexType2">
                        <p class="notmust"></p>
                        <p class="title">단위당 용량</p>
                        <span class="data" name="txt_unitwight" id="txt_unitwight"><?= $body['info_arr']['unit_str']?></span>
                    </div>
                    <div class="element element6 flexType2 selectMetirialBox " >
                        <p class="must"></p>
                        <p class="title">기본수량</p>
                        <input type="search" class="inputType2 quantityIn mr10 only-number" placeholder="숫자만 입력 (예:10000)" name="Quantity" id="Quantity">
                        <p class="msg fontType3">한 번 생산 시 만들어지는 수량입니다. </p>
                    </div>
                    <div class="element element5 flexType4 selectMetirialBox" >
                        <div class="cat flexType2">
                            <p class="must"></p>
                            <p class="title">원재료 선택</p>
                        </div>
                        <div class="searchMate_boxx21  flexCol " name="">
                            <div class="copyArea copyArea1 flexType2 mr10">
                                <div class="keyIn flexType2">
                                    <input type="search" class="copySearch" id="txt_product" name="txt_product" placeholder="입력후 엔터" data-code="">
                                    <button class="copyDropdown " type="button" id="btn_product" name="btn_product"> <i class="fas fa-caret-down"></i></button>
                                </div>
                                <input type="number" placeholder="무게입력" class="count mr10 only-number" id="txt_product_num" name="txt_product_num" />
                                <button class="copyAdd btnType3" type="button" id="addproduct" name="addproduct" data-mtcode="" data-mtname="">추가</button>
                            </div>
                            <div class="flexCol">
                                <div class="copyArea copyArea2" id="product_list" name="product_list">

                                </div>
                                <div class="copyArea copyArea3 tagBox" name="add_material" id="add_material">
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
                    <button type="button" class="btnType3 foldBtn"><i class="fa-solid fa-angle-down"></i></button>
                </div>
            </div>
            <div class="area5 area_box2qd proc_boxf9n">
                <div class="roasting_boxp9x " name="roastBox" id="roastBox">
                    <div class="oneRoast elementBox products_boxc7m " name="oneRoast" >
                        <input type="hidden" name="stepNum" value="1" />
                        <i class="fa-solid fa-xmark removeRoasting" name="removeThisRoast"></i>
                        <div class="goods_boxt6r  " name="" >
                            <div class="bomType_boxh1t flexType2" name="">
                                <p class="must mr10"></p>
                                <p class="title">공정타입</p>
                                <select name="ptype" class="inputType typeIn" data-code="" data-loss="">
                                    <option value="">선택하세요.</option>
                                    <?=$body['category'];?>
                                </select>
                            </div>
                            <div class="bomType_boxh1t flexType2">
                                <p class="must mr10"></p>
                                <p class="title">공정결과명</p>
                                <input type="search" class="inputType nameIn" name="processname" placeholder="공정결과명">
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
                                            <?=$body['material'];?>
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
                            <textarea class="mr10" name="step_memo"cols="" rows="" placeholder="내용을 입력하십시오. "></textarea>
                        </div>
                    </div>
                </div>
                <div class="cover_boxz7y flexType4">
                    <p class="ttl"></p>
                    <button type="button" class="btnType1" name="addRoasting" >공정추가</button>

                </div>
            </div>
        </div>
        <div class="lastBox flexType5">
            <button type="button" class="btnType1 mr10" onclick="go_productsMasterList();">취소</button>
            <button type="button" id="btn_confirm" name="btn_confirm" class="btnType2" >확인</button>
        </div>
    </div>

</section>

<?= $this->endSection() ?>