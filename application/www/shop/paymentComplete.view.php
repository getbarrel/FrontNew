<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

$oid = $view->getFlashData('payment_oid');
/*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
	$oid = "202403251643-0000219";
}*/
if (!empty($oid)) {
    /* @var $mypageModel CustomMallMypageModel */
    $mypageModel = $view->import('model.mall.mypage');

    if(empty($view->userInfo->code)){
       $userCode = $mypageModel->getOrderIdByCode($oid);
    }else{
       $userCode = $view->userInfo->code;
    }

    $data = $mypageModel->doOrderDetail($userCode, $oid);

    $view->assign($data);
    if (isset($data['paymentInfo']['payment'][0])) {
        $paymentData                         = $data['paymentInfo']['payment'][0];
        $paymentData['bank_input_date_yyyy'] = substr($paymentData['bank_input_date'], 0, 4);
        $paymentData['bank_input_date_mm']   = substr($paymentData['bank_input_date'], 5, 2);
        $paymentData['bank_input_date_dd']   = substr($paymentData['bank_input_date'], -2);
        $paymentData['total_reserve']        = $data['paymentInfo']['total_reserve'];

		if($paymentData['method'] == "1"){			// 신용카드결제
			$payMethod = "1";
		}else if($paymentData['method'] == "4"){	// 가상계좌결제
			$payMethod = "2";
		}else if($paymentData['method'] == "50"){	// 페이코
			$payMethod = "0";
		}else if($paymentData['method'] == "52"){	// 카카오페이
			$payMethod = "4";
		}else if($paymentData['method'] == "53"){	// 네이버페이
			$payMethod = "4";
		}else if($paymentData['method'] == "56"){	// 토스
			$payMethod = "4";
		}else if($paymentData['method'] == "9"){	// 에스크로(가상계좌)결제
			$payMethod = "2";
		}

        $view->assign('paymentData', $paymentData);
    }

    /**
     * 사은품 노출 관리
     */

    $view->assign('freeGift',$data['order']);

    if(isset($data['order']['freeGift']) && is_array($data['order']['freeGift'])){
        $freeGiftArray = [];
        foreach($data['order']['freeGift'] as $key => $val){
            $freeGiftArray[$val['gift_products'][0]['gift_condition']][] = $val;
        }
    }

    $view->assign('freeGiftG', $freeGiftArray['G'] ?? "");
    $view->assign('freeGiftC', $freeGiftArray['C'] ?? "");
    $view->assign('freeGiftP', $freeGiftArray['P'] ?? "");

    /**
     * 페이스북 픽셀 데이터 처리
     */

    $orderItemId = [];
    if(isset($data['order']['orderDetail']) && is_array($data['order']['orderDetail'])){
        foreach($data['order']['orderDetail'] as $dKey => $items){
            if(is_array($items)){
                foreach($items as $key=>$val){
                    array_push($orderItemId,$val['pid']);
                }
            }
        }
    }


    $payMentScript = '
    <!-- 전환페이지 설정 -->
    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
    <script type="text/javascript"> 
    var _nasa={};
    _nasa["cnv"] = wcs.cnv("1",'.str_replace(',','',g_price($val['pt_dcprice'])).'); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고
    </script> 

    ';


    if(BASIC_LANGUAGE == 'korean'){
        $currency = 'KRW';
    }else{
        $currency = 'USD';
    }

    $payMentScript .= "
    <script>
        fbq('track', 'Purchase', {
            content_ids: ".json_encode($orderItemId).",		// 위에서 선언한 구매 완료한 상품들의 id를 담은 배열
            content_type: 'product',
            value: '".$data['paymentInfo']['pt_dcprice']."',		// total_price 는 예시로서 총 구매 금액을 가져올 수 있는 변수를 입력해 주세요.
            currency: '".$currency."'
        });
    </script>
    ";

    //마일리지 정보
    /* @var $mileageModel CustomMallMileageModel */
    $mileageModel = $view->import('model.mall.mileage');

    $view->assign('mileageName', $mileageModel->getName());

	
	$mobionScript = "
	<!-- Enliple Tracker Start_모비온 -->
	<script type='text/javascript'>
		var ENP_VAR = { conversion: { product: [] } };
		// 주문한 각 제품들을 배열에 저장
		ENP_VAR.conversion.product.push(
	";


    //카카오 모먼트 장바구니 스크립트 추가 [S]
    $kakaoMomentItem = [];
    if(isset($data['order']['orderDetail']) && is_array($data['order']['orderDetail'])){
        foreach($data['order']['orderDetail'] as $dKey => $items){
            if(is_array($items)){
                foreach($items as $key=>$val){
                    $kakaoMomentItem[$key]['name'] = $val['pname'];
                    $kakaoMomentItem[$key]['quantity'] = $val['pcnt'];
                    $kakaoMomentItem[$key]['price'] = str_replace(',','',g_price($val['pt_dcprice']));

					//if($val['listprice'] <= $val['dcprice']){
					//	$treaPrice = $val['listprice'];
					//}else{
					//	$treaPrice = $val['dcprice'];
					//}

					$mobionScript .= "
						{
							productCode : '".$val['pid']."',
							productName : '".$val['pname']."',
							price : '".$val['listprice']."',
							dcPrice : '".$val['dcprice']."',
							qty : '".$val['pcnt']."'
						},
					";
					$mobionScript .= "
						{
							productCode : '".$val['pid']."',
							productName : '".$val['pname']."',
							price : '".$val['listprice']."',
							dcPrice : '".$val['dcprice']."',
							qty : '".$val['pcnt']."'
						}
					";
                }
            }
        }
    }

    //karrotPixel 스크립트 추가 [S]
    $karrotPixelItem = [];
    if(isset($data['order']['orderDetail']) && is_array($data['order']['orderDetail'])){
        foreach($data['order']['orderDetail'] as $dKey => $items){
            if(is_array($items)){
                foreach($items as $key=>$val){
                    $karrotPixelItem[$key]['id'] = $val['pid'];
                    $karrotPixelItem[$key]['name'] = $val['pname'];
                    $karrotPixelItem[$key]['quantity'] = $val['pcnt'];
                    $karrotPixelItem[$key]['price'] = str_replace(',','',g_price($val['pt_dcprice']));
                }
            }
        }
    }

	$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

	if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
		$agent = "M";
	}else{
		$agent = "W";
	}
	
	$mobionScript .= "
		);

		ENP_VAR.conversion.ordCode= '".$oid."';
		ENP_VAR.conversion.totalPrice = '".$data['paymentInfo']['pt_dcprice']."';
		ENP_VAR.conversion.totalQty = '".$data['paymentInfo']['total_pcnt']."';

		(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src='https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js';t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,'script');
		enp('create', 'conversion', 'barrel', { device: '".$agent."' }); // W:웹, M: 모바일, B: 반응형
		enp('send', 'conversion', 'barrel');
	</script>
	<!-- Enliple Tracker End -->
	";

	$view->assign('mobionScript',$mobionScript);

	$view->assign('payMentScript',$payMentScript);

    $kakaoMomentSubScript = "
    <script type='text/javascript'>
        kakaoPixel('".KAKAO_MOMENT_KEY."').purchase({
            total_quantity: '".$data['paymentInfo']['total_pcnt']."', // 주문 내 상품 개수(optional)
            total_price: '".$data['paymentInfo']['pt_dcprice']."',  // 주문 총 가격(optional)
            currency: '".$currency."',     // 주문 가격의 화폐 단위(optional, 기본 값은 KRW)
            products: ".json_encode($kakaoMomentItem)."
        });
    </script>
    ";


    $karrotPixelSubScript = "
    <script type='text/javascript'>
		window.karrotPixel.track(
		  'Purchase', 
		  {
			'total_price': '{".$data['paymentInfo']['pt_dcprice']."}',
			'total_quantity': '{".$data['paymentInfo']['total_pcnt']."}',
			'products': ".json_encode($karrotPixelItem)."
		  }
		)
    </script>
    ";
    $view->assign('kakaoMomentSubScript', $kakaoMomentSubScript);
    $view->assign('karrotPixelSubScript', $karrotPixelSubScript);
//카카오 모먼트 장바구니 스크립트 추가  [E]
    // ouput layout
    echo $view->loadLayout();
} else {
    redirect('/shop/cart');
}
