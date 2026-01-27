$(document).ready(function() {
    let filtcd = $('#filtcd').data('code');
    JsBarcode("#filtcd", filtcd, {format: "CODE39",displayValue: false});

    let delicode = $('#delicode1').data('code');
    JsBarcode("#delicode1", delicode, {format: "ITF",  width: 1.2,height:40,displayValue: false});
    JsBarcode("#delicode2", delicode, {format: "ITF",  width: 1.2,height:40,displayValue: false});

    $('#btn_print').on('click',async function(){
        printWindow('prn_body');
    });

    $('#xBtn').click(function () {
        window.close();
    });

    if (window.opener && !window.opener.closed) {
        let $parentElement = $(window.opener.document).find('#packing_delicode');
        if ($parentElement.length > 0) {
            let orcode = $('#pop_orcode').val();
            let delcode = $('#pop_delicode').val();
            window.opener.dataChange(orcode,delcode);
        }
    }

});
