<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() || $nonMemberOid != '') {
    // View get
    $view = getForbizView();


    if ($nonMemberOid) {
        // 비회원 주문번호 Assign
        $view->assign('nonMemberOid', $nonMemberOid);

    } else {
        // 템플릿 데이터 Assign
        $view->assign([
            'today' => date('Y-m-d'),
            'oneWeek' => date('Y-m-d', strtotime('-1 week')),
            'oneMonth' => date('Y-m-d', strtotime('-1 month')),
            'threeMonth' => date('Y-m-d', strtotime('-3 month')),
            'sixMonth' => date('Y-m-d', strtotime('-6 month')),
            'oneYear' => date('Y-m-d', strtotime('-1 year')),
            'orderStatus' => ($view->input->get('order_status') ? $view->input->get('order_status') : 'all'),
            'status' => [
                ORDER_STATUS_CANCEL_APPLY => trans('취소'),
                ORDER_STATUS_RETURN_APPLY => trans('반품'),
                //ORDER_STATUS_EXCHANGE_APPLY => trans('교환'),
            ]
        ]);

        // 마이페이지 공통
        $view->mypageCommon();
    }
    $view->define('content', 'customer/cliam_guide/cliam_guide_content.htm');
    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/returnHistory');
}