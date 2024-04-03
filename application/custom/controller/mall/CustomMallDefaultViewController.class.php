<?php

/**
 * Description of CustomMallDefaultViewController
 *
 * @author hoksi
 */
class CustomMallDefaultViewController extends ForbizMallDefaultViewController
{
    public function __construct($params = false)
    {
        parent::__construct($params);

        //카카오싱크 자동 로그인 체크
        if(isset($_SESSION['kakaoNotUser']) && $_SESSION['kakaoNotUser'] === false){
            $this->autoLoginCheckByKakao();
        }

    }

    /**
     * mypage에서 공통적으로 사용되는 부분 분리
     */
    public function mypageCommon()
    {
        /* @var $couponModel CustomMallCouponModel */
        $couponModel  = $this->import('model.mall.coupon');
        /* @var $orderModel CustomMallOrderModel */
        $orderModel   = $this->import('model.mall.order');
        /* @var $mileageModel CustomMallMileageModel */
        $mileageModel = $this->import('model.mall.mileage');
        /* @var $mypageModel CustomMallMypageModel */
        $mypageModel = $this->import('model.mall.mypage');

        if(is_login()) {
            // 배송상태별 카운팅
            $status = $orderModel->getStatusCount(sess_val('user', 'code'), ORDER_STATUS_DELIVERY_ING);

            $this->assign('mypage',
                [
                    'userName' => sess_val("user", "name"), // 회원 이름
                    'gpName' => sess_val("user", "gp_name"), // 멤버십 등급
                    'regDate' => sess_val("user", "mem_reg_date"), // 멤버십 등급
                    'deliveryIngCnt' => ($status[ORDER_STATUS_DELIVERY_ING] ?? 0), // 배송중인 상품
                    'myMileAmount' => $mileageModel->getUserAmount(), // 마일리지
                    'couponCnt' => $couponModel->setMember(sess_val('user', 'code'), sess_val('user', 'gp_ix'), sess_val('user', 'use_coupon_yn'))->getCouponCnt() // 보유중인 쿠폰수
                ]);

            $gp_ix =  sess_val('user','gp_ix');
            $userCode = sess_val('user', 'code');

            //그룹정보
            $ginfo = $mypageModel->getGroupInfo($gp_ix);
		
            //주문 총액
            $totalPrice = $orderModel->totalOrderPrice($userCode);
            if(isset($ginfo['nextGroup']['order_price']) && ($ginfo['nextGroup']['order_price'] >= $totalPrice)){
                $needPrice = $ginfo['nextGroup']['order_price'] - $totalPrice;
            }else{
                $needPrice = 0;
            }

            $this->assign('currentGroup', $ginfo['currentGroup']);
            $this->assign('nextGroup', $ginfo['nextGroup']);
            $this->assign('totalPrice', $totalPrice);
            $this->assign('needPrice', $needPrice);
        }

        if (!is_mobile()) {
            $this->define('mypage_top', 'mypage/mypage_top/mypage_top.htm');
        }

    }

    public function autoLoginCheckByKakao()
    {

        if (empty(sess_val('user', 'code'))) {
            //USER_AGENT 체크해서 KAKAOTALK 가 포함될 경우 자동로그인 시도 처리
            if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(KAKAOTALK)/i', $_SERVER['HTTP_USER_AGENT']) && empty($this->input->server('HTTP_REFERER'))) {
                /* @var $snsLoginModel CustomMallSnsLoginModel */
                $snsLoginModel = getForbiz()->import('model.mall.snsLogin');
                $url = $snsLoginModel->getKakaoSyncLogin();
                $_SESSION['gotoUrl'] = $this->input->server('REQUEST_URI');
                redirect($url);
               // echo "<script>location.href='{$url}'</script>";

            }
        }
    }
}

