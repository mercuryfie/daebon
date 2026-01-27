<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<link rel="stylesheet" href="/assets/web/css/style_dashBoard.css?rnd=<?echo(rand()); ?>">
<script src="<?=URL_COMMON_ASSETS?>/dashBoard_Do.js?rnd=<?rand();?>"> </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/GaugeMeter.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/gaugeandchart.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/flipcard_main.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/flipcard_dark.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/animation.js"></script>
<script src="<?= URL_DASHBOARD_ASSETS?>/weather.js"></script>

<script>
</script>

<section class="merright">

<body>
    <div id="wrap">
        <header>
            <div class="hbox hbox1">
                <p>logo</p>
            </div>
            <div class="hbox hbox2">
                <p>EMERGENCY MESSAGE</p>
            </div>
            <div class="hbox hbox3">
                <p>2025/01/01 THU</p>
                <p>09:00</p>
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
                            data-percent="26"
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
                            data-percent="58"
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
                <div class="mboxb mbox3-2">
                    <p>택배 마감까지 남은 시간</p>
                    <ul class="flipul">
                        <li>롯데</li>
                        <li>기타</li>
                    </ul>
                    <div class="pagebox">
                        <div class="pages"></div>
                        <div class="pages"></div>
                    </div>
                    <div class="clock">
                        <div class="flipper hours card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text">15</div>
                            </div>
                            <div class="bottom">
                                <div class="text">15</div>
                            </div>
                        </div>

                        <div class="flipper minutes card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text">00</div>
                            </div>
                            <div class="bottom">
                                <div class="text">00</div>
                            </div>
                        </div>

                        <div class="flipper seconds card">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text">00</div>
                            </div>
                            <div class="bottom">
                                <div class="text">00</div>
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
                            <p>주문 현황</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_1"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_2"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_3"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_4"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_5"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_6"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p></p>
                            <div class="rightbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_7"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="네이버"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_8"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="스마트스"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_9"
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
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="gm_market_10"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="SSG"
                                    data-label_color="#FFF"
                                    data-size="60"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="gm_market_11"
                                        data-back="rgba(174,174,174,0.5)"
                                        data-label="오아시스"
                                        data-label_color="#FFF"
                                        data-size="60"
                                        data-style="Arch"
                                        data-width="8"
                                        data-showvalue="true"
                                        data-min="0"
                                        data-total="100"
                                        data-stripe="3"
                                        data-used="80"
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="downside flexType2">
                        <div class="mbox2-1-1">
                            <p>진행 현황</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_113"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="생산현황"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_114"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="발송완료"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_115"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="발송지연"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="rgb(119 90 248)"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p>클레임</p>
                            <div class="rightbox">
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_116"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="취소"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="#23FFC8"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_117"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="반품"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="#23FFC8"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="GaugeMeter_118"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="교환"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="#95FF23"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                    class="GaugeMeter4 gaugapapa"
                                    id="gm_117"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="미수령"
                                    data-label_color="#FFF"
                                    data-size="70"
                                    data-style="Arch"
                                    data-width="8"
                                    data-showvalue="true"
                                    data-min="0"
                                    data-total="100"
                                    data-stripe="3"
                                    data-used="80"
                                    data-color="#95FF23"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
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
                            <li id="counter">200</li>
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
                    <div class="fcbox fcbox1 flexCol3">
                        <div class="labelBox labelBox1 flexType5-1">
                            <p class="amount mr10">적정재고수량</p>
                            <div class="fcircle fcircle1"></div>
                        </div>
                        <div class="labelBox labelBox2 flexType5-1">
                            <p class="amount mr10">현 재고량</p>
                            <div class="fcircle fcircle2"></div>
                        </div>
                        <p class="unit">(단위:%)</p>
                    </div>
                    <div class="fcbox fcbox2">
    <!--                    <p class="label">(단위:건)</p>-->
    <!--                    <canvas id="barChart"></canvas>-->
                        <canvas id="m_barChart"></canvas>
                    </div>
                    <div class="pagebox">
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>

                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                    </div>
                </div>
            </div>

            <div class="fbox fbox2">
                <p>제품 재고 현황</p>
                <div class="fbox2-1">
                    <div class="fcbox fcbox1 flexCol3">
                        <div class="labelBox labelBox1 flexType5-1">
                            <p class="amount mr10">적정재고수량</p>
                            <div class="fcircle fcircle1"></div>
                        </div>
                        <div class="labelBox labelBox2 flexType5-1">
                            <p class="amount mr10">현 재고량</p>
                            <div class="fcircle fcircle3"></div>
                        </div>
                        <p class="unit">(단위:%)</p>
                    </div>
                    <div class="fcbox fcbox2">
                        <canvas id="p_barChart"></canvas>
                    </div>
                    <div class="pagebox">
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>

                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                        <div class="pages"></div>
                    </div>
            </div>
        </section>
    </div>
    </body>

</section>

<?= $this->endSection() ?>