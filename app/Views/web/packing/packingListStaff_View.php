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
                    <input type="search" name="incode" id="incode" class="searchArea" autofocus placeholder="바코드를 스캔하십시오">
                </div>
                <div class="right flexType2">
                    <button type="button" class="btn60Type3 " name="searchType" data-val="0">포장전</button>
                    <button type="button" class="btn60Type3 " name="searchType" data-val="1">포장중</button>
                    <button type="button" class="btn60Type3 " name="searchType" data-val="2">송장<br>출력</button>
                    <button type="button" class="btn60Type3 " name="searchType" data-val="3">완료</button>
                    <button type="button" class="btnType60 " id="btn_reload" name="btn_reload">
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

                            <th class="ltThead productNo">상태(현재/전체)</th>
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