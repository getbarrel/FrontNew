<?php /* Template_ 2.2.8 2021/09/15 10:40:25 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/member_level/member_level.htm 000013929 */ ?>
<section class="fb__stock-alarm br__member-benefit">
    <div class="fb__mypage-top">	<!--wrap-mypage-top-->
        <section class="fb__mypage-top__grade grade">
            <a href="/mypage/passReconfirm">
                <figure class="fb__mypage-top__pic">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
                    <img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
                </figure>
            </a>
            <h2 class="fb__mypage-top__grade-text member-benefit__grade">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo $TPL_VAR["mypage"]["userName"]?> Your Membership is <em class=""fb__mypage-top__grade--em""><?php echo $TPL_VAR["mypage"]["gpName"]?></em>
<?php }else{?>
                Your Membership is <em class="fb__mypage-top__grade--em"><?php echo $TPL_VAR["mypage"]["gpName"]?></em>
<?php }?>
            </h2>
<?php if($TPL_VAR["currentGroup"]["gp_level"]> 3){?>
            <span class="fb__mypage-top__grade--color"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class=""fb__mypage-top__grade--font""><?php echo g_price($TPL_VAR["needPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?> left until the next level</span>

<?php }?>
            <!--<a href="#" class="fb__mypage-top__grade-benefit">회원등급혜택</a>-->
        </section>
    </div>
    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>

    <h2 class="fb__stock-alarm__title">Membership Policy</h2>
    <div class="fb__stock-alarm__list">
        <table class="table-default alarm-list">
            <colgroup>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <col width="161px">
                <col width="150px">
                <col width="*">
                <col width="93px">
                <col width="137px">
                <col width="200px">
<?php }else{?>
                <col width="161px">
                <col width="180px">
                <col width="*">
                <col width="100px">
                <col width="100px">
                <col width="200px">
<?php }?>
            </colgroup>
            <thead>
            <tr>
                <th>Membership level</th>
                <th>Condition of Membership level</th>
                <th>Coupons</th>
                <th>Reward</th>
                <th>Discount</th>
                <th>Membership Guide</th>
            </tr>
            </thead>
            <tbody class="br__member-benefit__contents">
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-yellow.png" alt="옐로우 서퍼">
                    </figure>
                    <p class="benefit-row__title">Yellow Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">신규회원 및 10만원<br>미만 구매고객</td>
                <td>3,000원 할인쿠폰 1매 <br>(3만원 구매 이상)</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">-</td>
                <!-- <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>Reward $3 -->
				<td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">New member & <br>Purchases less than $100</td>
                <!-- <td>One $3 discount coupon</td> -->
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">-</td>
                <td class="benefit-row__percent">Reward $3</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-green.png" alt="그린 서퍼">
                    </figure>
                    <p class="benefit-row__title">Green Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">Purchases over $100</td>
                <td>
                    5,000원 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 1매
                </td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">1%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $5
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $100</td>
                <td>One $5 discount coupon</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">Reward $5</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-blue.png" alt="블루 서퍼">
                    </figure>
                    <p class="benefit-row__title">Blue Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    Purchases over $300
                </td>
                <td>
                    10,000원 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 1매
                </td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">2%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $7
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $250</td>
                <td>One $7 discount coupon</td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">Reward $7</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-bronze.png" alt="브론즈 서퍼">
                    </figure>
                    <p class="benefit-row__title">Bronze Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    Purchases over $500</td>
                <td>
                    10% 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 2매
                </td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">3%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $10
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $400</td>
                <td>One 10% discount coupon</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">Reward $9</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-silver.png" alt="실버 서퍼">
                    </figure>
                    <p class="benefit-row__title">Silver Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    Purchases over $700
                </td>
                <td>
                    10% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">4%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $13
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $550</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">Reward $11</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-gold.png" alt="골드 서퍼">
                    </figure>
                    <p class="benefit-row__title">Gold Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    Purchases over $1000
                </td>
                <td>
                    10% 할인쿠폰 1매<br>15% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">4%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $16
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $850</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">4%</td>
                <td class="benefit-row__percent">Reward $14</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-barrel.png" alt="배럴 서퍼">
                    </figure>
                    <p class="benefit-row__title">Barrel Surfer</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    Purchases over $1500</td>
                <td>
                    10% 할인쿠폰 2매<br>15% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">5%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Reward $20
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $1250</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">6%</td>
                <td class="benefit-row__percent">4%</td>
                <td class="benefit-row__percent">Reward $17</td>
<?php }?>
            </tr>
            <tr class="benefit-row eng-hidden">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-teacher.png" alt="배럴 티쳐">
                    </figure>
                    <p class="benefit-row__title">Barrel Teacher</p>
                </td>
                <td class="benefit-row__condition">Teacher membership user</td>
                <td>
                    Benefits apply to purchases over 30,000 won <br> for barrel teaser members
                </td>
                <td class="benefit-row__percent">0%</td>
                <td class="benefit-row__percent">15%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    Instant discount(diffrent rates) 15%
                </td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="use-notice">
        <h3 class="use-notice__title">Notice</h3>
        <ul class="use-notice__list">
            <li class="use-notice__desc">On the 5th day of every month, the level adjustment shall be done.</li>
            <li class="use-notice__desc">If the 5th day of each month is a weekend or national holiday, reward and coupons will be paid in the next business day.</li>
            <li class="use-notice__desc">The benefit and selection criteria are subject to change for each stage of excellent customer.</li>
            <li class="use-notice__desc">As it is not possible to restore or reissue used coupons, please be cautious of using them.</li>
            <li class="use-notice__desc">The order amount by non membership shall not be included.</li>
        </ul>
    </div>

</section>