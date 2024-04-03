<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() || ($nonMemberOid != '' && $_GET['oid'] == $nonMemberOid)) {
    // View get
    $view = getForbizView();

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');
    $data = $mypageModel->doOrderDetail($view->userInfo->code, $view->input->get('oid'));

    $view->assign($data);
    $view->assign('freeGift',$data['order']['freeGift']);

    $view->assign('disTit', [
        'IN' => ForbizConfig::getDiscount('IN')
        , 'GP' => ForbizConfig::getDiscount('GP')
        , 'CP' => ForbizConfig::getDiscount('CP')
    ]);

    if ($nonMemberOid) {
        // 비회원 주문조회
        $view->assign('nonMemberOid', $nonMemberOid);
    } else {
        // 회원 Login Mypage 공통
        $view->mypageCommon();
    }

    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login');
}