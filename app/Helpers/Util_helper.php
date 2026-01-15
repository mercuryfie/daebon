<?php

use Carbon\Carbon;
use CodeIgniter\I18n\Time;
use Config\Services;
use App\Libraries\Auth;



function fn_InsertSystemLog($uid,$LogTyp,$Log){
    $param = [
        'uid' => $uid,
        'ip' => fn_getClientIp(),
        'LogTyp' => $LogTyp,
        'Log' => $Log
    ];

    $common_m=model('Common_m');
    $Cnt = $common_m->Insert_Log($param);

    return true;
}

/** date format
 * 1 : 2022-01-01 11:11:11 한국시간
 * 2 : 2022-01-01 한국시간
 */

function fn_NowDateFormat($typ){
    date_default_timezone_set('Asia/Seoul');
    if($typ==1) {
        return date('Y-m-d H:i:s');
    }else if($typ==2) {
        return date('Y-m-d');
    }
}


/** 송장번호 반환
 * 317957255781  -> 3179-5725-5781
 * 3179-5725-5781 -> 그대로 반환
 */

function fn_formatInvoiceNumber($invoice)
{
    $numbers = preg_replace('/[^0-9]/', '', $invoice);

    if (strlen($numbers) === 12) {
        return substr($numbers, 0, 4) . '-' .
            substr($numbers, 4, 4) . '-' .
            substr($numbers, 8, 4);
    }
    return $invoice;
}


/**
 * 01011112222  -> 010-3443-6063
 * 010-1111-2222 -> 그대로 반환
 */
function fn_formatmobile($phone)
{
    $digits = preg_replace('/\D+/', '', $phone);
    if (preg_match('/^010\d{8}$/', $digits)) {
        if (preg_match('/^010-\d{4}-\d{4}$/', $phone)) {
            return $phone;
        }
        return preg_replace('/^(010)(\d{4})(\d{4})$/', '$1-$2-$3', $digits); // [web:10]
    }
    return $phone;
}



function fn_toIso8601Kst(string $dateStr): string
{
    // '2025-12-30 143944' → '2025-12-30 14:39:44' 변환
    $normalized = preg_replace('/(\d{2})(\d{2})(\d{2})$/', '$1:$2:$3', $dateStr);

    $date = new DateTimeImmutable($normalized, new DateTimeZone('Asia/Seoul'));
    return $date->format('Y-m-d\TH:i:s.vP');
}


/** 자리수에 맞춰서 0넣기 */
function fn_padNumber($num, $targetLength) {
    return str_pad($num, $targetLength, '0', STR_PAD_LEFT);
}

/**배열에 내가 원하는값이 있는지 체크**/
function fn_IsValueInArray($needle, $haystack, $key = null) {
    if ($key !== null) {
        foreach ($haystack as $item) {
            if (is_array($item) && isset($item[$key]) && $item[$key] === $needle) {
                return true;
            }
        }
        return false;
    } else {
        return in_array($needle, $haystack, true);
    }
}


/** URL 가지고 오기 */
function fn_Get_URL($typ){
    if($typ==1){
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }else if($typ==2){
        $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = basename($url_path);
    }else{
        $path = '';
    }
    return $path;
}


function Check_Token($sessinarr):bool
{
    if($sessinarr['islogin']==false){
        $retval = false;
    }else {
        $headers = apache_request_headers();
        $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

        if ($token) {
            $token = str_replace('Bearer ', '', $token);
            $auth = new Auth();
            $key = $auth->Open_Key($token);
            $uid = $sessinarr['user']['uid'];
            $member_m = model('Member_m');
            $mRs = $member_m->Load_UserInfo_Uid($uid);
            if (fn_ArrayCnt($mRs) <= 0) {
                $retval = false;
            } else if ($key == $mRs[0]['token']) {
                $retval = true;
            } else {
                $retval = false;
            }
        } else {
            $retval = false;
        }
    }
    return $retval;
}



/** API Call ***/
function fn_CURL($URL,$apikey, $method, $header = [], $bodyData = [])
{
    $client = Services::curlrequest();

    $defaultHeaders = [
        'Accept'        => 'application/json',
        'cache-control' => 'no-cache',
        'ckAuthKey'     => $apikey
    ];

    if (strtoupper($method) !== 'GET') {
        $defaultHeaders['Content-Type'] = 'application/x-www-form-urlencoded';
        $bodyData = http_build_query($bodyData);
    }

    $options = [
        'headers' => array_merge($defaultHeaders, $header),
        'timeout' => 30
    ];

    if (strtoupper($method) === 'GET' && !empty($bodyData)) {
        $options['query'] = $bodyData;
    } elseif (!empty($bodyData)) {
        $options['body'] = $bodyData;
    }

    $response = $client->request($method, $URL, $options);

    return json_decode($response->getBody(), true);
}

/** 백분율 출력 */
function fn_calculatePercentage($number, $total) {
    if ($total == 0) {
        return 0; // 0으로 나누기 방지
    }
    return floor(($number / $total) * 100);
}

/** $date1과 $date2 의 일수차이가 $days랑 같은지 체크 */
function fn_isDaysDiff(string $date1, string $date2, int $days)
{
    $time1 = Time::parse($date1);
    $time2 = Time::parse($date2);

    $diff = $time1->difference($time2);
    $daysDiff = abs($diff->getDays());

    return $daysDiff === $days;
}

/** $date 날짜가 현재날짜에서 $days 만큼 차이가 나는지 체크 */
function fn_toDaysDiffUp(string $date, int $days)
{
    $today = Time::now();
    $inputDate = Time::parse($date);

    $diff = $today->difference($inputDate);
    $daysDiff = abs($diff->getDays());

    if($daysDiff>=$days){
        $bool = true;
    }else{
        $bool = false;
    }

    return $bool;
}

/** 배열 sorting  */
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

/** 배열 sorting */
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

/** 날짜 더하기 type=1이면 ****.**.**  / 2면 풀  */
function fn_AddDay($type,$addday,$start_date=''){
    if($start_date==''){
        $currentDateTime = Carbon::now();
    }else{
        if(!fn_IsDateFormat($start_date)){
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
            $rdate = fn_Short_Date($str_date);
        }else{
            $rdate = $str_date;
        }
    }

    return $rdate;

}

/** YYYY-MM-DD HH:MM:SS 형태 체크 */
function fn_IsDateFormat($string){
    if( preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2})\:([0-9]{2})\:([0-9]{2})$/", $string) ){
        $bool = true;
    } else {
        $bool = false;
    }
    return $bool;
}

/** javascript 콘솔로그 php에서 출력  */
function fn_Console_log($data){
    echo "<script>console.log(" . json_encode($data) . ");</script>";
}

/** 날짜 ****.**.** 출력 */
function fn_Short_Date($date)
{
    $tempStr = str_replace('-','.',fn_String_Nomal_Left($date,10));
    return $tempStr;
}

/** 파일 용량 출력 */
function fn_Str_File_Sise($size)
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

/** DB select field 정리 */
function fn_Make_Fields($fields){

    if($fields[0]=='ALL'){
        $ret_val = '*';
    }else{
        $ret_val = implode(',',$fields);
    }

    return $ret_val;
}

/** 문자열 left 자르기 */
function fn_String_Nomal_Left($string, $count)
{
    $Tlen =mb_strlen($string, 'UTF-8');
    if($Tlen > $count) {
        $value = (mb_substr($string, 0, $count, "UTF-8"));
    }else {
        $value =  $string;
    }
    return $value;
}

/*** 배열 갯수 체크 ***/
function fn_ArrayCnt($array = null)
{
    if (is_array($array) || $array instanceof Countable) {
        return count($array);
    }
    return 0;  // 배열 아니면 0 반환
}

/*** 모바일 체크 ***/
function fn_MobileCheck() {
    $ary_m = ["iPhone","iPod","IPad","Android","Blackberry","SymbianOS|SCH-M\d+","Opera Mini","Windows CE","Nokia","Sony","Samsung","LGTelecom","SKT","Mobile","Phone"];
    for($i=0; $i< fn_ArrayCnt($ary_m); $i++){
        if(preg_match("/$ary_m[$i]/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return 1;
            //break;
        }
    }
    return 0;
}

/*** 확장자 얻기 ***/
function fn_GetExtension($filename)
{

    $file = explode(".", basename($filename));
    $count = count($file);
    if ($count > 1) {
        return strtolower($file[$count-1]);
    } else {
        return '';
    }
}

function fn_ctimestamp()
{
    defined('TIMESTAMP') or define('TIMESTAMP' , time());
    return TIMESTAMP;
}

/*** DATE 함수의 약간 변형 ***/
function fn_cdate($date, $timestamp='')
{
    defined('TIMESTAMP') or define('TIMESTAMP' , time());
    return $timestamp ? date($date, $timestamp) : date($date, TIMESTAMP);
}


/*** Date & Time*/
function fn_DisplayDatetime($datetime='', $type='', $custom='')
{

    if ( ! $datetime) return FALSE;

    if ($type == 'sns') {

        $diff = fn_ctimestamp() - strtotime($datetime);

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
            if (substr($datetime,0, 10) == fn_cdate('Y-m-d')) {
                $result = str_replace('-', '.', substr($datetime,11,5));
            } else {
                $result = substr($datetime,5,5);
            }
        }
    } else if ($type == 'user' && $custom) {
        return fn_cdate($custom, strtotime($datetime));
    } else if ($type == 'full') {
        if (substr($datetime,0, 10) == fn_cdate('Y-m-d')) {
            $result = substr($datetime,11,5);
        } else if (substr($datetime,0, 4) == fn_cdate('Y')) {
            $result = substr($datetime,5,11);
        } else {
            $result = substr($datetime,0,10);
        }
    } else {
        if (substr($datetime,0, 10) == fn_cdate('Y-m-d')) {
            $result = substr($datetime,11,5);
        } else {
            $result = substr($datetime,5,5);
        }
    }

    return $result;
}


/*** 배열 키값 체크 ***/
function fn_ArrayToKeys($array='')
{
    $result = [];
    if ( ! is_array($array)) return FALSE;
    foreach ($array as $key) {
        $result[$key] = FALSE;
    }
    return $result;
}


/*** select option ***/
function fn_SearchOption($options='', $selected='')
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


/*** 글자자르기 ***/
function fn_CutStr($str='', $len='', $suffix='…')
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

/*** 금지어 필터 ***/
function fn_Except_FilterWord($word)
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

/*** ip 를 정한 형식에 따라 보여주기 ***/
function fn_DisplayIpaddress($ip='', $type='0001')
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


/*** number 출력 모양 ***/
function fn_NumberFormatShort($n, $precision = 1)
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


/*** 퍼센트 출력 ***/
function fn_Percent($range, $total, $slice)
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

/*** 나이계산 format:xxxx-xx-xx ***/
function fn_MakeAge($birth)
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

/*** 핸드폰 체크 ***/
function fn_isphone($phone)
{
    $phone = str_replace('-', '', trim($phone));
    if (preg_match("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $phone))
        return true;
    else
        return false;
}


/*** 핸드폰 번호 String ***/
function fn_GetPhone($phone, $hyphen=1)
{
    if ( !fn_isphone($phone)) return '';

    if ($hyphen) $preg = "$1-$2-$3"; else $preg = "$1$2$3";

    $phone = str_replace('-', '', trim($phone));
    $phone = preg_replace("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $preg, $phone);

    return $phone;
}

/*** 핸드폰 번호 Check ***/
function fn_PhoneChk($phone)
{
    $phone = str_replace('-', '', trim($phone));
    if (preg_match("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $phone))
        return true;
    else
        return false;
}

/*** alert 띠우기 ***/
function fn_Alert($msg = '', $url = '')
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

/** alert 없이 페이지 이동 */
function fn_Href($url = '')
{
    echo '<meta http-equiv="content-type" content="text/html; charset=' . getenv('data.charSet') . '">';
    echo '<script type="text/javascript">';
    if ( ! $url) echo 'history.go(-1);';
    if ($url) echo 'document.location.href="' . $url . '"';
    echo '</script>';
    exit;
}

/** alert 후 Close*/
function fn_AlertClose($msg = '')
{
    if ( ! $msg) {
        $msg = '잘못된 접근입니다';
    }
    echo '<meta http-equiv="content-type" content="text/html; charset=' . getenv('data.charSet') . '">';
    echo '<script type="text/javascript"> alert("' . $msg . '"); window.close(); </script>';
    exit;
}

function fn_MakeToast($msg = '')
{
    if (!$msg) {
        $msg = '잘못된 접근입니다.';
    }
    echo '<script>
        const toast = document.querySelector(".toastBox, #toast, [class*="toast"]");
        if(toast) toast.remove();
        
        const div = document.createElement("div");
        div.className = "toastBox";
        div.textContent = "'.$msg.'";
        div.style.cssText = `
            animation: toastSlideIn 0.3s ease-out;
            white-space: pre-line;
            word-wrap: break-word;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        `;
        document.body.appendChild(div);
        
        setTimeout(() => {
            div.style.animation = "toastSlideOut 0.3s ease-in forwards";
            setTimeout(() => div.remove(), 300);
        }, 3000);
    </script>';
    exit;
}


/**
 * 사설 IP 제외한 공개 IP만 유효
 */
function validate_ip($ip): bool
{
    if (strtolower($ip) === 'unknown') return false;

    $ip = ip2long($ip);
    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

/**
 * 접속자 ip
 */
function fn_getClientIp(): string
{
    // CI4 환경 우선 (프록시 자동 처리)
    if (function_exists('service')) {
        $request = service('request');
        $ip = $request->getIPAddress();
        if ($request->isValidIP($ip) && validate_ip($ip)) {
            return $ip;
        }
    }

    // 순수 PHP (원본 로직 + trim 개선)
    $ip_keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key] ?? '')) {
            $forwarded_ips = explode(',', $_SERVER[$key]);
            foreach (array_map('trim', $forwarded_ips) as $ip) {
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}


