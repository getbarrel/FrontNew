<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$view->define('customerTop', 'customer/index/customer_top.htm');
$storeId = $view->getParams(0);


$customerModel = $view->import('model.mall.customer');
$cityList = $customerModel->getCity();

$store_code = "31008";

if(!empty($storeId)) {
	$storeinfo = $customerModel->getStoreInfo($storeId);
	$store_code = $storeinfo[0]["store_code"];
    //$storeInfo = $customerModel->getStoreList(1,10,"","","",$storeId);
    //$view->assign('storeName', $storeInfo['list'][0]['store_name']);
}
$view->assign('cityList', $cityList);

$info = $customerModel->getStoreInfo($store_code);
$view->assign('storeBasicInfo', $info[0]);

echo $view->loadLayout('customer');