<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <script src="<?=URL_COMMON_ASSETS?>/dashBoard_Do.js"> </script>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>

    <!-- calendar ----------------------------  -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="packing_wraph1c">
            <div class="titleBox">
                <p class="headTitle">
                    포장발송화면 / 작업선택
                </p>
                <input type="search"
                       class="inputType520 ml20"
                       placeholder="작업지시서 번호를 입력하십시오" name="" id="">
            </div>
            <div class="areaBox">
                <div class="area5 flexType2 ">
                    <div class="progress_boxatq flexType2">
                        <div class="progress flexType3">
                            <button class="squareType">
                                <i class="fa-regular fa-square-check"></i>
                            </button>
                            <p class="status">작업선택</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="progress flexType3">
                            <button class="squareType">
                                <i class="fa-regular fa-square-check"></i>
                            </button>
                            <p class="status">작업선택</p>
                        </div>
                        <div class="angle">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
                <div class="area4 packing_boxfxp">
                    <table class="">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead productNo">주문번호</td>
                            <td class="ltThead productNo">상품명</td>
                            <td class="ltThead productNo">판매자ID</td>
                            <td class="ltThead productNo">수령인</td>

                            <td class="ltThead productNo">송장출력</td>
                            <td class="ltThead productNo">포장</td>
                            <td class="ltThead productNo">완료</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="ltTbody">
                                1
                            </td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>


                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                        </tr>
                        <tr>
                            <td class="ltTbody">2
                            </td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>


                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                        </tr>
                        <tr>
                            <td class="ltTbody">3
                            </td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>


                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>