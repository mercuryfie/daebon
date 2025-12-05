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
        this.value = this.value.replace(/[^0-9]/g, ''); // 숫자가 아닌 것 전부 제거
    });

    $('#addMateWrap #Xbtn, #addMateWrap #Xbtn2').click(function () {
        $('#addMateWrap').css('display','none');
    });

    $('#btn_pop').on('click',async function(){
        let typ = $(this).data('type');
        let gcode = $('#btn_pop').data('code');
        let category = $('#category').val();
        let gname = $('#gname').val();
        let quantity = $('#quantity').val();
        let inventory = $('#inventory').val();
        let bool = false;
        if(typ==1){
            console.log('22');
            if(category==''){
                Make_Toast('분류를 선택하세요.');
                $('#category').focus();
            }else if(gname==''){
                Make_Toast('제품명을 입력하세요.');
                $('#gname').focus();
            } else if(inventory=='') {
                Make_Toast('적정수량을 입력하세요.');
                $('#inventory').focus();
            }else{
                let param = {
                    gname : gname,
                    category : category,
                    gname : gname,
                    quantity : quantity,
                    inventory : inventory
                };
                bool = await Data_Add(param);
            }
        }else{

        }
    });



});

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
                let html = `
                    <tr>
                        <td class="ltTbody">
                            <input type="checkbox" name="goodsseq" id="goodsseq" value="${arr.seq}">
                        </td>
                        <td class="ltTbody">${arr.gcode}</td>
                        <td class="ltTbody ">
                            <a href="javascript:;" onclick="go_productsEditor('${arr.gcode}');" class="goodsName">${arr.gname}</a>
                        </td> 
                        <td class="ltTbody">${arr.inventory}</td>
                        <td class="ltTbody">${arr.avg.total}</td>
                        <td class="ltTbody">${arr.avg.input}</td>
                        <td class="ltTbody">${arr.avg.output}</td>  
                        <td class="ltThead">
                            <button type="button" class="btnType3 trashBtn" id="del_${arr.seq}" name="btn_del"  data-code="${el.mtcode}"> 
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                console.log(html);
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
    $('#quantity').val('');
    $('#inventory').val('');
    $('#btn_pop').data('code','');
    $('#btn_pop').html(poptext);
    $('#btn_pop').data('type',poptype);

    $('#addMateWrap').css('display','block');
}

function form_ini(){
    $('#category').val('');
    $('#gname').val('');
    $('#quantity').val('');
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

function Edit_Products(code,name,cat,quan,inven){
    let title = '제품수정';
    let poptype = '2';
    let poptext = '수정';

    $('#p_title').html(title);
    $('#category').val(cat);
    $('#gname').val(name);
    $('#quantity').val(quan);
    $('#inventory').val(inven);
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
                <tr>
                    <td class="ltTbody">${el.gcode}</td>
                    <td class="ltTbody ">
                        <a href="javascript:;" onclick="Edit_Products('${el.gcode}','${el.gname}','${el.category}','${el.quantity}','${el.inventory}');" class="goodsName">${el.gname}</a>
                    </td>
                    <td class="ltTbody">${el.c_str}</td>                   
                    <td class="ltTbody">${number_format(el.inventory)}개</td>
                    <td class="ltTbody">${el.avg.total}</td>
                    <td class="ltTbody">${el.avg.input}</td>
                    <td class="ltTbody">${el.avg.output}</td> 
                    <td class="ltTbody">${el.avg.avg}</td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 trashBtn" id="del_${arr.seq}" name="btn_del"  data-code="${el.mtcode}"> 
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
        let url = APIURL + '/Load_Goods_List';
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


