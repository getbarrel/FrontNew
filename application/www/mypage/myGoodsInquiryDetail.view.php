<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    $view            = getForbizView();
    
    $bbsIx = $view->getParams(0);

    /* @var $productQnaModel CustomMallProductQnaModel */
    $productQnaModel    = $view->import('model.mall.productQna');
    $productModel       = $view->import('model.mall.product');
    $result = $productQnaModel->getDetail($bbsIx, $view->userInfo->code);

    $datas = $productModel->get($result['pid']);

    $result['discount_rate'] = $datas['discount_rate'];
    $result['dcprice'] = $datas['dcprice'];
    $result['listprice'] = $datas['listprice'];

    $view->assign($result);
    
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/myGoodsInquiry');
}