$(document).ready(function() {

    let mtcode = $('#mtcode').val();
    JsBarcode("#prnbarcode", mtcode, {format: "CODE128",displayValue: true, width:2, height:50, fontSize: 16});

    $(document).on('click','#btn_print',function(){
        printWindow('frnbody');
    }); 

    // $(document).on('click','button[name="btn_print"]',function(){
    //     let code = $(this).data('code');
    //     let url = "/goods/prn_barcode_material?mt=" + code;
    //     pop_OrderRoastForm(url);
    // });


    // $('#btn_print').on('click',async function(){
    //     let orcode = $(this).data('orcode');
    //     let orstep = $(this).data('orstep');
    //     if( orstep==0) {
    //         let arr = await Insert_Delivery(orcode);
    //         if(!isEmptyData(arr)){
    //             $(window.opener.document).find('#ck_' + orcode).html('');
    //             $(window.opener.document).find('#bu_' + orcode).html(`<button type="button" class="btnType3" onclick="add_packingQueue('${orcode}',2);">지시완료</button>`);
    //             $(window.opener.document).find('#da_' + orcode).html(arr.indate);
    //
    //             printWindow('add_deli_box');
    //             $(this).data('orstep',1);fs
    //         }
    //     }else{
    //         printWindow('add_deli_box');
    //     }
    // });

});