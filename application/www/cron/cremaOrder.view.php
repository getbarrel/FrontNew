<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');
$page = $view->input->get('page');
$size = $view->input->get('size');
$orderModel->cremaCronOrderBfList($page, $size);