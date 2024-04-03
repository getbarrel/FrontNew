<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$gp_ix = $view->getParams(0);


/* @var $eventModel CustomMallEventModel */
$eventModel = $view->import('model.mall.event');
$group = $eventModel->getChampionshipOptions('group');
$event = $eventModel->getChampionshipOptions('event');
$attend = $eventModel->getChampionshipOptions('attend');

$info = $eventModel->checkChampionshipDay();
$now = date('Y-m-d H:i:s');

$chkButton = "T";
if($info->display_use == "Y"){
    if($now < $info->sdate || $now > $info->edate ) {
        $chkButton = "F";
    }
}else if($info->display_use == "N"){
    if($now < $info->sdate || $now > $info->edate ) {
        echo '<script>alert(" 신청서 조회 및 수정이 마감되었습니다.");location.href="/";</script>';
        exit;
    }
}

if(empty($gp_ix)) {
    //등록
    $type = 'I';

    //if($eventModel->checkChampionshipLimit() > $info->max || $now < $info->sdate || $now > $info->edate ) {
    if($eventModel->checkChampionshipLimit() > $info->max ) {
        echo '<script>alert("선착순 마감되었습니다.");location.href="/brand/applicationForm";</script>';
        exit;
    }

    $attend_event = array();
    $view->assign('attend_event' , $attend_event);

}else {
    //수정

    if($now < $info->sdate || $now > $info->edate ) {
        if(!empty($_SESSION['championship_allow'])) {
            unset($_SESSION['championship_allow']);
        }
        echo '<script>alert(" 신청서 조회 및 수정이 마감되었습니다.");location.href="/";</script>';
        exit;
    }

    //다른정보 조회막기
    if(isset($_SESSION['championship_allow']) && ($_SESSION['championship_allow'] != $gp_ix)){
        if(!empty($_SESSION['championship_allow'])) {
            unset($_SESSION['championship_allow']);
        }
        echo '<script>alert("잘못 된 접근입니다.");location.href="/brand/applicationForm";</script>';
        exit;
    }

    $type = 'M';
    $groupInfo = $eventModel->selectChampionshipGroup($gp_ix);
    $groupInfo['all_check']  = 'N';
    if($groupInfo['use_yn'] == 'Y' && $groupInfo['collection_yn'] == 'Y') {
        $groupInfo['all_check']  = 'Y';
    }

    $view->assign($groupInfo);
}

$view->assign('year', $info->year);
$view->assign('sdate', substr($info->sdate,0,4)."년 ".substr($info->sdate,5,2)."월 ".substr($info->sdate,8,2)."일 ".substr($info->sdate,11,2)."시 ".substr($info->sdate,14,2)."분");
$view->assign('chkButton' , $chkButton);
$view->assign('type' , $type);
$view->assign('gp_ix' , $gp_ix);
$view->assign('attendGroup' , $group);
$view->assign('attendEvent' , $event);
$view->assign('attend' , $attend);
$view->assign('info' , $info);
$view->assign('now' , $now);

echo $view->loadLayout();
