<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$view = getForbizView();
$params = $view->getParams();
$method = $params[0] ?? 'list';

//공지사항
if(BASIC_LANGUAGE == 'korean'){
    $boardName = 'notice';
}else{
    $boardName = 'notice_global';
}

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();

$view->define('customerTop', 'customer/index/customer_top.htm');
$view->assign('bType', $boardName);

if ($method == 'list') {
    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_list.htm');

} else if ($method == 'read') {
    $bbsIx = $params[1] ?? null;

    if (is_null($bbsIx)) {
        redirect("/customer/notice");
    }

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_read.htm');

    $result = $customerModel->getArticle($bbsIx);

    $view->assign('is_notice', $result['is_notice']);

    if(isset($result['before_record']['0'])){
        $view->assign('beforeRecord', $result['before_record']['0']);
    }
    if(isset($result['next_record']['0'])){
        $view->assign('nextRecord', $result['next_record']['0']);
    }

    $view->assign($result);

    $download_path = DATA_ROOT . "/bbs_data/bbs_" . $boardName . "/" . $bbsIx;
    $view->assign('download_path', $download_path);
}

echo $view->loadLayout();