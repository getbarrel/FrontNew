<?php

/**
 * Description of PgForbizInicis
 *
 * @author Lee
 * INIpay Standard 버전
 * 이니시스 로그는 homePath 에 log 에 남겨짐. 변경 불가함
 */
class PgForbizInicis extends PgForbiz
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

    /**
     * 가맹점 표준결제 스크립트 URL
     * @var type
     */
    private $payScriptUrl;

    /**
     * 모듈 경로
     * @var text
     */
    private $homePath;

    /**
     * PC 결제 방식 맵핑 정보
     * @var array
     */
    private $methodMapping = [
        ORDER_METHOD_CARD => 'Card'
        , ORDER_METHOD_PAYCO => 'onlypayco'
        , ORDER_METHOD_KAKAOPAY => 'onlykakaopay'
        , ORDER_METHOD_SSPAY => 'onlyssp'
        , ORDER_METHOD_ICHE => 'DirectBank'
        , ORDER_METHOD_VBANK => 'VBank'
        , ORDER_METHOD_PHONE => 'HPP'
        , ORDER_METHOD_ASCROW => 'DirectBank'
    ];

    /**
     * 모바일 결제 방식 맵핑 정보
     * @var array
     */
    private $methodMobileMapping = [
        ORDER_METHOD_CARD => 'wcard'
        , ORDER_METHOD_PAYCO => 'wcard'
        , ORDER_METHOD_KAKAOPAY => 'wcard'
        , ORDER_METHOD_SSPAY => 'wcard'
        , ORDER_METHOD_ICHE => 'bank'
        , ORDER_METHOD_VBANK => 'vbank'
        , ORDER_METHOD_PHONE => 'mobile'
        , ORDER_METHOD_ASCROW => 'bank'
    ];

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        $this->homePath = __DIR__ . '/inicis';

        if (ForbizConfig::getPaymentConfig('service_type', 'inicis') == 'service') {
            $this->mid = ForbizConfig::getPaymentConfig('mid', 'inicis');
            $this->serviceKey = ForbizConfig::getPaymentConfig('service_key', 'inicis');
            $this->payScriptUrl = 'https://stdpay.inicis.com/stdjs/INIStdPay.js';
            $this->cancelPassword = ForbizConfig::getPaymentConfig('cancel_pwd', 'inicis');
        } else {
            $this->mid = 'INIpayTest';
            $this->serviceKey = 'SU5JTElURV9UUklQTEVERVNfS0VZU1RS';
            $this->payScriptUrl = 'https://stgstdpay.inicis.com/stdjs/INIStdPay.js';
            $this->cancelPassword = "1111";
        }
    }

    public function getPaymentIncludeJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return "<script language='javascript' type='text/javascript' charset='UTF-8' src='" . $this->payScriptUrl . "'></script>";
        } else {
            return '';
        }
    }

    public function getPaymentRequestJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return "INIStdPay.pay('paymentGatewayForm');";
        } else {
            return implode('', [
                'var form = document.paymentGatewayForm;'
                , 'var paymethod = form.paymethod.value;'
                , '$(form).attr("accept-charset","EUC-KR");'
                , 'form.action = "https://mobile.inicis.com/smart/" + paymethod + "/";'
                , 'form.submit();'
            ]);
        }
    }

    /** 결제 요청 */
    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $data = [];

        require_once __DIR__ . '/inicis/libs/INIStdPayUtil.php';
        $SignatureUtil = new INIStdPayUtil();

        if ($this->agentType == 'W') {
            //PG사 필수 정보
            $data['version'] = '1.0';        // 전문버전
            $data['currency'] = 'WON';        // 통화구분
            $data['charset'] = "UTF-8"; //인코딩 설정
            $data['timestamp'] = $SignatureUtil->getTimestamp();  //TimeInMillis(Long형) 20byte 필수
            $data['mKey'] = $SignatureUtil->makeHash($this->serviceKey, "sha256"); //TimeInMillis(Long형) 20byte 필수
            $data['signature'] = $SignatureUtil->makeSignature([
                "oid" => $paymentData->oid,
                "price" => $paymentData->amt,
                "timestamp" => $data['timestamp']
            ], "sha256"); //위변조 방지 SHA256 Hash 값 64byte 필수
            $data['mid'] = $this->mid;   // 상점아이디
//            $data['languageView'] = 'ko'; //결제창 표시 언어 ko:한국어, en:영어
            $data['returnUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/inicis/result"; //Return URL
            $data['closeUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/inicis/close"; //결제창 닫기처리 close URL
//            $data['popupUrl'] = ""; //팝업처리 URL
            $data['gopaymethod'] = $this->getPayMethod($paymentData->method); //요청결제수단
            $data['acceptmethod'] = ''; //결제수단별 추가 옵션값
            if ($paymentData->method == ORDER_METHOD_PAYCO) {
                $data['acceptmethod'] = "cardonly:below1000";
            } else if ($paymentData->method == ORDER_METHOD_SSPAY) {
                $data['acceptmethod'] = "cardonly:below1000";
            } else if ($paymentData->method == ORDER_METHOD_KAKAOPAY) {
                $data['acceptmethod'] = "cardonly:below1000";
            } else if ($paymentData->method == ORDER_METHOD_ASCROW) {
                $data['acceptmethod'] = "VERIFY:SELF:no_receipt:useescrow";
            } else if ($paymentData->method == ORDER_METHOD_VBANK) {
                //vbank 입금기한및 입금시간 “vbank(20150416)”입금기한 및 입금 시간 설정 옵션
                //va_receipt 현금영수증발급 UI 옵션 “va_receipt” 현금영수증 발급 UI 표시 옵션 (CASHRECEIPT 옵션이기준정보에 있는 경우) – 주민번호만 표시
                //va_ckprice 주민번호 채번 시 금액 확인 “va_ckprice”주민번호 채번시 금액 체크 기능
                $data['acceptmethod'] = 'vbank(' . $paymentData->vbankExpirationDate . ')';
            } else if ($paymentData->method == ORDER_METHOD_CARD) {
                //below1000 1000원이하결제“below1000” 기본적으로 1000원이하 결제 불가능
                //mallpoint 몰포인트“mallpoint(14:03)” 상점에서 따로 카드사와 포인트 계약을 맺은 경우에 대한 처리이다. ':' 구분자로 카드코드를 구분한다.
                //ini_onlycardcode 결제 카드사 선택“1:2:3:4:6” 생략 시 결제 가능한 모든 카드사 표시
                //CARDPOINT 카드포인트 사용유무“cardpoint”포인트를 사용하는 카드를 선택시 신용카드 메인 화면에 카드포인트를 사용할지에 대한 선택창이 표시된다
                //OCB OCB사용유무“ocb” 카드메인 화면에 OCB 적립을 위한 카드번호 창이 표시된다. 기준정보에서 OCB 옵션을 받은 경우에만 정상 동작한다. OK Cashbag 포인트 적립을 가능하도록 체크박스가 나타난다.
                //SLIMQUOTA 부분무이자 설정“SLIMQUOTA (14:03)” 슬림할부를 지정한다. SLIMQUOTA(코드-개월:개월) 로 사용한다. '^' 구분자로 카드코드를 구분한다.
                //PAYPOPUP 안심클릭뷰옵션 “PAYPOPUP”안심클릭을 Popup 형태로 서비스를 제공한다. Edge의 경우 자동 설정됩니다
                //hidebar 프로그래스바뷰옵션 “hidebar” 결제진행시 노출되는 프로그래스 바를 안보이도록 설정된다.
                //useescrow 신에스크로사용여부 “useescrow”“신에스크로 약관동의” 와 “구매자 본인확인” 페이지가 포함된 신에스크로 결제창을 호출 합니다.
                $data['acceptmethod'] = 'below1000';
            } else if ($paymentData->method == ORDER_METHOD_ICHE) {
                //no_receipt 현금영수증 미발행 “no_receipt”현금영수증 발행 차단 옵션 계좌이체 시 사용하는 현금영수증 미발행 여부 확인 필드 – 옵션을 사용시 현금 영수증 UI 출력하지 않음
            } else if ($paymentData->method == ORDER_METHOD_ICHE) {
                //HPP 휴대폰 결제 상품 유형 ”HPP(1)”[1:컨텐츠,2:실물] 휴대폰 결제 상품 유형
                $data['acceptmethod'] = 'HPP(2)';
            }

            //주문정보
            $data['oid'] = $paymentData->oid;  //상품주문번호 64 byte
            $data['goodname'] = mb_strcut($paymentData->goodsName, 0, 39, "UTF-8");  //상품명
            $data['price'] = $paymentData->amt;  //결제금액
//            $data['tax'] = ''; //부가세 대상: 부가세업체정함’ 설정업체에 한함 주의: 전체금액의 10%이하로 설정 가맹점에서 등록시 VAT가 총 상품가격의 10% 초과할 경우는 거절됨  가맹점에서 등록시 VAT가 총상품가격의 10% 초과할 경우는 거절됨
//            $data['taxfree'] = ''; //비과세 대상: ‘부가세업체정함’ 설정업체에 한함 과세되지 않는 금액
            $data['buyername'] = $paymentData->buyerName;        // 구매자명
            $data['buyertel'] = $paymentData->buyerMobile; //구매자Mobile번호 숫자와 "-"만 허용
            $data['buyeremail'] = $paymentData->buyerEmail; //구매자Email
//            $data['parentemail'] = ""; //보호자메일주소 60 byte 14세 미만 필수
//            $data['offerPeriod'] = ''; //가맹점에서 판매상품에 대한 제공기한설정
            $data['merchantData'] = $paymentData->method; //인증 성공시 가맹점으로 리턴

            //신용카드 옵션
//            $data['quotabase'] = ''; //할부 개월수 “2:3:4”,“2:0” * 개월수를 : 로 구분된 값 일시불은 기본적을 표시, 생략시 일시불만 * 5만원 이상시에만 동작
//            $data['nointerest'] = ''; //가맹점 부담 무이자할부설정 “11-2:3:5:6,34-2:6”,“04-2:6”* 카드사코드-할부개월:할부개월… 여러카드는 공백없이 ,로구분

            //무통장 옵션
//            $data['INIregno'] = ''; //주민번호 설정 기능 ”201504161111111”13자리(주민번호),10자리(사업자번호),미입력시(화면에서입력가능)
        } else {
            //PG사 필수 정보
            $data['inipaymobile_type'] = "web";
            $data['paymethod'] = $this->getMobilePayMethod($paymentData->method); //요청결제수단 - url 만들기 위해서만 사용
            $data['P_CHARSET'] = 'utf8'; //캐릭터셋 설정
            $data['P_MID'] = $this->mid;   // 상점아이디
            $data['P_NOTI'] = $paymentData->method; //인증 성공시 가맹점으로 리턴
            $data['P_NOTI_URL'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/inicis/noti"; //가맹점과 인증/승인과정을 거치지 않고 승인결과를 통보하는 용도로 사용합니다. 단, 가상계좌의 경우, 입금완료시각이 비동기식 이므로, 입금완료 통보를 위해 사용됩니다.
            /**
             * 케이 페이만 P_RETURN_URL 를 사용함
             * 계좌 이체는 동기방식으로 twotrs_bank=Y 옵션을 줘서 P_NEXT_URL 로 이동 처리 함
             */
//            $data['P_RETURN_URL'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/inicis/return"; //“승인결과통보 Url” 을 사용하는 (비동기식으로 승인결과를 통보받는) 지불수단에서 사용되는 방식으로, 사용자가 이니페이 모바일 TM 에서 모든 결제과정을 마친 후, 이동할 가맹점 Url 입니다. 이 Url 은 당사에서 변조없이 그대로 호출하여 드립니다.
            $data['P_NEXT_URL'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/inicis/next"; //인증결과수신 Url 사용자의 인증이 완료될 때, 이 Url 로 인증결과를 전달합니다.
            if (in_array($paymentData->method, [ORDER_METHOD_CARD, ORDER_METHOD_PAYCO, ORDER_METHOD_KAKAOPAY, ORDER_METHOD_SSPAY])) {
                $data['P_RESERVED'] = 'twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N&below1000=N';
                if ($paymentData->method == ORDER_METHOD_PAYCO) {
                    $data['P_RESERVED'] .= "&d_payco=Y";
                    $data['DirectShowOpt'] = 'CARD'; //다이렉트 옵션
                    $data['InipayReserved'] = 'DirectPayco=Y'; //복합옵션
                } else if ($paymentData->method == ORDER_METHOD_KAKAOPAY) {
                    $data['P_RESERVED'] .= "&d_kakaopay=Y";
                    $data['DirectShowOpt'] = 'CARD'; //다이렉트 옵션
                    $data['InipayReserved'] = 'DirectKakao=Y'; //복합옵션
                } else if ($paymentData->method == ORDER_METHOD_SSPAY) {
                    $data['P_RESERVED'] .= "&d_samsungpay=Y";
                    $data['DirectShowOpt'] = 'CARD'; //다이렉트 옵션
                    $data['InipayReserved'] = 'DirectSspay=Y'; //복합옵션
                } else if ($paymentData->method == ORDER_METHOD_CARD) {
                    $data['P_RESERVED'] .= "&apprun_check=Y";
                }
            } else if (in_array($paymentData->method, [ORDER_METHOD_ICHE, ORDER_METHOD_ASCROW])) {
                $data['P_RESERVED'] = 'twotrs_bank=Y&apprun_check=Y';
                if ($paymentData->method == ORDER_METHOD_ASCROW) {
                    $data['P_RESERVED'] .= '&useescrow=Y';
                }
            } else if ($paymentData->method == ORDER_METHOD_VBANK) {
                $data['P_RESERVED'] = 'vbank_receipt=Y';
            }

            //주문정보
            $data['P_OID'] = $paymentData->oid;  //상품주문번호 64 byte
            $data['P_AMT'] = $paymentData->amt;  //결제금액
//            $data['P_TAX'] = '';  //영수증에 표기할 부가세 금액
//            $data['P_TAXFREE'] = '';  //과세 되지 않는 금액
            $data['P_GOODS'] = $paymentData->goodsName;  //상품명
            $data['P_UNAME'] = $paymentData->buyerName;        // 구매자명
            $data['P_MOBILE'] = $paymentData->buyerMobile; //구매자Mobile번호 숫자와 "-"만 허용
            $data['P_EMAIL'] = $paymentData->buyerEmail; //구매자Email

            //신용카드 옵션
//            $data['P_CARD_OPTION'] = ''; //신용카드 우선선택 옵션 설정 시, 해당 카드코드에 해당하는 카드가 선택된 채로 Display 됩니다. 적용 예시 : selcode=14
//            $data['P_ONLY_CARDCODE'] = ''; //신용카드 노출제한 옵션 선택된 카드 리스트만 출력되며, 나머지 카드리스트는 출력되지 않습니다 적용 예시 : 롯데, 외환, BC 카드만 사용할 경우, 롯데카드코드 : 03, 외환카드코드 : 01, BC 카드코드 : 11 이므로, 03:01:11 로 설정
//            $data['P_QUOTABASE'] = ''; //신용카드 할부기간 지정 50,000 원 이상 결제 시, 할부기간 지정 (36 개월 MAX) Ex. 01:02:03:04.. 01 은 일시불, 02 는 2 개월 등등

            //휴대폰 옵션
            $data['P_HPP_METHOD'] = "2"; // 휴대폰결제 필수 - 실물여부 1:컨텐츠, 2:실물

            //가상계좌 옵션
            $data['P_VBANK_DT'] = $paymentData->vbankExpirationDate; //가상계좌 입금기한 날짜 설정을 하지 않으면, 요청일 + 10 일로 자동설정 됩니다. Ex. 20151225
//            $data['P_VBANK_TM'] = ''; //가상계좌 입금기한 시간 시분까지 설정 가능합니다. (4 자리) Ex. 2030
        }

        return $data;
    }

    /**결제 승인 요청 */
    public function doApply($data)
    {
        require_once __DIR__ . '/inicis/libs/INIStdPayUtil.php';
        require_once __DIR__ . '/inicis/libs/HttpClient.php';

        $SignatureUtil = new INIStdPayUtil();

        //############################################
        // 1.전문 필드 값 설정(***가맹점 개발수정***)
        //############################################;
        $mid = $this->mid;                        // 가맹점 ID 수신 받은 데이터로 설정
        $timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
        $charset = "UTF-8";                                    // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
        $format = "JSON";                                    // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)
        $authToken = $data["authToken"];                // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
        $authUrl = $data["authUrl"];                        // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
        $netCancel = $data["netCancelUrl"];                // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

        //#####################
        // 2.signature 생성
        //#####################
        $signParam["authToken"] = $authToken;    // 필수
        $signParam["timestamp"] = $timestamp;    // 필수
        // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
        $signature = $SignatureUtil->makeSignature($signParam);


        //#####################
        // 3.API 요청 전문 생성
        //#####################
        $authMap = [];
        $authMap["mid"] = $mid;                  // 가맹점 ID 수신 받은 데이터로 설정
        $authMap["authToken"] = $authToken;    // 필수
        $authMap["signature"] = $signature;    // 필수
        $authMap["timestamp"] = $timestamp;    // 필수
        $authMap["charset"] = $charset; //인코딩 설정
        $authMap["format"] = $format;    // // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정) default=XML

        try {

            $httpUtil = new HttpClient();

            //#####################
            // 4.API 통신 시작
            //#####################
            if ($httpUtil->processHTTP($authUrl, $authMap)) {
                $resultMap = json_decode($httpUtil->body, true);
            } else {
                return $this->returnApplyData(false, "Http Connect Error");
            }

            //############################################################
            //5.API 통신결과 처리(***가맹점 개발수정***)
            //############################################################
            if ((strcmp("0000", $resultMap["resultCode"]) == 0)) {
                $secureMap = [];
                $secureMap["mid"] = $this->mid;                            //mid
                $secureMap["tstamp"] = $timestamp;                    //timestemp
                $secureMap["MOID"] = $resultMap["MOID"];            //MOID
                $secureMap["TotPrice"] = $resultMap["TotPrice"];        //TotPrice

                // signature 데이터 생성
                $secureSignature = $SignatureUtil->makeSignatureAuth($secureMap);
            } else {
                $secureSignature = '';
            }

            if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0)) {
                return $this->returnApplyData(true, "", $resultMap);
            } else {
                //결제보안키가 다른 경우.
                if (isset($resultMap["authSignature"]) && (strcmp($secureSignature, $resultMap["authSignature"]) != 0) && (strcmp("0000", $resultMap["resultCode"]) == 0)) {
                    if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                        //망취소
                        throw new Exception("데이터 위변조 체크 실패");
                    } else {
                        return $this->returnApplyData(false, "데이터 위변조 체크 실패");
                    }
                } else {
                    return $this->returnApplyData(false, ($resultMap["resultMsg"] ?? ''));
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            if ($httpUtil->processHTTP($netCancel, $authMap)) {
                $resultMap = json_decode($httpUtil->body, true);
                if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                    $message .= '(취소 성공)';
                }
            } else {
                $message = '(취소 실패 : Http Connect Error)';
            }
            return $this->returnApplyData(false, $message);
        }
    }

    /**
     * mobile 결제승인
     */
    public function doMobileApply($data)
    {
        require_once __DIR__ . '/inicis/libs/HttpClient.php';

        try {

            $httpUtil = new HttpClient();

            //#####################
            // 4.API 통신 시작
            //#####################
            $resultMap = [];
            $sendParams = [];
            $sendParams['P_TID'] = $data['P_TID'];
            $sendParams['P_MID'] = $this->mid;

            if ($httpUtil->processHTTP($data['P_REQ_URL'], $sendParams)) {
                $arr_result = explode("&", $httpUtil->body);
                foreach ($arr_result as $key => $val):
                    list($k_text, $v_text) = explode("=", $val);
                    $resultMap[trim($k_text)] = trim($v_text);
                endforeach;
                if ($resultMap['P_STATUS'] != '00') {
                    throw new Exception($resultMap['P_RMESG1']);
                }
                return $this->returnApplyData(true, '', $resultMap);
            } else {
                throw new Exception($httpUtil->errormsg);
            }
            //############################################################
            //5.API 통신결과 처리(***가맹점 개발수정***)
            //############################################################
        } catch (Exception $e) {
            return $this->returnApplyData(false, '[모바일결제승인 실패]' . $e->getMessage());
        }
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        require_once __DIR__ . '/inicis/libs/INILib.php';

        $inipay = new INIpay50;

        /* * *******************
         * 3. 취소 정보 설정 *
         * ******************* */
        $inipay->SetField("inipayhome", $this->homePath); // 이니페이 홈디렉터리(상점수정 필요)
        $inipay->SetField("debug", "false");                             // 로그모드("true"로 설정하면 상세로그가 생성됨.)
        $inipay->SetField("mid", $this->mid);                                 // 상점아이디
        $inipay->SetField("type", "cancel");                            // 고정 (절대 수정 불가)

        /* * ************************************************************************************************
         * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
         * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
         * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
         * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
         * ************************************************************************************************ */
        $inipay->SetField("admin", $this->cancelPassword);
        $inipay->SetField("tid", $cancelData->tid);                                 // 취소할 거래의 거래아이디
        $inipay->SetField("cancelmsg", $cancelData->message); // 취소사유

        /* * **************
         * 4. 취소 요청 *
         * ************** */

        $inipay->startAction();

        /* * **************************************************************
         * 5. 취소 결과                                           	*
         *                                                        	*
         * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
         * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
         * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
         * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
         * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
         * (현금영수증 발급 취소시에만 리턴됨)                          *
         * ************************************************************** */
        if ($inipay->getResult('ResultCode') == '00') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = trim(iconv('euc-kr', 'utf-8', $inipay->getResult('ResultMsg')));
        }

        return $responseData;
    }

    private function returnApplyData($result, $message, $data = [])
    {
        return [
            'result' => $result
            , 'message' => $message
            , 'data' => $data
        ];
    }

    private function getPayMethod($method)
    {
        return $this->methodMapping[$method] ?? '';
    }

    private function getMobilePayMethod($method)
    {
        return $this->methodMobileMapping[$method] ?? '';
    }

    public function getBankName($code)
    {
        $bnakName = [
            '02' => '한국산업은행'
            , '03' => '기업은행'
            , '04' => '국민은행'
            , '05' => '하나은행 (구)'
            , '06' => '국민은행 (구 주택)'
            , '07' => '수협중앙회'
            , '11' => '농협중앙회'
            , '12' => '단위농협'
            , '16' => '축협중앙회'
            , '20' => '우리은행'
            , '21' => '구)조흥은행'
            , '22' => '상업은행'
            , '23' => 'SC 제일은행'
            , '24' => '한일은행'
            , '25' => '서울은행'
            , '26' => '구)신한은행'
            , '27' => '한국씨티은행 (구 한미)'
            , '31' => '대구은행'
            , '32' => '부산은행'
            , '34' => '광주은행'
            , '35' => '제주은행'
            , '37' => '전북은행'
            , '38' => '강원은행'
            , '39' => '경남은행'
            , '41' => '비씨카드'
            , '45' => '새마을금고'
            , '48' => '신용협동조합중앙회'
            , '50' => '상호저축은행'
            , '53' => '한국씨티은행'
            , '54' => '홍콩상하이은행'
            , '55' => '도이치은행'
            , '56' => 'ABN 암로'
            , '57' => 'JP 모건'
            , '59' => '미쓰비시도쿄은행'
            , '60' => 'BOA(Bank of America)'
            , '64' => '산림조합'
            , '70' => '신안상호저축은행'
            , '71' => '우체국'
            , '81' => '하나은행'
            , '83' => '평화은행'
            , '87' => '신세계'
            , '88' => '신한 (통합)은행'
            , '89' => '케이뱅크'
            , '90' => '카카오뱅크'
            , 'D1' => '유안타증권 (구 동양증권)'
            , 'D2' => '현대증권'
            , 'D3' => '미래에셋증권'
            , 'D4' => '한국투자증권'
            , 'D5' => '우리투자증권'
            , 'D6' => '하이투자증권'
            , 'D7' => 'HMC 투자증권'
            , 'D8' => 'SK 증권'
            , 'D9' => '대신증권'
            , 'DA' => '하나대투증권'
            , 'DB' => '굿모닝신한증권'
            , 'DC' => '동부증권'
            , 'DD' => '유진투자증권'
            , 'DE' => '메리츠증권'
            , 'DF' => '신영증권'
            , 'DG' => '대우증권'
            , 'DH' => '삼성증권'
            , 'DI' => '교보증권'
        ];

        return $bnakName[$code] ?? '';
    }

    public function getCardName($code)
    {
        $cardName = [
            '01' => '하나 (외환)'
            , '03' => '롯데'
            , '04' => '현대'
            , '06' => '국민'
            , '11' => 'BC'
            , '12' => '삼성'
            , '14' => '신한'
            , '21' => '해외 VISA'
            , '22' => '해외마스터'
            , '23' => '해외 JCB'
            , '26' => '중국은련'
            , '32' => '광주'
            , '33' => '전북'
            , '34' => '하나'
            , '35' => '산업카드'
            , '41' => 'NH'
            , '43' => '씨티'
            , '44' => '우리'
            , '48' => '신협체크'
            , '51' => '수협'
            , '52' => '제주'
            , '54' => 'MG 새마을금고체크'
            , '55' => '케이뱅크'
            , '56' => '카카오뱅크'
            , '71' => '우체국체크'
            , '95' => '저축은행체크'
        ];

        return $cardName[$code] ?? '';
    }
}
