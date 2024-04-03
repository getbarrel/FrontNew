<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'kcp';

// Load Forbiz View
$view = getForbizView(true);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);
//**********************************************************************************
//가상계좌 모의 입금 페이지 http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti.jsp
//문제발생시 로그는 오류 추적의 중요데이터 이므로 아래 소스를 이용 바랍니다.
//**********************************************************************************
//$logfile = fopen($paymentGatewayModel->getLogPath() . "/vacct_noti_" . date('Ymd') . ".log", "a+");
//fwrite($logfile, "************************************************\r\n");
//fwrite($logfile, "POST     : " . print_r($view->input->post(), true) . "\r\n");
//fclose($logfile);
//**********************************************************************************

/* ============================================================================== */
/* =   01. 공통 통보 페이지 설명(필독!!)                                        = */
/* = -------------------------------------------------------------------------- = */
/* =   공통 통보 페이지에서는,                                                  = */
/* =   가상계좌 입금 통보 데이터를 KCP를 통해 실시간으로 통보 받을 수 있습니다. = */
/* =                                                                            = */
/* =   common_return 페이지는 이러한 통보 데이터를 받기 위한 샘플 페이지        = */
/* =   입니다. 현재의 페이지를 업체에 맞게 수정하신 후, 아래 사항을 참고하셔서  = */
/* =   KCP 관리자 페이지에 등록해 주시기 바랍니다.                              = */
/* =                                                                            = */
/* =   등록 방법은 다음과 같습니다.                                             = */
/* =  - KCP 관리자페이지(admin.kcp.co.kr)에 로그인 합니다.                      = */
/* =  - [쇼핑몰 관리] -> [정보변경] -> [공통 URL 정보] -> [공통 URL 변경 후]에  = */
/* =    결과값은 전송받을 가맹점 URL을 입력합니다.                              = */
/* ============================================================================== */

/* ============================================================================== */
/* =   02. 공통 통보 데이터 받기                                                = */
/* = -------------------------------------------------------------------------- = */
//$site_cd = $view->input->post("site_cd");                 // 사이트 코드
$tno = $view->input->post("tno");                 // KCP 거래번호
$order_no = $view->input->post("order_no");                 // 주문번호
$tx_cd = $view->input->post("tx_cd");                 // 업무처리 구분 코드
//$tx_tm = $view->input->post("tx_tm");                 // 업무처리 완료 시간
/* = -------------------------------------------------------------------------- = */
$ipgm_name = "";                                    // 주문자명
$remitter = "";                                    // 입금자명
$ipgm_mnyx = "";                                    // 입금 금액
$bank_code = "";                                    // 은행코드
$account = "";                                    // 가상계좌 입금계좌번호
$op_cd = "";                                    // 처리구분 코드
$noti_id = "";                                    // 통보 아이디
$cash_a_no = "";                                    // 현금영수증 승인번호
$cash_a_dt = "";                                    // 현금영수증 승인시간
$cash_no = "";                                    // 현금영수증 거래번호
/* = -------------------------------------------------------------------------- = */

/* = -------------------------------------------------------------------------- = */
/* =   02-1. 가상계좌 입금 통보 데이터 받기                                     = */
/* = -------------------------------------------------------------------------- = */
if ($tx_cd == "TX00") {
//    $ipgm_name = $view->input->post("ipgm_name");                // 주문자명
//    $remitter = $view->input->post("remitter");                // 입금자명
    $ipgm_mnyx = $view->input->post("ipgm_mnyx");                // 입금 금액
//    $bank_code = $view->input->post("bank_code");                // 은행코드
//    $account = $view->input->post("account");                // 가상계좌 입금계좌번호
    $op_cd = $view->input->post("op_cd");                // 처리구분 코드
//    $noti_id = $view->input->post("noti_id");                // 통보 아이디
//    $cash_a_no = $view->input->post("cash_a_no");                // 현금영수증 승인번호
//    $cash_a_dt = $view->input->post("cash_a_dt");                // 현금영수증 승인시간
//    $cash_no = $view->input->post("cash_no");                // 현금영수증 거래번호
}
/* = -------------------------------------------------------------------------- = */
/* =   02-2. 가상계좌(에스크로) 입금 통보 데이터 받기                                     = */
/* = -------------------------------------------------------------------------- = */
if ($tx_cd == "TX02") {
    $st_cd		= $view->input->post("st_cd");                // 구매 확인 코드(구매확인 : Y / 구매취소 : N / 시스템 구매확인 : S)
	$can_msg	= $view->input->post("can_msg");              // 구매 취소 사유
}


/* ============================================================================== */
/* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.      = */
/* = -------------------------------------------------------------------------- = */
/* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업에  = */
/* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는     = */
/* =   프로세스가 구성되어 있습니다.                                            = */
/* =                                                                            = */
/* =   * DB update가 정상적으로 완료된 경우                                     = */
/* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000으로     = */
/* =   설정해 주시기 바랍니다.                                                  = */
/* =                                                                            = */
/* =   * DB update가 실패한 경우                                                = */
/* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000이외의   = */
/* =   값으로 설정해 주시기 바랍니다.                                           = */
/* = -------------------------------------------------------------------------- = */


$tid = $tno;
$oid = $order_no;
$amt = $ipgm_mnyx;

//KCP 방화벽 체크
if (!in_array($view->input->server('REMOTE_ADDR'), ['210.122.73.58', '203.238.36.173', '103.215.144.173', '203.238.36.178', '103.215.144.174'])) {
    exit;
}

/* = -------------------------------------------------------------------------- = */
/* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분                        = */
/* = -------------------------------------------------------------------------- = */
$dbSuccess = false;
if ($tx_cd == "TX00") {
    //해당 변수를 통해서 가상계좌 상태 구분을 반드시 해주시기 바랍니다.‘13’을 제외한 모든 건은 입금 건으로 처리 하시기 바랍니다. op_cd =‘13’은 입금이 잘못 된 경우로 가맹점에 취소 노티가 나갑니다.
    if ($op_cd != '13' && !empty($oid)) {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $view->import('model.mall.order');
		$orderPaymentData = $orderModel->getPaymentInfo($oid);

        $payment = [
            'tid' => $tid
        ];

        //$depositResult = $orderModel->deposit($oid, ORDER_METHOD_VBANK, $amt, $payment);
		$depositResult = $orderModel->deposit($oid, $orderPaymentData[0]['method'], $amt, $payment); // ORDER_METHOD_ASCROW
		
        if ($depositResult['result']) {
            //가상계좌 입금확인 이메일 보내기
            $view->event->trigger('depositSucessVbank', ['oid' => $oid]);
            $dbSuccess = true;
        }
    }
} 
if ($tx_cd == "TX02") {
	if ($st_cd == "N") {
		$orderModel = $view->import('model.mall.order');

		$orderDateil = $orderModel->getOrderProduct($oid);

		$odIxs = array_column($orderDateil, 'pcnt', 'od_ix');

		$c = 1;
		foreach ($odIxs as $key => $val) {
			if ($c == count($odIxs)){
				$claimReasonMsg[$key] = 'KCP에서 고객 구매취소 요청';
			}
			$c++;
		}

		$claimDeliveryPrice = $view->getFlashData('claimDeliveryPrice'); //환불완료 처리시 필요한 클레임 배송비

		$cancelledNewOdIxs = $orderModel->updateCancelComplete($oid, $odIxs, $claimDeliveryPrice, 'NB', $claimReasonMsg);
	}
	$dbSuccess = true;
}
/* ============================================================================== */

/* ============================================================================== */
/* =   04. result 값 세팅 하기                                                  = */
/* ============================================================================== */
?>
<html>
<body>
<form><input type="hidden" name="result" value="<?php echo($dbSuccess ? "0000" : "9999") ?>"></form>
</body>
</html>