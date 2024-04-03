<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

if (is_login()) {
    redirect('/');
} else {
    if ($view->isCached() === false) {
        $memberRegRule = $view->import('model.mall.member')->getMemberRegRule();

        $view->assign('useBasicJoin', (substr_count($memberRegRule['join_type'], 'B') > 0 ? true : false)); //일반 회원
        $view->assign('useCompanyJoin', true); //사업자 회원
        $view->assign('auth_method', $memberRegRule['auth_method']);
    }

    echo $view->loadLayout();

    // Event
    $view->event->emmit('MemberRegLogic', ['code' => sess_val('user', 'code'), 'step' => 1]);
}
