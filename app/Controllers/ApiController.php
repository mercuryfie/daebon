<?php

namespace App\Controllers;


use App\Libraries;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;


class ApiController extends BaseController
{
    use ResponseTrait;

    public function Make_Token()
    {
        $request = service('request');
        $target = ($request->getPost('target') == '') ? '' : $request->getPost('target');

        if($target = 'gmarket'){
            $secretKey = 'SecretKey';
            $masterId = ESM_MID;
            $sellerId = ESM_SELLER;
            $siteId = 'G'; // G: G마켓, A: 옥션
            $issuer = 'https://www.daeguyg.com/';
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
        return $this->respond($return);

    }




}