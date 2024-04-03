<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// View get
$view = getForbizView();

$delivery_company = $view->getParams(0);
$invoice_no       = $view->getParams(1);

if ($delivery_company && $invoice_no) {
    /* @var $orderModel CustomMallOrderModel */
    $orderModel = $view->import('model.mall.order');

    $delivery_info = $orderModel->searchGoodsFlow($delivery_company);

    if($delivery_info['goodsflowYn'] == 'Y') {
        $delivery_info['code_etc1'] = $delivery_info['goodsflow']['site_domain'].'/'.$delivery_info['goodsflow']['site_id'].'/'.$delivery_info['goodsflow']['target_code'].'/';
    }

    if(empty($delivery_info)) {
        $view->assign('error', '해당택배사 정보가 존재 하지 않습니다');
    } else {
        $delivery_info['invoice_no'] = $invoice_no;
        $view->assign($delivery_info);
    }
} else {
    $view->assign('error', '배송코드 오류 입니다.');
}

// Layout 출력
echo $view->loadLayout();
