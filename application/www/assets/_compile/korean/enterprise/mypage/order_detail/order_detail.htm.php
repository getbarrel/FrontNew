<?php /* Template_ 2.2.8 2024/03/22 16:40:37 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_detail/order_detail.htm 000031382 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
<script>var orderDetailMode = 'member';</script>
<?php }else{?>
<script>var orderDetailMode = 'guest';</script>
<?php }?>
<!-- 컨텐츠 S -->
<section class="fb__od-detail wrap-mypage wrap-order-detail fb__mypage-detail" id="devOrderDetailContent">
	<div class="fb__mypage-title">
		<div class="title-md">주문 상세 내역</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 S -->
	<div class="order-number-box">
		<div class="order-number-box__cont">
			<dl class="order-number-box__item">
				<dt class="order-title">주문번호</dt>
				<dd class="order-number"><?php echo $TPL_VAR["order"]["oid"]?></dd>
			</dl>
			<dl class="order-number-box__item">
				<dt class="order-title">주문일자</dt>
				<dd class="order-day"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
			</dl>
		</div>
		<div class="order-number-box__btn">
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
			<button type="button" class="btn-default btn-dark-line devOrderCancelAllBtn"  data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">전체 취소</button>
<?php }?>

<?php if($TPL_VAR["langType"]=='korean'&&$TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["order"]["status"]!='IB'&&$TPL_VAR["order"]["status"]!='CA'&&$TPL_VAR["order"]["status"]!='CC'){?>
			<br><button class="fb__mypage__btn--black receipt-btn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">결제영수증 출력</button>
<?php }?>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="fb__mypage__section">
		<div class="fb__mypage-title">
			<div class="title-sm">주문 내역</div>
		</div>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-order">
			<ul class="product-item__wrap">
				<li class="product-item__list">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
<?php if($TPL_V2["set_group"]> 0){?>
<?php if(is_array($TPL_R3=$TPL_V2["setData"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3== 0){?>
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V3["option_text"]?></span>
										<span><?php echo $TPL_V3["add_info"]?></span>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">
                                    <p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>								
								</div>
								<!-- <div class="btn-group">
									<button type="button" class="btn-default btn-dark-line">주문 취소</button>
								</div> -->
							</div>
						</dd>
					</dl>
<?php }else{?>
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V3["option_text"]?></span>
										<span><?php echo $TPL_V3["add_info"]?></span>
										<span><?php echo $TPL_V3["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status"></div>
								<div class="btn-group"></div>
							</div>
						</dd>
					</dl>
<?php }?>
<?php }}?>
<?php }else{?>
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?>
										<span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">
									<p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
								</div>
								<!-- <div class="btn-group">
									<button type="button" class="btn-default btn-dark-line">주문 취소</button>
								</div> -->
							</div>
						</dd>
					</dl>
<?php }?>
					<!-- 상품 E -->

<?php if($TPL_V2["product_gift"]){?>
					<!-- 사은품 영역 S -->
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
							<li class="product-gift__box inner-gift devGiftList" id="devPgItem">
								<figure class="product-gift__thumb">
									<img src="<?php echo $TPL_V3["image_src"]?>" alt="" />
								</figure>
								<div class="product-gift__info">
									<div class="product-gift__info__pname"><?php echo $TPL_V3["pname"]?></div>
									<div class="product-gift__info__count">
										<span>1개</span>
									</div>
								</div>
							</li>
<?php }}?>
						</ul>
					</div>
					<!-- 사은품 영역 E -->
<?php }?>
<?php }}?>
				</li>
				<!--
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">결제완료</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-dark-line">주문 취소</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">결제완료</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-dark-line">주문 취소</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span>미드나잇</span>
										<span>95</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">배송준비중</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">배송중</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-gray-line">배송조회</button>
									<button type="button" class="btn-default btn-dark-line">배송완료</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">배송완료</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-gray-line">배송조회</button>
									<button type="button" class="btn-default btn-gray-line">반품신청</button>
									<button type="button" class="btn-default btn-dark-line">구매확정</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">구매확정</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-gray-line">배송조회</button>
									<button type="button" class="btn-default btn-dark-line">리뷰쓰기</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				<li class="product-item__list">
					-- 상품 S --
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span class="set-name">유니섹스 트랙 셋업 자켓</span>
										<span>블랙+M</span>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em>1,265,550</em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">구매확정</div>
								<div class="btn-group">
									<button type="button" class="btn-default btn-gray-line">내가 쓴 리뷰 보기</button>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --
				</li>
				-->
			</ul>
		</div>
<?php }}?>
	</section>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
	<section class="fb__mypage__section gift-wrap">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo trans($TPL_V1["freegift_condition_text"])?></div>
		</div>
		<div class="gift-list">
			<ul class="product-item__wrap">
				<li class="product-item__list">
					<!-- 상품 영역 S -->
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
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
					<!-- 상품 영역 E -->
				</li>
			</ul>
		</div>
	</section>
<?php }?>
<?php }}?>
<?php }?>

	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm">
				배송 정보
<?php if($TPL_VAR["order"]["deliveryChange"]> 0){?>
				<button class="fb__mypage__btn--lightgray float-r address-link" id="devDeliveryChangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" style="display:none;">배송지변경</button>
<?php }?>
			</div>
		</div>
		<div class="delivery-info__box">
			<div class="delivery-info__recipient"><span id="devRnameTxt"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></span></div>
			<div class="delivery-info__address">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<p>
					<span class="zip-code" id="devZipTxt"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span>
					<span class="addr1" id="devAddr1Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span>
					<span class="addr2" id="devAddr2Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span>
				</p>
				<p class="phone-number"><span id="devRmobileTxt"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></span></p>
<?php if($TPL_VAR["deliveryInfo"]["rtel"]!='--'){?>
				<p class="phone-number"><span id="devRtelTxt"><?php echo $TPL_VAR["deliveryInfo"]["rtel"]?></span></p>
<?php }?>
<?php }else{?>
				<p>
					<span class="zip-code" id=""><?php echo $TPL_VAR["deliveryInfo"]["country_full"]?></span>
					<span class="zip-code" id="devZipTxt"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span>
					<span class="addr1" id="devAddr1Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span>
					<span class="addr2" id="devAddr2Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span>
					<span class="addr2" id=""><?php echo $TPL_VAR["deliveryInfo"]["city"]?></span>
					<span class="addr2" id=""><?php echo $TPL_VAR["deliveryInfo"]["state"]?></span>
				</p>
<?php }?>
			</div>
			<dl class="delivery-info__list">
				<dt class="delivery-info__cate">배송 요청사항</dt>
				<dd class="delivery-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
                    <div <?php if($TPL_I1> 0&&$TPL_VAR["deliveryInfo"]["pcnt"]> 5){?>class="section devDeliveryMsgBox" style="display:none"<?php }else{?>class="section"<?php }?>>
<?php if($TPL_VAR["deliveryInfo"]["pcnt"]> 1){?><p class="product"><?php if($TPL_V1["brand_name"]){?>[<?php echo $TPL_V1["brand_name"]?>]<?php }?><?php echo $TPL_V1["pname"]?></p><?php }?>
                        <p id="devDeliveryMsgText<?php echo $TPL_V1["msg_ix"]?>"><?php echo $TPL_V1["msg"]?></p>
<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_READY||$TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <!-- <div class="mat10">
                            <input type="text" class="devDeliveryMsgInputBox" id="devDeliveryMsg<?php echo $TPL_V1["msg_ix"]?>" maxlength="60" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" />
<?php if(false){?>
                            <button class="btn-default btn-dark-line devDeliveryMsgModifyBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>">요청사항 변경</button>
<?php }?>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error">요청사항을 입력하세요.</em>
                                <span><em id="devMsgLength<?php echo $TPL_V1["msg_ix"]?>">0</em>/30 자</span>
                            </div>
                        </div> -->
<?php }else{?>
                        <!-- <div class="mat10">
                            <input type="text" class="devDeliveryMsgInputBox" id="devDeliveryMsg<?php echo $TPL_V1["msg_ix"]?>" maxlength="60" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" />
<?php if(false){?>
                            <button class="btn-default btn-dark-line devDeliveryMsgModifyBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>">요청사항 변경</button>
<?php }?>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error">요청사항을 입력하세요.</em>
                                <span><em id="devMsgLength<?php echo $TPL_V1["msg_ix"]?>">0</em>/60 byte</span>
                            </div>
                        </div> -->
<?php }?>

<?php }?>
                    </div>
<?php if($TPL_VAR["deliveryInfo"]["msg_type"]=='P'&&$TPL_VAR["deliveryInfo"]["pcnt"]> 5&&$TPL_I1== 0){?>
                    <div class="section more-btn toggle" id="devDeliveryMsgMoreBtn">
                        <span>더보기</span>
                    </div>
<?php }?>
<?php }}?>
				</dd>
			</dl>
		</div>
	</section>


	<section class="fb__mypage__section pmt-info">
		<div class="fb__mypage-title">
			<div class="title-sm">결제 정보</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">
<?php if($TPL_VAR["order"]["status"]=='IR'){?>
					총 결제 예정 금액
<?php }else{?>
					총 결제 금액
<?php }?>				
				</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["payment"][ 0]["payment_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 S -->
			<div class="pmt-info__virtual">
				<div class="pmt-info__virtual-box">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php switch($TPL_V1["method"]){case ORDER_METHOD_BANK:case ORDER_METHOD_VBANK:case ORDER_METHOD_ICHE:case ORDER_METHOD_ASCROW:?>
					<dl class="pmt-info__virtual-account">
						<dt><?php echo $TPL_V1["method_text"]?></dt>
						<dd><?php echo $TPL_V1["bank"]?> / 계좌번호 : <?php echo $TPL_V1["bank_account_num"]?> / 예금주 : <?php echo $TPL_V1["bank_input_name"]?></dd>
					</dl>
					<dl class="pmt-info__deadline txt-red">
						<dt>입금 기한</dt>
						<dd><?php echo date('Y-m-d',strtotime($TPL_V1["bank_input_date"]))?></dd>
					</dl>
<?php break;default:?>
					<dl class="pmt-info__virtual-account">
						<dt><?php echo $TPL_V1["method_text"]?></dt>
						<dd><?php echo $TPL_V1["memo"]?></dd>
					</dl>
<?php }?>
<?php }}?>
					<dl class="pmt-info__virtual-account">
						<dt>적립금 적립</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?> <?php echo g_price($TPL_VAR["paymentInfo"]["total_reserve"])?> <?php echo $TPL_VAR["fbUnit"]["b"]?>적립(상품 구매 시)</dd>
					</dl>
				</div>
				<!-- 안내/경고 메시지 영역(숨김처리함) S -->
				<p class="txt-guide" style="display: none"><!-- 혹여 안내 메시지 사용시 여기다 넣어주세요. --></p>
				<!-- 안내/경고 메시지 영역(숨김처리함) E -->
			</div>
			<!-- 가상계좌 결제시 노출 / 숨김처리 되어 있음 E -->
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제방법</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_V1["method_text"]?></dd>
				<!-- <dd class="pmt-info__cont"><?php echo $TPL_V1["method_text"]?> / <?php echo $TPL_V1["memo"]?></dd> -->
			</dl>
<?php }}?>	
			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">총 상품금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">총 할인금액</dt>
				<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">자동할인</dt>
				<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">등급 할인</dt>
				<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["mg_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">쿠폰 할인</dt>
				<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["cp_dc"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">적립금 사용</dt>
				<dd class="pmt-info__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">총 배송비</dt>
				<dd class="pmt-info__cont delivery"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>
		</div>
		<div class="fb__mypage__section-btn">
<?php if($TPL_VAR["langType"]=='korean'&&$TPL_VAR["order"]["status"]!='IR'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["method"]==ORDER_METHOD_CARD){?>
<?php if($TPL_V1["tid"]){?>
					<button type="button" class="btn-s btn-dark-line float-r devCardInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">신용카드 전표</button>
<?php }?>
<?php }else{?>
					<button type="button" class="btn-default btn-dark-line receipt-btn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">영수증 보기</button>
<?php }?>
<?php }}?>
<?php }?>
		</div>
	</section>

	<!--취소완료 S -->
<?php if($TPL_VAR["claimData"]["cancelData"]){?>
	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품신청 환불내역</div>
		</div>
		<div class="pmt-info__box">
			<div class="delivery-info__recipient"><span id="devRnameTxt"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></span></div>
<?php if(is_array($TPL_R1=$TPL_VAR["claimData"]["cancelData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>

			<dl class="pmt-info__list">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<dt class="pmt-info__cate"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>]<?php }?>  <?php echo $TPL_V2["pname"]?></dt>
<?php }}?>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["totReturnPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				<dd class="pmt-info__cont"><?php echo $TPL_V1["refundDate"]?></dd>
				
			</dl>
<?php }}?>
		</div>
	</section>
<?php }?>
	<!--취소완료 E -->

	<!--반품완료 S -->
<?php if($TPL_VAR["claimMergedData"]["returnData"]){?> 
	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품신청 환불내역</div>
		</div>
		<div class="pmt-info__box">
			<div class="delivery-info__recipient"><span id="devRnameTxt"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></span></div>
<?php if(is_array($TPL_R1=$TPL_VAR["claimMergedData"]["returnData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<dl class="pmt-info__list">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<dt class="pmt-info__cate"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>]<?php }?>  <?php echo $TPL_V2["pname"]?></dt>
<?php }}?>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["totReturnPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				<dd class="pmt-info__cont"><?php echo $TPL_V1["refundDate"]?></dd>
				
			</dl>
<?php }}?>
		</div>
	</section>
<?php }?>
	<!--반품완료-- E -->

</section>
<!-- 컨텐츠 E -->