<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

// 상품 코드
$id  = $view->getParams(0);
// 카테고리 코드
$cid = $view->getParams(1);

$viewMode = $view->input->get('viewMode');

if ($id != '') {
    $id = zerofill($id);

    /* @var $productModel CustomMallProductModel */
    $productModel = $view->import('model.mall.product');
    $productModel->setDiscoutMemberGroupCalculationYn('Y');

    //상품 상세 정보
    $datas = $productModel->get($id);

    $pcs = $view->userInfo->pcs;

    $pcs = explode("-",$pcs);

    $view->assign('pcs1',$pcs[0]);
    $view->assign('pcs2',$pcs[1]);
    $view->assign('pcs3',$pcs[2]);

    $options = $productModel->getOption($id);
    $optionData = $options['viewOptions'];

    $view->assign('optionData',$optionData);

	$preface = explode("_",$datas['preface']);

	$view->assign('prefaceName', $preface[0]);
	$view->assign('prefaceColor', $datas['c_preface']);
    $view->assign('b_preface', $datas['b_preface']);
    $view->assign('i_preface', $datas['i_preface']);
    $view->assign('u_preface', $datas['u_preface']);


    $view->assign('wear_info', nl2br($datas['wear_info']));

    $productModel->setDiscoutMemberGroupCalculationYn('N');

	$view->assign('ig_addOptions', $ig_options["addOptions"]);

	//	크리마 사이즈 조정때문에 옵션데이터 호출
	$ig_options = $productModel->getOption($id); //옵션 데이터 호출
    $view->assign('ig_addOptions', $ig_options["addOptions"]);

    $style = $productModel->getStoreGuideStyle($id);
    $view->assign('style', $style);

    $option = $productModel->getStoreGuideOption($id);
    $view->assign('option', $option);

    $customerModel = $view->import('model.mall.customer');

    $cityList = $customerModel->getCityCode();

    $view->assign('cityList', $cityList);

    $view->assign($datas);

    if(is_array($datas['product_gift']) && count($datas['product_gift']) > 0){
        $productGiftInfo = $datas['product_gift'][0]['product_gift_detail'];

        $view->assign('productGiftInfo',$productGiftInfo);
    }

    //크리마 리뷰 카운트 가져오기    
    $total_review_cnt = $datas['after_cnt'] ?? 0;
    $total_review_score = $datas['after_score'] ?? 0;
    $total_review_star = $total_review_score / 100;
    $total_review_star = (float) substr($total_review_star, 0, strpos($total_review_star, '.') + 2);
    $view->assign('total_review_cnt', $total_review_cnt);
    $view->assign('total_review_star', $total_review_star);
    $view->assign('total_review_star_per', $total_review_score);

    if(isset($datas['is_delete']) && $datas['is_delete'] == '1'){
        redirect('/');
    }

    if ((!isset($datas['status']) || $datas['status'] == 'stop') && $view->userInfo->mem_type !='A' && $viewMode != 'preview' ) { //판매중지 상품일 경우 접근불가
        redirect('/');
    } else {
        // 카테고리 코드 점검
        $cid = $cid ? $cid : $datas['cid'];

        /* @var $cartModel CustomMallCartModel */
        $cartModel   = $view->import('model.mall.cart');
        /* @var $sellerModel CustomMallSellerModel */
        $sellerModel = $view->import('model.mall.seller');
        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel = $view->import('model.mall.productReview');
        /* @var $qnaModel CustomMallProductQnaModel */
        $qnaModel    = $view->import('model.mall.productQna');
        /* @var $couponModel CustomMallCouponModel */
        $couponModel = $view->import('model.mall.coupon');

        //쿠폰 리스트
        $couponList = $couponModel->getMallCouponList($id);

        foreach($couponList as $key => $val){

            $couponDownCnt = $couponModel->checkCouponDownCnt($val['publish_ix']);

            $couponAllList[$key] = $val;

            $DownY = ($val['regist_count'] - $couponDownCnt);

            for($i=0;$i<$DownY;$i++){
                $couponAllList[$key]['DownUse'][$i]['DownUse'] = 'Y';
            }

            for($c=$i;$c<$val['regist_count'];$c++){
                $couponAllList[$key]['DownUse'][$c]['DownUse'] = 'N';
            }
        }

        $view->assign('couponList', $couponAllList);
        //상품 배송정책 정보
        $deliveryInfos = $cartModel->getDeliveryInfo($datas['dt_ix']);
        //상품문의 개수
        $qnas          = $qnaModel->getCount($id);
        //각 상품후기 개수
        $reviews       = $reviewModel->getCount($id);

		//sdk 추가 설정
		$categoryName = $productModel->getCategoryNavigationList($cid);
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

		$sdkImg[] = $datas['image_src'];
		foreach ($datas['add_image_src'] as $imgKey => $imgVal){
			$sdkImg[] = $imgVal['smallImg'];
		}

		$sdkScript = "<script id='bigin-detail-page'> 
(function () { 
	window._bigin = window._bigin || {};
	window._bigin.page = { 
		product: { 
			id: '".$id."', 
			name: '".$datas["pname"]."', 
			value: ".$datas["dcprice"].", 
			categories: ".json_encode($categories).", 
			images: ".json_encode($sdkImg)." 
		} 
	};
	window.dataLayer.push({ event: 'bg.notify' });
})();
</script>";
		$view->assign('sdkScript', $sdkScript);
		//sdk 추가 설정

        // Data Assign
        $view->assign([
            'pid' => $id //상품 시스템코드, 카테고리값. ex) 상세주소/상품시스템코드/카테고리
            , 'coupon_use_yn' => ForbizConfig::getSharedMemory("b2c_coupon_rule")['coupon_use_yn']
            , 'categorys' => $productModel->getCategoryNavigationList($cid) //상품 카테고리 정보
            , 'delivery' => $deliveryInfos //상품 배송정책 정보
            , 'mandatoryInfos' => $productModel->getMandatoryInfos($id) //상품 상세고시 정보
            , 'mandatoryInfosGlobal' => $productModel->getMandatoryInfosGlobal($id) //상품 상세고시 정보
            , 'relationInfos' => $productModel->getRelationProducts($id) //추천 연관상품
            , 'promotionInfos' => $productModel->getRelationPromotion($id) //관련 기획전
            , 'displayOptionInfos' => $productModel->getDisplayOptions($id) //디스플레이옵션
            , 'ranking' => $productModel->getCategoryRanking(15, $datas['cid']) //카테고리별 랭킹 정보
            //셀러 정보
            , 'sellerNotice' => $sellerModel->getSellerNotice($datas['admin']) //셀러 상품상세 공지사항
            , 'deadline' => $sellerModel->getSellerDeadline($deliveryInfos['company_id']) //셀러 배송 마감시간
            // 상품후기
            , 'avg' => $reviewModel->getAverage($id)
            , 'premiumReviewTotal' => $reviews['premiumReview']
            , 'reviewTotal' => $reviews['review']
            , 'allReviewTotal' => $reviews['total']
            // 상품문의 갯수
            , 'qnaTotal' => $qnas['all']
            , 'myQnaTotal' => $qnas['mine']
            //상품문의 분류
            , 'qnaDivs' => $qnaModel->getAllDivs()
            //쿠폰 다운로드 갯수
            , 'couponApplyCnt' => (is_null($couponList) ? 0 : count($couponList))
            , 'viewMode' => $viewMode
        ]);

        $isUserAdult   = (sess_val('user', 'age') >= '19' ? true : false);

        #기획 할인 정보 획득
        $discountView = false;
        $saleTime = "";
        $basicDiscountPrice = f_decimal(0);
        $groupDiscountPrice = f_decimal(0);
        $directDiscountPrice =f_decimal(0);
        $addDiscountPrice =f_decimal(0);
        $planDiscountPrice =f_decimal(0);

        if(isset($datas['discountList'])){
            if(is_array($datas['discountList'])){
                $beforEndTime = 0;
                $beforEndTimeSp = 0;

                foreach($datas['discountList'] as $key =>$val){

                    if ($val['type'] == 'MG') {
                        $groupDiscountPrice += $val['discount_amount'];
                    } else if($val['type'] == 'IN'){
                        $directDiscountPrice += $val['discount_amount'];
                    }else if($val['type'] == 'SP'){
                        $addDiscountPrice += $val['discount_amount'];
                    }else if($val['type'] == 'GP'){
                        $planDiscountPrice += $val['discount_amount'];
                    }else{
                        $basicDiscountPrice += $val['discount_amount'];
                    }

                    if ($val['type'] == 'GP') {
                        if (isset($val['sDate']) && isset($val['eDate']) && !empty($val['sDate']) && !empty($val['eDate'])) {
                            $sDate = $val['sDate'];
                            $eDate = $val['eDate'];

                            if (time() >= strtotime($sDate) && time() > strtotime($eDate)) {
                                $discountView = true;
                                $saleTime = $eDate;
                                $nowTime = time();
                                $endTime = $saleTime - $nowTime;
                                if($beforEndTime > $endTime){
                                    $endTime = $beforEndTime;
                                }
                                $beforEndTime = $endTime;
                                $view->assign('saleTime', $endTime);
                            }
                        }
                    }

                    //추가할인의 타임세일이 적용되어 있을 경우 기존 타임세일 정보는 추가할인의 타임세일 정보로 교체 한다.
                    if ($val['type'] == 'SP') {
                        if (isset($val['sDate']) && isset($val['eDate']) && !empty($val['sDate']) && !empty($val['eDate'])) {
                            $sDate = $val['sDate'];
                            $eDate = $val['eDate'];

                            if (time() >= strtotime($sDate) && time() > strtotime($eDate)) {
                                $discountView = true;
                                $saleTime = $eDate;
                                $nowTime = time();
                                $endTime_sp = $saleTime - $nowTime;
                                if($beforEndTimeSp > $endTime_sp){
                                    $endTime_sp = $beforEndTimeSp;
                                }
                                $beforEndTimeSp = $endTime_sp;
                                $view->assign('saleTime', $endTime_sp);
                            }
                        }
                    }

                }
            }
        }

        $view->assign('discountView', $discountView);

        //혜택내역
        $couponDiscountPrice = f_decimal(0);
        $couponApplyPrice = $datas['dcprice'];
        $userCouponList = $couponModel->applyProductUserCouponList($datas['id'], $datas['dcprice'], $datas['dcprice'], $datas['discount_coupon_use_yn']);

        foreach ($userCouponList as $couponKey => $coupon) {
            if ($coupon['activeBool'] == true) {
                if($couponApplyPrice > $coupon['total_coupon_with_dcprice']){
                    if($couponApplyPrice >= $coupon['discount_amount']){
                        $couponApplyPrice = $coupon['total_coupon_with_dcprice'];
                        $couponDiscountPrice = $coupon['discount_amount'];
                    }
                }
            }
        }

        $totalDiscountRate = ((int)$directDiscountPrice + (int)$planDiscountPrice + (int)$couponDiscountPrice + (int)$groupDiscountPrice) / (int)$datas['listprice'] * 100;

        $view->assign('totalDiscountRate', $totalDiscountRate);
        $view->assign('basicDiscountPrice', $basicDiscountPrice);
        $view->assign('addDiscountPrice', $addDiscountPrice);
        $view->assign('planDiscountPrice', $planDiscountPrice);
        $view->assign('directDiscountPrice', $directDiscountPrice);
        $view->assign('groupDiscountPrice', $groupDiscountPrice);
        $view->assign('couponDiscountPrice', $couponDiscountPrice);
        $view->assign('couponApplyPrice', $couponApplyPrice);


        #동일 품목 상품정보 가져오기
        $sameProduct = $productModel->getSameItem($id);
        $view->assign('sameProduct', $sameProduct);

        #같이구매한 상품
        $togetArr = ['pid'=>$id];
        #유사한 상품정보 - 카테고리 기준
        $simArr = ['cid'=>$cid, 'pid'=>$id];
        $togeterProduct = [];
        $similraProduct = [];
        $relationProduct = [];
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            $togeterProduct = $productModel->getTogeterProduct($togetArr);
            $similraProduct = $productModel->getSimilarProduct($simArr);
            $relationProduct = $productModel->getRelationProduct($togetArr);
        }
        $view->assign('togeterProduct', $togeterProduct);
        $view->assign('similraProduct', $similraProduct);
        $view->assign('relationProduct', $relationProduct);

        //Color Chip 가지고 오기
        $view->assign('colorChipList', $productModel->getColorChipList($id));

        /* @var $displayModel CustomMallDisplayModel */
        $displayModel = $view->import('model.mall.display');

        /*if(is_mobile()) {
            #상세 이베트 배너 노출
            $eventBannerInfo = $displayModel->getDisplayBannerGroup(12);
            $view->assign('eventBannerInfo', $eventBannerInfo);
        }else{*/
            #상세 이베트 배너 노출
            $eventBannerInfo = $displayModel->getDisplayBannerGroup(25);
            $view->assign('eventBannerInfo',$eventBannerInfo);
        //}

        #상품분류별 연관컨턴츠 가져오기
        $subCid0 = substr($cid, 0, 3);
        $subCid1 = substr($cid, 3, 3);
        $subCid2 = substr($cid, 6, 3);
        $subCid3 = substr($cid, 9, 3);
        $subCid4 = substr($cid, 12, 3);

        $cid = $subCid0."000000000000";
        $displayContentList0 = $displayModel->getDisplayContentGoodsRelationId($cid);

        $cid = $subCid0.$subCid1."000000000";
        $displayContentList1 = $displayModel->getDisplayContentGoodsRelationId($cid);

        $cid = $subCid0.$subCid1.$subCid2."000000";
        $displayContentList2 = $displayModel->getDisplayContentGoodsRelationId($cid);

        $cid = $subCid0.$subCid1.$subCid2.$subCid3."000";
        $displayContentList3 = $displayModel->getDisplayContentGoodsRelationId($cid);

        $cid = $cid;
        $displayContentList4 = $displayModel->getDisplayContentGoodsRelationId($cid);
        #상품분류별 연관컨턴츠 가져오기

        #상품별 연관컨턴츠 가져오기
        $displayContentList5 = $displayModel->getDisplayContentProductRelationId($id);

        $displayContentListId = array_merge($displayContentList0, $displayContentList1, $displayContentList2, $displayContentList3, $displayContentList4, $displayContentList5);

        foreach($displayContentListId as $key => $val){
            if($key == 0){
                $con_ix = $val['con_ix'];
            }else{
                $con_ix = $con_ix.", ".$val['con_ix'];
            }
        }

        if($con_ix != ""){
            $displayContentList = $displayModel->getDisplayContentGoodsRelationNew($con_ix);

            $wishModel = $view->import('model.mall.wish');
            $c = 0;
            foreach($displayContentList as $key){
                if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
                    $displayContentList[$c]['alreadyWishContent'] = 'Y';
                }else{
                    $displayContentList[$c]['alreadyWishContent'] = 'N';
                }
                $c++;
            }

            $view->assign('displayContentList', $displayContentList);
        }


        //sns 메타태그 데이터 assign
        $view->setLayoutAssign('isSnsShare', 'Y');
        $view->setLayoutAssign('snsShareImage', get_product_images_src($datas['id'], $isUserAdult, 'm', $datas['is_adult']));
        $view->setLayoutAssign('snsShareTitle', $datas['pname']);
        $view->setLayoutAssign('snsShareUrl', HTTP_PROTOCOL.FORBIZ_HOST.'/shop/goodsView/'.$id);
        $view->setLayoutAssign('snsShareDescription', $datas['shotinfo']);

		$laundry_cid = substr($datas['laundry_cid'],0,3)."000000000000";

		$laundryOneDepth	= $productModel->getLaundryList(0, '');
		$laundryTwoDepth	= $productModel->getLaundryList(1, substr($datas['laundry_cid'],0,3));

		$o = 0;
		foreach($laundryTwoDepth as $twoValue){
			$laundry[$o]['cid']			= $twoValue['cid'];
			$laundry[$o]['title']		= $twoValue['title'];
			$laundry[$o]['title_en']	= $twoValue['title_en'];

			$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

			$laundry[$o]['firstCid'] = $laundryThreeDepth[0]['cid'];
			
			$t = 0;
			foreach($laundryThreeDepth as $threeValue){
				$laundry[$o]['three'][$t]['cid']		= $threeValue['cid'];
				$laundry[$o]['three'][$t]['title']		= $threeValue['title'];
				$laundry[$o]['three'][$t]['title_en']	= $threeValue['title_en'];

				$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

				$f = 0;
				foreach($laundryFourDepth as $fourValue){

					if($fourValue['title'] == "중성세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "수돗물 세탁") {
						$imgCnt			= "02";
					}else if($fourValue['title'] == "건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "미끄럼틀 금지") {
						$imgCnt			= "04";
					}else if($fourValue['title'] == "트렁크 금지") {
						$imgCnt			= "05";
					}else if($fourValue['title'] == "모래끼임") {
						$imgCnt			= "06";
					}else if($fourValue['title'] == "오일") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "흙탕물 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "보관 시") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "네오프렌 세척") {
						$imgCnt			= "37";
					}else if($fourValue['title'] == "세제 금지") {
						$imgCnt			= "11";
					}else if($fourValue['title'] == "직사광선 주의") {
						$imgCnt			= "12";
					}else if($fourValue['title'] == "날카로움 주의") {
						$imgCnt			= "13";
					}else if($fourValue['title'] == "손바닥 사용") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "옷걸이 건조") {
						$imgCnt			= "38";
					}else if($fourValue['title'] == "네오프렌 보관 시") {
						$imgCnt			= "39";
					}else if($fourValue['title'] == "표백제 금지") {
						$imgCnt			= "17";
					}else if($fourValue['title'] == "세탁망") {
						$imgCnt			= "18";
					}else if($fourValue['title'] == "다리미 사용 금지") {
						$imgCnt			= "19";
					}else if($fourValue['title'] == "건조 시") {
						$imgCnt			= "20";
					}else if($fourValue['title'] == "단독 손세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "생활 방수") {
						$imgCnt			= "22";
					}else if($fourValue['title'] == "미지근한 온도") {
						$imgCnt			= "23";
					}else if($fourValue['title'] == "비틀기 금지") {
						$imgCnt			= "24";
					}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
						$imgCnt			= "25";
					}else if($fourValue['title'] == "충격 주의") {
						$imgCnt			= "26";
					}else if($fourValue['title'] == "화기 주의") {
						$imgCnt			= "27";
					}else if($fourValue['title'] == "수중 사용 금지") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "수경 세척 시") {
						$imgCnt			= "29";
					}else if($fourValue['title'] == "별도 사용 금지") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "올 관리") {
						$imgCnt			= "31";
					}else if($fourValue['title'] == "접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "유기 용액") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "유분 주의") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "안티포그액") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "렌즈 접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "중성 세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "오염주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "오염 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "단독세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "착용 시") {
						$imgCnt			= "32";
					}else if($fourValue['title'] == "30kg이하 사용 주의") {
						$imgCnt			= "33";
					}else if($fourValue['title'] == "어린이와 함께 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "인명 구조 주의") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "인명구조 사용금지") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "강한 물살 주의") {
						$imgCnt			= "36";
					}else{
						$imgCnt			= "0";
					}
					$laundry[$o]['three'][$t]['four'][$f]['cid']			= $fourValue['cid'];
					$laundry[$o]['three'][$t]['four'][$f]['imgCnt']			= $imgCnt;
					$laundry[$o]['three'][$t]['four'][$f]['title']			= $fourValue['title'];
					$laundry[$o]['three'][$t]['four'][$f]['contents']		= $fourValue['contents'];
					$laundry[$o]['three'][$t]['four'][$f]['title_en']		= $fourValue['title_en'];
					$laundry[$o]['three'][$t]['four'][$f]['contents_en']	= $fourValue['contents_en'];

					$f++;
				}
				$t++;
			}
			$o++;
		}

		$view->assign('laundryOneDepth', $laundryOneDepth);
		$view->assign('laundryCid', $laundry_cid);
		$view->assign('laundryTwoFirst', substr($datas['laundry_cid'],0,6)."000000000");
		$view->assign('laundry', $laundry);



        // 안내팝업 데이터 (frontend)
        $view->define([
            'productRepairGuide' => "customer/product_repair_guide/product_repair_guide_content.htm",
            'shippingGuide' => "customer/shipping_guide/shipping_guide_content.htm",
            //'productPrecautions' => 'customer/product_precautions/product_precautions_content.htm',
			//'productPrecautions' => $laundryInfo, 
            'cliamGuide' => 'customer/cliam_guide/cliam_guide_content_230126.htm'
        ]);

        //코스매틱 여부 (006으로 시작)
        $isCosmetic = 0;
        if(substr($datas['cid'], 0, 3) == '006') {
            $isCosmetic = 1;
        }

        $view->assign('isCosmetic',$isCosmetic);

        //후기영역 배너 추가
        if (is_mobile()) {
            $reviewBanner = $displayModel->getDisplayBannerGroup(64);
            $view->assign('reviewBanner', $reviewBanner[0]);
        } else {
            $reviewBanner = $displayModel->getDisplayBannerGroup(63);
            $view->assign('reviewBanner', $reviewBanner[0]);
        }

        //이메일
        if (!empty(sess_val('user', 'mail'))) {
            $email = explode('@', sess_val('user', 'mail'));

            $view->assign('emailId', $email[0]);
            $view->assign('emailHost', $email[1]);
        }

        // content output
        echo $view->loadLayout();
    }
} else {
    show_error('등록되지 않은 상품입니다.');
}
