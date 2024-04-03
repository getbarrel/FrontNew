<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();


/* @var $cartModel CustomMallCartModel */
$cartModel = $view->import('model.mall.cart');
/* @var $couponModel CustomMallCouponModel */
$couponModel = $view->import('model.mall.coupon');


$cartIxs = $view->input->post('cartIxs');
$couponDiv = $view->input->post('couponDiv');
$view->assign('couponDiv', $couponDiv);

$cartData = $cartModel->get($cartIxs);
$cartSummaryData = $cartModel->getSummary($cartData);

$list = [];
$cartCouponExceptProductDcprice = f_decimal(0);
foreach ($cartData as $company) {
    foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
        foreach ($deliveryTemplate['productList'] as $product) {
            $product['couponList'] = $couponModel->applyProductUserCouponList($product['id'], $product['dcprice'],
                $product['total_dcprice'], $product['discount_coupon_use_yn']);
            foreach ($product['couponList'] as $couponKey => $coupon) {
                //쿠폰을 이미 선택한 경우
                if (!empty($useCouponData[str_replace(",", "|",
                        $product['cart_ix'])]) && $useCouponData[str_replace(",", "|",
                        $product['cart_ix'])] == $coupon['regist_ix']
                ) {
                    $coupon['isSelected'] = true;
                } else {
                    $coupon['isSelected'] = false;
                }
                $product['couponList'][$couponKey] = $coupon;
            }
            $list[] = $product;
        }
    }
}


if($couponDiv == 'D') {
    $totalProductDcprice = $cartSummaryData['summary']['product_dcprice'];
    $totalDeliveryPrice = $cartSummaryData['summary']['total_delivery_price'];
    $deliveryCouponList = $couponModel->applyUserDeliveryCouponList($totalDeliveryPrice, $totalProductDcprice);

    $view->assign('deliveryCouponList', $deliveryCouponList);
    $view->assign('totalDeliveryPrice', $totalDeliveryPrice);
}else {

    $totalProductDcprice = $cartSummaryData['summary']['product_dcprice'];


    $useCouponData = $view->input->post('useCouponData');
    if (!is_array($useCouponData)) {
        $useCouponData = [];
    }



//장바구니 쿠폰
$cartCouponList = $couponModel->applyUserCartCouponList($totalProductDcprice, $list);
foreach ($cartCouponList as $cartCouponKey => $cartCoupon) {
    if (!empty($useCouponData['cart']) && $useCouponData['cart'] == $cartCoupon['regist_ix']) {
        $cartCoupon['isSelected'] = true;
    } else {
        $cartCoupon['isSelected'] = false;
    }
    $cartCouponList[$cartCouponKey] = $cartCoupon;
}
//print_r($totalProductDcprice);
    $view->assign('list', $list);
    $view->assign('cartCouponList', $cartCouponList);
    $view->assign('selectedCartCouponIx', $useCouponData['cart'] ?? '');
    $view->assign('totalProductDcprice', $totalProductDcprice);
}

echo $view->loadLayout();
