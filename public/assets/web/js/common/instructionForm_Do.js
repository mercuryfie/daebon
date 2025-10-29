$(document).ready(function() {
    let pcode = $("#barcodeDiv").data("pcode");
    Prn_Barcode(pcode);
});


function Prn_Barcode(pcode) {
    console.log("cpcode=" + pcode);
    if (pcode == "") {
        alert("잘못된 접근입니다.");
        window.close();
    } else {
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