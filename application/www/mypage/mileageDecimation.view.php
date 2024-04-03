<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
if (is_login()) {
    $view = getForbizView();

    // 소멸예정 마일리지 총액 (30일이내)
    /* @var $mileageModel CustomMallMileageModel */
    $mileageModel = $view->import('model.mall.mileage');

    $mileageRule = ForbizConfig::getSharedMemory('b2c_mileage_rule');

    if($mileageRule['auto_extinction'] == 'Y'){
        //마일리지 소멸 예정 금액 추출 기준 3개월 고정
        $extDate = 3;
        $extinctionMileage = $mileageModel->getExtMilageAmount($extDate);
    }else{
        $extinctionMileage = 0;
        $extDate = 0;
    }

    $view->assign('autoExtinction', $mileageRule['auto_extinction']);
    $view->assign('extDate', $extDate);
    $view->assign('ext_mileage_amount', g_price($extinctionMileage));

    // 마이페이지 공통
    $view->mypageCommon();

    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/mileageDecimation');
}