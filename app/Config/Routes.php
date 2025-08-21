<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->GET('/', 'MainController::Main');

/* Login */
$routes->GET('Member/Login','MemberController::Login');
$routes->POST('Member/Login_Do', 'MemberController::Login_Do');
$routes->GET('Member/Logout','MemberController::LogOut');

$routes->GET('Product/mainThum', 'CommonController::mainThum');

/* work - Sample */
$routes->GET('Order/DashBoard', 'CommonController::DashBoard');
$routes->GET('Order/LinkMalls', 'CommonController::linkMalls');
$routes->GET('Order/OrderInfo', 'CommonController::orderInfo');
$routes->GET('Order/DeliInfo', 'CommonController::deliInfo');
$routes->GET('Order/PackingInfo', 'CommonController::packingInfo');
$routes->GET('Order/PackingStatus', 'CommonController::PackingStatus');

$routes->GET('Goods/GoodsList', 'CommonController::GoodsList');
$routes->GET('Goods/GoodsRegister', 'CommonController::GoodsRegister');


/*API*/
$routes->match(['GET', 'POST'], 'Api/Make_Token', 'ApiController::Make_Token');