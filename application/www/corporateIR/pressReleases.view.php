<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();
$method = $params[0] ?? 'list';

// 재무정보
$boardName = 'press';

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();

$view->assign('bType', $boardName);
$view->assign($bbsConfig);

if ($method == 'list') {
    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_list.htm');
} else if ($method == 'read') {
    $bbsIx = $params[1] ?? null;

    if (is_null($bbsIx)) {
        redirect("/corporateIR/pressReleases");
    }

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_read.htm');


    $result = $customerModel->getArticle($bbsIx);

    if(isset($result['before_record']) && is_array($result['before_record'])){
        foreach($result['before_record'] as $key=>$val){
            $result['before_record'][$key]['link'] = str_replace('/customer','/corporateIR/pressReleases',$val['link']);
        }
    }

    if(isset($result['next_record']) && is_array($result['next_record'])){

        foreach($result['next_record'] as $key=>$val){
            $result['next_record'][$key]['link'] = str_replace('/customer','/corporateIR/pressReleases',$val['link']);
        }
    }

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