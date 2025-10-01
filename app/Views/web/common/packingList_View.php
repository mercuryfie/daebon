<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/dashBoard_Do.js"> </script>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>

<!-- calendar ----------------------------  -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
<!-- js ----------------------------  -->
<!--    <script src="--><?php //=URL_MASTER_ASSETS?><!--/burkOrderForm_Do.js?rnd=--><?php //= rand(); ?><!--"></script>-->
<script>
</script>

<section class="merright">
    <div class="packing_wraph1c">
        <div class="titleBox">
            <p class="headTitle">
                포장발송화면
            </p>
            <input type="search"
                   class="inputType520 ml20"
                   placeholder="작업지시서 번호를 입력하십시오" name="" id="">
        </div>
        <div class="areaBox">
            <div class="area1">
                <div class="innerBox">
                    <div class="status flexType3">
                        <p class="title">대기</p>
                        <p class="title">20건</p>
                    </div>
                    <div class="status flexType3">
                        <p class="title">완료</p>
                        <p class="title">20건</p>
                    </div>
                </div>
            </div>
            <div class="area area5  ">
                <p class='title mb10'>작업상태</p>
            </div>
            <div class="area4 packing_boxfxp">
                <table class="">
                    <thead>
                    <tr>
                        <td class="ltThead productNo checkCol"></td>
                        <td class="ltThead productNo">주문번호</td>
                        <td class="ltThead productNo">상품명</td>
                        <td class="ltThead productNo">판매자ID</td>

                        <td class="ltThead productNo">수령인</td>
                        <td class="ltThead productNo">수량</td>
                        <td class="ltThead productNo">작업등록일</td>
                        <td class="ltThead productNo">비고</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="ltTbody">
                            1
                        </td>
                        <td class="ltTbody">
                            <a href="#" class="hoverGreen" onclick="go_packingStatus();">13241234</a>
                        </td>
                        <td class="ltTbody">원물볶음차-</td>
                        <td class="ltTbody">daebon</td>
                        <td class="ltTbody">홍길동</td>


                        <td class="ltTbody">1</td>
                        <td class="ltTbody">2025.01.01</td>
                        <td class="ltTbody">-</td>
                    </tr>
                    <tr>
                        <td class="ltTbody">
                            2
                        </td>
                        <td class="ltTbody">
                            <a href="#" class="hoverGreen" onclick="go_packingStatus();">13241234</a>
                        </td>
                        <td class="ltTbody">원물볶음차-</td>
                        <td class="ltTbody">daebon</td>
                        <td class="ltTbody">홍길동</td>


                        <td class="ltTbody">1</td>
                        <td class="ltTbody">2025.01.01</td>
                        <td class="ltTbody">-</td>
                    </tr>
                    <tr>
                        <td class="ltTbody">
                            3
                        </td>
                        <td class="ltTbody">
                            <a href="#" class="hoverGreen" onclick="go_packingStatus();">13241234</a>
                        </td>
                        <td class="ltTbody">원물볶음차-</td>
                        <td class="ltTbody">daebon</td>
                        <td class="ltTbody">홍길동</td>


                        <td class="ltTbody">1</td>
                        <td class="ltTbody">2025.01.01</td>
                        <td class="ltTbody">-</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>