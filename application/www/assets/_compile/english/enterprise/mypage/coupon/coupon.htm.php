<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/coupon/coupon.htm 000011436 */ 
$TPL_mallCoupons_1=empty($TPL_VAR["mallCoupons"])||!is_array($TPL_VAR["mallCoupons"])?0:count($TPL_VAR["mallCoupons"]);?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage wrap-mypage br__mypage-coupon">
<?php if($TPL_VAR["langType"]=='korean'){?>
    <section class="br__mypage-coupon__input">
        <h2  class="fb__mypage__title">Coupons</h2>
        <div class="wrap-coupon-reg coupon-registration">
            <form id="devInputCoupon">
                <p class="tit coupon-registration__title">Coupon registration</p>
                <input type="text" name="coupon_num" id="devCouponNum" title="Coupon Number" placeholder="10 to 35 characters, Case sensitivity, Serial Number &Prime;-&Prime; except">
                <input type="submit" id="devSubmitBtn" class="btn-default btn-point" value="Submit">
                <p class="coupon-registration__desc--fail" id="devInputFail" style="display: none;">This coupon number has not been verified. Please check the serial coupon.</p>
                <p class="desc coupon-registration__desc">Please make sure to write the coupon number issued by the BARREL.</p>
            </form>
        </div>
    </section>
<?php }?>
    <section class="br__mypage-coupon__contents">
        <h2  class="fb__mypage__title">Coupon history</h2>
        <div class="tab-control coupon__tab">
            <ul class="fb__mypage__tab">
                <li data-target="download" class="fb__mypage__tab-menu fb__mypage__tab-menu--active">
                    <a href="javascript:void(0);" data-target="download">Downloadable</a>
                </li>
                <li data-target="available" class="fb__mypage__tab-menu coupon__tab__menu">
                    <a href="javascript:void(0);" data-target="available">Available</a>
                </li>
            </ul>
            <div class="coupon-list">
                <div data-target="download" class="coupon-list__download coupon-list__download__download coupon-list__download--show">
                    <div id="devTopButton" class="top-area clearfix items__btn">
                        <div class="float-l">
                            <input type="checkbox" id="all-check" >
                            <label for="all-check">Select All </label>
                            <div class="fb__wishlist__summary">
                                <p>(Download available coupons:<span><?php echo count($TPL_VAR["mallCoupons"])?></span> )</p>
                            </div>
                        </div>
                        <div class="coupon-list__btn">
                            <button type="button" class="coupon__btn--white devDownLoadCoupon" data-down_type="select">Download selected coupons</button>
                            <button type="button" class="coupon__btn--black devDownLoadCoupon" data-down_type="all">Download all coupons</button>
                        </div>
                    </div>
                    <ul>
<?php if($TPL_mallCoupons_1){foreach($TPL_VAR["mallCoupons"] as $TPL_V1){?>
                        <li>
                            <div class="coupon-list__check">
                                <input type="checkbox" name="publish_ix" value="<?php echo $TPL_V1["publish_ix"]?>" class="item-check devPublishIx">
                                <label for=""></label>
                            </div>
                            <div class="coupon-list__info">
                                <div>
                                    <p>
<?php if($TPL_V1["cupon_use_div"]=='G'){?>
                                            web only
<?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>
                                            Mobile only
<?php }else{?>

<?php }?>
                                        <?php echo $TPL_V1["publish_name"]?>

                                    </p>
                                    <strong><span></span>
<?php if($TPL_V1["cupon_sale_type"]=='1'){?>

<?php }else{?>
                                            <?php echo $TPL_VAR["fbUnit"]["f"]?>

<?php }?>
                                        <?php echo g_price($TPL_V1["cupon_sale_value"])?>

<?php if($TPL_V1["cupon_sale_type"]=='1'){?>
                                            % OFF
<?php }else{?>
                                            <?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php }?>
                                    </strong>
                                    <em>
<?php if($TPL_V1["publish_condition_price"]>'0'){?>
                                        <?php echo g_price($TPL_V1["publish_condition_price"])?>Purchase more than  (Some items excluded)
<?php }else{?>
                                        No constraints
<?php }?>
                                    </em>
                                </div>
                            </div>
                            <p class="coupon-list__date">
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
                            <button class="my-coupon__target__btn" devRegistix="<?php echo $TPL_V1["publish_ix"]?>">Confirm applied products</button>

                        </li>
<?php }}else{?>
                        <li class="coupon-list--empty">
                            <div class="empty-content">
                                <p>No Coupons that can be Downloaded.</p>
                            </div>
                        </li>
<?php }?>
                        <!--<li>
                            <div class="coupon-list__check">
                                <input type="checkbox" id="" name="coupon" value="" class="item-check">
                                <label for=""></label>
                            </div>
                            <div class="coupon-list__info">
                                <div>
                                    <p>Yellow Surfer $3 discount coupon</p>
                                    <strong>-3</strong>
                                    <em>Purchases over $50(Excluded specific items)</em>
                                </div>
                            </div>
                            <p class="coupon-list__date">2019.01.01 - 2020.01.01</p>
                            <a href="#">View Items</a>
                        </li>-->
                        <!--<li id="devMileageListEmpty" class="devForbizTpl">
                            <div class="empty-content">
                                <p>No Coupons that can be Downloaded.</p>
                            </div>
                        </li>-->
                    </ul>
                </div>
                <form id="devListForm">
                    <input type="hidden" name="page" value="1" id="devPage"/>
                    <input type="hidden" name="max" value="10" />
                    <input type="hidden" name="couponUseYn" value="1" id="devCouponUse" />
                </form>
                <div data-target="available" class="coupon-list__download coupon-list__download__available" >
                    <div id="devTopButton" class="top-area clearfix items__btn">
                        <div class="float-l">
                            <!--<input type="checkbox" id="all-check" >-->
                            <!--<label for="all-check">Select All </label>-->
                            <div class="fb__wishlist__summary">
                                <p>(Available coupons <span id="devCouponCount">0</span> )</p>
                            </div>
                        </div>
                    </div>
                    <ul id="devListContents">

                        <li id="devListDetail">
                            <div class="coupon-list__check">
                                <!--<input type="checkbox" id="" name="coupon" value="" class="item-check">-->
                                <label for=""></label>
                            </div>
                            <div class="coupon-list__info">
                                <div>
                                    <p>{[cupon_use_div_text]} {[publish_name]}</p>
                                    <strong><span class="coupon-list__info--font">{[cupon_sale_value_text]} </span></strong>
                                    <em>
                                        {[use_date_text]}
                                    </em>
                                </div>
                            </div>
                            <p class="coupon-list__date">
                                {[#if use_sdate_text]}
                                {[use_sdate_text]} ~ {[use_edate_text]}
                                {[/if]}
                            </p>
                            <div class="my-coupon__target">

                                <button class="my-coupon__target__btn devItemInfo" data-ix="{[publish_ix]}">Confirm applied products</button>

                            </div>
                        </li>

                        <div class="empty-content devForbizTpl" id="devListEmpty">
                            <p>No vaild coupon</p>
                        </div>
                        <div class="devForbizTpl" id="devListLoading">
                            <div class="loading"></div>
                        </div>
                    </ul>
                    <div id="devPageWrap"></div>
                </div>

                <div class="br__mypage-coupon__desc">
                    <h3 class="fb__mypage__title mypage-coupon__info">Guide for register a certificated coupon number</h3>
                    <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <li>It is possible to use the online coupon issued by registering authentication numbers such as paper coupon/serial coupon/mobile coupon issued by BARREL before the registration of coupon.</li>
                            <li>A coupon is applicable once in one year at the time of order. It is not possible to reuse the same coupon after using once.</li>
                            <li>It is possible to use a coupon to purchase the corresponding applicable product.</li>
                            <li>In case of specific paper coupon/serial coupon/mobile coupon, it is possible to use only once.</li>
<?php }else{?>
                            <li>A coupon is applicable once in one year at the time of order. It is not possible to reuse the same coupon after using once.</li>
                            <li>It is possible to use a coupon to purchase the corresponding applicable product.</li>
<?php }?>

                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>