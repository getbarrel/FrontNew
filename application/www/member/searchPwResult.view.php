<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');
$authData = $memberModel->getAuthSessionData();
$memberModel->resetAuthSession();


if (is_login() || $authData == '') {
    redirect('/');
} else {
    $view->assign('userData', $authData['0']);

    echo $view->loadLayout();
}
