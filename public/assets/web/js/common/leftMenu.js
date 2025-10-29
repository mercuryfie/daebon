
$(document).ready(function() {

    $('[name="topmenu"]').click(function() {
        let $clickedSubmenu = $(this).siblings('.submenu');
        let $clickedIcon = $(this).find('i.fa-solid');
        $clickedSubmenu.slideToggle();

        // $(this).siblings('.submenu').toggleClass('hidden');

        if ($clickedSubmenu.css('display') === 'none') {
            $('.submenu').not($clickedSubmenu).css('display', 'none').removeClass('flexCol').addClass('hidden');
            $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');

        } else {
            $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');
        }

        if ($clickedIcon.hasClass('fa-angle-down')) {
            $clickedIcon.removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $clickedIcon.removeClass('fa-angle-up').addClass('fa-angle-down');
        }


    });
// //
// // submenu 내 a 클릭 시 현재 submenu 숨기기
//     $('.submenu a').click(function(e) {
//         e.preventDefault(); // 기본 a 동작 차단
//
//         let $currentSubmenu = $(this).closest('.submenu');
//         let $parentTopmenu = $currentSubmenu.siblings('.topmenu');
//         let $icon = $parentTopmenu.find('i.fa-solid');
//
//         // $currentSubmenu.css('display', 'none').removeClass('flexCol').addClass('hidden');
//         // 아이콘 상태 변경
//         // $icon.removeClass('fa-angle-up').addClass('fa-angle-down');
//         // $icon.removeClass('fa-angle-down').addClass('fa-angle-up');
//     });

    // $('div[name="submenu"]').click(function(event){
    //     event.stopPropagation();
    //     let $menuBox = $('div[name="menuBox"]');
    //     $(this).css('display', 'flex').removeClass('hidden').addClass('flexCol');
    // });


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
