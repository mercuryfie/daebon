<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/missingList_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <div class="merright1-0 missing_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                누락목록 - 쿠팡
            </p>
        </div>
        <div class="areaBox pb100">
            <div class="area3 mb10">
<!--                <button type="button" class="btnType1 mr10" id="btn_showlog">로그보기</button>-->
<!--                <button type="button" class="btnType2" id="btn_mall">주문수집</button>-->
            </div>
            <div class="area4">
                <table class="missing_list_table ml20 ">
                    <thead>
                        <tr>
                            <td class="ltThead ">마켓 주문코드</td>
                            <td class="ltThead ">주문코드</td>
                            <td class="ltThead">누락이유</td>
                            <td class="ltThead">주문자명</td>
                            <td class="ltThead">주문일자</td>
                            <td class="ltThead ">등록일</td>
                        </tr>
                    </thead>
                    <tbody id="mList">
                        <tr onclick="More_Info(this);" class="more_tr">
                            <td class="ltThead ">DM12341234

                            </td>
                            <td class="ltThead">DM12341234
                                <div class="data_box flexCol4">
                                    <p class="data">우엉차(DM12341234)</p>
                                    <p class="data">생강차(DM12341234)</p>
                                </div>
                            </td>
                            <td class="ltThead">-
                                <div class="data_box flexCol4">
                                    <p class="data">매칭안됨</p>
                                    <p class="data">매칭안됨</p>
                                </div>
                            </td>
                            <td class="ltThead">주문자명</td>
                            <td class="ltThead">주문일자</td>
                            <td class="ltThead ">등록일</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>