<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

<script src="<?=URL_COMMON_ASSETS?>/main_Do.js?rnd=<?=rand();?>"> </script>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>

<!-- calendar ----------------------------  -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
<!-- js ----------------------------  -->

<section class="merright">
    <div class="main_boxowy mt20">
<!--        <div class="statusBox flexType2">-->
<!--            <div class="status">-->
<!--                <div class="aside upside flexType3">-->
<!--                    <p class="category">생산</p>-->
<!--                </div>-->
<!--                <div class="aside downside">-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">작업대기</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">공정중</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">공정완료</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="status">-->
<!--                <div class="aside upside flexType3">-->
<!--                    <p class="category">주문</p>-->
<!--                </div>-->
<!--                <div class="aside downside">-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">입금확인대기</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">작업대기</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">작업중</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="status">-->
<!--                <div class="aside upside flexType3">-->
<!--                    <p class="category">배송</p>-->
<!--                </div>-->
<!--                <div class="aside downside">-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">발송예정</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">금일발송완료</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">발송완료지연</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="status">-->
<!--                <div class="aside upside flexType3">-->
<!--                    <p class="category">클레임</p>-->
<!--                </div>-->
<!--                <div class="aside downside">-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">취소</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">반품</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">교환</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flexType3">-->
<!--                        <p class="now">미수령 신고</p>-->
<!--                        <div class="right flexType2">-->
<!--                            <p class="count">0</p>-->
<!--                            <p class="unit">건</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="refreshBox flexType3">-->
<!--            <div class="left flexType2">-->
<!--                <p class="subtitle mr10">최근수집</p>-->
<!--                <p class="mr10">12:12</p>-->
<!--                <i class="fa-solid fa-rotate-right"></i>-->
<!--            </div>-->
<!--            <div class="right swich_boxli6 flexType2 ">-->
<!--                <i class="fa-regular fa-calendar" onclick="go_main();"></i>-->
<!--                <p class="binder"></p>-->
<!--                <i class="fa-solid fa-list" onclick="go_orderList();"></i>-->
<!--            </div>-->
<!--        </div>-->
        <div class="calBox">
            <div id="calendar"></div>

            <div id="app"></div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>