<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

// 상품 코드
$id  = $view->getParams(0);
// 옵션 코드
$opn_id  = $view->getParams(1);

if ($id != '') {
    $id = zerofill($id);

    /* @var $productModel CustomMallProductModel */
    $productModel = $view->import('model.mall.product');
    $productModel->setDiscoutMemberGroupCalculationYn('Y');
    //상품 상세 정보
    $datas = $productModel->get($id);
    $productModel->setDiscoutMemberGroupCalculationYn('N');
    $view->assign($datas);

    $pcs = $view->userInfo->pcs;

    $view->assign('pcs',$pcs);

    if($opn_id){
       $option_div =  $productModel->getOptionDiv($opn_id);
       $view->assign('option_div',$option_div);
       $view->assign('opn_id',$opn_id);

    }else{
       $options = $productModel->getOption($id);
       $optionData = $options['viewOptions'];

       $view->assign('optionData',$optionData);

    }

}

echo $view->loadLayout();