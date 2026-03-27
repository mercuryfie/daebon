<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 |
 | If you set 'display_errors' to '1', CI4's detailed error report will show.
 */
error_reporting(E_ALL & ~E_DEPRECATED);
// If you want to suppress more types of errors.
// error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow changes throughout
 | the system. It's not widely used currently, and may not survive
 | release of the framework.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);



defined('ENVIRONMENT') || define('ENVIRONMENT', 'production');
defined('CK_DOMAIN') || define('CK_DOMAIN', '.djmedi.net');
defined('CK_DBIP')   || define('CK_DBIP', '172.27.0.21');
defined('CK_DBNAME')   || define('CK_DBNAME', 'daebon');
defined('CK_DBUSER')   || define('CK_DBUSER', 'daebon');
defined('CK_DBPWD')   || define('CK_DBPWD', 'djMedi!!999');
define("H_TITLE","DAEBON MES");