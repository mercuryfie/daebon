<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<script src="<?=ASSETS_URL?>/js/common/materialList_Do.js?rnd=<?=rand();?>"> </script>

    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    원자재 목록
                </p>
            </div>
            <div class="areaBox area_boxd2s">
                <div class="area2 flexType3">
                    <div class="left flexType2">
                        <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="원재료 또는 부자재 검색">
                        <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType2 " id="adddata" name="adddata" onclick="add_Material();">자재등록</button>
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
<!--                        <button type="button" class="btnType1 mr10">엑셀업로드</button>-->
<!--                        <button type="button" class="btnType1">엑셀다운로드</button>-->
                    </div>
                </div>
                <div class="area4 atom_boxa1b flexType2">
                    <div class="order_boxfxp">
                        <table class="orderInfoTable materialListTable " id="mTable">
                            <thead>
                            <tr>
                                <th class="ltThead" data-col="0">종류</th>
                                <th class="ltThead" data-col="1">원자재코드</th>
                                <th class="ltThead " data-col="2"  ><div class="flexType1"><p class="cname mr10">이름</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
<!--                                <td class="ltThead  ">단위</td>-->
                                <th class="ltThead" data-col="3"><div class="flexType1"><p class="cname mr10">한달평균사용</p><i class="fa-solid fa-angle-down dIcon"></i></div> </th>
                                <th class="ltThead" data-col="4"><div class="flexType1"><p class="cname mr10">적정재고</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                                <th class="ltThead" data-col="5"><div class="flexType1"><p class="cname mr10">현재재고</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                                <th class="ltThead" data-col="6"><div class="flexType1"><p class="cname mr10">재고율</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                                <th class="ltThead" data-col="7">삭제</th>
                            </tr>
                            </thead>
                            <tbody id="mlist" name="mlist">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->include('/web/include/pop_AddMaterial_View',$main); ?>
<?= $this->endSection() ?>

