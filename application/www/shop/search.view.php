<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$productModel = $view->import('model.mall.product');

$searchText = $view->input->get('searchText');
$filterText = $view->input->get('filterText');

$searchText = trim(urldecode($searchText));
$filterText = trim(urldecode($filterText));

if (!empty($searchText)) {
    $view->assign('searchText', $searchText);
    $productModel->addSearchKeywordLog($searchText);
    $productModel->setRecentKeyword($searchText);

}
$brandList = $productModel->getBrandList(); //브랜드 전체 호출
$view->assign('brandList', $brandList);

$recentKeywords = $productModel->getRecentKeyword(); //최근검색어 호출
$view->assign('recentKeywords', $recentKeywords);
//최근검색어 삭제 메소드 : deleteRecentKeyword

$popularKeyword = $productModel->getPopularKeyword(); //인기검색어 호출
$view->assign('popularKeyword', $popularKeyword);

#필터 정보가져오기
$filter = $productModel->getFilterList();
//print_r($filter);
$view->assign('filter', $filter);

echo $view->loadLayout('product');
