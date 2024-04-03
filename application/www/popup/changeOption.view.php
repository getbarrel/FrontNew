<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();


// 상품 코드
$id  = $view->getParams(0);
// 장바구니 코드
$cartIx  = $view->getParams(1);
// 주문 수량
$pcount  = $view->getParams(2);
// 주문 수량
$dOpt  = $view->getParams(3);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
//상품 상세 정보
$datas = $productModel->get($id);
//print_r($datas);
$view->assign($datas);

$cartModel = $view->import('model.mall.cart');
// 카트 상세 정보
$exCartIx    = explode('%2C', $cartIx);
$cartData    = $cartModel->get($exCartIx);
$cartData    = $cartData[0]['deliveryTemplateList'][0]['productList'][0];

foreach($cartData as $key => $val){
    if($key == "add_info" || $key == "pcount" || $key == "total_dcprice" || $key == "select_option_id"){
        $cartOptionp[$key] = $val;
    }else if($key == "options_text"){
		$arrText = explode(":",$val);
        $cartOptionp[$key] = $val;
        $cartOptionp["options_code"] = $arrText[1];
	}else if($key == "setData"){
        if($val){
            $num = 0;
            foreach($val as $key1){
                $options_text = explode(':', $key1['options_text']);
                $cartOptionp[$key][$num]['name'] = $options_text[0];
                $cartOptionp[$key][$num]['option'] = $options_text[1];
                $cartOptionp[$key][$num]['pcount'] = $key1['pcount'];
                $num++;
            }
        }else{
            $cartOptionp[$key] = $val;
        }
    }
}

$view->assign('pid', $id);
$view->assign('cartIx', urldecode($cartIx));
$view->assign('pcount', $pcount);
$view->assign('dOpt', $dOpt);
$view->assign('cartOptionp', $cartOptionp);

echo $view->loadLayout();