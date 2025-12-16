<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/packingList_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright">
    <div class="goods_boxfv6 packing_boxfxp">
        <div class="titleBox">
            <p class="headTitle">
                포장목록
            </p>
        </div>
        <div class="areaBox area_boxd2s">
            <div class="area1 flexType2">
                <div class="left flexType2">
<!--                    <p class="title">기간</p>-->
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
                </div> 
                <div class="date_boxtc6 flexType2">
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" placeholder="2025/01/01" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                    <p class="wave">~</p>
                    <label for="date2" class="dateLabel2">
                        <input type="text" id="e_date" name="date2" class="inputType160 datepicker" placeholder="2025/12/31" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                    </label>
                </div>
            </div>
            <div class="area2 flexType3">
                <div class="left flexType2">
<!--                        <p class="title">검색조건</p>-->
<!--                        <select name="" id="" class="searchFilter ">-->
<!--                            <option value="">전체</option>-->
<!--                            <option value="">상품준비중</option>-->
<!--                            <option value="">배송중</option>-->
<!--                            <option value="">배송완료</option>-->
<!--                        </select>-->
                    <select name="" id="" class="searchFilter">
                        <option value="">포장번호</option>
                        <option value="">상품번호</option>
                        <option value="">구매자명</option>
                        <option value="">구매자ID</option>
                    </select>
                    <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
                    <button type="button" class="btnType1">검색</button>
                </div>

                <div class="right flexType2 filter_boxa6m">
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>상품준비중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>포장중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >완료
                    </label>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">발송완료 / 발송예정 : </p>
                    <p class="count">30 / 80</p>
                </div>
                <div class="right">
<!--                        <button type="button" class="btnType1">엑셀다운로드</button>-->
                </div>
            </div>
            <div class="area4 products_boxa1b flexType2">
                <div class="products_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead">포장번호</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead  ">판매자 ID</td>
                            <td class="ltThead">수령인</td>

                            <td class="ltThead">수량</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">작업등록일</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="ltTbody">
                                <input type="checkbox" name="" id="">
                            </td>
                            <td class="ltTbody">13241234</td>
                            <td class="ltTbody " onclick="">
                                <a href="javascript:;" onclick="go_packingStatus();">허브차 혼합차 200g</a>
                            </td>
                            <td class="ltTbody">-</td>
                            <td class="ltTbody">-</td>


                            <td class="ltTbody">10</td>
                            <td class="ltTbody">상품준비중</td>
                            <td class="ltTbody">2025.01.01</td>
<!--                                <td class="ltTbody orderProduct">2025.01.02-->
<!--                                </td>-->
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
            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">
                <p class="more mr10">더보기</p>
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>