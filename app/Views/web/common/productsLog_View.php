<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/productsLog_Do.js?rnd=<?=rand();?>"></script>

<section class="merright">
    <div class="p_log_wrap">
        <input type="hidden" id="gscode" name="gscode" value="<?=$body['gscode'];?>" />
        <div class="titleBox">
            <p class="headTitle">
                제품 입출고 로그
            </p>
        </div>
        <div class="area area1 flexType3">
<!--            <div class="left">-->
<!--                <input type="search" name="txt_search" id="txt_search" class="searchArea" placeholder="제품코드 혹은 지시서코드 검색">-->
<!--                <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>-->
<!--            </div>-->
<!--            <button type="button" class="btnType1" id="excel_down" name="excel_down">엑셀다운로드</button>-->
            <button type="button" class="btnType1" id="btn_back" name="btn_back">목록보기</button>

        </div>
        <div class="area area2">
            <div class="area_mini area_mini1 flexType3">
                <table class="m_log_info_tbl">
                    <tr>
                        <td>제품코드: </td>
                        <td><p class="data" id="vw_gscode"></p></td>
                    </tr>
                    <tr>
                        <td>제품명: </td>
                        <td><p class="data" id="gsname"></p></td>
                    </tr>
                    <tr>
                        <td>카테고리: </td>
                        <td><p class="data" id="category"></p></td>
                    </tr>
                </table>
            </div>
            <div class="area_mini area_mini2 flexType2 ">
                <div class="p_log_tbl_wrap">
                    <table class="p_log_tbl" id="pTable">
                        <thead>
                        <tr>
                            <th class="ltThead" data-col="0">지시서코드</th>
                            <th class="ltThead" data-col="3">수량</th>
                            <th class="ltThead" data-col="3">무게(g)</th>
                            <th class="ltThead" data-col="3"><div class="flexType1"><p class="cname mr10">입/출고</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                            <th class="ltThead" data-col="4"><div class="flexType1"><p class="cname mr10">날짜</p><i class="fa-solid fa-angle-down dIcon"></i></div></th>
                        </tr>
                        </thead>
                        <tbody id="pList" name="pList">
                            <tr>
                                <td>12341234</td>
                                <td>none</td>
                                <td>1004</td>
                                <td>입고</td>
                                <td>2026-01-01</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>