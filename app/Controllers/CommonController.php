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

    public function orderList()
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

        return view('web/common/orderList_View');
    }

    public function deliList()
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

        return view('web/common/deliList_View');
    }

    public function packingList()
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

        return view('web/common/packingList_View');
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

    public function matiRegister()
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

        return view('web/common/matiRegister_View');
    }

    public function manuRegister()
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

        return view('web/common/manuRegister_View');
    }


    public function matiEditor()
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

        return view('web/common/matiEditor_View');
    }

    public function manuEditor()
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

        return view('web/common/manuEditor_View');
    }



    public function sangStatus()
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

        return view('web/common/sangStatus_View');
    }


    public function sangList()
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

        return view('web/common/sangList_View');
    }


    public function sangDetail()
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

        return view('web/common/sangDetail_View');
    }

    public function sangComplete()
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

        return view('web/common/sangComplete_View');
    }


    public function sangDetail2()
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

        return view('web/common/sangDetail2_View');
    }

    public function sangComplete2()
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

        return view('web/common/sangComplete2_View');
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