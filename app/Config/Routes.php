<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->GET('/', 'MainController::main');

/* Login */
$routes->GET('member/login','MemberController::login');
$routes->POST('member/login_Do', 'MemberController::login_Do');
$routes->GET('member/logOut','MemberController::logOut');

/* work - Sample */
$routes->GET('order/dashBoard', 'CommonController::dashBoard');
$routes->GET('order/mainThum', 'CommonController::mainThum');

$routes->GET('order/linkMalls', 'CommonController::linkMalls');
$routes->GET('order/orderInfo', 'CommonController::orderInfo');
$routes->GET('order/deliInfo', 'CommonController::deliInfo');
$routes->GET('order/packingInfo', 'CommonController::packingInfo');
$routes->GET('order/packingStatus', 'CommonController::packingStatus');

$routes->GET('goods/goodsList', 'CommonController::goodsList');
$routes->GET('goods/goodsRegister', 'CommonController::goodsRegister');
$routes->GET('goods/productsList', 'CommonController::productsList');
$routes->GET('goods/matiRegister', 'CommonController::matiRegister');
$routes->GET('goods/manuRegister', 'CommonController::manuRegister');
$routes->GET('goods/matiEditor', 'CommonController::matiEditor');
$routes->GET('goods/manuEditor', 'CommonController::manuEditor');

$routes->GET('produce/sangStatus', 'CommonController::sangStatus');
$routes->GET('produce/sangList', 'CommonController::sangList');
$routes->GET('produce/sangDetail', 'CommonController::sangDetail');
$routes->GET('produce/sangDetail2', 'CommonController::sangDetail2');
$routes->GET('produce/sangComplete', 'CommonController::sangComplete');
$routes->GET('produce/sangComplete2', 'CommonController::sangComplete2');

$routes->GET('inOut/inOutStatus', 'CommonController::inOutStatus');
$routes->GET('inOut/atomList', 'CommonController::atomList');
$routes->GET('inOut/atomRegister', 'CommonController::atomRegister');

/*API*/
$routes->match(['GET', 'POST'], 'Api/Make_Token', 'ApiController::Make_Token');