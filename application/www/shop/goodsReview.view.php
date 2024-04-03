<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // Load Forbiz View
    $view = getForbizView();

    // 상품 아이디
    $pid    = $view->getParams(0);
    // 주문 번호
    $oid    = $view->getParams(1);
    $ode_ix = $view->getParams(2);

    $bbsIx = $view->input->get('bbsIx');
    $mode  = $view->input->get('mode');

    $view->assign("mode", $mode);

    // 프리미엄 후기 설정
    $pconfig = ForbizConfig::getSharedMemory('divSetting_review');

    if (($mode == 'read' || $mode == 'modify') && $bbsIx) {
        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel = $view->import('model.mall.productReview');

        // review detail data get
        $result = $reviewModel->getReviewDetail($bbsIx);

        $view->assign($result['review']);
        $view->assign("cList", $result['cmt']);

    } else {

        /* @var $productModel CustomMallProductModel */
        $productModel = $view->import('model.mall.product');

        //상품 상세 정보
        $datas = $productModel->get($pid);

        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $view->import('model.mall.order');

        // 주문정보 조회
        if(is_mobile()){
            $order_id = $oid;
        }else {
            if (strlen($oid) == 4) {
                $order_id = $pid;
            } else {
                $order_id = $oid;
            }
        }
        $order_data = $orderModel->getOrderInfo($view->userInfo->code, $order_id);

        //마이페이지 구매확정시 상품후기 쓸때
        $thumb ='';
        $pname = '';
        $option_name = '';
        if($mode == 'write'){
            if (isset($order_data['orderDetail'])) {
                foreach ($order_data['orderDetail'] as $p) {
                    $thumb = $p[0]['pimg'];
                    $pname = $p[0]['pname'];
                    $option_name = $p[0]['option_text'];
                }
            }
        }else{
            $thumb = $datas['image_src'];
            $pname = $datas['pname'];
            $option_name = $datas['shotinfo'];
        }

        $product = true;

        $p = array();

        if ($product) {
            $view->assign([
                'valuation_delivery' => 5
                , 'valuation_goods' => 5
                , 'thumb' => $thumb
                // , 'brand_name' => $p['brand_name']
                , 'pname' => $pname
                , 'option_name' => $option_name
                , 'buy_date' => date('Y-m-d')
                , 'pid' => $pid
                , 'oid' => $oid
                , 'ode_ix' => $ode_ix
                , 'image_size' => $pconfig['image_size']
            ]);
        } else {
            exit("<script>alert('후기 상품이 존재하지 않습니다.');window.close()</script>");
        }
    }

    if ($mode == 'read') {
        $view->define("content", 'shop/goods_review/read.htm');
    } else {
        $view->define("content", 'shop/goods_review/write.htm');
    }

    if (is_mobile() || $view->userInfo->appType) {
        $view->assign([
            'appType' => $view->userInfo->appType
        ]);
    }

    echo $view->loadLayout();
} else {
    redirect('/member/login');
}