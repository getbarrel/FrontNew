<?php /* Template_ 2.2.8 2024/03/19 14:21:11 /home/barrel-stage/application/www/assets/templet/enterprise/customer/member_benefit/member_benefit.htm 000009063 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__customer fb__benefit">
	<div class="fb__customer__header">
		<div class="title-md">회원혜택</div>
	</div>

	<section class="fb__benefit-member">
		<div class="fb__benefit-title">
			<div class="title-sm">신규 가입 즉시 드리는 혜택</div>
		</div>
		<div class="member-benefit__list">
			<dl class="member-benefit__item">
				<dt class="member-benefit__img">
					<img src="/assets/templet/enterprise/assets/img/join_benefit_img01.png" alt="" />
				</dt>
				<dd class="member-benefit__text">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <p>10,000원 할인 쿠폰</p>(10만원 구매 이상)
<?php }else{?>
                    <p><span>$3</span> Discount coupon</p>
<?php }?>
				</dd>
			</dl>
			<dl class="member-benefit__item">
				<dt class="member-benefit__img">
					<img src="/assets/templet/enterprise/assets/img/join_benefit_img02.png" alt="" />
				</dt>
				<dd class="member-benefit__text">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <p>5,000원 할인 쿠폰</p>(5만원 구매 이상)
<?php }else{?>
                    <p><span>$3</span> Discount coupon</p>
<?php }?>
				</dd>
			</dl>
			<dl class="member-benefit__item">
				<dt class="member-benefit__img">
					<img src="/assets/templet/enterprise/assets/img/join_benefit_img03.png" alt="" />
				</dt>
				<dd class="member-benefit__text">
					<p>구매 금액의 1% 적립금</p>
				</dd>
			</dl>
		</div>
	</section>

	<section class="fb__benefit-level">
		<div class="fb__benefit-title">
			<div class="title-sm">회원 등급 별 혜택</div>
		</div>
		<div class="benefits">
			<ul class="benefits__list">
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">옐로우</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
							<span>신규 회원 및 누적 구매금액 10만원 미만</span>
<?php }else{?>
							<span>{=New member & Purchases less than $100')}</span>
<?php }?>
						</div>
						<div class="benefits__info-group">
<?php if($TPL_VAR["langType"]=='korean'){?>
							<ul>
								<li>5,000원 할인 쿠폰 1매 (5만원 구매 이상)</li>
								<li>10,000원 할인 쿠폰 1매 (10만원 구매 이상)</li>
							</ul>
							<ul>
								<li>적립금 1%</li>
							</ul>
<?php }else{?>
							<ul>
								<li>One $3 discount coupon</li>
							</ul>
							<ul>
								<li>1% reward</li>
							</ul>
<?php }?>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_yellow.png" alt="옐로우" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">그린</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
							<span>누적 구매금액 10만원 이상 30만원 미만</span>
<?php }else{?>
							<span>{=Purchases over $100')}</span>
<?php }?>
						</div>
						<div class="benefits__info-group">
<?php if($TPL_VAR["langType"]=='korean'){?>
							<ul>
								<li>5,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 1매</li>
								<li>적립금 5,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 1%</li>
								<li>적립금 1%</li>
							</ul>
<?php }else{?>
							<ul>
								<li>One $5 discount coupon</li>
							</ul>
							<ul>
								<li>Reward $5</li>
							</ul>
<?php }?>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_green.png" alt="그린" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">블루</div>
							<span>누적 구매금액 30만원 이상 50만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>10,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 1매</li>
								<li>적립금 7,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 2%</li>
								<li>적립금 2%</li>
							</ul>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_blue.png" alt="블루" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">브론즈</div>
							<span>누적 구매금액 50만원 이상 70만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>10% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 2매</li>
								<li>적립금 10,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 3%</li>
								<li>적립금 3%</li>
							</ul>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_bronze.png" alt="브론즈" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">실버</div>
							<span>누적 구매금액 70만원 이상 100만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>10% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 13,000원</li>
								<li>생일축하 7% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 4%</li>
								<li>적립금 3%</li>
							</ul>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_silver.png" alt="실버" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">골드</div>
							<span>누적 구매금액 100만원 이상 150만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>10% 할인 쿠폰 1매</li>
								<li>15% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 16,000원</li>
								<li>생일축하 10% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 4%</li>
								<li>적립금 5%</li>
							</ul>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_gold.png" alt="골드" />
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-lg">배럴</div>
							<span>누적 구매금액 100만원 이상 150만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>10% 할인 쿠폰 2매</li>
								<li>15% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 20,000원</li>
								<li>생일축하 10% 할인 쿠폰</li>
							</ul>
							<ul>
								<li>즉시할인 5%</li>
								<li>적립금 5%</li>
							</ul>
						</div>
					</div>
					<div class="benefits__img">
						<img src="/assets/templet/enterprise/assets/img/membership_barrel.png" alt="배럴" />
					</div>
				</li>
			</ul>

			<div class="benefits__join">
				<button class="btn-lg btn-dark-line"  onclick="location.href = '/member/joinInput'">회원가입</button>
			</div>
			<div class="use-notice">
				<h3 class="use-notice__title">회원 혜택 유의사항</h3>
				<ul class="use-notice__list">
					<li class="use-notice__desc">공식 홈페이지의 회원등급 기준은 정책에 의해 변경될 수 있습니다.</li>
					<li class="use-notice__desc">회원등급은 누적 결제 금액의 총액을 기준으로 조정하며, 매월 5일에 등급 조정이 이루어집니다.</li>
					<li class="use-notice__desc">누적 구매금액은 최근 3년 치로 반영하며, 구매 확정된 금액으로만 계산됩니다.</li>
					<li class="use-notice__desc">각 월의 5일이 주말 또는 공휴일일 경우, 영업일에 적립금 및 쿠폰이 일괄 지급됩니다.</li>
					<li class="use-notice__desc">등급이 한 번에 두 단계 이상 상향될 경우 최종 등급의 혜택만 지급됩니다.</li>
					<li class="use-notice__desc">사용된 쿠폰은 복원 또는 재발급은 불가하니 신중한 사용을 부탁드립니다.</li>
					<li class="use-notice__desc">비회원 주문 금액은 포함되지 않습니다.</li>
				</ul>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->