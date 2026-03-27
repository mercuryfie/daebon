<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <script src="<?=URL_COMMON_ASSETS?>/processStatus_Do.js?rnd=<?=rand();?>"> </script>
    <section class="merright">
        <div class="goods_boxfv6">
            <div class="titleBox">
                <p class="headTitle">
                    공정별 진행현황
                </p>
            </div>

            <div class="areaBox area_boxmxh min70vh">
                <div class="goods_boxkfg flexType3">
                    <div class="left flexType2">
                    </div>
                </div>
                <div class="area4 goods_boxa1b flexType2">
                    <div class="common_tbl_wrap" id="p_wrap">
                        <table class="common_tbl">
                            <thead>
                            <tr name="view_detail" data-code="${el.gicode}">
                                <th class="ltThead">공정코드</th>
                                <th class="ltThead">공정명</th>
                                <th class="ltThead">공정구분</th>
                                <th class="ltThead">공정로스율</th>
                                <th class="ltThead">공정진행수</th>
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