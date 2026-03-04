<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>


<link rel="stylesheet" href="/assets/web/css/style.css?rnd=<?echo(rand()); ?>">
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="<?=URL_COMMON_ASSETS?>/inoutMaterialPrn_Do.js?rnd=<?=rand();?>"> </script>
<section class="merright bar_mat_contents">
    <input type="hidden" id="mtcode" name="mtcode" value="<?=$body['data']['mtcode'];?>" />
    <div class="bar_mat_box " id="frnbody" name="frnbody">
        <table class="bar_mat_table">
            <thead>
            <tr class="">
                <td class="keyCol barcode" colspan="3" rowspan="">
                    <div class="barcodeArea">
                        <svg id="prnbarcode" name="prnbarcode" class="barcodeArea"  style=""></svg>
                    </div>
                </td>
            </tr>
            </thead>
            <tbody>
<!--            <tr>-->
<!--                <td class="keyCol" >입고일</td>-->
<!--                <td class="keyCol data1" colspan="1">2025.01.01 12:00am</td>-->
<!--            </tr>-->
            <tr>
                <th class="keyCol" colspan="2">품목명</th>
                <td class="keyCol fwbold" colspan="1" ><?=$body['data']['mtname'];?></td>
            </tr>
            <tr>
                <th class="keyCol" colspan="2">제조/공급사</th>
                <td class="keyCol" colspan="1" ><?=$body['data']['fk_mkname'];?>/<?=$body['data']['fk_suname'];?></td>
            </tr> 
            <tr>
                <th class="keyCol" colspan="2">적정재고량</th>
                <td class="keyCol fwbold" colspan="1" ><?=$body['data']['inventory'];?><?=$body['data']['unit_name'];?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="btnBox flexType1">
        <button type="button" class="btnType1 mr10 " id="xBtn" onclick="Close_Window();">닫기</button>
        <button type="button" class="btnType1" id="btn_print" data-code="<?=$body['data']['mtcode'];?>">출력</button>
    </div>
</section>

<?= $this->endSection() ?>