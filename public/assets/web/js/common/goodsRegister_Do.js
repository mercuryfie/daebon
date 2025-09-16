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

    $("button[name='addGoods']").click(function() {
        var $copy = $("div[name='goodsBox'] > div[name='oneGoods']").first().clone();
        // var $copy = $("div[name='oneGoods']").clone();

        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='goodsBox']").append($copy);
    });

    $("button[name='addPackage']").click(function() {
        var $copy = $("div[name='packageBox'] > div[name='onePackage']").first().clone();

        $copy.find("select").val("");
        $copy.find("input").val("");

        $("div[name='packageBox']").append($copy);
    });


    $("div[name='mached'] > i").click(function() {
        $(this).closest("div[name='mached']").css("display", "none");
    });


    $('#attachImg').on('click', function(e) {
        let thumCount = $('[name="thumBox"]').length;
        if (thumCount >= 1) {
            Make_Toast('이미지는 최대 1장까지 등록 가능합니다.');
            e.preventDefault(); // 파일 선택창 안 뜨게 막음
            return false;
        }
    });

    $('#attachImg').on('change', function(e) {
        let files = e.target.files;
        let thumbCount = $('[name="thumBox"]').length;

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
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>` );
                    $('#thumbArea').append($thumb);
                    $thumb.find('.delete-btn').on('click', function() {
                        $(this).closest('.thumBox').remove();
                        $('#attachImg').val('');
                    });
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // ckeditor
    ClassicEditor
        .create(document.querySelector("#ckeditor"), {
            removePlugins: ['ImageCaption'],
            image: {
                toolbar: [ 'imageStyle:full', 'imageStyle:side' ]
            },
            toolbar: {
                // licenseKey: '<YOUR_LICENSE_KEY>',
                label: 'Basic styles',
                icon: 'text',
                initialData: '<p></p>',
                items:
                    [
                        "selectAll",
                        "undo",
                        "redo",
                        "bold",
                        "italic",
                        "blockQuote",
                        "|",
                        //"todoList",
                        //"paragraph",
                        //"pasteFormat",
                        "numberedList",
                        "bulletedList",
                        "uploadImage",
                        "|",
                        "link",
                        // "ckfinder",
                        // "heading",
                        "imageStyle:full",
                        "imageStyle:side",
                        "indent",
                        "outdent",
                        "mediaEmbed"
                    ]

            },
            image: {
                upload: {
                    types: ['jpeg', 'png', 'gif']
                }
            },
            ckfinder: {
                uploadUrl: '/Api/Upload_file_editor'
            },
            codeBlock: {
                languages: [
                    { language: 'javascript', label: 'JavaScript' },
                    { language: 'html', label: 'HTML' }
                ]
            },
            language:'ko'
        })
        .then((editor) => {

            //console.log('Editor initialized', editor);
            theEditor = editor;

            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        })
        .catch((error) => {
            console.log(error);
        });



    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }
        abort() {
            if (this.xhr) { this.xhr.abort(); }
        }
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '/Api/Upload_file_editor', true);
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;
            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                resolve({
                    default: response.url
                });
            });
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }
        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

});