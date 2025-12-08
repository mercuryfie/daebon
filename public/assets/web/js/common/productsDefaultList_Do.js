$(document).ready(function() {
    Make_Html('');

    $('#btn_search').on('click', function () {
        doSearch();
    });

    $('#txt_search').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doSearch();
        }
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

    $('#addMateWrap #Xbtn, #addMateWrap #Xbtn2').click(function () {
        $('#addMateWrap').css('display','none');
    });

    $('#btn_pop').on('click',function(){
        let typ = $(this).data('type');
        let gscode = $('#btn_pop').data('code');
        let category = $('#category').val();
        let gsname = $('#gname').val();
        let inventory = $('#inventory').val();
        let unit_wight = $('#unit_wight').val();
        let bool = false;
        if(typ==1){
            if(category==''){
                Make_Toast('분류를 선택하세요.');
                $('#category').focus();
            }else if(gname==''){
                Make_Toast('제품명을 입력하세요.');
                $('#gname').focus();
            }else if(inventory=='') {
                Make_Toast('적정수량을 입력하세요.');
                $('#inventory').focus();
            }else if(unit_wight=='') {
                Make_Toast('단위용량을 입력하세요.');
                $('#unit_wight').focus();
            }else{
                let param = {
                    gsname : gsname,
                    category : category,
                    inventory : inventory,
                    unit_wight : unit_wight
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
                Make_Toast('적정수량을 입력하세요.');
                $('#inventory').focus();
            }else if(unit_wight=='') {
                Make_Toast('단위용량을 입력하세요.');
                $('#unit_wight').focus();
            }else{
                let param = {
                    gscode : gscode,
                    gsname : gsname,
                    category : category,
                    inventory : inventory,
                    unit_wight : unit_wight
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

});

async function Data_Delete(code){
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Delete_Product';
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
        let url = APIURL + '/Edit_Product';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
           let container = $('#list_' + param['gscode']);
           let html = `<a href="javascript:;" onclick="Edit_Products('${param['gscode']}','${param['gsname']}','${param['category']}','${param['inventory']}');" class="goodsName" name="gname">${param['gsname']}</a>`;
            container.find('[name="gnode"').html(html);
            container.find('[name="c_str"').text(fnGetProductNameByCode(param['category']));
            container.find('[name="inventory"').text(number_format(param['inventory'])+'개');
            container.find('[name="unit_wight"').text(number_format(param['unit_wight'])+'g');
            form_ini();
            $('#addMateWrap').css('display','none');
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
        let url = APIURL + '/Add_Product';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : null;
            if(arr) {
                let html = `
                    <tr id="list_${arr.gscode}">
                        <td class="ltTbody">${arr.gscode}</td>
                        <td class="ltTbody " name="gnode">
                            <a href="javascript:;" onclick="Edit_Products('${arr.gscode}','${arr.gsname}','${arr.category}','${arr.inventory}','${arr.unit_wight}');" class="goodsName" name="gname">${arr.gsname}</a>
                        </td>
                        <td class="ltTbody" name="c_str">${fnGetProductNameByCode(arr.category)}</td>     
                        <td class="ltTbody" name="inventory">${number_format(arr.inventory)}개</td>
                        <td class="ltTbody" name="inventory">${arr.unit_wight}g</td>
                        <td class="ltTbody">${arr.avg.total}</td>
                        <td class="ltTbody">${arr.avg.input}</td>
                        <td class="ltTbody">${arr.avg.output}</td>
                        <td class="ltTbody">${arr.avg.avg}</td>
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
    $('#category').val('');
    $('#gname').val('');
    $('#inventory').val('');
    $('#unit_wight').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    $('#addMateWrap').css('display','block');
}

function form_ini(){
    $('#category').val('');
    $('#gname').val('');
    $('#inventory').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html('');
    $('#btn_pop').data('type','');
}

function doSearch() {
    let skey = $('#txt_search').val();
    $('#clist').empty();
    Make_Html(skey);
}

function Edit_Products(code,name,cat,inven,unit_wight){
    let title = '제품수정';
    let poptype = '2';
    let poptext = '수정';

    $('#p_title').html(title);
    $('#category').val(cat);
    $('#gname').val(name);
    $('#inventory').val(inven);
    $('#unit_wight').val(unit_wight);
    $('#btn_pop').data('code',code);
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    $('#addMateWrap').css('display','block');
}

async function Make_Html(skey){
    let arr = await Data_Load(skey);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            html += `
                <tr id="list_${el.gscode}">
                    <td class="ltTbody">${el.gscode}</td>
                    <td class="ltTbody " name="gnode">
                        <a href="javascript:;" onclick="Edit_Products('${el.gscode}','${el.gsname}','${el.category}','${el.inventory}','${el.unit_wight}');" class="goodsName" name="gname">${el.gsname}</a>
                    </td>
                    <td class="ltTbody" name="c_str">${el.c_str}</td>                    
                    <td class="ltTbody" name="inventory">${number_format(el.inventory)}개</td>
                    <td class="ltTbody" name="unit_wight">${el.unit_wight}g</td>
                    <td class="ltTbody">${el.avg.total}</td>
                    <td class="ltTbody">${el.avg.input}</td>
                    <td class="ltTbody">${el.avg.output}</td>
                    <td class="ltTbody">${el.avg.avg}</td>
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


