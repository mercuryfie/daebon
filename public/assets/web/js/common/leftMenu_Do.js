
$(document).ready(function() {



    // $('[name="topmenu"]').click(function() {
    //     let $clickedSubmenu = $(this).siblings('.submenu');
    //     let $clickedIcon = $(this).find('i.fa-solid');
    //
    //     if ($clickedSubmenu.css('display') === 'none') {
    //         $('.submenu').not($clickedSubmenu).css('display', 'none').removeClass('flexCol').addClass('hidden');
    //         $('.topmenu').not(this).find('i.fa-solid').removeClass('fa-angle-up').addClass('fa-angle-down');
    //
    //         $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');
    //         $clickedIcon.removeClass('fa-angle-down').addClass('fa-angle-up');
    //
    //     } else {
    //         $clickedSubmenu.css('display', 'none').removeClass('flexCol').addClass('hidden');
    //         $clickedIcon.removeClass('fa-angle-up').addClass('fa-angle-down');
    //     }
    //
    //
    // });

    $('[name="topmenu"]').click(function() {
        let $clickedSubmenu = $(this).siblings('.submenu');
        let $clickedIcon = $(this).find('i.fa-solid');

        if ($clickedSubmenu.css('display') === 'none') {
            $('.submenu').not($clickedSubmenu).css('display', 'none').removeClass('flexCol').addClass('hidden');
            $('.topmenu').not(this).find('i.fa-solid').removeClass('fa-angle-down').addClass('fa-angle-up');

            $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');
            $clickedIcon.removeClass('fa-angle-down').addClass('fa-angle-up');

        } else {
            $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');
            $clickedIcon.removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });

// submenu 내 a 클릭 시 현재 submenu 숨기기
    $('.submenu a').click(function(e) {
        e.preventDefault(); // 기본 a 동작 차단

        let $currentSubmenu = $(this).closest('.submenu');
        let $parentTopmenu = $currentSubmenu.siblings('.topmenu');
        let $icon = $parentTopmenu.find('i.fa-solid');

        // 현재 submenu 숨기기
        $currentSubmenu.css('display', 'none').removeClass('flexCol').addClass('hidden');
        // 아이콘 상태 변경
        $icon.removeClass('fa-angle-up').addClass('fa-angle-down');
    });



    $('div[name="submenu"]').click(function(event){
        // event.stopPropagation();
        // let $menuBox = $('div[name="menuBox"]');
        $(this).css('display', 'flex').removeClass('hidden').addClass('flexCol');
    });


    $('[name="topmenu"]').hover(
        function() {
            $(this).css('background-color', '#ececec');
        },
        function() {
            $(this).css('background-color', '');
        }
    );


    $('.subtext').hover(
        function() {
            $(this).css('color', '#42b983');
        },
        function() {
            $(this).css('color', '');
        }
    );



});
