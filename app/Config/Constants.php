<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

define("URL_COMMON_ASSETS","/assets/web/js/common");
define("URL_DASHBOARD_ASSETS","/assets/web/js/dashboard");

$HTTPHOST = 'http://localhost:' . (PHP_SAPI === 'cli' ? '8080' : $_SERVER['SERVER_PORT']);
if (! empty($_SERVER['HTTP_HOST'])) {
    $HTTPHOST = $_SERVER['HTTP_HOST'];
}
$BASEURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . $HTTPHOST;
defined('BASE_URL') || define('BASE_URL', $BASEURL);

defined("GMARKET_KEY") || define('GMARKET_KEY', "G_daeguyg");

defined("ESM_MASTER") || define('ESM_MASTER', "kij4490");
defined("ESM_SELLER") || define('ESM_SELLER', "daeguyg");



define('SESSION_KEY','DB_Sstr');
define('COOKIE_KEY','DB_Cstr');
define('FILTER_WORD','관리자,운영자,[,],10새,10새기,10새리,10세리,10쉐이,10쉑,10스,10쌔,10쌔기,10쎄,10알,10창,10탱,18것,18넘,18년,18노,18놈,18뇬,18럼,18롬,18새,18새끼,18색,18세끼,18세리,18섹,18쉑,18스,18아,c파,c팔,fuck,ㄱㅐ,ㄲㅏ,ㄲㅑ,ㄲㅣ,ㅅㅂㄹㅁ,ㅅㅐ,ㅆㅂㄹㅁ,ㅆㅍ,ㅆㅣ,ㅆ앙,ㅍㅏ,凸,갈보,갈보년,강아지,같은년,같은뇬,개같은,개구라,개년,개놈,개뇬,개대중,개독,개돼중,개랄,개보지,개뻥,개뿔,개새,개새기,개새끼,개새키,개색기,개색끼,개색키,개색히,개섀끼,개세,개세끼,개세이,개소리,개쑈,개쇳기,개수작,개쉐,개쉐리,개쉐이,개쉑,개쉽,개스끼,개시키,개십새기,개십새끼,개쐑,개씹,개아들,개자슥,개자지,개접,개좆,개좌식,개허접,걔새,걔수작,걔시끼,걔시키,걔썌,걸레,게색기,게색끼,광뇬,구녕,구라,구멍,그년,그새끼,냄비,놈현,뇬,눈깔,뉘미럴,니귀미,니기미,니미,니미랄,니미럴,니미씹,니아배,니아베,니아비,니어매,니어메,니어미,닝기리,닝기미,대가리,뎡신,도라이,돈놈,돌아이,돌은놈,되질래,뒈져,뒈져라,뒈진,뒈진다,뒈질,뒤질래,등신,디져라,디진다,디질래,딩시,따식,때놈,또라이,똘아이,똘아이,뙈놈,뙤놈,뙨넘,뙨놈,뚜쟁,띠바,띠발,띠불,띠팔,메친넘,메친놈,미췬,미췬,미친,미친넘,미친년,미친놈,미친새끼,미친스까이,미틴,미틴넘,미틴년,미틴놈,바랄년,병자,뱅마,뱅신,벼엉신,병쉰,병신,부랄,부럴,불알,불할,붕가,붙어먹,뷰웅,븅,븅신,빌어먹,빙시,빙신,빠가,빠구리,빠굴,빠큐,뻐큐,뻑큐,뽁큐,상넘이,상놈을,상놈의,상놈이,새갸,새꺄,새끼,새새끼,새키,색끼,생쑈,세갸,세꺄,세끼,섹스,쇼하네,쉐,쉐기,쉐끼,쉐리,쉐에기,쉐키,쉑,쉣,쉨,쉬발,쉬밸,쉬벌,쉬뻘,쉬펄,쉽알,스패킹,스팽,시궁창,시끼,시댕,시뎅,시랄,시발,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,신발끈,심발끈,심탱,십8,십라,십새,십새끼,십세,십쉐,십쉐이,십스키,십쌔,십창,십탱,싶알,싸가지,싹아지,쌉년,쌍넘,쌍년,쌍놈,쌍뇬,쌔끼,쌕,쌩쑈,쌴년,썅,썅년,썅놈,썡쇼,써벌,썩을년,썩을놈,쎄꺄,쎄엑,쒸벌,쒸뻘,쒸팔,쒸펄,쓰바,쓰박,쓰발,쓰벌,쓰팔,씁새,씁얼,씌파,씨8,씨끼,씨댕,씨뎅,씨바,씨바랄,씨박,씨발,씨방,씨방새,씨방세,씨밸,씨뱅,씨벌,씨벨,씨봉,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨붕,씨브랄,씨빠,씨빨,씨뽀랄,씨앙,씨파,씨팍,씨팔,씨펄,씸년,씸뇬,씸새끼,씹같,씹년,씹뇬,씹보지,씹새,씹새기,씹새끼,씹새리,씹세,씹쉐,씹스키,씹쌔,씹이,씹자지,씹질,씹창,씹탱,씹퇭,씹팔,씹할,씹헐,아가리,아갈,아갈이,아갈통,아구창,아구통,아굴,얌마,양넘,양년,양놈,엄창,엠병,여물통,염병,엿같,옘병,옘빙,오입,왜년,왜놈,욤병,육갑,은년,을년,이년,이새끼,이새키,이스끼,이스키,임마,자슥,잡것,잡넘,잡년,잡놈,저년,저새끼,접년,젖밥,조까,조까치,조낸,조또,조랭,조빠,조쟁이,조지냐,조진다,조찐,조질래,존나,존나게,존니,존만,존만한,좀물,좁년,좁밥,좃까,좃또,좃만,좃밥,좃이,좃찐,좆같,좆까,좆나,좆또,좆만,좆밥,좆이,좆찐,좇같,좇이,좌식,주글,주글래,주데이,주뎅,주뎅이,주둥아리,주둥이,주접,주접떨,죽고잡,죽을래,죽통,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,짜식,짜아식,쪼다,쫍빱,찌랄,창녀,캐년,캐놈,캐스끼,캐스키,캐시키,탱구,팔럼,퍽큐,호로,호로놈,호로새끼,호로색,호로쉑,호로스까이,호로스키,후라들,후래자식,후레,후뢰,노벨리,스타프로젝트,스파이뮤즈,보석소녀엘레쥬,뿌띠빠띠,부티나살롱,쫑이네애견샵,때부자,온천왕,분식왕,비비빅,공식');


define('SECURITY_KEY','WMY784FY8ZPS8RRPZ82MHQ3K68NIEGP1');
define("ENVIRONMENT","development");
//define("ENVIRONMENT","production");


define("CK_IDSAVE","daebon_idsave");
define("CK_LOGINKEEP","daebon_loginkeep");

//define("CK_DOMAIN",".djmedi.net"); // live 적용
//define("CK_DBIP","172.27.0.21"); // live 적용
define("CK_DOMAIN",".daebon.com");
define("CK_DBIP","211.251.239.37");





define("ASSETS_URL","/assets/web");
define("H_TITLE","DAEBON ESM");


define("AUTH_MASTER",1101);
define("AUTH_PACKING",1102);
define("AUTH_PRODUCT",1103);


define("PROCESS_STEP1",'대기');
define("PROCESS_STEP2",'진행중');
define("PROCESS_STEP3",'완료');





















