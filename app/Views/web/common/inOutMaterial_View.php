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
                입출고관리 (원재료)
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
                            <option value="">전체기간</option>
                            <option value="">3개월</option>
                            <option value="">6개월</option>
                            <option value="">1년</option>
                        </select>
                        <input type="search" placeholder="원재료 또는 부자재 검색" class="inputSearch" >
                        <button type="button" class="btnType1">검색</button>

                    </div>
                    <div class="right3">
                        <button type="button" class="btnType1">로그표시</button>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                        <button type="button" class="btnType2 mr10" id="ipgoBtn" onclick="pop_ipgoView();" >입고하기</button>
                        <button type="button" class="btnType2" id="chulgoBtn" onclick="pop_chulgoView();">출고하기</button>

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
                            <td class="ltThead">입고바코드</td>
                            <td class="ltThead">입출고 메모</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="ltTbody">
                                <input type="checkbox" name="" id="">
                            </td>
                            <td class="ltTbody">원재료</td>
                            <td class="ltTbody">허브(농산물)</td>
                            <td class="ltTbody">45.000</td>
                            <td class="ltTbody">45.000</td>

                            <td class="ltTbody">45.000</td>
                            <td class="ltTbody">2025.01.01</td>
                            <td class="ltTbody">
                                <button type="button" class="btnType3 " onclick="pop_barcodeWindow();">123412341234</button>
<!--                                <a href="javascript:;" class="barcodeNo" onclick="pop_barcodeWindow();">123412341324</a>-->
                            </td>
                            <td class="ltTbody"><i class="fa-solid fa-pen memo"></i>주문번호 124 주문건 출고</td>


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