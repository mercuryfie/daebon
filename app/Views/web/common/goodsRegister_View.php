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
        <div class="goods_boxx7z">
            <div class="titleBox">
                <p class="headTitle">
                    기준정보관리 / 상품등록
                </p>
            </div>
            <div class="areaBox area_boxm9k">
                <div class="outerBox flexType3">
                    <p class="title">복사등록</p>
                    <div class="right flexType1">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </div>
                <select name="" id="" class="copySelect">
                    <option value="" disabled selected>복사할 항목을 선택하십시오. </option>
                    <option value="">b</option>
                    <option value="">c </option>
                </select>
            </div>
            <div class="areaBox area_boxm9k">
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
                        <div class="element flexCol">
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
                                <div class="flexCol">
                                    <div class="mached flexType2">
                                        <p class="code">DX12341234</p>
                                        <p class="market">11번가</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="mached flexType2">
                                        <p class="code">DX12341234</p>
                                        <p class="market">옥션</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="mached flexType2">
                                        <p class="code">DX12341234</p>
                                        <p class="market">지마켓</p>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                </div>
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