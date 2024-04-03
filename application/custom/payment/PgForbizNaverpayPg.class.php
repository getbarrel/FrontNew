<?php

/**
 * Description of PgForbizNaverpayPg
 * https://developer.pay.naver.com/docs/v2/api#common-common_certi
 * @author Hong
 */
class PgForbizNaverpayPg extends PgForbiz
{
    /**
     * 파트너 ID
     * @var type
     */
    private $partnerId;

    /**
     * 클라이언트 ID
     * @var type
     */
    private $clientId;

    /**
     * 클라이언트 시크릿 키
     * @var type
     */
    private $clientSecret;

    /**
     * 모드 development or production
     * @var
     */
    private $mode;

    /**
     * API 도메인
     * @var
     */
    private $apiDomain;

    /**
     * 서비스 도메인
     * @var
     */
    private $serviceDomain;

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        $this->partnerId = ForbizConfig::getMallConfig('naverpay_pg_partner_id');
        $this->clientId = ForbizConfig::getMallConfig('naverpay_pg_client_id');
        $this->clientSecret = ForbizConfig::getMallConfig('naverpay_pg_client_secret');

        if (ForbizConfig::getMallConfig('naverpay_pg_service_type') == 'service') {
            $this->mode = 'production';
            $this->apiDomain = 'https://apis.naver.com';
            if ($agentType == 'W') {
                $this->serviceDomain = 'https://pay.naver.com';
            } else {
                $this->serviceDomain = 'https://m.pay.naver.com';
            }
        } else {
            $this->mode = 'development';
            $this->apiDomain = 'https://dev.apis.naver.com';
            if ($agentType == 'W') {
                $this->serviceDomain = 'https://test-pay.naver.com';
            } else {
                $this->serviceDomain = 'https://test-m.pay.naver.com';
            }
        }
    }

    public function getPaymentIncludeJavaScript(): string
    {
        return "<script type='text/javascript' src='https://nsp.pay.naver.com/sdk/js/naverpay.min.js'></script>";
    }

    public function getPaymentRequestJavaScript(): string
    {
        $payType = 'normal'; //normal: 일반결제, recurrent: 정기결제
        $openType = ($this->agentType == 'W' ? 'layer' : 'page');

        return implode('', [
            'var oPay = Naver.Pay.create({'
            , '"mode" : "' . $this->mode . '"
            , "clientId" : "' . $this->clientId . '"
            , "payType" : "' . $payType . '"
            , "openType" : "' . $openType . '"
            , "onAuthorize" : function (oData){
                if(oData.resultCode === "Success") {
                    location.href="/payment/naverpayPg/result?resultCode=Success&paymentId=" + oData.paymentId;
                } else {
                    var resultMessage = oData.resultMessage;
                    if (resultMessage == "userCancel") {
                        resultMessage = "결제를 취소하셨습니다. 주문 내용 확인 후 다시 결제해주세요.";
                    } else if (resultMessage == "webhookFail") {
                        resultMessage = "webhookUrl 호출 응답 실패";
                    } else if (resultMessage == "paymentTimeExpire") {
                        resultMessage = "결제 가능한 시간이 지났습니다. 주문 내용 확인 후 다시 결제해주세요.";
                    } else if (resultMessage == "OwnerAuthFail") {
                        resultMessage = "타인 명의 카드는 결제가 불가능합니다. 회원 본인 명의의 카드로 결제해주세요.";
                    }
                    common.noti.alert(resultMessage);
                }
               }'
            , '});'
            , 'oPay.open(JSON.parse(unescape(document.paymentGatewayForm.data.value)));'
        ]);
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $data = [];

        $paymentData->amt = f_decimal($paymentData->amt)->toInt();
        $paymentData->taxAmt = f_decimal($paymentData->taxAmt)->toInt();
        $paymentData->taxExAmt = f_decimal($paymentData->taxExAmt)->toInt();

        $data['merchantPayKey'] = $paymentData->oid; //가맹점 주문내역 확인 가능한 가맹점 결제번호 또는 주문번호를 전달해야 합니다
//        $data['merchantUserKey'] = ''; //가맹점의 사용자 키(개인 아이디와 같은 개인정보 데이터는 제외하여 전달해야 합니다)
        $data['productName'] = $paymentData->mainGoodsName; //대표 상품명. 예: 장미의 이름 외 1건(X), 장미의 이름(O)
        $data['productCount'] = (int)$paymentData->totalPcnt; //상품 수량 예: A 상품 2개 + B 상품 1개의 경우 productCount 3으로 전달
        $data['totalPayAmount'] = $paymentData->amt; //총 결제 금액. 최소 결제금액은 100원
        $data['taxScopeAmount'] = $paymentData->taxAmt; //과세 대상 금액. 과세 대상 금액 + 면세 대상 금액 = 총 결제 금액
        $data['taxExScopeAmount'] = $paymentData->taxExAmt; //면세 대상 금액. 과세 대상 금액 + 면세 대상 금액 = 총 결제 금액
//        $data['deliveryFee'] = 0; //배송비
        $data['returnUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/naverpayPg/result"; //결제 인증 결과 전달 URL, 결제 완료 후 이동할 URL(returnUrl + 가맹점 파라미터 전달이 가능합니다) 네이버페이는 결제 작업 완료 후, 가맹점이 등록한 returnUrl로 리디렉션을 수행합니다 가맹점은 이를 활용하여 내부 처리를 수행하거나 구매자에게 결제 결과 화면을 노출할 수 있습니다
//        $data['purchaserName'] = (string)''; //구매자 성명. 결제 상품이 보험인 경우에만 필수 값입니다. 그 외에는 전달할 필요가 없습니다
//        $data['purchaserBirthday'] = (string)''; //구매자 생년월일(yyyymmdd). 결제 상품이 보험인 경우에만 필수 값입니다. 그 외에는 전달할 필요가 없습니다
//        $data['extraDeduction'] = 'false'; //도서·공연비 소득공제 대상 여부. 문화체육관광부에서 인증한 소득공제 제공 사업자가 대상 상품을 판매하는 경우 필수 값입니다. 해당 파라미터를 사용하기 위해서는 별도 요청을 주셔야 합니다. true : 대상, false : 비 대상 이며 Simple Version일 때는 반드시 String으로 true, false를 입력하시기 바랍니다. (ex: "true", "false")
//        $data['useCfmYmdt'] = 'false'; //이용완료일(yyyymmdd) 가맹점 타입이 이용완료일 정산 또는 이용완료일 포인트 적립인 경우 필수 해당 값을 기준으로 이용완료일 정산의 경우 '정산기준일' 또는 이용완료일 포인트 적립인 경우 '포인트적립 기준일'이 지정됩니다. 이용완료일은 반드시 결제일과 같거나 결제일 이후여야 하며, 이용완료일이 결제일자 이전으로 적용될 경우 에러(InvalidUseCfmYmdt)가 발생됩니다.
        $productItems = [];
        foreach ($paymentData->goodsList as $goods) {
            $productItems[] = [
                'categoryType' => 'PRODUCT' //결제 상품 유형. 정의는 별도로 제공되는 결제 상품의 유형, 분류, 식별값을 참고 바랍니다. ( 영대문자 허용 )
                , 'categoryId' => 'GENERAL' // 결제 상품 유형. 정의는 별도로 제공되는 결제 상품의 유형, 분류, 식별값을 참고 바랍니다. ( 영대문자, _ 허용 )
                , 'uid' => $goods['pid'] // 결제 상품 유형. 정의는 별도로 제공되는 결제 상품의 유형, 분류, 식별값을 참고 바랍니다. ( 영대소문자, 숫자, /, -, _, 공백문자 허용 )
                , 'name' => $goods['pname'] // 상품명
//                , 'payReferrer' => '' //결제 상품 유형. 정의는 별도로 제공되는 유입경로를 참고 바랍니다. ( 영대문자, _ 허용 )
//                , 'startDate' => '' // 시작일(yyyyMMdd). 예: 20160701 결제 상품이 공연, 영화, 보험, 여행, 항공, 숙박인 경우 입력을 권장합니다. ( 숫자 허용 )
//                , 'endDate' => '' // 종료일(yyyyMMdd). 예: 20160701 결제 상품이 공연, 영화, 보험, 여행, 항공, 숙박인 경우 입력을 권장합니다. ( 숫자 허용 )
//                , 'sellerId' => '' // 가맹점에서 하위 판매자를 식별하기 위해 사용하는 식별키를 전달 합니다. ( 영대소문자 및 숫자 허용 )
                , 'count' => $goods['pcnt'] // 결제 상품 개수. 기본값은 1입니다. ( 최대 999999 )
            ];
        }

        $data['productItems'] = $productItems; //productItem 배열. 자세한 내용은 아래 "표 2 productItem"을 참고 바랍니다

        return ['data' => rawurlencode(json_encode($data))];
    }

    public function doApply($data)
    {
        return $this->callApi($this->apiDomain . '/' . $this->partnerId . '/naverpay/payments/v2.2/apply/payment', $data);
    }

    public function doPurchaseConfirm($data)
    {
        return $this->callApi($this->apiDomain . '/' . $this->partnerId . '/naverpay/payments/v1/purchase-confirm', $data);
    }

    public function getHistory($data)
    {
        return $this->callApi($this->apiDomain . '/' . $this->partnerId . '/naverpay/payments/v2.2/list/history', json_encode($data), 'json');
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        $cancelData->amt = f_decimal($cancelData->amt)->toInt();
        $cancelData->taxAmt = f_decimal($cancelData->taxAmt)->toInt();
        $cancelData->taxExAmt = f_decimal($cancelData->taxExAmt)->toInt();
        $cancelData->expectedRestAmt = f_decimal($cancelData->expectedRestAmt)->toInt();

        $requestData = [
            'paymentId' => $cancelData->tid
            , 'merchantPayKey' => $cancelData->oid
            , 'cancelAmount' => $cancelData->amt
            , 'cancelReason' => $cancelData->message
            , 'cancelRequester' => $cancelData->cancelRequester == 'M' ? '1' : '2' // 취소 요청자(1: 구매자, 2: 가맹점 관리자) 구분이 애매한 경우 가맹점 관리자로 입력합니다
            , 'taxScopeAmount' => $cancelData->taxAmt //과세 대상 금액
            , 'taxExScopeAmount' => $cancelData->taxExAmt //면세 대상 금액
            , 'doCompareRest' => 1
            , 'expectedRestAmount' => $cancelData->expectedRestAmt // 이번 취소가 수행되고 난 후에 남을 가맹점의 예상 금액 , 옵션 파라미터인 doCompareRest값이 1일 때에만 동작합니다 Ex) 결제금액 1000원 중 200원을 취소하고 싶을 때 => expectedRestAmount =800원, cancelAmount=200원으로 요청
        ];

        $response = $this->callApi($this->apiDomain . '/' . $this->partnerId . '/naverpay/payments/v1/cancel', $requestData);

        if ($response->code == 'Success') {
            $responseData->result = true;
        } else if ($response->code == 'CancelNotComplete') { //취소처리가 완료되지 않아, 반드시 취소 재시도가 필요
            return $this->doCancel($cancelData, $responseData);
        } else {
            $responseData->result = false;
            $responseData->message = $response->message;
        }
        return $responseData;
    }

    private function callApi($url, $data, $requestType = false)
    {
        $curl = new Curl\Curl();

        $curl->setOpt(CURLOPT_TIMEOUT, 60);

        if ($requestType == 'json') {
            $curl->setHeader('Content-Type', 'application/json');
        }

        $curl->setHeader('X-Naver-Client-Id', $this->clientId)
            ->setHeader('X-Naver-Client-Secret', $this->clientSecret)
            ->post($url, $data);

        return json_decode($curl->response);
    }
}
