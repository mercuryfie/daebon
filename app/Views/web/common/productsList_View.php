<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <!-- js ----------------------------  -->
    <script src="<?=URL_COMMON_ASSETS?>/productsList_Do.js?rnd=<?=rand();?>"> </script>

    <section class="merright">
        <div class="goods_boxfv6 products_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    제품목록
                </p>
            </div>
            <div class="areaBox area_boxd2s">
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <input type="search" name="txt_search" id="txt_search" class="searchArea" placeholder="제품코드 혹은 제품명 검색">
                        <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2 " onclick="add_Products();">제품등록</button>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxmxh areaHidden  ">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                        <p class="title">총</p>
                        <p class="count" id="tcnt" name="tcnt">0</p>
                        <p class="unit">건</p>
                    </div>
                    <div class="flexType2">
                        <div class="right flexType2">
                            <button type="button" class="btnType1 mr10" id="excelPop" name="excelPop">엑셀업로드</button>
                        </div>
                        <div class="right flexType2 mr20">
                            <button type="button" class="btnType1" id="excel_down" name="excel_down">엑셀다운로드</button>
                        </div>
                    </div>
                </div>
                <div class="area4 products_boxa1b flexType2 ">
                    <div class="products_boxfxp  ">
                        <table class="orderInfoTable orderInfoTable1 prodDef_tablejf2" id="pTable">
                            <thead>
                            <tr>
                                <td class="ltThead" data-col="0"><div class="flexType1"><p class="cname mr10">제품코드</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="1"><div class="flexType1"><p class="cname mr10">제품명</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="2"><div class="flexType1"><p class="cname mr10">구분</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="3"><div class="flexType1"><p class="cname mr10">적정재고수량</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="4">단위용량</td>

                                <td class="ltThead" data-col="5"><div class="flexType1"><p class="cname mr10">총재고량</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="6"><div class="flexType1"><p class="cname mr10">평균사용량</p><i class="fa-solid fa-angle-down dIcon"></i></div></td>
                                <td class="ltThead" data-col="7">BOM</td>
                                <td class="ltThead orderProduct">간편작업지시</td>
                                <td class="ltThead" data-col="8">출력</td>
                                <td class="ltThead" data-col="8">삭제</td>
                            </tr>
                            </thead>
                            <tbody id="clist" name="clist">
                            </tbody>
                        </table>
                    </div>
                </div>
<!--                <div class="area lastArea flexType1" id="cpage" name="cpage" data-page="1">-->
<!--                    <p class="more mr10">더보기</p>-->
<!--                    <i class="fa-solid fa-angle-down"></i>-->
<!--                </div>-->
            </div>
        </div>

    </section>

<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?= $this->include('/web/include/pop_AddProducts_View'); ?>
<?= $this->endSection() ?>