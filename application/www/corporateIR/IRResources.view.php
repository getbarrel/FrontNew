<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();
$method = $params[0] ?? 'list';

// 재무정보
$boardName = 'ir';

if ($method == 'list') {
    $download_path = DATA_ROOT . "/bbs_data/bbs_" . $boardName . "";
    $view->assign('download_path', $download_path);


} else if ($method == 'read') {

    $bbsIx = $params[1] ?? null;

    if (is_null($bbsIx)) {
        redirect("/corporateIR");
    }

    /* @var $customerModel CustomMallCustomerModel */
    $customerModel = $view->import('model.mall.customer');
    $customerModel->setBoardConfig($boardName);
    $result = $customerModel->getCorporateIrArticle($bbsIx); // ir 예외처리

    $bbsConfig = $customerModel->getBoardConfig();

    $bbsConfig['bbs_templet_dir'] = 'custom'; // ir 예외처리
    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_read.htm');

    $view->assign('is_notice', $result['is_notice']);
    if(isset($result['before_record']['0'])){
        $view->assign('beforeRecord', $result['before_record']['0']);
    }
    if(isset($result['next_record']['0'])){
        $view->assign('nextRecord', $result['next_record']['0']);
    }
    $view->assign($result);
    $view->assign('board_name','IR Data');

    $download_path = DATA_ROOT . "/bbs_data/bbs_ir/" . $bbsIx;

	$view->assign('bType', $boardName);
    $view->assign('download_path', $download_path);
}
echo $view->loadLayout();