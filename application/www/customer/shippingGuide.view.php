<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$view->define('customerTop', 'customer/index/customer_top.htm');

$view->define('content', 'customer/shipping_guide/shipping_guide_content.htm');

echo $view->loadLayout();