<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

// 대시보드 데이터 Assign wish
$userCode = $view->userInfo->code;
$mypageModel = $view->import('model.mall.mypage');
$view->assign($mypageModel->doDashBoard($userCode));

//print_r($mypageModel->doDashBoard($userCode)[wishList]);


//장바구니 정보 가지고 오기
/* @var $cartModel CustomMallCartModel */
$cartModel = $view->import('model.mall.cart');
$productModel = $view->import('model.mall.product');

// 카트 상세 정보
$cartData    = $cartModel->get();
$cartSummary = $cartModel->getSummary($cartData);
$cartCnt = $cartModel->cartCnt();

$view->assign('isPrdSoldOut','N');
foreach($cartData as $cart){
    foreach($cart['deliveryTemplateList'] as $cartDt){
        foreach ($cartDt['productList'] as $cartPrd){
            if($cartPrd['is_soldout'] == '1'){
                $view->assign('isPrdSoldOut','Y');
                break;
            }else if($cartPrd['options_text'] != '') {
				$arrOptionText = explode(":",$cartPrd['options_text']);
				$cartPrd['options_text'] = $arrOptionText[1];
				//$view->assign('options_text',$arrOptionText[1]);
				
            }
        }
    }
}

//karrotPixel 스크립트 추가 [S]
$karrotPixelItem = [];
foreach($cartData as $cart){
    foreach($cart['deliveryTemplateList'] as $cartDt){
        foreach ($cartDt['productList'] as $key=>$val){
			$karrotPixelItem[$key]['id'] = $val['pid'];
			$karrotPixelItem[$key]['name'] = $val['pname'];
			$karrotPixelItem[$key]['quantity'] = $val['pcount'];
			$karrotPixelItem[$key]['price'] = str_replace(',','',g_price($val['dcprice']));
        }
    }
}

$karrotPixelSubScript = "
<script type='text/javascript'>
	window.karrotPixel.track(
	  'AddToCart', 
	  {
		'products': ".json_encode($karrotPixelItem)."
	  }
	)
</script>
";
$view->assign('karrotPixelSubScript', $karrotPixelSubScript);

//sdk 추가 설정
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
$sdkScript = "
<script id='bigin-cart-page'> 
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
//sdk 추가 설정

$view->assign([
    'cartDeleteDay' => ForbizConfig::getMallConfig('cart_delete_day') //장바구니 보관일
    , 'cart' => $cartData
    , 'cartCnt' => $cartCnt
    , 'cartSummary' => $cartSummary['summary']
]);

//카카오 모먼트 장바구니 스크립트 추가 [S]
$kakaoMomentSubScript = "
<script type='text/javascript'>
      kakaoPixel('".KAKAO_MOMENT_KEY."').viewCart();
</script>
";
$view->assign('kakaoMomentSubScript', $kakaoMomentSubScript);
//카카오 모먼트 장바구니 스크립트 추가  [E]

$view->mypageCommon();
// content output
echo $view->loadLayout();