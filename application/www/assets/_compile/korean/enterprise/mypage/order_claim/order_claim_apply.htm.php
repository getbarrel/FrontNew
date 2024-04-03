<?php /* Template_ 2.2.8 2024/03/22 17:11:18 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_apply.htm 000050246 */ 
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<!-- 컨텐츠 S -->
<section class="fb__order-claim fb__mypage-claim--complete fb__return-complete br__return-complete">
	<div class="fb__mypage-title">
		<div class="title-md"><?php echo $TPL_VAR["claimTypeName"]?> 신청</div>
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
	<form id="devClaimApplyForm" method="post">
	<input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
	<section class="fb__mypage__section cancel-area">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<ul class="product-item__wrap">
				<li class="product-item__list no-data" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>">
					<p class="empty-content">선택한 <?php echo $TPL_VAR["claimTypeName"]?>상품이 없습니다..</p>
				</li>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?><?php }else{?>none<?php }?>">
					<!-- 상품 S -->
					<input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' style="display:none" <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="btn-group">
									<button type="button" class="btn-link btn-del" data-odix="<?php echo $TPL_V2["od_ix"]?>">삭제</button>
								</div>
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

					<!-- 부분취소 S -->
					<div class="claim__list__reason reason-box devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])){?><?php }else{?>none<?php }?>">
						<div class="reason-top">
							<div class="title-sm">반품 수량</div>
							<div class="product-quantity__control control">
								<ul class="option-up-down">
<?php if(false){?><li>
										<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus"></i>DOWN</button>
									</li><?php }?>
									<li><input type="text" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devCount option-text" readonly /></li>
<?php if(false){?><li>
										<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus"></i>UP</button>
									</li><?php }?>
								</ul>
							</div>
						</div>
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
							</div>
							<div class="reason-box__cont">
								<div class="fb__form-item devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
									<label for="" class="hide">반품 사유</label>
									<select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>" class="devCcReason" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
											<option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>">Others</option>
<?php }else{?>
											<option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
									</select>
								</div>
<?php if($TPL_VAR["claimTypeName"]=='교환'){?>
									<textarea class="fb__form-textarea devCcMsg" name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="요청사항(변경사이즈, 색상)을 입력해 주세요." maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
<?php }else{?>
									<textarea class="fb__form-textarea devCcMsg" name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="<?php echo $TPL_VAR["claimTypeName"]?> 사유를 작성해 주세요. (최대 100자)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
<?php }?>
								<div class="counting">
									<span><em class="js__counting__num" id="devClaimMsgLength">0</em>/100 자</span>
								</div>
							</div>
						</dl>
					</div>
					<!-- 부분취소 E -->
				</li>
<?php }}?>
			</ul>
<?php }}?>
		</div>
	</section>

	<!-- 부분취소 할 경우 - 취소 상품 선택 영역 S -->
	<section class="fb__mypage__section cancel-area" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품 추가</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"])||($TPL_VAR["odIx"]=='')){?><?php }else{?>none<?php }?>">
					<!-- 상품 S -->
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="btn-group">
									<button type="button" class="btn-link" data-odix="<?php echo $TPL_V2["od_ix"]?>">추가</button>
								</div>
								<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->
				</li>
<?php }}?>
			</ul>
		</div>
<?php }}?>
	</section>
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

	<!-- 반품 사유 영역 S -- 
	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품 발송 방법</div>
		</div>
		<div class="return-type__list">
			<div class="return-type__haed">
				<div class="fb__form-btn send_type__select">
					<div class="fb__form-item">
						<input type="radio" name="send_type" value="2" class="fb__form-radio" id="send_type_2" checked />
						<label for="send_type_2"><span>지정택배 방문</span></label>
					</div>
					<div class="fb__form-item">
						<input type="radio" name="send_type" value="1" class="fb__form-radio" id="send_type_1" />
						<label for="send_type_1"><span>직접 발송</span></label>
					</div>
				</div>
				<div class="return-type__select">
					<div class="fb__form-item">
						<label for="devQuick" class="hide"></label>
						<select class="fb__form-select" id="devQuick">
							<option>배송업체 선택</option>
						</select>
					</div>
				</div>
			</div>
			<div class="return-type__cont">
				<div class="return-type__guide txt-list">
					<p>지정택배 방문 : 배럴과 계약된 택배사에서 방문하여 수거</p>
					<p>직접 발송 : 고객님께서 직접 상품을 발송하는 경우</p>
				</div>
				<div class="return-type__waybill">
					<div class="fb__form-item">
						<label for="devInvoiceNo" class="hide">운송장 번호</label>
						<input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-‘를 제외한 운송장번호를 입력해 주세요." title="송장번호" />
					</div>
					<ul class="fb__form-group">
						<li class="fb__form-item">
							<input type="radio" name="delivery_pay_type" id="delivery_pay_type1" value="1" />
							<label for="delivery_pay_type1">선불 배송</label>
						</li>
						<li class="fb__form-item">
							<input type="radio" name="delivery_pay_type" id="delivery_pay_type2" value="1" />
							<label for="delivery_pay_type2">착불 배송</label>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- 반품 사유 영역 E -->

	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 방법</div>
		</div>
		<div class="delivery-address__select">
			<div class="fb-tab__wrap">
				<div class="fb-tab__nav">
					<ul>
						<li class="active"><a href="#;">직접 발송</a></li>
						<li><a href="#;">지정택배 방문</a></li>
					</ul>
				</div>
				<div class="fb-tab__contents-wrap" id="devDirectDelivery">
					<div class="fb-tab__contents active">
						<ul class="address-list">
							<li class="address-list__item">
								<div class="list-info">
									<select name="quick" id="devQuick" class="devClaimDeliveryCls" title="배송업체">
										<option value="">배송업체 선택</option>
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option><?php }}?>
									</select>
									<input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-’을 제외한 송장번호를 입력해주세요." title="송장번호">
									<input type="checkbox" name="quick_info" value="N" id="devDcompnyApplyChk"><label for="devDcompnyApplyChk">배송업체 정보 입력 안함</label>
								</div>
								<input type="hidden" name="delivery_pay_type" value="1">
								<p class="exchange-method__cont-annc">상품 발송 시 배송비 선불</p>
							</li>
                        </ul>
					</div>
					<div class="fb-tab__contents" id="devClaimAdressForm1">
						<ul class="delivery-info__box">
							<li class="delivery-info__item delivery-info__list-name">
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
										<input type="text" class="fb__form-input devRecipientName" name="cname" id="devCname" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="selectWrap delivery-info__list-phone">
										<div class="fb__form-item">
											<label for="devCmobile1" class="delivery-info__label hide">휴대폰</label>
											<select class="fb__form-select" name="cmobile1" id="devCmobile1">
												<option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
												<option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
												<option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
												<option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
												<option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
												<option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
											</select>
											<input type="text" name="cmobile2" id="devCmobile2" class="fb__form-input devRecipientMobile2" title="받는 분 휴대폰 번호2" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" />
											<input type="text" name="cmobile3" id="devCmobile3" class="fb__form-input devRecipientMobile3" title="받는 분 휴대폰 번호3" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" />
										</div>
									</div>
								</div>
							</li>
							<li class="delivery-info__item">
								<div class="title-sm">주소</div>
								<div class="delivery-info__list delivery-info__list-address">
									<div class="form-info-wrap delivery-info__list-group">
										<div class="fb__form-item">
											<label for="devRecipientZip" class="delivery-info__label hide">주소</label>
											<input type="text" class="fb__form-input zip-code zipcode dim" name="czip" id="devClaim1Zip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>" readonly />
											<button type="button" class="btn-s btn-dark-line " id="devClaim1ZipPopupButton">검색</button>
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-address " name="caddr1" id="devClaim1Address1" title="받는 분 주소" placeholder="주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly />
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-add-detail" name="caddr2" id="devClaim1Address2" title="받는 분 상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>" />
										</div>
									</div>
								</div>
								<div class="delivery-info__list delivery-info__list-request">
									<div class="delivery-request nonmember delivery-info__list__input-area input-area">
										<div class="devDeliveryMessageContents option-box">
											<div class="fb__form-item">
												<div class="fb__form-item">
													<label for="cmsg" class="hide">배송 요청사항 입력</label>
													<input type="text" class="fb__form-input" name="cmsg" id="cmsg" placeholder="배송 요청사항을 입력해 주세요." value="" />
												</div>
											</div>
										</div>
										<!-- <div class="devEachDeliveryMessageContents option-box-each">
											<div class="fb__form-item">
												<label for="devDeliveryMessageSelectBox1" class="delivery-info__label hide">배송요청사항</label>
												<select class="fb__form-select devDeliveryMessageSelectBox" id="devDeliveryMessageSelectBox1">
													<option value="">배송요청사항 선택</option>
													<option>부재 시 경비실에 맡겨주세요.</option>
													<option>부재 시 휴대폰으로 연락주세요.</option>
													<option>집 앞에 놓아주세요.</option>
													<option>배송 전에 연락주세요.</option>
													<option value="direct">직접입력</option>
												</select>
											</div>
											<div class="devDeliveryMessageDirectContents write-area">
												<div class="fb__form-item">
													<label for="devDeliveryMessage6" class="hide">배송 요청사항 입력</label>
													<input type="text" class="fb__form-input devDeliveryMessage" id="devDeliveryMessage6" placeholder="배송 요청사항을 입력해 주세요." value="" />
												</div>
												<div class="counting">
													<span><em class="devDeliveryMessageByte">0</em>/30 자</span>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
<?php if($TPL_VAR["claimType"]=='change'){?>
		<br>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소</div>
		</div>
		<div class="delivery-address__select" id="devClaimAdressForm2">
			<div class="fb-tab__wrap">
				<div class="fb-tab__contents-wrap" id="devDirectDelivery">
					<div class="fb-tab__contents active" id="devClaimAdressForm1">
						<ul class="delivery-info__box">
							<li class="delivery-info__item delivery-info__list-name">
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
										<input type="text" class="fb__form-input" name="rname" id="devRname" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="selectWrap delivery-info__list-phone">
										<div class="fb__form-item">
											<label for="devRmobile1" class="delivery-info__label hide">휴대폰</label>
											<select class="fb__form-select" name="rmobile1" id="devRmobile1">
												<option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
												<option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
												<option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
												<option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
												<option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
												<option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
											</select>
											<input type="text" name="rmobile2" id="devRmobile2" class="fb__form-input" title="받는 분 휴대폰 번호2" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" />
											<input type="text" name="rmobile3" id="devRmobile3" class="fb__form-input" title="받는 분 휴대폰 번호3" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" />
										</div>
									</div>
								</div>
							</li>
							<li class="delivery-info__item">
								<div class="title-sm">주소</div>
								<div class="delivery-info__list delivery-info__list-address">
									<div class="form-info-wrap delivery-info__list-group">
										<div class="fb__form-item">
											<label for="devClaim2Zip" class="delivery-info__label hide">주소</label>
											<input type="text" class="fb__form-input zip-code zipcode dim" name="rzip" id="devClaim2Zip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>" readonly />
											<button type="button" class="btn-s btn-dark-line " id="devClaim2ZipPopupButton">검색</button>
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-address " name="raddr1" id="devClaim2Address1" title="받는 분 주소" placeholder="주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly />
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-add-detail" name="raddr2" id="devClaim2Address2" title="받는 분 상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>" />
										</div>
									</div>
								</div>
								<div class="delivery-info__list delivery-info__list-request">
									<div class="delivery-request nonmember delivery-info__list__input-area input-area">
										<div class="devDeliveryMessageContents option-box">
											<div class="fb__form-item">
												<label for="rmsg" class="hide">배송 요청사항 입력</label>
												<input type="text" class="fb__form-input" name="rmsg" id="rmsg" placeholder="배송 요청사항을 입력해 주세요." value="" />
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
<?php }?>
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
				<button type="button" class="btn-lg btn-dark-line" id="devPrevBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">취소</button>
				<button type="button" class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">반품 신청</button>
			</div>
		</div>
	</section>
	</form>
</section>
<?php }else{?>
<section class="fb__order-claim fb__mypage-claim--complete fb__return-complete br__return-complete">
	<div class="fb__mypage-title">
		<div class="title-md"><?php echo $TPL_VAR["claimTypeName"]?> 신청</div>
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
	<form id="devClaimApplyForm" method="post">
	<input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
	<section class="fb__mypage__section cancel-area">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<ul class="product-item__wrap">
				<li class="product-item__list no-data" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>">
					<p class="empty-content">선택한 <?php echo $TPL_VAR["claimTypeName"]?>상품이 없습니다..</p>
				</li>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?><?php }else{?>none<?php }?>">
					<!-- 상품 S -->
					<input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' style="display:none" <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span><?php echo $TPL_V2["pcnt"]?>개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="btn-group">
									<button type="button" class="btn-link btn-del" data-odix="<?php echo $TPL_V2["od_ix"]?>">삭제</button>
								</div>
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

					<!-- 부분취소 S -->
					<div class="claim__list__reason reason-box devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])){?><?php }else{?>none<?php }?>">
						<div class="reason-top">
							<div class="title-sm">반품 수량</div>
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
						<dl class="reason-box__inner">
							<div class="reason-box__title">
								<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 사유</div>
							</div>
							<div class="reason-box__cont">
								<div class="fb__form-item devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
									<label for="" class="hide">반품 사유</label>
									<select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>" class="devCcReason" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
											<option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>">Others</option>
<?php }else{?>
											<option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
									</select>
								</div>
<?php if($TPL_VAR["claimTypeName"]=='교환'){?>
									<textarea class="fb__form-textarea devCcMsg" name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="요청사항(변경사이즈, 색상)을 입력해 주세요." maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
<?php }else{?>
									<textarea class="fb__form-textarea devCcMsg" name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="<?php echo $TPL_VAR["claimTypeName"]?> 사유를 작성해 주세요. (최대 100자)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
<?php }?>
								<div class="counting">
									<span><em class="js__counting__num" id="devClaimMsgLength">0</em>/100 자</span>
								</div>
							</div>
						</dl>
					</div>
					<!-- 부분취소 E -->
				</li>
<?php }}?>
			</ul>
<?php }}?>
		</div>
	</section>

	<!-- 부분취소 할 경우 - 취소 상품 선택 영역 S -->
	<section class="fb__mypage__section cancel-area" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 신청 상품 추가</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="product-item__list devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"])||($TPL_VAR["odIx"]=='')){?><?php }else{?>none<?php }?>">
					<!-- 상품 S -->
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
									<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
										<span class="set-name"><?php echo $TPL_V2["option_text"]?></span>
<?php if($TPL_V2["add_info"]){?><span><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span>1개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="btn-group">
									<button type="button" class="btn-link" data-odix="<?php echo $TPL_V2["od_ix"]?>">추가</button>
								</div>
								<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->
				</li>
<?php }}?>
			</ul>
		</div>
<?php }}?>
	</section>
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

	<!-- 반품 사유 영역 S -- 
	<section class="fb__mypage__section return-info">
		<div class="fb__mypage-title">
			<div class="title-sm">반품 발송 방법</div>
		</div>
		<div class="return-type__list">
			<div class="return-type__haed">
				<div class="fb__form-btn send_type__select">
					<div class="fb__form-item">
						<input type="radio" name="send_type" value="2" class="fb__form-radio" id="send_type_2" checked />
						<label for="send_type_2"><span>지정택배 방문</span></label>
					</div>
					<div class="fb__form-item">
						<input type="radio" name="send_type" value="1" class="fb__form-radio" id="send_type_1" />
						<label for="send_type_1"><span>직접 발송</span></label>
					</div>
				</div>
				<div class="return-type__select">
					<div class="fb__form-item">
						<label for="devQuick" class="hide"></label>
						<select class="fb__form-select" id="devQuick">
							<option>배송업체 선택</option>
						</select>
					</div>
				</div>
			</div>
			<div class="return-type__cont">
				<div class="return-type__guide txt-list">
					<p>지정택배 방문 : 배럴과 계약된 택배사에서 방문하여 수거</p>
					<p>직접 발송 : 고객님께서 직접 상품을 발송하는 경우</p>
				</div>
				<div class="return-type__waybill">
					<div class="fb__form-item">
						<label for="devInvoiceNo" class="hide">운송장 번호</label>
						<input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-‘를 제외한 운송장번호를 입력해 주세요." title="송장번호" />
					</div>
					<ul class="fb__form-group">
						<li class="fb__form-item">
							<input type="radio" name="delivery_pay_type" id="delivery_pay_type1" value="1" />
							<label for="delivery_pay_type1">선불 배송</label>
						</li>
						<li class="fb__form-item">
							<input type="radio" name="delivery_pay_type" id="delivery_pay_type2" value="1" />
							<label for="delivery_pay_type2">착불 배송</label>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- 반품 사유 영역 E -->

	<section class="fb__mypage__section delivery-info">
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?> 방법</div>
		</div>
		<div class="delivery-address__select">
			<div class="fb-tab__wrap">
				<div class="fb-tab__nav">
					<ul>
						<li class="active"><a href="#;">직접 발송</a></li>
						<li><a href="#;">지정택배 방문</a></li>
					</ul>
				</div>
				<div class="fb-tab__contents-wrap" id="devDirectDelivery">
					<div class="fb-tab__contents active">
						<ul class="address-list">
							<li class="address-list__item">
								<div class="list-info">
									<select name="quick" id="devQuick" class="devClaimDeliveryCls" title="배송업체">
										<option value="">배송업체 선택</option>
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option><?php }}?>
									</select>
									<input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-’을 제외한 송장번호를 입력해주세요." title="송장번호">
									<input type="checkbox" name="quick_info" value="N" id="devDcompnyApplyChk"><label for="devDcompnyApplyChk">배송업체 정보 입력 안함</label>
								</div>
								<input type="hidden" name="delivery_pay_type" value="1">
								<p class="exchange-method__cont-annc">상품 발송 시 배송비 선불</p>
							</li>
                        </ul>
					</div>
					<div class="fb-tab__contents" id="devClaimAdressForm1">
						<ul class="delivery-info__box">
							<li class="delivery-info__item delivery-info__list-name">
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
										<input type="text" class="fb__form-input devRecipientName" name="cname" id="devCname" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="selectWrap delivery-info__list-phone">
										<div class="fb__form-item">
											<label for="devCmobile1" class="delivery-info__label hide">휴대폰</label>
											<select class="fb__form-select" name="cmobile1" id="devCmobile1">
												<option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
												<option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
												<option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
												<option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
												<option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
												<option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
											</select>
											<input type="text" name="cmobile2" id="devCmobile2" class="fb__form-input devRecipientMobile2" title="받는 분 휴대폰 번호2" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" />
											<input type="text" name="cmobile3" id="devCmobile3" class="fb__form-input devRecipientMobile3" title="받는 분 휴대폰 번호3" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" />
										</div>
									</div>
								</div>
							</li>
							<li class="delivery-info__item">
								<div class="title-sm">주소</div>
								<div class="delivery-info__list delivery-info__list-address">
									<div class="form-info-wrap delivery-info__list-group">
										<div class="fb__form-item">
											<label for="devRecipientZip" class="delivery-info__label hide">주소</label>
											<input type="text" class="fb__form-input zip-code zipcode dim" name="czip" id="devClaim1Zip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>" readonly />
											<button type="button" class="btn-s btn-dark-line " id="devClaim1ZipPopupButton">검색</button>
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-address " name="caddr1" id="devClaim1Address1" title="받는 분 주소" placeholder="주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly />
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-add-detail" name="caddr2" id="devClaim1Address2" title="받는 분 상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>" />
										</div>
									</div>
								</div>
								<div class="delivery-info__list delivery-info__list-request">
									<div class="delivery-request nonmember delivery-info__list__input-area input-area">
										<div class="devDeliveryMessageContents option-box">
											<div class="fb__form-item">
												<div class="fb__form-item">
													<label for="cmsg" class="hide">배송 요청사항 입력</label>
													<input type="text" class="fb__form-input" name="cmsg" id="cmsg" placeholder="배송 요청사항을 입력해 주세요." value="" />
												</div>
											</div>
										</div>
										<!-- <div class="devEachDeliveryMessageContents option-box-each">
											<div class="fb__form-item">
												<label for="devDeliveryMessageSelectBox1" class="delivery-info__label hide">배송요청사항</label>
												<select class="fb__form-select devDeliveryMessageSelectBox" id="devDeliveryMessageSelectBox1">
													<option value="">배송요청사항 선택</option>
													<option>부재 시 경비실에 맡겨주세요.</option>
													<option>부재 시 휴대폰으로 연락주세요.</option>
													<option>집 앞에 놓아주세요.</option>
													<option>배송 전에 연락주세요.</option>
													<option value="direct">직접입력</option>
												</select>
											</div>
											<div class="devDeliveryMessageDirectContents write-area">
												<div class="fb__form-item">
													<label for="devDeliveryMessage6" class="hide">배송 요청사항 입력</label>
													<input type="text" class="fb__form-input devDeliveryMessage" id="devDeliveryMessage6" placeholder="배송 요청사항을 입력해 주세요." value="" />
												</div>
												<div class="counting">
													<span><em class="devDeliveryMessageByte">0</em>/30 자</span>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
<?php if($TPL_VAR["claimType"]=='change'){?>
		<br>
		<div class="fb__mypage-title">
			<div class="title-sm"><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소</div>
		</div>
		<div class="delivery-address__select" id="devClaimAdressForm2">
			<div class="fb-tab__wrap">
				<div class="fb-tab__contents-wrap" id="devDirectDelivery">
					<div class="fb-tab__contents active" id="devClaimAdressForm1">
						<ul class="delivery-info__box">
							<li class="delivery-info__item delivery-info__list-name">
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
										<input type="text" class="fb__form-input" name="rname" id="devRname" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="selectWrap delivery-info__list-phone">
										<div class="fb__form-item">
											<label for="devRmobile1" class="delivery-info__label hide">휴대폰</label>
											<select class="fb__form-select" name="rmobile1" id="devRmobile1">
												<option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
												<option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
												<option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
												<option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
												<option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
												<option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
											</select>
											<input type="text" name="rmobile2" id="devRmobile2" class="fb__form-input" title="받는 분 휴대폰 번호2" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" />
											<input type="text" name="rmobile3" id="devRmobile3" class="fb__form-input" title="받는 분 휴대폰 번호3" placeholder="0000" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" />
										</div>
									</div>
								</div>
							</li>
							<li class="delivery-info__item">
								<div class="title-sm">주소</div>
								<div class="delivery-info__list delivery-info__list-address">
									<div class="form-info-wrap delivery-info__list-group">
										<div class="fb__form-item">
											<label for="devClaim2Zip" class="delivery-info__label hide">주소</label>
											<input type="text" class="fb__form-input zip-code zipcode dim" name="rzip" id="devClaim2Zip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>" readonly />
											<button type="button" class="btn-s btn-dark-line " id="devClaim2ZipPopupButton">검색</button>
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-address " name="raddr1" id="devClaim2Address1" title="받는 분 주소" placeholder="주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly />
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-add-detail" name="raddr2" id="devClaim2Address2" title="받는 분 상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>" />
										</div>
									</div>
								</div>
								<div class="delivery-info__list delivery-info__list-request">
									<div class="delivery-request nonmember delivery-info__list__input-area input-area">
										<div class="devDeliveryMessageContents option-box">
											<div class="fb__form-item">
												<label for="rmsg" class="hide">배송 요청사항 입력</label>
												<input type="text" class="fb__form-input" name="rmsg" id="rmsg" placeholder="배송 요청사항을 입력해 주세요." value="" />
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
<?php }?>
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
				<button type="button" class="btn-lg btn-dark-line">취소</button>
				<button type="button" class="btn-lg btn-dark">반품 신청</button>
			</div>
		</div>
	</section>
	</form>
</section>
<?php }?>
<!-- 컨텐츠 E -->