<?php

namespace App\Controllers;

use App\Libraries\Form;
use CodeIgniter\API\ResponseTrait;

class CommonController extends BaseController
{

    use ResponseTrait;

    public function __construct()
    {
        $Auth = [AUTH_MASTER];
        $this->Check_Auth($Auth);
    }

    public function noticeList()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '공지사항',
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

            return view('web/common/noticeList_View',$main_data);
        }
    }


    public function noticeRegister()
    {
        $sessinarr = $this->GetSessionData();
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else {
            $metaarr = [
                'h_title' => '공지사항',
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

            return view('web/common/noticeRegister_View',$main_data);
        }
    }

    public function noticeEditor()
    {
        $sessinarr = $this->GetSessionData();
        $master = $sessinarr['user']['grade'];
        $bcode  = ($this->request->getGet('cd') == '') ? '' : $this->request->getGet('cd');
        if($sessinarr['islogin']==false) {
            return redirect()->to('/member/login');
        }else if($bcode=='') {
            fn_Alert('잘못된 접근입니다.[Error101]');
        }else if ($master != AUTH_MASTER) {
            fn_Alert('master 권한이 없습니다.[Error102]');
        } else {

            $metaarr = [
                'h_title' => '공지사항 수정',
                'h_type' => 1
            ];

            $common_m = model('Common_m');
            $Rs = $common_m->Load_NoticeInfo($bcode);
            if(fn_ArrayCnt($Rs) <= 0){
                fn_Alert('존재하지 않는 게시글입니다.');
            } else if (fn_ArrayCnt($Rs) >= 1) {

                $data = [
                    'bcode' => $Rs[0]['bcode'],
                    'is_Fix' => $Rs[0]['is_Fix'],
                    'is_Notice' => $Rs[0]['is_Notice'],
                    'b_title' => $Rs[0]['bTitle'],
                    'b_content' => $Rs[0]['bContent']
                ];

                $form = new Form;
                $main_data = [
                    'meta' => $form->fnMake_Meta($metaarr),
                    'header' => $form->fnMake_Header($sessinarr),
                    'left' => $form->fnMake_Left(),
                    'body' => $data,
                    'footer' => $form->fnMake_Fooeter($sessinarr)
                ];

                return view('web/common/noticeEditor_View',$main_data);

            } else {
                fn_Alert('잘못된 접근입니다. [Error103]');

            }
        }
    }



}