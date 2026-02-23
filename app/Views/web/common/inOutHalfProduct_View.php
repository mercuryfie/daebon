<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/inoutHalfproduct_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox">
            <p class="headTitle">
                입출고관리 (반제품)
            </p>
        </div>
        <div class="areaBox area_boxmxh inout_boxq0b min80vh">
            <div class="goods_boxkfg mt10 inout_boxq0a">
                <div class="right flexType3">
                    <div class="left3 flexType1">
<!--                        <select name="" id="" class="btnType1 mr10">-->
<!--                            <option value="">기간</option>-->
<!--                            <option value="">3개월</option>-->
<!--                            <option value="">6개월</option>-->
<!--                            <option value="">1년</option>-->
<!--                            <option value="">전체</option>-->
<!--                        </select>-->
                        <input type="search" placeholder="반제품코드 또는 공정명을 검색" class="inputSearch" id="txt_search">
                        <button type="button" class="btnType1 mr20" id="btn_search">검색</button>
                        <div class="left2 flexType2">
                            <p class="title">전체</p>
                            <p class="count" id="tcnt">0</p>
                            <p class="unit">건</p>
                        </div>

                    </div>
                    <div class="right3">
<!--                        <button type="button" class="btnType1">로그표시</button>-->
<!--                        <button type="button" class="btnType1 mr20">엑셀다운로드</button>-->
<!--                        <button type="button" class="btnType2 mr20" id="chulgoBtn" onclick="pop_chulgoView();">출고하기</button>-->
                    </div>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="common_tbl_wrap" id="inout_half_wrap">
                    <table class="common_tbl ">
                        <thead>
                        <tr>
                            <th class="ltThead">제품명</th>
                            <th class="ltThead">반제품코드</th>
                            <th class="ltThead">BOM코드</th>
                            <th class="ltThead">공정이름</th>
                            <th class="ltThead">입고량</th>
                            <th class="ltThead">출고량</th>
                            <th class="ltThead">출입고일자</th>
                            <th class="ltThead">라벨</th>
                        </tr>
                        </thead>
                        <tbody id="clist">
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


<?= $this->include('/web/include/pop_Ipgo_View'); ?>
<?= $this->include('/web/include/pop_Chulgo_View'); ?>
<?= $this->endSection() ?>