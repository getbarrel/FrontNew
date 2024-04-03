<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();
$param = $view->getParams(0);
/* @var $companyModel CustomMallCompanyModel */
$companyModel = $view->import('model.mall.company');

$piCode = 'use';

if($param != 'sprint' && !empty($param)) {
    $piCode = 'use_global';
}

//이용약관
//$view->assign('policy', $companyModel->getPolicyHistory('use'));
$policy = $companyModel->getPolicyNow($piCode);
$policyHistory = $companyModel->getPolicyHistoryDate($piCode);
//이용약관
$view->assign('policy',$policy );
$view->assign('policyHistory',$policyHistory );

// 스프린트 이용약관
$view->define([
    'sprintAgreement' => "/company/agreement/agreement_sprint.htm"
]);
// 스프린트 분기값
$view->assign('type', $param);

echo $view->loadLayout();
