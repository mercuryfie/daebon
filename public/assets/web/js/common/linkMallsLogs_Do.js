$(document).ready(function() {
    Make_Html();

    $('.period').click(function(e) {
        e.preventDefault();
        $('.period').removeClass('active');
        $(this).addClass('active');

        const today = new Date();
        let startDate = new Date();
        let endDate = new Date();

        const periodText = $(this).text();

        switch (periodText) {
            case '오늘':
                startDate = today;
                endDate = today;
                break;
            case '1주일':
                startDate = new Date(today);
                startDate.setDate(today.getDate() - 6);
                endDate = today;
                break;
            case '1개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 1);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            case '3개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 3);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            default:
                startDate = today;
                endDate = today;
        } 

        $('#s_date').val(formatDate(startDate));
        $('#e_date').val(formatDate(endDate));
    });



    $('.datepicker').each(function(index, elem) {
        const fp = flatpickr(elem, {
            dateFormat: "Y-m-d",
            minDate: "2024-01-01",
            static: true,
            appendTo: elem.parentNode,
            onClose: function(selectedDates, dateStr, instance) {
                instance.element.blur();
            }
        });

        $('.calicon').eq(index).on('click', function(e) {
            e.preventDefault();
            fp.open();
        });
    });

    $('#btn_show').on('click',function(){
        go_linkMalls();
    });


});


async function Make_Html(){
    let code = $('#code').val();
    let arr = await Load_Data(code);
    console.log(arr);
    let html = '';
    if(arr.length > 0) {
        $.each(arr, function (index, el) {
            html += `
                    <tr>
                        <td class="ltTbody">${el.shop_name}</td>
                        <td class="ltTbody">${el.status}</td>
                        <td class="ltTbody">${el.content}</td>
                        <td class="ltTbody">${el.indate}</td>
                    </tr>
            `;
        });
        $('#tList').empty();
        $('#tList').append(html);
    }else{
        html = '<tr><td class="ltThead" colspan="9">검색된 데이터가 없습니다.</td></tr>';
        $('#tList').empty();
        $('#tList').append(html);
    }
}

async function Load_Data(code){
    let data = {};
    try {
        start_spinner();
        let dataarr = {code : code};
        let url = APIURL + '/Load_Mall_Log_List';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}


function formatDate(d) {
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${year}/${month}/${day}`;
}