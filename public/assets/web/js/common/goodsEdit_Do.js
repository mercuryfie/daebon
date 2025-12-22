$(document).ready(function(){
    Make_Html();

    $(".area_boxm9k > .outerBox > .right > .foldBtn").click(function() {
        // let $area = $(this);
        const $btn = $(this);
        const $icon = $btn.find("i");
        const $content = $btn.closest(".area_boxm9k").find(".area_box2qd");

        // .area_box2qd 슬라이드 토글
        // $content.slideToggle(200);
        $content.slideToggle(200, function () {
            // 토글 후 상태 기준으로 아이콘 변경
            if ($content.is(":visible")) {
                $icon.removeClass("fa-angle-up").addClass("fa-angle-down");
            } else {
                $icon.removeClass("fa-angle-down").addClass("fa-angle-up");
            }
        });
    });

    $('#txt_product').on('focus',function(){
        $(this).val('');
        $(this).data('code','');
        $('#goods_list').removeClass('active');
        $('#goods_list').empty();

    });

    $('#txt_product').on('keypress',async function(e){
        if (e.which === 13) {
            let skey = $(this).val();
            if(skey==''){
                Make_Toast('추가하실 제품명을 입력하세요.');
                $(this).focus();
            }else{
                $('#goods_list').empty();
                Find_Goods(skey);
            }
        }
    });

    $(document).on('click','button[name="btn_search_goods"]',function(){
        let code = $(this).data('code');
        let text = $(this).text();

        $('#txt_product').data('code', code);
        $('#txt_product').val(text);
        $('#goods_list').empty();
        $('#goods_list').removeClass('active');
        $('#txt_product_num').focus();
    });


    $('#attachImg').on('change', function(e) {
        let files = e.target.files;
        let thumbCount = $('[name="thumBox"]').length;

        if (thumbCount + files.length > 1) {
            Make_Toast('이미지는 1장만 등록 가능합니다.');
            $(this).val(''); // 파일 선택 취소
            return;
        }

        for (let i = 0; i < files.length; i++) {
            if (files[i].type.match('image.*')) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let $thumb = $(
                        `
                        <div class="thumBox" name="thumBox">
                            <img src="` + e.target.result + `" alt="img" class="addedImg">
                            <button type="button" class="delete-btn" onclick="">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>` );
                    $('#thumbArea').append($thumb);
                    $thumb.find('.delete-btn').on('click', function() {
                        $(this).closest('.thumBox').remove();
                        $('#attachImg').val('');
                    });
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });


    $('#addcode').on('click',function(){
        let excode = $('#excode').val();
        let extype = $('#extype option:selected').val();
        let exname = $('#extype option:selected').text();

        if(excode==''){
            Make_Toast('매칭하실 코드를 입력하세요.');
            $('#excode').focus();
        }else if((extype=='') || (exname=='')) {
            Make_Toast('매칭하실 쇼핑몰 선택하세요.');
            $('#extype').focus();
        }else {

            let html = '';
            html = `
                <div class="mached flexType2" data-extype="${extype}" name="mached">
                    <p class="code" name="m_code">${excode}</p>
                    <p class="market" name="m_market">${exname}</p>
                    <i class="fa-solid fa-xmark" name="mached_del"></i>
                </div>
            `;
            $('#mached_list').append(html);
            $('#excode').val('');
            $('#extype').val('');
        }
    });

    $('#addproduct').on('click',function(){
        let gcode = $('#txt_product').data('code');
        let gname = $('#txt_product').val();
        let cnt = $('#txt_product_num').val();
        if(gcode==''){
            Make_Toast('추가하실 체품을 검색하세요.');
            $('#txt_product').focus();
        }else if(cnt==''){
            Make_Toast('추가하실 체품 수량을 검색하세요.');
            $('#txt_product_num').focus();
        }else{
            let html = `
                <div class="productTag flexType3" name="add_product_info" data-code="${gcode}">
                    <p class="pname" name="gname">${gname}</p>
                    <p class="count" name="gcnt" data-cnt="${cnt}">${cnt}개</p>
                    <i class="fa-solid fa-xmark" name="add_product_del"></i>
                </div>
            `;
            $('#add_list').append(html);
            $('#txt_product').val('');
            $('#txt_product').data('code','');
            $('#txt_product_num').val('');
        }
    });


    $('#add_pouch').on('click',function(){
        // let gcode = $('#txt_cover').data('code');
        let p_code = $('#pouch_name').val();
        let p_name = $('#pouch_name option:selected').text();
        let p_cnt = $('#pouch_cnt').val();
        if(p_code==''){
            Make_Toast('부자재를 선택하세요.');
            $('#pouch_name').focus();
        }else if(p_cnt==''){
            Make_Toast('부자재 수량을 입력하세요.');
            $('#pouch_cnt').focus();
        }else{
            let html = `
                <div class="pouchTag flexType3" name="add_pouch_info" id="" data-code="${p_code}">
                    <p class="pname" name="p_name">${p_name}</p>
                    <p class="count" name="p_cnt" data-cnt="${p_cnt}">${p_cnt}개</p>
                    <i class="fa-solid fa-xmark" name="add_pouch_del"></i>
                </div>
            `;
            $('#pouch_list').append(html).addClass('active');
            $('#pouch_name').val('');
            $('#pouch_cnt').val('');
        }
    });

    $(document).on('click', 'i[name="mached_del"]', function () {
        $(this).closest('div[name="mached"]').remove();
    });

    $(document).on('click', 'i[name="add_product_del"]', function() {
        $(this).closest('div[name="add_product_info"]').remove();
    });

    $(document).on('click', 'i[name="add_pouch_del"]', function() {
        $(this).closest('div[name="add_pouch_info"]').remove();
    });

    $(document).on('click', '.delete-btn', function () {
        if(window.confirm('삭제하시겠습니까?')==true){
            $(this).closest('.thumBox').remove();
            $('#attachImg').val('');
            Make_Toast('삭제하였습니다.');
            // let bool = await Del_Data(code);
            // if(bool==true) {
            //     $(this).closest('.thumBox').remove();
            //     $('#attachImg').val('');
            //     Make_Toast('삭제 하였습니다.');
            // }
        }

    });

    $('#submitBtn').on('click',async function(){
        let category = $('#category').val();
        let pTitle = $('#pTitle').val();
        let pPrice = $('#pPrice').val();
        let pWeigth = $('#pWeight').val();
        let sell_type = $('#sell_type').val();
        let fileCount = $('#attachImg')[0].files.length;
        let bfileCount = $('#thumBox').length;
        let pdcode = $('#pdcode').val();
        if(pdcode=='') {
            Make_Toast('잘못된 접근입니다.');
        }else if(category ==''){
            Make_Toast('대분류를 선택하세요.');
            $('#category').focus();
        }else if(pTitle==''){
            Make_Toast('상품명을 입력하세요');
            $('#pTitle').focus();
        }else if(pPrice==''){
            Make_Toast('가격을 입력하세요.');
            $('#pPrice').focus();
        }else if(pWeigth==''){
            Make_Toast('중량을 입력하세요.');
            $('#pWeigth').focus();
        }else if(sell_type=='') {
            Make_Toast('판매여부를 선택하세요.');
            $('#sell_type').focus();
        }else if((fileCount===0) && (bfileCount===0)){
            Make_Toast('대표이미지를 선택하세요.');
            $('#attachImg').focus();
        }else {
            const container2 = $('#add_list');
            let goods_arr = [];
            container2.find('div[name="add_product_info"]').each(function () {
                let gcode = $(this).data('code');
                let gcnt = $(this).find('p[name="gcnt"]').data('cnt');
                let t_arr = {
                    gcode: gcode,
                    gcnt: gcnt
                }
                goods_arr.push(t_arr);
            });
            if (goods_arr.length === 0) {
                Make_Toast('제품 추가 정보는 필수 사항입니다.');
                $('#txt_product').focus();
            }else {
                let str_editor = theEditor.getData();
                let product_arr = {
                    pdcode: pdcode,
                    pTitle: pTitle,
                    pPrice: parseInt(pPrice.replace(/,/g, '')),
                    pWeigth: parseInt(pWeigth.replace(/,/g, '')),
                    sell_type: sell_type,
                    category: category,
                    str_editor: str_editor
                };

                let file_arr = {fname: ''};
                if(fileCount > 0) {
                    let fname = await Upload_File(pdcode);
                    file_arr = {fname: fname};
                }

                const container1 = $('#mached_list');
                let maching_arr = [];
                container1.find('div[name="mached"]').each(function () {
                    let market_type = $(this).data('extype');
                    let market_code = $(this).find('p[name="m_code"]').text();
                    let t_arr = {
                        m_code: market_code,
                        m_type: market_type
                    }
                    maching_arr.push(t_arr);
                });


                const container3 = $('#pouch_list');
                let pouch_arr = [];
                container3.find('div[name="add_pouch_info"]').each(function () {
                    let pcode = $(this).find('select[name="pouch_name"]').val();
                    let pcnt = $(this).find('input[name="pouch_cnt"]').val();
                    if(p_code!='') {
                        let p_arr = {
                            pcode: pcode,
                            pcnt: pcnt
                        };
                        console.log('dawn1737',p_arr)
                        pouch_arr.push(p_arr);
                    }
                });

                // const container3 = $('#cover_box');
                // let material_arr = [];
                // container3.find('div[name="oneTBag"]').each(function () {
                //     let acode = $(this).find('select[name="accessory"]').val();
                //     let acnt = $(this).find('input[name="accessory_cnt"]').val();
                //     if(acode!='') {
                //         let m_arr = {
                //             'acode': acode,
                //             'acnt': acnt
                //         };
                //         material_arr.push(m_arr);
                //     }
                // });

                let return_arr = {
                    info: product_arr,
                    file: file_arr,
                    macthing: maching_arr,
                    goods: goods_arr,
                    material: pouch_arr
                };

                console.log(return_arr);

                let bool = await Mod_Data(return_arr);
                if (bool === true) {
                    // go_goodsList();
                } else {
                    Make_Toast('상품 수정에 실패 하였습니다.');
                }
            }
        }
    });

    $('#btn_cancel').on('click',function(){
        go_goodsList();
    });


    $(document).on('click','button[name="addCover"]',function(){
        const parent = $(this).closest('.tBagBox');
        const node = parent.find('.oneTBag').first();
        const clone = node.clone();
        clone.find('button[name="removeCover"]').css('display','flex');
        clone.find('button[name="removeCover"]').addClass('flexType1');
        clone.find('select').prop('selectedIndex', 0);
        clone.find('input').val('');
        parent.append(clone);
    });


    $(document).on('click','button[name="removeCover"]',function(){
        const oneTBagCon = $(this).closest('[name="oneTBag"]');
        const container = $(this).closest('[name="coverBox"]').find('div[name="tBagBox"]');
        let cnt = 0;
        container.find('div[name="oneTBag"]').each(function () {
            cnt++;
        });
        if(cnt > 1){
            oneTBagCon.remove();
        }else{
            oneTBagCon.find('select[name="accessory"]').val('');
            oneTBagCon.find('input[name="accessory_cnt"]').val('');
        }
    });


    initCkEditor('#ckeditor');

});


async function Mod_Data(param){
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"data" : param};
        let url = APIURL + '/Edit_Product';
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


async function Make_Html() {
    let pdcode = $('#pdcode').val();
    let arr = await Data_Load(pdcode);
    console.log(arr);
    let info = arr.info;
    if (info && Object.keys(info).length > 0) {
        $('#category').val(info.pdcategory);
        $('#pTitle').val(info.pdname);
        $('#pPrice').val(info.pdprice);
        $('#pWeight').val(info.pdweigth);
        $('#sell_type').val(info.is_sale);
        theEditor.setData(info.content);
    }

    let img = arr.file;
    if (img && Object.keys(img).length > 0) {
        let html = '';
        let shortDate = img[0].indate.split(' ')[0].replace(/-/g, '');
        html += ` 
            <div class="thumBox" name="thumBox" id="thumBox">
              <img src="/assets/upload/goods/` + shortDate + `/`+ img[0].fname + `" alt="img" class="addedImg">
              <button type="button" class="delete-btn" onclick="">
                 <i class="fa-solid fa-xmark"></i>
              </button>   
            </div> 
        `;
        $('#thumbArea').empty();
        $('#thumbArea').append(html);
    }

    let match = arr.match;
    if (match && Object.keys(match).length > 0) {
        let html = '';
        $.each(match, function (index, el) {
            html += `
                <div class="mached flexType2" data-extype="${el.ex_type}" name="mached">
                    <p class="code" name="m_code">${el.fk_excode}</p>
                    <p class="market" name="m_market">${getNameByCode(el.ex_type)}</p>
                    <i class="fa-solid fa-xmark" name="mached_del"></i>
                </div>
            `;
        });
        $('#mached_list').empty();
        $('#mached_list').append(html);
    }

    let goods = arr.goods;
    if (goods && Object.keys(goods).length > 0) {
        let html = '';
        $.each(goods, function (index, el) {
            html += `
                <div class="productTag flexType3" name="add_product_info" data-code="${el.fk_gcode}">
                    <p class="pname" name="gname">${el.gsname}</p>
                    <p class="count" name="gcnt" data-cnt="${el.cnt}">${el.cnt}개</p>
                    <i class="fa-solid fa-xmark" name="add_product_del"></i>
                </div>
            `;
        });
        $('#add_list').empty();
        $('#add_list').append(html);
    }

    // let goods = arr.goods;
    // const pouch_options = $('#pouch_name').html();
    // console.log(pouch_options);
    let pouch = arr.material;
    if (pouch && Object.keys(pouch).length > 0) {
        let html = '';

        $.each(pouch, function (index, el) {
            html += `
               <div class="pouchTag flexType3" name="add_pouch_info" id="" data-code="${p_code}">
                    <p class="pname" name="p_name">${p_name}</p>
                    <p class="count" name="p_cnt" data-cnt="${p_cnt}">${p_cnt}개</p>
                    <i class="fa-solid fa-xmark" name="add_pouch_del"></i>
               </div>
            `;
        });
        $('#pouch_list').empty();
        $('#pouch_list').append(html);
    }





}

function Make_select(originalOptions,selectedValue ){
    let parser = new DOMParser();
    let doc = parser.parseFromString('<select>' + originalOptions + '</select>', 'text/html');
    let optionElements = doc.querySelectorAll('option');
    optionElements.forEach(option => {
        if (option.value === selectedValue) {
            option.setAttribute('selected', 'selected');
        } else {
            option.removeAttribute('selected');
        }
    });
    let newOptionsHtml = Array.from(optionElements).map(opt => opt.outerHTML).join('');
    return newOptionsHtml;
}


async function Data_Load(pcode) {
    let data = [];
    try {
        start_spinner();
        let dataarr = {"code": pcode};
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

async function Find_Goods(skey) {
    let data = await Load_Data(skey);
    let html = '';
    if (!fn_IsEmpty(data)) {
        $.each(data, function (index, el) {
            html += `<button class="copyOption active" type="button" name="btn_search_goods" data-code="${el.gcode}">${el.gname}</button>`;
        });
        $('#goods_list').append(html);
        $('#goods_list').addClass('active');
    }else{
        Make_Toast('검색된 제품이 없습니다.');
        $('#txt_product').focus();
    }
}

async function Load_Data(skey){
    let data = [];
    try {
        start_spinner();
        let dataarr = {"skey" : skey};
        let url = APIURL + '/Search_Goods';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data');
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

async  function Upload_File(pdcode){
    let fname = '';
    try {
        start_spinner();
        let url = APIURL + '/Upload_file';
        let key = 'attachImg';
        let param = {
            pdcode : pdcode,
            upload_key : 'attachImg',
            upload_type: 1
        };
        let result = await Load_FileUpload(url,key,param);
        if (result.get('status') == 'ok') {
            fname = result.get('data').fileName;
        }else{
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return fname;
}
