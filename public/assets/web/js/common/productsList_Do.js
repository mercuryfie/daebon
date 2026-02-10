$(document).ready(function() {

    let search = '';
    const data = {
        skey : search,
        page : $('#cpage').data('page')
    };
    Make_Html(search);


    $(document).on('click','button[name="btn_process"]',async function(){
        let quantity = $(this).closest('.flexType1').find('input[name="quantity"]').val();
        let code = $(this).closest('.flexType1').find('input[name="quantity"]').data('code');

        // let bool = await Make_instructions(code,quantity);
        // console.log(bool);
        // if(bool==true){
        //     if(window.confirm('작업지시를 발급하였습니다\n생산목록으로 이동하시겠습니까?')==true){
        //         go_productionList();
        //     }else{
        //         $(this).closest('.flexType1').find('input[name="quantity"]').val('');
        //         location.reload();
        //     }
        // }
    });

    $(document).on('keydown','input[name="quantity"]',function(e){
        if (e.key === "Enter") {
            e.preventDefault(); // 폼 전송 방지
            $(this).closest('.flexType1').find('button[name="btn_process"]').trigger('click');
        }

    });

    $(document).on('click','button[name="btn_process"]',async function(){
        let quantity = $(this).closest('.flexType1').find('input[name="quantity"]').val();
        let code = $(this).closest('.flexType1').find('input[name="quantity"]').data('code');

        let bool = await Make_instructions(code,quantity);
        console.log(bool);
        if(bool==true){
            if(window.confirm('작업지시를 발급하였습니다\n생산목록으로 이동하시겠습니까?')==true){
                go_productionList();
            }else{
                $(this).closest('.flexType1').find('input[name="quantity"]').val('');
                // location.reload();
            }
        }
    });

    $('#uploadExel #Xbtn, #uploadExel #Xbtn2').click(function () {
        $('#uploadExel').css('display','none');
    });

    $('#btn_search').on('click', function () {
        doSearch();
    });

    $('#txt_search').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doSearch();
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
            Upload_Excel('attachExcel',3,4);
            Make_Toast('업로드 성공하였습니다.');
            // $('#uploadExcel').css('display','none');

        }
    });

    $(document).on('click','button[name="btn_print"]',function(){
        let code = $(this).data('code');
        let url = "/goods/instructionform?cd=" + code;
        console.log('dawn1538',code);
        console.log('dawn1539',url);
        pop_OrderRoastForm(url);
    });

    $('.only-number').on('input', function () {
        let value = this.value.replace(/[^0-9.]/g, ''); // 숫자+소수점만

        // 소수점 2자리까지만
        let parts = value.split('.');
        if (parts[1] && parts[1].length > 2) {
            parts[1] = parts[1].substring(0, 2);
            value = parts.join('.');
        }

        // 맨앞 소수점 제거
        if (value.startsWith('.')) {
            value = value.substring(1);
        }

        this.value = value;
    });


    $("#pTable thead td").on("click", function () {
        let table = $("#pTable");
        let tbody = table.find("tbody");
        let rows = tbody.find("tr").toArray();

        let colIndex = $(this).data("col");

        let ascending = $(this).data("asc");
        if (ascending === undefined) {
            ascending = true; // 첫 클릭은 오름차순
        }

        $("#pTable thead td .dIcon").removeClass("fa-angle-up").addClass("fa-angle-down");

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

    $('#unit_typ').on('change',function(){
        let typ = $(this).val();
        if(typ=='') return ;
        if(typ=='kg'){
            $('span[name="u_type1"]').text('kg');
            $('span[name="u_type2"]').text('kg');
        }else if(typ=='g'){
            $('span[name="u_type1"]').text('g');
            $('span[name="u_type2"]').text('g');
        }else if(typ=='개'){
            $('span[name="u_type1"]').text('개');
            $('span[name="u_type2"]').text('g');
        }

    })

    $('#category').on('change',function(){
        form_ini();
    })



    $('#addMateWrap #Xbtn, #addMateWrap #Xbtn2').click(function () {
        $('#addMateWrap').css('display','none');
    });

    $('#btn_pop').on('click',function(){
        let typ = $(this).data('type');
        console.log('typ=' + typ);
        let gscode = $('#btn_pop').data('code');
        let category = $('#category').val();
        let gsname = $('#gname').val();
        let inventory = $('#inventory').val();
        let unit_weight = $('#unit_weight').val();
        let unit_typ = $('#unit_typ').val();
        let total_weight = $('#total_weight').val();
        let bool = false;
        if(typ==1){
            if(category==''){
                Make_Toast('분류를 선택하세요.');
                $('#category').focus();
            }else if(gsname==''){
                Make_Toast('제품명을 입력하세요.');
                $('#gname').focus();
            } else if(unit_typ=='') {
                Make_Toast('기본단위를 선택하세요.');
                $('#unit_typ').focus();
            }else if(inventory=='') {
                Make_Toast('적정용량을 입력하세요.');
                $('#inventory').focus();
            } else if(unit_weight=='') {
                Make_Toast('단위용량을 입력하세요.');
                $('#unit_weight').focus();
            } else if(total_weight=='') {
                Make_Toast('제품용량을 입력하세요.');
                $('#total_weight').focus();
            } else{
                let param = {
                    gsname : gsname,
                    category : category,
                    inventory : inventory,
                    unit_typ : unit_typ,
                    unit_weight : unit_weight,
                    t_cnt : total_weight
                };
                Data_Add(param);
            }
        }else {
            if (gscode == '') {
                Make_Toast('잘못된 접근입니다.');
            }else if(category==''){
                Make_Toast('분류를 선택하세요.');
                $('#category').focus();
            }else if(gname==''){
                Make_Toast('제품명을 입력하세요.');
                $('#gname').focus();
            }else if(inventory=='') {
                Make_Toast('텍스트를 입력하세요.');
                $('#inventory').focus();
            }else if(unit_weight=='') {
                Make_Toast('단위용량을 입력하세요.');
                $('#unit_weight').focus();
            }else if(total_weight=='') {
                Make_Toast('단위용량을 입력하세요.');
                $('#total_weight').focus();
            }else{
                let param = {
                    gscode : gscode,
                    gsname : gsname,
                    category : category,
                    inventory : inventory,
                    unit_typ : unit_typ,
                    unit_weight : unit_weight,
                    t_cnt : total_weight
                };
                Data_Edit(param);
            }
        }
    });

    $(document).on('click','button[name="btn_product_del"]',function(){
        let code = $(this).data('code');
        if(code==''){
            Make_Toast('잘못된 접근입니다.');
        }else if(window.confirm('삭제 하시겠습니까?')==true){
            Data_Delete(code);
        }
    });

    $('#execlUp').on('click',function(){
        $('#attachExcel').click(); // 숨겨진 파일 선택창 열기
    });

    $('#attachExcel').on('change', function () {
        let fname = $('#attachExcel').val();
        if(fname!='') {
            Upload_Execl('attachExcel',3,4);
        }
    });

});


async function Make_instructions(code,cnt){
    let r_bool = false;
    try {
        start_spinner();
        let dataarr = {"code" : code,"cnt" : cnt};
        let url = APIURL + '/Add_Instructions';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            r_bool = (data.gicode !='') ? true : false;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_bool;
}


let isSearching = false;

async function Data_Delete(code){
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Delete_Goods';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            $('#list_' + code).remove();
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

async function Data_Edit(param){
    try {
        start_spinner();
        let dataarr = {"data" : param};
        let url = APIURL + '/Edit_Goods';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {

            let params = {
                unit_type : param['unit_typ'],
                inventory : param['inventory'],
                t_cnt : param['t_cnt'],
                unit_weight : param['unit_weight']
            };

            let t_arr = fn_PrnUnitType(params);

            let container = $('#list_' + param['gscode']);
            let html = `<a href="javascript:;" onclick="Edit_Products('${param['gscode']}','${param['gsname']}','${param['category']}','${param['inventory']}','${param['unit_weight']}','${param['t_cnt']}','${param['unit_typ']}');" class="goodsName" name="gname">${param['gsname']}</a>`;
            container.find('[name="gnode"').html(html);
            container.find('[name="c_str"').text(fnGetProductNameByCode(param['category']));
            container.find('[name="inventory"').text(t_arr['cnt_str1']);
            container.find('[name="t_cnt"').text(t_arr['cnt_str2']);
            container.find('[name="unit_weight"').text(t_arr['cnt_str3']);
            form_ini();
            $('#addMateWrap').css('display','none');
            Make_Toast('수정되었습니다.');
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}


async function Data_Add(param){
    try {
        start_spinner();
        let dataarr = {"data" : param};
        let url = APIURL + '/Add_Goods';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : null;
            if(arr) {

                let params = {
                    unit_type : arr.unit_type,
                    inventory : arr.inventory,
                    t_cnt : arr.t_cnt,
                    unit_weight : arr.unit_weight
                };

                let t_arr = fn_PrnUnitType(params);



                let html = `
                    <tr id="list_${arr.gscode}">
                        <td class="ltTbody">${arr.gscode}</td>
                        <td class="ltTbody " name="gnode">
                            <a href="javascript:;" onclick="Edit_Products('${arr.gscode}','${arr.gsname}','${arr.category}','${arr.inventory}','${arr.unit_weight}','${arr.t_cnt}','${arr.unit_type}');" class="goodsName" name="gname">${arr.gsname}</a>
                        </td>
                        <td class="ltTbody" name="c_str">${fnGetProductNameByCode(arr.category)} </td>     
                        <td class="ltTbody" name="inventory">${t_arr['cnt_str1']}</td>
                        <td class="ltTbody" name="t_cnt">${t_arr['cnt_str2']}</td>
                        <td class="ltTbody" name="unit_weight">${t_arr['cnt_str3']}</td>
                        <td class="ltTbody">${arr.avg.total}</td> 
                        <td class="ltTbody">${arr.avg.avg}</td>
                        <td class="ltTbody"><button type="button" class="btnType3 " name="btn_bom_add" data-code="${arr.gscode}" onclick="go_productsMasterReg('${arr.gscode}');">등록</button>
                        <td class="ltTbody orderProduct"></td> 
                        <td class="ltTbody"></td>
                        <td class="ltThead">
                            <button type="button" class="btnType3 trashBtn" name="btn_product_del"  data-code="${arr.gscode}"> 
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#clist').prepend(html);
                form_ini();
                $('#addMateWrap').css('display','none');
            }

        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

function add_Products() {
    let title = '제품등록';
    let poptype = '1';
    let poptext = '등록';

    $('#p_title').html(title);
    $('#gname').val('');
    $('#category').val('');
    $('#unit_typ').val('');
    $('#inventory').val('');
    $('#unit_weight').val('');
    $('#total_weight').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    console.log();

    $('span[name="u_type"]').text('');
    $('#addMateWrap').css('display','block');
}

function form_ini(){
    $('#gname').val('');
    $('#unit_typ').val('');
    $('#inventory').val('');
    $('#unit_weight').val('');
    $('#total_weight').val('');
    // $('#btn_pop').data('code','');
    // $('#btn_pop').data('type','');
    $('span[name="u_type"]').text('');
}

function doSearch() {
    if (isSearching) return;  // 연타 방지

    isSearching = true;
    let btn = $('#btn_search');
    btn.prop('disabled', true).text('검색중...');

    let skey = $('#txt_search').val();
    $('#clist').empty();

    Make_Html(skey).finally(() => {
        // Make_Html 완료 후 복구
        isSearching = false;
        btn.prop('disabled', false).text('검색');
    });
}

function pop_UploadXlx() {

    $('#uploadExel').css('display','block');
}

function Edit_Products(code,name,cat,inven,unit_weight,t_cnt,unit_type){
    let title = '제품수정';
    let poptype = '2';
    let poptext = '수정';

    console.log('111=' + unit_type);

    $('#tBag_box').css('display','flex');
    $('#p_title').html(title);
    $('#category').val(cat);
    $('#gname').val(name);
    $('#inventory').val(inven);
    $('#unit_weight').val(unit_weight);
    $('#total_weight').val(t_cnt);
    $('#unit_typ').val(unit_type);
    $('#btn_pop').data('code',code);
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);


    $('#addMateWrap').css('display','block');
}

async function Make_Html(skey){
    let arr = await Data_Load(skey);
    console.log('dawn1525',arr);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            let bomstr = '';
            let bominput = '';
            let bomprn = '';
            let stock_css = '';
            let inventory = parseInt(el.inventory);
            let avgTotal = parseInt(el.avg.total);
            let cnt_str1 = '';
            let cnt_str2 = '';
            let cnt_str3 = '';
            if(inventory > avgTotal){
                stock_css =`low_stock active`;
            } else {
                stock_css =`belloff`;
            }
            bomprn = `
                    <button type="button" class="btnType3 printBtn" name="btn_print" data-code="${el.gcode}">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    `;
            if(el.gcode==''){
                bomstr =`<button type="button" class="btnType3 " name="btn_bom_add" data-code="${el.gscode}" onclick="go_productsMasterReg('${el.gscode}');">등록</button>`;
                bominput = '';
                bomprn = '';
            }else {
                bomstr = `<button type="button" class="btnType3 " name="btn_bom_add" data-code="${el.gcode}" onclick="go_productsEditor('${el.gcode}');">수정</button>`;
                bominput = `
                    <div class="flexType1">
                        <input type="search" name="quantity" class="countInput mr10" placeholder="수량(예:10)" data-code="${el.gcode}">
                        <button type="button" class="btnType3 submitBtn1" name="btn_process">확인</button>
                    </div>`;
                bomprn = `
                    <button type="button" class="btnType3 printBtn" name="btn_print" data-code="${el.gcode}">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    `;
            }

            let params = {
                unit_type : el.unit_type,
                inventory : el.inventory,
                t_cnt : el.t_cnt,
                unit_weight : el.unit_weight
            };

            let t_arr = fn_PrnUnitType(params);

            html += `
                <tr id="list_${el.gscode}" class="${stock_css}">
                    <td class="ltTbody ">${el.gscode}</td>
                    <td class="ltTbody " name="gnode">
                        <a href="javascript:;" onclick="Edit_Products('${el.gscode}','${el.gsname}','${el.category}','${el.inventory}','${el.unit_weight}','${el.t_cnt}','${el.unit_type}');" class="goodsName" name="gname">${el.gsname}</a>
                    </td>
                    <td class="ltTbody" name="c_str">${el.c_str}</td>                    
                    <td class="ltTbody" name="inventory">${t_arr['cnt_str1']}</td>
                    <td class="ltTbody" name="t_cnt">${t_arr['cnt_str2']}</td>
                    <td class="ltTbody" name="unit_weight">${t_arr['cnt_str3']}</td>
                    <td class="ltTbody ">${el.avg.total} ${el.unit_type}</td> 
                    <td class="ltTbody">${el.avg.avg} ${el.unit_type}</td> 
                    <td class="ltTbody">${bomstr}</td> 
                    <td class="ltTbody orderProduct">${bominput}</td> 
                    <td class="ltTbody">${bomprn}</td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3" name="btn_more" data-code="" onclick="go_halfListLog();">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 trashBtn"  name="btn_product_del"  data-code="${el.gscode}"> 
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td> 
                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#clist').append(html);
    $('#tcnt').html(arr.total);
}

async function Data_Load(skey){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"search" : skey};
        let url = APIURL + '/Load_Product';
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
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_arr;
}


