<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$cid = $view->getParams(0);
if(empty($cid)){
    redirect('/');
}

$view->assign('cid', $cid);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');
$cateUse = $productModel->getCategoryUseData($cid);

if($cateUse['category_use'] == 0){
    redirect('/');
}
$cateData = $productModel->getTopCategoryInList($cid);


$depth2CateCid = substr($cid, 0, 6).'000000000';


$cateArr = array();
$cateName = '';
$topCateName = '';
$topCateCid = '';
$cateData_cnt = count($cateData);
for($i=0; $i<$cateData_cnt; $i++) {
    $cate = $cateData[$i];
    $depth = $cate['depth'];

    //현재 선택된 카테고리 네임
    if($cate['cid'] == $cid) {
        $cateName = $cate['cname'];
    }

    if($depth == 0) {
        $cateArr = $cateData[$i];
        $topCateName = $cate['cname'];
        $topCateCid = $cate['cid'];
    }else if($depth == 1){
        $cateArr['subCate'][$cate['vlevel2']-1] = $cateData[$i];
    }else if($depth == 2) {
        $cateArr['subCate'][$cate['vlevel2']-1]['subCate'][$cate['vlevel3']-1] = $cateData[$i];
    }
}

#필터 정보가져오기
$filter = $productModel->getFilterList();

$bannerInfo = $displayModel->getDisplayBannerGroup('24','banner_ix',$cid);

//print_r($filter);
$view->assign('filter', $filter);

$view->assign('cateName', $cateName);
$view->assign('topCateName', $topCateName);
$view->assign('topCateCid', $topCateCid);
$view->assign('depth2CateCid', $depth2CateCid);
$view->assign('cateArr', $cateArr);

#배너
$view->assign('bannerInfo', $bannerInfo);
$view->assign('category_sort', $cateUse['category_sort']);
echo $view->loadLayout();