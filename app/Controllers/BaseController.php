<?php

namespace App\Controllers;

use App\Libraries\Auth;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['cookie'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->request = service('request');
    }

    public function fn_SetInstructions_Step($model,$gicode,$workeruid){
        $nowprcode = '';
        $data = [];
        $cRs = $model->Load_Instructions_Info($gicode);
        if(fn_ArrayCnt($cRs)>0) {
            $iscomplete = $cRs[0]['is_complete'];
            $stepnow = $cRs[0]['step_now'];
            $stepsubnow = $cRs[0]['step_sub_now'];
            $mType = Return_Member_Type($workeruid);
            $gubun = Return_Prodcess_Gubun($model,$gicode,$stepnow);
            if($iscomplete==0) {//완료 안됨
                //현재 prcode 로드
                $stepnow = ($stepnow==0) ? 1 : $stepnow;
                $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                if(fn_ArrayCnt($aRs) == 0){
                    $nowprcode = 'error';
                }else {
                    $nowprcode = $aRs[0]['fk_prcode'];
                    $gicode = $aRs[0]['fk_gicode'];
                    if (($mType == AUTH_PRODUCT) && ($stepsubnow == 0)) {
                        $Cnt = fn_Input_ProcessWorker($model, $gicode, $nowprcode, $workeruid, 1);
                    }
                    //새로운 프로세스 저장
                    $param = ['step_now'=>$stepnow,'step_sub_now' => 1];
                    $Cnt = $model->Update_Instructions_Info($gicode, $param);
                    $param = ['status' => 1];
                    $Cnt = $model->Update_Instructions_Process($gicode,$nowprcode,$param);
                }
            }else if($iscomplete==1) {//공정완료됨
                if($gubun==1) {
                    //단일공정일경우 다음프로세스로 넘긴다 로그인계정이 작업자일경우 작업자 등록까지 진행
                    $newStep = $stepnow + 1;
                    $aRs = $model->Load_Instructions_NowProcess($gicode, $newStep);
                    if (fn_ArrayCnt($aRs) == 0) {
                        $nowprcode = 'error';
                    } else {
                        $nowprcode = $aRs[0]['fk_prcode'];
                        $gicode = $aRs[0]['fk_gicode'];
                        //작업자 등록
                        if (($mType == AUTH_PRODUCT) && ($stepsubnow == 2)) {
                            $Cnt = fn_Input_ProcessWorker($model, $gicode, $nowprcode, $workeruid, 1);
                        }
                        //새로운 프로세스 저장
                        $param = ['step_now' => $newStep, 'step_sub_now' => 1, 'is_complete' => 0];
                        $Cnt = $model->Update_Instructions_Info($gicode, $param);
                        $param = ['status' => 1];
                        $Cnt = $model->Update_Instructions_Process($gicode,$nowprcode,$param);
                    }
                }else if($gubun==2) {
                    //복합공정일경우 현재 step_sub_now 가 0일경우 신규, 1일경우 복합공정 시작 2일경우 복합공정 완료
                    if($stepsubnow==0) {
                        //현재 prcode 로드
                        $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                        if(fn_ArrayCnt($aRs) == 0){
                            $nowprcode = 'error';
                        }else {
                            $nowprcode = $aRs[0]['fk_prcode'];
                            //새로운 프로세스 저장
                            $param = ['step_sub_now' => 1, 'is_complete' => 0];
                            $Cnt = $model->Update_Instructions_Info($gicode, $param);
                        }
                    }else if($stepsubnow==1){
                        $aRs = $model->Load_Instructions_NowProcess($gicode, $stepnow);
                        $nowprcode = (fn_ArrayCnt($aRs) === 0) ? 'error' : $aRs[0]['fk_prcode'];
                    }else if($stepsubnow==2){
                        $newStep = $stepnow + 1;
                        $aRs = $model->Load_Instructions_NowProcess($gicode, $newStep);
                        if (fn_ArrayCnt($aRs) == 0) {
                            $nowprcode = 'error';
                        } else {
                            $nowprcode = $aRs[0]['fk_prcode'];
                            $gicode = $aRs[0]['fk_gicode'];
                            if (($mType == AUTH_PRODUCT) && ($stepsubnow==2)){
                                $Cnt = fn_Input_ProcessWorker($model, $gicode, $nowprcode, $workeruid, 1);
                            }
                            //새로운 프로세스 저장
                            $param = ['step_now' => $newStep, 'step_sub_now' => 1, 'is_complete' => 0];
                            $Cnt = $model->Update_Instructions_Info($gicode, $param);

                            $param = ['status' => 1];
                            $Cnt = $model->Update_Instructions_Process($gicode,$nowprcode,$param);

                        }
                    }
                }
            }else if ($iscomplete==2) {//완전완료됨
                $nowprcode = 'complete';
            }
        }


        if(($nowprcode=='error') || ($nowprcode=='')) {
            $r_arr = [
                'status' => 'error',
                'prcode' =>'',
                'info' => [],
                'process' => []
            ];
        }else if($nowprcode=='complete'){
            $r_arr = [
                'status' => 'complete',
                'prcode' =>'',
                'info' => [],
                'process' => []
            ];
        }else{
            $info = fn_LoadInstructionsInfo($model,$gicode);
            $process = fn_LoadInstructionsSingleProcess($model,$gicode,$nowprcode);
            $r_arr = [
                'status' => 'ok',
                'prcode' => $nowprcode,
                'info' => $info,
                'process' => $process
            ];
        }

        return $r_arr;
    }


    public function GetSessionData()
    {
        $session = Services::session();
        $tstr = $session->get('DB_Sstr');
        if($tstr==''){
            $cstr = get_cookie(COOKIE_KEY);
            if($cstr==''){
                $data = [
                    'user' => '',
                    'islogin' => false
                ];
            }else{
                $auth = New Auth;
                $info = $auth->Open_Key($cstr);
                if(fn_ArrayCnt($info)<=0){
                    $data = [
                        'user' => '',
                        'islogin' => false
                    ];
                }else{
                    $user = [
                        'uid' => $info['uid'],
                        'userid' => $info['userid'],
                        'grade' => $info['grade'],
                        'name' => $info['name'],
                        'token' => $info['token']
                    ];

                    $data = [
                        'user' => $user,
                        'islogin' => true
                    ];
                    $session->set(SESSION_KEY,$cstr);
                }
            }
        }else{
            $auth = New Auth;
            $info = $auth->Open_Key($tstr);
            if(fn_ArrayCnt($info)<=0){
                $data = [
                    'user' => '',
                    'islogin' => false
                ];
            }else{
                $user = [
                    'uid' => $info['uid'],
                    'userid' => $info['userid'],
                    'grade' => $info['grade'],
                    'name' => $info['name'],
                    'token' => $info['token']
                ];

                $data = [
                    'user' => $user,
                    'islogin' => true
                ];
            }
        }
        return $data;
    }

    public function Check_Auth($AuthList){
        $sessinarr = $this->GetSessionData();
        if(!$sessinarr['islogin']){
            fn_Href('/member/login');
        } else {
            $auth = $sessinarr['user']['grade'];

            if(!in_array($auth, $AuthList)){
                fn_Alert('접근 권한이 없는 기능입니다. 다시 시도하여주세요', '/');
            }
        }
    }

    function fn_ENV_URL(){
        $retval = '';
        if(ENVIRONMENT=='production'){
            $retval = 'https://api.djmedi.net';
        }else if(ENVIRONMENT=='development'){
            $retval = 'https://devapi.djmedi.net';
        }

        return $retval;
    }

    private function Make_Token($target)
    {
        if($target == 'gmarket'){
            $secretKey = GMARKET_KEY;
            $masterId = ESM_MASTER;
            $sellerId = ESM_SELLER;
            $siteId = 'G'; // G: G마켓, A: 옥션
            $issuer = 'www.gmarket.co.kr';
            $timestamp = time();

            $header = [
                "alg" => "HS256",
                "typ" => "JWT",
                "kid" => $masterId,
            ];

            $payload = [
                "iss" => $issuer,
                "sub" => "sell",
                "aud" => "sa.esmplus.com",
                "iat" => $timestamp,
                "ssi" => "{$siteId}:{$sellerId}",
            ];

            $jwt = JWT::encode($payload, $secretKey, 'HS256', null, $header);
            $bodyarr = array(
                'Token' => "Bearer " . $jwt
            );

            $result = 'ok';
            $info = $bodyarr;
            $message = 'success';

        }else {
            $bodyarr = array(
                'Token' => "nothing"
            );

            $result = 'error';
            $info = $bodyarr;
            $message = 'NotMakeToken';
        }

        $return = array(
            'result' => $result,
            'info' => $info,
            'message' => $message
        );

        return $return;

    }


    public function Call_Cancels()
    {

        //$target = ($this->request->getPost('target') == '') ? '' : $this->request->getPost('target');
        $target = 'gmarket';

        $t_arr = $this->Make_Token($target);
        if($t_arr['result']=='ok') {
            $jwt = $t_arr['info']['Token'];
            echo($jwt.'<br><br>');
            $api = 'https://sa2.esmplus.com/claim/v1/sa/Cancels';
            $param = array(
                "SiteType" => 3,
                "CancelStatus" => 0,
                "Type" => 0,
                "StartDate" => "2025-08-01",
                "EndDate" => "2025-08-04",
                "PayNo" => "",
                "OrderNo" => "",
                "IsGiftOrder" => ""
            );
            //$result = $util->call_Market_api($jwt, $api, $param);

            //print_r($result);
        }

        return '';
    }



}
