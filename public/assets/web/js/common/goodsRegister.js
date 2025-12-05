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

    $('#addProductWrap #Xbtn, #addProductWrap #Xbtn2').click(function () {
        $('#addProductWrap').css('display','none');
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

    /* 상품등록>제품등록 팝업 end  */

    $("div[name='mached'] > i").click(function() {
        $(this).closest("div[name='mached']").css("display", "none");
    });

    initCkEditor('#ckeditor');
});


function pop_addProduct() {
    $('#addProductWrap').css('display','block');
}