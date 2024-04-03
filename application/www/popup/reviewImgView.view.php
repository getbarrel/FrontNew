<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();
$bbsIx = $view->getParams(0);
$index = $view->getParams(1);

$view->assign('bbsIx', $bbsIx);
$view->assign('selectIndex', $index);

/* @var $reviewModel CustomMallProductReviewModel */
$reviewModel = $view->import('model.mall.productReview');
$view->assign('imgs', $reviewModel->getAfterImg($reviewModel->getData($bbsIx), 'all'));

// content output
echo $view->loadLayout();
