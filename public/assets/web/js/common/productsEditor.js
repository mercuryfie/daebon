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


});

function addMate(button) {
    const mateBox = document.querySelector('[name="mateBox"]');

    const newMate = document.createElement('div');
    newMate.className = 'element flexType2 selectMetirialBox';
    newMate.setAttribute('name', 'oneMate');

    newMate.innerHTML = `
        <div class="left flexType2">
            <p class="notmust"></p>
            <p class="title">재료 선택</p>
            <select name="" id="" class="inputBorder mr10">
                <option value="">우엉1</option>
                <option value="">우엉2</option>
                <option value="">우엉3</option>
            </select>
            <input type="search" class="inputBorder inputBorder2 mr10" placeholder="예:10000">
            <p class="unit mr10">g</p>
        </div>
        <button type="button" class="btnType3 addBtn mr10" name="addMati" onclick="addMate(this);">
            <i class="fa-solid fa-plus"></i>
        </button>
        <button type="button" class="btnType3 removeBtn " name="removeMati" onclick="removeMate(this);">
            <i class="fa-solid fa-trash"></i>
        </button> 
    `;

    mateBox.appendChild(newMate);
}

function removeMate(button) {
    const oneMate = button.closest('[name="oneMate"]');
    if (oneMate) {
        oneMate.remove();
    }
}
