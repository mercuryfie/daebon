
$(document).ready(function() {
    $('#uploadExel #Xbtn, #uploadExel #Xbtn2').click(function () {
        $('#uploadExel').css('display','none');
    });

    $('#addPQueue #Xbtn, #addPQueue #Xbtn2').click(function () {
        $('#addPQueue').css('display','none');
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


    let param = '';
    Make_Html(param);

});

async function Make_Html(param){
    let arr = await Load_Data(param);
    let html = '';
    if(!fn_IsEmpty(arr)) {
        $.each(arr, function (index, el) {
            let subhtml = '';
            if(el.orstep==0) {
                subhtml = `<button type="button" class="btnType3">미확인</button> `;
            }else if(el.orstep==1) {
                subhtml = `<button type="button" class="btnType3">결제확인중</button> `;
            }else if(el.orstep==2){
                subhtml = `<button type="button" class="btnType3" onclick="add_packingQueue();">등록대기</button>`;
            }else if(el.orstep==3){
                subhtml = `<button type="button" class="btnType3">제품확인</button>`;
            }

            html +=`
                <tr class="">
                    <td class="ltTbody td40 fixedCol">
                        <input type="checkbox" name="chkorder" value="${el.orcode}">
                    </td>
                    <td class="ltTbody productNo fixedCol" name="packingStep"><div class="inner1"><p class="text">${subhtml}</p></div></td>
                    <td class="ltTbody fixedCol"><div class="inner1"><p class="text">엑셀</p></div></td>
                    <td class="ltTbody fixedCol underline2" data-copy="copy"><div class="inner2"><p class="text">${el.orcode}</p></div></td>
                    <td class="ltTbody fixedCol underline2"><div class="inner2 last_inner"><p class="text">${el.spcode}</p></div></td>
                    <td class="ltTbody scrollableCol underline2">daebonddd1234</td>
                    <td class="ltTbody scrollableCol underline2">daebonddd1234</td>  
                     
                    <td class="ltTbody scrollableCol">우엉차</td>
                    <td class="ltTbody scrollableCol">홍길동</td>
                    <td class="ltTbody scrollableCol">홍길동</td>
                    <td class="ltTbody scrollableCol">10,000</td>
                    
                    <td class="ltTbody scrollableCol">10</td> 
                    <td class="ltTbody scrollableCol">2025.01.01</td>
                    <td class="ltTbody scrollableCol">2025.01.01</td> 
                    <td class="ltTbody scrollableCol">-</td>
                </tr>
            `;
        });
        $('#cList').empty();
        $('#cList').append(html);
    }
}


function upload_Xlx() {
    $('#uploadExel').css('display','block');
}


function add_packingQueue() {
    $('#addPQueue').css('display','block');
}

function formatDate(d) {
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${year}/${month}/${day}`;
} 

async function Load_Data(param){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"search" : param};
        let url = APIURL + '/Load_Order_Data';
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