<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$joinType = sess_val('join', 'type');

if ($joinType) {
    // Load Forbiz View
    $view        = getForbizView();

    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    $view->assign($memberModel->doAuthentication($joinType));
    $view->define([
        'joinBasic' => "member/authentication/authentication_basic.htm",
        'joinCompany' => "member/authentication/authentication_company.htm",
    ]);

    echo $view->loadLayout();

    $view->event->emmit('MemberRegLogic',['code' => sess_val('user', 'code'), 'step' => 2]);
}
