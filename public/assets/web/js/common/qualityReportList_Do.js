$(document).ready(function() {
    let search = '';
    const data = {
        skey : search,
        page : $('#cpage').data('page')
    };

    Make_Html(data);


    $(document).on('click','button[name="vwReport"]',function() {
        let code = $(this).data('code');
        let url = "/report/q_form?cd=" + code;
        pop_qualityReportForm(url);
    });

    $(document).on('click','#cpage',function(){
        let currentPage = parseInt($('#cpage').data('page'), 10);
        let nextPage = currentPage + 1;
        $('#cpage').data('page',nextPage);

        const data = {
            stype : '',
            page : nextPage
        };
        Make_Html(data);

    });


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

});

async function Make_Html(data){
    let arr = await Data_Load(data);
    console.log(arr);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            if (el.stepnow == el.processcnt) {
                html += `
                <tr>
                    <td class="ltTbody">
                        <input type="checkbox" name="chk_seq" value="${el.seq}">
                    </td>
                    <td class="ltTbody">${el.shortdate}</td>
                    <td class="ltTbody">${el.shortdate}</td>
                    <td class="ltTbody">${el.gname}</td>
                    <td class="ltTbody">${el.gicode}</td>
                    <td class="ltTbody">${number_format(el.quantity)} 봉</td>
                    <td class="ltTbody">(${el.stepnow}/${el.processcnt})</td>  
                    <td class="ltTbody">
                        <button type="button" class="btnType3 statusBtn statusStandby" name="vwReport" data-code="${el.gicode}" >
                            <i class="fa-solid fa-scroll"></i>
                        </button>
                    </td>
                </tr>
            `;

            }
        });
    }else{
        Make_Toast('마지막입니다.');
        // html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    $('#tcnt').html(arr.total);
}

async function Data_Load(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"param" : data};
        let url = APIURL + '/Load_Instructions_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            tcnt = (data && data.tcnt) ? data.tcnt : 0;
            r_arr = {
                list : arr,
                total : tcnt
            };
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_arr;
}

