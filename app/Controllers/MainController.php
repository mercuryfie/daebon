<?php

namespace App\Controllers;


use CodeIgniter\API\ResponseTrait;
use App\Models;
use App\Libraries\Form;
use function PHPUnit\Framework\isEmpty;


class MainController extends BaseController
{

    use ResponseTrait;
    
    public function main(){
        $sessinarr = $this->GetSessionData();

        if($sessinarr['islogin']==true){
            if($sessinarr['user']['grade']==AUTH_MASTER){
                return redirect()->to('/order/dashboard');
            }else if($sessinarr['user']['grade']==AUTH_PRODUCT){
                return redirect()->to('/product');
            }else if($sessinarr['user']['grade']==AUTH_PACKING) {
                return redirect()->to('/packing');
            }
        }else{
            return redirect()->to('/member/login');
        }

    }
}
