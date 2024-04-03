<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$param = $view->getParams(0);

$customerModel = $view->import('model.mall.customer');
$info = $customerModel->getStoreInfo($param);

$view->assign('storeInfo', $info[0]);

echo $view->loadLayout();