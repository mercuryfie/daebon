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
$routes->GET('goods/productsRegister', 'CommonController::productsRegister');
$routes->GET('goods/productsAfterRegister', 'CommonController::productsAfterRegister');

$routes->GET('produce/producingStatus', 'CommonController::producingStatus');
$routes->GET('produce/producingControl', 'CommonController::producingControl');
$routes->GET('produce/producingDetail', 'CommonController::producingDetail');

$routes->GET('inOut/inOutStatus', 'CommonController::inOutStatus');
$routes->GET('inOut/atomList', 'CommonController::atomList');
$routes->GET('inOut/atomRegister', 'CommonController::atomRegister');

/*API*/
$routes->match(['GET', 'POST'], 'Api/Make_Token', 'ApiController::Make_Token');