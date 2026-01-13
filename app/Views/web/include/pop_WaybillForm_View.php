<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/deliveryform_Do.js?rnd=<?=rand();?>"> </script>

<section class="content waybill_content" >
    <div class="waybill_boxfxp flexType4" id="prn_body">
        <div class="bgBox">
            <img src="/assets/web/src/waybill3.png" alt="img" class="waybillImg">
        </div>
        <div class="paddingBox flexType4">
            <div class="left ">
                <div class="area area1 flexType3">
                    <div class="left1">
                        <p class="text text1"><?=$body['r_brnshp_nm']?></p>
                        <p class="text text2"><?=$body['r_emp_nm']?></p>
                    </div>
                    <div class="left2 barBox">
                        <div id="barcodeDiv" class="barcodeArea" data-filt_cd="<?=$body['r_filt_cd']?>" style=""></div>
                    </div>
                </div>
                <div class="area area2 ">
                    <p class="text"> <?=$body['pname']?></p>
                </div>
                <div class="area area3 flexType3">
                    <p class="text"></p>
                    <p class="text text2">[1/1]</p>

                </div>
                <div class="area area4">
                    <p class="text text1">운송장 번호 : <?=formatInvoiceNumber($body['fk_dcode'])?></p>
                    <p class="text text2">보내는분 : <?=$body['s_name'];?></p>
                    <div class="flexType3"><p class="text text3" name="r_name">받는분 : <?=formatInvoiceNumber($body['r_name']);?></p>
                        <p class="text text4" name="phone_type">☎<?=$body['r_phone']?></p></div>
                    <p class="text text5">주소 : <?=$body['r_address1']?> <?=$body['r_address2']?></p>
                    <p class="text text6">운임 : (신용)</p>

                </div>
                <div class="area barBox2 flexType2">
                    <div class="barBb barBb1">
                        <div id="barcodeDiv1" class="barcodeArea" data-orcode="<?=$body['fk_dcode']?>" style=""></div>
                    </div>
                    <div class="barBb barBb2">
                        <p class="text text1"><?=$body['r_brnshp_nm']?></p>
                        <p class="text text2"><?=$body['r_emp_nm']?></p>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="area area1 flexType3">
                    <p class="text text1"><?=formatInvoiceNumber($body['fk_dcode'])?> (신)</p>
                    <p class="text text2"><?=$body['confirm_date'];?></p>
                </div>
                <div class="area area2 ">
                    <p class="text text1"><?=$body['r_brnshp_nm']?></p>
                    <div class="telBo flexType2">
                        <p class="text text2"><?=$body['r_dong']?></p>
                        <p class="text text3"></p>
                        <p class="text text4" name="phone_type"><?=$body['r_phone']?></p>
                    </div>

                </div>
                <div class="area area3">
                    <p class="text text1"><?=$body['r_address1']?> <?=$body['r_address2']?></p>
                </div>
                <div class="area area4 flexType2" >
                    <p class="text text1" id="" name="r_name"><?= $body['r_name'];?></p>
                    <p class="text text2"> <?=$body['r_phone']?></p>
                </div>
                <div class="area area5">
                    <p class="text text1"><?=$body['fk_dcode']?></p>
                </div>
                <div class="area area6 flexType2">
                    <p class="text text1">(신)</p>
                    <p class="text text2">1-1</p>
                    <div class="area6bb">
                        <p class="text text3">※일반출고※ <?=formatInvoiceNumber($body['fk_dcode'])?></p>
                        <p class="text text4"><?=$body['r_brnshp_nm']?> ☎<?=$body['r_phone']?></p>

                    </div>
                </div>
                <div class="area area7 flexType3">
                    <p class="text text1"><?=$body['s_name']?></p>
                    <p class="text text1"><?=$body['s_phone']?></p>
                </div>
                <div class="area area8 flexType2">
                    <p class="text text2"><?=$body['s_address1']?> <?=$body['s_address2']?></p>
                </div>
                <div class="area area9 flexType2">
                    <p class="text text1"><?=$body['s_name']?></p>
                    <p class="text text2"><?=$body['s_phone']?></p>
                </div>
                <div class="area area10 flexType2">
                    <p class="text text1"><?=$body['s_address1']?> <?=$body['s_address2']?></p>
                </div>
                <div class="area area11 flexType2">
                    <p class="text text1"><?=$body['pname']?></p>
                </div>
                <div class="area area12 flexType2">
                    <p class="text text1"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="btnBox flexType1 mt20">
        <button type="button" class="btnType1 mr10 " id="xBtn">닫기</button>
        <button type="button" class="btnType1" id="btn_print">출력</button>
    </div>
</section>

<?= $this->endSection() ?>