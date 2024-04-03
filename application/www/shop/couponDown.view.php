<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$id = $view->getParams(0); //상품 시스템코드
$view->assign('pid', $id);

$couponModel = $view->import('model.mall.coupon');
$list = $couponModel->getMallCouponList($id);
$view->assign('list', $list);

echo $view->loadLayout('product');