<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 비회원 로그인을 통한 주문번호
//$nonMemberOid = sess_val('nonMember', 'oid');
// Load Forbiz View
$view         = getForbizView();
// 주문번호
$orderId      = $view->getParams(0);
if (is_login()) {
    $view->define('addressBookForm', 'mypage/addressbook_select/addressbook_member.htm');
    $view->assign('oid', $orderId);

    // 마이페이지 공통
    //$view->mypageCommon();
    // Layout 출력
    echo $view->loadLayOut();
} else {
    $view->define('addressBookForm', 'mypage/addressbook_select/addressbook_no_member.htm');
    $view->assign('oid', $orderId);
    echo $view->loadLayOut();
//    redirect('/member/login');
}
