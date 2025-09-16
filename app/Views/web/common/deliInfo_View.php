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
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="deli_wrapghj">
            <div class="titleBox">
                <p class="headTitle">
                    주문관리 / 배송정보
                </p>
                <div class="deli_box2w9 flexType3">
                    <p class="status">전체 주문 : 100 건 / 발송 : 10 건 / 발송완료 : 10 건</p>
                    <div class="swich_boxli6 ">
                        <i class="fa-regular fa-calendar"></i>
                        <p class="binder"></p>
                        <i class="fa-solid fa-list"></i>
                    </div>
                </div>
            </div>
            <div class="areaBox">
                <div class="area1 flexType3">
                    <div class="left flexType2">
                        <p class="title">기간</p>
                        <a href="#" class="period">오늘</a>
                        <a href="#" class="period">1주일</a>
                        <a href="#" class="period">1개월</a>
                        <a href="#" class="period">3개월</a>
                        <div class="date_boxtc6 flexType2">
                            <label for="date1" class="dateLabel1">
                                <input type="text" id="s_date" name="date1" class="inputType160 date1" placeholder="2025/01/01" >
                                <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                            </label>
                            <p class="wave">~</p>
                            <label for="date2" class="dateLabel2">
                                <input type="text" id="e_date" name="date2" class="inputType160 " placeholder="2025/12/31" >
                                <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                            </label>
                        </div>
                    </div>
                    <div class="right flexType1">
                        <select name="" id="" class="btnType1 mr10">
                            <option value="">20개씩</option>
                            <option value="">50개씩</option>
                            <option value="">100개씩</option>
                        </select>
                        <select name="" id="" class="btnType1 mr10 ">
                            <option value="">주문확인중</option>
                            <option value="">배송준비중</option>
                            <option value="">배송중</option>
                            <option value="">배송완료</option>
                        </select>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <p class="title">검색조건</p>
                        <select name="" id="" class="searchFilter ">
                            <option value="">쇼핑몰</option>
                            <option value="">옥션</option>
                            <option value="">지마켓</option>
                        </select>
                        <select name="" id="" class="searchFilter">
                            <option value="">주문번호</option>
                            <option value="">상품번호</option>
                            <option value="">구매자명</option>
                            <option value="">구매자ID</option>
                        </select>
                        <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
                        <button type="button" class="btnType2">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType1">초기화</button>

                    </div>
                </div>
                <div class="area4 ">
                    <div class="deli_box1od">
                        <table class="deliInfoTable ">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol"></td>
                                <td class="ltThead productNo">송장번호</td>
                                <td class="ltThead productNo">송장등록일</td>
                                <td class="ltThead productNo">주문일</td>
                                <td class="ltThead productNo">쇼핑몰</td>

                                <td class="ltThead productNo">상품명</td>
                                <td class="ltThead productNo">수량</td>
                                <td class="ltThead productNo">주문자</td>
                                <td class="ltThead productNo">수령인</td>
                                <td class="ltThead productNo">수령인 주소</td>
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