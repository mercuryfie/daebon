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
            <div class="area3 mb10">
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
                            <td class="ltThead">수집시간</td>
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