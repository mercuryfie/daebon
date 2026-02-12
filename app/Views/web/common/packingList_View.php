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
        <div class="areaBox area_boxmxh min80vh">
            <div class="area4 products_boxa1b flexType2">
                <div class="common_tbl_wrap mt20 ">
                    <table class="common_tbl">
                        <thead>
                        <tr>
                            <th class="ltThead td1">포장번호</th>
                            <th class="ltThead">상품명</th>
                            <th class="ltThead">수령인</th>
                            <th class="ltThead">수량</th>
                            <th class="ltThead">상태(현재/전체)</th>
                            <th class="ltThead">작업자</th>
                            <th class="ltThead">포장지시일</th>
                            <th class="ltThead">포장완료일</th>
                        </tr>
                        </thead>
                        <tbody id="cList">

                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">-->
<!--                <p class="more mr10">더보기</p>-->
<!--                <i class="fa-solid fa-angle-down"></i>-->
<!--            </div>-->
        </div>
    </div>

</section>

<?= $this->endSection() ?>