<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // View get
    $view = getForbizView();

    $userCode = $view->userInfo->code;

    // Load Model
    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');
    /* @var $productModel CustomMallProductModel */
    $productModel = $view->import('model.mall.product');
	
	//print_r($mypageModel->doDashBoard($userCode));
    // 대시보드 데이터 Assign wish
    $view->assign($mypageModel->doDashBoard($userCode));

    #최근본상품
    if(is_login()){
        $userMemberCode = $userCode;
    }else{
        $userMemberCode = session_id();
    }

    $beforeProductList = $productModel->getProductViewHistory($userMemberCode,1,5,false);
    if(!empty($beforeProductList['list'])){
        $view->assign('beforeProductList', $beforeProductList['list']);
    }

    // 마이페이지 공통
    $view->mypageCommon();
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage');
}