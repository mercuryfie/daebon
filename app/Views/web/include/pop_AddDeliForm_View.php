<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>
<script src="<?=URL_COMMON_ASSETS?>/jquery-barcode.js"> </script>
<script src="<?=URL_COMMON_ASSETS?>/AddDeliForm_Do.js"> </script>

<?php print_r($body)?>
<section class="merright add_deli_contents"  id="" >
    <div class="add_deli_wrap" id="add_deli_box">
<!--        <table class="add_deli_tbl" id="add_deli_table">-->
        <table class="add_deli_tbl" id="">
            <thead>
                <tr class="headTr">
                    <td class="keyCol data1" colspan="8" rowspan="1">배송출고지시서</td>
                </tr>
                <tr class=" ">
                    <td class="keyCol barTd" colspan="4" rowspan="2">
                        <div class="barcodeBox flexCol2">
                            <div id="barcodeDiv" class="barcodeArea" data-orcode="<?=$body['orcode']?>" style=""></div>
                            <p class="barcodeNo"></p>
                        </div>
                    </td>
                    <td class="keyCol" colspan="2">주문코드</td>
                    <td class="keyCol data1" colspan="2"><?=$body['orcode']?></td>
                </tr>
                <tr>
                    <td class="keyCol" colspan="2">쇼핑몰주문코드</td>
                    <td class="keyCol data1" colspan="2"><?=$body['info']['spcode'];?></td>
                </tr>
            </thead>
            <tbody name="iList" id="iList">
                <tr class="border_none">
                    <td class=" " colspan="8"></td>
                </tr>
                <tr>
                    <td class=" subTitle " colspan="8">주문자 정보</td>
                </tr>
                <tr>
                    <td class="row row3">주문일</td>
                    <td class="row row2" colspan="2">구매자ID</td>
                    <td class="row row8">쇼핑몰</td>
                    <td class="row row4">수량</td>
                    <td class="row row5" colspan="2">금액</td>
                    <td class="row row7">등록</td>
                </tr>
                <tr>
                    <td class="row row3"><?=$body['info']['orderdate'];?></td>
                    <td class="row row2"  colspan="2"><?=$body['info']['buy_id'];?></td>
                    <td class="row row1"><?=getExCodeName($body['info']['shoptyp']);?></td>
                    <td class="row row4"><?=$body['info']['tcnt'];?></td>
                    <td class="row row5" colspan="2"><?=number_format($body['info']['tprice']);?>원</td>
                    <td class="row row7"><?=get_Order_Input_Type($body['info']['input_typ']);?></td>

                </tr>
                <tr class="border_none">
                    <td class="" colspan="8"></td>
                </tr>
                <tr>
                    <td class=" subTitle" colspan="8">상품정보</td>
                </tr>
                <tr>
                    <td class="row row1">상품코드</td>
                    <td class="row row2" colspan="5">상품명</td>
                    <td class="row row3">수량</td>
                    <td class="row row4">비고</td>
                </tr>
                <div class="" name="goods_info" id="goods_info">
            <?if(fn_ArrayCnt($body['product'])>0){?>
                <?foreach ($body['product'] as $d){?>

                    <tr>
                        <td class="row row1"><?=$d['fk_pdcode'];?></td>
                        <td class="row row2" colspan="5"><?=$d['pdname'];?></td>
                        <td class="row row4"><?=$d['gcnt'];?></td>
                        <td class="row row5">-</td>
                    </tr>
                <?}?>
            <?}?>
                </div>
                <tr class="border_none">
                    <td class="" colspan="8"></td>
                </tr>

                <tr>
                    <td class=" subTitle" colspan="8">배송지 정보</td>
                </tr>
                <tr>
                    <td class="row row1">수령인</td>
                    <td class="row row2">연락처</td>
                    <td class="row row3" colspan="4">주소</td>
                    <td class="row row4" colspan="2">주소상세</td>
                </tr>
                <tr>
                    <td class="row row1"><?=$body['info']['receive_name'];?></td>
                    <td class="row row2">
                        <?php
                        function formatPhone($phone) {
                            return preg_replace('/(\d{3})(\d{3,4})(\d{4})/', '$1-$2-$3',
                                    preg_replace('/[^0-9]/', '', $phone));
                        }
                        echo formatPhone($body['info']['receive_phone']);
                        ?></td>
                    <td class="row row4" colspan="4">(<?=$body['info']['receive_zipcode'];?>) <?=$body['info']['receive_address1'];?></td>
                    <td class="row row5" colspan="2"><?=$body['info']['receive_address2'];?></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="btnBox flexType1">
        <button type="button" class="btnType1 mr10 " id="xBtn">닫기</button>
        <button type="button" class="btnType1" id="btn_print" data-orcode="<?=$body['orcode']?>" data-orstep="<?=$body['info']['orstep']?>">출력</button>
    </div>

</section>

<?= $this->endSection() ?>