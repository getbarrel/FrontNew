<?php /* Template_ 2.2.8 2024/02/21 15:27:37 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim_detail/order_claim_detail.htm 000014223 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);
$TPL_deny_1=empty($TPL_VAR["deny"])||!is_array($TPL_VAR["deny"])?0:count($TPL_VAR["deny"]);?>
<!-- 컨텐츠 S -->
<section class="br__order-claim br__order-claim-detail">
	<div class="page-title my-title">
		<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 내역</div>
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
				<dd class="order-day"><?php echo str_replace('-','.',$TPL_VAR["order"]["order_date"])?></dd>
			</dl>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->
	<section class="br__order-content">
		<!-- 주문 내역 - 리스트 S -->
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
			</div>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<ul class="product-list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-list__item">
					<!-- 상품 S -->
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>">
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>

								<!-- 세트 상품 S -->
								<!-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 -->
								<div class="product-list__info__optio">
									<div class="product-list__info__option-item">
										<span class="color"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?><span class="size"><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									<span class="product-list__info__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 주문 취소 영역 S -->
					<div class="reason-box">
						<div class="reason-top">
							<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>수량</div>
							<div class="cancel-quantity"><em><?php echo $TPL_V2["pcnt"]?></em>개</div>
						</div>
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>사유</div>
								<div class="reason-box__text"><?php echo $TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['reason_text']?></div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc"><?php echo $TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['status_message']?></div>
							</div>
						</dl>
					</div>
					<!-- 주문 취소 영역 E -->
				</li>
<?php }}?>
			</ul>
<?php }}?>
		</div>
		<!-- 주문 내역 - 리스트 E -->

		<!--구매별 사은품 S -->
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
		<div class="gift-wrap">
			<div class="br__mypage-title">
				<div class="title-sm">구매금액별 사은품</div>
			</div>
			<ul class="product-list">
				<li class="product-list__item">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="#;">
									 <img src="<?php echo $TPL_V2["image_src"]?>" alt="">
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></div>

								<!-- 일반 상품 S -->
								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
										<span class="color"><?php echo $TPL_V2["pname"]?></span>
										<span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>
								<!-- 일반 상품 E -->
								<!-- <div class="product-list__info__add">
									<div class="order-status">조건 미충족 자동취소</div>
								</div> -->
							</div>
						</dd>
					</dl>
<?php }}?>
				</li>
			</ul>
		</div>
<?php }?>
<?php }}?>
<?php }?>
		<!--구매별 사은품 E -->

<?php if($TPL_VAR["deny"]){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>거부/불가내역</div>
			</div>
			<div class="pay-comp__payment">
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>상품정보</dt>
					<dd><?php echo $TPL_V1["pname"]?><br/>옵션 : <?php echo $TPL_V1["option_text"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>거부<?php }else{?>불가<?php }?> 사유</dt>
						<dd><?php echo $TPL_V1["deny_message"]?></dd>
					</dl>
				</div>
<?php }}?>
			</div>
		</div>
<?php }?>

<?php if($TPL_VAR["returnMethod"]){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>방법</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</dt>
						<dd><?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>직접 발송<?php }else{?>지정택배 방문요청<?php }?></dd>
					</dl>

<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>                    <?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 발송 정보</dt>
						<dd><?php if($TPL_VAR["returnMethod"]["returnData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></dd>
					</dl>
<?php }?>
					<dl class="pay-comp__payment__box">
						<dt>상품 발송 시 배송비</dt>
						<dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?>(송장번호:<?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</dd>
					</dl>
<?php }else{?>					<dl class="pay-comp__payment__box">
						<dt>성명</dt>
						<dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주소</dt>
						<dd>[<?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?>] <br><?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?><br> <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr2"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>휴대폰번호</dt>
						<dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>전화번호</dt>
						<dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>배송요청사항</dt>
						<dd><div><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></div></dd>
					</dl>
<?php }?>
				</div>
			</div>
<?php if($TPL_VAR["claimType"]=='E'){?>
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소 (구매자 주소지)</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>성명</dt>
						<dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>성명</dt>
						<dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주소</dt>
						<dd>[<?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["zip"]?>]<br><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr1"]?><br><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr2"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>휴대폰번호</dt>
						<dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rmobile"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>전화번호</dt>
						<dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rtel"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>배송요청사항</dt>
						<dd><div><?php echo nl2br($TPL_VAR["returnMethod"]["reDeliveryData"]["msg"])?></div></dd>
					</dl>
				</div>
			</div>
<?php }?>
		</div>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">변동내역</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 신청 총 결제금액</dt>
						<dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</dt>
						<dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>추가 결제 예정 금액</dt>
						<dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["addPaymentPrice"])?></em>원</dd>
					</dl>
				</div>
			</div>
		</div>
<?php }else{?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">환불내역</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?>신청 총 결제금액</dt>
						<dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?>할 상품금액</dt>
						<dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>환불 예정 배송비</dt>
						<dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["deliveryPrice"])?></em>원</dd>
					</dl>
<?php if($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"]> 0){?>
                    <dl class="pay-comp__payment__box">
                        <dt>배송비쿠폰할인(차감)</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"])?></em>원</dd>
                    </dl>
<?php }?>
                    <dl class="pay-comp__payment__box">
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>시 추가 배송비(차감)</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em>원</dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>환불 예정 금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></em>원</dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>결제수단(상품 구매 시)</dt>
                        <dd><?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                    </dl>
<?php if($TPL_VAR["expectedRefund"]["returnBankBool"]){?>
                    <dl class="pay-comp__payment__box">
                        <dt>환불수단</dt>
                        <dd><?php echo $TPL_VAR["expectedRefund"]["refundBankName"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankOwner"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankNumber"]?></dd>
                    </dl>
<?php }?>
				</div>
			</div>
		</div>
<?php }?>
<?php }?>
		<div class="use-notice">
			<h3 class="use-notice__title">유의사항</h3>
			<ul class="use-notice__list">
				<li class="use-notice__desc">신용카드, 간편결제, 실시간 계좌이체는 자동 환불 처리됩니다.</li>
				<li class="use-notice__desc">결제 시 사용하신 적립금은 내부정책에 따라 취소신청 완료 후 환불 처리됩니다.</li>
			</ul>
		</div>
	</section>
	<div class="br__order-footer">
		<button type="button" class="btn-lg btn-dark-line"><a href="/mypage/">마이페이지</a></button>
		<button type="button" class="btn-lg btn-gray-line"><a href="/">홈으로</a></button>
	</div>
</section>
<!-- 컨텐츠 E -->