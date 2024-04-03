<?php /* Template_ 2.2.8 2021/08/23 17:01:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/member_benefit/member_benefit.htm 000018365 */ ?>
<section class="br__level">
    <h2 class="br__level__title">
        Membership Guide
    </h2>
    <section class="member-benefits">
        <dl class="member-benefits__new">
            <dt class="member-benefits__new__title">Online benefits when you sign up!<em class="member-benefits__new__title--italic">!</em></dt>
            <!-- <dd class="member-benefits__new__list">$3 <br>Reward</dd> -->
            <dd class="member-benefits__new__list" style="width:50%">$3 <br>Discount<br>coupon</dd>
            <dd class="member-benefits__new__list" style="width:50%">Reward 1% <br>of purchase amount</dd>
        </dl>
        <ul class="member-benefits__list">
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">1. Reward/Instant discount</h3>
                <p class="member-benefits__box__desc">We will give you a reserve for each level as your membership level is upgraded.<br/>Depending on your membership level, you can receive various reserves and instant discount benefits.</p>
            </li>
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">2. Coupon per membership tier</h3>
                <p class="member-benefits__box__desc">Coupon is available for each tier. <br> Also, customer&#39;s accumulation purchase over $100 is eligible for $5 point.</p>
            </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <li class="member-benefits__box">
                <h3 class="member-benefits__box__title">3. reward for positng review</h3>
                <p class="member-benefits__box__desc">영문몰해당없음</p>
            </li>
<?php }?>
            <li class="member-benefits__box eng-hidden">
                <h3 class="member-benefits__box__title">4. (english)무료 배송</h3>
                <p class="member-benefits__box__desc">해외몰에는 해당없음</p>
            </li>
        </ul>
    </section>
    <section class="level__benefits">
        <div class="benefits">
            <h3 class="benefits__title">
                Membership Policy
            </h3>
            <ul class="benefits__box">
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-yellow.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Yellow Surfer
                                </strong>
                                <ul>
                                    <li>
                                        No available instant discount
                                    </li>
                                    <li>
                                        Reward 1%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>New member & Purchases less than $100</li>
                        <li>One $3 discount coupon (purchases over $30)</li>
                        <!-- <li>Reward 3,000원</li> -->
                        <li>Photo Review 5,000원 / Text Review 3,000원 Mileage</li>
<?php }else{?>
                        <li>New member & Purchases less than $100</li>
                        <li>One $3 discount coupon</li>
                        <!-- <li>Reward $3</li> -->
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-green.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Green Surfer
                                </strong>
                                <ul>
                                    <li>Discount 1%</li>
                                    <li>Reward 1%</li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>Purchases over $100</li>
                        <li>5,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
                        <li>1 free shipping coupon</li>
                        <li>$5 reward</li>
                        <li>Photo Review 5,000원 / Text Review 3,000원 Mileage</li>
<?php }else{?>
                        <li>Purchases over $100</li>
                        <li>One $5 discount coupon</li>
                        <li>reward $5</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-blue.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Blue Surfer
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        Discount 2%
                                    </li>
                                    <li>
                                        Reward 2%
                                    </li>
<?php }else{?>
                                    <li>Discount 1%</li>
                                    <li>Reward 2%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>Purchases over $300</li>
                        <li>10,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
                        <li>1 free shipping coupon</li>
                        <li>$7 reward</li>
                        <li>Photo Review 5,000원 / Text Review 3,000원 Mileage</li>
<?php }else{?>
                        <li>Purchases over $250</li>
                        <li>One $7 discount coupon</li>
                        <li>Reward $7</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-bronze.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Bronze Surfer
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        Discount 3%
                                    </li>
                                    <li>
                                        Reward 3%
                                    </li>
<?php }else{?>
                                    <li>Discount 2%</li>
                                    <li>Reward 3%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            Purchases over $500
                        </li>
                        <li>
                            10% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            2 free shipping coupon
                        </li>
                        <li>
                            Reward $9 point
                        </li>
                        <li>
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li>Purchases over $400</li>
                        <li>One 10% discount coupon</li>
                        <li>Reward $9</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-silver.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Silver Surfer
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        Discount 4%
                                    </li>
                                    <li>
                                        Reward 3%
                                    </li>
<?php }else{?>
                                    <li>Discount 3%</li>
                                    <li>Reward 3%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            Purchases over $700
                        </li>
                        <li>
                            10% 할인 쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            영문몰해당없음
                        </li>
                        <li>
                            Reward $11 point
                        </li>
                        <li>
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li>Purchases over $550</li>
                        <li>One $10 discount coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $11</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-gold.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Gold Surfer
                                </strong>
                                <ul>
                                    <li>
                                        Discount 4%
                                    </li>
                                    <li>
                                        Reward 5%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            Purchases over $1000
                        </li>
                        <li>
                            1 10% discount coupon
                        </li>
                        <li>
                            15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            영문몰해당없음
                        </li>
                        <li>
                            Reward $14 point
                        </li>
                        <li>
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li>Purchases over $850</li>
                        <li>One 10% discount coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $14</li>
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
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        Discount 5%
                                    </li>
                                    <li>
                                        Reward 5%
                                    </li>
<?php }else{?>
                                    <li>Discount 4%</li>
                                    <li>Reward 6%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            Purchases over $1500
                        </li>
                        <li class="eng-hidden">
                            2 10% discount Coupons
                        </li>
                        <li>
                            15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            영문몰해당없음
                        </li>
                        <li>
                            Reward $17 point
                        </li>
                        <li>
                            Photo Review 5,000원 / Text Review 3,000원 Mileage
                        </li>
<?php }else{?>
                        <li>Purchases over $1250</li>
                        <li>One 10% discount Coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $17</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list eng-hidden">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-teacher.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    Barrel Teacher
                                </strong>
                                <ul>
                                    <li>
                                        Discount 15%
                                    </li>
                                    <!--<li>-->
                                        <!--Reward 5%-->
                                    <!--</li>-->
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
                        <li>
                            Teacher membership user
                        </li>
                        <!--<li>-->
                            <!--Benefit applied for purchases over 30,000 won-->
                        <!--</li>-->
                        <li>
                            Benefit from purchases over $30
                        </li>
                        <li>
                            Instant discount 15%
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="benefits__notice">
                <h2 class="benefits__notice__title">Notice</h2>
                <ul class="benefits__notice__list">
                    <li class="benefits__notice__desc">· On the 5th day of every month, the level adjustment shall be done.</li>
                    <li class="benefits__notice__desc">· If fifth days of each month are weekends or holidays, rewards and coupons will be given on the next business day.</li>
                    <li class="benefits__notice__desc">· The benefit and selection criteria are subject to change for each stage of excellent customer.</li>
                    <li class="benefits__notice__desc">· 등급이 한 번에 두 단계 이상 상향될 경우 최종 등급의 혜택만 지급됩니다.</li>
                    <li class="benefits__notice__desc">· As it is not possible to restore or reissue used coupons, please be cautious of using them.</li>
                    <li class="benefits__notice__desc">· The order amount by non-membership shall not be included.</li>
                </ul>
            </div>

            <div class="benefits__join">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <button class="btn-l member">Join</button>
<?php }else{?>
                <a href="/member/joinInput" class="btn-lg nonmember">Join</a>
<?php }?>
            </div>


        </div>
    </section>
</section>