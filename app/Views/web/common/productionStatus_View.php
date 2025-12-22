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
                <input type="search" class="inputType520 ml20" placeholder="바코드를 스캔하십시오" name="in_code" id="in_code">
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg sang_boxs7c flexType3">
                    <div class="left flexType2">
                        <p class="title">작업지시시번호</p>
                        <p class="count" id="gicode" name="gicode"><?=$body['code'];?></p>
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
                                    <td class="ltThead">작업번호</td>
                                    <td class="ltThead">공정결과명</td>
                                    <td class="ltThead">투입량</td>
                                    <td class="ltThead">예상산출량</td>
                                    <td class="ltThead">상태</td>
                                    <td class="ltThead">작업자</td>
                                </tr>
                            </thead>
                            <tbody id="tList" name="tList">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>