<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();

if(strlen($params[0]) > 1) {
	$con_ix = $view->getParams(0);
	$paramPage = $view->getParams(1);
}else{
	$paramPage = $view->getParams(0);
	$con_ix = "";
}

if($paramPage == "") {
	$paramPage = "1";
}

$displayModel = $view->import('model.mall.display');
$wishModel = $view->import('model.mall.wish');

$displayList = $displayModel->getDisplayContent('001003');

$c = 0;
foreach($displayList['list'] as $key){
    if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
        $displayList['list'][$c]['alreadyWishContent'] = 'Y';
    }else{
        $displayList['list'][$c]['alreadyWishContent'] = 'N';
    }
    $c++;
}

// ¹è·²ÀÎ»çÀÌµå > ÆäÀÌÂ¡
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

echo $view->loadLayout();