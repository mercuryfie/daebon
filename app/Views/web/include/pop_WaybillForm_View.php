<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="<?=URL_COMMON_ASSETS?>/deliveryform_Do.js?rnd=<?=rand();?>"> </script>

<section class="content waybill_content" >
    <input type="hidden" id="pop_orcode" name="pop_orcode" value="<?=$body['info']['fk_orcode'];?>"/>
    <input type="hidden" id="pop_delicode" name="pop_delicode" value="<?=fn_formatInvoiceNumber($body['info']['fk_dcode']);?>" />
    <div class="waybill_boxfxp flexType4" id="prn_body">
        <div class="waybill_inner">
            <div class="bgBox">
                <img src="/assets/web/src/waybill3.png" alt="img" class="waybillImg">
            </div>
            <div class="paddingBox flexType4">
                <div class="left ">
                    <div class="area area1 flexType3 ">
                        <div class="left1">
                            <p class="text text1"><?=$body['info']['r_tml_nm']?></p>
                            <p class="text text2"><?=$body['info']['r_city_gun_gu']?>
                                <br>
                                <?=$body['info']['r_dong']?>

                            </p>

                        </div>
                        <div class="left2 barBox flexType2">
                            <svg id="filtcd" name="filtcd" class="barcodeArea" data-code="<?=$body['info']['r_filt_cd']?>" style=""></svg>
                        </div>
                    </div>
                    <div class="area area2 flexCol">
                        <?foreach ($body['product'] as $d){?>
                            <p class="text"><?=$d['num']?>) <?=$d['sgname']?>/<?=$d['gcnt']?>개/<?=$d['spname']?></p>
                        <?}?>
                    </div>
                    <div class="area area3 flexCol3">
                        <p class="text">총수량:<?=$body['totalCnt']?>개</p>
                        <p class="text text2">[<?=$body['info']['pcnt']?>/<?=$body['info']['pcnt']?>]</p>
<!--                        <div class="left"></div>-->
<!--                        <div class="right">-->
<!---->
<!--                        </div>-->
                    </div>
                    <div class="area area4">
                        <p class="text text1">운송장 번호 : <?=fn_formatInvoiceNumber($body['info']['fk_dcode'])?></p>
                        <p class="text text2">보내는분 : <?=$body['info']['s_name'];?></p>
                        <div class="flexType2"><p class="text text3 mr10" name="r_name">받는분 : <?=fn_formatInvoiceNumber($body['info']['r_name']);?></p>
                            <p class="text text4" name="phone_type">☎<?=$body['info']['r_phone']?></p></div>
                        <p class="text text5">주소 : <?=$body['info']['r_address1']?><?=$body['info']['r_address2']?></p>
                        <p class="text text6">운임 : (신용)</p>

                    </div>
                    <div class="area area5 barBox2 flexType3-1">
                        <div class="barBb barBb1">
                            <svg id="delicode1" name="delicode1" class="barcodeArea" data-code="<?=$body['info']['fk_dcode']?>"  ></svg>
                        </div>
                        <div class="barBb barBb2 flexCol3-1 mr10">
                            <p class="text text1"><?=$body['info']['r_brnshp_nm']?></p>
                            <p class="text text2"><?=$body['info']['r_emp_nm']?></p>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="area area1 flexType3">
                        <p class="text text1"><?=fn_formatInvoiceNumber($body['info']['fk_dcode'])?> (신)</p>
                        <p class="text text2"><?=fn_Short_Date($body['info']['confirm_date']);?></p>
                    </div>
                    <div class="area area2 ">
                        <p class="text text1"><?=$body['info']['r_brnshp_nm']?><?=$body['info']['r_dong']?>
<!--                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A saepe velit voluptates. Amet architecto deleniti ducimus, ea est excepturi fugiat modi obcaecati possimus, quae quas sit voluptatem! Dolorum, magni, quod?-->

                        </p>
                        <div class="telBo flexType2">
                            <p class="text text2 mr10"><?=$body['info']['r_name']?></p>
                            <p class="text text3"><?=$body['info']['r_phone']?></p>
                        </div>
                        <p class="text text4"><?=$body['info']['r_address1']?> <?=$body['info']['r_address2']?>

                        </p>

                    </div>
<!--                    <div class="area area3">-->
<!--                        <p class="text text1">--><?php //=$body['info']['r_address1']?><!-- --><?php //=$body['info']['r_address2']?>
<!---->
<!--                        </p>-->
<!--                    </div>-->
                    <div class="area area4 flexType2" >
                        <p class="text text1" id="" name="s_name"><?= $body['info']['s_name'];?></p>
                        <p class="text text2"> <?=$body['info']['s_phone']?></p>
                    </div>
                    <div class="area area5 flexType3">
                        <p class="text text1"><?=$body['info']['fk_dcode']?></p>
                        <div class="barBox5 flexType1">
                            <svg id="delicode2" name="delicode2" class="barcodeArea" data-code="<?=$body['info']['fk_dcode']?>" style=""></svg>
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
                            <p class="text text3">※일반출고※ <?=$body['info']['fk_dcode']?></p>
                            <p class="text text4"><?=$body['info']['r_brnshp_nm']?> ☎<?=$body['info']['r_phone']?></p>

                        </div>
                    </div>
                    <div class="area area7">
                        <div class="flexType2">
                            <p class="text text1 mr10"><?=$body['info']['r_name']?></p>
                            <p class="text text2"><?=$body['info']['r_phone']?></p>
                        </div>
                        <p class="text text3"><?=$body['info']['r_address1']?> <?=$body['info']['r_address2']?></p>
                    </div>
                    <div class="area area9 ">
                        <div class="flexType2">
                            <p class="text text1"><?=$body['info']['s_name']?></p>
                            <p class="text text2"><?=$body['info']['s_phone']?></p>
                        </div>
                        <p class="text text3"><?=$body['info']['s_address1']?> <?=$body['info']['s_address2']?></p>
                    </div>
                    <div class="area area11 flexType2">
                        <p class="text text1"><?=$body['info']['pname']?></p>
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