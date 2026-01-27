<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

//    public function __construct()
//    {
//        $Auth = [AUTH_MASTER];
//        $this->Check_Auth($Auth);
//    }

    public function userRegister()
    {
        $sessinarr = $this->GetSessionData();

        $metaarr = [
            'h_title' => '사용자 등록',
            'h_type' => 1
        ];

        $main_data = [];

        $form = new Form;
        $main_data = [
            'meta' => $form->fnMake_Meta($metaarr),
            'header' => $form->fnMake_Header($sessinarr),
            'left' => $form->fnMake_Left(),
            'main' => $main_data,
            'footer' => $form->fnMake_Fooeter($sessinarr)
        ];

        return view('web/common/userRegister_View',$main_data);
    }


    public function userEditor()
    {
        $sessinarr = $this->GetSessionData();
        $uid = ($this->request->getGet('uid') == '') ? '' : $this->request->getGet('uid');
        $grade = ($this->request->getGet('grade') == '') ? '' : $this->request->getGet('grade');
        $master = $sessinarr['user']['grade'];
        log_message('debug', 'userEditor start uid=' . $uid . ', grade=' . $grade);

        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($uid=='') {
            fn_Alert('잘못된 접근입니다.[Error101]');
        }else if ($master != AUTH_MASTER) {
            fn_Alert('master 권한이 없습니다.[Error1022]');
        } else if ($uid == $sessinarr['user']['uid'] || (($uid != $sessinarr['user']['uid'])&&($master == AUTH_MASTER))){
            $metaarr = [
                'h_title' => '회원정보수정',
                'h_type' => 1
            ];

            $Member_m = model('Member_m');
            $u_info = $Member_m->Load_UserInfo($uid);
            if(fn_ArrayCnt($u_info)<=0){
                fn_Alert('잘못된 접근입니다.[Error103]');
            } else {
                $u_arr = [
                    'uid' => $u_info[0]['uid'],
                    'userid' => $u_info[0]['userid'],
                    'name' => $u_info[0]['name'],
                    'grade' => $u_info[0]['grade'],
                    'passwd' => $u_info[0]['passwd'],
                    'is_use' => $u_info[0]['is_use']
                ];
//
                $main_data = [
                    'grade_option' => fnMake_UserGrade_option($u_info[0]['grade']),
                    'user' => $u_arr
                ];

                $form = new Form;

                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $main_data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

            }
            return view('web/common/userEditor_View',$main_data);
        }
    }

    public function userList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '사용자 목록',
                'h_type' => 1
            ];

            $main_data = [];

            $form = new Form;
            $main_data = [
                'meta' => $form->fnMake_Meta($metaarr),
                'header' => $form->fnMake_Header($sessinarr),
                'left' => $form->fnMake_Left(),
                'main' => $main_data,
                'footer' => $form->fnMake_Fooeter($sessinarr)
            ];

            return view('web/common/userList_View',$main_data);
        }
    }



}
