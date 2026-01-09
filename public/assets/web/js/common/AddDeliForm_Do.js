$(document).ready(function() {
    let pcode = $("#barcodeDiv").data("orcode");
    Prn_Barcode(pcode);

    $('#btn_print').on('click',async function(){
        let orcode = $(this).data('orcode');
        let orstep = $(this).data('orstep');
        if( orstep==0) {
            let arr = await Insert_Delivery(orcode);
            if(!isEmptyData(arr)){
                $(window.opener.document).find('#ck_' + orcode).html('');
                $(window.opener.document).find('#bu_' + orcode).html(`<button type="button" class="btnType3" onclick="add_packingQueue('${orcode}',2);">지시완료</button>`);
                $(window.opener.document).find('#da_' + orcode).html(arr.indate);

                printWindow('add_deli_box');
                $(this).data('orstep',1);fs
            }
        }else{
            printWindow('add_deli_box');
        }
    });

    $('#xBtn').click(function () {
        window.close();
    });


    function Prn_Barcode(code) {
        console.log("cpcode=" + code);
        if (code != "") {
            $("#barcodeDiv").barcode(code, "code128", {
                barWidth: 2,
                barHeight: 40,
                fontSize: 15,
                showHRI: false,
            });
            $("#barcodeDiv").css("overflow", "hidden");
            $("#barcodeDiv").css("margin", "0 auto");
            $("#barcodeDiv").css("paddingTop", "5px");
            $("#barcodeDiv").css("display", "flex");
            $("#barcodeDiv").css("justifyContent", "center");
            $("#barcodeDiv").css("width", "360px");
            $("#barcodeDiv").css("height", "40px");

        }
    }

    async function Insert_Delivery(code){
        let data = {};
        try {
            start_spinner();
            let dataarr = {"code" : code};
            let url = APIURL + '/Insert_Delivery_Info';
            let result = await Load_API_Auth(url,dataarr);
            console.log(result);
            if (result.get('status') == 'NoLogin') {
                go_login();
            }else if(result.get('status') == 'Error003') {
                alert(result.get('message'));
                location.reload();
            }else if(result.get('status') == 'ok') {
                data = result.get('data').list;
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

});



