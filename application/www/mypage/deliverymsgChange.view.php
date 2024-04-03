<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 배송지 관리
 */

$view = getForbizView();
$params = $view->getParams();

if ($params['0'] != '') {

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');
    $orderInfo = $mypageModel->doOrderDetail($view->userInfo->code, $params['0']);


    $view->assign('oid', $orderInfo['order']['oid']);
    $view->assign('msgInfo', $orderInfo['deliveryInfo']['msg']);

    // 마이페이지 공통
    $view->mypageCommon();
    // Layout 출력
    echo $view->loadLayOut();
} else {
    redirect('/member/login');
}
