$(document).ready(function() {
    $(document).on('click', function(e){
        if (document.activeElement.id !== 'incode') {
            $('#incode').focus();
        }
    });


    $(document).on('click', function(e){
        if (document.activeElement.id !== 'incode') {
            $('#incode').focus();
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


    $(document).on('keypress','#incode',function(){
        let status = $('#status').val();
        if (status != 2) {
            let act = $('#btn_act').data('act');
            if(act=='yes') {
                let weight = $(this).val();
                if (weight == '') {
                    Make_Toast('저울을 확인하세요.');
                } else {
                    let gram = convertToGram(weight);
                    if (gram == 0) {
                        Make_Toast('무게값이 잘못되었습니다.');
                    } else {

                        let unit_wight = $('#unit_wight').val();
                        let ptyp = $('#ptyp').val();
                        let gstr = '';
                        if(ptyp==1){
                            gstr = gram + 'g';
                        }else if(ptyp==2) {
                            let gCnt = (gram/unit_wight);
                            gCnt = Math.round(gCnt);
                            gstr = gram + 'g / ' + gCnt + 'ea';
                        }

                        $('#afterweight').data('val', gram);
                        $('#afterweight').text(gstr);

                        $('#incode').val('');
                        $('#incode').focus();
                    }
                }
            }else{
                $('#incode').val('');
                $('#incode').focus();
            }
        }
    });


    $(document).on('click','#btn_act',function(){
        let act = $(this).data('act');
        if (act == 'yes') {
            $(this).data('act', 'no');
            $('#btn_act').addClass('active');
            $('#btn_act_i').removeClass('fa-lock-open');
            $('#btn_act_i').addClass('fa-lock');
        } else {
            $(this).data('act', 'yes');
            $('#btn_act').removeClass('active');
            $('#btn_act_i').removeClass('fa-lock');
            $('#btn_act_i').addClass('fa-lock-open');
        }
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

