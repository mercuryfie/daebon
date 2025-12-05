<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/goodsList_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                상품목록
            </p>
        </div>
        <div class="areaBox area_boxd2s">
            <div class="area2 flexType3">
                <div class="left flexType2">
                    <input type="search" name="txt_search" id="txt_search" class="searchArea" placeholder="상품코드 혹은 상품명 검색">
                    <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                </div>
                <div class="right">
                    <button type="button" class="btnType2 " onclick="go_goodsReg();">상품등록</button>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">상품목록</p>
                    <p class="count" id="tcnt" name="tcnt">0</p>
                    <p class="unit">건</p>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="order_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 goods_tablexo1 ">
                        <thead>
                        <tr>
                            <th class="ltThead productNo checkCol th1">-</th>
<!--                            <th class="ltThead th2">상세</th>-->
                            <td class="ltThead">상품코드</td>
                            <td class="ltThead">상품명</td>
                            <td class="ltThead">카테고리</td>
                            <td class="ltThead ">중량</td>
                            <td class="ltThead">가격</td>
                            <td class="ltThead">매칭수</td>
                            <td class="ltThead">구성품</td>
                            <td class="ltThead">등록일</td>
                        </tr>
                        </thead>
                        <tbody id="tList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->include('/web/include/pop_GoodsDetail_View'); ?>
<?= $this->endSection() ?>