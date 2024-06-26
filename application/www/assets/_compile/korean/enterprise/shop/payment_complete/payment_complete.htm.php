<?php /* Template_ 2.2.8 2024/03/25 16:45:54 /home/barrel-stage/application/www/assets/templet/enterprise/shop/payment_complete/payment_complete.htm 000037901 */ 
$TPL_freeGiftG_1=empty($TPL_VAR["freeGiftG"])||!is_array($TPL_VAR["freeGiftG"])?0:count($TPL_VAR["freeGiftG"]);?>
<!-- 변수 선언 23.06.29-->
<script>
    var emnet_tagm_products=[];
    var criteoList = [];
</script>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<script>
    emnet_tagm_products.push({
        'name': '<?php echo $TPL_V2["pname"]?>',
        'id': '<?php echo $TPL_V2["pid"]?>',
        'price': '<?php echo intval($TPL_V2["pt_dcprice"])?>',
        'quantity': '<?php echo $TPL_V2["pcnt"]?>'
    });
    criteoList.push({
        'id': '<?php echo $TPL_V2["pid"]?>',
        'price': '<?php echo intval($TPL_V2["pt_dcprice"])?>',
        'quantity': '<?php echo $TPL_V2["pcnt"]?>'
    });
</script>
<?php }}?>
<?php }}?>

<!-- 구매 완료 dataLayer -->
<script>
 dataLayer.push({
    'event':'purchase',
    'ecommerce': {
        'purchase': {
            'actionField': {
                'id': '<?php echo $TPL_VAR["order"]["oid"]?>',
                'affiliation': '',
                'revenue': '<?php echo intval($TPL_VAR["paymentData"]["payment_price"])?>'
            },
            'products': emnet_tagm_products
        }
    }
});
</script>

<!-- Criteo 세일즈 태그 23.06.29-->
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 104564},
        { event: "setEmail", email: "", hash_method: "" },
        { event: "setZipcode", zipcode: "" },
        { event: "setSiteType", type: deviceType},
        { event: "trackTransaction", id: '<?php echo $TPL_VAR["order"]["oid"]?>', item: criteoList}
    );
</script>
<!-- END Criteo 세일즈 태그 -->

<!-- 컨텐츠 영역 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="wrap-cart next-step fb__shop fb__payment-complete">
	<div class="fb__shop__title-area">
		<h2 class="fb__shop__title">주문 완료</h2>
		<ul class="fb__shop__step-area">
			<li class="fb__shop__step"><em>01.</em> 장바구니</li>
			<li class="fb__shop__step"><em>02.</em> 주문</li>
			<li class="fb__shop__step fb__shop__step--on"><em>03.</em> 주문 완료</li>
		</ul>
	</div>

	<div class="fb__payment-complete__wrap">
		<section class="fb__payment-complete__msg complete-msg">
			<div class="complete-msg__title">
				<div class="title-lg">주문이 완료되었습니다.</div>
			</div>
			<div class="complete-msg__subtit">
				<p>배럴 공식 홈페이지를 이용해 주셔서 감사합니다.</p>
				<p>주문하신 내역은 <a href="/mypage/" target="_blank">마이페이지 > 주문 내역</a>에서 확인하실 수 있습니다.</p>
			</div>
			<ul class="complete-msg__order-info">
				<li>
					<div class="title-sm">주문번호</div>
					<div class="order-number"><?php echo $TPL_VAR["order"]["oid"]?></div>
				</li>
				<li>
					<div class="title-sm">주문일자</div>
					<div class="order-day"><?php echo $TPL_VAR["order"]["bdatetime"]?></div>
				</li>
			</ul>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 S -->
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?>
			<div class="complete-msg__virtual">
				<div class="complete-msg__virtual-box">
					<dl class="complete-msg__account">
						<dt>입금 정보</dt>
						<dd> <?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?> / 예금주 : 주식회사 배럴</dd>
					</dl>
					<dl class="complete-msg__deadline txt-red">
						<dt>입금 기한</dt>
						<dd><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</dd>
					</dl>
				</div>
				<!-- 안내/경고 메시지 영역(숨김처리함) S -->
				<p class="txt-guide" style="display: none"><!-- 혹여 안내 메시지 사용시 여기다 넣어주세요. --></p>
				<!-- 안내/경고 메시지 영역(숨김처리함) E -->
			</div>
<?php }else{?>
			<div class="complete-msg__virtual">
				<div class="complete-msg__virtual-box">
					<dl class="complete-msg__account">
						<dt>입금 정보</dt>
						<dd><?php echo $TPL_VAR["paymentData"]["memo"]?></dd>
					</dl>
				</div>
			</div>
<?php }?>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 E -->
		</section>

		<!-- 공통 - 상품리스트 S -->
		<section class="fb__infoinput__order-info order-info">
			<div class="fb__infoinput-title">
				<div class="title-md">주문 상품</div>
			</div>
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<input type="hidden" name="cartType" class="cartType" value="set" />
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?></span>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
								<!-- 품절 문구 숨김 S -->
								<div class="product-item__status" style="display: none">판매중지/판매예정/판매종료</div>
								<!-- 품절 문구 숨김 E -->
							</div>
						</dd>
					</dl>
					<!-- 상품 영역 E -->

					<!-- 추가구성상품 영역 S -->
					<!-- 기존 배럴 html 에 있어서 추가했습니다. 일단 숨김처리 해놨습니다.-->
					<div class="add-product" style="display: none">
						<div class="add-product__title">추가구성 상품</div>
						<div class="bg-none"><input type="hidden" class="devCartOptionIx" value="" /></div>
						<div class="td-btn-area add-product__del-area">
							<button class="item-del-btn devAddOptionDeleteButton">삭제</button>
						</div>
						<dl class="product-quantity">
							<dt class="product-quantity__title">수량</dt>
							<dd>
								<div class="product-quantity__control control">
									<ul class="option-up-down">
										<li>
											<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus"></i>DOWN</button>
										</li>
										<li><input type="text" value="1" class="devCount option-text" /></li>
										<li>
											<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus"></i>UP</button>
										</li>
									</ul>
									<!-- 주문 횟수 텍스트 S -->
									<div class="txt-error mat10" style="display: none">주문 가능한 수량은 최대 5개입니다.</div>
									<!-- 주문 횟수 텍스트 E -->
								</div>
							</dd>
						</dl>
						<div class="product-quantity__price">
							<dt>총 상품 금액</dt>
							<dd class="product-item__price-group">
								<div class="product-item__price price"><em>10,000</em>원</div>
								<!-- 품절일 경우 S -->
								<div class="product-item__soldText" style="display: none">일시품절</div>
								<!-- 품절일 경우 E -->
							</dd>
						</div>
					</div>
					<!-- 추가구성상품 영역 E -->

<?php if($TPL_V2["product_gift"]){?>
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
							<li class="product-gift__box inner-gift devGiftList">
<?php if(is_array($TPL_R3=$TPL_V2["product_gift"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<figure class="product-gift__thumb">
									<img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["pname"]?>" data-devpid="<?php echo $TPL_V3["pid"]?>" data-devpcount="<?php echo $TPL_V3["cnt"]?>" />
								</figure>
								<div class="product-gift__info">
									<div class="product-gift__info__pname"><?php echo $TPL_V3["pname"]?></div>
									<div class="product-gift__info__count">
										<span><?php echo $TPL_V3["pcnt"]?>개</span>
									</div>
								</div>
<?php }}?>
							</li>
						</ul>
					</div>
<?php }?>
					<!-- 사은품 영역 E -->
				</li>
<?php }}?>
<?php }}?>

				<!--
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price-percent">30%</div>
									<div class="product-item__price price"><em>10,000</em>원</div>
									<div class="product-item__noprice"><del>1,405,550</del>원</div>
								</div>
							</div>
						</dd>
					</dl>

					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
							<span class="product-gift__not-selected">사은품 선택 안함</span>
						</div>
					</div>
				</li>
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>10,000</em>원</div>
								</div>
							</div>
						</dd>
					</dl>
				</li>
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price-percent">30%</div>
									<div class="product-item__price price"><em>10,000</em>원</div>
									<div class="product-item__noprice"><del>1,405,550</del>원</div>
								</div>
							</div>
						</dd>
					</dl>
				</li>
				-->
			</ul>
		</section>
		<!-- 공통 - 상품리스트 S -->

		<!-- 사은품 S -->
<?php if($TPL_VAR["freeGiftG"]){?>
		<section class="fb__infoinput__gift wrap-gift-area">
			<div class="fb__infoinput-title">
				<div class="title-md">구매금액별 사은품</div>
			</div>
			<div class="gift-list">
				<ul class="product-item__wrap">
					<li class="product-item__list">
						<!-- 상품 영역 S -->
<?php if($TPL_freeGiftG_1){foreach($TPL_VAR["freeGiftG"] as $TPL_V1){
$TPL_gift_products_2=empty($TPL_V1["gift_products"])||!is_array($TPL_V1["gift_products"])?0:count($TPL_V1["gift_products"]);?>
<?php if($TPL_gift_products_2){foreach($TPL_V1["gift_products"] as $TPL_V2){?>
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>" data-devpid="<?php echo $TPL_V2["pid"]?>" data-devpcount="<?php echo $TPL_V2["pcnt"]?>"/>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title"><?php echo $TPL_V2["pname"]?></div>
									<div class="product-item__option">
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>
							</dd>
						</dl>
<?php }}?>
<?php }}?>
						<!-- 상품 영역 E -->
					</li>
				</ul>
			</div>
		</section>
<?php }?>
		<!-- 사은품 E -->

		<section class="fb__payment-complete__delivery-info delivery-info">
			<div class="delivery-info__title">
				<div class="title-md">배송 정보</div>
			</div>
			<div class="delivery-info__box">
				<div class="delivery-info__recipient"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></div>

				<div class="delivery-info__address">
					<p>
						<span class="zip-code"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span>
						<span class="addr1"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span>
						<span class="addr2"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span>
					</p>
					<p class="phone-number"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></p>
				</div>
				<dl class="delivery-info__list">
					<dt class="delivery-info__cate">배송 요청사항</dt>
					<dd class="delivery-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]){?>
						<span>
							<span class="tit"><?php echo $TPL_V1["msg"]?></span>
						</span>
<?php }?>
<?php }}?>
					</dd>
				</dl>
			</div>
		</section>

		<section class="fb__payment-complete__pmt-info pmt-info">
			<div class="pmt-info__title">
				<div class="title-md">결제 정보</div>
			</div>
			<div class="pmt-info__box">
				<dl class="pmt-info__list pmt-info__total">
					<dt class="pmt-info__cate"><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?> 총 결제 예정 금액 <?php }else{?>총 결제 금액<?php }?></dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 S -->
				<div class="pmt-info__virtual" style="display: none">
					<div class="pmt-info__virtual-box">
						<dl class="pmt-info__virtual-account">
							<dt>입금 정보</dt>
							<dd><?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?> / 예금주 : 주식회사 배럴</dd>
						</dl>
						<dl class="pmt-info__deadline txt-red">
							<dt>입금 기한</dt>
							<dd><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</dd>
						</dl>
					</div>
					<!-- 안내/경고 메시지 영역(숨김처리함) S -->
					<p class="txt-guide" style="display: none"><!-- 혹여 안내 메시지 사용시 여기다 넣어주세요. --></p>
					<!-- 안내/경고 메시지 영역(숨김처리함) E -->
				</div>
				<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 E -->

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">결제방법</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["paymentData"]["method_text"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">총 상품금액</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">상품 할인</dt>
					<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<!-- <dl class="pmt-info__list">
					<dt class="pmt-info__cate">등급 할인</dt>
					<dd class="pmt-info__cont">-<span> 405,550</span>원</dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">쿠폰 할인</dt>
					<dd class="pmt-info__cont">-<span> 405,550</span>원</dd>
				</dl> -->

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate"><?php echo $TPL_VAR["mileageName"]?> 사용</dt>
					<dd class="pmt-info__cont">-<?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">총 배송비</dt>
					<dd class="pmt-info__cont delivery">
						<?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

						<!-- <span>3,000원(기본)</span>
						<span>3,000원(도서산간)</span> -->
					</dd>
				</dl>

				<dl class="pmt-info__list pmt-info__benefits">
					<dt class="pmt-info__cate">적립 혜택</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentData"]["total_reserve"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?> 적립</dd>
				</dl>
			</div>
		</section>

		<div class="fb__payment-complete__btn-area btn-area">
			<a href="/" class="btn-lg btn-dark btn-area__go-home">홈으로</a>
			<!--<a href="/mypage/orderHistory" class="btn-lg btn-dark-line">주문내역조회</a>
			<a href="/member/login" class="btn-lg btn-dark-line">주문내역조회</a>-->
		</div>
	</div>
</section>
<?php }else{?>
<section class="wrap-cart next-step fb__shop fb__payment-complete">
	<div class="fb__shop__title-area">
		<h2 class="fb__shop__title">주문 완료</h2>
		<ul class="fb__shop__step-area">
			<li class="fb__shop__step"><em>01.</em> 장바구니</li>
			<li class="fb__shop__step"><em>02.</em> 주문</li>
			<li class="fb__shop__step fb__shop__step--on"><em>03.</em> 주문 완료</li>
		</ul>
	</div>

	<div class="fb__payment-complete__wrap">
		<section class="fb__payment-complete__msg complete-msg">
			<div class="complete-msg__title">
				<div class="title-lg">주문이 완료되었습니다.</div>
			</div>
			<div class="complete-msg__subtit">
				<p>배럴 공식 홈페이지를 이용해 주셔서 감사합니다.</p>
				<p>주문하신 내역은 <a href="/mypage/" target="_blank">마이페이지 > 주문 내역</a>에서 확인하실 수 있습니다.</p>
			</div>
			<ul class="complete-msg__order-info">
				<li>
					<div class="title-sm">주문번호</div>
					<div class="order-number"><?php echo $TPL_VAR["order"]["oid"]?></div>
				</li>
				<li>
					<div class="title-sm">주문일자</div>
					<div class="order-day"><?php echo $TPL_VAR["order"]["bdatetime"]?></div>
				</li>
			</ul>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 S -->
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?>
			<div class="complete-msg__virtual">
				<div class="complete-msg__virtual-box">
					<dl class="complete-msg__account">
						<dt>입금 정보</dt>
						<dd> <?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?> / 예금주 : 주식회사 배럴</dd>
					</dl>
					<dl class="complete-msg__deadline txt-red">
						<dt>입금 기한</dt>
						<dd><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</dd>
					</dl>
				</div>
				<!-- 안내/경고 메시지 영역(숨김처리함) S -->
				<p class="txt-guide" style="display: none"><!-- 혹여 안내 메시지 사용시 여기다 넣어주세요. --></p>
				<!-- 안내/경고 메시지 영역(숨김처리함) E -->
			</div>
<?php }else{?>
			<div class="complete-msg__virtual">
				<div class="complete-msg__virtual-box">
					<dl class="complete-msg__account">
						<dt>입금 정보</dt>
						<dd><?php echo $TPL_VAR["paymentData"]["memo"]?></dd>
					</dl>
				</div>
			</div>
<?php }?>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 E -->
		</section>

		<!-- 공통 - 상품리스트 S -->
		<section class="fb__infoinput__order-info order-info">
			<div class="fb__infoinput-title">
				<div class="title-md">주문 상품</div>
			</div>
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<li class="product-item__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<input type="hidden" name="cartType" class="cartType" value="set" />
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span>95</span>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
								<!-- 품절 문구 숨김 S -->
								<div class="product-item__status" style="display: none">판매중지/판매예정/판매종료</div>
								<!-- 품절 문구 숨김 E -->
							</div>
						</dd>
					</dl>
					<!-- 상품 영역 E -->

					<!-- 추가구성상품 영역 S -->
					<!-- 기존 배럴 html 에 있어서 추가했습니다. 일단 숨김처리 해놨습니다.-->
					<div class="add-product" style="display: none">
						<div class="add-product__title">추가구성 상품</div>
						<div class="bg-none"><input type="hidden" class="devCartOptionIx" value="" /></div>
						<div class="td-btn-area add-product__del-area">
							<button class="item-del-btn devAddOptionDeleteButton">삭제</button>
						</div>
						<dl class="product-quantity">
							<dt class="product-quantity__title">수량</dt>
							<dd>
								<div class="product-quantity__control control">
									<ul class="option-up-down">
										<li>
											<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus"></i>DOWN</button>
										</li>
										<li><input type="text" value="1" class="devCount option-text" /></li>
										<li>
											<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus"></i>UP</button>
										</li>
									</ul>
									<!-- 주문 횟수 텍스트 S -->
									<div class="txt-error mat10" style="display: none">주문 가능한 수량은 최대 5개입니다.</div>
									<!-- 주문 횟수 텍스트 E -->
								</div>
							</dd>
						</dl>
						<div class="product-quantity__price">
							<dt>총 상품 금액</dt>
							<dd class="product-item__price-group">
								<div class="product-item__price price"><em>10,000</em>원</div>
								<!-- 품절일 경우 S -->
								<div class="product-item__soldText" style="display: none">일시품절</div>
								<!-- 품절일 경우 E -->
							</dd>
						</div>
					</div>
					<!-- 추가구성상품 영역 E -->

					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
							<li class="product-gift__box inner-gift devGiftList">
								<figure class="product-gift__thumb">
									<img src="<?php echo $TPL_VAR["product_gift"]["image_src"]?>" alt="<?php echo $TPL_VAR["product_gift"]["pname"]?>" data-devpid="<?php echo $TPL_VAR["giftItem"]["pid"]?>" data-devpcount="<?php echo $TPL_VAR["giftItem"]["cnt"]?>" />
								</figure>
								<div class="product-gift__info">
									<div class="product-gift__info__pname"><span>[사은품]</span> <?php echo $TPL_VAR["product_gift"]["pname"]?></div>
									<div class="product-gift__info__count">
										<span><?php echo $TPL_VAR["product_gift"]["pcnt"]?>개</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- 사은품 영역 E -->
<?php }}?>
				</li>
<?php }}?>

				<!--
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price-percent">30%</div>
									<div class="product-item__price price"><em>10,000</em>원</div>
									<div class="product-item__noprice"><del>1,405,550</del>원</div>
								</div>
							</div>
						</dd>
					</dl>

					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
							<span class="product-gift__not-selected">사은품 선택 안함</span>
						</div>
					</div>
				</li>
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>10,000</em>원</div>
								</div>
							</div>
						</dd>
					</dl>
				</li>
				<li class="product-item__list">
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<input type="hidden" name="cartType" class="cartType" value="set" />
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price-percent">30%</div>
									<div class="product-item__price price"><em>10,000</em>원</div>
									<div class="product-item__noprice"><del>1,405,550</del>원</div>
								</div>
							</div>
						</dd>
					</dl>
				</li>
				-->
			</ul>
		</section>
		<!-- 공통 - 상품리스트 S -->

		<!-- 사은품 S -->
		<section class="fb__infoinput__gift wrap-gift-area">
			<div class="fb__infoinput-title">
				<div class="title-md">구매금액별 사은품</div>
			</div>
			<div class="gift-list">
				<ul class="product-item__wrap">
					<li class="product-item__list">
						<!-- 상품 영역 S -->
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title">[사은품] 키즈 데이지 튜브</div>
									<div class="product-item__option">
										<span>페일네온옐로우</span>
									</div>
								</div>
							</dd>
						</dl>
						<!-- 상품 영역 E -->
					</li>
				</ul>
			</div>
		</section>
		<!-- 사은품 E -->

		<section class="fb__payment-complete__delivery-info delivery-info">
			<div class="delivery-info__title">
				<div class="title-md">배송 정보</div>
			</div>
			<div class="delivery-info__box">
				<div class="delivery-info__recipient"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></div>

				<div class="delivery-info__address">
					<p>
						<span class="zip-code"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span>
						<span class="addr1"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span>
						<span class="addr2"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span>
					</p>
					<p class="phone-number"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></p>
				</div>
				<dl class="delivery-info__list">
					<dt class="delivery-info__cate">배송 요청사항</dt>
					<dd class="delivery-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]){?>
						<span>
							<span class="tit"><?php echo $TPL_V1["pname"]?></span>
							<?php echo $TPL_V1["msg"]?>

						</span>
<?php }?>
<?php }}?>
					</dd>
				</dl>
			</div>
		</section>

		<section class="fb__payment-complete__pmt-info pmt-info">
			<div class="pmt-info__title">
				<div class="title-md">결제 정보</div>
			</div>
			<div class="pmt-info__box">
				<dl class="pmt-info__list pmt-info__total">
					<dt class="pmt-info__cate"><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?> 총 결제 예정 금액 <?php }else{?>총 결제 금액<?php }?></dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 S -->
				<div class="pmt-info__virtual" style="display: none">
					<div class="pmt-info__virtual-box">
						<dl class="pmt-info__virtual-account">
							<dt>입금 정보</dt>
							<dd><?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?> / 예금주 : 주식회사 배럴</dd>
						</dl>
						<dl class="pmt-info__deadline txt-red">
							<dt>입금 기한</dt>
							<dd><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</dd>
						</dl>
					</div>
					<!-- 안내/경고 메시지 영역(숨김처리함) S -->
					<p class="txt-guide" style="display: none"><!-- 혹여 안내 메시지 사용시 여기다 넣어주세요. --></p>
					<!-- 안내/경고 메시지 영역(숨김처리함) E -->
				</div>
				<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 E -->

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">결제방법</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["paymentData"]["method_text"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">총 상품금액</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">상품 할인</dt>
					<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<!-- <dl class="pmt-info__list">
					<dt class="pmt-info__cate">등급 할인</dt>
					<dd class="pmt-info__cont">-<span> 405,550</span>원</dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">쿠폰 할인</dt>
					<dd class="pmt-info__cont">-<span> 405,550</span>원</dd>
				</dl> -->

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate"><?php echo $TPL_VAR["mileageName"]?> 사용</dt>
					<dd class="pmt-info__cont">-<?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<dl class="pmt-info__list">
					<dt class="pmt-info__cate">총 배송비</dt>
					<dd class="pmt-info__cont delivery">
						<?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

						<!-- <span>3,000원(기본)</span>
						<span>3,000원(도서산간)</span> -->
					</dd>
				</dl>

				<dl class="pmt-info__list pmt-info__benefits">
					<dt class="pmt-info__cate">적립 혜택</dt>
					<dd class="pmt-info__cont"><span>123,000</span>원 적립</dd>
				</dl>
			</div>
		</section>

		<div class="fb__payment-complete__btn-area btn-area">
			<a href="/" class="btn-lg btn-dark btn-area__go-home">홈으로</a>
			<!--<a href="/mypage/orderHistory" class="btn-lg btn-dark-line">주문내역조회</a>
			<a href="/member/login" class="btn-lg btn-dark-line">주문내역조회</a>-->
		</div>
	</div>
</section>
<?php }?>
<?php echo $TPL_VAR["payMentScript"]?>

<?php echo $TPL_VAR["mobionScript"]?>

<!-- 컨텐츠 영역 E -->