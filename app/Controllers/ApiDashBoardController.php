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

    public function Load_DashBoard_Product(){
        $sessinarr = $this->GetSessionData();
        $page = ($this->request->getPost('page')=='') ?'':$this->request->getPost('page');
        if ($sessinarr['islogin'] == false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        } else if (!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        } else {
            $page = max(1, (int)($page ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $name_arr = [];
            $stock_arr =[];
            $inven_arr = [];
            $product_m =model('Product_m');
            $fields = ['info.gscode','info.gsname','info.inventory','IFNULL(inout_sum.total_in, 0) AS total_input','IFNULL(inout_sum.total_out, 0) AS total_output','(IFNULL(inout_sum.total_in, 0) - IFNULL(inout_sum.total_out, 0)) AS current_stock'];

            $mRs = $product_m->Load_DashBoard_Product($limit,$offset,$fields);
            if(fn_ArrayCnt($mRs)>0){
                foreach ($mRs as $d){
                    $name_arr[] = $d['gsname'];
                    $stock_arr[] = $d['current_stock'];
                    $inven_arr[] = $d['inventory'];
                }
            }

            $i_arr = [
                'name' => $name_arr,
                'stock' => $stock_arr,
                'inven' => $inven_arr
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


    public function Load_DashBoard_Material(){
        $sessinarr = $this->GetSessionData();
        $page = ($this->request->getPost('page')=='') ?'':$this->request->getPost('page');
        if ($sessinarr['islogin'] == false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        } else if (!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        } else {
            $page = max(1, (int)($page ?? 1));
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $name_arr = [];
            $stock_arr =[];
            $inven_arr = [];
            $material_m =model('Material_m');
            $fields = ['m.mtcode','m.mtname','m.inventory','IFNULL((SELECT total FROM tbl_material_inout WHERE fk_mtcode = m.mtcode ORDER BY seq DESC LIMIT 1), 0) AS last_total'];
            $mRs = $material_m->Load_DashBoard_Material($limit,$offset,$fields);
            if(fn_ArrayCnt($mRs)>0){
                foreach ($mRs as $d){
                    $name_arr[] = $d['mtname'];
                    $stock_arr[] = $d['last_total'];
                    $inven_arr[] = $d['inventory'];
                }
            }

            $i_arr = [
                'name' => $name_arr,
                'stock' => $stock_arr,
                'inven' => $inven_arr
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

    public function Load_DashBoard_Notice(){
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

            $notice = [];
            $common_m = model('Common_m');
            $cRs = $common_m->Load_NoticeType_List(2);
            if(fn_ArrayCnt($cRs)>0){
                foreach ($cRs as $d){
                    $notice[] = $d['bTitle'];
                }
            }

            $i_arr = [
                'list' => $notice
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

    public function Load_DashBoard_Weather(){
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

            $i_arr = [
                'list' => [
                    'temperature' => $temperature,
                    'humidity'    => $humidity
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

    public function Load_DashBoard_WeekOrder()
    {
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
            $order_data = [
                'Sunday' => 0,
                'Monday' => 0,
                'Tuesday' => 0,
                'Wednesday' => 0,
                'Thursday' => 0,
                'Friday' => 0,
                'Saturday' => 0
            ];
            $order_m = model('Order_m');
            $oRs = $order_m->Load_dashboard_WeekOrder();
            if(fn_ArrayCnt($oRs)>0){
                foreach ($oRs as $d){
                    $order_data[$d['day_name']] = (int)$d['order_count'];
                }
            }

            $i_arr = [
                'list' => $order_data
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

            $i_arr = [
                'list' => [
                    'order' => $o_arr,
                    'produce' => $p_arr,
                    'delivery' =>$d_arr
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