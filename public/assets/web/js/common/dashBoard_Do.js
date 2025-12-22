$(document).ready(function() {
    let calendar = initCalendar('calendar');
});


function initCalendar(calendarElId) {
    let calendarEl = document.getElementById(calendarElId);

    let events = Data_Load();

    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ko',
        initialView: 'dayGridMonth',
        height: 650,
        contentHeight: 650,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,addEventBtn'
        },
        customButtons: {
            addEventBtn: {
                text: '이벤트 추가ㅇㅇ',
                click: function() {
                    calendar.addEvent({
                        title: '새 이벤트',
                        start: new Date().toISOString().slice(0, 10),
                        color: 'skyblue',
                        textColor: '#000'
                    });
                }
            }
        },
        dateClick: function(info) {
            calendar.addEvent({
                title: '새 이벤트',
                start: info.dateStr,
                color: '#6FFF7480',
                textColor: '#000'
            });
        },
        events: events   // ← 외부에서 받은 배열
    });

    calendar.render();

    return calendar;     // 나중에 addEvent 등 쓰고 싶으면 반환
}

function Data_Load() {
    let events = [];

    // 오늘 기준으로 이번 달 정보 구하기
    let today = new Date();
    let year  = today.getFullYear();
    let month = today.getMonth() + 1;          // 1 ~ 12
    let monthStr = month < 10 ? '0' + month : String(month);

    // 이번 달의 마지막 날짜(말일) 구하기
    let daysInMonth = new Date(year, month, 0).getDate(); // 예: 30, 31 등

    for (let d = 1; d <= daysInMonth; d++) {
        let dayStr  = d < 10 ? '0' + d : String(d);       // "01" ~ "31"
        let dateStr = `${year}-${monthStr}-${dayStr}`;    // "2025-12-01" 형식

        events.push({
            title: '주문등록 100건',
            start: dateStr,
            color: '#6FFF7480',
            textColor: '#000'
        });
        events.push({
            title: '발송완료 96건',
            start: dateStr,
            color: '#6eec9a',
            textColor: '#000'
        });
    }

    return events;
}