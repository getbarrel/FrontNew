<?php /* Template_ 2.2.8 2024/03/26 16:19:03 /home/barrel-stage/application/www/assets/templet/enterprise/shop/coupon_pop/coupon_pop.htm 000008104 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$TPL_cartCouponList_1=empty($TPL_VAR["cartCouponList"])||!is_array($TPL_VAR["cartCouponList"])?0:count($TPL_VAR["cartCouponList"]);
$TPL_deliveryCouponList_1=empty($TPL_VAR["deliveryCouponList"])||!is_array($TPL_VAR["deliveryCouponList"])?0:count($TPL_VAR["deliveryCouponList"]);?>
<div id="devModalContent" class="popup-content">
	<section class="popup-content__wrap scrollVH">
		<div class="fb__coupon-popup">
			<div class="fb__coupon-popup__cont">
<?php if($TPL_VAR["list"]){?>
				<div class="fb__coupon-popup__title">
					<div class="title-sm">상품 쿠폰</div>
				</div>
<?php }?>
				<ul class="fb__coupon-popup__list" <?php if($TPL_VAR["list"]){?><?php }else{?>style="border-top:0px;"<?php }?>>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_couponList_2=empty($TPL_V1["couponList"])||!is_array($TPL_V1["couponList"])?0:count($TPL_V1["couponList"]);?>
					<li class="fb__coupon-popup__item">
						<div class="popup-product">
							<div class="popup-product__left">
								<figure class="popup-product__thumb">
									<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?>">
								</figure>
							</div>
							<div class="popup-product__info goods-info">
								<div class="goods-info__title"><?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?></div>
<?php if($TPL_V1["set_group"]> 0){?>
								<!-- 세트 상품 S -->
								<input type="hidden" name="cartType" class="cartType" value="set" />
								<dl class="goods-info__option">
									<!--<dt><?php echo $TPL_VAR["setData"]["options_text"]?></dt>-->
									<dd>
										<span><?php echo str_replace("사이즈:","",$TPL_VAR["setData"]["options_text"])?></span>
<?php if(!empty($TPL_V1["add_info"])){?>
										<span><?php echo $TPL_V1["add_info"]?></span>
<?php }?>
										<span><?php echo $TPL_V1["pcount"]?>개</span>
									</dd>
								</dl>
								<!-- 세트 상품 E -->
<?php }else{?>
								<dl class="goods-info__option">
									<!--<dt><?php echo $TPL_V1["options_text"]?></dt>-->
									<dd>
										<span><?php echo str_replace("사이즈:","",$TPL_V1["options_text"])?></span>
<?php if(!empty($TPL_V1["add_info"])){?>
										<span><?php echo $TPL_V1["add_info"]?></span>
<?php }?>
										<span><?php echo $TPL_V1["pcount"]?>개</span>
									</dd>
								</dl>
<?php }?>
								<dl class="goods-info__price-group">
									<dt class="goods-info__price" style="width:150px;"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["total_dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dt>
									<dd>
										<div class="goods-info__price-percent"><?php echo $TPL_VAR["fbUnit"]["f"]?><span devDiscountAmountText="<?php echo $TPL_V1["cart_ix"]?>">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?> 할인</div>
									</dd>
								</dl>
							</div>
						</div>
						<div class="popup-product__select goods-info__select">
							<div class="goods-info__set__box">
								<select devCouponSelect="<?php echo $TPL_V1["cart_ix"]?>" class="fb__form-select">
									<option value="">쿠폰선택</option>
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
							</div>
						</div>
					</li>
<?php }}?>
<?php if($TPL_VAR["cartCouponList"]){?>
					<li class="fb__coupon-popup__item">
						<div class="popup-product__title">
							<div class="title-sm">장바구니 쿠폰</div>
							<div class="popup-product__discount"><span devCartDiscountAmountText>0</span>원 할인</div>
						</div>
						<div class="popup-product__select goods-info__select">
							<div class="goods-info__set__box">
								<select devCartCouponSelect class="fb__form-select">
									<option value="">선택안함</option>
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
						</div>
					</li>
<?php }?>
<?php if($TPL_VAR["couponDiv"]=='D'){?>
					<li class="fb__coupon-popup__item">
						<div class="popup-product__title">
							<div class="title-sm">배송비 쿠폰</div>
							<!--<div class="popup-product__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponDiscountAmount">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?> 할인</div>-->
						</div>
						<div class="popup-product__select goods-info__select">
							<div class="goods-info__set__box">
								<select devDeliveryCouponSelect>
									<option value="">선택</option>
<?php if($TPL_deliveryCouponList_1){foreach($TPL_VAR["deliveryCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
									<option value="<?php echo $TPL_V1["regist_ix"]?>"
											devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
											devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
								</select>
							</div>
						</div>
					</li>
					<li class="fb__coupon-popup__item">
						<dl class="popup-product__total">
							<input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
							<input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["totalDeliveryPrice"]?>" />
							<input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
							<dt>총 쿠폰 할인 금액</dt>
							<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponDiscountAmount">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
						</dl>
					</li>
<?php }else{?>
					<li class="fb__coupon-popup__item">
						<dl class="popup-product__total">
							<input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
							<input type="hidden" id="devTotalProductDcprice" value="<?php echo $TPL_VAR["totalProductDcprice"]?>" />
							<input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
							<dt>총 쿠폰 할인 금액</dt>
							<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["productDcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
						</dl>
					</li>
<?php }?>
				</ul>
			</div>
		</div>
	</section>
	<div class="popup-content__footer">
<?php if($TPL_VAR["couponDiv"]=='D'){?>
			<button type="button" class="btn-lg btn-dark-line btn-close" id="devCouponCancelButton">취소</button>
			<button type="button" class="btn-lg btn-dark fb__change-option__btn--submit" id="devApplyDeliveryCouponButton">쿠폰적용</button>
<?php }else{?>
			<button type="button" class="btn-lg btn-dark-line btn-close" id="devCouponCancelButton">취소</button>
			<button type="button" class="btn-lg btn-dark fb__change-option__btn--submit" id="devApplyCouponButton">쿠폰적용</button>
<?php }?>

	</div>
</div>