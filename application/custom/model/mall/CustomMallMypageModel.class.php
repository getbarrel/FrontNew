<?php

/**
 * Description of CustomMallMypageModel
 *
 * @author hoksi
 */
class CustomMallMypageModel extends ForbizMallMypageModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 주문 교환/반품 확인
     * @param string $userCode
     * @param string $claimType
     * @param string $applyData
     * @return array
     */
    public function doOrderClaimConfirm($userCode, $claimType, $applyData)
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        // 세트/코디 주문 확장
        $extData = $this->extendOdIx($applyData['oid'], $applyData['od_ix'], $applyData['claim_cnt']);

        $applyData['od_ix']         = $extData['od_ix'];
        $applyData['claim_cnt']     = $extData['claim_cnt'];
        $applyData['claim_set_cnt'] = $extData['claim_set_cnt'];

        $orderSearch = (isset($applyData['od_ix']) ? ['od_ix' => $applyData['od_ix']] : []);

        //교환으로 신규 생성된 주문인지 확인. 해당 주문건은 동일한 배송정책인 다른 주문 상세건이 있어도 같이 클레임할 수 없도록하였으므로 count로 체크함.
        //해당 관련 따로 요구사항 없었고 다른 정상 주문건과 같은 프로세스를 탈 경우 꼬일 수 있음.
        if (count($applyData['od_ix']) == 1) {
            $details  = $this->qb->select('claim_delivery_od_ix')->from(TBL_SHOP_ORDER_DETAIL)->where('od_ix', $applyData['od_ix'][0])->exec()->getRowArray();
            $exchange = $details['claim_delivery_od_ix'];
        } else {
            $exchange = 0;
        }

        $ret = $this->doOrderDetail($userCode, $applyData['oid'], false, $orderSearch, [], $exchange);

        // 구매금액별 사은품 존재여부 체크 및 반품해야할 사은품 처리 부분
        if($ret['order']['freeGift']){
            // 주문전체금액 - 반품금액 계산하여 구매금액별 사은품 구간 체크하기
            //$totalPrice     = $ret['paymentInfo']['payment'][0]['payment_price'];
            $totalPrice     = $ret['paymentInfo']['nowPrice'];
            $refundPrice    = $ret['paymentInfo']['pt_dcprice'];
            $remainingPrice = $totalPrice - $refundPrice;
            $giftProducts   = $ret['order']['freeGift'][0]['gift_products'];

            // 월래 금액 사은품 목록 가져오기(금액별 사은품 일때)
            $rows = $this->qb
                ->select('fpr.pid')
                ->select('fg.freegift_event_title')
                ->from(TBL_SHOP_FREEGIFT . ' AS fg')
                ->join(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS fpg', 'fg.fg_ix = fpg.fg_ix')
                ->join(TBL_SHOP_FREEGIFT_PRODUCT_RELATION . ' AS fpr', 'fg.fg_ix = fpr.fg_ix')
                ->where('fg.freegift_condition', 'G')   // where('fg.freegift_condition', $freeGiftCondition) 현재는 금액별 사은품으로 G 이지만 C(특정 카테고리 사은품) P(이벤트 제품 구매시 금액별 사은품) 이 부분도 체크 해야함.
                ->where('fg.disp', 1)// 전시여부 = 전시
                ->where('fg.fg_use_sdate <=', time())
                ->where('fg.fg_use_edate >=', time())
                ->where('fpg.sale_condition_s <=', $totalPrice)
                ->where('fpg.sale_condition_e >=', $totalPrice)
                ->whereIn('fg.mall_ix',['', MALL_IX])
                ->orderBy('fpg.sale_condition_s','desc')
                ->exec()
                ->getResultArray();

            foreach ($giftProducts as $key => $freeGift) {
                foreach ($rows as $row) {
                    if($freeGift['pid'] == $row['pid']){
                        $ret['order']['freeGift'][0]['gift_products'][$key]['giftTitle'] = $row['freegift_event_title'];
                    }
                }
            }
            $giftProducts   = $ret['order']['freeGift'][0]['gift_products'];

            // 남은 금액 사은품 목록 가져오기(금액별 사은품 일때)
            $rows = $this->qb
                ->select('fpr.pid')
                ->from(TBL_SHOP_FREEGIFT . ' AS fg')
                ->join(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS fpg', 'fg.fg_ix = fpg.fg_ix')
                ->join(TBL_SHOP_FREEGIFT_PRODUCT_RELATION . ' AS fpr', 'fg.fg_ix = fpr.fg_ix')
                ->where('fg.freegift_condition', 'G')   // where('fg.freegift_condition', $freeGiftCondition) 현재는 금액별 사은품으로 G 이지만 C(특정 카테고리 사은품) P(이벤트 제품 구매시 금액별 사은품) 이 부분도 체크 해야함.
                ->where('fg.disp', 1)// 전시여부 = 전시
                ->where('fg.fg_use_sdate <=', time())
                ->where('fg.fg_use_edate >=', time())
                ->where('fpg.sale_condition_s <=', $remainingPrice)
                ->where('fpg.sale_condition_e >=', $remainingPrice)
                ->whereIn('fg.mall_ix',['', MALL_IX])
                ->orderBy('fpg.sale_condition_s','desc')
                ->exec()
                ->getResultArray();

            foreach ($giftProducts as $key => $freeGift) {
                foreach ($rows as $row) {
                    if($freeGift['pid'] == $row['pid']){
                        unset($giftProducts[$key]);
                    }
                }
            }
            $ret['refundGiftProduct'] = $giftProducts;
        }

        $ret['applyData'] = $applyData;

        // 반품인가?
        if ($claimType == 'return') {

            // 반품
            $ret['applyData']['claimReasonText'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_RETURN_APPLY, $applyData['claim_reason'], 'title');

            // 환불계좌 정보
            $ret['refundInfo'] = $memberModel->getRefundAccount($userCode, true);

        } else {

            // 교환
            $ret['applyData']['claimReasonText'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_EXCHANGE_APPLY, $applyData['claim_reason'], 'title');
        }

        if (isset($applyData['quick']) && !empty($applyData['quick'])) {
            if(BASIC_LANGUAGE == 'korean'){
                $ret['applyData']['quickText'] = ForbizConfig::getDeliveryCompanyInfo($applyData['quick'], 'name');
            }else{
                $ret['applyData']['quickText'] = $applyData['quick'];
            }

        }

        if(!empty($applyData['country'])){
            /* @var $globalModel CustomMallGlobalModel */
            $globalModel = $this->import('model.mall.global');
            $nation = $globalModel->getSelectNationInfo($applyData['country']);
            $ret['applyData']['country_full'] = $nation['nation_name'];
        }

        $ret['confirmKey'] = md5(time().rand());

        return $ret;
    }

    public function getOrderGift($oid, $odIxs, $claimCnt)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        $extData = [];
        foreach ($odIxs as $odIx) {
            $claim_cnt  = $claimCnt[$odIx];
            $set_groups = $orderModel->chkSetGroup($oid, [$odIx => $claim_cnt]);
            foreach ($set_groups as $od_ix => $cnt) {
                $extData['od_ix'][]               = $od_ix;
                $extData['claim_cnt'][$od_ix]     = $claim_cnt;
                $extData['claim_set_cnt'][$od_ix] = $cnt;
            }
        }

        return $extData;
    }

    /**
     * 세트/코디 상품 주문인 경우 set_group로 확장
     * @param string $oid 주문번호
     * @param array $odIxs 주문상품 상세ID
     * @param array $claimCnt 수량
     * @return array
     */
    public function extendOdIx($oid, $odIxs, $claimCnt)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        $extData = [];
        foreach ($odIxs as $odIx) {
            $claim_cnt  = $claimCnt[$odIx];
            $set_groups = $orderModel->chkSetGroup($oid, [$odIx => $claim_cnt]);
            foreach ($set_groups as $od_ix => $cnt) {
                $extData['od_ix'][]               = $od_ix;
                $extData['claim_cnt'][$od_ix]     = $claim_cnt;
                $extData['claim_set_cnt'][$od_ix] = $cnt;
            }
        }

        return $extData;
    }

    /**
     * 푸시 마켓팅 동의 여부
     * @param string $device_id
     * @return mixed
     */
    public function getIsAllowableCheck($device_id)
    {
        $data = $this->qb
            ->select('is_allowable')
            ->from(TBL_MOBILE_PUSH_SERVICE)
            ->where('device_id', $device_id)
            ->exec()
            ->getRowArray();

        return $data['is_allowable'] ?? 1;
    }
    /*
     * 소멸 예정 마일리지 구하기
     * 30일 이내에 소멸 예정인 적립금 합
     */

    public function getExtMilageAmount()
    {
        $ext_total = $this->qb->from(TBL_SHOP_ADD_MILEAGE)
            ->select("SUM(am_mileage) AS ext_amount")
            ->where("uid", $this->user_code)
            ->where("am_state", '1')
            ->groupStart()
            ->where("oid", '')
            ->orWhere("oid", "is NULL")
            ->groupEnd()
            ->where("datediff(DATE_FORMAT(extinction_date,'%Y-%m-%d'),DATE_FORMAT(SYSDATE(),'%Y-%m-%d')) <=", 30)
            ->where("datediff(DATE_FORMAT(extinction_date,'%Y-%m-%d'),DATE_FORMAT(SYSDATE(),'%Y-%m-%d')) >", 0)
            ->exec()
            ->getRowArray();
        ;

        return $ext_total;
    }

    /**
     * 주문상세 정보 조회
     * @param string $userCode
     * @param string $orderId
     * @param boolean $useDeliveryInfo
     * @param array $orderSearch
     * @param array $orderSearchEtc
     * @param int $exchange : 교환으로 신규 생성된 주문인지 여부 확인
     * @return type
     */
    public function doOrderDetail($userCode, $orderId, $useDeliveryInfo = true, $orderSearch = [], $orderSearchEtc = [], $exchange = 0)
    {

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        $orderInfo = $orderModel->getOrderInfo($userCode, $orderId, $orderSearch, $orderSearchEtc, $exchange);

        if (!empty($orderInfo)) {
            $orderPaymentInfo = $orderModel->getPaymentInfo($orderId);

            $orderRefundInfoPrice = $orderModel->getRefundPaymentInfo($orderId);

            // 마일리지
            $reserve    = 0;
            $cartCoupon = 0;
            foreach ($orderPaymentInfo as $key => $val) {
                if ($val['method'] == ORDER_METHOD_RESERVE) {
                    $reserve = $val['payment_price'];
                    unset($orderPaymentInfo[$key]);
                } elseif ($val['method'] == ORDER_METHOD_CART_COUPON) {
                    $cartCoupon = $val['payment_price'];
                    unset($orderPaymentInfo[$key]);
                }
            }

            // 결제 정보
            $paymentInfo = [
                'dr_dc' => 0,
                'cp_dc' => 0,
                'dcp_dc' => 0,
                'mg_dc' => 0,
                'gp_dc' => 0,
                'use_reserve' => $reserve,
                'use_cart_coupon' => $cartCoupon,
                'total_dc' => 0,
                'total_reserve' => 0,
                'total_listprice' => 0,
                'pt_dcprice' => 0,
                'total_pcnt' => 0,
                'nowPrice'  => $orderRefundInfoPrice['allPrice'],
                'payment' => $orderPaymentInfo
            ];

            if (!empty($orderInfo['orderDetail'])) {
                foreach ($orderInfo['orderDetail'] as $deliveryOrder) {
                    foreach ($deliveryOrder as $oitem) {
                        $paymentInfo['dr_dc']           += ($oitem['dr_dc'] + $oitem['gp_dc'] + $oitem['sp_dc']); // 즉시할인에 회원할인 더함
                        $paymentInfo['mg_dc']           += $oitem['mg_dc'];
                        $paymentInfo['cp_dc']           += $oitem['cp_dc'];
                        $paymentInfo['dcp_dc']          += $oitem['dcp_dc'];
                        $paymentInfo['gp_dc']           += $oitem['gp_dc'];
                        $paymentInfo['total_dc']        += $oitem['total_dc'];
                        $paymentInfo['total_reserve']   += $oitem['reserve'];
                        $paymentInfo['total_listprice'] += $oitem['pt_listprice'];
                        $paymentInfo['pt_dcprice']      += $oitem['pt_dcprice'];
                        $paymentInfo['total_pcnt']      += $oitem['pcnt'];
                    }
                }
            }


            //주문상세 클레임 정보 가져오기
            $claimData = [];
            if (!empty($orderInfo['orderDetail'])) {
                $claimData = $this->getDtailClaim($userCode, $orderId ,$orderInfo['orderDetail']);
            }

            //주문상세 클레임 합산 정보 가져오기
            $claimMergedData = [];
            if (!empty($orderInfo['orderDetail'])) {
                $claimMergedData = $this->getDtailClaimMerged($userCode, $orderId ,$orderInfo['orderDetail']);
            }

            return [
                'order' => $orderInfo,
                'paymentInfo' => $paymentInfo,
                'deliveryInfo' => ($useDeliveryInfo ? $orderModel->getDeliveryInfo($orderId) : false),
                'claimData' => ($claimData ? $claimData : []),
                'claimMergedData' =>($claimMergedData ? $claimMergedData : [])
            ];
        }
    }

    /**
     * 마이페이지 메인의 등급정보, 다음 등급정보 가져오기
     * @param string $gp_ix : 현재 등급 idx
     */
    public function getGroupInfo($gp_ix){

        $currentGroup = $this->qb->select('*')
            ->from(TBL_SHOP_GROUPINFO)
            ->where('gp_ix', $gp_ix)
            ->where('mall_ix', MALL_IX)
            ->exec()->getResultArray();

        $ngp_level = $currentGroup[0]['gp_level'] - 1;

        $nextGroup = $this->qb->select('*')
            ->from(TBL_SHOP_GROUPINFO)
            ->where('gp_level', $ngp_level)
            ->where('mall_ix', MALL_IX)
            ->exec()->getResultArray();

        return [
            'currentGroup' => $currentGroup[0] ?? "",
            'nextGroup' => $nextGroup[0] ?? ""
        ];
    }


    /**
     * 오프라인쿠폰 등록
     * @param $couponNum
     */
    public function registOffLineCoupon($couponNum){
        $coupon = $this->qb
            ->select('gcd.gcd_ix')
            ->select('gcd.gc_ix')
            ->select('gc.gift_type')
            ->select('gc.gift_amount')
            ->select('gc.gift_start_date')
            ->select('gc.gift_end_date')
            ->select('gcd.gift_change_state')
            ->from(TBL_SHOP_GIFT_CERTIFICATE .' as gc')
            ->join(TBL_SHOP_GIFT_CERTIFICATE_DETAIL .' as gcd' ,'gc.gc_ix = gcd.gc_ix' ,'inner')
            ->where('gcd.gift_code' , $couponNum)
            ->whereNotIn('gc.gift_type' , 'U')
            ->exec()->getRowArray();

        if(!empty($coupon)){

            if ($coupon['gift_change_state'] == '1') {
                return 'failOverlap';
            }

            $gc_ix = $coupon['gc_ix'];
            $gcd_ix = $coupon['gcd_ix'];
            $gift_type = $coupon['gift_type'];
            $gift_amount = $coupon['gift_amount'];
            $gift_start_date_ = $coupon['gift_start_date'];
            $gift_end_date_ = $coupon['gift_end_date'];
            $gift_start_date = str_replace("-","",$gift_start_date_);
            $gift_end_date = str_replace("-","",$gift_end_date_);

            $couponCheck = $this->qb
                ->select('')
                ->from(TBL_SHOP_GIFT_CERTIFICATE)
                ->betweenDate(date('Ymd'),$gift_start_date,$gift_end_date)
                ->where('gc_ix',$gc_ix)
                ->getCount();

            if($couponCheck > 0){
                //한 프로모션에 2개이상 쿠폰 발급 안되도록 X
                $userCheck = $this->qb
                    ->select('')
                    ->from(TBL_SHOP_GIFT_CERTIFICATE_DETAIL)
                    ->where('gc_ix',$gc_ix)
                    ->where('member_id',$this->userInfo->id)
                    ->getCount();

                if($userCheck == 0){
                    if($gift_type == 'R'){
                        /* @var $mileageModel CustomMallMileageModel */
                        $mileageModel = $this->import('model.mall.mileage');
                        $etc = "쿠폰수동등록[".$couponNum."]으로 인한 적립";
                        $mileageModel->addMileage($gift_amount, 7, $etc);

                        $this->qb
                            ->update(TBL_SHOP_GIFT_CERTIFICATE_DETAIL)
                            ->set('gift_change_state',1)
                            ->set('member_id',$this->userInfo->id)
                            ->set('member_ip',$_SERVER['REMOTE_ADDR'])
                            ->set('use_date',date('Y-m-d H:i:s'))
                            ->where('gcd_ix',$gcd_ix)->exec();

                        $returnStatus = "success";
                        return $returnStatus;
                    }else if($gift_type == "C" || $gift_type == "U"){
                        $cupon_info = $this->qb
                            ->select('gift_cupon_ix')
                            ->from(TBL_SHOP_GIFT_CERTIFICATE_CUPON)
                            ->where('gc_ix',$gc_ix)
                            ->exec()->getResultArray();

                        if(is_array($cupon_info) && count($cupon_info) > 0){
                            /* @var $couponModel CustomMallCouponModel */
                            $couponModel = $this->import('model.mall.coupon');
                            foreach($cupon_info as $key=>$val){
                                //$couponModel->giveCoupon($val['gift_cupon_ix']);
                                $couponModel->giveCouponTri($val['gift_cupon_ix']);
                            }

                            if($gift_type == "C"){
                                $this->qb
                                    ->update(TBL_SHOP_GIFT_CERTIFICATE_DETAIL)
                                    ->set('gift_change_state',1)
                                    ->set('member_id',$this->userInfo->id)
                                    ->set('member_ip',$_SERVER['REMOTE_ADDR'])
                                    ->set('use_date',date('Y-m-d H:i:s'))
                                    ->where('gcd_ix',$gcd_ix)->exec();

                            }
                            $returnStatus = "success";
                            return $returnStatus;
                        }else{
                            $returnStatus = "fail";
                            return $returnStatus;
                        }
                    }else{
                        $returnStatus = "fail";
                        return $returnStatus;
                    }
                }else{
                    $returnStatus = "failOverlap";
                    return $returnStatus;
                }
            }else{
                $returnStatus = "failOverDay";
                return $returnStatus;
            }

        }else{
            //무제한 쿠폰 상품권

            $count = $this->qb
                ->select('gc_ix')
                ->select('gift_prefix_code')
                ->select('gift_start_date')
                ->select('gift_end_date')
                ->from(TBL_SHOP_GIFT_CERTIFICATE)
                ->where('gift_prefix_code',$couponNum)
                ->where('gift_type','U')
                ->exec()->getRowArray();

            if(!empty($count)){
                $gc_ix = $count['gc_ix'];
                $gift_prefix_code = $count['gift_prefix_code'];
                $gift_start_date_ = $count['gift_start_date'];
                $gift_end_date_ = $count['gift_end_date'];
                $gift_start_date = str_replace("-","",$gift_start_date_);
                $gift_end_date = str_replace("-","",$gift_end_date_);

                $couponCheck = $this->qb
                    ->select('')
                    ->from(TBL_SHOP_GIFT_CERTIFICATE)
                    ->betweenDate(date('Ymd'),$gift_start_date,$gift_end_date)
                    ->where('gc_ix',$gc_ix)
                    ->getCount();

                if($couponCheck > 0){
                    $userCheck = $this->qb
                        ->select('')
                        ->from(TBL_SHOP_GIFT_CERTIFICATE_DETAIL)
                        ->where('gc_ix',$gc_ix)
                        ->where('member_id',$this->userInfo->id)
                        ->getCount();

                    if($userCheck == 0){
                        $cupon_info = $this->qb
                            ->select('gift_cupon_ix')
                            ->from(TBL_SHOP_GIFT_CERTIFICATE_CUPON)
                            ->where('gc_ix',$gc_ix)
                            ->exec()->getResultArray();

                        if(is_array($cupon_info) && count($cupon_info) > 0){
                            /* @var $couponModel CustomMallCouponModel */
                            $couponModel = $this->import('model.mall.coupon');
                            foreach($cupon_info as $key=>$val){
                                $couponModel->giveCoupon($val['gift_cupon_ix']);
                            }

                            $this->qb
                                ->insert(TBL_SHOP_GIFT_CERTIFICATE_DETAIL)
                                ->set('gc_ix',$gc_ix)
                                ->set('gift_code',$gift_prefix_code)
                                ->set('gift_change_state',1)
                                ->set('member_id',$this->userInfo->id)
                                ->set('member_ip',$_SERVER['REMOTE_ADDR'])
                                ->set('use_date',date('Y-m-d H:i:s'))
                                ->exec();

                            $returnStatus = "success";
                            return $returnStatus;
                        }else{
                            $returnStatus = "fail";
                            return $returnStatus;
                        }
                    }else{
                        $returnStatus = "failOverlap";
                        return $returnStatus;
                    }
                }else{
                    $returnStatus = "failOverDay";
                    return $returnStatus;
                }
            }else{
                $returnStatus = "fail";
                return $returnStatus;
            }
        }
    }



    /**
     * 주문취소 신청 완료
     * @param type $userCode
     * @param type $orderId
     * @return type
     */
    /*
    public function doOrderCancelComplete($userCode, $orderId, $od_ix, $status)
    {

        $this->qb
            ->select('od.oid')
            ->select('od.status')
            ->select('od.option_text')
            ->select('od.pcnt')
            ->select('od.pt_dcprice')
            ->select("date_format(o.order_date, '%Y-%m-%d') order_date", false)
            ->select('o.delivery_price')
            ->select('o.bname')
            ->select('o.bmail')
            ->select('o.bmobile')
            ->select('o.order_date bdatetime')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL .' as od','o.oid=od.oid','left')
            ->where('o.user_code',$userCode)
            ->where('o.oid',$orderId)
            ->whereIn('od.status', $status);
        $data = $this->qb->exec()->getResultArray();

        $result['order']['orderDetail'] = $data;

        return $result;
    }
    */

    /**
     * 주문 클레임 상세 정보 조회
     * @param type $userCode
     * @param type $orderId
     * @param type $claimGroup
     * @return type
     */
    public function doOrderClaimDetail($userCode, $orderId, $claimGroup)
    {

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        // 주문정보 조회
        $orderInfo = $orderModel->getOrderInfo($userCode, $orderId, [], ['claim_group'=>$claimGroup]);

        if (!empty($orderInfo)) {

            $claimType = ''; // I:입금전 취소, C:취소, R:반품, E:교환
            $randOdIx = '';
            $totalProductPrice = 0;

            if (is_array($orderInfo['orderDetail'])) {
                foreach ($orderInfo['orderDetail'] as $orderDetails) {
                    if (is_array($orderDetails)) {
                        foreach ($orderDetails as $orderDetail) {
                            $claimType = substr($orderDetail['status'], 0, 1);
                            $randOdIx = $orderDetail['od_ix'];
                            $totalProductPrice += $orderDetail['pt_dcprice'];
                        }
                    }
                }
            }

            //사유
            $reason = $orderModel->getOrderCalimReason($orderInfo['oid'], $randOdIx, $claimType);


            //환불 내역
            $expectedRefund = false;
            $reserve    = 0;
            $cartCoupon = 0;
            if ($claimType != 'I') {

                $returnBankBool = false;
                $paymentInfo['paymentInfo'] = $orderModel->getPaymentInfo($orderInfo['oid']);
                foreach ($paymentInfo['paymentInfo'] as $key => $val) {
                    if ($val['method'] == ORDER_METHOD_RESERVE) {
                        $reserve = $val['payment_price'];
                        unset($paymentInfo['paymentInfo'][$key]);
                    } else if ($val['method'] == ORDER_METHOD_VBANK || $val['method'] == ORDER_METHOD_ASCROW) {
                        $returnBankBool = true;
                    } else if ($val['method'] == ORDER_METHOD_ICHE) {
                        $returnBankBool = true;
                    } else if ($val['method'] == ORDER_METHOD_CART_COUPON) {
                        $cartCoupon = $val['payment_price'];
                    }
                }

                $paymentInfo['dr_dc'] = 0;
                $paymentInfo['cp_dc'] = 0;
                $paymentInfo['dcp_dc'] = 0;
                $paymentInfo['mg_dc'] = 0;
                $paymentInfo['gp_dc'] = 0;
                $paymentInfo['use_reserve'] = $reserve;
                $paymentInfo['use_cart_coupon'] = $cartCoupon;
                $paymentInfo['total_dc'] = 0;
                $paymentInfo['total_reserve'] = 0;
                $paymentInfo['total_listprice'] = 0;
                $paymentInfo['pt_dcprice'] = 0;
                $paymentInfo['total_pcnt'] = 0;

                if (!empty($orderInfo['orderDetail'])) {
                    foreach ($orderInfo['orderDetail'] as $deliveryOrder) {
                        foreach ($deliveryOrder as $oitem) {
                            $paymentInfo['dr_dc']           += ($oitem['dr_dc'] + $oitem['gp_dc'] + $oitem['sp_dc']); // 즉시할인에 회원할인 더함
                            $paymentInfo['mg_dc']           += $oitem['mg_dc'];
                            $paymentInfo['cp_dc']           += $oitem['cp_dc'];
                            $paymentInfo['dcp_dc']           += $oitem['dcp_dc'];
                            $paymentInfo['total_dc']        += $oitem['total_dc'];
                            $paymentInfo['total_reserve']   += $oitem['reserve'];
                            $paymentInfo['total_listprice'] += $oitem['pt_listprice'];
                            $paymentInfo['pt_dcprice']      += $oitem['pt_dcprice'];
                            $paymentInfo['total_pcnt']      += $oitem['pcnt'];
                        }
                    }
                }

                $refundBankName = '';
                $refundBankOwner = '';
                $refundBankNumber = '';
                if ($returnBankBool) {
                    // 회원인가?
                    if (!empty($userCode)) {
                        // 환불계좌 조회

                        /* @var $memberModel CustomMallMemberModel */
                        $memberModel = $this->import('model.mall.member');
                        $refundInfo = $memberModel->getRefundAccount($userCode, true);
                        if (!empty($refundInfo)) {
                            $refundBankName = $refundInfo['bank_name'];
                            $refundBankOwner = $refundInfo['bank_owner'];
                            $refundBankNumber = $refundInfo['bank_number'];
                        }
                    }

                    // 환불계좌 정보가 없는가?
                    if (empty($refundBankNumber)) {
                        $refundInfo = $orderModel->getClaimRefundAccount($orderInfo['oid']);
                        $refundBankName = $refundInfo['bankName'];
                        $refundBankOwner = $refundInfo['bankOwner'];
                        $refundBankNumber = $refundInfo['bankNumber'];
                    }
                }

                // 클레임 배송비 조회
                $claimDeliveryPrice = $orderModel->getOrderClaimDelivery($orderInfo['oid'], $claimGroup);

                $addPaymentPrice = 0;
                $deliveryPrice = 0;

                $orderPrice = $totalProductPrice ;
                if ($claimDeliveryPrice < 0) {
                    if ($claimType == 'E') {
                        $addPaymentPrice = $claimDeliveryPrice * -1;
                    } else {
                        $addPaymentPrice = ($totalProductPrice + $claimDeliveryPrice < 0 ? ($totalProductPrice + $claimDeliveryPrice) * -1 : 0);
                    }
                    $expectedRefundPrice = $orderPrice + $claimDeliveryPrice - $paymentInfo['dcp_dc'];
                    if ($expectedRefundPrice < 0) {
                        $expectedRefundPrice = 0;
                    }
                    $claimDeliveryPrice = $claimDeliveryPrice * -1;
                } else {
                    $deliveryPrice = $claimDeliveryPrice;
                    $orderPrice += $deliveryPrice;
                    $expectedRefundPrice = $orderPrice;
                    $claimDeliveryPrice = 0;
                }

                $expectedRefund = [
                    'paymentInfo' => $paymentInfo
                    ,'productPrice' => $totalProductPrice //상품금액
                    , 'deliveryPrice' => $deliveryPrice //배송비 금액
                    , 'orderPrice' => $orderPrice //신청 총 결제 금액
                    , 'claimDeliveryPrice' => $claimDeliveryPrice // 반품 배송비
                    , 'expectedRefundPrice' => $expectedRefundPrice //환불 예정금액
                    , 'addPaymentPrice' => $addPaymentPrice // 추가 결제 예정금액
                    , 'returnBankBool' => $returnBankBool
                    , 'refundBankName' => $refundBankName
                    , 'refundBankOwner' => $refundBankOwner
                    , 'refundBankNumber' => $refundBankNumber
                ];
            }

            //반품 내역
            $returnMethod = false;
            if (in_array($claimType, ['R', 'E'])) {
                $returnMethod['returnData'] = $orderModel->getClaimDeliveryinfo($orderInfo['oid'], $randOdIx);
                if($claimType == 'E'){
                    $exchangeProduct = $orderModel->getExchangeDetail($orderInfo['oid'], $randOdIx);
                    $returnMethod['reDeliveryData'] = $orderModel->getClaimDeliveryinfo($orderInfo['oid'], ($exchangeProduct[0]['od_ix'] ?? ''));
                }
            }

            //거부/불가 내역
            $deny = false;
            if (in_array($claimType, ['R', 'E'])) {
                $deny = $orderModel->getClaimDenyList($orderInfo['oid'], $claimGroup);
            }

            if ($claimType == 'R') {
                $claimTypeName = '반품';
            } else if ($claimType == 'E') {
                $claimTypeName = '교환';
            } else {
                $claimTypeName = '취소';
            }

            return [
                'claimType' => $claimType
                ,'claimTypeName' => $claimTypeName
                ,'order' => $orderInfo
                ,'reason' => $reason
                ,'expectedRefund' => $expectedRefund
                ,'returnMethod' => $returnMethod
                ,'deny' => $deny
            ];
        }
    }

    /**
     * 주문 교환/반품 신청
     * @param string $userCode
     * @param string $claimType
     * @param string $orderId
     * @param int $od_ix
     * @return array
     */
    public function doOrderClaimApply($userCode, $claimType, $orderId, $od_ix)
    {

        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        //취소/교환/반품 신청은 동일한 배송정책끼리만 가능함
        $details = $this->qb
            ->select('od.ode_ix')
            ->select('od.claim_delivery_od_ix')
            ->from(TBL_SHOP_ORDER_DETAIL.' AS od')
            ->join(TBL_SHOP_ORDER.' AS o', 'o.oid = od.oid')
            ->where('od.od_ix', $od_ix)
            ->where('o.user_code', $userCode)
            ->exec()
            ->getRowArray();

        if (!empty($details)) {
            $odeIx    = $details['ode_ix'];
            $exchange = $details['claim_delivery_od_ix'];

            $ret = $this->doOrderDetail($userCode, $orderId, true, [], ['status' => [ORDER_STATUS_DELIVERY_COMPLETE], 'ode_ix' => $odeIx], $exchange);

            if ($claimType == 'return') {
                // 반품 사유
                $ret['claimReason'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_RETURN_APPLY);
            } else {
                // 교환 사유
                $ret['claimReason'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_EXCHANGE_APPLY);
            }

            // 해당 상태 주문 상세 수
            $orderList = $this->qb->select('count(*) as cnt')
                ->from(TBL_SHOP_ORDER_DETAIL.' AS od')
                ->where('od.oid', $orderId)
                ->where('od.status', $ret['order']['status'])
                ->exec()
                ->getRow();

            $ret['orderDetailCnt'] = $orderList->cnt;
            // 환불계좌 정보
            $ret['refundInfo']      = $memberModel->getRefundAccount($userCode, true);
            $ret['claimOdIx']       = $od_ix;
            // 배송업체 정보
            $ret['deliveryCompany'] = ForbizConfig::getDeliveryCompanyInfo();

            return $ret;
        } else {
            return [];
        }
    }

    /**
     * 주문취소 신청
     * @param type $userCode
     * @param type $orderId
     * @return type
     */
    public function doOrderCancel($userCode, $orderId, $od_ix, $status)
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        //취소/교환/반품 신청은 동일한 배송정책끼리만 가능함
        $details = $this->qb->select('ode_ix')->from(TBL_SHOP_ORDER_DETAIL)->where('od_ix', $od_ix)->exec()->getRow(0, 'array');
        $odeIx   = $details['ode_ix'];

        $ret                 = $this->doOrderDetail($userCode, $orderId, false, [], ['status' => [ORDER_STATUS_INCOM_READY, ORDER_STATUS_INCOM_COMPLETE], 'ode_ix' => $odeIx]);

        // 해당 상태 주문 상세 수
        $orderList = $this->qb->select('count(*) as cnt')
            ->from(TBL_SHOP_ORDER_DETAIL.' AS od')
            ->where('od.oid', $orderId)
            ->where('od.status', $ret['order']['status'])
            ->exec()
            ->getRow();

        $ret['orderDetailCnt'] = $orderList->cnt;

        // 취소 사유
        $ret['cancelReason'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], $status);
        // 환불계좌 정보
        $ret['refundInfo']   = $memberModel->getRefundAccount($userCode, true);
        $ret['cancelOdIx']   = $od_ix;

        return $ret;
    }

    /**
     * 주문 상세 조회 + 클레임 조회 (통합출력용)
     * @param type $userCode
     * @param type $orderId
     * @param type $orderDetail
     * @return type
     */
    public function getDtailClaimMerged($userCode, $orderId, $orderDetail = [])
    {
        /* @var $mypageModel CustomMallMypageModel */
        $mypageModel = $this->import('model.mall.mypage');

        $cancelData = [];
        $returnData = [];

        $calimGroupList = [];
        foreach ($orderDetail as $productList) {
            foreach ($productList as $product) {
                if (!in_array($product['claim_group'], $calimGroupList)) {
                    $calimGroupList[] = $product['claim_group'];
                }
            }
        }

        foreach ($calimGroupList as $calimGroup) {

            $cancelBool = false; //취소
            $returnBool = false; //반품
            $data = [];
            $claimData = $mypageModel->doOrderClaimDetail($userCode, $orderId, $calimGroup);

            foreach ($claimData['order']['orderDetail'] as $value) {
                foreach ($value as $key => $val) {
                    if ($val['refund_status'] == 'FC') {
                        if ($val['status'] == 'RC' || $val['status'] == 'CC') {
                            $data['productList'][$val['pid']] = [
                                'brand_name' => $val['brand_name'],
                                'pname' => $val['pname']
                            ];

                            $data['refundDate'] = $val['fc_date'];
                            if ($val['status'] == 'RC') {
                                $returnBool = true;
                            } else {
                                $cancelBool = true;
                            }

                        }
                    }
                }
            }

            $data['totReturnPrice'] = $claimData['expectedRefund']['expectedRefundPrice'];

            if ($cancelBool == true) {
                $cancelData[] = $data;
            } else if ($returnBool == true) {
                $returnData[] = $data;
            }

        }

        $mergedCancel = false;
        $mergedReturn = false;

        if(!empty($cancelData)) {
            $productList = [];
            $amount = 0;
            $date = "";
            foreach ($cancelData as $p => $v) {
                $productList = array_merge($productList, $v['productList']);
                $amount += $v['totReturnPrice'];
                if (date($date) < date($v['refundDate'])) {
                    $date = $v['refundDate'];
                }
            }
            $mergedCancel['0']['productList'] = $productList;
            $mergedCancel['0']['totReturnPrice'] = $amount;
            $mergedCancel['0']['refundDate'] = $date;
        }

        if(!empty($returnData)) {
            $productList = [];
            $amount = 0;
            $date = "";
            foreach ($returnData as $p => $v) {
                $productList = array_merge($productList, $v['productList']);
                $amount += $v['totReturnPrice'];
                if (date($date) < date($v['refundDate'])) {
                    $date = $v['refundDate'];
                }
            }
            $mergedReturn['0']['productList'] = $productList;
            $mergedReturn['0']['totReturnPrice'] = $amount;
            $mergedReturn['0']['refundDate'] = $date;
        }

        return [
            'cancelData' => $mergedCancel,
            'returnData' => $mergedReturn
        ];
    }

    /**
     * 푸시 마켓팅 동의 업데이트
     * @param string $device_id, string $is_allowable (1,0)
     * @return mixed
     */
    public function modifyPushAllowable($device_id, $is_allowable)
    {
        $this->qb
            ->set('is_allowable', $is_allowable)
            ->update(TBL_MOBILE_PUSH_SERVICE)
            ->where('device_id',$device_id);

        return $this->qb->exec();
    }


    /**
     * 1:1문의 하기 분류 선택 시 안내 문구 가져오기
     */
    public function getBbsInfoText($bbsDiv){
        $data = $this->qb
                    ->select('div_info_text')
                    ->from(TBL_BBS_MANAGE_DIV)
                    ->where('div_ix',$bbsDiv)
                    ->exec()->getRowArray();

        return $data['div_info_text'];
    }

    public function getMileageList($curPage, $table, $state, $sDate, $eDate, $perPage)
    {

        $this->qb->startCache();
        $this->qb->select("*");
        $this->qb->where("uid", $this->user_code);
        if ($table == 'add') {
            $this->qb->from("shop_".$table."_mileage")
                ->select("am_state as state")
                ->select("state_desc as '적립'")
                ->select("state_desc2 as 'plus'")
                ->select("format(am_mileage,0) as mileage", false)
                ->select("concat('+', format(um_mileage,0)) as mileage_desc", false);
            if (intval($state) > 0) {
                $this->qb->where("am_state", $state);
            }
        } else if ($table == 'use') {
            $this->qb->from("shop_".$table."_mileage")
                ->select("um_state as state")
                ->select("state_desc as '사용'")
                ->select("state_desc2 as 'minus'")
                ->select("format(um_mileage,0) as mileage")
                ->select("concat('-', format(um_mileage,0)) as mileage_desc");
            if (intval($state) > 0) {
                $this->qb->where("um_state", $state);
            }
        } else {
            $this->qb->from("shop_mileage_log")
                ->select("ml_state as state")
                ->select("CASE WHEN ml_state = 1 THEN '적립' WHEN ml_state = 2 THEN '사용' ELSE '적립취소' END AS state_desc")
                ->select("CASE WHEN ml_state = 1 THEN 'plus' WHEN ml_state = 2 THEN 'minus' ELSE 'cancle' END AS state_desc2")
                ->select("CASE WHEN ml_state = 2 THEN concat('-',format(ml_mileage,0)) ELSE concat('+',format(ml_mileage,0)) END AS mileage_desc")
                ->select("format(ml_mileage,0) as mileage");
            if (intval($state) > 0) {
                $this->qb->where("ml_state", $state);
            }
        }
        if ($sDate != "") {
            $this->qb->where("date_format(regdate,'%Y-%m-%d') >= ", $sDate);
        }
        if ($eDate != "") {
            $this->qb->where("date_format(regdate,'%Y-%m-%d') <= ", $eDate);
        }

        $this->qb->stopCache();

        $total  = $this->qb->limit(1)->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage);
        $limit  = $perPage;
        $offset = $paging['offset'];

        if ($table == 'add') {
            $this->qb->orderBy("am_ix", "DESC");
        } else if ($table == 'use') {
            $this->qb->orderBy("um_ix", "DESC");
        } else {
            $this->qb->orderBy("ml_ix", "DESC");
        }

        $list = $this->qb->limit($limit, $offset)->exec()
            ->getResultArray();

        $this->qb->flushCache();

        foreach($list as $key => $val) {
            $list[$key]['state_desc'] = trans($list[$key]['state_desc']);
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    public function getOrderIdByCode($orderId){
        //회원코드가 누락된 상태로 진입 되었을때 주문번호를 기준으로 회원코드 획득 처리
        $userCode = "";

        $orderData = $this->qb
            ->select('user_code')
            ->from(TBL_SHOP_ORDER)
            ->where('oid',$orderId)
            ->exec()->getRowArray();

        if(!empty($orderData['user_code'])){
            $userCode = $orderData['user_code'];
        }

        return $userCode;
    }
}