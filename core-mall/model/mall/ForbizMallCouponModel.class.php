<?php

/**
 * Description of ForbizMallCouponModel
 *
 * @author hong
 */
class ForbizMallCouponModel extends ForbizModel
{

    /**
     * 쿠폰 정책 정보
     * @var type
     */
    protected $config;

    /**
     * 사용 환경 (G: PC, M:모바일)
     * 일반적으로 W가 웹이나, 쿠폰에서는 G가 웹으로 사용됨
     * @var string
     */
    protected $agentType = 'G';

    /**
     * 회원 그룹 인덱스 (common_member_detail.gp_ix)
     * @var type
     */
    protected $memberGroupIx = 0;

    /**
     * 회원 code (common_user.code)
     * @var type
     */
    protected $userCode = '';

    /**
     * 회원그룹 쿠폰사용여부
     * @var type
     */
    protected $userGroupCouponYn = '';

    public function __construct()
    {
        parent::__construct();

        $this->config = ForbizConfig::getSharedMemory('b2c_coupon_rule');

        $this->setAgentType((is_mobile() ? "M" : "G"));
        $this->setMember(sess_val('user', 'code'), sess_val('user', 'gp_ix'), sess_val('user', 'use_coupon_yn'));
    }

    /**
     * set 사용 환경
     * @param string $agentType
     * @return $this
     */
    public function setAgentType($agentType)
    {
        $this->agentType = strtoupper($agentType);
        return $this;
    }

    /**
     * set 회원
     * @param string $userCode
     * @param int $gpIx
     * @param string $userGroupCouponYn
     * @return $this
     */
    public function setMember($userCode, $gpIx, $userGroupCouponYn)
    {
        $this->userCode = $userCode;
        $this->memberGroupIx = $gpIx;
        $this->userGroupCouponYn = $userGroupCouponYn;
        return $this;
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
                ->whereIn('odd.dc_type', ['CP'])
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

    /**
     * 해당하는 쿠폰 정보 출력
     * @param int $publishIx
     * @return array
     */
    public function getCouponDatas($publishIx)
    {
        return $this->setBasicSelect()
                ->select('cp.regist_date_differ')
                ->from(TBL_SHOP_CUPON . ' as c')
                ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'on c.cupon_ix=cp.cupon_ix', 'inner')
                ->where('cp.publish_ix', $publishIx)
                ->exec()
                ->getRow(0, 'array');
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

        $this->qb
            ->select('use_yn')
            ->select("cr.regist_ix")
            ->select("date_format(cr.use_sdate, '%Y-%m-%d') as regist_start, date_format(cr.use_date_limit, '%Y-%m-%d') as regist_end")
            ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
            ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix=cp.publish_ix', 'inner')
            ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix=cp.cupon_ix', 'inner')
            ->where('cr.mem_ix', $this->userCode)
            ->whereIn('c.cupon_use_div', ['A', $this->agentType])
            ->where('cp.is_use !=', '3')
            ->orderBy('cr.regdate', 'desc');

        if ($useYn !== null) {
            if ($useYn) { //사용완료 & 기한만료된 쿠폰
                $this->setBasicUseWhere($useYn);
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

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 다운 가능한 쿠폰 리스트 노출(마이페이지에서 다운가능한 모든쿠폰)
     * @param string $pid
     * @return array
     */
    public function getDownCouponList()
    {
        if ($this->isUseCoupon()) {
            $result = $this
                ->setBasicQuery()
                ->where('cp.issue_type', '2')
                ->where('cp.use_product_type', '1') //발급 대상 상품 : 전체
                ->exec()
                ->getResultArray();

            return $result;
        }else {
            return;
        }
    }

    /**
     * 다운 가능한 쿠폰 리스트 노출(쇼핑몰에서 발행한 쿠폰)
     * @param string $pid
     * @return array
     */
    public function getMallCouponList($pid = '')
    {
        if ($this->isUseCoupon()) {
            $useForAllProduct = $this
                ->setBasicQuery()
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->where('cp.use_product_type', '1') //발급 대상 상품 : 전체
                ->exec()
                ->getResultArray();

            $useForSomeCategory = $this
                ->setBasicQuery()
                ->join(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as crc', 'cp.publish_ix=crc.publish_ix', 'inner')
                ->join(TBL_SHOP_PRODUCT_RELATION . ' as pr', 'SUBSTRING(crc.cid,1,(crc.depth+1)*3) = SUBSTRING(pr.cid,1,(crc.depth+1)*3) ' . (!empty($pid) ? 'and pr.pid="' . $pid . '"' : ''), 'inner')
                ->where('cp.use_product_type', '2') //발급 대상 상품 : 특정 카테고리
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->exec()
                ->getResultArray();

            $useForSomeProduct = $this
                ->setBasicQuery()
                ->join(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp', 'cp.publish_ix=crp.publish_ix ' . (!empty($pid) ? 'and crp.pid="' . $pid . '"' : ''), 'inner')
                ->where('cp.use_product_type', '3') //발급 대상 상품 : 특정 상품
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->exec()
                ->getResultArray();

            $useForSomeBrand = $this
                ->setBasicQuery()
                ->join(TBL_SHOP_CUPON_RELATION_BRAND . ' as crb', 'on cp.publish_ix=crb.publish_ix', 'inner')
                ->join(TBL_SHOP_PRODUCT . ' as p', 'on p.brand=crb.b_ix ' . (!empty($pid) ? 'and p.id="' . $pid . '"' : ''), 'inner')
                ->where('cp.use_product_type', '4') //발급 대상 상품 : 특정 브랜드
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->exec()
                ->getResultArray();

            $useForSomeSeller = $this
                ->setBasicQuery()
                ->join(TBL_SHOP_CUPON_RELATION_SELLER . ' as crs', 'cp.publish_ix=crs.publish_ix', 'inner')
                ->join(TBL_SHOP_PRODUCT . ' as p', 'crs.company_id=p.admin ' . (!empty($pid) ? 'and p.id="' . $pid . '"' : ''), 'inner')
                ->where('cp.use_product_type', '5') //발급 대상 상품 : 특정 셀러
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->exec()
                ->getResultArray();


            // 제외 대상이 아니면 쿠폰 노출
            $useForSomeExceptProduct = $this
                ->setBasicQuery()
                ->join(TBL_SHOP_CUPON_RELATION_PRODUCT . ' as crp', 'cp.publish_ix=crp.publish_ix ' . (!empty($pid) ? 'and crp.pid !="' . $pid . '"' : ''), 'inner')
                ->where('cp.use_product_type', '6') //발급 대상 상품 : 특정 상품 제외
                ->where('cp.issue_type', '2')
                ->where('cp.issue_type_detail', '1')
                ->exec()
                ->getResultArray();

            $result = array_merge($useForAllProduct, $useForSomeCategory, $useForSomeProduct, $useForSomeBrand, $useForSomeSeller, $useForSomeExceptProduct);

            foreach ($result as $k => $v) {
                $result[$k]['isPublished'] = $this->checkPublished($v['publish_ix']);
            }

            return $result;
        } else {
            return;
        }
    }

    /**
     * 쿠폰이 이미 등록된 상태인지 확인
     * @param int $publishIx
     * @return boolean
     */
    public function checkPublished($publishIx)
    {
        $count = $this->qb->select('regist_ix')
            ->from(TBL_SHOP_CUPON_REGIST)
            ->where('publish_ix', $publishIx)
            ->where('mem_ix', $this->userCode)
            ->limit(1)
            ->getCount();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 쿠폰발급받은 수량 체크
     * @param int $publishIx
     * @return boolean
     */
    public function checkCouponDownCnt($publishIx)
    {
        $count = $this->qb->select('regist_ix')
            ->from(TBL_SHOP_CUPON_REGIST)
            ->where('publish_ix', $publishIx)
            ->where('mem_ix', $this->userCode)
            ->getCount();

            return $count;
    }

    /**
     * 쿠폰 지급
     * @param int $publishIx
     * @return string
     */
    public function giveCoupon($publishIx)
    {
        if (!$this->checkPublished($publishIx)) {
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

            $this->qb->insert(TBL_SHOP_CUPON_REGIST, [
                'publish_ix' => $publishIx,
                'mem_ix' => $this->userCode,
                'open_yn' => 0,
                'use_yn' => 0,
                'use_sdate' => $use_sdate,
                'use_date_limit' => $use_date_limit,
                'regdate' => date('Y-m-d H:i:s')
            ])->exec();
            return 'success';
        } else {
            return 'fail';
        }
    }

    /**
     * 회원이 보유중인 쿠폰 수
     * @param string $useYn : true(사용한 & 기한만료된 쿠폰) or false(미사용한 쿠폰)
     * @return int
     */
    public function getCouponCnt($useYn = false)
    {
        $ret = 0;

        if ($this->isUseCoupon()) {
            $this->qb
                ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
                ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix = cp.publish_ix')
                ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix = cp.cupon_ix')
                ->where('cr.mem_ix', $this->userCode)
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
     * 해당 상품의 보유쿠폰 적용 정보 리스트
     * @param type $pid
     * @param type $unitPrice
     * @param type $paymentPrice
     * @return type
     */
    public function applyProductUserCouponList($pid, $unitPrice, $paymentPrice)
    {
        $myCouponList = $this->getUserCouponList(false, 1, 100
                , ['cr.regist_ix', 'cp.use_product_type', 'c.cupon_acnt', 'c.haddoffice_rate', 'c.seller_rate', 'c.round_position', 'c.round_type', 'cp.publish_max', 'cp.publish_limit_price']
                , ['c.cupon_div' => 'G'])['list'];
        foreach ($myCouponList as $key => $coupon) {
            $activeBool = $this->checkProductCouponActive($pid, $unitPrice, $coupon);
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
                'cp.publish_limit_price']
                , ['c.cupon_div' => 'G', 'cr.regist_ix' => $regist_ix])['list'][0] ?? false);

        //내 쿠폰인지 아닐경우
        if ($coupon === false) {
            return false;
        } else {
            $activeBool = $this->checkProductCouponActive($pid, $unitPrice, $coupon);
            if ($activeBool) {
                return $this->calculationDiscount($paymentPrice, $coupon);
            } else {
                return false;
            }
        }
    }

    /**
     * 쿠폰 사용 처리
     * @param type $registIx
     * @param type $oid
     * @param type $pid
     */
    public function useCoupon($registIx, $oid, $pid)
    {
        $this->qb
            ->set('use_yn', 1)
            ->set('use_oid', $oid)
            ->set('use_pid', $pid)
            ->set('usedate', date('Y-m-d H:i:s'))
            ->update(TBL_SHOP_CUPON_REGIST)
            ->where('regist_ix', $registIx)
            ->exec();
    }

    /**
     * 쿠폰 적용 대상
     * @param boolean $useYn
     * @param int $page
     * @param int $limit
     * @param array $addSelect
     * @param array $addWhere
     * @return array
     */
    public function getCouponApplyProductList($registIx)
    {
        $row = $this->setBasicSelect()
                ->select("cr.regist_ix")
                ->select("date_format(cr.use_sdate, '%Y-%m-%d') as regist_start, date_format(cr.use_date_limit, '%Y-%m-%d') as regist_end")
                ->from(TBL_SHOP_CUPON_REGIST . ' as cr')
                ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'cr.publish_ix=cp.publish_ix', 'inner')
                ->join(TBL_SHOP_CUPON . ' as c', 'c.cupon_ix=cp.cupon_ix', 'inner')
                ->where('cr.mem_ix', $this->userCode)
                ->where('cr.regist_ix', $registIx)
                ->exec()->getRowArray();

        if (!empty($row)) {
            // 카테고리 상품
            if ($row['use_product_type'] == '2') {

                $row['plist'] = $this->qb
                    ->select("t3.pname, t3.id, t2.cid")
                    ->from(TBL_SHOP_CUPON_RELATION_CATEGORY . ' as t1')
                    ->join(TBL_SHOP_PRODUCT_RELATION . ' as t2', 't1.cid = t2.cid', 'inner')
                    ->join(TBL_SHOP_PRODUCT . ' as t3', 't3.id = t2.pid', 'inner')
                    ->where('t1.publish_ix', $row['publish_ix'])
                    ->orderBy('t2.cid', 'asc')
                    ->orderBy('t3.regdate', 'desc')
                    ->exec()
                    ->getResultArray();

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
            }
        }
        return $row;
    }

    /**
     * 특정 조건 쿠폰 발급
     * @param type $issueTypeDetail 1:회원가입 완료시, 2:회원그룹 변경 시, 3:기념일(생일) 시, 4:APP 최초 다운로드 시
     */
    public function preferredConditionGiveCoupon($issueTypeDetail)
    {
        $rows = $this->setBasicQuery()
            ->where('cp.issue_type_detail', $issueTypeDetail)
            ->where('cp.issue_type', '4')
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $this->giveCoupon($row['publish_ix']);
            }
        }
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
        } else { //정액
            $discountAmount = $cuponSaleValue;
            $headofficeDiscountAmount = $haddofficeRate;
            $sellerDiscountAmount = $sellerRate;
        }

        //최대 할인금액
        if ($publishMax == 'Y' && $publishLimitPrice > 0 && $discountAmount > $publishLimitPrice) {
            $headofficeDiscountAmount = ($headofficeDiscountAmount * $publishLimitPrice / $discountAmount)->rund((defined('BCSCALE') ? BCSCALE : 0));
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
                default :
                    return false;
                    break;
            }

            $total = $this->qb->limit(1)->getCount();
            if ($total > 0) {
                $activeBool = true;
            }
        }
        return $activeBool;
    }

    /**
     * 관리자 설정의 쿠폰 사용 여부 확인
     * @return boolean
     */
    protected function isUseCoupon()
    {
        if ($this->config['coupon_use_yn'] == 'Y' && !empty($this->userCode) && $this->userGroupCouponYn == 'Y') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 쿠폰 리스트 호출의 기본 sql문 세팅
     * @return type
     */
    protected function setBasicQuery()
    {
        return $this->setBasicSelect()
                ->from(TBL_SHOP_CUPON . ' as c')
                ->join(TBL_SHOP_CUPON_PUBLISH . ' as cp', 'on c.cupon_ix=cp.cupon_ix', 'inner')
                ->join(TBL_SHOP_CUPON_PUBLISH_CONFIG . ' as cpc ', 'cp.publish_ix=cpc.publish_ix', 'left')
                ->whereIn('c.mall_ix', ['', MALL_IX])
                ->whereIn('c.cupon_use_div', ['A', $this->agentType])
                ->where('c.is_use', '1')
                ->where('cp.disp', '1')
                ->where('cp.cupon_use_sdate <=', time()) //노출기간
                ->where('cp.cupon_use_edate >=', time()) //노출기간
                //사용기간 조건
                ->groupStart()
                ->orGroupStart()
                ->where('cp.use_date_type', '9') //무기한
                ->groupEnd()
                ->orGroupStart()
                ->where('cp.use_date_type', '3') //사용기간 지정
                ->where('cp.use_sdate <=', date('Y-m-d H:i:s'))
                ->where('cp.use_edate >=', date('Y-m-d H:i:s'))
                ->groupEnd()
                ->orGroupStart()
                ->where('cp.use_date_type', '2') //발급일 기준
                ->groupEnd()
                ->orGroupStart()
                ->where('cp.use_date_type', '1') //발행일 기준
                ->where('cp.regdate <=', date('Y-m-d H:i:s'))
                ->where('case when publish_date_type = "1" then date_add(cp.regdate, INTERVAL cp.publish_date_differ YEAR )
                            when publish_date_type = "2" then date_add(cp.regdate, INTERVAL cp.publish_date_differ MONTH )
                            when publish_date_type = "3" then date_add(cp.regdate, INTERVAL cp.publish_date_differ DAY)
                            end >=', date('Y-m-d H:i:s'))
                ->groupEnd()
                ->groupEnd()
                //사용기간 조건
                //발급대상회원 조건
                ->groupStart()
                ->orGroupStart()
                ->where('cp.publish_type', '2') //전체회원
                ->groupEnd()
                ->orGroupStart()
                ->where('cp.publish_type', '1') //관리자 지정 회원
                ->where('cpc.r_ix', $this->userCode)
                ->groupEnd()
                ->orGroupStart()
                ->where('cp.publish_type', '4') //관리자 지정 그룹
                ->where('cpc.r_ix', $this->memberGroupIx)
                ->groupEnd()
                ->groupEnd();
        //발급대상회원 조건
    }

    /**
     *  쿠폰 리스트 호출 select문 기본 세팅. shop_cupon, shop_cupon_publish 테이블의 컬럼만 사용할것.
     */
    protected function setBasicSelect()
    {
        return $this->qb->select('(case when publish_date_type = 3 then DATE_ADD(c.regdate, INTERVAL publish_date_differ DAY)'
                    . 'when publish_date_type = 2 then DATE_ADD(c.regdate, INTERVAL publish_date_differ MONTH)'
                    . 'when publish_date_type = 1 then DATE_ADD(c.regdate, INTERVAL publish_date_differ YEAR) else "" end ) as publish_limit_date') //발행일 기준의 종료일
                ->select('cupon_use_div')
                ->select('use_product_type')
                ->select('use_date_type')
                ->select('publish_name')
                ->select('cupon_sale_type')
                ->select('cupon_sale_value')
                ->select('c.regdate')
                ->select('regist_date_type')
                ->select('cp.use_sdate')
                ->select('cp.use_edate')
                ->select('publish_min')
                ->select('publish_max')
                ->select('publish_condition_price')
                ->select('publish_limit_price')
                ->select('regist_count')
                ->select('cp.publish_ix')
                ->select('cp.regist_date_differ');
    }

    /**
     * 쿠폰 사용가능 여부 조건처리
     * @param boolean $useYn
     * @return type
     */
    protected function setBasicUseWhere($useYn)
    {
        if ($useYn) { //사용완료 & 기한만료된 쿠폰
            return $this->qb
                    ->groupStart()
                    ->where('use_yn', 1)
                    ->where('cp.is_use !=', '3')
                    ->orGroupStart()
                    ->where('use_yn', 0)
                    ->where('date_format(cr.use_date_limit, "%Y-%m-%d") < date_format(sysdate(), "%Y-%m-%d") ')
                    ->where('cp.use_date_type!=', 9)
                    ->groupEnd()
                    ->groupEnd();
        } else { //사용가능 쿠폰
            return $this->qb
                    ->where('use_yn', 0)
                    ->groupStart()
                    ->groupStart()
                    ->where('date_format(cr.use_date_limit, "%Y-%m-%d") >= date_format(sysdate(), "%Y-%m-%d") ')
                    ->where('date_format(cr.use_sdate, "%Y-%m-%d") <= date_format(sysdate(), "%Y-%m-%d") ')
                    ->where('cp.use_date_type!=', 9)
                    ->groupEnd()
                    ->where('cp.is_use !=', '3')
                    ->orGroupStart()
                    ->where('cp.use_date_type', 9)
                    ->groupEnd()
                    ->groupEnd();
        }
    }
}
