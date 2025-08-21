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
        <div class="order_box28f">
            <div class="titleBox">
                <p class="headTitle">
                    주문관리 / 주문정보  PackingStatus
                </p>
            </div>
            <div class="swich_boxli6 ">
                <i class="fa-regular fa-calendar"></i>
                <p class="binder"></p>
                <i class="fa-solid fa-list"></i>
            </div>
            <div class="areaBox">
                <div class="area5 flexType2 ">
                    <div class="countBox ">
                        <div class="count flexType3">
                            <p class="title">전체주문</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="count flexType3">
                            <p class="title">발송</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="count flexType3">
                            <p class="title">발송완료</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="count flexType3">
                            <p class="title">취소</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">10000</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                    <div class="countBox ml20">
                        <div class="count flexType3">
                            <p class="title">옥션</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">100</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="count flexType3">
                            <p class="title">지마켓</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="count flexType3">
                            <p class="title">농협몰</p>
                            <div class="howmany flexType2">
                                <p class="number mr10">100</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="area1 flexType3">
                    <div class="left flexType2">
                        <p class="title">기간</p>
                        <a href="#" class="period">오늘</a>
                        <a href="#" class="period">1주일</a>
                        <a href="#" class="period">1개월</a>
                        <a href="#" class="period">3개월</a>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType1">엑셀업로드</button>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <p class="title">검색조건</p>
                        <select name="" id="" class="searchFilter ">
                            <option value="">전체</option>
                            <option value="">정상수집</option>
                            <option value="">오류</option>
                        </select>
                        <select name="" id="" class="searchFilter">
                            <option value="">주문번호</option>
                            <option value="">상품번호</option>
                            <option value="">구매자명</option>
                            <option value="">구매자ID</option>
                        </select>
                        <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
                        <button type="button" class="btnType1">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2">주문등록</button>
                    </div>
                </div>
                <div class="area4 ">
                    <div class="order_boxfxp">
                        <table class="orderInfoTable orderInfoTable1 ">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol"></td>
                                <td class="ltThead productNo">주문번호</td>
                                <td class="ltThead productNo">진행상태</td>
                                <td class="ltThead productNo">판매자ID</td>
                                <td class="ltThead productNo">구매자ID</td>

                                <td class="ltThead productNo">주문번호</td>
                                <td class="ltThead productNo">상품번호</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>


                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>


                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>


                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>


                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
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
                    <div class="order_boxe4z">
                        <table class="orderInfoTable orderInfoTable2 ">
                            <thead>
                            <tr>
                                <td class="ltThead">상품명</td>
                                <td class="ltThead">구매자명</td>
                                <td class="ltThead">수신인명</td>

                                <td class="ltThead">구매금액</td>
                                <td class="ltThead">수량</td>
                                <td class="ltThead">송장출력일</td>
                                <td class="ltThead">등록일</td>
                                <td class="ltThead">등록</td>
                                <td class="ltThead">비고</td>
                                <td class="ltThead">비고</td>
                                <td class="ltThead">비고</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
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
<!--                    <table class="orderInfoTable ml20">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <td class="ltThead productNo"></td>-->
<!--                            <td class="ltThead productNo">주문번호</td>-->
<!--                            <td class="ltThead productNo">진행상태</td>-->
<!--                            <td class="ltThead productNo">판매자ID</td>-->
<!--                            <td class="ltThead productNo">구매자ID</td>-->
<!---->
<!--                            <td class="ltThead productNo">주문번호</td>-->
<!--                            <td class="ltThead productNo">상품번호</td>-->
<!--                            <td class="ltThead">상품명</td>-->
<!--                            <td class="ltThead">구매자명</td>-->
<!--                            <td class="ltThead">수신인명</td>-->
<!---->
<!--                            <td class="ltThead">구매금액</td>-->
<!--                            <td class="ltThead">수량</td>-->
<!--                            <td class="ltThead">송장출력일</td>-->
<!--                            <td class="ltThead">등록일</td>-->
<!--                            <td class="ltThead">등록</td>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        <tr>-->
<!--                            <td class="ltTbody">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td class="ltTbody">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td class="ltTbody">-->
<!--                                <input type="checkbox" name="" id="">-->
<!--                            </td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!---->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                            <td class="ltTbody">-</td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                    </table>-->
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>