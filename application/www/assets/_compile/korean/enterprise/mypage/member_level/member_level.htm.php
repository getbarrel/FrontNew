<?php /* Template_ 2.2.8 2024/03/19 14:21:35 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/member_level/member_level.htm 000023075 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__stock-alarm fb__member-benefit br__member-benefit">
	<div class="fb__mypage-title">
		<div class="title-md">회원혜택</div>
	</div>
	<div class="fb__mypage-top">
		<section class="fb__mypage-top__grade">
			<div class="fb__mypage-top__group">
				<div class="fb__mypage-top__item">
					<div class="fb__mypage-top__pic">
						<a href="/mypage/passReconfirm">
							<figure class="fb__mypage-top__pic">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
								<img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
							</figure>
						</a>
					</div>
					<div class="fb__mypage-top__grade-text">
						<div class="title-md">안녕하세요! <strong><?php echo $TPL_VAR["mypage"]["userName"]?></strong>님</div>
						<div class="join-date">
							<span>가입일</span>
							<span class="day"><?php echo date("Y.m.d",strtotime($TPL_VAR["mypage"]["regDate"]))?></span>
						</div>
					</div>
				</div>
				<div class="fb__mypage-top__item col">
					<span>회원등급</span>
					<div class="title-md level-name"><?php echo $TPL_VAR["mypage"]["gpName"]?></div>
					<p class="level-text"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="fb__mypage-top__grade--font"><?php echo g_price($TPL_VAR["needPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>을 추가 결제하시면 <span><?php echo $TPL_VAR["nextGroup"]["gp_name"]?></span> 혜택을 받을 수 있어요!</p>
				</div>
			</div>
			<div class="fb__mypage-top__btn">
				<a href="/customer/memberBenefit" class="btn-link">등급별 혜택 보기</a>
			</div>
		</section>
	</div>

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
							<span>신규 회원 및 누적 구매금액 10만원 미만</span>
						</div>
						<div class="benefits__info-group">
							<ul>
								<li>5,000원 할인 쿠폰 1매 (5만원 구매 이상)</li>
								<li>10,000원 할인 쿠폰 1매 (10만원 구매 이상)</li>
							</ul>
							<ul>
								<li>적립금 1%</li>
							</ul>
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
							<span>누적 구매금액 10만원 이상 30만원 미만</span>
						</div>
						<div class="benefits__info-group">
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
<section class="fb__stock-alarm br__member-benefit">
    <div class="fb__mypage-top">	
        <section class="fb__mypage-top__grade grade">
            <a href="/mypage/passReconfirm">
                <figure class="fb__mypage-top__pic">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
                    <img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
                </figure>
            </a>
            <h2 class="fb__mypage-top__grade-text member-benefit__grade">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo $TPL_VAR["mypage"]["userName"]?> 고객님의 멤버십 등급은 <em class=""fb__mypage-top__grade--em""><?php echo $TPL_VAR["mypage"]["gpName"]?></em>입니다.
<?php }else{?>
                Your Membership is <em class="fb__mypage-top__grade--em"><?php echo $TPL_VAR["mypage"]["gpName"]?></em>
<?php }?>
            </h2>
<?php if($TPL_VAR["currentGroup"]["gp_level"]> 3){?>
            <span class="fb__mypage-top__grade--color">다음 등급까지 <?php echo $TPL_VAR["fbUnit"]["f"]?><em class=""fb__mypage-top__grade--font""><?php echo g_price($TPL_VAR["needPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?> 남았습니다.</span>

<?php }?>
        </section>
    </div>
    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>

    <h2 class="fb__stock-alarm__title">배럴 회원 등급 별 혜택</h2>
    <div class="fb__stock-alarm__list">
        <table class="table-default alarm-list">
            <colgroup>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <col width="161px">
                <col width="150px">
                <col width="*">
                <col width="93px">
                <col width="137px">
                <col width="200px">
<?php }else{?>
                <col width="161px">
                <col width="180px">
                <col width="*">
                <col width="100px">
                <col width="100px">
                <col width="200px">
<?php }?>
            </colgroup>
            <thead>
            <tr>
                <th>회원등급</th>
                <th>회원등급 조건</th>
                <th>쿠폰</th>
                <th>적립금</th>
                <th>즉시할인</th>
                <th>회원혜택</th>
            </tr>
            </thead>
            <tbody class="br__member-benefit__contents">
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-yellow.png" alt="옐로우">
                    </figure>
                    <p class="benefit-row__title">옐로우</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">신규회원 및 10만원<br>미만 구매고객</td>
                <td>5,000원 할인쿠폰 1매 <br>(5만원 구매 이상)<br>10,000원 할인쿠폰 1매 <br>(10만원 구매 이상)</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">-</td>
                <!-- <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>적립금 3,000원<br>포토후기 5,000원<br>일반후기 3,000원 적립금 
				<td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">New member & <br>Purchases less than $100</td>
                <!-- <td>One $3 discount coupon</td> 
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">-</td>
                <td class="benefit-row__percent">Reward $3</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-green.png" alt="그린">
                    </figure>
                    <p class="benefit-row__title">그린</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">10만원 이상 구매고객</td>
                <td>
                    5,000원 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 1매
                </td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">1%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 5,000원<br>생일축하쿠폰5%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $100</td>
                <td>One $5 discount coupon</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">Reward $5</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-blue.png" alt="블루">
                    </figure>
                    <p class="benefit-row__title">블루</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    30만원 이상 구매고객
                </td>
                <td>
                    10,000원 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 1매
                </td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">2%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 7,000원<br>생일축하쿠폰5%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $250</td>
                <td>One $7 discount coupon</td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">1%</td>
                <td class="benefit-row__percent">Reward $7</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-bronze.png" alt="브론즈">
                    </figure>
                    <p class="benefit-row__title">브론즈</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    50만원 이상 구매고객</td>
                <td>
                    10% 할인쿠폰 1매<br>(3만원 구매 이상)<br>무료배송 쿠폰 2매
                </td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">3%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 10,000원<br>생일축하쿠폰 5%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $400</td>
                <td>One 10% discount coupon</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">2%</td>
                <td class="benefit-row__percent">Reward $9</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-silver.png" alt="실버">
                    </figure>
                    <p class="benefit-row__title">실버</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    70만원 이상 구매고객
                </td>
                <td>
                    10% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">4%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 13,000원<br>생일축하쿠폰 7%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $550</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">3%</td>
                <td class="benefit-row__percent">Reward $11</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-gold.png" alt="골드">
                    </figure>
                    <p class="benefit-row__title">골드</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    100만원 이상 구매고객
                </td>
                <td>
                    10% 할인쿠폰 1매<br>15% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">4%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 16,000원<br>생일축하쿠폰 10%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $850</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">4%</td>
                <td class="benefit-row__percent">Reward $14</td>
<?php }?>
            </tr>
            <tr class="benefit-row">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-barrel.png" alt="배럴">
                    </figure>
                    <p class="benefit-row__title">배럴</p>
                </td>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <td class="benefit-row__condition">
                    150만원 이상 구매고객</td>
                <td>
                    10% 할인쿠폰 2매<br>15% 할인쿠폰 1매<br>(3만원 구매 이상)<br>항시 무료배송
                </td>
                <td class="benefit-row__percent">5%</td>
                <td class="benefit-row__percent">5%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    적립금 20,000원<br>생일축하쿠폰 10%<br>포토후기 5,000원<br>일반후기 3,000원 적립금
                </td>
<?php }else{?>
                <td class="benefit-row__condition">Purchases over $1250</td>
                <td>One 10% discount coupon One 15% discount coupon</td>
                <td class="benefit-row__percent">6%</td>
                <td class="benefit-row__percent">4%</td>
                <td class="benefit-row__percent">Reward $17</td>
<?php }?>
            </tr>
            <tr class="benefit-row eng-hidden" style="display:none;">
                <td>
                    <figure class="benefit-row__img">
                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/img-memberLevel-teacher.png" alt="배럴 티쳐">
                    </figure>
                    <p class="benefit-row__title">배럴 티처</p>
                </td>
                <td class="benefit-row__condition">배럴 티처 멤버쉽 회원</td>
                <td>
                    배럴 티처 멤버십 회원<br>3만원 이상 구매 시 헤택 적용
                </td>
                <td class="benefit-row__percent">0%</td>
                <td class="benefit-row__percent">15%</td>
                <td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
                    즉시할인(종목 차등) 15%
                </td <?php if($TPL_VAR["langType"]!='korean'){?>class="benefit-row__percent"<?php }?>>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="use-notice">
        <h3 class="use-notice__title">유의사항</h3>
        <ul class="use-notice__list">
            <li class="use-notice__desc">회원등급은 누적 결제 금액의 총액을 기준으로 선정되며, 매월 5일 등급 조정이 이루어집니다.</li>
            <li class="use-notice__desc">각 월의 5일이 주말 또는 공휴일일 경우, 익영업일에 적립금 및 쿠폰이 일괄 지급됩니다.</li>
            <li class="use-notice__desc">향후 우수고객 단계별 혜택 및 선정기준은 변경될 수 있습니다.</li>
            <li class="use-notice__desc">사용된 쿠폰은 복원 또는 재발급이 불가능하오니 신중한 사용을 부탁드립니다.</li>
            <li class="use-notice__desc">비회원 주문 금액은 포함되지 않습니다.</li>
        </ul>
    </div>

</section>
-->