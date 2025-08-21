<?php
namespace App\Libraries;

use App\Libraries\Auth;
use App\Libraries\Utils;

class Form
{


    public function fnMake_Meta($data){
        $meta = array(
            'title' => $data['h_title'],
            'h_type' => $data['h_type']
        );

        return $meta;
    }


    public function fnMake_Header($sessionarr,$param=array()){
        $header = array();
        $islogin = $sessionarr['islogin'];
        if($islogin=='true'){
            $target = '';
            if($sessionarr['user']['mi_type']=='pharm'){
                $target = URL_PHARM;
            }else if($sessionarr['user']['mi_type']=='decoc'){
                $target = URL_Decoc;
            }else if($sessionarr['user']['mi_type']=='master'){
                $target = URL_MASTER;
            }
            $header = array(
                'islogin' => 'true',
                'uid' => $sessionarr['user']['uid'],
                'userid' => $sessionarr['user']['userid'],
                'micode' => $sessionarr['user']['mi_code'],
                'mitype' => $sessionarr['user']['mi_type'] ,
                'target' => $target,
            );



        }else{
            $header = array(
                'islogin' => 'false',
                'uid' => '',
                'userid' => '',
                'micode' => '',
                'mitype' => '',
                'target' => ''
            );

        }

        $util = new Utils;
        if($util->fnArrayCnt($param)>0){
            $header['h_key'] = $param['skey'];
        }else{
            $header['h_key'] = '';
        }
        return $header;
    }

    public function fnMake_Search($s_data){
        $searchData = '';
        return $searchData;
    }

    public function fnMake_Left($sessionarr){
        $left = array();
        $islogin = $sessionarr['islogin'];
        if($islogin=='true'){
            $left = array(
                'type' => $sessionarr['user']['mi_type'] ,
                'name' => $sessionarr['user']['mi_name']
            );
        }else{
            $left = array(
                'type' => '' ,
                'name' => '' 
            );

        }
        return $left;
    }

}