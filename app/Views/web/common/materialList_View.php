<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<script src="<?=ASSETS_URL?>/js/common/materialList_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">원자재목록</p>
        </div>
        <div class="areaBox area_boxd2s">
            <div class="area2 flexType3">
                <div class="left flexType2">
                    <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="통합 검색">
                    <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                </div>
                <div class="right ">
                    <button type="button" class="btnType2" id="adddata" name="adddata" onclick="add_Material();">자재등록</button>
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
                <div class="right">

                    <select name="mate_filter" id="mate_filter" class="btnType1 mr10">
                        <option value="0">전체</option>
                        <option value="1">원재료</option>
                        <option value="2">부자재</option>
                    </select>
<!--                    <input type="file" id="attachExcel" name="attachExcel" accept=".xlsx,.xls" style="display:none;">-->
                    <button type="button" class="btnType1 mr20" id="excelPop" name="excelPop" onclick="">엑셀업로드</button>
                    <!--                        <button type="button" class="btnType1">엑셀다운로드</button>-->
                </div>
            </div>
            <div class="area4 atom_boxa1b flexType2">
                <div class="order_boxfxp">
                    <table class="orderInfoTable materialListTable " id="mTable">
                        <thead>
                        <tr>
                            <th class="ltThead" data-col="0"><div class="flexType1"><p class="cname mr10">종류</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                            <th class="ltThead" data-col="1"><div class="flexType1"><p class="cname mr10">원자재코드</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                            <th class="ltThead" data-col="2"  ><div class="flexType1"><p class="cname mr10">이름</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                            <th class="ltThead" data-col="4"><div class="flexType1"><p class="cname mr10">적정재고수량</p></div></th>
                            <th class="ltThead" data-col="3"><div class="flexType1"><p class="cname mr10">한달평균사용</p><i class="fa-solid fa-angle-down dIcon"></i></div> </th>
                            <th class="ltThead" data-col="5"><div class="flexType1"><p class="cname mr10">현재재고</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                            <th class="ltThead" data-col="7">삭제</th>
                        </tr>
                        </thead>
                        <tbody id="mlist" name="mlist">
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

<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?= $this->include('/web/include/pop_AddMaterial_View',$body); ?>
<?= $this->endSection() ?>

