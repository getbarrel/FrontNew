<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_mobile()) {
    $view = getForbizView();
    $param = $view->getParams(0);

    $customerModel = $view->import('model.mall.customer');
    $info = $customerModel->getStoreInfo($param);

    $view->assign('storeInfo', $info[0]);

    echo $view->loadLayout();
}else{
    $view = getForbizView();
    $view->define('customerTop', 'customer/index/customer_top.htm');
    $storeId = $view->getParams(0);

    $customerModel = $view->import('model.mall.customer');
    $cityList = $customerModel->getCity();

    $storeinfo = $customerModel->getStoreInfo($storeId);
    $store_code = $storeinfo[0]["store_code"];

    $view->assign('cityList', $cityList);

    $info = $customerModel->getStoreInfo($store_code);
    $view->assign('storeBasicInfo', $info[0]);

    echo $view->loadLayout('customer');

    //redirect("/customer/storeInformation/".$param);
}

/*
$customerModel = $view->import('model.mall.customer');
$info = $customerModel->getStoreInfo($param);

$view->assign('storeInfo', $info[0]);

echo $view->loadLayout();
*/