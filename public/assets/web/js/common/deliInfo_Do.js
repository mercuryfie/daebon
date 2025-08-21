$(document).ready(function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ko', // 한글 지원
        initialView: 'dayGridMonth',
        height: 650, // 전체 캘린더 높이 고정
        contentHeight: 650, // 내용 최소 높이 고정 (옵션)
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        // customButtons: {
        //     addEventBtn: {
        //         text: '이벤트 추가ㅇㅇ',
        //         click: function() {
        //             calendar.addEvent({
        //                 title: '새 이벤트',
        //                 start: new Date().toISOString().slice(0,10), // 오늘 날짜
        //                 color: 'skyblue',
        //                 textColor: '#000'
        //             });
        //         }
        //     }
        // },
        // dateClick : function (info) {
        //   calendar.addEvent({
        //       title:'새 이벤트',
        //       start: info.dateStr,
        //       color:'#6FFF7480',
        //       textColor:'#000'
        //   });
        // },
        events: [
            {
                title: '생산 10/100건',
                start: '2025-08-15',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-15',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-18',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-18',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-14',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-14',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-12',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-12',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-13',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-13',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-11',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-11',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-08',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-08',
                color: '#6eec9a',
                textColor: '#000'
            },
            {
                title: '생산 10/100건',
                start: '2025-08-07',
                color: '#6FFF7480',
                textColor: '#000'
            },
            {
                title: '주문 10/100건',
                start: '2025-08-07',
                color: '#6eec9a',
                textColor: '#000'
            },
            // {
            //     title: '출장',
            //     start: '2025-08-20',
            //     end: '2025-08-22',
            //     color: '#6FFF74',
            //     textColor: '#000'
            // },
            // {
            //     title: '휴가',
            //     start: '2025-08-25',
            //     color: 'tan',
            //     textColor: '#000'
            // },
            // {
            //     title: '휴가2',
            //     start: '2025-08-26T14:00:00',
            //     allDays:false
            // },
            {
                title: '일정명입니다.',
                start: '2024-06-19T09:00:00',
                end: '2024-06-19T12:50:00',
                startStr: 'Start 텍스트',	// 일정 bar에 출력이 되지는 않음
                endStr: 'End 텍스트',		// 일정 bar에 출력이 되지는 않음
                classNames:['custom-className1','custom-className2'],
                editable: false,
                display: 'block',	// 직사각형 bar가 나타난다.
                overlap: false,
                backgroundColor: 'red',
                borderColor: 'blue',
                textColor: 'white'
            }
        ]
    });

    calendar.render();


});