<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/linkMallsLogs_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <input type="hidden" id="code" name="code" value="<?=$body['code'];?>" />
    <div class="merright1-0 linkLog_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                쇼핑몰연동-로그
            </p>
        </div>
        <div class="areaBox pb100">
            <div class="area3 mb10">
                <button type="button" class="btnType1" id="btn_show">목록보기</button>
            </div>
            <div class="area4 ">
                <table class="linkMallsTable ">
                    <thead>
                        <tr>
                            <td class="ltThead col2">쇼핑몰명</td>
<!--                                <td class="ltThead">쇼핑몰</td>-->
                            <td class="ltThead">API 상태</td>
                            <td class="ltThead">API 결과</td>
                            <td class="ltThead">호출 날짜</td>
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