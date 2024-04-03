<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();

// 재무정보
$boardName = 'finance';

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();

$docInfo = $customerModel->getFinanceInfo();
$gubun = $customerModel->getDivInfo();

$view->assign('gubun', $gubun);
$view->assign('docInfo', $docInfo);


//var_dump($docInfo);exit;

$view = getForbizView();

echo $view->loadLayout();