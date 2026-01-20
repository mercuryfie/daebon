<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/deliveryform_Do.js?rnd=<?=rand();?>"> </script>

<?php print_r($body)?>
<section class="content waybill_content" >
    <input type="hidden" id="pop_orcode" name="pop_orcode" value="<?=$body['fk_orcode'];?>"/>
    <input type="hidden" id="pop_delicode" name="pop_delicode" value="<?=fn_formatInvoiceNumber($body['fk_dcode']);?>" />
    <div class="waybill_boxfxp flexType4" id="prn_body">
         <div class="waybill_inner">
             <div class="bgBox">
                 <img src="/assets/web/src/waybill3.png" alt="img" class="waybillImg">
             </div>
             <div class="paddingBox flexType4">
                 <div class="left ">
                     <div class="area area1 ">
                         <div class="left1">
                             <p class="text text1"><?=$body['r_tml_nm']?></p>
                             <p class="text text2"><?=$body['r_city_gun_gu']?> <?=$body['r_dong']?></p>
                         </div>
                         <div class="left2 barBox flexType2">
                             <div id="filtcd" name="filtcd" class="barcodeArea" data-code="<?=$body['r_filt_cd']?>" style=""></div>
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
                         <p class="text text1">운송장 번호 : <?=fn_formatInvoiceNumber($body['fk_dcode'])?></p>
                         <p class="text text2">보내는분 : <?=$body['s_name'];?></p>
                         <div class="flexType2"><p class="text text3 mr10" name="r_name">받는분 : <?=fn_formatInvoiceNumber($body['r_name']);?></p>
                             <p class="text text4" name="phone_type">☎<?=$body['r_phone']?></p></div>
                         <p class="text text5">주소 : <?=$body['r_address1']?> <?=$body['r_address2']?></p>
                         <p class="text text6">운임 : (신용)</p>

                     </div>
                     <div class="area barBox2 flexType3">
                         <div class="barBb barBb1">
                             <div id="delicode" name="delicode" class="barcodeArea" data-code="<?=$body['fk_dcode']?>" style=""></div>
                         </div>
                         <div class="barBb barBb2 flexCol3 mr10">
                             <p class="text text1"><?=$body['r_brnshp_nm']?></p>
                             <p class="text text2"><?=$body['r_emp_nm']?></p>
                         </div>
                     </div>
                 </div>
                 <div class="right">
                     <div class="area area1 flexType3">
                         <p class="text text1"><?=fn_formatInvoiceNumber($body['fk_dcode'])?> (신)</p>
                         <p class="text text2"><?=fn_Short_Date($body['confirm_date']);?></p>
                     </div>
                     <div class="area area2 ">
                         <p class="text text1"><?=$body['r_brnshp_nm']?><?=$body['r_dong']?></p>
                         <div class="telBo flexType2">
                             <p class="text text2 mr10"><?=$body['r_name']?></p>
                             <p class="text text3"><?=$body['r_phone']?></p>
                         </div>

                     </div>
                     <div class="area area3">
                         <p class="text text1"><?=$body['r_address1']?> <?=$body['r_address2']?></p>
                     </div>
                     <div class="area area4 flexType2" >
                         <p class="text text1" id="" name="s_name"><?= $body['s_name'];?></p>
                         <p class="text text2"> <?=$body['s_phone']?></p>
                     </div>
                     <div class="area area5 flexType2">
                         <p class="text text1"><?=$body['fk_dcode']?></p>
                         <div class="barBox5 flexType1">
                             <div id="delicode2" name="delicode2" class="barcodeArea" data-code="<?=$body['fk_dcode']?>" style=""></div>
                         </div>
                     </div>
                     <div class="area area6 flexType3">
                         <p class="text text1">(신)</p>
                         <p class="text text2">1-1</p>
<!--                         <div class="left flexType2">-->
<!--                             <p class="text text1">(신)</p>-->
<!--                             <p class="text text2">1-1</p>-->
<!--                         </div>-->
                         <div class="area6bb flexCol3">
                             <p class="text text3">※일반출고※ <?=$body['fk_dcode']?></p>
                             <p class="text text4"><?=$body['r_brnshp_nm']?> ☎<?=$body['r_phone']?></p>

                         </div>
                     </div>
                     <div class="area area7">
                         <div class="flexType2">
                             <p class="text text1 mr10"><?=$body['r_name']?></p>
                             <p class="text text2"><?=$body['r_phone']?></p>
                         </div>
                         <p class="text text3"><?=$body['r_address1']?> <?=$body['r_address2']?></p>
                     </div>
                     <div class="area area9 ">
                         <div class="flexType2">
                             <p class="text text1"><?=$body['s_name']?></p>
                             <p class="text text2"><?=$body['s_phone']?></p>
                         </div>
                         <p class="text text3"><?=$body['s_address1']?> <?=$body['s_address2']?></p>
                     </div>
                     <div class="area area11 flexType2">
                         <p class="text text1"><?=$body['pname']?></p>
                     </div>
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