<?php

/**
 * Description of ForbizMallFatModel
 *
 * @author hong
 */
class ForbizMallFatModel extends ForbizModel
{
    protected $sDate;
    protected $eDate;
    protected $cid;
    protected $refHash;

    public function __construct()
    {
        parent::__construct();

        $this->initCfg();
    }

    protected function initCfg()
    {
        // DB 설정
        $statDb    = 'enter_statistics.';
        $productDb = 'enterprisedev_db.';

        // 테이블 설정
        define('STAT_TBL_LOG', $statDb.'system_prdt_vwlog');
        define('STAT_TBL_ORDER', $productDb.'shop_order');
        define('STAT_TBL_ORDER_DETAIL', $productDb.'shop_order_detail');
        define('STAT_TBL_PAYMENT', $productDb.'shop_order_payment');
        define('STAT_TBL_PRODUCT', $productDb.'shop_product');
        define('STAT_TBL_CATEGORY', $productDb.'shop_product_relation');

        // 기본날짜 구간 설정
        $this->sDate = date('Y-m-d');
        $this->eDate = date('Y-m-d');

        // 기준 URL
        $this->refHash = false;
    }

    /**
     * 통계DB
     * @return NunaQb
     */
    public function sQb()
    {
        return $this->qb->setDatabase('stat');
    }

    public function setSdate($sDate)
    {
        $this->sDate = $sDate;

        return $this;
    }

    public function setEdate($eDate)
    {
        $this->eDate = $eDate;

        return $this;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    public function setRefHash($url)
    {
        if (!empty($url)) {
            $this->refHash = md5(trim($url));
        } else {
            $this->refHash = false;
        }

        return $this;
    }

    /**
     * 주문 조건 설정
     * @param string $alias
     * @return NunaQb
     */
    protected function orderWhere($alias = '')
    {
        $this->sQb()
            ->whereIn(($alias ? $alias.'.product_type' : 'product_type'), [0, 99])
            ->whereIn(($alias ? $alias.'.status' : 'status'), ['IR', 'IC', 'DR', 'DI', 'DC', 'BF']);

        if ($this->refHash) {
            $this->sQb()
                ->where(($alias ? $alias.'.hash_idx' : 'hash_idx').' IN '.$this->qb->startSubQuery()
                    ->select('hash_idx')
                    ->from(STAT_TBL_LOG)
                    ->where('refhash', $this->refHash)
                    ->betweenDate('ldate', $this->sDate, $this->eDate)
                    ->endSubQuery(), '', false);
        }

        return $this->sQb();
    }

    /**
     * 조회 조건 설정
     * @param type $alias
     * @return type
     */
    protected function viewWhere($alias = '')
    {
        if ($this->refHash) {
            $this->sQb()
                ->where(($alias ? $alias.'.refhash' : 'refhash'), $this->refHash);
        }

        return $this->sQb();
    }

    /**
     * 옵션별 주문 분석(Tok)
     * @param string $pid
     * @return array
     */
    public function getOrderOptionStat($pid, $option_text = '')
    {
        if ($option_text) {
            $this->qb
                ->select("DATE_FORMAT(regdate, '%Y-%m-%d') AS ldate", false)
                ->where('option_text', $option_text)
                ->groupBy('ldate');
        } else {
            $this->qb
                ->select('option_text')
                ->groupBy('option_text');
        }

        $rows = $this->orderWhere()
            ->select('count(*) AS cnt')
            ->from(STAT_TBL_ORDER_DETAIL)
            ->where('pid', $pid)
            ->betweenDate('regdate', $this->sDate, $this->eDate)
            ->exec()
            ->getResultArray();

        return $rows;
    }

    /**
     * 함께 구매한 상품(Tok)
     * @param type $pid
     * @return type
     */
    public function getTogetherProuct($pid)
    {
        $lSql = $this->qb
            ->select('COUNT(*)', false)
            ->from(STAT_TBL_LOG.' l')
            ->where('l.pid = od.pid')
            ->betweenDate('ldate', $this->sDate, $this->eDate)
            ->toStr();

        $rows = $this->orderWhere('od')
            ->select('od.pid')
            ->select('p.pname')
            ->select('p.listprice AS dcprice', false)
            ->select('COUNT(*) AS orderCnt', false)
            ->select("({$lSql}) AS viewCnt", false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_PRODUCT.' p', 'od.pid=p.id')
            ->where('od.oid IN '.$this->qb->startSubQuery()
                ->select('oid')
                ->from(STAT_TBL_ORDER_DETAIL)
                ->where('pid', $pid)
                ->betweenDate('regdate', $this->sDate, $this->eDate)
                ->endSubQuery(), '', false)
            ->where('od.pid !=', $pid)
            ->groupBy('od.pid')
            ->groupBy('p.pname')
            ->groupBy('p.listprice')
            ->orderBy('orderCnt', 'desc')
            ->limit(20)
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            foreach ($rows as $key => $row) {
                if (($row['orderCnt'] ?? 0) > 0 && ($row['viewCnt'] ?? 0) > 0) {
                    $rows[$key]['cnv_rt'] = round($row['orderCnt'] / $row['viewCnt'] * 100, 2);
                } else {
                    $rows[$key]['cnv_rt'] = 0;
                }
                //$rows[$key]['thumb'] = get_product_images_src($row['pid'], true, 's');
                $rows[$key]['thumb'] = get_product_images_src_new($row['pid'], true, 'slist', '', 0);
            }
        }

        return $rows;
    }

    /**
     * 주문/조회 분석(Tok)
     * @param type $pid
     * @return type
     */
    public function getOrderAndView($pid)
    {
        $viewRows = $this->sQb()
            ->select("DATE_FORMAT(ldate, '%m-%d') AS ldate", false)
            ->select('wtype')
            ->select('count(*) AS cnt', false)
            ->from(STAT_TBL_LOG)
            ->where('pid', $pid)
            ->betweenDate('ldate', $this->sDate, $this->eDate)
            ->groupBy('ldate')
            ->groupBy('wtype')
            ->exec()
            ->getResultArray();

        $orderRows = $this->orderWhere('od')
            ->select("DATE_FORMAT(od.regdate, '%m-%d') AS ldate", false)
            ->select("o.payment_agent_type AS wtype")
            ->select("count(od.oid) AS cnt", false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_ORDER.' o', 'od.oid = o.oid')
            ->where('od.pid', $pid)
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('ldate')
            ->groupBy('wtype')
            ->exec()
            ->getResultArray();

        $viewRows  = fb_column($viewRows, 'ldate', true);
        $orderRows = fb_column($orderRows, 'ldate', true);

        $keys = array_unique(array_keys(array_merge($viewRows, $orderRows)));
        sort($keys);

        $statData = [];
        if (!empty($keys)) {
            foreach ($keys as $key => $date) {
                $vRow = [
                    'M' => ['cnt' => 0]
                    , 'W' => ['cnt' => 0]
                ];
                if (isset($viewRows[$date])) {
                    $tRow             = fb_column($viewRows[$date], 'wtype');
                    $vRow['M']['cnt'] = $tRow['M']['cnt'] ?? 0;
                    $vRow['W']['cnt'] = $tRow['W']['cnt'] ?? 0;
                }

                $oRow = [
                    'M' => ['cnt' => 0]
                    , 'W' => ['cnt' => 0]
                ];

                if (isset($orderRows[$date])) {
                    $tRow             = fb_column($orderRows[$date], 'wtype');
                    $oRow['M']['cnt'] = $tRow['M']['cnt'] ?? 0;
                    $oRow['W']['cnt'] = $tRow['W']['cnt'] ?? 0;
                }

                $statData[$key]['date']   = $date;
                $statData[$key]['view']   = ($vRow['M']['cnt'] + $vRow['W']['cnt']);
                $statData[$key]['mView']  = $vRow['M']['cnt'];
                $statData[$key]['wView']  = $vRow['W']['cnt'];
                $statData[$key]['order']  = ($oRow['M']['cnt'] + $oRow['W']['cnt']);
                $statData[$key]['mOrder'] = $oRow['M']['cnt'];
                $statData[$key]['wOrder'] = $oRow['W']['cnt'];
            }
        }

        return $statData;
    }

    /**
     * 주문/조회 상세 내역(Tok)
     * @param type $pid
     * @return type
     */
    public function getOrderAndViewDetail($pid)
    {
        $viewRows = $this->viewWhere()
            ->select('ldate')
            ->select('wtype')
            ->select('COUNT(*) AS cnt')
            ->from(STAT_TBL_LOG)
            ->where('pid', $pid)
            ->betweenDate('ldate', $this->sDate, $this->eDate)
            ->groupBy('ldate')
            ->groupBy('wtype')
            ->exec()
            ->getResultArray();

        $orderRows = $this->orderWhere('od')
            ->select("DATE_FORMAT(od.regdate, '%Y-%m-%d') AS ldate")
            ->select("o.payment_agent_type AS wtype")
            ->select("COUNT(*) AS cnt")
            ->from(STAT_TBL_ORDER.' o')
            ->join(STAT_TBL_ORDER_DETAIL.' od', 'o.oid = od.oid')
            ->where('od.pid', $pid)
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('ldate')
            ->groupBy('wtype')
            ->exec()
            ->getResultArray();

        $viewRows  = fb_column($viewRows, 'ldate');
        $orderRows = fb_column($orderRows, 'ldate');

        $dateArr = array_unique(array_merge(array_keys($viewRows), array_keys($orderRows)));

        $detailData = [];
        foreach ($dateArr as $day) {
            if (!isset($detailData[$day])) {
                $detailData[$day] = [
                    'vTotal' => 0,
                    'vWeb' => 0,
                    'vMob' => 0,
                    'oTotal' => 0,
                    'oWeb' => 0,
                    'oMob' => 0
                ];
            }

            if (isset($viewRows[$day])) {
                $detailData[$day]['vTotal'] += $viewRows[$day]['cnt'];
                $detailData[$day]['vWeb']   += ($viewRows[$day]['wtype'] == 'W' ? $viewRows[$day]['cnt'] : 0);
                $detailData[$day]['vMob']   += ($viewRows[$day]['wtype'] != 'W' ? $viewRows[$day]['cnt'] : 0);
            }

            if (isset($orderRows[$day])) {
                $detailData[$day]['oTotal'] += $orderRows[$day]['cnt'];
                $detailData[$day]['oWeb']   += ($orderRows[$day]['wtype'] == 'W' ? $orderRows[$day]['cnt'] : 0);
                $detailData[$day]['oMob']   += ($orderRows[$day]['wtype'] != 'W' ? $orderRows[$day]['cnt'] : 0);
            }
        }

        return $detailData;
    }

    /**
     * 상품별 주문,조회 리스트(Tok)
     * @param array $pids
     * @return array
     */
    public function getViewAndOrderList($pids)
    {
        // 일별 상품 조회수
        $viewRows = fb_column($this->viewWhere()
                ->select('pid')
                ->select('wtype')
                ->select('count(*) AS cnt', false)
                ->from(STAT_TBL_LOG)
                ->whereIn('pid', $pids)
                ->betweenDate('ldate', $this->sDate, $this->eDate)
                ->groupBy('pid')
                ->groupBy('wtype')
                ->exec()
                ->getResultArray(), 'pid', true);

        // 일별 주문수
        $orderRows = fb_column($this->orderWhere('od')
                ->select('od.pid')
                ->select("o.payment_agent_type AS wtype")
                ->select("COUNT(o.oid) AS cnt")
                ->from(STAT_TBL_ORDER.' o')
                ->join(STAT_TBL_ORDER_DETAIL.' od', 'o.oid = od.oid')
                ->whereIn('od.pid', $pids)
                ->betweenDate('regdate', $this->sDate, $this->eDate)
                ->groupBy('pid')
                ->groupBy('wtype')
                ->exec()
                ->getResultArray(), 'pid', true);

        $keys     = array_unique(array_merge(array_keys($viewRows), array_keys($orderRows)));
        $statData = [];

        $productRows = fb_column($this->sQb()
                ->select('id')
                ->select('pname')
                ->select('listprice')
                ->select('brand_name')
                ->select('pcode')
                ->select("CONCAT('http://getbarrel.com/shop/goodsView/', id) AS url", false)
                ->from(STAT_TBL_PRODUCT)
                ->whereIn('id', $pids)
                ->exec()
                ->getResultArray(), 'id');

        if (!empty($keys)) {
            foreach ($keys as $pid) {
                if (!isset($statData[$pid])) {
                    $statData[$pid] = [
                        'pid' => $pid
                        , 'pcode' => ($productRows[$pid]['pcode'] ?? '')
                        , 'pname' => ($productRows[$pid]['pname'] ?? '')
                        , 'brand' => ($productRows[$pid]['brand_name'] ?? '')
                        , 'price' => ($productRows[$pid]['listprice'] ?? '')
                        , 'wView' => 0
                        , 'mView' => 0
                        , 'tView' => 0
                        , 'wOrder' => 0
                        , 'mOrder' => 0
                        , 'tOrder' => 0
                        , 'wRate' => 0
                        , 'mRate' => 0
                        , 'tRate' => 0
                        , 'url' => ($productRows[$pid]['url'] ?? '')
                    ];
                }

                if (isset($viewRows[$pid])) {
                    $tRow                    = fb_column($viewRows[$pid], 'wtype');
                    $statData[$pid]['wView'] += ($tRow['W']['cnt'] ?? 0);
                    $statData[$pid]['mView'] += ($tRow['M']['cnt'] ?? 0);
                    $statData[$pid]['tView'] += ($statData[$pid]['wView'] + $statData[$pid]['mView']);
                }

                if (isset($orderRows[$pid])) {
                    $tRow                     = fb_column($orderRows[$pid], 'wtype');
                    $statData[$pid]['wOrder'] += ($tRow['W']['cnt'] ?? 0);
                    $statData[$pid]['mOrder'] += ($tRow['M']['cnt'] ?? 0);
                    $statData[$pid]['tOrder'] += ($statData[$pid]['wOrder'] + $statData[$pid]['mOrder']);
                }

                // 웹 구매율 계산
                if (($statData[$pid]['wOrder'] ?? 0) > 0 && $statData[$pid]['wView'] ?? 0 > 0) {
                    $statData[$pid]['wRate'] = round($statData[$pid]['wOrder'] / $statData[$pid]['wView'] * 100, 2);
                } else {
                    $statData[$pid]['wRate'] = 0;
                }
                // 모바일 구매율 계산
                if (($statData[$pid]['mOrder'] ?? 0) > 0 && ($statData[$pid]['mView'] ?? 0) > 0) {
                    $statData[$pid]['mRate'] = round($statData[$pid]['mOrder'] / $statData[$pid]['mView'] * 100, 2);
                } else {
                    $statData[$pid]['mRate'] = 0;
                }
                // 전체 구매율 계산
                if (($statData[$pid]['tOrder'] ?? 0) > 0 && ($statData[$pid]['tView'] ?? 0) > 0) {
                    $statData[$pid]['tRate'] = round($statData[$pid]['tOrder'] / $statData[$pid]['tView'] * 100, 2);
                } else {
                    $statData[$pid]['tRate'] = 0;
                }
            }
        }

        return $statData;
    }

    /**
     * 구매패턴분석 연령별 성별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getAgeAndSexOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('od.pid', $pid);
        }

        $rows = $this->orderWhere('od')
            ->select('sl.age')
            ->select('sl.sex')
            ->select('COUNT(*) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_LOG.' sl', 'od.hash_idx = sl.hash_idx', 'left')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('sl.age')
            ->groupBy('sl.sex')
            ->exec()
            ->getResultArray();

        $stat = [];
        for ($age = 0; $age <= 7; $age++) {
            if ($age == 6) {
                $age_label = '60대 이상';
            } elseif ($age == 7) {
                $age_label = '연령 알수없음';
            } else {
                $age_label = (($age + 1) * 10).'대';
            }

            $stat[$age] = ['label' => $age_label, 'M' => 0, 'W' => 0, 'N' => 0];
        }

        foreach ($rows as $row) {
            if ($row['age'] == '' || $row['age'] < 0) {
                $age_label = 7;
            } else {
                $age       = (int) ($row['age'] / 10 - 1);
                $age_label = ($age < 0 ? 0 : ($age > 5 ? 6 : $age));
            }

            if (array_key_exists($row['sex'], $stat[$age_label])) {
                $stat[$age_label][$row['sex']] += $row['cnt'];
            } else {
                $stat[$age_label]['N'] += $row['cnt'];
            }
        }

        return $stat;
    }

    /**
     * 구매패턴분석 성별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getSexOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('od.pid', $pid);
        }

        $rows = $this->orderWhere('od')
            ->select('sl.sex')
            ->select('COUNT(*) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_LOG.' sl', 'od.hash_idx = sl.hash_idx', 'left')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('sl.sex')
            ->exec()
            ->getResultArray();

        $stat = ['M' => 0, 'W' => 0, 'N' => 0];

        foreach ($rows as $row) {
            if (array_key_exists($row['sex'], $stat)) {
                $stat[$row['sex']] += $row['cnt'];
            } else {
                $stat['N'] += $row['cnt'];
            }
        }

        return $stat;
    }

    /**
     * 구매패턴분석 연령별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getAgeOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('od.pid', $pid);
        }

        $rows = $this->orderWhere('od')
            ->select('sl.age')
            ->select('COUNT(*) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_LOG.' sl', 'od.hash_idx = sl.hash_idx', 'left')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('sl.age')
            ->exec()
            ->getResultArray();

        $stat = [];
        for ($age = 0; $age <= 7; $age++) {
            if ($age == 6) {
                $age_label = '60대 이상';
            } elseif ($age == 7) {
                $age_label = '연령 알수없음';
            } else {
                $age_label = (($age + 1) * 10).'대';
            }

            $stat[$age] = ['label' => $age_label, 'cnt' => 0];
        }

        foreach ($rows as $row) {
            if ($row['age'] == '' || $row['age'] < 0) {
                $age_label = 7;
            } else {
                $age       = (int) ($row['age'] / 10 - 1);
                $age_label = ($age < 0 ? 0 : ($age > 5 ? 6 : $age));
            }
            $stat[$age_label]['cnt'] += $row['cnt'];
        }

        return $stat;
    }

    /**
     * 구매패턴분석 요일별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getWeekOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('pid', $pid);
        }

        $rows = $this->orderWhere()
            ->select('dayofweek(regdate) AS week', false)
            ->select('COUNT(oid) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL)
            ->betweenDate('regdate', $this->sDate, $this->eDate)
            ->groupBy('week')
            ->exec()
            ->getResultArray();

        $week_row   = array_column($rows, 'cnt', 'week');
        $week_label = [2 => '월', 3 => '화', 4 => '수', 5 => '목', 6 => '금', 7 => '토', 1 => '일'];

        $week_data = [];
        foreach ($week_label as $k => $w) {
            if (isset($week_row[$k])) {
                $week_data[$w] = $week_row[$k];
            } else {
                $week_data[$w] = 0;
            }
        }

        return $week_data;
    }

    /**
     * 구매패턴분석 시간대별 통계 (Tok)
     * @param int $pid
     * @return array
     */
    public function getHourOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('pid', $pid);
        }

        $rows = $this->orderWhere()
            ->select("DATE_FORMAT(regdate, '%H') AS hour", false)
            ->select('COUNT(oid) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL)
            ->betweenDate('regdate', $this->sDate, $this->eDate)
            ->groupBy('hour')
            ->exec()
            ->getResultArray();

        $hour_row  = array_column($rows, 'cnt', 'hour');
        $hour_data = [];
        for ($i = 0; $i < 24; $i++) {
            $hour_label = sprintf('%02d', $i);

            if (isset($hour_row[$hour_label])) {
                $hour_data[$hour_label] = $hour_row[$hour_label];
            } else {
                $hour_data[$hour_label] = 0;
            }
        }

        return $hour_data;
    }

    /**
     * 구매패턴분석 결제수단별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getPaymentOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('od.pid', $pid);
        }

        $rows = $this->orderWhere('od')
            ->select('p.method')
            ->select('COUNT(p.oid) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_PAYMENT.' p', 'od.oid = p.oid')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->where('p.pay_status', 'IC')
            ->where('p.pay_type', 'G')
            ->groupBy('p.method')
            ->exec()
            ->getResultArray();

        $pay_rows = array_column($rows, 'cnt', 'method');

        $pay_data = [];
        foreach ($pay_rows as $key => $val) {
            $pay_label = ForbizConfig::getPaymentMethod($key);
            if ($pay_label) {
                $pay_data[$pay_label] = $val;
            }
        }

        return $pay_data;
    }

    /**
     * 구매패턴분석 디바이스별 통계(Tok)
     * @param int $pid
     * @return array
     */
    public function getDeviceOrderStat($pid)
    {
        if ($pid != 'all') {
            $this->sQb()->where('od.pid', $pid);
        }

        $rows = $this->orderWhere('od')
            ->select('o.payment_agent_type')
            ->select('COUNT(o.oid) AS cnt', false)
            ->from(STAT_TBL_ORDER.' o')
            ->join(STAT_TBL_ORDER_DETAIL.' od', 'o.oid=od.oid')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate)
            ->groupBy('o.payment_agent_type')
            ->exec()
            ->getResultArray();

        $device_data = [
            'M' => ($device_data['M'] ?? 0),
            'W' => ($device_data['W'] ?? 0)
        ];

        if (!empty($rows)) {
            $device_data = array_column($rows, 'cnt', 'payment_agent_type');
            $total       = $device_data['M'] + $device_data['W'];
            // 모바일 디바이스 계산
            if ($device_data['M'] > 0) {
                $device_data['M'] = round(($device_data['M'] / $total * 100), 2);
            }
            // 웹 디바이스 계산
            if ($device_data['W'] > 0) {
                $device_data['W'] = round(($device_data['W'] / $total * 100), 2);
            }
        }

        return $device_data;
    }

    /**
     * 오늘주문 분석(Tok)
     * @return array
     */
    public function getTodayTotal()
    {
        $today = date('Y-m-d');

        // 총 접속 카운트
        $rows = $this->sQb()
            ->select('wtype')
            ->select('COUNT(*) AS cnt', false)
            ->from(STAT_TBL_LOG)
            ->where('ldate', $today)
            ->groupBy('wtype')
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            $view_rows      = array_column($rows, 'cnt', 'wtype');
            $view_rows['M'] = $view_rows['M'] ?? 0;
            $view_rows['W'] = $view_rows['W'] ?? 0;
        } else {
            $view_rows = [
                'M' => 0
                , 'W' => 0
            ];
        }

        // 총 주문 카운트
        $rows = $this->orderWhere('od')
            ->select('o.payment_agent_type')
            ->select('COUNT(o.oid) AS cnt', false)
            ->from(STAT_TBL_ORDER.' o')
            ->join(STAT_TBL_ORDER_DETAIL.' od', 'o.oid=od.oid')
            ->betweenDate('od.regdate', $today, $today)
            ->groupBy('o.payment_agent_type')
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            $order_rows      = array_column($rows, 'cnt', 'payment_agent_type');
            $order_rows['M'] = $order_rows['M'] ?? 0;
            $order_rows['W'] = $order_rows['W'] ?? 0;
        } else {
            $order_rows['M'] = 0;
            $order_rows['W'] = 0;
        }

        // 시간대별 접속 카운트
        $rows = $this->sQb()
            ->select('hour')
            ->select('COUNT(*) AS cnt', false)
            ->from(STAT_TBL_LOG)
            ->where('ldate', $today)
            ->groupBy('hour')
            ->exec()
            ->getResultArray();

        $hour_view = [];
        if (!empty($rows)) {
            $hrow = array_column($rows, 'cnt', 'hour');
        }

        for ($i = 0; $i <= 23; $i++) {
            $hour             = sprintf('%02d', $i);
            $hour_view[$hour] = $hrow[$hour] ?? 0;
        }

        // 시간대별 주문 카운트
        $rows = $this->orderWhere('od')
            ->select('HOUR(od.regdate) AS hour', false)
            ->select('COUNT(o.oid) AS cnt', false)
            ->from(STAT_TBL_ORDER.' o')
            ->join(STAT_TBL_ORDER_DETAIL.' od', 'o.oid=od.oid')
            ->betweenDate('od.regdate', $today, $today)
            ->groupBy('hour')
            ->exec()
            ->getResultArray();

        $hour_order = [];
        if (!empty($rows)) {
            $hrow = array_column($rows, 'cnt', 'hour');
        }

        for ($i = 0; $i <= 23; $i++) {
            $hour              = sprintf('%02d', $i);
            $hour_order[$hour] = $hrow[$hour] ?? 0;
        }

        // 오늘주문 분석 데이타
        $today_data = [];

        // 상품 조회수(오늘)
        $today_data['view'] = [
            'type' => 'view'
            , 'all' => $view_rows['M'] + $view_rows['W']
            , 'pc' => $view_rows['W']
            , 'mobile' => $view_rows['M']
        ];

        // 상품 주문수(오늘)
        $today_data['order'] = [
            'type' => 'order'
            , 'all' => $order_rows['M'] + $order_rows['W']
            , 'pc' => $order_rows['W']
            , 'mobile' => $order_rows['M']
        ];

        // 상품 주문 전환율(오늘)
        $today_data['conversionRate'] = [
            'type' => 'conversionRate'
            , 'all' => 0
            , 'pc' => 0
            , 'mobile' => 0
        ];

        if ($today_data['order']['all'] > 0 && $today_data['view']['all'] > 0) {
            $today_data['conversionRate']['all'] = round(($today_data['order']['all'] / $today_data['view']['all'] * 100), 2);
        }

        if ($today_data['order']['pc'] > 0 && $today_data['view']['pc'] > 0) {
            $today_data['conversionRate']['pc'] = round(($today_data['order']['pc'] / $today_data['view']['pc'] * 100), 2);
        }

        if ($today_data['order']['mobile'] > 0 && $today_data['view']['mobile'] > 0) {
            $today_data['conversionRate']['mobile'] = round(($today_data['order']['mobile'] / $today_data['view']['mobile'] * 100), 2);
        }

        // 시간대별 오늘주문/조회 분석
        foreach ($hour_view as $h => $cnt) {
            $today_data['time'][] = [
                'time' => $h
                , 'view' => $cnt
                , 'order' => $hour_order[$h]
            ];
        }

        // 오늘 구매율이 높은 상품 20개
        $today_data['product'] = $this->getPurchaseRateTop(20);

        return $today_data;
    }

    /**
     * 오늘 주문 Top20 상품(Tok)
     * @return array
     */
    public function getPurchaseRateTop($size = 20)
    {
        $today = date('Y-m-d');

        $rows = $this->orderWhere()
            ->select('pid')
            ->select('pname')
            ->select('listprice AS dcprice', false)
            ->select('COUNT(*) AS orderCnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->betweenDate('regdate', $today, $today)
            ->groupBy('pid')
            ->groupBy('pname')
            ->groupBy('dcprice')
            ->orderBy('orderCnt', 'desc')
            ->limit($size)
            ->exec()
            ->getResultArray();

        return $this->checkRate($rows, $today);
    }

    protected function checkRate($rows, $sDate, $eDate = false)
    {
        if (!empty($rows)) {
            if ($eDate === false) {
                $this->sQb()->where('ldate', $today);
            } else {
                $this->sQb()->betweenDate('ldate', $sDate, $eDate);
            }

            $vRows = $this->sQb()
                ->select('pid')
                ->select('COUNT(*) cnt', false)
                ->from(STAT_TBL_LOG)
                ->whereIn('pid', array_column($rows, 'pid'))
                ->groupBy('pid')
                ->exec()
                ->getResultArray();

            if (!empty($vRows)) {
                $viewRows = array_column($vRows, 'cnt', 'pid');
            } else {
                $viewRows = [];
            }

            //
            foreach ($rows as $key => $row) {
                $rows[$key]['rank']    = $key + 1;
                $rows[$key]['viewCnt'] = ($viewRows[$row['pid']] ?? 0);
                if (($viewRows[$row['pid']] ?? 0) > 0 && ($row['orderCnt'] ?? 0) > 0) {
                    $rows[$key]['cnv_rt'] = round(($row['orderCnt'] / $viewRows[$row['pid']] * 100), 2);
                } else {
                    $rows[$key]['cnv_rt'] = 0;
                }
                //$rows[$key]['thumb'] = get_product_images_src($row['pid'], true, 's');
                $rows[$key]['thumb'] = get_product_images_src_new($row['pid'], true, 'slist', '', 0);
            }
        }

        return $rows;
    }

    /**
     * 주문 옵션(Tok)
     * @param string $cid
     * @return array
     */
    public function getOptionPatton()
    {
        if ($this->cid) {
            $this->sQb()
                ->where('pid in ('.$this->sQb()->startSubQuery()
                    ->select('pid')
                    ->from(STAT_TBL_CATEGORY)
                    ->like('cid', rtrim($this->cid, '0'), 'after')
                    ->where('disp', 1)
                    ->endSubQuery().')', '', false);

            $this->cid = '';
        }

        $rows = $this->orderWhere()
            ->select('option_text')
            ->select('COUNT(oid) AS cnt', false)
            ->from(STAT_TBL_ORDER_DETAIL)
            ->where('option_text !=', '')
            ->betweenDate('regdate', $this->sDate, $this->eDate)
            ->groupBy('option_text')
            ->exec()
            ->getResultArray();


        $optStat = ['optName' => [], 'stat' => []];

        if (!empty($rows)) {
            $optData = [];
            $optName = [];
            foreach ($rows as $opt) {
                $sOpt = explode(':', $opt['option_text']);
                if (count($sOpt) > 1) {
                    $optKey             = 'K'.md5($sOpt[0]);
                    $optData[$optKey][] = ['option' => $sOpt[1], 'cnt' => $opt['cnt']];
                    if (!isset($optName[$optKey])) {
                        $optName[$optKey] = ['name' => $sOpt[0], 'idx' => $optKey];
                    }
                }
            }

            $optStat['optName'] = array_values($optName);
            $optStat['stat']    = $optData;
        }

        return $optStat;
    }

    /**
     * 카테고리 정보
     * @param string $cid
     * @return array
     */
    public function getCategory($cid = '')
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        if ($cid) {
            return $productModel->getCategorySubList($cid);
        } else {
            return $productModel->getLargeCategoryList();
        }
    }

    /**
     * 기간별 구매패턴 분석(종합)
     * @param type $pType
     */
    public function getPurchasePattern($pType)
    {
        switch ($pType) {
            case 'age':
                return $this->getAgeOrderStat('all');
                break;
            case 'sex':
                return $this->getSexOrderStat('all');
                break;
            case 'ageAndSex':
                return $this->getAgeAndSexOrderStat('all');
                break;
            case 'week':
                return $this->getWeekOrderStat('all');
                break;
            case 'hour':
                return $this->getHourOrderStat('all');
                break;
            case 'payment':
                return $this->getPaymentOrderStat('all');
                break;
            case 'device':
                return $this->getDeviceOrderStat('all');
                break;
            case 'option':
                return $this->getOptionPatton();
                break;
        }

        return [];
    }

    public function getExcelData($pIds)
    {
        $now = date('Y-m-d H:i:s');

        if ($pIds === 'all') {
            $pRows = $this->sQb()
                ->select('id')
                ->from(STAT_TBL_PRODUCT)
                ->whereIn('mall_ix', ['', MALL_IX])
                ->whereIn('state', [1, 0])
                ->where('is_delete', 0)
                ->where('disp', 1)
                ->where('product_type !=', 77)
                ->where("IF(is_sell_date = '1',sell_priod_sdate <= '{$now}' AND sell_priod_edate >= '{$now}','1=1')", '', false)
                ->exec()
                ->getResultArray();

            if (!empty($pRows)) {
                $pIds = array_column($pRows, 'id');
            } else {
                $pIds = ['all'];
            }
        }

        if (!empty($pIds)) {
            set_time_limit(0);
            $excel = $this->getViewAndOrderList($pIds);
        } else {
            $excel = [];
        }

        return $excel;
    }

    public function getPurchaseTargetGoods($sex = false, $age = false, $size = 5)
    {
        $this->orderWhere('od')
            ->select('od.pid')
            ->select('od.pname')
            ->select('od.listprice AS dcprice', false)
            ->select('COUNT(*) AS orderCnt', false)
            ->from(STAT_TBL_ORDER_DETAIL.' od')
            ->join(STAT_TBL_LOG.' sl', 'od.hash_idx = sl.hash_idx', 'left')
            ->betweenDate('od.regdate', $this->sDate, $this->eDate);

        if ($sex && $sex != 'A') {
            $sex = ($sex == 'W' ? 'W' : ($sex == 'M' ? 'M' : 'N'));
            $this->sQb()->where('sl.sex', $sex);
        }

        if ($age && $age != 'A') {
            switch (intval($age)) {
                case 0:
                    $sAge = 1;
                    $eAge = 10;
                    break;
                case 1:
                    $sAge = 11;
                    $eAge = 20;
                    break;
                case 2:
                    $sAge = 21;
                    $eAge = 30;
                    break;
                case 3:
                    $sAge = 31;
                    $eAge = 40;
                    break;
                case 4:
                    $sAge = 41;
                    $eAge = 50;
                    break;
                case 5:
                    $sAge = 51;
                    $eAge = 60;
                    break;
            }

            if ($age == 6) {
                $this->sQb()->where("sl.age BETWEEN 61 AND 100", null, false);
            } elseif ($age == 7) {
                $this->sQb()->where("sl.age < 1 AND sl.age > 100 OR sl.age IS NULL", null, false);
            } else {
                $this->sQb()->where("sl.age BETWEEN {$sAge} AND {$eAge}", null, false);
            }
        }

        $rows = $this->sQb()
            ->groupBy('pid')
            ->groupBy('pname')
            ->groupBy('dcprice')
            ->orderBy('orderCnt', 'desc')
            ->limit($size)
            ->exec()
            ->getResultArray();

        return $this->checkRate($rows, $this->sDate, $this->eDate);
    }
}