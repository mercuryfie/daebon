<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/missingList_Do.js?rnd=<?=rand();?>"> </script>
<input type="hidden" id="stype" name="stype" value="<?=$body['styp'];?>" />
<section class="merright">
    <div class="merright1-0 missing_list_wrap">
        <div class="titleBox">
            <p class="headTitle">
                누락목록 - <span id="sname" name="sname"></span>
            </p>
        </div>
        <div class="areaBox pb100 min80vh">
            <div class="area3 mb10">
            </div>
            <div class="area4">
                <table class="missing_list_table ml20 ">
                    <thead>
                        <tr>
                            <td class="ltThead ">주문코드</td>
                            <td class="ltThead ">마켓 주문코드</td>
                            <td class="ltThead">마켓 상품명</td>
                            <td class="ltThead">누락이유</td>
                            <td class="ltThead">주문자명</td>
                            <td class="ltThead">주문일자</td>
                            <td class="ltThead ">등록일</td>
                            <td class="ltThead ">매칭</td>
                        </tr>
                    </thead>
                    <tbody id="mList">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="area lastArea flexType5-1">
            <button type="button" class="btnType1 mr20" onclick="go_linkMalls();">목록</button>
        </div>
    </div>

</section>

<?= $this->endSection() ?>