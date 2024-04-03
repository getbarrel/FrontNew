<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/../core/framework/Forbiz.php');

$view = getForbizView();
$displayModel = $view->import('model.mall.display');
$bannerIx = $view->input->get('bannerIx');
$bdIx = $view->input->get('bdIx');

$link = $displayModel->getBannerLink($bannerIx, $bdIx);

if (! empty($link)) {
    header("Location:" . $link);
    exit;
} else {
    header("Location:/");
    exit;
}