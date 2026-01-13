$(document).ready(function() {
    let orcode = $("#barcodeDiv").data("orcode");
    Prn_Barcode(orcode);


    function Prn_Barcode(code) {
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

});