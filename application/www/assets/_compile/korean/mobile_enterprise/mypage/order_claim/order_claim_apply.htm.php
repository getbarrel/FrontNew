<?php /* Template_ 2.2.8 2024/03/22 17:48:44 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_apply.htm 000019665 */ 
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<form id="devClaimApplyForm" method="post">
    <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
	<!-- 컨텐츠 S -->
	<section class="br__order-claim">
		<div class="page-title my-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청</div>
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
					<div id="devTitle" class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
				</div>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<ul class="product-list">
					<!-- 상품없음 S --
					<li class="product-list__item no-data" style="display: none">
						<p class="empty-content">선택한 반품 신청 상품이 없습니다.</p>
					</li>
					<!-- 상품없음 E -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="product-list__item devBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_VAR["odIx"]==''||$TPL_VAR["odIx"]==$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
						<input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' style="display:" <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >
						<div class="product-list__item-top">
							<button type="button" class="btn-sm btn-line-no" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> 삭제</button>
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
									</div>

									<div class="product-list__info__price">
										<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
										<span class="product-list__info__status">배송완료</span>
									</div>
								</div>
							</dd>
						</dl>
						<!-- 상품 E -->

						<!-- 반품 신청 영역 S -->
						<div class="reason-box">
							<div class="reason-top">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 수량</div>
								<div class="product-quantity__control control">
									<ul class="option-up-down devControlCntBox">
<?php if(false){?><li class="devCntMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="down"></button></li><?php }?>
										<li><input type="text" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="br__form-input devPcnt" readonly></li>
<?php if(false){?><li class="devCntPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="up "></button></li><?php }?>
									</ul>
								</div>
							</div>

							<!-- 반품 신청 폼 S -->
							<dl class="reason-box__inner devExchangeCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
								<div class="reason-box__title">
									<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
								</div>
								<div class="reason-box__cont">
									<div class="br__form-item" data-odix="<?php echo $TPL_V2["od_ix"]?>">
										<label for="" class="hide">반품</label>
										<select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]"  class="br__form-select devClaimReason" data-odix="<?php echo $TPL_V2["od_ix"]?>" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
											<option value="<?php echo $TPL_K3?>"><?php echo $TPL_V3["title"]?></option>
<?php }}?>
										</select>
									</div>
<?php if($TPL_VAR["claimTypeName"]=='교환'){?>
										<textarea name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="요청사항(변경사이즈, 색상)을 입력해 주세요.(최대 100자)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>" class="br__form-textarea devCcMsg" title="<?php echo $TPL_VAR["claimTypeName"]?> 사유"></textarea>
										<span style="color:#000;font-size:1rem;line-height:1.5rem;">※불량상품의 경우, 고객센터 혹은 1:1문의로 교환/환불접수 부탁드립니다.</span><br>
										<span style="color:#000;font-size:1rem;line-height:1.5rem;">※교환 신청하신 제품이 품절일 경우, 환불로 진행될 수 있음을 안내드립니다.</span>
<?php }else{?>
										<textarea name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="<?php echo $TPL_VAR["claimTypeName"]?> 사유를 작성해 주세요. (최대 100자)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>" class="br__form-textarea devCcMsg" title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
<?php }?>
								</div>
							</dl>
							<!-- 반품 신청 폼 E -->
						</div>
						<!-- 반품 신청 영역 E -->
					</li>
<?php }}?>
				</ul>
<?php }}?>
			</div>
			<!-- 주문 내역 - 리스트 E -->

			<!-- 반품 신청 상품 추가 상품 선택 영역 S -->
			<div class="cancel-area" id="devClaimItemSec1" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
				<div class="br__mypage-title">
					<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>신청 상품 추가</div>
				</div>
				<!-- 주문 내역 - 리스트 S -->
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<div class="cancel-area__list">
					<ul class="product-list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li class="product-list__item devBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>"  style="display:<?php if(($TPL_VAR["odIx"]!=''&&$TPL_VAR["odIx"]!=$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
							<div class="product-list__item-top">
								<button type="button" class="btn-sm btn-line-no order-claim__goods__toggle" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> 추가</button>
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
										<!-- 세트 상품 E -->

										<div class="product-list__info__price">
											<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											<span class="product-list__info__status">배송완료</span>
										</div>
									</div>
								</dd>
							</dl>
							<!-- 상품 E -->
						</li>
<?php }}?>
					</ul>
				</div>
<?php }}?>
				<!-- 주문 내역 - 리스트 E -->
			</div>
			<!-- 반품 신청 상품 추가 상품 선택 영역 E -->

			<!-- 반품 발송 방법 영역 S -->
			<div class="pay-comp__wrap return-info">
				<div class="br__mypage-title">
					<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 방법</div>
				</div>
				<div class="return-type__list">
					<div class="br__form-btn send_type__select">
						<input type="hidden" name="send_type" value="1">
						<div class="br__form-item">
							<input type="radio" name="send_type" data-type="1" value="1" class="br__form-radio devSendTypeCls" id="send_type_1" />
							<label for="send_type_1"><span>직접 발송</span></label>
						</div>
						<div class="br__form-item">
							<input type="radio" name="send_type" data-type="2" value="2" class="br__form-radio devSendTypeCls" id="send_type_2"  />
							<label for="send_type_2"><span>지정택배 방문</span></label>
						</div>
					</div>


					<div class="return-type__guide txt-list">
						<p id="devMethod1">직접 발송 : 고객님께서 직접 상품을 발송하는 경우</p>
						<p id="devMethod2" style="display:none;">지정택배 방문 : 배럴과 계약된 택배사에서 방문하여 수거</p>
					</div>
				</div>
			</div>

			<!--배송 정보 S -->
			<div class="pay-comp__wrap address" id="devClaimAdressForm" style="display:none;">
				<div class="br__mypage-title">
					<div class="title-sm">반품 수거 주소</div>
				</div>
				<div class="pay-comp__address">
					<div class="br__infoinput">
						<div class="br-tab__wrap">
							<!--<div class="br-tab__nav">
								<ul>
									<li id="collect_address_type1" class="active" data-target="list" devRecipientTypeSelect="address"><a href="#;">최근 배송지</a></li>
									<li id="collect_address_type2" data-target="new"  devRecipientTypeSelect="input"><a href="#;">신규 배송지</a></li>
								</ul>
							</div>-->
							<div class="br-tab__contents-wrap devRecipientContents">
								<!--<div class="br-tab__contents active">
									<div class="info-addr">
										<div class="info-addr__recent">
											<button type="button" class="info-addr__recent__btn" id="devCollectAddressListButton">배송 주소록</button>
											<ul id="devCollectAddressListContent" class="info-addr__recent__list">
												<li class="br-loading devForbizTpl" id="devCollectAddressListLoading">
													<div class="info">
														<p class="name"><strong>Loading ...</strong></p>
													</div>
												</li>

												<li class="info-addr__recent__box no-data devForbizTpl" id="devCollectAddressListEmpty">
													<p class="empty-content">등록된 배송지가 없습니다.</p>
												</li>
												&lt;!&ndash; 등록된 배송지가 없을 경우 E &ndash;&gt;
												&lt;!&ndash;<?php echo '<script type="text/x-forbiz-template" id="devCollectAddressList">'?>&ndash;&gt;
												<li class="info-addr__recent__box devOrderAddress">
													<div class="info-addr__recent__info">
														<div class="info-addr__recent__name">{{[recipient]}} {{[#if isBasic]}}<span>(기본)</span>{{[/if]}}</div>
														<div class="info-addr__recent__addr">{{[zipcode]}} / {{[address1]}} {{[address2]}}</div>
														<div class="info-addr__recent__phone">{{[mobile]}}</div>
													</div>
													<input type="radio" class="devOrderAddressRadio" name="orderCAddress" data-rname="{{[recipient]}}" data-address1="{{[address1]}}" data-address2="{{[address2]}}" data-mobile="{{[mobile]}}" data-zipcode="{{[zipcode]}}" value="{{[index]}}" {{[#if isBasic]}} checked {{[/if]}}>
												</li>
												&lt;!&ndash;<?php echo '</script>'?>&ndash;&gt;
											</ul>
										</div>
									</div>
								</div>-->
								<div class="br-tab__contents devRecipientContents active">
									<div class="info-buyer">
										<div class="info-buyer__form">
											<label for="devCname" class="info-buyer__form__label">이름</label>
											<input type="text" id="devCname" name="cname" class="devRecipientName" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>" />
										</div>
										<div class="info-buyer__form info-buyer__form--phone">
											<label for="devCmobile1" class="info-buyer__form__label">휴대폰</label>
											<div class="flexWrap">
												<select id="devCmobile1" name="cmobile1" class="info-buyer__form__select devRecipientMobile1">
													<option value="" selected>선택</option>
													<option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
													<option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
													<option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
													<option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
													<option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
													<option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
												</select>
												<input type="number" name="cmobile2" id="devCmobile2" class="info-buyer__form__input devRecipientMobile2" title="받는 분 휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" />
												<input type="number" name="cmobile3" id="devCmobile3" class="info-buyer__form__input devRecipientMobile3" title="받는 분 휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" />
											</div>
										</div>
										<div class="info-buyer__form info-buyer__form--addr">
											<label class="info-buyer__form__label">주소</label>
											<div class="info-buyer__form__find-addr">
												<input type="text" class="info-buyer__form__input"  name="czip" id="devClaim1Zip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>"  readonly>
												<button type="button" class="info-buyer__form__btn devClaim1ZipPopupButton">검색</button>
											</div>
											<input type="text" class="info-buyer__form__input devRecipientAddr1" name="caddr1" id="devClaim1Address1" title="수거지 주소" placeholder="주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly/>
											<input type="text" class="info-buyer__form__input devRecipientAddr2" name="caddr2" id="devClaim1Address2" title="상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>" />
										</div>
									</div>
								</div>
							</div>
							<div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
								<div class="info-buyer__form__direct devDeliveryMessageDirectContents">
									<input type="text" class="info-buyer__form__input devDeliveryMessage" name="cmsg" id="cmsg" placeholder="배송 메시지 입력" value="" devmaxlength="30" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--배송 정보 E -->

			<!-- 직접 발송 S -->
			<div class="pay-comp__wrap directly" id="devDirectDelivery">
				<div class="br__mypage-title">
					<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 발송 정보</div>
				</div>
				<div class="pay-comp__directly">
					<div class="return-type__select" id="devDeliveryInfo">
						<div class="br__form-item">
							<label for="devQuick" class="hidden">배송업체 선택</label>
							<select  name="quick" id="devQuick" class="br__form-select devClaimDeliveryCls">
								<option>배송업체 선택</option>
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option><?php }}?>
							</select>
						</div>
					</div>
					<div class="return-type__waybill">
						<div class="br__form-item">
							<label for="devInvoiceNo" class="hide">운송장 번호</label>
							<input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-‘를 제외한 운송장번호를 입력해 주세요." title="송장번호" />
						</div>
						<ul class="br__form-group" style="width:0;height:0;overflow:hidden;opacity:0;">
						<input type="hidden" name="delivery_pay_type" value="1">
							<li class="br__form-item">
								<input type="radio" name="delivery_pay_type" id="delivery_pay_type1" value="1" />
								<label for="delivery_pay_type1">선불 배송</label>
								<span class="on devPayType" id="devPayType1" data-type="1">
							</li>
							<li class="br__form-item">
								<input type="radio" name="delivery_pay_type" id="delivery_pay_type2" value="1" />
								<label for="delivery_pay_type2">착불 배송</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- 직접 발송 E -->
			<!-- 반품 발송 방법 영역 E -->

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
			<button type="button" class="btn-lg btn-dark-line" id="devPrevBtn">취소</button>
			<button type="button" class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">반품 신청</button>
		</div>
	</section>
	<!-- 컨텐츠 E -->
</form>
<?php }?>

<form id="devCollectAddressListForm"></form>