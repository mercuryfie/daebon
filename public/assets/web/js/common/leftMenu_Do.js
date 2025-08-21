
$(document).ready(function() {



    $('[name="topmenu"]').click(function() {
        let $clickedSubmenu = $(this).siblings('.submenu');
        let $clickedIcon = $(this).find('i.fa-solid');

        if ($clickedSubmenu.css('display') === 'none') {
            $('.submenu').not($clickedSubmenu).css('display', 'none').removeClass('flexCol').addClass('hidden');
            $('.topmenu').not(this).find('i.fa-solid').removeClass('fa-angle-up').addClass('fa-angle-down');

            $clickedSubmenu.css('display', 'flex').removeClass('hidden').addClass('flexCol');
            $clickedIcon.removeClass('fa-angle-down').addClass('fa-angle-up');

        } else {
            $clickedSubmenu.css('display', 'none').removeClass('flexCol').addClass('hidden');
            $clickedIcon.removeClass('fa-angle-up').addClass('fa-angle-down');
        }
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
