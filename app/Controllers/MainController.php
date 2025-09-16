<?php

namespace App\Controllers;


use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Models;
use App\Libraries\Utils;
use App\Libraries\Form;


class MainController extends BaseController
{

    use ResponseTrait;
    
    public function main($skey=false){
        $util = New Utils;
//        $sessinarr = $util->fnGetSessionData();

        $metaarr = array(
            'h_title' => 'daebon',
            'h_type' => 1
        );

        return view('web/common/main_View',$metaarr);
    }
}
