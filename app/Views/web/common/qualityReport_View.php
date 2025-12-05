<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/qualityReport_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright">
    <div class="goods_boxx7z">
        <div class="titleBox">
            <p class="headTitle">
                품질보고서
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
            <div class="area2 production_boxa6m">
                <div class="left flexType2">
                    <input type="search" name="" id="" class="searchArea" placeholder="지시코드 또는 제품명 검색">
                    <button type="button" class="btnType1">검색</button>
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
                            <td class="ltThead">완료날짜</td>
                            <td class="ltThead">제품BOM명</td>
                            <td class="ltThead">지시코드</td>
                            <td class="ltThead">수량</td>
                            <td class="ltThead">공정 수</td>

                            <td class="ltThead">품질보고서</td>
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

<?= $this->endSection() ?>