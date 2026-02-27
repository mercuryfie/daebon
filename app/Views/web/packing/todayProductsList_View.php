<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<!--<link rel="stylesheet" href="/assets/web/css/style_staff.css">-->
<script src="<?=URL_COMMON_ASSETS?>/todayProductsList_Do.js?rnd=<?=rand();?>"> </script>

<section class="mainContentStaff ">
    <div class=" packing_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                오늘 제품
            </p>
<!--            <div class="left flexType2">-->
<!--                <p class="progress mr10">발송완료 / 대기건수 : </p>-->
<!--                <p class="progress count">30 / 80</p>-->
<!--            </div>-->
        </div>
        <div class="pack_boxdw1">
            <div class="area area2 flexType3">
                <div class="left flexType2">
<!--                    <input type="search" name="incode" id="incode" class="searchArea" autofocus placeholder="바코드를 스캔하십시오">-->
                </div>
                <div class="right flexType2">
                    <button type="button" class="btn60Type3 " name="searchType" data-val="0" onclick="go_packingList();">포장<br>목록</button>
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
                            <th class="ltThead productNo">제품명</th>
                            <th class="ltThead productNo">수량</th>
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