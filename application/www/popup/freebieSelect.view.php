<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$cartIxs = explode(",", $view->input->get('cartIx'));
$saleCouponPrice = $view->input->get('saleCouponPrice');
$useMileage = $view->input->get('useMileage');
$freeGiftCondition = $view->input->get('freeGiftCondition');

/* @var $cartModel CustomMallCartModel */
$cartModel = $view->import('model.mall.cart');

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');

$cartData = $cartModel->get($cartIxs);
$cartSummary = $cartModel->getSummary($cartData);

$freeGiftCheckPrice = $cartSummary['summary']['product_dcprice'] - $saleCouponPrice - $useMileage;

//$freeGift = $productModel->getFreeGift($freeGiftCheckPrice);
$freeGift = $productModel->getFreeGiftInfo($cartData,$freeGiftCondition,$freeGiftCheckPrice);
//print_r($freeGift);

$view->assign('freeGift', $freeGift);
$view->assign('cartIx', $cartIxs[0]);
//print_r($freeGift);
echo $view->loadLayout();