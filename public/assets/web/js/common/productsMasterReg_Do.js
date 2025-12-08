$(document).ready(function() {

    $(document).on('click','#btn_confirm', async function () {
        let gscode = $('#gscode').val();
        let Quantity = $('#Quantity').val();

        if (gscode == '') {
            $('#category').focus();
            Make_Toast('제품을 검색하세요. ');
        }else if(Quantity==''){
            $('#Quantity').focus();
            Make_Toast('제품 기본수량을 입력하세요.');
        } else {
            const container2 = $('#add_material');
            let goods_material = [];
            container2.find('div[name="add_product_info"]').each(function () {
                let gcode = $(this).data('code');
                let gcnt = $(this).find('p[name="mtcnt"]').data('cnt');
                let t_arr = {
                    gcode: gcode,
                    gcnt: gcnt
                }
                goods_material.push(t_arr);
            });
            if(goods_material.length<=0){
                Make_Toast('원자재 입력은 필수항목입니다.');
            }else{
                let goods_info = {
                    gscode : gscode,
                    quantity: Quantity,
                    material: goods_material
                };

                const container1 = $('div[name="roastBox"]');
                let goods_step = [];
                container1.find('div[name="oneRoast"]').each(function () {
                    let ptype = $(this).find('select[name="ptype"]').val();
                    if(ptype!='') {
                        let stepNum = $(this).find('input[name="stepNum"]').val();

                        let pname = $(this).find('input[name="processname"]').val();
                        let minput = $(this).find('input[name="material_input"]').val();
                        let moutput = $(this).find('input[name="material_output"]').val();
                        let memo = $(this).find('textarea[name="step_memo"]').val();
                        let accessory = [];
                        $(this).find('div[name="oneTBag"]').each(function () {
                            let acode = $(this).find('select[name="accessory"]').val();
                            let acnt = $(this).find('input[name="accessory_cnt"]').val();
                            let m_arr = {
                                'acode': acode,
                                'acnt': acnt
                            };
                            accessory.push(m_arr);
                        });

                        let m2_arr = {
                            stepNum: stepNum,
                            ptype: ptype,
                            pname: pname,
                            minput: minput,
                            moutput: moutput,
                            memo: memo,
                            accessory: accessory
                        };

                        goods_step.push(m2_arr);
                    }
                });

                let info_cnt = goods_info.length;
                let step_cnt = goods_step.length;
                if (info_cnt <= 0) {
                    Make_Toast('제품지시시 정보를 입력하세요.');
                } else if (step_cnt <= 0) {
                    Make_Toast('제품지지서에는 최소한 1개이상의 공정이 필요합니다.');
                } else {
                    let arr = await  Input_product(goods_info,goods_step);
                    go_productsMasterList();
                }
            }
        }


        $(document).on('click','button[name="option_Before"]',function(){
            let pdcode = $(this).data('code');
            set_Data(pdcode);
            $('#txt_before').val('');
            $('#beforelist').removeClass('active').empty();
        });

        $('#btn_reload').on('click',function(){
            location.reload();
        });

    });



    /* 제품등록>제품bom>공정 박스 start  */

    $(document).on('click','button[name="addRoasting"]',function(){
        const parent = $('div[name="roastBox"]');
        const node = parent.find('div[name="oneRoast"]').first();
        const clone = node.clone();

        const firstCover = clone.find('div[name="oneTBag"]').first();
        clone.find('div[name="oneTBag"]').not(':first').remove();
        firstCover.find('select').prop('selectedIndex', 0);

        clone.find('i[name="removeThisRoast"]').css('display','block');
        clone.find('p[name="unit_input"]').html('');
        clone.find('p[name="unit_output"]').html('');
        clone.find('input').val('');
        clone.find('select').prop('selectedIndex', 0);
        clone.find('textarea[name="step_memo"]').val('');
        let nowStep = $('#stepCnt').val();
        nowStep++;
        clone.find('input[name="stepNum"]').val(nowStep);
        parent.append(clone);
        $('#stepCnt').val(nowStep);
    });

    $(document).on('click','i[name="removeThisRoast"]',function(){
        let nowStep = $('#stepCnt').val();
        nowStep--;
        if(nowStep<=1) nowStep = 1;
        $('#stepCnt').val(nowStep);
        const oneRoast = $(this).closest('[name="oneRoast"]');
        oneRoast.remove();
        resetStepNum();
    });

    /* 제품등록>제품bom>공정 박스 end  */

    $(document).on('change','select[name="ptype"]',function(){
        let pname = $('#gname').val();
        if(pname==''){
            Make_Toast('제품을 검색하세요.');
        }else{
            let stxt = $(this).find('option:selected').text();
            let new_pname = pname + ' - ' + stxt;
            let styp = $(this).find('option:selected').data('type');
            let unit = (styp=='1') ? 'g' : 'ea';
            $(this).parent().parent().parent().find('[name="unit_input"]').html(unit);
            $(this).parent().parent().parent().find('[name="unit_output"]').html(unit);
            $(this).parent().parent().find('[name="processname"]').val(new_pname);
        }
    });

    // front js start



    $(".area_boxm9k > .outerBox > .right > .foldBtn").click(function() {
        let $foldBtn = $(this);
        let $icon = $(this > 'i');
        let $content = $foldBtn.closest(".area_boxm9k").find(".area_box2qd");

        // .area_box2qd 슬라이드 토글
        $content.slideToggle(200);

        // i 아이콘 클래스 변경
        if ($icon.hasClass("fa-angle-down")) {
            $icon.removeClass("fa-angle-down").addClass("fa-angle-up");
        } else {
            $icon.removeClass("fa-angle-up").addClass("fa-angle-down");
        }
    });

    $("button[name='addRoasting']").click(function() {
        let $firstRoasting = $("div[name='oneRoasting']").first();
        let $copy = $firstRoasting.clone();

        // $copy.find(".must").removeClass("must").addClass("notmust");
        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='roasting_boxp9x']").append($copy);
    });


    $(document).on('click','button[name="addMaterial"]',function(){
        const parent = $(this).closest('.rightSelectorBox');
        const node = parent.find('.rightSelector').first();
        const clone = node.clone();
        clone.find('input[type="search"]')
        clone.find('button[name="removeMaterial"]').css('display','flex');
        clone.find('button[name="removeMaterial"]').addClass('flexType1');
        clone.find('select').prop('selectedIndex', 0);
        clone.find('input').val('');
        parent.append(clone);
    });


    $(document).on('click','button[name="removeMaterial"]',function(){
        const oneMate = $(this).closest('[name="oneMate"]');
        const container = $(this).closest('[name="coverMaterial"]').find('div[name="materialBox"]');
        let cnt = 0;
        container.find('div[name="oneMate"]').each(function () {
            cnt++;
        });

        if(cnt > 1){
            oneMate.remove();
        }else{
            oneMate.find('select[name="material_code"]').val('');
            oneMate.find('input[name="material_cnt"]').val('');
        }
    });

    /* 제품등록>제품bom>공정입력>부자재추가> add cover start  */
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

    $('#btn_search').on('click', function () {
        doSearch();
    });

    $('#txt_search').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doSearch();
        }
    });

    $('#txt_product').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doMaterialSearch();
        }
    });

    $('#btn_product').on('click', function () {
        doMaterialSearch();
    });


    $(document).on('click','button[name="btn_selected"]',function(){
        let gscode = $(this).data('gscode');
        let gsname = $(this).data('gsname');
        let category = $(this).data('category');
        let inventory = $(this).data('inventory');
        let unitwight = $(this).data('unitwight');

        form_ini();
        $('#gscode').val(gscode);
        $('#gname').val(gsname);
        $('#txt_search').val(gsname);
        $('#txt_category').text(fnGetProductNameByCode(category));
        $('#txt_Inventory').text(number_format(inventory)+'개');
        $('#txt_unitwight').text(unitwight+'g');
        $('#Quantity').focus();
    });

    $('.only-number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // 숫자가 아닌 것 전부 제거
    });

    $(document).on('click','button[name="btn_material"]',function(){
        let mtcode = $(this).data('mtcode');
        let mtname = $(this).data('mtname');
        if((mtcode=='') || (mtname=='')){
            Make_Toast('잘못된 접근입니다.');
        }else{
            $('#addproduct').data('mtcode',mtcode);
            $('#addproduct').data('mtname',mtname);
            $('#product_list').empty().removeClass('active');
            $('#txt_product_num').val('').focus();
        }
    });

    $('#addproduct').on('click',function(){
        let mtcode = $(this).data('mtcode');
        let mtname = $(this).data('mtname');
        Set_Material(mtcode,mtname);
    });

    $('#txt_product_num').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            let mtcode = $('#addproduct').data('mtcode');
            let mtname = $('#addproduct').data('mtname');
            Set_Material(mtcode,mtname);
        }
    });


    /* 제품BOM등록>공정입력>부자재추가> add cover end  */

    $("button[name='nextBtn']").click(function() {
        let $mName = $("input[name='metirialName']").val();
        console.log($mName);
        go_manuRegister($mName);
    });


    $('#addCat2_wrap #Xbtn, #addCat2_wrap #Xbtn2').click(function () {
        $('#addCat2_wrap').css('display','none');
    });

    // front js end

    $(document).on('click','i[name="add_product_del"]',function(){
        $(this).closest('div[name="add_product_info"]').remove();
    });

});

function Set_Material(mtcode,mtname){
    let mtcnt = $('#txt_product_num').val();
    if((mtcode=='') || (mtname=='') || (mtcnt=='')) {
        Make_Toast('잘못된 접근입니다.');
    }else {
        let html = `
                <div class="productTag  flexType3" name="add_product_info" data-code="${mtcode}">
                    <div class="flexType2">
                        <p class="pname" name="mtname">${mtname}</p>
                        <p class="count" name="mtcnt" data-cnt="${mtcnt}">${number_format(mtcnt)}g</p>
                    </div>
                    <i class="fa-solid fa-xmark" name="add_product_del"></i>
                </div>
            `;
        $('#add_material').append(html);
        $('#addproduct').data('mtcode','');
        $('#addproduct').data('mtname','');
        $('#txt_product').val('');
        $('#txt_product_num').val('');
    }
}


function form_ini(){
    $('#gcode').val('');
    $('#gname').val('');
    $('#category').val('');
    $('#inventory').val('');
    $('#txt_search').val('');
    $('#txt_category').text('');
    $('#txt_Inventory').text('');
    $('#glist').empty();
    $('#glist').removeClass('active');
}

function doMaterialSearch(){
    let skey = $('#txt_product').val();
    if(skey==''){
        Make_Toast('제품코드 또는 제품명을 입력하세요');
    }else{
        Material_Data_Load(skey);
    }
}

function doSearch(){
    let skey = $('#txt_search').val();
    if(skey==''){
        Make_Toast('제품코드 또는 제품명을 입력하세요');
    }else{
        Data_Load(skey);
    }
}

async function Material_Data_Load(skey){
    try {
        start_spinner();
        let dataarr = {"key" : skey};
        let url = APIURL + '/Load_MaterialList';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let html = '';
            arr = (data && data.list) ? data.list : [];
            console.log(arr);
            if(arr.length > 0){
                $.each(arr, function (index, el) {
                    html += `
                        <button class="copyOption active" data-mtcode="${el.mtcode}" data-mtname="${el.mtname}"  name="btn_material">${el.mtname}</button>
                    `;
                });
                console.log(html);
                $('#product_list').empty();
                $('#product_list').append(html);
                $('#product_list').addClass('active');
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

async function Data_Load(skey){
    try {
        start_spinner();
        let dataarr = {"search" : skey};
        let url = APIURL + '/Load_Product';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let html = '';
            arr = (data && data.list) ? data.list : [];
            console.log(arr);
            if(arr.length > 0){
                $.each(arr, function (index, el) {
                    html += `
                        <button class="copyOption active" data-gscode="${el.gscode}" data-gsname="${el.gsname}" data-category="${el.category}" data-inventory="${el.inventory}" data-unitwight="${el.unit_wight}" name="btn_selected">${el.gsname}</button>
                    `;
                });
                console.log(html);
                $('#glist').empty();
                $('#glist').append(html);
                $('#glist').addClass('active');
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







async function Input_product(info,step){
    let arr = {};
    try {
        start_spinner();
        let dataarr = {"info" : info,"step":step};
        let url = APIURL + '/Add_Goods_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let arr = result.get('data');
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


function resetStepNum() {
    $('div[name="oneRoast"]').each(function(index) {
        $(this).find('input[name="stepNum"]').val(index + 1);
    });
}

