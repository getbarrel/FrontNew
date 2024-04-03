<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView();

$view->define('customerTop', 'customer/index/customer_top.htm');

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');

$openingInfo = $customerModel->getOperationInfo();
$view->assign('biz_hours', nl2br($openingInfo['opening_time']));

// 공지사항
//공지사항
if(BASIC_LANGUAGE == 'korean'){
    $noticeBoardName = 'notice';
}else{
    $noticeBoardName = 'notice_global';
}
$customerModel->setBoardConfig($noticeBoardName);
$notice = $customerModel->getCustomerNotice((is_mobile() ? 5 : 5));
$noticeSort = array();
for($i=0;$i<count($notice);$i++){
    if($notice[$i]['is_notice'] == 'Y'){
        array_push($noticeSort,$notice[$i]);
        array_splice($notice, $i, 1);
    }
}
$notice = array_merge($noticeSort, $notice);
$view->assign('noticeList', $notice);

// Faq
if(BASIC_LANGUAGE == 'korean'){
    $boardName = "faq";
}else{
    $boardName = "en_faq";
}

$customerModel->setBoardConfig($boardName);
$faq = $customerModel->getCustomerFaq(5);

$view->assign('faqList', $faq);
$view->mypageCommon();

echo $view->loadLayout();