<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_COMMON_ASSETS?><!--/productsEditor.js?rnd=--><?php //=rand();?><!--"> </script>-->
    <script src="<?=URL_COMMON_ASSETS?>/productsEditor_Do.js?rnd=<?=rand();?>"> </script>

    <section class="merright">
        <input type="hidden" id="gcode" name="gcode" value="<?=$body['code'];?>" />
        <div class="goods_boxx7z">
            <div class="titleBox">
                <p class="headTitle">
                    제품BOM수정
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
                        <div class="element element2 flexType2">
                            <p class="notmust"></p>
                            <p class="title">제품명</p>
                            <span class="data" name="txt_category" id="txt_category"><?=$body['goods_arr']['name'];?></span>
                        </div>
                        <div class="element element2 flexType2">
                            <p class="notmust"></p>
                            <p class="title">분류</p>
                            <span class="data" name="txt_category" id="txt_category"><?=$body['goods_arr']['c_str'];?></span>
                        </div>
                        <div class="element element4 flexType2">
                            <p class="notmust"></p>
                            <p class="title">적정 재고량</p>
                            <span class="data" name="txt_Inventory" id="txt_Inventory"><?=$body['goods_arr']['inventory'];?>개</span>
                        </div>
                        <div class="element element4 flexType2">
                            <p class="notmust"></p>
                            <p class="title">단위당 용량</p>
                            <span class="data" name="txt_unitwight" id="txt_unitwight"><?=$body['goods_arr']['unitwight'];?>g</span>
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">기본수량</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="Quantity" id="Quantity" value="<?=$body['goods_arr']['quantity'];?>">개
                        </div>
                        <div class="element element5 flexType4 selectMetirialBox" >
                            <div class="cat flexType2">
                                <p class="must"></p>
                                <p class="title">원자재 선택</p>
                            </div>

                            <div class="searchMate_boxx21  flexCol " name="">
                                <div class="copyArea copyArea1 flexType2 mr10">
                                    <div class="keyIn flexType2">
                                        <input type="search" class="copySearch" id="txt_product" name="txt_product" placeholder="원자재명 입력후 엔터" data-code="">
                                        <button class="copyDropdown " type="button" id="btn_product" name="btn_product"> <i class="fas fa-caret-down"></i></button>
                                    </div>
                                    <input type="number" placeholder="무게입력" class="count mr10 only-number" id="txt_product_num" name="txt_product_num" />
                                    <button class="copyAdd btnType3" type="button" id="addproduct" name="addproduct" data-mtcode="" data-mtname="">추가</button>
                                </div>
                                <div class="flexCol">
                                    <div class="copyArea copyArea3 tagBox" name="add_material" id="add_material">
                                <?if(fn_ArrayCnt($body['material_arr'])>0){?>
                                    <?foreach ($body['material_arr'] as $d){?>
                                        <div class="productTag  flexType3" name="add_product_info" data-code="<?=$d['mtcode'];?>">
                                            <div class="flexType2">
                                                <p class="pname" name="mtname"><?=$d['mtname'];?></p>
                                                <p class="count" name="mtcnt" data-cnt="<?=$d['cnt'];?>"><?=number_format($d['cnt']);?>g</p>
                                            </div>
                                            <i class="fa-solid fa-xmark" name="add_product_del"></i>
                                        </div>
                                    <?}?>
                                <?}?>
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

                <?php $first = 0; ?>
                <?if(fn_ArrayCnt($body['process_arr']) > 0){?>
                    <?for($i=0;$i<=(fn_ArrayCnt($body['process_arr'])-1);$i++){?>
                        <div class="oneRoast elementBox products_boxc7m " name="oneRoast" id="one_roast" data-prcode="<?=$body['process_arr'][$i]['prcode'];?>">
                            <input type="hidden" name="stepNum" value="<?=$body['process_arr'][$i]['stepNum'];?>" />
                            <i class="fa-solid fa-xmark removeRoasting" name="removeThisRoast" <?if($i!=0) echo('style="display: block;"'); ?>></i>
                            <div class="goods_boxt6r  " name="" >
                                <div class="cover_boxh1t flexType2" name="">
                                    <p class="must"></p>
                                    <p class="ttl">공정타입</p>
                                    <select name="ptype" class="inputType">
                                        <option value="">선택하세요.</option>
                                        <?= fnMake_Process_Type($body['process_arr'][$i]['step_typ']);?>
                                    </select>
                                </div>
                                <div class="cover_boxh1t flexType2">
                                    <p class="must"></p>
                                    <p class="ttl">공정 결과명</p>
                                    <input type="search" class="inputType" name="processname" placeholder="공정 결과명" value="<?=$body['process_arr'][$i]['step_name'];?>">

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
                                            <input type="search" class="inputData" placeholder="1000" name="material_input" value="<?=$body['process_arr'][$i]['input_material'];?>">
                                            <p class="unit ml10" name="unit_input">g</p>
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
                                    <input type="search" class="inputData" placeholder="1000" name="material_output" value="<?=$body['process_arr'][$i]['output_material'];?>">
                                    <p class="unit ml10">g</p>
                                </div>
                            </div>
                            <div class=" goods_boxt66" name="coverBox">
                                <div class="cover_boxz7y  flexType4" name="oneCover">
                                    <p class="ttl">부자재</p>
                                    <div class="tBagBox" name="tBagBox">
                                <?
                                    $first = 0;
                                    if(fn_ArrayCnt($body['process_arr'][$i]['material'])>0){?>
                                        <?for($j=0;$j<=(fn_ArrayCnt($body['process_arr'][$i]['material'])-1);$j++){?>
                                            <div class="oneTBag flexType2" name="oneTBag">
                                                <select name="accessory" class="option option1">
                                                    <option value="">선택하세요.</option>
                                                    <?= fnMake_Material_option($body['process_arr'][$i]['material'][$j]['code'],2);?>
                                                </select>
                                                <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" name="accessory_cnt" value="<?=$body['process_arr'][$i]['material'][$j]['cnt'];?>">
                                                <button type="button" class="btnType3 addBtn mr10" name="addCover">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <button type="button" class="btnType3 removeBtn flexType1 " name="removeCover" >
                                                    <i class="fa-solid fa-trash icon" name="fairy"></i>
                                                </button>
                                            </div>
                                        <?}
                                        }else{?>
                                        <div class="oneTBag flexType2" name="oneTBag">
                                            <select name="accessory" class="option option1">
                                                <option value="">선택하세요.</option>
                                                <?= fnMake_Material_option('',2);?>
                                            </select>
                                            <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" name="accessory_cnt" value="">
                                            <button type="button" class="btnType3 addBtn mr10" name="addCover">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btnType3 removeBtn" name="refreshCover" >
                                                <i class="fa-solid fa-rotate-right" name="fairy"></i>
                                            </button>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="element flexType4 roasting_boxe3x">
                                <p class="ttl">공정방법</p>
                                <textarea class="mr10" name="step_memo" cols="" rows="" placeholder=""><?=$body['process_arr'][$i]['method'];?></textarea>

                            </div>
                        </div>
                    <?}?>
                <?}?>
                    </div>
                    <div class="cover_boxz7y flexType4">
                        <p class="ttl"></p>
                        <button type="button" class="btnType1" name="modRoasting" >공정추가</button>

                    </div>
                </div>
            </div>
            <div class="lastBox flexType6">
                <button type="button" class="btnType1 mr10" id="btn_cancel" name="btn_cancel">취소</button>
                <button type="button" id="btn_confirm" name="btn_confirm" class="btnType2" >확인</button>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>