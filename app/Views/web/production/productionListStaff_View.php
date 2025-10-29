<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>


<script src="<?=URL_COMMON_ASSETS?>/productionListStaff_Do.js?rnd=<?=rand();?>"> </script>
    <!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="mainContentStaff">
    <div class="goods_boxfv6">
        <div class="titleBox">
            <p class="headTitle">
                생산목록 staff
            </p>
        </div>
        <div class="areaBoxStaff area_boxmxh ">
            <div class="titleBox area area1">
                <input type="search"
                       class="inputType520 ml20"
                       placeholder="바코드를 스캔하십시오" name="" id="" autofocus>
            </div>
            <div class="goods_boxkfg flexType3">
                <div class="left flexType2">
                    <p class="title">작업목록</p>
                    <p class="count">10</p>
                    <p class="unit">건</p>
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

                    <button type="button" class="btnType60 mr10">
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
                            <th class="ltThead">제품명</th>
                            <th class="ltThead">제품코드</th>
                            <th class="ltThead">수량</th>

                            <th class="ltThead">공정 수</th>
                            <th class="ltThead">현재공정위치</th>
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