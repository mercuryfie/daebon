
$(document).ready(function() {


    $('#txt_before').on('focus',function(){
        $(this).val('');
        $('#beforelist').removeClass('active');
        $('#beforelist').empty();

    });

    $('#txt_before').on('keypress',async function(e){
        if (e.which === 13) {
            let skey = $(this).val();
            if(skey==''){
                Make_Toast('검색하실 상품명을 입력하세요.');
                $(this).focus();
            }else{
                $('#beforelist').empty();
                Load_Before(skey);
            }
        }
    });

    $(document).on('click', function(e) {
        const beforeList = $('#beforelist');
        if (!beforeList.hasClass('active')) {
            return;
        }
        const copyBox = $('.copyBox');
        if ($(e.target).closest(copyBox).length) {
            return;
        }
        $('#txt_before').val('');
        beforeList.removeClass('active').empty();
    });


    $(document).on('click','button[name="option_Before"]',function(){
        let pdcode = $(this).data('code');
        set_Data(pdcode);
        $('#txt_before').val('');
        $('#beforelist').removeClass('active').empty();
    });


    $('#barcodeWrap #Xbtn, #barcodeWrap #Xbtn2').click(function () {
        $('#barcodeWrap').css('display','none');
    });

    $('#ipgoWrap #Xbtn, #ipgoWrap #Xbtn2').click(function () {
        $('#ipgoWrap').css('display','none');
    });

    $('#outWrap #Xbtn, #outWrap #Xbtn2').click(function () {
        $('#outWrap').css('display','none');
    });

    $("#supply").on("change", function() {
        if ($(this).val() === "bySelf") {
            $("#supply").hide();
            $("#suppCom").show().focus();
        } else {
            $("#suppCom").hide();
        }
    });


});

function pop_barcodeWindow() {
    let url = "/inout/prn_barcode_material";
    let width = 430;
    let height = 320;

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

function pop_barcodeLayer() {
    $('#barcodeWrap').css('display','block');
}

function pop_ipgoView() {
    $('#ipgoWrap').css('display','block');
}

function pop_chulgoView() {
    $('#outWrap').css('display','block');
}

async function Load_Before(skey){
    try {
        start_spinner();
        let fkey = 0;
        let dataarr = {'skey' : skey, 'fkey' : fkey};
        console.log('🚀 최종 dataarr:', dataarr);
        let url = APIURL + '/Load_MaterialList';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let arr = (data && data.list) ? data.list : [];
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}


async function Before_Data_Load(pdcode) {
    let data = [];
    try {
        start_spinner();
        let dataarr = {"code": pdcode};
        let url = APIURL + '/Load_Product_Info';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = result.get('data').info;
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


async function set_Data(pdcode) {
    let arr = await Before_Data_Load(pdcode);
    let info = arr.info;
    if (info && Object.keys(info).length > 0) {
        let cat_str = '';
        if (info.pdcategory == 'A001') {
            cat_str = '원재료';
        } else {
            cat_str = '부자재';

        }
        $('#cat_data').text(cat_str);
        $('#m_code').text(info.pdcode);
        $('#m_name').text(info.pdname);
        $('#m_maker').text(info.pdname);
        $('#m_supplier').text(info.pdname);
        // theEditor.setData(info.content);
    }
    //
    //
    // let pouch = arr.material;
    // if (pouch && Object.keys(pouch).length > 0) {
    //     let html = '';
    //
    //     $.each(pouch, function (index, el) {
    //         html += `
    //             <div class="pouchTag  flexType2" name="add_pouch_info" data-mtcode="${el.fk_mtcode}">
    //                 <p class="pname" name="p_name" data-mtcode="${el.fk_mtcode}">${el.mtname}</p>
    //                 <p class="count" name="p_cnt" data-cnt="${el.cnt}">${el.cnt}개</p>
    //                 <i class="fa-solid fa-xmark" name="add_pouch_del"></i>
    //             </div>
    //         `;
    //     });
    //
    //     $('#pouch_list').empty();
    //     $('#pouch_list').append(html);
    // }
}

