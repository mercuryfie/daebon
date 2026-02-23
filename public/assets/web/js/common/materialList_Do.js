let tcnt = 0;

$(document).ready(function() {

    $('#addMate').click(function () {
        $('#addMateWrap').css('display','block');
    });

    $('#addMateWrap #Xbtn, #addMateWrap #Xbtn2').click(function () {
        $('#addMateWrap').css('display','none');
    });


    $("#maker").on("change", function() {
        if ($(this).val() === "bySelf") {
            $("#maker").hide();
            $("#makeCom").show().focus();
        } else {
            $("#makeCom").hide();
        }
    });

    $("#supply").on("change", function() {
        if ($(this).val() === "bySelf") {
            $("#supply").hide();
            $("#suppCom").show().focus();
        } else {
            $("#suppCom").hide();
        }
    });

    $('#cpage_box').on('click',function(){
        let search = '';
        let filter = 0;
        let page = $('#cpage_box').data('page');
        const data = {
            page : page,
            skey : search,
            fkey : filter
        };

        Load_Data(data);
    });

    $("#mTable thead th").on("click", function () {
        let table = $("#mTable");
        let tbody = table.find("tbody");
        let rows = tbody.find("tr").toArray();

        let colIndex = $(this).data("col");

        let ascending = $(this).data("asc");
        if (ascending === undefined) {
            ascending = true; // 첫 클릭은 오름차순
        }

        $("#mTable thead th .dIcon").removeClass("fa-angle-up").addClass("fa-angle-down");

        // 현재 th만 스타일 적용 및 방향 반전
        $(this).data("asc", !ascending);

        // 아이콘 변경
        let icon = $(this).find(".dIcon");
        if (ascending) {
            icon.removeClass("fa-angle-down").addClass("fa-angle-up");
        } else {
            icon.removeClass("fa-angle-up").addClass("fa-angle-down");
        }

        rows.sort(function (a, b) {
            let A = $(a).children("td").eq(colIndex).text().trim();
            let B = $(b).children("td").eq(colIndex).text().trim();

            let numA = parseFloat(A.replace(/,/g, ''));
            let numB = parseFloat(B.replace(/,/g, ''));

            // 숫자 비교
            if (!isNaN(numA) && !isNaN(numB)) {
                return ascending ? (numB - numA) : (numA - numB);
            }

            // 문자열 비교
            if (ascending) {
                return A > B ? -1 : (A < B ? 1 : 0);
            } else {
                return A < B ? -1 : (A > B ? 1 : 0);
            }
        });

        tbody.empty().append(rows);

    });

    $(document).on('click','button[name="btn_pop"]',function(){
        let typ = $(this).data('type');
        console.log(typ);
    });

    $(document).on('click','button[name="btn_del"]',async function(){
        let code = $(this).data('code');
        if(window.confirm('삭제하시겠습니까?')==true){
            let bool = await Del_Data(code);
            if(bool==true) {
                Make_Toast('삭제 하였습니다.');
                $('#tr_' + code).remove();
            }
        }

    });

    $('#mate_filter').on('change', function() {
        $('#mlist').empty();
        Make_Html(Make_Search_Param());
    });

    $('#btn_search').on('click',function(){
        $('#mlist').empty();
        Make_Html(Make_Search_Param());
    });

    $('#mkey').on("keypress", function (key) {
        if (key.keyCode == 13) {
            $('#mlist').empty();
            Make_Html(Make_Search_Param());
        }
    });

    $('#btn_reload').on('click',function(){
        location.reload();
    });

    $('#btn_pop').on('click',async function(){
        let typ = $(this).data('type');
        if(typ==1){
            let division = $('#division').val();
            let mname = $('#mname').val();
            let maker = $('#maker').val();
            let supply = $('#supply').val();
            let unit = $('#unit').val();
            let inventory = $('#inventory').val();

            if(division==''){
                $('#division').focus();
                Make_Toast('구분을 선택하세요');
            }else if(mname==''){
                $('#mname').focus();
                Make_Toast('원재료명을 입력하세요.');
            }else if(maker==''){
                $('#maker').focus();
                Make_Toast('제조사를 선택하세요.');
            }else if(supply==''){
                $('#supply').focus();
                Make_Toast('공급사를 선택하세요.');
            }else if(unit==''){
                $('#unit').focus();
                Make_Toast('단위를 선택하세요.');
            }else{
                const data = {
                    typ : division,
                    mname : mname,
                    maker : maker,
                    supply : supply,
                    unit : unit,
                    inventory : inventory
                };
                let html = '';
                let el = await Add_Data(data);
                console.log(el);
                if(!fn_IsEmpty(el)){
                    html =`
                        <tr id="tr_${el.code}">
                            <td class="ltThead col1 ">${el.typ_str}</td>
                            <td class="ltThead col2 ">
                                <a href="javascript:;" class="materialName" onclick="mod_Material('${el.code}');">${el.code}</a>
                            </td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Material('${el.code}');">${el.name}</a>
                            </td> 
                            <td class="ltTbody col5">${el.inventory} ${el.uname}</td>   
                            <td class="ltTbody col5">${el.avg}</td>
                            <td class="ltTbody col5">${el.stock}</td> 
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 trashBtn" id="del_${el.seq}" name="btn_del"  data-code="${el.code}"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#mlist').prepend(html);
                    $('#addMateWrap').css('display','none');
                }
            }
        }else if(typ==2){
            let mcode = $(this).data('code');
            let division = $('#division').val();
            let mname = $('#mname').val();
            let maker = $('#maker').val();
            let supply = $('#supply').val();
            let unit = $('#unit').val();
            let inventory = $('#inventory').val();

            if(mcode==''){
                alert('잘못된 접근입니다.');
                $(location).reload();
            }else if(division==''){
                $('#division').focus();
                Make_Toast('구분을 선택하세요');
            }else if(mname==''){
                $('#mname').focus();
                Make_Toast('부자재명을 입력하세요.');
            }else if(maker==''){
                $('#maker').focus();
                Make_Toast('제조사를 선택하세요.');
            }else if(supply==''){
                $('#supply').focus();
                Make_Toast('공급사를 선택하세요.');
            }else if(unit==''){
                $('#unit').focus();
                Make_Toast('단위를 선택하세요.');
            }else{
                const data = {
                    mcode : mcode,
                    typ : division,
                    mname : mname,
                    maker : maker,
                    supply : supply,
                    unit : unit,
                    inventory : inventory

                };
                let html = '';
                let el = await Mod_Data(data);
                if(!fn_IsEmpty(el)){
                    $('#tr_' + mcode).remove();
                    html =`
                        <tr id="tr_${el.code}">
                            <td class="ltThead col1">${el.typ_str}</td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Material('${el.code}');">${el.code}</a>
                            </td>
                            <td class="ltThead col2">
                                <a href="javascript:;" class="materialName" onclick="mod_Material('${el.code}');">${el.name}</a>
                            </td> 
                            <td class="ltTbody col5">${el.inventory} ${el.uname}</td>  
                            <td class="ltTbody col5">${el.avg}</td>
                            <td class="ltTbody col5">${el.stock}</td> 
                            <td class="ltThead col6">
                                <button type="button" class="btnType3 trashBtn" id="del_${el.seq}" name="btn_del" data-code="${el.code}"> 
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#mlist').prepend(html);
                    $('#addMateWrap').css('display','none');
                }
            }
        }
    });

    $('#excelPop').click(function () {
        $('#uploadExcel').css('display','block');
    });

    $('#uploadExcel #Xbtn, #uploadExcel #Xbtn2').click(function () {
        $('#uploadExcel').css('display','none');
        $('#attachExcel').val('');
    });

    $('#submitBtn').on('click', function () {
        // let fname = $('#attachExcel').val();
        const fname = $('#attachExcel').val();
        if(fname == '') {
            Make_Toast('업로드한 파일이 없습니다.');
        } else {
            Upload_Excel('attachExcel',3,3);
            $('#uploadExcel').css('display','none');

        }
    });

    Make_Html(Make_Search_Param());

});

function Make_Search_Param(){
    let skey = $('#mkey').val();
    let mate_filter = $('#mate_filter').val();

    let param = {
        skey : skey,
        filter : mate_filter
    }
    return param;
}

function form_Ini(){
    $('#mlist').empty();
}

function add_Material(mcode) {
    let title = '원자재등록';
    let poptype = '1';
    let poptext = '등록';

    $('#p_title').html(title);
    $('#division').val('');
    $('#mname').val('');
    $('#maker').val('');
    $('#supply').val('');
    $('#unit').val('');
    $('#inventory').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    $('#addMateWrap').css('display','block');
}

async function mod_Material(mcode) {
    let title = '원자재수정';
    let poptype = '2';
    let poptext = '수정';
    let arr = await Load_Pop(mcode);
    console.log(arr);
    if(!fn_IsEmpty(arr)){
        $('#p_title').html(title);
        $('#division').val(arr.typ);
        $('#mname').val(arr.name);
        $('#maker').val(arr.mcode);
        $('#supply').val(arr.scode);
        $('#unit').val(arr.uname);
        $('#inventory').val(arr.inventory);
        $('#btn_pop').data('code',mcode);
        $('#btn_pop').html(poptext);
        $('#btn_pop').data('type',poptype);


        $('#addMateWrap').css('display','block');
    }
}

async function Add_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Add_Material_Info';
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

async function Del_Data(code){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Del_Material_Info';
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

async function Mod_Data(data){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_Material_Info';
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


async function Make_Html(data){
    let arr = await Load_Data(data);
    console.log(arr);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {

            if (el.stock < el.inventory) {
                stock_css = 'low_stock active';
            } else {
                stock_css = '';
            }

            html +=`
                <tr id="tr_${el.mtcode}" class="${stock_css}"> 
                    <td class="ltTbody col1">${el.typ_str}</td>
                    <td class="ltTbody col2">
                        <a href="javascript:;" class="materialName" onclick="mod_Material('${el.mtcode}');">${el.mtcode}</a>
                    </td>
                    <td class="ltTbody col2">
                        <a href="javascript:;" class="materialName" onclick="mod_Material('${el.mtcode}');">${el.mtname}</a>
                    </td>
                    <td class="ltTbody col5">${number_format(el.inventory)} ${el.uname}</td>
                    <td class="ltTbody col4">${el.avg}</td>
                    <td class="ltTbody col5">${number_format(el.stock)} ${el.uname}</td>
                    <td class="ltTbody col6">
                        <button type="button" class="btnType3 trashBtn" id="del_${el.seq}" name="btn_del"  data-code="${el.mtcode}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#p_wrap').css('height','560px');
    }else{
        Make_Toast('검색된 데이터가 없습니다.');
    }
    $('#mlist').append(html);
    $('#tcnt').html(arr.total);
}

async function Load_Data(data){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"params" : data};
        let url = APIURL + '/Load_MaterialList2';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            tcnt = (data && data.tCnt) ? data.tCnt : 0;
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


async function Load_Pop(mcode){
    let arr = [];
    try {
        start_spinner();
        let dataarr = {"code" : mcode};
        let url = APIURL + '/Load_Material_Info';
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