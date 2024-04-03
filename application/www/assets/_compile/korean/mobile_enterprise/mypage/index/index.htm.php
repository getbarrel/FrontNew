<?php /* Template_ 2.2.8 2024/03/06 11:24:09 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/index/index.htm 000008930 */ ?>
<!-- 컨텐츠 S -->
<section class="br__mypage">
	<h2 class="br__hidden">마이페이지</h2>
	<section class="br__mypage__user">
		<dl class="my-user">
			<dt class="my-user__info">
				<div class="my-user__name">안녕하세요! <span class="my-user__name--point"><?php echo $TPL_VAR["mypage"]["userName"]?></span><?php if($TPL_VAR["langType"]=='korean'){?> 님<?php }?></div>
				<div class="my-user__day"><span>가입일</span><span class="day"><?php echo date("Y.m.d",strtotime($TPL_VAR["mypage"]["regDate"]))?></span></div>
			</dt>
			<dd class="my-user__grade">
				<figure class="my-user__thumb">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
					<img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>" />
<?php }?>
				</figure>
			</dd>
		</dl>
		<div class="my-grade">
			<div class="my-grade__text">
				<div class="my-grade__text__title">
					<div class="title-sm">회원등급</div>
					<a href="/mypage/memberLevel" class="my-grade__text__link">
						<span class="my-grade__text__title--point"><?php echo $TPL_VAR["mypage"]["gpName"]?></span>
					</a>
				</div>
<?php if($TPL_VAR["currentGroup"]["gp_level"]> 3){?>
                <p class="my-grade__text__after"><strong class="my-grade__text__after--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["needPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></strong>원을 추가 결제하시면 <strong><?php echo $TPL_VAR["nextGroup"]["gp_name"]?></strong> 혜택을 받을 수 있어요!</p>
<?php }?>
			</div>
		</div>
		<div class="my-benefit">
			<ul class="my-benefit__list">
				<li class="my-benefit__item">
					<a href="/mypage/mileage" class="my-benefit__link">
						<span class="title">적립금</span>
						<span class="count"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["mypage"]["myMileAmount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
					</a>
				</li>
				<li class="my-benefit__item">
					<a href="/mypage/coupon" class="my-benefit__link">
						<span class="title">쿠폰</span>
						<span class="count"><em><?php echo number_format($TPL_VAR["mypage"]["couponCnt"])?></em>장</span>
					</a>
				</li>
				<li class="my-benefit__item">
					<a href="#;" class="my-benefit__link">
						<span class="title">작성 가능한 리뷰</span>
						<span class="count"><em>0</em>건</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="my-user__footer">
			<a href="/mypage/memberLevel" class="btn-link">등급별 혜택 보기</a>
		</div>
	</section>

	<section class="br__mypage__order">
		<div class="my-order">
			<div class="my-order__title">
				<div class="title-sm">주문 현황</div>
				<span class="txt-desc">최근 1개월</span>
			</div>
			<ul class="my-order__seq">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<li class="my-order__seq__box">
					<a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_INCOM_READY?>">
						<span class="my-order__seq__count <?php if(number_format($TPL_VAR["incom_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></span>
						<span class="my-order__seq__kind">입금 대기</span>
					</a>
				</li>
<?php }?>
				<li class="my-order__seq__box">
					<a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_INCOM_COMPLETE?>">
						<span class="my-order__seq__count <?php if(number_format($TPL_VAR["incom_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></span>
						<span class="my-order__seq__kind">결제 완료</span>
					</a>
				</li>
				<li class="my-order__seq__box">
					<a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_READY?>">
						<span class="my-order__seq__count <?php if(number_format($TPL_VAR["delivery_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></span>
						<span class="my-order__seq__kind">배송 준비</span>
					</a>
				</li>
				<li class="my-order__seq__box">
					<a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_ING?>">
						<span class="my-order__seq__count <?php if(number_format($TPL_VAR["delivery_ing_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></span>
						<span class="my-order__seq__kind">배송 중</span>
					</a>
				</li>
                <li class="my-order__seq__box">
                    <a class="my-order__seq__link devOrderStatusCnt" href="/mypage/orderHistory?order_status=<?php echo ORDER_STATUS_DELIVERY_COMPLETE?>">
                        <span class="my-order__seq__count <?php if(number_format($TPL_VAR["delivery_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></span>
                        <span class="my-order__seq__kind">배송 완료</span>
                    </a>
                </li>
			</ul>
			<div class="my-order__foot">
				<div class="my-order__foot__item">
					<a href="/mypage/returnHistory" class="my-order__foot__link">
						<span class="title">취소</span>
						<span class="count"><?php echo number_format($TPL_VAR["cancel_apply_cnt"])?></span>
					</a>
				</div>
				<div class="my-order__foot__item">
					<a href="/mypage/returnHistory" class="my-order__foot__link">
						<span class="title">반품</span>
						<span class="count"><?php echo number_format($TPL_VAR["return_apply_cnt"])?></span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="br__mypage__menu">
		<div class="title-sm">쇼핑 정보</div>
		<ul class="my-menu">
			<li class="my-menu__box">
				<a href="/mypage/orderHistory?order_status=IR" class="my-menu__link">주문 내역<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/returnHistory" class="my-menu__link">반품 / 취소 내역<i class="ico ico-arrow-right"></i></a>
			</li>
		</ul>
		<div class="title-sm">문의 및 활동 정보</div>
		<ul class="my-menu">
			<li class="my-menu__box">
				<a href="/mypage/wishlist" class="my-menu__link">위시리스트<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/myInquiry" class="my-menu__link">1:1 문의<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/myGoodsInquiry" class="my-menu__link">상품 Q&A<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/stockAlarm" class="my-menu__link">재입고 알림 신청 내역<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/recentView" class="my-menu__link">최근 본 상품<i class="ico ico-arrow-right"></i></a>
			</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<li class="my-menu__box">
				<a href="/mypage/myReviewList" class="my-menu__link">내가 쓴 리뷰<i class="ico ico-arrow-right"></i></a>
			</li>
<?php }else{?>
<?php }?>
			<!-- <li class="my-menu__box">
				<a href="#;" class="my-menu__link">댓글 참여 내역<i class="ico ico-arrow-right"></i></a>
			</li> -->
		</ul>
		<div class="title-sm">나의 정보</div>
		<ul class="my-menu">
			<li class="my-menu__box">
				<a href="/mypage/mileage" class="my-menu__link">적립금<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/coupon" class="my-menu__link">쿠폰<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/addressBook" class="my-menu__link">배송지 관리<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/memberLevel" class="my-menu__link">회원등급<i class="ico ico-arrow-right"></i></a>
			</li>
			<li class="my-menu__box">
				<a href="/mypage/passReconfirm" class="my-menu__link">회원정보 수정<i class="ico ico-arrow-right"></i></a>
			</li>
		</ul>
	</section>

	<section class="br__mypage__footer">
		<div class="btn-group col">
			<button type="button" class="btn-lg btn-dark-line br__mypage-link"><a href="/customer/" class="my-menu__link">고객센터</a></button>
			<button type="button" class="btn-lg btn-gray-line br__mypage-logout devLogout">로그아웃</button>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->