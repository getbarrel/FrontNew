<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$con_ix = $view->getParams(0);
$preview = $view->getParams(1);

if(empty($con_ix)){
    redirect('/');
}

$displayModel = $view->import('model.mall.display');
$productModel = $view->import('model.mall.product');

$displayContentDetail = $displayModel->getDisplayContentDetail($con_ix, $preview);

$view->assign('displayContentList', $displayContentDetail);

$displayContentGroupList = $displayModel->getDisplayContentGroup($con_ix);

foreach ($displayContentGroupList as $key => $val) {
    $displayContentGroupContent = $displayModel->getDisplayContentGroupContent($val['cgr_ix']);

    foreach ($displayContentGroupContent as $key1 => $val1) {
        $displayContentGroupList[$key]['groupList'][] = $val1;
    }

    $displayContentGroupProduct = $displayModel->getContentGroupProductRelationDetail($con_ix, $val['cgr_ix']);

    $ids = [];
    foreach($displayContentGroupProduct as $key2 => $val2){
        $ids[] = $val2['pid'];
    }

    $mainContentGroupProductRelationList = $productModel->getListById($ids);

    foreach ($mainContentGroupProductRelationList as $key3 => $val3) {
        $val3['listprice'] = g_price($val3['listprice']);
        $val3['dcprice'] = g_price($val3['dcprice']);
        $val3['sellprice'] = g_price($val3['sellprice']);
        $preface = explode('_', $val3['preface']);
        $val3['preface'] = $preface[0];
        $displayContentGroupList[$key]['productList'][] = $val3;
    }
}

$view->assign('displayContentGroupList', $displayContentGroupList);

echo $view->loadLayout();