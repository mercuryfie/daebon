<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/sangStatus_Do.js?rnd=<?=rand();?>"> </script>
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
                        <table class="orderInfoTable orderInfoTable1 pro_tablefz7c">
                            <thead>
                            <tr>
                                <td class="ltThead productNo checkCol"></td>
                                <td class="ltThead">작업번호</td>
                                <td class="ltThead">제품명</td>
                                <td class="ltThead">-</td>
                                <td class="ltThead">-</td>

                                <td class="ltThead">-</td>
                                <td class="ltThead">작업상태</td>
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
                                    <td class="ltTbody"><button type="button" class="btnType4 statusBtn statusStandby" name="sangStatus1" onclick="">생산대기</button></td>
<!--                                    상태값이 생산대기일때만 class에 btnType4랑 statusStandby 추가 나머지 상태에서는 btnType3이랑 statusBtn 만 반영-->

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
                                    <td class="ltTbody"><button type="button" class="btnType3 statusBtn" name="sangStatus1" onclick="">생산중</button></td>

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
                                    <td class="ltTbody"><button type="button" class="btnType3 statusBtn" name="sangStatus1" onclick="">생산완료</button></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>