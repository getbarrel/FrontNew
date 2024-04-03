<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

/* @var $eventModel CustomMallEventModel */
$eventModel = $view->import('model.mall.event');

$info = $eventModel->checkChampionshipDay();
$now = date('Y-m-d H:i:s');

//조회 후 신청하러가는 페이지 왔을시 허용값 제거
if(!empty($_SESSION['championship_allow'])) {
    unset($_SESSION['championship_allow']);
}

$view->assign('year', $info->year);

if($info->display_use == "N"){
    if($now < $info->sdate || $now > $info->edate ) {
        echo '<script>alert(" 신청서 조회 및 수정이 마감되었습니다.");location.href="/";</script>';
        exit;
    }
}

echo $view->loadLayout();
