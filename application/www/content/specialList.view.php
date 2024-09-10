<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();

if(strlen($params[0]) > 1) {
	$paramCid	= $view->getParams(0);
	$paramPage	= $view->getParams(1);
}else{
	$paramPage	= $view->getParams(0);
	$paramCid	= "001001";
}

if($paramPage == "") {
	$paramPage = "1";
}

$displayModel = $view->import('model.mall.display');
$wishModel = $view->import('model.mall.wish');

//배럴인사이트 좌측메뉴
$displayContentClassList = $displayModel->getDisplayContentClass();

foreach($displayContentClassList as $key => $val){
    if($val['cid'] == '001001000000000'){
        $displayContentClassDepthList = $displayModel->getDisplayContentClass(substr($val['cid'],0,6));
    }
}

$displayList = $displayModel->getDisplayContentList(substr($paramCid,0,9), $paramPage);

$view->assign('displayContentClassList', $displayContentClassList);
$view->assign('displayContentClassDepthList', $displayContentClassDepthList);
// //배럴인사이트 좌측메뉴

// 배럴인사이드 > 기획전 전체
$c = 0;
foreach($displayList['list'] as $key){
    if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
        $displayList['list'][$c]['alreadyWishContent'] = 'Y';
    }else{
        $displayList['list'][$c]['alreadyWishContent'] = 'N';
    }
    $c++;
}

// 배럴인사이드 > 페이징
$pageNumTpl = "";
foreach($displayList['paging']['page_list'] as $key2 => $val2){
	if($paramPage == $val2) {
		$pageNumTpl .='<a href="/content/specialList/'.$paramCid.'/'.$val2.'" class="devPageBtnCls on" data-page="'.$val2.'">'.$val2.'</a>';
	}else{
		$pageNumTpl .= '<a href="/content/specialList/'.$paramCid.'/'.$val2.'" class="devPageBtnCls" data-page="'.$val2.'">'.$val2.'</a>';
	}
}

$view->assign('displayContentList', $displayList['list']);
$view->assign('displayContentPaging', $displayList['paging']);
$view->assign('displayContentTotal', $displayList['total']);
$view->assign('firstPage', $displayList['paging']['first_page']);
$view->assign('prevJump', $displayList['paging']['prev_jump']);
$view->assign('prevPage', $displayList['paging']['prev_page']);
$view->assign('curPage', $displayList['paging']['cur_page']);
$view->assign('nextPage', $displayList['paging']['next_page']);
$view->assign('nextJump', $displayList['paging']['next_jump']);
$view->assign('lastPage', $displayList['paging']['last_page']);
$view->assign('pageList', $displayList['paging']['page_list']);
$view->assign('pagelistCnt', count($displayList['paging']['page_list']));
$view->assign('pageNumTpl', $pageNumTpl);
$view->assign('paramCid', $paramCid);
$view->assign('paramCidSplit', substr($paramCid,0,6));

echo $view->loadLayout();