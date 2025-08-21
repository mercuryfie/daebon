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
        <div class="merright1-0 link_wrap5r6">
            <div class="titleBox">
                <p class="headTitle">
                    주문관리 / 쇼핑몰 연동
                </p>
            </div>
            <div class="areaBox ">
                <div class="area1 flexType2">
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
                <div class="area2 flexType2">
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
                    <button type="button" class="btnType2">검색</button>

                </div>
                <div class="area3">
                    <button type="button" class="btnType1 mr10">주문수집</button>
                    <button type="button" class="btnType1">초기화</button>
                </div>
                <div class="area4">
                    <table class="linkMallsTable ">
                        <thead>
                            <tr>
                                <td class="ltThead"></td>
                                <td class="ltThead">번호</td>
                                <td class="ltThead">쇼핑몰</td>
                                <td class="ltThead">쇼핑몰명</td>
                                <td class="ltThead">구매자명</td>

                                <td class="ltThead">구매자ID</td>
                                <td class="ltThead">수집시점(주문)</td>
                                <td class="ltThead">상태</td>
                                <td class="ltThead">수집시점(클레임)</td>
                                <td class="ltThead">상태</td>

                                <td class="ltThead">비고</td>
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
                                <td class="ltTbody">
                                    <p class="positive">정상</p>
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">
                                    <p class="positive">정상</p>
                                </td>

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
                                <td class="ltTbody">
                                    <p class="positive">정상</p>
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">
                                    <p class="positive">정상</p>
                                </td>

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
                                <td class="ltTbody">
                                    <p class="negative">오류</p>
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">
                                    <p class="negative">오류</p>
                                </td>

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
                                <td class="ltTbody">
                                    <p class="negative">오류</p>
                                </td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">
                                    <p class="negative">오류</p>
                                </td>

                                <td class="ltTbody">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>