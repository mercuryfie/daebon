<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<?php //$body?>
<!-- js ----------------------------  -->
<!--<script src="--><?php //=URL_COMMON_ASSETS?><!--/orderList_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="odDeli_boxfxp">
        <table class="add_deli_tbl" id="add_deli_table">
            <thead>
                <tr class="headTr">
                    <td class="keyCol data1" colspan="8" rowspan="1">배송출고지시서</td>
                </tr>
                <tr class=" ">
                    <td class="keyCol barTd" colspan="4" rowspan="2">
                        <div class="barcodeBox flexCol2">
                            <div class="barcodeArea ">

                            </div>
                            <p class="text">12341234</p>
                        </div>
                    </td>
                    <td class="keyCol" colspan="2">등록자</td>
                    <td class="keyCol data1" colspan="2">2</td>
                </tr>
                <tr>
                    <td class="keyCol" colspan="2">등록일</td>
                    <td class="keyCol data1" colspan="2">2</td>
                </tr>
            </thead>
            <tbody name="iList" id="iList">
                <tr class="bdNone">
                    <td class="" colspan="8"></td>
                </tr>
                <tr>
                    <td class=" subTitle" colspan="8">상품정보</td>
                </tr>
                <tr>
                    <td class="row row1">주문코드</td>
                    <td class="row row1">상품코드</td>
                    <td class="row row2" colspan="3">상품명</td>
                    <td class="row row3">수량</td>
                    <td class="row row4">옵션</td>
                    <td class="row row5">옵션내용</td>
 s
                </tr>
                <div class="" name="goods_info" id="goods_info">
                    <tr>
                        <td class="row row1">-11</td>
                        <td class="row row1">-</td>
                        <td class="row row2" colspan="3">-</td>
                        <td class="row row3">-</td>
                        <td class="row row4">-</td>
                        <td class="row row5">-</td>

                    </tr>
                    <tr>
                        <td class="row row1">-</td>
                        <td class="row row1">-</td>
                        <td class="row row2" colspan="3">-</td>
                        <td class="row row3">-</td>
                        <td class="row row4">-</td>
                        <td class="row row5">-</td>

                    </tr>
                </div>
                <tr class="bdNone">
                    <td class="" colspan="8"></td>
                </tr>
                <tr>
                    <td class=" subTitle" colspan="8">주문자 정보</td>
                </tr>
                <tr>
                    <td class="row row1">쇼핑몰</td>
                    <td class="row row2">ID</td>
                    <td class="row row3">주문일</td>
                    <td class="row row4">금액</td>
                    <td class="row row5">-</td>

                    <td class="row row6">-</td>
                    <td class="row row7">-</td>
                    <td class="row row8">-</td>
                </tr>
                <tr>
                    <td class="row row1">-</td>
                    <td class="row row2">-</td>
                    <td class="row row3">-</td>
                    <td class="row row4">-</td>
                    <td class="row row5">-</td>

                    <td class="row row6">-</td>
                    <td class="row row7">-</td>
                    <td class="row row8">-</td>
                </tr>
                <tr class="bdNone">
                    <td class="" colspan="8"></td>
                </tr>
                <tr>
                    <td class=" subTitle" colspan="8">배송지 정보</td>
                </tr>
                <tr>
                    <td class="row row1">수령인</td>
                    <td class="row row2">연락처</td>
                    <td class="row row3" colspan="2">주소</td>
                    <td class="row row4" colspan="2">주소상세</td>
                    <td class="row row5">희망배송일</td>

                    <td class="row row6">택배사</td>
                </tr>
                <tr>
                    <td class="row row1">-</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="2">-</td>
                    <td class="row row4" colspan="2">-</td>
                    <td class="row row5">-</td>

                    <td class="row row6">-</td>
                </tr>
                <tr>
                    <td class="row row1">-</td>
                    <td class="row row2">-</td>
                    <td class="row row3" colspan="2">-</td>
                    <td class="row row4" colspan="2">-</td>
                    <td class="row row5">-</td>

                    <td class="row row6">-</td>
                </tr>

            </tbody>
        </table>

    </div>

</section>

<?= $this->endSection() ?>