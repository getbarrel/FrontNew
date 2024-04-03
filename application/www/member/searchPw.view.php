<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    redirect('/');
} else {
    // View get
    $view        = getForbizView();
    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    $view->assign($memberModel->doSearchPw());
    
    // Layout 출력
    echo $view->loadLayout();
}