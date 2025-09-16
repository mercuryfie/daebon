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
                    생산관리 / 작업현황
                </p>
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
                    <div class="produce_boxfxp">
                        <table class="orderInfoTable orderInfoTable1 ">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol"></td>
                                <td class="ltThead">작업번호</td>
                                <td class="ltThead">제품명</td>
                                <td class="ltThead">-</td>
                                <td class="ltThead">-</td>

                                <td class="ltThead">-</td>
                                <td class="ltThead">작업등록일</td>
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