<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/inoutStatus_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                입출고관리 / 입출고관리
            </p>
        </div>
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3 inout_boxq0a">
                <div class="left ">
                    <div class="left2 flexType2">
                        <p class="title">원자재목록</p>
                        <p class="count">10</p>
                        <p class="unit">건</p>
                    </div>
                    <div class="right2 flexType2">
<!--                            <a href="#" class="btnType1">전체</a>-->
<!--                            <a href="#" class="btnType1">원재료</a>-->
<!--                            <a href="#" class="btnType1">부자재</a>-->
                    </div>
                </div>
                <div class="right flexType5">
                    <div class="left3">
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                    <div class="right3">
                        <button type="button" class="btnType2" id="ipgoBtn">입고하기</button>
                        <button type="button" class="btnType2" id="chulgoBtn">출고하기</button>

                    </div>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol">순번</td>
                            <td class="ltThead">구분</td>
                            <td class="ltThead">이름</td>
                            <td class="ltThead">전체재고</td>
                            <td class="ltThead">입고량</td>

                            <td class="ltThead">출고량</td>
                            <td class="ltThead">날짜</td>
                            <td class="ltThead">-</td>
                            <td class="ltThead">-</td>
                            <td class="ltThead">-</td>
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
            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">
                <p class="more mr10">더보기</p>
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </div>
    </div>

</section>

<?= $this->include('/web/include/pop_Ipgo_View'); ?>
<?= $this->include('/web/include/pop_Chulgo_View'); ?>
<?= $this->endSection() ?>