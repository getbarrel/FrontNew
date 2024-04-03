<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/coupon_down/coupon_down.htm 000003235 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<section class="br__coupon-down">
    <!--<div class="coupon">-->
        <p class="br__coupon-down__desc">List of coupons available for the product.</p>

        <ul class="br__coupon-down__list devCouponContents">
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
            <li class="br__coupon-down__box">
                <div class="coupon-info"> <!--area-coupon-->
                    <div class="coupon-info__img coupon-img">
                        <div class="coupon-info__price per">
                            <span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }?>
                        </div>
                    </div>
                    <div class="coupon-info__detail">
                        <p class="coupon-info__name"><?php if($TPL_V1["cupon_use_div"]=='G'){?>[웹전용]<?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>[모바일전용]<?php }?> <?php echo $TPL_V1["publish_name"]?></p>
                        <p class="coupon-info__desc">
                            쿠폰혜택 : <?php echo number_format($TPL_V1["cupon_sale_value"])?> <?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }else{?>원<?php }?> 할인<br />
                            (<?php if($TPL_V1["publish_min"]=='N'){?>제한조건없음<?php }else{?><?php echo number_format($TPL_V1["publish_condition_price"])?> 원 이상 구매시<?php }?>)<br>
                            사용기간 :
                            <span class="font-rb">
<?php if($TPL_V1["use_date_type"]=='9'){?>무기한
<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
                                <?php echo $TPL_V1["regdate"]?>~<?php echo $TPL_V1["publish_limit_date"]?>

<?php }elseif($TPL_V1["use_date_type"]=='2'){?>발급 후 <?php echo $TPL_V1["regist_date_differ"]?>

<?php if($TPL_V1["regist_date_type"]=='3'){?>
                                일
<?php }elseif($TPL_V1["regist_date_type"]=='2'){?>
                                개월
<?php }elseif($TPL_V1["regist_date_type"]=='1'){?>
                                년
<?php }?> 이내 사용 가능
<?php }elseif($TPL_V1["use_date_type"]=='3'){?><?php echo $TPL_V1["use_sdate"]?>~<?php echo $TPL_V1["use_edate"]?>

<?php }?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="coupon-btn">
<?php if($TPL_V1["isPublished"]){?>
                    <button disabled>Download Complete</button>
<?php }else{?>
                    <button devPublishIx="<?php echo $TPL_V1["publish_ix"]?>">Coupon download</button>
<?php }?>
                </div>
            </li>
<?php }}?>
        </ul>
        <p class="br__coupon-down__desc--light">
            <?php echo trans('다운로드 된 쿠폰은 마이페이지 나의 쿠폰 및 주문/결제 시
            쿠폰 적용 단계에서 확인 하실 수 있습니다.')?>

        </p>
    <!--</div>-->
</section>