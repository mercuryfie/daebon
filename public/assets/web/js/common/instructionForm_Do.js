$(document).ready(function() {
    let pcode = $("#barcodeDiv").data("pcode");
    Prn_Barcode(pcode);

    $(document).on('click','#btn_print',function(){
        printWindow('frnbody');
    });

    $('#xBtn').click(function () {
        window.close();
    });


});


function Prn_Barcode(pcode) {
    console.log("cpcode=" + pcode);
    if (pcode != "") {
        $("#barcodeDiv").barcode(pcode, "code128", {
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

// ㅇㅇ