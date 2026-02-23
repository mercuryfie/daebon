<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>
<section class="merright ins_form_contents">
<!--    --><?php //print_r($body)?>
    <div class="odRoast_boxfxp"  id="frnbody">
        <table class="odRoast_Table ins_form_table">
            <thead>
                <tr class="headCol">
                    <td class="keyCol " colspan="8">생산작업지시서</td>
                </tr>
                <tr class="">
                    <td class="keyCol barcodeBox" colspan="5" rowspan="2">
                        <div id="barcodeDiv" class="barcodeArea" data-pcode="<?=$body['info_arr']['gicode']?>" style=""></div>
                        <p class="barcodeNo"><?=$body['info_arr']['gicode']?></p>
                    </td>
                    <th class="keyCol twnw ttl" colspan="">등록자</th>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['writer']?></td>
                </tr>
                <tr>
                    <th class="keyCol twnw ttl" colspan="1">등록일</th>
                    <td class="keyCol data1" colspan="2"><?=$body['info_arr']['indate']?></td>
                </tr>
                <tr>
                    <th class="keyCol twnw ttl" colspan="2" rowspan="2">제품명</th>
                    <td class="keyCol  m_name" colspan="3" rowspan="2" ><?=$body['info_arr']['gname']?></td>
                    <th class="keyCol twnw ttl" >상품분류</th>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
                </tr>
                <tr>
                    <th class="keyCol twnw ttl" >적정재고량</th>
                    <td class="keyCol" colspan="2" ><?=number_format($body['info_arr']['inventory'])?>개</td>
                </tr>
                <tr>
                    <th class="row row2 ttl mt_name_ttl " colspan="2" rowspan="2">원재료명</th>
                    <td class="row row2 m_name" colspan="3" rowspan="2">
                        <div class="dd flexCol2">
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
                    <th class="row row3 twnw ttl" colspan="">기본수량</th>
                    <td class="row row3" colspan="2"><?=$body['info_arr']['quantity']?> 개</td>
                </tr>
                <tr>
                    <th class="row row3 twnw ttl" colspan="">제조/공급사</th>
                    <td class="row row3 ma_data" colspan="2">
                        <div class="flexCol2">
                            <p class="text"><?= $body['material_arr'][0]['maker'];?>/<?= $body['material_arr'][0]['supply'];?></p>

                        </div>

                    </td>
<!--                    <td class="row row3 twnw ttl" colspan="">작업완료일시</td>-->
<!--                    <td class="row row5 " colspan="2">-</td>-->
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
                <td class="row row1 rName tww" colspan="5" rowspan="" ><?=$d['step_name'];?></td>

                <td class="row row2 " colspan="3">
                    <div class="flexCol2">
                        <p class="downside"><?=number_format($d['input_material'] * (int)$body['info_arr']['icnt'])?> / <?=number_format($d['output_material'] * (int)$body['info_arr']['icnt'])?></p>
                    </div>
                </td>
<!--                <td class="row row2 tww" colspan="">--><?php //=$d['material'];?><!--</td>-->
        <?}?>
            </tr>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3 twnw" colspan="2">기본수량</th>
                <td class="row row2" colspan="2"><?=$body['info_arr']['quantity']?> 개</td>
            </tr>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3 twnw" colspan="2">지시수량</th>
                <td class="row row2" colspan="2"><?=$body['info_arr']['icnt']?> 개</td>
            </tr>
            <tr>
                <td class="row row1" colspan="4">-</td>
                <th class="row row3 twnw" colspan="2">실제완성량</th>
                <td class="row row4" colspan="2">
                <?php
                    $qty  = (int) $body['info_arr']['quantity'];
                    $icnt = (int) $body['info_arr']['icnt'];
                    $result = $qty * $icnt;
                    ?><?=$result?> 개
                </td>
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