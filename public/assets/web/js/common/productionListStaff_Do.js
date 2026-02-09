$(document).ready(function() {
    const data = {
        stype : '',
        page : $('#cpage').data('page')
    };
    Make_Html(data);

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
        const data = {stype:stype};
        Make_Html(data);

    });

    $(document).on('keydown','#incode', async function(e){
        if (e.key === 'Enter' || e.keyCode === 13) {
            let code = $(this).val();
            let bool = await Check_instruction(code);
            if(bool){
                //go_productionListStaff();
                go_productionDetailStaff(code);
            }else{
                Make_Toast('존재하지 않는 지시서 입니다. ');
                $('#incode').val('');
                $('#incode').focus();
            }
        }
    });

    $(document).on('click','td[name="view_detail"]',function(){
        let iscomplete= $(this).data('iscomplete');
        if(iscomplete!=2) {
            let code = $(this).data('code');
            // console.log(code);
            // process_step(code);
            go_productionDetailStaff(code);
        }
    });

    $(document).on('click','#btn_reload',function(){
        location.reload();
    });

    $(document).on('click','#cpage',function(){
        let currentPage = parseInt($('#cpage').data('page'), 10);
        let nextPage = currentPage + 1;
        $('#cpage').data('page',nextPage);

        const data = {
            stype : '',
            page : nextPage
        };
        Make_Html2(data);

    });

    $(document).on('click','button[name="prn_label"]',function(e){
        if (e.target.tagName === "BUTTON") {
            let gicode = $(this).data('gicode');
            let sicode = $(this).data('sicode');
            let pname = $(this).data('pname');
            let indate = $(this).data('indate');
            let url = '/product/prn_label?gi=' + gicode + '&si=' + sicode + '&pn=' + pname + '&in=' + indate;
            // window.open(url, "_blank");


            console.log('dawn1646', gicode,sicode,pname,gicode);

            let width = '920';
            let height = '580';

            let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

            newWindow.onload = function() {
                try {
                    let docHeight = newWindow.document.body.scrollHeight;
                    newWindow.resizeTo(width, docHeight + 100);
                } catch(e) {
                    console.log("새 창 높이 조절 불가", e);
                }
            };
        }
    });

});

async function Make_Html(data){
    let arr = await Data_Load(data);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            let prog = '';
            let prn = '';
            if (!fn_IsEmpty(el.stepNum)) {
                prog = `(` + el.stepNum + `/` + el.processcnt + `)`;
            }
            if(el.semicode!=''){
                prn = `<button type="button" class="btn60Type3 " name="prn_label" data-gicode="${el.gicode}" data-sicode="${el.semicode}" data-pname="${el.processname}" data-indate="${el.indate}">출력</button>`;
            }

            html += `
                <tr class="" data-code="${el.gicode}" data-iscomplete="${el.iscomplete}"> 
                    <td class="ltTbody  ">${el.shortdate}</td>
                    <td class="ltTbody  ">${el.gicode}</td>
                    <td class="ltTbody gname" name="view_detail" data-code="${el.gicode}">${el.gname}</td>
                    <td class="ltTbody pname" name="view_detail" data-code="${el.gicode}">${el.processname} ${prog}</td> 
                    <td class="ltTbody">${number_format(el.quantity)}개</td>
                      
                    <td class="ltTbody">${el.processstr}</td> 
                    <td class="ltTbody">${el.worker}</td>  
                    <td class="ltTbody">${prn}</td> 
                </tr>
            `;
        });
    }else{
        // Make_Toast('마지막입니다.');
        html = '<tr><td class="ltThead" colspan="10" id="nomore" name="nomore">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    let tcnt = arr.total;
    $('#tcnt').html(tcnt);
    $('#tcnt').data('val',tcnt);
}


async function Make_Html2(data){
    let arr = await Data_Load(data);
    console.log(arr);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {

            let prog = '';
            if (!fn_IsEmpty(el.stepNum)) {
                prog = `(` + el.stepNum + `/` + el.processcnt + `)`;
            }
            html += `
                <tr class="" data-code="${el.gicode}" data-iscomplete="${el.iscomplete}"> 
                    <td class="ltTbody  ">${el.shortdate}</td>
                    <td class="ltTbody  ">${el.gicode}</td>
                    <td class="ltTbody" name="view_detail" data-code="${el.gicode}">${el.gname}</td>
                    <td class="ltTbody" name="view_detail" data-code="${el.gicode}">${el.processname} ${prog}</td> 
                    <td class="ltTbody">${number_format(el.quantity)}개</td>
                      
                    <td class="ltTbody">${el.processstr}</td> 
                    <td class="ltTbody">${el.worker}</td> 
                </tr>
            `;
        });
    }else{
        Make_Toast('마지막입니다.');
        // html = '<tr><td class="ltThead" colspan="10" id="nomore" name="nomore">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    let otcnt = parseInt($('#tcnt').data('val'), 10);
    let tcnt = arr.total + otcnt
    console.log(tcnt);
    $('#tcnt').html(tcnt);
    $('#tcnt').data('val',tcnt);
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
            console.log(data);
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

async function Check_instruction(code){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Check_instruction';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let Cnt = result.get('data').Cnt;
            if(Cnt > 0){
                bool = true;
            }
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}


