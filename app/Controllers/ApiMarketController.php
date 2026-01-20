<?php

namespace App\Controllers;


use App\Libraries\Auth;
use App\Libraries\CoupangApi;
use App\Libraries\ElevenStreetApi;
use App\Libraries\NaverApi;
use App\Libraries\EsmApi;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ApiMarketController extends BaseController
{
    use ResponseTrait;


    public function Shop_Opder_List(){
        $sessinarr = $this->GetSessionData();
        $shoptyp  = ($this->request->getPost('styp') == '') ? '' : $this->request->getPost('styp');
        $token = ($this->request->getPost('token') == '') ? '' : $this->request->getPost('token');
        if($sessinarr['islogin']==false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        }else if(!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        }else if($shoptyp==''){
            $result = 'Error003';
            $data = [];
            $message = '필수 입력값이 누락되었습니다.';
        }else {
            if($shoptyp=='type1'){
                $maker_m = model('Market_m');
                $param = ['shoptyp' => $shoptyp];
                $Rs = $maker_m->getMallLog($param);
                if(fn_ArrayCnt($Rs)>0){
                    $startdate =  explode(' ', $Rs[0]['indate'])[0].'%2B09:00';
                }else{
                    $startdate = fn_NowDateFormat(2).'%2B09:00';
                }
                $enddate = fn_NowDateFormat(2).'%2B09:00';
                $coupang = new CoupangApi();
                $order = $coupang->Get_Order_Period($startdate,$enddate,'ACCEPT',$token);
                if($order['code']==200){
                    $i_arr = ['list' => $order['data']];
                    $result = 'ok';
                    $data =$i_arr;
                    $message = '';
                }else{
                    $result = 'error';
                    $data = '';
                    $message = $order['message'];
                }
            }
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }


    public function Coupang_Order_Period(){
        $coupang = new CoupangApi();

        $sate = '2025-11-01';
        $edate = '2025-12-01';
        $status = 'FINAL_DELIVERY';
        $max = 10;

        $new_arr = [];
        $data = $coupang->Get_Order_Period($sate,$edate,$status,$max);
        if($data['code']=='200'){
            foreach ($data['data'] as $d){
                $t_arr = [
                    'shipmentBoxId' => $d['shipmentBoxId'],
                    'orderId' => $d['orderId'],
                    'orderedAt' => $d['orderedAt'],
                    'orderer' => $d['orderer'],
                    'paidAt' => $d['paidAt'],
                    'status' => $d['status'],
                    'receiver' => $d['receiver'],
                    'parcelPrintMessage' => $d['parcelPrintMessage'],
                    'deliveryCompanyName' => $d['deliveryCompanyName'],
                    'invoiceNumber' => $d['invoiceNumber'],
                    'inTrasitDateTime' => $d['inTrasitDateTime'],
                    'deliveredDate' => $d['deliveredDate']
                ];

                array_push($new_arr,$t_arr);
            }
        }


        print_r($new_arr);

        return '';
    }

    public function  Coupang_Info_Load(){
        $coupang = new CoupangApi();
        $pid = '15071727386';
        $t_arr = $coupang->Get_Product_Info_Load($pid);
        print_r($t_arr);

        return '';
    }

    public function ESM_Order_Check(){
        $esm = new EsmApi('au');
        $key = '2673852280';

        $arr = $esm->orderCheck($key);
        print_r($arr);
    }



    public function Eleven_Get_Standby()
    {
        $api = new ElevenStreetApi();
        $result = $api->Eleven_Get_Standby();
        print_r($result);
        return;
    }

    public function Eleven_Get_Order_Delivery(){

        $api = new ElevenStreetApi();
        $ordNo = '20251223026099039';
        $result = $api->Eleven_Get_Order_Delivery($ordNo);
        return $this->respond($result);
    }

    public function Eleven_Get_Order_Info_Period(){
        $sdate = date('YmdHi');
        $edate = date('YmdHi', strtotime('-7 days'));

        $api = new ElevenStreetApi();
        $result = $api->Eleven_Get_Order_Info_Period($sdate,$edate);
        return $this->respond($result);
    }


    public function Naver_Get_Product_Info()
    {
        try {
            $api = new NaverApi();

            $orders = $api->getOrders(['size' => 5]);
            return $this->response->setJSON([
                'success' => true,
                'count' => count($orders['data'] ?? []),
                'sample' => $orders['data'][0] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function Naver_Get_Order_Period()
    {
        try {
            $api = new NaverApi();

            $todayStart = date('Y-m-d') . ' 000000';
            $lastChangedFrom = fn_toIso8601Kst($todayStart);
            $response = $api->getOrdersAll(['lastChangedFrom' => $lastChangedFrom]);
            $arr = [];
            if(fn_ArrayCnt($response['data']) >0) {
                foreach ($response['data']['lastChangeStatuses'] as $d) {
                    $t_arr = [
                        'orderId' => $d['orderId'],
                        'productOrderId' => $d['productOrderId'],
                        'lastChangedType' => $d['lastChangedType'],
                        'paymentDate' => $d['paymentDate'],
                        'lastChangedDate' => $d['lastChangedDate'],
                        'productOrderStatus' => $d['productOrderStatus'],
                        'receiverAddressChanged' => $d['receiverAddressChanged']
                    ];
                    $arr[] = $t_arr;
                }
            }
            return $this->response->setJSON([
                'status' => 'ok',
                'data' => $arr,
                'msessage' => ''
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'data' => [],
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }


}