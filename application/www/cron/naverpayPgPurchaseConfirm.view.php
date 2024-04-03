<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'naverpayPg';

// Load Forbiz View
$view = getForbizView(true);

// 수동연동 대상일자
$bfDate  = $view->getParams(0);
$oid  = $view->getParams(1);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

if(empty($bfDate)){
    $yesterdayTime = strtotime('-1 day');
    $yesterdayDate = date('Y-m-d', $yesterdayTime);
}else{
    $yesterdayDate = date('Y-m-d', strtotime($bfDate));
}

if(!empty($oid)){
    $view->qb->where('op.oid',$oid);
}

$list = $view->qb->select('op.tid')
    ->select('op.oid')
    ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
    ->join(TBL_SHOP_ORDER_PAYMENT . ' AS op', 'od.oid=op.oid AND op.method="' . ORDER_METHOD_NPAY . '"')
    ->betweenDate('od.bf_date', $yesterdayDate, $yesterdayDate)
    ->groupBy('op.tid')
    ->exec()
    ->getResultArray();

foreach ($list as $li) {
    $result = $paymentGatewayModel->evalModuleMethod('doPurchaseConfirm', ['paymentId' => $li['tid'], 'requester' => '2']);

    if($result){
        $view->qb->insert(TBL_SHOP_ORDER_PURCHASE_CONFIRM_LOG, [
            'code' => $result->code ?? '',
            'message' => $result->message ?? '',
            'method' => ORDER_METHOD_NPAY,
            'oid' => $li['oid'],
            'tid' => $li['tid'],
            'data' => json_encode($result),
            'regdate' => date('Y-m-d H:i:s')
        ])->exec();
    }
}