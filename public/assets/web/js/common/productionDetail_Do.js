$(document).ready(function() {
    let gicode = $('#gicode').data('cd');
    let nd = $('#gicode').data('nd');
    const skey = {
        skey : gicode
    };

    Make_Html(gicode,skey);
    // Make_Detail(gicode,skey);

    // let pcode = $("#barcodeDiv").data("pcode");
    // Prn_Barcode(pcode);

    // $(document).on('click','#btn_print',function(){
    //     printWindow('frnbody');
    // });

    $('#xBtn').click(function () {
        window.close();
    });

    $(document).on('click','button[name="prnRoastForm"]',function() {
        let code = $(this).data('code');
        pop_OrderRoastForm(code);
    });

    $(document).on('click','tr[name="view_detail"]',function(){
        let code = $(this).data('code');

    });

    $(document).on('click','button[name="vwReport"]',function() {
        let code = $('#gicode').data('cd');
        let url = "/produce/report?cd=" + code;
        pop_OrderRoastForm(url);
    });

    // $(document).on('click','button[name="vwReport"]',function() {
    //     let code = $(this).data('code');
    //     let url = "/produce/report?cd=" + code;
    //     pop_OrderRoastForm(url);
    // });

});



async function process_step(code){
    let prcode = await Load_Step(code);
    go_productionDetailStaff(code,prcode);
}

async function Load_Step(code){
    let prcode = '';
    try {
        start_spinner();
        let dataarr = {"code" : code};
        let url = APIURL + '/Load_Instructions_NowStep';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            prcode = data.prcode;
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return prcode;
}

let counter = 0;
function getNumber() {
    return ++counter;
}

async function Make_Html(data,skey){
    let arr = await Data_Load(data,skey);
    let html = '';
    if(!fn_IsEmpty(arr.list)){
        $.each(arr.list, function (index, el) {
            let i = getNumber();
            let worker = '';
            if (el.worker) {
                worker = `${el.worker}`;
            } else {
                worker = `-`;
            }

            html += `
                <tr class="" name="view_detail" data-nd="${el.gicode}"> 
                    <td class="ltTbody numbering">${i}</td>
                    <td class="ltTbody  ">${el.shortdate}</td> 
                    <td class="ltTbody  ">${el.step_name}</td>  
                    <td class="ltTbody  ">${el.status}</td>    
                    <td class="ltTbody  ">${worker}</td>  
                </tr>
            `;
        });
    }else{
        html = '<tr><td class="ltThead" colspan="10">검색된 데이터가 없습니다.</td></tr>';
    }
    $('#tList').append(html);
    // $('#tcnt').html(arr.total);
}



async function Data_Load(data,skey){
    let r_arr = {};
    try {
        start_spinner();
        let dataarr = {"code" : data, "skey" :skey};
        let url = APIURL + '/Load_Instructions_Process';
        let result = await Load_API_Auth(url,dataarr);
        if (result.get('status') == 'NoLogin') {
            go_login();
        }else if(result.get('status') == 'ok') {
            let data = result.get('data');
            arr = (data && data.list) ? data.list : [];
            tcnt = (data && data.tcnt) ? data.tcnt : 0;
            r_arr = {
                list : arr,
                total : tcnt
            };
        }else{
            Make_Toast(result.get('message') + "[" + result.get('status') + "]");
        }
        stop_spinner();
    } catch (error) {
        Make_Toast('오류가 발생하였습니다. 다시 시도하여주세요.\n[ERROR : ' + error + '}');
        stop_spinner();
    }
    return r_arr;
}
