<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$con_ix = $view->getParams(0);
if(empty($con_ix)){
    redirect('/content/teamList');
}

$displayModel = $view->import('model.mall.display');
$productModel = $view->import('model.mall.product');

$displayContentDetail = $displayModel->getDisplayContentDetail($con_ix);

$imgpath	=  DATA_ROOT . "/images/content/player/".$con_ix."/";

$contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $displayContentDetail['con_ix'] . '/'; //배너이미지 기본 경로
$displayContentDetail['contentImgSrc'] = $contentPath.$displayContentDetail['list_img'];
$displayContentDetail['title'] = nl2br($displayContentDetail['title']);
$displayContentDetail['title_en'] = nl2br($displayContentDetail['title_en']);
$displayContentDetail['preface'] = nl2br($displayContentDetail['preface']);
$displayContentDetail['preface_en'] = nl2br($displayContentDetail['preface_en']);
$displayContentDetail['explanation'] = nl2br($displayContentDetail['explanation']);
$displayContentDetail['explanation_en'] = nl2br($displayContentDetail['explanation_en']);
$displayContentDetail['player_profile'] = nl2br($displayContentDetail['player_profile']);
$displayContentDetail['player_profile_en'] = nl2br($displayContentDetail['player_profile_en']);
$displayContentDetail['player_comment'] = nl2br($displayContentDetail['player_comment']);
$displayContentDetail['player_comment_en'] = nl2br($displayContentDetail['player_comment_en']);

foreach (json_decode($displayContentDetail['player_instar']) as $key => $val) {
    $displayContentDetail['instar'][$key]['Url'] = $val;
}

foreach (json_decode($displayContentDetail['player_youtube']) as $key => $val) {
    $displayContentDetail['youtube'][$key]['Url'] = $val;
}

if (file_exists($imgpath)) {
    $handle  = opendir($imgpath); // 디렉토리 open

    $files = array();
    $eleCount = 0;

    // 디렉토리의 파일을 저장
    while (false !== ($filename = readdir($handle))) {
        // 파일인 경우만 목록에 추가한다.
        if(is_file($imgpath . "/" . $filename)){
            $files[] = $filename;

        }
    }
    closedir($handle); // 디렉토리 close

    sort($files);

    foreach ($files as $f) { // 파일명 출력
        $displayContentDetail['imgSrc'][$eleCount]['imgSrcUrl'] = IMAGE_SERVER_DOMAIN . $imgpath.$f;

        $eleCount++;
    }
}

$view->assign('displayContentList', $displayContentDetail);

$displayContentGroupList = $displayModel->getDisplayContentGroup($con_ix);

foreach ($displayContentGroupList as $key => $val) {
    $displayContentGroupContent = $displayModel->getDisplayContentGroupContent($val['cgr_ix']);

    foreach ($displayContentGroupContent as $key1 => $val1) {
        $displayContentGroupList[$key]['groupList'][] = $val1;
    }

    $displayContentGroupProduct = $displayModel->getContentGroupProductRelationDetail($con_ix, $val['cgr_ix']);

    $ids = [];
    foreach($displayContentGroupProduct as $key2 => $val2){
        $ids[] = $val2['pid'];
    }

    $mainContentGroupProductRelationList = $productModel->getListById($ids);

    foreach ($mainContentGroupProductRelationList as $key3 => $val3) {
        $val3['listprice'] = g_price($val3['listprice']);
        $val3['dcprice'] = g_price($val3['dcprice']);
        $val3['sellprice'] = g_price($val3['sellprice']);
        $preface = explode('_', $val3['preface']);
        $val3['preface'] = $preface[0];
        $displayContentGroupList[$key]['productList'][] = $val3;
    }
}
//print_r($displayContentGroupList);

$view->assign('displayContentGroupList', $displayContentGroupList);

echo $view->loadLayout();