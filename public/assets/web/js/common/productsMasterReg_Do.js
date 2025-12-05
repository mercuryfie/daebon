$(document).ready(function() {

    $(document).on('click','#btn_confirm', async function () {
        let category = $('#category').val();
        let goodsName = $('#goodsName').val();
        let goodsQuantity = $('#goodsQuantity').val();
        let goodsInventory = $('#goodsInventory').val();

        if (category == '') {
            $('#category').focus();
            Make_Toast('상품분류를 선택하세요.');
        } else if (goodsName == '') {
            $('#goodsName').focus();
            Make_Toast('제품평을 입력하세요');
        } else if (goodsQuantity == '') {
            $('#goodsQuantity').focus();
            Make_Toast('기준수량을 입력하세요');
        } else if (goodsInventory == '') {
            $('#goodsInventory').focus();
            Make_Toast('적정재고량을 입력하세요');
        } else {
            const container = $('div[name="materialBox"]');
            let goods_material = [];
            container.find('div[name="oneMate"]').each(function () {
                let selectVal = $(this).find('select[name="material_code"]').val();
                if(selectVal!='') {
                    let inputVal = $(this).find('input[name="material_cnt"]').val();
                    let t_arr = {
                        'code': selectVal,
                        'cnt': inputVal
                    }
                    goods_material.push(t_arr);
                }
            });
            let goods_info = {
                category: category,
                name: goodsName,
                quantity: goodsQuantity,
                inventory: goodsInventory,
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
                go_productsList();
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
        let pname = $('#goodsName').val();
        if(pname==''){
            $(this).val('');
            $('#metirialName').focus();
            Make_Toast('제품명을 입력하세요.');
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

});


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


async function Load_Before(skey){
    try {
        start_spinner();
        let dataarr = {"search" : skey};
        let url = APIURL + '/Load_Product_List';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            if(Cnt > 0){
                let html = '';
                $.each(arr, function (index, el) {
                    html = `<button class="copyOption active" type="button" name="option_Before" data-code="${el.pdcode}">${el.pdname}</button>`;
                });

                $('#beforelist').append(html);
                $('#beforelist').addClass('active');
            }else{
                Make_Toast('검색된 상품이 없습니다.');
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




