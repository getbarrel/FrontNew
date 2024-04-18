<?php

/**
 * CustomMallOrderModel
 * @author hoksi
 */
class CustomMallOrderModel extends ForbizMallOrderModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 주문 구매자 정보 입력
     * @param type $oid
     * @param type $data
     */
    public function insertOrder($oid, $data)
    {
        $this->qb
            ->set('oid', $oid)
            ->set('order_pw', encrypt_user_password($data['order_pw'] ?? ''))
            ->set('buyer_type', ($data['buyer_type'] ?? ''))
            ->set('user_code', ($data['user_code'] ?? ''))
            ->set('user_com_id', ($data['user_com_id'] ?? ''))
            ->set('com_name', ($data['com_name'] ?? ''))
            ->set('buserid', ($data['buserid'] ?? ''))
            ->set('bname', ($data['bname'] ?? ''))
            ->set('sex', ($data['sex'] ?? ''))
            ->set('age', ($data['age'] ?? ''))
            ->set('gp_ix', ($data['gp_ix'] ?? ''))
            ->set('mem_group', ($data['mem_group'] ?? ''))
            ->set('btel', ($data['btel'] ?? ''))
            ->set('bmobile', ($data['bmobile'] ?? ''))
            ->set('bmail', ($data['bmail'] ?? ''))
            ->set('bzip', ($data['bzip'] ?? ''))
            ->set('baddr', ($data['baddr'] ?? ''))
            ->set('order_date', date('Y-m-d H:i:s'))
            ->set('mem_reg_date', ($data['mem_reg_date'] ?? ''))
            ->set('static_date', date('Ymd'))
            ->set('status', ORDER_STATUS_SETTLE_READY)
            ->set('org_delivery_price', ($data['org_delivery_price'] ?? ''))
            ->set('delivery_price', ($data['delivery_price'] ?? ''))
            ->set('org_product_price', ($data['org_product_price'] ?? ''))
            ->set('product_price', ($data['product_price'] ?? ''))
            ->set('total_price', ($data['total_price'] ?? ''))
            ->set('payment_price', ($data['payment_price'] ?? ''))
            ->set('user_ip', ($data['user_ip'] ?? ''))
            ->set('user_agent', ($data['user_agent'] ?? ''))
            ->set('choice_gift_order', ($data['choice_gift_order'] ?? ''))
            ->set('choice_gift_order_c', ($data['choice_gift_order_c'] ?? ''))
            ->set('choice_gift_order_p', ($data['choice_gift_order_p'] ?? ''))
            ->set('payment_agent_type', ($data['payment_agent_type'] ?? 'W'))
            ->set('escrow_yn', ($data['escrow_yn'] ?? 'N'))
            ->insert(TBL_SHOP_ORDER)
            ->exec();
    }

    /**
     * 주문 상품 정보 입력
     * @param string $mall_ix
     * @param string $oid
     * @param int $pid
     * @param int $ode_ix
     * @param int $odd_ix
     * @param array $data
     * @return int
     */
    public function insertOrderProduct($mall_ix, $oid, $pid, $ode_ix, $odd_ix, $data)
    {
        if (!empty($pid)) {
            $product = $this->qb
                ->select('r.cid')
                ->select('p.id')
                ->select('p.brand')
                ->select('p.brand_name')
                ->select('p.pcode')
                ->select('p.barcode')
                ->select('p.product_type')
                ->select('p.pname')
                ->select('p.preface')
                ->select('p.add_info')
                ->select('p.trade_admin')
                ->select('IFNULL(t.com_name,"") as trade_company_name')
                ->select('p.stock_use_yn')
                ->select('p.coprice')
                ->select('(case p.one_commission when "Y" then p.account_type else s.account_type end) as account_type')
                ->select('s.account_info')
                ->select('s.ac_delivery_type')
                ->select('s.ac_expect_date')
                ->select('s.account_method')
                ->select('IFNULL((case when p.md_code!="" then p.md_code else sd.md_code end),"") as md_code')
                ->select('p.admin as company_id')
                ->select('c.com_name as company_name')
                ->select('c.com_phone as com_phone')
                ->select('p.one_commission as one_commission')
                ->select('(case p.one_commission when "Y" then p.commission else s.commission end) as commission')
                ->select('(case p.one_commission when "Y" then p.wholesale_commission else s.wholesale_commission end) as wholesale_commission')
                ->select('p.surtax_yorn')
                ->select('p.exchangeable_yn')
                ->select('p.returnable_yn')
                ->select('p.delivery_type')
                ->from(TBL_SHOP_PRODUCT . ' as p')
                ->join(TBL_SHOP_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'left')
                ->join(TBL_COMMON_COMPANY_DETAIL . ' as t', 'p.trade_admin=t.company_id', 'left')
                ->join(TBL_COMMON_COMPANY_DETAIL . ' as c', 'p.admin=c.company_id', 'left')
                ->join(TBL_COMMON_SELLER_DELIVERY . ' as s', 'p.admin=s.company_id', 'left')
                ->join(TBL_COMMON_SELLER_DETAIL . ' as sd', 'p.admin=sd.company_id', 'left')
                ->where('p.id', $pid)
                ->orderBy("(CASE `r`.`basic` WHEN '1' THEN 1 ELSE 0 END)", 'desc')
                ->exec()
                ->getRow();
        }

        $buyer_type = ($data['buyer_type'] ?? '1');

        $option_kind = ($data['option_kind'] ?? '');
        $option_id = ($data['option_id'] ?? '');
        //조합&독립옵션이 아닐경우
        if (!empty($option_kind) && !empty($option_id) && !in_array($option_kind, ["c1", "i1"])) {
            $option = $this->qb
                ->select('od.option_gid')
                ->select('od.option_code')
                ->select('od.option_coprice')
                ->select('od.option_etc1') // 구성수량
                ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as od')
                ->where('od.id', $option_id)
                ->exec()
                ->getRow();
        }

        // 구성수량
        $option_etc1 = intval($option->option_etc1 ?? '1');
        $option_etc1 = $option_etc1 > 0 ? $option_etc1 : 1;
        // 옵션 원가
        $option_coprice = ($option->option_coprice ?? false);

        $stock_use_yn = ($product->stock_use_yn ?? $data['stock_use_yn']);
        if ($stock_use_yn == 'Y') {
            $gid = ($option->option_gid ?? $data['gid']);
            $gu_ix = ($option->option_code ?? $data['gu_ix']);
        } else {
            $gid = "";
            $gu_ix = "";
        }

        if (isset($data['commission'])) {
            $one_commission = $data['one_commission'];
            $commission = $data['commission'];
            $commission_msg = $data['commission_msg'];
        } else {
            $one_commission = $product->one_commission;
            if ($buyer_type == '2') {
                $commission = $product->wholesale_commission;
            } else {
                $commission = $product->commission;
            }
            if ($one_commission == 'Y') {
                $commission_msg = "product";
            } else if (isset($data['special_discount_yn']) && $data['special_discount_yn'] == 'Y') {
                $commission = $data['special_discount_commission'];
                $commission_msg = "special";
            } else {
                $commission_msg = "seller";
            }
        }

        // 주문상세 정보 기록
        $this->qb
            ->set('mall_ix', $mall_ix)
            ->set('oid', $oid)
            ->set('rfid', ($data['rfid'] ?? ''))
            ->set('kwid', ($data['kwid'] ?? ''))
            ->set('mpr_ix', ($data['mpr_ix'] ?? ''))
            ->set('event_ix', ($data['event_ix'] ?? ''))
            ->set('buyer_type', $buyer_type)
            ->set('order_from', ($data['order_from'] ?? 'self'))
            ->set('cid', ($product->cid ?? $data['cid']))
            ->set('pid', ($product->id ?? $pid))
            ->set('brand_code', ($product->brand ?? $data['brand_code']))
            ->set('brand_name', ($product->brand_name ?? $data['brand_name']))
            ->set('pcode', ($product->pcode ?? $data['pcode']))
            ->set('barcode', ($product->barcode ?? $data['barcode']))
            ->set('product_type', ($product->product_type ?? $data['product_type']))
            ->set('set_group', $data['set_group']) //세트상품 설정
            ->set('set_name', $data['set_name']) //세트상품명
            ->set('pname', ($product->pname ?? $data['pname']))
            ->set('preface', ($product->preface ?? ''))
            ->set('add_info', ($product->add_info ?? ''))
            ->set('trade_company', ($product->trade_admin ?? $data['trade_admin']))
            ->set('trade_company_name', ($product->trade_company_name ?? $data['trade_company_name']))
            ->set('stock_use_yn', $stock_use_yn)
            ->set('gid', $gid)
            ->set('gu_ix', $gu_ix)
            ->set('option_id', $option_id)
            ->set('option_text', ($data['option_text'] ?? ''))
            ->set('option_kind', $option_kind)
            ->set('option_price', ($data['option_price'] ?? 0)) // 코디상품인 경우 옵션가격 추가 안함
            ->set('pcnt', $data['pcnt'])
            ->set('coprice', ($option_coprice ? $option_coprice : ($product->coprice ?? $data['coprice']))) //원가
            ->set('listprice', ($data['listprice'] / $option_etc1)) //정가
            ->set('psprice', ($data['psprice'] / $option_etc1)) //판매가
            ->set('dcprice', ($data['dcprice'] / $option_etc1)) //할인가(단가)
            ->set('ptprice', $data['ptprice']) //최종가격 = (상품가+옵션가)*수량
            ->set('pt_dcprice', $data['pt_dcprice']) //최종할인상품가격
            ->set('reserve', $data['reserve']) //적립될적립금액
            ->set('msgbyproduct', $data['msgbyproduct'])
            ->set('status', ORDER_STATUS_SETTLE_READY)
            ->set('ode_ix', $ode_ix)
            ->set('odd_ix', $odd_ix)
            ->set('account_type', ($product->account_type ?? $data['account_type']))
            ->set('account_info', ($product->account_info ?? $data['account_info']))
            ->set('delivery_type',($product->delivery_type ?? '1'))
            ->set('ac_delivery_type', ($product->ac_delivery_type ?? $data['ac_delivery_type']))
            ->set('ac_expect_date', ($product->ac_expect_date ?? $data['ac_expect_date']))
            ->set('account_method', ($product->account_method ?? $data['account_method']))
            ->set('md_code', ($product->md_code ?? $data['md_code']))
            ->set('company_id', ($product->company_id ?? $data['company_id']))
            ->set('company_name', ($product->company_name ?? $data['company_name']))
            ->set('com_phone', ($product->com_phone ?? $data['com_phone']))
            ->set('one_commission', $one_commission)
            ->set('commission', $commission)
            ->set('commission_msg', $commission_msg)
            ->set('surtax_yorn', ($product->surtax_yorn ?? $data['surtax_yorn']))
            ->set('cart_ix', $data['cart_ix'])
            ->set('parent_od_ix', ($data['parent_od_ix'] ?? null))
            ->set('gift_type', ($data['gift_type'] ?? null))
            ->set('gift_condition', ($data['gift_condition'] ?? null))
            ->set('hash_idx', ($data['hash_idx'] ?? ''))
            ->set('exchangeable_yn', ($product->exchangeable_yn ?? 'Y'))
            ->set('returnable_yn', ($product->returnable_yn ?? 'Y'))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->set('choice_gift_prd', ($data['choice_gift_prd'] ?? ''))
            ->insert(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        // odIx 조회
        $od_ix = $this->qb->getInsertId();

        return $od_ix;
    }

    /**
     * 상품별 사은품 주문 내역 조회
     * @param string $parent_od_ix
     * @param string $sizeType
     * @return array
     */
    public function getProductGiftOrder($parent_od_ix, $sizeType = 's')
    {
        $rows = $this->qb
            ->select('od_ix')
            ->select('pid')
            ->select('pname')
            ->select('pcnt')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('parent_od_ix', $parent_od_ix)
            ->where('gift_type', 'G') // 상품별 사은품 지정
            ->exec()
            ->getResultArray();

        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $data[] = [
                    'pid' => $row['pid']
                    //, 'image_src' => get_product_images_src($row['pid'], true, $sizeType)
                    , 'image_src' => get_product_images_new_src($row['pid'])
                    , 'pname' => $row['pname']
                    , 'pcnt' => $row['pcnt']
                    , 'od_ix' => $row['od_ix']
                ];
            }
        }

        return $data;
    }

    /**
     * 주문 카운트 조회
     * @param string $oid
     * @param array $odIxs
     * @return array
     */
    public function chkAllOrderCnt($oid, $odIxs)
    {
        $rows = $this->qb
            ->select('od_ix')
            ->select('pcnt')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid')
            ->whereIn('gift_type', ['N'])
            ->whereIn('status', [ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_BUY_FINALIZED])
            ->exec()
            ->getResultArray();

        $allCancel = true;

        if (!empty($rows)) {
            foreach ($rows as $row) {
                if (!isset($odIxs[$row['od_ix']]) && $row['pcnt'] != $odIxs[$row['od_ix']]) {
                    $allCancel = false;
                    break;
                }
            }
        }

        $freeGift = [];

        if ($allCancel) {
            $rows = $this->getFreeGiftOrder($oid);
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $freeGift[$row['od_ix']] = $row['pcnt'];
                }
            }
        }

        return $freeGift;
    }

    /**
     * 구매금액별 사은품 조회
     * @param string $oid
     * @return array
     */
    public function getFreeGiftOrder($oid, $sizeType = 's', $claimGroup = '')
    {
        if ($claimGroup != '') {
            $this->qb->whereIn('claim_group', $claimGroup);
        }

        $rows = $this->qb
            ->select('od_ix')
            ->select('pid')
            ->select('pname')
            ->select('pcnt')
            ->select('gift_condition')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('gift_type', 'P') // 구매금액별 사은품 지정
            ->exec()
            ->getResultArray();

        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $data[] = [
                    'pid' => $row['pid']
                    , 'image_src' => get_product_images_new_src($row['pid'], true, $sizeType)
                    , 'pname' => $row['pname']
                    , 'od_ix' => $row['od_ix']
                    , 'pcnt' => $row['pcnt']
                    , 'gift_condition' => $row['gift_condition']
                ];
            }
        }

        return $data;
    }

    public function getFreeGiftOrderNew($oid,$giftCondition, $sizeType = 's', $claimGroup = ''){

        switch($giftCondition){
            case 'C':
                $freegift_condition_text = "특정 카테고리 사은품";
                break;
            case 'P':
                $freegift_condition_text = "이벤트 제품 구매시 금액별 사은품";
                break;
            case 'G':
                $freegift_condition_text = "구매 금액별 사은품";
                break;

        }

        if ($claimGroup != '') {
            $this->qb->whereIn('claim_group', $claimGroup);
        }

        $rows = $this->qb
            ->select('od_ix')
            ->select('pid')
            ->select('pname')
            ->select('pcnt')
            ->select('gift_condition')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('gift_type', 'P') // 구매금액별 사은품 지정
            ->where('gift_condition', $giftCondition) // 사은품타입 지정
            ->exec()
            ->getResultArray();

        $data = [];
        if (!empty($rows)) {

            $data['freegift_condition_text'] = $freegift_condition_text;
            foreach ($rows as $row) {
                $data['gift_products'][] = [
                    'pid' => $row['pid']
                    , 'image_src' => get_product_images_new_src($row['pid'], true, $sizeType)
                    , 'pname' => $row['pname']
                    , 'od_ix' => $row['od_ix']
                    , 'pcnt' => $row['pcnt']
                    , 'gift_condition' => $row['gift_condition']
                ];
            }
        }

        return $data;
    }

    /**
     * 배송정책별 주문상세 내역 조회
     * @param string $oid 주문번호
     * @param array $od_ix 주문상세ID
     * @param array $etcs
     * @param int $exchange : .교환으로 신규 생성된 주문인지 확인
     * @return type
     */
    public function getGroupByDeliveryOrderDetail($oid, $od_ix = [], $etcs = [], $exchange = 0)
    {

        $this->qb->startCache();
        $this->qb
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('gift_type', 'N') // 사은품 제외
            ->where('status !=', ORDER_STATUS_SETTLE_READY);
        $this->qb->stopCache();

        if ($exchange == 0) {
            $this->qb->where('claim_delivery_od_ix', 0);
        }

        if (!empty($od_ix)) {
            $this->qb->whereIn('od_ix', (is_array($od_ix) ? $od_ix : [$od_ix]));
        }

        if (!empty($etcs)) {
            foreach ($etcs as $k => $v) {
                $this->qb->whereIn($k, $v);
            }
        }

        $rows = $this->qb
                ->select('brand_name')
                ->select('pid')
                ->select('CONVERT(pid, signed integer) as co_no', false)
                ->select('pname')
                ->select('pcnt')
                ->select('listprice') // 정가(단가)
                ->select('psprice') // 판매가(단가)
                ->select('dcprice') // 할인가(단가)
                ->select('ptprice', false) // 최종가격 = (상품가+옵션가)*수량
                ->select('pt_dcprice') // 최종할인상품가격
                ->select('listprice * pcnt AS pt_listprice', false) // 정가 * 수량
                ->select('if((listprice - dcprice) > 0, (listprice - dcprice), 0) * pcnt AS calc_dcprice', false) // 즉시할인금액 = (정가(단가) - 할인가(단가)) * 수량
                ->select('if((listprice - psprice) > 0, (listprice - psprice), 0) * pcnt as dr_dc', false) // 즉시할인가
                ->select('if(((listprice + option_price) * pcnt - pt_dcprice) > 0, ((listprice + option_price) * pcnt - pt_dcprice), 0) as pt_calc_dcprice', false) // 총 할인금액
                ->select('reserve')
                ->select('option_text')
                ->select('set_group')
                ->select('claim_group')
                ->select('ic_date')
                ->select('dc_date')
                ->select('ra_date')
                ->select('fc_date')
                ->select('status')
                ->select('refund_status')
                ->select('ode_ix')
                ->select('odd_ix')
                ->select('option_kind')
                ->select('quick')
                ->select('invoice_no')
                ->select('add_info')
                ->select($this->qb->startSubQuery('dt_ix')
                    ->select('dt_ix')
                    ->from(TBL_SHOP_ORDER_DELIVERY)
                    ->where('ode_ix', TBL_SHOP_ORDER_DETAIL . '.ode_ix', false)
                    ->endSubQuery(), false
                )
                ->select($this->qb
                    ->startSubQuery('is_comment')
                    ->select('bbs_ix')
                    ->from(TBL_SHOP_PRODUCT_AFTER . ' AS pa')
                    ->where('pa.oid = ' . TBL_SHOP_ORDER_DETAIL . '.oid', null, false)
                    ->where('pa.pid = ' . TBL_SHOP_ORDER_DETAIL . '.pid', null, false)
                    ->limit(1)
                    ->endSubQuery(), false
                )
                ->select('od_ix')
                ->select('surtax_yorn')
                ->exec()->getResultArray();
        $this->qb->flushCache();

        $data = [];
        if (!empty($rows)) {
            // 세트 상품 변환
            $rows = $this->cvtOrderSetDetail($rows);

            // 할인정보 조회
            $od_ixs = [];
            foreach ($rows as $row) {
                if (isset($row['setData'])) {
                    $od_ixs = array_merge($od_ixs, array_column($row['setData'], 'od_ix'));
                } else {
                    $od_ixs[] = $row['od_ix'];
                }
            }
            $dcInfo = $this->getProductDiscountInfo($oid, $od_ixs);

            for ($i = 0; $i < count($rows); $i++) {

                $row = $rows[$i];

                // 세트,코디 상품 할인가격
                if (isset($row['setData'])) {
                    $dc = [];
                    foreach ($row['setData'] as $sItem) {
                        if (isset($dcInfo[$sItem['od_ix']])) {
                            foreach ($dcInfo[$sItem['od_ix']] as $dItem) {
                                if (isset($dc[$dItem['dc_type']])) {
                                    $dc[$dItem['dc_type']] += $dItem['dc_price'];
                                } else {
                                    $dc[$dItem['dc_type']] = $dItem['dc_price'];
                                }
                            }
                        }
                    }
                } else {
                    // 일반 상품 할인가격
                    if (isset($dcInfo[$row['od_ix']])) {
                        if (is_array($dcInfo[$row['od_ix']])) {
                            $dc = [];
                            foreach ($dcInfo[$row['od_ix']] as $dItem) {
                                if ($dItem['dc_type'] == 'CP') {
                                    if (isset($dc[$dItem['dc_type']])) {
                                        $dc[$dItem['dc_type']] += $dItem['dc_price'];
                                    } else {
                                        $dc[$dItem['dc_type']] = $dItem['dc_price'];
                                    }
                                } else {
                                    $dc[$dItem['dc_type']] = $dItem['dc_price'];
                                }
                            }
                        } else {
                            $dc = array_column($dcInfo[$row['od_ix']], 'dc_price', 'dc_type');
                        }
                    } else {
                        $dc = [];
                    }
                }

                // 데이타 리뉴얼
                //$row['pimg'] = get_product_images_src($row['pid'], is_adult());
                $row['pimg'] = get_product_images_new_src($row['pid']);
                $row['status_text'] = ForbizConfig::getOrderStatus($row['status']);
                $row['refund_status_text'] = ForbizConfig::getOrderStatus($row['refund_status']);
                $row['cp_dc'] = $dc['CP'] ?? 0; // 쿠폰 할인금액
                $row['dcp_dc'] = $dc['DCP'] ?? 0; // 배송비쿠폰 할인금액
                $row['mg_dc'] = $dc['MG'] ?? 0; // 회원 할인금액
                $row['gp_dc'] = $dc['GP'] ?? 0; // 기획 할인금액
                $row['sp_dc'] = $dc['SP'] ?? 0; // 특별 할인금액
                $row['total_dc'] = $row['pt_calc_dcprice']; // 총 할인금액
                $row['product_gift'] = $this->getProductGiftOrder($row['od_ix']);


                // 모바일은 주문 상세에서도 개별 주문 상태변경 가능. PC는 주문리스트에서만 가능함.
                if (is_mobile()) {
                    $row['isIncomeComplate'] = false;
                    $row['isDeliveryIng'] = false;
                    $row['isDeliveryComplate'] = false;
                    $row['isByFinalized'] = false;
                    $row['isClaimed'] = false;

                    if ($row['status'] == ORDER_STATUS_INCOM_COMPLETE) {
                        $row['isIncomeComplate'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_DELIVERY_ING) {
                        $row['isDeliveryIng'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_DELIVERY_COMPLETE) {
                        $row['isDeliveryComplate'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_BUY_FINALIZED) {
                        $row['isByFinalized'] = true;
                    }
                    if (!empty($row['refund_status'])) {
                        $row['isClaimed'] = true;
                    }
                }

                //배송 추적 유효기간 체크
                $row['tracking_expiration'] = false;
                if(isset($row['dc_date'])){
                    if(strtotime($row['dc_date'].' + 3month') < time()){
                        $row['tracking_expiration'] = true;
                    }
                }

                $data[$row['ode_ix']][$i] = $row;
            }
        }

        return $data;
    }

    /**
     * 주문 세트상품 변환
     * @param array $rows
     * @return array
     */
    protected function cvtOrderSetDetail($rows)
    {
        // 세트상품 데이타
        $setList = [];
        foreach ($rows as $row) {
            //세트,코디 상품?
            if ($row['set_group'] > 0) {
                if (!isset($setList[$row['set_group']])) {
                    $setList[$row['set_group']] = $row;

                    // 세트 구매 수량 조회
                    $buyCnt = $this->getOrderSetPcount($row['set_group']);
                    $setList[$row['set_group']]['pcnt'] = $buyCnt;

                    if ($row['option_kind'] == 'c') {
                        // 코디상품
                        $setList[$row['set_group']]['option_text'] = $row['option_text'];
                    } else {
                        // 세트상품
                        $opt_text = explode(':', $row['option_text']);
                        $setList[$row['set_group']]['option_text'] = $opt_text[0];

                        // 세트상품 정가 재 계산 , 확인 필요 
                        // *** $row['listprice'] =  (isset($row['listprice']) && $row['listprice'] > 0) ? $row['listprice'] * ($row['pcnt'] / $buyCnt) : 0;
                    }

                    $setList[$row['set_group']]['setData'] = [];

                    $setList[$row['set_group']]['listprice'] = $row['listprice'] ?? 0; // 정가(단가)
                    $setList[$row['set_group']]['psprice'] = $row['psprice'] ?? 0; // 판매가(단가)
                    $setList[$row['set_group']]['dcprice'] = $row['dcprice'] ?? 0; // 할인가(단가)
                    $setList[$row['set_group']]['ptprice'] = $row['ptprice'] ?? 0; // 최종가격 = (상품가+옵션가)*수량
                    $setList[$row['set_group']]['pt_dcprice'] = $row['pt_dcprice'] ?? 0;
                    $setList[$row['set_group']]['pt_listprice'] = $row['pt_listprice'] ?? 0;
                    $setList[$row['set_group']]['calc_dcprice'] = $row['calc_dcprice'] ?? 0;
                    $setList[$row['set_group']]['dr_dc'] = $row['dr_dc'] ?? 0;
                    $setList[$row['set_group']]['pt_calc_dcprice'] = $row['pt_calc_dcprice'] ?? 0;
                    $setList[$row['set_group']]['reserve'] = $row['reserve'] ?? 0;
                } else {
                    if ($row['option_kind'] == 'c') {
                        // 코디상품
                        $setList[$row['set_group']]['option_text'] .= (',' . $row['option_text']);
                    } else {
                        // 세트 구매 수량 조회
                        $buyCnt = $this->getOrderSetPcount($row['set_group']);

                        // 세트상품 정가 재 계산
                        $row['listprice'] = ((isset($row['listprice']) && $row['listprice'] > 0) ? ($row['listprice'] * ($row['pcnt'] / $buyCnt)) : 0);
                    }

                    $setList[$row['set_group']]['listprice'] += $row['listprice'] ?? 0;
                    $setList[$row['set_group']]['psprice'] += $row['psprice'] ?? 0;
                    $setList[$row['set_group']]['dcprice'] += $row['dcprice'] ?? 0;
                    $setList[$row['set_group']]['ptprice'] += $row['ptprice'] ?? 0;
                    $setList[$row['set_group']]['pt_dcprice'] += $row['pt_dcprice'] ?? 0;
                    $setList[$row['set_group']]['pt_listprice'] += $row['pt_listprice'] ?? 0;
                    $setList[$row['set_group']]['calc_dcprice'] += $row['calc_dcprice'] ?? 0;
                    $setList[$row['set_group']]['dr_dc'] += $row['dr_dc'] ?? 0;
                    $setList[$row['set_group']]['pt_calc_dcprice'] += $row['pt_calc_dcprice'] ?? 0;
                    $setList[$row['set_group']]['reserve'] += $row['reserve'] ?? 0;
                }

                $setList[$row['set_group']]['setData'][] = [
                    'option_text' => $row['option_text'],
                    'pcnt' => $row['pcnt'],
                    'od_ix' => $row['od_ix']
                ];
            }
        }

        $newList = [];
        $chkList = [];
        foreach ($rows as $row) {
            if (isset($setList[$row['set_group']])) {
                if (!isset($chkList[$row['set_group']])) {
                    $newList[] = $setList[$row['set_group']];
                    $chkList[$row['set_group']] = true;
                }
            } else {
                $newList[] = $row;
            }
        }

        return $newList;
    }

    /**
     * 주문세트 상품 수량 조회
     * @param int $shop_order_set_id
     * @return int
     */
    protected function getOrderSetPcount($shop_order_set_id)
    {
        $row = $this->qb
            ->select('pcount')
            ->from(TBL_SHOP_ORDER_SET)
            ->where('shop_order_set_id', $shop_order_set_id)
            ->exec()
            ->getRow();

        return isset($row->pcount) ? $row->pcount : 0;
    }

    /**
     * 주문 상품 정보 조회
     * @param array $oids
     * @param array $searchData
     * @param boolean $claimGroup
     * @return boolean
     */
    public function getOderDetailItems($oids, $searchData = [], $claimGroup = false)
    {
        $oids = is_array($oids) ? $oids : [$oids];

        // 주문상태 검색
        if (isset($searchData['status']) && $searchData['status']) {
            $this->qb->whereIn('status', (is_array($searchData['status']) ? $searchData['status'] : [$searchData['status']]));
        }

        // 상품명 검색
        if (isset($searchData['pname']) && $searchData['pname']) {
            $this->qb->like('pname', $searchData['pname']);
        }

        if ($claimGroup) {
            $this->qb
                ->select('claim_group')
                ->select("date_format(ea_date, '%Y-%m-%d') ea_date")
                ->select("date_format(ra_date, '%Y-%m-%d') ra_date")
                ->select("date_format(ca_date, '%Y-%m-%d') ca_date")
                ->select("date_format(cc_date, '%Y-%m-%d') cc_date")
                ->whereIn('claim_group', $claimGroup);
        }



        $rows = $this->qb
            ->select('oid')
            ->select('brand_name')
            ->select('pid')
            ->select('CONVERT(pid, signed integer) as co_no', false)
            ->select('pname')
            ->select('preface')
            ->select('add_info')
            ->select('option_text')
            ->select('pt_dcprice')
            ->select('dcprice')
            ->select('listprice')
            ->select('pcnt')
            ->select('status')
            ->select('refund_status')
            ->select('ode_ix')
            ->select('od_ix')
            ->select('invoice_no')
            ->select('quick')
            ->select('set_group')
            ->select('option_kind')
            ->select('exchangeable_yn')
            ->select('returnable_yn')
            ->select($this->qb
                ->startSubQuery('is_comment')
                ->select('bbs_ix')
                ->from(TBL_SHOP_PRODUCT_AFTER . ' AS pa')
                ->where('pa.oid = oid', null, false)
                ->where('pa.pid = pid', null, false)
                ->limit(1)
                ->endSubQuery()
            )
			->select($this->qb
                ->startSubQuery('is_method')
                ->select('method')
                ->from(TBL_SHOP_ORDER_PAYMENT . ' AS op')
                ->whereIn('oid', $oids)
                ->limit(1)
                ->endSubQuery()
            )
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('status !=', ORDER_STATUS_SETTLE_READY)
            ->whereIn('oid', $oids)
            ->where('claim_delivery_od_ix', 0)
            ->where('gift_type', 'N') // 사은품 제외
            ->orderBy('oid', 'desc')
            ->orderBy('set_group')
            ->orderBy('ode_ix')
            ->orderBy('pid')
            ->orderBy("(case option_kind when 'a' then 'ZZZZZZ' else option_kind end)", 'asc', false)
            ->exec()
            ->getResultArray();

        // 세트/코디 상품으로 변환
        $rows = $this->cvtOrderSetDetail($rows);

        $data = [];
        foreach ($rows as $k => $v) {
            $v['pimg'] = get_product_images_new_src($v['pid'], is_adult());
            $v['status_text'] = ForbizConfig::getOrderStatus($v['status']);
            $v['refund_status_text'] = ForbizConfig::getOrderStatus($v['refund_status']);
            $v['product_gift'] = $this->getProductGiftOrder($v['od_ix']);
			
			if(strpos($v["option_text"],':')) {
				$arrText = explode(":",$v["option_text"]);
				$v['option_text2'] = $arrText[1];
			}else{
				$v['option_text2'] = $v["option_text"];
			}
			

            // 취소/교환/반품 시 $claimGroup true
            if ($claimGroup) {
                $v['claim_date'] = $v['ea_date'];
                $v['claim_date'] = ($v['ra_date'] ? $v['ra_date'] : $v['claim_date']);
                $v['claim_date'] = ($v['ca_date'] ? $v['ca_date'] : $v['claim_date']);
                if ($v['status'] == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
                    $v['claim_date'] = $v['cc_date'];
                }
                $data[$v['oid']][$v['claim_group']][] = $v;
            } else {
                // 교환인 경우 교환 상품정보 가져오기
                switch ($v['status']) {
                    case ORDER_STATUS_EXCHANGE_ING:
                    case ORDER_STATUS_EXCHANGE_DELIVERY:
                    case ORDER_STATUS_EXCHANGE_ACCEPT:
                    case ORDER_STATUS_EXCHANGE_COMPLETE:
                        $v['exchageDetail'] = $this->getExchangeDetail($v['oid'], $v['od_ix'], ($v['setData'] ?? false));
                        break;
                    default:
                        $v['exchageDetail'] = false;
                        break;
                }

                $data[$v['oid']][] = $v;
            }
        }

        return $data;
    }

    /**
     * 교환 상품 주문 정보
     * @param string $oid
     * @param string $od_ix
     * @return array
     */
    public function getExchangeDetail($oid, $od_ix, $setData = false)
    {
        if (is_mobile()) {
            $imageSizeType = 'm';
        } else {
            $imageSizeType = 'b';
        }

        if (!empty($setData)) {
            $od_ix = array_column($setData, 'od_ix');
        } else {
            $od_ix = [$od_ix];
        }

        $rows = $this->qb
            ->select('oid')
            ->select('pid')
            ->select('is_adult')
            ->select('od.brand_name')
            ->select('od.pname')
            ->select('option_text')
            ->select('dcprice')
            ->select('od.listprice', false)
            ->select('pt_dcprice')
            ->select('pcnt')
            ->select('od.status')
            ->select('ode_ix')
            ->select('od_ix')
            ->select('invoice_no')
            ->select('quick')
            ->select('set_group')
            ->select('option_kind')
            ->select($this->qb
                ->startSubQuery('is_comment')
                ->select('bbs_ix')
                ->from(TBL_SHOP_PRODUCT_AFTER . ' AS pa')
                ->where('pa.oid = od.oid', null, false)
                ->where('pa.pid = od.pid', null, false)
                ->limit(1)
                ->endSubQuery()
            )
            ->from(TBL_SHOP_ORDER_DETAIL . ' as od')
            ->join(TBL_SHOP_PRODUCT . ' as p ', 'p.id=od.pid', 'inner')
            ->where('oid', $oid)
            ->whereIn('claim_delivery_od_ix', $od_ix)
            ->orderBy('ode_ix')
            ->orderBy('pid')
            ->orderBy("(case option_kind when 'a' then 'ZZZZZZ' else option_kind end)", 'asc', false)
            ->exec()
            ->getResultArray();

        // 세트/코디 상품으로 변환
        $rows = $this->cvtOrderSetDetail($rows);

        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $rows[$k]['status_text'] = ForbizConfig::getOrderStatus($v['status']);
                $rows[$k]['pimg'] = get_product_images_src($v['pid'], (sess_val('user', 'age') >= '19' ? true : false), $imageSizeType, $v['is_adult']);

                $rows[$k]['isDeliveryIng'] = false;
                if ($v['status'] == ORDER_STATUS_DELIVERY_ING) {
                    $rows[$k]['isDeliveryIng'] = true;
                }

                $rows[$k]['isDeliveryComplate'] = false;
                if ($v['status'] == ORDER_STATUS_DELIVERY_COMPLETE) {
                    $rows[$k]['isDeliveryComplate'] = true;
                }

                $rows[$k]['isByFinalized'] = false;
                if ($v['status'] == ORDER_STATUS_BUY_FINALIZED) {
                    $rows[$k]['isByFinalized'] = true;
                }
            }
        }

        return $rows;
    }

    /**
     *
     * @param string $oid 주문번호
     * @param array $odIx 주문상세 ['odix' => 1] 형식
     * @param int $cnt 구성수량
     * @return array
     */
    public function getSetGroup($oid, $odIx, $cnt = 0)
    {

        $setRows = [];
        $odIx = is_array($odIx) ? $odIx : [$odIx => $cnt];



        foreach ($odIx as $odIxKey => $odIxVal) {
            $row = $this->qb
                ->select('set_group')
                ->select($odIxVal . ' AS cnt')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->where('oid', $oid)
                ->where('od_ix', $odIxKey)
                ->where('set_group >', 0)
                ->exec()
                ->getRowArray();

            if ($row) {
                $setRows[$row['set_group']] = $row['cnt'];
            }
        }

        return $setRows;
    }

    /**
     * set_group 을 확인하여 od_ix 와 구성 수량을 조회한다.
     * @param string $oid 주문번호
     * @param array $odIx 주문상품ID
     * @return array
     */
    public function chkSetGroup($oid, $odIx)
    {
        if (is_array($odIx)) {

            $setRows = $this->getSetGroup($oid, $odIx);

            if (!empty($setRows)) {
                $setGroup = array_keys($setRows);

                $rows = $this->qb
                    ->select('od.od_ix')
                    ->select('od.set_group')
                    ->select('pod.option_etc1') // 구성수량
                    ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
                    ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'od.option_id = pod.id')
                    ->whereIn('od.set_group', $setGroup)
                    ->where('oid', $oid)
                    ->exec()
                    ->getResultArray();

                foreach ($rows as $row) {
                    $odIx[$row['od_ix']] = $setRows[$row['set_group']] * $row['option_etc1']; // 수량 * 구성수량
                }
            }
        }

        return $odIx;
    }

    /**
     * 주문상품 상세 ID를 이용하여 구성 수량 조회
     * @param int $odIx
     * @return int|false
     */
    public function getEtcQty($odIx)
    {
        $row = $this->qb
            ->select('pod.option_etc1') // 구성수량
            ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'od.option_id = pod.id')
            ->where('od_ix', $odIx)
            ->exec()
            ->getRow();

        return isset($row->option_etc1) ? $row->option_etc1 : false;
    }

    /**
     * 주문 취소 금액 확인
     * @param array $data
     * @return array
     */
    public function claimConfirm($data)
    {
        $od_ixs = [];
        $result = [];

        foreach ($data['odIx'] as $odIx => $cCnt) {
            if ($cCnt > 0) {
                $od_ixs[] = $odIx;
            }
        }

        if (!empty($od_ixs)) {
            $products = $this->qb
                ->from(TBL_SHOP_ORDER_DETAIL . ' as d')
                ->join(TBL_SHOP_ORDER_DELIVERY . ' as od', 'd.ode_ix=od.ode_ix', 'left')
                ->where('d.oid', $data['oid'])
                ->whereIn('d.od_ix', $od_ixs)
                ->exec()
                ->getResultArray();

            if (!empty($products)) {

                $claimFaultType = ForbizConfig::getOrderSelectStatus('F', $data['status'], $data['claimStatus'], $data['ccReason'], 'type');

                for ($i = 0; $i < count($products); $i++) {
                    $products[$i]['claim_type'] = substr($data['claimStatus'], 0, 1); //C : 취소 R : 반품 E : 교환
                    $products[$i]['claim_group'] = "99"; //클래임그룹임시로 99로 동일!
                    $products[$i]['claim_fault_type'] = $claimFaultType; //클래임책임자
                    $products[$i]['claim_apply_yn'] = "Y"; //요청상품
                    $products[$i]['claim_apply_cnt'] = $data['odIx'][$products[$i]['od_ix']]; //요청상품수량
                }
                //주문 취소 가격 계산
                $result = $this->claimChangePriceCalculate($products, $data);

                log_message('error', json_encode($result));
            }
        }

        return $result;
    }

    /**
     * 주문 취소 가격 계산
     * @param array $data
     */
    public function claimChangePriceCalculate($data, $claimData)
    {
        // 클레임 주문한 건 외의 남은 주문 금액/개수 데이터
        $oid = $data[0]['oid'];
        $leftoverDatas = $this->calculateLeftoverDeliveryPrice($oid, $data);

        //주문금액 관련
        $total_claim_delivery_price = 0;
        $total_etc_dcprice = 0;
        $tax_free_price = 0;
        $tax_price = 0;
        $total_coupon_dcprice = 0;
        $total_change_delivery_price = 0;
        $total_product_price = 0;
        $change_coupon_dcprice = 0;

        //클레임 배송비
        $total_org_delivery_price = 0;
        $total_delivery_price = 0; //최초 배송비
        $b_ode_ix = '';
        $company_id = '';
        $delivery_type = '';
        $addDeliveryPrice = 0;

        $b_claim_group = '';

        //각 od_ix 루프 돌리면서 데이터 처리
        for ($i = 0; $i < count($data); $i++) {
            $total_product_dcprice = 0; //개별 상품 총 할인금액
            //-, + 기호 처리
            if ($data[$i]['claim_apply_yn'] == "N") {//교환되어야할 배송상품
                $pm_sign = -1;
            } else {
                $pm_sign = 1;
            }

            //클레임 상품 총 금액
            $product_price = (($data[$i]['psprice'] + $data[$i]['option_price']) * $data[$i]['claim_apply_cnt']) * $pm_sign;
            $total_product_price += $product_price;

            /*
             * 클레임 처리시 배송비 구하기 START.
             */
            $claimOngoingPrice = 0;
            /*
              $claimOngoingPrice = $this->qb //현재 클레임 처리되었거나 처리중인 배송비 계산
              ->select('ifnull(sum(delivery_price), 0) as price')
              ->from(TBL_SHOP_ORDER_CLAIM_DELIVERY)
              ->where('oid', $oid)
              ->where('claim_group in ((select claim_group from shop_order_detail where oid="'.$oid.'"))')->exec()->getRow(0, 'array');
              $claimOngoingPrice = $claimOngoingPrice['price'];
             *
             */

            if ($b_ode_ix != $data[$i]['ode_ix']) { //기존 배송비 구하기. ode_ix 기준(동일 배송정책)으로 한 번만 처리함.
                $org_delivery_price = $data[$i]['delivery_dcprice']; //기존 배송비
                $total_org_delivery_price += $data[$i]['delivery_dcprice']; //기존 배송비(총 금액 계산)
                $dtIx = $data[$i]['dt_ix'];
            }


            if ($data[$i]['claim_type'] == "C") {//취소요청 CASE.
                if ($data[$i]['delivery_pay_method'] == "1") {//선불일 경우
                    if ($data[$i]['delivery_package'] == 'Y') { //개별배송
                        $delivery_bool = true;
                    } else { //묶음배송
                        if ($b_ode_ix != $data[$i]['ode_ix']) { //ode_ix 기준(동일 배송정책)으로 한 번만 처리함. 업체당 묶음배송비는 한 번만 계산함.
                            $delivery_bool = true;
                        } else {
                            $delivery_bool = false;
                        }
                    }

                    if ($delivery_bool) { //취소 후 환불해야하는 혹은 차감해야하는 배송비 구하기
                        // 취소후 주문 잔액 : leftOverPrice
                        // 취소 후 주문 잔액이 없을시
                        if (empty($leftoverDatas[$data[$i]['ode_ix']]['leftTotal'])) {
                            $leftOverPrice = 0;
                        } else {
                            $leftOverPrice = array_sum($leftoverDatas[$data[$i]['ode_ix']]['leftTotal']);
                        }

                        if (empty($leftoverDatas[$data[$i]['ode_ix']]['leftTotal'])) {
                            $leftOverPcnt = 0;
                        } else {
                            $leftOverPcnt = array_sum($leftoverDatas[$data[$i]['ode_ix']]['leftPcnt']);
                        }

                        if ($data[$i]['claim_fault_type'] == "B" && $leftOverPrice > 0) { //구매자 귀책일 경우 && 부분취소일 경우 계산
                            //남은 주문으로 배송비 재계산
                            $re_delivery_price_infos = $this->cartModel->getDeliveryInfo($data[$i]['dt_ix'], array('price' => $leftOverPrice, 'qty' => $leftOverPcnt));
                            $re_delivery_price = $re_delivery_price_infos['sumPrice'];

                            //기존 배송비 - 남은 주문 금액의 배송비 = 환불시 차감 혹은 환불시 추가 되어야할 금액
                            $change_delivery_price = $org_delivery_price - $re_delivery_price;

                            if ($change_delivery_price != 0) {
                                $total_change_delivery_price += $change_delivery_price;
                            }

                            // *** 부분 취소 시 잔액이 남아 있을 경우 배송비는 제외한다.
                        } else {
                            $total_change_delivery_price = $org_delivery_price; //판매자 귀책 혹은 전체취소일 경우에는 배송비 전체 환불
                        }
                    }
                }
            } else {//반품 또는 교환 CASE
                if ($data[$i]['claim_fault_type'] == "B" || $data[$i]['claim_fault_type'] == "N") {//구매자 귀책시 배송비 부과 , 기타일때 도 배송비 부과 추가
                    //요청한 그룹별로 배송비 부과. claim_group = 클레임시 +1로 업데이트되는 값.
                    //예) A, B, C 클레임 요청시 1로 업데이트 -> 클레임 중단 -> 이후 A, B 상품 재클레임 요청시 2로 업데이트. 최종 claim_group 값 : A, B = 2 / C = 1
                    if ($b_claim_group != $data[$i]['claim_group']) {

                        $dt_info = $this->qb->select('*')
                                ->from(TBL_SHOP_DELIVERY_TEMPLATE . ' as t')
                                ->join(TBL_SHOP_ORDER_DELIVERY . ' as od', 't.dt_ix=od.dt_ix', 'inner')
                                ->where('ode_ix', $data[$i]['ode_ix'])->exec()->getRow(0, 'array');

                        if ($dt_info['delivery_region_use'] == '1') {

                            if (!empty($claimData['czip'])) {
                                $region = $this->qb
                                    ->select('price')
                                    ->from(TBL_SHOP_ADD_DELIVERY_AREA)
                                    ->where('zip', $claimData['czip'])
                                    ->exec()->getRowArray();

                                if (!empty($region)) {
                                    $addDeliveryPrice = $region['price'];
                                }
                            }
                        }

                        if ($data[$i]['claim_type'] == "R") {//반품
                            if ($org_delivery_price == 0) { //무료배송시에만 왕복, 편도 선택이 적용되며 무료배송이 아닐 경우 편도만 가능
                                // 무료배송
                                if (empty($leftoverDatas[$data[$i]['ode_ix']]['leftTotal'])) {
                                    $leftOverPrice = 0;
                                } else {
                                    $leftOverPrice = array_sum($leftoverDatas[$data[$i]['ode_ix']]['leftTotal']);
                                }

                                if (empty($leftoverDatas[$data[$i]['ode_ix']]['leftTotal'])) {
                                    $leftOverPcnt = 0;
                                } else {
                                    $leftOverPcnt = array_sum($leftoverDatas[$data[$i]['ode_ix']]['leftPcnt']);
                                }

                                if ($leftOverPrice == 0) { //전체 클레임 처리인지 확인
                                    //무료 배송일때 전체 반품이고 왕복 설정이면 +
                                    //배송된 배송비
                                    $claim_delivery_price = 0;
                                    if ($dt_info['return_shipping_cnt'] == 2) {//왕복 1:편도 2:왕복
                                        $claim_delivery_price = $dt_info['return_shipping_price'];
                                    }

                                    //반품 배송비
                                    if ($claimData['send_type'] == 1) {
                                        // 직접 발송
                                        if ($claimData['delivery_pay_type'] == 2) {
                                            // 착불
                                            $claim_delivery_price += ($dt_info['return_shipping_price']+$addDeliveryPrice); //반품 배송비
                                        }
                                    } else {
                                        // 지정택배
                                        $claim_delivery_price += ($dt_info['return_shipping_price']+$addDeliveryPrice); //반품 배송비
                                    }
                                } else {
                                    if ($claimData['send_type'] == 1) {
                                        // 직접 발송
                                        if ($claimData['delivery_pay_type'] == 1) {
                                            // 선불
                                            $claim_delivery_price = 0; //반품 배송비 편도
                                        } else {
                                            // 착불
                                            $claim_delivery_price = ($dt_info['return_shipping_price']+$addDeliveryPrice); //반품 배송비
                                        }
                                    } else {
                                        // 지정택배
                                        $claim_delivery_price = ($dt_info['return_shipping_price']+$addDeliveryPrice); //반품 배송비
                                    }
                                }
                            } else { //무료배송시에만 왕복, 편도 선택이 적용되며 무료배송이 아닐 경우 편도만 가능
                                // 유료배송
                                // 직접 발송인가?
                                if ($claimData['send_type'] == 1) {
                                    // 직접 발송
                                    if ($claimData['delivery_pay_type'] == 1) {
                                        // 선불 일때
                                        $claim_delivery_price = 0;
                                    } else {
                                        // 착불일때
                                        $claim_delivery_price = ($dt_info['return_shipping_price']+$addDeliveryPrice); //반품 배송비 편도
                                    }
                                } else {
                                    // 지정택배
                                    $claim_delivery_price = ($dt_info['return_shipping_price']+$addDeliveryPrice);
                                }
                            }

                            $total_claim_delivery_price -= $claim_delivery_price; //환불시 차감되어야할 배송비 값
                        } elseif ($data[$i]['claim_type'] == "E") {//교환
                            if ($claimData['send_type'] == 1) {
                                // 직접발송
                                if ($claimData['delivery_pay_type'] == 1) { // 선불
                                    $claim_delivery_price = ($dt_info['exchange_shipping_price']+$addDeliveryPrice); // 편도 배송비 설정
                                } else {
                                    $claim_delivery_price = ($dt_info['exchange_shipping_price'] * 2) + ($addDeliveryPrice * 2); //교환 배송비 편도*2
                                }
                            } else {
                                // 지정택배
                                $claim_delivery_price = ($dt_info['exchange_shipping_price'] * 2) + ($addDeliveryPrice * 2); //교환 배송비 편도*2
                            }

                            $total_claim_delivery_price = $claim_delivery_price; //교환시 추가 청구되는 배송비
                        }
                    }
                } else { //판매자 귀책시 배송비 무료
                    $total_claim_delivery_price = 0;
                    if ($b_claim_group != $data[$i]['claim_group']) {
                        if ($data[$i]['claim_type'] == "R") {//반품
                            if (empty($leftoverDatas[$data[$i]['ode_ix']]['leftTotal'])) {
                                $leftOverPrice = 0;
                            } else {
                                $leftOverPrice = array_sum($leftoverDatas[$data[$i]['ode_ix']]['leftTotal']);
                            }
                            if ($leftOverPrice == 0) {
                                $total_change_delivery_price += $org_delivery_price;
                            }
                        }
                    }
                }
            }
            /*
             * 클레임 처리시 배송비 구하기 END. ode_ix 기준(동일 배송정책)으로 한 번만 처리함.
             */

            $dc_etc_info = array('SP' => array(), 'GP' => array());

            //클레임시 할인 상세 금액
            if (!empty($data[$i]["claim_discount_type"])) { //구매자가 아닌 관리자 화면에서 지정하여 넘기는 값(교환요청)
                if ($data[$i]["claim_discount_type"] == "array") {//다른 상품으로 교환할 경우. 현재(181016)는 모든 솔루션이 동일 상품 교환 기준임.
                    if (count($data[$i]["discount_desc"]) > 0) {
                        foreach ($data[$i]["discount_desc"] as $dc) {
                            //discount_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
                            if (!in_array($dc['discount_type'], array("CP", "SCP"))) {
                                $dc_etc_info[$dc['discount_type']][] = ($dc['discount_price'] * $pm_sign);
                                $total_etc_dcprice += ($dc['discount_price'] * $pm_sign);
                                $total_product_dcprice += ($dc['discount_price'] * $pm_sign);
                            }
                        }
                    }
                } elseif ($data[$i]["claim_discount_type"] == "cupon") {//동일 상품으로 교환할 경우.
                    $discount = $this->qb->select('*')->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT)->where('oid', $data[$i]['oid'])->where('od_ix', $data[$i]['od_ix'])->whereNotIn('dc_type', array('CP', 'SCP'))
                            ->exec()->getResultArray();

                    if (count($discount) > 0) { //쿠폰(CP, CSP) 제외한 할인 정보 호출
                        foreach ($discount as $dc) {
                            if ($data[$i]["claim_apply_cnt"] == $data[$i]["pcnt"]) { //전체취소,반품,교환일때
                                $dc_etc_info[$dc['dc_type']][] = ($dc['dc_price'] * $pm_sign);
                                $total_etc_dcprice += ($dc['dc_price'] * $pm_sign);
                                $total_product_dcprice += ($dc['dc_price'] * $pm_sign);
                            } else {
                                $dc_etc_info[$dc['dc_type']][] = round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                                $total_etc_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                                $total_product_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                            }
                        }
                    }

                    if (count($data[$i]["discount_desc"]) > 0) { //쿠폰 등의 할인 정보를 재적용하기위해 존재. 현재(181016) 기준 쿠폰 넘겨주는 부분은 주석처리되어있음.
                        foreach ($data[$i]["discount_desc"] as $dc) {
                            //discount_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
                            if (in_array($dc['discount_type'], array("CP", "SCP"))) {
                                $dc_etc_info[$dc['discount_type']][] = $dc['discount_price'];
                                $total_etc_dcprice += ($dc['discount_price'] * $pm_sign);
                                $total_product_dcprice += ($dc['discount_price'] * $pm_sign);
                            }
                        }
                    }
                }
            } else {
                //할인 데이터 재출력
                $discount = $this->qb->select('*')->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT)->where('oid', $data[$i]['oid'])->where('od_ix', $data[$i]['od_ix'])
                        ->exec()->getResultArray();

                if (count($discount) > 0) {
                    foreach ($discount as $dc) {
                        //dc_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
                        //배송비 쿠폰은 정책이 정해지면!
                        if (in_array($dc['dc_type'], array("CP", "SCP","DCP"))) {
                            if($dc['dc_type'] == 'DCP'){
                                if($data[$i]['claim_type'] == 'R'){
                                    if ($data[$i]['claim_fault_type'] == 'B') {
                                        //2020-03-20 #6778 반품 처리시 구매자 귀책 사유일때 할인 받은 금액 제외처리 하지 않는다하여 주석 진행
//                                        $total_coupon_dcprice += ($dc['dc_price'] * $pm_sign);
//                                        $total_product_dcprice += ($dc['dc_price'] * $pm_sign);
                                    }
                                }
                            }else {
                                $total_coupon_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                                $total_product_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                            }
                        } else {
                            if ($data[$i]["claim_apply_cnt"] == $data[$i]["pcnt"]) {
                                //전체취소,반품,교환일때
                                $dc_etc_info[$dc['dc_type']][] = ($dc['dc_price'] * $pm_sign);
                                $total_etc_dcprice += ($dc['dc_price'] * $pm_sign);
                                $total_product_dcprice += ($dc['dc_price'] * $pm_sign);
                            } else {
                                $dc_etc_info[$dc['dc_type']][] = round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                                $total_etc_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                                $total_product_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                            }
                        }
                    }
                }
            }

            //상품 과세 비과세금액. 실제로 과세/비과세를 사용하지는 않음. 협의 후 처리 필요.
            if ($data[$i]['surtax_yorn'] == "Y") {
                $tax_free_price += $product_price - $total_product_dcprice; //비과세금액
            } else {
                $tax_price += $product_price - $total_product_dcprice; //과세금액
            }

            $b_ode_ix = $data[$i]['ode_ix'];
            $b_claim_group = $data[$i]['claim_group'];
        }

        $total_dcprice = $total_etc_dcprice + $total_coupon_dcprice;
        $total_apply_product_price = $total_product_price - $total_dcprice;
        $total_apply_delivery_price = $total_claim_delivery_price + $total_change_delivery_price - $claimOngoingPrice; //교환/반품 발생 배송비 + 취소로 인한 변경 배송비 - 클레임 처리중/처리완료된 배송비
        $total_apply_price = $total_apply_product_price + $total_apply_delivery_price;



        //코멘트 관련 기존 파라미터 삭제
        return [
            'price' => $total_apply_price, //총 환불금액
            'tax_price' => $tax_price + $total_apply_delivery_price, //총 환불중 과세금액
            'tax_free_price' => $tax_free_price, //총 환불중 비과세금액
            'product' => [//상품
                'product_price' => $total_product_price, //할인전 총 상품가격
                'product_dc_price' => $total_apply_product_price, //할인차감된 총 상품가격(쿠폰포함)
                'dc_price' => $total_etc_dcprice, //총할인금액(쿠폰변동금액제외)
                'special_discount' => array_sum($dc_etc_info['SP']), //특별할인금액
                'promotion_discount' => array_sum($dc_etc_info['GP']), //기획할인금액
                'change_coupon_dcprice' => $total_coupon_dcprice, //총변동쿠폰할인금액
                'tax_price' => $tax_price, //할인차감된 총 과세금액
                'tax_free_price' => $tax_free_price, //할인차감된 총 비과세금액
            ],
            'delivery' => [//배송비
                'org_delivery_price' => $total_org_delivery_price, //할인차감되지않은 총 배송비
                'delivery_price' => $total_delivery_price, //할인 전 총 배송비
                'delivery_dc_price' => $total_apply_delivery_price, //총반품(교환)배송비
                'claim_delivery_price' => $total_claim_delivery_price,
                'change_delivery_price' => $total_change_delivery_price
            ],
            'claimDeliveryPrice' => [//shop_order_claim_delivery 에 입력되어야할 값. 환불완료처리, 정산에 사용되며 프론트는 동일한 배송정책끼리만 취소가 가능함.
                'company_id' => $data[0]['company_id'],
                'delivery_type' => $data[0]['delivery_type'],
                'delivery_price' => $total_apply_delivery_price
            ],
            'view_total_price' => $total_apply_product_price + $total_change_delivery_price, //반품신청 총 결제금액
            'view_claim_delivery_price' => abs($total_claim_delivery_price), //반품 시 추가 배송비
            'view_price' => ($total_apply_price > 0 ? $total_apply_price : 0) // 환불 예정 금액
        ];
    }

    /**
     * 세트/코디 상품의 주문 그룹 조회
     * @param string $oid 주문번호
     * @param int $set_group 세트/코디 주문 그룹
     * @param int $claim_group 클레임 그룹
     * @param int $pcnt 수량
     * @return int
     */
    public function getOrderSetGroup($oid, $set_group, $claim_group, $pcnt = null)
    {
        $row = $this->qb
            ->select('shop_order_set_id')
            ->from(TBL_SHOP_ORDER_SET)
            ->where('oid', $oid)
            ->where('parent_set_id', $set_group)
            ->where('claim_group', $claim_group)
            ->exec()
            ->getRowArray();

        // 세트/코드 주문 그룹이 존재?
        if (!isset($row['shop_order_set_id'])) {
            // No
            $shop_order_set_id = $this->qb
                ->set('oid', $oid)
                ->set('parent_set_id', $set_group)
                ->set('claim_group', $claim_group)
                ->insert(TBL_SHOP_ORDER_SET)
                ->exec();

            // 세트/코디상품 수량 업데이트
            $this->updateOrderSetCnt($oid, $set_group, $claim_group, $pcnt);
        } else {
            // Yes
            $shop_order_set_id = $row['shop_order_set_id'];
        }

        return $shop_order_set_id;
    }

    /**
     * 주문 세트상품 수량을 업데이트함
     * @param string $oid 주문번호
     * @param int $set_group 세트 그룹
     * @param int $claim_group 클레임 그룹
     * @param int $pcnt 수량(구매/취소등)
     */
    public function updateOrderSetCnt($oid, $set_group, $claim_group = 0, $pcnt = null)
    {
        // 입련된 $pcnt가 있는가?
        if ($pcnt === null) {
            // No, TBL_SHOP_CART_SET 에서 수량 가져옴
            $row = $this->qb
                ->select('pcount')
                ->from(TBL_SHOP_CART_SET)
                ->where('shop_cart_set_id', $set_group)
                ->exec()
                ->getRow();

            $pcnt = isset($row->pcount) ? $row->pcount : null;
        }

        if ($pcnt !== null) {
            $this->qb
                ->set('pcount', $pcnt)
                ->update(TBL_SHOP_ORDER_SET)
                ->where('oid', $oid)
                ->where('parent_set_id', $set_group)
                ->where('claim_group', $claim_group)
                ->exec();
        }
    }

    /**
     * 취소 완료 상태 변경
     * @param string $oid 주문번호
     * @param int $claimPcnts 취소 수량
     * @param int $claimDeliveryPrice 배송비
     * @param string $claimReason 취소사유코드
     * @param string $claimReasonMsg 취소사유
     */
    public function updateCancelComplete($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg)
    {
        //추가금액 데이터 입력 관련 프로세스 추가 필요 181016
        //추가금액. 기존에는 신청확인 페이지에서 hidden type으로 값 넘긴 것으로 보임.
        //total_apply_price, total_apply_product_price, total_apply_delivery_price, total_apply_tax_price, total_apply_tax_free_price

        $claimFaultType = ForbizConfig::getOrderSelectStatus('F', ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_CANCEL_COMPLETE, $claimReason, 'type');
        $claimGroup = $this->getClaimGroup($oid);

        $odIxs = array_keys(array_filter($claimPcnts));

        // 주문 취소 완료 페이지 display 용
        $newCancelledOdIxs = [];
        $orgCancelledOdIxs = [];

        if (empty($odIxs)) {
            return;
        } else {
            // 주문상세 조회
            $orderDetails = $this->qb
                ->select('*')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->whereIn('od_ix', $odIxs)
                ->exec()
                ->getResultArray();

            // 이전 세트그룹
            $prev_chk_group = false;
            $parent_od_ix_tbl = [];
            $new_parent_od_ix = null;
            for ($i = 0; $i < count($orderDetails); $i++) {

                $origin_od_ix = $orderDetails[$i]['od_ix'];
                $odIx = $orderDetails[$i]['od_ix'];
                $oid = $orderDetails[$i]['oid'];

                // 분할 취소 인가?
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) {
                    // 분할 취소
                    // 세트/코디 상품 주문?
                    if ($orderDetails[$i]['set_group'] > 0) {
                        // 세트코디상품
                        if ($orderDetails[$i]['set_group'] != $prev_chk_group) {
                            $prev_chk_group = $orderDetails[$i]['set_group'];
                            // 새로운 세트 그룹 생성
                            $set_group = $this->orderSetSeparate($oid, $orderDetails[$i]['set_group'], $claimGroup, $claimPcnts[$odIx], $orderDetails[$i]['od_ix']);
                        } else {
                            $set_group = $this->getOrderSetGroup($oid, $orderDetails[$i]['set_group'], $claimGroup);
                        }
                    } else {
                        // 일반상품
                        $set_group = $orderDetails[$i]['set_group'];
                    }

                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);

                    // 결제 완료 페이지 출력용
                    if ($orderDetails[$i]['product_type'] != '77') {
                        array_push($newCancelledOdIxs, $odIx);
                    }

                    // 사은품?
                    if ($orderDetails[$i]['gift_type'] == 'N') {
                        $parent_od_ix_tbl[$orderDetails[$i]['od_ix']] = $odIx;
                        $new_parent_od_ix = null;
                    } elseif ($orderDetails[$i]['gift_type'] == 'G') {
                        $new_parent_od_ix = $parent_od_ix_tbl[$orderDetails[$i]['parent_od_ix']];
                    } else {
                        $new_parent_od_ix = null;
                    }
                } else {
                    // 전체 취소
                    $set_group = $orderDetails[$i]['set_group'];
                    // 사은품 상위 주문 코드 설정
                    $new_parent_od_ix = $orderDetails[$i]['parent_od_ix'];
                }

                // 결제 완료 페이지 출력용
                if ($orderDetails[$i]['product_type'] != '77') {
                    array_push($orgCancelledOdIxs, $origin_od_ix);
                }

                $this->qb
                    ->set('status', ORDER_STATUS_CANCEL_COMPLETE)
                    ->set('ca_date', date('Y-m-d H:i:s'))
                    ->set('cc_date', date('Y-m-d H:i:s'))
                    ->set('fa_date', date('Y-m-d H:i:s'))
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('claim_fault_type', $claimFaultType)
                    ->set('claim_group', $claimGroup)
                    ->set('refund_status', ORDER_STATUS_REFUND_APPLY)
                    ->set('set_group', $set_group) //세트 그룹 설정
                    ->set('parent_od_ix', $new_parent_od_ix) //사은품 연동 주문 상세
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //사은품도 같이 업데이트 처리
                $this->giftStatusUpdate($odIx, ORDER_STATUS_CANCEL_COMPLETE, $claimGroup, $claimFaultType);

                //판매진행중 재고 업데이트
                $this->updateStockWhenClaim($orderDetails[$i]['pid'], $orderDetails[$i]['option_id'], $claimPcnts[$orderDetails[$i]['od_ix']], $orderDetails[$i]['stock_use_yn'], $orderDetails[$i]['gu_ix']);

                // *** 취소 사유,  신규 번호 : $odIx
                if ($orderDetails[$i]['product_type'] != '77') {
                    $data['pid'] = $orderDetails[$i]['pid'];
                    $data['admin_message'] = '구매자';
                    $data['c_type'] = 'B';  // 생성자(B:구매자,S:신청자,M:MD)
                    $data['reason_code'] = $claimReason;
                    $data['status_message'] = $claimReasonMsg[$origin_od_ix] ?? "";
                    $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_CANCEL_COMPLETE, $data);
                }

                //쿠폰 돌려주기. 전체 취소 혹은 관련 쿠폰으로 사용된 건이 전부 취소되었을 경우 사용함.
                //취소한 쿠폰건과 동일하게 사용된 쿠폰이 있는지 discount 확인
                //해당 od_ix 들의 정상 배송 프로세스가 있는지 개수 확인. 0이면 현재 주문건이 마지막 주문이므로 복원해주고 아니면 마지막 주문건이 아니므로 복원해주지 않음.
                $checkPossibleReturnCoupon = $this->qb
                        ->select('od.od_ix')
                        ->from(TBL_SHOP_ORDER_DETAIL . ' as od')
                        ->join(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as odd', 'od.od_ix=odd.od_ix', 'inner')
                        ->where('od.oid', $oid)
                        ->whereIn('od.status', [ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_BUY_FINALIZED])
                        ->where('dc_ix in (select dc_ix from shop_order_detail_discount where od_ix="' . $odIx . '")')
                        ->exec()->getResultArray();

                if (count($checkPossibleReturnCoupon) == 0) {
                    $this->couponModel->returnUsedCoupon($oid, ORDER_STATUS_CANCEL_COMPLETE, ['od_ix' => $odIx]);
                }
            }


            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY, [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                'oid' => $oid,
                'claim_group' => $claimGroup,
                'company_id' => (isset($claimDeliveryPrice['company_id']) ? $claimDeliveryPrice['company_id'] : ''),
                'delivery_type' => (isset($claimDeliveryPrice['delivery_type']) ? $claimDeliveryPrice['delivery_type'] : ''),
                'delivery_price' => (isset($claimDeliveryPrice['delivery_price']) ? $claimDeliveryPrice['delivery_price'] : ''),
                'regdate' => date('Y-m-d H:i:s')
            ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            if (count($newCancelledOdIxs) > 0) {
                $result = $newCancelledOdIxs;
            } else {
                $result = $orgCancelledOdIxs;
            }

            return $result;
        }
    }

    /**
     * 기프트 상품도 동일한 스테이터스로 변경
     */
    public function giftStatusUpdate($odix, $status, $claimGroup, $claimFaultType="")
    {

        if(!empty($claimFaultType)) {
            $this->qb->set('claim_fault_type', $claimFaultType);
        }

        $this->qb
            ->set('status', $status)
            ->set('claim_group', $claimGroup)
            ->set('ca_date', date('Y-m-d H:i:s'))
            ->set('cc_date', date('Y-m-d H:i:s'))
            ->set('fa_date', date('Y-m-d H:i:s'))
            ->set('update_date', date('Y-m-d H:i:s'))
            ->set('refund_status', ORDER_STATUS_REFUND_APPLY)
            ->where('parent_od_ix', $odix)
            ->where('gift_type', 'G')
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();
    }

    /**
     * 세트/코디 주문 정보 분할
     * @param string $oid 주문번호
     * @param int $set_group 세트 그룹
     * @param int $claim_group 클레임 그룹
     * @param int $pcnt 수량
     * @param int $odIx 주문상품 상세ID
     * @return int
     */
    public function orderSetSeparate($oid, $set_group, $claim_group, $pcnt, $odIx)
    {
        // 구매수량 산출
        $qty = $this->getEtcQty($odIx);

        if ($qty) {
            $pcount = $pcnt / $qty;

            // 기존 세트/코디 구매 수량 수정
            $this->qb
                ->set('pcount', 'pcount-' . $pcount, false)
                ->where('shop_order_set_id', $set_group)
                ->update(TBL_SHOP_ORDER_SET)
                ->exec();

            // 새로운 세트/코디 수량 추가
            $set_group = $this->getOrderSetGroup($oid, $set_group, $claim_group, $pcount);
        }

        return $set_group;
    }

    /**
     * 교환요청 상태 변경
     * @param string $oid 주문번호
     * @param int $claimPcnts 교환 수량
     * @param int $claimDeliveryPrice 교환 배송비
     * @param string $claimReason 교환사유 코드
     * @param string $claimReasonMsg 교환사유
     * @param array $returnDeliveryInfos 교환지 정보
     */
    public function updateExchangeApply($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg, $returnDeliveryInfos)
    {
        //추가금액 데이터 입력 관련 프로세스 추가 필요 181016
        //추가금액. 기존에는 신청확인 페이지에서 hidden type으로 값 넘긴 것으로 보임. total_apply_price, total_apply_product_price, total_apply_delivery_price, total_apply_tax_price, total_apply_tax_free_price

        $claimFaultType = ForbizConfig::getOrderSelectStatus('F', ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_EXCHANGE_APPLY, $claimReason, 'type'); //귀책사유 관련 데이터
        $claimGroup = $this->getClaimGroup($oid);

        $odIxs = array_keys(array_filter($claimPcnts));

        if (empty($odIxs)) {
            return;
        } else {
            $orderDetails = $this->qb
                ->select('*')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->whereIn('od_ix', $odIxs)
                ->exec()
                ->getResultArray();

            //교환 배송정보
            if ($returnDeliveryInfos['sendType'] == 1) { //직접 발송
                $orderType = 3;
                $sendYn = 'Y';
            } else { //지정택배 방문요청
                $orderType = 4;
                $sendYn = 'N';
            }

            $odIx = '';
            $prev_chk_group = false;
            for ($i = 0; $i < count($orderDetails); $i++) {
                $origin_od_ix = $orderDetails[$i]['od_ix'];
                $odIx = $orderDetails[$i]['od_ix'];
                $org_claim_cnt = $claimPcnts[$odIx];

                // 부분교환인가?
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) { //부분 교환일 경우 수량 기준으로 주문 복사 후 교환용으로 재복사
                    // 세트/코디 상품 주문?
                    if ($orderDetails[$i]['set_group'] > 0) {
                        if ($orderDetails[$i]['set_group'] != $prev_chk_group) {
                            $prev_chk_group = $orderDetails[$i]['set_group'];
                            // 새로운 세트 그룹 생성
                            $set_group = $this->orderSetSeparate($oid, $orderDetails[$i]['set_group'], $claimGroup, $claimPcnts[$odIx], $orderDetails[$i]['od_ix']);
                        } else {
                            $set_group = $this->getOrderSetGroup($oid, $orderDetails[$i]['set_group'], $claimGroup);
                        }
                    } else {
                        $set_group = $orderDetails[$i]['set_group'];
                    }

                    // 반품받을 주문 생성
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
                } else {
                    // 전체교환
                    $set_group = $orderDetails[$i]['set_group'];
                }

                // 세트/코디 상품 교환인가?
                if ($set_group > 0) {
                    //Yes
                    $qty = $this->getEtcQty($odIx);
                    $new_set_group = $this->getOrderSetGroup($oid, $set_group, $claimGroup, ($org_claim_cnt / $qty));
                } else {
                    //No
                    $new_set_group = $set_group;
                }

                // 교환 주문 생성
                $newOdIx = $this->orderSeparate($odIx, 0, true);

                //신규 복사(생성)된 주문 정보 초기화. 다른 프로세스에서 복사기능 사용 가능하므로 최초부터 아래 정보들을 초기화처리할 수 없음.
                $this->qb
                    ->where('od_ix', $newOdIx)
                    ->update(TBL_SHOP_ORDER_DETAIL, [
                        'delivery_pi_ix' => '',
                        'delivery_ps_ix' => '',
                        'delivery_basic_ps_ix' => '',
                        'delivery_status' => '',
                        'refund_status' => '',
                        'quick' => '',
                        'invoice_no' => '',
                        'input_type' => '',
                        'output_type' => '',
                        'claim_fault_type' => '',
                        'is_check_picking' => '',
                        'is_check_delivery' => '',
                        'return_product_state' => '',
                        'accounts_status ' => '',
                        'ac_ix' => '',
                        'refund_ac_ix' => '',
                        'dr_date' => NULL,
                        'di_date' => NULL,
                        'ac_date' => NULL,
                        'dc_date' => NULL,
                        'bf_date' => NULL,
                        'ea_date' => NULL,
                        'ra_date' => NULL,
                        'fa_date' => NULL,
                        'fc_date' => NULL,
                        'erp_link_date' => NULL,
                        'due_date' => ''
                    ])->exec();

                //교환 배송지 정보 입력
                $changeDeliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO, [//교환되어야할 상품
                        'oid' => $oid,
                        'od_ix' => $odIx,
                        'order_type' => $orderType,
                        'send_type' => $returnDeliveryInfos['sendType'],
                        'rname' => $returnDeliveryInfos['cname'],
                        'rtel' => $returnDeliveryInfos['ctel'],
                        'rmobile' => $returnDeliveryInfos['cmobile'],
                        'zip' => $returnDeliveryInfos['czip'],
                        'addr1' => $returnDeliveryInfos['caddr1'],
                        'addr2' => $returnDeliveryInfos['caddr2'],
                        'msg' => $returnDeliveryInfos['cmsg'],
                        'delivery_method' => 1,
                        'quick' => $returnDeliveryInfos['quick'],
                        'invoice_no' => $returnDeliveryInfos['invoiceNo'],
                        'send_yn' => $sendYn,
                        'delivery_pay_type' => $returnDeliveryInfos['payType'],
                        'add_delivery_price' => $claimDeliveryPrice['delivery_price'],
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();

                $deliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO, [//재배송할 상품
                        'oid' => $oid,
                        'od_ix' => $newOdIx,
                        'order_type' => 2,
                        'rname' => $returnDeliveryInfos['rname'],
                        'rtel' => $returnDeliveryInfos['rtel'] ?? '',
                        'rmobile' => $returnDeliveryInfos['rmobile'],
                        'zip' => $returnDeliveryInfos['rzip'],
                        'addr1' => $returnDeliveryInfos['raddr1'],
                        'addr2' => $returnDeliveryInfos['raddr2'],
                        'msg' => $returnDeliveryInfos['rmsg'],
                        'country' => $returnDeliveryInfos['country'] ?? '',
                        'city' => $returnDeliveryInfos['city'] ?? '',
                        'state' => $returnDeliveryInfos['state'] ?? '',
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();

                //배송비 입력
                $odeIx = $this->qb->insert(TBL_SHOP_ORDER_DELIVERY, [
                        'oid' => $oid,
                        'company_id' => $orderDetails[$i]['company_id'],
                        'delivery_type' => $orderDetails[$i]['delivery_type'],
                        'delivery_package' => $orderDetails[$i]['delivery_package'],
                        'delivery_policy' => 9, //1:무료배송 2:고정배송비 3:주문결제금액 할인 4:수량별할인 5:출고지별 배송비 6: 상품1개단위 배송비 9:클레임배송(교환)
                        'delivery_method' => $orderDetails[$i]['delivery_method'],
                        'delivery_pay_type' => 1, //선불:1, 착불:2
                        'delivery_addr_use' => $orderDetails[$i]['delivery_addr_use'],
                        'factory_info_addr_ix' => $orderDetails[$i]['factory_info_addr_ix'],
                        'pid' => '',
                        'delivery_price' => 0,
                        'delivery_dcprice' => 0,
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();

                //주문 상태 변경
                $this->qb //교환할 기존 상품 주문
                    ->set('status', ORDER_STATUS_EXCHANGE_APPLY)
                    ->set('ea_date', date('Y-m-d H:i:s'))
                    ->set('dc_date', 'IFNULL(dc_date,NOW())', false)
                    ->set('bf_date', 'IFNULL(bf_date,NOW())', false)
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('claim_fault_type', $claimFaultType)
                    ->set('claim_group', $claimGroup)
                    ->set('set_group', $set_group) //세트/코디 주문 그룹 변경
                    ->set('odd_ix', $changeDeliveryIx)
                    ->set('exchange_delivery_type', 'I') //교환배송상품발송타입(I:입고후발송,C:맞교환 발송,F:선발송)
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                $this->qb //재배송할 신규 교환 상품 주문
                    ->set('status', ORDER_STATUS_EXCHANGE_READY)
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('delivery_type', $orderDetails[$i]['delivery_type'])
                    ->set('delivery_package', $orderDetails[$i]['delivery_package'])
                    ->set('delivery_policy', $orderDetails[$i]['delivery_policy'])
                    ->set('delivery_method', $orderDetails[$i]['delivery_method'])
                    ->set('delivery_pay_method', 1) //선불:1, 착불:2
                    ->set('delivery_addr_use', $orderDetails[$i]['delivery_addr_use'])
                    ->set('factory_info_addr_ix', $orderDetails[$i]['factory_info_addr_ix'])
                    ->set('claim_delivery_od_ix', $odIx)
                    ->set('claim_group', $claimGroup)
                    ->set('set_group', $new_set_group) //세트/코디 주문 그룹 변경
                    ->set('odd_ix', $deliveryIx)
                    ->set('ode_ix', $odeIx)
                    ->where('od_ix', $newOdIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //사은품도 같이 업데이트 처리
                $this->giftStatusUpdate($odIx, ORDER_STATUS_EXCHANGE_APPLY, $claimGroup);

                //주문 상태 변경 기록
                $data['pid'] = $orderDetails[$i]['pid'];
                $data['status_message'] = $claimReasonMsg[$origin_od_ix] ?? '';
                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_EXCHANGE_APPLY, $data);
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY, [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                'oid' => $oid,
                'claim_group' => $claimGroup,
                'company_id' => $claimDeliveryPrice['company_id'],
                'delivery_type' => $claimDeliveryPrice['delivery_type'],
                'delivery_price' => $claimDeliveryPrice['delivery_price'],
                'regdate' => date('Y-m-d H:i:s')
            ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            return;
        }
    }

    /**
     * 반품요청 상태 변경
     * @param string $oid
     * @param int $claimPcnts
     * @param int $claimDeliveryPrice
     * @param string $claimReason
     * @param string $claimReasonMsg
     * @param array $returnDeliveryInfos
     */
    public function updateReturnApply($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg, $returnDeliveryInfos,$claimReasonText="")
    {
        //추가금액 데이터 입력 관련 프로세스 추가 필요 181016
        //추가금액. 기존에는 신청확인 페이지에서 hidden type으로 값 넘긴 것으로 보임. total_apply_price, total_apply_product_price, total_apply_delivery_price, total_apply_tax_price, total_apply_tax_free_price

        $claimFaultType = ForbizConfig::getOrderSelectStatus('F', ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_RETURN_APPLY, $claimReason, 'type'); //귀책사유 관련 데이터
        $claimGroup = $this->getClaimGroup($oid);

        $odIxs = array_keys(array_filter($claimPcnts));


        if (empty($odIxs)) {
            return;
        } else {
            $orderDetails = $this->qb
                ->select('*')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->whereIn('od_ix', $odIxs)
                ->exec()
                ->getResultArray();

            //반품 배송정보
            if ($returnDeliveryInfos['sendType'] == 1) { //직접 발송
                $orderType = 3;
                $sendYn = 'Y';
            } else { //지정택배 방문요청
                $orderType = 4;
                $sendYn = 'N';
            }

            $odIx = '';
            $prev_chk_group = false;

            for ($i = 0; $i < count($orderDetails); $i++) {
                $odIx = $orderDetails[$i]['od_ix'];
                $origin_od_ix = $orderDetails[0]['od_ix'];
                $odIxsArr = [];
                $odIxsArr[$odIx] = $orderDetails[$i]['pcnt'];


                // 부분반품인가?
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) {
                    // 부분반품
                    // 세트/코디 상품 주문?
                    if ($orderDetails[$i]['set_group'] > 0) {
                        // 세트/코디상품
                        if ($orderDetails[$i]['set_group'] != $prev_chk_group) {
                            $prev_chk_group = $orderDetails[$i]['set_group'];
                            // 새로운 세트 그룹 생성
                            $set_group = $this->orderSetSeparate($oid, $orderDetails[$i]['set_group'], $claimGroup, $claimPcnts[$odIx], $orderDetails[$i]['od_ix']);
                        } else {
                            $set_group = $this->getOrderSetGroup($oid, $orderDetails[$i]['set_group'], $claimGroup);
                        }
                    } else {
                        // 일반상품
                        $set_group = $orderDetails[$i]['set_group'];
                    }
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
                } else {
                    //전체반품
                    $set_group = $orderDetails[$i]['set_group'];
                }

                //반품 배송정보 입력
                $deliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO, [
                        'oid' => $oid,
                        'od_ix' => $odIx,
                        'order_type' => $orderType,
                        'send_type' => $returnDeliveryInfos['sendType'],
                        'rname' => $returnDeliveryInfos['cname'],
                        'rtel' => $returnDeliveryInfos['ctel'],
                        'rmobile' => $returnDeliveryInfos['cmobile'],
                        'zip' => $returnDeliveryInfos['czip'],
                        'addr1' => $returnDeliveryInfos['caddr1'],
                        'addr2' => $returnDeliveryInfos['caddr2'],
                        'msg' => $returnDeliveryInfos['cmsg'],
                        'delivery_method' => 1,
                        'quick' => $returnDeliveryInfos['quick'],
                        'invoice_no' => $returnDeliveryInfos['invoiceNo'],
                        'send_yn' => $sendYn,
                        'delivery_pay_type' => $returnDeliveryInfos['payType'],
                        'add_delivery_price' => 0,
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();

                //주문 상태 변경
                $this->qb
                    ->set('status', ORDER_STATUS_RETURN_APPLY)
                    ->set('ra_date', date('Y-m-d H:i:s'))
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('claim_fault_type', $claimFaultType)
                    ->set('claim_group', $claimGroup)
                    ->set('set_group', $set_group) //  세트 그룹 설정
                    ->set('odd_ix', $deliveryIx)
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //사은품도 같이 업데이트 처리
                $this->giftStatusUpdate($odIx, ORDER_STATUS_RETURN_APPLY, $claimGroup, $claimFaultType);

                //주문 상태 변경 기록
                $data['pid'] = $orderDetails[$i]['pid'];

                $data['status_message'] = $claimReasonMsg[$origin_od_ix] ?? "";

                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_RETURN_APPLY, $data);



                // 상품별 사은품 확인
                foreach ($odIxsArr as $parent_od_ix => $pcnt) {
                    $productGift = $this->getProductGiftOrder($parent_od_ix);
                    if (!empty($productGift)) {
                        foreach ($productGift as $pgItem) {
                            $odIxsArr[$pgItem['od_ix']] = $pcnt;
                        }
                    }
                }

                // 반품 사유 업데이트
                if(is_array($odIxsArr)){
                    $claim_datas = [];
                    foreach($odIxsArr as $key => $val){
                        $claim_datas['oid'] = $oid;
                        $claim_datas['od_ix'] = $key;
                        $claim_datas['status'] = ORDER_STATUS_RETURN_APPLY;
                        $claim_datas['c_type'] = 'B';//구매자 고정
                        $claim_datas['reason_code'] = $claimReason;
                        $claim_datas['status_message'] = $claimReasonText;
                        $claim_datas['msg'] = $claimReasonMsg[$origin_od_ix] ?? "";
                        $this->addClaimInfo($claim_datas);

                    }
                }
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY, [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                'oid' => $oid,
                'claim_group' => $claimGroup,
                'company_id' => $claimDeliveryPrice['company_id'],
                'delivery_type' => $claimDeliveryPrice['delivery_type'],
                'delivery_price' => $claimDeliveryPrice['delivery_price'],
                'regdate' => date('Y-m-d H:i:s')
            ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            return;
        }
    }

    /**
     * 구매확정 상태 변경
     * @param string $oid
     * @param string $odIx
     * @return type
     */
    public function updateBuyFinalized($oid, $odIx)
    {
        // 세트/코디 상품인지 체크한다.
        $rows = $this->chkSetGroup($oid, [$odIx => 0]);
        $odIxs = array_keys($rows);

        // 상품별 사은품 추가
        foreach (array_keys($rows) as $od_ix) {
            $prows = $this->getProductGiftOrder($odIx);
            foreach ($prows as $prow) {
                $odIxs[] = $prow['od_ix'];
            }
        }

        // 구매금액별 사은품 추가
        $freeGift = $this->getFreeGiftOrder($oid);
        foreach ($freeGift as $row) {
            $odIxs[] = $row['od_ix'];
        }

        $this->qb
            ->set('status', ORDER_STATUS_BUY_FINALIZED)
            ->set('bf_date', date('Y-m-d H:i:s'))
            ->set('update_date', date('Y-m-d H:i:s'))
            ->whereIn('od_ix', $odIxs)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        $data['status_message'] = '구매확정';
        $data['admin_message'] = '구매자';
        $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_BUY_FINALIZED, $data);

        //마일리지 적립
        $reserve = $this->qb
            ->setDatabase('payment')
            ->selectSum('reserve')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->whereIn('od_ix', $odIxs)
            ->where('status', ORDER_STATUS_BUY_FINALIZED)
            ->exec()
            ->getRowArray();

        $this->mileageModel->addMileage($reserve['reserve'], 1, '구매확정으로 인한 적립금 적립', ['oid' => $oid, 'od_ix' => $odIx]);

        //crema 주문 확정
        if(BASIC_LANGUAGE == 'korean') {
            foreach (array_keys($rows) as $od_ix) {
                $this->cremaOrderBfUpdate($od_ix);
            }
        }

        return;
    }

    /**
     * 배송완료 상태 변경
     * @param string $oid
     * @param string $odIx
     * @return type
     */
    public function updateDeliveryComplete($oid, $odIx)
    {
        // 세트/코디 상품인지 체크한다.
        $rows = $this->chkSetGroup($oid, [$odIx => 0]);
        $odIxs = array_keys($rows);

        // 상품별 사은품 추가
        foreach (array_keys($rows) as $od_ix) {
            $prows = $this->getProductGiftOrder($odIx);
            foreach ($prows as $prow) {
                $odIxs[] = $prow['od_ix'];
            }
        }

        // 구매금액별 사은품 추가
        $freeGift = $this->getFreeGiftOrder($oid);
        foreach ($freeGift as $row) {
            $odIxs[] = $row['od_ix'];
        }

        $this->qb
            ->set('status', ORDER_STATUS_DELIVERY_COMPLETE)
            ->set('dc_date', date('Y-m-d H:i:s'))
            ->set('update_date', date('Y-m-d H:i:s'))
            ->whereIn('od_ix', $odIxs)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        $data['status_message'] = '배송완료';
        $data['admin_message'] = '구매자';

        foreach ($odIxs as $od_ix) {
            $this->insertOrderHistory($oid, $od_ix, ORDER_STATUS_DELIVERY_COMPLETE, $data);
        }

        return;
    }

    /**
     * 주문 상세 정보 조회
     * @param string $userCode
     * @param string $oid
     * @param array $orderSearch
     * @param array $orderSearchEtc
     * @param int $exchange : 교환으로 신규 생성된 주문인지 확인
     * @return type
     */
    public function getOrderInfo($userCode, $oid, $orderSearch = [], $orderSearchEtc = [], $exchange = 0)
    {
        $row = parent::getOrderInfo($userCode, $oid, $orderSearch, $orderSearchEtc, $exchange);

        if (isset($row['oid'])) {
            $row['freeGift'][] = $this->getFreeGiftOrderNew($row['oid'], 'G','s', (isset($orderSearchEtc['claim_group']) ? $orderSearchEtc['claim_group'] : ''));
            $row['freeGift'][] = $this->getFreeGiftOrderNew($row['oid'], 'C','s', (isset($orderSearchEtc['claim_group']) ? $orderSearchEtc['claim_group'] : ''));
            $row['freeGift'][] = $this->getFreeGiftOrderNew($row['oid'], 'P','s', (isset($orderSearchEtc['claim_group']) ? $orderSearchEtc['claim_group'] : ''));
        }

        return $row;
    }

    /**
     * 주문상태별 카운트
     * @param string $userCode
     * @param array $status
     * @return array
     */
    public function getStatusCount($userCode, $status = false, $sDate = false, $eDate = false)
    {
        if ($status) {
            $this->qb->whereIn('od.status', is_array($status) ? $status : [$status]);
        }

        if ($sDate) {
            $this->qb->where('o.order_date >=', date('Y-m-d 00:00:00', strtotime($sDate)));
        } else {
            $this->qb->where('o.order_date >=', date('Y-m-d 00:00:00', strtotime('-1 month')));
        }

        if ($eDate) {
            $this->qb->where('o.order_date <', date('Y-m-d 23:59:59', strtotime($eDate)));
        } else {
            $this->qb->where('o.order_date <', date('Y-m-d 23:59:59'));
        }

        $rows = $this->qb
            ->select('od.status')
            ->select('COUNT(distinct(o.oid)) as cnt')
            ->from(TBL_SHOP_ORDER . ' AS o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS od', 'o.oid = od.oid')
            ->where('o.user_code', $userCode)
            ->where('od.claim_delivery_od_ix', 0)
            ->groupBy('od.status')
            ->exec()
            ->getResultArray();

        $data = [];

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $data[$row['status']] = $row['cnt'];
            }
        }

        return $data;
    }

    /**
     * 주문취소(입금후) 정보 조회
     * @param string $userCode
     * @param string $orderId
     * @return type
     */
    public function doOrderCancelInfo($userCode, $oid)
    {

        $row = $this->qb
            ->select('oid')
            ->select("date_format(order_date, '%Y-%m-%d') order_date", false)
            ->select('delivery_price')
            ->select('bname')
            ->select('bname as mem_name')
            ->select('bmail')
            ->select('bmobile')
            ->select('status')
            ->select('order_date bdatetime')
            ->select('status')
            ->select('refund_method')
            ->decryptSelect('refund_bank')
            ->decryptSelect('refund_bank_name')
            ->from(TBL_SHOP_ORDER)
            ->where('user_code', $userCode)
            ->where('oid', $oid)
            ->exec()
            ->getRowArray();

        // 배송정보
        if (isset($row['oid'])) {
            $row['orderDetail'] = $this->getGroupByDeliveryOrderDetail($row['oid'], [], '', '');

            $row['pname'] = "";
            $pcnt = 0;
            foreach ($row['orderDetail'] as $p => $v) {
                if ($pcnt == 0) {
                    $row['pname'] = $v['0']['pname'];
                }
                $pcnt++;
            }

            $deliveryPriceInfos = $this->getDeliveryPrice($oid, array_keys($row['orderDetail']));
            if (is_array($deliveryPriceInfos) && !empty($deliveryPriceInfos)) {
                $row['deliveryPrice'] = array_column($deliveryPriceInfos, 'delivery_dcprice', 'ode_ix');
                foreach ($deliveryPriceInfos as $deliveryPriceInfo) {
                    $deliveryInfo = $this->cartModel->getDeliveryInfo($deliveryPriceInfo['dt_ix']);
                    $row['deliveryPricePolicyText'][$deliveryPriceInfo['ode_ix']] = $deliveryInfo['text'];
                }
            } else {
                $row['deliveryPrice'] = [];
                $row['deliveryPricePolicyText'] = [];
            }
            $row['status'] = $this->checkOrderStatus($row['orderDetail'], $row['status']);
        }

        // 결제 정보
        $paymentInfo = $this->getPaymentInfo($oid, 'F');
        $row['payment_method'] = $paymentInfo['0']['method'];
        $row['payment_type'] = ForbizConfig::getPaymentMethod($row['payment_method']);

        $refundUserMemo = $this->qb
            ->select('status_message')
            ->from(TBL_SHOP_ORDER_STATUS)
            ->where('status', ORDER_STATUS_CANCEL_COMPLETE)
            ->where('oid', $oid)
            ->limit('1')
            ->exec()
            ->getRowArray();

        // 입금계좌 정보가 있을때
        if ($paymentInfo['0']['method'] == '4') {
            if (isset(explode("|", $row['refund_bank'])['1'])) {
                $row['refund_bank_account'] = explode("|", $row['refund_bank'])['1'];
            }
            $row['cancel_date'] = $paymentInfo['0']['regdate']; // 주문 취소 요청 일자
            $row['refund_date'] = ''; // 환불 완료 일자
            $row['cancel_reason'] = $refundUserMemo['status_message']; // 취소 사유
            $row['refund_type'] = ForbizConfig::getPaymentMethod(0);
        } else {
            $row['cancel_date'] = $paymentInfo['0']['regdate']; // 주문 취소 요청 일자
            $row['refund_date'] = $paymentInfo['0']['regdate']; // 환불 완료 일자
            $row['cancel_reason'] = $refundUserMemo['status_message']; // 취소 사유
            $row['refund_type'] = ForbizConfig::getPaymentMethod($row['payment_method']);
        }

        $row['payment_price'] = $paymentInfo['0']['payment_price']; // 배송비 포함 환불 금액
        $row['total_refund_amount'] = $paymentInfo['0']['payment_price']; // 배송비 포함 환불 금액
        $row['payment_price_desc'] = number_format($paymentInfo['0']['payment_price']);

        // 결제 총액 정보
        $paymentInfo = [
            'dr_dc' => 0,
            'cp_dc' => 0,
            'mg_dc' => 0,
            'gp_dc' => 0,
            'total_dc' => 0,
            'total_reserve' => 0,
            'total_listprice' => 0,
            'pt_dcprice' => 0,
            'total_pcnt' => 0,
            'payment' => $paymentInfo
        ];

        if (!empty($row['orderDetail'])) {
            foreach ($row['orderDetail'] as $deliveryOrder) {
                foreach ($deliveryOrder as $oitem) {
                    $paymentInfo['dr_dc'] += ($oitem['dr_dc'] + $oitem['gp_dc'] + $oitem['sp_dc']); // 즉시할인에 회원할인 더함
                    $paymentInfo['mg_dc'] += $oitem['mg_dc'];
                    $paymentInfo['cp_dc'] += $oitem['cp_dc'];
                    $paymentInfo['total_dc'] += $oitem['total_dc'];
                    $paymentInfo['total_reserve'] += $oitem['reserve'];
                    $paymentInfo['total_listprice'] += $oitem['pt_listprice'];
                    $paymentInfo['pt_dcprice'] += $oitem['pt_dcprice'];
                    $paymentInfo['total_pcnt'] += $oitem['pcnt'];
                }
            }
        }

        $row['refund_price'] = $paymentInfo['pt_dcprice']; // 배송비 미포함 금액
        $row['pcnt'] = $paymentInfo['total_pcnt'];

        return [
            'order' => $row,
            'paymentInfo' => $paymentInfo,
            'deliveryInfo' => $deliveryInfo
        ];
    }

    /**
     * 배송지 정보 및 배송 메시지
     * @param string $oid
     * @return array
     */
    public function getDeliveryInfo($oid)
    {
        $prows = $this->qb
            ->setDatabase('payment')
            ->select('od_ix')
            ->select('brand_name')
            ->select('set_group')
            ->select('product_type')
            ->select('pname')
            ->select('msgbyproduct')
            ->select('odd_ix')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('status !=', ORDER_STATUS_SETTLE_READY)
            ->where('product_type !=', '77')                 // 사은품 제외
            ->exec()
            ->getResultArray();

        if (!empty($prows)) {
            $odd_ixs = array_unique(array_column($prows, 'odd_ix'));

            // 배송정보 조회
            $data = $this->qb
                ->setDatabase('payment')
                ->select('odd_ix')
                ->select('rname')
                ->select('zip')
                ->select('addr1')
                ->select('addr2')
                ->select('rmobile')
                ->select('SUBSTRING_INDEX(rmobile, "-", 1) AS rm1, SUBSTRING_INDEX(SUBSTRING_INDEX(rmobile, "-", 2), "-", -1) AS rm2, SUBSTRING_INDEX(SUBSTRING_INDEX(rmobile, "-", 3), "-", -1) AS rm3')
                ->select('rtel')
                ->select('SUBSTRING_INDEX(rtel, "-", 1) AS rt1, SUBSTRING_INDEX(SUBSTRING_INDEX(rtel, "-", 2), "-", -1) AS rt2, SUBSTRING_INDEX(SUBSTRING_INDEX(rtel, "-", 3), "-", -1) AS rt3')
                ->select('msg')
                ->select('msg_type')
                ->select('country')
                ->select('city')
                ->select('state')
                ->from(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                ->where('oid', $oid)
                ->whereIn('odd_ix', $odd_ixs)
                ->orderBy('odd_ix')
                ->limit(1)
                ->exec()
                ->getRowArray();

            if (!empty($data)) {
                $data['pcnt'] = count($prows);

                if (!empty($data['country'])) {
                    /* @var $globalModel CustomMallGlobalModel */
                    $globalModel = $this->import('model.mall.global');
                    $nation = $globalModel->getSelectNationInfo($data['country']);
                    $data['country_full'] = $nation['nation_name'];
                }

                if ($data['msg_type'] == 'P') {
                    $data['msg'] = [];
                    $setGroup = [];
                    foreach ($prows as $prow) {
                        if ($prow['product_type'] == '0' || ($prow['product_type'] == '99' && !isset($setGroup[$prow['set_group']]))) {
                            $setGroup[$prow['set_group']] = true;
                            $data['msg'][] = [
                                'brand_name' => $prow['brand_name'],
                                'pname' => $prow['pname'],
                                'msg_ix' => $prow['od_ix'],
                                'msg' => $prow['msgbyproduct'],
                                'msg_type' => $data['msg_type']
                            ];
                        }
                    }
                } else {
                    if(BASIC_LANGUAGE == 'english'){
                        $pname_text = $prows[0]['pname'] . (count($prows) > 1 ? ' And ' . (count($prows) - 1) . ' other' : '');
                    }else{
                        $pname_text = $prows[0]['pname'] . (count($prows) > 1 ? ' 외 ' . (count($prows) - 1) . ' 건' : '');
                    }
                    $data['msg'] = [[
                        'brand_name' => $prows[0]['brand_name'],
                        'pname' => $pname_text,
                        'msg_ix' => $data['odd_ix'],
                        'msg' => $data['msg'],
                        'msg_type' => $data['msg_type']
                    ]];
                }
            }
        } else {
            $data = false;
        }
        return $data;
    }

    /**
     * 주문번호 생성
     * @return string
     */
    public function maxOid()
    {

        $configName = "shop_oid";
        $now = date('Ymd');
        $befor = date("Ymd", strtotime($now . " -1 day"));
        $next = date("Ymd", strtotime($now . " +1 day"));
        $nowTable = $configName . "_" . $now;
        $beforTable = $configName . "_" . $befor;
        $nextTable = $configName . "_" . $next;

        $activeTables = [$nowTable, $beforTable, $nextTable];

        $oidFirst = "";
        $oidLast = "";

        #테이블 존재 확인 후 생성
        $nowTableCheck = $this->qb->getTableList($nowTable);
        if (empty($nowTableCheck)) {
            $this->qb
                ->exec("create table " . $nowTable . " (
                        idx  int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
                        PRIMARY KEY (idx)
                        )");
        }

        $nextTableCheck = $this->qb->getTableList($nextTable);
        if (empty($nextTableCheck)) {
            $this->qb
                ->exec("create table " . $nextTable . " (
                        idx  int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
                        PRIMARY KEY (idx)
                        )");
        }

        #지난 테이블 제거
        $oidTableList = $this->qb->getTableList($configName);
        if (!empty($oidTableList)) {
            foreach ($oidTableList as $tb) {
                if (!in_array($tb, $activeTables)) {
                    $this->qb
                        ->exec("drop table " . $tb . " ");
                }
            }
        }

        $row = $this->qb
            ->set('idx')
            ->insert($nowTable)
            ->exec();
        $date = $now;
        $num = $row;

        $oidFirst = $date . date('Hi');
        $oidLast = zerofill($num, '7');
        $oid = $oidFirst . "-" . $oidLast;

        return $oid;
    }

    /**
     * 총 주문금액 합
     */
    public function totalOrderPrice($user_code)
    {

        $totalPrice = $this->qb->select('sum(od.pt_dcprice) as total ')
                ->from(TBL_SHOP_ORDER_DETAIL . " as od")
                ->join(TBL_SHOP_ORDER . ' as o', 'o.oid = od.oid', 'inner')
                ->where('od.status', ORDER_STATUS_BUY_FINALIZED)
                ->where('o.user_code', $user_code)
                ->where('od.mall_ix',MALL_IX)
                ->exec()->getRowArray();

        $beforPrice = $this->qb
                        ->select('decimal_price as total ')
                        ->from(TBL_MEMBER_PAYMENT_INFO)
                        ->where('code',$user_code)
                        ->where('mall_ix',MALL_IX)
            ->exec()->getRowArray();

        $sumTotal = $totalPrice['total'] + $beforPrice['total'];
        return $sumTotal;
    }

    /**
     * get 클레임 사유
     * @param type $oid
     * @param type $odIx
     * @param type $claimType
     * @return type
     */
    public function getOrderCalimReason($oid, $odIx, $claimType)
    {
        $applyStatus = ($claimType == 'I' ? ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE : $claimType . 'A');

        if ($applyStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
            $searchStatus = [ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE];
        } else {
            $searchStatus = [$claimType . 'A'];
            if ($applyStatus == ORDER_STATUS_CANCEL_APPLY) {
                $searchStatus[] = ORDER_STATUS_CANCEL_COMPLETE;
            } else {
                $searchStatus[] = $claimType . 'I';
            }
        }

        $row = $this->qb
            ->select('status_message')
            ->select('reason_code')
            ->from(TBL_SHOP_ORDER_STATUS)
            ->where('oid', $oid)
            ->where('od_ix', $odIx)
            ->whereIn('status', $searchStatus)
            ->whereNotIn('reason_code', [''])
            ->orderBy('regdate', 'DESC')
            ->limit(1)
            ->exec()
            ->getRowArray();


        // ***  취소 사유 추가
        $resultReasons = $this->qb
            ->select('od_ix')
            ->select('status_message')
            ->select('reason_code')
            ->from(TBL_SHOP_ORDER_STATUS)
            ->where('oid', $oid)
            ->whereIn('status', $searchStatus)
            ->whereNotIn('reason_code', [''])
            ->orderBy('od_ix', 'ASC')
            ->exec()
            ->getResultArray();


        if ($applyStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
            $fkey = ORDER_STATUS_INCOM_READY;
            $applyStatus = ORDER_STATUS_CANCEL_APPLY;
        } else if ($applyStatus == ORDER_STATUS_CANCEL_APPLY) {
            $fkey = ORDER_STATUS_INCOM_COMPLETE;
        } else {
            $fkey = ORDER_STATUS_DELIVERY_COMPLETE;
        }


        $ccReasonData = [];
        foreach ($resultReasons as $p => $v) {
            $ccReasonData[$v['od_ix']]['reason_code'] = $v['reason_code'];
            $ccReasonData[$v['od_ix']]['status_message'] = $v['status_message'];
            $reason_text = ForbizConfig::getOrderSelectStatus('F', $fkey, $applyStatus, $v['reason_code'], 'title');
            if (empty($reason_text)) {
                $reason_text = ForbizConfig::getOrderSelectStatus('A', $fkey, $applyStatus, $row['reason_code'], 'title');
            }
            $ccReasonData[$v['od_ix']]['reason_text'] = $reason_text;
        }

        $type_text = ForbizConfig::getOrderSelectStatus('F', $fkey, $applyStatus, $row['reason_code'], 'title');
        $responsibility_type = ForbizConfig::getOrderSelectStatus('F', $fkey, $applyStatus, $row['reason_code'], 'type');

        if (empty($type_text)) {
            $type_text = ForbizConfig::getOrderSelectStatus('A', $fkey, $applyStatus, $row['reason_code'], 'title');
            $responsibility_type = ForbizConfig::getOrderSelectStatus('A', $fkey, $applyStatus, $row['reason_code'], 'type');
        }


        return [
            'type_text' => $type_text
            , 'detail_text' => $row['status_message']
            , 'responsibility_type' => $responsibility_type
            , 'reason_data' => $ccReasonData
        ];
    }

    /**
     * 크리마
     * 구매확정 적용 api
     *
     */
    public function cremaOrderBfUpdate($od_ix)
    {

        $rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('od.dc_date')
            ->select('od.dr_date')
            ->select('od.di_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od_ix', $od_ix)
            ->groupBy('o.oid')
            ->orderBy('order_date', 'DESC')
            ->exec()
            ->getResultArray();

        $rows2 = $this->qb
            ->select('oid')
            ->select('od_ix')
            ->select('pid')
            ->select('option_text')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $od_ix)
            ->orderBy('oid', 'DESC')
            ->exec()
            ->getResultArray();

        foreach ($rows2 as $orderDetail) {
            foreach ($rows as $key => $value) {
                if ($orderDetail['oid'] == $value['oid']) {
                    $rows[$key]['orderDetail'][] = $orderDetail;
                    $rows[$key]['pid'] = $orderDetail['pid'];
                    $rows[$key]['option_text'] = $orderDetail['option_text'];
                }
            }
        }

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        foreach ($rows as $key => $val) {

            if ($val['payment_agent_type'] == "W") {
                $device = 'pc';
            } else {
                $device = 'mobile';
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

            //구매자 아이디가 필수
            if ($val['buserid']) {
                $param = ['code' => $val['oid']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['order_date']))
                    , 'total_price' => $val['payment_price'] //주문 실결제금액(쿠폰, 적립금을 제외한 결제 금액)
                    , 'user_code' => $val['buserid']
                    , 'user_name' => $val['bname']
                    , 'user_phone' => $val['bmobile']
                    , 'user_email' => $val['bmail']
                    , 'user_grade_id' => $user_grade_id
                    , 'store_name' => null //오프라인 매장명
                    , 'order_device' => $device
                ];
                $data = $this->cremaModel->putOrderLog($param);
                $data['id'] = $data['response']['id'] ?? 0;
                if (isset($data['error_code']) && $data['error_code'] == '00') {
                    //에러 아닌것
                    $this->insertCremaLog('order', $this->issetJson($param), $this->issetJson($data['response'] ?? null), $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson(null, $data['curl_error'] ?? null));
                } else {
                    //에러인것
                    $this->insertCremaLog('order', $this->issetJson($param), null, $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
                }

                if (isset($val['orderDetail']) && isset($data['id'])) {
                    foreach ($val['orderDetail'] as $od) {
                        $dc_date = null;
                        if ($val['dc_date'] !== null) {
                            $dc_date = date('Y-m-d\TH:i:sO', strtotime($val['dc_date']));
                        }

                        if (!trim($val['option_text'])) {
                            $val['option_text'] = "option:no";
                        }
                        $sub_param = ['order_id' => $data['id'] //crema insert id
                            , 'code' => $od['od_ix']
                            , 'product_code' => (int) $od['pid']
                            , 'price' => $od['pt_dcprice']
                            , 'status' => 'delivery_finished'
                            , 'delivery_started_at' => date('Y-m-d\TH:i:sO', strtotime($val['dr_date']))
                            , 'delivered_at' => $dc_date
                            , 'product_options' => [$val['option_text']]
                        ];
                        $sub_data = $this->cremaModel->postSubJsonOrderLog(json_encode($sub_param, JSON_UNESCAPED_UNICODE), $data['id']); //없으면 생성 
                    }
                    if (isset($sub_data['error_code']) && $sub_data['error_code'] == '00') {
                        //에러가 아닌것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), $this->issetJson($sub_data['response'] ?? null), $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson(null, $sub_data['curl_error'] ?? null)
                        );
                    } else {
                        //에러인것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), null, $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson($sub_data['response'] ?? null, $sub_data['curl_error'] ?? null));
                    }
                }
            }
        }
    }

    /**
     * 크리마
     * 구매확정 적용 api
     * cron 용
     *
     */
    public function cremaCronOrderBfList($page, $size = 100)
    {

        $page = $page ?? 1;
        if (!$page) {
            $page = 1;
        }

        $size = $size ?? 100;
        if (!$size) {
            $size = 100;
        }

        $limitMax = ($page * $size) - 1;
        $page = $page - 1;
        $limitMin = $page * $size;

        $rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('o.gp_ix >=', 1)
            ->where('od.status', 'BF') //거래 확정인 것만 찾아서 넣음            
            ->groupBy('o.oid')
            ->orderBy('order_date', 'ASC')
            ->limit($limitMax, $limitMin)
            ->exec()
            ->getResultArray();

        if ($rows) {
            $rows2 = $this->qb
                ->select('oid')
                ->select('od_ix')
                ->select('pid')
                ->select('pt_dcprice')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->whereIn('oid', array_column($rows, 'oid'))
                ->orderBy('oid', 'ASC')
                ->exec()
                ->getResultArray();
            foreach ($rows2 as $key => $val) {
                $this->cremaCronOrderBfUpdate($val['od_ix']);
            }
        }
    }
                    
    /**
     * 해당 주문정보를 강제로로 크리마에 재전송
     * 주문이 BF 인것만 가능
     * @param type $oid
     */
    public function cremaOrderReSend($oid)
    {
        $ret =[];

        $rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od.status', 'BF') //거래 확정인 것만 찾아서 넣음            
            ->where('o.oid',  $oid)
            ->groupBy('o.oid')
            ->orderBy('order_date', 'ASC')            
            ->exec()
            ->getResultArray();

        if ($rows) {
            $rows2 = $this->qb
                ->select('oid')
                ->select('od_ix')
                ->select('pid')
                ->select('pt_dcprice')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->whereIn('oid', array_column($rows, 'oid'))
                ->orderBy('oid', 'ASC')
                ->exec()
                ->getResultArray();
            foreach ($rows2 as $key => $val) {
                $ret[$val['od_ix']] = $this->cremaCronOrderBfUpdate($val['od_ix']);
            }
        }

        return $ret;
    }

    /**
     * 해당 주문정보를 강제로로 크리마에 재전송
     * 주문이 BF 인것만 가능
     * @param type $od_ix
     */
    public function cremaOrderDetailReSend($od_ix){
        $ret =[];

        $rows = $this->qb
            ->select('od.od_ix')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od.status', 'BF') //거래 확정인 것만 찾아서 넣음
            ->where('od.od_ix',  $od_ix)
            ->exec()
            ->getResultArray();

        if ($rows) {
            foreach ($rows as $key => $val) {
                $ret[$val['od_ix']] = $this->cremaCronOrderBfUpdate($val['od_ix']);
            }
        }

        return $ret;
    }
    /**
     * 크리마
     * 구매확정 적용 api
     * cron , hook 용도
     *
     */
    public function cremaCronOrderBfUpdate($od_ix)
    {
        $rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('od.dc_date')
            ->select('od.dr_date')
            ->select('od.di_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od_ix', $od_ix)
            ->groupBy('o.oid')
            ->exec()
            ->getResultArray();

        $rows2 = $this->qb
            ->select('oid')
            ->select('od_ix')
            ->select('pid')
            ->select('option_text')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $od_ix)
            ->orderBy('oid', 'DESC')
            ->exec()
            ->getResultArray();

        foreach ($rows2 as $orderDetail) {
            foreach ($rows as $key => $value) {
                if ($orderDetail['oid'] == $value['oid']) {
                    $rows[$key]['orderDetail'][] = $orderDetail;
                    $rows[$key]['pid'] = $orderDetail['pid'];
                    $rows[$key]['option_text'] = $orderDetail['option_text'];
                }
            }
        }

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        foreach ($rows as $key => $val) {

            if ($val['payment_agent_type'] == "W") {
                $device = 'pc';
            } else {
                $device = 'mobile';
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

            //구매자 아이디가 필수
            if ($val['buserid']) {
                $param = ['code' => $val['oid']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['order_date']))
                    , 'total_price' => $val['payment_price'] //주문 실결제금액(쿠폰, 적립금을 제외한 결제 금액)
                    , 'user_code' => $val['buserid']
                    , 'user_name' => $val['bname']
                    , 'user_phone' => $val['bmobile']
                    , 'user_email' => $val['bmail']
                    , 'user_grade_id' => $user_grade_id
                    , 'store_name' => null //오프라인 매장명
                    , 'order_device' => $device
                ];

                $data = $this->cremaModel->putOrderLog($param);
                $data['id'] = $data['response']['id'] ?? 0;
                if (isset($data['error_code']) && $data['error_code'] == '00') {
                    $this->insertCremaLog('order', $this->issetJson($param), $this->issetJson($data['response'] ?? null), $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson(null, $data['curl_error'] ?? null));
                } else {
                    $this->insertCremaLog('order', $this->issetJson($param), null, $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
                }


                if (isset($val['orderDetail']) && isset($data['id'])) {
                    foreach ($val['orderDetail'] as $od) {
                        $dc_date = null;
                        if ($val['dc_date'] !== null) {
                            $dc_date = date('Y-m-d\TH:i:sO', strtotime($val['dc_date']));
                        }
                        if (!trim($val['option_text']) || !$val['option_text']) {
                            $val['option_text'] = "option:no";
                        }
                        $sub_param = ['order_id' => $data['id'] //crema insert id
                            , 'code' => $od['od_ix']
                            , 'product_code' => (int) $od['pid']
                            , 'price' => $od['pt_dcprice']
                            , 'status' => 'delivery_finished'
                            , 'delivery_started_at' => date('Y-m-d\TH:i:sO', strtotime($val['dr_date']))
                            , 'delivered_at' => $dc_date
                            , 'product_options' => [$val['option_text']]
                        ];
                        $sub_data = $this->cremaModel->postSubJsonOrderLog(json_encode($sub_param, JSON_UNESCAPED_UNICODE), $data['id']); //없으면 생성 
                    }

                    if (isset($sub_data['error_code']) && $sub_data['error_code'] == '00') {
                        //에러가 아닌것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), $this->issetJson($sub_data['response'] ?? null), $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson(null, $sub_data['curl_error'] ?? null));
                    } else {
                        //에러인것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), null, $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson($sub_data['response'] ?? null, $sub_data['curl_error'] ?? null));
                    }
                }
            }
        }

        return true;
    }

	/**
     * 크리마
     * 반품신청 api(크리마에는 환불전 상태로 전송)
     * 
     */
	public function cremaOrderReApplySend($od_ix) {
		$rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('od.dc_date')
            ->select('od.dr_date')
            ->select('od.di_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od_ix', $od_ix)
            ->groupBy('o.oid')
            ->exec()
            ->getResultArray();

        $rows2 = $this->qb
            ->select('oid')
            ->select('od_ix')
            ->select('pid')
            ->select('option_text')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $od_ix)
            ->orderBy('oid', 'DESC')
            ->exec()
            ->getResultArray();

        foreach ($rows2 as $orderDetail) {
            foreach ($rows as $key => $value) {
                if ($orderDetail['oid'] == $value['oid']) {
                    $rows[$key]['orderDetail'][] = $orderDetail;
                    $rows[$key]['pid'] = $orderDetail['pid'];
                    $rows[$key]['option_text'] = $orderDetail['option_text'];
                }
            }
        }

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        foreach ($rows as $key => $val) {

            if ($val['payment_agent_type'] == "W") {
                $device = 'pc';
            } else {
                $device = 'mobile';
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

            //구매자 아이디가 필수
            if ($val['buserid']) {
                $param = ['code' => $val['oid']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['order_date']))
                    , 'total_price' => $val['payment_price'] //주문 실결제금액(쿠폰, 적립금을 제외한 결제 금액)
                    , 'user_code' => $val['buserid']
                    , 'user_name' => $val['bname']
                    , 'user_phone' => $val['bmobile']
                    , 'user_email' => $val['bmail']
                    , 'user_grade_id' => $user_grade_id
                    , 'store_name' => null //오프라인 매장명
                    , 'order_device' => $device
                ];

                $data = $this->cremaModel->putOrderLog($param);
                $data['id'] = $data['response']['id'] ?? 0;
                if (isset($data['error_code']) && $data['error_code'] == '00') {
                    $this->insertCremaLog('order', $this->issetJson($param), $this->issetJson($data['response'] ?? null), $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson(null, $data['curl_error'] ?? null));
                } else {
                    $this->insertCremaLog('order', $this->issetJson($param), null, $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
                }


                if (isset($val['orderDetail']) && isset($data['id'])) {
                    foreach ($val['orderDetail'] as $od) {
                        $dc_date = null;
                        if ($val['dc_date'] !== null) {
                            $dc_date = date('Y-m-d\TH:i:sO', strtotime($val['dc_date']));
                        }
                        if (!trim($val['option_text']) || !$val['option_text']) {
                            $val['option_text'] = "option:no";
                        }
                        $sub_param = ['order_id' => $data['id'] //crema insert id
                            , 'code' => $od['od_ix']
                            , 'product_code' => (int) $od['pid']
                            , 'price' => $od['pt_dcprice']
                            , 'status' => 'refund_requested'
                            , 'delivery_started_at' => date('Y-m-d\TH:i:sO', strtotime($val['dr_date']))
                            , 'delivered_at' => $dc_date
                            , 'product_options' => [$val['option_text']]
                        ];
                        $sub_data = $this->cremaModel->postSubJsonOrderLog(json_encode($sub_param, JSON_UNESCAPED_UNICODE), $data['id']); //없으면 생성 
                    }

                    if (isset($sub_data['error_code']) && $sub_data['error_code'] == '00') {
                        //에러가 아닌것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), $this->issetJson($sub_data['response'] ?? null), $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson(null, $sub_data['curl_error'] ?? null));
                    } else {
                        //에러인것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), null, $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson($sub_data['response'] ?? null, $sub_data['curl_error'] ?? null));
                    }
                }
            }
        }

        return true;
	}

	/**
     * 크리마
     * 환불완료 api
     * 
     */
	public function cremaOrderReCompleteSend($od_ix) {
		$rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('od.dc_date')
            ->select('od.dr_date')
            ->select('od.di_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->where('o.buserid IS NOT NULL', '', false)
            ->where('od_ix', $od_ix)
            ->groupBy('o.oid')
            ->exec()
            ->getResultArray();

        $rows2 = $this->qb
            ->select('oid')
            ->select('od_ix')
            ->select('pid')
            ->select('option_text')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $od_ix)
            ->orderBy('oid', 'DESC')
            ->exec()
            ->getResultArray();

        foreach ($rows2 as $orderDetail) {
            foreach ($rows as $key => $value) {
                if ($orderDetail['oid'] == $value['oid']) {
                    $rows[$key]['orderDetail'][] = $orderDetail;
                    $rows[$key]['pid'] = $orderDetail['pid'];
                    $rows[$key]['option_text'] = $orderDetail['option_text'];
                }
            }
        }

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        foreach ($rows as $key => $val) {

            if ($val['payment_agent_type'] == "W") {
                $device = 'pc';
            } else {
                $device = 'mobile';
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

            //구매자 아이디가 필수
            if ($val['buserid']) {
                $param = ['code' => $val['oid']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['order_date']))
                    , 'total_price' => $val['payment_price'] //주문 실결제금액(쿠폰, 적립금을 제외한 결제 금액)
                    , 'user_code' => $val['buserid']
                    , 'user_name' => $val['bname']
                    , 'user_phone' => $val['bmobile']
                    , 'user_email' => $val['bmail']
                    , 'user_grade_id' => $user_grade_id
                    , 'store_name' => null //오프라인 매장명
                    , 'order_device' => $device
                ];

                $data = $this->cremaModel->putOrderLog($param);
                $data['id'] = $data['response']['id'] ?? 0;
                if (isset($data['error_code']) && $data['error_code'] == '00') {
                    $this->insertCremaLog('order', $this->issetJson($param), $this->issetJson($data['response'] ?? null), $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson(null, $data['curl_error'] ?? null));
                } else {
                    $this->insertCremaLog('order', $this->issetJson($param), null, $this->issetJson($data['response_heder'] ?? null), $this->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
                }


                if (isset($val['orderDetail']) && isset($data['id'])) {
                    foreach ($val['orderDetail'] as $od) {
                        $dc_date = null;
                        if ($val['dc_date'] !== null) {
                            $dc_date = date('Y-m-d\TH:i:sO', strtotime($val['dc_date']));
                        }
                        if (!trim($val['option_text']) || !$val['option_text']) {
                            $val['option_text'] = "option:no";
                        }
                        $sub_param = ['order_id' => $data['id'] //crema insert id
                            , 'code' => $od['od_ix']
                            , 'product_code' => (int) $od['pid']
                            , 'price' => $od['pt_dcprice']
                            , 'status' => 'returned'
                            , 'delivery_started_at' => date('Y-m-d\TH:i:sO', strtotime($val['dr_date']))
                            , 'delivered_at' => $dc_date
                            , 'product_options' => [$val['option_text']]
                        ];
                        $sub_data = $this->cremaModel->postSubJsonOrderLog(json_encode($sub_param, JSON_UNESCAPED_UNICODE), $data['id']); //없으면 생성 
                    }

                    if (isset($sub_data['error_code']) && $sub_data['error_code'] == '00') {
                        //에러가 아닌것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), $this->issetJson($sub_data['response'] ?? null), $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson(null, $sub_data['curl_error'] ?? null));
                    } else {
                        //에러인것
                        $this->insertCremaLog('sub_order', $this->issetJson($sub_param), null, $this->issetJson($sub_data['response_heder'] ?? null), $this->issetErrorJson($sub_data['response'] ?? null, $sub_data['curl_error'] ?? null));
                    }
                }
            }
        }

        return true;
	}
        
    public function issetJson($data)
    {
        return ($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
    }

    public function issetErrorJson($arr = [], $arr2 = [])
    {
        $data = ['response_error' => $arr, 'curl_error' => $arr2];
        if ($arr || $arr2) {
            return ($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
        } else {
            return null;
        }
    }

    /**
     * 크리마 관련 로그
     * @param type $type
     * @param type $params
     * @param type $response
     */
    public function insertCremaLog($type, $params, $response, $response_heder, $response_error)
    {
        $this->qb
            ->set('type', $type)
            ->set('params', $params)
            ->set('response', $response)
            ->set('response_heder', $response_heder)
            ->set('response_error', $response_error)
            ->set('regdate', date("Y-m-d H:i:s"))
            ->insert('crema_logs')
            ->exec();
    }

    /**
     * 크리마 주문 연동
     */
    public function cronCremaOrder()
    {
        $sdate = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $edate = date('Y-m-d 23:59:59', strtotime('-1 day'));


        $rows = $this->qb
            ->select('o.oid')
            ->select('o.order_date')
            ->select('o.payment_price')
            ->select('o.buserid')
            ->select('o.bname')
            ->select('o.bmobile')
            ->select('o.bmail')
            ->select('o.gp_ix')
            ->select('o.payment_agent_type')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
            ->betweenDate('od.bf_date', $sdate, $edate)
            ->where('o.buserid IS NOT NULL', '', false)
            ->groupBy('o.oid')
            ->orderBy('order_date', 'DESC')
            ->exec()
            ->getResultArray();

        $rows2 = $this->qb
            ->select('oid')
            ->select('od_ix')
            ->select('pid')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->whereIn('oid', array_column($rows, 'oid'))
            ->betweenDate('bf_date', $sdate, $edate)
            ->orderBy('oid', 'DESC')
            ->exec()
            ->getResultArray();


        foreach ($rows2 as $orderDetail) {
            foreach ($rows as $key => $value) {
                if ($orderDetail['oid'] == $value['oid']) {
                    $rows[$key]['orderDetail'][] = $orderDetail;
                }
            }
        }

//crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);
        foreach ($rows as $key => $val) {

            if ($val['payment_agent_type'] == "W") {
                $device = 'pc';
            } else {
                $device = 'mobile';
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

//구매자 아이디가 필수
            if ($val['buserid']) {
                $param = ['code' => $val['oid']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['order_date']))
                    , 'total_price' => $val['payment_price'] //주문 실결제금액(쿠폰, 적립금을 제외한 결제 금액)
                    , 'user_code' => $val['buserid']
                    , 'user_name' => $val['bname']
                    , 'user_phone' => $val['bmobile']
                    , 'user_email' => $val['bmail']
                    , 'user_grade_id' => $user_grade_id
                    , 'store_name' => null //오프라인 매장명
                    , 'order_device' => $device
                ];
                $data = $this->cremaModel->putOrder($param);

                if (isset($val['orderDetail']) && isset($data['id'])) {
                    foreach ($val['orderDetail'] as $od) {
                        $sub_param = ['order_id' => $data['id'] //crema insert id
                            , 'code' => $od['od_ix']
                            , 'product_code' => (int) $od['pid']
                            , 'price' => $od['pt_dcprice']
                            , 'status' => 'delivery_finished'
                        ];
                        $sub_data = $this->cremaModel->postSubOrder($sub_param);
                    }
                }
            }
        }
    }

    /**
     * 입금전취소 상태 변경
     * @param string $oid
     * @param string $claimReason
     * @param string $claimReasonMsg
     */
    public function updateIncomBeforeCancel($oid, $claimReason, $claimReasonMsg)
    {
        $orderDetails = $this->qb
            ->select('od_ix')
            ->select('pid')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->whereIn('oid', $oid)
            ->whereNotIn('product_type', 77)
            ->exec()
            ->getResultArray();

// update order_detail
        $this->qb
            ->set('status', ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE)
            ->set('update_date', date('Y-m-d H:i:s'))
            ->set('cc_date', date('Y-m-d H:i:s'))
            ->where('oid', $oid)
            ->where('status', ORDER_STATUS_INCOM_READY)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

// update order
        $this->qb
            ->set('status', ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE)
            ->where('oid', $oid)
            ->where('status', ORDER_STATUS_INCOM_READY)
            ->update(TBL_SHOP_ORDER)
            ->exec();

        $msg = array_values($claimReasonMsg);
        foreach ($orderDetails as $p => $v) {
            $data['admin_message'] = '구매자';
            $data['c_type'] = 'B';  // 생성자(B:구매자,S:신청자,M:MD)
            $data['reason_code'] = $claimReason;
            $data['status_message'] = $msg['0'];
            $data['pid'] = $v['pid'];
            $this->insertOrderHistory($oid, $v['od_ix'], ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, $data);
        }

//쿠폰 돌려주기. 전체 취소 혹은 관련 쿠폰으로 사용된 건이 전부 취소되었을 경우 사용함.
//취소한 쿠폰건과 동일하게 사용된 쿠폰이 있는지 discount 확인
//해당 od_ix 들의 정상 배송 프로세스가 있는지 개수 확인. 0이면 현재 주문건이 마지막 주문이므로 복원해주고 아니면 마지막 주문건이 아니므로 복원해주지 않음.
//전체 취소이라서 주문 전체 돌려줌.
        $checkPossibleReturnCoupon = $this->qb
                ->select('od.od_ix')
                ->from(TBL_SHOP_ORDER_DETAIL . ' as od')
                ->join(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as odd', 'od.od_ix=odd.od_ix', 'inner')
                ->where('od.oid', $oid)
                ->whereIn('od.status', [ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE,
                    ORDER_STATUS_BUY_FINALIZED])
                ->where('dc_ix in (select dc_ix from shop_order_detail_discount where oid ="' . $oid . '")')
                ->exec()->getResultArray();

        if (count($checkPossibleReturnCoupon) == 0) {
            $this->couponModel->returnUsedCoupon($oid, ORDER_STATUS_CANCEL_COMPLETE, ['od_ix' => $odIx ?? null]);
        }

//판매진행중 재고 업데이트
        $orderDetails = $this->qb
            ->select('*')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->whereIn('oid', $oid)
            ->exec()
            ->getResultArray();
        foreach ($orderDetails as $k => $v) {
            $this->updateStockWhenClaim($v['pid'], $v['option_id'], $v['pcnt'], $v['stock_use_yn'], $v['gu_ix']);
        }

        $this->doCancelEtc($oid, ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, '입금전 취소에 따른 사용 적립금 재적립');

        return;
    }

    /**
     * 주문 배송지 조회(기본배송지)
     * @overwrite
     * 최근배송지에는 기본배송지, 배송주소록에 있는 주소는 조회안함
     * @param string $userCode
     * @return array
     */
    public function getAddressList($userCode)
    {
//기본 배송지 조회
        $basicList = $this->qb
            ->select('"B" as type')// 주소 타입
            ->select('shipping_name')// 배송명칭
            ->select('recipient')// 수신자명
            ->select('tel')// 전화번호
            ->select('mobile')// 핸드폰번호
            ->select('zipcode')//우편번호
            ->select('address1')// 주소
            ->select('address2')// 상세주소
            ->select('country')// 상세주소
            ->select('city')// 상세주소
            ->select('state')// 상세주소
			->select('default_yn')// 상세주소
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('mem_ix', $userCode)
            ->whereNotIn('mem_ix', [''])
            ->where('default_yn', 'Y')
            ->exec()
            ->getResultArray();

        if (!empty($basicList)) {
            //$recentList = [];
            if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
                $addressBookList = $this->qb
                    ->select('ix')// 배송지키
                    ->select('zipcode')// 우편번호
                    ->select('address1')// 주소
                    ->select('address2')// 상세주소
                    ->select('country')// 상세주소
                    ->select('city')// 상세주소
                    ->select('state')// 상세주소
                    ->from(TBL_SHOP_SHIPPING_ADDRESS)
                    ->where('mem_ix', $userCode)
                    ->where('default_yn != ', 'Y')
                    ->orderBy('ix', 'desc')
                    ->exec()
                    ->getResultArray();

                $this->qb->startCache();

                foreach ($addressBookList as $key => $address) {
                    $this->qb->groupStart()
                        ->orWhere('odd.zip != ', $address['zipcode'])
                        ->orWhere('odd.addr1 != ', $address['address1'])
                        ->orWhere('odd.addr2 != ', $address['address2'])
                        ->groupEnd();
                }
                $this->qb->groupStart()
                    ->orWhere('odd.zip != ', $basicList[0]['zipcode'])
                    ->orWhere('odd.addr1 != ', $basicList[0]['address1'])
                    ->orWhere('odd.addr2 != ', $basicList[0]['address2'])
                    ->groupEnd();

                $this->qb->stopCache();


                /*$recentList = $this->qb
                    ->select('"R" as type')// 주소 타입
                    ->select('"" as shipping_name')// 배송명칭
                    ->select('odd.rname as recipient')// 수신자명
                    ->select('odd.rtel as tel')// 전화번호
                    ->select('odd.rmobile as mobile')// 핸드폰번호
                    ->select('odd.zip as zipcode')//우편번호
                    ->select('odd.addr1 as address1')// 주소
                    ->select('odd.addr2 as address2')// 상세주소
                    ->from(TBL_SHOP_ORDER . ' as o')
                    ->join(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO . ' as odd', 'o.oid=odd.oid and odd.order_type="1"')
                    ->where('o.user_code', $userCode)
                    ->whereNotIn('o.status', [ORDER_STATUS_SETTLE_READY])
                    ->whereNotIn('o.user_code', [''])
                    ->groupBy('zipcode', 'address1', 'address2')
                    ->orderBy('o.order_date', 'desc')
                    ->limit(3)
                    ->exec()
                    ->getResultArray();
                $this->qb->flushCache();*/
            }

            //return array_merge($basicList, $recentList);
			return $basicList;
        } else {
            return [];
        }
    }

	/**
     * 주문 배송지 조회(최근배송지)
     * @overwrite
     * 최근배송지에는 기본배송지, 배송주소록에 있는 주소는 조회안함
     * @param string $userCode
     * @return array
     */
    public function getAddressListOrder($userCode)
    {
        $recentList = $this->qb
			->select('"R" as type')// 주소 타입
			->select('"" as shipping_name')// 배송명칭
			->select('odd.rname as recipient')// 수신자명
			->select('odd.rtel as tel')// 전화번호
			->select('odd.rmobile as mobile')// 핸드폰번호
			->select('odd.zip as zipcode')//우편번호
			->select('odd.addr1 as address1')// 주소
			->select('odd.addr2 as address2')// 상세주소
			->from(TBL_SHOP_ORDER . ' as o')
			->join(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO . ' as odd', 'o.oid=odd.oid and odd.order_type="1"')
			->where('o.user_code', $userCode)
			->whereNotIn('o.status', [ORDER_STATUS_SETTLE_READY])
			->whereNotIn('o.user_code', [''])
			->groupBy('zipcode', 'address1', 'address2')
			->orderBy('o.order_date', 'desc')
			->limit(3)
			->exec()
			->getResultArray();

        if (!empty($recentList)) {
			return $recentList;
        } else {
            return [];
        }
    }

    /**
     * get 취소 사유 조회
     * @param type $oid
     * @param type $odIx
     * @param type $claimType
     * @return type
     */
    public function getOrderCancelReason($oid, $odIx, $status, $fkey)
    {

        if ($status == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
            $searchStatus = [ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, ORDER_STATUS_CANCEL_COMPLETE];
        } else {
            $searchStatus = $status;
        }

        if ($odIx != '' && count($odIx) > 0) {

            $result = $this->qb
                ->select('od_ix')
                ->select('pid')
                ->select('status_message')
                ->select('reason_code')
                ->from(TBL_SHOP_ORDER_STATUS)
                ->where('oid', $oid)
                ->whereIn('od_ix', $odIx)
                ->whereIn('status', $searchStatus)
                ->orderBy('od_ix', 'ASC')
                ->exec()
                ->getResultArray();
        } else {

            $result = $this->qb
                ->select('od_ix')
                ->select('pid')
                ->select('status_message')
                ->select('reason_code')
                ->from(TBL_SHOP_ORDER_STATUS)
                ->where('oid', $oid)
                ->whereIn('status', $searchStatus)
                ->orderBy('od_ix', 'ASC')
                ->exec()
                ->getResultArray();
        }

        $ccReasonData = [];
        foreach ($result as $p => $v) {
            $ccReasonData[$v['pid']]['reason_code'] = $v['reason_code'];
            $ccReasonData[$v['pid']]['status_message'] = $v['status_message'];
            $reason_text = ForbizConfig::getOrderSelectStatus('F', $fkey, $status, $v['reason_code'], 'title');
            if (empty($reason_text)) {
                $reason_text = ForbizConfig::getOrderSelectStatus('A', $fkey, $status, $v['reason_code'], 'title');
            }
            $ccReasonData[$v['pid']]['reason_text'] = $reason_text;
        }

        return ['reason_data' => $ccReasonData];
    }

    /**
     * 주문 배송지 입력
     * @param type $oid
     * @param type $data
     * @param type $od_ix
     * @param type $order_type
     * @return int odd_ix
     */
    public function insertOrderShipping($oid, $data, $od_ix = '', $order_type = '1')
    {

        $this->qb
            ->set('oid', $oid)
            ->set('od_ix', $od_ix)
            ->set('order_type', $order_type)
            ->set('rname', ($data['name'] ?? ''))
            ->set('rtel', ($data['tel'] ?? ''))
            ->set('rmobile', ($data['mobile'] ?? ''))
            ->set('rmail', ($data['email'] ?? ''))
            ->set('zip', ($data['zip'] ?? ''))
            ->set('addr1', ($data['addr1'] ?? ''))
            ->set('addr2', ($data['addr2'] ?? ''))
            ->set('msg_type', ($data['msg_type'] ?? 'D'))
            ->set('msg', ($data['msg'] ?? ''))
            ->set('country', ($data['country'] ?? ''))
            ->set('city', ($data['city'] ?? ''))
            ->set('state', ($data['state'] ?? ''))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
            ->exec();

        return $this->qb->getInsertId();
    }

    /**
     * 주문시 상품 판매진행중 재고 및 주문수량 update
     * @param type $pid
     * @param type $ooptionIx
     * @param type $count
     * @param type $stockUseYn
     * @param type $guIx
     */
    protected function updateProductSellngCnt($pid, $ooptionIx, $count, $stockUseYn, $guIx = '')
    {
        if ($stockUseYn == 'Y') {
//get 진행중 재고
            $sellIngCnt = $this->getProductSellngCnt('inventory', $pid, $ooptionIx, $guIx);

//WMS 데이터 판매 진행 수량 및 주문 수량 수정
            $this->qb
                ->set('sell_ing_cnt', $sellIngCnt)
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_INVENTORY_GOODS_UNIT)
                ->where('gu_ix', $guIx)
                ->exec();

//상품 주문 수량 수정
            $this->qb
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

//글로벌 상품 주문 수량 수정
            $this->qb
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update('shop_product_global')
                ->whereIn('id', $pid)
                ->exec();

//get 옵션에 같은 품목 리스트
            $optionList = $this->qb
                    ->setDatabase('payment')
                    ->select('od.id as opnd_ix')
                    ->select('p.id as pid')
                    ->from(TBL_SHOP_PRODUCT . ' as p')
                    ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as od', 'p.id=od.pid')
                    ->where('p.stock_use_yn', 'Y')
                    ->where('od.option_code', $guIx)
                    ->exec()->getResultArray();

// 등록된 옵션이 있는가?
            if (!empty($optionList)) {
                $optionDetailIdList = [];
                $productIdList = [];
                foreach ($optionList as $option) {
                    $optionDetailIdList[] = $option['opnd_ix'];
                    $productIdList[] = $option['pid'];
                }

                $optionDetailIdList = array_unique($optionDetailIdList);
                $productIdList = array_unique($productIdList);

//옵션 판매 진행 재고 업데이트
                $this->qb
                    ->set('option_sell_ing_cnt', $sellIngCnt)
                    ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                    ->whereIn('id', $optionDetailIdList)
                    ->exec();

//글로벌 옵션 판매 진행 재고 업데이트
                $this->qb
                    ->set('option_sell_ing_cnt', $sellIngCnt)
                    ->update('shop_product_options_detail_global')
                    ->whereIn('id', $optionDetailIdList)
                    ->exec();

//옵션에 같은 품목인 상품 판매진행 수량 업데이트
                foreach ($productIdList as $_pid) {

                    $row = $this->qb
                            ->setDatabase('payment')
                            ->selectSum('option_sell_ing_cnt')
                            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                            ->where('pid', $_pid)
                            ->exec()->getRow();
                    $row->option_sell_ing_cnt;

                    $this->qb
                        ->set('sell_ing_cnt', $row->option_sell_ing_cnt)
                        ->update(TBL_SHOP_PRODUCT)
                        ->whereIn('id', $_pid)
                        ->exec();

//글로벌
                    $this->qb
                        ->set('sell_ing_cnt', $row->option_sell_ing_cnt)
                        ->update('shop_product_global')
                        ->whereIn('id', $_pid)
                        ->exec();
                }
            }

//옵션 없을경우
            $productIdList = $this->qb
                ->setDatabase('payment')
                ->select('p.id as pid')
                ->from(TBL_SHOP_PRODUCT . ' as p')
                ->where('p.stock_use_yn', 'Y')
                ->where('p.pcode', $guIx)
                ->exec()
                ->getResultArray();

            if (!empty($productIdList)) {
                $this->qb
                    ->set('sell_ing_cnt', $sellIngCnt)
                    ->update(TBL_SHOP_PRODUCT)
                    ->whereIn('id', array_column($productIdList, 'pid'))
                    ->exec();

//글로벌
                $this->qb
                    ->set('sell_ing_cnt', $sellIngCnt)
                    ->update('shop_product_global')
                    ->whereIn('id', array_column($productIdList, 'pid'))
                    ->exec();
            }
        } elseif ($stockUseYn == "Q") {
            $this->qb
                ->set('sell_ing_cnt', 'sell_ing_cnt + ' . $count, false)
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

//글로벌
            $this->qb
                ->set('sell_ing_cnt', 'sell_ing_cnt + ' . $count, false)
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update('shop_product_global')
                ->whereIn('id', $pid)
                ->exec();

            $this->qb
                ->set('option_sell_ing_cnt', 'option_sell_ing_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                ->whereIn('id', $ooptionIx)
                ->exec();

//글로벌
            $this->qb
                ->set('option_sell_ing_cnt', 'option_sell_ing_cnt + ' . $count, false)
                ->update('shop_product_options_detail_global')
                ->whereIn('id', $ooptionIx)
                ->exec();
        } else {
            $this->qb
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

//글로벌
            $this->qb
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update('shop_product_global')
                ->whereIn('id', $pid)
                ->exec();
        }
    }

    /**
     * 취소시 재고 업데이트
     * @param string $pid
     * @param int $optionId
     * @param int $count
     * @param string $stockUseYn
     * @param int $guIx
     */
    public function updateStockWhenClaim($pid, $optionId, $count, $stockUseYn, $guIx = '')
    {
        if ($stockUseYn == 'Y') {
            $sellIngCnt = $this->getProductSellngCnt('inventory', $pid, $optionId, $guIx);

//WMS 데이터 판매 진행 수량 및 주문 수량 수정
            $this->qb
                ->set('sell_ing_cnt', $sellIngCnt)
                ->update(TBL_INVENTORY_GOODS_UNIT)
                ->where('gu_ix', $guIx)
                ->exec();

//같은 품목 리스트 출력
            $optionList = $this->qb
                ->select('od.id as opnd_ix')
                ->select('p.id as pid')
                ->from(TBL_SHOP_PRODUCT . ' as p')
                ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as od', 'p.id=od.pid')
                ->where('p.stock_use_yn', 'Y')
                ->where('od.option_code', $guIx)
                ->exec()
                ->getResultArray();

            if (!empty($optionList)) {
                $optionDetailIdList = [];
                $productIdList = [];
                foreach ($optionList as $option) {
                    $optionDetailIdList[] = $option['opnd_ix'];
                    $productIdList[] = $option['pid'];
                }

                $optionDetailIdList = array_unique($optionDetailIdList);
                $productIdList = array_unique($productIdList);

//옵션 판매 진행 재고 업데이트
                $this->qb
                    ->set('option_sell_ing_cnt', $sellIngCnt)
                    ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                    ->whereIn('id', $optionDetailIdList)
                    ->exec();

//글로벌 옵션 판매 진행 재고 업데이트
                $this->qb
                    ->set('option_sell_ing_cnt', $sellIngCnt)
                    ->update('shop_product_options_detail_global')
                    ->whereIn('id', $optionDetailIdList)
                    ->exec();

//옵션에 같은 품목인 상품 판매진행 수량 업데이트
                foreach ($productIdList as $_pid) {

                    $row = $this->qb
                        ->selectSum('option_sell_ing_cnt')
                        ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                        ->where('pid', $_pid)
                        ->exec()
                        ->getRow();
                    $row->option_sell_ing_cnt;

                    $this->qb
                        ->set('sell_ing_cnt', $row->option_sell_ing_cnt)
                        ->update(TBL_SHOP_PRODUCT)
                        ->whereIn('id', $_pid)
                        ->exec();

//글로벌
                    $this->qb
                        ->set('sell_ing_cnt', $row->option_sell_ing_cnt)
                        ->update('shop_product_global')
                        ->whereIn('id', $_pid)
                        ->exec();
                }
            }

//옵션 없을경우
            $productIdList = $this->qb
                ->select('p.id as pid')
                ->from(TBL_SHOP_PRODUCT . ' as p')
                ->where('p.stock_use_yn', 'Y')
                ->where('p.pcode', $guIx)
                ->exec()
                ->getResultArray();

            if (!empty($productIdList)) {
                $this->qb
                    ->set('sell_ing_cnt', $sellIngCnt)
                    ->update(TBL_SHOP_PRODUCT)
                    ->whereIn('id', array_column($productIdList, 'pid'))
                    ->exec();

//글로벌
                $this->qb
                    ->set('sell_ing_cnt', $sellIngCnt)
                    ->update('shop_product_global')
                    ->whereIn('id', array_column($productIdList, 'pid'))
                    ->exec();
            }
        } elseif ($stockUseYn == "Q") {
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

//글로벌
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update('shop_product_global')
                ->whereIn('id', $pid)
                ->exec();

            if ($optionId > 0) {
                $this->qb
                    ->set('option_sell_ing_cnt', '(CASE WHEN IFNULL(option_sell_ing_cnt,0) > ' . $count . ' THEN option_sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                    ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                    ->whereIn('id', $optionId)
                    ->exec();

//글로벌
                $this->qb
                    ->set('option_sell_ing_cnt', '(CASE WHEN IFNULL(option_sell_ing_cnt,0) > ' . $count . ' THEN option_sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                    ->update('shop_product_options_detail_global')
                    ->whereIn('id', $optionId)
                    ->exec();
            }
        } else {
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

//글로벌
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update('shop_product_global')
                ->whereIn('id', $pid)
                ->exec();
        }

        return;
    }

    /**
     * 주문내역을 검색한다.
     * @param string $code
     * @param array $searchData
     * @param int $cur_page
     * @param int $per_page
     * @param boolean $is_paging
     * @return type
     */
    public function getOrderHistory($userCode, $searchData, $cur_page = 1, $per_page = 10, $is_paging = true)
    {
// qb 캐시 스타트
        $this->qb->startCache();

// 검색 조건
        if (isset($searchData['pname']) && $searchData['pname'] != '') {
            $this->qb->like('od.pname', $searchData['pname']);
        }

        if (isset($searchData['sDate']) && $searchData['sDate'] != '') {
            $this->qb->where('o.order_date >=', $searchData['sDate'] . ' 00:00:00');
        }

        if (isset($searchData['eDate']) && $searchData['eDate'] != '') {
            $this->qb->where('o.order_date <=', $searchData['eDate'] . ' 23:59:59');
        }

        if (isset($searchData['status']) && !empty($searchData['status'])) {
            $this->qb->whereIn('od.status', (is_array($searchData['status']) ? $searchData['status'] : [$searchData['status']]));
        }

        if (isset($searchData['oid']) && $searchData['oid'] != '') {
            $this->qb->where('o.oid', $searchData['oid']);
        }

        $this->qb
            ->from(TBL_SHOP_ORDER . ' AS o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS od', 'o.oid = od.oid')
            ->where('o.user_code', $userCode)
            ->where('od.gift_type', 'N') // 사은품 제외
            ->where('od.status !=', ORDER_STATUS_SETTLE_READY);

// qb 캐시 스톱
        $this->qb->stopCache();

// 페이징 여부 확인
        if ($is_paging) {
            $total = $this->qb->getCount('DISTINCT o.oid');
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit = $per_page;
            $offset = $paging['offset'];
        } else {
            $total = $this->qb->getCount();
            $limit = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

// Limit 설정 및 데이터 추출
        $orderList = $this->qb
            ->distinct()
            ->select("date_format(o.order_date, '%Y-%m-%d') order_date", false)
            ->select('o.oid')
            ->select('o.payment_price')
            ->orderBy('oid', 'desc')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

// qb 캐시 리셋
        $this->qb->flushCache();

        $list = [];

// 주문상세를 조합한다.
        if (!empty($orderList)) {
            $oids = array_column($orderList, 'oid');

// 주문상세 조회
            $orderDetail = $this->getOderDetailItems($oids, $searchData);

// 주문상세 조합
            foreach ($orderList as $oItem) {
                if (isset($orderDetail[$oItem['oid']])) {
                    $oItem['orderDetail'] = $orderDetail[$oItem['oid']];
//송장번호가 여러개 일때 앞의 송장번호만 노출
                    $z = 0;

                    //사은품 포함 여부 체크 (부분취소 가능 여부를 판단하기 위함 현재 2020-01-08 일 기준 사은품이 포함된 경우 부분취소는 안되면 전체 취소만 가능함) [S]
                    $orderGiftItem = $this->getOrderGiftItem($oItem['oid'],'all');
                    $partCancelBool = true;
                    if(count($orderGiftItem) > 0){
                        $partCancelBool = false;
                    }

                    //사은품 포함 여부 체크 (부분취소 가능 여부를 판단하기 위함 현재 2020-01-08 일 기준 사은품이 포함된 경우 부분취소는 안되면 전체 취소만 가능함) [E]

                    foreach ($oItem['orderDetail'] as $item) {
                        $oItem['orderDetail'][$z]['pname'] = html_entity_decode(stripslashes($item['pname']), ENT_QUOTES);;
                        if (strpos($item['invoice_no'], ',') !== false) {
                            $invoice = explode(',', $item['invoice_no']);
                            $oItem['orderDetail'][$z]['invoice_no'] = $invoice[0];
                        }
                        $oItem['orderDetail'][$z]['partCancelBool'] = $partCancelBool;
                        $z++;
                    }
                    $list[] = $oItem;
                }
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 배송사별 조회 정보
     * @param string $delivery_company
     * @return array
     */
    public function searchGoodsFlow($delivery_company)
    {
//굿스플로 사용여부체크
        $goodsflowYn = $this->qb
            ->select('api_yn')
            ->select('site_domain')
            ->select('si.site_id')
            ->select('api_yn')
            ->select('target_code')
            ->from('sellertool_site_info as si')
            ->join('sellertool_etc_linked_relation as elr', 'si.site_code = elr.site_code')
            ->where('si.site_code', 'goodsflow')
            ->where('origin_code', $delivery_company)
            ->limit(1)
            ->exec()
            ->getRowArray();

        $info = $this->qb
            ->select('code_etc1')
            ->select('code_etc3')
            ->select('code_etc4')
            ->select('code_ix')
            ->from(TBL_SHOP_CODE)
            ->where('code_gubun', '02')
            ->where('code_ix', $delivery_company)
            ->limit(1)
            ->exec()
            ->getRowArray();

        $info['goodsflowYn'] = 'N';

        if (!empty($goodsflowYn)) {
            $info['goodsflowYn'] = 'Y';
            $info['goodsflow'] = $goodsflowYn;
        }

        return $info;
    }

    /**
     * 결제 처리
     * @param $oid
     * @param $payMethod
     * @param $status
     * @param bool $paymentPrice
     * @param array $payment
     * @return array
     */
    public function payment($oid, $payMethod, $status, $paymentPrice = false, $payment = [])
    {
        $returnData = [
            'result' => true
            , 'message' => ''
        ];
        //회원 세션 누락 체크 세션 관련 쿠키 삭제 발생으로 주문데이터의 user_code 이용 하도록

        if(empty(sess_val('user', 'code'))){
            $user_data = $this->qb
                ->setDatabase('payment')
                ->select('o.user_code')
                ->select('o.gp_ix')
                ->select('g.use_reserve_yn')
                ->from(TBL_SHOP_ORDER ." as o")
                ->join(TBL_SHOP_GROUPINFO ." as g" ,'o.gp_ix = g.gp_ix' ,'left')
                ->where('o.oid',$oid)
                ->whereNotIn('o.user_code','')
                ->exec()->getRowArray();
            if(!empty($user_data)){
                $this->mileageModel->setMember($user_data['user_code'], $user_data['gp_ix'], $user_data['use_reserve_yn']);
                $this->userInfo->code = $user_data['user_code'];
            }
        }

//금액 비교
        if ($paymentPrice !== false) {
            $this->qb
                ->setDatabase('payment')
                ->select()
                ->from(TBL_SHOP_ORDER_PAYMENT)
                ->where('oid', $oid)
                ->where('method', $payMethod)
                ->where('payment_price', $paymentPrice)
                ->exec();

            if (!$this->qb->total) {
                $returnData = [
                    'result' => false
                    , 'message' => '금액 검증 실패'
                ];
                return $returnData;
            }
        }

//재고확인
        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');
        $products = $this->getOrderProduct($oid);
        $cartIxs = array_unique(array_column($products, 'cart_ix'));
        $cartList = $cartModel->get($cartIxs);
        if (!$cartModel->checkAllProductStatusSale($cartList)) {
            $returnData = [
                'result' => false
                , 'message' => '주문하실 상품중에 품절상품이 있습니다.'
            ];
            return $returnData;
        }

//shop_order update
        $this->qb
            ->set('status', $status)
            ->update(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->exec();

//shop_order_detail update
        if ($status == ORDER_STATUS_INCOM_COMPLETE) {
            $this->qb->set('ic_date', date('Y-m-d H:i:s'));
        }
        $this->qb
            ->set('status', $status)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->exec();

//shop_order_price insert
        if ($status == ORDER_STATUS_INCOM_COMPLETE) {
            $price = $this->qb
                    ->setDatabase('payment')
                    ->select('expect_product_price')
                    ->select('expect_delivery_price')
                    ->from(TBL_SHOP_ORDER_PRICE)
                    ->where('oid', $oid)
                    ->exec()->getRow();
            if ($price->expect_product_price > 0) {
                $priceData = [];
                $priceData['payment_price'] = $price->expect_product_price;
                $this->insertOrderPrice($oid, 'G', 'P', $priceData);
            }
            if ($price->expect_delivery_price > 0) {
                $priceData = [];
                $priceData['payment_price'] = $price->expect_delivery_price;
                $this->insertOrderPrice($oid, 'G', 'D', $priceData);
            }
        }

//shop_order_payment update
        if ($status == ORDER_STATUS_INCOM_COMPLETE) {
            $this->qb->set('ic_date', date('Y-m-d H:i:s'));
        }
        if ($payMethod != ORDER_METHOD_BANK) {
            $this->qb
                ->set('bank', ($payment['bank'] ?? ''))
                ->set('bank_account_num', ($payment['bank_account_num'] ?? ''))
                ->set('bank_input_date', ($payment['bank_input_date'] ?? ''))
                ->set('bank_input_name', ($payment['bank_input_name'] ?? ''));
        }
        $this->qb
            ->set('pay_status', $status)
            ->set('settle_module', ($payment['settle_module'] ?? ''))
            ->set('tid', ($payment['tid'] ?? ''))
            ->set('authcode', ($payment['authcode'] ?? ''))
            ->set('memo', ($payment['memo'] ?? ''))
            ->set('escrow_use', ($payment['escrow_use'] ?? 'N'))
            ->set('receipt_yn', ($payment['receipt_yn'] ?? 'N'))
			->set('receipt_code', ($payment['receipt_code'] ?? ''))
			->set('receipt_info', ($payment['receipt_info'] ?? ''))
            ->update(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', $payMethod)
            ->exec();

//shop_order_history insert
        $historyData = [];
        $historyData['status_message'] = ForbizConfig::getPaymentMethod($payMethod) . ' 완료';
        $historyData['admin_message'] = 'system';
        $this->insertOrderHistory($oid, '', $status, $historyData);

//상품 진행중 수량 처리
        $productList = $this->qb
                ->setDatabase('payment')
                ->select('pid')
                ->select('option_id')
                ->select('pcnt')
                ->select('stock_use_yn')
                ->select('gu_ix')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->where('oid', $oid)
                ->exec()->getResultArray();
        foreach ($productList as $product) {
            $this->updateProductSellngCnt($product['pid'], $product['option_id'], $product['pcnt'], $product['stock_use_yn'], $product['gu_ix']);
        }

//마일리지 사용 처리
        $row = $this->qb
            ->setDatabase('payment')
            ->select('opay_ix')
            ->select('payment_price')
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', ORDER_METHOD_RESERVE)
            ->exec()
            ->getRow();

        if ($this->qb->total) {

            if(BASIC_LANGUAGE == 'english'){
                $message = $oid . " Order use";
            }else{
                $message = $oid . " 주문 사용";
            }

            $this->mileageModel->useMileage($row->payment_price, 1, $message, ['oid' => $oid]);

            $this->qb
                ->set('pay_status', ORDER_STATUS_INCOM_COMPLETE)
                ->update(TBL_SHOP_ORDER_PAYMENT)
                ->where('opay_ix', $row->opay_ix)
                ->exec();
        }

//쿠폰 사용 처리
        $rows = $this->qb
            ->setDatabase('payment')
            ->select('dd.dc_ix as regist_ix')
            ->select('od.pid')
            ->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as dd')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'dd.oid=od.oid and dd.od_ix=od.od_ix', 'left')
            ->where('dd.oid', $oid)
            ->whereIn('dd.dc_type', ['CP','DCP'])
            ->exec()
            ->getResult();

        if ($this->qb->total) {
            /* @var $couponeModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            foreach ($rows as $row) {
                $couponModel->useCoupon($row->regist_ix, $oid, $row->pid);
            }
        }
//회원일 경우 최근 주문일 업데이트
        if (!empty($this->userInfo->code)) {
            $this->qb
                ->set('recent_order_date', date('Y-m-d H:i:s'))
                ->update(TBL_COMMON_MEMBER_DETAIL)
                ->where('code', $this->userInfo->code)
                ->exec();
        }
        return $returnData;
    }

    /**
     * 결제전 주문 여부
     * @param type $oid
     * @param type $method
     * @param type $status
     * @return type
     */
    public function isOrderSettleReady($oid, $method, $status = [ORDER_STATUS_SETTLE_READY])
    {
        $this->qb
            ->setDatabase('payment')
            ->select('o.oid')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_PAYMENT . ' as op', 'o.oid=op.oid and op.pay_type="G" and op.method="' . $method . '"')
            ->where('o.oid', $oid)
            ->whereIn('o.status', $status)
            ->exec();
        return ($this->qb->total > 0 ? true : false);
    }

    public function getGiftItemStockCheck($giftData){
        $giftStockBool = true;
        $result = [];
        if (is_array($giftData)) {
            foreach ($giftData as $key => $val) {

                $this->qb->where('p.id', $key);
                $selectCnt = $val;

                $prows = $this->qb
                    ->select('p.stock')
                    ->select('p.pname')
                    ->select('p.sell_ing_cnt')
                    ->select('p.disp')
                    ->select('p.state')
                    ->from(TBL_SHOP_PRODUCT . ' AS p')
                    ->exec()->getRowArray()
                ;
                $stock = $prows['stock'] - $prows['sell_ing_cnt'];
                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');
                $status = $productModel->setStatus($prows['disp'], $prows['state'], $stock);

                if ($status != 'sale' || $stock < $selectCnt) {
                    $giftStockBool = false;
                    $result['stock'] = $stock;
                    $result['pname'] = $prows['pname'];
                    $result['status'] = $status;
                    break;
                }
            }
        }
        $result['giftStockBool'] = $giftStockBool;


        return $result;
    }
    public function getGiftItemStock($giftData)
    {

        $giftStockBool = true;
        $result = [];
        if (is_array($giftData)) {
            foreach ($giftData as $key => $val) {

                //주문진행 시 체크되는 상품 코드는 giftPid 를 사용 하고 구매금액별 사은품 관리시 체크하는 상품 코드는 pid 를 사용하기에 값에 대한 분기 처리 진행 JK191119
                if (isset($val['giftPid'])) {
                    $this->qb->where('p.id', $val['giftPid']);
                    $selectCnt = $val['giftCount'];
                } else {
                    $this->qb->where('p.id', $val['pid']);
                    $selectCnt = $val['cnt'];
                }
                $prows = $this->qb
                        ->select('p.stock')
                        ->select('p.pname')
                        ->select('p.sell_ing_cnt')
                        ->select('p.disp')
                        ->select('p.state')
                        ->from(TBL_SHOP_PRODUCT . ' AS p')
                        ->exec()->getRowArray()
                ;
                $stock = $prows['stock'] - $prows['sell_ing_cnt'];
                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');
                $status = $productModel->setStatus($prows['disp'], $prows['state'], $stock);

                if ($status != 'sale' || $stock < $selectCnt) {
                    $giftStockBool = false;
                    $result['stock'] = $stock;
                    $result['pname'] = $prows['pname'];
                    $result['status'] = $status;
                    $result['freegift_condition'] = $val['freegift_condition'];
                    break;
                }
            }
        }
        $result['giftStockBool'] = $giftStockBool;


        return $result;
    }

    /**
     * 사은품 지급 수량 검증
     */
    public function getGiftItemCntCheck($giftData){
        $giftCntBool = true;
        $result = [];

        if (is_array($giftData)) {
            foreach ($giftData as $key => $val) {

                //주문진행 시 체크되는 상품 코드는 giftPid 를 사용 하고 구매금액별 사은품 관리시 체크하는 상품 코드는 pid 를 사용하기에 값에 대한 분기 처리 진행 JK191119
                if (isset($val['giftPid'])) {
                    $selectCnt = $val['giftCount'];
                } else {
                    $selectCnt = $val['cnt'];
                }
                $prows = $this->qb
                    ->select('p.gift_cnt')
                    ->from(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS p')
                    ->where('p.fg_ix',$val['fgIx'])
                    ->exec()->getRowArray()
                ;
                $gift_cnt = $prows['gift_cnt'];

                if ($gift_cnt != $selectCnt ) {
                    $giftCntBool = false;
                    $result['freegift_condition'] = $val['freegift_condition'];
                    break;
                }
            }
        }
        $result['giftCntBool'] = $giftCntBool;


        return $result;
    }

    /**
     * 물류센터 확인 후 배송준비중 상태로 변경
     */
    public function updateDeliveryReady($oid, $od_ix) {
        //상태값 변경
        $this->qb
            ->set('status', ORDER_STATUS_DELIVERY_READY)
            ->set('update_date', date('Y-m-d H:i:s'))
            ->set('dr_date', date('Y-m-d H:i:s'))
            ->where('oid', $oid)
            ->where('od_ix', $od_ix)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        //pid 구하기
        $info = $this->qb
            ->select('pid')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('od_ix', $od_ix)
            ->exec()->getRow();

        //상품 사은품 상태값 변경 -> 사은품은 재고부족으로 안나갈 수도 있어서 상태값 변경처리 X, ERP처리대로 처리
//        $this->qb
//            ->set('status', ORDER_STATUS_DELIVERY_READY)
//            ->set('update_date', date('Y-m-d H:i:s'))
//            ->set('dr_date', date('Y-m-d H:i:s'))
//            ->where('oid', $oid)
//            ->where('parent_od_ix', $od_ix)
//            ->where('gift_type', 'G')
//            ->update(TBL_SHOP_ORDER_DETAIL)
//            ->exec();


        //히스토리 데이터 세팅
        $history_data = array();
        $history_data['status_message'] = '구매자 취소요청 시 실제물류상태에 따른 입금확인 -> 배송준비 상태변경';
        $history_data['admin_message'] = 'system';
        $history_data['data_channer'] = 1;
        $history_data['pid'] = $info->pid;
        $history_data['c_type'] = "B"; // 생성자(B:구매자,S:신청자,M:MD)

        //히스토리 추가
        $this->insertOrderHistory($oid, $od_ix, ORDER_STATUS_DELIVERY_READY, $history_data);
    }

    /**
     * 주문 데이터 사은품 항목 추출
     */
    public function getOrderGiftItem($oid,$gifyType=''){

        if($gifyType == 'G'){
            //상품별 사은품
            $this->qb->where('gift_type','G');
        }else if($gifyType == 'P'){
            //구매금액별 사은품
            $this->qb->where('gift_type','P');
        }

        $datas = $this->qb
            ->select('pid')
            ->select('pname')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid',$oid)
            ->where('product_type','77')
            ->exec()->getResultArray()
        ;

        return $datas;
    }

    /**
     * 배송지 번호로 불러오기
     */
    public function getDeliveryAddress($deliveryIx) {

        return $this->qb
            ->select('recipient')
            ->select('zipcode')
            ->select('address1')
            ->select('address2')
            ->select('mobile')
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('ix', $deliveryIx)
            ->exec()->getRow();
    }

    /**
     * 주문 배송비 정보 입력
     * @param type $oid
     * @param type $data
     * @return type
     */
    public function insertOrderDelivery($oid, $data)
    {
        $this->qb
            ->set('oid', $oid)
            ->set('company_id', ($data['company_id'] ?? ''))
            ->set('dt_ix', ($data['dt_ix'] ?? ''))
            ->set('delivery_price', ($data['delivery_price'] ?? ''))
            ->set('delivery_dcprice', ($data['delivery_dcprice'] ?? ''))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->set('delivery_pay_type',1)
            ->insert(TBL_SHOP_ORDER_DELIVERY)
            ->exec();

        return $this->qb->getInsertId();
    }

    /**
     * 취소/교환/반품 주문 조회
     * @param string $userCode
     * @param array $searchData
     * @param int $cur_page
     * @param int $per_page
     * @param int $is_paging
     * @return array
     */
    public function getReturnHistory($userCode, $searchData, $cur_page = 1, $per_page = 10, $is_paging = true)
    {
        // qb 캐시 스타트
        $this->qb->startCache();

        // 검색 조건
        if (isset($searchData['pname']) && $searchData['pname'] != '') {
            $this->qb->like('od.pname', $searchData['pname']);
        }

        if (isset($searchData['sDate']) && $searchData['sDate'] != '') {
            $this->qb->where('o.order_date >=', $searchData['sDate'] . ' 00:00:00');
        }

        if (isset($searchData['eDate']) && $searchData['eDate'] != '') {
            $this->qb->where('o.order_date <=', $searchData['eDate'] . ' 23:59:59');
        }

        if (!empty($searchData['status'])) {
            $this->qb->whereIn('od.status', (is_array($searchData['status']) ? $searchData['status'] : [$searchData['status']]));
        }

        if (isset($searchData['oid']) && $searchData['oid'] != '') {
            $this->qb->where('o.oid', $searchData['oid']);
        }

        $this->qb
            ->from(TBL_SHOP_ORDER . ' AS o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS od', 'o.oid = od.oid')
            ->where('o.user_code', $userCode);

        // qb 캐시 스톱
        $this->qb->stopCache();

        // 페이징 여부 확인
        if ($is_paging) {
            $paging = $this->qb
                ->setTotalRows($this->qb->getCount('DISTINCT o.oid, od.claim_group'))
                ->pagination($cur_page, $per_page);

            $limit = $per_page;
            $offset = $paging['offset'];
            $total = $paging['per_page'];
        } else {
            $limit = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
            $total = $this->qb->getCount();
        }

        // Limit 설정 및 데이터 추출
        $orderList = $this->qb
            ->distinct()
            ->select('o.oid')
            ->select('od.claim_group')
            ->orderBy('od.update_date', 'desc')
            ->orderBy('oid', 'desc')
            ->orderBy('od.pid')
            ->orderBy("(case od.option_kind when 'a' then 'ZZZZZZ' else od.option_kind end)", 'asc', false)
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        // qb 캐시 리셋
        $this->qb->flushCache();

        $list = [];

        // 주문상세를 조합한다.
        if (!empty($orderList)) {
            $oids = array_column($orderList, 'oid');
            $claimGroup = array_unique(array_column($orderList, 'claim_group'));

            // 주문상세 조회
            $orderDetail = $this->getOderDetailItems($oids, $searchData, $claimGroup);

            // 주문상세 조합
            foreach ($orderList as $oItem) {
                if (isset($orderDetail[$oItem['oid']])) {
                    foreach ($orderDetail[$oItem['oid']] as $climGroup => $odItem) {
                        if ($climGroup == $oItem['claim_group']) {
                            $oItem['claim_date'] = $odItem[0]['claim_date'];
                            $odItem[0]['pname'] = html_entity_decode(stripslashes($odItem[0]['pname']),ENT_QUOTES);
                            $oItem['orderDetail'] = $odItem;
                            $list[] = $oItem;
                        }
                    }
                }
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 해당 주문의 현재 상태 체크(배송지변경시 체크)
     * @param $oid
     * @return array|mixed
     */
    public function getOrderStatus($oid)
    {
        return $this->qb
            ->select('status')
            ->from(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->exec()->getRowArray();
    }

    /**
     * 주문 상태값 변경
     * @param $oid
     * @param $status
     * @return bool|NunaResult
     */
    public function setOrderStatus($oid, $status) {

        return $this->qb
            ->set('status', $status)
            ->where('oid', $oid)
            ->update(TBL_SHOP_ORDER)
            ->exec();
    }

    /**
     * 주문 금액 등록
     * @param type $oid
     * @param type $paymentStatus
     * @param type $priceDiv
     * @param type $data
     */
    public function insertOrderPrice($oid, $paymentStatus, $priceDiv, $data)
    {
        $expect_price = ($data['expect_price'] ?? 0);
        $payment_price = ($data['payment_price'] ?? 0);
        $reserve = ($data['reserve'] ?? 0);

        $this->qb
            ->set('oid', $oid)
            ->set('od_ix', ($data['od_ix'] ?? ''))
            ->set('payment_status', $paymentStatus)
            ->set('price_div', $priceDiv)
            ->set('expect_price', $expect_price)
            ->set('payment_price', $payment_price)
            ->set('reserve', $reserve)
            ->set('claim_group', ($data['claim_group'] ?? 0))
            ->set('msg', ($data['msg'] ?? ''))
            ->set('charger', ($data['charger'] ?? ''))
            ->set('charger_ix', ($data['charger_ix'] ?? ''))
            ->set('regdate', 'NOW()', false)
            ->insert(TBL_SHOP_ORDER_PRICE_HISTORY)
            ->exec();

        $row = $this->qb
            ->setDatabase('payment')
            ->select('op_ix')
            ->from(TBL_SHOP_ORDER_PRICE)
            ->where('oid', $oid)
            ->where('payment_status', $paymentStatus)
            ->exec()
            ->getRow();

        if ($priceDiv == 'D') {
            if ($expect_price > 0) {
                $this->qb->set('expect_delivery_price', $expect_price);
            }
            if ($payment_price > 0) {
                $this->qb->set('delivery_price', $payment_price);
            }
        } else {
            if ($expect_price > 0) {
                $this->qb->set('expect_product_price', $expect_price);
            }
            if ($payment_price > 0) {
                $this->qb->set('product_price', $payment_price);
            }
        }
        if ($reserve > 0) {
            $this->qb->set('reserve', $reserve);
        }
        if (isset($row->op_ix)) {
            $this->qb
                ->update(TBL_SHOP_ORDER_PRICE)
                ->where('op_ix', $row->op_ix)
                ->exec();
        } else {
            $this->qb
                ->set('oid', $oid)
                ->set('payment_status', $paymentStatus)
                ->insert(TBL_SHOP_ORDER_PRICE)
                ->exec();
        }
    }

    public function addClaimInfo($datas){
        $rows = $this->qb
                    ->select('ci_ix')
                    ->from(TBL_SHOP_ORDER_CLAIM_INFO)
                    ->where('oid',$datas['oid'])
                    ->where('od_ix',$datas['od_ix'])
                    ->where('status',$datas['status'])
                    ->exec()->getRowArray();
        if(isset($rows['ci_ix'])){
            $this->qb
                ->update(TBL_SHOP_ORDER_CLAIM_INFO)
                ->set('oid',$datas['oid'])
                ->set('od_ix',$datas['od_ix'])
                ->set('status',$datas['status'])
                ->set('c_type',$datas['c_type'])
                ->set('reason_code',$datas['reason_code'])
                ->set('status_message',$datas['status_message'])
                ->set('msg',$datas['msg'])
                ->set('editdate',date('Y-m-d H:i:s'))
                ->where('ci_ix',$rows['ci_ix'])
                ->exec();
        }else{
            $this->qb
                ->insert(TBL_SHOP_ORDER_CLAIM_INFO)
                ->set('oid',$datas['oid'])
                ->set('od_ix',$datas['od_ix'])
                ->set('status',$datas['status'])
                ->set('c_type',$datas['c_type'])
                ->set('reason_code',$datas['reason_code'])
                ->set('status_message',$datas['status_message'])
                ->set('msg',$datas['msg'])
                ->set('editdate',date('Y-m-d H:i:s'))
                ->set('regdate',date('Y-m-d H:i:s'))
                ->exec();
        }
    }
}
