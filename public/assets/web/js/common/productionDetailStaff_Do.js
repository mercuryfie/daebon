$(document).ready(function() {
    $(document).on('click', function() {
        const incode = $('#incode');
        if (document.activeElement.id !== 'incode') {
            incode.focus();
        }
    });


    $('#btn_confirm').on('click',async function(){
        let gicode = $('#gicode').val();
        let prcode = $('#prcode').val();
        let gubun = $('#gubun').val();
        let weight = $('#afterweight').data('val');

        if(weight==''){
            Make_Toast('무게를 측정하세요.');
            $('#incode').focus();
        }else {
            let data = {
                gicode: gicode,
                prcode: prcode,
                gubun: gubun,
                weight: weight
            };

            let arr = await Process_Confirm(data);
            go_productionListStaff();
        }
    });


    $('#incode').on('keypress',function(e){
        console.log('keypress');
        if (e.which !== 13) return;
        let status = $('#status').val();
        if (status != 2) {
            let act = $('#btn_act').data('act');
            if(act=='yes') {
                let weight = $(this).val();
                if (weight == '') {
                    Make_Toast('저울을 확인하세요.');
                    $('#incode').val('');
                    $('#incode').focus();
                } else {
                    let gram = convertToGram(weight);
                    let unit_weight = $('#unit_weight').val();
                    let ptyp = $('#ptyp').val();
                    let gstr = '';
                    if(ptyp==1){
                        gstr = gram + 'g';
                    }else if(ptyp==2) {
                        let gCnt = (gram/unit_weight);
                        gCnt = Math.round(gCnt);
                        gstr = gram + 'g / ' + gCnt + 'ea';
                    }
                    $('#afterweight').data('val', gram);
                    $('#afterweight').text(gstr);
                    $('#incode').val('');
                    $('#incode').focus();
                }
            }else{
                $('#incode').val('');
                $('#incode').focus();
            }
        }
    });


    $('#btn_act').on('click',function(e){
        console.log('click');
        e.stopPropagation();
        let act = $(this).data('act');
        if (act == 'yes') {
            $(this).data('act', 'no');
            $(this).addClass('active');
            $('#btn_act_i').removeClass('fa-lock-open').addClass('fa-lock');
            $('#incode').val('').focus();
        } else {
            $(this).data('act', 'yes');
            $(this).removeClass('active');
            $('#btn_act_i').removeClass('fa-lock').addClass('fa-lock-open');
            $('#incode').val('').focus();
        }
        return false;
    });

});

async function Process_Confirm(data){
    let arr = {};
    try {
        start_spinner();
        let dataarr = {"data" : data};
        let url = APIURL + '/Process_Confirm';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let arr = result.get('data');
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return arr;
}

