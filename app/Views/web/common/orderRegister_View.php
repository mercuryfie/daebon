<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/orderRegister_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright">
    <div class="orderReg_boxx7x">
        <div class="titleBox">
            <p class="headTitle">
                주문등록
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
                        <div class="flexCol">
                            <select name="shoptyp" id="shoptyp" class="inputType2 mkSelect mb10">
                                <option value="">선택하세요.</option>
                                <?=$body['excode'];?>
                            </select>
                            <input type="search" name="spcode" id="spcode" placeholder="주문코드 입력" class="inputType2 odCodeIn mb10" >
                            <input type="search" name="buyid" id="buyid" placeholder="구매자 ID 입력" class="inputType2 odCodeIn" >
                        </div>

                    </div>
                    <div class="element element1 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">상품선택</p>
                        </div>
                        <div class="flexCol">
                            <div class="copyBox ">
                                <div class="copyArea copyArea1 flexType2 mr10">
                                    <div class="left flexType3 mr10">
                                        <input type="search" class="copySearch" id="txt_product" name="txt_product" placeholder="제품명 입력후 엔터" data-code="">
                                        <button class="copyDropdown" type="button" id="btn_product" name="btn_product"> <i class="fas fa-caret-down"></i></button>
                                    </div>
                                    <input type="number" placeholder="숫자만입력" class="count" id="txt_product_num" name="txt_product_num" />
                                    <button class="copyAdd btnType3 " type="button" id="addproduct" name="addproduct">추가</button>
                                </div>
                                <div class="copyArea copyArea2 flexCol" id="product_list" name="product_list">
                                </div>
                            </div>
                            <div class="tagBox" id="add_list" name="add_list">
                            </div>
                        </div>
                    </div>
                    <div class="element element2 flexType4">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">주소</p>
                        </div>
                        <div class="flexCol ">
                            <div class="flexType2 mb10">
                                <input type="search" name="zipcode" id="zipcode" placeholder="" class="inputType2 postIn" readonly>
                                <button type="button" class="btnType3 schBtn" onclick="execDaumPostcode();">검색</button>
                            </div>
                            <input type="search" name="address1" id="address1" placeholder="" class="inputType360 add1In  mr10" readonly>
                        </div>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">상세주소</p>
                        <input type="search" name="address2" id="address2" placeholder="" class="inputType360 mr10">
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">수령인</p>
                        <input type="search" class="inputType360" placeholder="" id="bname" name="bname" >
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">연락처</p>
                        <input type="search" class="inputType360" placeholder=" - 없이 숫자만 입력" id="bphone" name="bphone" >
                    </div>
                </div>
            </div>
        </div>
        <div class="lastBox flexType5">
            <button type="button" class="btnType1 mr10" onclick="go_orderList();">이전</button>
            <button type="button" id="submitBtn" name="submitBtn" class="btnType2" >주문등록</button>
        </div>
        </div>

</section>


<?= $this->endSection() ?>