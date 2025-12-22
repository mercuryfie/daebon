<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>
<script src="<?=ASSETS_URL?>/js/common/categoryList.js?rnd=<?=rand();?>"> </script>
<script src="<?=ASSETS_URL?>/js/common/categoryList_Do.js?rnd=<?=rand();?>"> </script>

    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    카테고리 관리
                </p>
            </div>
            <div class="areaBox area_boxd2s">

                <div class="area2 flexType3">
                        <div class="left flexType2">
                            <select name="" id="" class="searchFilter">
                                <option value="">선택하세요.</option>
                                <option value="1">상품분류</option>
                                <option value="2">원자재</option>
                            </select>
                            <input type="search" name="mkey" id="mkey" class="searchArea" placeholder="재료명을 입력하세요.">
                            <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                        </div>
                        <div class="right">
                            <button type="button" class="btnType3 refBtn mr10" id="btn_reload" name="btn_reload">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </button>
                            <button type="button" class="btnType1 mr10" id="" name="" onclick="pop_addCat2();">원자재 추가</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="areaBox area_boxmxh ">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                        <p class="title">카테고리</p>
                        <p class="count" id="tcnt" name="tcnt"></p>
                        <p class="unit">건</p>
                    </div>
<!--                    <div class="right">-->
<!--                        <button type="button" class="btnType1 mr10">엑셀업로드</button>-->
<!--                        <button type="button" class="btnType1">엑셀다운로드</button>-->
<!--                    </div>-->
                </div>
                <div class="area4 cat_boxa1b flexType2">
                    <div class="cat_boxfxp">
                        <table class="catTable ">
                            <thead>
                            <tr>
                                <td class="keyCol keyCol1">분류코드</td>
                                <td class="keyCol keyCol2">이름</td>
                                <td class="keyCol keyCol1">분류코드</td>
                                <td class="keyCol keyCol2">이름</td>
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


<?= $this->include('/web/include/pop_AddCategory2_View'); ?>
<?= $this->include('/web/include/pop_AddCategory3_View'); ?>
<?php //= $this->include('/web/include/pop_AddMaterial_View',$main); ?>
<?= $this->endSection() ?>
<?php //= $this->include('/web/include/pop_AddMaterial_View',$meta); ?>
