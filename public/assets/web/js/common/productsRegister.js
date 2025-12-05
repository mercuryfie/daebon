$(function() {

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


    /* 제품등록>제품bom>공정입력>부자재추가> add cover end  */


    $("button[name='nextBtn']").click(function() {
        let $mName = $("input[name='metirialName']").val();
        console.log($mName);
        go_manuRegister($mName);
        // var url = "/Goods/productsRegister";
        // $(location).attr("href", url);
    });


    $('#addCat2_wrap #Xbtn, #addCat2_wrap #Xbtn2').click(function () {
        $('#addCat2_wrap').css('display','none');
    });

});


