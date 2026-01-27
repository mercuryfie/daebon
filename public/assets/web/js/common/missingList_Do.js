$(document).ready(function() {


    Load_Data();

    $(document).on('click','#btn_print',function(){
        printWindow('frnbody');
    });

});



async function Load_Data() {
    try {
        start_spinner();
        let dataarr = {};
        let url = APIURL + '/Load_NoticeList';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if (result.get('status') == 'ok') {
            let html = '';
            let data = result.get('data');
            // let tCnt = data.tCnt;
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            let num = 0;
            if (Cnt > 0) {
                $.each(arr, function (index, el) {
                    num += 1;
                    html += ` 
                    `;
                });
            } else {
                html = ` 
                `;
            }

            // $('#mList').empty();
            $('#mList').append(html);
            // $('#tcnt').html(number_format(data.tCnt));
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }

}


function More_Info(tr) {
    // $(tr).empty();
    let $tr = $(tr);
    let $dataBox = $tr.find('.data_box');  // tr 안 data_box만

    $dataBox.slideToggle(300, function() {
        // 토글 완료 후 tr 높이 자동 조정
        $tr.closest('tbody').trigger('reflow');
    });

}