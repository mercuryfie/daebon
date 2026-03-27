<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<link rel="stylesheet" href="/assets/web/css/style_dashBoard.css?rnd=<?echo(rand()); ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="<?= URL_DASHBOARD_ASSETS?>/GaugeMeter.js"></script>
<script src="<?=URL_COMMON_ASSETS?>/dashBoard_Do.js?rnd=<?rand();?>"> </script>

<section class="merright">

<body>
    <div id="wrap">
        <header>
            <div class="hbox hbox1">
<!--                <p>logo</p>-->
                <img src="/assets/web/src/djlogo_white.png" alt="img" class="logo_img">
            </div>
            <!--                <p>EMERGENCY MESSAGE</p>-->
            <div class="hbox hbox2" id="" >
                <div class="msg_wrap " id="">
                    <div class="msg_box" id="notice">
                    </div>
                </div>
            </div>
            <div class="hbox hbox3" id="nowclock" name="nowclock">
                <p id="nowdate" name="nowdate"></p>
                <p id="nowtime" name="nowtime"></p>
                <p>🌞</p>
            </div>
        </header>
        <main>
            <div class="mbox mbox1">
                <!-- <p>logo5</p> -->
                <div class="mbox1-1">
                    <p>작업실 온 / 습도</p>
                    <div class="Preview tempbox">
                        <div
                            class="GaugeMeter no-scroll"
                            id="gm_tem"
                            data-percent="0"
                            data-size="100"
                            data-back="rgba(174,174,174,0.5)"
                            data-animate_gauge_colors="true"
                            data-animate_text_colors="true"
                            data-width="12"
                            data-label="온도"
                            data-style="Arch"
                            data-label_color="#fff"
                            data-append=""
                        ></div>
                        <div
                            class="GaugeMeter2"
                            id="gm_hum"
                            data-percent="0"
                            data-size="100"
                            data-theme="cyonblue"
                            data-back="rgba(174,174,174,0.5)"
                            data-animate_gauge_colors="true"
                            data-animate_text_colors="true"
                            data-width="12"
                            data-label="습도"
                            data-style="Arch"
                            data-label_color="#FFF"
                            data-append=""
                        ></div>
                    </div>
                </div>
                <div class="mboxb mbox3-2" id="cooldown" name="cooldown">
                    <p>택배 마감까지 남은 시간</p>
                    <ul class="flipul">
                        <li>롯데</li>
<!--                        <li>기타</li>-->
                    </ul>
<!--                    <div class="pagebox">-->
<!--                        <div class="pages"></div>-->
<!--                        <div class="pages"></div>-->
<!--                    </div>-->
                    <div class="clock">
                        <div class="flipper hours card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text"></div>
                            </div>
                            <div class="bottom">
                                <div class="text"></div>
                            </div>
                        </div>

                        <div class="flipper minutes card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text"></div>
                            </div>
                            <div class="bottom">
                                <div class="text"></div>
                            </div>
                        </div>

                        <div class="flipper seconds card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text"></div>
                            </div>
                            <div class="bottom">
                                <div class="text"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mbox mbox2">
                <!-- 탕전주문현황, 예비조제 주문현황  -->
                <div class="boxtwo mbox2-1 flexCol">
                    <div class="upside flexType4">
                        <div class="mbox2-1-1">
                            <p>주문 현황  (<span id="t_order" name="t_order">0</span>건)</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type1"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="쿠팡"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type3"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="지마켓"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type2"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="옥션"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type4"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="11번가"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type5"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="카카오"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type6"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="카페24"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p></p>
                            <div class="rightbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type8"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="스마트스토어"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type13"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="롯데On"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="type14"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="신세계몰"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-theme="White"
                                    data-append=""
                                >
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="type0"
                                        data-back="rgba(174,174,174,0.5)"
                                        data-label="수기주문"
                                        data-label_color="#FFF"
                                        data-size="60"
                                        data-style="Arch"
                                        data-width="8"
                                        data-showvalue="true"
                                        data-min="0"
                                        data-total="100"
                                        data-stripe="3"
                                        data-used="0"
                                        data-theme="White"
                                        data-append=""
                                >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="downside flexType2">
                        <div class="mbox2-1-1">
                            <p>생산 현황  (<span id="t_produce" name="t_produce">0</span>건)</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="p_ready"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="지시"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="p_ing"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="진행중"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="p_complete"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="완료"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                </div>
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p>배송 현황 (<span id="t_delivery" name="t_delivery">0</span>건)</p>
                            <div class="rightbox">
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="d_ready"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="지시"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="#23FFC8"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="d_ing"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="진행중"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="#23FFC8"
                                    data-append=""
                                >
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="d_compelete"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="배송시작"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="0"
                                    data-color="#95FF23"
                                    data-append=""
                                >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mbox mbox3">
                <div class="mboxb mbox3-1">
                    <ul class="weeklyul">
                        <li>주간 주문 건수</li>
                    </ul>
                    <div class="area area2 flexType3">
                        <div class="status">
                            <div class="status1-1">
                                <div class="statuscircle on"></div>
                                <p>이번주</p>
                            </div>
                            <div class="status1-3">
                                <div class="statuscircle standby"></div>
                                <p>지난주</p>
                            </div>
                        </div>
                        <ul class="counterul">
                            <li id="total_order" ></li>
                        </ul>
                    </div>
                    <div class="weekbox">
                        <canvas id="weekChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
        <section class="footer">
            <div class="fbox fbox1">
                <p>원자재 재고 현황</p>
                <div class="fbox1-1">
                    <div class="fcbox fcbox1 flexType5-1">
                        <div class="labelBox labelBox1 flexType5-1">
                            <p class="amount mr10">적정재고량</p>
                            <div class="fcircle fcircle1"></div>
                        </div>
                        <div class="labelBox labelBox2 flexType5-1">
                            <p class="amount mr10">현 재고량</p>
                            <div class="fcircle fcircle2"></div>
                        </div>
                        <p class="unit">(단위:g)</p>
                    </div>
                    <div class="fcbox fcbox2">
    <!--                    <p class="label">(단위:건)</p>-->
    <!--                    <canvas id="barChart"></canvas>-->
                        <canvas id="m_barChart"></canvas>
                    </div>
                    <div class="pagebox" id="material">
                    <?=$body['material_html'];?>
                    </div>
                </div>
            </div>

            <div class="fbox fbox2">
                <p>제품 재고 현황</p>
                <div class="fbox2-1">
                    <div class="fcbox fcbox1 flexType5-1">
                        <div class="labelBox labelBox1 flexType5-1">
                            <div class="fcircle fcircle1"></div>
                            <p class="amount mr10">적정재고량</p>
                        </div>
                        <div class="labelBox labelBox2 flexType5-1">
                            <div class="fcircle fcircle3"></div>
                            <p class="amount mr10">현 재고량</p>
                        </div>
                        <p class="unit">(단위:개 or g)</p>
                    </div>
                    <div class="fcbox fcbox2">
                        <canvas id="p_barChart"></canvas>
                    </div>
                    <div class="pagebox" id="goods">
                    <?=$body['product_html'];?>
                    </div>
            </div>
        </section>
    </div>
    </body>

</section>

<?= $this->endSection() ?>