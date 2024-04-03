<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// View get
$view = getForbizView();
/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');

$view->assign($memberModel->doSearchId());

// Layout 출력
echo $view->loadLayout();
