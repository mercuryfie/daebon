<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/packingStatus_Do.js?rnd=<?= rand(); ?>"></script>
<script>
</script>

<section class="merright">
    <div class="packing_wraptrf">
        <div class="titleBox">
            <p class="headTitle">
                포장작업화면
            </p>
            <input type="search"
                   class="inputType520 ml20"
                   placeholder="작업지시서 번호를 입력하십시오" name="" id="">
        </div>
        <div class="areaBox">
            <div class="area area5 flexType3-1 ">
                <div class="progress_boxatq flexType2-1">
                    <p class='title'>작업상태</p>
                    <div class="flexType2">
                        <div class="progress flexCol2">
                            <button class="squareType2">
                                <i class="fa-regular fa-square-check"></i>
                            </button>
                            <p class="status">작업선택</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType">
                                <i class="fa-solid fa-print"></i>
                            </button>
                            <p class="status">상품확인</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2">
                                <i class="fa-solid fa-print"></i>
                            </button>
                            <p class="status">수량확인</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2">
                                <i class="fa-solid fa-receipt"></i>
                            </button>
                            <p class="status">송장출력</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2">
                                <i class="fa-solid fa-box-open"></i>
                            </button>
                            <p class="status">포장</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexCol2">
                            <button class="squareType2">
                                <i class="fa-solid fa-cube"></i>
                            </button>
                            <p class="status">완료</p>
                        </div>
                    </div>

                </div>
                <div class="right flexType2 printBox">
                    <button type="button" class="btnType3 mr10" onclick="pop_waybillForm();">송장<br>출력</button>
                    <button type="button" class="btnType3" onclick="pop_waybillForm();">추가<br>출력</button>
                </div>
            </div>
            <div class="area area1">
                <p class='title'>상품정보/수량 확인</p>
                <div class="productCheck_boxarv">
                    <div class="productCheck flexType2">
                        <p class="category">주문번호</p>
                        <p class="data">12341234</p>
                    </div>
                    <div class="productCheck flexType2">
                        <p class="category">주소지</p>
                        <p class="data">서울시 강남구</p>
                    </div>
                    <div class="productCheck flexType2">
                        <p class="category">주문내용</p>
                        <p class="data">생강차 200g 외 2건</p>
                    </div>
                    <div class="productCheck flexType2">
                        <p class="category">수량</p>
                        <p class="data">총 10건</p>
                    </div>
                </div>
                <div class="imgBox_box2ck flexType2">
                    <div class="noirBox">
                        <div class="noirLayer noir2">
                            <!--                        <div class="noir"></div>-->
                            <div class="done active flexType1">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <img src="/assets/web/src/packing_1.png" alt="img">
                        </div>
                        <p class="ttl">우엉차 20%우엉차 20%우엉차 20%</p>
                    </div>
                    <div class="noirBox">
                        <div class="noirLayer">
                            <div class="noir"></div>
                            <div class="done flexType1">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <img src="/assets/web/src/packing_1.png" alt="img">
                        </div>
                        <p class="ttl">우엉차 20%우엉차 20%우엉차 20%</p>
                    </div>
                    <div class="noirBox">
                        <div class="noirLayer">
                            <div class="noir"></div>
                            <div class="done flexType1">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <img src="/assets/web/src/packing_1.png" alt="img">
                        </div>
                        <p class="ttl">우엉차 20%우엉차 20%우엉차 20%</p>
                    </div>
                    <div class="countBox">
                        <p class="count">2개</p>

                    </div>
                    <div class="btnBox">
                        <button type="button" class="btn">확인</button>

                    </div>
                </div>
            </div>
            <div class="area area3">
                <p class="title">포장과정 촬영</p>
                <div class="imgBox_boxdzu flexType2">
                    <div class="planeLayer">
                        <!--                        <div class="noir"></div>-->
                        <img src="/assets/web/src/packing_1.png" alt="img">
                    </div>
                    <div class="planeLayer">
                        <button type="button" class="closeBtn">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img src="/assets/web/src/packing_1.png" alt="img">
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
                    <div class="dashedLayer">
                        <p class="inputArea">+</p>
                    </div>
<!--                    <div class="dashedLayer">-->
<!--                        <button type="button" class="closeBtn">-->
<!--                            <i class="fa-solid fa-xmark"></i>-->
<!--                        </button>-->
<!--                        <p class="inputArea"></p> -->
<!--                    </div>-->
<!--                    <div class="dashedLayer">-->
<!--                        <button type="button" class="closeBtn">-->
<!--                            <i class="fa-solid fa-xmark"></i>-->
<!--                        </button>-->
<!--                        <p class="inputArea"></p> -->
<!--                    </div>-->
                    <div class="btnBox">
                        <button type="button" class="btn">촬영</button>

                    </div>
                </div>
                <div class="lastBox flexType6 ">
                    <button type="button" class="btnType2">확인</button>

                </div>

            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>