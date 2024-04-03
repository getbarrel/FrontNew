<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    $view = getForbizView();

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');
    $result       = $mypageModel->getMyMileageInfo();
    $view->assign($result);

    // 소멸예정 마일리지 총액 (30일이내)
    /* @var $mileageModel CustomMallMileageModel */
    $mileageModel = $view->import('model.mall.mileage');
    $view->assign('ext_mileage_amount', number_format($mileageModel->getExtMilageAmount()));

    // 마이페이지 공통
    $sDate = date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
    $view->assign('sDate', $sDate);
    $view->assign('eDate', date('Y-m-d'));

    $view->assign([
        'today' => date('Y-m-d'),
        'oneWeek' => date('Y-m-d', strtotime('-1 week')),
        'oneMonth' => date('Y-m-d', strtotime('-1 month')),
        'sixMonth' => date('Y-m-d', strtotime('-6 month')),
        'oneYear' => date('Y-m-d', strtotime('-1 year'))
    ]);

// 마이페이지 공통
    $view->mypageCommon();

    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/mileage');
}
