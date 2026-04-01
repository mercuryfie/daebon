<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/linkMalls_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="merright1-0 link_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                쇼핑몰연동
            </p>
        </div>
        <div class="areaBox pb100 min80vh">
            <div class="area3 mb10 flexType2">
                <div class="date_boxtc6 flexType2">
                    <p class="ttl "> 동기화일자 : </p>
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="s_date" name="date1" class="inputType160 date1 datepicker"  >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                    <p class="dd">~</p>
                    <label for="date1" class="dateLabel1">
                        <input type="text" id="e_date" name="date2" class="inputType160 date1 datepicker"  >
                        <i class="fa-regular fa-calendar calicon" id="calicon1-1"></i>
                    </label>
                </div>
<!--                <button type="button" class="btnType1 mr10" id="btn_showlog">로그보기</button>-->
<!--                <button type="button" class="btnType2" id="btn_mall">주문수집</button>-->
            </div>
            <div class="area4">
                <table class="linkMallsTable ml20">
                    <thead>
                        <tr>
                            <td class="ltThead">쇼핑몰명</td>
                            <td class="ltThead">아이디</td>
                            <td class="ltThead">연동방법</td>
                            <td class="ltThead">상태</td>
                            <td class="ltThead">수집기간</td>
                            <td class="ltThead">진행시간</td>
                            <td class="ltThead">메모</td>
                            <td class="ltThead">로그</td>
                            <td class="ltThead">연동</td>
                        </tr>
                    </thead>
                    <tbody id="tList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>