<?php

/**
 * Description of ForbizMallOrderModel
 *
 * @author hoksi
 * @property CustomMallCartModel $cartModel
 * @property CustomMallMileageModel $mileageModel
 * @property CustomMallCouponModel $couponModel
 */
class ForbizMallOrderModel extends ForbizModel
{
    protected $cartModel;
    protected $mileageModel;
    protected $couponModel;

    public function __construct()
    {
        parent::__construct();

        $this->cartModel = $this->import('model.mall.cart');
        $this->mileageModel = $this->import('model.mall.mileage');
        $this->couponModel = $this->import('model.mall.coupon');
    }

    /**
     * 주문 배송지 조회
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
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('mem_ix', $userCode)
            ->whereNotIn('mem_ix', [''])
            ->where('default_yn', 'Y')
            ->exec()
            ->getResultArray();

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

        return array_merge($basicList, $recentList);
    }

    /**
     * 주문번호 생성
     * @return string
     */
    public function maxOid()
    {

        $configName = "shop_oid";
        $now = date('Ymd');
        $oidFirst = "";
        $oidLast = "";

        $this->qb->transStart();

        //FOR UPDATE 구문은 select 도 락시킴!
        $row = $this->qb
            ->setDatabase('master')
            ->exec("SELECT config_value FROM " . TBL_SHOP_MALL_CONFIG . " WHERE mall_ix='" . MALL_ID . "' AND config_name='" . $configName . "' FOR UPDATE")
            ->getRow();

        $value = explode("|", ($row->config_value ?? ''));
        $date = ($value[0] ?? '');
        $num = ($value[1] ?? '');

        if ($date == $now) {
            $num++;
        } else {
            $date = $now;
            $num = 1;
        }

        $oidFirst = $date . date('Hi');
        $oidLast = zerofill($num, '7');
        $configValue = $date . "|" . $num;
        $oid = $oidFirst . "-" . $oidLast;

        $this->qb
            ->setDatabase('master')
            ->exec("REPLACE INTO " . TBL_SHOP_MALL_CONFIG . " (mall_ix, config_name, config_value) VALUES ('" . MALL_ID . "', '" . $configName . "', '" . $configValue . "')");

        $this->qb->transComplete();

        return $oid;
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
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
            ->exec();

        return $this->qb->getInsertId();
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
            ->insert(TBL_SHOP_ORDER_DELIVERY)
            ->exec();

        return $this->qb->getInsertId();
    }

    /**
     * 주문 상품 정보 입력
     * @param type $mall_ix
     * @param type $oid
     * @param type $pid
     * @param type $ode_ix
     * @param type $odd_ix
     * @param type $data
     * @return type
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
                ->from(TBL_SHOP_PRODUCT . ' as p')
                ->join(TBL_SHOP_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'left')
                ->join(TBL_COMMON_COMPANY_DETAIL . ' as t', 'p.trade_admin=t.company_id', 'left')
                ->join(TBL_COMMON_COMPANY_DETAIL . ' as c', 'p.admin=c.company_id', 'left')
                ->join(TBL_COMMON_SELLER_DELIVERY . ' as s', 'p.admin=s.company_id', 'left')
                ->join(TBL_COMMON_SELLER_DETAIL . ' as sd', 'p.admin=sd.company_id', 'left')
                ->where('p.id', $pid)
                ->exec()
                ->getRow();
        }

        $buyer_type = ($data['buyer_type'] ?? '1');

        $gid = "";
        $gu_ix = "";

        $stock_use_yn = ($product->stock_use_yn ?? $data['stock_use_yn']);
        $option_kind = ($data['option_kind'] ?? '');
        $option_id = ($data['option_id'] ?? '');
        //조합&독립옵션이 아닐경우
        if (!empty($option_kind) && !empty($option_id) && !in_array($option_kind, ["c1", "i1"])) {
            $option = $this->qb
                ->select('od.option_gid')
                ->select('od.option_code')
                ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as od')
                ->where('od.id', $option_id)
                ->exec()
                ->getRow();

            if ($stock_use_yn == 'Y') {
                $gid = ($option->option_gid ?? $data['gid']);
                $gu_ix = ($option->option_code ?? $data['gu_ix']);
            }
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

        if (!empty($data['pcode'])) {
            $pcode = $data['pcode'];
        } else if (!empty($option) && !empty($option->option_code)) {
            $pcode = $option->option_code;
        } else if (!empty($product->pcode)) {
            $pcode = $product->pcode;
        } else {
            $pcode = '';
        }

        $this->qb
            ->set('mall_ix', $mall_ix)
            ->set('oid', $oid)
            ->set('rfid', ($data['rfid'] ?? ''))
            ->set('kwid', ($data['kwid'] ?? ''))
            ->set('mpr_ix', ($data['mpr_ix'] ?? ''))
            ->set('event_ix', ($data['event_ix'] ?? ''))
            ->set('buyer_type', $buyer_type)
            ->set('order_from', ($data['order_from'] ?? 'self'))
            ->set('cid', ($data['cid'] ?? $product->cid))
            ->set('pid', ($pid ?? $product->id))
            ->set('brand_code', ($data['brand_code'] ?? $product->brand))
            ->set('brand_name', ($data['brand_name'] ?? $product->brand_name))
            ->set('pcode', $pcode)
            ->set('barcode', ($data['barcode'] ?? $product->barcode))
            ->set('product_type', ($data['product_type'] ?? $product->product_type))
            ->set('pname', ($data['pname'] ?? $product->pname))
            ->set('trade_company', ($data['trade_admin'] ?? $product->trade_admin))
            ->set('trade_company_name', ($data['trade_company_name'] ?? $product->trade_company_name))
            ->set('stock_use_yn', $stock_use_yn)
            ->set('gid', $gid)
            ->set('gu_ix', $gu_ix)
            ->set('option_id', $option_id)
            ->set('option_text', ($data['option_text'] ?? ''))
            ->set('option_kind', $option_kind)
            ->set('option_price', ($data['option_price'] ?? 0))
            ->set('pcnt', $data['pcnt'])
            ->set('coprice', ($data['coprice'] ?? $product->coprice))
            ->set('listprice', $data['listprice'])
            ->set('psprice', $data['psprice'])
            ->set('dcprice', $data['dcprice'])
            ->set('ptprice', $data['ptprice'])
            ->set('pt_dcprice', $data['pt_dcprice'])
            ->set('reserve', $data['reserve'])
            ->set('msgbyproduct', $data['msgbyproduct'])
            ->set('status', ORDER_STATUS_SETTLE_READY)
            ->set('ode_ix', $ode_ix)
            ->set('odd_ix', $odd_ix)
            ->set('account_type', ($data['account_type'] ?? $product->account_type))
            ->set('account_info', ($data['account_info'] ?? $product->account_info))
            ->set('ac_delivery_type', ($data['ac_delivery_type'] ?? $product->ac_delivery_type))
            ->set('ac_expect_date', ($data['ac_expect_date'] ?? $product->ac_expect_date))
            ->set('account_method', ($data['account_method'] ?? $product->account_method))
            ->set('md_code', ($data['md_code'] ?? $product->md_code))
            ->set('company_id', ($data['company_id'] ?? $product->company_id))
            ->set('company_name', ($data['company_name'] ?? $product->company_name))
            ->set('com_phone', ($data['com_phone'] ?? $product->com_phone))
            ->set('one_commission', $one_commission)
            ->set('commission', $commission)
            ->set('commission_msg', $commission_msg)
            ->set('surtax_yorn', ($data['surtax_yorn'] ?? $product->surtax_yorn))
            ->set('cart_ix', $data['cart_ix'])
            ->set('hash_idx',  ($data['hash_idx'] ?? ''))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        return $this->qb->getInsertId();
    }

    /**
     * 주문 할인 정보 등록
     * @param type $oid
     * @param type $od_ix
     * @param type $ode_ix
     * @param type $data
     * @return type
     */
    public function insertOrderDiscount($oid, $od_ix, $ode_ix, $data)
    {
        $this->qb
            ->set('oid', $oid)
            ->set('od_ix', $od_ix)
            ->set('ode_ix', $ode_ix)
            ->set('dc_type', $data['dc_type'])
            ->set('dc_title', ($data['dc_title'] ?? ''))
            ->set('dc_rate', ($data['dc_rate'] ?? ''))
            ->set('dc_price', $data['dc_price'])
            ->set('dc_rate_admin', ($data['dc_rate_admin'] ?? ''))
            ->set('dc_price_admin', $data['dc_price_admin'])
            ->set('dc_rate_seller', ($data['dc_rate_seller'] ?? ''))
            ->set('dc_price_seller', $data['dc_price_seller'])
            ->set('dc_criterion', ($data['dc_criterion'] ?? ''))
            ->set('dc_msg', ($data['dc_msg'] ?? ''))
            ->set('dc_ix', ($data['dc_ix'] ?? ''))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_ORDER_DETAIL_DISCOUNT)
            ->exec();

        return $this->qb->getInsertId();
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
            ->set('payment_agent_type', ($data['payment_agent_type'] ?? 'W'))
            ->insert(TBL_SHOP_ORDER)
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

    /**
     * 주문 결제 정보 등록
     * @param type $oid
     * @param type $payType
     * @param type $payStatus
     * @param type $method
     * @param type $paymentPrice
     * @param type $data
     */
    public function insertOrderPayment($oid, $payType, $payStatus, $method, $paymentPrice, $data)
    {
        if (isset($data['settle_module'])) {
            $this->qb->set('settle_module', $data['settle_module']);
        }
        if (isset($data['tid'])) {
            $this->qb->set('tid', $data['tid']);
        }
        if (isset($data['ic_date'])) {
            $this->qb->set('ic_date', $data['ic_date']);
        }
        $this->qb
            ->set('oid', $oid)
            ->set('pay_type', $payType)
            ->set('pay_status', $payStatus)
            ->set('method', $method)
            ->set('tax_price', ($data['tax_price'] ?? 0))
            ->set('tax_free_price', ($data['tax_free_price'] ?? 0))
            ->set('payment_price', $paymentPrice)
            ->set('regdate', 'NOW()', false)
            ->insert(TBL_SHOP_ORDER_PAYMENT)
            ->exec();
    }

    /**
     * 주문 히스토리 등록
     * @param type $oid
     * @param type $odIx
     * @param type $status
     * @param type $data
     */
    public function insertOrderHistory($oid, $odIx, $status, $data)
    {
        $this->qb
            ->set('oid', $oid)
            ->set('od_ix', $odIx)
            ->set('pid', ($data['pid'] ?? ''))
            ->set('status', $status)
            ->set('status_message', ($data['status_message'] ?? ''))
            ->set('admin_message', ($data['admin_message'] ?? ''))
            ->set('company_id', ($data['company_id'] ?? ''))
            ->set('quick', ($data['quick'] ?? ''))
            ->set('invoice_no', ($data['invoice_no'] ?? ''))
            ->set('reason_code', ($data['reason_code'] ?? ''))
            ->set('c_type', ($data['c_type'] ?? ''))
            ->set('data_channel', ($data['data_channel'] ?? ''))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_ORDER_STATUS)
            ->exec();
    }

    /**
     * 무료결제 결제전 주문 여부
     * @param type $oid
     * @return type
     */
    public function isFreeOrderSettleReady($oid)
    {
        return $this->isOrderSettleReady($oid, ORDER_METHOD_NOPAY);
    }

    /**
     * 무통장 결제전 주문 여부
     * @param type $oid
     * @return type
     */
    public function isBankOrderSettleReady($oid)
    {
        return $this->isOrderSettleReady($oid, ORDER_METHOD_BANK);
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
            ->select('o.oid')
            ->from(TBL_SHOP_ORDER . ' as o')
            ->join(TBL_SHOP_ORDER_PAYMENT . ' as op', 'o.oid=op.oid and op.pay_type="G" and op.method="' . $method . '"')
            ->where('o.oid', $oid)
            ->whereIn('o.status', $status)
            ->exec();
        return ($this->qb->total > 0 ? true : false);
    }

    /**
     * 과세, 비과세 금액 계산 함수
     * 비과세 금액서부터 차감함
     * @param type $taxPrice
     * @param type $taxFreePrice
     * @param type $mileage
     * @return type
     */
    public function calculationPaymentPriceTaxRate($taxPrice, $taxFreePrice, $mileage)
    {
        $mileageTaxPrice = 0;
        $mileageTaxFreePrice = 0;

        if ($taxFreePrice > 0 && $mileage > 0) {
            if ($taxFreePrice > $mileage) {
                $mileageTaxFreePrice = $mileage;
                $taxFreePrice -= $mileage;
            } else {
                $mileageTaxFreePrice = $taxFreePrice;
                $taxFreePrice = 0;
            }
        }

        $mileageTaxPrice = $mileage - $mileageTaxFreePrice;
        $taxPrice = $taxPrice - $mileageTaxPrice;

        return [
            'taxPrice' => $taxPrice
            , 'taxFreePrice' => $taxFreePrice
            , 'mileageTaxPrice' => $mileageTaxPrice
            , 'mileageTaxFreePrice' => $mileageTaxFreePrice
        ];
    }

    /**
     * get 주문자 정보
     * @param type $oid
     * @return type
     */
    public function getOrder($oid)
    {
        $row = $this->qb
            ->setDatabase('payment')
            ->select('buserid')
            ->select('bname')
            ->select('bmobile')
            ->select('bmail')
			->select('user_code')
            ->from(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * get 주문 상품 정보
     * @param type $oid
     * @return type
     */
    public function getOrderProduct($oid)
    {
        $rows = $this->qb
			->select('od_ix')
            ->setDatabase('payment')
            ->select('pid')
            ->select('pname')
            ->select('pcnt')
            ->select('cart_ix')
            ->select('pt_dcprice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->exec()
            ->getResultArray();

        return $rows;
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
        //금액 비교
        if ($paymentPrice !== false) {
            $this->qb
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
            ->select('opay_ix')
            ->select('payment_price')
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', ORDER_METHOD_RESERVE)
            ->exec()
            ->getRow();

        if ($this->qb->total) {

            $this->mileageModel->useMileage($row->payment_price, 1, $oid . " 주문 사용", ['oid' => $oid]);

            $this->qb
                ->set('pay_status', ORDER_STATUS_INCOM_COMPLETE)
                ->update(TBL_SHOP_ORDER_PAYMENT)
                ->where('opay_ix', $row->opay_ix)
                ->exec();
        }

        //쿠폰 사용 처리
        $rows = $this->qb
            ->select('dd.dc_ix as regist_ix')
            ->select('od.pid')
            ->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as dd')
            ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'dd.oid=od.oid and dd.od_ix=od.od_ix', 'left')
            ->where('dd.oid', $oid)
            ->where('dd.dc_type', 'CP')
            ->exec()
            ->getResult();

        if ($this->qb->total) {
            /* @var $couponeModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            foreach ($rows as $row) {
                $couponModel->useCoupon($row->regist_ix, $oid, $row->pid);
            }
        }

        return $returnData;
    }

    /**
     * 무통장 및 가상계좌 입금 확인으로 처리
     * @param type $oid
     * @param type $payMethod
     * @param type $paymentPrice
     * @param type $payment
     * @return boolean
     */
    public function deposit($oid, $payMethod, $paymentPrice, $payment = [])
    {
        $returnData = [
            'result' => true
            , 'message' => ''
        ];

        //금액 비교
        $this->qb
            ->select()
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', $payMethod)
            ->where('payment_price', $paymentPrice)
            ->where('pay_status', ORDER_STATUS_INCOM_READY)
            ->exec();

        if (!$this->qb->total) {
            $returnData = [
                'result' => false
                , 'message' => '금액 검증 실패'
            ];
            return $returnData;
        }

        //shop_order update
        $this->qb
            ->set('status', ORDER_STATUS_INCOM_COMPLETE)
            ->update(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->exec();

        //shop_order_detail update
        $this->qb
            ->set('status', ORDER_STATUS_INCOM_COMPLETE)
            ->set('ic_date', date('Y-m-d H:i:s'))
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->exec();

        //shop_order_price insert
        $price = $this->qb
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

        //shop_order_payment update
        if (!empty($payment['tid'])) {
            $this->qb->set('tid', $payment['tid']);
        }
        $this->qb
            ->set('pay_status', ORDER_STATUS_INCOM_COMPLETE)
            ->set('ic_date', date('Y-m-d H:i:s'))
            ->update(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', $payMethod)
            ->exec();

        //shop_order_history insert
        $historyData = [];
        $historyData['status_message'] = ForbizConfig::getPaymentMethod($payMethod) . ' 입금 완료';
        $historyData['admin_message'] = 'system';
        $this->insertOrderHistory($oid, '', ORDER_STATUS_INCOM_COMPLETE, $historyData);

        return $returnData;
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

            //get 옵션에 같은 품목 리스트
            $optionList = $this->qb
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

                //옵션에 같은 품목인 상품 판매진행 수량 업데이트
                foreach ($productIdList as $_pid) {

                    $row = $this->qb
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
            }
        } elseif ($stockUseYn == "Q") {
            $this->qb
                ->set('sell_ing_cnt', 'sell_ing_cnt + ' . $count, false)
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

            $this->qb
                ->set('option_sell_ing_cnt', 'option_sell_ing_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                ->whereIn('id', $ooptionIx)
                ->exec();
        } else {
            $this->qb
                ->set('order_cnt', 'order_cnt + ' . $count, false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();
        }
    }

    /**
     * get 판매 진행중 재고
     * @param type $type
     * @param type $pid
     * @param type $ooptionIx
     * @param type $guIx
     * @return type
     */
    protected function getProductSellngCnt($type, $pid = '', $ooptionIx = '', $guIx = '')
    {
        if ($type == 'inventory') {
            $this->qb->where('gu_ix', $guIx);
        } else if ($type == 'option') {
            $this->qb
                ->where('pid', $pid)
                ->where('option_id', $ooptionIx);
        } else {
            $this->qb
                ->where('pid', $pid);
        }
        $row = $this->qb
            ->setDatabase('payment')
            ->selectSum('pcnt')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->whereIn('status', [ORDER_STATUS_INCOM_READY, ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_DELAY])
            ->exec()->getRow();
        return ($row->pcnt ?? 0);
    }

    /**
     * 주문, 배송 진행중 확인
     * @param string $userCode
     * @return boolean
     */
    public function hasOngoingOrder($userCode)
    {
        return $this->qb
                ->from(TBL_SHOP_ORDER . ' as o')
                ->join(TBL_SHOP_ORDER_DETAIL . ' as od', 'o.oid = od.oid')
                ->whereNotIn('od.status',
                    [
                        ORDER_STATUS_DELIVERY_COMPLETE,
                        ORDER_STATUS_CANCEL_COMPLETE,
                        ORDER_STATUS_RETURN_COMPLETE,
                        ORDER_STATUS_EXCHANGE_COMPLETE,
                        ORDER_STATUS_ACCOUNT_COMPLETE,
                        ORDER_STATUS_ACCOUNT_READY,
                        ORDER_STATUS_ACCOUNT_APPLY,
                        ORDER_STATUS_SETTLE_READY,
                        ORDER_STATUS_REFUND_COMPLETE,
                        ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE,
                        ORDER_STATUS_BUY_FINALIZED
                    ])
                ->where('o.user_code', $userCode)
                ->getCount() > 0;
    }

    /**
     * 회원탈퇴시 주문내역 개인정보 관련 처리
     * @param string $userCode
     */
    public function withdrawOrderProcess($userCode)
    {
        if (ForbizConfig::getPrivacyConfig('secede_member_order_destruction_yn') == 'Y') {
            $rows = $this->qb->select('oid')->from(TBL_SHOP_ORDER)->where('user_code', $userCode)->exec()->getResultArray();
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $sql = [
                        'INSERT INTO',
                        TBL_SEPARATION_SHOP_ORDER,
                        '(oid, btel, bmobile, bmail, bzip, baddr, regdate)',
                        'SELECT',
                        'oid, btel, bmobile, bmail, bzip, baddr, NOW()',
                        'FROM',
                        TBL_SHOP_ORDER,
                        'WHERE oid = ?'
                    ];

                    $this->qb->exec($this->qb->queryBind(implode(' ', $sql), [$row['oid']]));

                    if ($this->qb->from(TBL_SEPARATION_SHOP_ORDER)->where('oid', $row['oid'])->getCount() > 0) {
                        $this->qb
                            ->set('btel', '')
                            ->set('bmobile', '')
                            ->set('bmail', '')
                            ->set('bzip', '')
                            ->set('baddr', '')
                            ->where('oid', $row['oid'])
                            ->update(TBL_SHOP_ORDER)
                            ->exec();
                    }

                    // 회원탈퇴시 배송 개인정보 관련 처리
                    $this->withdrawOrderDeliveryInfoProcess($row['oid']);
                }
            }
        }
    }

    /**
     * 회원탈퇴시 배송 개인정보 관련 처리
     * @param int $oid
     */
    protected function withdrawOrderDeliveryInfoProcess($oid)
    {
        $rows = $this->qb->select('odd_ix')->from(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)->where('oid', $oid)->exec()->getResultArray();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $sql = [
                    'INSERT INTO',
                    TBL_SEPARATION_SHOP_ORDER_DELIVERYINFO,
                    '(odd_ix, oid, od_ix, rname, rtel, rmobile, rmail, zip, addr1, addr2, regdate) ',
                    'SELECT',
                    'odd_ix, oid, od_ix, rname, rtel, rmobile, rmail, zip, addr1, addr2, NOW()',
                    'FROM',
                    TBL_SHOP_ORDER_DETAIL_DELIVERYINFO,
                    'WHERE odd_ix = ?'
                ];

                $this->qb->exec($this->qb->queryBind(implode(' ', $sql), [$row['odd_ix']]));

                if ($this->qb->from(TBL_SEPARATION_SHOP_ORDER_DELIVERYINFO)->where('odd_ix', $row['odd_ix'])->getCount() > 0) {
                    $this->qb
                        ->set('rname', '탈퇴회원')
                        ->set('rtel', '')
                        ->set('rmobile', '')
                        ->set('rmail', '')
                        ->set('zip', '')
                        ->set('addr1', '')
                        ->set('addr2', '')
                        ->where('odd_ix', $row['odd_ix'])
                        ->update(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                        ->exec();
                }
            }
        }
    }

    /**
     * 최근 주문내역
     * @param string $userCode
     * @return array
     */
    public function getLatestOrder($userCode)
    {
        $orderList = $this->qb
            ->distinct()
            ->select("date_format(o.order_date, '%Y-%m-%d') order_date", false)
            ->select('o.oid')
            ->from(TBL_SHOP_ORDER . ' AS o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS od', 'o.oid = od.oid')
            ->where('o.order_date >=', date('Y-m-d 00:00:00', strtotime('-1 month')))
            ->where('o.order_date <', date('Y-m-d 23:59:59'))
            ->where('o.user_code', $userCode)
            ->where('od.status !=', ORDER_STATUS_SETTLE_READY)
            ->orderBy('o.oid', 'desc')
            ->limit(3)
            ->exec()
            ->getResultArray();

        $list = [];

        // 주문상세를 조합한다.
        if (!empty($orderList)) {
            $oids = array_column($orderList, 'oid');

            // 주문상세 조회
            $orderDetail = $this->getOderDetailItems($oids);

            // 주문상세 조합
            foreach ($orderList as $oItem) {
                if (isset($orderDetail[$oItem['oid']])) {
                    $oItem['orderDetail'] = $orderDetail[$oItem['oid']];
                    $list[] = $oItem;
                }
            }
        }

        return $list;
    }
	
    public function getLatestOrderSummery($userCode)
    {
        $orderList = $this->qb
            ->distinct()
            ->select("date_format(o.order_date, '%Y-%m-%d') order_date", false)
            ->select('o.oid')
            ->select('o.total_price')
            ->select('count(o.oid)-1 AS ordCnt')
            ->from(TBL_SHOP_ORDER . ' AS o')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS od', 'o.oid = od.oid')
            ->where('o.order_date >=', date('Y-m-d 00:00:00', strtotime('-1 month')))
            ->where('o.order_date <', date('Y-m-d 23:59:59'))
            ->where('o.user_code', $userCode)
            ->where('od.status !=', ORDER_STATUS_SETTLE_READY)
			->groupBy('o.oid')
            ->orderBy('o.oid', 'desc')
            ->limit(3)
            ->exec()
            ->getResultArray();

        $list = [];

        // 주문상세를 조합한다.
        if (!empty($orderList)) {
            $oids = array_column($orderList, 'oid');

            // 주문상세 조회
            $orderDetailSummery = $this->getOderDetailItems($oids);

            // 주문상세 조합
            foreach ($orderList as $oItem) {
                if (isset($orderDetailSummery[$oItem['oid']])) {

                    $oItem['orderDetailSummery'] = $orderDetailSummery[$oItem['oid']][0];

                    $list[] = $oItem;
                }
            }
        }

        return $list;
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
                ->whereIn('claim_group', $claimGroup);
        }

        $rows = $this->qb
            ->select('oid')
            ->select('brand_name')
            ->select('pid')
            ->select('pname')
            ->select('option_text')
            ->select('pt_dcprice')
            ->select('dcprice')
            ->select('listprice * pcnt AS listprice', false)
            ->select('listprice AS ea_listprice', false)
            ->select('pcnt')
            ->select('status')
            ->select('refund_status')
            ->select('ode_ix')
            ->select('od_ix')
            ->select('option_id')
            ->select('invoice_no')
            ->select('quick')
            ->select($this->qb
                ->startSubQuery('is_comment')
                ->select('bbs_ix')
                ->from(TBL_SHOP_PRODUCT_AFTER . ' AS pa')
                ->where('pa.oid = ' . TBL_SHOP_ORDER_DETAIL . '.oid', null, false)
                ->where('pa.pid = ' . TBL_SHOP_ORDER_DETAIL . '.pid', null, false)
                ->where('pa.option_id = ' . TBL_SHOP_ORDER_DETAIL . '.option_id', null, false)
                ->limit(1)
                ->endSubQuery()
            )
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('status !=', ORDER_STATUS_SETTLE_READY)
            ->whereIn('oid', $oids)
            ->where('claim_delivery_od_ix', 0)
            ->orderBy('oid', 'desc')
            ->orderBy('ode_ix')
            ->orderBy('pid')
            ->orderBy("(case option_kind when 'a' then 'ZZZZZZ' else option_kind end)", 'asc', false)
            ->exec()
            ->getResultArray();

        $data = [];
        foreach ($rows as $k => $v) {
            $v['pimg'] = get_product_images_src($v['pid'], is_adult());
            $v['status_text'] = ForbizConfig::getOrderStatus($v['status']);
            $v['refund_status_text'] = ForbizConfig::getOrderStatus($v['refund_status']);

            // 취소/교환/반품 시 $claimGroup true
            if ($claimGroup) {
                $v['claim_date'] = $v['ea_date'];
                $v['claim_date'] = ($v['ra_date'] ? $v['ra_date'] : $v['claim_date']);
                $v['claim_date'] = ($v['ca_date'] ? $v['ca_date'] : $v['claim_date']);
                $data[$v['oid']][$v['claim_group']][] = $v;
            } else {
                // 교환인 경우 교환 상품정보 가져오기
                switch ($v['status']) {
                    case ORDER_STATUS_EXCHANGE_ING:
                    case ORDER_STATUS_EXCHANGE_DELIVERY:
                    case ORDER_STATUS_EXCHANGE_ACCEPT:
                    case ORDER_STATUS_EXCHANGE_COMPLETE:
                        $v['exchageDetail'] = $this->getExchangeDetail($v['oid'], $v['od_ix']);
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
    public function getExchangeDetail($oid, $od_ix)
    {
        if (is_mobile()) {
            $imageSizeType = 'm';
        } else {
            $imageSizeType = 'b';
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
            ->where('claim_delivery_od_ix', $od_ix)
            ->orderBy('ode_ix')
            ->orderBy('pid')
            ->orderBy("(case option_kind when 'a' then 'ZZZZZZ' else option_kind end)", 'asc', false)
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $rows[$k]['status_text'] = ForbizConfig::getOrderStatus($v['status']);
                $rows[$k]['pimg'] = get_product_images_src($v['pid'], (sess_val('user', 'age') >= '19' ? true : false), $imageSizeType,
                    $v['is_adult']);

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
            ->select('COUNT(*) as cnt')
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
     * 주문 상품 할인 정보
     * @param string $oid
     * @param array $od_ixs
     * @return type
     */
    public function getProductDiscountInfo($oid, $od_ixs)
    {
        $od_ixs = is_array($od_ixs) ? $od_ixs : [$od_ixs];

        $rows = $this->qb
            ->setDatabase('payment')
            ->select('od_ix')
            ->select('dc_type')
            ->select('dc_price')
            ->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT)
            ->where('oid', $oid)
            ->whereIn('od_ix', $od_ixs)
            ->exec()
            ->getResultArray();

        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $data[$row['od_ix']][] = $row;
            }
        }

        return $data;
    }

    /**
     * 배송지 정보 및 배송 메시지
     * @param string $oid
     * @return array
     */
    public function getDeliveryInfo($oid)
    {
        $prows = $this->qb
            ->select('od_ix')
            ->select('brand_name')
            ->select('pname')
            ->select('option_text')
            ->select('msgbyproduct')
            ->select('odd_ix')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->where('status !=', ORDER_STATUS_SETTLE_READY)
            ->where('product_type !=', '77')// 사은품 제외
            ->exec()
            ->getResultArray();

        if (!empty($prows)) {
            $odd_ixs = array_unique(array_column($prows, 'odd_ix'));

            // 배송정보 조회
            $data = $this->qb
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
                ->from(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                ->where('oid', $oid)
                ->whereIn('odd_ix', $odd_ixs)
                ->orderBy('odd_ix')
                ->limit(1)
                ->exec()
                ->getRowArray();

            if (!empty($data)) {
                $data['pcnt'] = count($prows);

                if ($data['msg_type'] == 'P') {
                    $data['msg'] = [];
                    foreach ($prows as $prow) {
                        $data['msg'][] = [
                            'brand_name' => $prow['brand_name'],
                            'pname' => $prow['pname'],
                            'option_text' => $prow['option_text'],
                            'msg_ix' => $prow['od_ix'],
                            'msg' => $prow['msgbyproduct'],
                            'msg_type' => $data['msg_type']
                        ];
                    }
                } else {
                    $data['msg'] = [[
                        'brand_name' => $prows[0]['brand_name'],
                        'pname' => $prows[0]['pname'] . (count($prows) > 1 ? trans(' 외 ') . (count($prows) - 1) . trans(' 건') : ''),
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
     * 배송 그룹별 배송비 조회
     * @param string $oid
     * @param array $ode_ixs
     * @return array
     */
    public function getDeliveryPrice($oid, $ode_ixs)
    {
        $ode_ixs = is_array($ode_ixs) ? $ode_ixs : [$ode_ixs];

        if (!empty($ode_ixs)) {
            $rows = $this->qb
                ->select('odd.ode_ix')
                ->select('odd.dt_ix')
                ->select('odd.delivery_dcprice')
                ->from(TBL_SHOP_ORDER_DELIVERY . ' AS odd')
                ->where('odd.oid', $oid)
                ->whereIn('odd.ode_ix', $ode_ixs)
                ->exec()
                ->getResultArray();

            return $rows;
        } else {
            return [];
        }
    }

    /**
     * shop_order_detail의 status 값이 ORDER_STATUS_INCOM_COMPLETE
     * @param array $orderDetail
     * @param string $orderStatus
     * @return string
     */
    public function checkOrderStatus($orderDetail, $orderStatus)
    {
        if ($orderStatus == ORDER_STATUS_INCOM_COMPLETE || $orderStatus == ORDER_STATUS_INCOM_READY) {
            $chkFn = function ($oitem) {
                if ($oitem['status'] != ORDER_STATUS_INCOM_COMPLETE && $oitem['status'] != ORDER_STATUS_INCOM_READY) {
                    return $oitem['status'];
                }

                return false;
            };

            if (isset($orderDetail[0])) {
                foreach ($orderDetail as $oitem) {
                    if ($ret = $chkFn($oitem)) {
                        return $ret;
                    }
                }
            } else {
                foreach ($orderDetail as $orow) {
                    foreach ($orow as $oitem) {
                        if ($ret = $chkFn($oitem)) {
                            return $ret;
                        }
                    }
                }
            }
        }

        return $orderStatus;
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
        $row = $this->qb
            ->setDatabase('payment')
            ->select('oid')
            ->select("date_format(order_date, '%Y-%m-%d') order_date", false)
            ->select('delivery_price')
            ->select('bname')
            ->select('bmail')
            ->select('bmobile')
            ->select('order_date bdatetime')
            ->select('status')
            ->select($this->qb->startSubQuery()
                    ->select('count(*) cnt', false)
                    ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
                    ->where('od.oid', $oid)
                    ->whereIn('od.status', [ORDER_STATUS_INCOM_READY, ORDER_STATUS_INCOM_COMPLETE])
                    ->endSubQuery() . ' AS deliveryChange', false
            )
            ->from(TBL_SHOP_ORDER)
            ->where('user_code', $userCode)
            ->where('oid', $oid)
            ->exec()
            ->getRowArray();

        if (isset($row['oid'])) {
            // 배송비별 주문내역
            $row['orderDetail'] = $this->getGroupByDeliveryOrderDetail($row['oid'], (isset($orderSearch['od_ix']) ? $orderSearch['od_ix'] : []),
                $orderSearchEtc, $exchange);

            // 배송비
            $deliveryPriceInfos = $this->getDeliveryPrice($oid, array_keys($row['orderDetail']));
            if (is_array($deliveryPriceInfos) && !empty($deliveryPriceInfos)) {
                $row['deliveryPrice'] = array_column($deliveryPriceInfos, 'delivery_dcprice', 'ode_ix');
                foreach ($deliveryPriceInfos as $deliveryPriceInfo) {
                    $deliveryInfo = $this->cartModel->getDeliveryInfo($deliveryPriceInfo['dt_ix']);
                    $row['deliveryPricePolicyText'][$deliveryPriceInfo['ode_ix']] = "{$deliveryInfo['text']}" . (!empty($deliveryInfo['regionText']) ? "({$deliveryInfo['regionText']})" : '');
                }
            } else {
                $row['deliveryPrice'] = [];
                $row['deliveryPricePolicyText'] = [];
            }

            // orderu status 검사
            $row['status'] = $this->checkOrderStatus($row['orderDetail'], $row['status']);
        }

        return $row;
    }

    /**
     * 배송정책별 주문상세 내역 조회
     * @param string $oid 주문번호
     * @param array $od_ix 주문상세ID
     * @param array $etcs
     * @param int $exchange : .교환으로 신규 생성된 주문인지 확인
     * @return array
     */
    public function getGroupByDeliveryOrderDetail($oid, $od_ix = [], $etcs = [], $exchange = 0)
    {
        $this->qb->startCache();
        $this->qb
            ->setDatabase('payment')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
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
            ->setDatabase('payment')
            ->select('brand_name')
            ->select('pid')
            ->select('pname')
            ->select('pcnt')
            ->select('listprice')// 정가(단가)
            ->select('psprice')// 판매가(단가)
            ->select('dcprice')// 할인가(단가)
            ->select('ptprice', false)// 최종가격 = (상품가+옵션가)*수량
            ->select('pt_dcprice')// 최종할인상품가격
            ->select('listprice * pcnt AS pt_listprice', false)// 정가 * 수량
            ->select('if((listprice - dcprice) > 0, (listprice - dcprice), 0) * pcnt AS calc_dcprice', false)// 즉시할인금액 = (정가(단가) - 할인가(단가)) * 수량
            ->select('if((listprice - psprice) > 0, (listprice - psprice), 0) * pcnt as dr_dc', false)// 즉시할인가
            ->select('if(((listprice + option_price) * pcnt - pt_dcprice) > 0, ((listprice + option_price) * pcnt - pt_dcprice), 0) as pt_calc_dcprice', false)// 총 할인금액
            ->select('reserve')
            ->select('option_text')
            ->select('option_id')
            ->select('set_group')
            ->select('status')
            ->select('claim_group')
            ->select('refund_status')
            ->select('fc_date')
            ->select('ode_ix')
            ->select('odd_ix')
            ->select('option_kind')
            ->select('quick')
            ->select('invoice_no')
            ->select($this->qb->startSubQuery('dt_ix')
                ->select('dt_ix')
                ->from(TBL_SHOP_ORDER_DELIVERY)
                ->where('ode_ix', TBL_SHOP_ORDER_DETAIL . '.ode_ix', false)
                ->endSubQuery(), false
            )
            ->select('od_ix')
            ->select('surtax_yorn')
            ->exec()->getResultArray();
        $this->qb->flushCache();

        $data = [];
        if (!empty($rows)) {
            $od_ixs = array_column($rows, 'od_ix');
            $dcInfo = $this->getProductDiscountInfo($oid, $od_ixs);

            for ($i = 0; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (isset($dcInfo[$row['od_ix']])) {
                    $dc = array_column($dcInfo[$row['od_ix']], 'dc_price', 'dc_type');
                } else {
                    $dc = [];
                }

                // 데이타 리뉴얼
                $row['pimg'] = get_product_images_src($row['pid'], is_adult());
                $row['status_text'] = ForbizConfig::getOrderStatus($row['status']);
                $row['refund_status_text'] = ForbizConfig::getOrderStatus($row['refund_status']);
                $row['cp_dc'] = $dc['CP'] ?? 0; // 쿠폰 할인금액
                $row['mg_dc'] = $dc['MG'] ?? 0; // 회원 할인금액
                $row['gp_dc'] = $dc['GP'] ?? 0; // 기획 할인금액
                $row['sp_dc'] = $dc['SP'] ?? 0; // 특별 할인금액
                $row['total_dc'] = $row['pt_calc_dcprice']; // 총 할인금액

                if (is_mobile()) { //모바일은 주문 상세에서도 개별 주문 상태변경 가능. PC는 주문리스트에서만 가능함.
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

                $data[$row['ode_ix']][$i] = $row;
            }
        }

        return $data;
    }

    /**
     * 결제 정보를 가져온다.
     * @param string $oid 주문번호
     * @param string $paymentType 결제방법
     * @return array
     */
    public function getPaymentInfo($oid, $paymentType = 'G')
    {
        $rows = $this->qb
            ->setDatabase('payment')
            ->select('method')
            ->select('vb_info')
            ->select('bank')
            ->select('bank_account_num')
            ->select('bank_input_date')
            ->select('bank_input_name')
            ->select('memo')
            ->select('payment_price')
            ->select('tax_price')
            ->select('tax_free_price')
            ->select('receipt_yn')
            ->select('tid')
            ->select('regdate')
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('pay_type', $paymentType)
            ->exec()
            ->getResultArray();

        $data = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $row['method_text'] = ForbizConfig::getPaymentMethod($row['method']);
                $row['bank_input_date'] = date('Y-m-d', strtotime($row['bank_input_date']));
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getRefundPaymentInfo($oid)
    {
        return $row = $this->qb
            ->select('sum(pt_dcprice) as allPrice')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->whereIn('status', [ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_BUY_FINALIZED])    // DI(배송중), DC(배송완료), BF(거래확정)
            ->exec()
            ->getRowArray();
    }

    /**
     * 결제 정보를 가지고 온다
     * @param $oid
     * @param $method
     * @param string $paymentType
     * @return mixed
     */
    public function getPaymentRowData($oid, $method, $paymentType = 'G')
    {
        return $row = $this->qb
            ->select('pay_status')
            ->select('tid')
            ->select('escrow_use')
            ->select('payment_price')
            ->select('tax_price')
            ->select('tax_free_price')
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', $method)
            ->where('pay_type', $paymentType)
            ->exec()
            ->getRowArray();
    }

    /**
     * 배송 메시지 수정
     * @param string $userCode
     * @param string $oid
     * @param string $msgIx
     * @param string $msgType
     * @param string $deliveryMsg
     * @return boolean
     */
    public function deliveryMsgUpdate($userCode, $oid, $msgIx, $msgType, $deliveryMsg)
    {
        // 주문자의 주문인지 확인
        $rowCnt = $this->qb->from(TBL_SHOP_ORDER)->where('user_code', $userCode)->where('oid', $oid)->getCount();

        if ($rowCnt > 0) {
            if ($msgType == 'P') {
                // 상품별 요구사항 수정
                $this->qb
                    ->set('msgbyproduct', $deliveryMsg)
                    ->where('od_ix', $msgIx)
                    ->where('oid', $oid)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();
            } else {
                // 통합 배송 메시지 수정
                $this->qb
                    ->set('msg', $deliveryMsg)
                    ->where('odd_ix', $msgIx)
                    ->where('oid', $oid)
                    ->update(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                    ->exec();
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * 우편번호를 기준으로 배송비가 동일한지 확인한다.
     * @param string $userCode 회원코드
     * @param string $orderId 주문번호
     * @param string $zipcode 우편번호
     * @return boolean
     */
    public function isSameDeliveryPrice($userCode, $orderId, $zipcode)
    {
        /* @var CustomMallCartModel $cartModel */
        $cartModel = $this->import('model.mall.cart');

        // 주문 정보 조회
        $orderInfo = $this->getOrderInfo($userCode, $orderId);

        $orderDetail = $orderInfo['orderDetail'];
        $deliveryPrice = $orderInfo['deliveryPrice'];

        foreach ($orderDetail as $odeIx => $productInfo) {
            $pInfo = ['price' => 0, 'qty' => 0];
            $dtIx = false;

            foreach ($productInfo as $p) {
                $pInfo['price'] += $p['pt_dcprice'];
                $pInfo['qty'] += $p['pcnt'];
                $dtIx = $p['dt_ix'];
            }

            // 배송지
            $dPrice = $cartModel->getDeliveryInfo($dtIx, $pInfo, $zipcode);

            if ($dPrice['sumPrice'] != $deliveryPrice[$odeIx]) {
                return false;
            }
        }

        return true;
    }

    /**
     * 배송지 정보를 바꾼다.
     * @param string $userCode
     * @param string $oid
     * @param int $ix
     * @return array
     */
    public function deliveryAddressChange($userCode, $oid, $ix)
    {
        $row = $this->qb
            ->distinct()
            ->select('odd.odd_ix')
            ->from(TBL_SHOP_ORDER . ' AS od')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS odd', 'od.oid = odd.oid')
            ->where('od.user_code', $userCode)
            ->where('od.oid', $oid)
            ->limit(1)
            ->exec()
            ->getRowArray();

        if (isset($row['odd_ix'])) {
            $srow = $this->qb
                ->select('ix')
                ->select('recipient rname')
                ->select('zipcode zip')
                ->select('address1 addr1')
                ->select('address2 addr2')
                ->select('tel rtel')
                ->select('mobile rmobile')
                ->from(TBL_SHOP_SHIPPING_ADDRESS)
                ->where('mem_ix', $userCode)
                ->where('ix', $ix)
                ->limit(1)
                ->exec()
                ->getRowArray();

            if (isset($srow['ix']) && $srow['ix'] == $ix) {
                if ($this->isSameDeliveryPrice($userCode, $oid, $srow['zip'])) {
                    $this->qb
                        ->set('rname', $srow['rname'])
                        ->set('zip', $srow['zip'])
                        ->set('addr1', $srow['addr1'])
                        ->set('addr2', $srow['addr2'])
                        ->set('rtel', $srow['rtel'])
                        ->set('rmobile', $srow['rmobile'])
                        ->where('odd_ix', $row['odd_ix'])
                        ->update(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                        ->exec();

                    return $srow;
                } else {
                    return 'differentPrice';
                }
            }
        }

        return 'notExists';
    }

    /**
     * 비회원 주문 배송지 정보를 바꾼다.
     * @param string $userCode
     * @param string $oid
     * @param int $ix
     * @return array
     */
    public function guestDeliveryAddressChange($oid, $deliveryInfo)
    {
        $row = $this->qb
            ->distinct()
            ->select('odd.odd_ix')
            ->from(TBL_SHOP_ORDER . ' AS od')
            ->join(TBL_SHOP_ORDER_DETAIL . ' AS odd', 'od.oid = odd.oid')
            ->where('od.user_code', '')
            ->where('od.oid', $oid)
            ->limit(1)
            ->exec()
            ->getRowArray();

        if (isset($row['odd_ix'])) {

            if(!is_array($deliveryInfo)) {
                $deliveryInfo = json_decode($deliveryInfo, true);
            }

            $rtel = '';
            if (!empty($deliveryInfo['tel1'])) {
                $rtel = $deliveryInfo['tel1'] . '-' . $deliveryInfo['tel2'] . '-' . $deliveryInfo['tel3'];
            }

            $srow = [
                'rname' => $deliveryInfo['recipient']
                , 'zip' => $deliveryInfo['zip']
                , 'addr1' => $deliveryInfo['addr1']
                , 'addr2' => $deliveryInfo['addr2']
                , 'rmobile' => $deliveryInfo['pcs1'] . '-' . $deliveryInfo['pcs2'] . '-' . $deliveryInfo['pcs3']
                , 'rtel' => $rtel
            ];

            if ($this->isSameDeliveryPrice('', $oid, $srow['zip'])) {
                $this->qb
                    ->set('rname', $srow['rname'])
                    ->set('zip', $srow['zip'])
                    ->set('addr1', $srow['addr1'])
                    ->set('addr2', $srow['addr2'])
                    ->set('rtel', $srow['rtel'])
                    ->set('rmobile', $srow['rmobile'])
                    ->where('odd_ix', $row['odd_ix'])
                    ->update(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
                    ->exec();

                return $srow;
            } else {
                return 'differentPrice';
            }
        }

        return 'notExists';
    }

    public function getOidUsingPasswordAndName($oid, $bname, $orderPw, $startDate = false)
    {
        if ($startDate) {
            $this->qb->where('order_date >=', $startDate);
        }

        return $this->qb
            ->select('oid')
            ->from(TBL_SHOP_ORDER)
            ->where('oid', $this->orderIdRlue($oid))
            ->where('bname', $bname)
            ->where('order_pw', encrypt_user_password($orderPw))
            ->where('status !=', ORDER_STATUS_SETTLE_READY)
            ->where('user_code', '')
            ->exec()
            ->getRowArray();
    }

    /**
     * 고객이 주문번호 - 없이 넘어올 경우 주문번호 수정
     * @param string $oid
     * @return mixed|string
     */
    public function orderIdRlue($oid)
    {
        $oid = str_replace('-', '', $oid);
        $oid = substr($oid, 0, 12) . '-' . substr($oid, -7);
        return $oid;
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

                $result = $this->claimChangePriceCalculate($products, $data);
            }
        }

        return $result;
    }

    /**
     * 동일 배송정책 기준으로 클레임하고 남은 주문건들에 대한 데이터
     * @param string $oid
     * @param array $data : od_ix, claim_apply_cnt 필수
     * @return
     * array (
     *  [ode_ix] => [leftPcnt] => array() //각 od_ix의 클레임 후 남은 상품 개수
     *              [leftTotal] => array() //각 od_ix의 클레임 후 남은 금액
     * )
     */
    public function calculateLeftoverDeliveryPrice($oid, $data)
    {
        $odeIxs = array_column($data, 'ode_ix');
        $claimApply = array();
        $result = array();

        //클레임 요청 상품별 개수
        foreach ($data as $k => $v) {
            $claimApply[$v['od_ix']] = $v['claim_apply_cnt'];
        }

        //클레임 요청시 넘어온 배송정책별(ode_ix)로 주문 정보 호출
        $odeDatas = $this->qb
            ->select('od_ix, ode_ix, psprice, pcnt')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->whereIn('ode_ix', $odeIxs)
            ->whereIn('status', [ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_INCOM_READY, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_DELIVERY_DELAY])
            ->groupStart()->where('refund_status is null or refund_status=""')->groupEnd()//이미 클레임 환불이 진행된 건들은 제외하고 계산함.
            ->exec()->getResultArray();

        //(주문된 개수-클레임 요청한 개수) * 상품판매단가(psprice) 로 계산하여 남은 금액 계산.
        $leftPcnt = 0;
        foreach ($odeDatas as $k2 => $v2) {
            if (empty($claimApply[$v2['od_ix']])) {
                $leftPcnt = $v2['pcnt'];
            } else {
                $leftPcnt = $v2['pcnt'] - $claimApply[$v2['od_ix']];
            }
            $result[$v2['ode_ix']]['leftPcnt'][] = $leftPcnt; //클레임 요청 후 남은 개수. 취소요청시 배송비 계산에 사용됨.
            $result[$v2['ode_ix']]['leftTotal'][] = $leftPcnt * $v2['psprice']; //클레임 요청 후 남은 금액. 취소요청시 배송비 계산에 사용됨.
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

                        if ($leftOverPrice > 0) { //구매자 귀책일 경우 && 부분취소일 경우 계산
                            //남은 주문으로 배송비 재계산
                            $re_delivery_price_infos = $this->cartModel->getDeliveryInfo($data[$i]['dt_ix'],
                                array('price' => $leftOverPrice, 'qty' => $leftOverPcnt));
                            $re_delivery_price = $re_delivery_price_infos['sumPrice'];

                            //기존 배송비 - 남은 주문 금액의 배송비 = 환불시 차감 혹은 환불시 추가 되어야할 금액
                            $change_delivery_price = $org_delivery_price - $re_delivery_price;
                            if ($change_delivery_price != 0) {
                                $total_change_delivery_price += $change_delivery_price;
                            }
                        } else {
                            $total_change_delivery_price += $org_delivery_price; //판매자 귀책 혹은 전체취소일 경우에는 배송비 전체 환불
                        }
                    }
                }
            } else {//반품 또는 교환 CASE
                if ($data[$i]['claim_fault_type'] == "B") {//구매자 귀책시 배송비 부과
                    //요청한 그룹별로 배송비 부과. claim_group = 클레임시 +1로 업데이트되는 값.
                    //예) A, B, C 클레임 요청시 1로 업데이트 -> 클레임 중단 -> 이후 A, B 상품 재클레임 요청시 2로 업데이트. 최종 claim_group 값 : A, B = 2 / C = 1
                    if ($b_claim_group != $data[$i]['claim_group']) {
                        $dt_info = $this->qb->select('*')
                            ->from(TBL_SHOP_DELIVERY_TEMPLATE . ' as t')
                            ->join(TBL_SHOP_ORDER_DELIVERY . ' as od', 't.dt_ix=od.dt_ix', 'inner')
                            ->where('ode_ix', $data[$i]['ode_ix'])->exec()->getRow(0, 'array');

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
                                            $claim_delivery_price += $dt_info['return_shipping_price']; //반품 배송비
                                        }
                                    } else {
                                        // 지정택배
                                        $claim_delivery_price += $dt_info['return_shipping_price']; //반품 배송비
                                    }
                                } else {
                                    if ($claimData['send_type'] == 1) {
                                        // 직접 발송
                                        if ($claimData['delivery_pay_type'] == 1) {
                                            // 선불
                                            $claim_delivery_price = 0; //반품 배송비 편도
                                        } else {
                                            // 착불
                                            $claim_delivery_price = $dt_info['return_shipping_price']; //반품 배송비
                                        }
                                    } else {
                                        // 지정택배
                                        $claim_delivery_price = $dt_info['return_shipping_price']; //반품 배송비
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
                                        $claim_delivery_price = $dt_info['return_shipping_price']; //반품 배송비 편도
                                    }
                                } else {
                                    // 지정택배
                                    $claim_delivery_price = $dt_info['return_shipping_price'];
                                }
                            }

                            $total_claim_delivery_price -= $claim_delivery_price; //환불시 차감되어야할 배송비 값
                        } elseif ($data[$i]['claim_type'] == "E") {//교환
                            if ($claimData['send_type'] == 1) {
                                // 직접발송
                                if ($claimData['delivery_pay_type'] == 1) { // 선불
                                    $claim_delivery_price = $dt_info['exchange_shipping_price']; // 편도 배송비 설정
                                } else {
                                    $claim_delivery_price = $dt_info['exchange_shipping_price'] * 2; //교환 배송비 편도*2
                                }
                            } else {
                                // 지정택배
                                $claim_delivery_price = $dt_info['exchange_shipping_price'] * 2; //교환 배송비 편도*2
                            }

                            $total_claim_delivery_price -= $claim_delivery_price; //교환시 추가 청구되는 배송비
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
                    $discount = $this->qb->select('*')->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT)->where('oid', $data[$i]['oid'])->where('od_ix',
                        $data[$i]['od_ix'])->whereNotIn('dc_type', array('CP', 'SCP'))
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
                $discount = $this->qb->select('*')->from(TBL_SHOP_ORDER_DETAIL_DISCOUNT)->where('oid', $data[$i]['oid'])->where('od_ix',
                    $data[$i]['od_ix'])
                    ->exec()->getResultArray();

                if (count($discount) > 0) {
                    foreach ($discount as $dc) {
                        //dc_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
                        //배송비 쿠폰은 정책이 정해지면!
                        if (in_array($dc['dc_type'], array("CP", "SCP"))) {
                            $total_coupon_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
                            $total_product_dcprice += round(($dc['dc_price'] / $data[$i]["pcnt"]) * $data[$i]["claim_apply_cnt"] * $pm_sign);
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

        //클레임 배송비 배송 업체 company_id 로 처리
        $orderDeliveryData = $this->qb
            ->select('company_id')
            ->from(TBL_SHOP_ORDER_DELIVERY)
            ->where('ode_ix', $b_ode_ix)
            ->exec()
            ->getRowArray();

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
                'company_id' => $orderDeliveryData['company_id'],
                'delivery_type' => $data[0]['delivery_type'],
                'delivery_price' => $total_apply_delivery_price
            ],
            'view_total_price' => $total_apply_product_price + $total_change_delivery_price, //반품신청 총 결제금액
            'view_claim_delivery_price' => abs($total_claim_delivery_price), //반품 시 추가 배송비
            'view_apply_delivery_price' => abs($total_apply_delivery_price), //
            'view_price' => ($total_apply_price > 0 ? $total_apply_price : 0) // 환불 예정 금액
        ];
    }

    /**
     * 입금전취소 상태 변경
     * @param string $oid
     * @param string $claimReason
     * @param string $claimReasonMsg
     */
    public function updateIncomBeforeCancel($oid, $claimReason, $claimReasonMsg)
    {

        // update order_detail
        $this->qb
            ->set('status', ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE)
            ->set('update_date', date('Y-m-d H:i:s'))
            ->set('ra_date', date('Y-m-d H:i:s'))
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

        $data['status_message'] = $claimReasonMsg;
        $data['admin_message']  = '구매자';
        $data['c_type']         = 'B'; //생성자(B:구매자,S:신청자,M:MD)
        $data['reason_code']    = $claimReason;
        $this->insertOrderHistory($oid, '', ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, $data);


        //쿠폰 돌려주기. 전체 취소 혹은 관련 쿠폰으로 사용된 건이 전부 취소되었을 경우 사용함.
        //취소한 쿠폰건과 동일하게 사용된 쿠폰이 있는지 discount 확인
        //해당 od_ix 들의 정상 배송 프로세스가 있는지 개수 확인. 0이면 현재 주문건이 마지막 주문이므로 복원해주고 아니면 마지막 주문건이 아니므로 복원해주지 않음.
        //전체 취소이라서 주문 전체 돌려줌.
        $checkPossibleReturnCoupon = $this->qb
            ->select('od.od_ix')
            ->from(TBL_SHOP_ORDER_DETAIL . ' as od')
            ->join(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as odd', 'od.od_ix=odd.od_ix', 'inner')
            ->where('od.oid', $oid)
            ->whereIn('od.status',
                [ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_BUY_FINALIZED])
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

        $this->doCancelEtc($oid, ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, '입금전 취소에 따른 사용 마일리지 재적립');

        return;
    }

    /**
     * 취소요청 상태 변경
     * @param string $oid 주문번호
     * @param int $claimPcnts 취소요청 수량
     * @param int $claimDeliveryPrice 배송비
     * @param string $claimReason 취소사유코드
     * @param string $claimReasonMsg 취소사유
     */
    public function updateCancelApply($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg)
    {
        //추가금액 데이터 입력 관련 프로세스 추가 필요 181016
        //추가금액. 기존에는 신청확인 페이지에서 hidden type으로 값 넘긴 것으로 보임. total_apply_price, total_apply_product_price, total_apply_delivery_price, total_apply_tax_price, total_apply_tax_free_price

        $claimFaultType = ForbizConfig::getOrderSelectStatus('F', ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_CANCEL_APPLY, $claimReason, 'type');
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

            $odIx = '';
            for ($i = 0; $i < count($orderDetails); $i++) {
                $odIx = $orderDetails[$i]['od_ix'];
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) {
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
                }

                $this->qb
                    ->set('status', ORDER_STATUS_CANCEL_APPLY)
                    ->set('ca_date', date('Y-m-d H:i:s'))
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('claim_fault_type', $claimFaultType)
                    ->set('claim_group', $claimGroup)
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                $data['pid'] = $orderDetails[$i]['pid'];
                $data['status_message'] = $claimReasonMsg;
                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($orderDetails[$i]['oid'], $orderDetails[$i]['od_ix'], ORDER_STATUS_CANCEL_APPLY, $data);
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY,
                [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                    'oid' => $oid,
                    'claim_group' => $claimGroup,
                    'company_id' => $claimDeliveryPrice['company_id'],
                    'delivery_price' => $claimDeliveryPrice['delivery_price'],
                    'regdate' => date('Y-m-d H:i:s')
                ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            return;
        }
    }

    /**
     * 취소 완료 상태 변경
     * @param string $oid
     * @param int $claimPcnts
     * @param int $claimDeliveryPrice
     * @param string $claimReason
     * @param string $claimReasonMsg
     */
    public function updateCancelComplete($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg)
    {
        //추가금액 데이터 입력 관련 프로세스 추가 필요 181016
        //추가금액. 기존에는 신청확인 페이지에서 hidden type으로 값 넘긴 것으로 보임.
        //total_apply_price, total_apply_product_price, total_apply_delivery_price, total_apply_tax_price, total_apply_tax_free_price

        $claimFaultType = ForbizConfig::getOrderSelectStatus('F', ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_CANCEL_COMPLETE, $claimReason, 'type');
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

            $odIx = '';
            for ($i = 0; $i < count($orderDetails); $i++) {
                $odIx = $orderDetails[$i]['od_ix'];
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) {
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
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
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //판매진행중 재고 업데이트
                $this->updateStockWhenClaim($orderDetails[$i]['pid'], $orderDetails[$i]['option_id'], $claimPcnts[$orderDetails[$i]['od_ix']],
                    $orderDetails[$i]['stock_use_yn'], $orderDetails[$i]['gu_ix']);

                //주문 상태 변경 기록
                $data['pid'] = $orderDetails[$i]['pid'];
                $data['status_message'] = $claimReasonMsg;
                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_CANCEL_COMPLETE, $data);

                //쿠폰 돌려주기. 전체 취소 혹은 관련 쿠폰으로 사용된 건이 전부 취소되었을 경우 사용함.
                //취소한 쿠폰건과 동일하게 사용된 쿠폰이 있는지 discount 확인
                //해당 od_ix 들의 정상 배송 프로세스가 있는지 개수 확인. 0이면 현재 주문건이 마지막 주문이므로 복원해주고 아니면 마지막 주문건이 아니므로 복원해주지 않음.
                $checkPossibleReturnCoupon = $this->qb
                    ->select('od.od_ix')
                    ->from(TBL_SHOP_ORDER_DETAIL . ' as od')
                    ->join(TBL_SHOP_ORDER_DETAIL_DISCOUNT . ' as odd', 'od.od_ix=odd.od_ix', 'inner')
                    ->where('od.oid', $oid)
                    ->whereIn('od.status',
                        [ORDER_STATUS_INCOM_COMPLETE, ORDER_STATUS_DELIVERY_READY, ORDER_STATUS_DELIVERY_ING, ORDER_STATUS_DELIVERY_COMPLETE, ORDER_STATUS_BUY_FINALIZED])
                    ->where('dc_ix in (select dc_ix from shop_order_detail_discount where od_ix="' . $odIx . '")')
                    ->exec()->getResultArray();

                if (count($checkPossibleReturnCoupon) == 0) {
                    $this->couponModel->returnUsedCoupon($oid, ORDER_STATUS_CANCEL_COMPLETE, ['od_ix' => $odIx]);
                }
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY,
                [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                    'oid' => $oid,
                    'claim_group' => $claimGroup,
                    'company_id' => $claimDeliveryPrice['company_id'],
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
    public function updateReturnApply($oid, $claimPcnts, $claimDeliveryPrice, $claimReason, $claimReasonMsg, $returnDeliveryInfos)
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
            for ($i = 0; $i < count($orderDetails); $i++) {
                $odIx = $orderDetails[$i]['od_ix'];
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) {
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
                }

                //반품 배송정보 입력
                $deliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO,
                    [
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
                    ->set('odd_ix', $deliveryIx)
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //주문 상태 변경 기록
                $data['pid'] = $orderDetails[$i]['pid'];
                $data['status_message'] = $claimReasonMsg;
                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_RETURN_APPLY, $data);
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY,
                [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                    'oid' => $oid,
                    'claim_group' => $claimGroup,
                    'company_id' => $claimDeliveryPrice['company_id'],
                    'delivery_price' => $claimDeliveryPrice['delivery_price'],
                    'regdate' => date('Y-m-d H:i:s')
                ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            return;
        }
    }

    /**
     * 교환요청 상태 변경
     * @param string $oid
     * @param int $claimPcnts
     * @param int $claimDeliveryPrice
     * @param string $claimReason
     * @param string $claimReasonMsg
     * @param array $returnDeliveryInfos
     *      */
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
            for ($i = 0; $i < count($orderDetails); $i++) {
                $odIx = $orderDetails[$i]['od_ix'];
                if ($orderDetails[$i]['pcnt'] > $claimPcnts[$odIx] && $claimPcnts[$odIx] > 0) { //부분 교환일 경우 수량 기준으로 주문 복사 후 교환용으로 재복사
                    $odIx = $this->orderSeparate($odIx, $claimPcnts[$odIx]);
                }

                $newOdIx = $this->orderSeparate($odIx, 0, true);

                //신규 복사(생성)된 주문 정보 초기화. 다른 프로세스에서 복사기능 사용 가능하므로 최초부터 아래 정보들을 초기화처리할 수 없음.
                $resetDatas = [
                    'delivery_pi_ix' => '',
                    'delivery_ps_ix' => '',
                    'delivery_basic_ps_ix' => '',
                    'delivery_status ' => '',
                    'refund_status ' => '',
                    'quick ' => '',
                    'invoice_no ' => '',
                    'input_type ' => '',
                    'output_type ' => '',
                    'claim_fault_type ' => '',
                    'is_check_picking ' => '',
                    'is_check_delivery ' => '',
                    'return_product_state' => '',
                    'accounts_status ' => '',
                    'ac_ix ' => '',
                    'refund_ac_ix ' => '',
                    'dr_date' => NULL,
                    'di_date' => NULL,
                    'ac_date ' => NULL,
                    'dc_date ' => NULL,
                    'bf_date' => NULL,
                    'ea_date ' => NULL,
                    'ra_date ' => NULL,
                    'fa_date ' => NULL,
                    'fc_date ' => NULL,
                    'due_date ' => ''
                ];

                $this->qb->where('od_ix', $newOdIx)->update(TBL_SHOP_ORDER_DETAIL, $resetDatas)->exec();

                //교환 배송지 정보 입력
                $changeDeliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO,
                    [//교환되어야할 상품
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

                $deliveryIx = $this->qb->insert(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO,
                    [//재배송할 상품
                        'oid' => $oid,
                        'od_ix' => $newOdIx,
                        'order_type' => 2,
                        'rname' => $returnDeliveryInfos['rname'],
                        'rtel' => $returnDeliveryInfos['rtel'],
                        'rmobile' => $returnDeliveryInfos['rmobile'],
                        'zip' => $returnDeliveryInfos['rzip'],
                        'addr1' => $returnDeliveryInfos['raddr1'],
                        'addr2' => $returnDeliveryInfos['raddr2'],
                        'msg' => $returnDeliveryInfos['rmsg'],
                        'regdate' => date('Y-m-d H:i:s')
                    ])->exec();

                //주문 상태 변경
                $this->qb//교환할 기존 상품 주문
                ->set('status', ORDER_STATUS_EXCHANGE_APPLY)
                    ->set('ea_date', date('Y-m-d H:i:s'))
                    ->set('dc_date', 'IFNULL(dc_date,NOW())', false)
                    ->set('bf_date', 'IFNULL(bf_date,NOW())', false)
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('claim_fault_type', $claimFaultType)
                    ->set('claim_group', $claimGroup)
                    ->set('odd_ix', $changeDeliveryIx)
                    ->set('exchange_delivery_type', 'I')//교환배송상품발송타입(I:입고후발송,C:맞교환 발송,F:선발송)
                    ->where('od_ix', $odIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                $this->qb//재배송할 신규 교환 상품 주문
                ->set('status', ORDER_STATUS_EXCHANGE_READY)
                    ->set('update_date', date('Y-m-d H:i:s'))
                    ->set('delivery_type', $orderDetails[$i]['delivery_type'])
                    ->set('delivery_package', $orderDetails[$i]['delivery_package'])
                    ->set('delivery_policy', $orderDetails[$i]['delivery_policy'])
                    ->set('delivery_method', $orderDetails[$i]['delivery_method'])
                    ->set('delivery_pay_method', 1)//선불:1, 착불:2
                    ->set('delivery_addr_use', $orderDetails[$i]['delivery_addr_use'])
                    ->set('factory_info_addr_ix', $orderDetails[$i]['factory_info_addr_ix'])
                    ->set('claim_delivery_od_ix', $odIx)
                    ->set('claim_group', $claimGroup)
                    ->set('odd_ix', $deliveryIx)
                    ->where('od_ix', $newOdIx)
                    ->update(TBL_SHOP_ORDER_DETAIL)
                    ->exec();

                //주문 상태 변경 기록
                $data['pid'] = $orderDetails[$i]['pid'];
                $data['status_message'] = $claimReasonMsg;
                $data['admin_message'] = '구매자';
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $data['reason_code'] = $claimReason;
                $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_EXCHANGE_APPLY, $data);
            }

            $this->qb->insert(TBL_SHOP_ORDER_CLAIM_DELIVERY,
                [//클레임 배송비 DB 입력. 해당 값 없을 경우 환불완료로 상태변경 불가.
                    'oid' => $oid,
                    'claim_group' => $claimGroup,
                    'company_id' => $claimDeliveryPrice['company_id'],
                    'delivery_price' => $claimDeliveryPrice['delivery_price'],
                    'regdate' => date('Y-m-d H:i:s')
                ])->exec();

            $this->sendMessageByOrder($oid, $odIxs); //메일 발송

            return;
        }
    }

    /**
     * 배송완료 상태 변경
     * @param string $oid
     * @param string $odIx
     * @return type
     */
    public function updateDeliveryComplete($oid, $odIx)
    {
        $this->qb
            ->set('status', ORDER_STATUS_DELIVERY_COMPLETE)
            ->set('dc_date', date('Y-m-d H:i:s'))
            ->set('update_date', date('Y-m-d H:i:s'))
            ->where('od_ix', $odIx)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        $data['status_message'] = '배송완료';
        $data['admin_message'] = '구매자';
        $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_DELIVERY_COMPLETE, $data);

        return;
    }

    /**
     * 구매확정 상태 변경
     * @param string $oid
     * @param string $odIx
     * @return type
     */
    public function updateBuyFinalized($oid, $odIx)
    {
        $reserve = $this->qb
            ->select('reserve')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $odIx)
            ->exec()
            ->getRow(0, 'array');

        $this->qb
            ->set('status', ORDER_STATUS_BUY_FINALIZED)
            ->set('bf_date', date('Y-m-d H:i:s'))
            ->set('update_date', date('Y-m-d H:i:s'))
            ->where('od_ix', $odIx)
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->exec();

        $data['status_message'] = '구매확정';
        $data['admin_message'] = '구매자';
        $this->insertOrderHistory($oid, $odIx, ORDER_STATUS_BUY_FINALIZED, $data);

        //마일리지 적립
        $this->mileageModel->addMileage($reserve['reserve'], 1, '구매확정으로 인한 마일리지 적립', ['oid' => $oid, 'od_ix' => $odIx]);

        return;
    }

    /**
     * 클레임 그룹 출력
     * @param string $oid
     * @return int
     */
    public function getClaimGroup($oid)
    {
        $sqlDatas = $this->qb
            ->select('( max(claim_group) +1 ) as claim_group')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->exec()
            ->getRow(0, 'array');
        return $sqlDatas["claim_group"];
    }

    /**
     * oid 데이터 출력 후 메일 발송 처리
     * @param string $oid
     * @param string $odIxs
     */
    public function sendMessageByOrder($oid, $odIxs)
    {
        //oid 데이터 출력 후 메일 발송 처리
    }

    /**
     * 배송사별 조회 정보
     * @param string $delivery_company
     * @return array
     */
    public function searchGoodsFlow($delivery_company)
    {
        return $this->qb
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
    }

    /**
     * 주문 분리
     * @param int $odIx
     * @param int $separateCnt
     * @param boolean $copyMode
     * @return type
     */
    public function orderSeparate($odIx, $separateCnt, $copyMode = false)
    {
        $datas = $this->qb
            ->select('*')
            ->from(TBL_SHOP_ORDER_DETAIL)
            ->where('od_ix', $odIx)
            ->exec()
            ->getRow(0, 'array');

        $oid = $datas["oid"];
        $originCnt = $datas["pcnt"];
        $status = $datas["status"];
        $pid = $datas["pid"];

        if ($originCnt > $separateCnt || $copyMode) {
            $changeCnt = $originCnt - $separateCnt;
            $od_colum = $this->qb
                ->exec('desc ' . TBL_SHOP_ORDER_DETAIL)
                ->getResultArray();

            $colum_str = [];
            foreach ($od_colum as $colum) {// 주문컬럼 추가 및 삭제시
                if ($colum["Extra"] != "auto_increment") {
                    $colum_str[] = $colum["Field"];
                } else {
                    $colum_str[] = "''";
                }
            }
            //shop_order_detail 생성
            $newOdIx = $this->qb
                ->exec("INSERT INTO " . TBL_SHOP_ORDER_DETAIL . " SELECT " . implode(',', $colum_str) . " FROM " . TBL_SHOP_ORDER_DETAIL . " where od_ix='" . $odIx . "'");

            //dc_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
            $this->qb->exec("INSERT INTO " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . "
            SELECT oid,'" . $newOdIx . "',ode_ix,dc_type,dc_title,dc_rate,dc_price,dc_rate_admin,dc_price_admin,dc_rate_seller,dc_price_seller,dc_criterion,dc_msg,dc_ix,NOW()
            FROM " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " WHERE od_ix = '" . $odIx . "' and dc_type not in ('DCP','SCP')");

            if (!$copyMode) {
                //분리생성된 신규 주문 할인가 업데이트
                $this->qb
                    ->exec("UPDATE " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " SET
						dc_price = (round((dc_price_admin / '" . $originCnt . "')*'" . $separateCnt . "') + round((dc_price_seller / '" . $originCnt . "')*'" . $separateCnt . "')),
						dc_price_admin = round((dc_price_admin / '" . $originCnt . "')*'" . $separateCnt . "'),
						dc_price_seller = round((dc_price_seller / '" . $originCnt . "')*'" . $separateCnt . "')
                        where od_ix='" . $newOdIx . "' and dc_type not in ('DCP', 'SCP')");

                //기존 주문 할인가 업데이트 (반올림 이슈로 기존 금액에서 분리생성된 주문 금액을 차감함)
                $this->qb
                    ->exec("UPDATE
                                    " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " d
                                INNER JOIN
                                    " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " d2
                                ON
                                    (d.od_ix='" . $odIx . "' and d2.od_ix='" . $newOdIx . "' and d.dc_type=d2.dc_type)
                                SET
                                    d.dc_price = d.dc_price - d2.dc_price,
                                    d.dc_price_admin = d.dc_price_admin - d2.dc_price_admin,
                                    d.dc_price_seller = d.dc_price_seller - d2.dc_price_seller
                                WHERE
                                    d.od_ix='" . $odIx . "'");

                //shop_order_detail pcnt , ptprice , pt_dcprice 업데이트처리하기!
                $this->qb
                    ->exec("UPDATE " . TBL_SHOP_ORDER_DETAIL . " SET
						pcnt='" . $changeCnt . "',
						ptprice=((psprice+option_price)*" . $changeCnt . "),
						pt_dcprice=(
                                                    ((psprice+option_price)*" . $changeCnt . ")-ifnull((select sum(dc_price) as sum_dc_price from " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " where od_ix='" . $odIx . "' ),0)
                                                ),
                                                reserve=if(reserve > 0, round(reserve/{$originCnt}*{$changeCnt}), 0)
					where od_ix='" . $odIx . "'");

                $this->qb
                    ->exec("UPDATE " . TBL_SHOP_ORDER_DETAIL . " SET
						pcnt='" . $separateCnt . "',
						ptprice=((psprice+option_price)*" . $separateCnt . "),
						pt_dcprice=(
                                                    ((psprice+option_price)*" . $separateCnt . ")-ifnull((select sum(dc_price) as sum_dc_price from " . TBL_SHOP_ORDER_DETAIL_DISCOUNT . " where od_ix='" . $newOdIx . "' ),0)
                                                ),
                                                reserve = if(reserve > 0, (reserve - if(reserve > 0, round(reserve/{$originCnt}*{$changeCnt}), 0)), 0)
					where od_ix='" . $newOdIx . "'");

                $data['pid'] = $pid;
                $data['status_message'] = "주문분할[수량:" . $originCnt . "->" . $changeCnt . "(" . $separateCnt . ")]";
                $data['admin_message'] = "구매자";
                $data['c_type'] = 'B'; //생성자(B:구매자,S:신청자,M:MD)
                $this->insertOrderHistory($oid, $odIx, $status, $data);
            }
        }

        return $newOdIx;
    }

    /**
     * 취소완료 / 입금전취소 구분
     * @param string $oid 주문번호
     * @return string
     */
    public function checkPossibleCancelApply($oid)
    {
        $check = $this->qb
            ->from(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->where('status', ORDER_STATUS_INCOM_READY)
            ->limit(1)
            ->getCount();
        if ($check > 0) {
            return ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE;
        } else {
            return ORDER_STATUS_CANCEL_COMPLETE;
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
            }
        } elseif ($stockUseYn == "Q") {
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();

            if ($optionId > 0) {
                $this->qb
                    ->set('option_sell_ing_cnt',
                        '(CASE WHEN IFNULL(option_sell_ing_cnt,0) > ' . $count . ' THEN option_sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                    ->update(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                    ->whereIn('id', $optionId)
                    ->exec();
            }
        } else {
            $this->qb
                ->set('sell_ing_cnt', '(CASE WHEN IFNULL(sell_ing_cnt,0) > ' . $count . ' THEN sell_ing_cnt - ' . $count . ' ELSE 0 END)', false)
                ->update(TBL_SHOP_PRODUCT)
                ->whereIn('id', $pid)
                ->exec();
        }

        return;
    }

    /**
     * 클레임 진행시 입력되는 환불 계좌 업데이트
     * @param string $oid
     * @param string $bankCode
     * @param string $Owner
     * @param string $number
     */
    public function updateRefundAccountForClaim($oid, $bankCode, $Owner, $number)
    {
        $this->qb
            ->set('refund_method', '0')
            ->encryptSet('refund_bank_name', $Owner)
            ->encryptSet('refund_bank', $bankCode . '|' . $number)
            ->where('oid', $oid)
            ->update(TBL_SHOP_ORDER)
            ->exec();
        return;
    }

    /**
     * 실제 결제에 사용한 마일리지 데이터 출력
     * @param string $oid
     * @return int
     */
    public function getUsedMileage($oid)
    {
        $used = $this->qb
            ->select('payment_price')
            ->select('tax_price')
            ->select('tax_free_price')
            ->from(TBL_SHOP_ORDER_PAYMENT)
            ->where('oid', $oid)
            ->where('method', ORDER_METHOD_RESERVE)
            ->where('pay_type', 'G')//F : 환불처리 G : 결제처리
            ->exec()
            ->getRow(0, 'array');

        return [
            'payment_price' => $used['payment_price'] ?? 0
            , 'tax_price' => $used['tax_price'] ?? 0
            , 'tax_free_price' => $used['tax_free_price'] ?? 0
        ];
    }

    /**
     * 주문 전체 취소 체크
     * @param type $oid
     * @return type
     */
    public function isAllCancelOrder($oid)
    {
        $row = $this->qb
            ->select('COUNT(*) as cnt')
            ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
            ->where('od.oid', $oid)
            ->where('od.status', ORDER_STATUS_CANCEL_COMPLETE)
            ->where('od.refund_status', ORDER_STATUS_REFUND_APPLY)
            ->exec()
            ->getRowArray();
        $orderCancelTotalCnt = $row['cnt'];

        $row = $this->qb
            ->select('COUNT(*) as cnt')
            ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
            ->where('od.oid', $oid)
            ->exec()
            ->getRowArray();
        $orderTotalCnt = $row['cnt'];

        return ($orderCancelTotalCnt == $orderTotalCnt ? true : false);
    }

    /**
     * get 취소 하려는 결제 데이터
     * @param type $oid
     * @return type
     */
    public function getCancelPaymentData($oid)
    {
        $rows = $this->qb
            ->select('op.escrow_use')
            ->select('op.method')
            ->select('op.settle_module')
            ->select('op.tid')
            ->select('op.payment_price')
            ->select('op.tax_price')
            ->select('op.tax_free_price')
            ->from(TBL_SHOP_ORDER_PAYMENT . ' AS op')
            ->where('op.oid', $oid)
            ->where('op.pay_type', 'G')
            ->where('op.pay_status', ORDER_STATUS_INCOM_COMPLETE)
            ->whereNotIn('op.method', [ORDER_METHOD_NOPAY, ORDER_METHOD_RESERVE])
            ->exec()
            ->getResultArray();
        return $rows;
    }

    /**
     * 기타 주문 관련 취소
     * @param type $oid
     * @param type $status
     */
    public function doCancelEtc($oid, $status, $message)
    {
        //마일리지 돌려주기
        $usedMileageData = $this->getUsedMileage($oid);
        $usedMileage = $usedMileageData['payment_price'];

        if ($usedMileage > 0) {
            $this->mileageModel->addMileage($usedMileage, 4, $message, ['oid' => $oid]); //마일리지 재적립

            $pData['tax_price'] = $usedMileageData['tax_price'];
            $pData['tax_free_price'] = $usedMileageData['tax_free_price'];
            $pData['ic_date'] = date('Y-m-d H:i:s');
            $this->insertOrderPayment($oid, 'F', ORDER_STATUS_INCOM_COMPLETE, ORDER_METHOD_RESERVE, $usedMileage, $pData);

            $prData['reserve'] = $usedMileage;
            $this->insertOrderPrice($oid, 'F', 'P', $prData);
        }

        //쿠폰 돌려주기
        $this->couponModel->returnUsedCoupon($oid, $status);
    }

    /**
     * 주문 환불 완료 처리
     * @param type $oid
     */
    public function updateOrderDetailRefundComplete($oid, $statusMessage)
    {
        //주문 상태 변경
        $this->qb
            ->set('refund_status', ORDER_STATUS_REFUND_COMPLETE)
            ->set('update_date', date('Y-m-d H:i:s'))
            ->set('fc_date', date('Y-m-d H:i:s'))
            ->update(TBL_SHOP_ORDER_DETAIL)
            ->where('oid', $oid)
            ->exec();

        //주문 히스토리 등록
        $historyData['status_message'] = $statusMessage;
        $historyData['admin_message'] = 'system';
        $this->insertOrderHistory($oid, '', ORDER_STATUS_REFUND_COMPLETE, $historyData);
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
            ->where('od_ix', ($applyStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE ? '' : $odIx))
            ->whereIn('status', $searchStatus)
            ->whereNotIn('reason_code', [''])
            ->orderBy('regdate', 'DESC')
            ->limit(1)
            ->exec()
            ->getRowArray();

        if ($applyStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
            $fkey = ORDER_STATUS_INCOM_READY;
            $applyStatus = ORDER_STATUS_CANCEL_APPLY;
        } else if ($applyStatus == ORDER_STATUS_CANCEL_APPLY) {
            $fkey = ORDER_STATUS_INCOM_COMPLETE;
        } else {
            $fkey = ORDER_STATUS_DELIVERY_COMPLETE;
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
        ];
    }

    /**
     * 클레임 배송비 정보 가지고 오기 + 환불 해줄 배송비, -추가 결제 배송비
     * @param type $oid
     * @param type $claimGroup
     * @return type
     */
    public function getOrderClaimDelivery($oid, $claimGroup)
    {
        $row = $this->qb
            ->select('ifnull(delivery_price, 0) as price')
            ->from(TBL_SHOP_ORDER_CLAIM_DELIVERY)
            ->where('oid', $oid)
            ->whereIn('claim_group', $claimGroup)
            ->exec()
            ->getRowArray();
        return $row['price'];
    }

    /**
     * get 입력되는 환불 계좌
     * @param type $oid
     * @return type
     */
    public function getClaimRefundAccount($oid)
    {
        $row = $this->qb
            ->decryptSelect('refund_bank_name')
            ->decryptSelect('refund_bank')
            ->from(TBL_SHOP_ORDER)
            ->where('oid', $oid)
            ->exec()
            ->getRowArray();

        $tmp = explode('|', $row['refund_bank']);
        $bankCode = $tmp[0];
        $bankNumber = ($tmp[1] ?? '');
        $bankNumber = substr($bankNumber, 0, 3) . '*******';

        return [
            'bankOwner' => $row['refund_bank_name']
            , 'bankCode' => $bankCode
            , 'bankName' => ForbizConfig::getBankList($bankCode)
            , 'bankNumber' => $bankNumber
        ];
    }

    /**
     * get 배송지 데이터 가지고 오기
     * @param type $oid
     * @param type $odIx
     * @param type $orderType
     * @return type
     */
    public function getClaimDeliveryinfo($oid, $odIx)
    {
        $row = $this->qb
            ->select('rname')
            ->select('zip')
            ->select('addr1')
            ->select('addr2')
            ->select('rmail')
            ->select('rmobile')
            ->select('rtel')
            ->select('msg')
            ->select('quick')
            ->select('invoice_no')
            ->select('send_yn')
            ->select('send_type')
            ->select('delivery_pay_type')
            ->from(TBL_SHOP_ORDER_DETAIL_DELIVERYINFO)
            ->where('oid', $oid)
            ->where('od_ix', $odIx)
            ->orderBy('regdate', 'DESC')
            ->limit(1)
            ->exec()
            ->getRowArray();

        $row['quickText'] = ForbizConfig::getDeliveryCompanyInfo($row['quick'], 'name');
        return $row;
    }

    /**
     * get 클레임 거부/불가 리스트
     * @param type $oid
     * @param type $claimGroup
     * @return type
     */
    public function getClaimDenyList($oid, $claimGroup)
    {
        $rows = $this->qb
            ->select('od.pname')
            ->select('od.option_text')
            ->select('SUBSTR(os.status,2,1) AS deny_type')
            ->select('os.status_message As deny_message')
            ->from(TBL_SHOP_ORDER_DETAIL . ' AS od')
            ->join(TBL_SHOP_ORDER_STATUS . ' AS os', 'od.oid=os.oid AND od.od_ix=os.od_ix AND od.status=os.status')
            ->where('od.oid', $oid)
            ->whereIn('od.claim_group', $claimGroup)
            ->whereIn('od.status',
                [ORDER_STATUS_RETURN_DENY, ORDER_STATUS_RETURN_IMPOSSIBLE, ORDER_STATUS_RETURN_DENY, ORDER_STATUS_RETURN_IMPOSSIBLE, ORDER_STATUS_EXCHANGE_DENY, ORDER_STATUS_EXCHANGE_IMPOSSIBLE])
            ->orderBy('os.regdate', 'DESC')
            ->limit(1)
            ->exec()
            ->getResultArray();
        return $rows;
    }
}