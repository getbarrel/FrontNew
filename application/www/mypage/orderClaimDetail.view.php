<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 비회원 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');
// View get
$view = getForbizView();
$oid = $view->getParams(0);
$claimGroup = $view->getParams(1);

// 로그인한 회원 또는 비회원 로그인한 회원인가?
if (is_login() || ($nonMemberOid != '' && $oid == $nonMemberOid)) {    
    if ($oid != '' && $claimGroup != '') {

        /* @var $mypageModel CustomMallMypageModel */
        $mypageModel = $view->import('model.mall.mypage');
        $result = $mypageModel->doOrderClaimDetail($view->userInfo->code, $oid, $claimGroup);
        $view->assign($result);
        $view->assign('reason_data',$result['reason']['reason_data']);
        $view->assign('freeGift',$result['order']['freeGift']);

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
        redirect('/mypage/orderHistory');
    }
} else {
    redirect('/member/login');
}