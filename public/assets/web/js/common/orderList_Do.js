
$(document).ready(function() {

    $('#addOrder_wrap #Xbtn, #addOrder_wrap #Xbtn2').click(function () {
        $('#addOrder_wrap').css('display','none');
    });

    $('#uploadExel #Xbtn, #uploadExel #Xbtn2').click(function () {
        $('#uploadExel').css('display','none');
    });

    $('#addPQueue #Xbtn, #addPQueue #Xbtn2').click(function () {
        $('#addPQueue').css('display','none');
    });


});

function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            $('[name="add1"]').val(data.roadAddress);
            $('[name="add2"]').focus();
        }
    }).open();
}

function execDaumPostcode2() {
    new daum.Postcode({
        oncomplete: function(data) {
            $('[name="add3"]').val(data.roadAddress);
            $('[name="add4"]').focus();
        }
    }).open();
}

function add_Order() {
    $('#addOrder_wrap').css('display','block');
}


function upload_Xlx() {
    $('#uploadExel').css('display','block');
}


function add_packingQueue() {
    $('#addPQueue').css('display','block');
}
