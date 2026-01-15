$(document).ready(function() {
    const $cam_area = $('#cam_area');
    const $uns = $('#unsupported_cam');
    const $pick = $('#pick');
    const $container = $('.imgBox_boxdzu');
    let videoStream = null;
    let videoEl = null;
    const MAX_SLOTS = 5;

    function checkCameraSupport() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            if (!navigator.getUserMedia && !navigator.webkitGetUserMedia && !navigator.mozGetUserMedia) {
                Make_Toast('카메라를 지원하지 않습니다.\nChrome 최신버전 또는 Firefox 사용하세요.');
                $uns.text('카메라 미지원');
                $uns.css('display','block');
                $cam_area.hide();
                return false;
            }
        }
        return true;
    }

    // 웹캠 시작
    if (checkCameraSupport()) {
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
            .catch(err => {
                console.error('카메라 오류:', err);
                Make_Toast('카메라 사용 불가\n1. HTTPS 환경 확인\n2. 카메라 권한 허용\n3. 다른 브라우저 사용');
                $pick.html('<p style="color:#fff;">카메라 오류</p>');
            });
    }

    // 촬영 버튼
    $('#pick').on('click', function() {
        if (!videoEl || videoEl.videoWidth === 0) {
            alert('카메라가 준비되지 않았습니다.');
            return;
        }

        let photoSlots = $container.find('.planeLayer:not(#pick) img, .dashedLayer .inputArea').length;

        console.log('photoSlots=' + photoSlots);

        if (photoSlots >= MAX_SLOTS) {
            alert(`최대 ${MAX_SLOTS}장까지 가능합니다. (현재 ${photoSlots}장)`);
            return;
        }

        // 캡처
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

        $emptySlot.html('').append($img)
            .removeClass('dashedLayer').addClass('planeLayer')
            .append('<button class="closeBtn"><i class="fa-solid fa-xmark"></i></button>');
    });

    $(document).on('click', '.closeBtn', function() {
        $(this).closest('.planeLayer').html('<p class="inputArea">+</p>')
            .removeClass('planeLayer').addClass('dashedLayer');
    });

    $(document).on('click','div[name="btn_noirbox"]',function(){

        let orstep = $('#orstep').val();
        if(orstep<2) {
            $(this).data('choice', 1);
            $(this).find('div[name="noir_active"]').addClass('active');
        }
    });

    $('#btn_complete').on('click', async function() {
        let opcode = $(this).data('opcode');
        let orcode = $(this).data('orcode');
        let delicode = $('#packing_delicode').html();
        if(delicode==''){
            Make_Toast('송장출력을 해야 포장완료로 진행이 가능합니다.');
        }else{
            let allChecked = true;
            $('#check_product div[name="btn_noirbox"').each(function(){
                let choice = $(this).data('choice');
                if(choice==0){
                    allChecked = false;
                    Make_Toast('확인이 안된 상품이 있습니다.');
                    return false;
                }
            });
            if (!allChecked){
                return;
            }else{
                const imageElements = $container.find('.planeLayer:not(#pick) img');
                if (imageElements.length > 0) {

                    let param = {
                        opcode : opcode,
                        uploadKey : 'photos',
                        uploadtype : 2,
                        imageElements : imageElements
                    };
                    let bool = await Upload_Pic(param);
                }
                let data = {
                    orcode : orcode,
                    opcode : opcode
                };
                let bool = await Process_Packing_End(data);
                if(bool==true){
                    go_packingListStaff();
                }
            }
        }

    });

    let p_status = $('#p_status').val();
    prn_status(p_status);
});

function prn_status(val){
    if((val==0) || (val==1)){
        $('#p_status1').removeClass().addClass('squareType');
        $('#p_status2').removeClass().addClass('squareType2');
        $('#p_status3').removeClass().addClass('squareType2');
    }else if(val==2){
        $('#p_status1').removeClass().addClass('squareType2');
        $('#p_status2').removeClass().addClass('squareType');
        $('#p_status3').removeClass().addClass('squareType2');
    }else if(val==3){
        $('#p_status1').removeClass().addClass('squareType2');
        $('#p_status2').removeClass().addClass('squareType2');
        $('#p_status3').removeClass().addClass('squareType');
    }
}

async function Upload_Pic(param){
    let bool = false;
    start_spinner();
    try {
        let { opcode, uploadKey, uploadtype,imageElements } = param;
        const formData = new FormData();

        // 각 이미지를 Blob 변환
        for (let i = 0; i < imageElements.length; i++) {
            const imgEl = imageElements[i];
            const imgSrc = imgEl.src;

            if (imgSrc.startsWith('data:image')) {
                const blob = await imageToBlob(imgSrc);
                if (blob) {
                    formData.append(`${uploadKey}[]`, blob, `photo_${Date.now()}_${i}.jpg`);
                }
            }
        }
        console.log(imageElements);
        formData.append('upload_type', uploadtype);  // packing 이미지
        formData.append('upload_key', uploadKey); // 파일 배열 키명
        formData.append('opcode', opcode);
        formData.append('total_count', imageElements.length);

        console.log(formData);

        const response = await fetch(APIURL + '/Upload_Multi_File', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success || result.result === 'ok') {
            bool = true;
        } else {
            Make_Toast('업로드 실패\n' + (result.message || '오류'));
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
    stop_spinner();
    return bool;
}


async function Process_Packing_End(param){
    let data =false;
    try {
        start_spinner();
        let dataarr = {"param" : param};
        let url = APIURL + '/Put_Packing_Info';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}



function imageToBlob(imgSrc) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth || 800;  // 최대 800px
            canvas.height = img.naturalHeight || 600;
            const ctx = canvas.getContext('2d');

            // 비율 유지 리사이즈
            const ratio = Math.min(canvas.width / img.width, canvas.height / img.height);
            const newWidth = img.width * ratio;
            const newHeight = img.height * ratio;

            ctx.drawImage(img, 0, 0, newWidth, newHeight);

            canvas.toBlob(resolve, 'image/jpeg', 0.8);
        };
        img.onerror = () => resolve(null);
        img.src = imgSrc;
    });
}

function dataChange(orcode,delicode){
    if((delicode!='') && (orcode!='')){
        let html = `
            <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('${orcode}','New');">송장<br>추가출력</button>
            <button type="button" class="btn80Type1 mr10" onclick="pop_waybillPacking('${orcode}','');">송장<br>재출력</button>
        `;

        $('#delicode_button').empty();
        $('#delicode_button').html(html);
        $('#packing_delicode').html(delicode);
    }
    prn_status(2);
}
