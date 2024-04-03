<?php

/**
 * Description of PgForbizNaverpayPg
 * http://tossdev.github.io
 * @author Hong
 */
class PgForbizToss extends PgForbiz
{

    /**
     * 토스 api url
     * @var type
     */
    private $apiUrl;

    /**
     * api key
     * @var type
     */
    private $apiKey;


    public function __construct($agentType)
    {
        parent::__construct($agentType);
        $this->apiUrl = 'https://pay.toss.im/api';

        if (ForbizConfig::getMallConfig('toss_service_type') == 'service') {
            $this->apiKey = ForbizConfig::getMallConfig('toss_api_key');
        } else {
            $this->apiKey = 'sk_test_apikey1234567890';
        }
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $checkoutPage = '';
        $paymentData->amt = f_decimal($paymentData->amt)->toInt();
        $paymentData->taxExAmt = f_decimal($paymentData->taxExAmt)->toInt();

        try {
            $data = [];
            $data['orderNo'] = $paymentData->oid;// 토스몰 고유의 주문번호 (필수)
            $data['amount'] = $paymentData->amt;// 결제 금액 (필수)
            $data['amountTaxFree'] = $paymentData->taxExAmt;// 비과세 금액 (필수)
//            $data['amountTaxable'] = 0;// 결제 금액 중 과세금액
//            $data['amountVat'] = 0;// 결제 금액 중 부가세
//            $data['amountServiceFee'] = 0;// 결제 금액 중 봉사료
            $data['productDesc'] = $paymentData->goodsName;// 상품 정보 (필수)
            $data['apiKey'] = $this->apiKey;// 상점의 API Key (필수)
            $data['autoExecute'] = false;// 자동 승인 설정 (필수)
            $data['cashReceipt'] = true; // 현금영수증 발급 가능 여부
            $data['metadata'] = ""; // metadata 값

            //retUrl 결제 완료 후 연결할 웹 URL (필수)
            //retCancelUrl 결제 취소 시 연결할 웹 URL (필수)
            if ($this->agentType == 'W') {
                $data['retUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/toss/popupResult";
                $data['retCancelUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/toss/popupCancel";
            } else {
                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');
                $products = $orderModel->getOrderProduct($paymentData->oid);
                $cartIxs = [];
                foreach ($products as $product) {
                    $cartIxs[] = $product['cart_ix'];
                }
                $cartIxs = array_unique($cartIxs);

                $data['retUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/payment/toss/result";
                $data['retCancelUrl'] = HTTP_PROTOCOL . FORBIZ_HOST . "/shop/infoInput?cartIx=" . implode(',', $cartIxs);
            }

            $responseData = $this->callApi($this->apiUrl . '/v1/payments', $data);
            if ($responseData->code == '0') {
                $this->qb
                    ->set('tid', $responseData->payToken)
                    ->update(TBL_SHOP_ORDER_PAYMENT)
                    ->where('oid', $paymentData->oid)
                    ->where('method', $paymentData->method)
                    ->exec();
                $checkoutPage = $responseData->checkoutPage;
                //$responseData->checkoutAppScheme;
            }
        } catch (Exception $e) {

        }

        return [
            'checkoutPage' => $checkoutPage
        ];
    }

    public function getPaymentIncludeJavaScript(): string
    {
        return "";
    }

    public function getPaymentRequestJavaScript(): string
    {
        $script = implode('', [
            'var checkoutPage = document.paymentGatewayForm.checkoutPage.value;'
            , 'if (checkoutPage == "") {'
            , 'alert("Toss 결제 생성 실패");'
            , 'return false;'
            , '}'
        ]);
        if ($this->agentType == 'W') {
            $script .= "window . open('/payment/toss/popup?checkoutPage=' + checkoutPage, 'popupToss', 'top=100, left=300, width=727px, height=512px, resizble=no, scrollbars=yes');";
        } else {
            $script .= 'document.location.href = checkoutPage';
        }
        return $script;
    }

    public function doApply($data)
    {
        $oid = $data['orderNo'];
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        $paymentData = $orderModel->getPaymentRowData($oid, ORDER_METHOD_TOSS);
        return $this->callApi($this->apiUrl . '/v2/execute', [
            'apiKey' => $this->apiKey
            , 'payToken' => $paymentData['tid']
            , 'orderNo' => $oid
        ]);
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        $cancelData->amt = f_decimal($cancelData->amt)->toInt();
        $cancelData->taxExAmt = f_decimal($cancelData->taxExAmt)->toInt();

        $data = [];

        $data['apiKey'] = $this->apiKey; // 가맹점 key (필수)
        $data['payToken'] = $cancelData->tid; // 토스 결제 토큰 (필수)
//        $data['refundNo'] = ''; // 환불 번호 (미입력 시 자동 생성되며 환불 완료 응답에서 확인 가능합니다. 매회 요청마다 유니크한 값을 사용하시길 권장드립니다.)
        $data['reason'] = $cancelData->message; // 환불 사유
        $data['amount'] = $cancelData->amt; // 환불할 금액 (필수)
        $data['amountTaxFree'] = $cancelData->taxExAmt; // 환불할 금액 중 비과세금액 (필수)
//        $data['amountTaxable'] = 0; // 환불할 금액 중 과세금액
//        $data['amountVat'] = 0; // 환불할 금액 중 부가세
//        $data['amountServiceFee'] = 0; // 환불할 금액 중 봉사료

        $response = $this->callApi($this->apiUrl . '/v2/refunds', $data);
        if ($response->code == '0') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = $response->msg;
        }
        return $responseData;
    }


    private function callApi($url, $data)
    {
        $curl = new Curl\Curl();

        $curl->setHeader('Content-Type', 'application/json')
            ->post($url, json_encode($data));

        return json_decode($curl->response);
    }
}
