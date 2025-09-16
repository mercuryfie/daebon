<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/producingControl_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    생산관리 / 제품생산화면
                </p>
                <input type="search"
                       class="inputType520 ml20"
                       placeholder="작업지시서 번호를 입력하십시오" name="" id="">
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg ">
                    <p class="form">생산지시서</p>
                    <div class="left flexType2">
                        <p class="title">생산목록</p>
                        <p class="count">10</p>
                        <p class="unit">건</p>
                    </div>
                </div>
                <div class="area4 goods_boxa1b flexType2">
                    <div class="produce_boxfxp">
                        <table class="orderInfoTable orderInfoTable1 ">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol">순번</td>
                                <td class="ltThead">등록일시</td>
                                <td class="ltThead">작업번호</td>
                                <td class="ltThead">작업명</td>
                                <td class="ltThead">무게</td>

                                <td class="ltThead">상태</td>
                                <td class="ltThead">작업자</td>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ltTbody">
                                        1
                                    </td>
                                    <td class="ltTbody">2025.01.01</td>
                                    <td class="ltTbody under">1234</td>
                                    <td class="ltTbody">허브차 200g</td>
                                    <td class="ltTbody">20kg</td>

                                    <td class="ltTbody under">1차 공정 진행중 (1/3)</td>
                                    <td class="ltTbody">홍길동</td>

                                </tr>
                                <tr>
                                    <td class="ltTbody">
                                        2
                                    </td>
                                    <td class="ltTbody">2025.01.01</td>
                                    <td class="ltTbody under">1234</td>
                                    <td class="ltTbody">허브차 200g</td>
                                    <td class="ltTbody">20kg</td>

                                    <td class="ltTbody under">1차 공정 진행중 (1/3)</td>
                                    <td class="ltTbody">홍길동</td>

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