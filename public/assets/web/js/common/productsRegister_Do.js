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

    // $("button[name='addProducts']").click(function() {
    //     let $first = $("div[name='oneProducts']").first();
    //     let $copy = $("div[name='productsBox'] > div[name='oneProducts']").first().clone();
    //     // var $copy = $("div[name='oneGoods']").clone();
    //
    //     $each.removeClass("must");
    //     $each.addClass("notmust");
    //
    //     $copy.find("select").val("");
    //     $copy.find("input").val("");
    //
    //     $("div[name='productsBox']").append($copy);
    // });

    $("button[name='addRoasting']").click(function() {
        let $firstRoasting = $("div[name='oneRoasting']").first();
        let $copy = $firstRoasting.clone();

        $copy.find(".must").removeClass("must").addClass("notmust");
        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='roastingBox']").append($copy);
    });

    $("button[name='addTbag']").click(function() {
        let $firstTbag = $("div[name='oneTbag']").first();
        let $copy = $firstTbag.clone();

        $copy.find(".must").removeClass("must").addClass("notmust");
        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='tBagBox']").append($copy);
    });


    $("button[name='nextBtn']").click(function() {
        let $mName = $("input[name='metirialName']").val();
        console.log($mName);
        go_productsAfterRegister($mName);
        // var url = "/Goods/productsRegister";
        // $(location).attr("href", url);
    });


});