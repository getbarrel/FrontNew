<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();
$divCode = $view->getParams(0);
/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');
$promotionArea = "";
$bestBannerInfo = "";
if($divCode) {
    $promotionArea = $displayModel->getPromotionDisplayLists($divCode);
    if(empty($promotionArea)){
        redirect('/');
    }

    $promotionProduct = [];
    if (is_array($promotionArea) && count($promotionArea) > 0) {
        foreach ($promotionArea as $key => $val) {
            $promotionArea[$key]['products'] = $displayModel->getPromotionDisplayDetails($val['div_code'],
                $val['pg_ix']);
        }
    }


    $bestBannerInfo = $displayModel->getDisplayBannerByDiv('BEST', 'TOP');
    //print_r($bestBannerInfo);

//print_r($promotionArea);
    $view->assign('promotionArea', $promotionArea);
    $view->assign('bestBannerInfo', $bestBannerInfo);

    echo $view->loadLayout();
}else{
    show_error('등록되지 않은 상품입니다.');
}