<?php

/**
 * Description of ForbizMallMypageController
 *
 * @author hoksi
 */
class ForbizMallMypageController extends ForbizMallController
{

    public function __construct()
    {
        parent::__construct();

        // 로그인 체크 활성
        $this->useLoginCheck = true;
        // 로그인 없이 실행 가능 메소드 설정
        $this->noCheckMethod = [
            'orderHistory', 'returnHistory', 'claimConfirm', 'orderClaim'
            , 'deliveryAddressChange', 'deliveryMsgModify'
            , 'updateCancelStatus', 'updateDeliveryComplete', 'updateBuyFinalized'
        ];
    }

    /**
     * 배송지 정보 리스트
     */
    public function addressBook()
    {
        $chkField = ['page'];

        if (form_validation($chkField)) {

            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');

            $cur_page = $this->input->post('page');
            $len = $this->input->post('max');
            $pageMode = $this->input->post('pageMode');

            // Get address book list & paging data
            $responseData = $memberModel->getAddressBookList(sess_val('user', 'code'), $cur_page, $len, true);

            if (!empty($responseData)) {
                $this->setResponseResult('success')->setResponseData($responseData);
            } else {
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 배송지 추가 / 수정
     */
    public function addressBookReplace()
    {
        $chkField = ['recipient', 'pcs1', 'pcs2', 'pcs3', 'mode'];
        if ($this->input->post('type') == 'update') {
            $chkField[] = ['ix'];
        }

        if (form_validation($chkField)) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');

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

    /**
     * 배송지 삭제
     */
    public function adreessBookDelete()
    {
        $chkField = ['ix'];
        if (form_validation($chkField)) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');
            $memberModel->addressBookDelete(sess_val('user', 'code'), $this->input->post('ix'));

            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
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
            $perPage = 10;

            /* @var $mileageModel CustomMallMypageModel */
            $mileageModel = $this->import('model.mall.mypage');
            $responseData = $mileageModel->getMileageList($curPage, $table, $state, $sDate, $eDate, $perPage);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    // 1:1 문의내역
    public function myInquiryList()
    {
        $chkField = ['bType', 'page'];

        if (form_validation($chkField)) {
            $param['bType'] = $this->input->post('bType');
            $param['sType'] = $this->input->post('sType');
            $param['curPage'] = $this->input->post("page");
            $param['bbsDiv'] = $this->input->post("bbsDiv");
            $param['sDate'] = $this->input->post("sDate");
            $param['eDate'] = $this->input->post("eDate");
            $param['searchText'] = $this->input->post("searchText");
            $param['mypageQnaYn'] = $this->input->post("mypageQnaYn");
            $param['devCkStatus'] = $this->input->post("devCkStatus");

            $param['status'] = array();

            if ($this->input->post("s1") != '') {
                array_push($param['status'], $this->input->post("s1"));
            }
            if ($this->input->post("s2") != '') {
                array_push($param['status'], $this->input->post("s2"));
            }
            if ($this->input->post("s3") != '') {
                array_push($param['status'], $this->input->post("s3"));
            }

            /* @var $customerModel ForbizMallCustomerModel */
            $customerModel = $this->import('model.mall.customer');
            $customerModel->setBoardConfig($param['bType']);
            $responseData = $customerModel->getNoticeList($param);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }


    /*
     * 나의 상품 후기
     */
    public function myReviewList()
    {
        $chkField = ['page'];

        if (form_validation($chkField)) {
            $param['id'] = $this->input->post('id');
            $param['page'] = $this->input->post('page');
            $param['sDate'] = $this->input->post('sDate');
            $param['eDate'] = $this->input->post('eDate');
            $param['max'] = $this->input->post('max');

            // 댓글 가져오기
            $param['havingCmt'] = true;

            /* @var $productReviewModel CustomMallProductReviewModel */
            $productReviewModel = $this->import('model.mall.productReview');

            if (is_login()) {
                $code = $_SESSION['user']['code']; //회원코드
            } else {
                $code = "";
            }

            $this->setResponseResult('success')->setResponseData($productReviewModel->getReviewList($param, $code));
        } else {
            $this->setResponseResult('fail');
        }
    }


    /*
     * 나의 관심 상품
     */
    public function myWishList()
    {
        $chkField = ['page', 'max'];

        if (form_validation($chkField)) {
            $wishModel = $this->import('model.mall.wish');
            /* @var $wishModel CustomMallWishModel */
            $responseData = $wishModel->getWishList($this->userInfo->code, $this->input->post('page'), $this->input->post('max'), true);
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
        } else {
            $this->setResponseResult('fail');
        }
    }


    /*
     * 나의 관심 상품 삭제
     */
    public function deleteMyWishList()
    {
        $chkField = ['wishList[]'];

        if (form_validation($chkField)) {
            $param = $this->input->post('wishList');

            $wishModel = $this->import('model.mall.wish');
            /* @var $wishModel CustomMallWishModel */
            $responseData = $wishModel->deleteWish($param);
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    public function deleteMyProductReview()
    {
        $chkField = ['bbsIx'];

        if (form_validation($chkField)) {
            $param['bbs_ix'] = $this->input->post('bbsIx');
            $param['mem_ix'] = sess_val('user', 'code');

            /* @var $productReviewModel CustomMallProductReviewModel */
            $productReviewModel = $this->import('model.mall.productReview');
            $responseData = $productReviewModel->deleteReview($param);
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
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

            if ($type == '') {
                $type = '1';
            }

            /* @var $productQnaModel CustomMallProductQnaModel */
            $productQnaModel = $this->import('model.mall.productQna');
            $responseData = $productQnaModel->getList($id, $type, '', $max, $curPage, '', $sDate, $eDate);
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * 환불계좌 정보
     */
    public function refundAccount()
    {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $this->import('model.mall.member');

        $cur_page = $this->input->post('page');
        $len = $this->input->post('max');

        $responseData = $memberModel->getRefundAccount(sess_val('user', 'code'));
        if (!empty($responseData)) {
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * 환불계좌 정보 삭제
     */
    public function removeRefundAccount()
    {
        if (form_validation(['bank_ix'])) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');

            $memberModel->refundAccountDelete(sess_val('user', 'code'), $this->input->post('bank_ix'));

            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 환불계좌 정보 등록/수정
     */
    public function replaceRefundAccount()
    {
        $chkField = ['bank_code', 'bank_owner', 'bank_number'];

        if (form_validation($chkField)) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');

            $responseData = $memberModel->refundAccountReplace(sess_val('user', 'code'), $this->input->post(null, true));
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 주문내역 조회
     */
    public function orderHistory()
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        // 비회원 주문번호
        $nonMemberOid = sess_val('nonMember', 'oid');

        if (is_login() || $nonMemberOid) {
            $data['sDate'] = $this->input->post('sDate');
            $data['eDate'] = $this->input->post('eDate');
            $data['status'] = $this->input->post('status');

            if ($nonMemberOid) {
                // 비회원 주문번호 조회 설정
                $data['oid'] = $nonMemberOid;
                $cur_page = 1;
                $per_page = 1;

                $data['sDate'] = date('Y-m-d H:i:s', strtotime('-3 years'));
                $data['eDate'] = date('Y-m-d H:i:s');
                if ($data['status'] == '' || $data['status'] == 'all') {
                    $data['status'] = [
                        ORDER_STATUS_INCOM_READY,
                        ORDER_STATUS_INCOM_COMPLETE,
                        ORDER_STATUS_DELIVERY_READY,
                        ORDER_STATUS_DELIVERY_ING,
                        ORDER_STATUS_DELIVERY_COMPLETE,
                        ORDER_STATUS_BUY_FINALIZED,
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
                        ORDER_STATUS_RETURN_DEFER, //
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
                        ORDER_STATUS_EXCHANGE_DEFER, //
                        ORDER_STATUS_EXCHANGE_IMPOSSIBLE
                    ];
                } else {
                    $data['status'] = [$data['status']];
                }

                $is_paging = false;
            } else {
                $data['sDate'] = $this->input->post('sDate');
                $data['eDate'] = $this->input->post('eDate');
                $data['status'] = $this->input->post('status');
                $data['pname'] = $this->input->post('pname');

                $cur_page = $this->input->post('page');
                $per_page = $this->input->post('max');

                $is_paging = true;

                if ($data['status'] == '' || $data['status'] == 'all') {
                    $data['status'] = [
                        ORDER_STATUS_INCOM_READY,
                        ORDER_STATUS_INCOM_COMPLETE,
                        ORDER_STATUS_DELIVERY_READY,
                        ORDER_STATUS_DELIVERY_DELAY,
                        ORDER_STATUS_DELIVERY_ING,
                        ORDER_STATUS_DELIVERY_COMPLETE,
                        ORDER_STATUS_BUY_FINALIZED,
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
                        ORDER_STATUS_RETURN_DEFER, //
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
                        ORDER_STATUS_EXCHANGE_DEFER, //
                        ORDER_STATUS_EXCHANGE_IMPOSSIBLE
                    ];
                } else {
                    $data['status'] = [$data['status']];
                }
            }

            $data = $orderModel->getOrderHistory(sess_val('user', 'code'), $data, $cur_page, $per_page, $is_paging);

            $this->setResponseResult('success')->setResponseData($data);
        } else {
            // 권한 없음
            $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
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

    /**
     * 최근 본 상품
     */
    public function recentView()
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->getProductViewHistory($this->userInfo->code, $this->input->post('page'), $this->input->post('max'));
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

    /*
     * 최근 본 상품 삭제
     */
    public function deleteRecentView()
    {
        $chkField = ['recentList[]'];

        if (form_validation($chkField)) {
            $param['pids'] = $this->input->post('recentList');

            if (!empty($this->userInfo->code)) {
                $param['mem_ix'] = sess_val('user', 'code');
            } else {
                $param['mem_ix'] = session_id();
            }
            $recentProductModel = $this->import('model.mall.product');
            /* @var $recentProductModel CustomMallProductModel */
            $responseData = $recentProductModel->deleteProductViewHistory($param);
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }


    /**
     * 배송 메시지 수정
     */
    public function deliveryMsgModify()
    {
        // 필수 컬럼 설정
        $chkField = ['oId', 'msgIx', 'msgType']; // deliveryMsg 필수 제외, 모바일 때문
        // 필수 데이터 점검
        if (form_validation($chkField)) {
            /* @var $orderModel CustomMallOrderModel */
            $orderModel = $this->import('model.mall.order');

            // 비회원 로그인을 통한 주문번호
            $nonMemberOid = sess_val('nonMember', 'oid');
            // 회원 코드
            $memberCode = sess_val('user', 'code');
            // 주문 번호
            $orderId = $this->input->post('oId');

            if ($memberCode != '' || $nonMemberOid == $orderId) {
                // 배송 메시지 수정
                if ($orderModel->deliveryMsgUpdate($memberCode, $orderId, $this->input->post('msgIx'), $this->input->post('msgType'), $this->input->post('deliveryMsg'))) {
                    $this->setResponseResult('success')->setResponseData($this->input->post('deliveryMsg'));
                } else {
                    $this->setResponseResult('noOrder');
                }
            } else {
                $this->setResponseResult('noOrder');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 배송지 변경
     */
    public function deliveryAddressChange()
    {
        $chkField = ['oId', 'deliveryIx'];
        if (form_validation($chkField)) {
            /* @var $orderModel CustomMallOrderModel */
            $orderModel = $this->import('model.mall.order');

            // 배송지 code
            $deliveryIx = $this->input->post('deliveryIx');
            // 주문번호
            $orderId = $this->input->post('oId');
            if ($deliveryIx === 'false') {
                // 비회원 로그인을 통한 주문번호
                $nonMemberOid = sess_val('nonMember', 'oid');
                if ($nonMemberOid == $orderId) {
                    // 비회원 배송지 변경
                    $ret = $orderModel->guestDeliveryAddressChange($orderId, $this->input->post('deliveryInfo'));
                } else {
                    $ret = 'notExists';
                }
            } else {
                // 로그인 회원 배송지 변경
                $ret = $orderModel->deliveryAddressChange(sess_val('user', 'code'), $orderId, $deliveryIx);
            }

            if (isset($ret['zip'])) {
                $this->setResponseResult('success')->setResponseData($ret);
            } else {
                $this->setResponseResult($ret);
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
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
                if (is_login() || $nonMemberOid == $this->input->post('oid')) {
                    /* @var $orderModel CustomMallOrderModel */
                    $orderModel = $this->import('model.mall.order');
                    $ret = $orderModel->claimConfirm($this->input->post());
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
                    // 반품/교환 신청
                    $this->setFlashData('claimApplyData',
                        [
                            'applyData' => $this->input->post(),
                            'claimType' => $claimType
                        ]);

                    $this->setResponseResult('success')->setResponseData(['url' => '/mypage/orderClaim/' . $claimType . '/confirm']);
                } elseif ($claimStep == 'confirm') {
                    // 반품/교환 확인
                    // Get Confirm Data
                    $claimConfirmData = $this->getFlashData('claimConfirmData');

                    if (isset($claimConfirmData['confirmKey']) && $claimConfirmData['confirmKey'] === $this->input->post('confirm_key')) {
                        // Set Conplete Data
                        $CompleteData = [
                            'order' => $claimConfirmData['order'],
                            'claimCnt' => $claimConfirmData['applyData']['claim_cnt'],
                            'claimReason' => $claimConfirmData['applyData']['claim_reason'],
                            'claimReasonMsg' => $claimConfirmData['applyData']['claim_msg'],
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

                            $CompleteData['claimDeliveryInfos'] = array_merge($CompleteData['claimDeliveryInfos'], $changeDeliveryInfos);
                        }

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
     * 취소 상태 업데이트(입금전취소, 취소요청, 취소완료). 확인페이지 없음.
     * 반품/교환은 컨트롤러 사용없이 완료 view 페이지에서 따로 처리함.
     */
    public function updateCancelStatus()
    {
        // 비회원 주문번호
        $nonMemberOid = sess_val('nonMember', 'oid');

        if (is_login() || $nonMemberOid) {

            // 필수 컬럼 설정
            $chkField = ['oid', 'claimStatus', 'ccReason', 'ccReasonMsg', 'odIxs[]'];

            // 필수 데이터 있음?
            if (form_validation($chkField)) {
                $oid = $this->input->post('oid');
                $claimStatus = $this->input->post('claimStatus'); //클레임 변경 요청할 상태
                $claimReason = $this->input->post('ccReason');
                $claimReasonMsg = $this->input->post('ccReasonMsg');
                $odIxs = $this->input->post('odIxs');

                $bankCode = $this->input->post('bankCode');
                $bankOwner = $this->input->post('bankOwner');
                $bankNumber = $this->input->post('bankNumber');

                $claimDeliveryPrice = $this->getFlashData('claimDeliveryPrice'); //환불완료 처리시 필요한 클레임 배송비

                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');

                if ($claimStatus == ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE) { //입금전취소
                    $orderModel->updateIncomBeforeCancel($oid, $claimReason, $claimReasonMsg);
                } else if ($claimStatus == ORDER_STATUS_CANCEL_APPLY) { //취소요청
                    $orderModel->updateCancelApply($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg);
                } else if ($claimStatus == ORDER_STATUS_CANCEL_COMPLETE) { //취소완료
                    $orderModel->updateCancelComplete($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg);
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
                        $message = $claimReasonMsg;
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

                $this->setResponseResult('success');

                // 주문 취소 메일 발송 event
                return ['oid' => $oid, 'claimStatus' => $claimStatus, 'claimReason' => $claimReason, 'claimReasonMsg' => $claimReasonMsg];

            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
        }
    }

    /**
     * 배송완료 상태변경
     */
    public function updateDeliveryComplete()
    {
        $chkField = ['oid', 'odIx'];

        if (form_validation($chkField)) {
            // 비회원 주문번호
            $nonMemberOid = sess_val('nonMember', 'oid');

            // 주문번호
            $oid = $this->input->post('oid');
            $odIx = $this->input->post('odIx');

            if (is_login() || $nonMemberOid == $oid) {

                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');
                $orderModel->updateDeliveryComplete($oid, $odIx);

                $this->setResponseResult('success');
            } else {
                // 권한 없음
                $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 구매확정 상태변경
     */
    public function updateBuyFinalized()
    {
        $chkField = ['oid', 'odIx'];

        if (form_validation($chkField)) {

            // 비회원 주문번호
            $nonMemberOid = sess_val('nonMember', 'oid');

            // 주문번호
            $oid = $this->input->post('oid');
            $odIx = $this->input->post('odIx');

            if (is_login() || $nonMemberOid == $oid) {

                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');
                $orderModel->updateBuyFinalized($oid, $odIx);

                $this->setResponseResult('success');
            } else {
                // 권한 없음
                $this->setResponseResult('notLogin')->setResponseData(['url' => '/member/login']);
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }
}