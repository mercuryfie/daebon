$(function() {

    $(".area_boxm9k > .outerBox > .right > i").click(function() {
        var $icon = $(this);
        var $content = $icon.closest(".area_boxm9k").find(".area_box2qd");

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


