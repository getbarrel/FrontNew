<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$registIx = $view->input->get('regIx');

/* @var $couponModel CustomMallCouponModel */
$couponModel = $view->import('model.mall.coupon');
$data = $couponModel->getCouponApplyProductListByPub($registIx);
$view->assign($data);
//print_r($data);
//exit;
//$view->assign($couponModel->getCouponApplyProductList($registIx));
//$view->assign();

echo $view->loadLayout();