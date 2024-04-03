<?php

/**
 * Description of PgForbizPayco
 * 기술지원 사이트 https://devcenter.payco.com [id : payco , password : payco1234]
 * 파트너센터(개발) https://demo-partner.payco.com [id : partner-test@nhnent.com , password : qwer1357]
 * @author Hong
 */
class PgForbizPayco extends PgForbiz
{
    /**
     * 가맹점 코드 - 파트너센터에서 알려주는 값으로, 초기 연동 시 PAYCO에서 쇼핑몰에 값을 전달한다.
     * @var type
     */
    private $sellerKey;

    /**
     * 상점ID, 30자 이내
     * @var type
     */
    private $cpId;

    /**
     * 상품ID, 50자 이내
     * @var type
     */
    private $productId;

    /**
     * API 도메인
     * @var
     */
    private $apiDomain;

    /**
     * 로그 사용 여부
     * @var bool
     */
    private $logUse = false;

    /**
     * 로그 경로
     * @var bool
     */
    private $logPath;

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        $this->sellerKey = ForbizConfig::getMallConfig('payco_seller_key');
        $this->cpId = ForbizConfig::getMallConfig('payco_cp_id');
        $this->productId = ForbizConfig::getMallConfig('payco_product_id');

        if (ForbizConfig::getMallConfig('payco_service_type') == 'service') {
            $this->apiDomain = 'https://api-bill.payco.com';
        } else {
            $this->apiDomain = 'https://alpha-api-bill.payco.com';
        }
    }

    public function getPaymentIncludeJavaScript(): string
    {
        return "";
    }

    public function getPaymentRequestJavaScript(): string
    {
        $script = implode('', [
            'var orderSheetUrl = document.paymentGatewayForm.orderSheetUrl.value;'
            , 'if (orderSheetUrl == "") {'
            , 'alert("PAYCO 예약 실패");'
            , 'return false;'
            , '}'
        ]);
        if ($this->agentType == 'W') {
            $script .= "window.open('/payment/payco/popup?orderSheetUrl='+orderSheetUrl,'popupPayco', 'top=100, left=300, width=727px, height=512px, resizble=no, scrollbars=yes');";
        } else {
            $script .= 'document.location.href = orderSheetUrl';
        }
        return $script;
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $paymentData->amt = f_decimal($paymentData->amt)->toInt();
        $paymentData->taxAmt = f_decimal($paymentData->taxAmt)->toInt();
        $paymentData->taxExAmt = f_decimal($paymentData->taxExAmt)->toInt();

        //---------------------------------------------------------------------------------------------------------------------------------
        // 주문서에 담길 부가 정보를 JSON 으로 작성 (필요시 사용)
        // payExpiryYmdt			: 해당 주문예약건 만료 처리 일시
        // virtualAccountExpiryYmd  : 가상계좌만료일시
        //
        // cancelMobileUrl			: 모바일 결제페이지에서 취소 버튼 클릭시 이동할 URL (결제창 이전 URL 등). 미입력시 메인 URL로 이동
        /// 모바일 결제페이지에서 취소 버튼 클릭시 이동할 URL (결제창 이전 URL 등)
        /// 1순위 : 주문예약 > extraData > cancelMobileUrl 값이 있을시 => cancelMobileUrl 이동
        /// 2순위 : 주문예약시 전달받은 returnUrl 이동 + 실패코드(오류코드:2222)
        /// 3순위 : 가맹점 URL로 이동(가맹점등록시 받은 사이트URL)
        /// 4순위 : 이전 페이지로 이동 => history.Back();
        //
        // viewOptions : 화면UI옵션(showMobileTopGnbYn : 모바일 상단 GNB 노출여부 , iframeYn : Iframe 호출현재 iframeYN의 용도는 없으며, 차후 iframe 이슈 대응을 위한 필드로 iframe 사용인 경우는 Y로사용 )
        //---------------------------------------------------------------------------------------------------------------------------------
        //$payExpiryYmdt			             	= "20171231180000";	             // 미적용시, 자동으로 만료시간 지정됨.
        //$virtualAccountExpiryYmd					= "20171231180000";

        $appUrl = "";                                                         // IOS 인앱 결제시 ISP 모바일 등의 앱에서 결제를 처리한 뒤 복귀할 앱 URL
        if (getAppType()) {
            $appUrl = APP_SCHEME;
        }
        // 앱을 호출하는 url , Safari 에서 호출 테스트  예) payco://

        $viewOptionsArry = [];
        $viewOptionsArry["showMobileTopGnbYn"] = "N";
        $viewOptionsArry["iframeYn"] = "N";

        $extraDataArray = [];
        //$extraDataArray["payExpiryYmdt"] = "20171231180000"; // 미적용시, 자동으로 만료시간 지정됨.
        $extraDataArray["virtualAccountExpiryYmd"] = $paymentData->vbankExpirationDate . "235959";

        $extraDataArray["appUrl"] = $appUrl;
        //$extraDataArray["cancelMobileUrl"] = ""; //모바일 PAYCO 결제창 [취소] 버튼 선택

        $extraDataArray["viewOptions"] = $viewOptionsArry;

        $extraData = addslashes(json_encode($extraDataArray));

        //---------------------------------------------------------------------------------
        // 상품값으로 읽은 변수들로 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------
        $ProductRows = [];

        //페이코 답변 : productPaymentAmt 합계 금액이 totalPaymentAmt 같아야됨. 부분취소시에는 상품별로 취소되는 부분이 아닌 취소금액( cancelTotalAmt )을 기준으로 취소됩니다.
        $ProductsList = [];
        $ProductsList["cpId"] = $this->cpId;
        $ProductsList["productId"] = $this->productId;
        $ProductsList["productAmt"] = $paymentData->amt;
        $ProductsList["productPaymentAmt"] = $paymentData->amt;
        $ProductsList["orderQuantity"] = 1;
        $ProductsList["option"] = urlencode("");
        $ProductsList["sortOrdering"] = 1;
        $ProductsList["productName"] = urlencode($paymentData->goodsName);
        $ProductsList["sellerOrderProductReferenceKey"] = $paymentData->oid;
        //면세상품 : DUTYFREE, 과세상품 : TAXATION (기본), 결합상품 : COMBINE
        if ($paymentData->taxExAmt == $paymentData->amt) {
            $taxationType = 'DUTYFREE';
        } else if ($paymentData->taxAmt == $paymentData->amt) {
            $taxationType = 'TAXATION';
        } else {
            $taxationType = 'DUTYFREE';
        }
        $ProductsList["taxationType"] = $taxationType;
//        $ProductsList["orderConfirmUrl"] = $orderConfirmUrl; // 주문완료 후 주문상품을 확인할 수 있는 url, 4000자 이내
//        $ProductsList["orderConfirmMobileUrl"] = $orderConfirmMobileUrl; // 주문완료 후 주문상품을 확인할 수 있는 모바일 url, 1000자 이내
//        $ProductsList["productImageUrl"] = $productImageUrl; // 이미지URL (배송비 상품이 아닌 경우는 필수), 4000자 이내, productImageUrl에 적힌 이미지를 썸네일해서 PAYCO 주문창에 보여줍니다.
        array_push($ProductRows, $ProductsList);

        //---------------------------------------------------------------------------------
        // 설정한 주문정보들을 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------
        try {
            $strJson = [];
            $strJson["sellerKey"] = $this->sellerKey;
            $strJson["sellerOrderReferenceKey"] = $paymentData->oid; //(필수) 외부가맹점의 주문번호
            $strJson["sellerOrderReferenceKeyType"] = 'UNIQUE_KEY'; //외부가맹점의 주문번호 타입 UNIQUE_KEY 유니크 키 - 기본값, DUPLICATE_KEY 중복 가능한 키( 외부가맹점의 주문번호가 중복 가능한 경우 사용)

            // $strJson["sellerOptions"] = "{\\\"clientIp\\\":\\\"210.206.104.164\\\",\\\"memberId\\\":\\\"userid\\\"}"; // 게임결제용_판매자부가정보

            $strJson["totalPaymentAmt"] = $paymentData->amt; // (필수) 총 결재 할 금액.
            $strJson["orderTitle"] = urlencode($paymentData->goodsName); // 주문 타이틀
            $strJson["orderMethod"] = "EASYPAY"; // (필수) 주문유형(=결재유형) - 체크아웃형 : CHECKOUT - 간편결제형+가맹점 id 로그인 : EASYPAY_F , 간편결제형+가맹점 id 비로그인(PAYCO 회원구매) : EASYPAY
            $strJson["currency"] = "KRW"; // 통화(default=KRW);
            if ($this->agentType == 'W') {
                $strJson["returnUrl"] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/payco/popupResult"; // 주문완료 후 Redirect 되는 Url
            } else {
                $strJson["returnUrl"] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/payco/result"; // 주문완료 후 Redirect 되는 Url
            }
//            $strJson["returnUrlParam"] = addslashes(json_encode('{"cartNo":"CartNo_12345"}')); //주문완료 시 PAYCO에서 가맹점의 Service API 호출할때 같이 전달할 파라미터(payco_reserve.php 에서 payco_return.php 로 전달할 값을 JSON 형태의 문자열로 전달)
            $strJson["nonBankbookDepositInformUrl"] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/payco/vbankNotice"; //무통장입금완료통보 URL
            $strJson["orderChannel"] = $this->agentType == 'W' ? 'PC' : 'MOBILE'; // 주문채널 ( default : PC / MOBILE )
            $strJson["inAppYn"] = "N"; // 인앱결제 여부( Y/N ) ( default = N )
            $strJson["individualCustomNoInputYn"] = "N"; // 개인통관고유번호 입력 여부 ( Y/N ) ( default = N )
            $strJson["orderSheetUiType"] = "GRAY"; // 주문서 UI 타입 선택 ( 선택 가능값 : RED / GRAY )
            $strJson["payMode"] = "PAY2"; // 결제모드 ( PAY1 - 결제인증, 승인통합 / PAY2 - 결제인증, 승인분리 )

            //-----------------------------------------------------------------------------------------------------------------------------------------------------------
            // totalTaxfreeAmt(면세상품 총액) / totalTaxableAmt(과세상품 총액) / totalVatAmt(부가세 총액) -> 일부 필요한 가맹점을위한 예제임 (필요시 사용)
            //------------------------------------------------------------------------------------------------------------------------------------------------------------
            $strJson["totalTaxfreeAmt"] = $paymentData->taxExAmt;
            $strJson["totalTaxableAmt"] = round($paymentData->taxAmt / 1.1);
            $strJson["totalVatAmt"] = ($paymentData->taxAmt - $strJson['totalTaxableAmt']);

            $strJson["extraData"] = $extraData;
            $strJson["orderProducts"] = $ProductRows;

            $res = $this->payco_reserve(urldecode(stripslashes(json_encode($strJson))));  //주문예약 API 호출 함수
            if ($res['code'] == '0') {
                $orderSheetUrl = $res['result']['orderSheetUrl'];
            } else {
                $orderSheetUrl = '';
            }
        } catch (Exception $e) {
//            $e->getMassage();
//            $e->getCode();
            $orderSheetUrl = '';
        }
        return [
            'orderSheetUrl' => $orderSheetUrl
        ];
    }

    public function doApply($data)
    {
        return $this->payco_approval(urldecode(stripslashes(json_encode([
            "sellerKey" => $this->sellerKey
            , "reserveOrderNo" => $data['reserveOrderNo']
            , "paymentCertifyToken" => $data['paymentCertifyToken']
            , "sellerOrderReferenceKey" => $data['sellerOrderReferenceKey']
            , "totalPaymentAmt" => $data['totalPaymentAmt']
        ]))));  // 결제승인 요청
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        $cancelData->amt = f_decimal($cancelData->amt)->toInt();
        $cancelData->taxAmt = f_decimal($cancelData->taxAmt)->toInt();
        $cancelData->taxExAmt = f_decimal($cancelData->taxExAmt)->toInt();
        $cancelData->expectedRestAmt = f_decimal($cancelData->expectedRestAmt)->toInt();

        $this->logPath = $cancelData->logPath;
        list($orderNo, $tid) = explode("|", $cancelData->tid);
        //-----------------------------------------------------------------------------------
        // 취소 내역을 담을 JSON OBJECT를 선언합니다.
        //-----------------------------------------------------------------------------------
        $cancelOrder = [];

        //---------------------------------------------------------------------------------
        // 주문상품 데이터 불러오기
        // 파라메터로 값을 받을 경우 받은 값으로만 작업을 하면 됩니다.
        // 주문 키값으로만 DB에서 취소 상품 데이터를 불러와야 한다면 이 부분에서 작업하세요.
        //---------------------------------------------------------------------------------
        $orderProducts = [];

        //---------------------------------------------------------------------------------
        // 취소 상품값으로 읽은 변수들로 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------
        $orderProduct = [];
        $orderProduct["cpId"] = $this->cpId;                            // 상점 ID , payco_config.php 에 설정
        $orderProduct["productId"] = $this->productId;                        // 상품 ID , payco_config.php 에 설정
        $orderProduct["productAmt"] = $cancelData->amt;                        // 취소 상품 금액 ( 파라메터로 넘겨 받은 금액 - 필요서 DB에서 불러와 대입 )
        $orderProduct["sellerOrderProductReferenceKey"] = $cancelData->oid;    // 취소 상품 연동 키 ( 파라메터로 넘겨 받은 값 - 필요서 DB에서 불러와 대입 )
        $orderProduct["cancelDetailContent"] = urlencode($cancelData->message);    // 취소 상세 사유
        array_push($orderProducts, $orderProduct);

        //---------------------------------------------------------------------------------
        // 설정한 주문정보 변수들로 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------
        $cancelOrder["sellerKey"] = $this->sellerKey;                            //가맹점 코드. payco_config.php 에 설정
        $cancelOrder["orderCertifyKey"] = $tid;                        //주문완료통보시 내려받은 인증값
        $cancelOrder["requestMemo"] = urlencode($cancelData->message);                //취소처리 요청메모
        $cancelOrder["cancelTotalAmt"] = $cancelData->amt;                        //주문서의 총 금액을 입력합니다. (전체취소, 부분취소 전부다)
        $cancelOrder["orderProducts"] = $orderProducts;                        //위에서 작성한 상품목록과 배송비상품을 입력

        $cancelOrder["orderNo"] = $orderNo;                                // 주문번호 (sellerOrderReferenceKeyType 을 DUPLICATE_KEY로 넘긴 경우 orderNo 필수)
        $cancelOrder["totalCancelTaxfreeAmt"] = $cancelData->taxExAmt;                // 총 취소할 면세금액
        $cancelOrder["totalCancelTaxableAmt"] = round($cancelData->taxAmt / 1.1);                // 총 취소할 과세금액
        $cancelOrder["totalCancelVatAmt"] = ($cancelData->taxAmt - $cancelOrder['totalCancelTaxableAmt']);                    // 총 취소할 부가세
        $cancelOrder["totalCancelPossibleAmt"] = ($cancelData->amt + $cancelData->expectedRestAmt);                // 총 취소가능금액(현재기준): 취소가능금액 검증
        //---------------------------------------------------------------------------------
        // 주문 결제 취소 가능 여부 API 호출 ( JSON 데이터로 호출 )
        //---------------------------------------------------------------------------------
        $response = $this->payco_cancel(urldecode(stripslashes(json_encode($cancelOrder))));
        if ($response['code'] == '0') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = $response['message'];
        }
        return $responseData;
    }

    //-----------------------------------------------------------------------------
    // 로그 기록 함수 ( 디버그용 )
    // 사용 방법	: Call Write_Log(Log_String)
    // Log_String	: 로그 파일에 기록할 내용
    //-----------------------------------------------------------------------------
    private function Write_Log($Input_String)
    {
        if ($this->logUse && !empty($this->logPath)) {
            $oTextStream = fopen($this->logPath . "/Payco_Log_" . date("Ymd") . "_php.txt", "a");
            $today = date("Y-m-d H:i:s");

            //-----------------------------------------------------------------------------
            // 내용 기록
            //-----------------------------------------------------------------------------
            fwrite($oTextStream, $today . " " . $Input_String . "\n");

            //-----------------------------------------------------------------------------
            // 리소스 해제
            //-----------------------------------------------------------------------------
            fclose($oTextStream);
        }
    }

    //-------------------------------------------------------------------------------
    // 주문 예약 API 호출 함수
    // 사용 방법 : payco_reserve($mData)
    // $mData - JSON 데이터
    //-------------------------------------------------------------------------------
    private function payco_reserve($mData)
    {
        $Result = $this->Call_API($this->apiDomain . '/outseller/order/reserve', "json", $mData);

        if ($Result[0] == 200) {
            return $Result[1];
        } else {
            $Error_Return = array();
            $Error_Return["result"] = "주문 예약 API 호출 도중 오류가 발생하였습니다.";
            $Error_Return["message"] = $Result[1];
            $Error_Return["code"] = $Result[0];
            return $Error_Return;
        }
    }

    //---------------------------------------------------------------------------------
    // 결제 승인 API 호출 함수
    // 사용 방법 : payco_approval($mData)
    // $mData - JSON 데이터
    //---------------------------------------------------------------------------------
    private function payco_approval($mData)
    {
        $Result = $this->Call_API($this->apiDomain . '/outseller/payment/approval', "json", $mData);

        if ($Result[0] == 200) {
            return $Result[1];
        } else {
            $Error_Return = array();
            $Error_Return["result"] = "결제 승인 API 호출 도중 오류가 발생하였습니다.";
            $Error_Return["message"] = $Result[1];
            $Error_Return["code"] = $Result[0];
            return $Error_Return;
        }
    }

    //---------------------------------------------------------------------------------
    // PAYCO 주문 취소 API 호출 함수
    // 사용 방법 : payco_cancel($mData)
    // $mData - JSON 데이터
    //---------------------------------------------------------------------------------
    private function payco_cancel($mData)
    {
        $Result = $this->Call_API($this->apiDomain . '/outseller/order/cancel', "json", $mData);

        if ($Result[0] == 200) {
            return $Result[1];
        } else {
            $Error_Return = array();
            $Error_Return["result"] = "주문 결제 취소 도중 오류가 발생하였습니다.";
            $Error_Return["message"] = $Result[1];
            $Error_Return["code"] = $Result[0];
            return $Error_Return;
        }
    }

    //-----------------------------------------------------------------------------
    // API 호출 함수( POST 전용 - PAYCO 연동은 모든 API 호출에 POST만을 사용합니다. )
    // 사용 방법	: Call_API(SiteURL, App_Mode, Param)
    // SiteURL		: 호출할 API 주소
    // App_Mode		: 데이터 전송 형태 ( 예: json, x-www-form-urlencoded 등 )
    // Param		: 전송할 POST 데이터
    //-----------------------------------------------------------------------------
    private function Call_API($SiteURL, $App_Mode, $Param)
    {
        $curl = new Curl\Curl();

        $this->Write_Log("Call API   $SiteURL Data : $Param");

        try {
            $curl->setOpt(CURLOPT_FOLLOWLOCATION, TRUE);
            $curl->setOpt(CURLOPT_MAXREDIRS, 5);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);

            $curl->setHeader('Content-Type', 'application/' . $App_Mode)
                ->post($SiteURL, $Param);

            $this->Write_Log("API Result $SiteURL Status : " . $curl->http_status_code);
            $this->Write_Log("API Result $SiteURL ResponseText : " . $curl->response);
        } catch (RequestException $e) {
            $this->Write_Log("Call API Function Error : Number - " . $e->getRequest() . ", Description - " . $e->getResponse());
        }

        return [$curl->http_status_code, json_decode($curl->response, true)];
    }
}
