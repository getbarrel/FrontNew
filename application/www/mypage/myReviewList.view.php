<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    $view = getForbizView();

// 마이페이지 공통
    $sDate = date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
    $view->assign([
        'sDate' => $sDate
        , 'eDate' => date('Y-m-d')
        , 'today' => date('Y-m-d')
        , 'oneWeek' => date('Y-m-d', strtotime('-1 week'))
        , 'oneMonth' => date('Y-m-d', strtotime('-1 month'))
        , 'sixMonth' => date('Y-m-d', strtotime('-6 month'))
        , 'oneYear' => date('Y-m-d', strtotime('-1 year'))
    ]);
    $view->mypageCommon();

    $view->assign('image_review_src', IMAGE_SERVER_DOMAIN . DATA_ROOT . '/product_after');

    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/myProductReview');
}