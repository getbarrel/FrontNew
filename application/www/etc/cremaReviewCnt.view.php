<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

$datas = json_decode($view->input->raw_input_stream,true);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
log_message('error', 'cremaReviewCountIn : '.$view->input->raw_input_stream);
$count_item = array();
if(is_array($datas)){
    foreach($datas as $key=>$val){
        foreach($val['products'] as $k=>$v){
            $count_item['id']  = $v['id']; //크리마 상품 ID
            $count_item['product_code']  = $v['code']; //상품 코드
            $count_item['reviews_count']  = $v['reviews_count']; //상품 리뷰수
            $count_item['meta_reviews_count']  = $v['meta_reviews_count']; //상품 리뷰수 (서브 상품 리뷰 수 포함)
            $count_item['score']  = $v['score']; //상품 평점
            $count_item['meta_score']  = $v['meta_score']; //상품 평점 (서브상품 리뷰 평점 포함)



            $productModel->cremaReviewCountById($count_item);
        }
    }
}
