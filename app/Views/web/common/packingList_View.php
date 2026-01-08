<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/packingList_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="goods_boxfv6 packing_boxfxp">
        <div class="titleBox">
            <p class="headTitle">
                포장목록
            </p>
        </div>
<!--        <div class="areaBox area_boxd2s">-->
<!--            <div class="area1 flexType2">-->
<!--                <div class="left flexType2">-->
<!--                    <a href="javascript:;" class="period">오늘</a>-->
<!--                    <a href="javascript:;" class="period">1주일</a>-->
<!--                    <a href="javascript:;" class="period">1개월</a>-->
<!--                    <a href="javascript:;" class="period">3개월</a>-->
<!--                </div> -->
<!--                <div class="date_boxtc6 flexType2">-->
<!--                    <label for="date1" class="dateLabel1">-->
<!--                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" placeholder="2025/01/01" >-->
<!--                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>-->
<!--                    </label>-->
<!--                    <p class="wave">~</p>-->
<!--                    <label for="date2" class="dateLabel2">-->
<!--                        <input type="text" id="e_date" name="date2" class="inputType160 datepicker" placeholder="2025/12/31" >-->
<!--                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>-->
<!--                    </label>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="area2 flexType3">-->
<!--                <div class="left flexType2">-->
<!--                    <select name="" id="" class="searchFilter">-->
<!--                        <option value="">포장번호</option>-->
<!--                        <option value="">상품번호</option>-->
<!--                        <option value="">구매자명</option>-->
<!--                        <option value="">구매자ID</option>-->
<!--                    </select>-->
<!--                    <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">-->
<!--                    <button type="button" class="btnType1">검색</button>-->
<!--                </div>-->
<!---->
<!--                <div class="right flexType2 filter_boxa6m">-->
<!--                    <label for="filter" class="statusLabel flexType2">-->
<!--                        <input type="checkbox" name="filter" id="" class="status" checked>상품준비중-->
<!--                    </label>-->
<!--                    <label for="filter" class="statusLabel flexType2">-->
<!--                        <input type="checkbox" name="filter" id="" class="status" checked>포장중-->
<!--                    </label>-->
<!--                    <label for="filter" class="statusLabel flexType2">-->
<!--                        <input type="checkbox" name="filter" id="" class="status" >완료-->
<!--                    </label>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">포장완료 / 포장예정 : </p>
                    <p class="count">30 / 80</p>
                </div>
            </div>
            <div class="area4 products_boxa1b flexType2">
                <div class="products_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 pack_table ">
                        <thead>
                        <tr>
                            <td class="ltThead td1">포장번호</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead">수령인</td>
                            <td class="ltThead">수량</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">작업자</td>
                            <td class="ltThead">포장지시일</td>
                            <td class="ltThead">포장완료일</td>
                        </tr>
                        </thead>
                        <tbody id="cList">

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
            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">
                <p class="more mr10">더보기</p>
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>