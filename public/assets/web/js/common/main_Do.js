$(document).ready(function() {
    let calendar = initCalendar('calendar');
});

function initCalendar(calendarElId) {
    let calendarEl = document.getElementById(calendarElId);
    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ko',
        initialView: 'dayGridMonth',
        height: 650,
        contentHeight: 650,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        datesSet: async function(info) {
            let currDate = info.view.currentStart;
            let midDate = new Date((info.view.activeStart.getTime() + info.view.activeEnd.getTime()) / 2);
            let year = midDate.getFullYear();
            let month = midDate.getMonth() + 1;
            calendar.removeAllEvents();
            try {
                let newEvents = await Make_Chart(year, month);
                calendar.addEventSource(newEvents);
            } catch (e) {
                console.error("이벤트 로드 실패:", e);
            }
        }
    });

    calendar.render();
    return calendar;
}


async function Make_Chart(year,month) {
    let events = [];
    let monthStr = month < 10 ? '0' + month : String(month);
    let arr = await Data_Load(year,monthStr);
    console.log('data',arr);
    let daysInMonth = new Date(year, month, 0).getDate(); // 예: 30, 31 등

    for (let d = 1; d <= daysInMonth; d++) {
        let dayStr = String(d).padStart(2, '0');
        let dateStr = `${year}-${monthStr}-${dayStr}`;

        let orderCount = (arr.order && arr.order[dateStr]) ? arr.order[dateStr] : 0;
        let deliveryCount = (arr.delivery && arr.delivery[dateStr]) ? arr.delivery[dateStr] : 0;

        orderColor = (orderCount > 0) ? '#0000CD' : '#000';
        deliveryColor = (deliveryCount > 0) ? '#FF0000' : '#000';

        events.push({
            title: `주문 : ${orderCount}건`,
            start: dateStr,
            color: '#cccccc40',
            textColor: orderColor
        });

        events.push({
            title: `배송 : ${deliveryCount}건`,
            start: dateStr,
            color: '#cccccc20',
            textColor: deliveryColor
        });
    }

    return events;
}

async function Data_Load(year,month){
    let r_arr = {};
    try {
        start_spinner();
        if (!year || !month) {
            let now = new Date();
            year = year || now.getFullYear();
            month = month || (now.getMonth() + 1);
        }

        let targetDate = new Date(year, month - 1, 1);
        targetDate.setMonth(targetDate.getMonth() + 1); // 한 달 더하기
        let e_year = targetDate.getFullYear();
        let e_month = String(targetDate.getMonth() + 1).padStart(2, '0');
        let e_date = e_year + '-' + e_month + '-01';
        let s_date = year + '-' + month + '-01';

        console.log("조회 기간:", s_date, "~", e_date);


        let dataarr = {"sdate": s_date,"edate" : e_date};
        let url = APIURL + '/Load_Statistics_Month';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            r_arr = {
                order : result.get('data').order,
                delivery : result.get('data').delivery
            };
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }finally {
        stop_spinner();
    }
    return r_arr;
}

