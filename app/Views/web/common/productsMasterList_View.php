<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/productsMasterList_Do.js?rnd=<?=rand();?>"> </script>

    <script>
    </script>
    <section class="merright">
        <div class="goods_boxfv6 products_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    제품BOM목록
                </p>
            </div>
            <div class="areaBox area_boxd2s">
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <input type="search" name="txt_search" id="txt_search" class="searchArea" placeholder="제품코드 혹은 제품명 검색">
                        <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2 " onclick="go_productsMasterReg();">제품 BOM등록</button>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxmxh areaHidden ">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                        <p class="title">총</p>
                        <p class="count" id="tcnt" name="tcnt">0</p>
                        <p class="unit">건</p>
                    </div>
                    <div class="right flexType2">
                        <!--                    <button type="button" class="btnType2 mr20" onclick="go_productsMasterReg();">제품 BOM등록</button>-->
                    </div>
                </div>
                <div class="area4 products_boxa1b flexType2 ">
                    <div class="products_boxfxp  ">
                        <table class="orderInfoTable orderInfoTable1 prodMas_tabledo1 ">
                            <thead>
                            <tr>
                                <td class="ltThead">BOM코드</td>
                                <td class="ltThead">제품명</td>
                                <td class="ltThead">지시수량</td>
                                <td class="ltThead">작업 중 수량</td>
                                <td class="ltThead">공정단계수</td>
                                <td class="ltThead ">출력</td>
                                <td class="ltThead">삭제</td>
                            </tr>
                            </thead>
                            <tbody id="clist" name="clist">
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

<?php //= $this->include('/web/include/pop_OrderRoastForm_View'); ?>
<?= $this->endSection() ?>