<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>


    <!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/goodsList_Do.js?rnd=--><?php //=rand();?><!--"> </script>-->
<script>
</script>

<section class="merright">
    <div class="barcode_boxfxp label80x40">
        <table class="barcode_Table">
            <thead>
                <tr class="">
                    <td class="keyCol barcode" colspan="2" rowspan="">
                        <div class="barcodeArea">-</div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="keyCol" >입고일</td>
                    <td class="keyCol data1" colspan="1">2025.01.01 12:00am</td>
                </tr>
                <tr>
                    <td class="keyCol" colspan="1">품목명</td>
                    <td class="keyCol" colspan="1" >연고농장 연근차(티백)-A</td>
                </tr>
                <tr>
                    <td class="keyCol" >포장단위</td>
                    <td class="keyCol" colspan="1" >1,000</td>
                </tr>
                <tr>
                    <td class="keyCol" >입고처리자</td>
                    <td class="keyCol" colspan="1" >홍길동</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection() ?>