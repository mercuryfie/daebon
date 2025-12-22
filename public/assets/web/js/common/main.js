$(document).ready(function () {
    $('.bannerwrap').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        prevArrow: '<button type="button" class="slickprev"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slicknext"><i class="fas fa-chevron-right"></i></button>'
    });

    // 초기 값 설정
    updateSlideInfo(1, $('.bannerwrap').slick('getSlick').slideCount);

    // 슬라이드 변경 이벤트
    $('.bannerwrap').on('afterChange', function(event, slick, currentSlide) {
        updateSlideInfo(currentSlide + 1, slick.slideCount);
    });

    // 슬라이드 정보 업데이트 함수
    function updateSlideInfo(current, total)
    {
        $('.pageno .current').text(current);
        $('.pageno .total').text(total);
    }

})