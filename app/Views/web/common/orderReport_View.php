<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<!-- js ----------------------------  -->
<script src="<?=URL_COMMON_ASSETS?>/orderReport_Do.js?rnd=<?=rand();?>"> </script>
<script>
</script>

<section class="merright">
    <div class="order_report_wrap">
        <div class="titleBox">
            <p class="headTitle">
                주문보고서
            </p>
        </div>
        <div style="" class=" order_report_box">
            <div class="common_tbl_wrap">
                <table class="common_tbl">
                    <thead>
                    <tr>
                        <th>기간</th>
                <?if(fn_ArrayCnt($body['name']) > 0){?>
                    <?foreach($body['name'] as $a){?>
                        <th><?=$a;?></th>
                    <?}?>
                <?}?>
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