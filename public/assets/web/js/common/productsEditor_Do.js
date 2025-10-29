$(function() {
    $(document).on('click','button[name="addMaterial"]',function(){
        const $parent = $(this).closest('.rightSelectorBox');
        const $node = $parent.find('.rightSelector').first();
        const $clone = $node.clone();
        $clone.find('input[type="search"]')
        $clone.find('button[name="removeMaterial"]').css('display','flex');
        $clone.find('button[name="removeMaterial"]').addClass('flexType1');
        $clone.find('select').prop('selectedIndex', 0);
        $parent.append($clone);
    });


    $('#btn_confirm').on('click', function () {
        const $container = $('#materialBox');
        console.log($container.find('.rightSelector'));


        let data = [];

        $container.find('.selectMetirialBox').each(function () {
            const selectVal = $(this).find('select').val();
            const inputVal = $(this).find('input[type="search"]').val();
            data.push({selectVal, inputVal});
        });

        console.log(data);
        alert(JSON.stringify(data));
    });

    $(document).on('click','button[name="removeMaterial"]',function(){
        const oneMate = $(this).closest('[name="oneMate"]');
        oneMate.remove();
    });

    /* 제품등록>제품bom>공정입력>부자재추가> add cover start  */
    $(document).on('click','button[name="addCover"]',function(){
        const $parent = $(this).closest('.tBagBox');
        const $node = $parent.find('.oneTBag').first();
        const $clone = $node.clone();
        $clone.find('button[name="removeCover"]').css('display','flex');
        $clone.find('button[name="removeCover"]').addClass('flexType1');
        $clone.find('select').prop('selectedIndex', 0);
        $parent.append($clone);
    });



    $(document).on('click','button[name="removeCover"]',function(){
        const oneTBagCon = $(this).closest('[name="oneTBag"]');
        oneTBagCon.remove();
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

    $(document).on('click','i[name="removeThisRoast"]',function(){
        const oneRoast = $(this).closest('[name="oneRoast"]');
        oneRoast.remove();
    });

    /* 제품등록>제품bom>공정 박스 end  */



});

