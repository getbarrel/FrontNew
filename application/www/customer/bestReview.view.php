<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

$view->define('customerTop', 'customer/index/customer_top.htm');

/* @var $reviewModel CustomMallProductReviewModel */
$reviewModel = $view->import('model.mall.productReview');

//상품후기 개수
$reviews = $reviewModel->getCount('');

/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');
$reviewBanner = $displayModel->getDisplayBannerByDiv('REVIEW','TOP');

// Data Assign
$view->assign([
    'premiumReviewTotal' => $reviews['premiumReview']
    , 'reviewTotal' => $reviews['review']
    , 'allReviewTotal' => $reviews['total']
    , 'avg' => $reviewModel->getAverage('')
    ,'reviewBanner' => $reviewBanner
]);

//후기영역 배너 추가
if (is_mobile()) {
    $reviewBanner2 = $displayModel->getDisplayBannerGroup(64);
    $view->assign('reviewBanner2', $reviewBanner2[0]);
} else {
    $reviewBanner2 = $displayModel->getDisplayBannerGroup(63);
    $view->assign('reviewBanner2', $reviewBanner2[0]);
}
// content output
echo $view->loadLayout();
