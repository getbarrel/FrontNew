<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // View get
    $view = getForbizView();

    //sns 회원이 접근 못하도록
    /* @var $loginModel CustomMallMemberLoginModel */
    $loginModel = $view->import('model.mall.memberLogin');
    $sns_user = $loginModel->isSnsMember(sess_val('user', 'code'));
    if ($sns_user === true) {
        redirect('/');
    }else {

        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $view->import('model.mall.member');
        // Set password chang
        $memberModel->setChangePasswordAccessSessionUserCode(sess_val('user', 'code'));

        // Layout 출력
        echo $view->loadLayout();
    }
} else {
    redirect('/member/login?url=/mypage/profile');
}