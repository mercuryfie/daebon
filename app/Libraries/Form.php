<?php
namespace App\Libraries;

use App\Libraries\Auth;

class Form
{
    public function fnMake_Meta($param)
    {
        $meta = array(
            'title' => $param['h_title'],
            'h_type' => $param['h_type']
        );

        return $meta;
    }


    public function fnMake_Header($sessionarr,$param=[])
    {

        $islogin = $sessionarr['islogin'];
        if($islogin=='true'){
            $header = [
                'islogin' => true,
                'uid' => $sessionarr['user']['uid'],
                'userid' => $sessionarr['user']['userid'],
                'name' => $sessionarr['user']['name'],
                'grade' => $sessionarr['user']['grade'],
                'token' => $sessionarr['user']['token']
            ];
        }else{
            $header = [
                'islogin' => false,
                'uid' => '',
                'userid' => '',
                'grade' => '',
                'token' => ''
            ];
        }
        if(fn_ArrayCnt($param)>0){
            $header['h_key'] = $param['skey'];
        }else{
            $header['h_key'] = '';
        }

        return $header;
    }

    public function fnMake_Left($inputinfo=[])
    {
        $currentUrl = fn_Get_URL(1);
        $m_arr = fnMake_Menu_name();
        $mCnt = fn_ArrayCnt($m_arr);
        $html='';
        for($i=1;$i<=$mCnt;$i++){
            $high = fnMake_HignMenu_name($i);
            $menuKey = 'menu'.$i;
            $data = $m_arr[$menuKey];
            $chkbool = fn_IsValueInArray($currentUrl,$data,'url');
            $angle = $chkbool ? 'fa-angle-up' : 'fa-angle-down';

            $html .= "<div class='menuBox' name='menuBox'>
                        <div class='topmenu flexType3' name='topmenu'>
                            <a href='javascript:;' class='topText'>" . $high . "</a>
                            <i class='fa-solid " . $angle . "'></i>
                        </div>";

            if($chkbool){
                $html .= "<div class='submenu submenu1-1 flexCol' name='submenu'>";
            }else{
                $html .= "<div class='submenu submenu1-1' name='submenu'>";
            }

            $sHtml = '';
            foreach ($data as $d){
                if($currentUrl===$d['url']){
                    $sHtml .= "<a href='javascript:;' class='subtext active' onclick='" . $d['link'] . "'>" . $d['name'] . "</a>";
                }else{
                    $sHtml .= "<a href='javascript:;' class='subtext' onclick='" . $d['link'] . "'>" . $d['name'] . "</a>";
                }

            }

            $html .= $sHtml . '</div></div>';
        }

        $left = [
            'searchval' => isset($inputinfo['searchval']) ? $inputinfo['searchval'] : '',
            'searchtyp' => isset($inputinfo['searchtyp']) ? $inputinfo['searchtyp'] : '',
            'html' => $html
        ];

        return $left;
    }

    public function fnMake_Fooeter($param=[])
    {

    }

    public function fnMake_Staff_Left($param=[])
    {
        $gicode = $param['gicode'];
        $left = [];
        if($gicode==''){
            $left = [
                'code' => ''
            ];
        }else{
            $produce_m = model('Produce_m');
            $info_arr = fn_LoadInstructionsInfo($produce_m,$gicode);
            $process_arr = fn_LoadInstructionsProcess($produce_m,$gicode);
            $prcode = (isset($param['prcode'])) ? $param['prcode'] : '';


            $left = [
                'gicode' => $gicode,
                'i_info' => $info_arr,
                'p_info' => $process_arr,
                'prcode' => $prcode
            ];
        }


        return $left;

    }



}