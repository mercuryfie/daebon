<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | In development, we want to show as many errors as possible to help
 | make sure they don't make it to production. And save us hours of
 | painful debugging.
 |
 | If you set 'display_errors' to '1', CI4's detailed error report will show.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
 |--------------------------------------------------------------------------
 | DEBUG BACKTRACES
 |--------------------------------------------------------------------------
 | If true, this constant will tell the error screens to display debug
 | backtraces along with the other error information. If you would
 | prefer to not see this, set this value to false.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow changes throughout
 | the system. This will control whether Kint is loaded, and a few other
 | items. It can always be used within your own application too.
 */
defined('CI_DEBUG') || define('CI_DEBUG', true);


defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');
defined('CK_DOMAIN') || define('CK_DOMAIN', '.daebon.com');
defined('CK_DBIP')   || define('CK_DBIP', '211.251.239.37');
defined('CK_DBNAME')   || define('CK_DBNAME', 'daebondev');
defined('CK_DBUSER')   || define('CK_DBUSER', 'daebon');
defined('CK_DBPWD')   || define('CK_DBPWD', 'djMedi!!999');
define("H_TITLE","DAEBON MES TEST");