<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/producingControl_Do.js?rnd=--><?php //=rand();?><!--"> </script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox producing_boxr8j">
            <p class="headTitle">
                생산관리 / 진행상태
            </p>
        </div>
        <div class="areaBox area_boxg4q ">
            <div class="elementBox flexType2">
                <div class="element flexType2 left">
                    <p class="title">작업번호</p>
                    <p class="data data1">1234</p>
                </div>
                <div class="element flexType2">
                    <p class="title">작업명</p>
                    <p class="data data1">우엉차티백 생산공정</p>
                </div>

<!--                    <div class="element flexType2">-->
<!--                        <p class="title">작업명</p>-->
<!--                        <input type="search" class="inputType360" placeholder="우엉차티백 생산공정" readonly>-->
<!--                    </div>-->
<!--                    <div class="element flexType2">-->
<!--                        <p class="title">제품명</p>-->
<!--                        <input type="search" class="inputType360" placeholder="우엉차티백" readonly>-->
<!--                    </div>-->
<!--                    <div class="element flexType2">-->
<!--                        <p class="title">공정명</p>-->
<!--                        <input type="search" class="inputType360" placeholder="재료배합" readonly>-->
<!--                    </div>-->
            </div>
        </div>
        <div class="areaBox area_boxg4q ">
            <div class="elementBox">
                <div class="element flexType2">
                    <p class="title">제품명</p>
                    <p class="data">우엉차티백</p>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxg4q ">
            <div class="elementBox">
                <div class="titleBox ">
                    <p class="subtitle fontType1">
                        1차공정
                    </p>
                </div>
                <div class="element flexType2 roastingBox">
                    <div class="left flexType2">
                        <p class="title">공정명</p>
                        <p class="data">재료배합</p>
                    </div>
                    <div class="element flexType2 right">
                        <button type="button" class="btnType1 mr10">취소</button>
                        <button type="button" class="btnType2">시작</button>
                    </div>
                </div>

                <div class="element flexType2-1 status_boxv2l">
                    <div class="left flexType2">
                        <p class="title">저울측정</p>
                        <p class="data">50</p>
                        <p class="ml10 unit">kg</p>
                    </div>
                    <div class="right">
                        <div class="ingBox">
                            <div class="upside flexType2">
                                <p class="title">재료명</p>
                                <p class="title">투입량</p>
                            </div>
                            <div class="downside flexType2">
                                <p class="ingName mr10">우엉차</p>
                                <div class=" flexType2">
                                    <p class="data">50</p>
                                    <p class="ml10 unit">kg</p>
                                </div>
                            </div>
                            <div class="downside flexType2">
                                <p class="ingName mr10">우엉차</p>
                                <div class=" flexType2">
                                    <p class="data">50</p>
                                    <p class="ml10 unit">kg</p>
                                </div>
                            </div>
                            <div class="downside flexType2">
                                <p class="ingName mr10">우엉차</p>
                                <div class=" flexType2">
                                    <p class="data">50</p>
                                    <p class="ml10 unit">kg</p>
                                </div>
                            </div>
<!--                                <div class="submitBox flexType5 ">-->
<!--                                    <button type="button" class="btnType2">완료</button>-->
<!--                                </div>-->
                        </div>
                    </div>
                </div>
                <div class="elemment memo_boxb5h">
                    <textarea name="" id="" cols="" rows="" readonly placeholder="배합물의 상태를 확인한다. (건조도 확인, 용량 확인) "></textarea>
                </div>
                <div class="submitBox flexType5">
                    <button type="button" class="btnType2">완료</button>
                </div>
<!--                    <div class="element flexType3-1 status_boxv2l">-->
<!--                        <div class="left flexType2">-->
<!--                            <p class="title">저울측정</p>-->
<!--                            <p class="data">50</p>-->
<!--                            <p class="ml10 unit">kg</p>-->
<!--                        </div>-->
<!--                        <div class="right">-->
<!--                                <div class="ingBox">-->
<!--                                    <div class="upside flexType2">-->
<!--                                        <p class="title">재료명</p>-->
<!--                                        <p class="title">투입량</p>-->
<!--                                    </div>-->
<!--                                    <div class="downside flexType2">-->
<!--                                        <p class="ingName mr10">우엉차</p>-->
<!--                                        <div class=" flexType2">-->
<!--                                            <p class="data">50</p>-->
<!--                                            <p class="ml10 unit">kg</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="downside flexType2">-->
<!--                                        <p class="ingName mr10">우엉차</p>-->
<!--                                        <div class=" flexType2">-->
<!--                                            <p class="data">50</p>-->
<!--                                            <p class="ml10 unit">kg</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="downside flexType2">-->
<!--                                        <p class="ingName mr10">우엉차</p>-->
<!--                                        <div class=" flexType2">-->
<!--                                            <p class="data">50</p>-->
<!--                                            <p class="ml10 unit">kg</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="ingBox">-->
<!--                                    <div class="upside flexType2">-->
<!--                                        <p class="title">재료명</p>-->
<!--                                        <p class="title">투입량</p>-->
<!--                                    </div>-->
<!--                                    <div class="downside flexType2">-->
<!--                                        <p class="ingName mr10">우엉차</p>-->
<!--                                        <div class=" flexType2">-->
<!--                                            <p class="data">50</p>-->
<!--                                            <p class="ml10 unit">kg</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                        </div>-->
<!--                    </div>-->
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>