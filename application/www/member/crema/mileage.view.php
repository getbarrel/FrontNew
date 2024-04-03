<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView('noLayout');

/* @var $mileageModel CustomMallMileageModel */
$mileageModel = $view->import('model.mall.mileage');
log_message('error', 'crema  => ' . json_encode($view->input->post())); //check log

/**
 * Callback URL Parameters
  이름            	타입        	필수     설명
  user_code       string        ✔       적립금을 지급 받을 회원의 쇼핑몰 아이디입니다.
  amount          integer       ✔       적립금 액수
  review_id       integer       ✖       적립금 지급할 리뷰 id
  product_code    string        ✖       상품 code
  order_code      string        ✖       주문 code
  message         string        ✔       적립금 지급 사유
  created_at      datetime      ✖       리뷰 생성 날짜 Wed, 05 Jun 2019 16:19:47 KST +09:00
 */
$data = $mileageModel->cremaMileAgeCallBack($view->input->post());

/* @var $mileageModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
/**
 * 마일리지 넘어오면 해당 상품 인기도 +1
 */
$productModel->cremaMileAgeCallBackProductRecommand($view->input->post());


if ($data['message'] == 'success') {
    echo json_encode(['code' => 0, 'message' => 'success']);
} else {
    echo json_encode(['code' => $data['code'] ?? -1, 'message' => $data['message'] ?? "error not message"]);
}