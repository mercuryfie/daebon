<?php
namespace App\Libraries;

class Auth
{
	protected $Config;


    public function __construct()
    {
        $this->Config         = new \Config\Encryption();
        $this->Config->key    = SECURITY_KEY;
        $this->Config->driver = 'OpenSSL';
    }

    public function Make_Key($enArr){

        $encrypter = \Config\Services::encrypter($this->Config);
        $en_str = json_encode($enArr);
        $ciphertext = $encrypter->encrypt($en_str);

        return $this->base64UrlEncode($ciphertext);
    }

    public function Open_Key($deVal){
        $val = $this->base64UrlDecode($deVal);
        $encrypter = \Config\Services::encrypter($this->Config);
        $orgtext = $encrypter->decrypt($val);
        if($orgtext!=''){
            $de_str = json_decode($orgtext,true);
        }else{
            $de_str = array();
        }


        return $de_str;

    }

    private function base64UrlEncode(string $data)
    {
        $base64Url = strtr(base64_encode($data), '+/', '-_');
        return urlencode(rtrim($base64Url, '='));
    }
   
    private function base64UrlDecode(string $base64Url)
    {
        return base64_decode(strtr(urldecode($base64Url), '-_', '+/'));
    }

    
}