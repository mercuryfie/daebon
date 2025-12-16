$(document).ready(function() {

    Load_Data('');

    const url = new URLSearchParams(window.location.search);
    const tp = url.get('tp');

    $('.tab').removeClass('active');

    if(tp == 1) {
        $('.tab').eq(0).addClass('active'); // 제조사관리
    } else if(tp == 2) {
        $('.tab').eq(1).addClass('active'); // 공급사관리
    } else {
        $('.tab').eq(0).addClass('active'); // 기본값
    }


    $('#addSupplier').click(function () {
        $('#addSupplierWrap').css('display','block');
    });

    $('#addSupplierWrap #Xbtn, #addSupplierWrap #Xbtn2').click(function () {
        $('#addSupplierWrap').css('display','none');
    });


    $(document).on('click','button[name="btn_search"]',function(){
        let key = $('#mkey').val();
        form_Ini();
        Load_Data(key);
    });

    $(document).on("keypress",'#mkey', function (key) {
        if (key.keyCode == 13) {
            let key = $(this).val();
            form_Ini();
            Load_Data(key);
        }
    });

    $(document).on('click','button[name="btn_del"]',async function(){
        let code = $(this).data('code');
        console.log('dawn1052',code);
        if(window.confirm('삭제하시겠습니까?')==true){
            let bool = await Del_Data(code);
            if(bool==true) {
                $('#tr_' + code).remove();
                // location.reload();
                Make_Toast('삭제 하였습니다.');
            }
        }

    });

    $(document).on('click','#btn_pop',async function(){
        let typ = $(this).data('type');

        if(typ==1){
            let name = $('#mname').val();

            if(name==''){
                $('#mname').focus();
                Make_Toast('공급사명을 입력하세요.');
            }else{
                const data = {
                    name : name,
                };
                let html = '';
                let el = await Add_Data(data);
                if(!fn_IsEmpty(el)){
                    html =`
                        <tr id="tr_${el.code}"> 
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Supplier('${el.code}');">${el.code}</a>
                            </td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Supplier('${el.code}');">${el.name}</a>
                            </td> 
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 removeBtn" id="del_${el.seq}" name="btn_del"  data-code="${el.code}" onclick="Del_Data('${el.code}');"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#sList').prepend(html);
                    $('#addSupplierWrap').css('display','none');
                }
            }
        }else if(typ==2){
            let code = $(this).data('code');
            let name = $('#mname').val();

            if(name==''){
                $('#mname').focus();
                Make_Toast('공급사명을 입력하세요.');
            }else{
                const data = {
                    code : code,
                    name : name,
                };
                let html = '';
                let el = await Mod_Data(data);
                if(!fn_IsEmpty(el)){
                    $('#tr_' + code).remove();
                    html =`
                        <tr id="tr_${el.code}"> 
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Supplier('${el.code}');">${el.code}</a>
                            </td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Supplier('${el.code}');">${el.name}</a>
                            </td> 
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 removeBtn" id="del_${el.seq}" name="btn_del" data-code="${el.code}"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#sList').prepend(html);
                    $('#addSupplierWrap').css('display','none');
                }
            }
        }
    });

});

async function Load_Data(skey) {
    let typ = $(this).data('type');
    try {
        start_spinner();
        let dataarr = {"key" : skey};
        let url = APIURL + '/Load_Supplier';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let html = '';
            let data = result.get('data');
            let tCnt = data.tCnt;
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            if (Cnt > 0) {
                $.each(arr, function (index, el) {
                    html +=`
                        <tr id="tr_${el.code}"> 
                            <td class="ltHead col2" onclick="mod_Supplier('${el.code}');">${el.code}</td> 
                            <td class="ltHead col3">
                                <a href="javascript:;" class="materialName" onclick="mod_Supplier('${el.code}');">${el.name}</a>
                            </td>  
                            <td class="ltThead col3">
                                <button type="button" class="btnType3 removeBtn" name="btn_del"  id="del_${el.seq}" data-code="${el.code}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td> 
                        </tr>
                    `;
                });
            }else{
                html = `
                    <tr>
                        <td class="ltTbody">-</td>
                        <td class="ltTbody">-</td> 
                        <td class="ltTbody">-</td> 
                        <td class="ltTbody">-</td>  
                    </tr>
                `;
            }
            $('#sList').empty();
            $('#sList').append(html);
            $('#tcnt').html(number_format(data.tCnt));
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

function add_Supplier() {
    let title = '공급사등록';
    let poptype = '1';
    let poptext = '등록';

    $('#p_title').html(title);
    $('#mname').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    $('#addSupplierWrap').css('display','block');
}

async function mod_Supplier(code) {
    let title = '공급사수정';
    let poptype = '2';
    let poptext = '수정';
    let arr = await Load_Pop(code);
    if(!fn_IsEmpty(arr)){
        $('#p_title').html(title);
        $('#mcode').html(arr[0].code);
        $('#mname').val(arr[0].name);
        $('#btn_pop').data('code',code);
        $('#btn_pop').html(poptext);
        $('#btn_pop').data('type',poptype);
        //
        $('#addSupplierWrap').css('display','block');
    } else {
        console.log('bello');
    }
}

async function Add_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Add_Supplier_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}

async function Mod_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_Supplier_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            $('#addSupplierWrap').css('display','none');
            Make_Toast('등록되었습니다. ');
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}

async function Del_Data(code){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Del_Maker_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
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

async function Load_Pop(code){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"key" : code};
        console.log('dawn2',dataarr)
        let url = APIURL + '/Load_Supplier';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
        }else{
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}


function form_Ini(){
    $('#sList').empty();
}