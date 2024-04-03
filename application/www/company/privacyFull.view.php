<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

$piCode = $view->getParams(0);

if($piCode == "person"){
    $piTitle = '개인정보처리방침';
}else{
    $piTitle = '이용약관';
}

/* @var $companyModel CustomMallCompanyModel */
$companyModel = $view->import('model.mall.company');

//개인정보취급방침
$view->assign('policy', $companyModel->getPolicyHistory($piCode));
$view->assign('piTitle', trans($piTitle));

echo $view->loadLayout();