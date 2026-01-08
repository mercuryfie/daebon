$(document).ready(function() {
    const $pick = $('#pick');
    const $container = $('.imgBox_boxdzu');
    let videoStream = null;
    let videoEl = null;
    const MAX_SLOTS = 7;

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            videoStream = stream;
            videoEl = document.createElement('video');
            videoEl.autoplay = true;
            videoEl.muted = true;
            videoEl.playsInline = true;
            $(videoEl).css({
                'position': 'absolute', 'top': 0, 'left': 0,
                'width': '100%',
                'height': '100%',
                'border-radius': '5px',
                'object-fit': 'cover'
            });
            $pick.append(videoEl);
            videoEl.srcObject = stream;
        })
        .catch(err => console.error(err));

    $('#btn_prn').on('click', function() {
        if (!videoEl || videoEl.videoWidth === 0) return alert('카메라 준비중...');
        let photoSlots = $container.find('.planeLayer:not(#pick) img, .dashedLayer .inputArea').length;
        console.log('사진 슬롯 수:', photoSlots);
        if (photoSlots >= MAX_SLOTS) {
            return alert(`최대 ${MAX_SLOTS}장까지 가능합니다. (현재 ${photoSlots}장)`);
        }

        const canvas = document.createElement('canvas');
        canvas.width = videoEl.videoWidth;
        canvas.height = videoEl.videoHeight;
        canvas.getContext('2d').drawImage(videoEl, 0, 0);
        const imgData = canvas.toDataURL('image/jpeg', 0.8);

        let $emptySlot = $container.find('.dashedLayer:has(.inputArea):not(:has(img))').first();

        if ($emptySlot.length === 0) {
            $emptySlot = $('<div class="dashedLayer"><p class="inputArea">+</p></div>');
            $container.find('.btnBox').before($emptySlot);
        }

        const $img = $('<img>').attr('src', imgData).css({
            'width': '100%', 'height': '100%', 'object-fit': 'cover'
        });

        $emptySlot.html('')
            .append($img)
            .removeClass('dashedLayer')
            .addClass('planeLayer')
            .append('<button class="closeBtn"><i class="fa-solid fa-xmark"></i></button>');
    });

    $(document).on('click', '.closeBtn', function() {
        $(this).closest('.planeLayer').html('<p class="inputArea">+</p>')
            .removeClass('planeLayer').addClass('dashedLayer');
    });
});