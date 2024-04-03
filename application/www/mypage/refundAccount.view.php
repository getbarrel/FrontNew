<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    $view = getForbizView();

    $view->assign('bankList', ForbizConfig::getBankList());

    // 마이페이지 공통
    $view->mypageCommon();
    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/refundAccount');
}