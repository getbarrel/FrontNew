<?php /* Template_ 2.2.8 2024/03/03 15:49:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_cancel_complete/order_cancel_complete.htm 000006629 */ ?>
<!-- 컨텐츠 S -->
			<section class="br__order-claim">
				<div class="page-title my-title">
					<div class="title-sm">주문 취소 신청이 완료되었습니다.</div>
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
							<dd class="order-day"><?php echo str_replace('-','.',$TPL_VAR["order"]["order_date"])?></dd>
						</dl>
					</div>
				</div>
				<div class="br__order-claim--desc">취소처리 현황은 <span>마이페이지 > 반품/취소 내역</span>에서 확인하실 수 있습니다.</div>
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
<?php if($TPL_V2["status"]=='CC'||$TPL_V2["status"]=='IB'){?>
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
											<div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>

											<!-- 세트 상품 S -->
											<!-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 -->
											<div class="product-list__info__option">
												<div class="product-list__info__option-item">
													<span class="color"><?php echo $TPL_V2["add_info"]?></span>
													<span class="color"><?php echo $TPL_V2["option_text"]?></span>
													<span class="count"><?php echo number_format($TPL_VAR["restOrderDetail"][$TPL_V2["pid"]]['rest_cnt']+$TPL_V2["pcnt"])?>개</span>
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

								<!-- 주문 취소 영역 S -->
								<div class="reason-box">
									<div class="reason-top">
										<div class="title-sm">취소 수량</div>
										<div class="cancel-quantity"><em><?php echo $TPL_V2["pcnt"]?></em>개</div>
									</div>
									<dl class="reason-box__inner">
										<div class="reason-box__title">
											<div class="title-sm">취소 사유</div>
											<div class="reason-box__text"><?php echo trans($TPL_VAR["reason_data"][$TPL_V2["pid"]]['reason_text'])?></div>
										</div>
										<div class="reason-box__cont">
											<div class="reason-box__desc"><?php echo nl2br($TPL_VAR["reason_data"][$TPL_V2["pid"]]['status_message'])?></div>
										</div>
									</dl>
								</div>
								<!-- 주문 취소 영역 E -->
							</li>
<?php }?>
<?php }}?>
						</ul>
<?php }}?>
					</div>
					<!-- 주문 내역 - 리스트 E -->

					<!--결제 정보 S -- 
					<div class="pay-comp__wrap payment">
						<div class="br__mypage-title">
							<div class="title-sm">환불 내역</div>
						</div>
						<div class="pay-comp__payment">
							<dl class="pay-comp__payment__total">
								<dt>환불 예정 금액</dt>
								<dd><em>1,265,550</em>원</dd>
							</dl>

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
					<button type="button" class="btn-lg btn-dark-line" onClick="location.href='/mypage/orderHistory'">주문 내역 조회</button>
					<button type="button" class="btn-lg btn-dark" onClick="location.href='/mypage/returnHistory'">반품/취소 내역</button>
				</div>
			</section>
			<!-- 컨텐츠 E -->