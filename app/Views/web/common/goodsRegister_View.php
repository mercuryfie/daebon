<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/goodsRegister_Do.js?rnd=<?=rand();?>"> </script>
    <!-- ckeditor ----------------------------  -->
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <script>
    </script>

    <section class="merright">
        <div class="goods_boxx7z">
            <div class="titleBox">
                <p class="headTitle">
                    기준정보관리 / 상품등록
                </p>
            </div>
            <div class="areaBox area_boxm9k">
                <div class="outerBox flexType3">
                    <p class="title">복사등록</p>
<!--                    <div class="right flexType1">-->
<!--                        <i class="fa-solid fa-angle-down"></i>-->
<!--                    </div>-->
                </div>
                <select name="" id="" class="copySelect">
                    <option value="" disabled selected>복사할 항목을 선택하십시오. </option>
                    <option value="">b</option>
                    <option value="">c </option>
                </select>
            </div>
            <div class="areaBox area_boxm9k ">
                <div class="outerBox flexType3">
                    <p class="title">상품정보</p>
                    <div class="right flexType1">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <div class="area5 flexType2 area_box2qd ">
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
                            <p class="title">상품명</p>
                            <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">가격</p>
                            <input type="search" class="inputType360" placeholder="숫자만 입력 (예:10000)" >
                            <p class="unit">원</p>
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">중량</p>
                            <input type="search" class="inputType360" placeholder="상품명을 입력하세요." >
                            <p class="unit">g</p>
                        </div>
                        <div class="element flexType2">
                            <p class="must"></p>
                            <p class="title">판매여부</p>
                            <select name="" id="" class="inputType360">
                                <option value="">판매중</option>
                                <option value="">판매종료</option>
                            </select>
                        </div>
                        <div class="element flexCol  ">
                            <div class="upside flexType2">
                                <p class="must"></p>
                                <p class="title">매칭코드</p>
                                <input type="search" class="inputType" placeholder="상품명을 입력하세요." >
                                <select name="" id="" class="selectType">
                                    <option value="" disabled selected>선택</option>
                                    <option value="">옥션</option>
                                    <option value="">지마켓</option>
                                </select>
                                <button type="button" class="btnType1">코드추가</button>
                            </div>
                            <div class="downside flexType2">
                                <p class="notmust"></p>
                                <p class="title"></p>
                                <div class="flexCol mach_boxd2g mt10">
                                    <div class="mached flexType2" name="mached">
                                        <p class="code">DX12341234</p>
                                        <p class="market">11번가</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="mached flexType2" name="mached">
                                        <p class="code">DX12341234</p>
                                        <p class="market">옥션</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="mached flexType2" name="mached">
                                        <p class="code">DX12341234</p>
                                        <p class="market">지마켓</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="goods_boxt6r" name="goodsBox" id="">
                            <div class="goods_boxk8u" name="oneGoods">
                                <div class="element flexType2">
                                    <p class="notmust"></p>
                                    <p class="title">제품</p>
                                    <select name="" id="" class="inputType360">
                                        <option value="">선택1</option>
                                        <option value="">우엉차</option>
                                        <option value="">우엉차</option>
                                    </select>
                                </div>
                                <div class="element flexType2">
                                    <p class="notmust"></p>
                                    <p class="title">소분류</p>
                                    <select name="" id="" class="inputType360">
                                        <option value="">선택2</option>
                                        <option value="">우엉차 10% [200g]</option>
                                        <option value="">우엉차 10% [200g]</option>
                                    </select>
                                </div>
                                <div class="element flexType2">
                                    <p class="notmust"></p>
                                    <p class="title">수량</p>
                                    <input type="search" class="inputType360" placeholder="숫자만 입력(예:1)" >
                                    <p class="count">개</p>
                                </div>
                            </div>
                        </div>
                        <div class="element flexType2 goods_boxj3v ">
                            <p class="notmust"></p>
                            <p class="title"></p>
                            <button type="button" class="btnType1" name="addGoods" >제품추가</button>

                        </div>
                        <div class="goods_boxt6r cover_boxh1t" name="packageBox" id="" >
                            <div class="element flexType2" name="onePackage" id="">
                                <p class="notmust"></p>
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
                        <div class="element flexType2 goods_boxj3v">
                            <p class="notmust"></p>
                            <p class="title"></p>
                            <button type="button" class="btnType1" name="addPackage">부자재 추가</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxm9k ">
                <div class="outerBox flexType3">
                    <p class="title">상세정보</p>
                    <div class="right flexType1">
                        <i class="fa-solid fa-angle-down"></i>
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
            <div class="lastBox flexType6">
                <button type="button" class="btnType1 mr10">취소</button>
                <button type="button" id="submitBtn" name="submitBtn" class="btnType2">확인</button>
            </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>