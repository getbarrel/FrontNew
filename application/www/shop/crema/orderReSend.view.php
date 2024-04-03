<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView('noLayout');

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');

$oid =  $view->input->get("oid");
$od_ix =  $view->input->get("od_ix");
$ora_ix =  $view->input->get("ora_ix");
$orc_ix =  $view->input->get("orc_ix");

if($od_ix){
    echo json_encode($orderModel->cremaOrderDetailReSend($od_ix));
}else if($oid){
    echo json_encode($orderModel->cremaOrderReSend($oid));
}else if($ora_ix){
    echo json_encode($orderModel->cremaOrderReApplySend($ora_ix));
}else if($orc_ix){
    echo json_encode($orderModel->cremaOrderReCompleteSend($orc_ix));
}else{
    echo 'not post oid!';
}