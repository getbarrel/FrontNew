<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'naverpayPg';

// Load Forbiz View
$view = getForbizView(true);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

$stime = strtotime('-30 minute');
$etime = strtotime('-15 minute');
$startDate = date('YmdHi00', $stime);
$endDate = date('YmdHi59', $etime);

$list = [];
$searchData = [
    'startTime' => $startDate
    , 'endTime' => $endDate
    , 'rowsPerPage' => '50'
    , 'approvalType' => 'APPROVAL'
];

$data = $paymentGatewayModel->evalModuleMethod('getHistory', $searchData);
$list = array_merge($list, $data->body->list);
if ($data->body->totalPageCount > 1) {
    for ($pageNumber = 2; $pageNumber < $data->body->totalPageCount; $pageNumber++) {
        $searchData['pageNumber'] = $pageNumber;
        $data = $paymentGatewayModel->evalModuleMethod('getHistory', $searchData);
        $list = array_merge($list, $data->body->list);
    }
}

if (count($list) > 0) {
    /* @var $orderModel CustomMallOrderModel */
    $orderModel = $view->import('model.mall.order');

    $method = ORDER_METHOD_NPAY;
    $status = ORDER_STATUS_INCOM_COMPLETE;

    foreach ($list as $li) {
        $amt = $li->totalPayAmount;
        $oid = $li->merchantPayKey;
        $tid = $li->paymentId;
        $authCode = '';
        $memo = '';
        if ($li->primaryPayMeans == 'CARD') {
            $authCode = $li->cardAuthNo;
            $memo = 'Card : ' . $li->cardNo;
        } else if ($li->primaryPayMeans == 'BANK') {
            $memo = 'Bank : ' . $li->bankAccountNo;
        }

        $order = $view->qb->select('op.oid')
            ->from(TBL_SHOP_ORDER_PAYMENT . ' AS op')
            ->join(TBL_SHOP_ORDER . ' AS o', 'op.oid=o.oid')
            ->where('op.pay_status', ORDER_STATUS_INCOM_READY)
            ->where('op.method', ORDER_METHOD_NPAY)
            ->where('o.status', ORDER_STATUS_SETTLE_READY)
            ->where('op.oid', $oid)
            ->exec()
            ->getRowArray();

        if ($view->qb->total > 0) {
            $payment = [
                'settle_module' => $paymentGatewayModel->getModuleName()
                , 'tid' => $tid
                , 'authcode' => $authCode
                , 'memo' => $memo
                , 'pay_status' => $status
                , 'escrow_use' => 'N'
            ];

            $paymentResult = $orderModel->payment($oid, $method, $status, $amt, $payment);
            if ($paymentResult['result']) {
                //SMS & 메일 보내기
                $view->event->trigger('payment', ['oid' => $oid]);
            } else {
                $resultMsg = $paymentResult['message'];

                $mainPaymentInfo = $orderModel->getPaymentRowData($oid, $method);

                //PG 취소
                $cancelData = new PgForbizCancelData();
                $cancelData->isPartial = false;
                $cancelData->oid = $oid;
                $cancelData->amt = $amt;
                $cancelData->message = $resultMsg;
                $cancelData->tid = $tid;
                $cancelData->taxAmt = $mainPaymentInfo['tax_price'];
                $cancelData->taxExAmt = $mainPaymentInfo['tax_free_price'];
                $cancelData->expectedRestAmt = 0;
                $cancelData->logPath = $paymentGatewayModel->getLogPath();
                $response = $paymentGatewayModel->requestCancel($cancelData);

                //shop_order 주문번호 상태변경 SR => SO
                $orderModel->setOrderStatus($oid, ORDER_STATUS_SOLDOUT_CANCEL);
            }
        }
    }
}