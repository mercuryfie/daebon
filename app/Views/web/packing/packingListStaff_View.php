<?= $this->extend("/web/template/layout_staff") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/deliListStaff_Do.js?rnd=<?=rand();?>"> </script>
<!-- calendar ----------------------------  -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>

<script>
</script>

<section class="mainContentStaff ">
    <div class="deli_wrapghj packing_wrapghj">
        <div class="titleBox">
            <p class="headTitle">
                포장목록 staff
            </p>
            <div class="left flexType2">
                <p class="progress mr10">발송완료 / 대기건수 : </p>
                <p class="progress count">30 / 80</p>
            </div>
        </div>
        <div class="areaBox areaBoxStaff">
            <div class="area2 flexType3">
                <div class="left flexType2">
                    <input type="search" name="" id="" class="searchArea" autofocus placeholder="바코드를 스캔하십시오">
                    <button type="button" class="btnType2">검색</button>
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

            <div class="area4  ">
                <div class="deli_box1od flexType1">
                    <table class="deliInfoTable ">
                        <thead>
                        <tr>
                            <!--                            <td class="ltThead productNo checkCol"></td>-->
                            <th class="ltThead productNo">주문일</th>
                            <th class="ltThead productNo">송장번호</th>
                            <th class="ltThead productNo">송장등록일</th>
                            <th class="ltThead productNo">쇼핑몰</th>

                            <th class="ltThead productNo">상품명</th>
                            <th class="ltThead productNo">수량</th>
                            <th class="ltThead productNo">주문자</th>
                            <th class="ltThead productNo">수령인</th>
                            <th class="ltThead productNo">수령인 주소</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr onclick="go_packingStatusStaff();">
                            <!--                            <td class="ltTbody">-->
                            <!--                                <input type="checkbox" name="" id="">-->
                            <!--                            </td>-->
                            <td class="ltTbody">2025.01.01</td>
                            <td class="ltTbody" onclick="">13242134</td>
                            <td class="ltTbody">2025.01.01</td>
                            <td class="ltTbody">amazon</td>

                            <td class="ltTbody">ginger tea</td>
                            <td class="ltTbody">10</td>
                            <td class="ltTbody">john doe</td>
                            <td class="ltTbody">john doe</td>
                            <td class="ltTbody">GA, United States</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>