<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();

if(strlen($params[0]) > 1) {
	$con_ix = $view->getParams(0);
	$paramPage = $view->getParams(1);
}else{
	$paramPage = $view->getParams(0);
	$con_ix = "001002";
}

if($paramPage == "") {
	$paramPage = "1";
}

$displayModel = $view->import('model.mall.display');
$wishModel = $view->import('model.mall.wish');

if($con_ix == ''){
    $displayList = $displayModel->getDisplayContentList('001002', $paramPage);
}else{
    $displayList = $displayModel->getDisplayContentList(substr($con_ix,0,9), $paramPage);
}

$c = 0;
foreach($displayList['list'] as $key){
	if($displayList['list'][$c]['explanation'] != '') {
		$displayList['list'][$c]['explanation'] = trim($displayList['list'][$c]['explanation']);
	}
    //print_r($displayList['list'][$c]['explanation']);
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
		$pageNumTpl .='<a href="/content/styleList/'.$val2.'" class="devPageBtnCls on" data-page="'.$val2.'">'.$val2.'</a>';
	}else{
		$pageNumTpl .= '<a href="/content/styleList/'.$val2.'" class="devPageBtnCls" data-page="'.$val2.'">'.$val2.'</a>';
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

//스타일큐레이션 좌측메뉴
$displayContentClassDepthList = $displayModel->getDisplayContentClass('001002','S');

$view->assign('displayContentClassStyleList', $displayContentClassDepthList);
$view->assign('con_ix', $con_ix);
$view->assign('pageDepth', "1");
// //스타일큐레이션 좌측메뉴

echo $view->loadLayout();