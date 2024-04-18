<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/***
 * 대기열 적용
 */
$WG_GATE_ID = WEB_GATE_ID_2;
$WG_SERVICE_ID  = WEB_GATE_SERVICE_ID;                   // fixed
$WG_SECRET_TEXT = "BARREL-LEGGINGS";   // fixed
$WG_VALIDATION_KEY  = $WG_SERVICE_ID . "-" . $WG_GATE_ID . "-" . $WG_SECRET_TEXT;
$WG_COOKIE_NAME     = "WG_VALIDATION_KEY";
//$WG_GATE_SERVERS    = array("wk2.devy.kr", "wk3.devy.kr", "wc1.devy.kr", "wc2.devy.kr", "ws1.devy.kr");
$WG_GATE_SERVERS    = array("1012-0.devy.kr","1012-1.devy.kr","1012-2.devy.kr");
//$NextUrl = $view->input->server('REQUEST_URI');
//$NowUrl = $view->input->server('HTTP_REFERER');

$wg_is_need_to_redirect = true;
if(isset($_COOKIE[$WG_COOKIE_NAME])) {
    $wg_cookie_value = $_COOKIE[$WG_COOKIE_NAME];
    if($wg_cookie_value == $WG_VALIDATION_KEY)
    {
        $wg_is_need_to_redirect = false;
    }
}


// 검증키가 Cache에 없거나 값이 다르면 대기열 요청 후 응답 내용(대기자 수)으로 PASS/WAIT 판단
//      --> 대기자가 없으면 PASS(정상 페이지로드)
//      --> 대기자가 있으면 WAIT(응답을 LoadWebGate.html의 html로 교체)
if($wg_is_need_to_redirect  && (defined('IS_USE_WEB_GATE') && IS_USE_WEB_GATE === true))
{
    // 검증키 체크가 실패한 경우, 즉 대기열 체크를 하지 않은 경우 이곳으로 진입합니다.
    $wg_isWaiting = false; // 대기자가 있는지 여부

    // WG_GATE_SERVERS 서버 중 임의의 서버에 API 호출 --> json 응답
    $wg_receiveLine="";
    $wg_receiveText="";
    // Fail-over를 위해 최대 2차까지 시도
    $wg_serverCount = count($WG_GATE_SERVERS);
    $wg_serverChoice1  = rand(0, $wg_serverCount-1); // 1차대기열서버 : 임의의 대기열 서버
    $wg_url1 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice1] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";
    $wg_serverChoice2 = ($wg_serverChoice1 + rand(1, $wg_serverCount-1)) % $wg_serverCount; // 2차대기열서버 :1차 서버를 제외한 임의의 서버
    $wg_url2 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice2] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";

    // 1차 시도
    $wg_responseText = file_get_contents($wg_url1);
    // 오류나면 공백 $wg_responseText이 null
    if ( $wg_responseText == null || $wg_responseText == "")
    {
        // 1차시도 실패 시 2차시도
        $wg_responseText = file_get_contents($wg_url2);
    }

    // 1차 또는 2차시도로 응답을 받은경우 json decode
    if ( $wg_responseText != null && $wg_responseText != "")
    {
        $wg_responseJson = json_decode($wg_responseText);

        $wg_apiResultCode    = $wg_responseJson->ResultCode;        // 0:정상, 그외 : 오류
        $wg_apiResultMessage = $wg_responseJson->ResultMessage;     // "PASS" or "WAIT"


        // 대기자 수가 있으면 대기열 UI 표시(WAIT)
        // 대기자 수가 없으면 PASS
        $wg_isWaiting = $wg_apiResultCode == 0 && $wg_apiResultMessage == "WAIT";
        // 대기가 있는 경우
        if ($wg_isWaiting) {
            // 대기열 호출용 html로 load
            $doc = new DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $loadPagePath = $_SERVER['DOCUMENT_ROOT']."/gate/LoadWebGate.html";
            $doc->loadHTMLFile($loadPagePath);
            $html = $doc->saveHTML();
            // load한 html로 응답을 교체하고 return
            print str_replace("WG_GATE_ID", $WG_GATE_ID, $html); // SET Gate ID
            return;
        }
        // 대기가 없는 경우
        else {
            // 냉무 : 별도의 코딩 필요 없음
        }
    }
}

// 페이지 새로고침 시에도 대기열을 체크하기위해 아래와 같이 쿠키를 삭제해줍니다.
setcookie($WG_COOKIE_NAME, "", time() + (-1 * 86400), "/"); // 86400 = 1 day

// Load Forbiz View
$view = getForbizView();

$isLogin = is_login();

if ($isLogin) {
    if (BASIC_LANGUAGE == 'english') {
        $view->define(['userTemplate' => "shop/infoinput/infoinput_member_global.htm"]);
    } else {
        $view->define(['userTemplate' => "shop/infoinput/infoinput_member.htm"]);
        $view->define(['userTemplateCoupon' => "shop/infoinput/infoinput_member_coupon.htm"]);
    }
} else {
    if (BASIC_LANGUAGE == 'english') {
        $view->define(['userTemplate' => "shop/infoinput/infoinput_non_member_global.htm"]);
    } else {
        $view->define(['userTemplate' => "shop/infoinput/infoinput_non_member.htm"]);
        $view->define(['userTemplateCoupon' => "shop/infoinput/infoinput_non_member_coupon.htm"]);
    }
}

$cartIx = $view->input->get('cartIx');
if (empty($cartIx)) {
    redirect('/shop/cart');
    exit;
}

$cartIxs = explode(",", $view->input->get('cartIx'));

//장바구니 정보 가지고 오기
/* @var $cartModel CustomMallCartModel */
$cartModel = $view->import('model.mall.cart');

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');

/* @var $companyModel CustomMallCompanyModel */
$companyModel = $view->import('model.mall.company');

/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');

/* @var $couponModel CustomMallCouponModel */
$couponModel = $view->import('model.mall.coupon');

$cartData = $cartModel->get($cartIxs);
/*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
    print_r($cartIxs);
    echo "<br>";
    print_r($cartData);
    echo "<hr>";
}*/
//print_r($cartData);
$cartSummary = $cartModel->getSummary($cartData);

if (empty($cartData)) {
    redirect('/shop/cart');
    exit;
}
//print_r($cartSummary);

$view->assign('deliveryTemplateList', $cartData[0]['deliveryTemplateList'][0]);
$view->assign('cart', $cartData);

$view->assign('cartSummary', $cartSummary['summary']);

    if (defined('IS_EVENT_FREE_GIFT_USE') && IS_EVENT_FREE_GIFT_USE === true) {
        //$freeGift = $productModel->getFreeGift($cartSummary['summary']['payment_price']);
        $freeGift = $productModel->getFreeGiftInfo($cartData,'all',$cartSummary['summary']['product_dcprice']);

        $view->assign('freeGift', $freeGift);

        $freeGiftG = "N";
        $freeGiftC = "N";
        $freeGiftP = "N";

        foreach ($freeGift as $key => $val) {
            if($val['freegift_condition'] == "G"){
                $freeGiftG = "Y";
            }else if($val['freegift_condition'] == "C"){
                $freeGiftC = "Y";
            }else if($val['freegift_condition'] == "P"){
                $freeGiftP = "Y";
            }else{
                $freeGiftG = "N";
                $freeGiftC = "N";
                $freeGiftP = "N";
            }
        }
        $view->assign('freeGiftG', $freeGiftG);
        $view->assign('freeGiftC', $freeGiftC);
        $view->assign('freeGiftP', $freeGiftP);

        $orderGiftItem = $cartModel->getSeletedGiftItem($cartIxs[0], 'O');
        $view->assign('orderGiftItem', $orderGiftItem);

//        //카테고리 포함 시 사은품 증정
//        $freeGiftByCategory = $productModel->getFreeGiftByCategory($cartData);
//        $view->assign('freeGiftByCategory', $freeGiftByCategory);

    }



//모바일에서 상품 노출 구조가 다름
if (is_mobile()) {
    $firstCartDeliveryTemplateData = false;
    $moreCartDeliveryTemplateData = [];
    foreach ($cartData as $cart) {
        foreach ($cart['deliveryTemplateList'] as $deliveryTemplate) {
            if ($firstCartDeliveryTemplateData === false) {
                $firstCartDeliveryTemplateData = [$deliveryTemplate];
            } else {
                $moreCartDeliveryTemplateData[] = $deliveryTemplate;
            }
        }
    }

    //print_r($firstCartDeliveryTemplateData);
    $view->assign('firstCartDeliveryTemplateData', $firstCartDeliveryTemplateData);
    $view->assign('moreCartDeliveryTemplateData', $moreCartDeliveryTemplateData);

    // 배너 캐시 적용
    if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
        $topBanner = $displayModel->getDisplayBannerGroup(62);
    }else{
        $topBanner = fb_get('bannerPosition62');
    }

    if ($isLogin) {
        $cartSummaryData = $cartModel->getSummary($cartData);

        $list = [];
        $cartCouponExceptProductDcprice = f_decimal(0);
        foreach ($cartData as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $product) {
                    $product['couponList'] = $couponModel->applyProductUserCouponList($product['id'], $product['dcprice'],
                        $product['total_dcprice'], $product['discount_coupon_use_yn']);
                    foreach ($product['couponList'] as $couponKey => $coupon) {
                        //쿠폰을 이미 선택한 경우
                        if (!empty($useCouponData[str_replace(",", "|",
                                $product['cart_ix'])]) && $useCouponData[str_replace(",", "|",
                                $product['cart_ix'])] == $coupon['regist_ix']
                        ) {
                            $coupon['isSelected'] = true;
                        } else {
                            $coupon['isSelected'] = false;
                        }
                        $product['couponList'][$couponKey] = $coupon;
                    }
                    $list[] = $product;
                }
            }
        }

        $totalProductDcprice = $cartSummaryData['summary']['product_dcprice'];


        $useCouponData = $view->input->post('useCouponData');
        if (!is_array($useCouponData)) {
            $useCouponData = [];
        }

        $view->assign('list', $list);
        $view->assign('selectedCartCouponIx', $useCouponData['cart'] ?? '');
        $view->assign('totalProductDcprice', $totalProductDcprice);
    }

}else {
    // 배너 캐시 적용
    if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
        $topBanner = $displayModel->getDisplayBannerGroup(61);
    }else{
        $topBanner = fb_get('bannerPosition61');
    }
    //$topBanner    = $displayModel->getDisplayBannerInfo(1788);
}


$view->assign('topBanner', $topBanner[0]);

//개인정보 제3자 정보 제공 동의 노출 조건 체크
$isThirdBool = false;
//장바구니 상품명 축약
$contractionProductName = "";
//장바구니 상품종류 갯수
$productKindCount = 0;
//장바구니 담긴 상품 정보
$cartProductList = [];
$sdkItem = [];
foreach ($cartData as $cart) {
    if ($cart['company_id'] != ForbizConfig::getCompanyInfo('company_id')) {
        $isThirdBool = true;
    }

    foreach ($cart['deliveryTemplateList'] as $deliveryTemplate) {
        foreach ($deliveryTemplate['productList'] as $product) {

			$categoryName = $productModel->getCategoryNavigationList($product['cid']);
			foreach ($categoryName as $key => $val){
				foreach ($val as $key1 => $val1){
					foreach ($val1 as $key2 => $val2){
						if($val1['isBelong'] == 1){
							if($key2 == 'cname'){
								$categories[] = $val2;
							}
						}
					}
				}
			}

			$options[] = $product['options_text'];
			$options[] = $product['add_info'];
			
			$sdkItem[$keys]['id'] = $product['id'];
			$sdkItem[$keys]['name'] = $product['pname'];
			$sdkItem[$keys]['value'] = str_replace(',','',g_price($product['dcprice']));
			$sdkItem[$keys]['categories'] = json_encode($categories);
			$sdkItem[$keys]['quantity'] = $product['pcount'];
			$sdkItem[$keys]['variants'] = json_encode($options);

            $cartProductList[] = [
                'cart_ix' => $product['cart_ix'],
                'pname' => $product['pname'],
                'options_text' => $product['options_text']
            ];

            if (empty($contractionProductName)) {
                $contractionProductName = $product['pname'];
            }
            $productKindCount++;
        }
    }
}
$sdkScript = "
<script id='bigin-order-form-page'> 
(function () { 
	window._bigin = window._bigin || {};
	window._bigin.page = { 
		products: ".json_encode($sdkItem)."
	};
	window.dataLayer.push({ event: 'bg.notify' });
})();
</script>
";
$view->assign('sdkScript', $sdkScript);
//print_r($sdkScript);
/*
$sdkItem = [];
foreach($cartData as $cart){
    foreach($cart['deliveryTemplateList'] as $cartDt){
        foreach ($cartDt['productList'] as $keys=>$vals){

			$categoryName = $productModel->getCategoryNavigationList($val['cid']);
			foreach ($categoryName as $key => $val){
				foreach ($val as $key1 => $val1){
					foreach ($val1 as $key2 => $val2){
						if($val1['isBelong'] == 1){
							if($key2 == 'cname'){
								$categories[] = $val2;
							}
						}
					}
				}
			}

			$options[] = $vals['options_text'];
			$options[] = $vals['add_info'];
			
			$sdkItem[$keys]['id'] = $vals['id'];
			$sdkItem[$keys]['name'] = $vals['pname'];
			$sdkItem[$keys]['value'] = str_replace(',','',g_price($vals['dcprice']));
			$sdkItem[$keys]['categories'] = json_encode($categories);
			$sdkItem[$keys]['quantity'] = $vals['pcount'];
			$sdkItem[$keys]['variants'] = json_encode($options);
        }
    }
}
*/

if ($productKindCount > 1) {
    $contractionProductName .= ' 외 ' . ($productKindCount - 1) . '건';
}
$view->assign('isThirdBool', $isThirdBool);
$view->assign('contractionProductName', $contractionProductName);
$view->assign('productKindCount', $productKindCount);

$view->assign('cartProductList', $cartProductList);

//자동 취소 일자
$cancelAutoDay = ForbizConfig::getMallConfig('mall_cc_interval');
$view->assign('cancelAutoDay', $cancelAutoDay);

//약관
$view->assign($companyModel->getPolicy('consign', 'third', 'non_collection'));
if (BASIC_LANGUAGE == 'english') {
    //약관동의
    //약관 확인 필요
    /* @var $globalModel CustomMallGlobalModel */
    $globalModel = $view->import('model.mall.global');
    $nation = $globalModel->getNationInfo();

    $regional_information = $globalModel->getRegionalInformation();

    if (sess_val('user', 'code')) {
        $globalUserInfo = $globalModel->getGlobalUserInfo(sess_val('user', 'code'));
        $view->assign($globalUserInfo);
    }


    $view->assign('nation', $nation);
    $view->assign('regional_information', $regional_information);
} else {
    //약관동의
    //약관 확인 필요
}
//추가 결제 수단
$view->assign('add_sattle_module_naverpay_pg', ForbizConfig::getMallConfig('add_sattle_module_naverpay_pg'));
$view->assign('add_sattle_module_payco', ForbizConfig::getMallConfig('add_sattle_module_payco'));
$view->assign('add_sattle_module_kakao', ForbizConfig::getMallConfig('kakaopay_yn'));
$view->assign('add_sattle_module_toss', ForbizConfig::getMallConfig('add_sattle_module_toss'));

//결제 스크립트
/* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
$paymentGatewayModel = $view->import('model.mall.payment.gateway');
$view->assign('paymentIncludeJavaScript', $paymentGatewayModel->getPaymentIncludeJavaScript());


if ($isLogin) {

    //마일리지 정보
    /* @var $mileageModel CustomMallMileageModel */
    $mileageModel = $view->import('model.mall.mileage');

    $userMileage = $mileageModel->getUserAmount();

    $maxUseMileage = $userMileage;
    $mileageConditionUseDeliverypriceYn = $mileageModel->getConfig('deliveryprice');
    if ($mileageConditionUseDeliverypriceYn == 'Y') {
        $mileageTargetPrice = $cartSummary['summary']['payment_price'];
    } else {
        $mileageTargetPrice = $cartSummary['summary']['product_dcprice'];;
    }
    if ($userMileage > $mileageTargetPrice) {
        $maxUseMileage = $mileageTargetPrice;
    }

    $view->assign('mileageName', $mileageModel->getName());
    $view->assign('mileageUnit', $mileageModel->getUnit());
    $view->assign('userMileage', $userMileage);
    $view->assign('mileageConditionMinMileage', $mileageModel->getConfig('min_mileage_price'));
    $view->assign('mileageConditionUseUnit', $mileageModel->getConfig('use_unit'));
    $view->assign('mileageConditionMinBuyAmt', $mileageModel->getConfig('total_order_price'));
    $view->assign('maxUseMileage', $maxUseMileage);
    $view->assign('mileageTargetPrice', $mileageTargetPrice);
    $view->assign('mileageConditionUseDeliverypriceYn', $mileageConditionUseDeliverypriceYn);

    $mileageConditionUseLimitType = "noLimit";
    $mileageConditionUseLimitValue = "";
    switch ($mileageModel->getConfig('mileage_one_use_type')) {
        case '1';
            $mileageConditionUseLimitType = "price";
            $mileageConditionUseLimitValue = $mileageModel->getConfig('use_mileage_max');
            break;
        case '2';
            $mileageConditionUseLimitType = "rate";
            $mileageConditionUseLimitValue = $mileageModel->getConfig('max_goods_sum_rate');
            break;
    }
    $view->assign('mileageConditionUseLimitType', $mileageConditionUseLimitType);
    $view->assign('mileageConditionUseLimitValue', $mileageConditionUseLimitValue);

    //쿠폰 정보
    /* @var $couponeModel CustomMallCouponModel */
    $couponeModel = $view->import('model.mall.coupon');
    $couponDiv = ['G','C'];
    $userCouponCnt = $couponeModel->getCouponCnt(false,$couponDiv);
    $couponDeliveryDiv = ['D'];
    $userDeliveryCouponCnt = $couponeModel->getCouponCnt(false,$couponDeliveryDiv);
    $view->assign('userCouponCnt', $userCouponCnt);
    $view->assign('userDeliveryCouponCnt', $userDeliveryCouponCnt);

    //회원 정보
    $view->assign('buyerName', sess_val('user', 'name'));

    $buyerEmail = sess_val('user', 'mail');
    $view->assign('buyerEmail', $buyerEmail);
    $ExBuyerEmail = explode("@", $buyerEmail);
    $view->assign('buyerEmailId', ($ExBuyerEmail[0] ?? ''));
    $view->assign('buyerEmailHost', ($ExBuyerEmail[1] ?? ''));

    $buyerMobile = sess_val('user', 'pcs');
    $view->assign('buyerMobile', $buyerMobile);
    $ExBuyerMobile = explode("-", $buyerMobile);
    $view->assign('buyerMobile1', ($ExBuyerMobile[0] ?? ''));
    $view->assign('buyerMobile2', ($ExBuyerMobile[1] ?? ''));
    $view->assign('buyerMobile3', ($ExBuyerMobile[2] ?? ''));

    $totalDeliveryPrice = $cartSummaryData['summary']['total_delivery_price'];
    $deliveryCouponList = $couponModel->applyUserDeliveryCouponList($totalDeliveryPrice, $totalProductDcprice);

    $view->assign('deliveryCouponList', $deliveryCouponList);
    $view->assign('totalDeliveryPrice', $totalDeliveryPrice);


} else {
    //비회원 약관 동의 가지고 오기
    if (BASIC_LANGUAGE == 'english') {
        $use = $companyModel->getPolicyNow('use_global');
        $view->assign('use', $use[0]['pi_contents']);
        $use = $companyModel->getPolicyNow('collection_global');
        $view->assign('non_collection', $use[0]['pi_contents']);
    }else {
        $view->assign($companyModel->getPolicy('use'));
    }
}

echo $view->loadLayout();
