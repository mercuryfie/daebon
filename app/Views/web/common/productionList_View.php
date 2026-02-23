<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/productionList_Do.js?rnd=<?=rand();?>"> </script>
<?php //print_r($body)?>
<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                생산목록
            </p>
        </div>

        <div class="areaBox area_boxd2s">
            <div class="area area1 flexType2">
                <div class="left flexType2 dateBox">
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
                </div>
                <div class="date_boxtc6 flexType2">
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="s_date" name="s_date" class="inputType160 date1 datepicker" placeholder="2025/01/01" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                    <p class="wave">~</p>
                    <label for="date2" class="dateLabel2">
                        <input type="text" id="e_date" name="e_date" class="inputType160 datepicker" placeholder="2025/12/31" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                    </label>
                </div>
            </div>
            <div class="area2 flexType3 production_boxa6m ">
                <div class="left flexType2">
                    <input type="search" name="skey" id="skey" class="searchArea" placeholder="지시코드 혹은 제품명 검색">
                    <button type="button" class="btnType1" id="btn_search" name="btn_search">검색</button>
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="filter1" class="status" value="0">대기중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="filter2" class="status" value="1">작업중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="filter3" class="status"  value="2">완료
                    </label>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxmxh min70vh">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">총</p>
                    <p class="count" id="tcnt" name="tcnt"></p>
                    <p class="unit">건</p>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="common_tbl_wrap" id="p_wrap">
                    <table class="common_tbl">
                        <thead>
                        <tr name="view_detail" data-code="${el.gicode}">
                            <th class="ltThead">지시날짜</th>
                            <th class="ltThead">지시코드</th>
                            <th class="ltThead">제품BOM명</th>
                            <th class="ltThead">생산수량</th>
                            <th class="ltThead">현재공정위치</th>
                            <th class="ltThead">상태</th>
                            <th class="ltThead">생산자</th>
                            <th class="ltThead">생산현황</th>
                            <th class="ltThead">출력</th>
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