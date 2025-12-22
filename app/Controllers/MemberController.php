<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class MemberController extends BaseController
{

    use ResponseTrait;

    public function logIn()
    {
        $sessinarr = $this->GetSessionData();

        if($sessinarr['islogin']==true){
            return redirect()->to('/order/dashboard');
        }else {
            $saveid = get_cookie(index: CK_IDSAVE);
            $prev_url = previous_url();
            if ($prev_url == '' || stripos($prev_url, 'login') !== false) {
                $rec_url = '';
            } else {
                $rec_url = $prev_url;
            }

            $metaarr = [
                'h_title' => '로그인',
                'h_type' => 1
            ];

            $main_data = [
                'saveid' => $saveid,
                'rec_url' => $rec_url
            ];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'main' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/login_View', $main_data);
        }
    }

    public function logOut()
    {
        $session = service('session');
        $session->remove(SESSION_KEY);
        delete_cookie(COOKIE_KEY, CK_DOMAIN, '/');

        return redirect()->to('/');
    }
}