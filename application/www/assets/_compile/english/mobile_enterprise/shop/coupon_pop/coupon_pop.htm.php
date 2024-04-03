<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/coupon_pop/coupon_pop.htm 000008982 */ 
$TPL_deliveryCouponList_1=empty($TPL_VAR["deliveryCouponList"])||!is_array($TPL_VAR["deliveryCouponList"])?0:count($TPL_VAR["deliveryCouponList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$TPL_cartCouponList_1=empty($TPL_VAR["cartCouponList"])||!is_array($TPL_VAR["cartCouponList"])?0:count($TPL_VAR["cartCouponList"]);?>
<div class="coupon-sel br__infoinput">
<?php if($TPL_VAR["couponDiv"]=='D'){?>
	<div class="infoinput__toggle infoinput__toggle--hide">
		<h3 class="infoinput__toggle__title">
			&middot; (english)배송비 쿠폰
			<span class="infoinput__toggle__sub"></span>
			<button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
		</h3>
		<div class="infoinput__toggle__content">
			<div class="coupon-sel__wrap-select">
				<div class="coupon-sel__select">
					<select devDeliveryCouponSelect class="js__couponpop__select">
						<option value="">No Selection</option>
<?php if($TPL_deliveryCouponList_1){foreach($TPL_VAR["deliveryCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
						<option value="<?php echo $TPL_V1["regist_ix"]?>"
								devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
								devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_VAR["cartCouponList"]["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
					</select>
				</div>
				<span class="coupon-sel__cancel devCouponCancel">취소</span>
			</div>
		</div>
	</div>
	<div class="coupon-sel__total">
		<dl class="coupon-sel__total__indiv">
			<dt>Shipping fee :</dt>
			<input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
			<input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["totalDeliveryPrice"]?>" />
			<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["totalDeliveryPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
		<dl class="coupon-sel__total__indiv">
			<dt>Coupons-discount :</dt>
			<dd><span id='tot_discount'>-</span><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponDiscountAmount">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
		<dl class="coupon-sel__total__price total-price">
			<input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
			<dt>Total coupon application amount :</dt>
			<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["totalDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
	</div>
	<div class="coupon-sel__btn">
		<button class="coupon-sel__btn__cancel" id="devCouponCancelButton">Cancel</button>
		<button class="coupon-sel__btn__submit" id="devApplyDeliveryCouponButton">Valid Coupons</button>
	</div>
<?php }else{?>
	<div class="infoinput__toggle infoinput__toggle--hide">
		<h3 class="infoinput__toggle__title">
			&middot; Product coupons
			<span class="infoinput__toggle__sub"></span>
			<button type="button" class="infoinput__toggle__btn">View/hide information button</button>
		</h3>
		<div class="infoinput__toggle__content">
			<ul class="info-goods__list">
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_setData_2=empty($TPL_V1["setData"])||!is_array($TPL_V1["setData"])?0:count($TPL_V1["setData"]);
$TPL_couponList_2=empty($TPL_V1["couponList"])||!is_array($TPL_V1["couponList"])?0:count($TPL_V1["couponList"]);?>
				<li class="info-goods__box">
					<figure class="info-goods__box__thumb">
						<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?>">
					</figure>
					<div class="info-goods__box__info">
						<p class="info-goods__box__title"><?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?></p>
						<p class="info-goods__box__option">
							<span><?php echo $TPL_V1["add_info"]?></span>
<?php if($TPL_V1["set_group"]> 0){?>							<?php if($TPL_setData_2){foreach($TPL_V1["setData"] as $TPL_V2){?>
							<span><?php echo $TPL_V2["options_text"]?> / <em><?php echo $TPL_V1["pcount"]?> quantities</em></span>
<?php }}?>
<?php }else{?>							<span ><?php echo $TPL_V1["options_text"]?> / <em><?php echo $TPL_V1["pcount"]?> quantities</em></span>
<?php }?>

						</p>
						<div class="info-goods__box__price">
<?php if($TPL_V1["total_listprice"]>$TPL_V1["total_dcprice"]){?>
							<span class="info-goods__box__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["total_listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
							<span class="info-goods__box__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["total_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_V1["discount_rate"]){?>
							<span class="info-goods__box__price--discount">[<?php echo $TPL_V1["discount_rate"]?>%]</span>
<?php }?>
						</div>
					</div>
					<div class="coupon-sel__wrap-select">
						<div class="coupon-sel__select">
							<select devCouponSelect="<?php echo $TPL_V1["cart_ix"]?>" class="js__couponpop__select cupon_select">
								<option value="">Coupon Selection</option>
<?php if($TPL_couponList_2){foreach($TPL_V1["couponList"] as $TPL_V2){?>
<?php if($TPL_V2["activeBool"]){?>
								<option value="<?php echo $TPL_V2["regist_ix"]?>"
										devTotalCouponWithDcprice="<?php echo $TPL_V2["total_coupon_with_dcprice"]?>"
										devDiscountAmount="<?php echo $TPL_V2["discount_amount"]?>"
										devCartOverlapUseYn="<?php echo $TPL_V2["overlap_use_yn"]?>"
										devPaymentMethod="<?php echo $TPL_V2["payment_method"]?>"
<?php if($TPL_V2["isSelected"]){?>selected<?php }?>><?php echo $TPL_V2["publish_name"]?></option>
<?php }?>
<?php }}?>
							</select>
							<span devCartOverlapNoText="<?php echo $TPL_V1["cart_ix"]?>" style="color:red;display:none;">Cart coupon is not applicable</span>
						</div>
						<span class="coupon-sel__cancel">취소</span>
					</div>
					<div class="coupon-sel__apply">
						Coupon used amount<span><?php echo $TPL_VAR["fbUnit"]["f"]?><em devTotalCouponWithDcpriceText="<?php echo $TPL_V1["cart_ix"]?>">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
					</div>
				</li>
<?php }}?>
			</ul>
		</div>
	</div>
	<div class="infoinput__toggle infoinput__toggle--hide">
		<h3 class="infoinput__toggle__title">
			&middot; shopping card coupon
			<span class="infoinput__toggle__sub"></span>
			<button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
		</h3>
		<div class="infoinput__toggle__content">
			<div class="coupon-sel__wrap-select">
				<div class="coupon-sel__select">
					<select devCartCouponSelect class="js__couponpop__select">
						<option value="">No Selection</option>
<?php if($TPL_cartCouponList_1){foreach($TPL_VAR["cartCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
						<option value="<?php echo $TPL_V1["regist_ix"]?>"
								devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
								devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
					</select>
				</div>
				<span class="coupon-sel__cancel devCouponCancel">취소</span>
			</div>
		</div>
	</div>
	<div class="coupon-sel__total">
		<dl class="coupon-sel__total__indiv">
			<dt>Item Total :</dt>
			<input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
			<input type="hidden" id="devTotalProductDcprice" value="<?php echo $TPL_VAR["totalProductDcprice"]?>" />
			<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["totalProductDcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
		<dl class="coupon-sel__total__indiv">
			<dt>Coupons-discount :</dt>
			<dd><span id='tot_discount'>-</span><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponDiscountAmount">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
		<dl class="coupon-sel__total__price total-price">
			<input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
			<dt>Total coupon application amount :</dt>
			<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["productDcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
		</dl>
	</div>
	<div class="coupon-sel__btn">
		<button class="coupon-sel__btn__cancel" id="devCouponCancelButton">Cancel</button>
		<button class="coupon-sel__btn__submit" id="devApplyCouponButton">Valid Coupons</button>
	</div>
<?php }?>
</div>