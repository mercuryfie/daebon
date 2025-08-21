$(document).ready(function () {
    // show locatip
    const $tUid = $("#tUid");
    if ($tUid.length && $tUid.val()) {
        const $locatip = $(".locatip");
        let hideTimeout;
        $(".locatip").hide(); // 기본적으로 숨김

        $(".icon1").on("click", function() {
            clearTimeout(hideTimeout);
            $(".locatip").toggle(); // 나타나게 함
            hideTimeout = setTimeout(function() {
                $(".locatip").hide(); // 3초 후 다시 숨김
            }, 3000);
        });

    }

    // btnslt: 버튼 클릭 시 checkedGreen 토글
    $(".btnslt button").on("click", function () {
        $(this).closest(".btnslt").find("button").removeClass("checkedGreen");
        $(this).addClass("checkedGreen");
    });

    // btnon: 그룹 내 첫 버튼 checkedGreen, 클릭 시 토글
    $(".btnon").each(function () {
        const $buttons = $(this).find("button");
        if ($buttons.length > 0) {
            $buttons.eq(0).addClass("checkedGreen");
        }
        $buttons.on("click", function () {
            $buttons.removeClass("checkedGreen");
            $(this).addClass("checkedGreen");
        });
    });

    // selectAll: 체크박스 전체 선택
    $(document).on('change', '.selectAll', function() {
        var colIdx = $(this).closest('td,th').index();
        $('tbody tr').each(function() {
            $(this).find('td').eq(colIdx).find('input[type="checkbox"]').prop('checked', $('.selectAll').prop('checked'));
        });
    });
});