$(document).ready(function() {
    let param = {
        skey : '',
        stype : ''
    };
    Make_Html(param);


    $('#incode').on('keydown',async function(e){
        if (e.key === 'Enter' || e.keyCode === 13) {
            let param = {
                skey : $(this).val(),
                stype : ''
            };
            Make_Html(param);
            $('#incode').val('');
            $('#incode').focus();
        }
    });

    $('#btn_reload').on('click',function(){
        location.reload();
    });

    $(document).on('click', function(e){
        if (document.activeElement.id !== 'incode') {
            $('#incode').focus();
        }
    });


    $(document).on('click','button[name="searchType"]',function(){
        let stype = $(this).data('val');
        $('button[name="searchType"]').removeClass('active');
        $(this).addClass('active');
        $('#clist').empty();
        let param = {
            skey : '',
            stype : stype
        };
        Make_Html(param);
    });



    async function Make_Html(param){
        let arr = await Load_Data(param);
        let html = '';
        if(!fn_IsEmpty(arr)) {
            $.each(arr, function (index, el) {
                html +=`
                        <tr onclick="go_packingStatusStaff('${el.opcode}');">
                            <td class="ltTbody td1">${el.opcode}</td>
                            <td class="ltTbody " onclick="">${el.sname}</td>
                            <td class="ltTbody">${el.rname}</td>
                            <td class="ltTbody">${el.tcnt}</td>
                            <td class="ltTbody">${el.status}</td>
                            <td class="ltThead">${el.worker}</td>
                            <td class="ltTbody">${el.start}</td>
                            <td class="ltTbody">${el.end}</td>
                        </tr>
                    
                `;
            });
            $('#cList').empty();
            $('#cList').append(html);
        }else{
            html +=`<tr><td class="ltTbody td1" colspan="8">검색된 정보가 없습니다.</td></tr>`;
            $('#cList').empty();
            $('#cList').append(html);
        }
    }

    async function Load_Data(param){
        let data = {};
        try {
            start_spinner();
            let dataarr = {"param" : param};
            let url = APIURL + '/Load_Packing_Data';
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