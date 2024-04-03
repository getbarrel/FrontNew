<?php

/**
 * 쇼핑몰 설정 데이타 클래스
 *
 * @author hoksi
 */
class ForbizConfig extends ForbizCoreConfig
{

    public static function getDiscount($key = false)
    {
        $data = [
            'IN' => '즉시할인'
            , 'MG' => '회원할인'
            , 'GP' => '특별할인'
            , 'SP' => '특별할인'
            , 'M' => '모바일할인'
            , 'APP' => '앱할인'
            , 'CP' => '쿠폰할인'
        ];

        return self::findKey($data, $key);
    }

    // 없음(적립금 사용)
    public static function getPaymentMethod($key = false)
    {
        $data = [
            ORDER_METHOD_BANK => '무통장', // 환불정보 필요
            ORDER_METHOD_CARD => '카드',
            ORDER_METHOD_PHONE => '휴대폰결제',
            ORDER_METHOD_AFTER => '사용안함',
            ORDER_METHOD_VBANK => '가상계좌', // 환불정보 필요
            ORDER_METHOD_ICHE => '실시간계좌이체',
            ORDER_METHOD_MOBILE => '모바일결제',
            ORDER_METHOD_NOPAY => '없음(적립금 사용)',
            ORDER_METHOD_ASCROW => '에스크로(가상계좌)', // 환불정보 필요
            ORDER_METHOD_CASH => '현금', // 환불정보 필요
            ORDER_METHOD_BOX_ENCLOSE => '박스동봉',
            ORDER_METHOD_SAVEPRICE => '예치금',
            ORDER_METHOD_RESERVE => '적립금',
            ORDER_METHOD_CART_COUPON => '장바구니쿠폰',
            ORDER_METHOD_DELIVERY_COUPON => '배송비쿠폰',
            ORDER_METHOD_PAYCO => '페이코',
            ORDER_METHOD_PAYPAL => '페이팔',
            ORDER_METHOD_KAKAOPAY => '카카오페이',
            ORDER_METHOD_NPAY => '네이버페이',
            ORDER_METHOD_EXIMBAY => 'Eximbay',
            ORDER_METHOD_TOSS => '토스',
            ORDER_METHOD_ERROR => '미정의타입',
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
                        "" => ["type" => "N", "title" => "취소사유 선택"],
                        "NB" => ["type" => "N", "title" => "구매의사취소(단순변심)"],
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ],
                    //입금예정->취소완료(프론트)
                    ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE => [
                        "" => ["type" => "N", "title" => "취소사유 선택"],
                        "NB" => ["type" => "N", "title" => "구매의사취소(단순변심)"],
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                ORDER_STATUS_INCOM_COMPLETE => [
                    //입금완료->취소요청(프론트)
                    ORDER_STATUS_CANCEL_APPLY => [
                        "" => ["type" => "N", "title" => "취소사유 선택"],
                        "NB" => ["type" => "N", "title" => "구매의사취소(단순변심)"],
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ],
                    //입금완료->취소완료(프론트)
                    ORDER_STATUS_CANCEL_COMPLETE => [
                        "" => ["type" => "N", "title" => "취소사유 선택"],
                        "NB" => ["type" => "B", "title" => "구매의사취소(단순변심)"], //  N => B로 변경
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "B", "title" => "기타"] //  N => B로 변경
                    ]
                ],
                //발주확인->취소요청(프론트)
                ORDER_STATUS_DELIVERY_READY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "NB" => ["type" => "B", "title" => "고객변심"],
                        "NB" => ["type" => "N", "title" => "구매의사취소(단순변심)"],
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                //배송지연->취소신청(프론트)
                ORDER_STATUS_DELIVERY_DELAY => [
                    ORDER_STATUS_CANCEL_APPLY => [
                        "NB" => ["type" => "B", "title" => "고객변심"],
                        "NB" => ["type" => "N", "title" => "구매의사취소(단순변심)"],
                        "DD" => ["type" => "N", "title" => "배송지연"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ]
                ],
                ORDER_STATUS_DELIVERY_COMPLETE => [
                    //배송완료->교환요청(프론트)
                    ORDER_STATUS_EXCHANGE_APPLY => [
                        "" => ["type" => "B", "title" => "교환사유 선택"],
                        "SCF" => ["type" => "B", "title" => "색상변경"],
                        "CCF" => ["type" => "B", "title" => "사이즈변경"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "DE" => ["type" => "S", "title" => "배송상품 오배송"],
                        "ETC" => ["type" => "N", "title" => "기타"]
                    ],
                    //배송완료->반품요청(프론트)
                    ORDER_STATUS_RETURN_APPLY => [
                        "" => ["type" => "B", "title" => "반품사유 선택"],
                        "NB" => ["type" => "B", "title" => "구매의사 취소(단순변심)"],
                        "PD" => ["type" => "S", "title" => "배송상품 파손/하자"],
                        "PNT" => ["type" => "S", "title" => "상품미도착"],
                        "PIE" => ["type" => "S", "title" => "상품정보상이"],
                        "ETC" => ["type" => "N", "title" => "기타"]
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
                //배송완료->교환요청(관리자)
                ORDER_STATUS_DELIVERY_COMPLETE => [
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
                //배송완료->반품요청(관리자)
                ORDER_STATUS_DELIVERY_COMPLETE => [
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

    public static function getProductTopKind($find = false, $returnType = 'value')
    {
        $data = [
            'productType' => '000000000000000'
            , 'skinSolution' => '001000000000000'
            , 'productLine' => '002000000000000'
        ];

        if ($find) {
            if ($returnType == 'value') {
                return $data[$find] ?? '';
            } else {
                return array_search($find, $data);
            }
        } else {
            return $data;
        }
    }

    public static function getNavInfo($cid = false, $list)
    {
        if ($list) {
            foreach ($list as $k => $v) {
                if (substr($v['cid'], 0, 3) == '000') {
                    $subPath = "productType";
                } else if (substr($v['cid'], 0, 3) == '001') {
                    $subPath = "skinSolution";
                } else if (substr($v['cid'], 0, 3) == '002') {
                    $subPath = "productLine";
                } else {
                    $subPath = "productType";
                }
                $sub[] = self::navItem("/shop/goodsList/" . $subPath . "/" . $v['cid'] . "", "" . $v['cname'] . "", "" . $v['depth'] . "", "" . $v['cid'] . "");
            }
        } else {
            $sub = "";
        }

        $data = [
            [
                'main' => self::navItem('/shop/goodsList/productType', 'PRODUCT TYPE', 0, 'productType')
                , 'sub' => $sub
            ]
            , [
                'main' => self::navItem('/shop/goodsList/skinSolution', 'SKIN SOLUTION', 0, 'skinSolution')
                , 'sub' => $sub
            ]
            , [
                'main' => self::navItem('/shop/goodsList/productLine', 'PRODUCT LINE', 0, 'productLine')
                , 'sub' => $sub
            ]
            , [
                'main' => self::navItem('/story/', 'BRAND STORY', 0, 'story')
                , 'sub' => [
                    self::navItem('/story/ourConcept', '브랜드 컨셉', 1, 'ourConcept')
                    , self::navItem('/story/weakAcidity', '약산성 스토리', 1, 'weakAcidity')
                    , self::navItem('/story/appointment', '30일 간의 약속', 1, 'appointment')
                    , self::navItem('/story/ourVideo', '브랜드 영상', 1, 'ourVideo')
                    , self::navItem('/story/magazine', '매거진', 1, 'magazine')
                    //, self::navItem('https://www.facebook.com/ILoveDewyTree', '페이스북', 1, 'https://www.facebook.com/ILoveDewyTree')
                    //, self::navItem('https://www.instagram.com/dewytree_official', '인스타그램', 1, 'https://www.instagram.com/dewytree_official')
                    //, self::navItem('https://twitter.com/dewytree_ko', '트위터', 1, 'https://twitter.com/dewytree_ko')
                ]
            ]
            , [
                'main' => self::navItem('/event/', 'EVENT', 0, 'event')
                , 'sub' => [
                    self::navItem('/event/currentEvent', '진행이벤트', 1, 'currentEvent')
                    , self::navItem('/event/eventWinner', '당첨자발표', 1, 'eventWinner')
                    , self::navItem('/event/monthlyBenefit', '이달의 구매혜택', 1, 'monthlyBenefit')
                ]
            ]
            , [
                'main' => self::navItem('/review/', 'REVIEW', 0, 'review')
                , 'sub' => [
                    self::navItem('/review/review', '일반후기', 1, 'review')
                    , self::navItem('/review/photoReview', '포토후기', 1, 'photoReview')
                ]
            ]
        ];

        if ($cid) {
            $nav = [];
            foreach ($data as $item) {
                $nav['main'][] = $item['main'];
                if ($cid == $item['main']['cid']) {
                    $nav['sub'] = $item['sub'];
                }
            }

            return $nav;
        } else {
            return $data;
        }
    }

    protected static function navItem($cid, $cname, $depth = 1, $path = '')
    {
        return [
            'isBelong' => 0
            , 'cid' => $cid
            , 'cname' => $cname
            , 'depth' => $depth
            , 'path' => $path
        ];
    }

    public static function getOrderStatus($key = false)
    {
        $data = [
            //입금
            ORDER_STATUS_SETTLE_READY => '결제중',
            ORDER_STATUS_REPAY_READY => '재결제대기중',
            ORDER_STATUS_INCOM_READY => '입금대기',
            ORDER_STATUS_INCOM_COMPLETE => '결제완료',
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

    public static function getSmsTpl($key)
    {
        static $data = [];

        if (!isset($data[$key])) {
            $row = getForbiz()->qb
                ->select('mc_sms_text')
                ->select('kakao_alim_talk_template_code as kakao_code')
                ->select('kakao_alim_talk_btn_code as kakao_btn_code')
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
            "sj" => "상호저축은행", "hsbc" => "HSBC", "kb" => "케이뱅크", "kkao" => "카카오뱅크"
        ];

        return self::findKey($data, $key, true);
    }
}
