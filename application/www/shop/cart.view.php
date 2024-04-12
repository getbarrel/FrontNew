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

if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
    print_r($karrotPixelSubScript);
}

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