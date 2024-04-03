<?php
return function ($type = 'all') {
    /**
     * 예시 http://도메인/controller/global/jsLanguageCollection 일때 이벤트를 주고 싶으면
     * controller/global/jsLanguageCollection url 에 앞에 / 지우고 처리해야함
     */

    if ($type == 'controller') {
        // 컨트롤러 전역 이벤트
        $this->event->on('controller', function ($e) {
            $params = $e->getParams();
        });

        //일반회원 가입 메시지 보내기
        $this->event->on('controller/member/joinInputBasic',
            function ($e) {
                /* @var $this ForbizController */
                $params = $e->getParams();
                if (!empty($params)) {
                    sendMessage('member_reg', $params['user']['email'], $params['user']['pcs'],
                        [
                            'userName' => $params['user']['name']
                            , 'userId' => $params['user']['userId']
                            , 'mem_id' => $params['user']['userId']
                            , 'registDate' => $params['user']['date']
                            , 'emailAcceptance' => $params['user']['info'] == '1' ? '수신' : '수신거부'
                            , 'smsAcceptance' => $params['user']['sms'] == '1' ? '수신' : '수신거부'
                        ]);
                }
            });

        //일반회원 가입 적립금 및 쿠폰 지급
        $this->event->on('controller/member/joinInputBasic',
            function ($e) {
                $params = $e->getParams();
                if (!empty($params)) {
                    /* @var $couponModel CustomMallCouponModel */
                    $couponModel = $this->import('model.mall.coupon');

                    /* @var $memberModel CustomMallMemberModel */
                    $memberModel = $this->import('model.mall.member');

                    /* @var $mileageModel CustomMallMileageModel */
                    $mileageModel = $this->import('model.mall.mileage');

                    $groupInfo = $memberModel->getGroupInfo($params['user']['gpIx']);

                    //특정 조건 쿠폰 자동 발급
                    $couponModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_coupon_yn']);
                    $couponModel->preferredConditionGiveCoupon('1');

                    //회원가입 시 마일리지 지급
                    $mileageModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_reserve_yn']);
                    $mileageModel->memberJoinGiveMileage();
                }
            });

        //일반회원 가입 통계
        $this->event->on('controller/member/joinInputBasic',
            function ($e) {
                $params = $e->getParams();
                //$this->event->emmit('MemberRegLogic', ['userCode' => $userCode, 'setp' => 6]);
                log_message('info', '일반회원 가입 통계 :: ' . json_encode($params));
            });

		//카카오1초 가입 메시지 보내기
        $this->event->on('controller/member/joinInputBasic2',
            function ($e) {
                /* @var $this ForbizController */
                $params = $e->getParams();
                if (!empty($params)) {
                    sendMessage('member_reg', $params['user']['email'], $params['user']['pcs'],
                        [
                            'userName' => $params['user']['name']
                            , 'userId' => $params['user']['userId']
                            , 'mem_id' => $params['user']['userId']
                            , 'registDate' => $params['user']['date']
                            , 'emailAcceptance' => $params['user']['info'] == '1' ? '수신' : '수신거부'
                            , 'smsAcceptance' => $params['user']['sms'] == '1' ? '수신' : '수신거부'
                        ]);
                }
            });

        //카카오1초 가입 적립금 및 쿠폰 지급
        $this->event->on('controller/member/joinInputBasic2',
            function ($e) {
                $params = $e->getParams();
                if (!empty($params)) {
                    /* @var $couponModel CustomMallCouponModel */
                    $couponModel = $this->import('model.mall.coupon');

                    /* @var $memberModel CustomMallMemberModel */
                    $memberModel = $this->import('model.mall.member');

                    /* @var $mileageModel CustomMallMileageModel */
                    $mileageModel = $this->import('model.mall.mileage');

                    $groupInfo = $memberModel->getGroupInfo($params['user']['gpIx']);

                    //특정 조건 쿠폰 자동 발급
                    $couponModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_coupon_yn']);
                    $couponModel->preferredConditionGiveCoupon('1');

                    //회원가입 시 마일리지 지급
                    $mileageModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_reserve_yn']);
                    $mileageModel->memberJoinGiveMileage();
                }
            });

        //카카오1초 가입 통계
        $this->event->on('controller/member/joinInputBasic2',
            function ($e) {
                $params = $e->getParams();
                //$this->event->emmit('MemberRegLogic', ['userCode' => $userCode, 'setp' => 6]);
                log_message('info', '일반회원 가입 통계 :: ' . json_encode($params));
            });

		//카카오1초 후 경로처리
        $this->event->on('controller/member/joinInputBasic2',
            function ($e) {
				$params = $e->getParams();
				if($params['user']['kakaoOk'] == "ok"){
					redirect('/member/joinEnd?utm_source='.$params['user']['utm_source'].'&utm_medium='.$params['user']['utm_medium']);
				}else{
					redirect('/member/joinEnd');
				}
            });

        //사업자회원 가입 메시지 보내기
        $this->event->on('controller/member/joinInputCompany',
            function ($e) {
                /* @var $this ForbizController */
                $params = $e->getParams();
                if (!empty($params)) {
                    sendMessage('member_reg', $params['user']['email'], $params['user']['pcs'],
                        [
                            'userName' => $params['user']['name']
                            , 'userId' => $params['user']['userId']
                            , 'registDate' => $params['user']['date']
                            , 'emailAcceptance' => $params['user']['info']
                            , 'smsAcceptance' => $params['user']['sms']
                            , 'userComName' => $params['company']['comName']
                            , 'userComNumber' => $params['company']['comNumber']
                            , 'authorized' => $params['user']['authorized']
                        ]);
                }
            });

        //사업자회원 가입 적립금 및 쿠폰 지급
        $this->event->on('controller/member/joinInputCompany',
            function ($e) {
                $params = $e->getParams();
                if (!empty($params)) {
                    /* @var $couponModel CustomMallCouponModel */
                    $couponModel = $this->import('model.mall.coupon');

                    /* @var $memberModel CustomMallMemberModel */
                    $memberModel = $this->import('model.mall.member');

                    /* @var $mileageModel CustomMallMileageModel */
                    $mileageModel = $this->import('model.mall.mileage');

                    $groupInfo = $memberModel->getGroupInfo($params['user']['gpIx']);

                    //특정 조건 쿠폰 자동 발급
                    $couponModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_coupon_yn']);
                    $couponModel->preferredConditionGiveCoupon('1');

                    //회원가입 시 마일리지 지급
                    $mileageModel->setMember($params['user']['code'], $params['user']['gpIx'], $groupInfo['use_reserve_yn']);
                    $mileageModel->memberJoinGiveMileage();
                }
            });

        //사업자회원 가입 통계
        $this->event->on('controller/member/joinInputCompany',
            function ($e) {
                $params = $e->getParams();
                //$this->event->emmit('MemberRegLogic', ['userCode' => $userCode, 'setp' => 6]);
                log_message('info', '사업자회원 가입 통계 :: ' . json_encode($params));
            });

        // 주문 취소 (입금후)
        $this->event->on('controller/mypage/updateCancelStatus',
            function ($e) {
                $params = $e->getParams();

                if (!empty($params['oid']) && $params['sendCancelComplete']) {

                    /* @var $orderModel CustomMallOrderModel */
                    $orderModel = $this->import('model.mall.order');
                    $cancelInfo = $orderModel->doOrderCancelInfo(sess_val('user', 'code'), $params['oid']);

                    if ($cancelInfo['order']['status'] == ORDER_STATUS_CANCEL_COMPLETE) {
                        sendMessage('order_cancel', $cancelInfo['order']['bmail'], $cancelInfo['order']['bmobile'], $cancelInfo['order']);
                    }
                }
            });


        // 교환신청 메일발송
        $this->event->on('controller/mypage/orderClaim/change/confirm',
            function ($e) {
                $params = $e->getParams();

                if(isset($params['data']) && isset($params['claimType']) && isset($params['claimStep']))  {
                    if ($params['claimType'] == 'change' && $params['claimStep'] == 'confirm') {

                        if (!empty($params['data']['order']['oid'])) {

                            /* @var $mypageModel CustomMallMypageModel */
                            $mypageModel = $this->import('model.mall.mypage');
                            $orderInfo = $mypageModel->doOrderDetail(sess_val('user', 'code'), $params['data']['order']['oid']);
                            $orderInfo['order']['mem_name'] = $orderInfo['order']['bname'];
                            $orderInfo['order']['pname'] = $orderInfo['deliveryInfo']['msg']['0']['pname'];
                            // 교환수량 수정
                            $orderInfo['order']['pcnt'] = array_sum($params['data']['originClaimCnt']);

                            sendMessage('exchange_apply', $orderInfo['order']['bmail'], $orderInfo['order']['bmobile'], $orderInfo['order']);
                        }

                    }
                }
            });


        // 반품신청 메일발송
        $this->event->on('controller/mypage/orderClaim/return/confirm',
            function ($e) {
                $params = $e->getParams();

                if(isset($params['data']) && isset($params['claimType']) && isset($params['claimStep']))  {
                    if ($params['claimType'] == 'return' && $params['claimStep'] == 'confirm') {

                        if (!empty($params['data']['order']['oid'])) {

                            /* @var $mypageModel CustomMallMypageModel */
                            $mypageModel = $this->import('model.mall.mypage');
                            $orderInfo = $mypageModel->doOrderDetail(sess_val('user', 'code'), $params['data']['order']['oid']);
                            $orderInfo['order']['mem_name'] = $orderInfo['order']['bname'];
                            $orderInfo['order']['pname'] = $orderInfo['deliveryInfo']['msg']['0']['pname'];
                            // 반품수량 수정
                            $orderInfo['order']['pcnt'] = array_sum($params['data']['originClaimCnt']);

                            sendMessage('return_apply', $orderInfo['order']['bmail'], $orderInfo['order']['bmobile'], $orderInfo['order']);
                        }
                    }
                }
            });


        // 회원 탈퇴
        $this->event->on('withdrowMemberSendEmail',
            function ($e) {
                $params = $e->getParams();
                sendMessage('member_exit', $params['mem_mail'], $params['mem_mobile'], $params);
            });






    } elseif ($type == 'viewController') {

        // View 컨트롤러 전역 이벤트
        $this->event->on('viewController', function ($e) {
            $params = $e->getParams();
        });

        //결제 완료시 메시지 보내기
        $this->event->on('payment',
            function ($e) {
                $params = $e->getParams();
                if (!empty($params['oid'])) {
                    /* @var $mypageModel CustomMallMypageModel */
                    $mypageModel = $this->import('model.mall.mypage');

                    $orderData = $mypageModel->doOrderDetail(sess_val('user', 'code'), $params['oid']);

                    // 발송용 정보 설정
                    $orderData['order']['mem_name'] = $orderData['order']['bname'];
                    $orderData['order']['pcnt'] = $orderData['paymentInfo']['total_pcnt'];
                    $orderData['order']['pname'] = $orderData['deliveryInfo']['msg']['0']['pname'];
                    $orderData['order']['total_price'] = number_format($orderData['paymentInfo']['payment']['0']['payment_price']); // 결제 금액
                    $orderData['order']['payment_price'] = $orderData['paymentInfo']['payment']['0']['payment_price']; // 결제금액
                    $orderData['order']['paymentInfo'] = $orderData['paymentInfo']; // 결제정보
                    $orderData['order']['method_text'] = $orderData['paymentInfo']['payment'][0]['method_text']; // 결제수단명
                    // 신용카드
                    if ($orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_CARD) {
                        $orderData['order']['memo'] = str_replace('(00)', '', $orderData['paymentInfo']['payment'][0]['memo']); // 결제정보
                    }
                    // 가상계좌 추가
                    if ($orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_VBANK || $orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_ASCROW) {
                        $orderData['order']['bank_account_num'] = $orderData['paymentInfo']['payment']['0']['bank_account_num']; // 계좌번호
                        $orderData['order']['vb_info'] = $orderData['paymentInfo']['payment']['0']['bank_account_num']; // 계좌번호, 알림톡
                        $orderData['order']['bank_name'] = $orderData['paymentInfo']['payment']['0']['bank']; // 은행명
                        $orderData['order']['bank_input_name'] = $orderData['paymentInfo']['payment']['0']['bank_input_name']; // 예금주
                        $orderData['order']['payment_price'] = $orderData['paymentInfo']['payment']['0']['payment_price']; // 결제금액
                        $orderData['order']['bank_input_date'] = $orderData['paymentInfo']['payment']['0']['bank_input_date']; // 마감일자
                    }

                    $orderData['order']['deliveryInfo'] = $orderData['deliveryInfo']; // 배송정보

                    sendMessage(
                        (($orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_VBANK || $orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_ASCROW) && $orderData['order']['status'] == ORDER_STATUS_INCOM_READY
                            ? 'order_sucess_vbank' : 'order_sucess')
                        , $orderData['order']['bmail']
                        , $orderData['order']['bmobile']
                        , $orderData['order']
                    );
                }
            });

        //결제 완료시 메시지 보내기
        $this->event->on('depositSucessVbank',
            function ($e) {
                $params = $e->getParams();
                if (!empty($params['oid'])) {
                    /* @var $mypageModel CustomMallMypageModel */
                    $mypageModel = $this->import('model.mall.mypage');

                    $row = $this->qb->select('user_code')->from(TBL_SHOP_ORDER)->where('oid', $params['oid'])->exec()->getRowArray();
                    $orderData = $mypageModel->doOrderDetail($row['user_code'], $params['oid']);

                    // 발송용 정보 설정
                    $orderData['order']['mem_name'] = $orderData['order']['bname'];
                    $orderData['order']['pcnt'] = $orderData['paymentInfo']['total_pcnt'];
                    $orderData['order']['pname'] = $orderData['deliveryInfo']['msg']['0']['pname'];
                    $orderData['order']['total_price'] = number_format($orderData['paymentInfo']['payment']['0']['payment_price']); // 결제 금액
                    $orderData['order']['payment_price'] = $orderData['paymentInfo']['payment']['0']['payment_price']; // 결제금액
                    $orderData['order']['paymentInfo'] = $orderData['paymentInfo']; // 결제정보
                    $orderData['order']['method_text'] = $orderData['paymentInfo']['payment'][0]['method_text']; // 결제수단명
                    // 신용카드
                    if ($orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_CARD) {
                        $orderData['order']['memo'] = str_replace('(00)', '', $orderData['paymentInfo']['payment'][0]['memo']); // 결제정보
                    }
                    // 가상계좌 추가
                    if ($orderData['paymentInfo']['payment'][0]['method'] == ORDER_METHOD_VBANK) {
                        $orderData['order']['bank_account_num'] = $orderData['paymentInfo']['payment']['0']['bank_account_num']; // 계좌번호
                        $orderData['order']['vb_info'] = $orderData['paymentInfo']['payment']['0']['bank_account_num']; // 계좌번호, 알림톡
                        $orderData['order']['bank_name'] = $orderData['paymentInfo']['payment']['0']['bank']; // 은행명
                        $orderData['order']['bank_input_name'] = $orderData['paymentInfo']['payment']['0']['bank_input_name']; // 예금주
                        $orderData['order']['payment_price'] = $orderData['paymentInfo']['payment']['0']['payment_price']; // 결제금액
                        $orderData['order']['bank_input_date'] = $orderData['paymentInfo']['payment']['0']['bank_input_date']; // 마감일자
                    }

                    $orderData['order']['deliveryInfo'] = $orderData['deliveryInfo']; // 배송정보

                    sendMessage('deposit_sucess_vbank', $orderData['order']['bmail'], $orderData['order']['bmobile'], $orderData['order']);
                }
            });

        if(){

        }

        //상품 상세보기 이벤트 처리
        $this->event->on('shop/goodsView',
            function ($e) {
echo "A";
                $productCode = $this->getParams(0);

                if ($productCode) {
                    /* @var $productModel CustomMallProductModel */
                    $productModel = $this->import('model.mall.product');

                    /* @var $collectModel CustomMallCollectModel */
                    $collectModel = $this->import('model.mall.collect');

                    // 상품상세 페이지 정보 수집 여기 찾기 )))))
                    $collectModel->setPid($productCode)->addViewData();



                    if ($this->userInfo->code != '') {
                        if (!empty(sess_val('latest_product_view'))) {
                            // 세션 정보 저장
                            $productModel->replaceProductViewHistory($this->userInfo->code, '', '');
                        }

                        // 최근 본 상품 저장
                        $productModel->replaceProductViewHistory($this->userInfo->code, $productCode, '');
                    } else {
                        if (isset($_SESSION['latest_product_view'])) {
                            $_SESSION['latest_product_view'][$productCode] = $productCode;
                        } else {
                            $_SESSION['latest_product_view'] = [$productCode => $productCode];
                        }

                        // 최근 본 상품 저장
                        $productModel->replaceProductViewHistory(session_id(), $productCode, '');
                    }
                }
            });
    }
};
