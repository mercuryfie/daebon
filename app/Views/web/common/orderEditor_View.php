<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/orderEditor_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>
<?php print_r($body['info'])?>
<?php print_r($body['p_arr'])?>
<?=$body['info'][0]['orcode'];?>
<section class="merright">
    <input type="hidden" id="orcode" name="orcode" value="<?=$body['info'][0]['orcode'];?>">
    <div class="orderReg_boxx7x">
        <div class="titleBox">
            <p class="headTitle">
                주문수정
            </p>
        </div>
        <div class="areaBox areaBox2 area_boxm9k ">
            <div class="area1 flexType3">
                <p class="title">주문정보</p>
            </div>
            <div class="area2 flexType2 area_box2qd ">
                <div class="elementBox ">
                    <div class="element element11 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">마켓</p>
                        </div>
                        <p class="data" >자체</p>
                    </div>
                    <div class="element element1 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">주문코드</p>
                        </div>
                        <p class="data" id="orcode" data-code="<?=$body['info'][0]['orcode'];?>"><?=$body['info'][0]['orcode'];?></p>
<!--                        <input type="search" name="spcode" id="spcode" placeholder="주문코드 입력" class="inputType360 odCodeIn " value="--><?php //=$body['info'][0]['orcode'];?><!--" readonly>-->
                    </div>
                    <div class="element element1 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">주문상품</p>
                        </div>
                        <div class="dd">
                            <?foreach ($body['p_arr'] as $d){?>
                                <div class="flexType2 mb10 ">
                                    <p class="data mr10"><?=$d['sgname'];?></p>
                                    <p class="data"><?=$d['gcnt'];?>개</p>
                                </div>
                            <?}?>
<!--                            <p class="data">-->
<!--                                -->
<!--                            </p>-->
                        </div>
<!--                        <div class="flexCol">-->
<!--                            <div class="copyBox ">-->
<!--                                <div class="copyArea copyArea1 flexType2 mr10">-->
<!--                                    <div class="left flexType3 mr10">-->
<!--                                        <input type="search" class=" sch_input " id="txt_product" name="txt_product" placeholder="제품명 입력후 엔터" data-code="">-->
<!--                                        <button class="copyDropdown" type="button" id="btn_product" name="btn_product"> <i class="fas fa-caret-down"></i></button>-->
<!--                                    </div>-->
<!--                                    <input type="number" placeholder="숫자만입력" class="count" id="txt_product_num" name="txt_product_num" />-->
<!--                                    <button class="copyAdd btnType3 " type="button" id="addproduct" name="addproduct">추가</button>-->
<!--                                </div>-->
<!--                                <div class="copyArea copyArea2 flexCol" id="product_list" name="product_list">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="tagBox" id="add_list" name="add_list">-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="element element2 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">주소</p>
                        </div>
                        <div class="flexCol ">
                            <div class="flexType2 mb10">
                                <input type="search" name="zipcode" id="zipcode" placeholder="" class="inputType2 postIn" value="<?=$body['info'][0]['receive_zipcode'];?>" readonly>
                                <button type="button" class="btnType3 schBtn" onclick="execDaumPostcode();">검색</button>
                            </div>
                            <input type="search" name="address1" id="address1" placeholder="" class="inputType360 add1In  mr10" value="<?=$body['info'][0]['receive_address1'];?>" readonly>
                        </div>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">상세주소</p>
                        <input type="search" name="address2" id="address2" placeholder="" class="inputType360 mr10" value="<?=$body['info'][0]['receive_address2'];?>">
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">수령인</p>
                        <input type="search" class="inputType360" placeholder="" id="rname" name="" value="<?=$body['info'][0]['receive_name'];?>" >
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">연락처</p>
                        <input type="search" class="inputType360" placeholder=" - 없이 숫자만 입력" id="rphone" name="" value="<?=$body['info'][0]['receive_phone'];?>" >
                    </div>
                </div>
            </div>
        </div>
        <div class="lastBox flexType5">
            <button type="button" class="btnType1 mr10" onclick="go_orderList();">목록</button>
            <button type="button" id="submitBtn" name="submitBtn" class="btnType2" >수정</button>
        </div>
        </div>

</section>


<?= $this->endSection() ?>