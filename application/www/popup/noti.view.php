<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');

// 팝업 ix
$popupIx = $view->getParams(0);
$data = $displayModel->getPopup($popupIx);

#배너팝업가져오기
$slideBannerPopUp = $displayModel->getDisplayBannerGroup(69);
$view->assign('slideBannerPopUp', $slideBannerPopUp);

$view->assign('popupIx', $slideBannerPopUp[0]['banner_ix']);
$view->assign('popupTitle', $slideBannerPopUp[0]['banner_name']);
$view->assign('popupToday', $data['popup_today']);
$view->assign('popupText', $data['popup_text']);
$view->assign('popupType', "L");

// content output
echo $view->loadLayout();
