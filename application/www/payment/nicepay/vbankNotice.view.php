<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$pgName = 'nicepay';

// Load Forbiz View
$view = getForbizView(true);

/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$paymentGatewayModel->init($pgName);
//**********************************************************************************
//문제발생시 로그는 오류 추적의 중요데이터 이므로 아래 소스를 이용 바랍니다.
//**********************************************************************************
//$logfile = fopen($paymentGatewayModel->getLogPath() . "/vacct_noti_" . date('Ymd') . ".log", "a+");
//fwrite($logfile, "************************************************\r\n");
//fwrite($logfile, "POST     : " . print_r($view->input->post(), true) . "\r\n");
//fclose($logfile);

//'**********************************************************************************
//' 구매자가 입금하면 결제데이터 통보를 수신하여 DB 처리 하는 부분 입니다.
//' 수신되는 필드에 대한 DB 작업을 수행하십시오.
//' 수신필드 자세한 내용은 메뉴얼 참조
//'**********************************************************************************
$PayMethod = $view->input->post('PayMethod');           //지불수단
//$M_ID = $MID;                 //상점ID
//$MallUserID = $MallUserID;          //회원사 ID
$Amt = $view->input->post('Amt');                 //금액
//$name = $name;                //구매자명
//$GoodsName = $GoodsName;           //상품명
$TID = $view->input->post('TID');                 //거래번호
$MOID = $view->input->post('MOID');                //주문번호
//$AuthDate = $AuthDate;            //입금일시 (yyMMddHHmmss)
$ResultCode = $view->input->post('ResultCode');          //결과코드 ('4110' 경우 입금통보)
//$ResultMsg = $ResultMsg;           //결과메시지
//$VbankNum = $VbankNum;            //가상계좌번호
//$FnCd = $FnCd;                //가상계좌 은행코드
//$VbankName = $VbankName;           //가상계좌 은행명
//$VbankInputName = $VbankInputName;      //입금자 명
//가상계좌채번시 현금영수증 자동발급신청이 되었을경우 전달되며 
//RcptTID 에 값이 있는경우만 발급처리 됨
//$RcptTID = $RcptTID;             //현금영수증 거래번호
//$RcptType = $RcptType;            //현금 영수증 구분(0:미발행, 1:소득공제용, 2:지출증빙용)
//$RcptAuthCode = $RcptAuthCode;        //현금영수증 승인번호

//나이스 방화벽 체크
if (in_array($view->input->server('REMOTE_ADDR'), ['121.133.126.10', '121.133.126.11', '211.33.136.39'])) {
    if ($PayMethod == 'VBANK' && !empty($MOID) && $ResultCode == "4110") {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $view->import('model.mall.order');

        $tid = $TID;
        $oid = $MOID;
        $amt = $Amt;

        //가맹점 DB처리
        $payment = [
            'tid' => $tid
        ];

        $depositResult = $orderModel->deposit($oid, ORDER_METHOD_VBANK, $amt, $payment);
        //**************************************************************************************************
        //결제 데이터 통보 설정 > “OK” 체크박스에 체크한 경우" 만 처리 하시기 바랍니다.
        //**************************************************************************************************
        //TCP인 경우 OK 문자열 뒤에 라인피드 추가
        //위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 NICEPAY로
        //리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
        //(주의) OK를 리턴하지 않으시면 NICEPAY 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
        //기타 다른 형태의 PRINT(out.print)는 하지 않으시기 바랍니다
        if ($depositResult['result']) {
            //가상계좌 입금확인 이메일 보내기
            $view->event->trigger('depositSucessVbank', ['oid' => $oid]);
            echo "OK";                        // 절대로 지우지마세요
        } else {
            echo "FAIL";                        // 절대로 지우지마세요
        }
    }
}
