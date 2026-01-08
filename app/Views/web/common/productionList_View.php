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
<!--                    <p class="title">기간</p>-->
                    <a href="javascript:;" class="period">오늘</a>
                    <a href="javascript:;" class="period">1주일</a>
                    <a href="javascript:;" class="period">1개월</a>
                    <a href="javascript:;" class="period">3개월</a>
                </div>
                <div class="date_boxtc6 flexType2">
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker" placeholder="2025/01/01" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                    <p class="wave">~</p>
                    <label for="date2" class="dateLabel2">
                        <input type="text" id="e_date" name="date2" class="inputType160 datepicker" placeholder="2025/12/31" >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-2"></i>
                    </label>
                </div>
            </div>
            <div class="area2 flexType3 production_boxa6m">
                <div class="left flexType2">
<!--                    <select name="" id="" class="searchFilter ">-->
<!--                        <option value="">작업상태</option>-->
<!--                        <option value="">대기중</option>-->
<!--                        <option value="">작업중</option>-->
<!--                        <option value="">완료</option>-->
<!--                    </select>-->
                    <input type="search" name="" id="" class="searchArea" placeholder="지시코드 혹은 제품명 검색">
                    <button type="button" class="btnType1">검색</button>
                </div>
                <div class="right flexType2 filter_boxa6m">
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>대기중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" checked>작업중
                    </label>
                    <label for="filter" class="statusLabel flexType2">
                        <input type="checkbox" name="filter" id="" class="status" >완료
                    </label>
                </div>
            </div>
        </div>
        <div class="areaBox area_boxmxh ">
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">작업목록</p>
                    <p class="count">10</p>
                    <p class="unit">건</p>
                </div>
                <div class="right">
                    <button type="button" class="btnType1">엑셀다운로드</button>
                </div>
            </div>
            <div class="area4 goods_boxa1b flexType2">
                <div class="produce_boxfxp">
                    <table class="orderInfoTable orderInfoTable1 pro_tablefz7c">
                        <thead>
                        <tr name="view_detail" data-code="${el.gicode}">
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead">지시날짜</td>
                            <td class="ltThead">지시코드</td>
                            <td class="ltThead">제품BOM명</td>
                            <td class="ltThead">현재공정위치</td>

                            <td class="ltThead">생산수량</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">생산자</td>
                            <td class="ltThead">생산현황</td>
                            <td class="ltThead">출력</td>
                        </tr>
                        </thead>
                        <tbody name="clist" id="clist">

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
<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>