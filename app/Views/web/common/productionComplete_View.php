<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/sangComplete_Do.js?rnd=<?=rand();?>"> </script>
    <script>
    </script>

    <section class="merright">
        <div class="goods_boxfv6 ">
            <div class="titleBox producing_boxr8j">
                <p class="headTitle">
                    생산현황 상세
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
            <div class="areaBox area_boxg4q sang_boxu9d">
                <div class="elementBox">
                    <div class="titleBox ">
                        <p class="subtitle fontType1">
                            1차공정
                        </p>
                    </div>
                    <div class="element flexType2 prog_boxl1p">
                        <div class="left flexType2">
                            <p class="title">공정명</p>
                            <p class="data">재료배합</p>
                        </div>
                        <div class="right prog_boxo6r">
                            <div class="status_boxi3f flexType3">
                                <p class="status start">시작</p>
                                <p class="status end">완료</p>
                            </div>
                            <div class="prog_Box">
                                <div class=" prog_background">
                                    <div class="stanbyBox flexType1">
                                        <p class="stanby"></p>
                                    </div>
                                    <div class="stanbyBox2 flexType1">
                                        <p class="stanby2"></p>
                                    </div>
                                </div>
                                <div class="prog_now" name="progNow">
                                    <div class="stanbyBox flexType1">
                                        <p class="stanby"></p>
                                    </div>
                                    <div class="stanbyBox2 flexType1">
                                        <p class="stanby2"></p>
                                    </div>
                                </div>
                            </div>
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
                                <table class="weight_tablevufb">
                                    <thead>
                                    <tr>
                                        <td class="title">재료명</td>
                                        <td class="title">예상 입고량</td>
                                        <td class="title">실제 입고량</td>
                                        <td class="title">-</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="weight">우엉차</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight ">
                                            <button type="button" class="wConfirm">확인</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="weight">우엉차</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight ">
                                            <button type="button" class="wConfirm">확인</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="weight">우엉차</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight">50kg</td>
                                        <td class="weight ">
                                            <button type="button" class="wConfirm">확인</button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="elemment memo_boxb5h">
                        <textarea name="" id="" cols="" rows="" readonly placeholder="배합물의 상태를 확인한다. (건조도 확인, 용량 확인) "></textarea>
                    </div>
                    <div class="submitBox flexType5">
                        <button type="button" class="btnType2" onclick="go_productionStatus();">확인</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>