<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/inoutStatus_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox">
            <p class="headTitle">
                입출고관리 (반제품)
            </p>
        </div>
        <div class="areaBox area_boxmxh inout_boxq0b">
            <div class="goods_boxkfg  inout_boxq0a">
                <div class="left ">
                    <div class="left2 flexType2">
                        <p class="title">전체</p>
                        <p class="count">10</p>
                        <p class="unit">건</p>
                    </div>
                </div>
                <div class="right flexType3">
                    <div class="left3 flexType1">
                        <select name="" id="" class="btnType1 mr10">
                            <option value="">기간</option>
                            <option value="">3개월</option>
                            <option value="">6개월</option>
                            <option value="">1년</option>
                            <option value="">전체</option>
                        </select>
                        <input type="search" placeholder="반제품코드 또는 제품명 검색" class="inputSearch" >
                        <button type="button" class="btnType1">검색</button>

                    </div>
                    <div class="right3">
                        <button type="button" class="btnType1">로그표시</button>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol">순번</td>
                            <td class="ltThead">날짜</td>
                            <td class="ltThead">BOM코드</td>
                            <td class="ltThead">반제품코드</td>
                            <td class="ltThead">제품명</td>
                            <td class="ltThead">공정명</td>
                            <td class="ltThead">전체재고</td>

                            <td class="ltThead">입고량</td>
                            <td class="ltThead">출고량</td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">우엉 혼합물</td>
                                <td class="ltTbody">우엉 계량</td>
                                <td class="ltTbody">허브(농산물)</td>
                                <td class="ltTbody">45.000g</td>
                                <td class="ltTbody">-</td>


                            </tr>
                            <tr>
                                <td class="ltTbody">
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="ltTbody">2025.01.01</td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">12341234</td>
                                <td class="ltTbody">우엉 혼합물</td>
                                <td class="ltTbody">우엉 계량</td>
                                <td class="ltTbody">허브(농산물)</td>
                                <td class="ltTbody">-</td>
                                <td class="ltTbody">45.000g</td>


                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>


<?= $this->include('/web/include/pop_Ipgo_View'); ?>
<?= $this->include('/web/include/pop_Chulgo_View'); ?>
<?= $this->endSection() ?>