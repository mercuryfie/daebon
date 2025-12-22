<?php

namespace App\Controllers;


use App\Libraries\Auth;
use App\Libraries\CoupangApi;
use App\Libraries\EsmApi;
use App\Libraries\GmarketEsmApi;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiShopController extends BaseController
{
    use ResponseTrait;

    public function coupong_api_GetOrderPeriod(){
        $api = new CoupangApi();
        $body = $api->Get_Order_Period();
        return $this->respond($body);
    }
    public function coupong_api_getOrderInfo(){
        $api = new CoupangApi();
        $body = $api->Get_Order_Period('test111');
        return $this->respond($body);
    }

    public function esm_api_GetOrderInfo(){
        $api = New EsmApi('au');
        $body = $api->orderCheck('1111');
        return $this->respond($body);
    }



}