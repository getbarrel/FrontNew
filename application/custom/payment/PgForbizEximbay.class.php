<?php

/**
 * Description of PgForbizEximbay
 * @author Hong
 */
class PgForbizEximbay extends PgForbiz
{
    /**
     * 가맹점 아이디
     * @var type
     */
    private $mid;

    /**
     * 가맹점 secretkey
     * @var type
     */
    private $secretKey;
    /**
     * 서비스 도메인
     * @var
     */
    private $serviceDomain;

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        //글로벌 관련 고려가 안되어 있어서 설정은 우선 하드코딩으로 진행
        if (ForbizConfig::getMallConfig('eximbay_service_type') == 'service') {
            $this->mid = ForbizConfig::getMallConfig('eximbay_mid');
            $this->secretKey = ForbizConfig::getMallConfig('eximbay_secret_key');
            $this->serviceDomain = 'https://secureapi.eximbay.com';
        } else {
            $this->mid = '1849705C64';
            $this->secretKey = '289F40E6640124B2628640168C3C5464';
            $this->serviceDomain = 'https://secureapi.test.eximbay.com';
        }
    }

    public function getPaymentIncludeJavaScript(): string
    {
        return "";
    }

    public function getPaymentRequestJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return implode('', [
                "window.open('','popupEximbay', 'top=100, left=300, width=415px, height=605px, resizble=no, scrollbars=yes');"
                , "var form = document.paymentGatewayForm;"
                , "form.target = 'popupEximbay';"
                , "form.action = '/payment/eximbay/popup?url=" . $this->serviceDomain . "/Gateway/BasicProcessor.krp';"
                , "form.submit()"
            ]);
        } else {
            return implode('', [
                'var form = document.paymentGatewayForm;'
                , 'form.action = "' . $this->serviceDomain . '/Gateway/BasicProcessor.krp";'
                , "form.submit()"
            ]);
        }
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $data = [];

        //필수 정보
        $data['ver'] = '230'; //연동 버전
        $data['txntype'] = 'PAYMENT'; //거래 타입
        $data['charset'] = 'UTF-8'; //기본값은 UTF-8
        $data['cur'] = 'USD'; //통화 USD
        $data['lang'] = 'EN'; //KR Korean, EN English, CN Chinese (simplified Chinese character), JP Japanese, RU Russian, TH Thai, TW Chinese (Traditional Chinese Characters)
//        $data['paymethod'] = ''; //결제 수단코드
//        $data['shop'] = ''; //상점명(가맹점명과 다른 경우 사용)
        $data['mid'] = $this->mid; //Eximbay에서 할당한 가맹점 아이디
        $data['statusurl'] = HTTP_PROTOCOL . FORBIZ_HOST . '/payment/eximbay/noti'; //결제 처리가 끝나면 Backend로 호출되는 가맹점 페이지로 returnurl와 파라미터가 동일함. 브라우져에서 호출되지 않으므로, 스크립트, 쿠키, 세션사용 불가.
        $data['autoclose'] = 'Y'; //완료 화면에서 성공/실패와 무관하게‘Y’ : 바로 returnurl을 호출‘N’ : 완료 화면 표시(기본값)
//        $data['issuercountry'] = ''; //KR : 한국결제수단 (국내발급카드, TOSS, BankPay 사용시 필수.) 그 외는 해외결제수단 표시
//        $data['siteforeigncur'] = ''; //가맹점 사이트의 고객 선택통화로 결제창 첫 화면에 표시를 원하는 경우 사용.
        if ($this->agentType == 'W') {
            $data['ostype'] = 'P'; //P : pc version(기본값), M : mobile
            $data['displaytype'] = 'P'; //P : popup(기본값) R : page redirect
            $data['returnurl'] = HTTP_PROTOCOL . FORBIZ_HOST . '/payment/eximbay/popupResult'; //결제 결과 확인화면에서 사용자가 결제창을 종료 할 경우 호출되는 가맹점 페이지
        } else {
            $data['ostype'] = 'M'; //P : pc version(기본값), M : mobile
            $data['displaytype'] = 'R'; //P : popup(기본값) R : page redirect
            $data['returnurl'] = HTTP_PROTOCOL . FORBIZ_HOST . '/payment/eximbay/result'; //결제 결과 확인화면에서 사용자가 결제창을 종료 할 경우 호출되는 가맹점 페이지
        }

        //주문정보
        $data['ref'] = $paymentData->oid; //가맹점에서 Transaction을 구분할 유일한 값으로 거래 실패 시에도 새로운 값으로 셋팅 요망
        $data['amt'] = $paymentData->amt; //결제할 총 금액
        $data['buyer'] = $paymentData->buyerName; //결제자 명 (실명 사용 요망)
        $data['tel'] = $paymentData->buyerMobile; //결제자 연락처
        $data['email'] = $paymentData->buyerEmail; //결제자 이메일 주소(결제완료 메일 발송 용도)
//        $data['param1'] = ''; //가맹점 정의 파라미터1
//        $data['param2'] = ''; //가맹점 정의 파라미터2
//        $data['param3'] = ''; //가맹점 정의 파라미터3
//        $data['partnercode'] = ''; //파트너코드 (KRP에서 할당)
        $data['item_0_product'] = str_replace(array("&#39;","&#039;"),"'",$paymentData->goodsName); //주문 상품의 상품명
        $data['item_0_quantity'] = 1; //주문 상품의 상품별 수량 (반드시 1이상 이어야함)
        $data['item_0_unitPrice'] = $paymentData->amt; //주문 상품의 상품별 단가 (‘,’ 포함불가, 반드시 0보다 커야 함)
//        $data['surcharge_0_name'] = ''; //추가항목 명 (e.g. 할인(-), 배송비(+) 등)
//        $data['surcharge_0_quantity'] = ''; //추가항목 수량 (반드시 1이상 이어야 함)
//        $data['surcharge_0_unitPrice'] = ''; //추가항목 할인 단가 (‘,’ 포함불가, 음수 가능) (e.g. -1000.50, 9.15)
        $data['shipTo_city'] = ""; //(배송지)도시 (예. Hanoi, Brisbane, Houston)
        $data['shipTo_country'] = ""; //(배송지)국가. ISO3166 country code (예. KR, US..)
        $data['shipTo_firstName'] = ""; //(배송지)수신자 명
        $data['shipTo_lastName'] = ""; //(배송지)수신자 명
        $data['shipTo_phoneNumber'] = ""; //(배송지)수신자 연락처(국가번호 포함)
        $data['shipTo_postalCode'] = ""; //(배송지)우편번호
        $data['shipTo_state'] = ""; //(배송지)주. US or CA만 사용. (예. MA, NY, CA) (Appendix E 참고)
        $data['shipTo_street1'] = ""; //(배송지)상세주소 (예. 123 Main street, 56 Le Loistreet)
//        $data['billTo_city'] = ""; //(청구지)도시 (예. Hanoi, Brisbane, Houston)
//        $data['billTo_country'] = ""; //(청구지)국가. ISO3166 country code (예. KR, US..)
//        $data['billTo_firstName'] = ""; //(청구지)카드 명의자 명
//        $data['billTo_lastName'] = ""; //(청구지)카드 명의자 명
//        $data['billTo_phoneNumber'] = ""; //(청구지)카드 명의자 연락처(국가번호 포함)
//        $data['billTo_postalCode'] = ""; //(청구지)우편번호
//        $data['billTo_state'] = ""; //(청구지)주. US or CA만 사용. (예. MA, NY, CA) (Appendix E 참고)
//        $data['billTo_street1'] = ""; //(청구지)상세주소 (예. 123 Main street, 56 Le Loistreet)
        $data['fgkey'] = $this->getFgkey($data); //검증키

        return $data;
    }

    public function doApply($data)
    {
        //엑심 베이는 txntype = PAYMENT 통보만 하는 케이스라 승인이 필요 없음
        return;
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        $data = [];

        //필수 정보
        $data['ver'] = '230'; //연동 버전
        $data['txntype'] = 'REFUND'; //거래 타입
        $data['charset'] = 'UTF-8'; //기본값은 UTF-8
        $data['cur'] = 'USD'; //통화 USD
        $data['mid'] = $this->mid; //Eximbay에서 할당한 가맹점 아이디
        $data['lang'] = 'EN'; //KR Korean, EN English, CN Chinese (simplified Chinese character), JP Japanese, RU Russian, TH Thai, TW Chinese (Traditional Chinese Characters)

        //취소정보
        $data['refundtype'] = $cancelData->isPartial ? 'P' : 'F'; //“F” : Fully, “P” : Partial
        $data['ref'] = $cancelData->oid; //원 승인 거래 ref
        $data['amt'] = $cancelData->originAmt; //원 승인 거래 금액 (e.g. 1000.50, 9.15)
        $data['refundamt'] = $cancelData->amt; //환불 요청 금액 원 승인 거래 금액을 초과할 수 없습니다.
        $data['balance'] = $cancelData->amt + $cancelData->expectedRestAmt; //“원 승인 금액 – 합(환불금액)”으로 환불 가능 금액 가맹점과 Eximbay간 환불 거래 불일치를 방지하기 위해 사용. 값이 있는 경우만 체크합니다.
        $data['transid'] = $cancelData->tid; //승인 거래의 결제사 거래 아이디
        $data['refundid'] = str_replace("-", "", $cancelData->oid) . time(); //환불 요청에 대한 유일한 값으로 가맹점에서 생성. 모든 요청데이터의 refundid는 Unique 해야 합니다
        $data['reason'] = $cancelData->message; //환불사유
//        $data['param1'] = ''; //가맹점 정의 파라미터1
//        $data['param2'] = ''; //가맹점 정의 파라미터2
//        $data['param3'] = ''; //가맹점 정의 파라미터3
        $data['fgkey'] = $this->getFgkey($data); //검증키

        $response = $this->callApi($this->serviceDomain . '/Gateway/DirectProcessor.krp', $data);

        if ($response['rescode'] == '0000') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = $response['resmsg'];
        }
        return $responseData;
    }

    public function getFgkey($data)
    {
        ksort($data);
        $linkBuf = $this->secretKey . "?";
        $linkBufData = [];
        foreach ($data as $key => $val) {
            $linkBufData[] = $key . "=" . $val;
        }
        $linkBuf .= implode('&', $linkBufData);
        return hash("sha256", $linkBuf);
    }

    public function getPaymethod($paymethod)
    {
        $data = [];

        $data['P000'] = 'CreditCard';
        $data['P101'] = 'VISA';
        $data['P102'] = 'MasterCard';
        $data['P103'] = 'AMEX';
        $data['P104'] = 'JCB';
        $data['P105'] = 'UnionPay 비인증';
        $data['P110'] = 'BC카드';
        $data['P111'] = 'KB카드';
        $data['P112'] = '하나카드(구 외환)';
        $data['P113'] = '삼성카드';
        $data['P114'] = '신한카드';
        $data['P115'] = '현대카드';
        $data['P116'] = '롯데카드';
        $data['P117'] = '농협카드';
        $data['P118'] = '하나카드(구 SK)';
        $data['P119'] = '씨티카드';
        $data['P120'] = '우리카드';
        $data['P121'] = '수협카드';
        $data['P122'] = '제주카드';
        $data['P123'] = '전북카드';
        $data['P124'] = '광주카드';
        $data['P125'] = '카카오뱅크';
        $data['P126'] = '케이뱅크';
        $data['P127'] = '미래에셋대우';
        $data['P128'] = '코나카드';
        $data['P001'] = 'PayPal';
        $data['P002'] = 'CUP (UnionPay)';
        $data['P003'] = 'Alipay';
        $data['P141'] = 'WeChat (PC)';
        $data['P142'] = 'WeChat (Mobile)';
        $data['P143'] = 'WeChat (OA)';
        $data['P006'] = '일본 편의점, 인터넷뱅킹 결제';
        $data['P007'] = 'Molpay';
        $data['P171'] = 'Molpay (말레이시아)';
        $data['P172'] = 'Molpay (베트남)';
        $data['P173'] = 'Molpay (태국)';
        $data['P010'] = 'BestPay';
        $data['P301'] = 'BankPay';
        $data['P303'] = 'TOSS';
        $data['P011'] = 'Yandex';

        return $data[$paymethod] ?? $paymethod;
    }

    private function callApi($url, $data)
    {
        $curl = new Curl\Curl();

        $curl->post($url, $data);

        $return = [];
        parse_str($curl->response, $return);
        return $return;
    }
}