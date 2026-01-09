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
$routes->GET('order/main', 'OrderController::main');
$routes->GET('order/mainthum', 'CommonController::mainThum');
$routes->GET('order/linkmalls', 'OrderController::linkMalls');
$routes->GET('order/linkmallslogs', 'OrderController::linkMallsLogs');
$routes->GET('order/orderlist', 'OrderController::orderList');
$routes->GET('order/orderregister', 'OrderController::orderRegister');
$routes->GET('order/deliverylist', 'OrderController::deliveryList');
$routes->GET('order/packinglist', 'OrderController::packingList');
$routes->GET('order/packingstatus', 'OrderController::packingStatus');

$routes->GET('goods/materiallist', 'GoodsController::materialList');
$routes->GET('goods/otherinfo', 'GoodsController::otherInfo');
$routes->GET('goods/goodslist', 'GoodsController::goodsList');
$routes->GET('goods/goodsreg', 'GoodsController::goodsReg');
$routes->GET('goods/goodsedit', 'GoodsController::goodsEdit');
$routes->GET('goods/productslist', 'GoodsController::productsList');
$routes->GET('goods/productsmasterlist', 'GoodsController::productsMasterList');
$routes->GET('goods/productsmasterreg', 'GoodsController::productsMasterReg');
$routes->GET('goods/productsmasterreg2', 'GoodsController::productsMasterReg2');
$routes->GET('goods/productsreg2', 'GoodsController::productsReg2');
$routes->GET('goods/productseditor', 'GoodsController::productsEditor');
$routes->GET('goods/instructionform', 'GoodsController::instructionForm');

$routes->GET('produce/productionstatus', 'ProduceController::productionStatus');
$routes->GET('produce/productionlist', 'ProduceController::productionList');
$routes->GET('produce/productionliststaff', 'ProduceController::productionListStaff');
$routes->GET('produce/productiondetail', 'ProduceController::productionDetail');
$routes->GET('produce/productiondetailmono', 'ProduceController::productionDetailMono');
$routes->GET('produce/instructionform', 'ProduceController::instructionForm');
//$routes->GET('produce/report', 'ProduceController::reportForm');

$routes->GET('inout/material', 'InoutController::inOutMaterial');
$routes->GET('inout/halfproduct', 'InoutController::inOutHalfproduct');
//$routes->GET('inout/materialreg', 'InoutController::materialReg');
$routes->GET('inout/popbarcodewindow', 'InoutController::popBarcodeWindow');
//$routes->GET('inout/popaddmatirial', 'InoutController::pop_AddMatirial');

$routes->GET('report/quality', 'ReportController::qualityReport');
$routes->GET('report/q_form', 'ReportController::qualityReportForm');
$routes->GET('report/order', 'ReportController::orderReport');
$routes->GET('report/o_form', 'ReportController::orderReportForm');

$routes->GET('monitor/workstatus', 'MonitorController::workStatus');
$routes->GET('monitor/processstatus', 'MonitorController::processStatus');

$routes->GET('info/user', 'CommonController::userInfo');
$routes->GET('info/notice', 'CommonController::notice');

/* Packing */
$routes->GET('packing/', 'PackingController::main');
$routes->GET('packing/process', 'PackingController::packingProcess');
$routes->GET('packing/waybillform', 'PackingController::waybillForm');


/* Product */
$routes->GET('product/', 'ProductController::main');
$routes->GET('product/statusdetail', 'ProductController::statusDetail');

/*API*/
$routes->match(['GET', 'POST'], 'Api/Call_Cancels', 'ApiController::Call_Cancels');
$routes->match(['GET', 'POST'], 'Api/Coupang_Order_Period', 'ApiMarketController::Coupang_Order_Period');
$routes->match(['GET', 'POST'], 'Api/Coupang_Info_Load', 'ApiMarketController::Coupang_Info_Load');
$routes->match(['GET', 'POST'], 'Api/ESM_Order_Check', 'ApiMarketController::ESM_Order_Check');
$routes->match(['GET', 'POST'], 'Api/Eleven_Get_Standby', 'ApiMarketController::Eleven_Get_Standby');
$routes->match(['GET', 'POST'], 'Api/Eleven_Get_Order_Delivery', 'ApiMarketController::Eleven_Get_Order_Delivery');
$routes->match(['GET', 'POST'], 'Api/Eleven_Get_Order_Info_Period', 'ApiMarketController::Eleven_Get_Order_Info_Period');
$routes->match(['GET', 'POST'], 'Api/Naver_Get_Product_Info', 'ApiMarketController::Naver_Get_Product_Info');
$routes->match(['GET', 'POST'], 'Api/Naver_Get_Order_Period', 'ApiMarketController::Naver_Get_Order_Period');


$routes->match(['GET', 'POST'], 'Api/login_do', 'ApiController::Login_Do');
$routes->match(['GET', 'POST'], 'Api/Load_MaterialList', 'ApiController::Load_MaterialList');
$routes->match(['GET', 'POST'], 'Api/Load_Material_Info', 'ApiController::Load_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Add_Material_Info', 'ApiController::Add_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Mod_Material_Info', 'ApiController::Mod_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Del_Material_Info', 'ApiController::Del_Material_Info');
$routes->match(['GET', 'POST'], 'Api/Load_Goods_List', 'ApiController::Load_Goods_List');
$routes->match(['GET', 'POST'], 'Api/Add_Goods_Info', 'ApiController::Add_Goods_Info');
$routes->match(['GET', 'POST'], 'Api/Add_Instructions', 'ApiController::Add_Instructions');
$routes->match(['GET', 'POST'], 'Api/Load_Produce_List', 'ApiController::Load_Produce_List');
$routes->match(['GET', 'POST'], 'Api/Load_Goods_Info', 'ApiController::Load_Goods_Info');
$routes->match(['GET', 'POST'], 'Api/mod_Goods_Info', 'ApiController::mod_Goods_Info');
$routes->match(['GET', 'POST'], 'Api/Upload_File_Editor', 'ApiController::Upload_File_Editor');
$routes->match(['GET', 'POST'], 'Api/Upload_file', 'ApiController::Upload_File');
$routes->match(['GET', 'POST'], 'Api/Upload_Multi_File', 'ApiController::Upload_Multi_File');
$routes->match(['GET', 'POST'], 'Api/Add_Goods', 'ApiController::Add_Goods');
$routes->match(['GET', 'POST'], 'Api/Delete_Goods', 'ApiController::Delete_Goods');
$routes->match(['GET', 'POST'], 'Api/Load_Product', 'ApiController::Load_Product');
$routes->match(['GET', 'POST'], 'Api/Delete_Goods_List', 'ApiController::Delete_Goods_List');
$routes->match(['GET', 'POST'], 'Api/Load_Maker', 'ApiController::Load_Maker');
$routes->match(['GET', 'POST'], 'Api/Load_Maker_Each', 'ApiController::Load_Maker_Each');
$routes->match(['GET', 'POST'], 'Api/Load_Maker2', 'ApiController::Load_Maker2');
$routes->match(['GET', 'POST'], 'Api/Add_Maker_Info', 'ApiController::Add_Maker_Info');
$routes->match(['GET', 'POST'], 'Api/Mod_Maker_Info', 'ApiController::Mod_Maker_Info');
$routes->match(['GET', 'POST'], 'Api/Del_Maker_Info', 'ApiController::Del_Maker_Info');
$routes->match(['GET', 'POST'], 'Api/Load_Supplier', 'ApiController::Load_Supplier');
$routes->match(['GET', 'POST'], 'Api/Add_Supplier_Info', 'ApiController::Add_Supplier_Info');
$routes->match(['GET', 'POST'], 'Api/Mod_Supplier_Info', 'ApiController::Mod_Supplier_Info');
$routes->match(['GET', 'POST'], 'Api/Del_Supplier_Info', 'ApiController::Del_Supplier_Info');
$routes->match(['GET', 'POST'], 'Api/Edit_Goods', 'ApiController::Edit_Goods');
$routes->match(['GET', 'POST'], 'Api/Insert_Excel', 'ApiController::Insert_Excel');
$routes->match(['GET', 'POST'], 'Api/Load_Mall_List', 'ApiController::Load_Mall_List');
$routes->match(['GET', 'POST'], 'Api/Load_Mall_Log_List', 'ApiController::Load_Mall_Log_List');


$routes->match(['GET', 'POST'], 'Api/Load_Instructions_Process', 'ApiProduceController::Load_Instructions_Process');
$routes->match(['GET', 'POST'], 'Api/Load_Instructions_Info', 'ApiProduceController::Load_Instructions_Info');
$routes->match(['GET', 'POST'], 'Api/Load_Instructions_NowStep', 'ApiProduceController::Load_Instructions_NowStep');
$routes->match(['GET', 'POST'], 'Api/Process_Confirm', 'ApiProduceController::Process_Confirm');
$routes->match(['GET', 'POST'], 'Api/Search_Goods', 'ApiProduceController::Search_Goods');
$routes->match(['GET', 'POST'], 'Api/Check_instruction', 'ApiProduceController::Check_instruction');

$routes->match(['GET', 'POST'], 'Api/Insert_Product', 'ApiProductController::Insert_Product');
$routes->match(['GET', 'POST'], 'Api/Load_Product_List', 'ApiProductController::Load_Product_List');
$routes->match(['GET', 'POST'], 'Api/Load_Product_Info', 'ApiProductController::Load_Product_Info');
$routes->match(['GET', 'POST'], 'Api/Edit_Product', 'ApiProductController::Edit_Product');
$routes->match(['GET', 'POST'], 'Api/Load_Product_Detail', 'ApiProductController::Load_Product_Detail');

$routes->match(['GET', 'POST'], 'Api/Insert_Order', 'ApiOrderController::Insert_Order');
$routes->match(['GET', 'POST'], 'Api/Load_Order_Data', 'ApiOrderController::Load_Order_Data');
$routes->match(['GET', 'POST'], 'Api/Load_Order_Info', 'ApiOrderController::Load_Order_Info');
$routes->match(['GET', 'POST'], 'Api/Put_Delivery_Info', 'ApiOrderController::Put_Delivery_Info');
$routes->match(['GET', 'POST'], 'Api/Put_Package_Info', 'ApiOrderController::Put_Package_Info');
$routes->match(['GET', 'POST'], 'Api/Load_Packing_Data', 'ApiOrderController::Load_Packing_Data');
$routes->match(['GET', 'POST'], 'Api/Put_Order_Info', 'ApiOrderController::Put_Order_Info');
$routes->match(['GET', 'POST'], 'Api/Insert_Delivery_Info', 'ApiOrderController::Insert_Delivery_Info');


$routes->match(['GET', 'POST'], 'Api/coupong_api_no1', 'ApiShopController::coupong_api_GetOrderPeriod');
$routes->match(['GET', 'POST'], 'Api/coupong_api_no2', 'ApiShopController::coupong_api_getOrderInfo');
$routes->match(['GET', 'POST'], 'Api/ESM_api_no2', 'ApiShopController::esm_api_GetOrderInfo');



