<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 비회원 주문번호
$nonMemberOid = sess_val('nonMember', 'oid');

if (is_login() || $nonMemberOid) {
    // View get
    $view = getForbizView();
    $view->assign('nonMemberOid', $nonMemberOid);

    //환불 은행리스트
    $view->assign('bankList', ForbizConfig::getBankList());

    $claimType = $view->getParams(0); //교환(change), 반품(return)
    $claimStep = $view->getParams(1); //apply(신청&정보입력), confirm(정보확인), complete(신청완료)

    if ($claimType != '' && $claimStep != '') {
        /* @var $mypageModel CustomMallMypageModel */
        /* @var $orderModel CustomMallorderModel */
        $mypageModel = $view->import('model.mall.mypage');
        $orderModel  = $view->import('model.mall.order');

        // 기본 데이타 Assign
        $view->assign([
            'claimType' => $claimType,
            'claimTypeName' => $claimType == 'return' ? trans('반품') : trans('교환'),
            'claimStep' => $claimStep,
            'claimstatus' => $claimType == 'return' ? ORDER_STATUS_RETURN_APPLY : ORDER_STATUS_EXCHANGE_APPLY
        ]);

        // 교환/반품 단계 확인
        if ($claimStep == 'confirm') {

            // 교환/반품 정보확인
            // ApplyData Get
            $claimApplyData = $view->getFlashData('claimApplyData');

            // 이벤트에서 사용할 데이터 전달
            $view->setFlashData('claimApplyData', $claimApplyData);

            if (!empty($claimApplyData)) {

                // ConfirmData Get
                $claimConfirmData = $mypageModel->doOrderClaimConfirm($view->userInfo->code, $claimType, $claimApplyData['applyData']);
               // echo "<pre>"; var_dump($claimConfirmData);exit;

                $view->setFlashData('claimConfirmData', $claimConfirmData);
                $view->assign($claimConfirmData);

                //환불금액 계산 영역. 교환/반품은 신청페이지에서 최종선택 후 확인페이지로 넘어오므로 따로 컨트롤러 쓰지 않음.
                $checkDatas['oid']               = $claimApplyData['applyData']['oid'];
                $checkDatas['odIx']              = $claimConfirmData['applyData']['claim_set_cnt'];
                $checkDatas['status']            = ORDER_STATUS_DELIVERY_COMPLETE;
                $checkDatas['claimStatus']       = ($claimType == 'return' ? ORDER_STATUS_RETURN_APPLY : ORDER_STATUS_EXCHANGE_APPLY);
                $checkDatas['ccReason']          = $claimApplyData['applyData']['claim_reason'];

                // 직접발송(1),지정택배(2) 선택 값
                $checkDatas['send_type']         = $claimApplyData['applyData']['send_type'] ?? '1'; //글로벌의 경우 해당 선택 값이 없기 때문에 값이 없을 경우 직접 발송 상태로 넘김
                // 선불(1),착불(2) 선택 값
                $checkDatas['delivery_pay_type'] = $claimApplyData['applyData']['delivery_pay_type'] ?? '1';
                $checkDatas['czip']               = $claimApplyData['applyData']['czip'];
                $claimPriceData = $orderModel->claimConfirm($checkDatas);

                if (!empty($claimPriceData)) {
                    $view->setFlashData('claimDeliveryPrice', $claimPriceData['claimDeliveryPrice']);
                }
                $view->assign($claimPriceData);

                //htm 페이지 지정
                $view->define('claimPage', 'mypage/order_claim/order_claim_confirm.htm');
            } else {
                // 허가되지 않은 접근
                redirect('/mypage');
            }



        } else if ($claimStep == 'complete') {
            // CompleteData Get / mypage 컨트롤러에서 set함
            $claimCompleteData = $view->getFlashData('claimCompleteData');

            $view->setFlashData('claimCompleteData', $claimCompleteData);

            if (!empty($claimCompleteData)) {
                $view->assign($claimCompleteData);

                //반품/교환 요청시 필요한 데이터들
                $claimDeliveryPrice = $view->getFlashData('claimDeliveryPrice'); //환불완료 처리시 필요한 클레임 배송비

                $view->setFlashData('claimDeliveryPrice', $claimDeliveryPrice);

                $oid            = $claimCompleteData['order']['oid'];
//                $odIxs          = $claimCompleteData['claimCnt'];
                $odIxs          = $claimCompleteData['claimSetCnt']; // 세트/코디 구성수량 * 반품/교환 수량
                $claimReason    = $claimCompleteData['claimReason'];
                $claimReasonMsg = $claimCompleteData['claimReasonMsg'];
                $claimReasonText = $claimCompleteData['claimReasonText'];

                if ($claimType == 'return') {

                    //반품
                    $orderModel->updateReturnApply($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg, $claimCompleteData['claimDeliveryInfos'],$claimReasonText);

                    //환불 계좌 업데이트.
                    if (!empty($claimCompleteData['bankCode']) && !empty($claimCompleteData['bankOwner']) && !empty($claimCompleteData['bankNumber'])) {
                        $bankCode   = $claimCompleteData['bankCode'];
                        $bankOwner  = $claimCompleteData['bankOwner'];
                        $bankNumber = $claimCompleteData['bankNumber'];

                        // 기본 환불 계좌가 있는 경우, 기획서에는 임의 수정이 가능하도록 되어있으나 관리자 환불시 계좌 노출과 맞지않아 해당 사항은 작업하지않았음. 181030.
                        // 필요한 경우 관리자도 수정 필요.
                        $orderModel->updateRefundAccountForClaim($oid, $bankCode, $bankOwner, $bankNumber);
                    }

                } else {

                    //교환
                    $orderModel->updateExchangeApply($oid, $odIxs, $claimDeliveryPrice, $claimReason, $claimReasonMsg, $claimCompleteData['claimDeliveryInfos']);
                }

                //htm 페이지 지정
                $view->define('claimPage', 'mypage/order_claim/order_claim_complete.htm');
            } else {
                // 허가되지 않은 접근
                redirect('/mypage');
            }

        } else {

            $claimOrderData = $mypageModel->doOrderClaimApply(
                $view->userInfo->code, $claimType, $view->input->get('oid'), $view->input->get('od_ix')
            );

            $view->assign('odIx', $view->input->get('od_ix'));
            $view->assign('claimAbleCnt', $claimOrderData['orderDetailCnt']);

            if(BASIC_LANGUAGE == 'english'){
                /* @var $globalModel CustomMallGlobalModel */
                $globalModel = $view->import('model.mall.global');
                $nation = $globalModel->getNationInfo();

                $regional_information = $globalModel->getRegionalInformation();

                $view->assign('nation', $nation);
                $view->assign('regional_information', $regional_information);
            }

            // 사용자 주문데이터 있는지 확인
            if (!empty($claimOrderData) && !empty($claimOrderData['order']['orderDetail'])) {
                // apply
                $view->assign($claimOrderData);
                // apply htm 페이지 지정
                $view->define('claimPage', 'mypage/order_claim/order_claim_apply.htm');
            } else {
                // 허가되지 않은 접근
                redirect('/mypage');
            }
        }

        $view->mypageCommon();

        // Layout 출력
        echo $view->loadLayout();
    } else {
        redirect('/mypage/orderHistory');
    }

    // $view->debug();
} else {
    redirect('/member/login');
}