$(document).ready(function() {

    $('#attachImg').on('change', function(e) {
        let files = e.target.files;
        let thumbCount = $('div[name="thumBox"]').length;

        if (thumbCount + files.length > 1) {
            Make_Toast('이미지는 1장만 등록 가능합니다.');
            $(this).val(''); // 파일 선택 취소
            return;
        }

        for (let i = 0; i < files.length; i++) {
            if (files[i].type.match('image.*')) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let $thumb = $(
                        `
                        <div class="thumBox" name="thumBox">
                            <img src="` + e.target.result + `" alt="img" class="addedImg">
                            <button type="button" class="delete-btn">
                                <i class="fa-solid fa-xmark "></i>
                            </button>
                        </div>` );
                    $('#thumbArea').append($thumb);
                    $thumb.find('.delete-btn').on('click', function() {
                        $(this).closest('.thumBox').remove();
                        $('#attachImg').val('');
                        Make_Toast('삭제하였습니다.');
                    });
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

});