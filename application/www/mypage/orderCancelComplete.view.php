<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$params = $view->getParams();
// 주문번호
$oid = $params[0];

// 비회원 로그인을 통한 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() && $oid) {

    //환불 은행리스트
    $view->assign('bankList', ForbizConfig::getBankList());

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');

    /* @var $orderModel CustomMallOrderModel */
    $orderModel  = $view->import('model.mall.order');

    // 취소 완료
    $view->assign('claimstatus', ORDER_STATUS_CANCEL_COMPLETE);

    // 입금대기, 입금완료 주문 조회
    $result = $mypageModel->doOrderDetail(sess_val('user', 'code'), $oid);

    // echo "<pre>";   var_dump($result);exit;
    array_shift($params);

    if($result['order']['status'] == ORDER_STATUS_CANCEL_COMPLETE) { // 입금완료 주문 취소
        /* @var $orderModel CustomMallOrderModel */
        $reason = $orderModel->getOrderCancelReason($oid, $params, $result['order']['status'], ORDER_STATUS_INCOM_COMPLETE);
    }else{
        /* @var $orderModel CustomMallOrderModel */
        $reason = $orderModel->getOrderCancelReason($oid, $params, $result['order']['status'], ORDER_STATUS_INCOM_READY);
    }


//echo "<pre>";    var_dump($result['paymentInfo']['pt_dcprice']);exit;


    // *** 뷰단 취소 리스트를 출력시키고 잔여 주문수량 정보를 별도로 추가해주고, 부분 취소(분할)시 해당 od_ix 만 노출처리 (기획 요청)
    $restOrderDetail = array();

    if($result['order']['status'] == ORDER_STATUS_CANCEL_COMPLETE){ // 입금완료 주문 취소

        foreach($result['order']['orderDetail'] as $odeIx=>$odeInfo){
            foreach($odeInfo as $p=>$v){
                // 잔여 입금 완료 건
                if($v['status'] == ORDER_STATUS_INCOM_COMPLETE){
                    $restOrderDetail[$v['pid']]['rest_cnt'] = $v['pcnt'];
                }

                if(isset($params) && count($params) > 0){
                    $key = array_search($v['od_ix'], $params);
                    if($key === false){
                        $result['order']['orderDetail'][$odeIx][$p]['status'] = 'NODISP'; // 비노출 처리
                    }
                }
            }
        }
    }

    $view->assign($result);
    $view->assign('restOrderDetail', $restOrderDetail);
    $view->assign('reason_data', $reason['reason_data']);

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