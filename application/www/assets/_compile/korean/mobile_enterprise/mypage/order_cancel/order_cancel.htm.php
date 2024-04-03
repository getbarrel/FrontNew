<?php /* Template_ 2.2.8 2024/02/21 17:40:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_cancel/order_cancel.htm 000012232 */ ?>
<!-- 컨텐츠 S -->
<section class="br__order-claim">
	<div class="page-title my-title">
		<div class="title-sm">주문취소</div>
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
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm">취소 신청 상품</div>
			</div>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<ul class="product-list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-list__item devCancelBoxOn devCancelArea" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-pcnt="<?php echo $TPL_V2["pcnt"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["allSelected"]=='Y')){?>block<?php }else{?>none<?php }?>">
					<input type="hidden" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" value='<?php echo $TPL_V2["od_ix"]?>'>
					<!-- 부분 취소 일 때 S -->
<?php if($TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["cancelAbleCnt"]> 1){?>
						<!--사은품 포함 시 부분취소 불가 처리 를 위한 버튼 노출 제어 2020-01-08 -->
<?php if($TPL_VAR["partCancelBool"]==true){?>
						<button class="btn-sm btn-line-no devCancelMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-cancel="Y">삭제</button>
<?php }?>
<?php }?>
					<!-- 부분 취소 일 때 E -->

					<!-- 상품 S -->
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["pname"]?>">
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>

								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
<?php if($TPL_V2["add_info"]){?><span class="color"><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span class="size"><?php echo $TPL_V2["option_text"]?></span>
										<span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									<span class="product-list__info__status"><?php echo trans($TPL_V2["status_text"])?></span>
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->

					<!-- 사은품 S -- 
					<div class="product-list__freebie">
						<div class="product-list__freebie__title"><span>구매 사은품</span></div>
						<ul class="product-list__freebie__list">
							<li class="product-list__freebie__box">
								<div class="product-list__freebie__thumb">
									<figure>
										<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
									</figure>
								</div>
								<div class="product-list__freebie__info">
									<div class="product-list__freebie__name">[사은품] 키즈 데이지 튜브</div>
									<div class="product-list__freebie__option">
										<div class="product-list__freebie__option-item">
											<span>페일네온옐로우</span>
											<span>OS</span>
											<span>1개</span>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					-- 사은품 E -->

					<!-- 주문 취소 영역(입금대기&입금완료) S -->
					<div class="reason-box">
						<div class="reason-top">
							<div class="title-sm">취소 수량</div>
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
								<div class="cancel-quantity"><em><?php echo $TPL_V2["pcnt"]?></em>개</div>
								<input type="hidden" name="pcnt" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devPcnt">
<?php }else{?>
								<div class="product-quantity__control control">
									<ul class="option-up-down devControlCntBox">
										<li class="devCntMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>" <?php if($TPL_VAR["order"]["status"]!='IC'){?> disabled="true" <?php }?>><button class="down"></button></li>
										<li><input type="text" name="pcnt" value="<?php echo $TPL_V2["pcnt"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>"  class="br__form-input devAddCount" readonly/></li>
										<li class="devCntPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>" <?php if($TPL_VAR["order"]["status"]!='IC'){?> disabled="true" <?php }?>><button class="up"></button></li>
									</ul>
								</div>
<?php }?>
						</div>
						<!-- 주문 취소 폼(입금완료) S -->
						<dl class="reason-box__inner">
							<div class="reason-box__cont">
								<div class="br__form-item devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
									<label for="" class="hide">취소사유</label>
                                    <select name="cc_reason" class="br__form-select devCcReason" data-odix="<?php echo $TPL_V2["od_ix"]?>">
<?php if(is_array($TPL_R3=($TPL_VAR["cancelReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
                                        <option value="<?php echo $TPL_K3?>">Others</option>
<?php }else{?>
                                        <option value="<?php echo $TPL_K3?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
                                    </select>
								</div>
								<textarea placeholder="취소 사유를 작성해 주세요. (최대 100자)" name="cc_msg[<?php echo $TPL_V2["od_ix"]?>]" data-odIx="<?php echo $TPL_V2["od_ix"]?>" maxlength="100" class="br__form-textarea devCcMsg"></textarea>
							</div>
						</dl>
						<!-- 주문 취소 폼(입금완료) E -->
					</div>
					<!-- 주문 취소 영역(입금대기&입금완료) E -->
				</li>
<?php }}else{?>
				<li class="product-list__item no-data">
					<p class="empty-content">선택한 취소 신청 상품이 없습니다.</p>
				</li>
<?php }?>
			</ul>
<?php }}?>
		</div>
		<!-- 주문 내역 - 리스트 E -->

		<!-- 부분취소 할 경우 - 취소 상품 선택 영역 S -->
		<div class="cancel-area" id="devCancelItemSec1" style="display:<?php if($TPL_VAR["cancelAbleCnt"]> 1&&$TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["partCancelBool"]==true){?>block<?php }else{?>none<?php }?>">
			<div class="br__mypage-title">
				<div class="title-sm">취소 신청 상품 추가</div>
			</div>
			<!-- 주문 내역 - 리스트 S -->
			<div class="cancel-area__list">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<ul class="product-list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="product-list__item devCancelBoxOff"  data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_VAR["odIx"]!=''&&$TPL_VAR["odIx"]!=$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
						<div class="product-list__item-top">
							<button class="btn-sm btn-line-no devCancelPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-cancel="Y">추가</button>
						</div>
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

									<div class="product-list__info__price">
										<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
										<span class="product-list__info__status"><?php echo trans($TPL_V2["status_text"])?></span>
									</div>
								</div>
							</dd>
						</dl>
						<!-- 상품 E -->
					</li>
<?php }}?>
				</ul>
<?php }}?>
			</div>
			<!-- 주문 내역 - 리스트 E -->
		</div>
		<!-- 부분취소 할 경우 - 취소 상품 선택 영역 E -->


		<!--결제 정보 S -->
<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">환불 내역</div>
			</div>
			<div class="pay-comp__payment">
				<dl class="pay-comp__payment__total">
					<dt>환불 예정 금액</dt>
					<dd><em>1,265,550</em>원</dd>
				</dl>

				<!-- 가상 계좌 결제 시 노출 S -->
				<!-- 숨김 처리 -->
				<div class="pay-comp__payment__virtual" style="display: none">
					<div class="title-sm">입금 정보</div>
					<div class="pay-comp__payment__virtual-text">
						기업은행 / 계좌번호 : <em>48002668997451</em> /<br />
						예금주 : 주식회사 배럴
					</div>
					<div class="layout-flex txt-red">
						<span>입금 기한</span>
						<span>2024년 12월 31일까지</span>
					</div>
				</div>
				<!-- 가상 계좌 결제 시 노출 E -->

				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>결제방법</dt>
						<dd>

							가상계좌 / 기업은행 48002668997451<br />
							예금주 : 주식회사 배럴
						</dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>취소 신청 총 결제금액</dt>
						<dd><em>1,405,550</em>원</dd>
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
<?php }?>
		<!--결제 정보 E -->
		
		<div class="use-notice">
			<h3 class="use-notice__title">유의사항</h3>
			<ul class="use-notice__list">
				<li class="use-notice__desc">신용카드, 간편결제, 실시간 계좌이체는 자동 환불 처리됩니다.</li>
				<li class="use-notice__desc">결제 시 사용하신 적립금은 내부정책에 따라 취소신청 완료 후 환불 처리됩니다.</li>
			</ul>
		</div>
	</section>
	<div class="br__order-footer">
		<button type="button" class="btn-lg btn-dark-line" id="devClaimCancel">취소</button>
		<button type="button" class="btn-lg btn-dark" id="devClaimApply">취소 신청</button>
	</div>
</section>
<!-- 컨텐츠 E -->