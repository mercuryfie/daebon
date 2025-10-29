<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/productionList_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                생산목록
            </p>
        </div>

        <div class="areaBox area_boxd2s">
            <div class="area2 flexType3 production_boxa6m">
                <div class="left flexType2">
<!--                    <select name="" id="" class="searchFilter ">-->
<!--                        <option value="">작업상태</option>-->
<!--                        <option value="">대기중</option>-->
<!--                        <option value="">작업중</option>-->
<!--                        <option value="">완료</option>-->
<!--                    </select>-->
                    <select name="" id="" class="searchFilter">
                        <option value="">제품명</option>
                        <option value="">작업번호</option>
                    </select>
                    <input type="search" name="" id="" class="searchArea" placeholder="1324-1234">
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
                        <tr>
                            <td class="ltThead productNo checkCol"></td>
                            <td class="ltThead">날짜</td>
                            <td class="ltThead">제품명</td>
                            <td class="ltThead">제품코드</td>
                            <td class="ltThead">수량</td>
                            <td class="ltThead">공정 수</td>

                            <td class="ltThead">현재공정위치</td>
                            <td class="ltThead">생산현황</td>
                            <td class="ltThead">출력</td>
                        </tr>
                        </thead>
                        <tbody name="clist" id="clist">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('/web/include/pop_UploadXlx_View'); ?>
<?= $this->include('/web/include/pop_OrderForm_View'); ?>
<?= $this->endSection() ?>