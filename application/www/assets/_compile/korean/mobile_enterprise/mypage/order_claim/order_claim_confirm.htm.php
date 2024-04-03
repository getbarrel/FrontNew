<?php /* Template_ 2.2.8 2024/03/22 18:05:22 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_confirm.htm 000024681 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!-- 컨텐츠 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__order-claim order-complete">
	<div class="page-title my-title">
		<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 확인</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 S -->
	<div class="order-number-box">
		<div class="order-number-box__cont">
			<dl class="order-number-box__item">
				<dt class="order-title">주문번호</dt>
				<dd class="order-number" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
			</dl>
			<dl class="order-number-box__item">
				<dt class="order-title">주문일자</dt>
				<dd class="order-day"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
			</dl>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="br__order-content">
		<!-- 주문 내역 - 리스트 S -->
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm">반품 신청 상품</div>
			</div>
			<ul class="product-list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-list__item">
					<!-- 상품 S -->
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></div>

								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
<?php if($TPL_V2["add_info"]){?><span class="color"><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span class="size"><?php echo $TPL_V2["option_text"]?></span>
										<span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									<span class="product-list__info__status"><?php echo trans($TPL_V2["status_text"])?></span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 반품 영역 S -->
					<div class="reason-box">
						<div class="reason-top">
							<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 수량</div>
							<div class="cancel-quantity"><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></div>
						</div>
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
								<div class="reason-box__text"><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc"><?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?></div>
							</div>
						</dl>
					</div>
					<!-- 반품 영역 E -->
				</li>
<?php }}?>
				<!--
				<li class="product-list__item">
					-- 상품 S --
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="#;">
									<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>

								-- 세트 상품 S --
								-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 --
								<div class="product-list__info__option set">
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
								</div>
								-- 세트 상품 E --

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
									<span class="product-list__info__status">배송완료</span>
								</div>
							</div>
						</dd>
					</dl>
					-- 상품 E --

					-- 반품 영역 S --
					<div class="reason-box">
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
					-- 반품 영역 E --
				</li>
				-->
			</ul>
		</div>
<?php }}?>
		<!-- 주문 내역 - 리스트 E -->

		<!--반품 방식 S -->
		<div class="pay-comp__wrap address">
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</div>
				<span class="method"><?php if($TPL_VAR["applyData"]["send_type"]== 1){?>직접 발송<?php }else{?>지정 택배 발송<?php }?></span>
			</div>
		</div>
		<!--반품 방식 E -->

		<!--배송 정보 S -->
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>		<div class="pay-comp__wrap payment">
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
<?php if($TPL_VAR["applyData"]["quick_info"]!='N'){?>
					<dl class="pay-comp__payment__box">
						<dt>배송업체</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["quickText"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>송장번호</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["invoice_no"]?></em></dd>
					</dl>
<?php }?>
					<dl class="pay-comp__payment__box">
						<dt>상품 발송 배송비</dt>
						<dd><em><?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></em></dd>
					</dl>
				</div>
			</div>
		</div>
<?php }else{?>		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">상품 수거지 주소</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>성명</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["cname"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주소</dt>
						<dd><em>[<?php echo $TPL_VAR["applyData"]["czip"]?>] <?php echo $TPL_VAR["applyData"]["caddr1"]?> <?php echo $TPL_VAR["applyData"]["caddr2"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>휴대폰</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["cmobile1"]?>-<?php echo $TPL_VAR["applyData"]["cmobile2"]?>-<?php echo $TPL_VAR["applyData"]["cmobile3"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>배송요청사항</dt>
						<dd><em><?php echo nl2br($TPL_VAR["applyData"]["cmsg"])?></em></dd>
					</dl>
				</div>
			</div>
		</div>
<?php }?>
		<!--배송 정보 E -->

		<!--상품 받으실 주소 S -->
<?php if($TPL_VAR["claimType"]=='change'){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 상품 받으실 주소</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>성명</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["rname"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주소</dt>
						<dd><em>[<?php echo $TPL_VAR["applyData"]["rzip"]?>] <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>휴대폰</dt>
						<dd><em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>배송요청사항</dt>
						<dd><em><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></em></dd>
					</dl>
				</div>
			</div>
		</div>
<?php }?>
		<!--상품 받으실 주소 E -->

		<!--결제 정보 S -->
<?php if($TPL_VAR["claimType"]=='change'){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">변동내역</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?>신청 총 결제금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
				</div>
			</div>
		</div>
<?php }else{?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">환불 내역</div>
			</div>
			<div class="pay-comp__payment">
				<dl class="pay-comp__payment__total">
					<dt>환불 예정 금액</dt>
					<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["view_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<div class="pay-comp__payment__list">
					
					<!--<dl class="pay-comp__payment__box">
						<dt>결제방법</dt>
						<dd>신용카드 / 국민카드(00**)</dd>
					</dl>-->

					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 신청 총 결제금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>반품할 상품금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>환불 예정 배송비</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
				</div>
			</div>
		</div>

		<section class="order-claim__payment">
			<form id="devClaimConfirmForm" method="post">
				<input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
				<input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
				<h3 class="order-claim__title br__hidden">환불계좌 정보</h3>
				<div class="order-claim__content" id="devInfoBankNumber" style="padding-bottom:50px;">
<?php if($TPL_VAR["refundInfo"]){?>
					<input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
					<div class="cancel-account">
						<p class="cancel-account__title">환불수단: 무통장입금 (가상계좌)</p>
						<div class="cancel-account__box">
							<select name="bankCode" title="은행명" id="devBankCode">
								<option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
							</select>
						</div>
						<div class="cancel-account__box">
							<input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주를 입력해 주세요.">
						</div>
						<div class="cancel-account__box">
							<input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호를 입력해 주세요.">
						</div>
					</div>
<?php }else{?>
					<div class="cancel-account">
						<p class="cancel-account__title">환불수단: 무통장입금 (가상계좌)</p>
						<div class="cancel-account__box">
							<select name="bankCode" title="은행명" id="devBankCode">
								<option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
							</select>
						</div>
						<div class="cancel-account__box">
							<input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주를 입력해 주세요.">
						</div>
						<div class="cancel-account__box">
							<input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["ori_bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호를 입력해 주세요.">
						</div>
					</div>
<?php }?>
					<ul class="br__order-claim__notice">
						<li class="br__order-claim__desc">· <?php echo trans('결제수단 중 가상계좌 외 모든 결제수단은 자동 환불 처리되며 가상계좌로 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리 됩니다.')?></li>
						<li class="br__order-claim__desc">· <?php echo trans('결제 시 사용한 쿠폰 및 마일리지는 내부정책에 따라 취소신청 완료 후 환불됩니다.')?></li>
					</ul>
				</div>
			</form>
		</section>
<?php }?>
		<!--결제 정보 E -->


<?php if($TPL_VAR["claimType"]!='change'){?>
		<div class="use-notice">
			<h3 class="use-notice__title">유의사항</h3>
			<ul class="use-notice__list">
				<li class="use-notice__desc">· 교환배송비는 접수완료 시 안내문자가 발송 되며, 안내문자 확인 후 배송비를 입금 부탁드립니다.</li>
				<li class="use-notice__desc">· 교환배송비는 접수완료 시 안내문자가 발송 되며, 안내문자 확인 후 배송비를 입금 부탁드립니다.</li>
				<li class="use-notice__desc">· 교환배송비는 접수완료 시 안내문자가 발송 되며, 안내문자 확인 후 배송비를 입금 부탁드립니다.</li>
			</ul>
		</div>
<?php }else{?>
		<div class="use-notice">
			<h3 class="use-notice__title">유의사항</h3>
			<ul class="use-notice__list">
				<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복배송비가 발생합니다.</li>
				<li class="use-notice__desc">상품 하자 등의 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
				<li class="use-notice__desc">반품 신청 없이 반품 시에는 처리가 안될 수 있습니다.</li>
			</ul>
		</div>
<?php }?>
	</section>
	<div class="br__order-footer">
		<button type="button" class="btn-lg btn-dark-line" id="devPrevBtn">이전</button>
		<button type="button" class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">반품 신청</button>
	</div>
</section>
<?php }else{?>
<section class="br__order-claim order-complete">
	<div class="page-title my-title">
		<div class="title-sm">반품 신청 확인</div>
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

	<section class="br__order-content">
		<!-- 주문 내역 - 리스트 S -->
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm">반품 신청 상품</div>
			</div>
			<ul class="product-list">
				<li class="product-list__item">
					<!-- 상품 S -->
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="#;">
									<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>

								<!-- 세트 상품 S -->
								<!-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 -->
								<div class="product-list__info__option set">
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
									<span class="product-list__info__status">배송완료</span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 반품 영역 S -->
					<div class="reason-box">
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
					<!-- 반품 영역 E -->
				</li>
				<li class="product-list__item">
					<!-- 상품 S -->
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="#;">
									<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>

								<!-- 세트 상품 S -->
								<!-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 -->
								<div class="product-list__info__option set">
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
									<div class="product-list__info__option-item">
										<span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
										<span class="color">블랙</span>
										<span class="size">M</span>
										<span class="count">1개</span>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
									<span class="product-list__info__status">배송완료</span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 반품 영역 S -->
					<div class="reason-box">
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
					<!-- 반품 영역 E -->
				</li>
			</ul>
		</div>
		<!-- 주문 내역 - 리스트 E -->

		<!--반품 방식 S -->
		<div class="pay-comp__wrap address">
			<div class="br__mypage-title">
				<div class="title-sm">반품 발송 방법</div>
				<span class="method">지정택배 발송</span>
			</div>
		</div>
		<!--반품 방식 E -->

		<!--배송 정보 S -->
		<div class="pay-comp__wrap address">
			<div class="br__mypage-title">
				<div class="title-sm">반품 수거 주소</div>
			</div>
			<div class="pay-comp__address">
				<div class="name">김배럴</div>
				<div class="address">
					<p>04366 / 서울특별시 용산구 원효로 138 2층</p>
					<p>010-1234-5678</p>
				</div>
				<div class="title">배송 요청사항</div>
				<div class="message">문 앞에 놔주세요.</div>
			</div>
		</div>
		<!--배송 정보 E -->

		<!--결제 정보 S -->
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">환불 내역</div>
			</div>
			<div class="pay-comp__payment">
				<dl class="pay-comp__payment__total">
					<dt>환불 예정 금액</dt>
					<dd><em>1,265,550</em>원</dd>
				</dl>
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>결제방법</dt>
						<dd>신용카드 / 국민카드(00**)</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>취소 신청 총 결제금액</dt>
						<dd><em>1,405,550</em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>반품할 상품금액</dt>
						<dd><em>405,550</em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>환불 예정 배송비</dt>
						<dd><em>0</em>원</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>취소 시 차감 배송비</dt>
						<dd><em>0</em>원</dd>
					</dl>
				</div>
			</div>
		</div>
		<!--결제 정보 E -->
		<div class="use-notice">
			<h3 class="use-notice__title">유의사항</h3>
			<ul class="use-notice__list">
				<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복배송비가 발생합니다.</li>
				<li class="use-notice__desc">상품 하자 등의 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
				<li class="use-notice__desc">반품 신청 없이 반품 시에는 처리가 안될 수 있습니다.</li>
			</ul>
		</div>
	</section>
	<div class="br__order-footer">
		<button type="button" class="btn-lg btn-dark-line">이전</button>
		<button type="button" class="btn-lg btn-dark">반품 신청</button>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 E -->