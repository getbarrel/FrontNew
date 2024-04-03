<?php

/**
 * Description of FobizMallMypageModel
 *
 * @author hoksi
 */
class ForbizMallMypageModel extends ForbizModel
{
    protected $user_code = "";

    public function __construct()
    {
        parent::__construct();

        $this->user_code = sess_val('user', 'code');
    }

    /**
     * 회원 프로필 정보
     *
     * @param string $userCode
     * @return array
     */
    public function doProfile()
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        // Member profile data
        $data = $memberModel->getMemberProfile($this->user_code);

        // 사업자 회원인지 확인
        if ($data['mem_type'] == 'C' && $data['company_id'] != '') {
            // Company profile data
            $com_data = $memberModel->getCompanyProfile($data['company_id']);
            if (!empty($com_data)) {
                foreach ($com_data as $key => $val) {
                    $data[$key] = $val;
                }
            }
        }

        /* @var $companyModel CustomMallCompanyModel */
        $companyModel = $this->import('model.mall.company');

        // 선택 동의 항목
        $data['policyData'] = $companyModel->getPolicy('marketing');

        return $data;
    }

    /**
     * 회원 탈퇴 사유
     * @param string $witdrawCode
     * @return array
     */
    public function doSecede($withdrawCode)
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        return [
            'reason' => $memberModel->getDropMemberReasen(),
            'withdrawCode' => $withdrawCode
        ];
    }

    /**
     * 홰원 적립금 정보
     * @return array
     */
    public function getMyMileageInfo()
    {
        $result['myMileAmount']    = $this->getExchangeFormat($this->getReserveValue()); //현재 나의 마일리지
        $result['myMileageWaitAmount'] = $this->getExchangeFormat($this->getReserveWaitValue()); //현재 나의 적립 예정 마일리지
        $result['availMileAmount'] = $this->getExchangeFormat($this->getStateReserve('1', 'mileage')); //적립된 총 마일리지
        $result['usedMileAmount']  = $this->getExchangeFormat($this->getStateReserve('2', 'mileage')); //사용된 총 마일리지
        //$result['totalMileAmount'] = $this->getExchangeFormat(intval($this->getStateReserve('0', 'mileage')) + intval($this->getStateReserve('1', 'mileage')));
        return $result;
    }

    /**
     * 회원등급 조회
     * @return array
     */
    public function getMyGrade()
    {

        $result = $this->qb
            ->setDatabase($this->slave_db)
            ->select("sg.gp_name")
            ->from(TBL_COMMON_MEMBER_DETAIL." AS cmd")
            ->join(TBL_SHOP_GROUPINFO." AS sg", " cmd.gp_ix = sg.gp_ix", 'left')
            ->where("cmd.code", $this->user_code)
            ->exec()
            ->getResultArray();

        return $result;
    }

    /**
     * 마일리지 금액 조회
     * @param string $return_type
     * @param string $reserve_type
     * @return int
     */
    public function getReserveValue($return_type = "", $reserve_type = "mileage")
    {

        if ($reserve_type == "point") {
            $this->qb->select("point as amount");
        } else {
            $this->qb->select("mileage as amount");
        }

        $result = $this->qb->from(TBL_COMMON_USER)
            ->where("code", $this->user_code)
            ->limit("1")
            ->exec()
            ->getRow(1, 'array');

        return $result['amount'];
    }

    /**
     * 마일리지 상태별 총액 조회
     * @param string $state
     * @param string $reserve_type
     * @return int
     */
    public function getStateReserve($state, $reserve_type = "mileage")
    {

        if ($reserve_type == "point") {
            $table_add = 'shop_use_point';
            $table_use = 'shop_add_point';
        } else {
            $table_add = 'shop_add_mileage';
            $table_use = 'shop_use_mileage';
        }

        if ($state == '1') {
            $this->qb->selectSum("am_mileage", "reserve")
                ->from($table_add)
                ->where("am_state", 1);
        } else {
            $this->qb->selectSum("um_mileage", "reserve")
                ->from($table_use)
                ->where("um_state", 1);
        }

        $result = $this->qb->where("uid", $this->user_code)
            ->exec()
            ->getRow(0, 'array');

        return $result['reserve'];
    }

    /**
     * getExchangeFormat
     * @param int $price
     * @return string
     */
    public function getExchangeFormat($price)
    {
        if (sess_val("layout_config", "front_language") == "english") {
            $return_price = number_format($price, 2);
        } else {
            $return_price = number_format($price);
        }
        return $return_price;
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

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    public function getQnaCounts()
    {

        $memIx  = $this->user_code;
        $result = $this->qb->select("(select count(*) from bbs_qna where mem_ix = '$memIx' ) as qna_total")
            ->select("(select count(*) from bbs_qna where mem_ix = '$memIx' and `status` = '1') as qna_ing")
            ->select("(select count(*) from bbs_qna where mem_ix = '$memIx' and `status` = '5') as qna_complete")
            ->limit('1')
            ->exec()
            ->getRow(0);

        return $result;
    }

    public function getMyGoodsInquiryList()
    {
        
    }

    /**
     * Mypage main data
     * @param string $userCode
     * @return array
     */
    public function doDashBoard($userCode)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');
        /* @var $wishModel CustomMallWishModel */
        $wishModel = $this->import('model.mall.wish');
        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');

        $status = $orderModel->getStatusCount($this->userInfo->code, [
            ORDER_STATUS_INCOM_READY
            , ORDER_STATUS_INCOM_COMPLETE
            , ORDER_STATUS_DELIVERY_READY
            , ORDER_STATUS_DELIVERY_ING
            , ORDER_STATUS_DELIVERY_COMPLETE
            // 주문취소
            , ORDER_STATUS_CANCEL_APPLY
            , ORDER_STATUS_CANCEL_COMPLETE
            , ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE
            // 교환신청
            , ORDER_STATUS_EXCHANGE_APPLY
            , ORDER_STATUS_EXCHANGE_DENY
            , ORDER_STATUS_EXCHANGE_ING
            , ORDER_STATUS_EXCHANGE_DELIVERY
            , ORDER_STATUS_EXCHANGE_ACCEPT
            , ORDER_STATUS_EXCHANGE_DEFER
            , ORDER_STATUS_EXCHANGE_IMPOSSIBLE
            , ORDER_STATUS_EXCHANGE_COMPLETE
            // 반품신청
            , ORDER_STATUS_RETURN_APPLY
            , ORDER_STATUS_RETURN_DENY
            , ORDER_STATUS_RETURN_ING
            , ORDER_STATUS_RETURN_DELIVERY
            , ORDER_STATUS_RETURN_ACCEPT
            , ORDER_STATUS_RETURN_DEFER
            , ORDER_STATUS_RETURN_IMPOSSIBLE
            , ORDER_STATUS_RETURN_COMPLETE
        ]);

        // 주문취소, 주문취소(환불신청), 주문취소(환불완료) 합산
        $cancel_apply_cnt = ($status[ORDER_STATUS_CANCEL_APPLY] ?? 0) + ($status[ORDER_STATUS_CANCEL_COMPLETE] ?? 0) + ($status[ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE] ?? 0);
        // 교환요청, 교환거부, 교환승인, 교환상품배송중, 교환회수완료, 교환보루, 교환불가, 교환반품확정
        $exchange_apply_cnt = ($status[ORDER_STATUS_EXCHANGE_APPLY] ?? 0) + ($status[ORDER_STATUS_EXCHANGE_DENY] ?? 0)
            + ($status[ORDER_STATUS_EXCHANGE_ING] ?? 0) + ($status[ORDER_STATUS_EXCHANGE_DELIVERY] ?? 0)
            + ($status[ORDER_STATUS_EXCHANGE_ACCEPT] ?? 0) + ($status[ORDER_STATUS_EXCHANGE_DEFER] ?? 0)
            + ($status[ORDER_STATUS_EXCHANGE_IMPOSSIBLE] ?? 0) + ($status[ORDER_STATUS_EXCHANGE_COMPLETE] ?? 0);
        // 반품요청, 반품거부, 반품승인, 반품상품배송중, 반품회수완료, 반품보류, 반품불가, 반품확정(환불신청), 반품확정(환불완료) 합산
        $return_apply_cnt = ($status[ORDER_STATUS_RETURN_APPLY] ?? 0) + ($status[ORDER_STATUS_RETURN_DENY] ?? 0)
            + ($status[ORDER_STATUS_RETURN_ING] ?? 0) + ($status[ORDER_STATUS_RETURN_DELIVERY] ?? 0)
            + ($status[ORDER_STATUS_RETURN_ACCEPT] ?? 0) + ($status[ORDER_STATUS_RETURN_DEFER] ?? 0)
            + ($status[ORDER_STATUS_RETURN_IMPOSSIBLE] ?? 0) + ($status[ORDER_STATUS_RETURN_COMPLETE] ?? 0);

        return [
            'incom_ready_cnt' => ($status[ORDER_STATUS_INCOM_READY] ?? 0) // 입금예정
            , 'incom_end_cnt' => ($status[ORDER_STATUS_INCOM_COMPLETE] ?? 0) // 입금완료
            , 'delivery_ready_cnt' => ($status[ORDER_STATUS_DELIVERY_READY] ?? 0) // 배송준비중
            , 'delivery_ing_cnt' => ($status[ORDER_STATUS_DELIVERY_ING] ?? 0) // 배송중
            , 'delivery_end_cnt' => ($status[ORDER_STATUS_DELIVERY_COMPLETE] ?? 0) // 배송완료
            , 'cancel_apply_cnt' => $cancel_apply_cnt // 주문취소
            , 'exchange_apply_cnt' => $exchange_apply_cnt // 교환신청
            , 'return_apply_cnt' => $return_apply_cnt // 반품신청
            , 'order_data' => $orderModel->getLatestOrder($userCode) // 최근주문내역
            , 'order_summerydata' => $orderModel->getLatestOrderSummery($userCode) // 최근주문내역통합본
            , 'historyList' => $productModel->getProductViewHistory($userCode, 1, 5)['list']
            , 'wishList' => $wishModel->getWishlist($userCode, 1, 5)['list']
            , 'cartList' => $cartModel->getCartProductList($userCode, 1, 4)['list']
        ];
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

            // 마일리지
            $reserve    = 0;
            $cartCoupon = 0;
            foreach ($orderPaymentInfo as $key => $val) {
                if ($val['method'] == ORDER_METHOD_RESERVE) {
                    $reserve = $val['payment_price'];
                    unset($orderPaymentInfo[$key]);
                }
            }

            // 결제 정보
            $paymentInfo = [
                'dr_dc' => 0,
                'cp_dc' => 0,
                'mg_dc' => 0,
                'gp_dc' => 0,
                'use_reserve' => $reserve,
                'total_dc' => 0,
                'total_reserve' => 0,
                'total_listprice' => 0,
                'pt_dcprice' => 0,
                'total_pcnt' => 0,
                'payment' => $orderPaymentInfo
            ];


            if (!empty($orderInfo['orderDetail'])) {
                foreach ($orderInfo['orderDetail'] as $deliveryOrder) {
                    foreach ($deliveryOrder as $oitem) {
                        $paymentInfo['dr_dc']         += $oitem['dr_dc'];
                        $paymentInfo['cp_dc']         += $oitem['cp_dc'];
                        $paymentInfo['mg_dc']         += $oitem['mg_dc'];
                        $paymentInfo['gp_dc']         += $oitem['gp_dc'];
                        $paymentInfo['total_dc']      += $oitem['total_dc'];
                        $paymentInfo['total_reserve'] += $oitem['reserve'];
                        $paymentInfo['total_listprice']     += $oitem['listprice'] * $oitem['pcnt'];
                        $paymentInfo['pt_dcprice']    += $oitem['pt_dcprice'];
                        $paymentInfo['total_pcnt']    += $oitem['pcnt'];
                    }
                }
            }

            //주문상세 클레임 정보 가져오기
            $claimData = [];
            if (!empty($orderInfo['orderDetail'])) {
                $claimData = $this->getDtailClaim($userCode, $orderId ,$orderInfo['orderDetail']);
            }

            return [
                'order' => $orderInfo,
                'paymentInfo' => $paymentInfo,
                'deliveryInfo' => ($useDeliveryInfo ? $orderModel->getDeliveryInfo($orderId) : false),
                'claimData' => ($claimData ? $claimData : [])
            ];
        }
    }
    
    /**
     * 주문 상세 조회 + 클레임 조회
     * @param type $userCode
     * @param type $orderId
     * @param type $orderDetail
     * @return type
     */
    protected function getDtailClaim($userCode, $orderId, $orderDetail = [])
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
                            $data['productList'][] = [
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
        return [
            'cancelData' => (!empty($cancelData) ? $cancelData : false),
            'returnData' => (!empty($returnData) ? $returnData : false)
        ];
    }

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
            if ($claimType != 'I') {
                
                $returnBankBool = false;
                $paymentInfo = $orderModel->getPaymentInfo($orderInfo['oid']);
                foreach ($paymentInfo as $key => $val) {
                    if ($val['method'] == ORDER_METHOD_RESERVE) {
                        unset($paymentInfo[$key]);
                    } else if ($val['method'] == ORDER_METHOD_VBANK) {
                        $returnBankBool = true;
                    } else if ($val['method'] == ORDER_METHOD_ICHE) {
                        $returnBankBool = true;
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
                
                $orderPrice = $totalProductPrice;
                if ($claimDeliveryPrice < 0) {
                    if ($claimType == 'E') {
                        $addPaymentPrice = $claimDeliveryPrice * -1;
                    } else {
                        $addPaymentPrice = ($totalProductPrice + $claimDeliveryPrice < 0 ? ($totalProductPrice + $claimDeliveryPrice) * -1 : 0);
                    }
                    $expectedRefundPrice = $orderPrice + $claimDeliveryPrice;
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
     * 결제영수증 출력
     * @param string $userCode
     * @param string $orderId
     * @return array
     */
    public function doReceiptPrint($userCode, $orderId)
    {
        return $this->doOrderDetail($userCode, $orderId, false);
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

        $ret                 = $this->doOrderDetail($userCode, $orderId, false, [],
            ['status' => [ORDER_STATUS_INCOM_READY, ORDER_STATUS_INCOM_COMPLETE], 'ode_ix' => $odeIx]);
        // 취소 사유
        $ret['cancelReason'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], $status);
        // 환불계좌 정보
        $ret['refundInfo']   = $memberModel->getRefundAccount($userCode, true);
        $ret['cancelOdIx']   = $od_ix;

        return $ret;
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

        $orderSearch = (isset($applyData['od_ix']) ? ['od_ix' => $applyData['od_ix']] : []);

        //교환으로 신규 생성된 주문인지 확인. 해당 주문건은 동일한 배송정책인 다른 주문 상세건이 있어도 같이 클레임할 수 없도록하였으므로 count로 체크함.
        //해당 관련 따로 요구사항 없었고 다른 정상 주문건과 같은 프로세스를 탈 경우 꼬일 수 있음.
        if (count($applyData['od_ix']) == 1) {
            $details  = $this->qb->select('claim_delivery_od_ix')->from(TBL_SHOP_ORDER_DETAIL)->where('od_ix', $applyData['od_ix'][0])->exec()->getRow(0,
                'array');
            $exchange = $details['claim_delivery_od_ix'];
        } else {
            $exchange = 0;
        }

        $ret = $this->doOrderDetail($userCode, $applyData['oid'], false, $orderSearch, [], $exchange);

        $ret['applyData'] = $applyData;

        if ($claimType == 'return') {
            $ret['applyData']['claimReasonText'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_RETURN_APPLY,
                    $applyData['claim_reason'], 'title');

            // 환불계좌 정보
            $ret['refundInfo'] = $memberModel->getRefundAccount($userCode, true);
        } else {
            $ret['applyData']['claimReasonText'] = ForbizConfig::getOrderSelectStatus('F', $ret['order']['status'], ORDER_STATUS_EXCHANGE_APPLY,
                    $applyData['claim_reason'], 'title');
        }

        if (isset($applyData['quick']) && !empty($applyData['quick'])) {
            $ret['applyData']['quickText'] = ForbizConfig::getDeliveryCompanyInfo($applyData['quick'], 'name');
        }
        $ret['confirmKey'] = md5(time().rand());

        return $ret;
    }

    /**
     * 적립예정 마일리지 가져오기
     * @return mixed
     */
    public function getReserveWaitValue(){
        $this->qb
            ->selectSum('reserve','state_wait')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL .' as od','o.oid=od.oid','left')
            ->where('o.user_code',$this->userInfo->code)
            ->whereIn('od.status', [
                ORDER_STATUS_INCOM_COMPLETE
                , ORDER_STATUS_DELIVERY_READY
                , ORDER_STATUS_DELIVERY_DELAY
                , ORDER_STATUS_DELIVERY_ING
                , ORDER_STATUS_DELIVERY_COMPLETE
            ]);

        $data = $this->qb->exec()->getRow();

        return $data->state_wait;
    }
}