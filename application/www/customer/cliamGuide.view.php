<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$view->define('customerTop', 'customer/index/customer_top.htm');

$view->define('content', 'customer/cliam_guide/cliam_guide_content_230126.htm');

echo $view->loadLayout();