<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() || ($nonMemberOid != '' && $_GET['oid'] == $nonMemberOid)) {
    // View get
    $view = getForbizView();

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');

    $view->assign($mypageModel->doReceiptPrint(sess_val('user', 'code'), $view->input->get('oid')));

    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/receiptPrint');
}