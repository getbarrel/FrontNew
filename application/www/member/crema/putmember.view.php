<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView('noLayout');

/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');

$input = $view->input->post();
if(empty($input)) {
    $input = json_decode($view->input->raw_input_stream, true);
}

if (isset($input['user_codes'])) {
    $user_codes = $input['user_codes'] ?? [];
    $data       = $memberModel->cronCremaMemberInsert($user_codes);
} else {
    $data = [];
}


// log_message('error', 'crema_member_call  => ' . json_encode($view->input->post())); //check log
$orderModel->insertCremaLog('putMember', json_encode(['get' => $view->input->get(), 'post' => $view->input->post(), 'input_stream' => $view->input->raw_input_stream], JSON_UNESCAPED_UNICODE),
    json_encode($data, JSON_UNESCAPED_UNICODE), '', '');

echo json_encode($data);
