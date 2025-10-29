<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<script src="<?=ASSETS_URL?>/js/common/materialList.js?rnd=<?=rand();?>"> </script>
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
                        <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="원재료명을 검색하세요.">
                        <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType3 refBtn mr10" id="btn_reload" name="btn_reload">
                            <i class="fa-solid fa-arrow-rotate-right"></i>
                        </button>
                        <button type="button" class="btnType2 " id="adddata" name="adddata" onclick="add_Material();">자재등록</button>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                        <p class="title">상품목록</p>
                        <p class="count" id="tcnt" name="tcnt"></p>
                        <p class="unit">건</p>
                    </div>
                    <div class="right">
                        <button type="button" class="btnType1 mr10">엑셀업로드</button>
                        <button type="button" class="btnType1">엑셀다운로드</button>
                    </div>
                </div>
                <div class="area4 atom_boxa1b flexType2">
                    <div class="order_boxfxp">
                        <table class="orderInfoTable materialListTable ">
                            <thead>
                            <tr>
                                <td class="ltThead">종류</td>
                                <td class="ltThead">이름</td>
                                <td class="ltThead  ">단위</td>
                                <td class="ltThead">재고</td>
                                <td class="ltThead">1개월 평균사용량</td>
                                <td class="ltThead">
                                    -
                                </td>
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
<?php //= $this->include('/web/include/pop_AddMaterial_View',$meta); ?>
