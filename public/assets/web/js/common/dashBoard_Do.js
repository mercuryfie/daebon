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
    const interval_info = 300000;
    const interval_material = 4000;
    const interval_goods = 4000;
    const interval_week = 3000;


    start_realtime_clock();

    initChart();
    Set_Data();
    Set_Notice();
    refreshMaterialChart();
    refreshWeekChart();
    refreshGoodsChart();

    setInterval(Set_Data, interval_info);
    setInterval(refreshMaterialChart, interval_material);
    setInterval(refreshWeekChart, interval_week);
    setInterval(refreshGoodsChart, interval_goods);
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



async function refreshWeekChart() {
    if (weekChart) {
        weekChart.data.labels = ['월', '화', '수', '목', '금', '토', '일'];

        weekChart.data.datasets[0].data = Array.from({length: 7}, () => Math.floor(Math.random() * 300) + 300);
        weekChart.data.datasets[1].data = Array.from({length: 7}, () => Math.floor(Math.random() * 300) + 200);
        weekChart.update();

        weekChart.update();
        console.log("주간 현황 차트 업데이트 완료");
    }
}


async function refreshMaterialChart() {
    $m_pages = $('#material .pages');
    m_totalPages = $m_pages.length;

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
    console.log("nowmaterialpage : ", pageNum);

    if (materialChart) {
        //let arr = await Load_Material(pageNum,m_totalPages);


        const newLabels = ['전체','결명자','계피','구기자','노니','당귀','대추','도꼬마리','도라지','돼지감자'];
        materialChart.data.labels = newLabels;

        // 랜덤 데이터 주입 (테스트용)
        materialChart.data.datasets[0].data = Array.from({length: 10}, () => Math.floor(Math.random() * 100) + 150);
        materialChart.data.datasets[1].data = Array.from({length: 10}, () => Math.floor(Math.random() * 200));

        materialChart.update();
    }
    m_currentPage++;
}

async function refreshGoodsChart() {
    $g_pages = $('#goods .pages');
    g_totalPages = $g_pages.length;
    console.log("total=" + g_totalPages);

    if (!$g_pages || g_totalPages === 0) {
        $g_pages = $('#goods .pages');
        g_totalPages = $g_pages.length;
    }
    if (g_currentPage >= g_totalPages) {
        g_currentPage = 0;
    }

    console.log("current=" + g_currentPage);

    $g_pages.removeClass('active').css('background-color', 'transparent');
    const $target = $g_pages.eq(g_currentPage);
    $target.addClass('active').css('background-color', '#6af288');

    let pageNum = $target.data('page');
    console.log("nowgoodspage : ", pageNum);

    if (goodsChart) {
        //let arr = await Load_Material(pageNum,m_totalPages);


        const newLabels = ['전체','결명자','계피','구기자','노니','당귀','대추','도꼬마리','도라지','돼지감자'];
        goodsChart.data.labels = newLabels;

        // 랜덤 데이터 주입 (테스트용)
        goodsChart.data.datasets[0].data = Array.from({length: 10}, () => Math.floor(Math.random() * 100) + 150);
        goodsChart.data.datasets[1].data = Array.from({length: 10}, () => Math.floor(Math.random() * 200));

        goodsChart.update();
    }
    g_currentPage++;
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



function Set_Notice(){
    let rollingIndex = 0;
    setInterval(function () {
        rollingIndex++;
        if (rollingIndex > 2) {
            rollingIndex = 0;
            $('.msg_box').css('top', '0px');
            setTimeout(function() {
                rollingIndex = 1;
                $('.msg_box').animate({
                    top: '-40px'
                }, 500);
            }, 50);
        } else {
            $('.msg_box').animate({
                top: -(rollingIndex * 40) + 'px'
            }, 500);
        }
    }, 5000);
}




async function Set_Data(){
    let org_temp = 0;
    let org_hum = 0;
    let start_temp = 0;
    let start_hum = 0;
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
    let notice = '';

    let arr = await Load_Data();
    console.log(arr);
    if (arr && typeof arr === 'object' && !Array.isArray(arr)) {
        org_temp = Number(arr.temperature);
        start_temp = (org_temp<0) ? 0 : getPercentage(org_temp,100);
        org_hum = Number(arr.humidity);
        start_hum = (org_hum<0) ? 0 : getPercentage(org_hum,100);

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

        notice = arr.notice;

    }

    $('#gm_tem').data('percent',Math.round(start_temp));
    $('#gm_hum').data('percent',Math.round(start_hum));

    $('#type1').data('used',type1);
    $('#type3').data('used',type3);
    $('#type2').data('used',type2);
    $('#type4').data('used',type4);
    $('#type5').data('used',type5);
    $('#type6').data('used',type6);
    $('#type8').data('used',type8);
    $('#type13').data('used',type13);
    $('#type14').data('used',type14);
    $('#type0').data('used',type0);

    $('p[name="t_order"]').text(totalOrder);
    $('#total_order').text(totalOrder);

    $('#p_ready').data('used',p_ready);
    $('#p_ing').data('used',p_ing);
    $('#p_complete').data('used',p_complete);
    $('p[name="t_produce"]').text(totalProduce);

    $('#d_ready').data('used',d_ready);
    $('#d_ing').data('used',d_ing);
    $('#d_complete').data('used',d_complete);
    $('p[name="t_delivery"]').text(totalDelivery);

    let n_Cnt = notice.length;
    let n_html = '';
    if(n_Cnt > 0){
        $.each(notice ,function(index,el){
            n_html += `<p class="data data${index+1}">${el}</p> `
        });
        $('#notice').empty().append(n_html);
    }

    $(".GaugeMeter").gaugeMeter({theme: 'pink',color: '#FF5894'});
    $(".GaugeMeter2").gaugeMeter({theme: 'cyonblue',color: '#41F3F5'});
    $(".GaugeMeter3").gaugeMeter({theme: 'green',color: '#6AF288'});
    $(".GaugeMeter4").gaugeMeter({theme: 'red',color: 'red'});

    return bool = true;
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

