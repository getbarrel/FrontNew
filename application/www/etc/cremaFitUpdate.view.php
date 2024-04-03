<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');

$mode = $view->input->get('mode');
$start_date = $view->input->get('start_date');
$end_date = $view->input->get('end_date');

$result = ['status' => 'success'];

if(!$mode){
    $result['status'] = 'fail';
    $result['message'] = 'not parameter mode';    
    print_r(json_encode($result));
    exit;
}

if(!$start_date){
    $result['status'] = 'fail';
    $result['message'] = 'not parameter start_date';    
    print_r(json_encode($result));
    exit;
}

if(!$end_date){
    $result['status'] = 'fail';
    $result['message'] = 'not parameter end_date';    
    print_r(json_encode($result));
    exit;
}
//?mode=productcreate&start_date=20180401&end_date=20180509


if($mode && $start_date &&  $end_date){
    $result = $productModel->cronCremaFitProduct($mode, $start_date, $end_date);
}


print_r(json_encode($result));




//크리마 상품 등록 ! 오늘 날짜 기준으로 전체