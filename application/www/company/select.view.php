<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

$piCode = $view->getParams(0);

$piTitle = '개인정보처리방침';

if(empty($piCode)) {
    $piCode ='collection_select';
    $piTitle = '개인정보 수집 및 이용(선택)';
}

/* @var $companyModel CustomMallCompanyModel */
$companyModel = $view->import('model.mall.company');

//개인정보취급방침
$view->assign('policy', $companyModel->getPolicyHistory($piCode));
$view->assign('piTitle', trans($piTitle));

// 스프린트 개인정보 수집 및 이용
$view->define([
    'sprintPrivacy' => "/company/privacy/privacy_sprint.htm"
]);
// 스프린트 분기값
$view->assign('type', $piCode);


echo $view->loadLayout();
