<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

// 주문번호
$orderId      = $view->getParams(0);

$view->assign('oid', $orderId);

echo $view->loadLayout();