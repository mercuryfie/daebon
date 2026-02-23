<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/inoutMaterial_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="goods_boxfv6 ">
        <div class="titleBox">
            <p class="headTitle">
                입출고관리 (원재료)
            </p>
        </div>
        <div class="areaBox area_boxmxh inout_boxq0b min80vh">
            <div class="goods_boxkfg mt10 inout_boxq0a">
<!--                <div class="left ">-->
<!--                    <div class="left2 flexType2">-->
<!--                        <p class="title">전체</p>-->
<!--                        <p class="count">10</p>-->
<!--                        <p class="unit">건</p>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="right flexType3">
                    <div class="left3 flexType1">
<!--                        <select name="" id="" class="btnType1 mr10">-->
<!--                            <option value="">전체기간</option>-->
<!--                            <option value="">3개월</option>-->
<!--                            <option value="">6개월</option>-->
<!--                            <option value="">1년</option>-->
<!--                        </select>-->
                        <input type="search" placeholder="재료명 또는 재료코드 입력" class="inputSearch" id="txt_mtinfo">
<!--                        <button type="button" class="btnType1 mr20">검색</button>-->
                        <div class="left2 flexType2">
                            <p class="title">전체</p>
                            <p class="count" id="tcnt"></p>
                            <p class="unit">건</p>
                        </div>

                    </div>
                    <div class="right3">
<!--                        <button type="button" class="btnType1">엑셀다운로드</button>-->
                        <button type="button" class="btnType2 mr10" id="bnt_input">입고하기</button>
                        <button type="button" class="btnType2 mr20" id="btn_output">출고하기</button>

                    </div>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2 ">
                <div class="common_tbl_wrap" id="inout_m_wrap">
                    <table class="common_tbl">
                        <thead>
                        <tr>
                            <th class="ltThead">구분</th>
                            <th class="ltThead">이름</th>
                            <th class="ltThead">전체재고</th>
                            <th class="ltThead">최종일자</th>
                            <th class="ltThead">입고바코드</th>
                            <th class="ltThead">로그</th>
                        </tr>
                        </thead>
                        <tbody id="tList">

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