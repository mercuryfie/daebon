<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productsList_Do.js?rnd=<?=rand();?>"> </script>


<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>
<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                제품목록
            </p>
        </div>
        <div class="areaBox area_boxd2s">
            <div class="area1 flexType3">
                <div class="left flexType2 dateBox">
                    <p class="title">기간</p>
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>상품준비중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>포장중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >포장완료
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >발송완료
                    </label>
                </div>
            </div>
            <div class="area2 flexType3">
                <div class="left flexType2">
<!--                    <p class="title">검색조건</p>-->
<!--                    <select name="" id="" class="searchFilter ">-->
<!--                        <option value="">전체</option>-->
<!--                        <option value="">상품준비중</option>-->
<!--                        <option value="">배송중</option>-->
<!--                        <option value="">배송완료</option>-->
<!--                    </select>-->
                    <select name="" id="" class="searchFilter">
                        <option value="">주문번호</option>
                        <option value="">상품번호</option>
                        <option value="">구매자명</option>
                        <option value="">구매자ID</option>
                    </select>
                    <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
                    <button type="button" class="btnType1">검색</button>
                </div>
                <div class="right">
                    <button type="button" class="btnType2 " onclick="go_productsReg();">제품등록</button>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">제품목록</p>
                    <p class="count" id="tcnt" name="tcnt">0</p>
                    <p class="unit">건</p>
                </div>
                <div class="right">
                    <button type="button" class="btnType1 mr10">엑셀업로드</button>
                    <button type="button" class="btnType1">엑셀다운로드</button>
                </div>
            </div>
            <div class="area4 products_boxa1b flexType2">
                <div class="products_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 ">
                        <thead>
                        <tr>
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead">제품번호</td>
                            <td class="ltThead">제품명</td>
                            <td class="ltThead">기본수량</td>
                            <td class="ltThead">적정재고량</td>
                            <td class="ltThead">총재고량</td>
                            <td class="ltThead">총입고량</td>
                            <td class="ltThead">총출고량</td>
                            <td class="ltThead">평균사용량</td>
                            <td class="ltThead">작업 중 수량</td>
                            <td class="ltThead orderProduct">간편작업지시</td>
                        </tr>
                        </thead>
                        <tbody id="clist" name="clist">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>