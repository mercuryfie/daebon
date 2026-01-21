
// $(document).ready(function() {

document.addEventListener('DOMContentLoaded', function() {

    function setData(){
        //작업실 온/습도 tempbox
        $("#GaugeMeter_101").attr("data-percent",36);
        $("#GaugeMeter_102").attr("data-percent",36);

        //각 공정 현황
        $("#GaugeMeter_103").attr("data-used",36);
        $("#GaugeMeter_104").attr("data-used",36);
        $("#GaugeMeter_105").attr("data-used",36);
        $("#GaugeMeter_106").attr("data-used",36);

        //탕전 주문 현황
        $("#GaugeMeter_107").attr("data-percent",36);
        $("#GaugeMeter_108").attr("data-percent",36);
        $("#GaugeMeter_109").attr("data-percent",36);
        $("#GaugeMeter_110").attr("data-percent",36);

        //예비 조제 주문 현황
        $("#GaugeMeter_111").attr("data-percent",36);
        $("#GaugeMeter_112").attr("data-percent",36);
        $("#GaugeMeter_113").attr("data-percent",36);
        $("#GaugeMeter_114").attr("data-percent",36);
        $("#GaugeMeter_115").attr("data-percent",36);

        //택배 발송 현황
        $("#GaugeMeter_116").attr("data-used",36);
        $("#GaugeMeter_117").attr("data-used",36);
        $("#GaugeMeter_118").attr("data-used",36);
        $("#GaugeMeter_119").attr("data-used",36);
    }
    setData();

    //작업실 온/습도 tempbox
    $(".GaugeMeter").gaugeMeter({
        theme: 'pink',
        color: '#FF5894',
    });
    $(".GaugeMeter2").gaugeMeter({
        theme: 'cyonblue',
        color: '#41F3F5',
    });

    // 각 공정 현황 procbox
    $(".GaugeMeter3").gaugeMeter({
        theme: 'green',
        color: '#6AF288',
    });

    // 택배발송현황 parbox
    $(".GaugeMeter5").gaugeMeter({
        theme: 'blue',
        color: '#2986cc',
    });
    $(".GaugeMeter6").gaugeMeter({
        theme: 'cyonblue',
        color: '#62E9EB',
    });

    // 탕전 주문현황 leftbox
    $(".GaugeMeter7").gaugeMeter({
        theme: 'Purple',
        color: '#C322FB',
    });

    // 예비조제 주문현황 rightbox
    $(".GaugeMeter8").gaugeMeter({
        theme: 'green',
        color: '#6AF288',
    });


    // 주간 주문 건수 weekbox
    const ctx3 = document.getElementById('weekChart');
    const weekChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['월', '화', '수', '목', '금', '토','일'],
            datasets: [{
                label: '# of this week',
                data: [464, 300, 400, 500, 600, 300,450],
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
                    data: [596, 512, 417, 389, 348, 342,450],
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
                title: {
                    display: true,

                },
                legend: {
                    display:false,
                    labels: {
                        color:'red'
                    },
                    data: {
                        color:'white'
                    }
                }
            },

            scales: {
                x: {
                    ticks: {
                        color:'#ececec'
                    },
                    grid: {
                        color: '#5c5c5c', // x축 그리드 색상 변경
                    }
                },
                y: {
                    beginAtZero: false,
                    min:100,
                    max:700,
                    ticks: {
                        color:'#ececec'
                    },
                    grid: {
                        color: '#5c5c5c' // x축 그리드 색상 변경
                    }
                },

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
                },

            },

        }
    });


    // 원자재 재고 현황
    const ctx = document.getElementById('m_barChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['전체','결명자','계피','구기자','노니','당귀','대추','도꼬마리','도라지','돼지감자' ],
            datasets: [{
                label: '전체',
                data: [120,100,80,60,40,20],
                borderWidth: 1,
                borderColor:'transparent',
                fill:true,
                backgroundColor: [
                    'rgba(236,236,236,0.5)'
                ],   },
                {
                    label: '진척도',
                    data: [60,80,60, 40, 40],
                    borderWidth: 1,
                    borderColor:'rgba(106,242,136,0.8)',
                    fill:true,
                    backgroundColor: [
                        'rgba(106,242,136,0.8)'
                    ],   },
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                bar: {
                    borderWidth: 5,
                }
            },
            plugins: {
                title: {
                    display: false,
                    text: '전체 작업 시간',
                    color:'#ececec'

                },
                legend: {
                    position: 'right',
                    display:false,
                    labels: {
                        color:'#ececec'
                    },
                    data: {
                        color:'white',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Horizontal Bar Chart'
                    }
                }
            },

            scales: {
                x: {
                    ticks: {
                        color:'#ececec',

                    },
                    grid: {
                        color: '#5c5c5c',
                    },
                },
                y: {
                    beginAtZero: false,
                    max:450,
                    ticks: {
                        color:'#ececec'
                    },
                    grid: {
                        color: '#5c5c5c',
                    },
                }
            }

        }
    });

    // 제품 재고 현황
    const ctx2 = document.getElementById('p_barChart');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['전체','결명자','계피','구기자','노니','당귀','대추','도꼬마리','도라지','돼지감자','두충','도꼬마리','도라지','돼지감자','두충'  ],
            datasets: [{
                label: '전체',
                data: [120,100,80,60,40,20],
                borderWidth: 1,
                borderColor:'transparent',
                fill:true,
                backgroundColor: [
                    'rgba(236,236,236,0.5)'
                ],   },
                {
                    label: '진척도',
                    data: [60,80,60, 40, 40],
                    borderWidth: 1,
                    borderColor:'rgba(106,242,136,0.8)',
                    fill:true,
                    backgroundColor: [
                        'rgba(106,242,136,0.8)'
                    ],   },
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                bar: {
                    borderWidth: 5,
                }
            },
            plugins: {
                title: {
                    display: false,
                    text: '전체 작업 시간',
                    color:'#ececec'

                },
                legend: {
                    position: 'right',
                    display:false,
                    labels: {
                        color:'#ececec'
                    },
                    data: {
                        color:'white',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Horizontal Bar Chart'
                    }
                }
            },

            scales: {
                x: {
                    ticks: {
                        color:'#ececec',

                    },
                    grid: {
                        color: '#5c5c5c',
                    },
                },
                y: {
                    beginAtZero: false,
                    max:450,
                    ticks: {
                        color:'#ececec'
                    },
                    grid: {
                        color: '#5c5c5c',
                    },
                }
            }

        }
    });



});