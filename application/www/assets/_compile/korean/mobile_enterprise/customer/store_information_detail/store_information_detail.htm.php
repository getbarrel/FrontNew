<?php /* Template_ 2.2.8 2024/03/25 17:32:52 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/store_information_detail/store_information_detail.htm 000003964 */ ?>
<!-- 컨텐츠 S -->
<section class="br__store">
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
				<li class="swiper-slide active">
					<a href="/customer/storeInformation">매장안내</a>
				</li>
				<li class="swiper-slide">
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
	<div class="br__store-wrap">
		<div class="store-map">
			<div class="store-map__info">
				<div class="store-map__name"><?php echo $TPL_VAR["storeInfo"]["store_name"]?></div>
				<div class="store-map__address">
					<p>
						<span id="devAddress1"><?php echo $TPL_VAR["storeInfo"]["store_address1"]?></span><br />
						<?php echo $TPL_VAR["storeInfo"]["store_address2"]?>

					</p>
				</div>
				<div class="store-map__businessDay">
					<p><?php echo $TPL_VAR["storeInfo"]["open_time"]?></p>
					<p><?php echo $TPL_VAR["storeInfo"]["store_tel"]?></p>
					<div class="btn-group">
						<button type="button" class="btn-sns" onclick="location.href='<?php echo $TPL_VAR["storeInfo"]["sns_info"]?>'"><i class="ico ico-instargram-BK"></i></button>
<?php if($TPL_VAR["storeInfo"]["store_tel"]){?>
						<button type="button" class="btn-sns"><a class="store-each__call" href="tel:<?php echo $TPL_VAR["storeInfo"]["store_tel"]?>"><i class="ico ico-phone-BK"></i></a></button>
<?php }?>
					</div>
				</div>
			</div>
			<div class="store-map__slide swiper-container">
				<div class="swiper-wrapper">
					<?php echo $TPL_VAR["storeInfo"]["srcM"]?>

				</div>
				<div class="store-map__slide-control">
					<div class="swiper-control-group">
						<div class="swiper-scrollbar"></div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>

			 <div id="map">
				<div id="daumRoughmapContainer1700540198701" class="root_daum_roughmap root_daum_roughmap_landing"></div>
	
				<script charset="UTF-8" class="daum_roughmap_loader_script" src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>
				
				<script charset="UTF-8">
					new daum.roughmap.Lander({
						timestamp: "1700540198701",
						key: "2gwnb",
						mapWidth: "640",
						mapHeight: "468",
					}).render();
				</script>
			</div>
			<div class="store-map__traffic">
				<div class="store-map__traffic-item">
					<div class="title-sm">지하철 이용 안내</div>
					<div class="store-map__desc">
						<p><?php echo $TPL_VAR["storeInfo"]["subway"]?></p>
					</div>
				</div>
				<div class="store-map__traffic-item">
					<div class="title-sm">버스 이용 안내</div>
					<div class="store-map__desc">
						<?php echo nl2br($TPL_VAR["storeInfo"]["bus"])?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo KAKAO_SCRIPT_KEY?>&libraries=services"></script>
<!-- 컨텐츠 E -->