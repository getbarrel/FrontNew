<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

// 상품 코드
$state  = $view->getParams(0);

$view->assign('state', $state);

echo $view->loadLayout();