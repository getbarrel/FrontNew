<?php /* Template_ 2.2.8 2024/03/03 21:07:32 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_cancel/order_cancel.htm 000017940 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!-- 컨텐츠 S -->
<section class="fb__mypage-claim fb__mypage__order-claim wrap-mypage wrap-order-claim">
	<div class="fb__mypage-title">
		<div class="title-md">주문 취소 신청</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 S -->
	<div class="order-number-box">
		<div class="order-number-box__cont">
			<dl class="order-number-box__item">
				<dt class="order-title">주문번호</dt>
				<dd class="order-number" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-allselected="<?php echo $TPL_VAR["allSelected"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
			</dl>
			<dl class="order-number-box__item">
				<dt class="order-title">주문일자</dt>
				<dd class="order-day"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
			</dl>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<!--[S] 주문 취소 상품 상단-->
	<section class="fb__mypage__section cancel-area">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm">취소 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
				<!-- 부분취소 할 경우 - 상품없음 S -->
				<!-- 숨김처리 되어 있음 -->
				<li class="product-item__list no-data" style="display: none">
					<p class="empty-content">기간내 주문내역이 없습니다.</p>
				</li>
				<!-- 부분취소 할 경우 - 상품없음 E -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list devCancelBoxOn devCancelArea" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-pcnt="<?php echo $TPL_V2["pcnt"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["allSelected"]=='Y')){?><?php }else{?>none<?php }?>">
					<!-- 상품 S -->
					<input type="hidden" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" value='<?php echo $TPL_V2["od_ix"]?>'>
					<dl class="product-item">
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
									<a href="#;">
										<span class="set-name"><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<!-- 부분취소 S -->
								<!-- 숨김처리 -->
								<div class="btn-group">
									<button type="button" class="btn-link btn-del">삭제</button>
								</div>
								<!-- 부분취소 E -->
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
					<!-- 사은품 영역 E -->

					
					<!-- 입금대기/결제완료 S -->
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm">취소 수량</div>
							<div class="cancel-quantity">
								<em class="devCancelCntCls devPcnt" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_V2["pcnt"]?></em>개
							</div>
							<!-- <input type="hidden" name="pcnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>"> -->
						</div>
						<dl class="reason-box__inner devCancelBoxOn devCancelTr" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["allSelected"]=='Y')){?><?php }else{?>none<?php }?>">
							<div class="reason-box__title">
								<div class="title-sm">취소 사유</div>
							</div>
							<div class="reason-box__cont">
								<div class="fb__form-item devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
									<label for="" class="hide">취소사유</label>
									<select name="cc_reason" class="fb__form-select devCcReason" data-odix="<?php echo $TPL_V2["od_ix"]?>">
<?php if(is_array($TPL_R3=($TPL_VAR["cancelReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
										<option value="<?php echo $TPL_K3?>">Others</option>
<?php }else{?>
										<option value="<?php echo $TPL_K3?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
									</select>
								</div>
								<textarea class="fb__form-textarea devCcMsg" placeholder="취소 사유를 작성해 주세요. (최대 100자)" text="취소사유" name="cc_msg[<?php echo $TPL_V2["od_ix"]?>]" data-odIx="<?php echo $TPL_V2["od_ix"]?>" maxlength="100"></textarea>
							</div>
						</dl>
					</div>
					<!-- 입금대기/결제완료 E -->
<?php }else{?>
					<!-- 부분취소 S -->
					<div class="claim__list__reason reason-box">
						<div class="reason-top">
							<div class="title-sm">취소 수량</div>
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
							</div>
						</div>
						<dl class="reason-box__inner devCancelBoxOn devCancelTr" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["allSelected"]=='Y')){?><?php }else{?>none<?php }?>">
							<div class="reason-box__title">
								<div class="title-sm">취소 사유</div>
							</div>
							<div class="reason-box__cont">
								<div class="fb__form-item devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
									<label for="" class="hide">취소사유</label>
									<select name="cc_reason" class="fb__form-select devCcReason" data-odix="<?php echo $TPL_V2["od_ix"]?>">
<?php if(is_array($TPL_R3=($TPL_VAR["cancelReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
										<option value="<?php echo $TPL_K3?>">Others</option>
<?php }else{?>
										<option value="<?php echo $TPL_K3?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
									</select>
								</div>
								<textarea class="fb__form-textarea devCcMsg" placeholder="취소 사유를 작성해 주세요. (최대 100자)" text="취소사유" name="cc_msg[<?php echo $TPL_V2["od_ix"]?>]" data-odIx="<?php echo $TPL_V2["od_ix"]?>" maxlength="100"></textarea>
							</div>
						</dl>
					</div>
<?php }?>
					<!-- 부분취소 E -->
				</li>
<?php }}?>
			</ul>
		</div>

		<div class="claim__list__empty" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''&&$TPL_VAR["allSelected"]!='Y'){?>block<?php }else{?>none<?php }?>" >
			<span>선택한 취소 상품이 없습니다.</span>
		</div>
<?php }}?>
	</section>

	<!-- 부분취소 할 경우 - 취소 상품 선택 영역 S -->
<?php if($TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["partCancelBool"]==true){?>
	<section class="fb__mypage__section cancel-area">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm">취소 신청 상품 추가</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
				<li class="product-item__list">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<dl class="product-item devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"]&&$TPL_VAR["allSelected"]!='Y')){?><?php }else{?>none<?php }?>">
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
										<span class="set-name"><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>			
										<input type="hidden" name="pcnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>">
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="btn-group">
									<button type="button" class="btn-link devCancelPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>">추가</button>
								</div>
								<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
							</div>
						</dd>
					</dl>
<?php }}?>
					<!-- 상품 E -->
				</li>
			</ul>
		</div>
<?php }}?>
	</section>
<?php }?>
	<!-- 부분취소 할 경우 - 취소 상품 선택 영역 E -->

	<!-- 구매금액별 사은품 영역 S --
	<section class="fb__mypage__section gift-wrap">
		<div class="fb__mypage-title">
			<div class="title-sm">구매금액별 사은품</div>
		</div>
		<div class="gift-list">
			<ul class="product-item__wrap">
				<li class="product-item__list">
					<!-- 상품 영역 S -- 
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title">[사은품] 키즈 데이지 튜브</div>
								<div class="product-item__option">
									<span>페일네온옐로우</span>
									<span>OS</span>
									<span>1개</span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 영역 E -- 
				</li>
			</ul>
		</div>
	</section>
	<!-- 구매금액별 사은품 영역 E -->

	<section class="fb__mypage__section pmt-info">
<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
		<div class="fb__mypage-title">
			<div class="title-sm">환불 내역</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">환불 예정 금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devCancelTotalReturnPrice">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">결제수단(상품 구매 시)</dt>
				<dd class="pmt-info__cont">
					가상계좌 / 기업은행 48002668997451<br />
					예금주 : 주식회사 배럴
				</dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소 신청 총 결제금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devCancelTotalPrice">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소할 상품금액</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devCancelProductPrice">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>

			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">환불 예정 배송비</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devCancelDeliveryReturnPrice">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소 시 추가 배송비</dt>
				<dd class="pmt-info__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devCancelTotalReceivePrice">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
			</dl>
<?php }?>
			<!-- <dl class="pmt-info__list">
				<dt class="pmt-info__cate">취소 시 차감 배송비</dt>
				<dd class="pmt-info__cont"><span>0</span>원</dd>
			</dl> -->

		</div><br>

		<div class="fb__mypage-title">
			<div class="title-sm">환불수단</div>
		</div>
		<div class="pmt-info__box">
			<dl class="pmt-info__list pmt-info__total">
				<dt class="pmt-info__cate">결제수단(상품 구매 시)</dt>
				<dd class="pmt-info__cate"><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
			</dl>
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["refundInfo"]){?>
<?php if($TPL_VAR["refundInfo"]["method"]=='4'||$TPL_VAR["refundInfo"]["method"]=='9'){?>
					<input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
					<dl class="pmt-info__list">
						<dt class="pmt-info__cate">은행명</dt>
						<dd class="pmt-info__cont">
							<select name="bankCode" title="은행명" id="devBankCode">
								<option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>>
									<?php echo $TPL_V1?>

								</option>
<?php }}?>
							</select>						
						</dd>
					</dl>
					<dl class="pmt-info__list">
						<dt class="pmt-info__cate">예금주</dt>
						<dd class="pmt-info__cont"><input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner"></dd>
					</dl>
					<dl class="pmt-info__list">
						<dt class="pmt-info__cate">계좌번호</dt>
						<input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="계좌번호" id="devBankNumber">
					</dl>
<?php }else{?>
					<dl class="pmt-info__list">
						<dt class="pmt-info__cate">결제 수단으로 환불</dt>
					</dl>
					
<?php }?>
<?php }?>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php switch($TPL_V1["method"]){case ORDER_METHOD_BANK:case ORDER_METHOD_VBANK:case ORDER_METHOD_ASCROW:case ORDER_METHOD_CASH:case ORDER_METHOD_ICHE:?><script>$(function(){$('#devRefundMethod').show();});</script><?php }?><?php }}?>
		</div>

		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">신용카드, 간편결제, 실시간 계좌이체는 자동 환불 처리됩니다.</li>
					<li class="use-notice__desc">결제 시 사용하신 적립금은 내부정책에 따라 취소신청 완료 후 환불 처리됩니다.</li>
				</ul>
			</div>
		</div>
<?php }?>
		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line" id="devClaimCancel">취소</button>
				<button type="button" class="btn-lg btn-dark" id="devClaimApply">취소 신청</button>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->