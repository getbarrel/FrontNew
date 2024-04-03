<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

$id = $view->getParams(0);

if ($id != '') {
    $id = zerofill($id);

    /* @var $productModel CustomMallProductModel */
    $productModel = $view->import('model.mall.product');

    //상품 상세 정보
    $datas = $productModel->get($id);
    $view->assign($datas);

    //품목 스타일코드 정보
    $style_code = $productModel->getStyleCode($id);
    $view->assign('style_code',$style_code);

    $style = $productModel->getStoreGuideStyle($id);
    $view->assign('style', $style);

    $option = $productModel->getStoreGuideOption($id);
    $view->assign('option', $option);

    $customerModel = $view->import('model.mall.customer');

    $cityList = $customerModel->getCityCode();
    $view->assign('cityList', $cityList);


}



echo $view->loadLayout();