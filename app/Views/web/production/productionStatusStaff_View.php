<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/productionStatus_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
    <script>
    </script>

    <section class="mainContentStaff">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    생산현황 staff
                </p>
                <input type="search"
                       class="inputType520 "
                       placeholder="바코드를 스캔하십시오" name="" id="" autofocus>
            </div>
            <div class="areaBoxStaff area_boxmxh ">
                <div class="goods_boxkfg sang_boxs7c flexType3">
                    <div class="left flexType2">
                        <p class="title">작업번호</p>
                        <p class="count">12341234</p>
<!--                        <p class="unit">건</p>-->
                    </div>
                    <div class="right">
                        <button type="button" class="btn80Type1 mr10" onclick="">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                        <button type="button" class="btn80Type2  " onclick="go_productionListStaff();">목록</button>
                    </div>
                </div>
                <div class="area4 goods_boxa1b flexType2">
                    <div class="produce_boxfxp">
                        <table class="orderInfoTable orderInfoTable1 ">
                            <thead>
                                <tr>
                                    <th class="ltThead productNo checkCol">순번</th>
                                    <th class="ltThead">등록일시</th>
                                    <th class="ltThead">작업번호</th>
                                    <th class="ltThead">공정결과명</th>
                                    <th class="ltThead">무게</th>

                                    <th class="ltThead">상태</th>
                                    <th class="ltThead">작업자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr onclick="go_productionDetailStaff();">
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
                                <tr onclick="go_productionDetailMonoStaff();">
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