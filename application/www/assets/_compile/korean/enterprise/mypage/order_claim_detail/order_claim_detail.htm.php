<?php /* Template_ 2.2.8 2024/03/06 13:56:52 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim_detail/order_claim_detail.htm 000022684 */ 
$TPL_deny_1=empty($TPL_VAR["deny"])||!is_array($TPL_VAR["deny"])?0:count($TPL_VAR["deny"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<!-- 컨텐츠 S -->
<section class="fb__return-history wrap-mypage wrap-order-detail">
	<div class="fb__mypage-title">
		<div class="title-md"><?php echo $TPL_VAR["claimTypeName"]?> 신청 내역</div>
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
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="fb__mypage__section cancel-area">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
		</div>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
				<li class="product-item__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
					<!-- 상품 S -->
<?php if($TPL_V2["set_group"]> 0){?>
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
										<span class="set-name"<?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?>
										<span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">
									<?php echo $TPL_V2["status_text"]?>

<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
								</div>
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
										<span class="set-name"<?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?>
										<span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">
									<?php echo $TPL_V2["status_text"]?>

<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
								</div>
							</div>
						</dd>
					</dl>
<?php }?>
<?php if($TPL_V2["product_gift"]){?>
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
							<li class="product-gift__box inner-gift devGiftList"  id="devPgItem">
								<figure class="product-gift__thumb">
									<img src="<?php echo $TPL_V3["image_src"]?>" alt="" />
								</figure>
								<div class="product-gift__info">
									<div class="product-gift__info__pname"><span>[사은품]</span><?php echo $TPL_V3["pname"]?></div>
									<div class="product-gift__info__count">
										<span>1{=trans('개')</span>
									</div>
								</div>
							</li>
<?php }}?>
						</ul>
					</div>
<?php }?>
<?php }}?>
					<!-- 상품 E -->

					<!-- 반품 사유 영역 S -->
					<div class="claim__list__reason reason-box">
						<!-- <div class="reason-top">
							<div class="title-sm">반품 수량</div>
							<div class="cancel-quantity"><em>1</em>개</div>
						</div> -->
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
								<div class="reason-box__text"><?php echo $TPL_VAR["reason"]["type_text"]?></div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc"><?php echo $TPL_VAR["reason"]["detail_text"]?></div>
							</div>
						</dl>
					</div>
					<!-- 반품 사유 영역 E -->
				</li>
			</ul>
		</div>
<?php }}?>
	</section>

<?php if($TPL_VAR["deny"]){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?>거부/불가내역</h2>
        <table class="join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
            <tr>
                <th>상품정보</th>
                <td><?php echo $TPL_V1["pname"]?><br/>옵션 : <?php echo $TPL_V1["option_text"]?></td>
            </tr>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>거부<?php }else{?>불가<?php }?> 사유</th>
                <td><?php echo $TPL_V1["deny_message"]?></td>
            </tr>
<?php }}?>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["returnMethod"]){?>
	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</div>
			<span class="method"><?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>직접발송 <span>(구매자께서 개별로 상품을 이미 발송한 경우)</span><?php }else{?>지정택배 방문요청 <span>(판매사와 계약된 택배업체에서 방문수령 수거)</span><?php }?></span>
		</div>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>
		<div class="return-info__box">
<?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>
			<div class="return-type"><?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?></div>
			<p><span>운송장 번호</span><span class="waybill-number"><?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</span></p>
<?php }?>
			<p><?php if($TPL_VAR["returnMethod"]["returnData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></p>
		</div>
<?php }?>
	</section>
<?php }?>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]!= 1){?>
	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 수거 주소</div>
		</div>
		<div class="delivery-info__box">
			<div class="delivery-info__recipient"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></div>
			<div class="delivery-info__address">
				<p>
					<span class="zip-code"><?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?></span>
					<span class="addr1"><?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?></span>
					<span class="addr2"><?php echo $TPL_VAR["returnMethod"]["returnData"]["caddr2"]?></span>
				</p>
				<p class="phone-number"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></p>
				<p class="phone-number"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></p>
			</div>
			<dl class="delivery-info__list">
				<dt class="delivery-info__cate">배송 요청사항</dt>
				<dd class="delivery-info__cont"><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></dd>
			</dl>
		</div>
	</section>
<?php }?>
<?php if($TPL_VAR["claimType"]=='E'){?>
	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm">교환상품 받으실 주소</div>
		</div>
		<div class="delivery-info__box">
			<div class="delivery-info__recipient"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></div>
			<div class="delivery-info__address">
				<p>
					<span class="zip-code"><?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?></span>
					<span class="addr1"><?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?></span>
					<span class="addr2"><?php echo $TPL_VAR["returnMethod"]["returnData"]["caddr2"]?></span>
				</p>
				<p class="phone-number"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></p>
				<p class="phone-number"><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></p>
			</div>
			<dl class="delivery-info__list">
				<dt class="delivery-info__cate">배송 요청사항</dt>
				<dd class="delivery-info__cont"><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></dd>
			</dl>
		</div>
	</section>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
<?php }else{?>
	<section class="fb__mypage__section pmt-info">
		<div class="fb__mypage-title">
			<div class="title-sm">환불 내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">환불 예정 금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></span></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제방법</dt>
				<dd class="pmt-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> <?php echo $TPL_V1["method_text"]?> <?php }}?>
				</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?>신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?>할 상품금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불 예정 배송비</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["expectedRefund"]["deliveryPrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>
<?php if($TPL_VAR["expectedRefund"]["returnBankBool"]){?>
			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불수단</dt>
				<dd class="pmt-info__cont">
                    <?php echo $TPL_VAR["expectedRefund"]["refundBankName"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankOwner"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankNumber"]?>

				</dd>
			</dl>
<?php }?>
		</div>
		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등의 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">반품 신청 없이 반품 시에는 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line" onclick="parent.history.back(-1);">반품 / 취소 내역</button>
			</div>
		</div>
	</section>
<?php }?>
<?php }?>
</section>
<!-- 컨텐츠 E -->
<?php }else{?>
<!-- 컨텐츠 S -->
<section class="fb__return-history wrap-mypage wrap-order-detail">
	<div class="fb__mypage-title">
		<div class="title-md">반품 신청 내역</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 S -->
	<div class="order-number-box">
		<div class="order-number-box__cont">
			<dl class="order-number-box__item">
				<dt class="order-title">주문번호</dt>
				<dd class="order-number">202412312359-0000001</dd>
			</dl>
			<dl class="order-number-box__item">
				<dt class="order-title">주문일자</dt>
				<dd class="order-day">2024.12.31</dd>
			</dl>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="fb__mypage__section cancel-area">
		<div class="fb__mypage-title">
			<div class="title-sm">반품 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
				<li class="product-item__list">
					<!-- 상품 S -->
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
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 사은품 영역 S -->
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
							<li class="product-gift__box inner-gift devGiftList">
								<figure class="product-gift__thumb">
									<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
								</figure>
								<div class="product-gift__info">
									<div class="product-gift__info__pname"><span>[사은품]</span> 키즈 데이지 튜브</div>
									<div class="product-gift__info__count">
										<span>페일네온옐로우</span>
										<span>OS</span>
										<span>1개</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- 사은품 영역 E -->

					<!-- 반품 사유 영역 S -->
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm">반품 수량</div>
							<div class="cancel-quantity"><em>1</em>개</div>
						</div>
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm">반품 사유</div>
								<div class="reason-box__text">단순 변심</div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc">사이즈 잘못주문으로 다시 재주문하려고 취소합니다.</div>
							</div>
						</dl>
					</div>
					<!-- 반품 사유 영역 E -->
				</li>
				<li class="product-item__list">
					<!-- 상품 S -->
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
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 반품 사유 영역 S -->
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm">반품 수량</div>
							<div class="cancel-quantity"><em>1</em>개</div>
						</div>
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm">반품 사유</div>
								<div class="reason-box__text">단순 변심</div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc">사이즈 잘못주문으로 다시 재주문하려고 취소합니다.</div>
							</div>
						</dl>
					</div>
					<!-- 반품 사유 영역 E -->
				</li>
			</ul>
		</div>
	</section>

	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품 발송 방법</div>
			<span class="method">직접 발송</span>
		</div>
		<div class="return-info__box">
			<div class="return-type">우체국 택배</div>
			<p><span>운송장 번호</span><span class="waybill-number">134123434</span></p>
			<p>선불 발송</p>
		</div>
	</section>

	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품 수거 주소</div>
		</div>
		<div class="delivery-info__box">
			<div class="delivery-info__recipient">김배럴</div>
			<div class="delivery-info__address">
				<p>
					<span class="zip-code">04366</span>
					<span class="addr1">서울특별시 용산구 원효로 138</span>
					<span class="addr2">2층</span>
				</p>
				<p class="phone-number">010-1234-5678</p>
			</div>
			<dl class="delivery-info__list">
				<dt class="delivery-info__cate">배송 요청사항</dt>
				<dd class="delivery-info__cont">문 앞에 놔주세요.</dd>
			</dl>
		</div>
	</section>

	<section class="fb__mypage__section pmt-info">
		<div class="fb__mypage-title">
			<div class="title-sm">환불 내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">환불 예정 금액</dt>
				<dd class="pmt-info__cont"><span>1,265,550</span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제방법</dt>
				<dd class="pmt-info__cont">
					가상계좌 / 기업은행 48002668997451<br />
					예금주 : 주식회사 배럴
				</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소 신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><span>1,405,550</span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소할 상품금액</dt>
				<dd class="pmt-info__cont"><span>1,405,550</span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불 예정 배송비</dt>
				<dd class="pmt-info__cont"><span>0</span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소 시 차감 배송비</dt>
				<dd class="pmt-info__cont">-<span>5,000</span>원(왕복 + 3,000 도서산간비)</dd>
			</dl>
		</div>
		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등의 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">반품 신청 없이 반품 시에는 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line">반품 / 취소 내역</button>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->

<?php }?>