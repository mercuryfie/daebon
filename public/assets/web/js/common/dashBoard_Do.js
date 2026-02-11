$(document).ready(function() {

    Set_Data();

    let rollingIndex = 0;
    setInterval(function () {
        rollingIndex++;
        if (rollingIndex > 2) {
            rollingIndex = 0;
            $('.msg_box').css('top', '0px');
            setTimeout(function() {
                rollingIndex = 1;
                $('.msg_box').animate({
                    top: '-40px'
                }, 500);
            }, 50);
        } else {
            $('.msg_box').animate({
                top: -(rollingIndex * 40) + 'px'
            }, 500);
        }
    }, 5000);

});




async function Set_Data(){
    let org_temp = 0;
    let org_hum = 0;
    let start_temp = 0;
    let start_hum = 0;
    let type0 = 0;
    let type1 = 0;
    let type2 = 0;
    let type3 = 0;
    let type4 = 0;
    let type5 = 0;
    let type6 = 0;
    let type8 = 0;
    let type13 = 0;
    let type14 = 0;
    let totalOrder = 0;


    let arr = await Load_Data();
    console.log(arr);
    if (arr && typeof arr === 'object' && !Array.isArray(arr)) {
        org_temp = Number(arr.temperature);
        start_temp = (org_temp<0) ? 0 : getPercentage(org_temp,100);
        org_hum = Number(arr.humidity);
        start_hum = (org_hum<0) ? 0 : getPercentage(org_hum,100);

        type0 = arr.order.o_list.type0;
        type1 = arr.order.o_list.type1;
        type2 = arr.order.o_list.type2;
        type3 = arr.order.o_list.type3;
        type4 = arr.order.o_list.type4;
        type5 = arr.order.o_list.type5;
        type6 = arr.order.o_list.type6;
        type8 = arr.order.o_list.type8;
        type13 = arr.order.o_list.type13;
        type14 = arr.order.o_list.type14;

        totalOrder = arr.order.o_tcnt;
    }

    $('#gm_tem').data('percent',Math.round(start_temp));
    $('#gm_hum').data('percent',Math.round(start_hum));

    $('#type1').data('used',type1);
    $('#type3').data('used',type3);
    $('#type2').data('used',type2);
    $('#type4').data('used',type4);
    $('#type5').data('used',type5);
    $('#type6').data('used',type6);
    $('#type8').data('used',type8);
    $('#type13').data('used',type13);
    $('#type14').data('used',type14);
    $('#type0').data('used',type0);

    $('p[name="t_order"]').text(totalOrder);
    $('#total_order').text(totalOrder);



    $(".GaugeMeter").gaugeMeter();
    $(".GaugeMeter2").gaugeMeter();
    $(".GaugeMeter3").gaugeMeter({
        theme: 'green',
        color: '#6AF288',
    });
    return bool = true;
}

async function Load_Data(){
    let data = {};
    try {
        start_spinner();
        let dataarr = {};
        let url = APIURL + '/Load_DashBoard_Info';
        let result = await Load_API_Auth(url, dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        } else if(result.get('status') == 'ok') {
            data = result.get('data').list;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
    } finally {
        stop_spinner();
    }
    return data;
}

