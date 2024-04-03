<?php /* Template_ 2.2.8 2024/03/22 18:02:33 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_confirm.htm 000030258 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!-- 컨텐츠 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__order-claim fb__mypage-claim--confirm fb__order-claim-confirm">
	<div class="fb__mypage-title">
		<div class="title-md"><?php echo $TPL_VAR["claimTypeName"]?> 신청 확인</div>
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

	<section class="fb__mypage__section cancel-area">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list">
					<!-- 상품 S -->
					<dl class="product-item devOdIxCls" devOdIx="<?php echo $TPL_V2["od_ix"]?>" devClaimCnt="<?php echo $TPL_V2["claim_cnt"]?>">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>">
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
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 사은품 영역 S --
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
							<li class="product-gift__box inner-gift devGiftList">
								<figure class="product-gift__thumb">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
					-- 사은품 영역 E -->

					<!-- 반품 사유 영역 S -->
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 수량</div>
							<div class="cancel-quantity"><em><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></em>개</div>
						</div>
						<dl class="reason-box__inner devCancelBoxOn">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
								<div class="reason-box__text"><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc"><?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?></div>
							</div>
						</dl>
					</div>
					<!-- 반품 사유 영역 E -->
				</li>
<?php }}?>
			</ul>
		</div>
<?php }}?>
	</section>

	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</div>
			<span class="method"><?php if($TPL_VAR["applyData"]["send_type"]== 1){?>직접발송 <span>(구매자께서 개별로 상품을 이미 발송한 경우)</span><?php }else{?>지정택배 방문요청 <span>(판매사와 계약된 택배업체에서 방문수령 수거)</span><?php }?></span>
		</div>
		<!--<div class="delivery-info__box">
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
		</div>-->
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?> 발송 정보</dt>
				<dd class="pmt-info__cont"></dd>
			</dl>
<?php if($TPL_VAR["applyData"]["quick_info"]!='N'){?>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["applyData"]["quickText"]?></dt>
				<dd class="pmt-info__cont">송장번호:<?php echo $TPL_VAR["applyData"]["invoice_no"]?></dd>
			</div>
<?php }?>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">상품 발송 시 배송비</dt>
				<dd class="pmt-info__cont"><?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></dd>
			</div>
		</div>
<?php }else{?>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?> 수거 주소</dt>
				<dd class="pmt-info__cont"></dd>
			</dl>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">성명</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["cname"]?></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">주소</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["czip"]?> <?php echo $TPL_VAR["applyData"]["caddr1"]?> <?php echo $TPL_VAR["applyData"]["caddr2"]?></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">휴대폰 번호</dt>
				<dd class="pmt-info__cont"><em><?php echo $TPL_VAR["applyData"]["cmobile1"]?>-<?php echo $TPL_VAR["applyData"]["cmobile2"]?>-<?php echo $TPL_VAR["applyData"]["cmobile3"]?></em></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">배송요청사항</dt>
				<dd class="pmt-info__cont"><?php echo nl2br($TPL_VAR["applyData"]["cmsg"])?></dd>
			</div>
		</div>
<?php }?>

<?php if($TPL_VAR["claimType"]=='change'){?>
			<div class="pmt-info__box">
				<dl class="pmt-info__list pmt-info__total">
					<dt class="pmt-info__cate">교환상품 받으실 주소</dt>
					<dd class="pmt-info__cate">(구매자 주소지)</dd>
				</dl>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">성명</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["rname"]?></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">주소</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["rzip"]?> <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">휴대폰 번호</dt>
					<dd class="pmt-info__cont"><em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">배송요청사항</dt>
					<dd class="pmt-info__cont"><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></dd>
				</div>
			</div>
<?php }?>
	</section>

	<section class="fb__mypage__section pmt-info">
<?php if($TPL_VAR["claimType"]=='change'){?>

		<div class="fb__mypage-title">
			<div class="title-sm">변동내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">교환신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></span>원</dd>
			</dl>
		</div>

		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">교환배송비는 접수완료 시 안내문자가 발송 되며, 안내문자 확인 후 배송비를 입금 부탁드립니다.</li>
					<li class="use-notice__desc">교환 신청하신 제품이 품절일 경우 환불로 진행될 수 있음을 안내드립니다.</li>
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
<?php }else{?>
		<div class="fb__mypage-title">
			<div class="title-sm">환불내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">환불 예정 금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["view_price"])?></span>원</dd>
			</dl>

			<!--<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제방법</dt>
				<dd class="pmt-info__cont">
					가상계좌 / 기업은행 48002668997451<br />
					예금주 : 주식회사 배럴
				</dd>
			</dl>-->

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["view_total_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품할 상품금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불 예정 배송비</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품 시 추가 배송비</dt>
				<dd class="pmt-info__cont">-<span><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></span>원</dd>
			</dl>
		</div>

		<form id="devClaimConfirmForm" method="post">
		<input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">결제수단(상품 구매 시)</dt>
				<dd class="pmt-info__cate">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<?php echo $TPL_V1["method_text"]?>

						<input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
						<input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
				</dd>
			</dl>
			<dl class="pmt-info__list" id="devInfoBankNumber">
				<dt class="pmt-info__cate">환불수단 * 주문 상세 건별 환불 계좌 지정은 불가능합니다.</dt>
<?php if($TPL_VAR["refundInfo"]){?>
				<input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
				<dd class="pmt-info__cont">
					<select name="bankCode" title="은행명" id="devBankCode" style="height:40px;">
						<option value="">은행명 선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
					</select>
					<input type="text" class="devOdIxCls" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
					<input type="text" class="devOdIxCls" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
				</dd>
<?php }else{?>
				<dd class="pmt-info__cont">
					<select name="bankCode" title="은행명" id="devBankCode" style="height:40px;">
						<option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
					</select>
					<input type="text" class="devOdIxCls" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
					<input type="text" class="devOdIxCls" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["ori_bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
				</dd>
<?php }?>
			</dl>
		</div>
		</form>
		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">반품 시 유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
<?php }?>



		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line">취소</button>
				<button type="button" class="btn-lg btn-dark">반품 신청</button>
			</div>
		</div>
	</section>
</section>
<?php }else{?>
<section class="fb__order-claim fb__mypage-claim--confirm fb__order-claim-confirm">
	<div class="fb__mypage-title">
		<div class="title-md"><?php echo $TPL_VAR["claimTypeName"]?> 신청 확인</div>
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

	<section class="fb__mypage__section cancel-area">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list">
					<!-- 상품 S -->
					<dl class="product-item devOdIxCls" devOdIx="<?php echo $TPL_V2["od_ix"]?>" devClaimCnt="<?php echo $TPL_V2["claim_cnt"]?>">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>">
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
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em>원</div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 사은품 영역 S --
					<div class="product-gift-wrap">
						<div class="product-gift__title">
							<strong>구매 사은품</strong>
						</div>
						<ul class="product-gift__list">
							<li class="product-gift__box inner-gift devGiftList">
								<figure class="product-gift__thumb">
									<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
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
					-- 사은품 영역 E -->

					<!-- 반품 사유 영역 S -->
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 수량</div>
							<div class="cancel-quantity"><em><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></em>개</div>
						</div>
						<dl class="reason-box__inner devCancelBoxOn">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
								<div class="reason-box__text"><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></div>
							</div>
							<div class="reason-box__cont">
								<div class="reason-box__desc"><?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?></div>
							</div>
						</dl>
					</div>
					<!-- 반품 사유 영역 E -->
				</li>
<?php }}?>
			</ul>
		</div>
<?php }}?>
	</section>

	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</div>
			<span class="method"><?php if($TPL_VAR["applyData"]["send_type"]== 1){?>직접발송 <span>(구매자께서 개별로 상품을 이미 발송한 경우)</span><?php }else{?>지정택배 방문요청 <span>(판매사와 계약된 택배업체에서 방문수령 수거)</span><?php }?></span>
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
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?> 발송 정보</dt>
				<dd class="pmt-info__cont"></dd>
			</dl>
<?php if($TPL_VAR["applyData"]["quick_info"]!='N'){?>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["applyData"]["quickText"]?></dt>
				<dd class="pmt-info__cont">송장번호:<?php echo $TPL_VAR["applyData"]["invoice_no"]?></dd>
			</div>
<?php }?>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">상품 발송 시 배송비</dt>
				<dd class="pmt-info__cont"><?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></dd>
			</div>
		</div>
<?php }else{?>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate"><?php echo $TPL_VAR["claimTypeName"]?> 수거 주소</dt>
				<dd class="pmt-info__cont"></dd>
			</dl>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">성명</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["cname"]?></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">주소</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["czip"]?> <?php echo $TPL_VAR["applyData"]["caddr1"]?> <?php echo $TPL_VAR["applyData"]["caddr2"]?></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">휴대폰 번호</dt>
				<dd class="pmt-info__cont"><em><?php echo $TPL_VAR["applyData"]["cmobile1"]?>-<?php echo $TPL_VAR["applyData"]["cmobile2"]?>-<?php echo $TPL_VAR["applyData"]["cmobile3"]?></em></dd>
			</div>
			<div class="pmt-info__list">
				<dt class="pmt-info__cate">배송요청사항</dt>
				<dd class="pmt-info__cont"><?php echo nl2br($TPL_VAR["applyData"]["cmsg"])?></dd>
			</div>
		</div>
<?php }?>

<?php if($TPL_VAR["claimType"]=='change'){?>
			<div class="pmt-info__box">
				<dl class="pmt-info__list pmt-info__total">
					<dt class="pmt-info__cate">교환상품 받으실 주소</dt>
					<dd class="pmt-info__cate">(구매자 주소지)</dd>
				</dl>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">성명</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["rname"]?></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">주소</dt>
					<dd class="pmt-info__cont"><?php echo $TPL_VAR["applyData"]["rzip"]?> <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">휴대폰 번호</dt>
					<dd class="pmt-info__cont"><em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em></dd>
				</div>
				<div class="pmt-info__list">
					<dt class="pmt-info__cate">배송요청사항</dt>
					<dd class="pmt-info__cont"><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></dd>
				</div>
			</div>
<?php }?>
	</section>

	<section class="fb__mypage__section pmt-info">
<?php if($TPL_VAR["claimType"]=='change'){?>

		<div class="fb__mypage-title">
			<div class="title-sm">변동내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">교환신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></span>원</dd>
			</dl>
		</div>

		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">교환배송비는 접수완료 시 안내문자가 발송 되며, 안내문자 확인 후 배송비를 입금 부탁드립니다.</li>
					<li class="use-notice__desc">교환 신청하신 제품이 품절일 경우 환불로 진행될 수 있음을 안내드립니다.</li>
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
<?php }else{?>
		<div class="fb__mypage-title">
			<div class="title-sm">환불내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">환불 예정 금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["view_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제방법</dt>
				<dd class="pmt-info__cont">
					가상계좌 / 기업은행 48002668997451<br />
					예금주 : 주식회사 배럴
				</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["view_total_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품할 상품금액</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불 예정 배송비</dt>
				<dd class="pmt-info__cont"><span><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?></span>원</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">반품 시 추가 배송비</dt>
				<dd class="pmt-info__cont">-<span><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></span>원</dd>
			</dl>
		</div>

		<form id="devClaimConfirmForm" method="post">
		<input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">결제수단(상품 구매 시)</dt>
				<dd class="pmt-info__cate">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<?php echo $TPL_V1["method_text"]?>

						<input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
						<input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
				</dd>
			</dl>
			<dl class="pmt-info__list" id="devInfoBankNumber">
				<dt class="pmt-info__cate">환불수단 * 주문 상세 건별 환불 계좌 지정은 불가능합니다.</dt>
<?php if($TPL_VAR["refundInfo"]){?>
				<input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
				<dd class="pmt-info__cont">
					<select name="bankCode" title="은행명" id="devBankCode" style="height:40px;">
						<option value="">은행명 선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
					</select>
					<input type="text" class="devOdIxCls" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
					<input type="text" class="devOdIxCls" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
				</dd>
<?php }else{?>
				<dd class="pmt-info__cont">
					<select name="bankCode" title="은행명" id="devBankCode" style="height:40px;">
						<option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
					</select>
					<input type="text" class="devOdIxCls" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
					<input type="text" class="devOdIxCls" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["ori_bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
				</dd>
<?php }?>
			</dl>
		</div>
		</form>
		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">반품 시 유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.</li>
					<li class="use-notice__desc">상품 하자 등 판매자 귀책 사유인 경우 추가 배송비가 발생하지 않습니다.</li>
					<li class="use-notice__desc">판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.</li>
				</ul>
			</div>
		</div>
<?php }?>



		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line" id="devPrevBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">취소</button>
				<button type="button" class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">>반품 신청</button>
			</div>
		</div>
	</section>
</section>
<?php }?>
<!-- 컨텐츠 E -->