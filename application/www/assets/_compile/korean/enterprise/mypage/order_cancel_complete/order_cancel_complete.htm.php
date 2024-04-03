<?php /* Template_ 2.2.8 2024/03/03 21:30:17 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_cancel_complete/order_cancel_complete.htm 000007158 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage-claim--complete wrap-claim-complete">
	<div class="fb__mypage-title">
		<div class="title-md">주문 취소 신청이 완료되었습니다.</div>
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
	<div class="fb__mypage-claim--desc">취소 처리 현황은 <a href="/mypage/returnHistory">마이페이지 > 반품/취소 내역</a>에서 확인하실 수 있습니다.</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="fb__mypage__section cancel-area">
		<div class="fb__mypage-title">
			<div class="title-sm">취소 신청 상품</div>
		</div>
		<div class="fb__mypage-claim claim__list claim__able">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='CC'||$TPL_V2["status"]=='IB'){?>
						<li class="product-item__list">
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
											<a href="#;">
												<span class="set-name"><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?></span>
												<span><?php echo number_format($TPL_VAR["restOrderDetail"][$TPL_V2["pid"]]['rest_cnt']+$TPL_V2["pcnt"])?></span>개
											</a>
										</div>
										<div class="product-item__price-group">
											<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
										</div>
									</div>
									<div class="product-item__btn-area">
										<div class="order-status"><?php echo trans($TPL_V2["status_text"])?></div>
									</div>
								</dd>
							</dl>
							<!-- 상품 E -->

							<!-- 취소 사유 영역 S -->
							<div class="claim__list__reason reason-box">
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
							<!-- 취소 사유 영역 E -->
						</li>
<?php }?>
<?php }}?>
			</ul>
<?php }}?>
		</div>
	</section>

	<!--
	<section class="fb__mypage__section gift-wrap">
		<div class="fb__mypage-title">
			<div class="title-sm">구매금액별 사은품</div>
		</div>
		<div class="gift-list">
			<ul class="product-item__wrap">
				<li class="product-item__list">
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
							<div class="product-item__btn-area">
								<div class="order-status">조건 미충족 자동취소</div>
							</div>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</section>

	-->
	<section class="fb__mypage__section pmt-info">
		<!--
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
		-->
		<div class="fb__mypage__section-footer">
			<div class="use-notice">
				<h3 class="use-notice__title">유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">신용카드, 간편결제, 실시간 계좌이체는 자동 환불 처리됩니다.</li>
					<li class="use-notice__desc">결제 시 사용하신 적립금은 내부정책에 따라 취소신청 완료 후 환불 처리됩니다.</li>
				</ul>
			</div>
		</div>
		<div class="fb__mypage__section-btn">
			<div class="btn-group">
				<button type="button" class="btn-lg btn-dark-line" onClick="location.href='/mypage/orderHistory'">주문 내역 조회</button>
				<button type="button" class="btn-lg btn-dark" onClick="location.href='/mypage/returnHistory'">반품/취소 내역</button>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->