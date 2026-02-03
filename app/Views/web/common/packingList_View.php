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
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
<!--                    <p class="title">포장완료 / 포장예정 : </p>-->
<!--                    <p class="count">30 / 80</p>-->
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
                            <td class="ltThead">상태(현재/전체)</td>
                            <td class="ltThead">작업자</td>
                            <td class="ltThead">포장지시일</td>
                            <td class="ltThead">포장완료일</td>
                        </tr>
                        </thead>
                        <tbody id="cList">

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

<?= $this->endSection() ?>