<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();
$id = $view->getParams(0); //상품 시스템코드
$bbs_ix = $view->getParams(1); //상품 시스템코드
$view->assign('pid', $id);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');
/* @var $qnaModel CustomMallProductQnaModel */
$qnaModel = $view->import('model.mall.productQna');

//상품문의 분류
$qnaDivs = $qnaModel->getAllDivs();
$view->assign('qnaDivs', $qnaDivs);

//상품정보
$datas = $productModel->get($id); //상품 상세 정보
$view->assign($datas);

if($bbs_ix){
    $qnaData = $qnaModel->getSelectQna($bbs_ix);
    $view->assign($qnaData);
}else{
    //이메일
    if (!empty(sess_val('user', 'mail'))) {
        $email = explode('@', sess_val('user', 'mail'));

        $view->assign('emailId', $email[0]);
        $view->assign('emailHost', $email[1]);
    }
}



echo $view->loadLayout('product');
