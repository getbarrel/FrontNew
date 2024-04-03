<?php

/**
 * 설정 데이타 클래스
 *
 * @author hoksi
 */
class ForbizCoreConfig
{

    /**
     * 회사 정보
     * @staticvar array $data
     * @param string $key
     * @return string or array
     */
    public static function getCompanyInfo($key = false)
    {
        static $data = [];

        if (defined('MALL_DATA_PATH')) {
            $configFilePath = realpath(MALL_DATA_PATH.'/_config/company.php');

            if (empty($data) && file_exists($configFilePath)) {
                $data = require($configFilePath);
            }
        }

        if ($key) {
            return $data[$key] ?? false;
        } else {
            return $data;
        }
    }

    public static function getAssign($key = false)
    {
        static $data = [];

        if (defined('FORBIZ_MALL_VERSION')) {
            if (empty($data) && file_exists(CUSTOM_ROOT.'/config/assign.php')) {
                $data = require(CUSTOM_ROOT.'/config/assign.php');

                // layoutCommon
                $data['layoutCommon']['templetSrc'] = $data['layoutCommon']['templetSrc'] ?? TPL_ROOT;
                $data['layoutCommon']['productSrc'] = $data['layoutCommon']['productSrc'] ?? (DATA_ROOT."/images/product");
                $data['layoutCommon']['imagesSrc']  = $data['layoutCommon']['imagesSrc'] ?? (DATA_ROOT."/images/images");
                $data['layoutCommon']['dataRoot']   = $data['layoutCommon']['dataRoot'] ?? DATA_ROOT;

                $pathList = explode("/", getForbiz()->router->routeUri);
                if (isset($pathList[1])) {
                    list($Group, $Page) = $pathList;
                } else if (isset($pathList[0]) && $pathList[0]) {
                    $Group = $pathList[0];
                    $Page  = 'index';
                } else {
                    // main index
                    $Group = 'main';
                    $Page  = 'index';
                }

                // layout
                $data['layout']['GroupCssSrc']   = $data['layout']['GroupCssSrc'] ?? (TPL_ROOT.'/css/'.$Group.'.css');
                $data['layout']['GroupJsSrc']    = $data['layout']['GroupJsSrc'] ?? (TPL_ROOT.'/js/'.$Group.'/common_'.$Group.'.js');
                $data['layout']['PageJsSrc']     = $data['layout']['PageJsSrc'] ?? (TPL_ROOT.'/js/'.$Group.'/'.$Page.'.js');
                $data['layout']['LanguageJsSrc'] = $data['layout']['LanguageJsSrc'] ?? (DATA_ROOT.'/_language/'.LANGUAGE.'.js');

                // 업체 정보
                $data['companyInfo'] = self::getCompanyInfo();
            }
        }

        if ($key) {
            return [$key => ($data[$key] ?? '')];
        } else {
            return $data;
        }
    }

    public static function getConfig($key)
    {
        static $data = [];

        if (defined('FORBIZ_MALL_VERSION')) {
            if (!isset($data[$key]) && file_exists(CUSTOM_ROOT."/config/{$key}.php")) {
                $data[$key] = require(CUSTOM_ROOT."/config/{$key}.php");
            }
        }

        return $data[$key] ?? false;
    }

    public static function getPrivacyConfig($key)
    {
        static $data = null;

        if ($data === null) {
            $row = getForbiz()->qb
                ->select('config_name')
                ->select('config_value')
                ->from(TBL_SHOP_MALL_PRIVACY_SETTING)
                ->where('mall_ix', MALL_IX)
                ->exec()
                ->getResultArray();

            $data = [];
            foreach ($row as $item) {
                switch ($item['config_name']) {
                    case 'pw_combi':
                    case 'pw_continuous_check':
                    case 'pw_same_check':
                        $data[$item['config_name']] = json_decode($item['config_value'], true);
                        break;
                    default:
                        $data[$item['config_name']] = $item['config_value'];
                        break;
                }
            }
        }

        return $data[$key] ?? '';
    }

    public static function getShopInfo($key)
    {
        static $data = [];
        if (!isset($data[$key])) {
            $data = getForbiz()->qb
                ->from(TBL_SHOP_SHOPINFO)
                ->where('mall_ix', MALL_IX)
                ->limit(1)
                ->exec()
                ->getRowArray();
        }

        return $data[$key] ?? '';
    }

    public static function getMallConfig($key)
    {
        static $data = [];

        if (!isset($data[$key])) {
            $row = getForbiz()->qb
                ->select('config_value')
                ->from(TBL_SHOP_MALL_CONFIG)
                ->where('mall_ix', MALL_IX)
                ->where('config_name', $key)
                ->limit(1)
                ->exec()
                ->getRow();

            $data[$key] = $row->config_value ?? '';
        }

        return $data[$key] ?? '';
    }

    public static function getAdminImage($upload_type, $sub_type, $select = 'url')
    {
        return $row = getForbiz()->qb
            ->select($select)
            ->from(TBL_SYSTEM_UPLOAD_FILE)
            ->where('upload_type', $upload_type)
            ->where('sub_type', $sub_type)
            ->orderBy('system_upload_file_id', 'DESC')
            ->limit(1)
            ->exec()
            ->getRowArray();
    }

    public static function getPaymentConfig($key, $pg)
    {
        static $data = [];

        if (!isset($data[$key])) {
            $row = getForbiz()->qb
                ->select('config_value')
                ->from(TBL_SHOP_PAYMENT_CONFIG)
                ->where('mall_ix', MALL_IX)
                ->where('pg_code', $pg)
                ->where('config_name', $key)
                ->limit(1)
                ->exec()
                ->getRow();

            $data[$key] = $row->config_value ?? '';
        }

        return $data[$key];
    }

    public static function getSharedMemory($name, $subName = false)
    {
        static $result = [];

        if ($subName === false) {
            $subName = $name;
        }

        $sharedId = sprintf('%s_%s', $name, $subName);

        if (isset($result[$sharedId]) === false) {
            $cacheSharedPath = CUSTOM_ROOT.'/_cache/_shared/';

            /*if (defined('USE_SHARED_CACHE') && USE_SHARED_CACHE === true && file_exists($cacheSharedPath.'/'.$name)) {
                $sharedPath = $cacheSharedPath;
            } else {*/
                $sharedPath = MALL_DATA_PATH.'/_shared/';
            //}

            $shmop            = new \Shared($name);
            $shmop->filepath  = $sharedPath;
            $shmop->SetFilePath();
            $data             = $shmop->getObjectForKey($subName);
            $result[$sharedId] = unserialize(urldecode($data));
        }

        return $result[$sharedId];
    }

    public static function setSharedMemory($name, $obj, $subName = false)
    {
        if ($subName === false) {
            $subName = $name;
        }
        $shmop           = new \Shared($name);
        $shmop->filepath = MALL_DATA_PATH."/_shared/";
        $shmop->SetFilePath();

        return $shmop->setObjectForKey($obj, $subName);
    }

    public static function getChangePasswordSession()
    {
        return sess_val('user', 'changeAccessPassword');
    }

    public static function findKey($data, $key, $sort = false)
    {
        if ($key !== false) {
            foreach ($data as $k => $v) {
                if ($k == $key) {
                    return $v;
                } elseif ($v == $key) {
                    return $k;
                }
            }

            return '';
        }

        if ($sort) {
            asort($data);
        }

        return $data;
    }

    public static function getParser()
    {
        getForbiz()->load->library('parser');

        return getForbiz()->parser;
    }

    public static function getSmsTpl($key)
    {
        static $data = [];

        if (!isset($data[$key])) {
            $row = getForbiz()->qb
                ->select('mc_sms_text')
                ->select('kakao_alim_talk_template_code as kakao_code')
                ->select('mc_sms_usersend_yn as send_yn')
                ->from(TBL_SHOP_MAILSEND_CONFIG)
                ->where('mc_code', $key)
                ->limit(1)
                ->exec()
                ->getRowArray();

            if (isset($row['mc_sms_text'])) {
                $data[$key] = $row;
            } else {
                $data[$key] = [
                    'mc_sms_text' => ''
                    , 'kakao_code' => ''
                    , 'send_yn' => 'N'
                ];
            }
        }

        return $data[$key];
    }

    public static function getBankList($key = false)
    {
        $data = [
            "su" => "한국산업은행", "ku" => "기업은행", "km" => "국민은행", "yh" => "외환은행",
            "ss" => "수협중앙회", "nh" => "농협중앙회", "nh2" => "단위농협", "ch" => "축협중앙회",
            "wr" => "우리은행", "sh" => "신한은행", "jh" => "신한은행(조흥은행)", "shjh" => "신한은행(조흥통합)",
            "sc" => "SC제일은행", "hn" => "하나은행", "hn2" => "하나은행(서울은행)", "hc" => "한국씨티은행(한미은행)",
            "dk" => "대구은행", "bs" => "부산은행", "kj" => "광주은행", "jj" => "제주은행",
            "jb" => "전북은행", "gw" => "강원은행", "kn" => "경남은행", "bc" => "비씨카드",
            "ct" => "씨티은행", "hks" => "홍콩상하이은행", "po" => "우체국", "ph" => "평화은행",
            "ssg" => "신세계", "sl" => "산림조합", "sk" => "새마을금고", "sn" => "신협은행",
            "sj" => "상호저축은행", "hsbc" => "HSBC"
        ];

        return self::findKey($data, $key, true);
    }

    public static function getOrderStatus($key = false)
    {
        $data = [
            //입금
            ORDER_STATUS_SETTLE_READY => '결제중',
            ORDER_STATUS_REPAY_READY => '재결제대기중',
            ORDER_STATUS_INCOM_READY => '입금예정',
            ORDER_STATUS_INCOM_COMPLETE => '입금확인',
            ORDER_STATUS_DEFERRED_PAYMENT => '후불(외상)',
            ORDER_STATUS_LOSS => '손실',
            //취소
            ORDER_STATUS_CANCEL_APPLY => '취소요청',
            ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE => '입금전취소완료',
            ORDER_STATUS_CANCEL_COMPLETE => '취소완료',
            ORDER_STATUS_CANCEL_DENY => '취소거부',
            ORDER_STATUS_CANCEL_ING => '취소처리중',
            //환불
            ORDER_STATUS_REFUND_READY => '환불대기',
            ORDER_STATUS_REFUND_APPLY => '환불요청',
            ORDER_STATUS_REFUND_COMPLETE => '환불완료',
            //출고
            ORDER_STATUS_WAREHOUSING_STANDYBY => '입고대기',
            ORDER_STATUS_WAREHOUSE_DELIVERY_APPLY => '출고요청',
            ORDER_STATUS_WAREHOUSE_DELIVERY_CONFIRM => '출고요청확정',
            ORDER_STATUS_WAREHOUSE_DELIVERY_PICKING => '포장대기',
            ORDER_STATUS_WAREHOUSE_DELIVERY_READY => '출고대기',
            ORDER_STATUS_WAREHOUSE_DELIVERY_COMPLETE => '출고완료',
            //배송
            ORDER_STATUS_DELIVERY_READY => '배송준비중',
            ORDER_STATUS_DELIVERY_DELAY => '배송지연',
            ORDER_STATUS_DELIVERY_ING => '배송중',
            ORDER_STATUS_DELIVERY_COMPLETE => '배송완료',
            ORDER_STATUS_BUY_FINALIZED => '구매확정',
            ORDER_UNRECEIVED_CLAIM => '미수령 신고 접수',
            ORDER_UNRECEIVED_CLAIM_COMPLETE => '미수령 신고 철회',
            //교환
            ORDER_STATUS_EXCHANGE_APPLY => '교환요청',
            ORDER_STATUS_EXCHANGE_DENY => '교환거부',
            ORDER_STATUS_EXCHANGE_ING => '교환승인',
            ORDER_STATUS_EXCHANGE_READY => '교환예정',
            ORDER_STATUS_EXCHANGE_DELIVERY => '교환상품배송중',
            ORDER_STATUS_EXCHANGE_ACCEPT => '교환회수완료',
            ORDER_STATUS_EXCHANGE_DEFER => '교환보류',
            ORDER_STATUS_EXCHANGE_IMPOSSIBLE => '교환불가',
            ORDER_STATUS_EXCHANGE_COMPLETE => '교환반품확정',
            ORDER_STATUS_EXCHANGE_CANCEL => '교환신청취소',
            ORDER_STATUS_EXCHANGE_AGAIN_DELIVERY => '교환재배송중',
            //반품
            ORDER_STATUS_RETURN_APPLY => '반품요청',
            ORDER_STATUS_RETURN_ING => '반품승인',
            ORDER_STATUS_RETURN_DELIVERY => '반품상품배송중',
            ORDER_STATUS_RETURN_COMPLETE => '반품확정',
            ORDER_STATUS_RETURN_ACCEPT => '반품회수완료',
            ORDER_STATUS_RETURN_CANCEL => '반품취소',
            ORDER_STATUS_RETURN_DEFER => '반품보류',
            ORDER_STATUS_RETURN_DENY => '반품거부',
            ORDER_STATUS_RETURN_DENY_DEFER => '반품완료보류',
            ORDER_STATUS_RETURN_IMPOSSIBLE => '반품불가',
            //정산
            ORDER_STATUS_ACCOUNT_APPLY => '정산요청',
            ORDER_STATUS_ACCOUNT_READY => '정산대기',
            ORDER_STATUS_ACCOUNT_COMPLETE => '정산완료',
            ORDER_STATUS_ACCOUNT_PAYMENT => '정산지급완료',
            //해외배송
            ORDER_STATUS_OVERSEA_WAREHOUSE_DELIVERY_READY => '해외프로세싱중',
            ORDER_STATUS_OVERSEA_WAREHOUSE_DELIVERY_ING => '해외창고배송중',
            ORDER_STATUS_AIR_TRANSPORT_READY => '항공배송준비중',
            ORDER_STATUS_AIR_TRANSPORT_ING => '항공배송중',
        ];

        return self::findKey($data, $key);
    }

    public static function getPaymentMethod($key = false)
    {
        $data = [
            ORDER_METHOD_BANK => '무통장',
            ORDER_METHOD_CARD => '카드',
            ORDER_METHOD_PHONE => '휴대폰결제',
            ORDER_METHOD_AFTER => '사용안함',
            ORDER_METHOD_VBANK => '가상계좌',
            ORDER_METHOD_ICHE => '실시간계좌이체',
            ORDER_METHOD_MOBILE => '모바일결제',
            ORDER_METHOD_NOPAY => '무료결제',
            ORDER_METHOD_ASCROW => '에스크로',
            ORDER_METHOD_CASH => '현금',
            ORDER_METHOD_BOX_ENCLOSE => '박스동봉',
            ORDER_METHOD_SAVEPRICE => '예치금',
            ORDER_METHOD_RESERVE => '적립금',
            ORDER_METHOD_CART_COUPON => '장바구니쿠폰',
            ORDER_METHOD_DELIVERY_COUPON => '배송비쿠폰',
            ORDER_METHOD_PAYCO => '페이코',
            ORDER_METHOD_PAYPAL => '페이팔',
            ORDER_METHOD_KAKAOPAY => '카카오페이',
            ORDER_METHOD_NPAY => '네이버페이',
            ORDER_METHOD_EXIMBAY => 'EXIMBAY',
            ORDER_METHOD_TOSS => '토스',
            ORDER_METHOD_ERROR => '미정의타입'
        ];

        return self::findKey($data, $key);
    }

    public static function getDiscount($key = false)
    {
        $data = [
            'IN' => '즉시할인'
            , 'MG' => '회원할인'
            , 'GP' => '기획할인'
            , 'SP' => '특별할인'
            , 'M' => '모바일할인'
            , 'APP' => '앱할인'
            , 'CP' => '쿠폰할인'
        ];

        return self::findKey($data, $key);
    }

    public static function getOrderSelectStatus($type, $fkey, $skey, $code = false, $key = false)
    {
        $data = [
            "F" => [
                ORDER_STATUS_INCOM_READY => [
                    //입금예정->취소요청(프론트)
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "N", "title" => "다른상품구매"],
                        "NB" => ["type" => "N", "title" => "구매의사없음"],
                        "PIE" => ["type" => "N", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "N", "title" => "기타(구매자책임)"]
                    ],
                    //입금예정->취소완료(프론트)
                    ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE => [
                        "DPB" => ["type" => "N", "title" => "다른상품구매"],
                        "NB" => ["type" => "N", "title" => "구매의사없음"],
                        "PIE" => ["type" => "N", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "N", "title" => "기타(구매자책임)"]
                    ]
                ],
                ORDER_STATUS_INCOM_COMPLETE => [
                    //입금완료->취소요청(프론트)
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ],
                    //입금완료->취소완료(프론트)
                    ORDER_STATUS_CANCEL_COMPLETE => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
                //발주확인->취소요청(프론트)
                ORDER_STATUS_DELIVERY_READY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
                //배송지연->취소신청(프론트)
                ORDER_STATUS_DELIVERY_DELAY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
                ORDER_STATUS_DELIVERY_COMPLETE => [
                    //배송완료->교환요청(프론트)
                    ORDER_STATUS_EXCHANGE_APPLY => [
                        "OCF" => ["type" => "B", "title" => "사이즈,색상잘못선택"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "DE" => ["type" => "S", "title" => "배송상품 오배송"],
                        "PNT" => ["type" => "S", "title" => "상품미도착"],
                        "PIE" => ["type" => "S", "title" => "상품정보 틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ],
                    //배송완료->반품요청(프론트)
                    ORDER_STATUS_RETURN_APPLY => [
                        "OCF" => ["type" => "B", "title" => "사이즈,색상잘못선택"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "DE" => ["type" => "S", "title" => "배송상품 오배송"],
                        "PNT" => ["type" => "S", "title" => "상품미도착"],
                        "PIE" => ["type" => "S", "title" => "상품정보 틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
            ],
            "A" => [
                //입금예정->취소요청(관리자)
                ORDER_STATUS_INCOM_READY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "N", "title" => "다른상품구매"],
                        "NB" => ["type" => "N", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "N", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "N", "title" => "상품정보틀림"],
                        "PSL" => ["type" => "S", "title" => "상품재고부족"],
                        "PSO" => ["type" => "S", "title" => "상품품절"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"],
                        "SYS" => ["type" => "N", "title" => "시스템자동취소"]
                    ]
                ],
                //입금완료->취소요청(관리자)
                ORDER_STATUS_INCOM_COMPLETE => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "PSL" => ["type" => "S", "title" => "상품재고부족"],
                        "PSO" => ["type" => "S", "title" => "상품품절"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"],
                        "SYS" => ["type" => "N", "title" => "시스템자동취소"]
                    ]
                ],
                //발주확인->취소요청(관리자)
                ORDER_STATUS_DELIVERY_READY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "PSL" => ["type" => "S", "title" => "상품재고부족"],
                        "PSO" => ["type" => "S", "title" => "상품품절"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"],
                    ]
                ],
                //취소요청->취소거부(관리자)
                ORDER_STATUS_CANCEL_APPLY => [
                    ORDER_STATUS_CANCEL_DENY => [
                        "MCC" => ["type" => "N", "title" => "주문제작 취소불가"],
                        "NCP" => ["type" => "N", "title" => "취소불가상품(상품페이지참조)"],
                        "DR" => ["type" => "N", "title" => "포장완료/배송대기"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //배송지연(관리자)
                ORDER_STATUS_DELIVERY_DELAY => [
                    //배송지연
                    ORDER_STATUS_DELIVERY_DELAY => [
                        "STS" => ["type" => "N", "title" => "단기재고부족"],
                        "OG" => ["type" => "N", "title" => "주문폭주로인한 작업지연"],
                        "OMI" => ["type" => "N", "title" => "주문제작 중"],
                        "BA" => ["type" => "N", "title" => "고객요청"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ],
                    //배송지연->취소요청(관리자)
                    ORDER_STATUS_CANCEL_APPLY => [
                        "DPB" => ["type" => "B", "title" => "다른상품구매"],
                        "NB" => ["type" => "B", "title" => "구매의사없음/변심"],
                        "DD" => ["type" => "S", "title" => "배송처리늦음/지연"],
                        "PIE" => ["type" => "S", "title" => "상품정보틀림"],
                        "PSL" => ["type" => "S", "title" => "상품재고부족"],
                        "PSO" => ["type" => "S", "title" => "상품품절"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
                //교환거부(관리자)
                ORDER_STATUS_EXCHANGE_DENY => [
                    ORDER_STATUS_EXCHANGE_DENY => [
                        "MPNE" => ["type" => "N", "title" => "주문제작상품으로 교환불가"],
                        "NEP" => ["type" => "N", "title" => "교환불가상품(상세페이지참조)"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //교환보류(관리자)
                ORDER_STATUS_EXCHANGE_DEFER => [
                    ORDER_STATUS_EXCHANGE_DEFER => [
                        "NRA" => ["type" => "N", "title" => "반품상품 미입고"],
                        "NRDP" => ["type" => "N", "title" => "반품배송비 미동봉"],
                        "RPD" => ["type" => "N", "title" => "반품상품 훼손/파손"],
                        "RPPD" => ["type" => "N", "title" => "반품상품포장 훼손/파손"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //교환불가(관리자)
                ORDER_STATUS_EXCHANGE_IMPOSSIBLE => [
                    ORDER_STATUS_EXCHANGE_IMPOSSIBLE => [
                        "RPD" => ["type" => "N", "title" => "반품상품 훼손/파손"],
                        "RPPD" => ["type" => "N", "title" => "반품상품포장 훼손/파손"],
                        "BNC" => ["type" => "N", "title" => "구매자 연락되지 않음"]
                    ]
                ],
                //배송완료(관리자)
                ORDER_STATUS_DELIVERY_COMPLETE => [
                    //반품요청
                    ORDER_STATUS_RETURN_APPLY => [
                        "OCF" => ["type" => "B", "title" => "사이즈,색상잘못선택"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "DE" => ["type" => "S", "title" => "배송상품 오배송"],
                        "PNT" => ["type" => "S", "title" => "상품미도착"],
                        "PIE" => ["type" => "S", "title" => "상품정보 틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ],
                    //교환요청
                    ORDER_STATUS_EXCHANGE_APPLY => [
                        "OCF" => ["type" => "B", "title" => "사이즈,색상잘못선택"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "DE" => ["type" => "S", "title" => "배송상품 오배송"],
                        "PNT" => ["type" => "S", "title" => "상품미도착"],
                        "PIE" => ["type" => "S", "title" => "상품정보 틀림"],
                        "ETCB" => ["type" => "B", "title" => "기타(구매자책임)"],
                        "ETCS" => ["type" => "S", "title" => "기타(판매자책임)"]
                    ]
                ],
                //반품거부(관리자)
                ORDER_STATUS_RETURN_DENY => [
                    ORDER_STATUS_RETURN_DENY => [
                        "MPNE" => ["type" => "N", "title" => "주문제작상품으로 교환불가"],
                        "NEP" => ["type" => "N", "title" => "교환불가상품(상세페이지참조)"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //반품보류(관리자)
                ORDER_STATUS_RETURN_DEFER => [
                    ORDER_STATUS_RETURN_DEFER => [
                        "NRA" => ["type" => "N", "title" => "반품상품 미입고"],
                        "NRDP" => ["type" => "N", "title" => "반품배송비 미동봉"],
                        "RPD" => ["type" => "N", "title" => "반품상품 훼손/파손"],
                        "RPPD" => ["type" => "N", "title" => "반품상품포장 훼손/파손"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //반품불가(관리자)
                ORDER_STATUS_RETURN_IMPOSSIBLE => [
                    ORDER_STATUS_RETURN_IMPOSSIBLE => [
                        "RPD" => ["type" => "N", "title" => "반품상품 훼손/파손"],
                        "RPPD" => ["type" => "N", "title" => "반품상품포장 훼손/파손"],
                        "BNC" => ["type" => "N", "title" => "구매자 연락되지 않음"]
                    ]
                ]
            ]
        ];

        if (isset($data[$type][$fkey][$skey])) {
            if ($code === false) {
                return $data[$type][$fkey][$skey];
            } elseif ($key === false) {
                return $data[$type][$fkey][$skey][$code] ?? [];
            } else {
                return $data[$type][$fkey][$skey][$code][$key] ?? '';
            }
        } else {
            return [];
        }
    }

    public static function getDeliveryCompanyInfo($code_ix = false, $key = false)
    {
        static $data = false;

        if ($data === false) {
            $rows = getForbiz()->qb
                ->select('code_ix')
                ->select('code_name')
                ->select('code_etc1')
                ->select('code_etc2')
                ->select('code_etc3')
                ->select('code_etc4')
                ->from(TBL_SHOP_CODE)
                ->where('code_gubun', '02')
                ->where('disp', 1)
                ->exec()
                ->getResultArray();

            foreach ($rows as $row) {
                $data[$row['code_ix']] = [
                    'name' => $row['code_name'],
                    'url' => $row['code_etc1'],
                    'method' => $row['code_etc3'],
                    'column' => $row['code_etc4'],
                    'etc' => $row['code_etc2']
                ];
            }
        }

        if ($key === false) {
            return $code_ix === false ? $data : ($data[$code_ix] ?? []);
        } else {
            return $data[$code_ix][$key] ?? '';
        }
    }
}