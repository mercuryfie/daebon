$(document).ready(function() {
    let param = {
        keyword : '',
        sdate : '',
        edate : '',
        select_typ : ''
    }
    Make_Html(param);


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
            case '전체':
                startDate = '';
                endDate = '';
                break;
            default:
                startDate = today;
                endDate = today;
        }
        if(startDate!='') {
            $('#s_date').val(formatDate(startDate));
        }else{
            $('#s_date').val('');
        }
        if(endDate!='') {
            $('#e_date').val(formatDate(endDate));
        }else{
            $('#e_date').val('');
        }

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

    $('#btn_search').on('click',function(){
        let param = {
            keyword : $('#stxt').val(),
            sdate : $('#s_date').val(),
            edate : $('#e_date').val(),
            select_typ : $('#select_typ').val()
        }
        $('#cList').empty();
        Make_Html(param);
    });

    $('#stxt').on('keypress',function(e){
        if (e.key === 'Enter') {
            let param = {
                keyword : $('#stxt').val(),
                sdate : $('#s_date').val(),
                edate : $('#e_date').val(),
                select_typ : $('#select_typ').val()
            }
            $('#cList').empty();
            Make_Html(param);
        }
    });


    $('#btn_reload').on('click',function(){
        $('#cList').empty();
        let param = {
            keyword : '',
            sdate : '',
            edate : '',
            select_typ : ''
        }
        Make_Html(param);

    });

    async function Make_Html(param){
        let arr = await Load_Data(param);
        console.log(arr);
        let html = '';
        if(!fn_IsEmpty(arr)) {
            $.each(arr, function (index, el) {
                html +=`
                        <tr>
                            <td class="ltTbody">${el.shopname}</td>
                            <td class="ltTbody">${el.spcode}</td>
                            <td class="ltTbody">${el.delicode}</td>
                            <td class="ltTbody">${el.confirm_date}</td>
                            <td class="ltTbody">${el.orderdate}</td>
                            <td class="ltTbody">${el.pname}</td>
                            <td class="ltTbody">${el.pcnt}</td>
                            <td class="ltTbody">${el.r_name}</td>
                            <td class="ltTbody">${el.r_phone}</td>
                            <td class="ltTbody">${el.r_address}</td>
                        </tr>
                `;
            });
            $('#cList').empty();
            $('#cList').append(html);
        }else{
            html +=`<tr><td class="ltTbody td1" colspan="10">검색된 정보가 없습니다.</td></tr>`;
            $('#cList').empty();
            $('#cList').append(html);
        }
    }

    async function Load_Data(param){
        let data = {};
        try {
            start_spinner();
            let dataarr = {"param" : param};
            let url = APIURL + '/Load_Delivery_Data';
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

});


