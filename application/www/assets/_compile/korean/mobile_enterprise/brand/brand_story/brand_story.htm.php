<?php /* Template_ 2.2.8 2023/07/18 10:19:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/brand/brand_story/brand_story.htm 000005918 */ ?>
<section class="br__brand-story">
    <div class="br__brand-story__header">
        <h2 class="br__brand-story__title">브랜드 스토리</h2>
        <nav class="story__menu">
            <ul>
                <!--li class="story__menu__link <?php if($TPL_VAR["layoutCommon"]["bodyId"]=='brand_brandStory'){?>story__menu__link--active<?php }?>"><a href="/brand/brandStory">배럴 스포츠웨어</a></li>
                <li class="story__menu__link <?php if($TPL_VAR["layoutCommon"]["bodyId"]=='brand_cosmeticsStory'){?>story__menu__link--active<?php }?>"><a href="/brand/cosmeticsStory">배럴 코스메틱스</a></li-->
            </ul>
        </nav>
    </div>
    <div class="br__brand-story__content">
<?php if($TPL_VAR["langType"]=='korean'){?>
        <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet" />
		<style type="text/css">
			.event__wrap {background: #fff; position: relative; font-size: 0; line-height: 0;}
			.event__wrap img {max-width: 100%;}
			.event__wrap .bg {width: 100%; z-index: -1;}
			.event__wrap .item {width: 100%; z-index: -1;}
			.event__wrap .video-wrap {padding:56.25% 0 0 0; position:relative;}
			
			#slide-wrap {position:relative;}
			.slide-bnr {position:absolute; top: 21.46%; left: 50%; transform: translateX(-50%); width: 100%; overflow: hidden;}
			.slide-bnr .swiper-button-prev {top:14%; width:40px; height:40px; background:url('https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/brand_story_arrow_l_40px.png') 0 0 no-repeat; background-size:100% 100%;  left:0px;}
			.slide-bnr .swiper-button-prev:after {display:none;}
			.slide-bnr .swiper-button-next {top:14%; width:40px; height:40px; background:url('https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/brand_story_arrow_r_40px.png') 0 0 no-repeat; background-size:100% 100%; right:0px;}
			.slide-bnr .swiper-button-next:after {display:none;}
		</style>
		<div class="event__wrap">
			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec01.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec02.jpg" /></div>
			<!--사은품 이벤트02-->

			<div id="slide-wrap">
				<img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec03.jpg" />
				<!-- Swiper -->
				<div class="swiper-container slide-bnr slide-01">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2014.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2015.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2016.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2017.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2018.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2019.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2020.jpg" /></div>

						<div class="swiper-slide"><img class="item" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_m_2021.jpg" /></div>
					</div>

					<div class="swiper-button-next btn-next1">&nbsp;</div>

					<div class="swiper-button-prev btn-prev1">&nbsp;</div>
					<!-- <div class="swiper-pagination"></div> -->
				</div>
			</div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec04.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec05.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec06.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec07.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_m_sec08.jpg" /></div>
			<!-- Swiper JS -->
			<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
			<!-- Initialize Swiper -->
			<script>
				var swiper = new Swiper(".slide-bnr", {
					spaceBetween: 0,
							loop: true,
					//effect: "fade",
					navigation: {
						nextEl: ".swiper-button-next",
						prevEl: ".swiper-button-prev",
					},
					pagination: {
						el: ".swiper-pagination",
						clickable: true,
					},
				});
            </script>
		</div>
		<!-- Image Map -->
		<script src="//image.getbarrel.com/barrel_data/js/imageMapResizer.min.js"></script>
		<script>
			window.load = function() { $('map').imageMapResize(); } window.resize= function() { $('map').imageMapResize(); }
	    </script>
<?php }else{?>
        <img src="//image2.getbarrel.com/landing/brand_story_en/brandstory_mo_en_20210908.jpg" alt="스포츠웨어">
		<a href="/brand/technology">자세히 보러가기</a>
<?php }?>
    </div>
</section>