<?php

/**
 * Description of ForbizMallCartModel
 *
 * @author hong
 */
class ForbizMallCartModel extends ForbizModel
{
    /**
     * 회원 비회원 여부 (member or nonMmber)
     * @var string
     */
    protected $userType;

    /**
     * 회원 고유 키 (member: user.code, nonMember:session_id)
     * @var string
     */
    protected $userKey;

    /**
     * 도소매 구분 (R:소매, W:도매)
     * @var string
     */
    protected $sellingType;

    public function __construct()
    {
        parent::__construct();

        //로그인 여부에 따라 기본 set
        if (is_login()) {
            $this->setUser('member', sess_val('user', 'code'));
            $this->setSellingType(sess_val('user', 'selling_type'));
        } else {
            $this->setUser('nonMmber', session_id());
            $this->setSellingType('R');
        }
    }

    /**
     * set 회원 타입, 키
     * @param string $userType
     * @param string $userKey
     * @return $this
     */
    public function setUser($userType, $userKey)
    {
        $this->userType = $userType;
        $this->userKey  = $userKey;
        return $this;
    }

    /**
     * set 도소매 구분
     * @param string $sellingType
     * @return $this
     */
    public function setSellingType($sellingType)
    {
        $this->sellingType = strtoupper($sellingType);
        return $this;
    }

    /**
     * get 도소매 구분
     * @return string
     */
    public function getSellingType()
    {
        return $this->sellingType;
    }

    /**
     * 추가
     * $datas[] = [
     *  'pid' => '상품ID', 'optionId' => '선택옵션ID', 'count' => '수량'
     *  , 'addOptionList'[] => ['optionId' => '추가구성ID', 'count' => '추가구성수량']
     * ]
     * @param array $datas
     * @return array 추가된 cart_ix
     */
    public function add($datas)
    {
        $addCartIxs = [];
        if (is_array($datas)) {
            foreach ($datas as $data) {

                //선택 옵션일 경우 , 구분으로 여러게 넘어 오기 때문에 값 정렬처리!
                $optionText = "";
                if (!empty($data['optionId'])) {
                    $optionIds = [];
                    $optionIds = explode(",", $data['optionId']);
                    if (count($optionIds) > 1) {
                        sort($optionIds, SORT_NUMERIC);
                        $data['optionId'] = implode(",", $optionIds);
                    }

                    $optionText = $this->getProductOptionText($data['optionId']);
                } else {
                    //옵션 필수
                    continue;
                }

                //장바구니
                $cart = $this->userWhere()
                        ->select('cart_ix')
                        ->from(TBL_SHOP_CART.' as c')
                        ->where('id', $data['pid'])
                        ->where('select_option_id', $data['optionId'])
                        ->exec()->getRow();

                if (empty($cart->cart_ix)) {
                    /* @var $collectModel CustomMallCollectModel */
                    $collectModel = $this->import('model.mall.collect');

                    //추가
                    $this->userSet()
                        ->set('id', $data['pid'])
                        ->set('pcount', $data['count'])
                        ->set('select_option_id', $data['optionId'])
                        ->set('options_text', $optionText)
                        ->set('regdate', date('Y-m-d H:i:s'))
                        ->set('hash_idx', $collectModel->setPid($data['pid'])->getHash())
                        ->insert(TBL_SHOP_CART)
                        ->exec();

                    $cartIx = $this->qb->getInsertId();
                } else {
                    //수정
                    $cartIx = $cart->cart_ix;
                    $this->userWhere()
                        ->set('pcount', $data['count'])
                        ->set('options_text', $optionText)
                        ->where('cart_ix', $cartIx)
                        ->update(TBL_SHOP_CART.' as c')
                        ->exec();
                }

                $addCartIxs[] = $cartIx;

                //장바구니 추가구성상품
                if (isset($data['addOptionList']) && is_array($data['addOptionList'])) {
                    foreach ($data['addOptionList'] as $addOption) {

                        $cartAddOption = $this->qb
                                ->select('cart_option_ix')
                                ->from(TBL_SHOP_CART_OPTIONS)
                                ->where('cart_ix', $cartIx)
                                ->where('opn_d_ix', $addOption['optionId'])
                                ->exec()->getRow();

                        $addOptionText = $this->getProductOptionText($addOption['optionId']);

                        if (empty($cartAddOption->cart_option_ix)) {
                            //등록
                            $this->qb
                                ->set('cart_ix', $cartIx)
                                ->set('opn_count', $addOption['count'])
                                ->set('opn_d_ix', $addOption['optionId'])
                                ->set('opn_text', $addOptionText)
                                ->set('regdate', date('Y-m-d H:i:s'))
                                ->insert(TBL_SHOP_CART_OPTIONS)
                                ->exec();
                        } else {
                            //수정
                            $this->qb
                                ->set('opn_count', 'opn_count + '.$addOption['count'], false)
                                ->set('opn_text', $addOptionText)
                                ->where('cart_option_ix', $cartAddOption->cart_option_ix)
                                ->update(TBL_SHOP_CART_OPTIONS)
                                ->exec();
                        }
                    }
                }
            }
        }
        return $addCartIxs;
    }

    /**
     * 정보 조회
     * API로 바로 데이터 구조 호출 X (노출되면 안되는 정보도 있기 때문에)
     * @param array $cartIxs
     * @param string $zipCode
     * @param array $useCoupon
     * @return array
     */
    public function get($cartIxs = [], $zipCode = '', $useCoupon = [])
    {
        //배송 업체별 리스트
        $cartData = $this->getGroupByDeliveryCompany($cartIxs);

        if (!empty($cartData)) {

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');
            /* @var $mileageModel CustomMallMileageModel */
            $mileageModel = $this->import('model.mall.mileage');
            /* @var $couponModel CustomMallCouponModel */
            $couponModel  = $this->import('model.mall.coupon');

            if (!is_array($useCoupon)) {
                $useCoupon = [];
            }

            //상품 추가 정보 select column
            $addProductColumn = [
                'p.admin'
                , 'p.surtax_yorn'
                , "IF(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' AND p.sell_priod_edate >= '".date('Y:m:d H:i:s')."', true) AS isSellBool"
            ];
            if ($this->sellingType == 'W') {
                $addProductColumn = array_merge($addProductColumn,
                    ['p.wholesale_reserve_yn as reserve_yn', 'p.wholesale_rate_type as rate_type', 'p.wholesale_reserve_rate as reserve_rate']);
            } else {
                $addProductColumn = array_merge($addProductColumn, ['p.reserve_yn', 'p.rate_type', 'p.reserve_rate']);
            }

            //업체 Loop start
            foreach ($cartData as $cartDataKey => $data) {
                $companySumProductListprice   = f_decimal(0);
                $companySumProductDcprice     = f_decimal(0);
                $companySumTotalDeliveryPrice = f_decimal(0);
                $companySumDeliveryPrice      = f_decimal(0);
                $companySumDeliveryAddPrice   = f_decimal(0);

                //배송정책 Loop start
                foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {

                    //상품 정보 가지고 오기
                    $productList = $productModel->getListById(array_column($deliveryTemplate['productList'], 'id'), 'm', $addProductColumn);

                    $deliverySumProductListprice         = f_decimal(0);
                    $deliverySumProductDcprice           = f_decimal(0);
                    $deliverySumProductCouponWithDcprice = f_decimal(0);
                    $deliverySumProductQty               = 0;

                    //상품 Loop start
                    foreach ($deliveryTemplate['productList'] as $key => $list) {
                        $product = array_merge($list, $productList[array_search($list['id'], array_column($productList, 'id'))]);

                        //옵션 정보로 가격 변경
                        $product['add_price'] = 0;
                        if (!empty($product['select_option_id'])) {
                            $option = $productModel->getOption($product['id'], 'row', $product['select_option_id']);

                            //옵션이 삭제되었거나 변경되었을때 예외처리
                            if ($product['select_option_id'] != $option['option_id']) {
                                $product['status'] = 'stop';
                            }

                            $product['option_kind']     = $option['option_kind'];
                            $product['listprice']       = $option['option_listprice'];
                            $product['sellprice']       = $option['option_sellprice'];
                            $product['dcprice']         = $option['option_dcprice'];
                            $product['add_price']       = $option['option_add_price'];
                            $product['discount_amount'] = $option['option_discount_amount'];
                            $product['discount_rate']   = $option['option_discount_rate'];
                            $product['discountList']    = $option['optionDiscountList'];

                            $product['stock'] = $option['option_stock'];
                        }

                        //재고를 체크하여 상품 판매 상태 변경
                        if ($product['status'] == 'sale' && !($product['stock'] > 0)) {
                            $product['status'] = 'soldout';
                        }

                        if (!$product['isSellBool']) {
                            $product['status'] = 'stop';
                        }

                        //할인 정보 * 수량 처리
                        $product['discount_amount'] = $product['discount_amount'] * $product['pcount'];
                        foreach ($product['discountList'] as $discountKey => $discount) {
                            if (isset($discount['discount_amount'])) {
                                $discount['discount_amount'] = $discount['discount_amount'] * $product['pcount'];
                            }
                            if (isset($discount['headoffice_discount_amount'])) {
                                $discount['headoffice_discount_amount'] = $discount['headoffice_discount_amount'] * $product['pcount'];
                            }
                            if (isset($discount['seller_discount_amount'])) {
                                $discount['seller_discount_amount'] = $discount['seller_discount_amount'] * $product['pcount'];
                            }
                            $product['discountList'][$discountKey] = $discount;
                        }

                        $product['total_listprice'] = $product['listprice'] * $product['pcount'];
                        $product['total_dcprice']   = $product['dcprice'] * $product['pcount'];

                        //추가 구성 상품 Loop start
                        foreach ($product['addOptionList'] as $addOptionKey => $addOption) {
                            $option                       = $productModel->getOption($product['id'], 'row', $addOption['opn_d_ix']);
                            $addOption['listprice']       = $option['option_listprice'];
                            $addOption['sellprice']       = $option['option_sellprice'];
                            $addOption['dcprice']         = $option['option_dcprice'];
                            $addOption['total_listprice'] = $addOption['listprice'] * $addOption['opn_count'];
                            $addOption['total_dcprice']   = $addOption['dcprice'] * $addOption['opn_count'];

                            //추가 구성 상품 재고
                            $addOption['stock'] = $option['option_stock'];

                            //적립 마일리지 처리
                            $addOption['mileage'] = $mileageModel->getSaveMileage($product['reserve_yn'], $product['rate_type'],
                                $product['reserve_rate']
                                , $product['admin'], $addOption['total_listprice'], $addOption['total_dcprice'], $addOption['total_dcprice']);

                            $deliverySumProductListprice         += $addOption['total_dcprice'];
                            $deliverySumProductDcprice           += $addOption['total_dcprice'];
                            $deliverySumProductCouponWithDcprice += $addOption['total_dcprice'];
                            $deliverySumProductQty               += $addOption['opn_count'];

                            $product['addOptionList'][$addOptionKey] = $addOption;
                        }
                        //추가 구성 상품 Loop end
                        //쿠폰 사용 처리
                        $registIx = ($useCoupon[$product['cart_ix']] ?? 0);
                        if ($registIx > 0) {
                            $couponData = $couponModel->applyProductCoupon($registIx, $product['id'], $product['dcprice'], $product['total_dcprice']);
                            if ($couponData === false) {
                                $totalCouponWithDcprice = $product['total_dcprice'];
                            } else {
                                $couponData['type']     = 'CP';
                                $couponData['title']    = ForbizConfig::getDiscount('CP');
                                array_push($product['discountList'], $couponData);
                                $totalCouponWithDcprice = $product['total_dcprice'] - $couponData['discount_amount'];
                            }
                        } else {
                            $totalCouponWithDcprice = $product['total_dcprice'];
                        }
                        //쿠폰할인 포함된 가격
                        $product['total_coupon_with_dcprice'] = $totalCouponWithDcprice;

                        //적립 마일리지 처리
                        $product['mileage'] = $mileageModel->getSaveMileage($product['reserve_yn'], $product['rate_type'],
                            $product['reserve_rate']
                            , $product['admin'], $product['total_listprice'], $product['total_dcprice'], $product['total_coupon_with_dcprice']);

                        if ($product['status'] == 'sale') {
                            $deliverySumProductListprice         += $product['total_listprice'];
                            $deliverySumProductDcprice           += $product['total_dcprice'];
                            $deliverySumProductCouponWithDcprice += $product['total_coupon_with_dcprice'];
                            $deliverySumProductQty               += $product['pcount'];
                        }

                        $deliveryTemplate['productList'][$key] = $product;
                    }
                    //상품 Loop end
                    //배송비
                    //쇼핑몰정보설정 > 배송비 부과 정책
                    $deliveryWithCouponConfig = ForbizConfig::getMallConfig('delivery_with_coupon');
                    if ($deliveryWithCouponConfig == 'Y') {
                        $targetDeliveryPrice = $deliverySumProductCouponWithDcprice;
                    } else {
                        $targetDeliveryPrice = $deliverySumProductDcprice;
                    }
                    $deliveryInfo                             = $this->getDeliveryInfo($deliveryTemplate['dt_ix'],
                        ['price' => $targetDeliveryPrice, 'qty' => $deliverySumProductQty], $zipCode);
                    $deliveryTemplate['total_delivery_price'] = $deliveryInfo['sumPrice'];
                    $deliveryTemplate['delivery_price']       = $deliveryInfo['price'];
                    $deliveryTemplate['delivery_add_price']   = $deliveryInfo['addPrice'];
                    $deliveryTemplate['delivery_text']        = $deliveryInfo['text'].(!empty($deliveryInfo['regionText']) ? " (".$deliveryInfo['regionText'].")"
                            : "");

                    $data['deliveryTemplateList'][$deliveryTemplateKey] = $deliveryTemplate;

                    //업체별 금액 합산을 위한 계산
                    $companySumProductListprice   += $deliverySumProductListprice;
                    $companySumProductDcprice     += $deliverySumProductCouponWithDcprice;
                    $companySumTotalDeliveryPrice += $deliveryTemplate['total_delivery_price'];
                    $companySumDeliveryPrice      += $deliveryTemplate['delivery_price'];
                    $companySumDeliveryAddPrice   += $deliveryTemplate['delivery_add_price'];
                }
                //배송정책 Loop end

                $data['product_listprice']       = $companySumProductListprice;
                $data['product_dcprice']         = $companySumProductDcprice;
                $data['product_discount_amount'] = $data['product_listprice'] - $data['product_dcprice'];
                $data['total_delivery_price']    = $companySumTotalDeliveryPrice;
                $data['delivery_price']          = $companySumDeliveryPrice;
                $data['delivery_add_price']      = $companySumDeliveryAddPrice;
                $data['payment_price']           = $data['product_dcprice'] + $data['total_delivery_price'];
                $cartData[$cartDataKey]          = $data;
            }
            //업체 Loop end
        }
        return $cartData;
    }

    /**
     * 집계 정보
     * getCart 리턴된 데이터로 집계에 필요한 정보로 리턴
     * 업체별 companySummary 와 전체합계 summary return
     * @param array $cartData
     * @return array
     */
    public function getSummary($cartData)
    {
        $companySummary = [];
        $summary = [
            'product_listprice' => f_decimal(0)
            , 'product_dcprice' => f_decimal(0)
            , 'product_discount_amount' => f_decimal(0)
            , 'total_delivery_price' => f_decimal(0)
            , 'delivery_price' => f_decimal(0)
            , 'delivery_add_price' => f_decimal(0)
            , 'payment_price' => f_decimal(0)
            , 'tax_price' => f_decimal(0)
            , 'tax_free_price' => f_decimal(0)
            , 'mileage' => f_decimal(0)
            , 'productDiscountList' => []
        ];

        foreach ($cartData as $company) {
            $companySummary[] = [
                'company_id' => $company['company_id']
                , 'product_listprice' => $company['product_listprice']
                , 'product_dcprice' => $company['product_dcprice']
                , 'product_discount_amount' => $company['product_discount_amount']
                , 'total_delivery_price' => $company['total_delivery_price']
                , 'delivery_price' => $company['delivery_price']
                , 'delivery_add_price' => $company['delivery_add_price']
                , 'payment_price' => $company['payment_price']
            ];

            $summary['product_listprice']       += $company['product_listprice'];
            $summary['product_dcprice']         += $company['product_dcprice'];
            $summary['product_discount_amount'] += $company['product_discount_amount'];
            $summary['total_delivery_price']    += $company['total_delivery_price'];
            $summary['delivery_price']          += $company['delivery_price'];
            $summary['delivery_add_price']      += $company['delivery_add_price'];
            $summary['payment_price']           += $company['payment_price'];

            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                $summary['tax_price'] += $deliveryTemplate['total_delivery_price'];
                foreach ($deliveryTemplate['productList'] as $product) {
                    $summary['mileage'] += $product['mileage'];
                    if ($product['surtax_yorn'] == 'Y') {
                        $summary['tax_free_price'] += $product['total_coupon_with_dcprice'];
                    } else {
                        $summary['tax_price'] += $product['total_coupon_with_dcprice'];
                    }
                    foreach ($product['addOptionList'] as $addOption) {
                        $summary['mileage']   += $addOption['mileage'];
                        $summary['tax_price'] += $addOption['total_dcprice'];
                    }
                    foreach ($product['discountList'] as $discount) {
                        $index = array_search($discount['type'], array_column($summary['productDiscountList'], 'type'));
                        if ($index === false) {
                            $summary['productDiscountList'][] = [
                                'type' => $discount['type']
                                , 'title' => $discount['title']
                                , 'discount_amount' => $discount['discount_amount']
                            ];
                        } else {
                            $summary['productDiscountList'][$index]['discount_amount'] += $discount['discount_amount'];
                        }
                    }
                }
            }
        }

        return ['companySummary' => $companySummary, 'summary' => $summary];
    }

    /**
     * 삭제
     * @param array $cartIxs
     */
    public function delete($cartIxs)
    {
        if (!empty($cartIxs)) {
            $rows = $this->userWhere()
                    ->select('cart_ix')
                    ->from(TBL_SHOP_CART.' as c')
                    ->whereIn('cart_ix', $cartIxs)
                    ->exec()->getResultArray();

            if (!empty($rows)) {
                $deleteCartIxs = [];
                foreach ($rows as $row) {
                    $deleteCartIxs[] = $row['cart_ix'];
                }

                $this->qb->delete(TBL_SHOP_CART)->whereIn('cart_ix', $deleteCartIxs)->exec();
                $this->qb->delete(TBL_SHOP_CART_OPTIONS)->whereIn('cart_ix', $deleteCartIxs)->exec();
            }
        }
    }

    /**
     * 옵션(추가구성상품) 삭제
     * @param array $cartOptionIxs
     */
    public function deleteOption($cartOptionIxs = [])
    {
        $rows = $this->userWhere()
                ->select('co.cart_option_ix')
                ->from(TBL_SHOP_CART.' as c')
                ->join(TBL_SHOP_CART_OPTIONS.' as co', 'c.cart_ix=co.cart_ix')
                ->whereIn('co.cart_option_ix', $cartOptionIxs)
                ->exec()->getResultArray();

        if (!empty($rows)) {
            $deleteCartOptionIxs = [];
            foreach ($rows as $row) {
                $deleteCartOptionIxs[] = $row['cart_option_ix'];
            }

            $this->qb->delete(TBL_SHOP_CART_OPTIONS)->whereIn('cart_option_ix', $deleteCartOptionIxs)->exec();
        }
    }

    /**
     * 수량 수정
     * @param int $cartIx
     * @param int $count
     */
    public function updateCountNew($cartIx, $count, $optVal, $optionText)
    {
        $this->userWhere()
            ->set('pcount', $count)
            ->set('select_option_id', $optVal)
            ->set('options_text', $optionText)
            ->where('cart_ix', $cartIx)
            ->update(TBL_SHOP_CART.' as c')
            ->exec();
    }

    /**
     * 수량 수정
     * @param int $cartIx
     * @param int $count
     */
    public function updateCount($cartIx, $count)
    {
        $this->userWhere()
            ->set('pcount', $count)
            ->where('cart_ix', $cartIx)
            ->update(TBL_SHOP_CART.' as c')
            ->exec();
    }

    /**
     * 옵션(추가구성상품) 수량 수정
     * @param int $cartOptionIx
     * @param int $count
     */
    public function updateOptionCount($cartOptionIx, $count)
    {
        $row = $this->userWhere()
                ->select('c.cart_ix')
                ->from(TBL_SHOP_CART.' as c')
                ->join(TBL_SHOP_CART_OPTIONS.' as co', 'c.cart_ix=co.cart_ix')
                ->where('co.cart_option_ix', $cartOptionIx)
                ->exec()->getRowArray();

        if (!empty($row)) {
            $this->qb
                ->update(TBL_SHOP_CART_OPTIONS)
                ->set('opn_count', $count)
                ->where('cart_ix', $row['cart_ix'])
                ->where('cart_option_ix', $cartOptionIx)
                ->exec();
        }
    }

    /**
     * get 하나의 상품정보
     * @param int $cartIx
     * @return array
     */
    public function getProductRow($cartIx)
    {
        $cart = $this->get((is_array($cartIx) ? $cartIx : [$cartIx]));

        if (isset($cart[0])) {
            unset($cart[0]['deliveryTemplateList'][0]['productList'][0]['addOptionList']);
            return $cart[0]['deliveryTemplateList'][0]['productList'][0];
        } else {
            return [];
        }
    }

    /**
     * get 하나의 옵션(추가구성상품) 정보
     * @param int $cartOptionIx
     * @return array
     */
    public function getOptionRow($cartOptionIx)
    {
        $row = $this->qb
                ->select('c.id')
                ->select('co.opn_d_ix')
                ->from(TBL_SHOP_CART.' as c')
                ->join(TBL_SHOP_CART_OPTIONS.' as co', 'c.cart_ix=co.cart_ix', 'left')
                ->where('co.cart_option_ix', $cartOptionIx)
                ->exec()->getRowArray();


        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');
        return $productModel->getOption($row['id'], 'row', $row['opn_d_ix']);
    }

    /**
     * 회원 타입에 따른 update 지정
     * @return qb
     */
    protected function userSet()
    {
        if ($this->userType == 'member') {
            $this->qb->set('mem_ix', $this->userKey);
        } else {
            $this->qb->set('cart_key', $this->userKey);
        }
        return $this->qb;
    }

    /**
     * 회원 타입에 따른 where 지정
     * @return qb
     */
    protected function userWhere()
    {
        if ($this->userType == 'member') {
            $this->qb->where('c.mem_ix', $this->userKey);
        } else {
            $this->qb->where('c.cart_key', $this->userKey);
        }
        return $this->qb;
    }

    /**
     * get 업체-배송정책-상품-옵션(추가구성상품)별 정보
     * get 함수의 기본 뼈대 정보 리턴
     * @param array $cartIxs
     * @return array
     */
    protected function getGroupByDeliveryCompany($cartIxs)
    {
        //장바구니 정보 및 배송정책 조회
        $this->userWhere()
            ->select('c.cart_ix')
            ->select('c.id')
            ->select('c.select_option_id')
            ->select('c.options_text')
            ->select('c.pcount')
            ->select('pd.dt_ix')
            ->select('c.hash_idx')
            ->from(TBL_SHOP_CART.' as c')
            ->join(TBL_SHOP_PRODUCT_DELIVERY.' as pd', 'c.id = pd.pid')
            ->where('pd.is_wholesale', $this->sellingType)
            ->orderBy('c.regdate', 'DESC');

        if (!empty($cartIxs)) {
            $this->qb->whereIn('c.cart_ix', $cartIxs);
        }

        $list = $this->qb
                ->exec()->getResultArray(); //리턴은 array로

        if (empty($list)) {
            return [];
        }

        //templetList = [ dt_ix => [ cart_ix, id, select_option_id, pcount, options_text ] ];
        $templetList = [];
        $cartIxs     = [];
        foreach ($list as $li) {
            if (empty($templetList[$li['dt_ix']])) {
                $templetList[$li['dt_ix']] = [];
            }
            //혹시 모르는 중복 값이 있을 수 있음
            if (array_search($li['cart_ix'], array_column($templetList[$li['dt_ix']], 'cart_ix')) === false) {
                $templetList[$li['dt_ix']][] = [
                    'cart_ix' => $li['cart_ix']
                    , 'id' => $li['id']
                    , 'select_option_id' => $li['select_option_id']
                    , 'pcount' => $li['pcount']
                    , 'options_text' => $li['options_text']
                    , 'hash_idx' => $li['hash_idx']
                ];

                $cartIxs[] = $li['cart_ix'];
            }
        }
        unset($list);

        //추가 구성 상품 조회
        $cartAddOption = $this->qb
                ->select('cart_option_ix')
                ->select('cart_ix')
                ->select('opn_d_ix')
                ->select('opn_count')
                ->select('opn_text')
                ->from(TBL_SHOP_CART_OPTIONS)
                ->whereIn('cart_ix', $cartIxs)
                ->exec()->getResultArray();

        //cartAddOptionList = [ cart_ix => [ cart_option_ix, opn_d_ix, opn_count, opn_text ] ];
        $cartAddOptionList = [];
        foreach ($cartAddOption as $cao) {
            $cartAddOptionList[$cao['cart_ix']][] = [
                'cart_option_ix' => $cao['cart_option_ix']
                , 'opn_d_ix' => $cao['opn_d_ix']
                , 'opn_count' => $cao['opn_count']
                , 'opn_text' => $cao['opn_text']
            ];

            $cartIxs[] = $li['cart_ix'];
        }

        //묶음 배송 처리
        $deliveryGroup = $this->getDeliveryGroup(array_keys($templetList));

        //묶음 배송을 사용하는 dt_ix 는 target_dt_ix 로 변경
        foreach ($deliveryGroup as $dg) {
            $templetList[$dg['target_dt_ix']] = array_merge(($templetList[$dg['target_dt_ix']] ?? []), $templetList[$dg['dt_ix']]);
            unset($templetList[$dg['dt_ix']]);
        }
        unset($deliveryGroup);

        //업체 별 조회
        $list = $this->qb
                ->select('cd.company_id')
                ->select('cd.com_name')
                ->select('dt.dt_ix')
                ->select('dt.delivery_region_use')
                ->select('dt.delivery_region_area')
                ->select('dt.delivery_jeju_price')
                ->select('dt.delivery_except_price')
                ->from(TBL_SHOP_DELIVERY_TEMPLATE.' as dt')
                ->join(TBL_COMMON_COMPANY_DETAIL.' as cd', 'dt.company_id = cd.company_id')
                ->whereIn('dt.dt_ix', array_keys($templetList))
                ->exec()->getResultArray();

        if (empty($list)) {
            return [];
        }

        //deliveryCompanyList = [ company_id => [ com_name, dt_ix=[] ] ];
        $deliveryCompanyList = [];
        foreach ($list as $li) {
            if (empty($deliveryCompanyList[$li['company_id']])) {
                $deliveryCompanyList[$li['company_id']]['com_name'] = $li['com_name'];
                $deliveryCompanyList[$li['company_id']]['dt_ix']    = [];
            }
            //혹시 모르는 중복 값이 있을 수 있음
            if (!in_array($li['dt_ix'], $deliveryCompanyList[$li['company_id']]['dt_ix'])) {
                $deliveryCompanyList[$li['company_id']]['dt_ix'][] = [
                    'dt_ix' => $li['dt_ix']
                    , 'delivery_region_use' => $li['delivery_region_use']
                    , 'delivery_region_area' => $li['delivery_region_area']
                    , 'delivery_jeju_price' => $li['delivery_jeju_price']
                    , 'delivery_except_price' => $li['delivery_except_price']
                ];
            }
        }

        //최종 결과 데이터 만들기
        $result = [];
        foreach ($deliveryCompanyList as $companyId => $deliveryCompany) {

            $deliveryTemplateList = [];
            foreach ($deliveryCompany['dt_ix'] as $key => $dtData) {
                $dtIx = $dtData['dt_ix'];

                foreach ($templetList[$dtIx] as $templetKey => $templet) {
                    if (!empty($cartAddOptionList[$templet['cart_ix']])) {
                        $templetList[$dtIx][$templetKey]['addOptionList'] = $cartAddOptionList[$templet['cart_ix']];
                    } else {
                        $templetList[$dtIx][$templetKey]['addOptionList'] = array();
                    }
                }

                $deliveryTemplateList[$key]['dt_ix']                 = $dtIx;
                $deliveryTemplateList[$key]['delivery_region_use']   = $dtData['delivery_region_use'];
                $deliveryTemplateList[$key]['delivery_region_area']  = $dtData['delivery_region_area'];
                $deliveryTemplateList[$key]['delivery_jeju_price']   = $dtData['delivery_jeju_price'];
                $deliveryTemplateList[$key]['delivery_except_price'] = $dtData['delivery_except_price'];
                $deliveryTemplateList[$key]['productList']           = $templetList[$dtIx];
            }

            $result[] = [
                'company_id' => $companyId
                , 'com_name' => $deliveryCompany['com_name']
                , 'deliveryTemplateList' => $deliveryTemplateList
            ];
        }

        return $result;
    }

    /**
     * get 옵션명
     * @param int $optionDetailId
     * @return string
     */
    protected function getProductOptionText($optionDetailId)
    {
        echo "A : ".$optionDetailId;
        exit;
        $optionDetailIds = explode(",", $optionDetailId);

        $list = $this->qb
                ->select('pod.option_div')
                ->select('po.option_name')
                ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL.' as pod')
                ->join(TBL_SHOP_PRODUCT_OPTIONS.' as po', 'pod.opn_ix = po.opn_ix')
                ->whereIn('pod.id', $optionDetailIds)
                ->exec()->getResultArray();

        $optionText = [];
        foreach ($list as $li) {
            $optionText[] = $li['option_name'].":".$li['option_div'];
        }

        return implode(", ", $optionText);
    }

    /**
     * 배송비 정보
     * @param int $dtIx
     * @param array $productData
     * @param string $zipCode
     * @return array
     */
    public function getDeliveryInfo($dtIx, $productData = [], $zipCode = '')
    {
        if (!is_array($productData)) {
            $productData = [];
        }
        $productPrice = f_decimal($productData['price'] ?? 0);
        $productQty   = ($productData['qty'] ?? 1);

        $deliveryPrice    = f_decimal(0);
        $addDeliveryPrice = f_decimal(0);
        $conditionText    = "";
        $regionText       = "";

        // 네이버페이 전용
        $qtyPrice = [];
        $feePrice = 0;


        $template = $this->qb
                ->select('delivery_policy')
                ->select('delivery_price')
                ->select('delivery_cnt_price')
                ->select('free_shipping_term')
                ->select('delivery_unit_price')
                ->select('delivery_region_use')
                ->select('delivery_region_area')
                ->select('delivery_jeju_price')
                ->select('delivery_except_price')
                ->select('delivery_region_use')
                ->select('company_id')
                ->select('delivery_policy_text_m')
                ->select('delivery_policy_text')
                ->select('tekbae_ix')
                ->from(TBL_SHOP_DELIVERY_TEMPLATE)
                ->where('dt_ix', $dtIx)
                ->exec()->getRowArray();

        switch ($template['delivery_policy']) {
            //무료배송
            case '1':
                $conditionText = "무료배송";
                break;
            //고정 배송비
            case '2':
                $deliveryPrice = f_decimal($template['delivery_price']);
                $conditionText = "배송비 ".g_price($deliveryPrice)."원";
                break;
            //결제금액당 배송비
            case '3':
            //수량별 할인/할증적용(상품단위)
            case '4':
                $this->qb
                    ->select('delivery_price')
                    ->select('delivery_basic_terms')
                    ->from(TBL_SHOP_DELIVERY_TERMS)
                    ->where('dt_ix', $dtIx)
                    ->where('delivery_policy_type', $template['delivery_policy']);

                $basicDeliveryPrice     = 0;
                $conditionDeliveryPrice = false;
                switch ($template['delivery_policy']) {
                    //결제금액당 배송비
                    case '3':
                        $row = $this->qb
                                ->exec()->getRowArray();
                        if (!empty($row)) {
                            if ($row['delivery_basic_terms'] > $productPrice && $conditionDeliveryPrice === false) {
                                $conditionDeliveryPrice = $row['delivery_price'];
                            }
                            $conditionText = g_price($row['delivery_basic_terms'])."원 이상 구매 시 무료배송";
                            // 네이버페이 전요
                            $conditionFree = $row['delivery_basic_terms'];
                            $feePrice      = $row['delivery_price'];
                        }
                        break;
                    //수량별 할인/할증적용(상품단위)
                    case '4':
                        $basicDeliveryPrice = $template['delivery_cnt_price'];

                        $rows = $this->qb
                                ->orderBy('delivery_basic_terms', 'desc')
                                ->exec()->getResultArray();

                        if (!empty($rows)) {
                            $conditionTextList = [];
                            foreach ($rows as $key => $row) {
                                if ($row['delivery_basic_terms'] <= $productQty && $conditionDeliveryPrice === false) {
                                    $conditionDeliveryPrice = $row['delivery_price'];
                                }
                                $conditionTextList[] = number_format($row['delivery_basic_terms'])."개 이상 ".g_price($row['delivery_price'])."원";
                                // 네이버 페이 추가
                                $qtyPrice[]          = [
                                    'qty' => $row['delivery_basic_terms']
                                    , 'price' => $row['delivery_price']
                                ];
                            }
                            $conditionText = "기본 배송비 ".g_price($basicDeliveryPrice)."원 / ".implode(", ", $conditionTextList);
                        }
                        break;
                }
                $deliveryPrice = f_decimal($conditionDeliveryPrice !== false ? $conditionDeliveryPrice : $basicDeliveryPrice);
                break;
            //상품 1개단위 배송비
            case '6':
                $deliveryPrice = f_decimal($template['delivery_unit_price'] * $productQty);
                $conditionText = "1개당 배송비 ".g_price($template['delivery_unit_price'])."원";
                break;
            default :
                break;
        }


        //추가 배송비
        if ($template['delivery_region_use'] == '1') {

            if ($template['delivery_region_area'] == '2') {
                $regionText = "제주 및 도서산간 ".g_price($template['delivery_jeju_price'])."원 추가";
            } else if ($template['delivery_region_area'] == '3') {
                $regionText = "제주 ".g_price($template['delivery_jeju_price'])."원 / 제주 외 도서산간 ".g_price($template['delivery_except_price'])."원 추가";
            }

            if (!empty($zipCode)) {
                $region = $this->qb
                        ->select('jeju_yn')
                        ->select('island_yn')
                        ->from(TBL_SHOP_DELIVERY_AREA)
                        ->where('zip', $zipCode)
                        ->exec()->getRowArray();

                if (!empty($region)) {
                    //2권역
                    if ($template['delivery_region_area'] == '2') {
                        $addDeliveryPrice = f_decimal(!empty($template['delivery_jeju_price']) ? $template['delivery_jeju_price'] : 0);
                    }
                    //3권역
                    else if ($template['delivery_region_area'] == '3') {
                        if ($region['jeju_yn'] == 'Y') {
                            $addDeliveryPrice = f_decimal(!empty($template['delivery_jeju_price']) ? $template['delivery_jeju_price'] : 0);
                        } else {
                            $addDeliveryPrice = f_decimal(!empty($template['delivery_except_price']) ? $template['delivery_except_price'] : 0);
                        }
                    }
                }
            }
        }

        //교환/반품안내
        if (is_mobile()) {
            $deliveryClaimText = $template['delivery_policy_text_m'];
        } else {
            $deliveryClaimText = $template['delivery_policy_text'];
        }

        //택배사명
        $deliveryCompany = $this->qb
                ->select('c.code_name')
                ->from(TBL_SHOP_DELIVERY_TEMPLATE.' as t')
                ->join(TBL_SHOP_CODE.' as c', 't.tekbae_ix=c.code_ix', 'inner')
                ->where('t.dt_ix', $dtIx)
                ->where('c.code_gubun', '02')
                ->exec()->getRowArray();

        return ['sumPrice' => ($deliveryPrice + $addDeliveryPrice)
            , 'price' => $deliveryPrice
            , 'addPrice' => $addDeliveryPrice
            , 'text' => $conditionText
            , 'regionText' => $regionText
            , 'deliveryPolicy' => $template['delivery_policy']
            , 'deliveryRegionUse' => $template['delivery_region_use']
            , 'deliveryClaimText' => $deliveryClaimText
            , 'deliveryComCode' => $template['tekbae_ix']
            , 'deliveryComName' => $deliveryCompany['code_name']
            , 'company_id' => $template['company_id']
            // 네이버페이 추가 항목
            , 'conditionDeliveryPrice' => ($conditionDeliveryPrice ?? '')
            , 'delivery_region_area' => $template['delivery_region_area']
            , 'regionPrice2' => $template['delivery_jeju_price']
            , 'regionPrice3' => $template['delivery_except_price']
            , 'feePrice' => $feePrice
            , 'conditionFree' => ($conditionFree ?? '')
            , 'qtyPrice' => $qtyPrice
            , 'qtyBasicPrice' => ($basicDeliveryPrice ?? '')
        ];
    }

    /**
     * 카트에 담긴 상품수
     *
     * @return int 카트에 담긴 상품수
     */
    public function cartCnt()
    {
        return $this->userWhere()
                ->from(TBL_SHOP_CART.' AS c')
                ->join(TBL_SHOP_PRODUCT.' AS p', 'c.id = p.id')
                ->getCount();
    }

    /**
     * 묶음그룹 배송 사용시. 상품상세에서도 사용.
     * @param array $dtIxs
     * @return array
     */
    public function getDeliveryGroup($dtIxs)
    {
        return $this->qb
                ->select('target.dt_ix as target_dt_ix')
                ->select('dr.dt_ix')
                ->from(TBL_SHOP_DELIVERY_RELATION.' as target')
                ->join(TBL_SHOP_DELIVERY_GROUP.' as dg', 'target.g_ix = dg.g_ix')
                ->join(TBL_SHOP_DELIVERY_RELATION.' as dr', 'dg.g_ix = dr.g_ix')
                ->where('target.rep', 'Y')
                ->where('target.dt_ix !=', 'dr.dt_ix', false)
                ->where('dg.state', '1')
                ->whereIn('dr.dt_ix', $dtIxs)
                ->exec()->getResultArray();
    }

    /**
     * 카트에 담긴 상품 리스트
     * @param type $userCode 회원코드
     * @param type $cur_page 현재 페이지
     * @param type $per_page 페이지당 라인수
     * @param type $is_paging 페이징 여부
     */
    public function getCartProductList($userCode, $cur_page = 1, $per_page = 10, $is_paging = true)
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $this->qb->startCache();
        $productModel->basicWhere()
            ->from(TBL_SHOP_PRODUCT.' as p')
            ->join(TBL_SHOP_CART.' as c', 'c.id = p.id')
            ->where('c.mem_ix', $userCode)
            ->stopCache();

        if ($is_paging) {
            // Get total rows
            $total = $this->qb->getCount('distinct c.id');

            // Get paging data
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit  = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit  = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        $list = [];
        if ($total > 0) {
            $ids = $this->qb
                ->distinct()
                ->select('c.id')
                ->orderBy('c.regdate', 'desc')
                ->limit($limit, $offset)
                ->exec()
                ->getResultArray();
        }

        $this->qb->flushCache();

        if ($total > 0) {
            $list = $productModel->getListById(array_column($ids, 'id'));
        }

        return [
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 장바구니 데이터중 판매중이 아닌 상품 체크
     * @param $cartData
     * @return bool
     */
    public function checkAllProductStatusSale($cartData)
    {
        foreach ($cartData as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $product) {
                    if ($product['status'] == 'sale' && ($product['stock']- $product['pcount']) < 0) {
                        $product['status'] = 'soldout';
                    }

                    if ($product['status'] != 'sale') {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}