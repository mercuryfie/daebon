<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<link rel="stylesheet" href="/assets/web/css/style_staff.css?rnd=<?=rand();?>">

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="<?=URL_COMMON_ASSETS?>/prn_label_Do.js?rnd=<?=rand();?>"> </script>

<div class="prod_label_wrap2" >
    <div class="area area1 prn_half_area1" id="prn_body2">
        <table class="prod_label_table2">
            <tr>
                <th>지시서 코드</th>
                <td class="data data2">
                    <svg id="gicode" name="gicode" class="barcodeArea" data-gicode="<?=$body['gicode']?>" style=""></svg>
                </td>
<!--                <td class="" colspan="2">-->
<!--                    <div class="bar_wrap flexType2">-->
<!--                        <div class="bar_box left">-->
<!--                            <p class="title">지시서 코드dd</p>-->
<!--                            <svg id="gicode" name="gicode" class="barcodeArea" data-gicode="--><?php //=$body['gicode']?><!--" style=""></svg>-->
<!---->
<!--                        </div>-->
<!--                        <div class="bar_box right">-->
<!--                            <p class="title">반제품 코드</p>-->
<!--                            <svg id="gicode" name="gicode" class="barcodeArea" data-gicode="--><?php //=$body['gicode']?><!--" style=""></svg>-->
<!---->
<!--                             -->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                </td>-->
            </tr>
            <tr>
                <th>원료 공급사</th>
                <td class="data data4"><?=$body['indate'];?></td>
            </tr>
            <tr>
                <th>원료 제조사</th>
                <td class="data data4"><?=$body['indate'];?></td>
            </tr>
            <tr>
                <th>원료 입고일</th>
                <td class="data data4"><?=$body['indate'];?></td>
            </tr>
            <tr>
                <th>공정명</th>
                <td class="data data3"><?=$body['pname'];?></td>
            </tr>
            <tr>
                <th>공정완료일</th>
                <td class="data data4"><?=$body['indate'];?></td>
            </tr>
            <tr>
                <th>반제품 코드</th>
                <td class="data data2">
                    <svg id="sicode" name="sicode" class="barcodeArea" data-sicode="<?=$body['sicode']?>" style=""></svg>
                </td>
            </tr>
        </table>
    </div>
    <div class="area lastArea flexType1">
        <button type="button" class="btn60Type3 mr10" id="xBtn" name="Xbtn">닫기</button>
        <button type="button" class="btn60Type3" id="btn_print" name="btn_print">출력</button>

    </div>
</div>

<?= $this->endSection() ?>