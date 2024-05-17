<?php

/**
 * Description of CustomMallOrderController
 *
 * @author hoksi
 */
class CustomMallOrderController extends ForbizMallOrderController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 결제 요청
     */
    public function paymentRequest()
    {

        $chkField = ['recipientList[]', 'payment[]'];
        if (form_validation($chkField)) {
            $buyer = $this->input->post('buyer');
            $recipientList = $this->input->post('recipientList');
            $coupon = $this->input->post('coupon');
            $deliveryCoupon = $this->input->post('deliveryCoupon');
            $payment = $this->input->post('payment');
            $freeGift = $this->input->post('freeGift');
            $freeGiftOrder = $this->input->post('freeGiftOrder');

            //사은품 선택 여부 값
            $giftSelect = $this->input->post('giftSelect');
            $giftSelectC = $this->input->post('giftSelectC');
            $giftSelectP = $this->input->post('giftSelectP');



            log_message('error', '주문자정보 : ' . json_encode($recipientList, JSON_UNESCAPED_UNICODE));

            //$freeGift = $freeGift == '' ? false : $freeGift;

            /* @var $cartModel CustomMallCartModel */
            $cartModel = $this->import('model.mall.cart');

            $userCode = $this->userInfo->code;

            $productListprice = 0;
            $productDcprice = 0;
            $totalOrgDeliveryPrice = 0;
            $totalDeliveryPrice = 0;
            $sumDeliveryPrice = 0;
            $sumAddDeliveryPrice = 0;
            $totalPrice = 0;
            $taxPrice = 0;
            $taxFreePrice = 0;

            //장바구니 쿠폰 체크 하여 $cartModel->get 함수 호출하여 $totalProductDcprice 값으로 쿠폰 할인값 구한후 $cartCouponData 로 필요한 데이터 추가로 넘겨서 처리
            //세트상품 쿠폰 사용도 동일
            $setProductUseCouponBool = false;
            $setProductCouponData = false;
            $cartRegistIx = ($coupon['cart'] ?? 0);
            $deliveryRegistIx = ($deliveryCoupon['delivery'] ?? 0);

            if (is_array($coupon)) {
                foreach ($coupon as $cartIx => $registIx) {
                    if (substr_count($cartIx, '|') > 0) {
                        $coupon[str_replace("|", ",", $cartIx)] = $registIx;
                        unset($coupon[$cartIx]);
                        if ($registIx > 0) {
                            $setProductUseCouponBool = true;
                        }
                    }
                }
            }

            // 배송지 정보
            foreach ($recipientList as $recipientKey => $recipient) {
                // 장바구니 정보 조회

                $cartCouponData = false;
                $reGetCartBool = false;
                $deliveryCouponData = false;
                if ($cartRegistIx > 0 || $setProductUseCouponBool === true || $deliveryRegistIx > 0) {
                    /* @var $couponModel CustomMallCouponModel */
                    $couponModel = $this->import('model.mall.coupon');

                    $list = [];
                    $cartLastCartIx = '';
                    $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon);
                    if (!empty($cartList)) {
                        foreach ($cartList as $cartDataKey => $data) {
                            foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {
                                foreach ($deliveryTemplate['productList'] as $key => $product) {

                                    //세트 쿠폰
                                    $registIx = ($coupon[$product['cart_ix']] ?? 0);
                                    if ($setProductUseCouponBool && $registIx > 0 && substr_count($product['cart_ix'], ',') > 0 && $product['total_dcprice']
                                        > 0
                                    ) {
                                        $_setProductCouponData = $couponModel->applyProductCoupon($registIx, $product['id'], $product['dcprice'],
                                            $product['total_dcprice']);
                                        if ($_setProductCouponData !== false) {
                                            $_setProductCouponData['type'] = 'CP';
                                            $_setProductCouponData['title'] = ForbizConfig::getDiscount('CP');
                                            $_setProductCouponData['total_product_dcprice'] = $product['total_dcprice'];
                                            $setCartIxList = explode(",", $product['cart_ix']);
                                            $_setProductCouponData['last_cart_ix'] = array_pop($setCartIxList);
                                            $_setProductCouponData['sum_discount_amount'] = 0;
                                            $_setProductCouponData['sum_headoffice_discount_amount'] = 0;

                                            if ($setProductCouponData === false) {
                                                $setProductCouponData = [];
                                            }
                                            $setProductCouponData[$product['set_group']] = $_setProductCouponData;
                                            $reGetCartBool = true;
                                        }
                                    }

                                    if ($cartRegistIx > 0 && $product['total_dcprice'] > 0) {
                                        $cartLastCartIx = $product['cart_ix'];
                                    }

                                    $list[] = $product;
                                }
                            }
                        }
                    }
                    $cartSummary = $cartModel->getSummary($cartList);
                    $totalProductDcprice = $cartSummary['summary']['product_dcprice'];

                    $cartCouponData = $couponModel->applyCartCoupon($cartRegistIx, $totalProductDcprice, $list);
                    if ($cartCouponData !== false) {
                        $cartCouponData['type'] = 'CP';
                        $cartCouponData['title'] = ForbizConfig::getDiscount('CP');
                        $cartCouponData['last_cart_ix'] = $cartLastCartIx;
                        $cartCouponData['total_product_dcprice'] = $cartCouponData['targetPrice'];
                        $cartCouponData['sum_discount_amount'] = 0;
                        $cartCouponData['sum_headoffice_discount_amount'] = 0;
                        $reGetCartBool = true;
                    }

                    $chkTotalDeliveryPrice = $cartSummary['summary']['delivery_price'];
                    $deliveryCouponData = $couponModel->applyDeliveryCoupon($deliveryRegistIx, $chkTotalDeliveryPrice, $list);

                    if ($deliveryCouponData !== false) {
                        $deliveryCouponData['type'] = 'DCP';
                        $deliveryCouponData['title'] = ForbizConfig::getDiscount('DCP');
                        $deliveryCouponData['last_cart_ix'] = $cartLastCartIx;
                        $deliveryCouponData['total_delivery_price'] = $deliveryCouponData['targetPrice'];
                        $deliveryCouponData['sum_discount_amount'] = 0;
                        $deliveryCouponData['sum_headoffice_discount_amount'] = 0;
                        $reGetCartBool = true;
                    }
                } else {
                    $reGetCartBool = true;
                }

                if ($reGetCartBool) {
                    $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon, true, $cartCouponData, $setProductCouponData,$deliveryCouponData);
                    $cartSummary = $cartModel->getSummary($cartList);
                }

                $productListprice += $cartSummary['summary']['product_listprice'];
                $productDcprice += $cartSummary['summary']['product_dcprice'];

                $totalOrgDeliveryPrice += $cartSummary['summary']['org_total_delivery_price'];
                $totalDeliveryPrice += $cartSummary['summary']['total_delivery_price'];
                $sumDeliveryPrice += $cartSummary['summary']['delivery_price'];
                $sumAddDeliveryPrice += $cartSummary['summary']['delivery_add_price'];

                $totalPrice += $cartSummary['summary']['payment_price'];

                $taxPrice += $cartSummary['summary']['tax_price'];
                $taxFreePrice += $cartSummary['summary']['tax_free_price'];

                $recipientList[$recipientKey]['cartList'] = $cartList;
                //상품 전체 판매중 검증
                if (!$cartModel->checkAllProductStatusSale($cartList)) {
                    $this->setResponseResult('noProductStatusSale');
                    return;
                }
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



            //구매금액대별 사은품 최종 체크[S]
            $giftCheckPrice = $totalPrice - $mileage - $totalDeliveryPrice;

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');
            if(isset($freeGiftOrder)){

                //선택된 사은품의 갯수와 설정된 갯수를 체크 하기 위한 데이터 [S]
                $freeGiftCntCheckData = [];
                //선택된 사은품의 갯수와 설정된 갯수를 체크 하기 위한 데이터 [E]
                foreach($freeGiftOrder as $key=>$freeGiftOrderItem){

                    //선택된 사은품의 갯수와 설정된 갯수를 체크 하기 위한 데이터 [S]
                    if(!isset($freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['cnt'])){
                        $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['cnt'] = 0;
                    }
                    $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['cnt'] += $freeGiftOrderItem['giftCount'];
                    $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['fgIx'] = $freeGiftOrderItem['fgIx'];
                    $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['freegift_condition'] = $freeGiftOrderItem['freegift_condition'];
                    //선택된 사은품의 갯수와 설정된 갯수를 체크 하기 위한 데이터 [E]

                    switch($freeGiftOrderItem['freegift_condition']){
                        case 'G';
                            $checkGiftSelect = $giftSelect;
                            $freeGiftArray = $productModel->getFreeGiftNew($freeGiftOrderItem['freegift_condition'],$giftCheckPrice,'','',$cartList);
                            $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['checkGiftSelect'] = $giftSelect;
                            break;
                        case 'P';
                            $checkGiftSelect = $giftSelectP;
                            $freeGiftArray = $productModel->getFreeGiftByProducts($cartList,$giftCheckPrice);
                            $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['checkGiftSelect'] = $giftSelectP;
                            break;
                        case 'C';
                            $checkGiftSelect = $giftSelectC;
                            $freeGiftArray = $productModel->getFreeGiftByCategory($cartList);
                            $freeGiftCntCheckData[$freeGiftOrderItem['fgIx']]['checkGiftSelect'] = $giftSelectC;
                            break;
                    }

                    //구매금액대별 사은품이 존재하지 않는데 선택된 사은품이 있을 경우 체크 (보통 가격변조에 따른 선 사은품 선택 후 할인 적용 시 발생)
                    if(!isset($freeGiftArray['fg_ix']) && isset($freeGiftOrderItem) && $checkGiftSelect == 'true'){
                        $this->setResponseResult('giftCheckFail')->setResponseData($freeGiftOrderItem);
                        return;
                    }

                    //구매금액이 변경되어 사은품 정보가 변경되어야 하는데 변경되지 않았을때
                    /*if(isset($freeGiftArray['fg_ix']) && isset($freeGiftOrderItem) && $checkGiftSelect == 'true' ){
                        if($freeGiftOrderItem['fgIx'] != $freeGiftArray['fg_ix']){
                            $this->setResponseResult('giftCompareFail');
                            return;
                        }
                    }*/

                    //구매금액대별 사은품 필수 선택 체크
                    if(isset($freeGiftArray['gift_products']) && !isset($freeGiftOrderItem) && $checkGiftSelect == 'false'){
                        $this->setResponseResult('selectGiftOrder');
                        return;
                    }
                }

                //사은품 지급 수량과 실제로 선택한 수량이 다른경우 체크
                /*if(is_array($freeGiftCntCheckData) && count($freeGiftCntCheckData) > 0){
                    foreach($freeGiftCntCheckData as $checkData){

                         @var $orderModel CustomMallOrderModel
                        $orderModel = $this->import('model.mall.order');
                        $giftCntResult = $orderModel->getGiftItemCntCheck(array($checkData));
                        if($giftCntResult['giftCntBool'] === false && $checkData['checkGiftSelect'] == 'true'){
                            $this->setResponseResult('giftCntCheckFail')->setResponseData($giftCntResult);
                            return;
                        }
                    }
                }*/

                //사은품 재고 채크 방식 변경
                //구매금액별, 카테고리별, 특정상품 포함 이 추가 됨에 따라 동일한 사은품이 각각 포함 될 경우 해당 상품의 수량이 합산되어 계산되어야 하기 때문에
                //재고 체크는 개별로 분리 함

                $giftSelectCntArr = [];
               // print_r($freeGiftOrder);
                foreach($freeGiftOrder as $key=>$freeGiftOrderItem){
                    //선택된 사은품의 상품별 합산 수량을 구한다.
                    $giftPid = $freeGiftOrderItem['giftPid'];
                    if($giftPid != "55421"){ // qa : 55410 || stg / real : 55421
                        if(isset($giftSelectCntArr[$freeGiftOrderItem['giftPid']])){
                            $giftSelectCntArr[$freeGiftOrderItem['giftPid']] += $freeGiftOrderItem['giftCount'];
                        }else{
                            $giftSelectCntArr[$freeGiftOrderItem['giftPid']] = $freeGiftOrderItem['giftCount'];
                        }
                    }
                }

                if($giftPid != "55421"){ // qa : 55410 || stg / real : 55421
                    if(count($giftSelectCntArr) > 0){
                        /* @var $orderModel CustomMallOrderModel */
                        $orderModel = $this->import('model.mall.order');
                        $giftResult = $orderModel->getGiftItemStockCheck($giftSelectCntArr);
                        if($giftResult['giftStockBool'] === false){
                            $this->setResponseResult('giftItemStockFail')->setResponseData($giftResult);
                            return;
                        }
                    }
                }

                //구매금액대별 사은품 재고 체크
                //사은품이 존재하고, 선택한 사은품이 있을때 체크 1
                //사은품 선택안함을 선택했을때 예외처리
//                if( isset($freeGiftArray['gift_products']) && isset($freeGiftOrderItem) ) {
//                    /* @var $orderModel CustomMallOrderModel */
//                    $orderModel = $this->import('model.mall.order');
//                    $giftResult = $orderModel->getGiftItemStock(array($freeGiftOrderItem));
//                    if($giftResult['giftStockBool'] === false && $checkGiftSelect == 'true'){
//                        $this->setResponseResult('giftItemSoldOutFail')->setResponseData($giftResult);
//                        return;
//                    }
//                }

                //사은품이 품절되어 존재하지 않을때, 선택된 사은품이 있을 경우에대 체크 2
                //print_r($freeGiftArray);
//                if( !isset($freeGiftArray['gift_products']) && isset($freeGiftOrderItem) ) {
//                    /* @var $orderModel CustomMallOrderModel */
//                    $orderModel = $this->import('model.mall.order');
//                    $giftResult = $orderModel->getGiftItemStock(array($freeGiftOrderItem));
//                    if($giftResult['giftStockBool'] === false && $checkGiftSelect == 'true'){
//
//                        $this->setResponseResult('giftItemSoldOutFail')->setResponseData($giftResult);
//                        return;
//                    }
//                }
            }



            //금액대별 사은품이 맞는 지 확인 체크 (쿠폰 또는 마일리지를 사용하였을때 최종 결제 금액과 선택한 구매금액대별 사은품의 정합성 체크)


            //사용한 적립금 대비 적립될 적립금을 비율 제한 설정 진행 [S]
            //echo $totalDeliveryPrice; //추가 배송비 포함된 전체 배송비 금액
            //echo $sumDeliveryPrice; //추가 배송비가 포함되지 않은 배송금액 합계
            //배송 금액 산정시 적립금으로 도서산간 추가 배송비에 대해 사용처리가 가능 할 경우라면 $totalDeliveryPrice 를 사용하고 일반 배송비만 처리 가능할때는 $sumDeliveryPrice 를 사용한다
            //만약 추가 배송비까지 사용가능한 구조를 구현하려면 할인/혜택 적용 영역은 배송지 정보보다 하위에 있어야 정상적인 구동이 가능하며 주소 선택에 따른 배송금액 이 달라질 수 있기 때문에
            //해당 예외처리를 생각해야 한다.

            $deduction_value = $this->deductionMileage($productDcprice,$sumDeliveryPrice,$mileage);



            /* @var $orderModel CustomMallOrderModel */
            $orderModel = $this->import('model.mall.order');

            //주문번호 생성
            $oid = $orderModel->maxOid();

            //주문 배송지별 상품 정보 등록
            foreach ($recipientList as $recipient) {

                //배송지 등록 및 배송지 목록 추가
                $odd_ix = $this->registShpping($oid, $userCode, $recipient);

                //get 배송지별 상품 정보
                foreach ($recipient['cartList'] as $cartCompany) {
                    foreach ($cartCompany['deliveryTemplateList'] as $cartDeliveryTemplate) {
                        //배송비 등록
                        $deliveryData = [
                            'company_id' => $cartCompany['company_id']
                            , 'dt_ix' => $cartDeliveryTemplate['dt_ix']
                            , 'delivery_price' => $cartDeliveryTemplate['org_total_delivery_price'] //배송비
                            , 'delivery_dcprice' => $cartDeliveryTemplate['total_delivery_price'] //할인된최종배송비
                        ];
                        $ode_ix = $orderModel->insertOrderDelivery($oid, $deliveryData);

                        foreach ($cartDeliveryTemplate['productList'] as $cartProduct) {
                            //상품 등록
                            $mainPromotion = $this->input->cookie("main_promotion");
                            $eventContribution = $this->input->cookie("event_contribution");

                            // 세트 상품명
                            $set_name = '';
                            if ($cartProduct['set_group'] > 0) {
                                $tmpName = explode(':', $cartProduct['options_text']);
                                $set_name = $tmpName[0];
                                $set_group = $orderModel->getOrderSetGroup($oid, $cartProduct['set_group'], 0);
                            } else {
                                $set_group = null;
                            }

                            $msgbyproduct = ""; //개별 배송메세지 - 복수 타입일때만 들어감

                            //개별
                            //recipientList[0][product_msg][0][cart_ix]: 2383
                            //recipientList[0][product_msg][0][msg]: aa
                            //세트 
                            //recipientList[0][product_msg][0][cart_ix]: 2383, 2384
                            //recipientList[0][product_msg][0][msg]: aa
                            if (isset($recipient['product_msg'])) {
                                foreach ($recipient['product_msg'] as $key => $val) {
                                    if ($cartProduct['cart_ix'] == $val['cart_ix']) {
                                        $msgbyproduct = $val['msg'];
                                    } else {
                                        //세트 검출
                                        $cnt = 0;
                                        foreach (explode(",", $val['cart_ix']) as $value) {
                                            if ($cnt == 0) {
                                                if ($cartProduct['cart_ix'] == $value) {
                                                    $msgbyproduct = $val['msg'];
                                                }
                                            }
                                            $cnt++;
                                        }
                                    }
                                }
                            }


                            //사용한 적립금 대비 적립될 적립금을 비율 제한 설정 진행 (최종계산) [S]
                            if(BASIC_LANGUAGE == 'english') {
                                $reservePrice = f_decimal($cartProduct['mileage'] * $deduction_value)->round((defined('BCSCALE') ? BCSCALE : 0),\Decimal\Decimal::ROUND_HALF_UP);
                            }else{
                                $reservePrice = f_decimal($cartProduct['mileage'] * $deduction_value)->round((defined('BCSCALE') ? BCSCALE : 0),\Decimal\Decimal::ROUND_HALF_UP);
                            }
                            //사용한 적립금 대비 적립될 적립금을 비율 제한 설정 진행 (최종계산) [E]

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
                                , 'ptprice' => $cartProduct['total_ptprice']
                                , 'pt_dcprice' => $cartProduct['total_coupon_with_dcprice']
                                , 'reserve' => $reservePrice
                                , 'msgbyproduct' => $msgbyproduct
                                , 'cart_ix' => $cartProduct['cart_ix']
                                , 'cart_ix' => $cartProduct['cart_ix']
                                , 'hash_idx' => ($cartProduct['hash_idx'] ?? '') // 주문통계 수집
                                , 'set_group' => $set_group // 세트상품 그룹 설정
                                , 'set_name' => $set_name // 세트상품명
                                , 'parent_od_ix' => null
                                , 'gift_type' => 'N' // 사은품 아님
                                , 'choice_gift_prd' => $cartProduct['choice_gift']
                            ];

                            //특별할인 체크
                            $specialDiscountIndex = array_search('SP', array_column($cartProduct['discountList'], 'type'));
                            if ($specialDiscountIndex !== false) {
                                $productData['special_discount_yn'] = 'Y';
                                $productData['special_discount_commission'] = $cartProduct['discountList'][$specialDiscountIndex]['commission'];
                            }

                            //주문 상세정보 등록
                            $od_ix = $orderModel->insertOrderProduct(MALL_IX, $oid, $cartProduct['id'], $ode_ix, $odd_ix, $productData);

                            //상품 할인 정보 등록
                            foreach ($cartProduct['discountList'] as $cartDiscount) {
                                $discountData = $this->makeDiscountData($cartDiscount);
                                if ($discountData) {
                                    $orderModel->insertOrderDiscount($oid, $od_ix, '', $discountData);
                                }
                            }

                            //추가 상품 등록
                            foreach ($cartProduct['addOptionList'] as $cartAddOption) {
                                //위 상품정보 기본으로 받아서 처리
                                $productData = $this->makeAddOptionData($productData, $cartAddOption);

                                $orderModel->insertOrderProduct(MALL_IX, $oid, $cartProduct['id'], $ode_ix, $odd_ix, $productData);
                            }

                            //상품별 사은품 등록
                            foreach ($cartProduct['giftItem'] as $product_gift) {
                                $productData = $this->makeGiftData($product_gift['pid'], $cartProduct['cart_ix'], $product_gift['cnt'], $od_ix, 'G');

                                $orderModel->insertOrderProduct(MALL_IX, $oid, $product_gift['pid'], $ode_ix, $odd_ix, $productData);
                            }
                        }
                    }

                    //배송비쿠폰 정보 등록

                    if(isset($cartCompany['deliveryCoupon'])) {
                        $discountData = $this->makeDiscountData($cartCompany['deliveryCoupon']);
                        if ($discountData) {
                            $orderModel->insertOrderDiscount($oid, $od_ix, '', $discountData);
                        }
                    }
                }
            }

            //주문 정보 등록
            $paymentPrice = $totalPrice - $mileage; //결제금액(예치금,포인트,적립금차감금액)

            //구매금액별 사은품 등록
            if ($freeGiftOrder && count($freeGiftOrder) > 0) {
                foreach ($freeGiftOrder as $key => $val) {
                    $productData = $this->makeGiftData($val['giftPid'], null, $val['giftCount'], null, 'P',$val['freegift_condition']);
                    $orderModel->insertOrderProduct(MALL_IX, $oid, $val['giftPid'], $ode_ix, $odd_ix, $productData);
                }
            }

//            if($freeGift && count($freeGift) > 0){
//                foreach($freeGift as $freeGiftPid){
//                    if($this->chkFreeGift($freeGiftPid, $paymentPrice)){
//                        $productData = $this->makeGiftData($freeGiftPid, null, 1, null, 'P');
//                        $orderModel->insertOrderProduct(MALL_IX, $oid, $freeGiftPid, $ode_ix, $odd_ix, $productData);
//                    }
//                }
//            }

            //

            //사은품 선택 여부 및 존재여부 체크
            $conditionBool['G'] = false;
            $conditionBool['C'] = false;
            $conditionBool['P'] = false;
            if ($freeGiftOrder && count($freeGiftOrder) > 0) {
                foreach ($freeGiftOrder as $key => $val) {
                    $conditionBool[$val['freegift_condition']] = true;
                }
            }
            if($giftSelect == 'true'){
                if($conditionBool['G'] == true){
                    $choicePuchaseGift = 'Y';
                }else{
                    $choicePuchaseGift = 'N';
                }
            }else{
                $choicePuchaseGift = 'E';
            }

            if($giftSelectC == 'true'){
                if($conditionBool['C'] == true){
                    $choicePuchaseGiftC = 'Y';
                }else{
                    $choicePuchaseGiftC = 'N';
                }
            }else{
                $choicePuchaseGiftC = 'E';
            }

            if($giftSelectP == 'true'){
                if($conditionBool['P'] == true){
                    $choicePuchaseGiftP = 'Y';
                }else{
                    $choicePuchaseGiftP = 'N';
                }
            }else{
                $choicePuchaseGiftP = 'E';
            }

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
                , 'org_delivery_price' => $totalOrgDeliveryPrice
                , 'delivery_price' => $totalDeliveryPrice
                , 'org_product_price' => $productListprice
                , 'product_price' => $productDcprice
                , 'total_price' => $totalPrice
                , 'payment_price' => $paymentPrice
                , 'user_ip' => $this->input->server('REMOTE_ADDR')
                , 'user_agent' => $this->input->server('HTTP_USER_AGENT')
                , 'payment_agent_type' => (is_mobile() ? "M" : "W")
                , 'choice_gift_order' => $choicePuchaseGift
                , 'choice_gift_order_c' => $choicePuchaseGiftC
                , 'choice_gift_order_p' => $choicePuchaseGiftP
				, 'escrow_yn' => ($payment['method'] == 9 ? "Y" : "N")
            ];
            if (sess_val('app_type')) {
                $orderData['payment_agent_type'] = 'A';
            }

            // 주문정보 등록
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
        } else {
            // 폼검증 에러
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 추가 옵션 정보를 이용하여 상품 상세 데이터 생성
     * @param array $productData
     * @param array $cartAddOption
     * @return array
     */
    protected function makeAddOptionData($productData, $cartAddOption)
    {
        if (!empty($cartAddOption) && isset($cartAddOption['opn_d_ix'])) {
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
        }

        return $productData;
    }

    /**
     * 할인정보 생성
     * @param array $cartDiscount
     * @return array|boolean
     */
    protected function makeDiscountData($cartDiscount)
    {
        $discountData = false;


        if (isset($cartDiscount['type']) && $cartDiscount['type'] != 'IN') { //즉시 할인 제외
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
        }

        return $discountData;
    }

    /**
     * 사은품 주문상세 정보를 조합
     * @param int $cart_ix
     * @param int $pcount
     * @param int $od_ix
     * @param string $gift_type
     * @return array
     */
    protected function makeGiftData($pid, $cart_ix, $pcount, $od_ix, $gift_type,$freegift_condition="")
    {

        $row = $this->qb
            ->select('gu.gu_ix')
            ->select('gu.gid')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_INVENTORY_GOODS_UNIT . ' as gu', 'gu.gu_ix=p.pcode', 'left')
            ->where('p.id', $pid)
            ->exec()
            ->getRow();

        return [
            'rfid' => $this->input->cookie("RFID")
            , 'kwid' => $this->input->cookie("KWID")
            , 'mpr_ix' => ''
            , 'event_ix' => ''
            , 'buyer_type' => '1'
            , 'order_from' => 'self'
            , 'option_kind' => ''
            , 'option_id' => null
            , 'option_text' => ''
            , 'option_price' => 0
            , 'pcnt' => $pcount
            , 'listprice' => 0
            , 'psprice' => 0
            , 'dcprice' => 0
            , 'ptprice' => 0
            , 'pt_dcprice' => 0
            , 'reserve' => 0
            , 'msgbyproduct' => ''
            , 'cart_ix' => $cart_ix
            , 'parent_od_ix' => $od_ix
            , 'gift_type' => $gift_type
            , 'gift_condition' => $freegift_condition
            , 'gid' => ($row->gid ?? '')
            , 'gu_ix' => ($row->gu_ix ?? 0)
            , 'cid' => ''
            , 'set_group' => NULL
            , 'set_name' => ''
        ];
    }

    /**
     * 배송지 업데이트
     * @param string $userCode
     * @param array $recipient
     */
    protected function registShpping($oid, $userCode, $recipient)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        $shippingData = [
            'name' => $recipient['name']
            // , 'tel' => $recipient['tel']
            , 'mobile' => $recipient['mobile']
            , 'email' => ''
            , 'zip' => $recipient['zip']
            , 'addr1' => $recipient['addr1']
            , 'addr2' => $recipient['addr2']
            , 'msg_type' => $recipient['msg_type']
            , 'msg' => $recipient['msg']
            , 'country' => $recipient['country'] ?? ""
            , 'city' => $recipient['city'] ?? ""
            , 'state' => $recipient['state'] ?? ""
        ];
        $odd_ix = $orderModel->insertOrderShipping($oid, $shippingData);

        //배송지 목록에 추가
        if (!empty($userCode) && $recipient['addAddressBookYn'] == 'Y') {
            $addressBookData = [
                'shipping_name' => $recipient['name']
                , 'recipient' => $recipient['name']
                // , 'tel' => $recipient['tel']
                , 'mobile' => $recipient['mobile']
                , 'zip' => $recipient['zip']
                , 'addr1' => $recipient['addr1']
                , 'addr2' => $recipient['addr2']
                , 'country' => $recipient['country'] ?? ""
                , 'city' => $recipient['city'] ?? ""
                , 'state' => $recipient['state'] ?? ""
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

        return $odd_ix;
    }

    /**
     * 구매금액별 사은품 검증
     * @param int $pid
     * @param int $paymentPrice
     * @return boolean
     */
    public function chkFreeGift($pid, $paymentPrice)
    {
        $rows = $this->qb
            ->select('fg.fg_ix')
            ->select('fg.member_target')
            ->from(TBL_SHOP_FREEGIFT . ' AS fg')
            ->join(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS fpg', 'fg.fg_ix = fpg.fg_ix')
            ->whereIn('fg.fg_ix',
                $this->qb
                    ->startSubQuery()
                    ->select('fg_ix')
                    ->from(TBL_SHOP_FREEGIFT_PRODUCT_RELATION)
                    ->where('pid', $pid)
                    ->endSubQuery(), false
            )
            ->where('fg.fg_use_sdate <=', time())
            ->where('fg.fg_use_edate >=', time())
            ->where('fpg.sale_condition_s <=', $paymentPrice)
            ->where('fpg.sale_condition_e >=', $paymentPrice)
            ->exec()
            ->getResultArray();

        $pcnt = 0;
        if (!empty($rows)) {
            foreach ($rows as $row) {
                switch ($row['member_target']) {
                    case 'G': // 회원 그룹
                        $pcnt = $this->qb
                            ->from(TBL_SHOP_FREEGIFT_DISPLAY_RELATION)
                            ->where('r_ix', $this->userInfo->gp_ix)
                            ->getCount();
                        break;
                    case 'M': // 회원
                        $pcnt = $this->qb
                            ->from(TBL_SHOP_FREEGIFT_DISPLAY_RELATION)
                            ->where('r_ix', $this->userInfo->code)
                            ->getCount();
                        break;
                    case 'A': // 전체 회원
                        $pcnt = 1;
                        break;
                }

                if ($pcnt > 0) {
                    break;
                }
            }
        }

        return $pcnt > 0;
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
            $deliveryCoupon = $this->input->post('deliveryCoupon');
            $payment = $this->input->post('payment');

            /* @var $cartModel CustomMallCartModel */
            $cartModel = $this->import('model.mall.cart');

            $summary = false;

            //주문 배송지별 상품 정보 등록
            foreach ($recipientList as $recipient) {
                //get 배송지별 상품 정보

                $setProductUseCouponBool = false;
                $setProductCouponData = false;
                $cartCouponData = false;
                $deliveryCouponData = false;
                $reGetCartBool = false;

                //장바구니 쿠폰 체크 하여 $cartModel->get 함수 호출하여 $totalProductDcprice 값으로 쿠폰 할인값 구한후 $cartCouponData 로 필요한 데이터 추가로 넘겨서 처리
                //세트상품 쿠폰 사용도 동일
                $cartRegistIx = ($coupon['cart'] ?? 0);
                $deliveryRegistIx = ($deliveryCoupon['delivery'] ?? 0);
                if (is_array($coupon)) {
                    foreach ($coupon as $cartIx => $registIx) {
                        if (substr_count($cartIx, '|') > 0) {
                            $coupon[str_replace("|", ",", $cartIx)] = $registIx;
                            unset($coupon[$cartIx]);
                            if ($registIx > 0) {
                                $setProductUseCouponBool = true;
                            }
                        }
                    }
                }

                if ($cartRegistIx > 0 || $setProductUseCouponBool === true || $deliveryRegistIx > 0) {
                    /* @var $couponModel CustomMallCouponModel */
                    $couponModel = $this->import('model.mall.coupon');

                    $list = [];
                    $cartLastCartIx = '';
                    $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon);

                    if (!empty($cartList)) {
                        foreach ($cartList as $cartDataKey => $data) {
                            foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {
                                foreach ($deliveryTemplate['productList'] as $key => $product) {

                                    //세트 쿠폰
                                    $registIx = ($coupon[$product['cart_ix']] ?? 0);
                                    if ($setProductUseCouponBool && $registIx > 0 && substr_count($product['cart_ix'], ',') > 0 && $product['total_dcprice']
                                        > 0
                                    ) {
                                        $_setProductCouponData = $couponModel->applyProductCoupon($registIx, $product['id'], $product['dcprice'],
                                            $product['total_dcprice']);
                                        if ($_setProductCouponData !== false) {
                                            $_setProductCouponData['type'] = 'CP';
                                            $_setProductCouponData['title'] = ForbizConfig::getDiscount('CP');
                                            $_setProductCouponData['total_product_dcprice'] = $product['total_dcprice'];
                                            $setCartIxList = explode(",", $product['cart_ix']);
                                            $_setProductCouponData['last_cart_ix'] = array_pop($setCartIxList);
                                            $_setProductCouponData['sum_discount_amount'] = 0;
                                            $_setProductCouponData['sum_headoffice_discount_amount'] = 0;

                                            if ($setProductCouponData === false) {
                                                $setProductCouponData = [];
                                            }
                                            $setProductCouponData[$product['set_group']] = $_setProductCouponData;
                                            $reGetCartBool = true;
                                        }
                                    }

                                    if ($cartRegistIx > 0 && $product['total_dcprice'] > 0) {
                                        $cartLastCartIx = $product['cart_ix'];
                                    }

                                    $list[] = $product;
                                }
                            }
                        }
                    }

                    $cartSummary = $cartModel->getSummary($cartList);
                    $totalProductDcprice = $cartSummary['summary']['product_dcprice'];

                    $cartCouponData = $couponModel->applyCartCoupon($cartRegistIx, $totalProductDcprice, $list);
                    if ($cartCouponData !== false) {
                        $cartCouponData['type'] = 'CP';
                        $cartCouponData['title'] = ForbizConfig::getDiscount('CP');
                        $cartCouponData['last_cart_ix'] = $cartLastCartIx;
                        $cartCouponData['total_product_dcprice'] = $cartCouponData['targetPrice'];
                        $cartCouponData['sum_discount_amount'] = 0;
                        $cartCouponData['sum_headoffice_discount_amount'] = 0;
                        $reGetCartBool = true;
                    }

                    $totalDeliveryPrice = $cartSummary['summary']['delivery_price'];

                    $deliveryCouponData = $couponModel->applyDeliveryCoupon($deliveryRegistIx, $totalDeliveryPrice, $list);

                    if ($deliveryCouponData !== false) {
                        $deliveryCouponData['type'] = 'DCP';
                        $deliveryCouponData['title'] = ForbizConfig::getDiscount('DCP');
                        $deliveryCouponData['last_cart_ix'] = $cartLastCartIx;
                        $deliveryCouponData['total_delivery_price'] = $deliveryCouponData['targetPrice'];
                        $deliveryCouponData['sum_discount_amount'] = 0;
                        $deliveryCouponData['sum_headoffice_discount_amount'] = 0;
                        $reGetCartBool = true;
                    }
                } else {
                    $reGetCartBool = true;
                }

                if ($reGetCartBool) {
                    $cartList = $cartModel->get($recipient['cart_ix'], $recipient['zip'], $coupon, true, $cartCouponData, $setProductCouponData,$deliveryCouponData);
                    $cartSummary = $cartModel->getSummary($cartList);
                }
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


            //적립금 사용양 제외 설정 시 예상마일리지 금액 변경을 위한 처리
            $deduction_value = $this->deductionMileage($summary['product_dcprice'],$summary['delivery_price'],$summary['use_mileage']);
            if(BASIC_LANGUAGE == 'english') {
                $reservePrice = f_decimal($summary['mileage'] * $deduction_value)->round((defined('BCSCALE') ? BCSCALE : 0),\Decimal\Decimal::ROUND_HALF_UP);
            }else{
                $reservePrice = f_decimal($summary['mileage'] * $deduction_value)->round((defined('BCSCALE') ? BCSCALE : 0),\Decimal\Decimal::ROUND_HALF_UP);
            }

            $summary['mileage'] = $reservePrice;
            $summary['deduction_value'] = $deduction_value;

            //주문정보 조회 및 처리
            $this->setResponseData($summary);
//            $this->setResponseData(array_merge($summary,['cartList' => $cartList]));
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function applyUserCartCouponList()
    {

        $totalProductDcprice = f_decimal($this->input->post('totalProductDcprice'));
        $cartIxs = $this->input->post('cartIxs');
        $coupon = $this->input->post('coupon');
        $selectedCartCouponIx = $this->input->post('selectedCartCouponIx');

        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');
        /* @var $couponModel CustomMallCouponModel */
        $couponModel = $this->import('model.mall.coupon');

        $cartData = $cartModel->get($cartIxs);

        $productUseCouponBool = false;
        $setProductUseCouponBool = false;
        if (is_array($coupon)) {
            foreach ($coupon as $cartIx => $registIx) {
                $productUseCouponBool = true;
                if (substr_count($cartIx, '|') > 0) {
                    $coupon[str_replace("|", ",", $cartIx)] = $registIx;
                    unset($coupon[$cartIx]);
                    if ($registIx > 0) {
                        $setProductUseCouponBool = true;
                    }
                }
            }
        }

        $setProductCouponData = false;
        if ($productUseCouponBool === true || $setProductUseCouponBool === true) {
            $cartData = $cartModel->get($cartIxs, '', $coupon);
            if (!empty($cartData)) {
                foreach ($cartData as $cartDataKey => $data) {
                    foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {
                        foreach ($deliveryTemplate['productList'] as $key => $product) {

                            //세트 쿠폰
                            $registIx = ($coupon[$product['cart_ix']] ?? 0);
                            if ($setProductUseCouponBool && $registIx > 0 && substr_count($product['cart_ix'], ',') > 0 && $product['total_dcprice']
                                > 0
                            ) {
                                $_setProductCouponData = $couponModel->applyProductCoupon($registIx, $product['id'], $product['dcprice'],
                                    $product['total_dcprice']);
                                if ($_setProductCouponData !== false) {
                                    $_setProductCouponData['type'] = 'CP';
                                    $_setProductCouponData['title'] = ForbizConfig::getDiscount('CP');
                                    $_setProductCouponData['total_product_dcprice'] = $product['total_dcprice'];
                                    $setCartIxList = explode(",", $product['cart_ix']);
                                    $_setProductCouponData['last_cart_ix'] = array_pop($setCartIxList);
                                    $_setProductCouponData['sum_discount_amount'] = 0;
                                    $_setProductCouponData['sum_headoffice_discount_amount'] = 0;

                                    if ($setProductCouponData === false) {
                                        $setProductCouponData = [];
                                    }
                                    $setProductCouponData[$product['set_group']] = $_setProductCouponData;
                                }
                            }
                        }
                    }
                }
            }
            $cartSummary = $cartModel->getSummary($cartData);
            $totalProductDcprice = $cartSummary['summary']['product_dcprice'];
        }

        $list = [];
        foreach ($cartData as $cartDataKey => $data) {
            foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $key => $product) {
                    $list[] = $product;
                }
            }
        }
        $cartCouponList = $couponModel->applyUserCartCouponList($totalProductDcprice, $list);
        foreach ($cartCouponList as $cartCouponKey => $cartCoupon) {
            if (!empty($selectedCartCouponIx) && $selectedCartCouponIx == $cartCoupon['regist_ix']) {
                $cartCoupon['isSelected'] = true;
            } else {
                $cartCoupon['isSelected'] = false;
            }
            $cartCouponList[$cartCouponKey] = $cartCoupon;
        }

        $this->setResponseData($cartCouponList);
    }

    /**
     * 주문내역 조회
     */
    public function getOrderList()
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        $max = $this->input->post('max');
        $page = $this->input->post('page');

        $result = $orderModel->getOrderHistory(sess_val('user', 'code'), [], $page, $max);

        $orderList = [];
        if ($result['total'] > 0) {
            foreach ($result['list'] as $key => $order) {

                if(count($order['orderDetail']) > 1){
                    $extra_count = count($order['orderDetail']) - 1;
                    if(BASIC_LANGUAGE == 'english'){
                        $buy_product_name_text = $extra_count." extra product";
                    }else{
                        $buy_product_name_text = "외 ".$extra_count."건";
                    }
                }

                $result['list'][$key]['payment_price'] = g_price($order['payment_price']);
                $result['list'][$key]['product_image_src'] = $order['orderDetail'][0]['pimg'];
                $result['list'][$key]['buy_product_name'] = html_entity_decode(stripslashes($order['orderDetail'][0]['pname']), ENT_QUOTES) . " ".$buy_product_name_text;
            }
        }

        $this->setResponseResult('success')->setResponseData($result);
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
                if ($method == ORDER_METHOD_VBANK || $method == ORDER_METHOD_ASCROW) {
                    $cancelAutoDay = ForbizConfig::getMallConfig('mall_cc_interval');
                    $holiday_text = ForbizConfig::getMallConfig('holiday_text');
                    if (empty($cancelAutoDay)) {
                        $vbankExpirationDate = date('Ymd', strtotime('+7 day'));
                    } else {
                        $vbankExpirationDate = date('Ymd', strtotime('+' . $cancelAutoDay . ' day'));
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

    public function checkGiftItemStock(){
        $giftData = $this->input->post('giftData');

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        if (!empty($giftData)) {
            $result = $orderModel->getGiftItemStock($giftData);

            $this->setResponseResult('success')->setResponseData($result);
        }else{
            $this->setResponseResult('noGiftData');
        }
    }


    /**
     * @param $productDcprice
     * @param $deliveryPrice
     * @param $mileage
     * @return float|int     *
     */
    public function deductionMileage($productDcprice,$deliveryPrice,$mileage){

        //사용한 적립금 대비 적립될 적립금을 비율 제한 설정 진행 [S]
        //echo $totalDeliveryPrice; //추가 배송비 포함된 전체 배송비 금액
        //echo $sumDeliveryPrice; //추가 배송비가 포함되지 않은 배송금액 합계
        //배송 금액 산정시 적립금으로 도서산간 추가 배송비에 대해 사용처리가 가능 할 경우라면 $totalDeliveryPrice 를 사용하고 일반 배송비만 처리 가능할때는 $sumDeliveryPrice 를 사용한다
        //만약 추가 배송비까지 사용가능한 구조를 구현하려면 할인/혜택 적용 영역은 배송지 정보보다 하위에 있어야 정상적인 구동이 가능하며 주소 선택에 따른 배송금액 이 달라질 수 있기 때문에
        //해당 예외처리를 생각해야 한다.

        //echo $productDcprice; //결제 예정금액
        //echo $mileage; //사용 마일리지 금액
        if(BASIC_LANGUAGE == 'english') {
            $mileageRule = ForbizConfig::getSharedMemory('global_mileage_rule');
        }else{
            $mileageRule = ForbizConfig::getSharedMemory('b2c_mileage_rule');
        }

        //사용 적립금 제외설정 사용 함 일때
        if($mileageRule['excluding_use_reserve'] == 'Y'){
            //배송비 포함 전액 사용 가능일때
            if($mileageRule['deliveryprice'] == 'Y'){
                $deduction_percentage = (($productDcprice+$deliveryPrice-$mileage) / ($productDcprice+$deliveryPrice) * 100);
            }else{
                $deduction_percentage = (($productDcprice-$mileage) / ($productDcprice) * 100);
            }

            $deduction_value = $deduction_percentage/100;

        }else{
            //사용 적립금 제외설정 사용하지 않을때 적립금 계산시 기존 상품의 적립금액을 유지하기 위해 기본 값으로 1 처리
            $deduction_value = 1;
        }
        //사용한 적립금 대비 적립될 적립금을 비율 제한 설정 진행 [E]

        return $deduction_value;
    }

    public function paymentLog(){
        $orderModel = $this->import('model.mall.order');
        $orderModel->paymentLog();
    }
}