<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// View get
$view = getForbizView();

// *** 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

// 주문번호
$oid          = $view->input->get('oid');
// 개별 아이템
$od_ix        = $view->input->get('od_ix');


if ((is_login() || $nonMemberOid != '') && $oid) {

    //환불 은행리스트
    $view->assign('bankList', ForbizConfig::getBankList());

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');

    /* @var $orderModel CustomMallOrderModel */
    $orderModel  = $view->import('model.mall.order');

    // *** 취소 가능 주문 조회
    $claimstatus = $orderModel->checkPossibleCancelApply($oid);

    $view->assign('claimstatus', $claimstatus); // IR or IB, CC

    // 입금확인시 취소신청할 경우 취소완료 & 환불신청 상태
    $result = $mypageModel->doOrderCancel(sess_val('user', 'code'), $oid, $view->input->get('od_ix'), $claimstatus);


    $view->assign($result);

    // 임시처리 : 전체취소로만 처리 2019-10-16 -> 2020-01-08 부분취소 허용으로 처리
     $view->assign('odIx', $view->input->get('od_ix'));


    $view->assign('cancelAbleCnt', $result['orderDetailCnt']);
    $view->assign('cancelReason', $result['cancelReason']);
    // $view->assign('paymentMethodInfo', $result['paymentInfo']['payment']['0']);
    $view->assign('refundInfo', $result['paymentInfo']['payment']['0']);

//print_r($result['paymentInfo']['payment']['0']['method']);

    // 전체취소 이거나 단일 상품 부분 취소
    // 임시처리 : 전체취소로만 처리 2019-10-16 -> 2020-01-08 부분취소 허용으로 처리
    // 사은품이 포함된 주문일 경우 전체 취소만 가능하도록 설정 추가 2020-01-08
    $orderGiftItem = $orderModel->getOrderGiftItem($oid,'all');
    $partCancelBool = true;
    if(count($orderGiftItem) > 0){
        $partCancelBool = false;
    }
	if($result['paymentInfo']['payment']['0']['method'] == 9){
		$partCancelBool = false;
	}
    $view->assign('partCancelBool', $partCancelBool);


    if ($od_ix == '' || ($result['orderDetailCnt'] == 1 && $od_ix != '')) {
        //if(true){
        $view->assign('allSelected', 'Y');
    }



    if ($nonMemberOid) {
        // 비회원 주문번호 Assign
        $view->assign('nonMemberOid', $nonMemberOid);
    } else {
        // Mypage 공통
        $view->mypageCommon();
    }

    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/mypage');
}