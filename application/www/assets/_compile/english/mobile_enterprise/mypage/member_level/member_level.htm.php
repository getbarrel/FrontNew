<?php /* Template_ 2.2.8 2021/08/23 17:00:09 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/member_level/member_level.htm 000018795 */ ?>
<section class="br__level">
    <h2 class="br__title">
        Membership level
    </h2>
    <section class="br__level__user">
        <div class="level level--green">
            <h2 class="level__title">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo $TPL_VAR["mypage"]["userName"]?> your membership tier is <span><b><?php echo $TPL_VAR["mypage"]["gpName"]?></b></span>
<?php }else{?>
                Your Membership is <span><b><?php echo $TPL_VAR["mypage"]["gpName"]?></b></span>
<?php }?>
            </h2>
            <p class="level__summary">
                <b>$<?php echo g_price($TPL_VAR["needPrice"])?></b> left until the next level
            </p>
            <div class="level__content">
                <figure class="level__img">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
                    <img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
                    <figcaption class="level__info">
                        <strong>
                            <?php echo $TPL_VAR["mypage"]["gpName"]?>

                        </strong>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <?php echo $TPL_VAR["currentGroup"]["gp_ename"]?>

<?php }?>
                    </figcaption>
                </figure>
                <!--
                <p class="level--green__info level__condition">
                    신규 회원 및 10만원 미만 구매 고객
                </p>
                <ul class="level__coupon">
                    <li>
                        <button>
                            3,000원 쿠폰 1매
                            <em>- 5만원 이상 -</em>
                        </button>
                    </li>
                    <li>
                        <button class="level__coupon--blue">
                            3,000원 쿠폰 1매
                        </button>
                    </li>
                </ul>
                <div class="level__couponInfo">
                    <div class="level__save">
                        <span>적립금</span>1%
                    </div>
                    <div class="level__sale">
                        <span>즉시할인</span>해당없음
                    </div>
                    <div class="level__return">
                        <ul>
                            <li>
                                적립금 3,000원 지급
                            </li>
                            <li>
                                포토후기 5,000원 지급 / 일반후기 3,000원 지급
                            </li>
                        </ul>
                    </div>
                </div>
                -->
            </div>
        </div>
    </section>
    <section class="level__benefits">
        <div class="benefits">
            <h2 class="benefits__title">
                Membership Policy
            </h2>
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
                        <li>One $3 discount coupon (purchases over $30)</li>
                        <li>Reward $3</li>
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
                                    <li>
                                        1% instant discount
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
                        <li>Purchases over $100</li>
                        <li>5,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
                        <li>1 free shipping coupon</li>
                        <li>$5 reward</li>
                        <li>Photo Review 5,000원 / Text Review 3,000원 Mileage</li>
<?php }else{?>
                        <li>Purchases over $100</li>
                        <li>One $5 discount coupon</li>
                        <li>Reward $5</li>
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
                                        2% instant discount
                                    </li>
                                    <li>
                                        Reward 2%
                                    </li>
<?php }else{?>
                                    <li>1% instant discount</li>
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
                                        3% instant discount
                                    </li>
                                    <li>
                                        Reward 3%
                                    </li>
<?php }else{?>
                                    <li>2% instant discount</li>
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
                                        4% instant discount
                                    </li>
                                    <li>
                                        Reward 3%
                                    </li>
<?php }else{?>
                                    <li>3% instant discount</li>
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
                                        4% instant discount
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
                                        5% instant discount
                                    </li>
                                    <li>
                                        Reward 5%
                                    </li>
<?php }else{?>
                                    <li>4% Instant discount</li>
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
                                        Instant discount(diffrent rates) 15%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
                        <li>
                            Teacher membership user
                        </li>
                        <li>
                            Benefit from purchases over $30
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
                    <li class="benefits__notice__desc">· As it is not possible to restore or reissue used coupons, please be cautious of using them.</li>
                    <li class="benefits__notice__desc">· The order amount by non-membership shall not be included.</li>
                </ul>
            </div>
        </div>
    </section>
</section>