$(document).ready(function() {

    Make_Barcode('filtcd','code39');
    Make_Barcode('delicode','code128');
    Make_Barcode2('delicode2','code128');

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

function Make_Barcode(containerId,typ) {
    const $container = $(`#${containerId}`);
    let code = $container.attr('data-code');
    console.log(code);
    console.log($container);
    if (code != "") {
        $container.barcode(code, typ, {
            barWidth: 1,
            barHeight: 40,
            fontSize: 14,
            showHRI: false,
        });
    }
}

function Make_Barcode2(containerId,typ) {
    const $container = $(`#${containerId}`);
    let code = $container.attr('data-code');
    console.log(code);
    console.log($container);
    if (code != "") {
        $container.barcode(code, typ, {
            barWidth: 2,
            barHeight: 40,
            fontSize: 14,
            showHRI: false,
        });
    }
}
