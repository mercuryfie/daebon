<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/goodsList_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    상품목록
                </p>
            </div>
            <div class="areaBox area_boxd2s">
                <div class="flexType2">
                    <div class="progress flexType2">
                        <button class="squareType">
                            <i class="fa-regular fa-square-check"></i>
                        </button>
                        <div class="right">
                            <p class="status">전체</p>
                            <div class="countBox flexType2">
                                <p class="count">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress flexType2">
                        <button class="squareType2">
                            <i class="fa-solid fa-arrow-trend-down"></i>
                        </button>
                        <div class="right">
                            <p class="status">재고 10개 이하</p>
                            <div class="countBox flexType2">
                                <p class="count">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress flexType2">
                        <button class="squareType2">
                            <i class="fa-solid fa-chart-line"></i>
                        </button>
                        <div class="right">
                            <p class="status">주간 평균판매량</p>
                            <div class="countBox flexType2">
                                <p class="count">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress flexType2">
                        <button class="squareType2">
                            <i class="fa-solid fa-chart-line"></i>
                        </button>
                        <div class="right">
                            <p class="status">월간 평균판매량</p>
                            <div class="countBox flexType2">
                                <p class="count">10</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="area1 flexType3">
                    <div class="left flexType2">
                        <p class="title">기간</p>
                        <a href="javascript:;" class="period">오늘</a>
                        <a href="javascript:;" class="period">1주일</a>
                        <a href="javascript:;" class="period">1개월</a>
                        <a href="javascript:;" class="period">3개월</a>
                    </div>
                </div>
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <p class="title">검색조건</p>
                        <select name="" id="" class="searchFilter ">
                            <option value="">전체</option>
                            <option value="">상품준비중</option>
                            <option value="">배송중</option>
                            <option value="">배송완료</option>
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
                        <button type="button" class="btnType2 " onclick="go_goodsReg();">상품등록</button>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                        <p class="title">상품목록</p>
                        <p class="count">10</p>
                        <p class="unit">건</p>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
                <div class="area4 goods_boxa1b flexType2">
                    <div class="order_boxfxp">
                        <table class="orderInfoTable orderInfoTable1 ">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol"></td>
                                <td class="ltThead">상품번호</td>
                                <td class="ltThead">상품명</td>
                                <td class="ltThead  ">중량</td>
                                <td class="ltThead">가격</td>

                                <td class="ltThead">등록일</td>
                                <td class="ltThead">최근 30일간 판매량</td>
                                <td class="ltThead">전년도 동월 판매량</td>
                                <td class="ltThead">재고현황</td>
                                <td class="ltThead">작업 중 수량</td>

                                <td class="ltThead">간편작업지시</td>
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
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>

                                <td class="ltTbody">-</td>
                                <td class="ltTbody">-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<!--                    <div class="order_boxe4z">-->
<!--                        <table class="orderInfoTable orderInfoTable2 ">-->
<!--                            <thead>-->
<!--                            <tr>-->
<!--                                <td class="ltThead">최근 30일간 판매량</td>-->
<!--                                <td class="ltThead">전년도 동월 판매량</td>-->
<!--                                <td class="ltThead">재고현황</td>-->
<!--                                <td class="ltThead">작업 중 수량</td>-->
<!--                                <td class="ltThead">간편작업지시</td>-->
<!--                                <td class="ltThead">비고</td>-->
<!---->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                            <tr>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!---->
<!--                                <td class="ltTbody">-</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!---->
<!--                                <td class="ltTbody">-</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!---->
<!--                                <td class="ltTbody">-</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!---->
<!--                                <td class="ltTbody">-</td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!--                                <td class="ltTbody">-</td>-->
<!---->
<!--                                <td class="ltTbody">-</td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>