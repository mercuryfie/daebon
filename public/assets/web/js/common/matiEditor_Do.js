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

});


function add_matiBox(btn) {
    let $matiBox = $("div[name='matiBox']");
    let $firstMati = $('div[name="oneMati"]').first();
    let $last = $('div[name="oneMati"]').last();
    let $copy = $last.clone();

    let $notmust = $firstMati.find(".notmust");
    let $must = $last.find(".must");

    if ($notmust.length > 0) {
        $notmust.removeClass("notmust").addClass("must");
        console.log('hello2');
    }
    $copy.find("select").val("");
    $copy.find("input").val("");

    $matiBox.append($copy);

    if ($must.length > 0) {
        $notmust.removeClass("must").addClass("notmust");
        console.log('hello2');
    }

    console.log('hello223');
}

function removeMati(btn) {
    let $matiBox = $("div[name='matiBox']");
    let $thisMati = btn.closest('[name="oneMati"]');
    if ($thisMati) $thisMati.remove();

    let $firstMati = $matiBox.find("div[name='oneMati']").first();
    let $notmust = $firstMati.find(".notmust");
    if ($notmust.length > 0) {
        $notmust.removeClass("notmust").addClass("must");
        console.log('hello2');
    }
    console.log('hello');
}