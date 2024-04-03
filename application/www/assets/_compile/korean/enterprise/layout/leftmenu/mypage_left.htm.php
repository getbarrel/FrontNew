<?php /* Template_ 2.2.8 2024/03/06 11:25:01 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/mypage_left.htm 000003743 */ ?>
<section class="fb__left-basicList">
	<div class="basicNav">
		<div class="basicNav__wrap">
			<div class="basicNav__item">
<?php if(!$TPL_VAR["nonMemberOid"]){?>
				<div class="title-sm">쇼핑 정보</div>
<?php }else{?>
				<div class="title-sm">비회원주문조회</div>
<?php }?>
				<ul class="basicNav__list">
					<li class="basicNav__list-item"><!-- 현재 페이지 메뉴일 경우 li class = active 추가 --><a href="/mypage/orderHistory" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/orderHistory")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/orderDetail")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/orderCancel")> 0||substr_count($_SERVER["PHP_SELF"],"/mypage/order_status_popup")> 0){?>on<?php }?>'>주문 내역</a></li>
					<li class="basicNav__list-item"><a href="/mypage/returnHistory" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/returnHistory")> 0){?>on<?php }?>'>반품 / 취소 내역</a></li>
				</ul>
			</div>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
			<div class="basicNav__item">
				<div class="title-sm">문의 및 활동 정보</div>
				<ul class="basicNav__list">
					<li class="basicNav__list-item"><a href="/mypage/wishlist" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/wishlist")> 0){?>on<?php }?>'>위시리스트</a></li>
					<li class="basicNav__list-item"><a href="/mypage/myInquiry" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myInquiry")> 0){?>on<?php }?>'>1:1 문의</a></li>
					<li class="basicNav__list-item"><a href="/mypage/myGoodsInquiry" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myGoodsInquiry")> 0){?>on<?php }?>'>상품 Q&A</a></li>
					<li class="basicNav__list-item"><a href="/mypage/stockAlarm" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/stockAlarm")> 0){?>on<?php }?>'>재입고 알림 신청 내역</a></li>
					<li class="basicNav__list-item"><a href="/mypage/recentView" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/recentView")> 0){?>on<?php }?>'>최근 본 상품</a></li>
					<li class="basicNav__list-item"><a href="/mypage/myReviewList" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/myReviewList")> 0){?>on<?php }?>'>내가 쓴 리뷰</a></li>
					<!-- <li class="basicNav__list-item"><a href="#;">댓글 참여 내역</a></li> -->
				</ul>
			</div>
			<div class="basicNav__item noline">
				<div class="title-sm">나의 정보</div>
				<ul class="basicNav__list">
					<li class="basicNav__list-item"><a href="/mypage/mileage" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/mileage")> 0){?>on<?php }?>'>적립금</a></li>
					<li class="basicNav__list-item"><a href="/mypage/coupon" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/coupon")> 0){?>on<?php }?>'>쿠폰</a></li>
					<li class="basicNav__list-item"><a href="/mypage/addressBook" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/addressBook")> 0){?>on<?php }?>'>배송지 관리</a></li>
					<li class="basicNav__list-item"><a href="/mypage/memberLevel">회원등급</a></li>
					<li class="basicNav__list-item"><a href="/mypage/profile" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/profile")> 0){?>on<?php }?>'>회원정보 수정</a></li>
					<li class="basicNav__list-item"><a href="/mypage/secede" class='<?php if(substr_count($_SERVER["PHP_SELF"],"/mypage/secede")> 0){?>on<?php }?>'>회원탈퇴</a></li>
				</ul>
				<div class="basicNav__list-footer">
					<a href="#;" class="btn-link">로그아웃</a>
				</div>
			</div>
<?php }?>
		</div>
	</div>
</section>