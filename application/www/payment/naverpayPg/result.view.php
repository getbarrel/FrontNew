<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'naverpayPg';

// Load Forbiz View
$view = getForbizView(true);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);

$resultCode = $_REQUEST['resultCode'];             // 결제 결과(Fail: 실패)
if ($resultCode != 'Success') {
    $resultMessage = $_REQUEST['resultMessage'];              // 실패 사유 메시지
    if ($resultMessage == 'userCancel') {
        $resultMessage = '결제를 취소하셨습니다. 주문 내용 확인 후 다시 결제해주세요.';
    } else if ($resultMessage == 'webhookFail') {
        $resultMessage = 'webhookUrl 호출 응답 실패';
    } else if ($resultMessage == 'paymentTimeExpire') {
        $resultMessage = '결제 가능한 시간이 지났습니다. 주문 내용 확인 후 다시 결제해주세요.';
    } else if ($resultMessage == 'OwnerAuthFail') {
        $resultMessage = '타인 명의 카드는 결제가 불가능합니다. 회원 본인 명의의 카드로 결제해주세요.';
    }
    $paymentGatewayModel->paymentFailGoCart($resultMessage);
    exit;
}

//승인 요청
$paymentId = $_REQUEST['paymentId'];              // 네이버페이 결제번호. 최대 50바이트
$response = $paymentGatewayModel->paymentApply(['paymentId' => $paymentId]);

if ($response->code == 'Success') {

    $method = ORDER_METHOD_NPAY;
    $status = ORDER_STATUS_INCOM_COMPLETE;

    $tid = $response->body->paymentId;
    $detail = $response->body->detail;

    $oid = $detail->merchantPayKey;
    $amt = $detail->totalPayAmount;

    /* @var $orderModel CustomMallOrderModel */
    $orderModel = $view->import('model.mall.order');
    $products = $orderModel->getOrderProduct($oid);
    $cartIxs = array_unique(array_column($products, 'cart_ix'));

    $authCode = '';
    $memo = '';
//    ※ 검수시 주의 사항 때문에  memo 주석처리
//    1안) 모든 결제수단에 "네이버페이"로 공통 적용
//
//    2안) 결제수단에 따라 "네이버페이+실제 결제 수단"으로 상세 적용
//    네이버페이(신용카드)
//    네이버페이(계좌이체)
//    네이버페이(포인트)
//    네이버페이(신용카드+포인트)
//    네이버페이(계좌이체+포인트)
    if ($detail->primaryPayMeans == 'CARD') {
        $authCode = $detail->cardAuthNo;
        //$memo = 'Card : ' . $detail->cardNo;
    } else if ($detail->primaryPayMeans == 'BANK') {
        //$memo = 'Bank : ' . $detail->bankAccountNo;
    }

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
        $cancelData->expectedRestAmt = 0;
        $cancelData->logPath = $paymentGatewayModel->getLogPath();
        $response = $paymentGatewayModel->requestCancel($cancelData);
        if ($response['result']) {
            $resultMsg .= "(PG 취소 완료)";
        } else {
            $resultMsg .= "(PG 취소 실패 - " . $response['message'] . ")";
        }
        $paymentGatewayModel->paymentFailGoCart($resultMsg);

        //shop_order 주문번호 상태변경 SR => SO
        $orderModel->setOrderStatus($oid, ORDER_STATUS_SOLDOUT_CANCEL);

        exit;
    }
} else {
    $paymentGatewayModel->paymentFailGoCart($response->message);
}