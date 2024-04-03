<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$view->define('customerTop', 'customer/index/customer_top.htm');
$storeId = $view->getParams(0);


$customerModel = $view->import('model.mall.customer');
$cityList = $customerModel->getCity();

if(!empty($storeId)) {
    $storeInfo = $customerModel->getStoreList(1,10,"","","",$storeId);
    $view->assign('storeName', $storeInfo['list'][0]['store_name']);
}
$view->assign('cityList', $cityList);

$info = $customerModel->getStoreInfo("31008");
$view->assign('storeBasicInfo', $info[0]);

echo $view->loadLayout('customer');