<?php

namespace App\Controllers;

use App\Libraries\Auth;
use App\Libraries\Form;
use App\Libraries\Utils;
use CodeIgniter\API\ResponseTrait;

class CommonController extends BaseController
{

    use ResponseTrait;

    public function dashBoard()
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


    public function packingStatus()
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

        return view('web/common/packingStatus_View');
    }


    public function goodsList()
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


    public function goodsRegister()
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

    public function productsList()
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

        return view('web/common/productsList_View');
    }

    public function productsRegister()
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

        return view('web/common/productsRegister_View');
    }

    public function productsAfterRegister()
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

        return view('web/common/productsAfterRegister_View');
    }



    public function producingStatus()
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

        return view('web/common/producingStatus_View');
    }


    public function producingControl()
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

        return view('web/common/producingControl_View');
    }


    public function producingDetail()
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

        return view('web/common/producingDetail_View');
    }


    public function inOutStatus()
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

        return view('web/common/inOutStatus_View');
    }


    public function atomList()
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

        return view('web/common/atomList_View');
    }

    public function atomRegister()
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

        return view('web/common/atomRegister_View');
    }



}