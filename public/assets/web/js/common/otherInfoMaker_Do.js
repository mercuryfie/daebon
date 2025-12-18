$(document).ready(function() {


    const data = {
        skey : '',
        page : $('#cpage').data('page')
    };
    Load_Data(data);

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

    $('button[name="refreshBtn"]').click(function () {
        location.reload();
    });


    $('#addMaker').click(function () {
        $('#addMakerWrap').css('display','block');
    });

    $('#addMakerWrap #Xbtn, #addMakerWrap #Xbtn2').click(function () {
        $('#addMakerWrap').css('display','none');
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
        if(window.confirm('삭제하시겠습니까?')==true){
            let bool = await Del_Data(code);
            if(bool==true) {
                $('#tr_' + code).remove();
                Make_Toast('삭제하였습니다.');
            }
        }

    });

    $(document).on('click','#cpage',function(){
        let currentPage = parseInt($('#cpage').data('page'), 15);
        let nextPage = currentPage + 1;
        $('#cpage').data('page',nextPage);

        const data = {
            stype : '',
            page : nextPage
        };
        Load_Data(data);

    });

    $(document).on('click','#btn_pop',async function(){
        let typ = $(this).data('type');

        if(typ==1){ // 등록인 경우
            let name = $('#mname').val();
            let location = $('#lname').val();

            if(name==''){
                $('#mname').focus();
                Make_Toast('제조사명을 입력하세요.');
            } else{
                const data = {
                    name : name,
                    location : location,
                };
                let html = '';
                let el = await Add_Data(data);
                if(!fn_IsEmpty(el)){
                    html =`
                        <tr id="tr_${el.code}"> 
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Maker('${el.code}');">${el.code}</a>
                            </td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Maker('${el.code}');">${el.name}</a>
                            </td> 
                            <td class="ltHead col3" id="">
                                <p class="materialName" onclick="">${el.location}</p>
                            </td>  
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 removeBtn" id="del_${el.seq}" name="btn_del"  data-code="${el.code}" onclick="Del_Data('${el.code}');"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#mList').prepend(html);
                    $('#addMakerWrap').css('display','none');
                }
            }
        }else if(typ==2){ // 수정인 경우
            let code = $(this).data('code');
            let name = $('#mname').val();
            let location = $('#lname').val();

            if(name==''){
                $('#mname').focus();
                Make_Toast('제조사명을 입력하세요.');
            }else{
                const data = {
                    code : code,
                    name : name,
                    location : location
                };
                let html = '';
                let el = await Mod_Data(data,code);
                if(!fn_IsEmpty(el)){
                    html =`
                        <tr id="tr_${el.code}">
                            <td class="ltThead col1">${el.code}</td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Maker('${el.code}');">${el.name}</a>
                            </td>
                            <td class="ltThead col2">
                                <p class="materialName" onclick="">${el.location}</p>
                            </td> 
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 removeBtn" id="del_${el.code}" name="btn_del" data-code="${el.code}"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#tr_' + code).remove();
                    $('#mList').prepend(html);
                    $('#addMakerWrap').css('display','none');
                }
            }
        }
    });

});

async function Load_Data(data) {
    let typ = $(this).data('type');
    try {
        start_spinner();
        let dataarr = {'data' : data};
        let url = APIURL + '/Load_Maker';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let html = '';
            let data = result.get('data');
            let tCnt = data.tCnt;
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            if (Cnt > 0 ) {
                $.each(arr, function (index, el) {
                    html +=`
                        <tr id="tr_${el.code}"> 
                            <td class="ltHead col2" onclick="mod_Maker('${el.code}');">${el.code}</td> 
                            <td class="ltHead col3" id="name_${el.code}">
                                <a href="javascript:;" class="materialName" onclick="mod_Maker('${el.code}');">${el.name}</a>
                            </td>  
                            <td class="ltHead col3" id="">
                                <p class="materialName" onclick="">${el.location}</p>
                            </td>  
                            <td class="ltThead col3">
                                <button type="button" class="btnType3 removeBtn" name="btn_del"  id="del_${el.seq}" data-code="${el.code}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td> 
                        </tr>
                    `;
                    $('#cpage').show();
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
                $('#cpage').hide();
                console.log('daw',1458)
                Make_Toast('검색결과가 없습니다. ');
            }
            $('#mList').append(html);
            $('#tcnt').html(tCnt);
            $('#tcnt').data('cnt',tCnt);
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

function add_Maker() {
    let title = '제조사등록';
    let poptype = '1';
    let poptext = '등록';

    $('#p_title').html(title);
    $('#mname').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);
    $('#code_box').hide();

    $('#addMakerWrap').css('display','block');
}

async function mod_Maker(code) {
    let title = '제조사수정';
    let poptype = '2';
    let poptext = '수정';
    let arr = await Load_Pop(code);
    if(!fn_IsEmpty(arr)){
        $('#p_title').html(title);
        $('#mcode').html(arr[0].code);
        $('#mname').val(arr[0].name);
        $('#lname').val(arr[0].location);
        $('#btn_pop').data('code',code);
        $('#btn_pop').html(poptext);
        $('#btn_pop').data('type',poptype);
        $('#addMakerWrap').css('display','block');
    }
}

async function Add_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Add_Maker_Info';
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
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}

async function Mod_Data(data,code){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_Maker_Info';
        let result = await Load_API_Auth(url,dataarr);
        let html = '';
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            $('#addMakerWrap').css('display','none');

            Make_Toast('등록되었습니다. ');
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
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
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}

async function Load_Pop(code){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Load_Maker_Each';
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
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}


function form_Ini(){
    $('#mList').empty();
}