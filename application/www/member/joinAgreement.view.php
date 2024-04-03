<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    redirect('/');
} else {
// Load Forbiz View
    $view = getForbizView();
    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    $view->assign($memberModel->doJoinAgreement(sess_val('join', 'type')));
    
    echo $view->loadLayout();

    $view->event->emmit('MemberRegLogic',['code' => sess_val('user', 'code'), 'step' => 2]);
}