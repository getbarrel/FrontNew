<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$view = getForbizView();
$params = $view->getParams();
$method = $params[0] ?? 'list';

$bbsIx = $view->input->get('bbs_ix'); 
$sText = $view->input->get('sText'); // 검색어
if(BASIC_LANGUAGE == 'korean'){
    $boardName = 'faq';
}else{
    $boardName = 'faq_global';
}
//print_r($view->input->get('bbs_ix'));

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();
$bbsDivs = $customerModel->getDivInfo(null, false, 1);

$view->define('customerTop', 'customer/index/customer_top.htm');
$view->assign('bbs_divs', $bbsDivs);
$view->assign('bType', $boardName);
$view->assign('sText', $sText);
$view->assign('bbsIx', $bbsIx);

if ($method == 'list') {
    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/faq_list.htm');

    if (is_mobile()) {
        $divInfo = $customerModel->getCustomerFaq(20);
        $addTabCount = (count($divInfo)) % 3;
        $view->assign('addTabCount', $addTabCount);
    } else {
        $divInfo = $customerModel->getCustomerFaq(10);

    }
}

echo $view->loadLayout();