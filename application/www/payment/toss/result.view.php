<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'toss';

// Load Forbiz View
$view = getForbizView(true);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');

$status = $view->input->get('status');
$orderNo = $view->input->get('orderNo');

$products = $orderModel->getOrderProduct($orderNo);
$cartIxs = [];
foreach ($products as $product) {
    $cartIxs[] = $product['cart_ix'];
}
$cartIxs = array_unique($cartIxs);

if ($status != 'PAY_APPROVED') {
    $paymentGatewayModel->paymentFail($status, $cartIxs);
    exit;
}

//승인 요청
$response = $paymentGatewayModel->paymentApply([
    'orderNo' => $orderNo
]);

if ($response->code == '0') {
    $method = ORDER_METHOD_TOSS;
    $status = ORDER_STATUS_INCOM_COMPLETE;

    $tid = $response->payToken;
    $authCode = $response->transactionId;
    $amt = $response->amount;
    $oid = $response->orderNo;

    $payment = [
        'settle_module' => $paymentGatewayModel->getModuleName()
        , 'tid' => $tid
        , 'authcode' => $authCode
        , 'pay_status' => $status
        , 'escrow_use' => 'N'
    ];

    $paymentResult = $orderModel->payment($oid, $method, $status, $amt, $payment);
    if ($paymentResult['result']) {
        //장바구니 삭제
        /* @var $cartModel CustomMallCartModel */
        $cartModel = $view->import('model.mall.cart');
        $cartModel->delete($cartIxs);

        $view->setFlashData('payment_oid', $oid);
        //SMS & 메일 보내기
        $view->event->trigger('payment', ['oid' => $oid]);
        $paymentGatewayModel->paymentSuccess($oid);
        exit;
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
        $cancelData->logPath = $paymentGatewayModel->getLogPath();
        $response = $paymentGatewayModel->requestCancel($cancelData);
        if ($response['result']) {
            $resultMsg .= "(PG 취소 완료)";
        } else {
            $resultMsg .= "(PG 취소 실패 - " . $response['message'] . ")";
        }
        $paymentGatewayModel->paymentFailGoCart($resultMsg);
        exit;
    }
} else {
    $paymentGatewayModel->paymentFail($response->msg, $cartIxs);
}