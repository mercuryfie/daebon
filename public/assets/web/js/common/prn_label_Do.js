$(document).ready(function() {



    let gicode = $('#gicode').attr('data-gicode')
    JsBarcode("#gicode", gicode, {format: "CODE128",displayValue: true, width:2.4});

    let sicode = $('#sicode').attr('data-sicode');
    JsBarcode("#sicode", sicode, {format: "CODE128",  displayValue: true,width:2.4});

    $('#btn_print').on('click',function(){
        printWindow('prn_body');
    });

    $('#xBtn').click(function () {
        window.close();
    });

    if (window.opener && !window.opener.closed) {
        let $parentElement = $(window.opener.document).find('#prn_body');
        if ($parentElement.length > 0) {
            let gicode = $('#gicode').val();
            let sicode = $('#sicode').val();
            window.opener.dataChange(gicode,sicode);
        }
    }

});
