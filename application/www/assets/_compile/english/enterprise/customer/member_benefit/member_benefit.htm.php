<?php /* Template_ 2.2.8 2021/08/23 17:01:57 /home/barrel-stage/application/www/assets/templet/enterprise/customer/member_benefit/member_benefit.htm 000019314 */ ?>
<section class="br__level br__member-benefit">
<?php $this->print_("customerTop",$TPL_SCP,1);?>

    <h2 class="br__level__title">
        Membership Guide
    </h2>
    <section class="member-benefits">
        <div class="member-benefits__new">
            <p class="member-benefits__new__title">
                Online benefits when you sign up!</em>
            </p>
            <div class="member-benefits__wrap">
                <!-- <div class="member-benefits__wrap__list">
                    <div class="member-benefits__wrap__img" data-title="Reward"></div>
                   <p class="member-benefits__wrap__txt"><span>$3</span> Reward</p>
                </div> -->
                <div class="member-benefits__wrap__list" style="width:calc(100%/2);">
                    <div class="member-benefits__wrap__img" data-title="Reward"></div>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <p class="member-benefits__wrap__txt"><span>$3</span> Discount coupon</p>
<?php }else{?>
                    <p class="member-benefits__wrap__txt"><span>$3</span> Discount coupon</p>
<?php }?>
                </div>
                <div class="member-benefits__wrap__list" style="width:calc(100%/2);">
                    <div class="member-benefits__wrap__img" data-title="Reward"></div>
                    <p class="member-benefits__wrap__txt">Reward <span>1%</span> of purchase amount</p>
                </div>
            </div>
        </div>
        <ul class="member-benefits__list">
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">1. Reward/Instant Discount</h3>
                <p class="member-benefits__box__desc">You will receive reward for each membership tier upgrade. You can receive a variety of rewards and immediate discounts based on your membership tier.</p>
            </li>
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">2. Coupon per membership tier</h3>
                <p class="member-benefits__box__desc">Coupon is available for each tier. Also, customer&#39;s accumulation purchase over $100 is eligible for $5 point.</p>
            </li>
            <!--
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">3. Review reward</h3>
                <p class="member-benefits__box__desc member-benefits__box__desc--line1">영문몰해당없음</p>
            </li>
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">4. Free shipping</h3>
                <p class="member-benefits__box__desc member-benefits__box__desc--line1">해외몰에는 해당없음</p>
            </li>
            -->
        </ul>
    </section>
    <section class="level__benefits">
        <div class="benefits">
            <h3 class="benefits__title">
                Membership Policy
            </h3>
            <a href="/mypage/memberLevel" class="benefits__btn">More</a>
            <ul class="benefits__box">
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-yellow.png" alt="옐로우 서퍼">
                        <figcaption class="benefits__name">
                            <p>
                                Yellow Surfer
                            </p>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>No instant disount</strong>
                        </li>
                        <li>
                            <strong>1% reward</strong>
                        </li>

                        <li>
                            New member & Purchases less than $100
                        </li>
                        <li>
                            One $3 discount coupon
                        </li>
                        <!-- <li>
                            $3 Reward
                        </li> -->
                        <li class="eng-hidden">
                            - Photo Review $5 / Text Review $3 Mileage
                        </li>
<?php }else{?>
                        <li><strong>No instant discount</strong></li>
                        <li><strong>1% reward</strong></li>
                        <li>- New member & Purchases less than $100</li>
                        <li>- One $3 discount coupon</li>
                        <!-- <li>- Reward $3</li> -->
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-green.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <p>
                                    Green Surfer
                                </p>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>1% instant discount</strong>
                        </li>
                        <li>
                            <strong>1% reward</strong>
                        </li>
                        <li>
                            Purchases over $100
                        </li>
                        <li>
                            - 	5,000원 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            1 free shipping coupon
                        </li>
                        <li>
                            $5 reward
                        </li>
                        <li class="eng-hidden">
                            - Photo Review $5 / Text Review $3 Mileage
                        </li>
<?php }else{?>
                        <li><strong>1% instant discount</strong></li>
                        <li><strong>1% reward</strong></li>
                        <li>- Purchases over $100</li>
                        <li>- One $5 discount coupon</li>
                        <li>- Reward $5</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-blue.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <p>
                                    Blue Surfer
                                </p>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>2% instant discount</strong>
                        </li>
                        <li>
                            <strong>2% reward</strong>
                        </li>

                        <li>
                            Purchases over $250
                        </li>
                        <li>
                            - 10,000원 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            1 free shipping coupon
                        </li>
                        <li>
                            Reward $7
                        </li>
                        <li class="eng-hidden">
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li><strong>1% instant discount</strong></li>
                        <li><strong>2% reward</strong></li>
                        <li>- Purchases over $250</li>
                        <li>- One $7 discount coupon</li>
                        <li>- Reward $7</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-bronze.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <p>
                                    Bronze Surfer
                                </p>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>3% instant discount</strong>
                        </li>
                        <li>
                            <strong>3% Reward</strong>
                        </li>

                        <li>
                            Purchases over $400
                        </li>
                        <li>
                            - 10% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            2 free shipping coupons
                        </li>
                        <li>
                            Reward $9
                        </li>
                        <li class="eng-hidden">
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li><strong>2% instant discount</strong></li>
                        <li><strong>3% reward</strong></li>
                        <li>- Purchases over $400</li>
                        <li> -One 10% discount coupon</li>
                        <li> -Reward $9</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-silver.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <p>
                                    Silver Surfer
                                </p>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>4% instant discount</strong>
                        </li>
                        <li>
                            <strong>3% Reward</strong>
                        </li>

                        <li>
                            Purchases over $550
                        </li>
                        <li>
                            - 10% 할인 쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            영문몰해당없음
                        </li>
                        <li>
                            Reward $13
                        </li>
                        <li class="eng-hidden">
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li><strong>3% instant discount</strong></li>
                        <li><strong>3% reward</strong></li>
                        <li>- Purchases over $550</li>
                        <li>- One 10% discount coupon & <br>One 15% discount coupon</li>
                        <li>- Reward $11</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-gold.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <p>
                                    Gold Surfer
                                </p>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>4% instant discount</strong>
                        </li>
                        <li>
                            <strong>5% reward</strong>
                        </li>

                        <li>
                            Purchases over $850
                        </li>
                        <li>
                            One 10% discount coupon
                        </li>
                        <li>
                            - 15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            영문몰해당없음
                        </li>
                        <li>
                            - Mileage 16,000원 / Happy birthday coupons 10%
                        </li>
                        <li class="eng-hidden">
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li><strong>4% instant discount</strong></li>
                        <li><strong>5% reward</strong></li>
                        <li>- Purchases over $850</li>
                        <li>- One 10% discount coupon & <br>One 15% discount coupon</li>
                        <li>- Reward $14</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-barrel.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Barrel Surfer
                                </strong>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            <strong>5% Instant discount</strong>
                        </li>
                        <li>
                            <strong>5% reward</strong>
                        </li>

                        <li>
                            Purchases over $1250
                        </li>
                        <li>
                            Two 10% discount Coupons
                        </li>
                        <li>
                            - 15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li class="eng-hidden">
                            영문몰해당없음
                        </li>
                        <li>
                            reward $17 point
                        </li>
                        <li class="eng-hidden">
                            - Photo Review $5 / Text Review $3 Mileage
                        </li>
<?php }else{?>
                        <li><strong>4% instant discount</strong></li>
                        <li><strong>6% reward</strong></li>
                        <li>- Purchases over $1250</li>
                        <li>- One 10% discount coupon & <br>One 15% discount coupon</li>
                        <li>- Reward $17</li>
<?php }?>
                    </ul>
                </li>
                </li>
                <li class="benefits__list eng-hidden">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-teacher.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Barrel Teacher
                                </strong>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
                        <li>
                            <strong>Discount 15%</strong>
                        </li>
                        <!--<li>-->
                            <!--<strong>5% reward</strong>-->
                        <!--</li>-->
                        <li>
                            Teacher membership user
                        </li>
                        <li>
                            Benefit from purchases over $30
                        </li>
                        <li>
                            Instant discount 15%
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="use-notice">
                <h3 class="use-notice__title">Notice</h3>
                <ul class="use-notice__list">
                    <li class="use-notice__desc">On the 5th day of every month, the level adjustment shall be done.</li>
                    <li class="use-notice__desc">If the 5th day of each month is a weekend or national holiday, reward and coupons will be paid in the next business day.</li>
                    <li class="use-notice__desc">The benefit and selection criteria are subject to change for each stage of excellent customer.</li>
                    <li class="use-notice__desc">등급이 한 번에 두 단계 이상 상향될 경우 최종 등급의 혜택만 지급됩니다.</li>
                    <li class="use-notice__desc">As it is not possible to restore or reissue used coupons, please be cautious of using them.</li>
                    <li class="use-notice__desc">The order amount by non membership shall not be included.</li>
                </ul>
            </div>

            <div class="benefits__join">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <button class="btn-lg btn-dark member">Join</button>
<?php }else{?>
                <a href="/member/joinInput" class="btn-lg btn-dark nonmember">Join</a>
<?php }?>
            </div>
        </div>
    </section>
</section>