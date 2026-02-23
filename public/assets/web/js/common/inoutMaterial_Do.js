$(document).ready(function() {



    $('#txt_before').on('focus',function(){
        $(this).val('');
        $('#inputlist').removeClass('active');
        $('#inputlist').empty();

    });

    $('#txt_mtinfo').on('keypress',function(e){
        if (e.which === 13) {
            let search = $('#txt_mtinfo').val();
            Make_Html(search);
        }
    });

    $('#bnt_input').on('click',function(){
        input_Form_ini();
        $('#ipgoWrap').css('display','block');
    });

    $('#btn_output').on('click',function(){
        output_Form_ini();
        $('#outWrap').css('display','block');
    });


    $(document).on('click','button[name="btn_barcode"]',function(){
        let mtcode = $(this).data('mtcode');
        let url = "/inout/prn_barcode_material?mt=" + mtcode;
        let width = 800;
        let height = 400;

        let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

        newWindow.onload = function() {
            try {
                let docHeight = newWindow.document.body.scrollHeight;
                newWindow.resizeTo(width, docHeight + 100);
            } catch(e) {
                console.log("새 창 높이 조절 불가", e);
            }
        };
    });

    $('#txt_pop_input').on('keypress',function(e){
        if (e.which === 13) {
            let search = $('#txt_pop_input').val();
            let data = {skey:search};
            Load_Material(1,data);
        }
    });

    $('#txt_pop_output').on('keypress',function(e){
        if (e.which === 13) {
            let search = $('#txt_pop_output').val();
            let data = {skey:search};
            Load_Material(2,data);
        }
    });

    $('#txt_pop_income').on("input",function() {
        $(this).val($(this).val().replace(/\D/g, ""));
    });

    $('#txt_pop_outcome').on("input",function() {
        $(this).val($(this).val().replace(/\D/g, ""));
    });

    $('#txt_pop_input').on('focus', function(){
        $(this).val('');
        input_Form_ini();
    });

    $('#txt_pop_output').on('focus', function(){
        $(this).val('');
        output_Form_ini();
    });

    $('#btn_income').on('click',async function(){
        const income = $('#txt_pop_income').val();
        const memo = $('#txt_mtmemo').val();
        const mtcode = $('#pop_mtcode').val();

        if(income==''){
            Make_Toast('입고량을 입력하세요.');
            $('#txt_pop_income').focus();
        }else if(mtcode==''){
            $('#ipgoWrap').css('display','block');
            Make_Toast('잘못된 접근입니다. ');
        }else if(window.confirm('입고 처리 하시겠습니까?')==true){
            const params = {
                mtcode : mtcode,
                income : income,
                stocktyp : 1,
                reason : 0,
                memo : memo
            }
            let bool = await Patch_Material_Income(mtcode,params);
            if(bool==true){
                Make_Toast('입고 처리 하였습니다.');
            }
        }
    });

    $('#btn_outcome').on('click',async function(){
        const outcome = $('#txt_pop_outcome').val();
        const memo = $('#txt_omtmemo').val();
        const mtcode = $('#pop_omtcode').val();
        const reason = $('#o_reason').val();

        if(outcome=='') {
            Make_Toast('출고량을 입력하세요.');
            $('#txt_pop_outcome').focus();
        }else if(reason==''){
            Make_Toast('출고사유를 선택하세요.');
            $('#o_reason').focus();
        }else if(mtcode==''){
            $('#ipgoWrap').css('display','block');
            Make_Toast('잘못된 접근입니다. ');
        }else if(window.confirm('출고 처리 하시겠습니까?')==true){
            const params = {
                mtcode : mtcode,
                income : outcome,
                stocktyp : 2,
                reason : reason,
                memo : memo
            }
            let bool = await Patch_Material_Income(mtcode,params);
            if(bool==true){
                Make_Toast('입고 처리 하였습니다.');
            }
        }
    });



    $(document).on('click','button[name="select_output"]',function() {
        let mtcode = $(this).data('mtcode');
        let mtname = $(this).data('mtname');
        let mtyp = $(this).data('typstr');
        let mkname= $(this).data('mkname');
        let suname= $(this).data('suname');
        let typ = $(this).data('typ');
        let unit = $(this).data('uname');

        $('#o_mtcode').text(mtcode);
        $('#o_mtname').text(mtname);
        $('#pop_omtcode').val(mtcode);
        $('#o_mttype').text(mtyp);
        $('#o_mtmaker').text(mkname);
        $('#o_mtsupplier').text(suname);
        $('#pop_ounit').text(unit);
        $('#txt_pop_output').val('');
        $('#txt_pop_outcome').prop('disabled',false);
        $('#txt_omtmemo').val('');
        $('#txt_omtmemo').prop('disabled',false);
        $('#outputlist').remove();
        $('#o_reason').prop('disabled',false);
        $('#o_reason').focus();
    });


    $(document).on('click','button[name="select_input"]',function(){
        let mtcode = $(this).data('mtcode');
        let mtname = $(this).data('mtname');
        let mtyp = $(this).data('typstr');
        let mkname= $(this).data('mkname');
        let suname= $(this).data('suname');
        let typ = $(this).data('typ');
        let unit = $(this).data('uname');

        $('#mtcode').text(mtcode);
        $('#mtname').text(mtname);
        $('#pop_mtcode').val(mtcode);
        $('#mttype').text(mtyp);
        $('#mtmaker').text(mkname);
        $('#mtsupplier').text(suname);
        $('#pop_unit').text(unit);
        $('#txt_pop_input').val('');
        $('#txt_pop_income').prop('disabled',false);
        $('#txt_mtmemo').val('');
        $('#txt_mtmemo').prop('disabled',false);
        $('#inputlist').remove();
        $('#txt_pop_income').focus();

    });

    $(document).on('click','button[name="btn_showlog"]',function(){
        const mtcode = $(this).data('mtcode');
        go_inOutMaterial_Log(mtcode);
    });

    // $('#chulgoBtn').click(function () {
    //     $('#outWrap').css('display','block');
    // });

    $('#barcodeWrap #Xbtn, #barcodeWrap #Xbtn2').click(function () {
        $('#barcodeWrap').css('display','none');
    });

    $('#ipgoWrap #Xbtn, #ipgoWrap #Xbtn2').click(function () {
        $('#ipgoWrap').css('display','none');
    });

    $('#outWrap #Xbtn, #outWrap #Xbtn2').click(function () {
        $('#outWrap').css('display','none');
    });

    $('#cpage').on('click',function(){
        $('#p_wrap').css('width','81vw');
        Make_Html(Make_Search_Param());
    });

    input_Form_ini();
    output_Form_ini();


    Make_Html(Make_Search_Param());


});

function Make_Search_Param(){
    let skey = $('#txt_mtinfo').val();
    let page = $('#cpage').data('page');

    let param = {
        skey : skey,
        page : page
    }
    return param;
}



async function Patch_Material_Income(code,params){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"params": params};
        let url = APIURL + '/Patch_Meterial_Income';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            location.reload(true);
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    } finally {
        stop_spinner();
    }
    return bool;
}


function output_Form_ini(){
    $('#pop_omtcode').val('');
    $('#outputlist').empty();
    $('#o_mttype').text('');
    $('#o_mtcode').text('');
    $('#o_mtname').text('');
    $('#o_mtmaker').text('');
    $('#o_mtsupplier').text('');
    $('#txt_pop_output').val('');
    $('#txt_pop_outcome').prop('disabled',true);
    $('#o_reason').prop('disabled',true);
    $('#txt_pop_outcome').val('');
    $('#txt_omtmemo').val('');
    $('#pop_ounit').text('');

    $('#txt_omtmemo').prop('disabled',true);
    $('#outputlist').removeClass('active');

}

function input_Form_ini(){
    $('#pop_mtcode').val('');
    $('#inputlist').empty();
    $('#mttype').text('');
    $('#mtcode').text('');
    $('#mtname').text('');
    $('#mtmaker').text('');
    $('#mtsupplier').text('');
    $('#txt_pop_input').val('');
    $('#txt_pop_income').prop('disabled',true);
    $('#txt_pop_income').val('');
    $('#txt_mtmemo').val('');
    $('#pop_unit').text('');

    $('#txt_mtmemo').prop('disabled',true);
    $('#inputlist').removeClass('active');

}

async function Make_Html(data){
    let arr = await Load_data(data);
    let html = '';
    if(arr.tcnt > 0) {
        $.each(arr.list, function (index, el) {
            html += `
                    <tr id="tr_${el.mtcode}">
                        <td class="ltTbody">${el.mttype}</td>
                        <td class="ltTbody">${el.mtname}</td>
                        <td class="ltTbody" id="td1_${el.mtcode}">${el.total} ${el.unit}</td>
                        <td class="ltTbody" id="td2_${el.mtcode}">${el.indate}</td>
                        <td class="ltTbody">
                            <button type="button" class="btnType3 " name="btn_barcode" data-mtcode="${el.mtcode}" >${el.mtcode}</button>
                        </td>
                        <td class="ltTbody">
                            <button type="button" class="btnType3" name="btn_showlog" data-mtcode="${el.mtcode}">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                        </td>
                    </tr>
                `;
        });
        $('#inout_m_wrap').css('height','600px');
        $('#cpage').data('page',(data.page+1))
    }else{
        Make_Toast('검색된 데이터가 없습니다.');
        // html = '<tr><td class="ltThead" colspan="9">검색된 데이터가 없습니다.</td></tr>';
    }

    $('#tList').append(html);
    let nowcnt = $('#tcnt').html();
    if(nowcnt==='') nowcnt = 0;
    let newcnt = Number(nowcnt) + Number(arr.total);
    $('#tcnt').html(newcnt);


}

async function Load_data(data) {
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"params": data};
        let url = APIURL + '/Load_Material_Inout';
        let result = await Load_API_Auth(url, dataarr);
       if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
           r_arr = {
                list : result.get('data').list,
                tcnt : result.get('data').tcnt
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

async function Load_Material(stocktyp,param){
    try {
        start_spinner();
        let fkey = 0;
        let dataarr = {'data' : param};
        let url = APIURL + '/Load_MaterialList';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            if(Cnt > 0){
                let html = '';
                let sname = '';
                let listname = '';
                if(stocktyp==1){
                    sname = 'select_input';
                    listname = 'inputlist';
                }else{
                    sname = 'select_output';
                    listname = 'outputlist';
                }
                $.each(arr, function (index, el) {
                    html += `<button class="copyOption active" type="button" name="${sname}" data-typ="${el.typ}" data-mtcode="${el.mtcode}" data-mtname="${el.mtname}" data-typstr="${el.typ_str}" data-mkname="${el.fk_mkname}" data-suname="${el.fk_suname}" data-uname="${el.uname}">${el.mtname}</button>`;
                });
                $('#' + listname).append(html);
                $('#' + listname).addClass('active');
            }else{
                Make_Toast('검색된 상품이 없습니다.');
            }
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }finally {
        stop_spinner();
    }
}
