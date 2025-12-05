<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/instructionForm_Do.js?rnd=<?=rand();?>"> </script>
<section class="merright instruction_boxqqq">
    <div class="odRoast_boxfxp"  id="frnbody">
        <table class="odRoast_Table">
            <thead>
                <tr class="headCol">
                    <td class="keyCol " colspan="8">생산작업지시서</td>
                </tr>
                <tr class="">
                    <td class="keyCol barcodeBox" colspan="4" rowspan="2">
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
                    <td class="keyCol " rowspan="2">제품명</td>
                    <td class="keyCol productName" colspan="3" rowspan="2" ><?=$body['info_arr']['gname']?></td>
                    <td class="keyCol" >상품분류</td>
                    <td class="keyCol" colspan="2" ><?=$body['info_arr']['catestr']?></td>
                </tr>
                <tr>
                    <td class="keyCol" >적정재고</td>
                    <td class="keyCol" colspan="2" ><?=number_format($body['info_arr']['inventory'])?>개</td>
                </tr>
                <tr>
                    <td class="row row2 ttl" >원료명</td>
                    <td class="row row3 ttl" colspan="2">입고량</td>
                    <td class="row row4 ttl">단위</td>
                    <td class="row row5 ttl" colspan="3">비고</td>
                </tr>
            <?foreach ($body['material_arr'] as $d){?>
                <tr>
                    <td class="row row2"><?=$d['mtname'];?></td>
                    <td class="row row3" colspan="2"><?= number_format($d['capacity']);?></td>
                    <td class="row row4">g</td>
                    <td class="row row5" colspan="3"><?=$d['maker'];?> / <?=$d['supply'];?></td>
                </tr>
            <?}?>
            </thead>
            <tbody>
                <tr>
                    <td class="row subTitle" colspan="7"></td>
                </tr>
                <tr>
                    <td class="row row1 ttl stepName">공정명</td>
                    <td class="row row2 ttl">총투입량</td>
                    <td class="row row2 ttl">예상산출량</td>
                    <td class="row row3 ttl" colspan="2">가이드</td>
                    <td class="row row4 ttl">부자재</td>

                    <td class="row row6 ttl">검사확인</td>
                </tr>
           <?foreach ($body['step_arr'] as $d){?>
                <tr>
                    <td class="row row1 stepName"><?=$d['step_name'];?></td>
                    <td class="row row2"><?=number_format($d['input_material']);?>g</td>
                    <td class="row row2"><?=number_format($d['output_material']);?>g</td>
                    <td class="row row3 " colspan="2">
                        <p class="desc">
                            <?=$d['p_method'];?>
                        </p>
                    </td>
                    <td class="row row2"><?=$d['material'];?></td>
                    <td class="row row2">-</td>
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
        <button type="button" class="btnType1" id="btn_print">출력</button>
    </div>

</section>

<?= $this->endSection() ?>