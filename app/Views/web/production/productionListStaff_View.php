<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/productionListStaff_Do.js?rnd=<?=rand();?>"> </script>

<section class="mainContentStaff flexType2">
    <div class="goods_boxfv6">
        <div class="listTitleBox">
            <p class="headTitle">
                생산목록 staff
            </p>
        </div>
        <div class="areaBoxStaff area_boxmxh ">
            <div class="area area1 ">
                <input type="search"
                       class="inputType520 ml20"
                       placeholder="바코드를 스캔하십시오" name="incode" id="incode" autofocus>
            </div>
            <div class="goods_boxkfg flexType3 productionList_boxkkq">
                <div class="left flexType2">
                    <p class="title">작업목록</p>
                    <p class="count" id="tcnt" name="tcnt" data-val="0"></p>
                    <p class="unit">건</p>
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <button type="button" class="btn60Type3 mr10" name="searchType" data-val="0">대기중</button>
                    <button type="button" class="btn60Type3 mr10" name="searchType" data-val="1">진행중</button>
                    <button type="button" class="btn60Type3 mr10" name="searchType" data-val="2">완료</button>
                    <button type="button" class="btnType60 " id="btn_reload" name="btn_reload">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 pro_tablefz7c">
                        <thead>
                        <tr>
                            <th class="ltThead">날짜</th>
                            <th class="ltThead">지시서코드</th>
                            <th class="ltThead">제품명</th>
                            <th class="ltThead">공정명</th>
                            <th class="ltThead">수량</th>

                            <th class="ltThead">상태</th>
                            <th class="ltThead">작업자</th>
                        </tr>
                        </thead>
                        <tbody name="clist" id="clist">

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

<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>