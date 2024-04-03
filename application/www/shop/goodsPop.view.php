<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

$sizeModel = $view->import('model.mall.popup');

$sizeTitle = $sizeModel->goodsSizeTitle();

foreach($sizeTitle as $key => $val){
	$sizeList[substr($val['cid'],0,3)]['main_cid'] = $val['cid'];
	$sizeList[substr($val['cid'],0,3)]['main_title'] = $val['title'];
	$sizeList[substr($val['cid'],0,3)]['subInfo']  = $sizeModel->goodsSizeList(substr($val['cid'],0,3));
}

$view->assign('title', $sizeTitle);
$view->assign('list', $sizeList);
echo $view->loadLayout();