<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>

    <!-- calendar ----------------------------  -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>

    <!-- daum 주소 api ----------------------------  -->
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/orderList_Do.js?rnd=<?= rand(); ?>"></script>
    <script>
    </script>

    <section class="merright">
        <div class="order_box28f">
            <div class="titleBox">
                <p class="headTitle">
                    주문관리 / 주문목록
                </p>
            </div>
            <div class="swich_boxli6 ">
                <i class="fa-regular fa-calendar" onclick="go_dashboard();"></i>
                <p class="binder"></p>
                <i class="fa-solid fa-list" onclick="go_orderList();"></i>
            </div>
            <div class="areaBox">
                <div class="area5 flexType2 ">
                    <div class="countBox ">
                        <p class="status status1">전체 주문: 16건, 작업중 16건, 발송완료 14건</p>
                        <p class="status status2">옥션1: 000건,  옥션2 : 004건, 지마켓: 002건  농협몰:  010건, 취소: 000건 </p>
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">전체주문</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">10</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">발송</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">10</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">발송완료</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">10</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">취소</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">10000</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
<!--                    <div class="countBox ml20">-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">옥션</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">100</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">지마켓</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">10</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="count flexType3">-->
<!--                            <p class="title">농협몰</p>-->
<!--                            <div class="howmany flexType2">-->
<!--                                <p class="number mr10">100</p>-->
<!--                                <p class="unit">건</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
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
                        <button type="button" class="btnType1 mr10" onclick="upload_Xlx();">엑셀업로드</button>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <p class="title">검색조건</p>
                        <select name="" id="" class="searchFilter ">
                            <option value="">상태필터</option>
                            <option value="">포장대기</option>
                            <option value="">포장중</option>
                            <option value="">포장완료</option>
                        </select>
                        <select name="" id="" class="searchFilter">
                            <option value="">검색조건</option>
                            <option value="">주문번호</option>
                            <option value="">상품번호</option>
                            <option value="">구매자명</option>
                            <option value="">구매자ID</option>
                        </select>
                        <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
                        <button type="button" class="btnType1">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2" onclick="add_Order();">주문등록</button>
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
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody status10" onclick="add_packingQueue();">포장대기</td>
                                <td class="ltTbody">abcabc</td>
                                <td class="ltTbody">abcabc</td>

                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">12341234</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody status10" onclick="add_packingQueue();">포장대기</td>
                                <td class="ltTbody">abcabc</td>
                                <td class="ltTbody">abcabc</td>

                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">12341234</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody status10" onclick="add_packingQueue();">포장대기</td>
                                <td class="ltTbody">abcabc</td>
                                <td class="ltTbody">abcabc</td>

                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">12341234</td>
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
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="ltTbody">우엉차</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">10,000</td>
                                <td class="ltTbody">10</td>

                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">엑셀</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">우엉차</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">10,000</td>
                                <td class="ltTbody">10</td>

                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">엑셀</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            <tr>
                                <td class="ltTbody">우엉차</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">홍길동</td>
                                <td class="ltTbody">10,000</td>
                                <td class="ltTbody">10</td>

                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">엑셀</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->include('/web/include/pop_AddPackingQueue_View'); ?>
<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?= $this->include('/web/include/pop_AddOrder_View'); ?>
<?= $this->endSection() ?>