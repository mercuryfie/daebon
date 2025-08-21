<?php

namespace App\Controllers;

use App\Libraries\Auth;
use App\Libraries\Form;
use App\Libraries\Utils;
use CodeIgniter\API\ResponseTrait;

class MemberController extends BaseController
{

    use ResponseTrait;

    public function Login()
    {
        $util = new Utils;
//        $sessinarr = $util->fnGetSessionData();

        helper(filenames: 'cookie');
        $saveid = get_cookie(index: 'dj_save');
        $data = array(
            'saveid' => $saveid
        );

        $metaarr = array(
            'h_title' => '로그인',
            'h_type' => 1
        );

        $form = new Form;
        $main_data = array(
            'meta' => $form->fnMake_Meta($metaarr),
//            'header' => $form->fnMake_Header($sessinarr),
            'main' => $data
        );
//        print_r($main_data);
//        return '';

        return view('web/common/login_View', $main_data);
    }

    public function LogOut()
    {
        $session = service('session');
        $session->remove(SESSION_KEY);
        helper('cookie');
        delete_cookie(COOKIE_KEY, '.djherb.kr', '/');

        return $this->response->redirect('/');
    }

    public function Login_Do()
    {
        $request = service('request');
        $userid = ($request->getPost('userid') == '') ? '' : $request->getPost('userid');
        $pwd = ($request->getPost('passwd') == '') ? '' : $request->getPost('passwd');
        $is_keep = ($request->getPost('iskeep') == '') ? 0 : $request->getPost('iskeep');
        $is_save = ($request->getPost('issave') == '') ? 0 : $request->getPost('issave');

        if (($userid == '') || ($pwd == '')) {
            $result = 'type101';
            $message = 'NotInputParameter';
        } else {
            $util = new Utils;
            $Member_m = model('Member_m');
            $fields = array('uid', 'userid', 'grade', 'name', 'mi_code', 'mi_name', 'mi_type','mi_cfcode');
            $param = array(
                'userid' => $userid,
                'passwd' => $pwd
            );
            $Rs = $Member_m->Load_UserID_Info($param, $fields);
            if ($util->fnArrayCnt($Rs) <= 0) {
                $result = 'type102';
                $message = 'Not Found User';
            } else {
                $Rs2 = $Member_m->Load_UserIDAPWD_Info($param, $fields);
                if ($util->fnArrayCnt($Rs2) <= 0) {
                    $result = 'type103';
                    $message = 'Not Match PWD';
                } else {
                    $auth = new Auth;
                    $LoginInfo = array(
                        'uid' => $Rs2[0]['uid'],
                        'userid' => $Rs2[0]['userid'],
                        'grade' => $Rs2[0]['grade'],
                        'name' => $Rs2[0]['name'],
                        'mi_code' => $Rs2[0]['mi_code'],
                        'mi_name' => $Rs2[0]['mi_name'],
                        'mi_type' => $Rs2[0]['mi_type'],
                        'mi_cfcode' => $Rs2[0]['mi_cfcode']
                    );
                    $security = $auth->Make_Key($LoginInfo);
                    if ($security == '') {
                        $result = 'type104';
                        $message = 'Error Encrypt';
                    } else {
                        $session = service('session');
                        $session->set(SESSION_KEY, $security);

                        helper('cookie');
                        if ($is_keep == 1) {
                            delete_cookie('dj_Cstr');

                            $cookie = array(
                                'name' => COOKIE_KEY,
                                'value' => $security,
                                'expire' => 86400 * 30,
                                'domain' => '.djherb.kr',
                                'path' => '/',
                                'prefix' => ''
                            );
                            set_cookie($cookie);
                        } else {
                            delete_cookie(COOKIE_KEY, '.djherb.kr', '/');
                        }

                        if ($is_save == 1) {
                            $cookie = array(
                                'name' => 'dj_save',
                                'value' => $userid,
                                'expire' => 2147483647,
                                'domain' => '.djherb.kr',
                                'path' => '/',
                                'prefix' => ''
                            );
                            set_cookie($cookie);
                        } else {
                            delete_cookie('dj_save', '.djherb.kr', '/');
                        }

                        $result = 'ok';
                        $key = $security;
                        $message = 'success';
                    }
                }
            }
        }

        $return = array(
            'result' => $result,
            'message' => $message
        );
        return $this->respond($return);


    }
}