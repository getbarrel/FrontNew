<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$id = $view->getParams(0);

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');


$result = $orderModel->getOrderHistory(sess_val('user', 'code'), $searchData, []);

$orderList = [];
if ($result['total'] > 0) {
    foreach ($result['list'] as $order) {

        if(count($order['orderDetail']) > 1){
            $extra_count = count($order['orderDetail']) - 1;
            if(BASIC_LANGUAGE == 'english'){
                $buy_product_name_text = $extra_count." extra product";
            }else{
                $buy_product_name_text = "외 ".$extra_count."건";
            }
        }

        $view->assign([
            'today' => date('Y-m-d'),
            'oneWeek' => date('Y-m-d', strtotime('-1 week')),
            'oneMonth' => date('Y-m-d', strtotime('-1 month')),
            'threeMonth' => date('Y-m-d', strtotime('-3 month')),
            'sixMonth' => date('Y-m-d', strtotime('-6 month')),
            'oneYear' => date('Y-m-d', strtotime('-1 year')),
            'orderStatus' => ($view->input->get('order_status') ? $view->input->get('order_status') : 'all'),
            'status' => $status
        ]);

        $orderList[] = [
            'oid' => $order['oid']
            , 'order_date' => $order['order_date']
            , 'payment_price' => $order['payment_price']
            , 'product_image_src' => $order['orderDetail'][0]['pimg']
            , 'buy_product_name' => $order['orderDetail'][0]['pname']." ". $buy_product_name_text
        ];
    }
}

$view->assign('orderList', $orderList);

// content output
echo $view->loadLayout();