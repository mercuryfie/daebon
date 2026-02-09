<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/material_StockLog_Do.js?rnd=<?=rand();?>"> </script>

<section class="merright">
    <input type="hidden" id="mtcode" name="mtcode" value="<?=$body['mtcode'];?>" />
    <div class="merright1-0 linkLog_wrap5r6">
        <div class="titleBox">
            <p class="headTitle">
                입출고 로그 - <span id="stockname" name="stockname"></span>
            </p>
        </div>
        <div class="areaBox pb100">
            <div class="area3 mb10">
                <button type="button" class="btnType1" id="btn_showlist">목록보기</button>
            </div>
            <div class="area4 ">
                <table class="linkMallsTable ">
                    <thead>
                        <tr>
                            <td class="ltThead">현재재고</td>
                            <td class="ltThead">입고량</td>
                            <td class="ltThead">출고량</td>
                            <td class="ltThead">입출고사유</td>
                            <td class="ltThead">입출고메모</td>
                            <td class="ltThead">일시</td>
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