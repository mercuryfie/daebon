<?php

namespace App\Controllers;


use App\Libraries\Auth;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiPackingController extends BaseController
{
    use ResponseTrait;

    public function Put_Packing_Info()
    {
        $sessinarr = $this->GetSessionData();
        $param = $this->request->getPost('param') ?? [];
        if ($sessinarr['islogin'] == false) {
            $result = 'NoLogin';
            $data = [];
            $message = '로그인이 필요합니다.';
        } else if (fn_ArrayCnt($param) === 0) {
            $result = 'Error001';
            $data = [];
            $message = '잘못된 접근입니다.';
        } else if (!Check_Token($sessinarr)) {
            $result = 'Error002';
            $data = [];
            $message = '잘못된 토큰입니다.';
        } else {
            $orcode = $param['orcode'];
            $opcode = $param['opcode'];

            $order_m = model('Order_m');
            $info = $order_m->Load_Order_Info($orcode);
            if (fn_ArrayCnt($info) <= 0) {
                $result = 'Error003';
                $data = [];
                $message = '존재하지 않는 주문번호 입니다. ';
            } else {
                $spcode = $info[0]['spcode'];
                $shoptyp = $info[0]['shoptyp'];
                $deli_info = $order_m->Load_PackingByOpcode($opcode);
                if (fn_ArrayCnt($deli_info) <= 0) {
                    $result = 'Error003';
                    $data = [];
                    $message = '존재하지 않는 배송정보 입니다. ';
                } else {
                    $delicode = $deli_info[0]['deli_code'];
                    $confirmseq = $deli_info[0]['fk_confirm'];

                    $param = [
                        'p_status' => 3,
                        'enddate' => fn_NowDateFormat(1),
                        'worker' => $sessinarr['user']['uid']
                    ];
                    $cnt = $order_m->Update_Order_Delivery_Info($opcode, $param);

                    $param = ['orstep' => 2];
                    $cnt = $order_m->Update_Order_Info2($orcode, $param);

                    $param = [
                        'opcode' => $opcode,
                        'spcode' => $spcode,
                        'delicode' => $delicode,
                        'shoptyp' =>$shoptyp
                    ];
                    $bool = $this->Put_Mall_DeliCode($param);


                    $result = 'ok';
                    $data = [];
                    $message = '';
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

    private function Put_Mall_DeliCode()
    {
        //각 쇼핑몰에 송장 업데이트 하기
        
        $bool = true;
        return $bool;
    }




}