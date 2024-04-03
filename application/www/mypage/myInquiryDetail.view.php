<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView();

if(is_mobile()){
    $bbsIx = $view->uri->segments[3];
}else{
    $bbsIx = $view->input->get('bbs_ix');
}
if(BASIC_LANGUAGE == 'korean'){
    $board = 'qna';
}else{
    $board = 'qna_global';
}

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($board);
$result = $customerModel->getQnaDetail($bbsIx, 'bbs_'.$board);

$productName = "";
$productImage = "";

if(isset($result['qInfo']['oInfo'])){

    $productCnt = count($result['qInfo']['oInfo']);

    if($productCnt > 1){
        $productName = $result['qInfo']['oInfo']['0']['pname']." 외 ".($productCnt -1)."개 상품";
    }else{
        $productName = $result['qInfo']['oInfo']['0']['pname'];
    }
    $productImage = $result['qInfo']['oInfo']['0']['pimg'];
}


if(isset($result['qInfo']['cInfo'])){
    $view->assign('cInfo', $result['qInfo']['cInfo']);
}

$view->assign($result['qInfo']);
$view->assign('productName', $productName);
$view->assign('productImage', $productImage);
$view->assign('bbsIx', $bbsIx);
$view->assign('oInfoCnt', empty($result['qInfo']['oInfo']) ? 0 : count($result['qInfo']['oInfo']));

$tpl = $view->tpl;

echo $view->loadLayout();