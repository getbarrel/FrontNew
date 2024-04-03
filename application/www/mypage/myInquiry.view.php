<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    $view = getForbizView();

    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel   = $view->import('model.mall.mypage');
    $qnaInfo       = $mypageModel->getQnaCounts();
    /* @var $customerModel CustomMallCustomerModel */
    $customerModel = $view->import('model.mall.customer');
    if(BASIC_LANGUAGE == 'korean'){
        $board = 'qna';
    }else{
        $board = 'qna_global';
    }
    $customerModel->setBoardConfig($board);

    $bbsDiv        = $customerModel->getDivInfo(null, false, 1);
    $view->assign('bbsDiv', $bbsDiv);
    $view->assign('bType', $board);

    $bbsStatus = $customerModel->getBbsStatus();

    $view->assign('bbsStatus', $bbsStatus);
    $view->assign('bbsStatus1', $bbsStatus[0]);
    $view->assign('bbsStatus2', $bbsStatus[1]);
    $view->assign('bbsStatus5', $bbsStatus[2]);

    // 마이페이지 공통c
    $sDate = date("Y-m-d", strtotime("-12 month", strtotime(date("Y-m-d"))));
    $view->assign('sDate', $sDate);
    $view->assign('eDate', date('Y-m-d'));

    $view->assign([
        'today' => date('Y-m-d'),
        'oneWeek' => date('Y-m-d', strtotime('-1 week')),
        'oneMonth' => date('Y-m-d', strtotime('-1 month')),
        'threeMonth' => date('Y-m-d', strtotime('-3 month')),
        'sixMonth' => date('Y-m-d', strtotime('-6 month')),
        'oneYear' => date('Y-m-d', strtotime('-1 year'))
    ]);
    $view->mypageCommon();

    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/myInquiry');
}