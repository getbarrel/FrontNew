<?php /* Template_ 2.2.8 2024/02/15 16:04:13 /home/barrel-stage/application/www/assets/templet/enterprise/popup/change_option/change_option.htm 000004706 */ ?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>
<section class="popup-content__wrap">
	<div class="fb__change-option devProductContents">
		<div class="fb__change-option__cont">
			<ul class="fb__change-option__list">
				<li class="fb__change-option__item" id="devSildeMinicartArea">
					<div class="popup-product">
						<div class="popup-product__left">
							<figure class="popup-product__thumb">
								<img src="<?php echo $TPL_VAR["thumb_src"]?>" alt="" />
							</figure>
						</div>
						<div class="popup-product__info goods-info" data-pid="<?php echo $TPL_VAR["pid"]?>" data-cart_ix="<?php echo $TPL_VAR["cartIx"]?>" data-pcount="<?php echo $TPL_VAR["pcount"]?>">
							<div class="goods-info__title"><?php echo $TPL_VAR["pname"]?></div>
<?php if($TPL_VAR["cartOptionp"]["options_text"]==''){?>
							<input type="hidden" name="cartType" class="cartType" value="set" />
<?php if(is_array($TPL_R1=$TPL_VAR["cartOptionp"]["setData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<dl class="goods-info__option">
									<dt><?php echo $TPL_V1["name"]?> : </dt>
									<dd>
										<span><?php echo $TPL_V1["option"]?></span>
										<span><?php echo $TPL_V1["pcount"]?></span>
									</dd>
								</dl>
<?php }}?>
<?php }else{?>
								<dl class="goods-info__option">
									<dt><?php echo $TPL_VAR["cartOptionp"]["add_info"]?> / </dt>
									<dd>
										<span><?php echo str_replace("사이즈:","",$TPL_VAR["cartOptionp"]["options_text"])?></span>
										<span><?php echo $TPL_VAR["cartOptionp"]["pcount"]?></span>
									</dd>
								</dl>
<?php }?>
							<dl class="goods-info__option"id="devSildeLonelyOptionName"></dl>
							<dl class="goods-info__price-group">
<?php if($TPL_VAR["discount_rate"]> 0){?><dt class="goods-info__price-percent"><?php echo $TPL_VAR["discount_rate"]?>%</dt><?php }?>
								<dd>
<?php if($TPL_VAR["discount_rate"]> 0){?><div class="goods-info__price-regular"><?php echo $TPL_VAR["fbUnit"]["f"]?><del><?php echo g_price($TPL_VAR["listprice"])?></del><?php echo $TPL_VAR["fbUnit"]["b"]?></div><?php }?>
									<div class="goods-info__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
									<input type="hidden" id="dcprice" value="<?php echo $TPL_VAR["dcprice"]?>">
								</dd>
							</dl>
						</div>
					</div>
					<div class="popup-product__select goods-info__select" id="devSildeMinicartOptions" data-oprionCode="<?php echo $TPL_VAR["dOpt"]?>"></div>

					<dl class="popup-product__quantity product-quantity">
						<dt class="product-quantity__title">수량</dt>
						<dd>
							<div class="product-quantity__control control devAddOptionContents">
								<ul class="option-up-down">
									<li>
										<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus"></i>DOWN</button>
									</li>
									<li><input type="text" value="<?php echo $TPL_VAR["cartOptionp"]["pcount"]?>" class="devCount option-text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/></li>
									<li>
										<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus"></i>UP</button>
									</li>
									<input type="hidden" value="<?php echo $TPL_VAR["cartIx"]?>" class="cart_ix">
								</ul>
								<!-- 주문 횟수 텍스트 S -->
								<div class="txt-error mat10" style="display: none">주문 가능한 수량은 최대 5개입니다.</div>
								<!-- 주문 횟수 텍스트 E -->
							</div>
						</dd>
					</dl>
					<div class="popup-product__quantity-price product-quantity__price">
						<dt>총 상품 금액</dt>
						<dd class="product-item__price-group">
							<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="total_dcprice"><?php echo g_price($TPL_VAR["cartOptionp"]["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
							<!-- 품절일 경우 S -->
							<div class="product-item__soldText" style="display: none">일시품절</div>
							<!-- 품절일 경우 E -->
						</dd>
					</div>
				</li>
			</ul>
		</div>
		<div class="fb__change-option__btn">
			<button type="button" class="btn-lg btn-dark-line fb__change-option__btn--submit devCountUpdateButton">변경하기</button>
		</div>
	</div>
</section>