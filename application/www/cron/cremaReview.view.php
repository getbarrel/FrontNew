<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);


/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
$productModel->cremaReviewCount();
