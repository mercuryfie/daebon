$(document).ready(function() {
    $('.period').click(function(e) {
        e.preventDefault();
        $('.period').removeClass('active');
        $(this).addClass('active');

        const today = new Date();
        let startDate = new Date();
        let endDate = new Date();

        const periodText = $(this).text();

        switch (periodText) {
            case '오늘':
                startDate = today;
                endDate = today;
                break;
            case '1주일':
                startDate = new Date(today);
                startDate.setDate(today.getDate() - 6);
                endDate = today;
                break;
            case '1개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 1);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            case '3개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 3);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            default:
                startDate = today;
                endDate = today;
        }

        $('#s_date').val(formatDate(startDate));
        $('#e_date').val(formatDate(endDate));

    });

    $('.datepicker').each(function(index, elem) {
        const fp = flatpickr(elem, {
            dateFormat: "Y-m-d",
            minDate: "2024-01-01",
            static: true,
            appendTo: elem.parentNode,
            onClose: function(selectedDates, dateStr, instance) {
                instance.element.blur();
            }
        });

        $('.calicon').eq(index).on('click', function(e) {
            e.preventDefault();
            fp.open();
        });
    });

    $('#btn_search').on('click', function () {
        doSearch();
    });

    $('#txt_search').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); // 폼 submit 등 기본 동작 방지
            doSearch();
        }
    });

    $('#gdsDetailWrap #Xbtn, #gdsDetailWrap #Xbtn2').click(function () {
        $('#gdsDetailWrap').css('display','none');
    });

    $('#excelPop').click(function () {
        $('#uploadExcel').css('display','block');
    });

    $('#uploadExcel #Xbtn, #uploadExcel #Xbtn2').click(function () {
        $('#uploadExcel').css('display','none');
        $('#attachExcel').val('');
    });

    $(document).on('click','button[name="remove_btn"]',function(){
        let code = $(this).data('code');
        if(code==''){
            Make_Toast('잘못된 접근입니다.');
        }else if(window.confirm('삭제 하시겠습니까?')==true){
            Data_Delete(code);
        }
    });

    $('#submitBtn').on('click', function () {
        const fname = $('#attachExcel').val();
        if(fname == '') {
            Make_Toast('업로드한 파일이 없습니다.');
        } else {
            Upload_Excel('attachExcel',3,5);
            $('#attachExcel').val('');
            $('#uploadExcel').css('display','none');

        }
    });

    $(document).on('click', '.fa-copy', function() {
        let code = $(this).data('copy');
        let temp = $("<textarea>");
        $("body").append(temp);
        temp.val(code).select();
        document.execCommand("copy");
        temp.remove();

        Make_Toast('복사되었습니다. ');
    });

    doSearch();

});

let isSearching = false;

function ini_pop(){
    $('#matchlist').empty();
    $('#goodslist').empty();
    $('#materiallist').empty();
}

async function pop_GoodsDetail(pdcode,pdname) {
    if(pdcode==''){
        Make_Toast('잘못된 접근입니다.');
    }else {
        ini_pop();

        $('#pdcode').text(pdcode);
        $('#pdname').text(pdname);

        let arr = await Load_Detail(pdcode);
        let match = arr.match;
        if (match && Object.keys(match).length > 0) {
            let html = '';
            $.each(match, function (index, el) {
                html += ` 
                    <tr>
                        <td class=" copyIcon">${el.fk_excode}<i class="fa-regular fa-copy" data-copy="${el.fk_excode}"></i></td>
                        <td class="">${el.shopname}</td>
                    </tr>
                `;
            });
            $('#matchlist').append(html);
        }

        let goods = arr.goods;
        if (goods && Object.keys(goods).length > 0) {
            let html = '';
            $.each(goods, function (index, el) {
                html += ` 
                    <tr>
                        <td class="">${el.gsname}</td>
                        <td class="">${el.cnt}개</td>
                    </tr> 
                `;
            });
            $('#goodslist').append(html);
        }

        let material = arr.material;
        if (material && Object.keys(material).length > 0) {
            let html = '';
            $.each(material, function (index, el) {
                html += ` 
                    <tr>
                        <td class="">${el.mtname}</td>
                        <td class="">${el.cnt}개</td>
                    </tr>
                `;
            });
            $('#materiallist').append(html);
        }


        $('#gdsDetailWrap').css('display', 'block');
    }
}

async function Data_Delete(code){
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Delete_Products';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            $('#list_' + code).remove();
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
        Make_Toast('삭제하였습니다. ');
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
}

function doSearch() {
    let skey = $('#txt_search').val();
    if (isSearching) return;  // 연타 방지
    isSearching = true;
    Make_Html(skey).finally(() => {
        // Make_Html 완료 후 복구
        isSearching = false;
    });
}

async function Load_Detail(pdcode){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"code" : pdcode};
        let url = APIURL + '/Load_Product_Detail';
        let result = await Load_API_Auth(url,dataarr);
        console.log(result);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = result.get('data').info;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}



async function Make_Html(skey){
    let data = await Load_Data(skey);
    let arr = (data && data.list) ? data.list : [];
    console.log(arr);
    let html = '';
    if(arr.length > 0) {
        $.each(arr, function (index, el) {
            html += `
                <tr id="list_${el.pdcode}">
                    <td class="ltTbody detailTd"><div class="flexType2  "><a href="javascript:void(0);" onclick="go_goodsEdit('${el.pdcode}');">${el.pdcode}</a><a href="javascript:;" class="detail_fo1 flexType1 ml10" onclick="pop_GoodsDetail('${el.pdcode}','${el.pdname}');"><i class="fa-solid fa-info"></i></a></div></td>
                    <td class="ltTbody"><a href="javascript:void(0);" onclick="go_goodsEdit('${el.pdcode}');">${el.pdname}</a></td>
                    <td class="ltTbody">${el.cname}</td>
                    <td class="ltTbody">${number_format(el.pdWeigth)}g</td>
                    <td class="ltTbody">${number_format(el.pdprice)}원</td>
                    <td class="ltTbody">${el.mCnt}개</td>
                    <td class="ltTbody">${el.gCnt}개</td>
                    <td class="ltTbody">${el.indate}</td>
                    <td class="ltTbody">
                        <button type="button" class="btnType3 removeBtn" data-code="${el.pdcode}" name="remove_btn">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#tList').empty();
        $('#tList').append(html);
        $('#tcnt').html(data.tcnt);
    }else{
        html = '<tr><td class="ltThead" colspan="9">검색된 데이터가 없습니다.</td></tr>';
        $('#cpage').hide();
        $('#tList').empty();
        $('#tList').append(html);
        $('#tcnt').html(data.tcnt);
    }
}

async function Load_Data(skey){
    let data = {};
    try {
        start_spinner();
        let dataarr = {"search" : skey};
        let url = APIURL + '/Load_Product_List';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            data = {
                list : result.get('data').list,
                tcnt : result.get('data').total
            }
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return data;
}
