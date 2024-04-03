<?php /* Template_ 2.2.8 2020/09/21 11:19:39 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/mypage_left.htm 000004356 */ ?>
<section class="fb__left-nav">
    <h2 class="fb__left-nav__title">
<?php if(!$TPL_VAR["nonMemberOid"]){?>
            <a href="/mypage/"> My page</a>
<?php }else{?>
            <a href="#">Guest Checkout</a>
<?php }?>
    </h2>
    <ul class="fb__left-nav__box">
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">My shopping history</h3>
            <a href="/mypage/orderHistory" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/orderHistory")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/orderDetail")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/orderCancel")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/order_status_popup")> 0){?>on<?php }?>'>
               <span> Your Orders</span>
            </a>
            <a href="/mypage/returnHistory" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/returnHistory")> 0){?>on<?php }?>'>
                <span>Return/Cancellation</span>
            </a>
        </li>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">Edit My membership</h3>
            <a href="/mypage/mileage" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/mileage")> 0){?>on<?php }?>'>
                <span> Reward</span>
            </a>
            <a href="/mypage/coupon" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/coupon")> 0){?>on<?php }?>'>

                <span>Coupons</span>
            </a>
            <a href="/mypage/memberLevel" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/memberLevel")> 0){?>on<?php }?>'>

                <span>Membership Guide</span>
            </a>
        </li>

        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">Details of my interest</h3>
            <a href="/mypage/recentView" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/recentView")> 0){?>on<?php }?>'>
                <span> Recently Viewed Products</span>
            </a>
            <a href="/mypage/wishlist" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/wishlist")> 0){?>on<?php }?>'>

                <span>Wish list</span>
            </a>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <a href="/mypage/stockAlarm" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/stockAlarm")> 0){?>on<?php }?>'>
                <span>Restock Notification breakdown</span>
            </a>
<?php }?>
        </li>

        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">My Community</h3>
            <a href="/mypage/myInquiry" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myInquiry")> 0){?>on<?php }?>'>
                <span> 1:1 Inquiry</span>
            </a>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <a href="/mypage/myReviewList" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myReviewList")> 0){?>on<?php }?>'>
                <span>My Reviews</span>
            </a>
<?php }else{?>
<?php }?>
            <a href="/mypage/myGoodsInquiry" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myGoodsInquiry")> 0){?>on<?php }?>'>
                <span>Q&A</span>
            </a>
        </li>

        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">My Account</h3>
            <a href="/mypage/profile" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/profile")> 0){?>on<?php }?>'>
                <span> My Account</span>
            </a>
            <a href="/mypage/addressBook" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/addressBook")> 0){?>on<?php }?>'>

                <span>Edit Addresses</span>
            </a>
            <!--<a href="/mypage/refundAccount" class='eng-hidden <?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/refundAccount")> 0){?> on <?php }?>'>

                <span>Refund account management</span>
            </a>-->
            <a href="/mypage/secede" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/secede")> 0){?>on<?php }?>'>

                <span>Delete Account</span>
            </a>
        </li>
<?php }?>
    </ul>
</section>