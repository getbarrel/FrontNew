<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$con_ix = $view->getParams(0);
$cid = $view->getParams(1);
$preview = $view->getParams(2);

if(empty($con_ix)){
    redirect('/content/styleList');
}

$displayModel = $view->import('model.mall.display');
$productModel = $view->import('model.mall.product');

$displayContentDetail = $displayModel->getDisplayContentDetail($con_ix, $preview);

$displayContentDetail['preface'] = nl2br($displayContentDetail['preface']);
$displayContentDetail['preface_en'] = nl2br($displayContentDetail['preface_en']);

$imgpath	=  DATA_ROOT . "/images/content/style/".$con_ix."/";

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

$view->assign('displayContentGroupList', $displayContentGroupList);

//스타일큐레이션 좌측메뉴
$displayContentClassDepthList = $displayModel->getDisplayContentClass('001002','S');

$view->assign('displayContentClassStyleList', $displayContentClassDepthList);
$view->assign('con_ix', $cid);
$view->assign('pageDepth', "2");
// //스타일큐레이션 좌측메뉴

echo $view->loadLayout();