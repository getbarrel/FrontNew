<?php

/**
 * Description of CustomMallMypageController
 *
 * @author hoksi
 */
class CustomMallMypageController extends ForbizMallMypageController
{

    public function __construct()
    {
        parent::__construct();

        $this->noCheckMethod[] = 'isAllowableCheck';
    }

    /**
     * 주문취소 점검
     */
    public function claimConfirm()
    {
        if ($this->input->post('claimStatus') == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {
            $this->setResponseResult('fail');
        } else {
            $chkField = ['oid', 'odIx[]', 'ccReason'];

            // 비회원 주문번호
            $nonMemberOid = sess_val('nonMember', 'oid');

            if (form_validation($chkField)) {
                $pData = [
                    'oid' => $this->input->post('oid')
                    , 'odIx' => $this->input->post('odIx')
                    , 'ccReason' => $this->input->post('ccReason')
                    , 'status' => $this->input->post('status')
                    , 'claimStatus' => $this->input->post('claimStatus')
                ];

                if (is_login() || $nonMemberOid == $pData['oid']) {
                    /* @var $orderModel CustomMallOrderModel */
                    $orderModel = $this->import('model.mall.order');
                    // 세트/코디 상품인지 확인하여 변환
                    $pData['odIx'] = $orderModel->chkSetGroup($pData['oid'], $pData['odIx']);

                    // 주문 취소 금액 확인
                    $ret = $orderModel->claimConfirm($pData);

                    if (!empty($ret)) {
                        $this->setFlashData('claimDeliveryPrice', $ret['claimDeliveryPrice']);
                    }
                    $this->setResponseResult('success')->setResponseData($ret);
                } else {
                    // 권한 없음
                    $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
                }
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        }
    }

    /**
     * 취소 상태 업데이트(입금전취소, 취소요청, 취소완료). 확인페이지 없음.
     * 반품/교환은 컨트롤러 사용없이 완료 view 페이지에서 따로 처리함.
     */
    public function updateCancelStatus()
    {

        // 비회원 주문번호
        $nonMemberOid = sess_val('nonMember', 'oid');
        $claimDeliveryPrice = $this->getFlashData('claimDeliveryPrice'); //환불완료 처리시 필요한 클레임 배송비

        if (is_login() || $nonMemberOid) {

            // 필수 컬럼 설정
            $chkField = ['oid', 'claimStatus', 'ccReason', 'odIxs[]', 'ccReasonMsg[]'];

            // 필수 데이터
            if (form_validation($chkField)) {
                $oid = $this->input->post('oid');
                $claimStatus = $this->input->post('claimStatus'); //클레임 변경 요청할 상태
                $claimReason = $this->input->post('ccReason');
                $claimReasonMsg = $this->input->post('ccReasonMsg');
                $ccReasonText = $this->input->post('ccReasonText');
                $odIxs = $this->input->post('odIxs');
                $bankCode = $this->input->post('bankCode');
                $bankOwner = $this->input->post('bankOwner');
                $bankNumber = $this->input->post('bankNumber');

                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');

                //현재 물류 상황 체크 $key => od_ix , $value => pcnt
				$updateChk = 'N';
                foreach($odIxs as $key => $value) {
                    //부분 취소 시 선택되지 않은 상품의 경우 odIxs 값에는 포함 되어 있지만 value 값에 0으로 넘어오는 프로세스 이므로 해당 조건 추가 JK20200131
                    if ($value > 0) {
                        $chkResult = json_decode($this->checkLogistic($oid, $key));

                        if ($chkResult->res_cd == '0000') {
                            if ($chkResult->invo_yn == 'Y') {
                                //송장이 발행이 된 상태이므로 배송준비중 상태로 변경
                                $orderModel->updateDeliveryReady($oid, $key);
								$updateChk = 'Y';
                                /*
								$msg = "고객님께서 주문하신 상품은 포장이 완료되어 배송 대기 상태로 현재 취소가 불가합니다.";

                                if (BASIC_LANGUAGE == 'english') {
                                    $msg = "You can't cancel your order. It's currently pending for delivery.";
                                }

                                $this->setResponseResult('fail')->setResponseData($msg);
                                return false;
								*/
                            }
                        }
                    }
                }
				//송장이 발행이 된 상태에서 배송준비중으로 변경되면 취소진행을 막아야함
				if ($updateChk == 'Y') {
					$msg = "고객님께서 주문하신 상품은 포장이 완료되어 배송 대기 상태로 현재 취소가 불가합니다.";

					if (BASIC_LANGUAGE == 'english') {
						$msg = "You can't cancel your order. It's currently pending for delivery.";
					}

					$this->setResponseResult('fail')->setResponseData($msg);
					return false;
				}

                // 세트,코디 상품인 경우 odIx 조회
                $odIxs = $orderModel->chkSetGroup($oid, $odIxs);

                // 상품별 사은품 확인
                foreach ($odIxs as $parent_od_ix => $pcnt) {
                    $productGift = $orderModel->getProductGiftOrder($parent_od_ix);
                    if (!empty($productGift)) {
                        foreach ($productGift as $pgItem) {
                            $odIxs[$pgItem['od_ix']] = $pcnt;
                        }
                    }
                }

                // 전체취소 확인후 구매금액별 사은품 취소
                foreach ($orderModel->chkAllOrderCnt($oid, $odIxs) as $od_ix => $pcnt) {
                    $odIxs[$od_ix] = $pcnt;
                }

                // *** 입금전 전체 취소 수정
                if ($claimStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) {	// IB
                    $orderModel->updateIncomBeforeCancel($oid, $claimReason, $claimReasonMsg);

                    // *** 취소요청
                } else if ($claimStatus == ORDER_STATUS_CANCEL_APPLY) {				// CA
                    $orderModel->updateCancelApply($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg);

                    // *** 입금완료후 전체/부분취소 처리
                } else if ($claimStatus == ORDER_STATUS_CANCEL_COMPLETE) {			// CC
                    $cancelledNewOdIxs = $orderModel->updateCancelComplete($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg);
                }

                if (!empty($bankCode)) { //환불 계좌 업데이트.
                    // 기본 환불 계좌가 있는 경우, 기획서에는 임의 수정이 가능하도록 되어있으나 관리자 환불시 계좌 노출과 맞지않아 해당 사항은 작업하지않았음. 181030.
                    // 필요한 경우 관리자도 수정 필요.
                    $orderModel->updateRefundAccountForClaim($oid, $bankCode, $bankOwner, $bankNumber);
                }

                if ($claimStatus == ORDER_STATUS_CANCEL_COMPLETE) {
                    //전체 취소시 PG 취소 처리
                    if ($orderModel->isAllCancelOrder($oid)) {
                        $payDatas = $orderModel->getCancelPaymentData($oid);

                        $payPGSuccessBool = false;
                        $msg = array_values($claimReasonMsg);
                        $message = $msg[0];
                        if (empty($message)) {
                            $message = $oid . ' 전체 취소';
                        }
                        if (is_array($payDatas)) {
                            foreach ($payDatas as $payData) {
                                if (!in_array($payData['method'], [ORDER_METHOD_BANK, ORDER_METHOD_VBANK, ORDER_METHOD_ASCROW])) {
                                    /* @var $paymentGatewayModel CustomMallPaymentGatewayModel */
                                    $paymentGatewayModel = $this->import('model.mall.payment.gateway');
                                    $paymentGatewayModel->init($payData['settle_module']);

                                    //PG 취소
                                    $cancelData = new PgForbizCancelData();
                                    $cancelData->cancelRequester = 'M';
                                    $cancelData->isEscrow = ($payData['escrow_use'] == 'Y' ? true : false);
                                    $cancelData->isPartial = false;
                                    $cancelData->method = $payData['method'];
                                    $cancelData->oid = $oid;
                                    $cancelData->originAmt = $payData['payment_price'];
                                    $cancelData->amt = $payData['payment_price'];
                                    $cancelData->taxAmt = $payData['tax_price'];
                                    $cancelData->taxExAmt = $payData['tax_free_price'];
                                    $cancelData->expectedRestAmt = 0;
                                    $cancelData->message = $message;
                                    $cancelData->tid = $payData['tid'];

                                    $response = $paymentGatewayModel->requestCancel($cancelData);
                                    if ($response['result']) {
                                        $payPGSuccessBool = true;
                                        $pData['tax_price'] = $payData['tax_price'];
                                        $pData['tax_free_price'] = $payData['tax_free_price'];
                                        $pData['settle_module'] = $payData['settle_module'];
                                        $pData['tid'] = $payData['tid'];
                                        $pData['ic_date'] = date('Y-m-d H:i:s');
                                        $orderModel->insertOrderPayment($oid, 'F', ORDER_STATUS_INCOM_COMPLETE, $payData['method'], $payData['payment_price'], $pData);

                                        $prData['expect_price'] = $payData['payment_price'];
                                        $prData['payment_price'] = $payData['payment_price'];
                                        $orderModel->insertOrderPrice($oid, 'F', 'P', $prData);
                                    }
                                }
                            }
                        } else {
                            $payPGSuccessBool = true;
                        }

                        if ($payPGSuccessBool == true) {
                            //기타 취소
                            $orderModel->doCancelEtc($oid, ORDER_STATUS_CANCEL_COMPLETE, $message);
                            //주문 취소
                            $orderModel->updateOrderDetailRefundComplete($oid, $message);
                        }
                    }
                }


                // 취소 사유 업데이트
                if(is_array($odIxs)){
                    $claim_datas = [];
                    foreach($odIxs as $key => $val){
                        $claim_datas['oid'] = $oid;
                        $claim_datas['od_ix'] = $key;
                        $claim_datas['status'] = $claimStatus;
                        $claim_datas['c_type'] = 'B';//구매자 고정
                        $claim_datas['reason_code'] = $claimReason;
                        $claim_datas['status_message'] = $ccReasonText;
                        $claim_datas['msg'] = $claimReasonMsg[$key] ?? "";
                        $orderModel->addClaimInfo($claim_datas);
                    }
                }


                if (!empty($cancelledNewOdIxs)) {
                    $odixs = implode("/", $cancelledNewOdIxs);
                    $this->setResponseResult('success')->setResponseData(['odixs' => $odixs]);
                } else {
                    $this->setResponseResult('success');
                }

                // 주문 취소 메일 발송 event
                return ['oid' => $oid, 'sendCancelComplete' => ($payPGSuccessBool ?? false)];

            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
        }
    }


    /**
     * 주문 교환/반품 확인 페이지 이동
     * @param string $claimType
     * @param string $claimStep
     */
    public function orderClaim($claimType = null, $claimStep = null)
    {
        // 비회원 주문번호
        $nonMemberOid = sess_val('nonMember', 'oid');

        if (is_login() || $nonMemberOid) {

            if ($claimStep != '' && $claimType != '') {

                if ($claimStep == 'apply') {

                    $appData = $this->input->post();
                    foreach ($appData['claim_reason'] as $p => $v) {
                        if ($v != '') {
                            $appData['claim_reason'] = $v;
                        }
                    }

//                    echo "<pre>"; print_r($appData);exit;
                    // 반품/교환 신청
                    $this->setFlashData('claimApplyData',
                        [
                            'applyData' => $appData,
                            'claimType' => $claimType,
                            'applyOid' => $this->input->post('oid'),
                            'originClaimCnt' => $this->input->post('claim_cnt')
                        ]);

                    $this->setResponseResult('success')->setResponseData(['url' => '/mypage/orderClaim/' . $claimType . '/confirm']);


                } elseif ($claimStep == 'confirm') {
                    // 반품/교환 확인
                    // Get Confirm Data
                    $claimConfirmData = $this->getFlashData('claimConfirmData');

                    if (isset($claimConfirmData['confirmKey']) && $claimConfirmData['confirmKey'] === $this->input->post('confirm_key')) {
                        // Set Complete Data
                        $CompleteData = [
                            'order' => $claimConfirmData['order'],
                            'claimCnt' => $claimConfirmData['applyData']['claim_cnt'],
                            'claimSetCnt' => $claimConfirmData['applyData']['claim_set_cnt'], // 세트/코디 구성상품 * 반품/교환 수량
                            'claimReason' => $claimConfirmData['applyData']['claim_reason'],   // 1개
                            'claimReasonMsg' => $claimConfirmData['applyData']['claim_msg'],  // 다중 입력
                            'claimReasonText' => $claimConfirmData['applyData']['claimReasonText'],  // 다중 입력
                            'claimDeliveryInfos' => [
                                'sendType' => ($claimConfirmData['applyData']['send_type'] ?? ''),
                                'invoiceNo' => ($claimConfirmData['applyData']['invoice_no'] ?? ''),
                                'quick' => ($claimConfirmData['applyData']['quick'] ?? ''),
                                'payType' => ($claimConfirmData['applyData']['delivery_pay_type'] ?? ''),
                                'cname' => ($claimConfirmData['applyData']['cname'] ?? ''),
                                'czip' => ($claimConfirmData['applyData']['czip'] ?? ''),
                                'caddr1' => ($claimConfirmData['applyData']['caddr1'] ?? ''),
                                'caddr2' => ($claimConfirmData['applyData']['caddr2'] ?? ''),
                                'cmsg' => ($claimConfirmData['applyData']['cmsg'] ?? ''),
                                'cmobile' => ($claimConfirmData['applyData']['cmobile1'] ?? '') . '-' . ($claimConfirmData['applyData']['cmobile2'] ?? '') . '-' . ($claimConfirmData['applyData']['cmobile3']
                                        ?? ''),
                                'ctel' => ($claimConfirmData['applyData']['ctel1'] ?? '') . '-' . ($claimConfirmData['applyData']['ctel2'] ?? '') . '-' . ($claimConfirmData['applyData']['ctel3']
                                        ?? '')
                            ]
                        ];

                        if ($claimType == 'change') {//교환
                            if (BASIC_LANGUAGE == 'korean') {
                                $changeDeliveryInfos = [
                                    'rname' => ($claimConfirmData['applyData']['rname'] ?? ''),
                                    'rzip' => ($claimConfirmData['applyData']['rzip'] ?? ''),
                                    'raddr1' => ($claimConfirmData['applyData']['raddr1'] ?? ''),
                                    'raddr2' => ($claimConfirmData['applyData']['raddr2'] ?? ''),
                                    'rmsg' => ($claimConfirmData['applyData']['rmsg'] ?? ''),
                                    'rmobile' => ($claimConfirmData['applyData']['rmobile1'] ?? '') . '-' . ($claimConfirmData['applyData']['rmobile2'] ?? '') . '-' . ($claimConfirmData['applyData']['rmobile3']
                                            ?? ''),
                                    'rtel' => ($claimConfirmData['applyData']['rtel1'] ?? '') . '-' . ($claimConfirmData['applyData']['rtel2'] ?? '') . '-' . ($claimConfirmData['applyData']['rtel3']
                                            ?? '')
                                ];
                            } else {
                                $changeDeliveryInfos = [
                                    'rname' => ($claimConfirmData['applyData']['rname'] ?? ''),
                                    'rzip' => ($claimConfirmData['applyData']['rzip'] ?? ''),
                                    'raddr1' => ($claimConfirmData['applyData']['raddr1'] ?? ''),
                                    'raddr2' => ($claimConfirmData['applyData']['raddr2'] ?? ''),
                                    'rmsg' => ($claimConfirmData['applyData']['rmsg'] ?? ''),
                                    'rmobile' => ($claimConfirmData['applyData']['rmobile1'] ?? '') . '-' . ($claimConfirmData['applyData']['rmobile2'] ?? ''),
                                    'country' => ($claimConfirmData['applyData']['country'] ?? ''),
                                    'city' => ($claimConfirmData['applyData']['city'] ?? ''),
                                    'state' => ($claimConfirmData['applyData']['state'] ?? '')
                                ];
                            }


                            $CompleteData['claimDeliveryInfos'] = array_merge($CompleteData['claimDeliveryInfos'], $changeDeliveryInfos);
                        }

                        // 교환 상품 총 수량 추가(메일 발송용)
                        $claimConfirmData['originClaimCnt'] = ($this->getFlashData('claimApplyData')['originClaimCnt'] ?? '');

                        $bankCode = $this->input->post('bankCode');
                        $bankOwner = $this->input->post('bankOwner');
                        $bankNumber = $this->input->post('bankNumber');

                        if (!empty($bankCode)) {
                            $refundAccount = [
                                'bankCode' => ($bankCode ?? ''),
                                'bankOwner' => ($bankOwner ?? ''),
                                'bankNumber' => ($bankNumber ?? '')
                            ];

                            $CompleteData = array_merge($CompleteData, $refundAccount);
                        }

                        $this->setFlashData('claimCompleteData', $CompleteData);
                        $this->setResponseResult('success')->setResponseData(['url' => '/mypage/orderClaim/' . $claimType . '/complete']);

                        return [
                            'claimType' => $claimType,
                            'claimStep' => $claimStep,
                            'data' => $claimConfirmData ?? []
                        ];

                    } else {
                        $this->setResponseResult('notMetchConfirmKey');
                    }

                } else {
                    $this->setResponseResult('notDefineStep');
                }
            } else {
                $this->setResponseResult('bad request');
            }
        } else {
            // 권한 없음
            $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
        }
    }

    /**
     * 앱 설정 쇼핑알림설정
     */
    public function isAllowableCheck()
    {

        $chkField = ['id'];

        if (form_validation($chkField)) {
            /* @var $mypageModel CustomMallMypageModel */
            $mypageModel = $this->import('model.mall.mypage');

            $data = $mypageModel->getIsAllowableCheck($this->input->post('id'));

            $this->setResponseResult('success')->setResponseData($data);

        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 앱 설정 쇼핑알림설정
     */
    public function modifyPushAllowable()
    {

        $chkField = ['deviceId'];

        if (form_validation($chkField)) {
            /* @var $mypageModel CustomMallMypageModel */
            $mypageModel = $this->import('model.mall.mypage');

            $responseData = $mypageModel->modifyPushAllowable($this->input->post('deviceId'), $this->input->post('isAllowed'));

            if ($responseData == true) {
                $this->setResponseResult('success')->setResponseData($responseData);
            } else {
                $this->setResponseResult('fail')->setResponseData($responseData);
            }

        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    // 1:1 문의내역
    public function myInquiryList()
    {
        $chkField = ['bType', 'page'];

        if (form_validation($chkField)) {
            $param['bType'] = $this->input->post('bType');
            $param['sType'] = $this->input->post('sType');
            $param['qType'] = $this->input->post('qType');
            $param['curPage'] = $this->input->post("page");
            $param['bbsDiv'] = $this->input->post("bbsDiv");
            $param['sDate'] = $this->input->post("sDate");
            $param['eDate'] = $this->input->post("eDate");
            $param['searchText'] = $this->input->post("searchText");
            $param['mypageQnaYn'] = $this->input->post("mypageQnaYn");
            $param['devCkStatus'] = $this->input->post("devCkStatus");

            $param['status'] = $this->input->post("bbs_status");
/*
            if ($this->input->post("s1") != '') {
                array_push($param['status'], $this->input->post("s1"));
            }
            if ($this->input->post("s2") != '') {
                array_push($param['status'], $this->input->post("s2"));
            }
            if ($this->input->post("s3") != '') {
                array_push($param['status'], $this->input->post("s3"));
            }
*/

            /* @var $customerModel ForbizMallCustomerModel */
            $customerModel = $this->import('model.mall.customer');
            $customerModel->setBoardConfig($param['bType']);
            $responseData = $customerModel->getNoticeList($param);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * Qna 삭제
     */
    public function deleteQna()
    {
        $chkField = ['bbs_ix'];

        if (form_validation($chkField)) {
            /* @var $productQnaModel CustomMallProductQnaModel */
            $productQnaModel = $this->import('model.mall.productQna');

            $data = $productQnaModel->deleteQna($this->input->post('bbs_ix'));

            if ($data['result'] == 'success') {
                $this->setResponseResult('success')->setResponseData($data);
            } else {
                $this->setResponseResult('fail')->setResponseData($data);
            }

        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 최근 본 상품
     * @overwrite
     * 비회원일때도 조회가능
     */
    public function recentView()
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');
        if (!empty($this->userInfo->code)) {
            $userCode = $this->userInfo->code;
        } else {
            $userCode = session_id();
        }

        $responseData = $productModel->getProductViewHistory($userCode, $this->input->post('page'), $this->input->post('max'));
        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                $row['state_sale'] = ($row['status'] == 'sale');
                $row['state_soldout'] = ($row['status'] == 'soldout');
                $row['state_stop'] = ($row['status'] == 'stop');
                $responseData['list'][$key] = $row;
            }
        }
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 배송지 추가 / 수정
     * @overwrite
     * 배송지 10가 초과시 insert 불가
     */
    public function addressBookReplace()
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');
        if (BASIC_LANGUAGE == 'english') {
            $chkField = ['recipient', 'pcs', 'mode'];
        } else {
            $chkField = ['recipient', 'pcs1', 'pcs2', 'pcs3', 'mode'];
        }

        if ($this->input->post('mode') == 'update') {
            $chkField[] = 'ix';
        }

        if ($this->input->post('mode') == 'insert') {
            if ($memberModel->getAddressBookCnt($this->userInfo->code) >= MAX_ADDRESS_BOOK) {
                return $this->setResponseResult('over');
            }
        }

        if (form_validation($chkField)) {

            $ix = $memberModel->addressBookReplace(sess_val('user', 'code'), $this->input->post(null, true));

            $this->setResponseResult('success')->setResponseData([
                'ix' => $ix,
                'isMobile' => is_mobile(),
                'mode' => $this->input->post('mode')
            ]);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function registOffLineCoupon()
    {

        $chkField = ['coupon_num'];

        if (form_validation($chkField)) {
            /* @var $mypageModel CustomMallMypageModel */
            $mypageModel = $this->import('model.mall.mypage');
            $couponNum = $this->input->post('coupon_num');
            $couponNum = str_replace('-', '', $couponNum);
            $responseData = $mypageModel->registOffLineCoupon($couponNum);
            $this->setResponseResult('success')->setResponseData($responseData);

        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }


    /**
     * 나의 상품 문의
     */
    public function myGoodsInquiryList()
    {
        $chkField = ['page'];

        if (form_validation($chkField)) {
            $id = $this->input->post('id');
            $curPage = $this->input->post('page');
            $sDate = $this->input->post('sDate');
            $eDate = $this->input->post('eDate');
            $type = $this->input->post('type');
            $max = $this->input->post('max');
            $resYn = $this->input->post('state');

            $ready = $this->input->post('ready');
            $complete = $this->input->post('complete');
            if ($ready == 'Y' && $complete != 'Y') {
                $resYn = "N";
            } else if ($complete == 'Y' && $ready != 'Y') {
                $resYn = "Y";
            }

            if ($type == '') {
                $type = '1';
            }

            $time = time();
            $now = date('Y-m-d');

            switch ($sDate) {
                case '1':
                    $sDate = date('Y-m-d', strtotime("-1 month", $time));
                    $eDate = $now;
                    break;
                case '3':
                    $sDate = date('Y-m-d', strtotime("-3 month", $time));
                    $eDate = $now;
                    break;
                case '6':
                    $sDate = date('Y-m-d', strtotime("-6 month", $time));
                    $eDate = $now;
                    break;
                case '12':
                    $sDate = date('Y-m-d', strtotime("-12 month", $time));
                    $eDate = $now;
                    break;
                default:
                    break;
            }

            /* @var $productQnaModel CustomMallProductQnaModel */
            $productQnaModel = $this->import('model.mall.productQna');
            $responseData = $productQnaModel->getList($id, $type, '', $max, $curPage, $resYn, $sDate, $eDate);
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }


    public function extMileageList()
    {

        if (is_login()) {
            $mileageRule = ForbizConfig::getSharedMemory('b2c_mileage_rule');
            if ($mileageRule['auto_extinction'] == 'Y') {
                $month = $this->input->post('month');
                $page = $this->input->post('page');
                $max = $this->input->post('max');

                /* @var $mileageModel CustomMallMileageModel */
                $mileageModel = $this->import('model.mall.mileage');
                $responseData = $mileageModel->extMileageList($month, $page, $max);
            } else {
                $responseData = [
                    'total' => 0,
                    'list' => '',
                    'paging' => ''
                ];
            }


            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }

    }

    /*
         * 나의 마일리지 내역
         */

    public function mileageList()
    {
        $chkField = ['page'];

        if (form_validation($chkField)) {

            $curPage = $this->input->post('page');
            $table = $this->input->post('table');
            $state = $this->input->post('state');
            $sDate = $this->input->post('sDate');
            $eDate = $this->input->post('eDate');
            $perPage = $this->input->post('max');;

            /* @var $mileageModel CustomMallMypageModel */
            $mileageModel = $this->import('model.mall.mypage');
            $responseData = $mileageModel->getMileageList($curPage, $table, $state, $sDate, $eDate, $perPage);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }


    /**
     * 취소/교환/반품 내역
     */
    public function returnHistory()
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        // 비회원 주문번호
        $nonMemberOid = sess_val('nonMember', 'oid');

        if (is_login() || $nonMemberOid) {

            if ($nonMemberOid) {
                // 비회원 주문번호 조회 설정
                $data['oid'] = $nonMemberOid;
                $cur_page = 1;
                $per_page = 100;

                $data['sDate'] = date('Y-m-d H:i:s', strtotime('-5 years'));
                $data['eDate'] = date('Y-m-d H:i:s');
                $data['status'] = [
                    ORDER_STATUS_CANCEL_APPLY,
                    ORDER_STATUS_CANCEL_COMPLETE,
                    ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE,
                    ORDER_STATUS_RETURN_APPLY,
                    ORDER_STATUS_RETURN_COMPLETE,
                    ORDER_STATUS_RETURN_ING,
                    ORDER_STATUS_RETURN_DELIVERY,
                    ORDER_STATUS_RETURN_DENY,
                    ORDER_STATUS_RETURN_ACCEPT,
                    ORDER_STATUS_RETURN_DEFER,
                    ORDER_STATUS_RETURN_IMPOSSIBLE,
                    ORDER_STATUS_EXCHANGE_APPLY,
                    ORDER_STATUS_EXCHANGE_COMPLETE,
                    ORDER_STATUS_EXCHANGE_DELIVERY,
                    ORDER_STATUS_EXCHANGE_ING,
                    ORDER_STATUS_EXCHANGE_DENY,
                    ORDER_STATUS_EXCHANGE_ACCEPT,
                    ORDER_STATUS_EXCHANGE_DEFER,
                    ORDER_STATUS_EXCHANGE_IMPOSSIBLE
                ];

                $is_paging = false;
            } else {
                $data['sDate'] = $this->input->post('sDate', true);
                $data['eDate'] = $this->input->post('eDate', true);
                $data['status'] = $this->input->post('status', true);
                $data['pname'] = $this->input->post('pname', true);

                $data['sel_sdate'] = $this->input->post('sel_sdate', true);
                $data['sel_edate'] = $this->input->post('sel_edate', true);

                // 기간 설정시
                if ($data['sDate'] == 'timeSelect' && $data['sel_sdate'] != '' && $data['sel_edate'] != '') {
                    $data['sDate'] = $data['sel_sdate'];
                    $data['eDate'] = $data['sel_edate'];
                }


                $cur_page = $this->input->post('page');
                $per_page = $this->input->post('max');

                $is_paging = true;

                if ($data['status'] == '' || $data['status'] == 'all') {
                    $data['status'] = [
                        ORDER_STATUS_CANCEL_APPLY,
                        ORDER_STATUS_CANCEL_COMPLETE,
                        ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE,
                        ORDER_STATUS_RETURN_APPLY,
                        ORDER_STATUS_RETURN_COMPLETE,
                        ORDER_STATUS_RETURN_ING,
                        ORDER_STATUS_RETURN_DELIVERY,
                        ORDER_STATUS_RETURN_DENY,
                        ORDER_STATUS_RETURN_ACCEPT,
                        ORDER_STATUS_RETURN_DEFER,
                        ORDER_STATUS_RETURN_IMPOSSIBLE,
                        ORDER_STATUS_EXCHANGE_APPLY,
                        ORDER_STATUS_EXCHANGE_COMPLETE,
                        ORDER_STATUS_EXCHANGE_DELIVERY,
                        ORDER_STATUS_EXCHANGE_ING,
                        ORDER_STATUS_EXCHANGE_DENY,
                        ORDER_STATUS_EXCHANGE_ACCEPT,
                        ORDER_STATUS_EXCHANGE_DEFER,
                        ORDER_STATUS_EXCHANGE_IMPOSSIBLE
                    ];
                } elseif ($data['status'] == ORDER_STATUS_CANCEL_APPLY) {
                    $data['status'] = [
                        ORDER_STATUS_CANCEL_APPLY,
                        ORDER_STATUS_CANCEL_COMPLETE,
                        ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE
                    ];
                } elseif ($data['status'] == ORDER_STATUS_RETURN_APPLY) {
                    $data['status'] = [
                        ORDER_STATUS_RETURN_APPLY,
                        ORDER_STATUS_RETURN_COMPLETE,
                        ORDER_STATUS_RETURN_ING,
                        ORDER_STATUS_RETURN_DELIVERY,
                        ORDER_STATUS_RETURN_DENY,
                        ORDER_STATUS_RETURN_ACCEPT,
                        ORDER_STATUS_RETURN_DEFER,
                        ORDER_STATUS_RETURN_IMPOSSIBLE
                    ];
                } elseif ($data['status'] == ORDER_STATUS_EXCHANGE_APPLY) {
                    $data['status'] = [
                        ORDER_STATUS_EXCHANGE_APPLY,
                        ORDER_STATUS_EXCHANGE_COMPLETE,
                        ORDER_STATUS_EXCHANGE_DELIVERY,
                        ORDER_STATUS_EXCHANGE_ING,
                        ORDER_STATUS_EXCHANGE_DENY,
                        ORDER_STATUS_EXCHANGE_ACCEPT,
                        ORDER_STATUS_EXCHANGE_DEFER,
                        ORDER_STATUS_EXCHANGE_IMPOSSIBLE
                    ];
                }
            }

            $data = $orderModel->getReturnHistory(sess_val('user', 'code'), $data, $cur_page, $per_page, $is_paging);
            $this->setResponseResult('success')->setResponseData($data);
        } else {
            // 권한 없음
            $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
        }
    }


    public function getAddressBookCnt()
    {

        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        $this->setResponseData($memberModel->getAddressBookCnt(sess_val('user', 'code')));
    }

    /**
     * 현재 물류상황 체크 API
     */
    public function checkLogistic($oid, $od_ix) {

        $data = array(
            'key' => '6485DD4E6FB095EA',
            'ord_id' => $oid,
            'ord_seq' => $od_ix
        );
        $queryString = http_build_query($data, '', '&');
        $url = "http://erp.getbarrel.com/openapi/ord_invo_yn?" . $queryString;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $responseData = curl_exec($ch);
        curl_close($ch);

        return $responseData;
    }

    /**
     * 배송지변경 가능 체크 API
     */
    public function checkAddressChange() {

        $url = "http://erp.getbarrel.com/openapi/addr_change";

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        $oid = $this->input->post('oid');
        $deliveryIx = $this->input->post('deliveryIx');

        $noid = sess_val('nonMember', 'oid');

        if(!empty($noid)) {
            $oinfo = $orderModel->getOrderStatus($noid);
        }else {
            $oinfo = $orderModel->getOrderStatus($oid);
        }

        if($oinfo['status'] == 'IR') {
            $this->setResponseResult('success')->setResponseData('OK');
        }else {
            if(!empty($noid)) {
                //비회원
                $oid = $noid;
                $address = (object)$this->input->post('deliveryInfo');
                $address->address1 = $address->addr1;
                $address->address2 = $address->addr2;
                $address->mobile = $address->pcs1.'-'.$address->pcs2.'-'.$address->pcs3;
            }else {
                //회원
                $address = $orderModel->getDeliveryAddress($deliveryIx);
            }

            $data = array(
                'key' => '6485DD4E6FB095EA',
                'ord_id' => $oid,
                'ord_addr1' => $address->address1,
                'ord_addr2' => $address->address2,
                'ord_nm' => $address->recipient,
                'ord_hp' => $address->mobile
            );

            $queryString = http_build_query($data, '', '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $responseData = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($responseData, true);

            if($result['res_cd'] == '0000') {
                if($result['chg_yn'] == 'Y') {
                    $this->setResponseResult('success')->setResponseData('OK');
                }else{
                    $this->setResponseResult('success')->setResponseData('FAIL');
                }
            }else {
                //아직 ERP 연동 안된 주문
                $this->setResponseResult('success')->setResponseData('FAIL');
            }
        }
    }

}