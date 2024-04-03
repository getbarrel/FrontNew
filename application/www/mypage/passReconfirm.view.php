<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // View get
    $view = getForbizView();

    $reconfirmType = $view->getFlashData('passReconfirmType');
    $sns_login = sess_val('sns_login');

    if (($reconfirmType == 'profile' || $reconfirmType == 'secede') && !$sns_login) {
        // 비밀번호 재확인 타입
        $view->setFlashData('passReconfirmType', $reconfirmType);
        $view->assign('passReconfirmType', $reconfirmType);

        // Layout 출력
        echo $view->loadLayout();
    } else {
        redirect('/mypage/profile');
    }
} else {
    redirect('/member/login?url=/mypage/passReconfirm');
}