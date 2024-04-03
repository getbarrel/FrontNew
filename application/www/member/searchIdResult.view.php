<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view        = getForbizView();
/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');
$authData = $memberModel->getAuthSessionData();
$memberModel->resetAuthSession();

if (is_login()) {
    redirect('/');
} elseif($authData == '' || count($authData) < 1) {
    //redirect('/member/searchId');
    $view->assign('userData', $authData);
    echo $view->loadLayout();
} else {
    $view->assign('userData', $authData);
    echo $view->loadLayout();
}