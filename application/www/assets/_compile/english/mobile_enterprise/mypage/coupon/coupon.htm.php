<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/coupon/coupon.htm 000010244 */ 
$TPL_mallCoupons_1=empty($TPL_VAR["mallCoupons"])||!is_array($TPL_VAR["mallCoupons"])?0:count($TPL_VAR["mallCoupons"]);?>
<section class="br__coupon br">
    <h2 class="br__coupon__title">Coupons</h2>
    <div class="br__infoinput">
        <div class="br__tabs">
            <ul class="br__tabs__list">
                <li class="br__tabs__box">
                    <button type="button" class="br__tabs__btn br__tabs__btn--active" data-target="download">Downloadable</button>
                </li>
                <li class="br__tabs__box">
                    <button type="button" class="br__tabs__btn" data-target="available">Available</button>
                </li>
            </ul>
            <div class="br__tabs__content br__tabs__content--show" data-target="download">
                <div class="my-coupon__count">
<?php if($TPL_VAR["langType"]=='english'){?>
                    <span class="my-coupon__count__text--point"><?php echo count($TPL_VAR["mallCoupons"])?></span>
                    <span class="my-coupon__count__text">
                        Downloadable
<?php if(count($TPL_VAR["mallCoupons"])> 1){?>
                        coupons
<?php }else{?>
                        coupon
<?php }?>
                    </span>
<?php }else{?>
                    <p class="my-coupon__count__text">Downloadable <span class="my-coupon__count__text--point"><?php echo count($TPL_VAR["mallCoupons"])?></span> </p>
<?php }?>
                </div>
                <div class="my-coupon">
                    <button type="button" class="my-coupon__action devDownLoadCoupon" >Download all coupons</button>
<?php if($TPL_mallCoupons_1){foreach($TPL_VAR["mallCoupons"] as $TPL_V1){?>
                    <input type="hidden" class="devPublishIx" name="publish_ix" value="<?php echo $TPL_V1["publish_ix"]?>" />
                    <ul class="my-coupon__list">
                        <li class="my-coupon__box">
                            <dl class="my-coupon__ticket">
                                <dt class="my-coupon__ticket__title"><?php if($TPL_V1["cupon_use_div"]=='G'){?>web only <?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>Mobile only <?php }else{?><?php }?><?php echo $TPL_V1["publish_name"]?></dt>
                                <dd class="my-coupon__ticket__desc">
                                    <span class="my-coupon__ticket__discount"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>% OFF<?php }else{?>Won <?php }?></span>
                                    <span class="my-coupon__ticket__cutline">
<?php if($TPL_V1["publish_condition_price"]>'0'){?>
                                        <?php echo number_format($TPL_V1["publish_condition_price"])?>above won purchase (excluding certain items)
<?php }else{?>
                                        No constraints
<?php }?>
                                    </span>
                                </dd>
                            </dl>
                            <p class="my-coupon__date">
                                <span class="br__hidden">Validation Period : </span>
<?php if($TPL_V1["use_date_limit"]>'3000-12-31 00:00:00'||$TPL_V1["use_date_type"]=='9'){?>
                                an indefinite period
<?php }elseif($TPL_V1["use_date_type"]=='2'){?>
                                <?php echo substr($TPL_V1["regist_start"], 0, 10)?> ~ <?php echo substr($TPL_V1["regist_end"], 0, 10)?>

<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
                                <?php echo substr($TPL_V1["regdate"], 0, 10)?> ~ <?php echo substr($TPL_V1["publish_limit_date"], 0, 10)?>

<?php }else{?>
                                <?php echo substr($TPL_V1["use_sdate"], 0, 10)?> ~ <?php echo substr($TPL_V1["use_edate"], 0, 10)?>

<?php }?>
                            </p>
                            <div class="my-coupon__target">

                                <button class="my-coupon__target__btn" devRegistix="<?php echo $TPL_V1["publish_ix"]?>">Confirm applied products</button>

                            </div>
                        </li>
                    </ul>
<?php }}else{?>
                    <div class="empty-content">
                        <p>No Coupons that can be Downloaded.</p>
                    </div>
<?php }?>
                    <div class="my-coupon__guide">
                        <p class="my-coupon__guide__title">Notice</p>
                        <ul class="my-coupon__guide__list">
                            <li class="my-coupon__guide__desc">(english)· 쿠폰 인증 번호 등록하기에서 배럴에서 발행한 종이쿠폰/시리얼쿠폰 모바일쿠폰 등의 인증번호를 등록하시면 온라인쿠폰으로 발급되어 사용이 가능합니다.</li>
                            <li class="my-coupon__guide__desc">· Coupons are only applied once in an order and cannot be reused in use.</li>
                            <li class="my-coupon__guide__desc">· Coupons are only available for purchase if applicable.</li>
                            <li class="my-coupon__guide__desc">· Certain coupons may only be used once.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="devListForm">
                <input type="hidden" name="page" value="1" id="devPage"/>
                <input type="hidden" name="max" value="10" />
                <input type="hidden" name="couponUseYn" value="1" id="devCouponUse" />
            </form>
            <div class="br__tabs__content" data-target="available">
                <div class="my-coupon__count">
                    <p class="my-coupon__count__text">Usable coupons <span class="my-coupon__count__text--point" id="devCouponCount">0</span> </p>
                </div>
                <div class="my-coupon" >
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <button type="button" class="my-coupon__action" data-type="available">Coupon registration</button>
<?php }?>
                    <div id="devListContents">
                        <ul class="my-coupon__list" id="devListDetail">
                            <li class="my-coupon__box">
                                <dl class="my-coupon__ticket">
                                    <dt class="my-coupon__ticket__title">
                                        {[cupon_use_div_text]} {[publish_name]}
                                    </dt>
                                    <dd class="my-coupon__ticket__desc">
                                        <span class="my-coupon__ticket__discount">
                                            <span>{[cupon_sale_value_text]}</span>
                                        </span>
                                        <span class="my-coupon__ticket__cutline">
                                            {[use_date_text]}
                                        </span>
                                    </dd>
                                </dl>
                                <p class="my-coupon__date">
                                    <span class="br__hidden">Validation Period : </span>
                                    {[#if use_sdate_text]}
                                    {[use_sdate_text]} ~ {[use_edate_text]}
                                    {[/if]}
                                </p>
                                <div class="my-coupon__target">

                                    <button class="my-coupon__target__btn devItemInfo" data-ix="{[publish_ix]}">Confirm applied products</button>

                                </div>
                            </li>
                        </ul>


                        <div class="empty-content devForbizTpl" id="devListEmpty">
                            <p>No vaild coupon</p>
                        </div>
                        <div class="devForbizTpl" id="devListLoading">
                            <div class="loading"></div>
                        </div>
                    </div>
                    <div class="br__more" id="devPageWrap"></div>


                    <div class="my-coupon__guide">
                        <p class="my-coupon__guide__title">Notice</p>
                        <ul class="my-coupon__guide__list">
                            <li class="my-coupon__guide__desc">Registering a coupon authentication number and registering the authentication number of a paper coupon/Serial coupon mobile coupon issued in the barrel, is issued as an online coupon and can use.</li>
                            <li class="my-coupon__guide__desc">· Coupons are only applied once in an order and cannot be reused in use.</li>
                            <li class="my-coupon__guide__desc">· Coupons are only available for purchase if applicable.</li>
                            <li class="my-coupon__guide__desc">Certain coupons may only be used once.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="coupon-popup">
    <div class="coupon-reg">
        <h2 class="coupon-reg__title">Coupon registration</h2>
        <form id="devInputCoupon">
        <div class="coupon-reg__content">
            <p class="coupon-reg__desc">
                from the barrel <br>Be sure to enter the coupon number issued
                <span class="coupon-reg__notice">(10 to 35 characters, case sensitive, serial number "-" excluded)</span>
            </p>
            <div class="coupon-reg__input">
                <input type="text" name="coupon_num" id="devCouponNum" title="쿠폰번호">
                <p class="coupon-reg__input__valid" id="devInputFail" style="display: none;">Coupon number entered incorrectly or does not exist.</p>
            </div>
            <button type="button" class="coupon-reg__btn" id="devSubmitBtn">Coupon registration</button>
        </div>
        <button type="button" class="coupon-reg__close">Close button</button>
        </form>
    </div>
</div>