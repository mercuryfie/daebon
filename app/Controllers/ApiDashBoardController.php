<?php

namespace App\Controllers;


use App\Libraries\Auth;
use App\Libraries\WeatherApi;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ApiDashBoardController extends BaseController
{
    use ResponseTrait;


    public function Load_DashBoard_Material(){

    }


    public function Load_DashBoard_Info(){
        $sessinarr = $this->GetSessionData();
        if ($sessinarr['islogin'] == false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        } else if (!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        } else {
            $weather = new WeatherApi();
            $locationStn = 143;
            $wResult = $weather->getAsosData($locationStn);
            $temperature = ($wResult) ? ($wResult['TA'] ?? '10') : '10';
            $humidity    = ($wResult) ? ($wResult['HM'] ?? '50') : '50';
            $order = [
                'type0' => 0,
                'type1' => 0,
                'type2' => 0,
                'type3' => 0,
                'type4' => 0,
                'type5' => 0,
                'type6' => 0,
                'type8' => 0,
                'type13' => 0,
                'type14' => 0
            ];

            $totarOrder = 0;
            $order_m = model('Order_m');
            $oRs = $order_m->Load_dashboardOrder_Info();
            if(fn_ArrayCnt($oRs)>0){
                foreach ($oRs as $d){
                    $order[$d['shoptyp']] = $d['Cnt'];
                    $totarOrder += $d['Cnt'];
                }
            }
            $o_arr = [
                'o_list' => $order,
                'o_tcnt' => $totarOrder
            ];

            $produce = [
                'p_ready' => 0,
                'p_ing' => 0,
                'p_complete' => 0
            ];

            $totalproduce = 0;
            $produce_m = model('Produce_m');
            $pRs = $produce_m->Load_dashboardProduce_Info();
            if(fn_ArrayCnt($pRs)>0){
                $produce['p_ready'] = $pRs[0]['count_ready'];
                $produce['p_ing'] = $pRs[0]['count_ing'];
                $produce['p_complete'] = $pRs[0]['count_complete'];
                $totalproduce += $pRs[0]['count_ready'] + $pRs[0]['count_ing'] + $pRs[0]['count_complete'];
            }

            $p_arr = [
                'p_list' => $produce,
                'p_tcnt' => $totalproduce
            ];

            $delivery = [
                'd_ready' => 0,
                'd_ing' => 0,
                'd_complete' =>0
            ];

            $totaldelivery = 0;
            $delivery_m = model('Delivery_m');
            $dRs = $delivery_m->Load_dashboardDelivery_Info();
            if(fn_ArrayCnt($dRs) > 0){
                $delivery['d_ready'] = $dRs[0]['package_ready'];
                $delivery['d_ing'] = $dRs[0]['package_start'];
                $delivery['d_complete'] = $dRs[0]['package_complete'];
                $totaldelivery = $dRs[0]['package_ready'] + $dRs[0]['package_start'] + $dRs[0]['package_complete'];
            }

            $d_arr = [
                'd_list' => $delivery,
                'd_tcnt' => $totaldelivery
            ];

            $notice = [];
            $common_m = model('Common_m');
            $cRs = $common_m->Load_NoticeType_List(2);
            if(fn_ArrayCnt($cRs)>0){

                foreach ($cRs as $d){
                    $notice[] = $d['bTitle'];
                }
            }


            $i_arr = [
                'list' => [
                    'temperature' => $temperature,
                    'humidity'    => $humidity,
                    'order' => $o_arr,
                    'produce' => $p_arr,
                    'delivery' =>$d_arr,
                    'notice' => $notice
                ]
            ];

            $result = 'ok';
            $data = $i_arr;
            $message = '';
        }

        $return = [
            'result' => $result,
            'info' => $data,
            'message' => $message
        ];
        return $this->respond($return);
    }

}