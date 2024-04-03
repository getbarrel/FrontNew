<?php

/**
 * Description of CustomMallCouponModel
 *
 * @author hong
 */
class CustomMallCouponModel extends ForbizMallCouponModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 해당 상품의 보유쿠폰 적용 정보 리스트
     * @param type $pid
     * @param type $unitPrice
     * @param type $paymentPrice
     * @return type
     */
    public function applyProductUserCouponList($pid, $unitPrice, $paymentPrice, $discountCouponUseYn = "X")
    {
        $myCouponList = $this->getUserCouponList(false, 1, 100
            , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type', 'cp.publish_max', 'cp.publish_limit_price', 'cp.discount_use_yn', 'cp.is_except', 'cp.overlap_use_yn', 'cp.payment_method']
            , ['c.cupon_div' => 'G'])['list'];

        foreach ($myCouponList as $key => $coupon) {
            $activeBool = $this->checkProductCouponActive($pid, $unitPrice, $coupon);
            //쿠폰에 기획할인 상품에 쿠폰 적용에 상품에 기획할인 쿠폰 사용여부 사용 을 제외한 모든 케이스에 사용처리 안되도록 추가 조건 처리
            if ($activeBool) {
                if ($discountCouponUseYn == 'N' || ($discountCouponUseYn == 'Y' && $coupon['discount_use_yn'] == 'N')) {
                    $activeBool = false;
                }
            }
            if ($activeBool) {
                $coupon['discount_amount'] = $this->calculationDiscount($paymentPrice, $coupon)['discount_amount'];
                $coupon['total_coupon_with_dcprice'] = f_decimal($paymentPrice) - $coupon['discount_amount'];
            }
            $coupon['activeBool'] = $activeBool;
            $myCouponList[$key] = $coupon;
        }
        return $myCouponList;
    }

    /**
     * 장바구니 보유쿠폰 적용 정보 리스트
     * @param type $price
     * @param type $productList
     * @return type
     */
    public function applyUserCartCouponList($price, $productList)
    {

        $myCouponList = $this->getUserCouponList(false, 1, 100
            , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type',
                'cp.publish_max', 'cp.publish_limit_price', 'cp.publish_min',
                'cp.publish_condition_price', 'cp.discount_use_yn', 'cp.is_except', 'cp.overlap_use_yn', 'cp.payment_method']
            , ['c.cupon_div' => 'C'])['list'];

        if (count($myCouponList) > 0) {
            $cartCouponExcept = [];
            foreach ($myCouponList as $key => $coupon) {
                $cartCouponExcept[$coupon['regist_ix']] = 0;
                foreach ($productList as $product) {
                    $productActiveBool = $this->checkCartCouponProductActive($product['id'], $coupon);
                    if ($productActiveBool) {
                        if ($product['cartOverlapUseYn'] == 'N' || $product['discount_coupon_use_yn'] == 'N' || ($product['discount_coupon_use_yn'] == 'Y' && $coupon['discount_use_yn'] == 'N')) {
                            $productActiveBool = false;
                        }
                    }
                    if (!$productActiveBool) {
                        $cartCouponExcept[$coupon['regist_ix']] += $product['total_coupon_with_dcprice'];
                    }
                }
            }

            foreach ($myCouponList as $key => $coupon) {
                $targetPrice = $price - $cartCouponExcept[$coupon['regist_ix']];
                $activeBool = $this->checkCartCouponActive($targetPrice, $coupon);
                if ($activeBool) {
                    $coupon['discount_amount'] = $this->calculationDiscount($targetPrice, $coupon)['discount_amount'];
                    $coupon['total_coupon_with_dcprice'] = $targetPrice - $coupon['discount_amount'];
                }
                $coupon['activeBool'] = $activeBool;
                $myCouponList[$key] = $coupon;
            }
        }
        return $myCouponList;
    }

    /**
     * 배송비 보유쿠폰 적용 정보 리스트
     * @param type $price
     * @param type $productList
     * @return type
     */
    public function applyUserDeliveryCouponList($price, $totalProductDcprice)
    {

        $myCouponList = $this->getUserCouponList(false, 1, 100
            , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type',
                'cp.publish_max', 'cp.publish_limit_price', 'cp.publish_min',
                'cp.publish_condition_price', 'cp.discount_use_yn', 'cp.is_except', 'cp.overlap_use_yn', 'cp.payment_method']
            , ['c.cupon_div' => 'D'])['list'];

        if (count($myCouponList) > 0) {

            foreach ($myCouponList as $key => $coupon) {
                $targetPrice = $price;
                $activeBool = $this->checkDeliveryCouponActive($totalProductDcprice, $coupon);
                if ($activeBool) {
                    $coupon['discount_amount'] = $this->calculationDiscount($targetPrice, $coupon)['discount_amount'];
                    $coupon['total_coupon_with_dcprice'] = $targetPrice - $coupon['discount_amount'];
                }
                $coupon['activeBool'] = $activeBool;
                $myCouponList[$key] = $coupon;
            }
        }
        return $myCouponList;
    }

    /**
     * 해당 장바구니 쿠폰 상품 사용 가능 여부
     * @param type $pid
     * @param type $unitPrice
     * @param type $couponData
     * @return boolean
     */
    protected function checkCartCouponProductActive($pid, $couponData)
    {
        $publishIx = $couponData['publish_ix'];
        $useProductType = $couponData['use_product_type'];

        $activeBool = false;

        //사용가능상품
        if ($useProductType == '1') {
            $activeBool = true;
        } else {
            switch ($useProductType) {
                case'2': //카테고리
                    $this->qb
                        ->select('crc.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as crc')
                        ->join(TBL_SHOP_PRODUCT_RELATION . ' as pr', 'SUBSTRING(crc.cid,1,(crc.depth+1)*3) = SUBSTRING(pr.cid,1,(crc.depth+1)*3)', 'inner')
                        ->where('crc.publish_ix', $publishIx)
                        ->where('pr.pid', $pid);
                    break;
                case'3': //상품
                    $this->qb
                        ->select('crp.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                        ->where('crp.publish_ix', $publishIx)
                        ->where('crp.pid', $pid);
                    break;
                case'4': //브랜드
                    $this->qb
                        ->select('crb.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_BRAND . ' as crb')
                        ->join(TBL_SHOP_PRODUCT . ' as p', 'p.brand=crb.b_ix', 'inner')
                        ->where('crb.publish_ix', $publishIx)
                        ->where('p.id', $pid);
                    break;
                case'5': //셀러
                    $this->qb
                        ->select('crs.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_SELLER . ' as crs')
                        ->join(TBL_SHOP_PRODUCT . ' as p', 'crs.company_id=p.admin', 'inner')
                        ->where('crs.publish_ix', $publishIx)
                        ->where('p.id', $pid);
                    break;
                case'6': //특정 상품 제외
                    $this->qb
                        ->select('crp.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                        ->where('crp.publish_ix', $publishIx)
                        ->where('crp.pid', $pid);
                    break;
                default :
                    return false;
                    break;
            }

            $total = $this->qb->limit(1)->getCount();
            if ($useProductType == '6') {
                if ($total == 0) {
                    $activeBool = true;
                }
            } else {
                if ($total > 0) {
                    $activeBool = true;
                }
            }
        }

        //일부 상품 제외
        if ($activeBool == true && $couponData['is_except'] == '1') {
            $this->qb
                ->select('crp.publish_ix')
                ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                ->where('crp.publish_ix', $publishIx)
                ->where('crp.pid', $pid);
            $total = $this->qb->limit(1)->getCount();
            if ($total > 0) {
                $activeBool = false;
            }
        }
        return $activeBool;
    }

    /**
     * 해당 장바구니 쿠폰 사용 가능 여부
     * @param type $unitPrice
     * @param type $couponData
     * @return boolean
     */
    protected function checkCartCouponActive($unitPrice, $couponData)
    {
        $unitPrice = f_decimal($unitPrice);
        $publishMin = $couponData['publish_min'];
        $publishConditionPrice = f_decimal($couponData['publish_condition_price']);
        $publishMaxProduct = $couponData['publish_max_product'];
        $publishMaxPrice = f_decimal($couponData['publish_max_price']);

        //상품 금액이 0일면 X
        if ($unitPrice == 0) {
            return false;
        }

        //쿠폰 혜택 제한 (최소 상품금액)
        if ($publishMin == 'Y' && $unitPrice < $publishConditionPrice) {
            return false;
        }
        //쿠폰 혜택 제한 (최대 상품금액)
        if ($publishMaxProduct == 'Y' && $unitPrice > $publishMaxPrice) {
            return false;
        }

        return true;
    }

    /**
     * 해당 배송비 쿠폰 사용 가능 여부
     * @param type $unitPrice
     * @param type $couponData
     * @return boolean
     */
    protected function checkDeliveryCouponActive($unitPrice, $couponData)
    {
        $unitPrice = f_decimal($unitPrice);
        $publishMin = $couponData['publish_min'];
        $publishConditionPrice = f_decimal($couponData['publish_condition_price']);
        $publishMaxProduct = $couponData['publish_max_product'];
        $publishMaxPrice = f_decimal($couponData['publish_max_price']);

        //상품 금액이 0일면 X
        if ($unitPrice == 0) {
            return false;
        }

        //쿠폰 혜택 제한 (최소 상품금액)
        if ($publishMin == 'Y' && $unitPrice < $publishConditionPrice) {
            return false;
        }
        //쿠폰 혜택 제한 (최대 상품금액)
        if ($publishMaxProduct == 'Y' && $unitPrice > $publishMaxPrice) {
            return false;
        }

        return true;
    }

    /**
     * 카트에서 장바구니 쿠폰 사용 리스트 처리
     * @param type $regist_ix
     * @param type $price
     */
    public function applyCartCoupon($regist_ix, $price, $productList)
    {

        $coupon = ($this->getUserCouponList(false, 1, 100
                , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type'
                    , 'cp.publish_max', 'cp.publish_limit_price', 'cp.discount_use_yn', 'cp.is_except']
                , ['c.cupon_div' => 'C', 'cr.regist_ix' => $regist_ix])['list'][0] ?? false);

        //내 쿠폰인지 아닐경우
        if ($coupon === false) {
            return false;
        } else {
            $cartCouponExcept = f_decimal(0);
            $permitPid = [];
            foreach ($productList as $product) {
                $productActiveBool = $this->checkCartCouponProductActive($product['id'], $coupon);
                if ($productActiveBool) {
                    if ($product['cartOverlapUseYn'] == 'N' || $product['discount_coupon_use_yn'] == 'N' || ($product['discount_coupon_use_yn'] == 'Y' && $coupon['discount_use_yn'] == 'N')) {
                        $productActiveBool = false;
                    }
                }
                if ($productActiveBool) {
                    $permitPid[] = $product['id'];
                } else {
                    $cartCouponExcept += $product['total_coupon_with_dcprice'];
                }
            }

            $targetPrice = $price - $cartCouponExcept;
            $activeBool = $this->checkCartCouponActive($targetPrice, $coupon);
            if ($activeBool) {
                return array_merge($this->calculationDiscount($targetPrice, $coupon), ['targetPrice' => $targetPrice, 'discount_use_yn' => $coupon['discount_use_yn'], 'permitPid' => $permitPid]);
            } else {
                return false;
            }
        }
    }

    /**
     * 카트에서 배송비 쿠폰 사용 리스트 처리
     * @param type $regist_ix
     * @param type $price
     */
    public function applyDeliveryCoupon($regist_ix, $price)
    {

        $coupon = ($this->getUserCouponList(false, 1, 100
                , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type'
                    , 'cp.publish_max', 'cp.publish_limit_price', 'cp.discount_use_yn', 'cp.is_except']
                , ['c.cupon_div' => 'D', 'cr.regist_ix' => $regist_ix])['list'][0] ?? false);

        //내 쿠폰인지 아닐경우
        if ($coupon === false) {
            return false;
        } else {
            $targetPrice = $price;
            return array_merge($this->calculationDiscount($targetPrice, $coupon), ['targetPrice' => $targetPrice, 'discount_use_yn' => $coupon['discount_use_yn']]);

        }
    }


    /**
     * 해당 회원의 쿠폰리스트( 모바일 : 마이페이지 > 쿠폰 팝업 > 적용대상 상품리스트 )
     * @param boolean $useYn
     * @param int $page
     * @param int $limit
     * @param array $addSelect
     * @param array $addWhere
     * @return array
     */
    public function getCouponApplyProductList($registIx)
    {

        $this->qb->startCache();

        $this->qb
            ->select("cr.regist_ix")
            ->select("date_format(cr.use_sdate, '%Y-%m-%d') as regist_start, date_format(cr.use_date_limit, '%Y-%m-%d') as regist_end")
            ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
            ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix=cp.publish_ix', 'inner')
            ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix=cp.cupon_ix', 'inner')
            ->where('cr.mem_ix', $this->userCode)
            ->where('cr.regist_ix', $registIx);

        $this->qb->stopCache();
        $list = $this->setBasicSelect()->exec()->getResultArray();
        $this->qb->flushCache();


        // 쿠폰 타입에 따라 적용 대상 상품 리스트를 추가해준다.
        if (count($list) > 0) {

            foreach ($list as $p => $v) {

                // 카테고리 상품
                if ($v['use_product_type'] == '2') {

                    $list[$p]['plist'] = $this->qb
                        ->select("t3.pname, t3.id, t2.cid")
                        ->from(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as t1')
                        ->join(TBL_SHOP_PRODUCT_RELATION . ' as t2', 't1.cid = t2.cid', 'inner')
                        ->join(TBL_SHOP_PRODUCT . ' as t3', 't3.id = t2.pid', 'inner')
                        ->where('t1.publish_ix', $list[$p]['publish_ix'])
                        ->orderBy('t2.cid', 'asc')
                        ->orderBy('t3.regdate', 'desc')
                        ->exec()
                        ->getResultArray();

                    // 특정 상품 (type:3)
                    // 특정 상품 제외 쿠폰(type:6) 추가, 제외 대상 상품을 조회 한다.
                } else if ($v['use_product_type'] == '3' || $v['use_product_type'] == '6') {

                    $list[$p]['plist'] = $this->qb
                        ->select("sp.pname, sp.id")
                        ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as cr')
                        ->join(TBL_SHOP_PRODUCT . ' as sp', 'cr.pid = sp.id', 'inner')
                        ->where('cr.publish_ix', $list[$p]['publish_ix'])
                        ->orderBy('sp.regdate', 'desc')
                        ->exec()
                        ->getResultArray();
                }
            }
        }

        return [
            'list' => $list
        ];
    }

    /**
     * 해당 회원의 쿠폰리스트( 모바일 : 마이페이지 > 쿠폰 팝업 > 적용대상 상품리스트 )
     * @param boolean $useYn
     * @param int $page
     * @param int $limit
     * @param array $addSelect
     * @param array $addWhere
     * @return array
     */
    public function getCouponApplyProductListByPub($publish_ix)
    {

        $row = $this->setBasicSelect()
            ->select("cp.publish_max_price")
            ->select("cp.publish_max_product")
            ->select("cp.publish_ix")
            ->select("cp.is_except")
            ->from(TBL_SHOP_CUPON_PUBLISH . ' as cp')
            ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix=cp.cupon_ix', 'inner')
            ->where('cp.publish_ix', $publish_ix)
            ->exec()->getRowArray();

        if (!empty($row)) {

            if ($row['publish_min'] == 'Y' && $row['publish_condition_price'] > 0 && $row['publish_max'] == 'N' && $row['publish_max_product'] == 'N') {
                $publish_condition_price_text = g_price($row['publish_condition_price']) . trans("원 이상 구매시");
//                }else if($row['publish_limit_price'] > 0){
            } else if ($row['publish_max_product'] == 'Y' && $row['publish_max_price'] > 0 && $row['publish_max'] == 'N' && $row['publish_min'] == 'N'){
                $publish_condition_price_text = g_price($row['publish_max_price']) . trans("원 미만 구매시");
            } else if ($row['publish_min'] == 'Y' && $row['publish_condition_price'] > 0 && $row['publish_max_product'] == 'Y' && $row['publish_max_price'] > 0 && $row['publish_max'] == 'N'){
                $publish_condition_price_text = g_price($row['publish_condition_price']) . trans("원 이상 ").g_price($row['publish_max_price']) . trans("원 미만 구매시");
            }else if ($row['publish_max'] == 'Y' && $row['publish_limit_price'] > 0 && $row['publish_min'] == 'N' && $row['publish_max_product'] == 'N') {
                $publish_condition_price_text = trans('최대 ') . g_price($row['publish_limit_price']) . trans("원 할인");
            } else if ($row['publish_max'] == 'Y' && $row['publish_limit_price'] > 0 && $row['publish_min'] == 'Y' && $row['publish_condition_price'] > 0 && $row['publish_max_product'] == 'N') {
                $publish_condition_price_text = g_price($row['publish_condition_price']) . trans('원 이상 구매시 최대 ') . g_price($row['publish_limit_price']) . trans("원 할인");
            } else if ($row['publish_max'] == 'Y' && $row['publish_limit_price'] > 0 && $row['publish_min'] == 'Y' && $row['publish_condition_price'] > 0 && $row['publish_max_product'] == 'Y'  && $row['publish_max_price'] > 0){
                $publish_condition_price_text = g_price($row['publish_condition_price']) . trans('원 이상 ').g_price($row['publish_max_price']) . trans('원 미만 구매시 최대 ') . g_price($row['publish_limit_price']) . trans("원 할인");
            } else if ($row['publish_max'] == 'Y' && $row['publish_limit_price'] > 0  && $row['publish_max_product'] == 'Y'  && $row['publish_max_price'] > 0 && $row['publish_min'] == 'N' ){
                $publish_condition_price_text = g_price($row['publish_max_price']) . trans('원 미만 구매시 최대 ') . g_price($row['publish_limit_price']) . trans("원 할인");
            } else {
                $publish_condition_price_text = trans("제한조건 없음");
            }
            $row['publish_condition_price_text'] = $publish_condition_price_text;

            if($row['use_date_type'] == '2'){
                $userDate = $this->qb
                    ->select("date_format(cr.use_sdate, '%Y-%m-%d') as regist_start, date_format(cr.use_date_limit, '%Y-%m-%d') as regist_end")
                    ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
                    ->where('cr.mem_ix', $this->userCode)
                    ->where('cr.publish_ix', $row['publish_ix'])
                    ->exec()->getRowArray();

                $row['regist_start'] = $userDate['regist_start'];
                $row['regist_end'] = $userDate['regist_end'];
            }


            // 카테고리 상품
            if ($row['use_product_type'] == '2') {

                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');

                $cResults = $this->qb
                    ->select("t1.cid")
                    ->from(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as t1')
                    ->where('t1.publish_ix', $row['publish_ix'])
                    ->exec()
                    ->getResultArray();
                $row['clist'] = [];
                foreach ($cResults as $key => $val) {
                    $res = $productModel->getCategoryPath($val['cid'], $productModel->getDepth($val['cid']));
                    $cnameList = [];
                    foreach ($res as $key2 => $cname) {
                        $cnameList[] = $cname['cname'];
                    }
                    $row['clist'][$key]['cPathName'] = implode('/', $cnameList);
                    $row['clist'][$key]['cid'] = $val['cid'];
                }


                // 특정 상품
            } else if ($row['use_product_type'] == '3') {

                $row['plist'] = $this->qb
                    ->select("sp.pname, sp.id")
                    ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as cr')
                    ->join(TBL_SHOP_PRODUCT . ' as sp', 'cr.pid = sp.id', 'inner')
                    ->where('cr.publish_ix', $row['publish_ix'])
                    ->orderBy('sp.regdate', 'desc')
                    ->exec()
                    ->getResultArray();
            } else if ($row['use_product_type'] == '4') {
                // 브랜드
                $row['blist'] = $this->qb
                    ->select("b.b_ix, b.brand_name")
                    ->from(TBL_SHOP_BRAND . ' b')
                    ->join(TBL_SHOP_CUPON_RELATION_BRAND . ' rb', 'b.b_ix = rb.b_ix', 'left')
                    ->where('rb.publish_ix', $row['publish_ix'])
                    ->where('disp', 1)
                    ->where('apply_status', 1)
                    ->exec()
                    ->getResultArray();
            } else if ($row['use_product_type'] == '5') {
                // 셀러
                $row['slist'] = $this->qb
                    ->select("cd.company_id, cd.com_name")
                    ->from(TBL_COMMON_COMPANY_DETAIL . ' as cd')
                    ->join(TBL_COMMON_USER . ' as cu', 'cu.company_id = cd.company_id')
                    ->join(TBL_SHOP_CUPON_RELATION_SELLER . ' rs', 'cd.company_id = rs.company_id', 'left')
                    ->where('rs.publish_ix', $row['publish_ix'])
                    ->where('cd.com_type', 'S')
                    ->where('cu.auth', '4')
                    ->where('cu.authorized', 'Y')
                    ->exec()
                    ->getResultArray();
            } else if ($row['use_product_type'] == '6' || $row['is_except'] == '1') {
                // 제외 상품
                $row['plist'] = $this->qb
                    ->select("sp.pname, sp.id")
                    ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as cr')
                    ->join(TBL_SHOP_PRODUCT . ' as sp', 'cr.pid = sp.id', 'inner')
                    ->where('cr.publish_ix', $row['publish_ix'])
                    ->orderBy('sp.regdate', 'desc')
                    ->exec()
                    ->getResultArray();
            }
        }
        return $row;
    }

    /**
     * 해당 회원의 쿠폰리스트(마이페이지 > 쿠폰리스트)
     * @param boolean $useYn
     * @param int $page
     * @param int $limit
     * @param array $addSelect
     * @param array $addWhere
     * @return array
     */
    public function getUserCouponList($useYn = null, $page = '1', $limit = '10', $addSelect = [], $addWhere = [])
    {
        $this->qb->startCache();

        //추가 select 처리
        if (!empty($addSelect) && is_array($addSelect)) {
            foreach ($addSelect as $select) {
                $this->qb->select($select);
            }
        }

        //추가 select 처리
        if (!empty($addWhere) && is_array($addWhere)) {
            foreach ($addWhere as $key => $value) {
                $this->qb->where($key, $value);
            }
        }

        $now = date('Y-m-d H:i:s');

        $this->qb
            ->select('use_yn')
            ->select("cr.regist_ix")
            ->select("cp.is_except")
            ->select('cp.publish_max_product')
            ->select('cp.publish_max_price')
            ->select("date_format(cr.use_sdate, '%Y-%m-%d') as regist_start, date_format(cr.use_date_limit, '%Y-%m-%d') as regist_end")
            ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
            ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix=cp.publish_ix', 'inner')
            ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix=cp.cupon_ix', 'inner')
            ->where('cr.mem_ix', $this->userCode)
            ->whereIn('c.cupon_use_div', ['A', $this->agentType])
            ->where('cp.is_use !=', '3')
            ->where('cr.use_sdate <= ', $now)
            ->where('cr.use_date_limit >= ', $now)
            ->whereIn('cp.mall_ix', ['', MALL_IX])
            ->orderBy('cr.regdate', 'desc');

        if ($useYn !== null) {
            if ($useYn) { //사용완료 & 기한만료된 쿠폰
                $this->setBasicUseWhere($useYn);
                $this->qb->select("cr.use_oid");
            } else { //사용가능 쿠폰
                $this->setBasicUseWhere($useYn);
            }
        }

        $this->qb->stopCache();

        $total = $this->qb->limit(1)->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($page, $limit);
        $offset = $paging['offset'];

        $list = $this->setBasicSelect()
            ->limit($limit, $offset)->exec()->getResultArray();
        $this->qb->flushCache();

        if (is_array($list)) {
            foreach ($list as $key => $val) {
                $cupon_use_div_text = "";
                if ($val['cupon_use_div'] == 'G') {
                    $cupon_use_div_text = "[웹전용]";
                } else if ($val['cupon_use_div'] == 'M') {
                    $cupon_use_div_text = "[모바일전용]";
                }
                $list[$key]['cupon_use_div_text'] = $cupon_use_div_text;
                $list[$key]['cupon_sale_value'] = $val['cupon_sale_value'];
                $list[$key]['cupon_sale_value_text'] = number_format($val['cupon_sale_value']);

                $cupon_sale_type_text = "";
                if ($val['cupon_sale_type'] == '1') {
                    $list[$key]['cupon_sale_type_isPer'] = true;
                    $cupon_sale_type_text = "%";
                    $list[$key]['cupon_sale_value_text'] = $list[$key]['cupon_sale_value_text'] . " " . $cupon_sale_type_text;
                } else if ($val['cupon_sale_type'] == '2') {
                    $list[$key]['cupon_sale_type_isPer'] = false;
                    if (BASIC_LANGUAGE == 'korean') {
                        $list[$key]['cupon_sale_value_text'] = $list[$key]['cupon_sale_value_text'] . BACK_UNIT;
                    } else {
                        $list[$key]['cupon_sale_value_text'] = FRONT_UNIT . $list[$key]['cupon_sale_value_text'];
                    }
                }else if($val['cupon_sale_type'] == '3'){
                    $list[$key]['cupon_sale_value_text'] = trans('전액할인');
                }
                $list[$key]['cupon_sale_type_text'] = $cupon_sale_type_text;


                $use_date_text = "";
                $use_sdate_text = "";
                $use_edate_text = "";

                //$from = new DateTime( $val['regist_start'] );
                $from = new DateTime( date() );
                $to = new DateTime( $val['regist_end'] );
                $use_date_text = date_diff( $from, $to )->days."일 남음";

                if ($val['regist_end'] > '3000-12-31 00:00:00' || $val['use_date_type'] == '9') {
                    $use_date_text = "무기한";
                } else if ($val['use_date_type'] == '2') {
                    $use_sdate_text = substr($val['regist_start'], 0, 10);
                    $use_edate_text = substr($val['regist_end'], 0, 10);
                } else if ($val['use_date_type'] == '1') {
                    $use_sdate_text = substr($val['regdate'], 0, 10);
                    $use_edate_text = substr($val['publish_limit_date'], 0, 10);
                } else {
                    $use_sdate_text = substr($val['use_sdate'], 0, 10);
                    $use_edate_text = substr($val['use_edate'], 0, 10);
                }

                $list[$key]['regist_diff'] = $use_date_text;
                $list[$key]['use_sdate_text'] = $use_sdate_text;
                $list[$key]['use_edate_text'] = $use_edate_text;

                $publish_condition_price_text = "";
                if ($val['publish_min'] == 'Y' && $val['publish_condition_price'] > 0 && $val['publish_max'] == 'N' && $val['publish_max_product'] == 'N') {
                    $publish_condition_price_text = g_price($val['publish_condition_price']) . trans("원 이상 구매시");
//                }else if($val['publish_limit_price'] > 0){
                } else if ($val['publish_max_product'] == 'Y' && $val['publish_max_price'] > 0 && $val['publish_max'] == 'N' && $val['publish_min'] == 'N'){
                    $publish_condition_price_text = g_price($val['publish_max_price']) . trans("원 미만 구매시");
                } else if ($val['publish_min'] == 'Y' && $val['publish_condition_price'] > 0 && $val['publish_max_product'] == 'Y' && $val['publish_max_price'] > 0 && $val['publish_max'] == 'N'){
                    $publish_condition_price_text = g_price($val['publish_condition_price']) . trans("원 이상 ").g_price($val['publish_max_price']) . trans("원 미만 구매시");
                }else if ($val['publish_max'] == 'Y' && $val['publish_limit_price'] > 0 && $val['publish_min'] == 'N' && $val['publish_max_product'] == 'N') {
                    $publish_condition_price_text = trans('최대 ') . g_price($val['publish_limit_price']) . trans("원 할인");
                } else if ($val['publish_max'] == 'Y' && $val['publish_limit_price'] > 0 && $val['publish_min'] == 'Y' && $val['publish_condition_price'] > 0 && $val['publish_max_product'] == 'N') {
                    $publish_condition_price_text = g_price($val['publish_condition_price']) . trans('원 이상 구매시 최대 ') . g_price($val['publish_limit_price']) . trans("원 할인");
                } else if ($val['publish_max'] == 'Y' && $val['publish_limit_price'] > 0 && $val['publish_min'] == 'Y' && $val['publish_condition_price'] > 0 && $val['publish_max_product'] == 'Y'  && $val['publish_max_price'] > 0){
                    $publish_condition_price_text = g_price($val['publish_condition_price']) . trans('원 이상 ').g_price($val['publish_max_price']) . trans('원 미만 구매시 최대 ') . g_price($val['publish_limit_price']) . trans("원 할인");
                } else if ($val['publish_max'] == 'Y' && $val['publish_limit_price'] > 0  && $val['publish_max_product'] == 'Y'  && $val['publish_max_price'] > 0 && $val['publish_min'] == 'N' ){
                    $publish_condition_price_text = g_price($val['publish_max_price']) . trans('원 미만 구매시 최대 ') . g_price($val['publish_limit_price']) . trans("원 할인");
                } else {
                    $publish_condition_price_text = trans("제한조건 없음");
                }

                $list[$key]['publish_condition_price_text'] = $publish_condition_price_text;

                $use_product_type_text = "";
                $use_product_type_all = false;

                if ($val['use_product_type'] == '1') {
                    $use_product_type_text = trans("전체상품 적용");

                    #전체상품 중 일부 상품 제외 일때
                    if ($val['is_except'] == true) {
                        $use_product_type_all = false;
                    } else {
                        $use_product_type_all = true;
                    }

                } else if ($val['use_product_type'] == '4') {
                    $use_product_type_text = trans("특정 브랜드에 속한 상품 적용");
                } else if ($val['use_product_type'] == '2') {
                    $use_product_type_text = trans("특정 카테고리에 속한 상품 적용");
                } else if ($val['use_product_type'] == '5') {
                    $use_product_type_text = trans("특정 셀러에 속한 상품 적용");
                } else if ($val['use_product_type'] == '3') {
                    $use_product_type_text = trans("특정 상품 적용");
                }else{
                    $use_product_type_all = true;
                    $use_product_type_text = trans("전체상품 적용");
                }
                $list[$key]['use_product_type_all'] = $use_product_type_all;
                if ($useYn == false) {
                    $list[$key]['use_product_type_text'] = $use_product_type_text;
                }

                $use_yn_text = "";
                if ($val['use_yn'] == '1') {
                    $use_yn_text = trans("사용완료");
                } else {
                    if(date('Y-m-d') > $use_edate_text){
                        $use_yn_text = trans("기간만료");
                    }

                }
                $list[$key]['use_yn_text'] = $use_yn_text;
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 해당 상품의 쿠폰 사용 가능 여부
     * @param type $pid
     * @param type $unitPrice
     * @param type $couponData
     * @return boolean
     */
    protected function checkProductCouponActive($pid, $unitPrice, $couponData)
    {
        $unitPrice = f_decimal($unitPrice);
        $publishIx = $couponData['publish_ix'];
        $publishMin = $couponData['publish_min'];
        $publishConditionPrice = f_decimal($couponData['publish_condition_price']);
        $publishMaxProduct = $couponData['publish_max_product'];
        $publishMaxPrice = f_decimal($couponData['publish_max_price']);
        $useProductType = $couponData['use_product_type'];

        $activeBool = false;

        //상품 금액이 0일면 X
        if ($unitPrice == 0) {
            return false;
        }

        //쿠폰 혜택 제한 (최소 상품금액)
        if ($publishMin == 'Y' && $unitPrice < $publishConditionPrice) {
            return false;
        }

        //쿠폰 혜택 제한 (최대 상품금액)
        if ($publishMaxProduct == 'Y' && $unitPrice > $publishMaxPrice) {
            return false;
        }

        //사용가능상품
        if ($useProductType == '1') {
            $activeBool = true;
        } else {
            switch ($useProductType) {
                case'2': //카테고리
                    $this->qb
                        ->select('crc.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as crc')
                        ->join(TBL_SHOP_PRODUCT_RELATION . ' as pr', 'SUBSTRING(crc.cid,1,(crc.depth+1)*3) = SUBSTRING(pr.cid,1,(crc.depth+1)*3)', 'inner')
                        ->where('crc.publish_ix', $publishIx)
                        ->where('pr.pid', $pid);
                    break;
                case'3': //상품
                    $this->qb
                        ->select('crp.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                        ->where('crp.publish_ix', $publishIx)
                        ->where('crp.pid', $pid);
                    break;
                case'4': //브랜드
                    $this->qb
                        ->select('crb.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_BRAND . ' as crb')
                        ->join(TBL_SHOP_PRODUCT . ' as p', 'p.brand=crb.b_ix', 'inner')
                        ->where('crb.publish_ix', $publishIx)
                        ->where('p.id', $pid);
                    break;
                case'5': //셀러
                    $this->qb
                        ->select('crs.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_SELLER . ' as crs')
                        ->join(TBL_SHOP_PRODUCT . ' as p', 'crs.company_id=p.admin', 'inner')
                        ->where('crs.publish_ix', $publishIx)
                        ->where('p.id', $pid);
                    break;
                case'6': //특정 상품 제외
                    $this->qb
                        ->select('crp.publish_ix')
                        ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                        ->where('crp.publish_ix', $publishIx)
                        ->where('crp.pid', $pid);
                    break;
                default :
                    return false;
                    break;
            }

            $total = $this->qb->limit(1)->getCount();
            if ($useProductType == '6') {
                if ($total == 0) {
                    $activeBool = true;
                }
            } else {
                if ($total > 0) {
                    $activeBool = true;
                }
            }
        }

        //일부 상품 제외
        if ($activeBool == true && $couponData['is_except'] == '1') {
            $this->qb
                ->select('crp.publish_ix')
                ->from(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp')
                ->where('crp.publish_ix', $publishIx)
                ->where('crp.pid', $pid);
            $total = $this->qb->limit(1)->getCount();
            if ($total > 0) {
                $activeBool = false;
            }
        }
        return $activeBool;
    }

    /**
     * 카트에서 쿠폰 사용 리스트 처리
     * @param type $regist_ix
     * @param type $pid
     * @param type $unitPrice
     * @param type $paymentPrice
     */
    public function applyProductCoupon($regist_ix, $pid, $unitPrice, $paymentPrice)
    {
        $coupon = ($this->getUserCouponList(false, 1, 100
                , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type', 'cp.publish_max',
                    'cp.publish_limit_price', 'cp.is_except', 'cp.overlap_use_yn']
                , ['c.cupon_div' => 'G', 'cr.regist_ix' => $regist_ix])['list'][0] ?? false);

        //내 쿠폰인지 아닐경우
        if ($coupon === false) {
            return false;
        } else {
            $activeBool = $this->checkProductCouponActive($pid, $unitPrice, $coupon);
            if ($activeBool) {
                return array_merge(['cartOverlapUseYn' => $coupon['overlap_use_yn']], $this->calculationDiscount($paymentPrice, $coupon));
            } else {
                return false;
            }
        }
    }

    /**
     * 해당하는 쿠폰 정보 출력
     * @param int $publishIx
     * @return array
     */
    public function getCouponDatas($publishIx)
    {
        return $this->setBasicSelect()
            ->select('cp.regist_date_differ')
            ->select('cp.regist_count')
            ->select('cp.is_use')
			->select('cp.issue_type')
            ->from(TBL_SHOP_CUPON . ' as c')
            ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'on c.cupon_ix=cp.cupon_ix', 'inner')
            ->where('cp.publish_ix', $publishIx)
            ->exec()
            ->getRow(0, 'array');
    }

	public function checkPublishedConfig($publishIx)
    {
        $count = $this->qb->select('cpc_ix')
            ->from(TBL_SHOP_CUPON_PUBLISH_CONFIG)
            ->where('publish_ix', $publishIx)
            ->where('r_ix', $this->userCode)
            ->limit(1)
            ->getCount();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 쿠폰 지급
     * @param int $publishIx
     * @return string
     */
    public function giveCoupon($publishIx)
    {
        $couponDownCnt  = $this->checkCouponDownCnt($publishIx);
        $datas          = $this->getCouponDatas($publishIx);

        if($couponDownCnt < $datas['regist_count']){
            if ($datas['use_date_type'] == 9) { //무제한
                $use_date_limit = date('Y-m-d H:i:s', strtotime('+100 years'));;
                $use_sdate = date('Y-m-d H:i:s');
            } else if ($datas['use_date_type'] == 1) { //발행일 기준
                $use_date_limit = $datas['publish_limit_date'];
                $use_sdate = $datas['regdate'];
            } else if ($datas['use_date_type'] == 2) {//발급일 기준
                if ($datas['regist_date_type'] == 1) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' years'));
                } else if ($datas['regist_date_type'] == 2) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' months'));
                } else if ($datas['regist_date_type'] == 3) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' days'));
                }
                $use_sdate = date('Y-m-d H:i:s');
            } else if ($datas['use_date_type'] == 3) {//사용기간 지정
                $use_date_limit = $datas['use_edate'];
                $use_sdate = $datas['use_sdate'];
            } else {
                return 'fail';
            }

            //쿠폰 사용 여부가 사용 상태가 아닌 경우 등록하지 않는다.
            if($datas['is_use'] !='1'){
                return 'useFail';
            }

            if ($datas['issue_type'] == 2 && $datas['publish_type'] == 1) {
                if ($this->checkPublishedConfig($publishIx)) {
                    //for ($rc = 0; $rc < $datas['regist_count']; $rc++) {
                        $this->qb->insert(TBL_SHOP_CUPON_REGIST, [
                            'publish_ix' => $publishIx,
                            'mem_ix' => $this->userCode,
                            'open_yn' => 0,
                            'use_yn' => 0,
                            'use_sdate' => $use_sdate,
                            'use_date_limit' => $use_date_limit,
                            'regdate' => date('Y-m-d H:i:s')
                        ])->exec();
                    //}
                } else {
                    return 'useFail';
                }
            } else {
                //for ($rc = 0; $rc < $datas['regist_count']; $rc++) {
                    $this->qb->insert(TBL_SHOP_CUPON_REGIST, [
                        'publish_ix' => $publishIx,
                        'mem_ix' => $this->userCode,
                        'open_yn' => 0,
                        'use_yn' => 0,
                        'use_sdate' => $use_sdate,
                        'use_date_limit' => $use_date_limit,
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();
                //}
            }
            return 'success';
        }else{
            return 'overlap';
        }

        /*if (!$this->checkPublished($publishIx)) {
            $datas = $this->getCouponDatas($publishIx);
            if ($datas['use_date_type'] == 9) { //무제한
                $use_date_limit = null;
                $use_sdate = date('Y-m-d H:i:s');
            } else if ($datas['use_date_type'] == 1) { //발행일 기준
                $use_date_limit = $datas['publish_limit_date'];
                $use_sdate = $datas['regdate'];
            } else if ($datas['use_date_type'] == 2) {//발급일 기준
                if ($datas['regist_date_type'] == 1) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' years'));
                } else if ($datas['regist_date_type'] == 2) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' months'));
                } else if ($datas['regist_date_type'] == 3) {
                    $use_date_limit = date('Y-m-d H:i:s', strtotime('+' . $datas['regist_date_differ'] . ' days'));
                }
                $use_sdate = date('Y-m-d H:i:s');
            } else if ($datas['use_date_type'] == 3) {//사용기간 지정
                $use_date_limit = $datas['use_edate'];
                $use_sdate = $datas['use_sdate'];
            } else {
                return 'fail';
            }

            //쿠폰 사용 여부가 사용 상태가 아닌 경우 등록하지 않는다.
            if($datas['is_use'] !='1'){
                return 'useFail';
            }

			if ($datas['issue_type'] == 2) {
				if ($this->checkPublishedConfig($publishIx)) {
					for ($rc = 0; $rc < $datas['regist_count']; $rc++) {
						$this->qb->insert(TBL_SHOP_CUPON_REGIST, [
							'publish_ix' => $publishIx,
							'mem_ix' => $this->userCode,
							'open_yn' => 0,
							'use_yn' => 0,
							'use_sdate' => $use_sdate,
							'use_date_limit' => $use_date_limit,
							'regdate' => date('Y-m-d H:i:s')
						])->exec();
					}
				} else {
					return 'useFail';
				}
			} else {
				for ($rc = 0; $rc < $datas['regist_count']; $rc++) {
					$this->qb->insert(TBL_SHOP_CUPON_REGIST, [
						'publish_ix' => $publishIx,
						'mem_ix' => $this->userCode,
						'open_yn' => 0,
						'use_yn' => 0,
						'use_sdate' => $use_sdate,
						'use_date_limit' => $use_date_limit,
						'regdate' => date('Y-m-d H:i:s')
					])->exec();
				}
			}
            return 'success';
        } else {
            return 'overlap';
        }*/
    }

    public function getRandomCouponInfo($gc_ix=''){

        $nowDate = date('Y-m-d');

        if($gc_ix){
            $this->qb->where('gc.gc_ix',$gc_ix);
        }
        //랜덤 쿠폰 사용 가능 개수 처리 할때 한번이라도 등록 한 쿠폰이 있을 경우는 제외 해야 함 subquery 이용처리
        $this->qb->setDatabase('payment');
        $datas = $this->qb
            ->distinct()
            ->select('gcd.gc_ix')
            ->select('gc.percentage')
            ->select('gc.gift_file_path')
            ->from(TBL_SHOP_GIFT_RANDOM_CERTIFICATE .' as gc')
            ->join(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL .' as gcd' ,'gc.gc_ix = gcd.gc_ix','left')
            ->where('gcd.status','Y')
            ->where('gcd.gift_change_state','0')
            ->where('gc.is_use','1')
            ->whereNotIn('gc.gc_ix',
                $this->qb
                    ->startSubQuery()
                    ->select('gc_ix')
                    ->from(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL)
                    ->where('user_code', $this->userInfo->code)
                    ->endSubQuery(), false
            )
            ->whereNotIn('gcd.gcd_ix',
                $this->qb
                    ->startSubQuery()
                    ->select('sgcd.gcd_ix')
                    ->from(TBL_SHOP_CUPON_REGIST .' as cr')
                    ->join(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL .' as sgcd','cr.publish_ix = sgcd.gift_value','left')
                    ->where('sgcd.gift_type' ,'C')
                    ->where('cr.mem_ix', $this->userInfo->code)
                    ->endSubQuery(), false
            )
            ->where( "'{$nowDate}' between gc.gift_start_date and gc.gift_end_date", '', false)
            ->exec()->getResultArray();

        return $datas;
    }

    /***
     * @return string
     * 랜덤 쿠폰 발행 프로세스
     */
    public function randomCouponIssue($gc_ix){

        $return = array();

        //쿠폰 존재 여부 체크
        if($this->getRandomCouponInfo($gc_ix)){
            $nowDate = date('Y-m-d');

            //지급 가능 쿠폰 중 1개의 쿠폰 랜덤 획득 처리
            $this->qb->setDatabase('payment');
            $couponData = $this->qb
                ->select('gc.gift_certificate_name')
                ->select('gc.gc_ix')
                ->select('gcd.gcd_ix')
                ->select('gcd.gift_type')
                ->select('gcd.gift_value')
                ->from(TBL_SHOP_GIFT_RANDOM_CERTIFICATE .' as gc')
                ->join(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL .' as gcd' ,'gc.gc_ix = gcd.gc_ix','left')
                ->where('gcd.status','Y')
                ->where('gc.is_use','1')
                ->where('gcd.gift_change_state','0')
                ->whereNotIn('gc.gc_ix',
                    $this->qb
                        ->startSubQuery()
                        ->select('gc_ix')
                        ->from(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL)
                        ->where('user_code', $this->userInfo->code)
                        ->endSubQuery(), false
                )
                ->whereNotIn('gcd.gcd_ix',
                    $this->qb
                        ->startSubQuery()
                        ->select('sgcd.gcd_ix')
                        ->from(TBL_SHOP_CUPON_REGIST .' as cr')
                        ->join(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL .' as sgcd','cr.publish_ix = sgcd.gift_value','left')
                        ->where('sgcd.gift_type' ,'C')
                        ->where('cr.mem_ix', $this->userInfo->code)
                        ->endSubQuery(), false
                )
                ->where( "'{$nowDate}' between gc.gift_start_date and gc.gift_end_date", '', false)
                ->orderBy('gcd.gcd_ix','RANDOM')
                ->limit(1)->exec()->getRowArray();

            if(isset($couponData)) {
                //업데이트 시 중복 등록이 될 수 있으니 insert log 테이블을 추가 함
                $this->qb
                    ->insert(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_ISSUE_LOG)
                    ->set('gc_ix',$couponData['gc_ix'])
                    ->set('gcd_ix',$couponData['gcd_ix'])
                    ->set('user_code',$this->userInfo->code)
                    ->set('regdate',date('Y-m-d H:i:s'))
                    ->exec();

                //획득한 쿠폰 사용 상태 업데이트 처리
                $this->qb
                    ->set('gift_change_state', '1')
                    ->set('user_code', $this->userInfo->code)
                    ->set('member_id', $this->userInfo->id)
                    ->set('member_ip', $this->input->server("REMOTE_ADDR"))
                    ->set('use_date', date('Y-m-d H:i:s'))
                    ->update(TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL . ' as gcd')
                    ->where('gcd.status', 'Y')
                    ->where('gcd.gift_change_state', '0')
                    ->where('gcd.gcd_ix', $couponData['gcd_ix'])
                    ->exec();

                //획득한 쿠폰에 따른 마일리지 또는 쿠폰 지급 처리
                if ($couponData['gift_type'] == 'C') {
                    $giveCoupon = $this->giveCoupon($couponData['gift_value']);
                    if($giveCoupon == 'success'){
                        $return['success'] = true;
                    }else{
                        $return['success'] = false;
                        $return['fail_code'] = 'giveCoupon';
                    }

                } else if ($couponData['gift_type'] == 'M') {
                    /* @var $mileageModel CustomMallMileageModel */
                    $mileageModel = $this->import('model.mall.mileage');
                    $msg = $couponData['gift_certificate_name'] . ' 당첨에 따른 적립';
                    $mileageModel->addMileage($couponData['gift_value'], 7, $msg);
                    $return['success'] = true;
                }
            }else{
                $return['success'] = false;
                $return['fail_code'] = 'notCoupon';
            }
        }else{
            $return['success'] = false;
            $return['fail_code'] = 'notCoupon';
        }

        return $return;
    }

    /**
     * 쿠폰 할인 금액 계산
     * @param type $paymentPrice
     * @param type $couponData
     * @return type
     */
    protected function calculationDiscount($paymentPrice, $couponData)
    {
        $paymentPrice = f_decimal($paymentPrice);
        $registIx = $couponData['regist_ix'];
        $publishName = $couponData['publish_name'];
        $cuponSaleType = $couponData['cupon_sale_type'];
        $cuponAcnt = $couponData['cupon_acnt'];
        $cuponSaleValue = f_decimal($couponData['cupon_sale_value']);
        $haddofficeRate = f_decimal($couponData['haddoffice_rate']);
        $sellerRate = f_decimal($couponData['seller_rate']);
        $roundPosition = $couponData['round_position'];
        $roundType = $couponData['round_type'];
        $publishMax = $couponData['publish_max'];
        $publishLimitPrice = f_decimal($couponData['publish_limit_price']);

        //할인부담
        if ($cuponAcnt == '1') {//본사
            $haddofficeRate = $cuponSaleValue;
            $sellerRate = 0;
        }

        if ($cuponSaleType == '1') { //정률
            $discountAmount = $paymentPrice * $cuponSaleValue / 100;
            $headofficeDiscountAmount = $paymentPrice * $haddofficeRate / 100;

            if ($roundPosition > 0) {
                $pow = pow(10, $roundPosition);
                switch ($roundType) {
                    case '3'://내림
                        $discountAmount = floor($discountAmount / $pow) * $pow;
                        $headofficeDiscountAmount = floor($headofficeDiscountAmount / $pow) * $pow;
                        break;
                    case '4'; //올림
                        $discountAmount = ceil($discountAmount / $pow) * $pow;
                        $headofficeDiscountAmount = ceil($headofficeDiscountAmount / $pow) * $pow;
                        break;
                    default ://반올림
                        $discountAmount = round($discountAmount / $pow) * $pow;
                        $headofficeDiscountAmount = round($headofficeDiscountAmount / $pow) * $pow;
                }
                $discountAmount = f_decimal($discountAmount);
                $headofficeDiscountAmount = f_decimal($headofficeDiscountAmount);
            } else {
                $places = $roundPosition * -1;
                switch ($roundType) {
                    case '3'://내림
                        $discountAmount = $discountAmount->round($places, $discountAmount::ROUND_FLOOR);
                        $headofficeDiscountAmount = $headofficeDiscountAmount->round($places, $headofficeDiscountAmount::ROUND_FLOOR);
                        break;
                    case '4'; //올림
                        $discountAmount = $discountAmount->round($places, $discountAmount::ROUND_CEILING);
                        $headofficeDiscountAmount = $headofficeDiscountAmount->round($places, $headofficeDiscountAmount::ROUND_CEILING);
                        break;
                    default ://반올림
                        $discountAmount = $discountAmount->round($places);
                        $headofficeDiscountAmount = $headofficeDiscountAmount->round($places);
                        break;
                }
            }
            $sellerDiscountAmount = $discountAmount - $headofficeDiscountAmount;
        } else if($cuponSaleType == '2')  { //정액
            $discountAmount = $cuponSaleValue;
            $headofficeDiscountAmount = $haddofficeRate;
            $sellerDiscountAmount = $sellerRate;
        } else if($cuponSaleType == '3'){ //전액
            $discountAmount = $paymentPrice;
            $headofficeDiscountAmount = $haddofficeRate;
            $sellerDiscountAmount = $sellerRate;
        }

        //최대 할인금액
        if ($publishMax == 'Y' && $publishLimitPrice > 0 && $discountAmount > $publishLimitPrice) {
            $headofficeDiscountAmount = ($headofficeDiscountAmount * $publishLimitPrice / $discountAmount)->round((defined('BCSCALE') ? BCSCALE : 0));
            $discountAmount = $publishLimitPrice;
            $sellerDiscountAmount = $discountAmount - $headofficeDiscountAmount;
        }

        return [
            'sale_type' => $cuponSaleType
            , 'sale_value' => $cuponSaleValue
            , 'headoffice_sale_value' => $haddofficeRate
            , 'seller_sale_value' => $sellerRate
            , 'code' => $registIx
            , 'commission' => 0
            , 'description' => $publishName
            , 'discount_amount' => $discountAmount
            , 'headoffice_discount_amount' => $headofficeDiscountAmount
            , 'seller_discount_amount' => $sellerDiscountAmount
        ];
    }

    /**
     * 회원이 보유중인 쿠폰 수
     * @param string $useYn : true(사용한 & 기한만료된 쿠폰) or false(미사용한 쿠폰)
     * @return int
     */
    public function getCouponCnt($useYn = false, $couponDiv = [])
    {
        $ret = 0;

        if ($this->isUseCoupon()) {
            if(is_array($couponDiv) && count($couponDiv) > 0){
                $this->qb->whereIn('c.cupon_div',$couponDiv);
            }

            $this->qb
                ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
                ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix = cp.publish_ix')
                ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix = cp.cupon_ix')
                ->where('cr.mem_ix', $this->userCode)
                ->whereIn('cp.mall_ix', ['', MALL_IX])
                ->whereIn('c.cupon_use_div', ['A', $this->agentType]);

            if ($useYn) { //사용완료 & 기한만료된 쿠폰
                $this->setBasicUseWhere($useYn);
            } else { //사용가능 쿠폰
                $this->setBasicUseWhere($useYn);
            }
            $ret = $this->qb->getCount();
        }

        return $ret;
    }

    /**
     * 쿠폰 복구
     * @param string $oid
     * @param string $status
     * @param array $odIxs shop_order_detail 키값
     * @param array $odeIxs shop_order_detail_discount 키값
     * @return type
     */
    public function returnUsedCoupon($oid, $status, $odIxs = [], $odeIxs = [])
    {
        //관리자 쿠폰설정에서 N이 복원함 이었음. 그래서 프론트가 N으로 설정되었지만, 관리자 로직에서는  Y가 복원함으로 조건이 엇갈려서 Y로 통일 한다
        switch ($status) { //상태에 따라 복구가능 시점 다름. 관리자 설정 참조.
            case ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE :
                $restoreConfig = $this->config['restore_cc1'];
                break;
            case ORDER_STATUS_CANCEL_COMPLETE :
                $restoreConfig = $this->config['restore_cc2'];
                break;
            case ORDER_STATUS_RETURN_COMPLETE :
                $restoreConfig = $this->config['restore_bf'];
                break;
            default :
                $restoreConfig = 'Y';
                break;
        }

        if ($restoreConfig == 'Y') {
            //할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
            $this->qb
                ->select('cr.regist_ix')
                ->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as odd')
                ->join(TBL_SHOP_CUPON_REGIST . ' as cr', 'odd.dc_ix=cr.regist_ix', 'left')
                ->whereIn('odd.dc_type', ['CP','DCP'])
                ->where('odd.oid', $oid);

            if (!empty($odIxs)) {
                $this->qb->whereIn('odd.od_ix', $odIxs);
            }
            if (!empty($odeIxs)) {
                $this->qb->whereIn('odd.ode_ix', $odeIxs);
            }

            $usedLists = $this->qb->exec()->getResultArray();
            $usedLists = array_column($usedLists, 'regist_ix');

            if (!empty($usedLists)) {
                $this->qb
                    ->set('use_yn', 0)
                    ->set('use_oid', '')
                    ->set('use_pid', '')
                    ->set('usedate', '')
                    ->whereIn('regist_ix', $usedLists)
                    ->where('mem_ix', $this->userCode)
                    ->update(TBL_SHOP_CUPON_REGIST)
                    ->exec();
            }
        }
        return;
    }
}
