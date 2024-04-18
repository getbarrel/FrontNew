<?php

/**
 * Description of CustomMallShopController
 *
 * @author hoksi
 */
class CustomMallProductController extends ForbizMallProductController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 미니카트에 사용할 옵션 데이터 호출
     * @param string $pid
     */
    public function loadOptionDatas($pid = null)
    {

        if ($pid) {
            $this->setResponseType('js'); //js 로 리턴

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');
            $productModel->setDiscoutMemberGroupCalculationYn('Y');

            $prdData = $productModel->get($pid); //옵션 데이터 호출
            $options = $productModel->getOption($pid); //옵션 데이터 호출

            $buyCountCondition = $productModel->getBuyCountCondition($pid, sess_val('user', 'code')); //구매가능 조건(수량) 호출

            $productModel->setDiscoutMemberGroupCalculationYn('N');
            echo "var devOptionData = " . json_encode($options) . ";\n" //옵션 데이터
                . "var allow_basic_cnt = " . $buyCountCondition['allow_basic_cnt'] . ";\n" //구매허용 수량
                . "var allow_max_cnt = " . $buyCountCondition['allow_max_cnt'] . ";\n" //구매허용 수량
            . "var product_state = '" . $prdData['status'] . "';\n" //판매상태
            . "var user_buy_cnt = '" . $buyCountCondition['user_buy_cnt'] . "';\n" //회원구매수량
            . "var allow_byoneperson_cnt = " . ($buyCountCondition['allow_byoneperson_cnt'] ) . ";\n"; //인당 최대구매 수량. 옵션일 경우 계산하기 애매함. PM 협의필요.
        }
    }

    /**
     * 검색어 자동완성
     */
    public function getAutocomplet()
    {
        $keyword = $this->input->post('searchText');
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->getAutocomplet($keyword);
        $this->setResponseResult('success')->setResponseData($responseData);
        
    }

    /**
     * 상품 리스트
     */
    public function getGoodsList()
    {
        /* 기본 필터 */
        $max = $this->input->post('max');
        $page = $this->input->post('page');
        $orderBy = $this->input->post('orderBy');

        $cid = $this->input->post('filterCid');
        $subCid = $this->input->post('subCid');
        

        /* 추가 필터 */
        $filter['filterCid'] = ($subCid ? $subCid : $cid);
        $filter['filterBrands'] = $this->input->post('filterBrands');
        $filter['filterDeliveryFree'] = $this->input->post('filterDeliveryFree');

        if($this->input->post('filterInsideText') != "") {
			$filter['filterInsideText'] = "";
			$filter['filterText'] = $this->input->post('filterInsideText');

        }else{
			$filter['filterInsideText'] = $this->input->post('filterInsideText');
			$filter['filterText'] = $this->input->post('filterText');
		}
        
		$isSearchPage = $this->input->post('filterSearchPage'); //search page 구분용
        $filter['product_filter'] = $this->input->post('product_filter');
        $filter['sprice'] = $this->input->post('sprice');
        $filter['eprice'] = $this->input->post('eprice');

        // 최상위 카테고리 정보
        $kind = ForbizConfig::getProductTopKind();
        $filter['filterCid'] = $kind[$filter['filterCid']] ?? $filter['filterCid'];

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        /* @var $wishModel ForbizMallWishModel */
        $wishModel = $this->import('model.mall.wish');

        $responseData = $productModel->getList($filter, $page, $max, $orderBy);
        /*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
            print_r($responseData);
            exit;
        }*/
        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                $responseData['list'][$key] = $row;
            }
            //$responseData['filterInsideText'] = $filter['filterInsideText'];
            $responseData['filterText'] = $filter['filterInsideText'];
        }

        $isFilterSearch = false;

        foreach ($filter as $key => $val) {
            if ($key == 'filterCid')
                continue;
            if ($val != '') {
                $isFilterSearch = true;
                break;
            }
        }

        if ($isFilterSearch === true && $responseData['total'] == 0 && !$isSearchPage) {
            $this->setResponseResult('emptySearchFilter')->setResponseData($responseData);
        } else {
            $this->setResponseResult('success')->setResponseData($responseData);
        }
    }
    
    /**
     * 검색엔진용
     */
    public function getSearchGoodsList()
    {
        /* 기본 필터 */
        $max = $this->input->post('max');
        $page = $this->input->post('page');
        $orderBy = $this->input->post('orderBy');

        $cid = $this->input->post('filterCid');
        $subCid = $this->input->post('subCid');


        /* 추가 필터 */
        //$filter['filterCid'] = ($subCid ? $subCid : $cid);
        $filter['filterBrands'] = $this->input->post('filterBrands');
        $filter['filterDeliveryFree'] = $this->input->post('filterDeliveryFree');

        if($this->input->post('filterInsideText') != "") {
			$filter['filterInsideText'] = "";
			$filter['filterText'] = $this->input->post('filterInsideText');

        }else{
			$filter['filterInsideText'] = $this->input->post('filterInsideText');
			$filter['filterText'] = $this->input->post('filterText');
		}
        
        $isSearchPage = $this->input->post('filterSearchPage'); //search page 구분용
        $filter['product_filter'] = $this->input->post('product_filter');
        $filter['sprice'] = $this->input->post('sprice');
        $filter['eprice'] = $this->input->post('eprice');

        // 최상위 카테고리 정보
        $kind = ForbizConfig::getProductTopKind();
        $filter['filterCid'] = $kind[$filter['filterCid']] ?? $filter['filterCid'];

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        /* @var $wishModel ForbizMallWishModel */
        $wishModel = $this->import('model.mall.wish');

        $responseData = $productModel->getSearchList($filter, $page, $max, $orderBy);
        

        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                $responseData['list'][$key] = $row;
            }
            //$responseData['filterInsideText'] = $filter['filterInsideText'];
            $responseData['filterText'] = $filter['filterInsideText'];
        }

        $isFilterSearch = false;

        foreach ($filter as $key => $val) {
            if ($key == 'filterCid')
                continue;
            if ($val != '') {
                $isFilterSearch = true;
                break;
            }
        }

        if ($isFilterSearch === true && $responseData['total'] == 0 && !$isSearchPage) {
            $this->setResponseResult('emptySearchFilter')->setResponseData($responseData);
        } else {
            $this->setResponseResult('success')->setResponseData($responseData);
        }
    }

    /**
     * 최근검색어 삭제
     */
    function deleteRecentKeyword()
    {
        $searchText = $this->input->post('searchText');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->deleteRecentKeyword($searchText);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 최근검색어 전체삭제
     */
    function deleteAllRecentKeyword()
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->deleteAllRecentKeyword();

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 관심상품 체크
     */
    function getCheckAlreadyWish()
    {
        $id = $this->input->post('id');

        /* @var $wishModel ForbizMallWishModel */
        $wishModel = $this->import('model.mall.wish');

        $responseData = $wishModel->checkAlreadyWish($id);

        $this->setResponseResult('success')->setResponseData($responseData);
    }
    /*
     * 이벤트 쿠폰 다운로드 링크
     */

    public function downEventCoupon()
    {
        $chkField = ['publishIx'];

        // 비로그인시 로그인 페이지로
        if (form_validation($chkField)) {
            $publishIx = $this->input->post('publishIx');

            /* @var $couponModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            $result = $couponModel->giveCoupon($publishIx);

            $this->setResponseResult($result);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function selectQna()
    {
        $bbsIx = $this->input->post('bbs_ix');

        $qnaModel = $this->import('model.mall.productQna');
        $qnaData = $qnaModel->getSelectQna($bbsIx);

        $this->setResponseResult('success')->setResponseData($qnaData);

        return $qnaData;
        //$view->assign($qnaData);
    }
    /**
     * 상품문의 작성
     */
    public function qnaWrite()
    {
        if (is_login()) {
            $chkField = ['div', 'pid', 'subject', 'contents'];

            if (form_validation($chkField)) {
                $res = $this->input->post(); //데이터가 많아 배열로 넘김

                $bbsIx = $this->input->post('bbs_ix');

                /* @var $qnaModel CustomMallProductQnaModel */
                $qnaModel = $this->import('model.mall.productQna');

                if ($bbsIx) {
                    $responseData = $qnaModel->updateQna($res);
                } else {
                    $responseData = $qnaModel->insertQna($res);
                }


                if ($responseData) {
                    $this->setResponseResult('success');
                } else {
                    $this->setResponseResult('fail');
                }
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        }
    }

    public function productReStock()
    {
        $chkField = ['option_id'];

        if (is_login()) {
            if (form_validation($chkField)) {
                $res = $this->input->post(); //데이터가 많아 배열로 넘김
                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');

                $responseData = $productModel->inputProductReStock($res);

                if ($responseData == 'success') {
                    $this->setResponseResult('success');
                } else if ($responseData == 'overlap') {
                    $this->setResponseResult('overlap');
                } else {
                    $this->setResponseResult('fail');
                }
            } else {
                $this->setResponseResult('optionIdFail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('loginFail');
        }
    }

	public function productReStockMobile()
    {
		//$chkField = ['option_id'];
		$res = $this->input->get(); //데이터가 많아 배열로 넘김

		if (is_login()) {
			if ($res['option_id'] != "") {
				/* @var $productModel CustomMallProductModel */
				$productModel = $this->import('model.mall.product');
				$responseData = $productModel->inputProductReStock($res);

				if ($responseData == 'success') {
					exit("<script>alert('입고알림 신청이 완료 되었습니다.');document.location.replace('/shop/goodsView/".$res['pid']."');</script>");
				} else if ($responseData == 'overlap') {
					exit("<script>alert('신청된 정보가 존재합니다.');document.location.replace('/shop/goodsView/".$res['pid']."');</script>");
				} else {
					exit("<script>alert('system error');document.location.replace('/shop/goodsView/".$res['pid']."');</script>");
				}
			} else {
				exit("<script>alert('옵션을 선택해 주세요.');document.location.replace('/shop/goodsView/".$res['pid']."');</script>");
			}	
        } else {
			exit("<script>alert('로그인이 필요합니다.');document.location.replace('/member/login?url=/shop/goodsView/'".$res['pid']."');</script>");
        }
    }

    public function getStockReminderList()
    {
        $max = $this->input->post('max');
        $page = $this->input->post('page');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');


        $responseData = $productModel->getStockReminderList($page, $max);

        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                //$row['optionDiv'] = $row['option_name'] . ':' . $productModel->getOptionDiv($row['op_id']);
                $row['optionDiv'] = $productModel->getOptionDiv($row['op_id']);
                $row['regdateYmd'] = date('Y.m.d', strtotime($row['regdate']));
                $row['expiration_date'] = date('Y.m.d', strtotime($row['expiration_date']));

				if($row['rm_status'] == "N"){
					$row['rm_status_name'] = "알림신청";
				} else if($row['rm_status'] == "Y"){
					$row['rm_status_name'] = "알림완료";
				} else if($row['rm_status'] == "X"){
					$row['rm_status_name'] = "알림취소";
				} else if($row['rm_status'] == "P"){
					$row['rm_status_name'] = "입고미정";
				} else if($row['rm_status'] == "E"){
					$row['rm_status_name'] = "판매종료";
				}
			
                $responseData['list'][$key] = $row;
            }
        }

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function deleteReminder()
    {
        $sr_ix = $this->input->post('sr_ix');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');


        $responseData = $productModel->deleteReminder($sr_ix);
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function getBeforeProductView()
    {

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');


        if (is_login()) {
            $userCode = $this->userInfo->code;
        } else {
            $userCode = session_id();
        }

        $responseData = $productModel->getBeforeProductView($userCode);
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function searchStore()
    {

        $item = $this->input->post('item');
        $city = $this->input->post('city');

        $data = array(
            'key' => '6485DD4E6FB095EA',
            'item_id' => $item,
            'area_cd' => $city
        );
        $queryString = http_build_query($data, '', '&');
        $url = "http://barrel.sgerp.com/openapi/shop_stock?" . $queryString;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $responseData = curl_exec($ch);
        curl_close($ch);
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function searchFreeGift(){

        $chkField = ['cartIx[]'];


        if (form_validation($chkField)) {
            $cartIxs = $this->input->post('cartIx');
            $saleCouponPrice = $this->input->post('saleCouponPrice');
            $useMileage = $this->input->post('useMileage');
            $giftOrderData = $this->input->post('giftOrderData');
            $giftSelect = $this->input->post('giftSelect');
            $giftSelectC = $this->input->post('giftSelectC');
            $giftSelectP = $this->input->post('giftSelectP');


            /* @var $cartModel CustomMallCartModel */
            $cartModel = $this->import('model.mall.cart');

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');

            $cartData = $cartModel->get($cartIxs);
            $cartSummary = $cartModel->getSummary($cartData);

            $freeGiftCheckPrice = $cartSummary['summary']['product_dcprice'] - (int)$saleCouponPrice - (int)$useMileage;
            $freeGift = $productModel->getFreeGiftInfo($cartData,'all',$cartSummary['summary']['product_dcprice']);

            if(isset($freeGift) && is_array($freeGift)){
                $responseArray = [];
                foreach($freeGift as $key=>$freeGiftOrderItem){
                    switch($freeGiftOrderItem['freegift_condition']){
                        case 'G';
                            $checkGiftSelect = $giftSelect;
                            $freeGiftArray = $productModel->getFreeGiftNew($freeGiftOrderItem['freegift_condition'],$freeGiftCheckPrice,'','',$cartData);
                            break;
                        case 'P';
                            $checkGiftSelect = $giftSelectP;
                            $freeGiftArray = $productModel->getFreeGiftByProducts($cartData,$freeGiftCheckPrice);
                            break;
                        case 'C';
                            $checkGiftSelect = $giftSelectC;
                            $freeGiftArray = $productModel->getFreeGiftByCategory($cartData);
                            break;
                    }

                    if (isset($freeGiftArray['gift_products'])) {
                        if(isset($freeGiftArray['fg_ix']) && isset($giftOrderData) && $checkGiftSelect == 'true'){
                            //$responseArray['giftPid'] = [];
                            foreach($giftOrderData as $gOrderVal){
                                if($gOrderVal['freegift_condition'] == $freeGiftArray['freegift_condition']){
                                    /*if($gOrderVal['fgIx'] != $freeGiftArray['fg_ix']){
                                        $responseArray[$freeGiftOrderItem['freegift_condition']] = 'giftCompareFail';
                                    }else{*/
                                        //$responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'success';

                                        $responseArray[$freeGiftOrderItem['freegift_condition']]['giftPid'][] = $gOrderVal['giftPid'];
                                        $responseArray[$freeGiftOrderItem['freegift_condition']]['fgIx'][] = $gOrderVal['fgIx'];

                                        foreach($freeGiftArray['gift_products'] as $gVal){
                                            foreach($gVal as $gVal2){
                                                if($gOrderVal['giftPid'] == $gVal2['pid'] && $gOrderVal['fgIx'] == $gVal2['event_fg_ix']){
                                                    $responseArray[$freeGiftOrderItem['freegift_condition']]['pid'][] = $gVal2['pid'];
                                                    $responseArray[$freeGiftOrderItem['freegift_condition']]['eFgIx'][] = $gVal2['event_fg_ix'];
                                                }
                                            }
                                        }

                                    //}
                                    //$responseArray[$freeGiftOrderItem['freegift_condition']]['giftPid'][] = $gOrderVal['giftPid'];
                                    //$responseArray[$freeGiftOrderItem['freegift_condition']]['pid'][] = $gOrderVal['giftPid'];
                                }




                                /*if($gOrderVal['freegift_condition'] == $freeGiftArray['freegift_condition']){
                                    if($gOrderVal['fgIx'] != $freeGiftArray['fg_ix']){
                                        $responseArray[$freeGiftOrderItem['freegift_condition']] = 'giftCompareFail';
                                        //$this->setResponseResult('giftCompareFail');
                                    }else{
                                        $responseArray[$freeGiftOrderItem['freegift_condition']] = 'success';
                                    }
                                }else{
                                    $responseArray[$freeGiftOrderItem['freegift_condition']] = 'success';
                                }

                                //$responseArray['giftPid'][] = $gOrderVal['giftPid'];
                                $responseArray[$freeGiftOrderItem['freegift_condition']]['giftPid'][] = $gOrderVal['giftPid'];*/
                            }

                            /*foreach($freeGiftArray['gift_products'] as $gVal){
                                foreach($gVal as $gVal2){
                                    $responseArray[$gVal['freegift_condition']]['pid'][] = $gVal2['pid'];
                                }
                            }*/
/*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
    print_r($responseArray);
}*/


                            if(count($responseArray[$freeGiftOrderItem['freegift_condition']]['giftPid']) == count($responseArray[$freeGiftOrderItem['freegift_condition']]['pid'])){
                                $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'success';
                            }else{
                                $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'giftCompareFail';
                            }

                        }else{
                            $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'success';
                            //$this->setResponseResult('success')->setResponseData($val['freegift_condition']);
                        }

                    }else{
                        if(isset($freeGiftArray['soldOut']) && $freeGiftArray['soldOut'] == true){
                            $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'stockFail';
                            //$this->setResponseResult('stockFail');
                        }else if($cartSummary['summary']['payment_price'] != $freeGiftCheckPrice){
                            $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'changePrice';
                            //$this->setResponseResult('changePrice');
                        }else{
                            $responseArray[$freeGiftOrderItem['freegift_condition']]['result'] = 'stockFail';
                            //$this->setResponseResult('stockFail');
                        }

                    }
                }

                $this->setResponseResult('success')->setResponseData($responseArray);
            }


            //$freeGift = $productModel->getFreeGift($freeGiftCheckPrice);


        } else {
            $this->setResponseResult('optionIdFail')->setResponseData(validation_errors());
        }
    }
}
