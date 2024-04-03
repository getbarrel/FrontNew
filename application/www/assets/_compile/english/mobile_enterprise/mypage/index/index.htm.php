<?php /* Template_ 2.2.8 2020/09/21 11:20:19 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/index/index.htm 000009376 */ 
$TPL_beforeProductList_1=empty($TPL_VAR["beforeProductList"])||!is_array($TPL_VAR["beforeProductList"])?0:count($TPL_VAR["beforeProductList"]);?>
<section class="br__mypage">
    <h2 class="br__hidden">My page</h2>
    <section class="br__mypage__user">
        <div class="my-user">
            <h3 class="my-user__name">
                <span class="my-user__name--point"><?php echo $TPL_VAR["mypage"]["userName"]?></span>
<?php if($TPL_VAR["langType"]=='korean'){?>
                없음 
<?php }?>
            </h3>
            <div class="my-user__info"><a href="/mypage/profile" class="my-user__info__btn">My Account</a><a class="my-user__info__btn devLogout">Logout</a></div>
<?php if($TPL_VAR["layoutCommon"]["appType"]){?>
            <!-- mobile App -->
            <div class="my-user__setting">
                <a href="/mypage/preferences" class="my-user__setting__btn">Settings</a>
            </div>
<?php }?>
            <div class="my-user__btn">
                <a href="/mypage/wishlist" class="my-user__btn__wish">
                    <span class="my-user__btn__wish--hidden">Wish list : </span>
                    <span class="my-user__btn__wish--count"><?php echo $TPL_VAR["headerMenu"]["totalWish"]?></span>
                </a>
            </div>
        </div>
    </section>
    <section class="br__mypage__grade">
        <div class="my-grade">
            <figure class="my-grade__thumb">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
                <img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
            </figure>
            <div class="my-grade__text">
                <h3 class="my-grade__text__title">
                    <a href="/mypage/memberLevel" class="my-grade__text__link">
                        <span class="my-grade__text__title--point"><?php echo $TPL_VAR["mypage"]["gpName"]?></span>
<?php if($TPL_VAR["langType"]=='korean'){?><span class="my-grade__text__title--sub"><?php echo $TPL_VAR["currentGroup"]["gp_ename"]?></span><?php }?>
                    </a>
                </h3>
<?php if($TPL_VAR["currentGroup"]["gp_level"]> 3){?>
                <p class="my-grade__text__after"><strong class=""my-grade__text__after--point""><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["needPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></strong> left until the next level</p>
<?php }?>
            </div>
        </div>
    </section>
    <section class="br__mypage__benefit">
        <h3 class="br__hidden">Reward & Coupon</h3>
        <div class="my-benefit">
            <a href="/mypage/mileage" class="my-benefit__point">
                Valid Reward<span class="my-benefit__point--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["mypage"]["myMileAmount"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
            </a>
            <a href="/mypage/coupon" class="my-benefit__coupon">
                Coupons <span class="my-benefit__coupon--point"><?php echo number_format($TPL_VAR["mypage"]["couponCnt"])?> </span>
            </a>
        </div>
    </section>
    <section class="br__mypage__order">
        <div class="my-order">
            <h3 class="my-order__title">Order Status</h3>
            <a href="/mypage/addressBook" class="my-order__link" titl="배송지 관리페이지 바로가기">Edit Addresses</a>
            <ul class="my-order__seq">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_INCOM_READY?>">
                        <span class="my-order__seq__kind">Ordered</span>
                        <span class="my-order__seq__count <?php if(number_format($TPL_VAR["incom_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></span>
                    </a>
                </li>
<?php }?>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_INCOM_COMPLETE?>">
                        <span class="my-order__seq__kind">Ordered</span>
                        <span class="my-order__seq__count<?php if(number_format($TPL_VAR["incom_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></span>
                    </a>
                </li>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_READY?>">
                        <span class="my-order__seq__kind">Preparing</span>
                        <span class="my-order__seq__count<?php if(number_format($TPL_VAR["delivery_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></span>
                    </a>
                </li>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_ING?>">
                        <span class="my-order__seq__kind">Shipped</span>
                        <span class="my-order__seq__count<?php if(number_format($TPL_VAR["delivery_ing_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></span>
                    </a>
                </li>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_COMPLETE?>">
                        <span class="my-order__seq__kind">Out for Delivery</span>
                        <span class="my-order__seq__count <?php if(number_format($TPL_VAR["delivery_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></span>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <section class="br__mypage__menu">
        <h3 class="br__hidden">My Page Menu List</h3>
        <ul class="my-menu">
            <li class="my-menu__box">
                <a href="/mypage/profile" class="my-menu__link">My Account</a>
            </li>
            <li class="my-menu__box">
                <a href="/mypage/memberLevel" class="my-menu__link">Membership Guide</a>
            </li>
            <li class="my-menu__box">
                <a href="/mypage/orderHistory" class="my-menu__link">Your Orders</a>
            </li>
            <li class="my-menu__box">
                <a href="/mypage/returnHistory" class="my-menu__link">Return/Cancellation</a>
            </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <li class="my-menu__box">
                <a href="/mypage/myReviewList" class="my-menu__link">My Reviews</a>
            </li>
<?php }else{?>
<?php }?>
            <li class="my-menu__box">
                <a href="/mypage/myGoodsInquiry" class="my-menu__link">Q&A</a>
            </li>
            <li class="my-menu__box">
                <a href="/mypage/myInquiry" class="my-menu__link">1:1 Inquiry</a>
            </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <li class="my-menu__box">
                <a href="/mypage/stockAlarm" class="my-menu__link">Restock Notification breakdown</a>
            </li>
            <!--<li class="my-menu__box">
                <a href="/mypage/refundAccount" class="my-menu__link">Setting payment</a>
            </li>-->
<?php }?>
            <li class="my-menu__box">
                <a href="/customer/" class="my-menu__link">CS Center</a>
            </li>
        </ul>
    </section>
    <section class="br__mypage__recent">
        <div class="my-recent">
            <h3 class="my-recent__title">Recently Viewed Products</h3>
            <button class="my-recent__btn open-layer__recent-view" data-title="Recently viewed product">Detail</button>
            <div class="my-recent__list">
                <ul class="my-recent__list__wrap">
<?php if($TPL_VAR["beforeProductList"]> 0){?>
<?php if($TPL_beforeProductList_1){foreach($TPL_VAR["beforeProductList"] as $TPL_V1){?>
                    <li class="my-recent__list__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="my-recent__list__link">
                            <figure class="my-recent__list__thumb">
                                <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                            </figure>
                        </a>
                    </li>
<?php }}?>
<?php }else{?>
                    <li class="empty-content">No Recently Viewed Items</li>
<?php }?>

                </ul>
            </div>
        </div>
    </section>
</section>