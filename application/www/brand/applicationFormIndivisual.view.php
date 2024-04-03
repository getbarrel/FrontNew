<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$cm_ix = $view->getParams(0);

/* @var $eventModel CustomMallEventModel */
$eventModel = $view->import('model.mall.event');

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

if(empty($cm_ix)) {
    //등록
    $type = 'I';

    //if($eventModel->checkChampionshipLimit() > $info->max || $now < $info->sdate || $now > $info->edate ) {
    if($eventModel->checkChampionshipLimit() > $info->max ) {
        echo '<script>alert("선착순 마감되었습니다.");location.href="/brand/applicationForm";</script>';
        exit;
    }

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
    if($_SESSION['championship_allow'] != $cm_ix){
        unset($_SESSION['championship_allow']);
        echo '<script>alert("잘못 된 접근입니다.");location.href="/brand/applicationForm";</script>';
        exit;
    }
    
    $type = 'M';
    $memberInfo = $eventModel->selectChampionshipMember($cm_ix);

    if($memberInfo['use_yn'] == 'Y' && $memberInfo['collection_yn'] == 'Y') {
        $memberInfo['all_check']  = 'Y';
    }

    $view->assign($memberInfo);
}
$group = $eventModel->getChampionshipOptions('group');
$event = $eventModel->getChampionshipOptions('event');

$view->assign('year', $info->year);
$view->assign('sdate', substr($info->sdate,0,4)."년 ".substr($info->sdate,5,2)."월 ".substr($info->sdate,8,2)."일 ".substr($info->sdate,11,2)."시 ".substr($info->sdate,14,2)."분");
$view->assign('chkButton' , $chkButton);
$view->assign('type' , $type);
$view->assign('cm_ix' , $cm_ix);
$view->assign('attendGroup' , $group);
$view->assign('attendEvent' , $event);
$view->assign('info' , $info);
$view->assign('now' , $now);

echo $view->loadLayout();
