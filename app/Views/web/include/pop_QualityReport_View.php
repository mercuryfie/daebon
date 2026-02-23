<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>

<script>
</script>
<!--    *$body['info_arr']['icnt'] info_arr-->
<?php //print_r($body)?>

<section class="merright q_report_box22 ">
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
                <th class="keyCol" colspan="">등록자</th>
                <td class="keyCol data1" colspan="2"><?=$body['info_arr']['writer']?></td>
            </tr>
            <tr>
                <th class="keyCol" colspan="1">등록일</th>
                <td class="keyCol data1" colspan="2"><?=$body['info_arr']['indate']?></td>
            </tr>
            <tr>
                <th class="keyCol " colspan="2" rowspan="2">제품명</th>
                <td class="keyCol productName m_name" colspan="3" rowspan="2" ><?=$body['info_arr']['gname']?></td>
                <th class="keyCol" >상품분류</th>
                <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
            </tr>
            <tr>
                <th class="keyCol" >적정재고량</th>
                <td class="keyCol" colspan="2" ><?=number_format($body['info_arr']['inventory'])?>개</td>
            </tr>
            <tr>
                <th class="row row2 ttl " colspan="2" rowspan="2">원재료명</th>
                <td class="row row2 m_name" colspan="3" rowspan="2">
                    <div class="dd">
                <?if ($body['material_arr'] >= 0 ) {?>
                    <?foreach ($body['material_arr'] as $d){?>
                    <?=$body['material_arr'][0]['mtname'];?>
                    <?}?>
                <?}?>
                    </div>
                </td>
                <th class="row row3 ttl" colspan="">제조사/공급사</th>
                <td class="row row3" colspan="2"><?= $body['material_arr'][0]['maker'];?>/<?= $body['material_arr'][0]['supply'];?></td>
            </tr>
            <tr>
                <th class="row row3 ttl" colspan="">작업완료일시</th>
                <td class="row row5 ttl" colspan="2">-</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="row subTitle bn" colspan="8"></td>
            </tr>
            <tr>
                <th class="row row1 ttl  " colspan="5" >공정명</th>
                <th class="row row2 ttl" colspan="3" >
                    <p class="downside">투입/산출량(g)</p>
                </th>
            </tr>
            <?foreach ($body['step_arr'] as $d){?>
                <tr>
                    <td class="row row1 rName " colspan="5" rowspan="" ><?=$d['step_name'];?></td>

                    <td class="row row2 " colspan="3"><div class="flexCol2">
                            <!--                        <p class="upside">--><?php //=number_format($d['input_material']);?><!--/--><?php //=number_format($d['output_material']);?><!--</p>-->
<!--                            --><?//if ($d['step_typ']=='P001'){?>
<!--                                <p class="downside">--><?php //=number_format($d['end_weight']);?><!--</p>-->
<!--                            --><?//} else {?>
<!--                                <p class="downside">--><?php //=number_format($d['start_weight']);?><!--/--><?php //=number_format($d['end_weight']);?><!--</p>-->
<!--                            --><?//}?>
                            <p class="downside"><?=number_format($d['input_material']*$body['info_arr']['icnt']);?>/<?=number_format($d['output_material']*$body['info_arr']['icnt']);?></p>


                        </div></td>
                </tr>
            <?}?>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3" colspan="2">기본수량</th>
                <td class="row row2" colspan="2"><?=$body['info_arr']['quantity']?>개</td>
            </tr>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3" colspan="2">지시수량</th>
                <td class="row row2" colspan="2"><?=$body['info_arr']['icnt']?>개</td>
            </tr>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3" colspan="2">실제완성량</th>
                <td class="row row4" colspan="2"><?php
                    $qty  = (int) $body['info_arr']['quantity'];
                    $icnt = (int) $body['info_arr']['icnt'];
                    $result = $qty * $icnt;
                    ?><?=$result?> 개</td>
            </tr>
            <tr class="signArea">
                <td class="row row1" colspan="8" rowspan=""></td>
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