<?php

/**
 * Description of ForbizMallOrderController
 *
 * @author hoksi
 */
class ForbizMallOrderController extends ForbizMallController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 주문 배송지 조회(기본배송지)
     */
    public function addressList()
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        $list = $orderModel->getAddressList(sess_val('user', 'code'));

        $this->setResponseData(['list' => $list]);
    }

	/**
     * 주문 배송지 조회(최근배송지)
     */
    public function addressListOrder()
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        $list = $orderModel->getAddressListOrder(sess_val('user', 'code'));

        $this->setResponseData(['list' => $list]);
    }

    /**
     * get 변동 주문 데이터
     */
    public function getChangeOrderData()
    {
        $chkList = ['recipientList[]', 'payment[]'];

        if (form_validation($chkList)) {
            $recipientList = $this->input->post('recipientList');
            $coupon = $this->input->post('coupon');
            $payment = $this->input->post('payment');

            /* @var $cartModel CustomMallCartModel */
            $cartModel = $this->import('model.mall.cart');

            $summary = false;

            //주문 배송지별 상품 정보 등록
            foreach ($recipientList as $recipient) {
                //get 배송지별 상품 정보
                $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon);
                $cartSummary = $cartModel->getSummary($cartList);

                if ($summary === false) {
                    $summary = $cartSummary['summary'];
                } else {
                    array_walk($summary, array($this, 'sumCartSummary'), $cartSummary['summary']);
                }
            }

            unset($summary['tax_price']);
            unset($summary['tax_free_price']);

            $summary['origin_payment_price'] = $summary['payment_price'];
            $summary['use_mileage'] = ($payment['mileage'] ?? 0);
            if ($summary['payment_price'] < $summary['use_mileage']) {
                $summary['use_mileage'] = $summary['payment_price'];
                $summary['payment_price'] = 0;
            } else {
                $summary['payment_price'] -= $summary['use_mileage'];
            }
            //주문정보 조회 및 처리
            $this->setResponseData($summary);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * get 배송지 정보
     */
    public function getAddressBook()
    {
        $deliveryIx = $this->input->post('deliveryIx');

        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        $this->setResponseData($memberModel->getAddressBookItem(sess_val('user', 'code'), $deliveryIx));
    }

    /**
     * 결제 요청
     */
    public function paymentRequest()
    {
        $buyer = $this->input->post('buyer');
        $recipientList = $this->input->post('recipientList');
        $coupon = $this->input->post('coupon');
        $payment = $this->input->post('payment');

        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');

        $userCode = sess_val('user', 'code');

        $productListprice = 0;
        $productDcprice = 0;
        $totalDeliveryPrice = 0;
        $totalPrice = 0;
        $taxPrice = 0;
        $taxFreePrice = 0;

        foreach ($recipientList as $recipientKey => $recipient) {
            $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon);
            //상품 전체 판매중 검증
            if (!$cartModel->checkAllProductStatusSale($cartList)) {
                $this->setResponseResult('noProductStatusSale');
                return;
            }
            $cartSummary = $cartModel->getSummary($cartList);
            $productListprice += $cartSummary['summary']['product_listprice'];
            $productDcprice += $cartSummary['summary']['product_dcprice'];
            $totalDeliveryPrice += $cartSummary['summary']['total_delivery_price'];
            $totalPrice += $cartSummary['summary']['payment_price'];

            $taxPrice += $cartSummary['summary']['tax_price'];
            $taxFreePrice += $cartSummary['summary']['tax_free_price'];

            $recipientList[$recipientKey]['cartList'] = $cartList;
        }

        //마일리지 사용 검증 처리 [s]
        $mileage = ($payment['mileage'] ?? 0);
        if (!empty($userCode) && $mileage > 0) {
            /* @var $mileageModel CustomMallMileageModel */
            $mileageModel = $this->import('model.mall.mileage');
            $userMileage = $mileageModel->getUserAmount();

            $mileageFailData = [
                'mileageName' => $mileageModel->getName()
                , 'mileageUnit' => $mileageModel->getUnit()
            ];

            //보유하고 계신 {mileage} {mileageName} 이하로만 사용 가능합니다.
            if ($mileage > $userMileage) {
                $mileageFailData['mileage'] = number_format($userMileage);
                $this->setResponseResult('overUseMileage');
                $this->setResponseData($mileageFailData);
                return;
            }
            //보유 {mileageName}가 {mileage}{mileageUnit} 이상일 경우에만 사용 가능합니다.
            $mileageConditionMinMileage = $mileageModel->getConfig('min_mileage_price');
            if ($mileageConditionMinMileage > 0 && $userMileage < $mileageConditionMinMileage) {
                $mileageFailData['mileage'] = number_format($mileageConditionMinMileage);
                $this->setResponseResult('littleUserMinMileage');
                $this->setResponseData($mileageFailData);
                return;
            }

            //주문 상품 합계가 {price}원 이상일 경우에만 {mileageName}를 사용하실 수 있습니다.
            $mileageConditionIncludeDeliveryYn = $mileageModel->getConfig('deliveryprice');
            if ($mileageConditionIncludeDeliveryYn == 'Y') {
                $mileageTargetPrice = $totalPrice;
            } else {
                $mileageTargetPrice = $productDcprice;
            }
            $mileageConditionMinBuyAmt = $mileageModel->getConfig('total_order_price');
            if ($mileageConditionMinBuyAmt > 0 && $mileageTargetPrice < $mileageConditionMinBuyAmt) {
                $mileageFailData['price'] = number_format($mileageConditionMinBuyAmt);
                $this->setResponseResult('littleBuyAmt');
                $this->setResponseData($mileageFailData);
                return;
            }

            switch ($mileageModel->getConfig('mileage_one_use_type')) {
                case '1';
                    //보유 {mileageName}는 최대 {mileage}{mileageUnit}까지 사용 가능합니다.
                    $mileageConditionUseLimitValue = $mileageModel->getConfig('use_mileage_max');
                    if ($mileageConditionUseLimitValue > 0 && $mileage > $mileageConditionUseLimitValue) {
                        $mileageFailData['mileage'] = number_format($mileageConditionUseLimitValue);
                        $this->setResponseResult('overUseMaxmileagePrice');
                        $this->setResponseData($mileageFailData);
                        return;
                    }
                    break;
                case '2';
                    //보유 {mileageName}는 주문 상품 합계의 {rate}%인 {mileage}{mileageUnit}만 사용 가능합니다.
                    $mileageConditionUseLimitValue = $mileageModel->getConfig('max_goods_sum_rate');
                    $allowMileage = round($mileageTargetPrice * $mileageConditionUseLimitValue / 100);
                    if ($allowMileage < $mileage) {
                        $mileageFailData['rate'] = $mileageConditionUseLimitValue;
                        $mileageFailData['mileage'] = number_format($allowMileage);
                        $this->setResponseResult('overUseMaxmileageRate');
                        $this->setResponseData($mileageFailData);
                        return;
                    }
                    break;
            }

            //보유 {mileageName}는 최대 {mileage}{mileageUnit}까지 사용 가능합니다.
            if ($mileageTargetPrice < $mileage) {
                $mileageFailData['mileage'] = number_format($mileageTargetPrice);
                $this->setResponseResult('overUseMaxmileagePrice');
                $this->setResponseData($mileageFailData);
                return;
            }

            //{mileageName}는 {unit}원 단위로 입력해 주세요.
            $mileageConditionUseUnit = $mileageModel->getConfig('use_unit');
            if ($mileageConditionUseUnit != '1') {
                $unitNum = $mileage % $mileageConditionUseUnit;
                if ($unitNum != 0) {
                    $mileageFailData['unit'] = $mileageConditionUseUnit;
                    $this->setResponseResult('noFormatMileage');
                    $this->setResponseData($mileageFailData);
                    return;
                }
            }
        }
        //마일리지 사용 조건 처리 [e]

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        //주문번호 생성
        $oid = $orderModel->maxOid();

        //주문 배송지별 상품 정보 등록
        foreach ($recipientList as $recipient) {

            //배송지 등록
            $shippingData = [
                'name' => $recipient['name']
                , 'tel' => $recipient['tel']
                , 'mobile' => $recipient['mobile']
                , 'email' => ''
                , 'zip' => $recipient['zip']
                , 'addr1' => $recipient['addr1']
                , 'addr2' => $recipient['addr2']
                , 'msg_type' => $recipient['msg_type']
                , 'msg' => $recipient['msg']
            ];
            $odd_ix = $orderModel->insertOrderShipping($oid, $shippingData);

            //배송지 목록에 추가
            if (!empty($userCode) && $recipient['addAddressBookYn'] == 'Y') {
                $addressBookData = [
                    'shipping_name' => $recipient['name']
                    , 'recipient' => $recipient['name']
                    , 'tel' => $recipient['tel']
                    , 'mobile' => $recipient['mobile']
                    , 'zip' => $recipient['zip']
                    , 'addr1' => $recipient['addr1']
                    , 'addr2' => $recipient['addr2']
                    , 'default_yn' => $recipient['baiscAddressBookYn']
                ];

                $addressBookIx = $memberModel->searchAddressBook($userCode, $addressBookData);
                if ($addressBookIx !== false) {
                    $addressBookData['ix'] = $addressBookIx;
                    $addressBookData['mode'] = 'update';
                } else {
                    $addressBookData['mode'] = 'insert';
                }
                $memberModel->addressBookReplace($userCode, $addressBookData);
            }

            //get 배송지별 상품 정보
            foreach ($recipient['cartList'] as $cartCompany) {
                foreach ($cartCompany['deliveryTemplateList'] as $cartDeliveryTemplate) {
                    //배송비 등록
                    $deliveryData = [
                        'company_id' => $cartCompany['company_id']
                        , 'dt_ix' => $cartDeliveryTemplate['dt_ix']
                        , 'delivery_price' => $cartDeliveryTemplate['total_delivery_price'] //배송비
                        , 'delivery_dcprice' => $cartDeliveryTemplate['total_delivery_price'] //할인된최종배송비
                    ];
                    $ode_ix = $orderModel->insertOrderDelivery($oid, $deliveryData);

                    foreach ($cartDeliveryTemplate['productList'] as $cartProduct) {
                        //상품 등록
                        $mainPromotion = $this->input->cookie("main_promotion");
                        $eventContribution = $this->input->cookie("event_contribution");
                        $productData = [
                            'rfid' => $this->input->cookie("RFID")
                            , 'kwid' => $this->input->cookie("KWID")
                            , 'mpr_ix' => ($mainPromotion[$cartProduct['id']] ?? '')
                            , 'event_ix' => ($eventContribution[$cartProduct['id']] ?? '')
                            , 'buyer_type' => ($cartModel->getSellingType() == 'W' ? '2' : '1')//1:소매,2:도매
                            , 'order_from' => 'self'
                            , 'option_kind' => $cartProduct['option_kind']
                            , 'option_id' => $cartProduct['select_option_id']
                            , 'option_text' => $cartProduct['options_text']
                            , 'option_price' => $cartProduct['add_price']
                            , 'pcnt' => $cartProduct['pcount']
                            , 'listprice' => $cartProduct['listprice']
                            , 'psprice' => $cartProduct['sellprice']
                            , 'dcprice' => $cartProduct['dcprice']
                            , 'ptprice' => $cartProduct['sellprice'] * $cartProduct['pcount']
                            , 'pt_dcprice' => $cartProduct['total_coupon_with_dcprice']
                            , 'reserve' => $cartProduct['mileage']
                            , 'msgbyproduct' => ($recipient['product_msg'][$cartProduct['cart_ix']] ?? '')
                            , 'cart_ix' => $cartProduct['cart_ix']
                            , 'hash_idx' => $cartProduct['hash_idx']
                        ];
                        //특별할인 체크
                        $specialDiscountIndex = array_search('SP', array_column($cartProduct['discountList'], 'type'));
                        if ($specialDiscountIndex !== false) {
                            $productData['special_discount_yn'] = 'Y';
                            $productData['special_discount_commission'] = $cartProduct['discountList'][$specialDiscountIndex]['commission'];
                        }
                        $od_ix = $orderModel->insertOrderProduct(MALL_IX, $oid, $cartProduct['id'], $ode_ix, $odd_ix, $productData);

                        //상품 할인 정보 등록
                        foreach ($cartProduct['discountList'] as $cartDiscount) {
                            if ($cartDiscount['type'] != 'IN') { //즉시 할인 제외
                                //상품 등록
                                $discountData = [
                                    'dc_type' => $cartDiscount['type']
                                    , 'dc_title' => $cartDiscount['title']
                                    , 'dc_rate' => $cartDiscount['sale_value']
                                    , 'dc_price' => $cartDiscount['discount_amount']
                                    , 'dc_price_admin' => $cartDiscount['headoffice_discount_amount']
                                    , 'dc_price_seller' => $cartDiscount['seller_discount_amount']
                                    , 'dc_msg' => $cartDiscount['description']
                                    , 'dc_ix' => $cartDiscount['code']
                                ];
                                if ($cartDiscount['sale_type'] == "1") {
                                    $discountData['dc_rate_admin'] = $cartDiscount['headoffice_sale_value'];
                                    $discountData['dc_rate_seller'] = $cartDiscount['seller_sale_value'];
                                } else {
                                    $discountData['dc_rate_admin'] = 0;
                                    $discountData['dc_rate_seller'] = 0;
                                }
                                $orderModel->insertOrderDiscount($oid, $od_ix, '', $discountData);
                            }
                        }
                        //추가 상품 등록
                        foreach ($cartProduct['addOptionList'] as $cartAddOption) {
                            //위 상품정보 기본으로 받아서 처리
                            $productData['option_kind'] = 'a';
                            $productData['option_id'] = $cartAddOption['opn_d_ix'];
                            $productData['option_text'] = $cartAddOption['opn_text'];
                            $productData['option_price'] = 0;
                            $productData['pcnt'] = $cartAddOption['opn_count'];
                            $productData['listprice'] = $cartAddOption['listprice'];
                            $productData['psprice'] = $cartAddOption['sellprice'];
                            $productData['dcprice'] = $cartAddOption['dcprice'];
                            $productData['ptprice'] = $cartAddOption['total_dcprice'];
                            $productData['pt_dcprice'] = $cartAddOption['total_dcprice'];
                            $productData['reserve'] = $cartAddOption['mileage'];

                            $orderModel->insertOrderProduct(MALL_IX, $oid, $cartProduct['id'], $ode_ix, $odd_ix, $productData);
                        }
                    }
                }
            }
        }

        //주문 정보 등록

        $paymentPrice = $totalPrice - $mileage; //결제금액(예치금,포인트,적립금차감금액)

        $orderData = [
            'order_pw' => ($buyer['password'] ?? '')
            , 'buyer_type' => ($cartModel->getSellingType() == 'W' ? '2' : '1') //1:소매,2:도매
            , 'user_code' => $userCode
            , 'user_com_id' => sess_val('user', 'company_id')
            , 'buserid' => sess_val('user', 'id')
            , 'bname' => $buyer['name']
            , 'sex' => sess_val('user', 'sex')
            , 'age' => sess_val('user', 'age')
            , 'gp_ix' => sess_val('user', 'gp_ix')
            , 'mem_group' => sess_val('user', 'gp_name')
            , 'btel' => $buyer['tel'] ?? ''
            , 'bmobile' => $buyer['mobile']
            , 'bmail' => $buyer['email'] ?? ''
            , 'bzip' => ''
            , 'baddr' => ''
            , 'mem_reg_date' => sess_val('user', 'mem_reg_date')
            , 'org_delivery_price' => $totalDeliveryPrice
            , 'delivery_price' => $totalDeliveryPrice
            , 'org_product_price' => $productListprice
            , 'product_price' => $productDcprice
            , 'total_price' => $totalPrice
            , 'payment_price' => $paymentPrice
            , 'user_ip' => $this->input->server('REMOTE_ADDR')
            , 'user_agent' => $this->input->server('HTTP_USER_AGENT')
            , 'payment_agent_type' => (is_mobile() ? "M" : "W")
        ];
        if (getAppType()) {
            $orderData['payment_agent_type'] = 'A';
        }

        $orderModel->insertOrder($oid, $orderData);

        //주문 금액 등록
        $priceData = [
            'expect_price' => $orderData['product_price']
            , 'payment_price' => 0
            , 'reserve' => $mileage
        ];
        $orderModel->insertOrderPrice($oid, 'G', 'P', $priceData);
        if ($orderData['delivery_price'] > 0) {
            $priceData = [
                'expect_price' => $orderData['delivery_price']
                , 'payment_price' => 0
            ];
            $orderModel->insertOrderPrice($oid, 'G', 'D', $priceData);
        }

        //주문 결제 등록
        $taxData = $orderModel->calculationPaymentPriceTaxRate($taxPrice, $taxFreePrice, $mileage);
        $paymentData = [
            'tax_price' => $taxData['taxPrice']
            , 'tax_free_price' => $taxData['taxFreePrice']
        ];
        if ($paymentPrice == 0) {
            $paymentMethod = ORDER_METHOD_NOPAY;
        } else {
            $paymentMethod = $payment['method'];
        }
        $orderModel->insertOrderPayment($oid, 'G', ORDER_STATUS_INCOM_READY, $paymentMethod, $paymentPrice, $paymentData);
        if ($mileage > 0) {
            $paymentData = [
                'tax_price' => $taxData['mileageTaxPrice']
                , 'tax_free_price' => $taxData['mileageTaxFreePrice']
            ];
            $orderModel->insertOrderPayment($oid, 'G', ORDER_STATUS_INCOM_READY, ORDER_METHOD_RESERVE, $mileage, $paymentData);
        }

        //주문 히스토리 등록
        $historyData = [
            'status_message' => '주문데이터생성'
            , 'admin_message' => 'system'
        ];
        $orderModel->insertOrderHistory($oid, '', ORDER_STATUS_SETTLE_READY, $historyData);

        //주문번호 FlashData 생성
        $this->setFlashData('payment_oid', $oid);

        //주문정보 조회 및 처리
        $responseData = [
            'oid' => $oid
            , 'payment' => [
                'method' => $paymentMethod
                , 'payment_price' => $paymentPrice
            ]
        ];
        $this->setResponseData($responseData);
    }

    /**
     * 무료 결제 처리
     */
    public function paymentFree()
    {
        $oid = $this->getFlashData('payment_oid');

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');
        if (!empty($oid)) {
            if ($orderModel->isFreeOrderSettleReady($oid)) {
                //결제 처리
                $orderModel->payment($oid, ORDER_METHOD_NOPAY, ORDER_STATUS_INCOM_COMPLETE);
                //카트 삭제
                $products = $orderModel->getOrderProduct($oid);
                $cartIxs = [];
                foreach ($products as $product) {
                    $cartIxs[] = $product['cart_ix'];
                }
                $cartIxs = array_unique($cartIxs);
                $cartModel->delete($cartIxs);
                //주문번호 FlashData 생성
                $this->setFlashData('payment_oid', $oid);
            } else {
                $this->setResponseResult('noSettleReady');
            }
        } else {
            $this->setResponseResult('noOid');
        }
    }

    /**
     * 무통장 결제 처리
     */
    public function paymentBank()
    {
        $oid = $this->getFlashData('payment_oid');

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');
        if (!empty($oid)) {
            if ($orderModel->isBankOrderSettleReady($oid)) {
                //결제 처리
                $orderModel->payment($oid, ORDER_METHOD_BANK, ORDER_STATUS_INCOM_READY);
                //카트 삭제
                $products = $orderModel->getOrderProduct($oid);
                $cartIxs = [];
                foreach ($products as $product) {
                    $cartIxs[] = $product['cart_ix'];
                }
                $cartIxs = array_unique($cartIxs);
                $cartModel->delete($cartIxs);
                //주문번호 FlashData 생성
                $this->setFlashData('payment_oid', $oid);
            } else {
                $this->setResponseResult('noSettleReady');
            }
        } else {
            $this->setResponseResult('noOid');
        }
    }

    /**
     * PG 결제 처리
     */
    public function paymentGateway()
    {
        $oid = $this->getFlashData('payment_oid');
        $method = $this->input->post('method');
        $agentType = $this->input->post('agentType');

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        if (!empty($oid)) {
            if ($orderModel->isOrderSettleReady($oid, $method)) {
                /* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
                $paymentGatewayModel = $this->import('model.mall.payment.gateway');
                $paymentGatewayModel->init($paymentGatewayModel->getPayModuleNameByMethod($method), $agentType);

                $order = $orderModel->getOrder($oid);
                $products = $orderModel->getOrderProduct($oid);

                $orderMainGoodsName = "";
                $orderProductName = "";
                $totalPcnt = 0;
                foreach ($products as $product) {
                    if (empty($orderMainGoodsName)) {
                        $orderMainGoodsName = $orderProductName = $product['pname'];
                    }
                    $totalPcnt += $product['pcnt'];
                }
                $orderProductCnt = count($products);
                $orderProductName = str_cut($orderProductName, 39);
                if ($orderProductCnt > 1) {
                    $orderProductName = $orderProductName . " 외 " . ($orderProductCnt - 1) . "건";
                }

                $paymentInfos = $orderModel->getPaymentInfo($oid, 'G');
                $paymentInfo = [];
                foreach ($paymentInfos as $payInfo) {
                    if ($payInfo['method'] == $method) {
                        $paymentInfo = $payInfo;
                        break;
                    }
                }

                $pgPaymentData = new PgForbizPaymentData();
                $pgPaymentData->oid = $oid;
                $pgPaymentData->goodsCount = $orderProductCnt;
                $pgPaymentData->totalPcnt = $totalPcnt;
                $pgPaymentData->mainGoodsName = $orderMainGoodsName;
                $pgPaymentData->goodsName = $orderProductName;
                $pgPaymentData->amt = $paymentInfo['payment_price'];
                $pgPaymentData->taxAmt = $paymentInfo['tax_price'];
                $pgPaymentData->taxExAmt = $paymentInfo['tax_free_price'];
                $pgPaymentData->method = $paymentInfo['method'];
                $pgPaymentData->buyerId = $order['buserid'];
                $pgPaymentData->buyerName = $order['bname'];
                $pgPaymentData->buyerMobile = $order['bmobile'];
                $pgPaymentData->buyerEmail = $order['bmail'];
                $pgPaymentData->goodsList = $products;
                if ($method == ORDER_METHOD_VBANK) {
                    $cancelAutoDay = ForbizConfig::getMallConfig('mall_cc_interval');
                    $holiday_text = ForbizConfig::getMallConfig('holiday_text');
                    if (empty($cancelAutoDay)) {
                        $vbankExpirationDate = date('Ymd', strtotime('+7 day'));
                    } else {
                        $vbankExpirationDate = $this->holiday($holiday_text, $cancelAutoDay);
                    }
                    $pgPaymentData->vbankExpirationDate = $vbankExpirationDate;
                }

                $this->setResponseData([
                    'html' => $paymentGatewayModel->requestPaymentForm($pgPaymentData)
                ]);
            } else {
                $this->setResponseResult('noSettleReady');
            }
        } else {
            $this->setResponseResult('noOid');
        }
    }

    /**
     * cart summary data sum
     * @param type $value
     * @param type $key
     * @param type $data
     */
    protected function sumCartSummary(&$value, $key, $data)
    {
        if ($key == 'productDiscountList') {
            foreach ($value as $discount) {
                if (!isset($data['productDiscountList'])) {
                    $data['productDiscountList'] = [];
                }
                $index = array_search($discount['type'], array_column($data['productDiscountList'], 'type'));
                if ($index === false) {
                    $data['productDiscountList'][] = [
                        'type' => $discount['type']
                        , 'title' => $discount['title']
                        , 'discount_amount' => $discount['discount_amount']
                    ];
                } else {
                    $data['productDiscountList'][$index]['discount_amount'] += $discount['discount_amount'];
                }
            }
        } else {
            if (!isset($data[$key])) {
                $data[$key] = 0;
            }
            $data[$key] += $value;
        }
    }

    /**
     * vbankExpirationDate  생성
     * 관리자 자동 주문 취소일 + 주말 + 휴가 일 만큼 더하고 날짜로 반환
     * @return date
     */
    protected function holiday($holiday_text = "", $mall_cc_interval = 7)
    {
        $order_date = date('Ymd'); //오늘 주문일        
        $ex_holiday = explode(',', $holiday_text); //추가 휴일

        //영업일 기준으로 일단 형변환해서 날짜를 가지고 있음
        $date = date('Ymd', strtotime($order_date));  //비교 날짜
        $odate = date('Ymd', strtotime($order_date)); //입금 날짜

        //자동 취소일 만큼 실행
        for ($i = 0; $mall_cc_interval >= 0; $i++) {
            $is_holiy = false; //휴일 인지 여부 체크
            //해당일이 토요일 일요일 인지 구분
            if (date('w', strtotime($date)) == 0 || date('w', strtotime($date)) == 6) {
                $is_holiy = true;
            } else {
                //나머지 평일 ** 휴일 + 공휴일이 겹쳐도 카운트 되지 않음 평일만 뽑기때문
                //설정 휴일 값 계산
                foreach ($ex_holiday as $key => $val) {
                    //현재 날짜와 휴일 값이 같으면 휴일로 추가
                    if (strtotime($val) && strtotime($val) == strtotime($date)) {
                        $is_holiy = true;
                    }
                }
            }

            if ($is_holiy) {
                //휴일 추가
                $odate = date('Ymd', strtotime($odate . '+1 day'));
            } else {
                //일반 영업일 추가 일반일 이니 루프 카운트 차감 * 차감 로직상 0 번째는 더하지 않음
                if ($mall_cc_interval > 0) {
                    $odate = date('Ymd', strtotime($odate . '+1 day'));
                }
                $mall_cc_interval--;
            }

            //비교날짜 +1
            $date = date('Ymd', strtotime($date . '+1 day'));

            //무한 루프 방지. 최대 365일을 넘어갈수는 없다.
            if ($i >= 365) break;
        }

        return $odate;
    }
}