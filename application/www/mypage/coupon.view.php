<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // Get view
    $view = getForbizView();
    $view->define('mypage_top', 'mypage/mypage_top/mypage_top.htm');
    $view->define('mypage_bottom', 'mypage/mypage_bottom/mypage_bottom.htm');

    /* @var $couponModel CustomMallCouponModel */
    $couponModel = $view->import('model.mall.coupon');
    $coupons     = $couponModel->getUserCouponList(false); //사용가능
    $usedCoupons = $couponModel->getUserCouponList(true); //사용완료&사용불가
    //$mallCoupons = $couponModel->getMallCouponList();//다운가능 쿠폰

    //쿠폰 리스트
    $couponList = $couponModel->getDownCouponList();

    $DownTatal = 0;
    foreach($couponList as $key => $val){

        $couponDownCnt = $couponModel->checkCouponDownCnt($val['publish_ix']);

        $couponAllList[$key] = $val;

        $DownY = ($val['regist_count'] - $couponDownCnt);

        for($i=0;$i<$DownY;$i++){
            $couponAllList[$key]['DownUse'][$i]['DownUse'] = 'Y';
        }

        for($c=$i;$c<$val['regist_count'];$c++){
            $couponAllList[$key]['DownUse'][$c]['DownUse'] = 'N';
        }

        $DownTatal = $DownTatal + $DownY;
    }

    $view->assign('couponList', $couponAllList);
    $view->assign('downTatal', $DownTatal);

    /*$downLoadCoupon = array();
    if(is_array($mallCoupons) && count($mallCoupons)){
        foreach($mallCoupons as $key=>$val){
            if($couponModel->checkPublished($val['publish_ix'])){
                unset($mallCoupons[$key]);
            }else{
                $downLoadCoupon[$val['publish_ix']] = $val;
            }

        }
    }*/

   // print_r($downLoadCoupon);

    $view->assign('coupons', $coupons['list']);
    $view->assign('usedCoupons', $usedCoupons['list']);
    //$view->assign('mallCoupons', $downLoadCoupon);

    $tpl = $view->tpl;

    // 마이페이지 공통
    $view->mypageCommon();

    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/coupon');
}
