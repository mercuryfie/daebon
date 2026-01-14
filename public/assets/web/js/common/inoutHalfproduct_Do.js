
$(document).ready(function() {

    $('#barcodeWrap #Xbtn, #barcodeWrap #Xbtn2').click(function () {
        $('#barcodeWrap').css('display','none');
    });

    $('#ipgoWrap #Xbtn, #ipgoWrap #Xbtn2').click(function () {
        $('#ipgoWrap').css('display','none');
    });

    $('#outWrap #Xbtn, #outWrap #Xbtn2').click(function () {
        $('#outWrap').css('display','none');
    });

    $("#supply").on("change", function() {
        if ($(this).val() === "bySelf") {
            $("#supply").hide();
            $("#suppCom").show().focus();
        } else {
            $("#suppCom").hide();
        }
    });


});

function pop_barcodeWindow() {
    let url = "/inout/popbarcodewindow";
    let width = 430;
    let height = 320;

    let newWindow = window.open(url, "_blank", `width=${width},height=${height},resizable=yes,scrollbars=yes`);

    newWindow.onload = function() {
        try {
            let docHeight = newWindow.document.body.scrollHeight;
            newWindow.resizeTo(width, docHeight + 100);
        } catch(e) {
            console.log("새 창 높이 조절 불가", e);
        }
    };
}

function pop_barcodeLayer() {
    $('#barcodeWrap').css('display','block');
}

function pop_ipgoView() {
    $('#ipgoWrap').css('display','block');
}

function pop_chulgoView() {
    $('#outWrap').css('display','block');
}


