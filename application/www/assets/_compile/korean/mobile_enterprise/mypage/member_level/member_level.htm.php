<?php /* Template_ 2.2.8 2024/03/19 14:21:28 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/member_level/member_level.htm 000025761 */ ?>
<!-- 컨텐츠 S -->
<section class="br__level">
	<div class="page-title my-title">
		<div class="title-sm">회원등급</div>
	</div>
	<section class="br__level__user">
		<dl class="my-user">
			<dt class="my-user__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<div class="my-user__text">현재 <?php echo $TPL_VAR["mypage"]["userName"]?>님의 등급은</div>
				<div class="my-user__grade"><?php echo $TPL_VAR["mypage"]["gpName"]?></div>
				<div class="txt-desc"><strong><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["needPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></strong>을 추가 결제하시면<br /><strong><?php echo $TPL_VAR["nextGroup"]["gp_name"]?></strong> 혜택을 받을 수 있어요!</div>
<?php }else{?>
                <div class="my-user__text">Your Membership is <span><b><?php echo $TPL_VAR["mypage"]["gpName"]?></b></span></div>
<?php }?>
			</dt>
			<dd class="my-user__grade">
				<figure class="my-user__thumb">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
					<img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
				</figure>
			</dd>
		</dl>
	</section>
	<section class="level__benefits">
		<div class="level__benefits-title">
			<div class="title-sm">회원 등급 별 혜택</div>
		</div>
		<div class="benefits">
			<ul class="benefits__list">
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">옐로우</div>
							<span>신규 회원 및 누적 구매금액 10만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_yellow.png" alt="옐로우" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>적립금 1%</li>
								<li>5,000원 할인 쿠폰 1매 (5만원 구매 이상)</li>
								<li>10,000원 할인 쿠폰 1매 (10만원 구매 이상)</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">그린</div>
							<span>누적 구매금액 10만원 이상 30만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_green.png" alt="그린" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 1%</li>
								<li>적립금 1%</li>
								<li>5,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 1매</li>
								<li>적립금 5,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">블루</div>
							<span>누적 구매금액 30만원 이상 50만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_blue.png" alt="블루" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 2%</li>
								<li>적립금 2%</li>
								<li>10,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 1매</li>
								<li>적립금 7,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">브론즈</div>
							<span>누적 구매금액 50만원 이상 70만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_bronze.png" alt="브론즈" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 3%</li>
								<li>적립금 3%</li>
								<li>10% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>무료배송 쿠폰 2매</li>
								<li>적립금 10,000원</li>
								<li>생일축하 5% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">실버</div>
							<span>누적 구매금액 70만원 이상 100만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_silver.png" alt="실버" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 4%</li>
								<li>적립금 3%</li>
								<li>10% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 13,000원</li>
								<li>생일축하 7% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">골드</div>
							<span>누적 구매금액 100만원 이상 150만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_gold.png" alt="골드" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 4%</li>
								<li>적립금 5%</li>
								<li>10% 할인 쿠폰 1매</li>
								<li>15% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 16,000원</li>
								<li>생일축하 10% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="benefits__item">
					<div class="benefits__info">
						<div class="benefits__info-title">
							<div class="title-md">배럴</div>
							<span>누적 구매금액 100만원 이상 150만원 미만</span>
						</div>
						<div class="benefits__img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/membership_barrel.png" alt="배럴" />
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>즉시할인 5%</li>
								<li>적립금 5%</li>
								<li>10% 할인 쿠폰 2매</li>
								<li>15% 할인 쿠폰 1매 (3만원 구매 이상)</li>
								<li>항시 무료 배송</li>
								<li>적립금 20,000원</li>
								<li>생일축하 10% 할인 쿠폰</li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
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
<!--
<section class="br__level">
    <h2 class="br__title">
        회원등급
    </h2>
    <section class="br__level__user">
        <div class="level level--green">
            <h2 class="level__title">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo $TPL_VAR["mypage"]["userName"]?>님의 회원등급은 <span><b><?php echo $TPL_VAR["mypage"]["gpName"]?></b>입니다.</span>
<?php }else{?>
                Your Membership is <span><b><?php echo $TPL_VAR["mypage"]["gpName"]?></b></span>
<?php }?>
            </h2>
            <p class="level__summary">
                다음 등급까지  <b><?php echo g_price($TPL_VAR["needPrice"])?>원</b> 남았습니다.
            </p>
            <div class="level__content">
                <figure class="level__img">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
                    <img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
                    <figcaption class="level__info">
                        <strong>
                            <?php echo $TPL_VAR["mypage"]["gpName"]?>

                        </strong>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <?php echo $TPL_VAR["currentGroup"]["gp_ename"]?>

<?php }?>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>
    <section class="level__benefits">
        <div class="benefits">
            <h2 class="benefits__title">
                배럴 회원 등급 별 혜택
            </h2>
            <ul class="benefits__box">
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-yellow.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    옐로우
                                </strong>
                                <ul>
                                    <li>
                                        즉시할인 없음
                                    </li>
                                    <li>
                                        적립금 1%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>신규 회원 및 10만원 미만 구매고객</li>
                        <li>5,000원 할인 쿠폰 1매(5만원 구매 이상)</li>
						<li>10,000원 할인 쿠폰 1매(10만원 구매 이상)</li>
                        <!-- <li>적립금 3,000원</li> -- 
                        <li>포토후기 5,000원 / 일반후기 3,000원 적립금</li>
<?php }else{?>
                        <li>New member & Purchases less than $100</li>
                        <li>One $3 discount coupon (purchases over $30)</li>
                        <li>Reward $3</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-green.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    그린
                                </strong>
                                <ul>
                                    <li>
                                        즉시할인 1%
                                    </li>
                                    <li>
                                        적립금 1%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>10만원 이상 구매고객</li>
                        <li>5,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
                        <li>무료배송 쿠폰 1매</li>
                        <li>적립금 5,000원 / 생일축하쿠폰 5%</li>
                        <li>포토후기 5,000원 / 일반후기 3,000원 적립금</li>
<?php }else{?>
                        <li>Purchases over $100</li>
                        <li>One $5 discount coupon</li>
                        <li>Reward $5</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-blue.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    블루
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        즉시할인 2%
                                    </li>
                                    <li>
                                        적립금 2%
                                    </li>
<?php }else{?>
                                    <li>1% instant discount</li>
                                    <li>Reward 2%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>30만원 이상 구매고객</li>
                        <li>10,000원 할인 쿠폰 1매 (3만원 구매 이상)</li>
                        <li>무료배송 쿠폰 1매</li>
                        <li>적립금 7,000원 / 생일축하쿠폰 5%</li>
                        <li>포토후기 5,000원 / 일반후기 3,000원 적립금</li>
<?php }else{?>
                        <li>Purchases over $250</li>
                        <li>One $7 discount coupon</li>
                        <li>Reward $7</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-bronze.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    브론즈
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        즉시할인 3%
                                    </li>
                                    <li>
                                        적립금 3%
                                    </li>
<?php }else{?>
                                    <li>2% instant discount</li>
                                    <li>Reward 3%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            50만원 이상 구매고객
                        </li>
                        <li>
                            10% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            무료배송 쿠폰 2매
                        </li>
                        <li>
                            적립금 10,000원 / 생일축하쿠폰 5%
                        </li>
                        <li>
                            포토후기 5,000원 / 일반후기 3,000원 적립금
                        </li>
<?php }else{?>
                        <li>Purchases over $400</li>
                        <li>One 10% discount coupon</li>
                        <li>Reward $9</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-silver.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    실버
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        즉시할인 4%
                                    </li>
                                    <li>
                                        적립금 3%
                                    </li>
<?php }else{?>
                                    <li>3% instant discount</li>
                                    <li>Reward 3%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            70만원 이상 구매고객
                        </li>
                        <li>
                            10% 할인 쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            항시 무료배송
                        </li>
                        <li>
                            적립금 13,000원 / 생일축하쿠폰 7%
                        </li>
                        <li>
                            포토후기 5,000원 / 일반후기 3,000원 적립금
                        </li>
<?php }else{?>
                        <li>Purchases over $550</li>
                        <li>One $10 discount coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $11</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-gold.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    골드
                                </strong>
                                <ul>
                                    <li>
                                        즉시할인 4%
                                    </li>
                                    <li>
                                        적립금 5%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            100만원 이상 구매고객
                        </li>
                        <li>
                            10% 할인 쿠폰 1매 발행
                        </li>
                        <li>
                            15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            항시 무료배송
                        </li>
                        <li>
                            적립금 16,000원 / 생일축하쿠폰 10%
                        </li>
                        <li>
                            포토후기 5,000원 / 일반후기 3,000원 적립금
                        </li>
<?php }else{?>
                        <li>Purchases over $850</li>
                        <li>One 10% discount coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $14</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-barrel.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    {=trans('배럴)}
                                </strong>
                                <ul>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <li>
                                        즉시할인 5%
                                    </li>
                                    <li>
                                        적립금 5%
                                    </li>
<?php }else{?>
                                    <li>4% Instant discount</li>
                                    <li>Reward 6%</li>
<?php }?>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li>
                            150만원 이상 구매고객
                        </li>
                        <li class="eng-hidden">
                            10% 할인 쿠폰 2매 발행
                        </li>
                        <li>
                            15% 할인쿠폰 1매 (3만원 구매 이상)
                        </li>
                        <li>
                            항시 무료배송
                        </li>
                        <li>
                            적립금 20,000원 / 생일축하쿠폰 10%
                        </li>
                        <li>
                            포토후기 5,000원 / 일반후기 3,000원 적립금
                        </li>
<?php }else{?>
                        <li>Purchases over $1250</li>
                        <li>One 10% discount Coupon</li>
                        <li>One 15% discount coupon</li>
                        <li>Reward $17</li>
<?php }?>
                    </ul>
                </li>
                <li class="benefits__list eng-hidden" style="display:none;">
                    <figure class="benefits__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-teacher.png" alt="">
                        <figcaption class="benefits__name">
                            <span class="benefits__nameInner">
                                <strong>
                                    배럴 티처
                                </strong>
                                <ul>
                                    <li>
                                        즉시할인(종목 차등) 15%
                                    </li>
                                </ul>
                            </span>
                        </figcaption>
                    </figure>
                    <ul class="benefits__info">
                        <li>
                            배럴 티처 멤버십 회원
                        </li>
                        <li>
                            3만원 이상 구매 시 혜택 적용
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="benefits__notice">
                <h2 class="benefits__notice__title">유의사항</h2>
                <ul class="benefits__notice__list">
                    <li class="benefits__notice__desc">· 회원등급은 누적 결제 금액의 총액을 기준으로 선정되며, 매월 5일 등급 조정이 이루어집니다.</li>
                    <li class="benefits__notice__desc">· 각 월의 5일이 주말 또는 공휴일일 경우, 익영업일에 적립금 및 쿠폰이 일괄 지급됩니다.</li>
                    <li class="benefits__notice__desc">· 향후 우수고객 단계별 혜택 및 선정기준은 변경될 수 있습니다.</li>
                    <li class="benefits__notice__desc">· 사용된 쿠폰은 복원 또는 재발급이 불가능하오니 신중한 사용을 부탁드립니다.</li>
                    <li class="benefits__notice__desc">· 비회원 주문 금액은 포함되지 않습니다.</li>
                </ul>
            </div>
        </div>
    </section>
</section>
-->