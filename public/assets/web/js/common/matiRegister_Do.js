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

    $("button[name='addMati']").click(function() {
        let $firstMati = $("div[name='oneMati']").first();
        let $copy = $firstMati.clone();
        // var $copy = $("div[name='oneGoods']").clone();

        $copy.find(".must").removeClass("must").addClass("notmust");
        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='matiBox']").append($copy);
    });

    // $(document).ready(function () {
    //     $("button[name='removeMati']").click(function() {
    //         $(this).closest('[name="oneMati"]').remove();
    //         let $firstMati = $("div[name='oneMati']").first();
    //         $firstMati.find(".must").removeClass("notmust").addClass("must");
    //         console.log('hello');
    //     });
    //
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
        go_manuRegister($mName);
        // var url = "/Goods/productsRegister";
        // $(location).attr("href", url);
    });


});

function removeMati(btn) {
    let $matiBox = $("div[name='matiBox']");
    let thisMati = btn.closest('[name="oneMati"]');
    if (thisMati) thisMati.remove();

    let $firstMati = $matiBox.find("div[name='oneMati']").first();
    let $notmust = $firstMati.find(".notmust");
    if ($notmust.length > 0) {
        $notmust.removeClass("notmust").addClass("must");
        console.log('hello2');
    };
    console.log('hello');
}