<?php /* Template_ 2.2.8 2024/02/29 17:49:16 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/best_review/best_review.htm 000006114 */ ?>
<!-- 컨텐츠 S -->
 <!-- crema load -->
<script>
        var crema_userId = null;
    var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
        crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>";
<?php }?>

    window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
      //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
      crema.init(crema_userId, crema_userNm);
      //console.log("[CREMA] crema.init() - EXECUTED!");
    };

    (function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<section class="br__best-review">
	<section class="cs__menu">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide ">
					<a href="/customer">고객센터 홈</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/faq">자주 묻는 질문</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/notice">공지사항</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/memberBenefit">회원혜택</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/storeInformation">매장안내</a>
				</li>
				<li class="swiper-slide active">
					<a href="/customer/bestReview">제품후기</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/benefitsGuide/">적립금 / 쿠폰 안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/cliamGuide">반품 / 환불 안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/shippingGuide">배송 안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/productPrecautions">제품 주의사항</a>
				</li>
				<li class="swiper-slide ">
					<a href="/customer/contactUs">제휴 문의</a>
				</li>
			</ul>
		</div>
	</section>
	<div class="br__best-review__wrap">
		<div class="page-title">
			<div class="title-md">제품후기</div>
		</div>
		<div class="crema-review">
			<div class="crema-review__head">
				<div class="crema-review__head-title">후기 적립금 안내</div>
				<div class="crema-review__info">
					<div class="crema-review__info-box">
						<div class="crema-review__info-img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_view_review_img01.png" alt="" />
						</div>
						<div class="crema-review__info-cont">
							<div class="crema-review__info-title">
								<div class="title-sm">포토 리뷰</div>
								<span class="price"><em>5,000</em>원</span>
							</div>
							<p class="txt-desc">착용컷과 50자 이상의 실사용 후기</p>
						</div>
					</div>
					<div class="crema-review__info-box">
						<div class="goods-review__info-img">
							<img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_view_review_img02.png" alt="" />
						</div>
						<div class="crema-review__info-cont">
							<div class="crema-review__info-title">
								<div class="title-sm">텍스트 리뷰</div>
								<span class="price"><em>3,000</em>원</span>
							</div>
							<p class="txt-desc">50자 이상의 실사용 후기 작성</p>
						</div>
					</div>
				</div>
				<div class="crema-review__head-title">매달 베스트 리뷰 선정</div>
				<div class="crema-review__head-desc">베스트 리뷰에 선정되시면, 등수에 따라 최대 50,000원의 적립금을 드립니다.</div>
			</div>
			<div class="crema-review__body">
				<!-- 베스트 위젯 -->
				<style>.crema-reviews > iframe { max-width: 100% !important; }</style>
				<div class="crema-reviews" data-widget-id="34"></div>

				<div class="best-review__notice">
					<h4 class="best-review__notice__title">적립불가 조건</h4>
					<ul class="best-review__notice__list">
						<li class="best-review__notice__desc">·리뷰 작성시 수정이 안되오니 이점 참고 부탁 드립니다.</li>
						<li class="best-review__notice__desc">·상품 품절시 리뷰 적용이 안되어 적립금 지급이 안되오니 이점 양해 부탁 드립니다.</li>

						<li class="best-review__notice__desc">·두 가지 제품으로 같은 사진을 두번 올리는 경우 및 중복 후기 (복사/붙여넣기)의 경우 적립금은 한번만 지급.</li>
						<li class="best-review__notice__desc">·글 50자는 ‘공백 제외/ 특수문자 제외 / ㅋ,ㅎ,ㅠ,..등 자음 및 모음 ,한자는 제외 숫자의 경우 한 글자로 처리.</li>
						<li class="best-review__notice__desc">·오프라인 매장 구매, 공식 홈페이지 구매제품이 아닌 경우.</li>
						<li class="best-review__notice__desc">·배송완료일로 부터 30일이 지난제품일 경우.</li>
						<li class="best-review__notice__desc">·비회원으로 구입후 후기 작성 시 적립금 미지급.(회원혜택)</li>
						<li class="best-review__notice__desc">·1만원 이하의 상품일 경우 미지급.</li>
						<li class="best-review__notice__desc">·배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가.</li>
						<li class="best-review__notice__desc">·이벤트 진행 시 해당 상품 구매에 대한 후기 적립금은 조정될 수 있습니다.</li>
					</ul>
				</div>

				<div class="crema-review">
					<!-- <h3 class="crema-review__title">Photo Review</h3> -->
					<div class='crema-reviews' data-widget-id='27'></div>
				</div>

				<div class="crema-review">
					<!-- <h3 class="crema-review__title">Review</h3> -->
					<div class='crema-reviews'></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->