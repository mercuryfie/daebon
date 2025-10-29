<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->GET('/', 'MainController::main');


/* Login */
$routes->GET('member/login','MemberController::logIn');
$routes->GET('member/logout','MemberController::logOut');



$routes->GET('order/adddeliform', 'OrderController::addDeliForm');

$routes->GET('order/waybill', 'OrderController::waybillForm');
$routes->GET('order/dashboard', 'OrderController::dashBoard');
$routes->GET('order/mainthum', 'CommonController::mainThum');
$routes->GET('order/linkmalls', 'OrderController::linkMalls');
$routes->GET('order/orderlist', 'OrderController::orderList');
$routes->GET('order/deliverylist', 'OrderController::deliveryList');
$routes->GET('order/packinglist', 'OrderController::packingList');
$routes->GET('order/packingstatus', 'OrderController::packingStatus');

$routes->GET('goods/productsmaster', 'GoodsController::productsMaster');
$routes->GET('goods/goodsetc', 'GoodsController::goodsEtc');
$routes->GET('goods/goodslist', 'GoodsController::goodsList');
$routes->GET('goods/goodsreg', 'GoodsController::goodsReg');
$routes->GET('goods/productslist', 'GoodsController::productsList');
$routes->GET('goods/productsreg', 'GoodsController::productsReg');
$routes->GET('goods/productsreg2', 'GoodsController::productsReg2');
$routes->GET('goods/productseditor', 'GoodsController::productsEditor');
$routes->GET('goods/manuregister', 'GoodsController::manuRegister');
$routes->GET('goods/manueditor', 'GoodsController::manuEditor');
$routes->GET('goods/categorylist', 'GoodsController::categoryList');

$routes->GET('produce/productionstatus', 'ProduceController::productionStatus');
$routes->GET('produce/productionlist', 'ProduceController::productionList');
$routes->GET('produce/productionliststaff', 'ProduceController::productionListStaff');
$routes->GET('produce/productiondetail', 'ProduceController::productionDetail');
$routes->GET('produce/productiondetailmono', 'ProduceController::productionDetailMono');
//$routes->GET('produce/productioncomplete', 'ProduceController::productionComplete');
//$routes->GET('produce/productioncomplete2', 'ProduceController::productionComplete2');
$routes->GET('produce/instructionform', 'ProduceController::instructionForm');

$routes->GET('inout/inoutstatus', 'InoutController::inoutStatus');
$routes->GET('inout/materiallist', 'InoutController::materialList');
$routes->GET('inout/materialreg', 'InoutController::materialReg');
$routes->GET('inout/popbarcodewindow', 'InoutController::popBarcodeWindow');
$routes->GET('inout/popaddmatirial', 'InoutController::pop_AddMatirial');

$routes->GET('report/quality', 'ReportController::qualityReport');
$routes->GET('report/order', 'ReportController::orderReport');

$routes->GET('monitor/workstatus', 'MonitorController::workStatus');
$routes->GET('monitor/processstatus', 'MonitorController::processStatus');

$routes->GET('info/user', 'CommonController::userInfo');
$routes->GET('info/notice', 'CommonController::notice');

/* Packing */
$routes->GET('packing/', 'PackingController::main');
$routes->GET('packing/status', 'PackingController::packingStatus');
$routes->GET('packing/waybillform', 'PackingController::waybillForm');


/* Product */
$routes->GET('product/', 'ProductController::main');
$routes->GET('product/status', 'ProductController::productionStatus');
$routes->GET('product/statusDetail', 'ProductController::statusDetail');
$routes->GET('product/statusDetailMono', 'ProductController::statusDetailMono');


/*API*/
$routes->match(['GET', 'POST'], 'Api/Call_Cancels', 'ApiController::Call_Cancels');
$routes->match(['GET', 'POST'], 'Api/login_do', 'ApiController::Login_Do');
$routes->match(['GET', 'POST'], 'Api/Load_MaterialList', 'ApiController::Load_MaterialList');
$routes->match(['GET', 'POST'], 'Api/Load_Material_Info', 'ApiController::Load_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Add_Material_Info', 'ApiController::Add_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Mod_Material_Info', 'ApiController::Mod_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Del_Material_Info', 'ApiController::Del_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Load_Goods_List', 'ApiController::Load_Goods_List');
$routes->match(['GET', 'POST'], 'Api/Add_Goods_Info', 'ApiController::Add_Goods_Info');
$routes->match(['GET', 'POST'], 'Api/Add_Goods_Instructions', 'ApiController::Add_Goods_Instructions');
$routes->match(['GET', 'POST'], 'Api/Load_Produce_List', 'ApiController::Load_Produce_List');