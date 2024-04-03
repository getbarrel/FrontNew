<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$view->define('customerTop', 'customer/index/customer_top.htm');

echo $view->loadLayout();