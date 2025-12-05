$(function() {
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

    /* 제품등록>제품bom>공정입력>부자재추가> add  cover start  */

    $(document).on('click','button[name="addCover"]',function(){
        const parent = $(this).closest('.tBagBox');
        const node = parent.find('.oneTBag').first();
        const clone = node.clone();

        clone.find('.removeBtn').attr('name', 'removeCover')
            .css('display','flex').addClass('flexType1');
        clone.find('i[name="fairy"]')
            .removeClass('fa-rotate-right')
            .addClass('fa-trash');
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


    /* 제품등록>제품bom>공정입력>부자재추가> add cover end  */
    /* 제품등록>제품bom>공정 박스 start  */

    $(document).on('click','button[name="addRoasting"]',function(){
        const $parent = $('#roast_box');
        const $node = $parent.find('.oneRoast').first();
        const $clone = $node.clone();

        const $firstCover = $clone.find('.oneTBag').first();
        $clone.find('.oneTBag').not(':first').remove();
        $firstCover.find('select').prop('selectedIndex', 0);

        $clone.find('i[name="removeThisRoast"]').css('display','block');
        $clone.find('input').not('.oneTBag input').val('');
        $clone.find('select').prop('selectedIndex', 0);
        $parent.append($clone);
    });

    /* 제품등록>제품bom>공정 박스 end  */

    $(document).on('click','i[name="removeThisRoast"]',function(){
        let nowStep = $('#stepCnt').val();
        nowStep--;
        if(nowStep<=1) nowStep = 1;
        $('#stepCnt').val(nowStep);
        const oneRoast = $(this).closest('[name="oneRoast"]');
        oneRoast.remove();
        resetStepNum();
    });

    $(document).on('click','#btn_confirm', async function () {
        console.log('start');
        let gcode = $('#gcode').val();
        let category = $('#category').val();
        let goodsName = $('#goodsName').val();
        let goodsQuantity = $('#goodsQuantity').val();
        let goodsInventory = $('#goodsInventory').val();

        if(category==''){
            $('#category').focus();
            Make_Toast('상품분류를 선택하세요.');
        }else if(goodsName==''){
            $('#goodsName').focus();
            Make_Toast('제품평을 입력하세요');
        }else if(goodsQuantity==''){
            $('#goodsQuantity').focus();
            Make_Toast('기준수량을 입력하세요');
        }else if(goodsInventory==''){
            $('#goodsInventory').focus();
            Make_Toast('적정재고량을 입력하세요');
        }else {
            const container = $('div[name="materialBox"]');
            let goods_material = [];
            container.find('div[name="oneMate"]').each(function () {
                let selectVal = $(this).find('select[name="material_code"]').val();
                if(selectVal!='')
                {
                    let inputVal = $(this).find('input[name="material_cnt"]').val();
                    let t_arr = {
                        'code': selectVal,
                        'cnt': inputVal
                    }
                    goods_material.push(t_arr);
                }
            });
            let material_cnt = goods_material.length;
            if(material_cnt<=0){
                Make_Toast('재료는 1개 이상은 입력되어야 합니다.');
            }else {


                let goods_info = {
                    gcode: gcode,
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
                        let prcode = $(this).data('prcode');
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
                            prcode: prcode,
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
                    let arr = await  Update_product(goods_info,goods_step);
                    go_productsList();
                }
            }
        }
    });

});

async function Update_product(info,step){
    let arr = {};
    try {
        start_spinner();
        let dataarr = {"info" : info,"step":step};
        let url = APIURL + '/mod_Goods_Info';
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