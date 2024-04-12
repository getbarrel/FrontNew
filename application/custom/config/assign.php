<?php
return (function() {

        /* @var $cartModel CustomMallCartModel */
        $cartModel    = getForbiz()->import('model.mall.cart');
        /* @var $productModel CustomMallProductModel */
        $productModel = getForbiz()->import('model.mall.product');
        /* @var $displayModel CustomMallDisplayModel */
        $displayModel = getForbiz()->import('model.mall.display');

        /* @var $couponModel CustomMallCouponModel */
        $couponModel = getForbiz()->import('model.mall.coupon');

        $isLogin = is_login();
        $appType = getAppType();

        $title_desc   = ForbizConfig::getMallConfig('mall_title');
        $mall_keyword = ForbizConfig::getMallConfig('mall_keyword');

		//print_r($_SERVER['REQUEST_URI']);


        $routeUri = getForbiz()->router->routeUri;
        $bodyId   = $routeUri ? str_replace('/', '_', $routeUri) : 'main';
        $routeUri = '/'.$routeUri;

		$AGENT = strpos($_SERVER['HTTP_USER_AGENT'],'KAKAOTALK');
		$AutoChk = $_REQUEST['AutoChk'];

		if($AGENT !== false && $AutoChk == "ok"){
			$URI = $_SERVER['REQUEST_URI'];
			redirect('/controller/member/kakaoDirectLogin?uri='.$URI);

		}

        // 비즈팻 사용USER 정의
        $_SESSION['allowFatUser'] = ['forbiz', 'barrel_user', 'ebusiness'];
        // QAUSER 정의
        if(in_array(sess_val('user', 'id'), ['swlee1', 'sja0705', 'swlee22'])){
            $_SESSION['forbiz_qa_user'] = true;
        }

        // 카테고리 캐시 적용
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            $largeCateData = array();
        }else{
            if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
                $largeCateData = fb_get('largeEnCateData');
            }else{
                $largeCateData = fb_get('largeCateData');
            }
        }

        if (empty($largeCateData)) {
            //카테고리
            $largeCateData = $productModel->getLargeCategoryList();

            if (is_array($largeCateData)) {
                foreach ($largeCateData as $key => $largeCate) {
                    $largeCateData[$key]['subCateList'] = $productModel->getCategorySubList($largeCate['cid']);
                    if (is_array($largeCateData[$key]['subCateList'])) {
                        foreach ($largeCateData[$key]['subCateList'] as $key2 => $smallCate) {
                            $largeCateData[$key]['subCateList'][$key2]['subCateList'] = $productModel->getCategorySubList($smallCate['cid']);
                        }
                    }
                }
            }
        }
        //BARREL ISSUE 카테고리 메뉴 사용을 위한 고정 값 처리
        $customCategoryMenu = $productModel->getCategoryMenu('008000000000000');

        //회원
        $userInfo = [];
        if ($isLogin) {
            $userInfo = [
                'name' => sess_val('user', 'name')
                , 'id' => sess_val('user', 'id')
                , 'mem_type' => sess_val('user', 'mem_type')
				, 'MBCODE' => sess_val('user', 'code')
				, 'pcs' => sess_val('user', 'pcs')
            ];
        }
        $userInfo['cartCnt'] = $cartModel->cartCnt();

        //로그인화면 체크
        $loginPage = false;
        if (strpos($_SERVER['REQUEST_URI'], '/member/login') !== false) {
            $loginPage = true;
        }
        $prepPage = false;
        if (strpos($_SERVER['REQUEST_URI'], '/mypage/preferences') !== false) {
            $prepPage = true;
        }

        $leftTopMenu    = array();
        $leftBrandStory = array();
        $totalWish      = "";
        $totalCoupon    = "";

        if (is_mobile()) {

            // 배너 캐시 적용
            if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
                $leftTopMenu    = $displayModel->getDisplayBannerGroup(10, 'banner_ix asc');
                $leftBrandStory = $displayModel->getDisplayBannerGroup(11, 'banner_ix asc');
            }else{
                $leftTopMenu    = fb_get('bannerPosition10');
                $leftBrandStory = fb_get('bannerPosition11');
            }



            if ($isLogin) {
                //wish total
                $wishModel = getForbiz()->import('model.mall.wish');
                $totalWish = $wishModel->getTotalWish();

                $totalCoupon = $couponModel->getCouponCnt();
            }
        } else {

            // 배너 캐시 적용
            if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
                $leftBrandStory = $displayModel->getDisplayBannerGroup(57, 'banner_ix asc');
            }else{
                $leftBrandStory = fb_get('bannerPosition57');
            }

        }

        //배럴데이 세팅
    $isBarrelDay    = false;
    $isOnlineBarrelDay    = false;
    $isOfflineBarrelDay    = false;
    if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === true) {
        $isBarrelDay = true;
        $isOnlineBarrelDay = true;
    }

    $displayContentClassList = $displayModel->getDisplayContentClass();

    foreach($displayContentClassList as $key => $val){
        if($val['cid'] == '001001000000000'){
            $displayContentClassDepthList = $displayModel->getDisplayContentClass(substr($val['cid'],0,6));

            $displayContentList = $displayModel->getDisplayContent(substr($val['cid'],0,6));
        }
    }

    /*
        $startBarrelDay = '2020-03-24 09:50:00';
        $startOfflineBarrelDay = '2020-03-24 09:50:00';
        $endBarrelDay = '2020-03-27 23:59:59';
        $now            = date('Y-m-d H:i:s');

        $isBarrelDay    = false;
        $isOnlineBarrelDay    = false;
        $isOfflineBarrelDay    = false;

        if ($now >= $startBarrelDay && $now < $endBarrelDay) {
            $isBarrelDay = true;
            $isOnlineBarrelDay = true;
//            if($now < $startOfflineBarrelDay) {
//                $isOnlineBarrelDay = true;r
//            }else if($now >= $startOfflineBarrelDay){
//                $isOfflineBarrelDay = true;
//            }

        }
    */

        if (is_https()) {
            $daumJsUrl = 'https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js';
        } else {
            $daumJsUrl = 'http://dmaps.daum.net/map_js_init/postcode.v2.js';
        }

        //랜덤쿠폰 존재 여부 체크
        $randomCouponCnt = 0;
        $randomCouponInfo = [];
        $selected = 0;
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            if (is_login() && BASIC_LANGUAGE == 'korean') {
                $randomCouponInfo = $couponModel->getRandomCouponInfo();
                $randomCouponCnt = count($randomCouponInfo);
                if ($randomCouponCnt > 1) {
                    $selected = array_rand($randomCouponInfo);
                }
                if ($randomCouponCnt > 0) {
                    $randomCouponInfo = $randomCouponInfo[$selected];
                }

            }
        }

		$barrelfitYN = "N";
		if(strpos($_SERVER['REQUEST_URI'],"eventDetail")){
			if(basename($_SERVER["PHP_SELF"]) == 261){
				$barrelfitYN = "Y";
			}
		}

		/*
        $footerScript = '
        <script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script> 
        <script type="text/javascript"> 
        if (!wcs_add) var wcs_add={};
        wcs_add["wa"] = "s_273c58f4fec1";
        if (!_nasa) var _nasa={};
        wcs.inflow();
        wcs_do(_nasa);
        </script>
        
        <!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZSZD5J"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
        ';
		*/

        $footerScript = '
        <script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script> 
        <script type="text/javascript"> 
        if (!wcs_add) var wcs_add={};
        wcs_add["wa"] = "s_273c58f4fec1";
        if (!_nasa) var _nasa={};
        wcs.inflow();
        wcs_do(_nasa);
        </script>
        
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PM9F928"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
        ';

        $layOutHeaderScript = '
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,\'script\',
          \'https://connect.facebook.net/en_US/fbevents.js\');
          fbq(\'init\', \'1121475617870083\');
          fbq(\'track\', \'PageView\');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=1121475617870083&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
        ';

	/*
    $layOutHeaderScript .= "
        <!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MZSZD5J');</script>
		<!-- End Google Tag Manager -->
    ";
	*/
    $layOutHeaderScript .= "
        <!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PM9F928');</script>
		<!-- End Google Tag Manager -->

		<!-- Danggeun Market Code -->
		<script src='https://karrot-pixel.business.daangn.com/0.1/karrot-pixel.umd.js'></script>
		<script>
		  window.karrotPixel.init('1712286267255600001');
		  window.karrotPixel.track('ViewPage');
		</script>
		<!-- End Danggeun Market Code -->

    ";


    $kakaoMomentScript ="        
    <script type='text/javascript' charset='UTF-8' src='//t1.daumcdn.net/adfit/static/kp.js'></script>
    <script type='text/javascript'>
            kakaoPixel('".KAKAO_MOMENT_KEY."').pageView();
    </script> 
    ";

        return [
            'layoutCommon' => [
                'isLogin' => $isLogin
                , 'appType' => $appType
                , 'userInfo' => $userInfo
                , 'bodyId' => $bodyId
                , 'routeUri' => $routeUri
                , 'title_desc' => $title_desc
                , 'mall_keyword' => $mall_keyword
				, 'barrelfitYN' => $barrelfitYN
            ]
            , 'layout' => [
                //'jsonPopupList' => json_encode($displayModel->getPopupList()),
                'jsonPopupList' => json_encode($displayModel->getDisplayBannerCount(69)), // qa 66 stg 69
                'loginPage' => $loginPage,
                'prepPage' => $prepPage,
                'layOutHeaderScript' => $layOutHeaderScript,
                'kakaoMomentScript' =>$kakaoMomentScript
            ]
            , 'headerTop' => [
                'popularKeyword' => $productModel->getPopularKeyword()
                , 'recentKeyword' => $productModel->getRecentKeyword()
                , 'randomCoupon' => $randomCouponCnt
                , 'randomCouponInfo' => $randomCouponInfo
            ]
            , 'headerMenu' => [
                'categoryList' => $largeCateData,
                'leftTopList' => $leftTopMenu,
                'leftBrandStory' => $leftBrandStory,
                'totalWish' => $totalWish,
                'totalCoupon' => $totalCoupon,
                'customCategoryMenu' => $customCategoryMenu
            ]
            , 'contentsAdd' => []
            , 'leftMenu' => []
            , 'rightMenu' => [
                'historyList' => $productModel->getProductViewHistory((sess_val('user', 'code') ? sess_val('user', 'code') : session_id()), 1, 3,
                    false)['list']
            ]
            , 'footerMenu' => []
            , 'footerDesc' => [
                'footerScript' => $footerScript
            ]
            , 'useFat' => defined('USE_FAT') && USE_FAT === true && (in_array(sess_val('user', 'id'), sess_val('allowFatUser')) || sess_val('forbiz_qa_user') === true)
            , 'langType' => BASIC_LANGUAGE
            , 'appType' => $appType
            , 'fbUnit' => ['f' => FRONT_UNIT, 'b' => BACK_UNIT]
            , 'daumJsUrl' => $daumJsUrl
            , 'isBarrelDay' => $isBarrelDay
            , 'isOnlineBarrelDay' => $isOnlineBarrelDay
            , 'isOfflineBarrelDay' => $isOfflineBarrelDay
            , 'displayContentClassList' => $displayContentClassList
            , 'displayContentClassDepthList' => $displayContentClassDepthList
        ];
    })();
