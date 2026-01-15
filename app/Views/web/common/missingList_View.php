<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/linkMalls_Do.js?rnd=--><?php //=rand();?><!--"> </script>-->

<section class="merright">
    <div class="merright1-0 link_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                누락목록 - 쿠팡
            </p>
        </div>
        <div class="areaBox pb100">
            <div class="area3 mb10">
<!--                <button type="button" class="btnType1 mr10" id="btn_showlog">로그보기</button>-->
<!--                <button type="button" class="btnType2" id="btn_mall">주문수집</button>-->
            </div>
            <div class="area4">
                <table class="linkMallsTable ">
                    <thead>
                        <tr>
                            <td class="ltThead ">주문코드</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead">개수</td>
                            <td class="ltThead">누락이유</td>
                            <td class="ltThead">주문일자</td>
                        </tr>
                    </thead>
                    <tbody id="tList">
                        <tr>
                            <td class="ltThead ">주문코드</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead">개수</td>
                            <td class="ltThead">누락이유</td>
                            <td class="ltThead">주문일자</td>
                        </tr>
                        <tr>
                            <td class="ltThead ">주문코드</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead">개수</td>
                            <td class="ltThead">누락이유</td>
                            <td class="ltThead">주문일자</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>