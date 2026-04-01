$(document).ready(function() {


    let bcode = $('#bcode').val();
    // let dataarr = {
    //     bcode : bcode
    // };
    let data = {'bcode' : bcode};
    Load_Data(data);

    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "ir1",
        sSkinURI: "/assets/web/src/smarteditor/SmartEditor2Skin.html",
        htParams: {
            fOnAppLoad: function() {
                // 기본 폰트사이즈 11pt 설정
                oEditors[0].setDefaultFont('나눔고딕', 11);
                oEditors[0].exec('FONT_SIZE', ['11pt']);
            }
        },
        fCreator: "createSEditor2"

    });



});


function submitForm(elClicked) {
    try {
        oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
    } catch (e) {}

    elClicked.form.submit();
}

var oEditors = [];
var editorReady = false;


async function Add_Content() {

    // if (!editorReady || !oEditors.length) {
    //     Make_Toast('에디터 로딩 중입니다. 잠시 후 다시 시도하세요.');
    //     return;
    // }

    oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);

    try {
        let is_fixed = $('#is_fixed').val();
        let is_notice = $('#is_notice').val();
        let n_title = $('#n_title').val();
        // let content = $('#ir1').val();
        let content = oEditors[0].getContents();

        if(is_fixed==''){
            $('#is_fixed').focus();
            Make_Toast('게시타입을 선택하세요.');
        } else if (is_notice == '') {
            $('#is_notice').focus();
            Make_Toast('전광판 노출 여부를 선택하세요.');
        } else if (n_title == '') {
            $('#n_title').focus();
            Make_Toast('제목을 입력하세요.');
        }  else {
            const data = {
                is_fixed: is_fixed,
                is_notice: is_notice,
                n_title: n_title,
                content: content
            };
            // console.log('dawn1421', dataarr);
            let bool = await Add_NoticeInfo(data);
            if (bool == true) {
                Make_Toast('등록하였습니다');
                go_noticeList();
            } else {
                Make_Toast('등록에 실패했습니다.');
            }
        }
    } catch (error) {
        Make_Toast('1701오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }

    async function Add_NoticeInfo (data){
        // let arr = [];
        let bool = false;
        try {
            start_spinner();
            let dataarr = {"data" : data};
            let url = APIURL + '/Add_NoticeInfo';
            let result = await Load_API_Auth(url,dataarr);
            let html = '';
            if (result.get('status') == 'NoLogin') {
                go_login();
            }else if(result.get('status') == 'ok') {

                 bool = true;
            }else{
                Make_Toast(result.get('message') + "[" + result.get('status') + "]");
            }
            stop_spinner();
        } catch (error) {
            Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
            stop_spinner();
        }
        return bool;
    }
}

async function Load_Data(data) {
    let b_arr = {};
    try {
        start_spinner();
        let url = APIURL + '/Load_NoticeInfo';
        let result = await Load_API_Auth(url,data);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let b_content = '';

            if (!fn_IsEmpty(data)) {
                is_fixed += data.ix_Fix;
                is_notice += data.is_Notice;
                b_content += data.b_content;
                $('#ir1').val(b_content);
            }else{
                Make_Toast('검색된 제품이 없습니다.');

            }
        } else {
            Make_Toast(result.get('message'));
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return b_arr;
}


async function Mod_Content() {

    oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);

    try {
        let bcode = $('#bcode').val();
        let is_fixed = $('#is_fixed').val();
        let is_notice = $('#is_notice').val();
        let b_title = $('#n_title').val();
        let b_content = oEditors[0].getContents();

        if (b_title == '') {
            $('#n_title').focus();
            Make_Toast('제목을을 입력하세요.');
        } else if (b_content=='') {
            $('#ir1').focus();
            Make_Toast('내용을 선택하세요.');
        } else {
            const dataarr = {
                'bcode': bcode,
                'is_fixed': is_fixed,
                'is_notice': is_notice,
                'b_title': b_title,
                'b_content': b_content
            };
            let bool = await Mod_NoticeInfo(dataarr);
            if (bool == true) {
                Make_Toast('수정하였습니다');
                go_noticeList();
            } else {
                Make_Toast('등록에 실패했습니다.');
            }
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    }
}

async function Mod_NoticeInfo (data){
    // let arr = [];
    let bool = false;
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Mod_NoticeInfo';
        let result = await Load_API_Auth(url,dataarr);
        let html = '';
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여 주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}