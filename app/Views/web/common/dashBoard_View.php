<?= $this->extend("/web/template/layout_workpage") ?>
<?= $this->section("content") ?>

    <script src="<?=URL_COMMON_ASSETS?>/dashBoard_Do.js?rnd=<?rand();?>"> </script>

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
        <div class="dashBoard_boxowy">
            <div class="refreshBox flexType2">
                <p class="subtitle mr10">최근수집</p>
                <div class="flexType2">
                    <p class="mr10">12:12</p>
                    <i class="fa-solid fa-rotate-right"></i>
                </div>
            </div>
            <div class="statusBox flexType2">
                <div class="status">
                    <div class="aside upside flexType3">
                        <p class="category">주문</p>
<!--                        <div class="right flexType1">-->
<!--                            <p class="mr10">12:12</p>-->
<!--                            <i class="fa-solid fa-rotate-right"></i>-->
<!--                        </div>-->
                    </div>
                    <div class="aside downside">
                        <div class="flexType3">
                            <p class="now">입금대기</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">신규주문</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">입금대기</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">입금대기</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="status">
                    <div class="aside upside flexType3">
                        <p class="category">배송</p>
<!--                        <div class="right flexType1">-->
<!--                            <p class="mr10">12:12</p>-->
<!--                            <i class="fa-solid fa-rotate-right"></i>-->
<!--                        </div>-->
                    </div>
                    <div class="aside downside">
                        <div class="flexType3">
                            <p class="now">발송예정</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">배송중</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">배송완료</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">배송완료 지연</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="status">
                    <div class="aside upside flexType3">
                        <p class="category">클레임</p>
<!--                        <div class="right flexType1">-->
<!--                            <p class="mr10">12:12</p>-->
<!--                            <i class="fa-solid fa-rotate-right"></i>-->
<!--                        </div>-->
                    </div>
                    <div class="aside downside">
                        <div class="flexType3">
                            <p class="now">취소요청</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">반품요청</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">교환요청</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">미수령 신고</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="status">
                    <div class="aside upside flexType3">
                        <p class="category">정산</p>
<!--                        <div class="right flexType1">-->
<!--                            <p class="mr10">12:12</p>-->
<!--                            <i class="fa-solid fa-rotate-right"></i>-->
<!--                        </div>-->
                    </div>
                    <div class="aside downside">
                        <div class="flexType3">
                            <p class="now">정산예정</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>
                        <div class="flexType3">
                            <p class="now">정산완료</p>
                            <div class="right flexType2">
                                <p class="count">0</p>
                                <p class="unit">건</p>
                            </div>
                        </div>

                    </div>
                </div>
    
            </div>
            <div class="swich_boxli6 ">
                <i class="fa-regular fa-calendar" onclick="go_dashboard();"></i>
                <p class="binder"></p>
                <i class="fa-solid fa-list" onclick="go_orderList();"></i>
            </div>
            <div class="calBox">
                <div id="calendar"></div>

                <div id="app"></div>
            </div>
        </div>

    </section>

<?= $this->endSection() ?>