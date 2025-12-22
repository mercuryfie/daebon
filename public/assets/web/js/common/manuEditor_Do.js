$(function() {

    $(".roasting_boxe3x > .outerBox > .right > i").click(function() {
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

function add_manuBox(btn) {
    let $manuBox = $("div[name='roasting_boxp9x']");
    let $firstRoasting = $("div[name='oneRoasting']").first();
    let $copy = $firstRoasting.clone();

    $copy.find("select").val("");
    $copy.find("input").val("");
    $manuBox.append($copy);
    console.log('hello22');
}

function removeRoasting(btn) {
    let $roastingBox = $("div[name='roasting_boxp9x']");
    let thisRoast = btn.closest('[name="oneRoasting"]');
    if (thisRoast) thisRoast.remove();

    console.log('hello');
}