$(document).ready(function() {

    $('#order_wrapdek #Xbtn, #order_wrapdek #Xbtn2').click(function () {
        $('#order_wrapdek').css('display','none');
    });

    $(document).on('click','button[name="view_production"]',function(){
        let code = $(this).data('code');
        let nd = $(this).data('nd');
        go_productionDetail(code);
    });

    $(document).on('click','button[name="prnRoastForm"]',function() {
        let code = $(this).data('code');
        let url = "/produce/instructionform?cd=" + code;
        pop_OrderRoastForm(url);
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

    $('.dateBox .period').eq(2).trigger('click');


    $('#btn_search').on('click',function(){
        $('#clist').empty();
        $('#cpage').data('page',1);
        Make_Html(Make_Search_Param());
    });

    $('#skey').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            $('#clist').empty();
            $('#cpage').data('page',1);
            Make_Html(Make_Search_Param());
        }
    });

    $('input[name="filter"]').on('change',function(){
        if ($(this).is(':checked')) {
            $('input[name="filter"]').not(this).prop('checked', false);
        }
        $('#clist').empty();
        Make_Html(Make_Search_Param());
    });

    $('#cpage').on('click',function(){
        $('#p_wrap').css('width','81vw');
        Make_Html(Make_Search_Param());
    });

    Make_Html(Make_Search_Param());

});

function Make_Search_Param(){
    let sdata = $('#s_date').val();
    let edata = $('#e_date').val();
    let skey = $('#skey').val();
    let filterVal = $('input[name="filter"]:checked').val() || '';
    let page = $('#cpage').data('page');

    let param = {
        sdata : sdata,
        edata : edata,
        skey : skey,
        filter : filterVal,
        page : page
    }
    return param;
}


async function Make_Html(data){
    let arr = await Data_Load(data);
    console.log(arr);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            let prog = '';
            if (!fn_IsEmpty(el.stepNum)) {
                prog = `(` + el.stepNum + `/` + el.processcnt + `)`;
            }

            let totalCnt = Number(el.quantity) * Number(el.icnt);
            html += `
                <tr>
                    <td class="ltTbody">${el.shortdate}</td>
                    <td class="ltTbody">${el.gicode}</td>
                    <td class="ltTbody">${el.gname}</td>
                    <td class="ltTbody">${number_format(totalCnt)} ${el.unit_type}</td>  
                    <td class="ltTbody">${el.processname} ${prog}</td>  
                    <td class="ltTbody">${el.processstr}</td>
                    <td class="ltTbody">${el.worker}</td> 
                    <td class="ltTbody">
                        <button type="button" class="btnType3 statusBtn" name="view_production" data-code="${el.gicode}" data-nd="${el.prcode}" >현황보기</button>
                    </td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 statusBtn statusStandby" name="prnRoastForm" data-code="${el.gicode}" >
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#p_wrap').css('height','560px');
        $('#cpage').data('page',(data.page+1))
    }else{
        //html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
        Make_Toast('검색된 데이터가 없습니다.');
    }
    $('#clist').append(html);

    let nowcnt = $('#tcnt').html();
    if(nowcnt==='') nowcnt = 0;
    let newcnt = Number(nowcnt) + Number(arr.total);
    $('#tcnt').html(newcnt);
}

async function Data_Load(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"params" : data};
        let url = APIURL + '/Load_Instructions_Info2';
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
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }finally {
        stop_spinner();
    }
    return r_arr;
}



function pop_OrderForm() {
    $('#order_wrapdek').css('display','block');
}

