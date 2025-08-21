<?php

namespace App\Controllers;

use App\Libraries\Auth;
use App\Libraries\Form;
use App\Libraries\Utils;
use CodeIgniter\API\ResponseTrait;

class CommonController extends BaseController
{

    use ResponseTrait;

    public function DashBoard()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/dashBoard_View');
    }

    public function linkMalls()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/linkMalls_View');
    }

    public function orderInfo()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/orderInfo_View');
    }

    public function deliInfo()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/deliInfo_View');
    }

    public function packingInfo()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/packingInfo_View');
    }


    public function GoodsList()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/GoodsList_View');
    }


    public function GoodsRegister()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();


        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
//        print_r($main_data);
//        return '';

        return view('web/common/GoodsRegister_View');
    }
}