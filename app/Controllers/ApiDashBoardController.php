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

            $i_arr = [
                'list' => [
                    'temperature' => $temperature,
                    'humidity'    => $humidity,
                    'order' => $o_arr
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