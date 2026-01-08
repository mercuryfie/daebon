<?= $this->extend("/web/template/layout_none") ?>
<?= $this->section("content") ?>

<link rel="stylesheet" href="/assets/web/css/style_dashBoard.css">
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
                            id="GaugeMeter_101"
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
                            id="GaugeMeter_102"
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
                        <div class="flipper hours">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text">15</div>
                            </div>
                            <div class="bottom">
                                <div class="text">15</div>
                            </div>
                        </div>

                        <div class="flipper minutes">
                            <div class="gear"></div>
                            <div class="gear"></div>
                            <div class="top">
                                <div class="text">00</div>
                            </div>
                            <div class="bottom">
                                <div class="text">00</div>
                            </div>
                        </div>

                        <div class="flipper seconds">
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
                    <div class="upside flexType2">
                        <div class="mbox2-1-1">
                            <p>생산 현황</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="GaugeMeter_103"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="작업대기"
                                    data-label_color="#FFF"
                                    data-size="70"
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
                                        id="GaugeMeter_104"
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
                                        data-used="80"
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_105"
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
                                        data-used="80"
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <!--                            <div-->
                                <!--                                class="GaugeMeter7"-->
                                <!--                                id="GaugeMeter_109"-->
                                <!--                                data-percent="70"-->
                                <!--                                data-append=""-->
                                <!--                                data-size="60"-->
                                <!--                                data-theme="Purple"-->
                                <!--                                data-back="rgba(174,174,174,0.5)"-->
                                <!--                                data-animate_gauge_colors="true"-->
                                <!--                                data-animate_text_colors="true"-->
                                <!--                                data-width="9"-->
                                <!--                                data-label="자보"-->
                                <!--                                data-style="Arch"-->
                                <!--                                data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter7"-->
                                <!--                                    id="GaugeMeter_110"-->
                                <!--                                    data-percent="60"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="Purple"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="기타"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p>주문 현황</p>
                            <div class="rightbox">
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_106"
                                        data-back="rgba(174,174,174,0.5)"
                                        data-label="결제대기"
                                        data-label_color="#FFF"
                                        data-size="70"
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
                                        id="GaugeMeter_107"
                                        data-back="rgba(174,174,174,0.5)"
                                        data-label="포장대기"
                                        data-label_color="#FFF"
                                        data-size="70"
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
                                        id="GaugeMeter_108"
                                        data-back="rgba(174,174,174,0.5)"
                                        data-label="포장중"
                                        data-label_color="#FFF"
                                        data-size="70"
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
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_111"-->
                                <!--                                    data-percent="90"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="공진단"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_112"-->
                                <!--                                    data-percent="70"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="경옥고"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_113"-->
                                <!--                                    data-percent="60"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="다이어트"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_114"-->
                                <!--                                    data-percent="50"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="약속・탕약"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_115"-->
                                <!--                                    data-percent="40"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="기타"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="downside flexType2">

                        <div class="mbox2-1-1">
                            <p>발송 현황</p>
                            <div class="leftbox">
                                <div
                                    class="GaugeMeter3 gaugapapa"
                                    id="GaugeMeter_109"
                                    data-back="rgba(174,174,174,0.5)"
                                    data-label="발송대기"
                                    data-label_color="#FFF"
                                    data-size="70"
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
                                    id="GaugeMeter_110"
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
                                    data-theme="White"
                                    data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_111"
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
                                        data-theme="greenRed"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <!--                            <div-->
                                <!--                                class="GaugeMeter7"-->
                                <!--                                id="GaugeMeter_109"-->
                                <!--                                data-percent="70"-->
                                <!--                                data-append=""-->
                                <!--                                data-size="60"-->
                                <!--                                data-theme="Purple"-->
                                <!--                                data-back="rgba(174,174,174,0.5)"-->
                                <!--                                data-animate_gauge_colors="true"-->
                                <!--                                data-animate_text_colors="true"-->
                                <!--                                data-width="9"-->
                                <!--                                data-label="자보"-->
                                <!--                                data-style="Arch"-->
                                <!--                                data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter7"-->
                                <!--                                    id="GaugeMeter_110"-->
                                <!--                                    data-percent="60"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="Purple"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="기타"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                            </div>
                        </div>
                        <div class="mbox2-1-2">
                            <p>클레임</p>
                            <div class="rightbox">
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_112"
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
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_113"
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
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_114"
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
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <div
                                        class="GaugeMeter3 gaugapapa"
                                        id="GaugeMeter_115"
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
                                        data-theme="White"
                                        data-append=""
                                >
                                    <p class="line1-1">200</p>
                                </div>
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_111"-->
                                <!--                                    data-percent="90"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="공진단"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_112"-->
                                <!--                                    data-percent="70"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="경옥고"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_113"-->
                                <!--                                    data-percent="60"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="다이어트"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_114"-->
                                <!--                                    data-percent="50"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="약속・탕약"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                                <!--                            <div-->
                                <!--                                    class="GaugeMeter8"-->
                                <!--                                    id="GaugeMeter_115"-->
                                <!--                                    data-percent="40"-->
                                <!--                                    data-append=""-->
                                <!--                                    data-size="60"-->
                                <!--                                    data-theme="DarkGreen-LightGreen"-->
                                <!--                                    data-back="rgba(174,174,174,0.5)"-->
                                <!--                                    data-animate_gauge_colors="true"-->
                                <!--                                    data-animate_text_colors="true"-->
                                <!--                                    data-width="9"-->
                                <!--                                    data-label="기타"-->
                                <!--                                    data-style="Arch"-->
                                <!--                                    data-label_color="#FFF"-->
                                <!--                            >-->
                                <!--                                <p class="line1-1">200</p>-->
                                <!--                            </div>-->
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="boxtwo mbox2-2">-->
<!--                    <div class="moonleft">-->
<!--                        <div class="moon1-1">-->
<!--                            <p>전체 진척도</p>-->
<!--                            <div class="barbox">-->
<!--                                <canvas id="barChart"></canvas>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="moon1-2">-->
<!--                            <p>작업 시간 평균</p>-->
<!--                            <div class="cardbox">-->
<!--                                <div class="cardbox1">-->
<!--                                    <div class="cardbox1-1">-->
<!--                                        <p>조제</p>-->
<!--                                        <p>5</p>-->
<!--                                        <span>초</span>-->
<!--                                    </div>-->
<!--                                    <div class="cardbox1-2">-->
<!--                                        <p>탕전</p>-->
<!--                                        <p>180</p>-->
<!--                                        <span>분</span>-->
<!--                                    </div>-->
<!--                                </div> -->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="moonright">-->
<!--                        <p>전체 작업 현황</p>-->
<!--                        <div class="radarbox">-->
<!--                            <canvas id="radarChart"></canvas>-->
<!--                        </div>-->
<!--                        <div class="radar-status">-->
<!--                            <div class="status1-1">-->
<!--                                <div class="statuscircle parcel1"></div>-->
<!--                                <p>전체</p>-->
<!--                            </div>-->
<!--                            <div class="status1-2">-->
<!--                                <div class="statuscircle parcel2"></div>-->
<!--                                <p>로젠</p>-->
<!--                            </div>-->
<!--                            <div class="status1-3">-->
<!--                                <div class="statuscircle parcel3"></div>-->
<!--                                <p>기타</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

            </div>
            <div class="mbox mbox3">
                <div class="mboxb mbox3-1">
                    <ul class="weeklyul">
                        <li>주간 주문 건수</li>
                    </ul>
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
                    <div class="fcbox fcbox1">
                        <div class="fcircle fcircle1"></div>
                        <p>적정재고수량</p>
                    </div>
                    <div class="fcbox fcbox2">
                        <div class="fcircle fcircle2"></div>
                        <p>현 재고량</p>
                    </div>
                </div>
                <div class="fbox1-2">
                    <p>(단위:건)</p>
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

            <div class="fbox fbox2">
                <p>제품 재고 현황</p>
                <div class="fbox2-1">
                    <div class="fcbox fcbox1">
                        <div class="fcircle fcircle1"></div>
                        <p>적정재고수량</p>
                    </div>
                    <div class="fcbox fcbox2">
                        <div class="fcircle fcircle3"></div>
                        <p>현 재고량</p>
                    </div>
                </div>
                <div class="fbox2-2">
                    <p>(단위:건)</p>
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