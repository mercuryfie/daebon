let materialChart;
let weekChart;
let goodsChart;
let $m_pages;
let m_totalPages;
let m_currentPage = 0;
let $g_pages;
let g_totalPages;
let g_currentPage = 0;

$(document).ready(function() {
    start_realtime_clock();
    start_delivery_cooldown();
    Start_Notice();

    initChart();
    Set_Weather();
    Set_Data();
    refreshWeekChart();
    refreshMaterialChart();
    refreshGoodsChart();

});


function initChart() {

    $(".GaugeMeter").gaugeMeter({theme: 'pink',color: '#FF5894'});
    $(".GaugeMeter2").gaugeMeter({theme: 'cyonblue',color: '#41F3F5'});
    $(".GaugeMeter3").gaugeMeter({theme: 'green',color: '#6AF288'});
    $(".GaugeMeter4").gaugeMeter({theme: 'red',color: 'red'});

    const w_dom = $('#weekChart')[0].getContext('2d');
    weekChart = new Chart(w_dom, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: '# of this week',
                    data: [],
                    tension:0.4,
                    borderWidth: 5,
                    borderColor:'#6AF288',
                    pointBorderColor: 'white',
                    pointWidth:5,
                    pointRadius: 5,
                    pointBorderWidth: 2,
                    pointBackgroundColor: '#6AF288'
                },
                {
                    label: '# of last week',
                    data: [],
                    tension:0.4,
                    borderWidth: 5,
                    borderColor: '#ccc',
                    pointBorderColor: 'white',
                    pointRadius: 5,
                    pointBorderWidth: 2,
                    pointBackgroundColor: '#ccc'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {display: true},
                    legend: {display:false,labels: {color:'red'},data: {color:'white'}
                }
            },
            scales: {
                x: {
                    ticks: {color:'#ececec'},grid: {color: '#5c5c5c'}
                },
                y: {
                    beginAtZero: false,
                    min:100,
                    max:700,
                    ticks: {color:'#ececec'},
                    grid: {color: '#5c5c5c'}
                }
            },
            animations: {
                y: {
                    easing: 'easeInOutElastic',
                    from: (ctx) => {
                        if (ctx.type === 'data') {
                            if (ctx.mode === 'default' && !ctx.dropped) {
                                ctx.dropped = true;
                                return 0;
                            }
                        }
                    }
                }
            }
        }
    });

    const m_dom = $('#m_barChart')[0].getContext('2d');
    materialChart = new Chart(m_dom, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: '적정재고',
                    data: [0,0,0,0,0,0,0,0,0,0], // 초기값
                    backgroundColor: 'rgba(236,236,236,0.5)',
                    borderWidth: 0,
                    indexAxis: 'y'
                },
                {
                    label: '현재재고',
                    data: [0,0,0,0,0,0,0,0,0,0], // 초기값
                    backgroundColor: 'rgba(106,242,136,0.8)',
                    borderColor: 'rgba(106,242,136,0.8)',
                    borderWidth: 1,
                    indexAxis: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: { ticks: { color: '#ececec' }, grid: { color: '#5c5c5c' }, max: 450 },
                y: { ticks: { color: '#ececec' }, grid: { color: '#5c5c5c' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    const g_dom = $('#p_barChart')[0].getContext('2d');
    goodsChart = new Chart(g_dom, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: '적정재고',
                    data: [0,0,0,0,0,0,0,0,0,0], // 초기값
                    backgroundColor: 'rgba(236,236,236,0.5)',
                    borderWidth: 0,
                    indexAxis: 'y'
                },
                {
                    label: '현재재고',
                    data: [0,0,0,0,0,0,0,0,0,0], // 초기값
                    backgroundColor: 'rgba(106,242,136,0.8)',
                    borderColor: 'rgba(106,242,136,0.8)',
                    borderWidth: 1,
                    indexAxis: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: { ticks: { color: '#ececec' }, grid: { color: '#5c5c5c' }, max: 450 },
                y: { ticks: { color: '#ececec' }, grid: { color: '#5c5c5c' } }
            },
            plugins: { legend: { display: false } }
        }
    });

}


function Set_Data(){
    let type0 = 0;
    let type1 = 0;
    let type2 = 0;
    let type3 = 0;
    let type4 = 0;
    let type5 = 0;
    let type6 = 0;
    let type8 = 0;
    let type13 = 0;
    let type14 = 0;
    let totalOrder = 0;
    let p_ready = 0;
    let p_ing= 0;
    let p_complete = 0;
    let totalProduce = 0;
    let d_ready = 0;
    let d_ing= 0;
    let d_complete = 0;
    let totalDelivery = 0;

    async function update() {
        let arr = await Load_Data();
        console.log(arr);
        if (arr && typeof arr === 'object' && !Array.isArray(arr)) {
            org_temp = Number(arr.temperature);
            start_temp = (org_temp < 0) ? 0 : getPercentage(org_temp, 100);
            org_hum = Number(arr.humidity);
            start_hum = (org_hum < 0) ? 0 : getPercentage(org_hum, 100);

            type0 = arr.order.o_list.type0;
            type1 = arr.order.o_list.type1;
            type2 = arr.order.o_list.type2;
            type3 = arr.order.o_list.type3;
            type4 = arr.order.o_list.type4;
            type5 = arr.order.o_list.type5;
            type6 = arr.order.o_list.type6;
            type8 = arr.order.o_list.type8;
            type13 = arr.order.o_list.type13;
            type14 = arr.order.o_list.type14;
            totalOrder = arr.order.o_tcnt;

            p_ready = arr.produce.p_list.p_ready;
            p_ing = arr.produce.p_list.p_ing;
            p_complete = arr.produce.p_list.p_complete;
            totalProduce = arr.produce.p_tcnt;

            d_ready = arr.delivery.d_list.d_ready;
            d_ing = arr.delivery.d_list.d_ing;
            d_complete = arr.delivery.d_list.d_complete;
            totalDelivery = arr.delivery.d_tcnt;
        }


        $('#type1').data('used', type1);
        $('#type3').data('used', type3);
        $('#type2').data('used', type2);
        $('#type4').data('used', type4);
        $('#type5').data('used', type5);
        $('#type6').data('used', type6);
        $('#type8').data('used', type8);
        $('#type13').data('used', type13);
        $('#type14').data('used', type14);
        $('#type0').data('used', type0);

        $('#t_order').text(totalOrder);
        $('#total_order').text(totalOrder);

        $('#p_ready').data('used', p_ready);
        $('#p_ing').data('used', p_ing);
        $('#p_complete').data('used', p_complete);
        $('#t_produce').text(totalProduce);

        $('#d_ready').data('used', d_ready);
        $('#d_ing').data('used', d_ing);
        $('#d_complete').data('used', d_complete);
        $('#t_delivery').text(totalDelivery);

        $(".GaugeMeter3").gaugeMeter({theme: 'green', color: '#6AF288'});
        $(".GaugeMeter4").gaugeMeter({theme: 'red', color: 'red'});

        console.log("주문현황 업데이트");
    }


    update();
    setInterval(update, 10000);

}

function Set_Weather(){
    let org_temp = 0;
    let org_hum = 0;
    let start_temp = 0;
    let start_hum = 0;

    async function update() {
        let arr = await Load_Weather();
        console.log(arr);
        if (arr && typeof arr === 'object' && !Array.isArray(arr)) {
            org_temp = Number(arr.temperature);
            start_temp = (org_temp < 0) ? 0 : getPercentage(org_temp, 100);
            org_hum = Number(arr.humidity);
            start_hum = (org_hum < 0) ? 0 : getPercentage(org_hum, 100);
        }

        $('#gm_tem').data('percent', Math.round(start_temp));
        $('#gm_hum').data('percent', Math.round(start_hum));

        $(".GaugeMeter").gaugeMeter({theme: 'pink', color: '#FF5894'});
        $(".GaugeMeter2").gaugeMeter({theme: 'cyonblue', color: '#41F3F5'});
        console.log("날씨 업데이트");
    }

    update();
    setInterval(update, 600000);
}

async function Start_Notice() {
    let rollingIndex = 0;
    const rowHeight = 40;
    let totalItems = await Load_Notice();

    const rollingInterval = setInterval(function () {
        rollingIndex++;
            if (rollingIndex >= totalItems) {
            $('.msg_box').css('top', '0px');
            rollingIndex = 1;

            $('.msg_box').animate({
                top: -(rollingIndex * rowHeight) + 'px'
            }, 500);
        } else {
            $('.msg_box').animate({
                top: -(rollingIndex * rowHeight) + 'px'
            }, 500);
        }
    }, 5000);

    console.log("공지 업데이트");
    setInterval(function() {
        Load_Notice();
    }, 100000);
}

async function refreshWeekChart() {
    function update() {
        if (weekChart) {
            weekChart.data.labels = ['월', '화', '수', '목', '금', '토', '일'];

            weekChart.data.datasets[0].data = Array.from({length: 7}, () => Math.floor(Math.random() * 300) + 300);
            weekChart.data.datasets[1].data = Array.from({length: 7}, () => Math.floor(Math.random() * 300) + 200);
            weekChart.update();

            weekChart.update();
            console.log("주간 현황 차트 업데이트");
        }
    }

    update();
    setInterval(update, 10000);
}


async function refreshMaterialChart() {
    $m_pages = $('#material .pages');
    m_totalPages = $m_pages.length;

    function update() {
        if (!$m_pages || m_totalPages === 0) {
            $m_pages = $('#material .pages');
            m_totalPages = $m_pages.length;
        }
        if (m_currentPage >= m_totalPages) {
            m_currentPage = 0;
        }
        $m_pages.removeClass('active').css('background-color', 'transparent');
        const $target = $m_pages.eq(m_currentPage);
        $target.addClass('active').css('background-color', '#6af288');

        let pageNum = $target.data('page');

        if (materialChart) {
            //let arr = await Load_Material(pageNum,m_totalPages);


            const newLabels = ['전체', '결명자', '계피', '구기자', '노니', '당귀', '대추', '도꼬마리', '도라지', '돼지감자'];
            materialChart.data.labels = newLabels;

            // 랜덤 데이터 주입 (테스트용)
            materialChart.data.datasets[0].data = Array.from({length: 10}, () => Math.floor(Math.random() * 100) + 150);
            materialChart.data.datasets[1].data = Array.from({length: 10}, () => Math.floor(Math.random() * 200));

            materialChart.update();
        }
        m_currentPage++;
        console.log("원자재현황 차트 업데이트");
    }

    update();
    setInterval(update, 10000);
}

async function refreshGoodsChart() {
    $g_pages = $('#goods .pages');
    g_totalPages = $g_pages.length;

    function update() {
        if (!$g_pages || g_totalPages === 0) {
            $g_pages = $('#goods .pages');
            g_totalPages = $g_pages.length;
        }
        if (g_currentPage >= g_totalPages) {
            g_currentPage = 0;
        }

        $g_pages.removeClass('active').css('background-color', 'transparent');
        const $target = $g_pages.eq(g_currentPage);
        $target.addClass('active').css('background-color', '#6af288');

        let pageNum = $target.data('page');
        if (goodsChart) {
            //let arr = await Load_Material(pageNum,m_totalPages);
            const newLabels = ['전체', '결명자', '계피', '구기자', '노니', '당귀', '대추', '도꼬마리', '도라지', '돼지감자'];
            goodsChart.data.labels = newLabels;

            // 랜덤 데이터 주입 (테스트용)
            goodsChart.data.datasets[0].data = Array.from({length: 10}, () => Math.floor(Math.random() * 100) + 150);
            goodsChart.data.datasets[1].data = Array.from({length: 10}, () => Math.floor(Math.random() * 200));

            goodsChart.update();
        }
        g_currentPage++;
        console.log("재품재고 차트 업데이트");
    }
    update();
    setInterval(update, 10000);
}

async function Load_Material(page,total){
    let data = {};
    try {
        let dataarr = {page:page,total:total};
        let url = APIURL + '/Load_DashBoard_Material';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
    return data;
}


async function Load_Data(){
    let data = {};
    try {
        let dataarr = {};
        let url = APIURL + '/Load_DashBoard_Info';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
    return data;
}

async function Load_Weather(){
    let data = {};
    try {
        let dataarr = {};
        let url = APIURL + '/Load_DashBoard_Weather';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
    return data;
}

async function Load_Notice(){
    let n_Cnt = 0;
    try {
        let dataarr = {};
        let url = APIURL + '/Load_DashBoard_Notice';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            let notice = result.get('data').list;
            n_Cnt = notice.length;
            let n_html = '';
            if (n_Cnt > 0) {
                $.each(notice, function (index, el) {
                    n_html += `<p class="data data${index + 1}">${el}</p> `
                });
                $('#notice').empty().append(n_html);
            }
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
    return n_Cnt;
}

function start_realtime_clock() {
    // 요일 배열 (오늘 날짜인 2026/02/11 수요일에 맞춰 WED가 나옵니다)
    const weekDays = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

    function update() {
        const now = new Date();

        // 1. 날짜 데이터 추출 (YYYY/MM/DD 요일)
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const week = weekDays[now.getDay()];

        // 2. 시간 데이터 추출 (HH:mm:ss)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        // 3. 낮/밤 아이콘 설정 (오후 6시 이후 달 아이콘)
        const icon = (now.getHours() >= 18 || now.getHours() < 6) ? '🌙' : '🌞';

        // 4. ID를 이용해 HTML에 반영
        $('#nowdate').text(`${year}/${month}/${day} ${week}`);
        $('#nowtime').text(`${hours}:${minutes}:${seconds}`);
        $('#nowclock p').last().text(icon);
    }

    // 초기 실행 후 1초 간격으로 반복
    update();
    setInterval(update, 1000);
}


function start_delivery_cooldown() {
    let myhour = $(".clock .flipper:nth-child(1) div:not(.new) .text");
    let myminute = $(".clock .flipper:nth-child(2) div:not(.new) .text");
    let mysecond = $(".clock .flipper:nth-child(3) div:not(.new) .text");

    function update() {
        $(".flipper").removeClass("flipping");
        $(".flipper .new").remove();

        let now = new Date();
        let target = new Date();
        target.setHours(18, 0, 0, 0);
        let diff = target - now;
        let hour, minutes, seconds;
        if (diff <= 0) {
            hour = "00";
            minutes = "00";
            seconds = "00";
        } else {
            let totalSeconds = Math.floor(diff / 1000);
            let h = Math.floor(totalSeconds / 3600);
            let m = Math.floor((totalSeconds % 3600) / 60);
            let s = totalSeconds % 60;
            hour = h.toString().padStart(2, "0");
            minutes = m.toString().padStart(2, "0");
            seconds = s.toString().padStart(2, "0");
        }

        if ($(myhour[0]).text() !== hour) flipNumber($(myhour[0]).closest(".flipper"), hour);
        if ($(myminute[0]).text() !== minutes) flipNumber($(myminute[0]).closest(".flipper"), minutes);
        if ($(mysecond[0]).text() !== seconds) flipNumber($(mysecond[0]).closest(".flipper"), seconds);
    }

    update();
    setInterval(update, 500);
}

function flipNumber(el, newnumber) {
    let thistop = el.find(".top").clone();
    let thisbottom = el.find(".bottom").clone();
    thistop.addClass("new");
    thisbottom.addClass("new");
    thisbottom.find(".text").text(newnumber);
    el.find(".top").after(thistop);
    el.find(".top.new").append(thisbottom);
    el.addClass("flipping");
    el.find(".top:not(.new)").find(".text").text(newnumber);
    setTimeout(function () {
        el.find(".bottom:not(.new)").find(".text").text(newnumber);
    }, 500);
}
