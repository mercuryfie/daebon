<?php
namespace App\Libraries;

use Carbon\Carbon;
use Config\Services;

class Utils
{

    function fn_OrderStepName($step){
            $str = '';
        if($step==0){
            $str = "미확인";
        }else if($step==1){
            $str = "제품준비중";
        }else if($step==2){
            $str = "배송준비중";
        }else if($step==3){
            $str = "배송중";
        }else if($step==4){
            $str = "배송완료";
        }
        return $str;
    }

    function fn_PackageStepName($step){
        $str = '';
        if($step==0){
            $str = "제품준비중";
        }else if($step==1){
            $str = "배송준비중";
        }else if($step==2){
            $str = "배송중";
        }else if($step==3){
            $str = "배송완료";
        }
        return $str;
    }

    function fn_ArrayMutiSorting($arr, $key1, $order1, $key2, $order2) {
        usort($arr, function($a, $b) use ($key1, $order1, $key2, $order2) {
            // 첫 번째 키 비교
            if ($a[$key1] == $b[$key1]) {
                // 2순위 키 비교
                if ($order2 === 'desc') {
                    return $b[$key2] <=> $a[$key2]; // 내림차순
                } else {
                    return $a[$key2] <=> $b[$key2]; // 오름차순
                }
            } else {
                if ($order1 === 'desc') {
                    return $b[$key1] <=> $a[$key1]; // 내림차순
                } else {
                    return $a[$key1] <=> $b[$key1]; // 오름차순
                }
            }
        });
        return $arr;
    }


    function fn_ArraySorting($arr, $key, $method = 'asc') {
        usort($arr, function($a, $b) use ($key, $method) {
            if ($method === 'desc') {
                return $b[$key] <=> $a[$key]; // 내림차순
            } else {
                return $a[$key] <=> $b[$key]; // 오름차순
            }
        });
        return $arr;
    }


    function fnLoadDecoc($mitype){
        $herb_m = model('Herb_m');

        $r_arr = array();
        $dRs = $herb_m->Load_Decoc_List($mitype);
        if($this->fnArrayCnt($dRs)>0) {

            foreach ($dRs as $d) {
                $t_arr = array();

                $t_arr['mi_cfcode'] = $d['mi_cfcode'];
                $t_arr['mi_code'] = $d['mi_code'];
                $t_arr['mi_name'] = $d['mi_name'];

                array_push($r_arr,$t_arr);
            }
        }

        return $r_arr;

    }

    function fnIsEmpty($value) {
        $bool = false;
        if( $value == "" || $value == '' || $value == null || $value == NULL || empty($value) || $value == "null" || !isset($value)){
            $bool = true;
        }else{
            $bool = false;
        }
        return $bool;
    }

    function fnLoadPrice($hncode){
        $herb_m = model('Herb_m');

        $pricearr = [
            [
                'hn_method' => '',
                'hn_gPrice' => '',
                'hn_pPrice' => '',
                'hn_stock' => '',
                'hn_period' => '',
                'hn_sellmethod' => '',
                'hn_weight' => '',
            ],
            [
                'hn_method' => '',
                'hn_gPrice' => '',
                'hn_pPrice' => '',
                'hn_stock' => '',
                'hn_period' => '',
                'hn_sellmethod' => '',
                'hn_weight' => '',
            ]
        ];


        $pRs = $herb_m->Load_Product_Price($hncode);
        if($this->fnArrayCnt($pRs)>0){
            foreach ($pRs as $p){
                if($p['hn_method']==1){
                    $posion = 0;
                }else if($p['hn_method']==2){
                    $posion = 1;
                }else if($p['hn_method']==3){
                    $posion = 2;
                }
                $pricearr[$posion]['hn_method'] = $p['hn_method'];
                $pricearr[$posion]['hn_gPrice'] = $p['hn_gPrice'];
                $pricearr[$posion]['hn_pPrice'] = $p['hn_pPrice'];
                $pricearr[$posion]['hn_stock'] = $p['hn_stock'];
                $pricearr[$posion]['hn_period'] = $p['hn_period'];
            }
        }

        return $pricearr;

    }


    function fnAddDay($type,$addday,$start_date=''){
        if($start_date==''){
            $currentDateTime = Carbon::now();
        }else{
            if(!$this->fnIsDateFormat($start_date)){
                $currentDateTime = '';
            }else{
                $currentDateTime = Carbon::create($start_date);
            }
        }

        if($currentDateTime==''){
            $rdate = '';
        }else{
            $str_date = $currentDateTime->addDays($addday)->toDateTimeString();
            if($type==1){
                $rdate = $this->fnShort_Date($str_date);
            }else{
                $rdate = $str_date;
            }
        }

        return $rdate;

    }

    function fnIsDateFormat($string){
        if( preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2})\:([0-9]{2})\:([0-9]{2})$/", $string) ){
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }


    function fnConsole_log($data){
        echo "<script>console.log( 'PHP_Console: " . $data . "' );</script>";
    }

    function fnLog_Reg($micode,$typ,$Log){
        $request = service('request');
        $ip = $request->getIPAddress();
        $param = array(
            'micode' => $micode,
            'typ' => $typ,
            'log' => $Log,
            'ip' => $ip
        );
        $log_m = model('Log_m');
        $Cnt = $log_m->Insert_Log($param);
    }

    function fnLog_Board($micode,$Log){
        $request = service('request');
        $ip = $request->getIPAddress();
        $param = array(
            'micode' => $micode,
            'log' => $Log,
            'ip' => $ip
        );
        $log_m = model('Log_m');
        $Cnt = $log_m->Insert_Log($param);
    }


    function fnCheck_Auth($MyAuth){
        $sessinarr = $this->fnGetSessionData();
        if(!$sessinarr['islogin']){
            $this->fnHref('/Member/Login');
        }else{
            $auth = $sessinarr['user']['mi_type'];
            if($auth!=$MyAuth){
                $this->fnAlert('접근 권한이 없는 기능입니다.다시 시도하여주세요','/');
            }
        }
    }

    function fnShort_Date($date)
    {
        $tempStr = str_replace('-','.',$this->fnString_Nomal_Left($date,10));
        return $tempStr;
    }

    function fnString_Nomal_Left($string, $count)
    {
        $Tlen =mb_strlen($string, 'UTF-8');
        if($Tlen > $count) {
            $value = (mb_substr($string, 0, $count, "UTF-8"));
        }else {
            $value =  $string;
        }
        return $value;
    }

    public function fnMake_Code($type){
        $code = '';
        $timeNow = date("Ymd");
        $rnd = mt_rand(100000, 999999);
        if($type==1){
            $code = 'HB'. $timeNow.$rnd;
        }else if($type==2){
            $code = 'DC'. $timeNow.$rnd;
        }else if($type==3){
            $code = 'OD'. $timeNow.$rnd;
        }else if($type==4){
            $code = 'OP'. $timeNow.$rnd;
        }else if($type==5){
            $code = 'DA'. $timeNow.$rnd;
        }else if($type==6){
            $code = 'AP'. $timeNow.$rnd;
        }

        return $code;
    }


    public function Str_File_Sise($size)
    {
        $str = '';
        if(!$size) {
            $str = '0';
        }else if($size < 1024) {
            $str = $size . ' Byte';
        } elseif(($size >= 1024) && ($size < 1024 * 1024)) {
            $str = ($size / 1024) . " KB";
        } elseif($size >= 1024 * 1024 && $size < 1024 * 1024 * 1024) {
            $str = ($size / 1024 / 1024) . "MB";
        } else {
            $str = ($size / 1024 / 1024 / 1024)." GB";
        }
        return $str ;
    }

    public  function fnMake_Fields($fields){

        if($fields[0]=='ALL'){
            $ret_val = '*';
        }else{
             $ret_val = implode(',',$fields);
        }
 
        return $ret_val;
    }


    /**
	 * 로그인 세션 로드
	 */
//    public function fnGetSessionData()
//    {
//        $session = Services::session();
//        $tstr = $session->get('dj_Sstr');
//        if($tstr==''){
//            helper('cookie');
//            $cstr = get_cookie(COOKIE_KEY);
//            if($cstr==''){
//                $data = array(
//                    'user' => '',
//                    'islogin' => false
//                );
//            }else{
//                $auth = New Auth;
//                $info = $auth->Open_Key($cstr);
//                if($this->fnArrayCnt($info)<=0){
//                    $data = array(
//                        'user' => '',
//                        'islogin' => false
//                    );
//                }else{
//                    $user = array(
//                        'uid' => $info['uid'],
//                        'userid' => $info['userid'],
//                        'grade' => $info['grade'],
//                        'name' => $info['name'],
//                        'mi_code' => $info['mi_code'],
//                        'mi_name' => $info['mi_name'],
//                        'mi_type' => $info['mi_type'],
//                        'mi_cf' => $info['mi_cfcode']
//                    );
//
//                    $data = array(
//                        'user' => $user,
//                        'islogin' => true
//                    );
//
//                    $session->set(SESSION_KEY,$cstr);
//                }
//            }
//        }else{
//            $auth = New Auth;
//            $info = $auth->Open_Key($tstr);
//            if($this->fnArrayCnt($info)<=0){
//                $data = array(
//                    'user' => '',
//                    'islogin' => false
//                );
//            }else{
//                $user = array(
//                    'uid' => $info['uid'],
//                    'userid' => $info['userid'],
//                    'grade' => $info['grade'],
//                    'name' => $info['name'],
//                    'mi_code' => $info['mi_code'],
//                    'mi_name' => $info['mi_name'],
//                    'mi_type' => $info['mi_type'],
//                    'mi_cf' => $info['mi_cfcode']
//                );
//
//                $data = array(
//                    'user' => $user,
//                    'islogin' => true
//                );
//            }
//        }
//        return $data;
//    }


    /**
	 * 배열 갯수 체크
	 */
    public function fnArrayCnt($array='')
    {
        if (isset($array)) return count($array);
        return -1;
    }
    
    /**
	 * 모바일 체크
	 */
    public function fnMobileCheck() {
        $ary_m = array("iPhone","iPod","IPad","Android","Blackberry","SymbianOS|SCH-M\d+","Opera Mini","Windows CE","Nokia","Sony","Samsung","LGTelecom","SKT","Mobile","Phone");
        for($i=0; $i<$this->fnArrayCnt($ary_m); $i++){
            if(preg_match("/$ary_m[$i]/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return 1;
                //break;
            }
        }
        return 0;
    }

    /**
	 * 확장자 얻기
	 */
    public function fnGetExtension($filename)
    {

        $file = explode(".", basename($filename));
        $count = count($file);
        if ($count > 1) {
                return strtolower($file[$count-1]);
        } else {
                return '';
        }
    }


    public function ctimestamp()
    {
        defined('TIMESTAMP') or define('TIMESTAMP' , time());
        return TIMESTAMP;
    }
    

    	/**
	 * DATE 함수의 약간 변형
	 */
	public function cdate($date, $timestamp='')
	{
		defined('TIMESTAMP') or define('TIMESTAMP' , time());
		return $timestamp ? date($date, $timestamp) : date($date, TIMESTAMP);
	}


    /**
	 * Date & Time
	 */
	public function fnDisplayDatetime($datetime='', $type='', $custom='')
	{

		if ( ! $datetime) return FALSE;

		if ($type == 'sns') {

			$diff = $this->ctimestamp() - strtotime($datetime);

			$s = 60; //1분 = 60초
			$h = $s * 60; //1시간 = 60분
			$d = $h * 24; //1일 = 24시간
			$y = $d * 10; //1년 = 1일 * 10일

			if ($diff < $s) {
				$result = $diff . '초전';
			} else if ($h > $diff && $diff >= $s) {
				$result = round($diff/$s) . '분전';
			} else if ($d > $diff && $diff >= $h) {
				$result = round($diff/$h) . '시간전';
			} else if ($y > $diff && $diff >= $d) {
				$result = round($diff/$d) . '일전';
			} else {
				if (substr($datetime,0, 10) == $this->cdate('Y-m-d')) {
					$result = str_replace('-', '.', substr($datetime,11,5));
				} else {
					$result = substr($datetime,5,5);
				}
			}
		} else if ($type == 'user' && $custom) {
			return $this->cdate($custom, strtotime($datetime));
		} else if ($type == 'full') {
			if (substr($datetime,0, 10) == $this->cdate('Y-m-d')) {
				$result = substr($datetime,11,5);
			} else if (substr($datetime,0, 4) == $this->cdate('Y')) {
				$result = substr($datetime,5,11);
			} else {
				$result = substr($datetime,0,10);
			}
		} else {
			if (substr($datetime,0, 10) == $this->cdate('Y-m-d')) {
				$result = substr($datetime,11,5);
			} else {
				$result = substr($datetime,5,5);
			}
		}

		return $result;
	}

    /**
	 * Date & Time
	 */
    public function fnCdate($date, $timestamp='')
	{
		defined('TIMESTAMP') or define('TIMESTAMP' , time());
		return $timestamp ? date($date, $timestamp) : date($date, TIMESTAMP);
	}

    /**
	 * TIMESTAMP
	 */
    public function fnCtimeStamp()
	{
		defined('TIMESTAMP') or define('TIMESTAMP' , time());
		return TIMESTAMP;
	}

    /**
	 * 배열 키값 체크
	 */
    public function fnArrayToKeys($array='')
	{
		$result = array();
		if ( ! is_array($array)) return FALSE;
		foreach ($array as $key) {
			$result[$key] = FALSE;
		}
		return $result;
	}

    /**
	 * select option
	 */
    public function fnSearchOption($options='', $selected='')
	{
		if ( ! $options OR ! is_array($options)) return FALSE;

		$result = '';
		foreach ($options as $key => $val) {
			$result .= '<option value="' . $key . '" ';
			if ($selected == $key) {
				$result .=' selected="selected" ';
			}
			$result .=' >' . $val . '</option>';
		}
		return $result;
	}

    /**
	 * 글자자르기
	 */
	public function fnCutStr($str='', $len='', $suffix='…')
	{
		$arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
		$str_len = count($arr_str);

		if ($str_len >= $len) {
			$slice_str = array_slice($arr_str, 0, $len);
			$str = join('', $slice_str);
			return $str . ($str_len > $len ? $suffix : '');
		} else {
			$str = join('', $arr_str);
			return $str;
		}
	}

    /**
	 * 금지어 필터
	 */
    public function fnExcept_FilterWord($word)
    {
        $filter = explode(",", trim(FILTER_WORD));
        $eword = '';
        foreach($filter as $val)
        {
            //금지어 필터링 (찾으면 경고메시지)
            if (stripos($word, $val) !== false) {
                $eword = $val;
                break;
            }
        }

        return $eword;
    }


    /**
	 * ALERT MESSAGE 가 있을 경우 DIV 로 감싸서 보여주기
	 */
	public function fnShowAlertMessage($message = '', $html1='', $html2='')
	{
		if ( ! $message) return FALSE;

		$result  = $html1;
		$result .= $message;
		$result .= $html2;
		return $result;
	}

    /**
	 * ip 를 정한 형식에 따라 보여주기
	 */
	public function fnDisplayIpaddress($ip='', $type='0001')
	{
		$len = strlen($type);
		if ($len != 4) return FALSE;

		if ( ! $ip) return FALSE;

		$regex = '';
		$regex .= ($type[0] == '1') ? '\\1' : '&#9825;';
		$regex .= '.';
		$regex .= ($type[1] == '1') ? '\\2' : '&#9825;';
		$regex .= '.';
		$regex .= ($type[2] == '1') ? '\\3' : '&#9825;';
		$regex .= '.';
		$regex .= ($type[3] == '1') ? '\\4' : '&#9825;';
		return preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", $regex, $ip);
	}

     /**
	 * number 출력 모양
	 */
    public function fnNumberFormatShort($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }

    /**
	 * 퍼센트 출력
	 */
    public function fnPercent($range, $total, $slice)
    {
        if ($total == 0) $total = 1;
        $result = 0;
        if ($range == "totalPer" || $range == "total") {
            //n = 전체값 * 퍼센트 / 100;
            $result = ($total * $slice) / 100;
            return round($result);
        } else {
            //n% = 일부값 / 전체값 * 100;
            $result = ($slice / $total) * 100;
            return number_format($result, 2, '.', '');
        }
    }

    /**
	 * 나이계산 format:xxxx-xx-xx
	 */
    public function fnMakeAge($birth)
    {
        
        $birth_year = substr($birth, 0, 4);
        $birth_month = substr($birth, 4, 2);
        $brith_day = substr($birth, 6, 2);

        $birth_year = (int)$birth_year;
        $birth_month = (int)$birth_month;
        $brith_day = (int)$brith_day;
        $now_year = date("Y");
        $now_month = date("m");
        $now_day = date("d");
        if ($birth_month < $now_month) {
            $age = $now_year - $birth_year;
        } else if ($birth_month == $now_month) {
            if ($brith_day <= $now_day)
                $age = $now_year - $birth_year;
            else
                $age = $now_year - $birth_year - 1;
        } else {
            $age = $now_year - $birth_year - 1;
        }

        return $age;
    }

    /**
	 * ajax api 콜
	 */
    public function fnApiCall($bodyData)
    {
        $client = Services::curlrequest();
        $apiUrl = getenv('api.baseURI');
        
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Accept'   => 'application/json',
                'cache-control' => 'no-cache',
                'Content-Type' => 'application/json;charset='.getenv('data.charSet'),
                'authKey'  => getenv('data.secuKey'),
            ],
            'body' => json_encode($bodyData),
            'timeout' => 5
        ]);
        
        return  json_decode($response->getBody(), true);
    }
    
    /**
	 * ajax api 콜
	 */
    public function fnApiRunFolder($bodyData, $folderNm)
    {
        $client = Services::curlrequest();
        $apiUrl = getenv('api.baseURI');
               
        //echo $apiUrl."".$folderNm."/";
        
        $response = $client->request('POST', $apiUrl."".$folderNm."/", [
            'headers' => [
                'Accept'   => 'application/json',
                'cache-control' => 'no-cache',
                'Content-Type' => 'application/json;charset='.getenv('data.charSet'),
                'authKey'  => getenv('data.secuKey'),
            ],
            'body' => json_encode($bodyData),
            'timeout' => 5
        ]);
        /*
        echo "<br/>=====<br/>";
        echo $bodyData;
        echo "<br/>=====<br/>";
        */ 
     //   echo $response->getBody();
               
        return  json_decode($response->getBody(), true);
    }

    public function is_phone($phone)
    {
        $phone = str_replace('-', '', trim($phone));
        if (preg_match("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $phone))
            return true;
        else
            return false;
    }


    /*
      *핸드폰 번호 String
    */
    public function fnGetPhone($phone, $hyphen=1)
    {
        if ( !$this->is_phone($phone)) return '';

        if ($hyphen) $preg = "$1-$2-$3"; else $preg = "$1$2$3";

        $phone = str_replace('-', '', trim($phone));
        $phone = preg_replace("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $preg, $phone);

        return $phone;
    }

    /*
      *핸드폰 번호 Check
    */
    public function fnPhoneChk($phone)
    {
        $phone = str_replace('-', '', trim($phone));
        if (preg_match("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $phone))
            return true;
        else
            return false;
    }
    
    /*
      * alert 띠우기
    */
    public function fnAlert($msg = '', $url = '')
	{
		if ( ! $msg) {
			$msg = '잘못된 접근입니다';
		}
		echo '<meta http-equiv="content-type" content="text/html; charset=' . getenv('data.charSet') . '">';
		echo '<script type="text/javascript">alert("' . $msg . '");';
		if ( ! $url) echo 'history.go(-1);';
		if ($url) echo 'document.location.href="' . $url . '"';
		echo '</script>';
		exit;
	}

    public function fnHref($url = '')
    {
        echo '<meta http-equiv="content-type" content="text/html; charset=' . getenv('data.charSet') . '">';
        echo '<script type="text/javascript">';
        if ( ! $url) echo 'history.go(-1);';
        if ($url) echo 'document.location.href="' . $url . '"';
        echo '</script>';
        exit;
    }
    
    /*
      * alert 후 Close
    */
    public function fnAlertClose($msg = '')
	{
		if ( ! $msg) {
			$msg = '잘못된 접근입니다';
		}
		echo '<meta http-equiv="content-type" content="text/html; charset=' . getenv('data.charSet') . '">';
		echo '<script type="text/javascript"> alert("' . $msg . '"); window.close(); </script>';
		exit;
	}

}

?>