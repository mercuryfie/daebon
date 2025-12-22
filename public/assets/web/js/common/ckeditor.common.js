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
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', '/Api/Upload_File_Editor', true); // 공통 업로드 URL
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (!response || response.error) {
                return reject(
                    response && response.error
                        ? response.error.message
                        : genericErrorText
                );
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

// CKEditor용 공통 플러그인
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

// 공통 초기화 함수
function initCkEditor(selector, extraConfig = {}) {
    return ClassicEditor
        .create(document.querySelector(selector), {
            removePlugins: ['ImageCaption'],
            language: 'ko',
            image: {
                toolbar: ['imageStyle:full', 'imageStyle:side'],
                upload: {
                    types: ['jpeg', 'png', 'gif']
                }
            },
            toolbar: {
                label: 'Basic styles',
                icon: 'text',
                items: [
                    "selectAll",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "|",
                    "numberedList",
                    "bulletedList",
                    "uploadImage",
                    "|",
                    "link",
                    "imageStyle:full",
                    "imageStyle:side",
                    "indent",
                    "outdent",
                    "mediaEmbed"
                ]
            },
            ckfinder: {
                uploadUrl: '/Api/Upload_File_Editor'
            },
            codeBlock: {
                languages: [
                    { language: 'javascript', label: 'JavaScript' },
                    { language: 'html', label: 'HTML' }
                ]
            },
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            ...extraConfig // 페이지별 추가 옵션 덮어쓰기
        })
        .then(editor => {
            window.theEditor = editor; // 필요하면 전역 보관
            return editor;
        });
}