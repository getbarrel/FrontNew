<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
$productModel->cronCremaPutProductAllImsi($_REQUEST['cnt']);


//크리마 상품 등록 ! DB 기준 무조건 전체