<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/productsEditor.js?rnd=<?=rand();?>"> </script>
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
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">상품분류</p>
                            <select name="category" id="category" class="inputType360">
                                <option value="">선택하세요.</option>
                                <?=$body['category'];?>
                            </select>
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">제품명</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsName" id="goodsName" value="<?=$body['goods_arr']['name'];?>">
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">기본수량</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsQuantity" id="goodsQuantity" value="<?=$body['goods_arr']['quantity'];?>">
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">적정재고량</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" name="goodsInventory" id="goodsInventory" value="<?=$body['goods_arr']['inventory'];?>">
                        </div>
                        <div class="element flexType2 selectMetirialBox hide" >
                            <div class="left flexType4" name="coverMaterial">
                                <div class="cat flexType2">
                                    <p class="must"></p>
                                    <p class="title">재료선택</p>
                                </div>
                                <div class="rightSelectorBox flexCol" name="materialBox" >
                            <?if(fn_ArrayCnt($body['material_arr']) > 0){?>
                                <?for($i=0;$i<=(fn_ArrayCnt($body['material_arr'])-1);$i++){?>
                                    <div class="rightSelector flexType2" name="oneMate">
                                        <select name="material_code" class="inputBorder mr10">
                                            <option value="">선택하세요.</option>
                                            <?= fnMake_Material_option($body['material_arr'][$i]['mtcode'],1);?>
                                        </select>
                                        <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000" value="<?=$body['material_arr'][$i]['cnt'];?>" name="material_cnt">
                                        <p class="unit mr10">g</p>
                                        <button type="button" class="btnType3 addBtn mr10" name="addMaterial">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="button" class="btnType3 removeBtn" name="removeMaterial">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                <?}?>
                            <?}?>
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
                <button type="button" class="btnType1 mr10">취소</button>
                <button type="button" id="btn_confirm" name="btn_confirm" class="btnType2" >확인</button>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>