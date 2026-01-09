<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<!--<link rel="stylesheet" href="/assets/web/css/style_staff.css">-->
<script src="<?=URL_COMMON_ASSETS?>/packingListStaff_Do.js?rnd=<?=rand();?>"> </script>


<section class="mainContentStaff ">
    <div class=" packing_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                포장목록 staff
            </p>
<!--            <div class="left flexType2">-->
<!--                <p class="progress mr10">발송완료 / 대기건수 : </p>-->
<!--                <p class="progress count">30 / 80</p>-->
<!--            </div>-->
        </div>
        <div class="pack_boxdw1">
            <div class="area area2 flexType3">
                <div class="left flexType2">
                    <input type="search" name="" id="" class="searchArea" autofocus placeholder="바코드를 스캔하십시오">
                </div>
                <div class="right flexType2">
                    <div class=" flexType2 filter_boxa6m">
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" checked>
                            <p class="text">상품준비중</p>
                        </label>
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" checked>포장중
                        </label>
                        <label for="filter" class="statusLabel flexType2">
                            <input type="checkbox" name="filter" id="" class="status" >완료
                        </label>
                    </div>
                    <button type="button" class="btnType60 mr10">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>

                </div>
            </div>

            <div class="area area4  ">
                <div class="deli_box1od flexType1">
                    <table class="pack_list_table ">
                        <thead>
                        <tr>
                            <th class="ltThead productNo">포장번호</th>
                            <th class="ltThead productNo">상품명</th>
                            <th class="ltThead productNo">수령인</th>
                            <th class="ltThead productNo">수량</th>

                            <th class="ltThead productNo">상태</th>
                            <th class="ltThead productNo">작업자</th>
                            <th class="ltThead productNo">포장지시일</th>
                            <th class="ltThead productNo">포장완료일</th>
                        </tr>
                        </thead>
                        <tbody id="cList">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>