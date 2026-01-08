<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>

<section class="merright q_report_box22 ">
        <?php print_r($body)?>
<!--        --><?php //print_r($body['material_arr'])?>
    <div class=" q_report_box23d" id="frnbody" >
        <table class=" q_report_table" >
            <thead>
            <tr class="headCol">
                <td class="keyCol" colspan="8">품질보고서</td>
            </tr>
            <tr class="">
                <td class="keyCol barcodeBox" colspan="5" rowspan="2">
                    <div id="barcodeDiv" class="barcodeArea" data-pcode="<?=$body['info_arr']['gicode']?>" style=""></div>
                    <p class="barcodeNo"><?=$body['info_arr']['gicode']?></p>
                </td>
                <td class="keyCol" colspan="">등록자</td>
                <td class="keyCol data1" colspan="2"><?=$body['info_arr']['writer']?></td>
            </tr>
            <tr>
                <td class="keyCol" colspan="1">등록일</td>
                <td class="keyCol data1" colspan="2"><?=$body['info_arr']['indate']?></td>
            </tr>
            <tr>
                <td class="keyCol " colspan="2" rowspan="2">제품명</td>
                <td class="keyCol productName m_name" colspan="3" rowspan="2" ><?=$body['info_arr']['gname']?></td>
                <td class="keyCol" >상품분류</td>
                <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
            </tr>
            <tr>
                <td class="keyCol" >적정재고수량</td>
                <td class="keyCol" colspan="2" ><?=number_format($body['info_arr']['inventory'])?>개</td>
            </tr>
            <tr>
                <td class="row row2 ttl " colspan="2" rowspan="2">원재료명</td>
                <td class="row row2 m_name" colspan="3" rowspan="2"><?=$body['material_arr'][0]['mtname'];?></td>
                <td class="row row3 ttl" colspan="">제조사</td>
                <td class="row row3" colspan="2"><?= $body['material_arr'][0]['maker'];?></td>
            </tr>
            <tr>
                <td class="row row3 ttl" colspan="">공급사</td>
                <td class="row row5 ttl" colspan="2"><?= $body['material_arr'][0]['supply'];?></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="row subTitle bn" colspan="8"></td>
            </tr>
            <tr>
                <td class="row row1 ttl  " colspan="2" >공정명</td>
                <td class="row row2 ttl" colspan="2" >
                    <p class="downside">투입/산출량(g)</p>
                    <!--                        <div class="flexCol2">-->
                    <!--                            <p class="upside">예상 투입/산출(g)</p>-->
                    <!--                            <p class="downside">실제 투입/산출(g)</p>-->
                    <!--                        </div>-->
                </td>
                <td class="row row3 ttl" colspan="2" rowspan="">가이드</td>
                <td class="row row4 ttl" rowspan="">부자재</td>

                <td class="row row6 ttl" rowspan="">담당자</td>
            </tr>
            <?foreach ($body['step_arr'] as $d){?>
                <tr>
                    <td class="row row1 rName " colspan="2" rowspan="" ><?=$d['step_name'];?></td>

                    <td class="row row2 " colspan="2"><div class="flexCol2">
                            <!--                        <p class="upside">--><?php //=number_format($d['input_material']);?><!--/--><?php //=number_format($d['output_material']);?><!--</p>-->
                            <?if ($d['step_typ']=='P001'){?>
                                <p class="downside"><?=number_format($d['end_weight']);?></p>
                            <?} else {?>
                                <p class="downside"><?=number_format($d['start_weight']);?>/<?=number_format($d['end_weight']);?></p>
                            <?}?>

                        </div></td>
                    <td class="row row3 " colspan="2" rowspan="">
                        <p class="desc">
                            <?=$d['p_method'];?>
                        </p>
                    </td>
                    <td class="row row2" rowspan=""><?=$d['material'];?></td>
                    <td class="row row2" rowspan=""><?=$d['worker']['name']?></td>
                </tr>
            <?}?>
            <tr>
                <td class="row row1" colspan="6">-</td>
                <td class="row row3">지시수량</td>
                <td class="row row2"><?=$body['info_arr']['quantity']?>개</td>
            </tr>
            <tr>
                <td class="row row1" colspan="6">-</td>
                <td class="row row3" >실제완성량</td>
                <td class="row row4"></td>
            </tr>
            <tr class="signArea">
                <td class="row row1" colspan="2" rowspan="">작업완료일시</td>
                <td class="row row3 m_name" colspan="6"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="btnBox flexType1 mt20">
        <button type="button" class="btnType1 mr10 " id="xBtn">닫기</button>
        <button type="button" class="btnType1" id="btn_print">출력</button>
    </div>

</section>

<?= $this->endSection() ?>