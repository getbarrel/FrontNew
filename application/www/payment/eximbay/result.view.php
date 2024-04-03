<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'eximbay';

// Load Forbiz View
$view = getForbizView(true);

/* @var $orderModel CustomMallOrderModel */
$orderModel = $view->import('model.mall.order');
/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

$response = $view->input->post();

$products = $orderModel->getOrderProduct($response['ref']);
$cartIxs = array_unique(array_column($products, 'cart_ix'));

if ($response['rescode'] == '0000') {

    $paymentResult = [
        'result' => false
        , 'message' => ''
    ];

    $fgkey = $response['fgkey'];
    unset($response['fgkey']);
    $newFgkey = $paymentGatewayModel->evalModuleMethod('getFgkey', $response);

    //fgkey 검증키 비교
    if (strtolower($fgkey) != $newFgkey) {
        $paymentResult['message'] = "Invalid transaction";
    } else {
        //일본 결제 파라미터
//        $response['status'];//(일본결제)Registered or Sale :: Sale은 입금완료 시, statusurl로만 전송됨 일본 편의점/온라인뱅킹 후불결제 이용 시, 결제정보 등록에 대한 통지가 설정된 경우 발송됩니다.
//        $response['paymentURL'];//일본결제의 편의점/온라인뱅킹 후불 결제 이용시 고객에게 결제 방법을 안내하는 URL

        $method = ORDER_METHOD_EXIMBAY;
        $status = ORDER_STATUS_INCOM_COMPLETE;
        $tid = $response['transid'];
        $oid = $response['ref'];
        $amt = $response['amt'];
        $authCode = $response['authcode'];
        $memo = $paymentGatewayModel->evalModuleMethod('getPaymethod', $response['paymethod']);

        $payment = [
            'settle_module' => $paymentGatewayModel->getModuleName()
            , 'tid' => $tid
            , 'authcode' => $authCode
            , 'memo' => $memo
            , 'pay_status' => $status
            , 'escrow_use' => 'N'
        ];

        $mainPaymentInfo = $orderModel->getPaymentRowData($oid, $method);

        //statusurl 에서 먼저 update 가능 할수 있어 예외 처리
        if ($mainPaymentInfo['pay_status'] == $status && $mainPaymentInfo['tid'] == $tid) {
            $paymentResult['result'] = true;
        } else {
            $paymentResult = $orderModel->payment($oid, $method, $status, $amt, $payment);
        }
    }

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

        //PG 취소
        $cancelData = new PgForbizCancelData();
        $cancelData->isPartial = false;
        $cancelData->oid = $oid;
        $cancelData->originAmt = $amt;
        $cancelData->amt = $amt;
        $cancelData->message = $resultMsg;
        $cancelData->tid = $tid;
        $cancelData->logPath = $paymentGatewayModel->getLogPath();
        $cancelData->expectedRestAmt = 0;
        $response = $paymentGatewayModel->requestCancel($cancelData);
        if ($response['result']) {
            $resultMsg .= "(Cancel complete)";
        } else {
            $resultMsg .= "(Cancel failed - " . $response['message'] . ")";
        }
        $paymentGatewayModel->paymentFailGoCart($resultMsg);
        exit;
    }
} else {
    $paymentGatewayModel->paymentFail($response['resmsg'], $cartIxs);
    exit;
}