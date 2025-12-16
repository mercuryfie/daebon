<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/goodsRegister.js?rnd=--><?php //=rand();?><!--"> </script>-->
<script src="<?=URL_COMMON_ASSETS?>/goodsRegister_Do.js?rnd=<?=rand();?>"> </script>
<!-- ckeditor ----------------------------  -->
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="<?=URL_COMMON_ASSETS?>/ckeditor.common.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright">
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                상품등록
            </p>
        </div>
        <div class="areaBox area1 area_boxm9k">
            <div class="outerBox flexType3">
                <p class="title">복사등록</p>
                <div class="right flexType1">

                    <button type="button" class="btnType3 refBtn mr10" id="btn_reload" name="btn_reload">
                        <i class="fa-solid fa-arrow-rotate-right"></i>
                    </button>
                    <button type="button" class="btnType3 foldBtn"><i class="fa-solid fa-angle-down"></i></button>
                </div>

            </div>
            <div class="copyBox area_box2qd">
                <div class="copyArea copyArea1 flexType3">
                    <input type="search" class="copySearch" id="txt_before" name="txt_before" placeholder="이전 상품명을 입력하시고 엔터를 누르세요" onfocus="">
                    <button class="copyDropdown" type="button" id="btn_before" name="btn_before"> <i class="fas fa-caret-down"></i></button>
                </div>
                <div class="copyArea copyArea2  mr10 flexCol" id="beforelist" name="beforelist">
                </div>
            </div>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <p class="title">상품정보</p>
                <div class="right flexType1">
                    <button type="button" class="btnType3 foldBtn"><i class="fa-solid fa-angle-down"></i></button>
                </div>
            </div>
            <div class="area5 flexType2 area_box2qd ">
                <div class="elementBox ">
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
                        <p class="title">상품명</p>
                        <input type="search" id="pTitle" name="pTitle" class="inputType360" placeholder="상품명을 입력하세요." >
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">가격</p>
                        <input type="search" id="pPrice" name="pPrice" class="inputType360" placeholder="숫자만 입력 (예:10000)" >
                        <p class="unit">원</p>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">중량</p>
                        <input type="search" id="pWeight" name="pWeight"  class="inputType360" placeholder="중량을 입력하세요." >
                        <p class="unit">g</p>
                    </div>
                    <div class="element flexType2">
                        <p class="must"></p>
                        <p class="title">판매여부</p>
                        <select name="sell_type" id="sell_type" class="inputType360">
                            <option value="0" >판매대기</option>
                            <option value="1" selected>판매중</option>
                            <option value="2" >판매종료</option>
                        </select>
                    </div>
                    <div class="element element6 flexCol  ">
                        <div class="upside flexType2">
                            <p class="notmust"></p>
                            <p class="title">매칭코드</p>
                            <input type="search" class="inputType" id="excode" name="excode" placeholder="매칭코드를 입력하세요." >
                            <select name="extype" id="extype" class="selectType">
                                <option value="">선택</option>
                                <?=$body['excode'];?>
                            </select>
                            <button type="button" class="addMatch btnType3" name="addcode" id="addcode">추가</button>
                        </div>
                        <div class="downside flexType2">
                            <p class="notmust"></p>
                            <p class="title"></p>
                            <div class="flexCol mach_boxd2g " id="mached_list">
                            </div>
                        </div>
                    </div>
                    <div class="element goods_boxj3v flexType4">
                        <div class="left flexType2">
                            <p class="must"></p>
                            <p class="title">제품추가</p>
                        </div>
                        <div class="flexCol">
                            <div class="copyBox ">
                                <div class="copyArea copyArea1 flexType2 mr10">
                                    <div class="left">
                                        <input type="search" class="copySearch" id="txt_product" name="txt_product" placeholder="제품명 입력후 엔터" data-code="">
                                        <button class="copyDropdown" type="button" id="find_gcode" name="find_gcode"> <i class="fas fa-caret-down"></i></button>
                                    </div>
                                    <input type="number" placeholder="숫자만입력" class="count" id="txt_product_num" name="txt_product_num" />
                                    <button class="copyAdd btnType3 ml20" type="button" id="addproduct" name="addproduct">추가</button>
                                </div>
                                <div class="copyArea copyArea2" id="goods_list">
                                </div>
                            </div>
                            <div class="tagBox copyArea3" id="add_list" name="add_list">
                            </div>
                        </div>

                    </div>
                    <div class="goods_boxt6r cover_boxh1t" name="coverBox" id="cover_box" >
                        <div class="element flexType4 oneCover" name="oneCover" id="">
                            <p class="notmust"></p>
                            <p class="title">부자재</p>
                            <div class="tBagBox " name="tBagBox">
                                <div class="oneTBag mb10 flexType2" name="oneTBag">
                                    <select name="accessory" class="option option1">
                                        <option value="">선택</option>
                                        <?=$body['material'];?>
                                    </select>
                                    <input type="search" name="accessory_cnt" class="inputBorder inputBorder2 mr10" placeholder="예:10000">
                                    <button type="button" class="btnType3 addBtn mr10" name="addCover" >
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button type="button" class="btnType3 removeBtn" name="removeCover" style="">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                                <div class="tagBox smTagBox" id="sm_tag_list" name="sm_tag_list">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxm9k ">
            <div class="outerBox flexType3">
                <p class="title">상세정보</p>
                <div class="right flexType1">
                    <button type="button" class="btnType3 foldBtn"><i class="fa-solid fa-angle-down"></i></button>
                </div>
            </div>
            <div class="area5  area_box2qd   ">
                <div class="elementbox">
                    <div class="element flexType4 attach_boxp5s">
                        <div class="flexType2">
                            <p class="must"></p>
                            <p class="title">대표이미지</p>
                        </div>
                        <div id="thum_wrap" name="thum_wrap" class="thum_boxn4e mr10">
                            <label for="attachImg" class="photo-picker">
                                <input class="" type="file" name="attachImg" id="attachImg" multiple style="" data-ext="jpg,jpeg,png,gif" accept="image/jpeg, image/jpg, image/png, image/gif">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                        </div>
                        <div id="thumbArea" name="thumbArea" class="thum_arange flexType2 mr10">
                        </div>
                    </div>
                    <div class="element flexType4 attach_boxw0f">
                        <div class="flexType2">
                            <p class="notmust"></p>
                            <p class="title">상세설명</p>
                        </div>
                        <div class="infodetail">
                            <div id="ckeditor" class="infockeditor">
                            </div>
                            <textarea id="editor_data" name="editor_data" class="ckTextArea" style="display: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lastBox flexType5">
            <button type="button" class="btnType1 mr10">취소</button>
            <button type="button" id="submitBtn" name="submitBtn" class="btnType2">등록</button>
        </div>
        </div>

</section>
<?= $this->endSection() ?>