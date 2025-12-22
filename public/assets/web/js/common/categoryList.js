
$(document).ready(function() {


    $('#addCat2_wrap #Xbtn, #addCat2_wrap #Xbtn2').click(function () {
        $('#addCat2_wrap').css('display','none');
    });

    $('#addCat3_wrap #Xbtn, #addCat3_wrap #Xbtn2').click(function () {
        $('#addCat3_wrap').css('display','none');
    });


});

function pop_addCat2() {
    $('#addCat2_wrap').css('display','block');
}

function pop_addCat3() {
    $('#addCat3_wrap').css('display','block');
}
