<?php

namespace App\Controllers;

use App\Libraries\Auth;
use App\Libraries\Form;
use App\Libraries\Utils;
use CodeIgniter\API\ResponseTrait;

class SampleController extends BaseController
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

        return view('web/master/work_DashBoard_View');
    }
}