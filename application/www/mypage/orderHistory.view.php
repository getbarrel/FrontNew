<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() || $nonMemberOid != '') {
    // View get
    $view = getForbizView();

    $userCode = $view->userInfo->code;
    
    // Load Model
    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');

	//print_r($mypageModel->doDashBoard($userCode));
    // 대시보드 데이터 Assign wish
    $view->assign($mypageModel->doDashBoard($userCode));

    $status = [
        ORDER_STATUS_INCOM_READY => ForbizConfig::getOrderStatus(ORDER_STATUS_INCOM_READY),
        ORDER_STATUS_INCOM_COMPLETE => ForbizConfig::getOrderStatus(ORDER_STATUS_INCOM_COMPLETE),
        ORDER_STATUS_DELIVERY_READY => ForbizConfig::getOrderStatus(ORDER_STATUS_DELIVERY_READY),
        ORDER_STATUS_DELIVERY_ING => ForbizConfig::getOrderStatus(ORDER_STATUS_DELIVERY_ING),
        ORDER_STATUS_DELIVERY_COMPLETE => ForbizConfig::getOrderStatus(ORDER_STATUS_DELIVERY_COMPLETE),
        ORDER_STATUS_BUY_FINALIZED => ForbizConfig::getOrderStatus(ORDER_STATUS_BUY_FINALIZED),
        ORDER_STATUS_CANCEL_APPLY => trans('취소'),
        ORDER_STATUS_RETURN_APPLY => trans('반품'),
        //ORDER_STATUS_EXCHANGE_APPLY => trans('교환'),
    ];

    if(BASIC_LANGUAGE != 'korean') {
        array_shift($status);
    }

    if ($nonMemberOid) {
        // 비회원 주문번호 Assign
        $view->assign('nonMemberOid', $nonMemberOid);
        $view->assign([
            'orderStatus' => ($view->input->get('order_status') ? $view->input->get('order_status') : 'all'),
            'status' => $status
        ]);
    } else {
        // 데이터 Assign
        $view->assign([
            'today' => date('Y-m-d'),
            'oneWeek' => date('Y-m-d', strtotime('-1 week')),
            'oneMonth' => date('Y-m-d', strtotime('-1 month')),
            'threeMonth' => date('Y-m-d', strtotime('-3 month')),
            'sixMonth' => date('Y-m-d', strtotime('-6 month')),
            'oneYear' => date('Y-m-d', strtotime('-1 year')),
            'orderStatus' => ($view->input->get('order_status') ? $view->input->get('order_status') : 'all'),
            'status' => $status
        ]);
        // 마이페이지 공통
        
    }

	$view->mypageCommon();
    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/orderHistory');
}