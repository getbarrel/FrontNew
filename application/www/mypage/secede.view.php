<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // View get
    $view = getForbizView();
    $sns_login = sess_val('sns_login');

    if ($view->getFlashData('reconfirmPassMode') == 'secede' || $sns_login) {
        // Load Model
        /* @var $mypageModel CustomMallMypageModel */
        $mypageModel = $view->import('model.mall.mypage');

        // 회원탈퇴 코드 생성
        $withdrawCode = md5('withdraw'.$view->userInfo->code.time());
        $view->setFlashData('withdrawCode', $withdrawCode);

        // 탈퇴에 필요한 데이터 assign
        $view->assign($mypageModel->doSecede($withdrawCode));

        // 마이페이지 공통
        $view->mypageCommon();
        // Layout 출력
        echo $view->loadLayout();
    } else {
        // 비밀번호 재확인
        $view->setFlashData('passReconfirmType', 'secede');
        redirect('/mypage/passReconfirm');
    }
} else {
    redirect('/member/login?url=/mypage/secede');
}