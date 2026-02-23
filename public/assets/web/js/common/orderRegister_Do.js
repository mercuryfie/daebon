$(document).ready(function(){


    $('#txt_product').on('focus',function(){
        console.log('cc');
        $(this).val('');
        $(this).data('code','');
        $('#product_list').empty().removeClass('active');
    });

    $('#txt_product').on('keypress',async function(e){
        if (e.which === 13) {
            let skey = $(this).val();
            if(skey==''){
                Make_Toast('추가하실 제품명을 입력하세요.');
                $(this).focus();
            }else{
                $('#product_list').empty().removeClass('active');
                Load_Product(skey);
            }
        }
    });

    $('#txt_product_num').on('keypress',function(e){
        if (e.which === 13) {
            let gcode = $('#txt_product').data('code');
            let gname = $('#txt_product').val();
            let cnt = $('#txt_product_num').val();
            addProduct(gcode,gname,cnt);
        }
    });


    $('#btn_product').on('click',async function(e){
        let skey = $(this).val();
        if(skey==''){
            Make_Toast('추가하실 제품명을 입력하세요.');
            $(this).focus();
        }else{
            $('#product_list').empty().removeClass('active');
            Load_Product(skey);
        }
    });

    $(document).on('click','button[name="option_product"]',function(){
        let pdcode = $(this).data('code');
        let pdname = $(this).text();
        if(pdcode==='') {
            Make_Toast('선택하신 상품의 정보가 잘못되었습니다.');
            $('#txt_product').data('code', '');
            $('#product_list').empty().removeClass('active');

        }else{
            $('#txt_product').data('code', pdcode);
            $('#txt_product').val(pdname);
            $('#product_list').empty().removeClass('active');
            $('#txt_product_num').focus();
        }
    });


    $(document).on('click', 'i[name="add_product_del"]', function() {
        $(this).closest('div[name="add_product_info"]').remove();
    });

    $('#addproduct').on('click',function(){
        let gcode = $('#txt_product').data('code');
        let gname = $('#txt_product').val();
        let cnt = $('#txt_product_num').val();
        addProduct(gcode,gname,cnt);
    });

    $('#shoptyp').on('change',function(){
        let selected = $(this).val();
        if(selected=='type0'){
            let newcode = generateNewCode(2);
            $('#spcode').val(newcode).prop('disabled', true);
        }else{
            $('#spcode').val('').prop('disabled', false).focus();
        }


    });

    $('#submitBtn').on('click',async function(){
        let shoptyp = $('#shoptyp').val();
        let spcode = $('#spcode').val();
        let zipcode = $('#zipcode').val();
        let address1 = $('#address1').val();
        let address2 = $('#address2').val();
        let bname = $('#bname').val();
        let bphone = $('#bphone').val();
        let product_arr = [];
        let buyid = $('#buyid').val();
        $('#add_list').find('div[name="add_product_info"]').each(function () {
            let pdcode = $(this).data('code');
            let pdcnt = $(this).find('p[name="gcnt"]').data('cnt');
            let t_arr = {
                pdcode: pdcode,
                pdcnt: pdcnt
            }
            product_arr.push(t_arr);
        });

        if(shoptyp=='') {
            Make_Toast('주문 마켓을 선택하세요.');
        }else if(spcode==''){
            Make_Toast('마켓 주문 번호를 입력하세요.');
        }else if((zipcode=='') || (address1=='')){
            Make_Toast('주소 검색을 다시 하여주세요.');
        }else if(address2==''){
            Make_Toast('상세주소를 입력하세요.');
            $('#address2').focus();
        }else if(bname==''){
            Make_Toast('수령인 입력하세요.');
            $('#bname').focus();
        }else if(bphone==''){
            Make_Toast('연락처 입력하세요.');
            $('#bphone').focus();
        }else if(product_arr.length===0){
            Make_Toast('상품을 추가하세요.');
            $('#txt_product').focus();
        }else{
            let data ={
                shoptyp : shoptyp,
                spcode : spcode,
                sell_id : '',
                buy_id : buyid,
                zipcode : zipcode,
                address1 : address1,
                address2 : address2,
                bname : bname,
                bphone : bphone,
                r_zipcode : zipcode,
                r_address1 : address1,
                r_address2 : address2,
                r_bname : bname,
                r_bphone : bphone,
                product : product_arr,
                orderdate : ''
            };

            console.log('dawn',data);
            let bool = await Reg_Order(data);
            if(bool===true){
                // go_orderList();
            }else{
                Make_Toast('주문등록에 실패 하였습니다.');
            }
        }
    });

    $('#bphone').on('input', function() {
        let value = $(this).val();
        let cleanPhone = value.replace(/[^0-9]/g, '');

        if (value !== cleanPhone) {
            $(this).val(cleanPhone);
            return;
        }

        if (cleanPhone.length > 11) {
            $(this).val(cleanPhone.substr(0, 11));
        }
    });

});

function addProduct(gcode,gname,cnt){
    if(gcode==''){
        Make_Toast('추가하실 체품을 검색하세요.');
        $('#txt_product').focus();
    }else if(cnt==''){
        Make_Toast('추가하실 체품 수량을 검색하세요.');
        $('#txt_product_num').focus();
    }else{
        let html = `
                <div class="productTag flexType3" name="add_product_info" data-code="${gcode}">
                    <p class="gname mr10" name="gname">${gname}</p>
                    <p class="count" name="gcnt" data-cnt="${cnt}">${cnt} 봉</p>
                    <i class="fa-solid fa-xmark" name="add_product_del"></i>
                </div>
            `;
        $('#add_list').append(html).addClass('active');
        $('#txt_product').val('');
        $('#txt_product').data('code','');
        $('#txt_product_num').val('');
    }
}


async function Reg_Order(param){
    let bool = false;
    try {
        start_spinner();
        console.log('dawn',param);
        let dataarr = {"param" : param};
        let url = APIURL + '/Insert_Order';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            bool = true;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return bool;
}

async function Load_Product(skey){
    try {
        start_spinner();
        let dataarr = {"search" : skey};
        let url = APIURL + '/Load_Goods_List';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            let arr = (data && data.list) ? data.list : [];
            let Cnt = arr.length;
            if(Cnt > 0){
                let html = '';
                console.log(arr);
                $.each(arr, function (index, el) {
                    html += `<button class="copyOption active" id="option_product" name="option_product" data-code="${el.pdcode}">${el.pdname}</button>`;
                });
                $('#product_list').append(html);
                $('#product_list').addClass('active');
            }else{
                Make_Toast('검색된 상품이 없습니다.');
            }
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            console.log(data);
            $('#zipcode').val(data.zonecode);
            $('#address1').val(data.roadAddress);
            $('#address2').focus();
        }
    }).open();
}
