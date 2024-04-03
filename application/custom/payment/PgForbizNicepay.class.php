<?php

/**
 * Description of PgForbizNicepay
 *
 * @author Hong
 */
class PgForbizNicepay extends PgForbiz
{

    /**
     * 가맹점 ID
     * @var type
     */
    private $mid;

    /**
     * 가맹점 KEY
     * @var type
     */
    private $serviceKey;

    /**
     * 가맹점 취소 비밀번호
     * @var type
     */
    private $cancelPassword;

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        if (ForbizConfig::getPaymentConfig('service_type', 'nicepay') == 'service') {
            $this->mid = ForbizConfig::getPaymentConfig('mid', 'nicepay');
            $this->serviceKey = ForbizConfig::getPaymentConfig('service_key', 'nicepay');
            $this->cancelPassword = ForbizConfig::getPaymentConfig('cancel_pwd', 'nicepay');
        } else {
            $this->mid = 'nicepay00m';
            $this->serviceKey = 'EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg==';
            $this->cancelPassword = "123456";
        }
    }

    /**
     * get 가맹점 KEY
     * @return string
     */
    public function getServiceKey()
    {
        return $this->serviceKey;
    }

    public function getPaymentIncludeJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return implode('', [
                "<script type='text/javascript' src='https://web.nicepay.co.kr/flex/js/nicepay_tr_utf.js'></script>"
                , '<script>'
                , 'function nicepaySubmit(){'
                , 'document.paymentGatewayForm.submit();'
                , '}'
                , 'function nicepayClose(){'
                , 'alert("결제가 취소 되었습니다");'
                , '}'
                , '</script>'
            ]);
        } else {
            return '';
        }
    }

    public function getPaymentRequestJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return implode('', [
                'document.paymentGatewayForm.action="/payment/nicepay/result";'
                , 'goPay(document.paymentGatewayForm);'
            ]);
        } else {
            return implode('', [
                'document.charset = "euc-kr";'
                , 'document.paymentGatewayForm.acceptCharset="euc-kr";'
                , 'document.paymentGatewayForm.action="https://web.nicepay.co.kr/smart/paySmart.jsp";'
                , 'document.paymentGatewayForm.submit();'
            ]);
        }
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $data = [];

        $payco = false;
        $kakao = false;
        $payMethod = '';
        // 메소드 페이코와 카카오페이는 별도취급.. 기본은 리턴값 그대로 넣음
        if ($paymentData->method == ORDER_METHOD_PAYCO) {
            $payMethod = "CARD";
            $payco = true;
        } else if ($paymentData->method == ORDER_METHOD_KAKAOPAY) {
            $payMethod = "CARD";
            $kakao = true;
        } else {
            $payMethod = $this->getPayMethod($paymentData->method);
        }

        /* PG사 필수 요청 정보 [S] */
        $data['PayMethod'] = $payMethod; //결제수단 필수 10 byte
        $data['GoodsCnt'] = $paymentData->goodsCount; //결제상품개수 필수 2 byte 디폴트 값 1로 세팅
        $data['GoodsName'] = mb_strcut($paymentData->goodsName, 0, 39, "UTF-8"); //결제상품명 필수 40 byte
        $data['Amt'] = $paymentData->amt; //결제상품금액 필수 12 byte, 반드시 숫자로만 입력
        $data['MID'] = $this->mid; //상점아이디 필수 10 byte
        $data['BuyerName'] = $paymentData->buyerName; //구매자명 필수 30 byte
        $data['BuyerTel'] = $paymentData->buyerMobile; //구매자연락처 필수 40 byte-없이 입력
        $data['UserIP'] = $this->input->server('REMOTE_ADDR'); //회원사고객IP 필수 20 byte
        $data['MallIP'] = $this->input->server('SERVER_ADDR'); //상점서버IP 필수 20 byte
        $data['SocketYN'] = "Y"; //소켓이용유무 필수 Y로 사용
        $data['EdiDate'] = date("YmdHis"); //전문 생성 일시 필수 14 byte
        $data['EncryptData'] = bin2hex(hash('sha256', $data['EdiDate'] . $this->mid . $data['Amt'] . $this->serviceKey, true)); //해쉬 값 필수 100 byte 변경 불가
        $data['EncodeParameters'] = "CardNo,CardExpire,CardPwd"; //암호화대상항목 필수 고정값
        if ($this->agentType != 'W') {
            $data['CharSet'] = "utf-8"; //인코딩 설정
            $data['ReturnURL'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/nicepay/result"; //Return URL
        }
        /* PG사 필수 요청 정보 [E] */

        /* PG사 추가 요청 정보 [S] */
        $data['GoodsCl'] = "1"; //상품구분 핸드폰 결제인 경우 필수
        $data['Moid'] = $paymentData->oid; //상품주문번호 64 byte
        $data['BuyerAuthNum'] = ""; //구매자인증번호 13 byte, 주민번호 또는 사업자번호
        $data['BuyerEmail'] = $paymentData->buyerEmail; //구매자메일주소 60 byte
        $data['ParentEmail'] = ""; //보호자메일주소 60 byte
        $data['BuyerAddr'] = ""; //배송지주소 100 byte
        $data['BuyerPostNo'] = ""; //우편번호 6 byte
        $data['SUB_ID'] = ""; //서브몰 아이디
        $data['MallUserID'] = $paymentData->buyerId; //회원사고객아이디 20 byte
        $data['VbankExpDate'] = $paymentData->vbankExpirationDate; //가상계좌입금만료일 8자리 또는 12자리(ex :20110225)
        $data['TransType'] = 0; //일반(0)/에스크로(1)
        /* PG사 추가 요청 정보 [E] */

        /* PAYCO 사용시 추가 파라메터         */
        if ($payco) {
            $data['DirectShowOpt'] = 'CARD'; //다이렉트 옵션
            $data['NicepayReserved'] = 'DirectPayco=Y'; //복합옵션
        } else if ($kakao) {
            $data['DirectShowOpt'] = 'CARD'; //다이렉트 옵션
            $data['NicepayReserved'] = 'DirectKakao=Y'; //복합옵션
        }
        return $data;
    }

    public function doApply($data)
    {
        $this->loadRequireList();

        /*
         * ******************************************************
         * <결제 결과 설정>
         * 사용전 결과 옵션을 사용자 환경에 맞도록 변경하세요.
         * 로그 디렉토리는 꼭 변경하세요.
         * ******************************************************
         */
        $nicepayWEB = new NicePayWEB();
        $httpRequestWrapper = new NicePayHttpServletRequestWrapper($data);
        $_REQUEST = $httpRequestWrapper->getHttpRequestMap();

        $payMethod = $_REQUEST['PayMethod'];

        $nicepayWEB->setParam("NICEPAY_LOG_HOME", $data['logPath']);             // 로그 디렉토리 설정
        $nicepayWEB->setParam("APP_LOG", "1");                           // 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
        $nicepayWEB->setParam("EncFlag", "S");                           // 암호화플래그 설정(N: 평문, S:암호화)
        $nicepayWEB->setParam("SERVICE_MODE", "PY0");                   // 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
        $nicepayWEB->setParam("Currency", "KRW");                       // 통화 설정(현재 KRW(원화) 가능)
        $nicepayWEB->setParam("CHARSET", "UTF8");                       // 인코딩
        $nicepayWEB->setParam("PayMethod", $payMethod);                  // 결제방법
        $nicepayWEB->setParam("LicenseKey", $this->serviceKey);               // 상점키

        return $nicepayWEB->doService($_REQUEST);
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        $this->loadRequireList();

        $requestData = [
            'MID' => $this->mid
            , 'TID' => $cancelData->tid
            , 'CancelAmt' => $cancelData->amt
            , 'CancelMsg' => $cancelData->message
            , 'CancelPwd' => $this->cancelPassword
            , 'PartialCancelCode' => ($cancelData->isPartial ? "1" : "0")
            , 'Moid' => $cancelData->oid
        ];

        $httpRequestWrapper = new NicePayHttpServletRequestWrapper($requestData);
        $_REQUEST = $httpRequestWrapper->getHttpRequestMap();
        $nicepayWEB = new NicePayWEB();

        $nicepayWEB->setParam("NICEPAY_LOG_HOME", $cancelData->logPath);             // 로그 디렉토리 설정
        $nicepayWEB->setParam("APP_LOG", "1");                           // 이벤트로그 모드 설정(0: DISABLE, 1: ENABLE)
        $nicepayWEB->setParam("EVENT_LOG", "1");                         // 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
        $nicepayWEB->setParam("EncFlag", "S");                           // 암호화플래그 설정(N: 평문, S:암호화)
        $nicepayWEB->setParam("SERVICE_MODE", "CL0");                   // 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
        $nicepayWEB->setParam("CHARSET", "UTF8");                       // 인코딩

        /*
         * ******************************************************
         * <취소 결과 필드>
         * ******************************************************
         */
        $responseDTO = $nicepayWEB->doService($_REQUEST);
        $resultCode = $responseDTO->getParameter("ResultCode");        // 결과코드 (취소성공: 2001, 취소성공(LGU 계좌이체):2211)
        $resultMsg = $responseDTO->getParameterUTF("ResultMsg");      // 결과메시지
        $cancelAmt = $responseDTO->getParameter("CancelAmt");         // 취소금액
        $cancelDate = $responseDTO->getParameter("CancelDate");        // 취소일
        $cancelTime = $responseDTO->getParameter("CancelTime");        // 취소시간
        $cancelNum = $responseDTO->getParameter("CancelNum");         // 취소번호
        $payMethod = $responseDTO->getParameter("PayMethod");         // 취소 결제수단
        $mid = $responseDTO->getParameter("MID");               // 상점 ID
        $tid = $responseDTO->getParameter("TID");               // 거래아이디 TID

        $resultCode = trim($resultCode);

        if ($resultCode == '2001' || $resultCode == '2211') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = trim($resultMsg);
        }
        return $responseData;
    }

    private function getPayMethod($method)
    {
        switch ($method) {
            case ORDER_METHOD_CARD: //신용카드
                $payMethod = 'CARD';
                break;
            case ORDER_METHOD_ICHE: //실시간계좌이체
                $payMethod = 'BANK';
                break;
            case ORDER_METHOD_VBANK: //무통장입금(가상계좌)
                $payMethod = 'VBANK';
                break;
            case ORDER_METHOD_PHONE: //핸드폰
                $paymethod = 'CELLPHONE';
                break;
        }

        return $payMethod;
    }

    private function loadRequireList()
    {
        require_once CUSTOM_ROOT . '/payment/nicepay/lib/nicepay/web/NicePayWEB.php';
        require_once CUSTOM_ROOT . '/payment/nicepay/lib/nicepay/core/Constants.php';
        require_once CUSTOM_ROOT . '/payment/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php';
    }
}
