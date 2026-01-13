<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>
<?php print_r($body)?>
<?php print_r($body['info_arr'])?>
<section class="merright instruction_boxqqq">
    <div class="odRoast_boxfxp" id="frnbody">
        <table class="odRoast_Table" >
            <thead>
                <tr class="headCol">
                    <td class="keyCol" colspan="7">생산작업지시서</td>
                </tr>
                <tr class="">
                    <td class="keyCol barcodeBox" colspan="4" rowspan="2">
<!--                        <div id="barcodeDiv" class="barcodeArea" data-pcode="--><?php //=$body['info_arr']['gicode']?><!--" style=""></div>-->
<!--                        <p class="barcodeNo">--><?php //=$body['info_arr']['gicode']?><!--</p>-->
                    </td>
                    <td class="keyCol" colspan="">등록자</td>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['writer']?></td>
                </tr>
                <tr>
                    <td class="keyCol" colspan="1">등록일</td>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['indate']?></td>
                </tr>
                <tr>
                    <td class="keyCol " rowspan="2">제품명</td>
                    <td class="keyCol productName" colspan="3" rowspan="2" ><?=$body['info_arr']['gname']?></td>
                    <td class="keyCol" >상품분류</td>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
                </tr>
                <tr>
                    <td class="keyCol" >적정재고수량</td>
                    <td class="keyCol" colspan="2" ><?=number_format($body['info_arr']['inventory'])?>개</td>
                </tr>
                <tr>
                    <td class="row row2  " colspan="" rowspan="2">원재료명</td>
                    <td class="row row2 m_name" colspan="3" rowspan="2">
                        <div class="dd flexCol2">
<!--                            --><?php //=$body['material_arr'][0]['mtname']?>
                            <?php
                            if ($body['material_arr'] == 1 ) {
                                $mtNames = [$body['material_arr']['mtname'].' '.$body['material_arr']['capacity'].'g'];
                            } else {
                                $mtNames = array_map(function($item) {
                                    return $item['mtname'].' '.$item['capacity'].'g';
                                }, $body['material_arr']);
                            }
                            ?>
                            <p class="mtname">
                                <?php foreach($mtNames as $name): ?>
                                    <?=$name?><br>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </td>
                    <td class="row row3 twnw" colspan="">제조사/공급사</td>
                    <td class="row row3" colspan="2">
                        <div class="flexType1">
                            <p class="text"><?= $body['material_arr'][0]['maker'];?>/<?= $body['material_arr'][0]['supply'];?></p>
                            <?if ($body['step_arr'] > 1){?>
                                <p class="add">외 <?=count($body['material_arr'])-1?>건</p>
                            <?}?>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td class="row row3 twnw" colspan="">작업완료일시</td>
                    <td class="row row5 " colspan="2">-</td>
                </tr>
            </thead>
            <tbody><>
                <tr>
                    <td class="row </>subTitle" colspan="7"></td>
                </tr>
                <tr>
                    <td class="row row1 ttl stepName" colspan="2">공정명</td>
                    <td class="row row2 ttl">투입/산출량(g)</td>
                    <td class="row row3 ttl" colspan="2">공정방법</td>
                    <td class="row row4 ttl">부자재</td>

                    <td class="row row6 ttl">담당자</td>
                </tr>
           <?foreach ($body['step_arr'] as $d){?>
                <tr>
                    <td class="row row1 stepName" colspan="2"><?=$d['step_name'];?></td>
                    <td class="row row2"><?=number_format($d['input_material']);?>/<?=number_format($d['output_material']);?></td>
                    <td class="row row3 " colspan="2">
                        <p class="desc">
                            <?=$d['p_method'];?>
                        </p>
                    </td>
                    <td class="row row2"><?=$d['material'];?></td>
                    <td class="row row2" rowspan=""><?=$d['worker'][0]['name'] ?? '-'?></td>
                </tr>
           <?}?>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row3">기본수량</td>
                    <td class="row row2"><?=$body['info_arr']['quantity']?></td>
                </tr>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row3">실제완성량</td>
                    <td class="row row4"></td>
                </tr>
                <tr>
                    <td class="row row1" colspan="5">-</td>
                    <td class="row row5">남은재료</td>
                    <td class="row row6"></td>
                </tr>
                <tr class="signArea">
                    <td class="row row1" colspan="" rowspan="">작업완료일시</td>
                    <td class="row row3 " colspan="2"></td>
                    <td class="row row4" colspan="2">이름</td>
                    <td class="row row5" colspan="2">사인</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="btnBox flexType2 mt20">
        <button type="button" class="btnType1 mr10 " id="xBtn">닫기</button>
        <button type="button" class="btnType1" id="btn_print" data-code="">출력</button>
    </div>

</section>

<?= $this->endSection() ?>