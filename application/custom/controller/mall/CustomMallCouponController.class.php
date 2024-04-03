<?php

/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2019-05-25
 * Time: 오후 6:40
 */
class CustomMallCouponController extends ForbizMallBbsController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserCouponList(){
        if(is_login()){

            $couponUseYn = $this->input->post("couponUseYn");
            $max     = $this->input->post('max');
            $page    = $this->input->post('page');

            if($couponUseYn == '1'){
                $couponUse = false;
            }else{
                $couponUse = true;
            }
            /* @var $couponModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            $responseData = $couponModel->getUserCouponList($couponUse,$page,$max);;

            if($responseData == true){
                $this->setResponseResult('success')->setResponseData($responseData);
            }else{
                $this->setResponseResult('fail')->setResponseData($responseData);
            }

        }else{
            $this->setResponseResult('loginFail');
        }
    }

    public function randomCouponIssue(){
        if(is_login()){

            $gc_ix    = $this->input->post('gc_ix');

            /* @var $couponModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            $responseData = $couponModel->randomCouponIssue($gc_ix);;

            if($responseData['success'] == true){
                $this->setResponseResult('success')->setResponseData($responseData);
            }else{
                $this->setResponseResult('fail')->setResponseData($responseData);
            }
        }else{
            $this->setResponseResult('loginFail');
        }
    }

}