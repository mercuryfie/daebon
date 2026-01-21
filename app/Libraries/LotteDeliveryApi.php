<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Client;
use CodeIgniter\API\ResponseTrait;

class LotteDeliveryApi
{
    use ResponseTrait;

    private $superCustCd;
    private $jobCustCd;
    private $accessToken;
    private $baseUrl;
    private $http;

    public function __construct()
    {
        $this->http = \Config\Services::curlrequest();
        if(ENVIRONMENT=='production'){
            $this->superCustCd = '289163';
            $this->jobCustCd = '289163';
            $this->baseUrl = 'https://apigw.llogis.com:10100/api';
            $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJDMDE0MDI1IiwiYXVkIjoiQzAxNDAyNSIsIm5hbWUiOiJkam1lZGkiLCJleHAiOjE1MzUxMzU1OTk5OTksImlhdCI6MTY5MDI1ODEwMH0.U9ZrVxawqDX1SiQbgoXCLI5kVcYG7qHt7ymlx88VcT4';
        }else{
            $this->superCustCd = '289163';
            $this->jobCustCd = '101000';
            $this->baseUrl = 'http://devapigw.llogis.com:10110/api';
            $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJDMDEwNjE5IiwiYXVkIjoiQzAxMDYxOSIsIm5hbWUiOiJkam1lZGkiLCJleHAiOjE1MzUxMzU1OTk5OTksImlhdCI6MTY5MDI1NzYwNX0.Gk4md4iQhEFdSuHst3NZosTbbM1b1PrBdPLXDm4hrfY';
        }
    }

    public function Make_Delivery_Code11(){

        $start=31810365581;
        $end=31810385580;

        $m=0;
        $deli_arr = [];
        for($i=$start;$i<=$end;$i++){
            $t_mod=$i%7;
            $deli_code=$i.$t_mod;

            $deli_arr[] = [ 'dcode' => $deli_code, 'typ' => 'lotte'];
            $m++;
        }
        return $deli_arr;
    }


    public function Get_Delivery_Info($orcode,$prtyp)
    {
        $order_m = model('Order_m');
        $data = get_Delivery_ConfirmByOrcode($order_m,$orcode);
        if(fn_ArrayCnt($data)<=0){
            $result = 'error103';
            $data = [];
            $message = '존재하지 않는 송장정보 입니다.';
        }else{
            $opcode = $data['opcode'];
            if ($prtyp == 1) {
                $deli_data = $this->Get_New_Address_Confirm($orcode);
                if ($deli_data['result']=='ok') {
                    $deli_code = $deli_data['data']['info']['deli_code'];
                    $confirm_num = $deli_data['data']['confirmseq'];

                    $response = $this->Send_Delivery_Info($deli_data['data']['info']);
                    if (fn_ArrayCnt($response) > 0) {
                        if($response['result'] =='ok') {

                            $deli_m= model('Delivery_m');
                            $param = [
                                'deli_code' => $deli_code,
                                'fk_confirm' => $confirm_num,
                                'deli_prn_date' => fn_NowDateFormat(1),
                                'p_status' => 2
                            ];
                            $Cnt = $deli_m->Update_Delivery_Info($opcode,$param);
                            $param = [
                                'fk_opcode' => $opcode,
                                'is_use' => 1
                            ];
                            $Cnt = $deli_m->Update_Delivery_Code($deli_code,$param);

                            $Rs = $deli_m->get_Delivery_confirm_info($confirm_num);

                            $result = 'ok';
                            $data = $Rs[0];
                            $message = '';
                        }else{
                            $result = 'error101';
                            $data = [];
                            $message = $response['message'];
                        }
                    }else{
                        $result = 'error103';
                        $data = [];
                        $message = $response['message'];
                    }
                } else {
                    $result = 'error101';
                    $data = [];
                    $message = $deli_data['message'];
                }
            }else if($prtyp == 2) {
                $confirm_num = $data['fk_confirm'];
                $deli_m = model('Delivery_m');
                $deli_data = $deli_m->get_Delivery_confirm_info($confirm_num);
                if (fn_ArrayCnt($deli_data) > 0) {
                    $result = 'ok';
                    $data = $deli_data[0];
                    $message = '';
                } else {
                    $result = 'error102';
                    $data = [];
                    $message = '확인되지 않는 배송정보 입니다.';
                }
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];

        return $return;
    }

    private function Send_Delivery_Info($param)
    {
        if(fn_ArrayCnt($param)>0) {

            $data = [
                'snd_list' => [
                    [
                        'superCustCd'=> $this->superCustCd, //계약코드
                        'jobCustCd' => $this->jobCustCd, // 거래처코드
                        'ustRtgSctCd' => '01', //출고반품구분(01:출고 02:반품)
                        'ordSct' => '01', //오더구분(1:일반 2:교환 3:AS)
                        'fareSctCd' => '01', //운임구분(01:현불,02:착불,03:신용)
                        'ordNo' => $param['orcode'], //주문번호
                        'invNo' => $param['deli_code'], //운송장번호
                        'snperNm' => $param['sender']['name'], //송하인명
                        'snperTel' => $param['sender']['phone'], //송하인전화번호
                        'snperCpno' => $param['sender']['phone'], //송하인휴대전화번호
                        'snperZipcd' => $param['sender']['zipcode'], //송하인우편번호
                        'snperAdr' => $param['sender']['address1'] . " " . $param['sender']['address2'], //송하인주소(기본주소 + 상세주소)
                        'acperNm' => $param['receiver']['name'], //수하인명
                        'acperTel' => $param['receiver']['phone'], //수하인전화번호
                        'acperCpno' => $param['receiver']['phone'], //수하인휴대전화번호
                        'acperZipcd' => $param['receiver']['zipcode'], //수하인우편번호
                        'acperAdr' => $param['receiver']['address1'] . " " . $param['receiver']['address2'], //수하인주소(기본주소 + 상세주소)
                        'boxTypCd' => "A", //박스크기(A, B, C, D, E, F)
                        'sumFare' => "", //현/착불 기본운임 ex(2500)
                        'gdsNm' =>  $param['pname'],//상품명
                        'dlvMsgCont' => $param['receiver']['comment'], //배달메세지내용
                        'cusMsgCont' => '', //고객메세지내용
                        'pickReqYmd' => date("Ymd"), //집하요청일
                        'bdpkSctCd' => 'N', //합포장여부(Y / N)
                        'bdpkKey' => '', //합포장KEY
                        'bdpkRpnSeq' => '', //합포장순번
                        'ordPerNm' => '', //주문자명
                        'ordPerTel' => '', //주문자전화번호
                        'ispdQty' => $param['pcnt'] //내품수량
                    ]
                ]
            ];

            $api = '/pid/cus/714a/apiSndOut';
            $data = $this->Load_API($api, $data);
            if($data['status']=='success'){
                $result = 'ok';
                $data = $data['rtn_list'];
                $message = '';
            } else {
                $result = 'error100';
                $data = [];
                $message = '송장정보 전송에 실패 하였습니다.\n(error:' . $data['message'] .')' ;
            }
        }else{
            $result = 'error101';
            $data = [];
            $message = '정보로드에 실패하였습니다.\n(error:' . $data['message'] .')' ;
        }
        $return = [
            'result' => $result,
            'data' => $data,
            'message' => $message
        ];

        return $return;
    }




    private function Get_New_Address_Confirm($orcode)
    {
        $deli_code = $this->Get_Delivery_Code();
        if($deli_code==''){
            $r_arr = [
                'result' => 'error',
                'data'  => [],
                'message' => '사용할수 있는 송장번호가 없습니다.\n전산실로 문의 부탁 드립니다.'
            ];
        }else{
            $order_m = model('Order_m');
            $Rs = $order_m->Load_Order_Info($orcode);
            if(fn_ArrayCnt($Rs) > 0) {
                $r_name = $Rs[0]['receive_name'];
                $r_phone = $Rs[0]['receive_phone'];
                $r_zip = $Rs[0]['receive_zipcode'];
                $r_address1 = $Rs[0]['receive_address1'];
                $r_address2 = $Rs[0]['receive_address2'];
                $r_comment = $Rs[0]['receive_memo'];
                $param = [
                    'zipcode' => $r_zip,
                    'address1' => $r_address1,
                    'address2' => $r_address2
                ];
                $data1 = $this->Get_Address_refinement($param);
                if (($data1['result'] != 'ok') || ($data1['data']['filt_cd']=='')){
                    $r_arr = [
                        '$result' => 'error',
                        'data'  => [],
                        'message' => '받으시는분 주소 재확인 부탁 드립니다.'
                    ];
                } else {
                    $s_name = COMPANY_NAME;
                    $s_phone = COMPANY_MOBILE;
                    $s_zip = COMPANY_ZIP;
                    $s_address1 = COMPANY_ADDRESS1;
                    $s_address2 = COMPANY_ADDRESS2;

                    $param = [
                        'zipcode' => $s_zip,
                        'address1' => $s_address1,
                        'address2' => $s_address2
                    ];
                    $data2 = $this->Get_Address_refinement($param);
                    if (($data2['result'] != 'ok') || ($data2['data']['filt_cd']=='')){
                        $r_arr = [
                            '$result' => 'error',
                            'data'  => [],
                            'message' => '받으시는분 주소 재확인 부탁 드립니다.'
                        ];
                    } else {
                        $sender = [
                            'name' => $s_name,
                            'phone' => fn_formatmobile($s_phone),
                            'zipcode' => $s_zip,
                            'address1' => $s_address1,
                            'address2' => $s_address2,
                            'filt_cd' => $data2['data']['filt_cd'],
                            'tml_cd' => $data2['data']['tml_cd'],
                            'tml_nm' => $data2['data']['tml_nm'],
                            'city_gun_gu' => $data2['data']['city_gun_gu'],
                            'dong' => $data2['data']['dong'],
                            'brnshp_nm' => $data2['data']['brnshp_nm'],
                            'emp_nm' => $data2['data']['emp_nm']

                        ];

                        $receiver = [
                            'name' => $r_name,
                            'phone' => fn_formatmobile($r_phone),
                            'zipcode' => $r_zip,
                            'address1' => $r_address1,
                            'address2' => $r_address2,
                            'comment' => $r_comment,
                            'filt_cd' => $data1['data']['filt_cd'],
                            'tml_cd' => $data1['data']['tml_cd'],
                            'tml_nm' => $data1['data']['tml_nm'],
                            'city_gun_gu' => $data1['data']['city_gun_gu'],
                            'dong' => $data1['data']['dong'],
                            'brnshp_nm' => $data1['data']['brnshp_nm'],
                            'emp_nm' => $data1['data']['emp_nm']
                        ];

                        $prodct = get_Order_Product_short_info($order_m,$orcode);
                        if((fn_ArrayCnt($prodct)>0)){
                            $pname = $prodct['name'];
                            $pcnt = $prodct['pcnt'];
                        }else{
                            $pname = '';
                            $pcnt = 0;
                        }


                        $param = [
                            'fk_dcode' => $deli_code,
                            'fk_orcode' => $orcode,
                            'confirm_date' => date('Y/m/d'),
                            'pname' => $pname,
                            'pcnt' => $pcnt,
                            's_filt_cd' => $data2['data']['filt_cd'],
                            's_name' => $s_name,
                            's_phone' => fn_formatmobile($s_phone),
                            's_zipcode' => $s_zip,
                            's_address1' => $s_address1,
                            's_address2' => $s_address2,
                            's_tml_cd' => $data2['data']['tml_cd'],
                            's_tml_nm' => $data2['data']['tml_nm'],
                            's_city_gun_gu' => $data2['data']['city_gun_gu'],
                            's_dong' => $data2['data']['dong'],
                            's_brnshp_nm' => $data2['data']['brnshp_nm'],
                            's_emp_nm' => $data2['data']['emp_nm'],
                            'r_filt_cd' => $data1['data']['filt_cd'],
                            'r_name' => $r_name,
                            'r_phone' => fn_formatmobile($r_phone),
                            'r_zipcode' => $r_zip,
                            'r_address1' => $r_address1,
                            'r_address2' => $r_address2,
                            'r_comment' => $r_comment,
                            'r_tml_cd' => $data1['data']['tml_cd'],
                            'r_tml_nm' => $data1['data']['tml_nm'],
                            'r_city_gun_gu' => $data1['data']['city_gun_gu'],
                            'r_dong' => $data1['data']['dong'],
                            'r_brnshp_nm' => $data1['data']['brnshp_nm'],
                            'r_emp_nm' => $data1['data']['emp_nm']
                        ];

                        $del_m = model('Delivery_m');
                        $confirm_seq = $del_m->Insert_Delivery_Confirm($param);

                        $d_arr = [
                            'orcode' => $orcode,
                            'deli_code' => $deli_code,
                            'confirm_date' => date('Y/m/d'),
                            'pname' => $pname,
                            'pcnt' => $pcnt,
                            'sender' => $sender,
                            'receiver' => $receiver
                        ];

                        $i_arr = [
                            'confirmseq' => $confirm_seq,
                            'info' => $d_arr
                        ];

                        $r_arr = [
                            'result' => 'ok',
                            'data'  => $i_arr,
                            'message' => ''
                        ];
                    }
                }
            }
        }
        return $r_arr;
    }

    private function Get_Address_refinement($data)
    {
        $api = '/address/newprint-info';
        $s_zip = $data['zipcode'];
        $s_address = $data['address1'] . $data['address1'];
        $param1 = [
            "address" => $s_address,
            "area_no" => $s_zip,
            "id" => $this->superCustCd,
            "network" => "00"
        ];
        $response = $this->Load_API($api, $param1);
        if($response['result'] == 'success'){
            return [
                'result' => 'ok',
                'data' => $response,
                'message' => ''
            ];
        } else {
            return [
                'result' => 'error',
                'info' => [],
                'message' => '주소정제 실패'
            ];
        }
    }

    private function Get_Delivery_Code(){
        $del_code = '';
        $delivery_m = model('Delivery_m');
        $Rs = $delivery_m->get_Delivery_code();
        if(fn_ArrayCnt($Rs)>0){
            $del_code = $Rs[0]['dcode'];
        }
        return $del_code;
    }

    private function Load_API($endpoint, $data)
    {
        $response = $this->http->request('POST', $this->baseUrl . $endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'IgtAK ' . $this->accessToken
            ],
            'json' => $data,
            'http_errors' => false,
            'timeout' => 30
        ]);

        $body = $response->getBody();
        $bodyJson = json_decode($body, true);
        return $bodyJson;

    }



}