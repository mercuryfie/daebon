<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/productionStatus_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    생산현황
                </p>
                <input type="search"
                       class="inputType520 ml20"
                       placeholder="바코드를 스캔하십시오" name="" id="">
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg sang_boxs7c flexType3">
                    <div class="left flexType2">
                        <p class="title">작업번호</p>
                        <p class="count">12341234</p>
<!--                        <p class="unit">건</p>-->
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2">목록</button>
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
                                    <td class="ltThead">공정결과명</td>
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
                                    <td class="ltTbody under" onclick="go_productionDetail();">1234</td>
                                    <td class="ltTbody">허브차 1</td>
                                    <td class="ltTbody">20kg</td>

                                    <td class="ltTbody under" onclick="go_productionDetail();">진행중</td>
                                    <td class="ltTbody">홍길동</td>

                                </tr>
                                <tr>
                                    <td class="ltTbody">
                                        2
                                    </td>
                                    <td class="ltTbody">2025.01.01</td>
                                    <td class="ltTbody under" onclick="go_productionDetail();">1234</td>
                                    <td class="ltTbody">허브차 2</td>
                                    <td class="ltTbody">20kg</td>

                                    <td class="ltTbody under" onclick="go_productionDetail();">준비중</td>
                                    <td class="ltTbody">홍길동</td>

                                </tr>
                                <td class="ltTbody">
                                    3
                                </td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody under" onclick="go_productionDetail();">1234</td>
                                <td class="ltTbody">허브차 3</td>
                                <td class="ltTbody">20kg</td>

                                <td class="ltTbody under" onclick="go_productionDetail();">완료</td>
                                <td class="ltTbody">춘향이</td>

                                </tr>
                                <td class="ltTbody">
                                    4
                                </td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody under" onclick="go_productionDetail();">1234</td>
                                <td class="ltTbody">허브차 4</td>
                                <td class="ltTbody">20kg</td>

                                <td class="ltTbody under" onclick="go_productionDetail();">대기</td>
                                <td class="ltTbody">춘향이</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>