<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(false);

// 품목 코드
$gid  = $view->getParams(0);


if(!empty($gid)) {
    /* @var $productModel CustomMallProductModel */
    $productModel = $view->import('model.mall.product');
    $product = $productModel->getItemCodeByProduct($gid);

    if(!empty($product)){
        redirect('/shop/goodsView/'.$product['pid']);
    }else{
        redirect('/');
    }
}else{
    redirect('/');
}