<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
$productModel->cronCremaPutProductUpdate();

//크리마 상품 업데이트 ! 오늘 날짜 기준으로 전체