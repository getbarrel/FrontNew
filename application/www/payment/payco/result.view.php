<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'payco';

// Load Forbiz View
$view = getForbizView(true);

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');
/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

$returnData = $view->input->get();
if (!isset($returnData['code'])) {
    $returnData = $view->input->post();
}

$products = $orderModel->getOrderProduct($returnData['sellerOrderReferenceKey']);
$cartIxs = array_unique(array_column($products, 'cart_ix'));

if ($returnData['code'] != '0') {
    if ($returnData['code'] == '2222') {
        $resultMessage = '구매자 취소';
    } else {
        $resultMessage = '결제 오류 : ' . $returnData['code'];
    }
    $paymentGatewayModel->paymentFail($resultMessage, $cartIxs);
    exit;
}

//승인 요청
$response = $paymentGatewayModel->paymentApply($returnData);

if ($response['code'] == '0') {

    $resultData = $response['result'];

    $method = ORDER_METHOD_PAYCO;
    if ($resultData['paymentCompletionYn'] == 'Y') {
        $status = ORDER_STATUS_INCOM_COMPLETE;
    } else {
        $status = ORDER_STATUS_INCOM_READY;
    }
    $tid = $resultData['orderNo'] . "|" . $resultData['orderCertifyKey'];
    $oid = $resultData['sellerOrderReferenceKey'];
    $amt = $resultData['totalPaymentAmt'];

    $authCode = '';
    $_memo = [];
    foreach ($resultData['paymentDetails'] as $paymentDetail) {
        $_memo[] = $paymentDetail['paymentMethodName'] . ' : ' . number_format($paymentDetail['paymentAmt']);
    };
    $memo = implode(", ", $_memo);

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
    $paymentGatewayModel->paymentFail($response['message'], $cartIxs);
}