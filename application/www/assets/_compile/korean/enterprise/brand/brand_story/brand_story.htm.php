<?php /* Template_ 2.2.8 2023/07/18 10:19:59 /home/barrel-stage/application/www/assets/templet/enterprise/brand/brand_story/brand_story.htm 000005821 */ ?>
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
			.event__wrap img {width: 100%;}
			.event__wrap .bg {width: 100%; z-index: -1;}
				
			#video-wrap_01 {position: absolute; top: 24.5%; left: 50%; transform: translateX(-50%); width: 100%; min-width: 800px; height: 40.714vw; min-height: 450px; overflow: hidden;}
			#video-wrap_01 > iframe {width: 100%; height: 91%; margin-left: -0.5%; margin-top: -0.5%;}
			
			#slide-wrap {position:relative;}
			.slide-bnr {position:absolute; top: 22%; left: 50%; transform: translateX(-50%); width: 100%; overflow: inherit;}
			.slide-bnr .swiper-button-prev {top:80%; width: 40px; height:40px; background:url('https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/brand_story_arrow_l_40px.png') 0 0 no-repeat; left:0%; }
			.slide-bnr .swiper-button-prev:after {display:none;}
			.slide-bnr .swiper-button-next {top:80%; width: 40px; height:40px; background:url('https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/brand_story_arrow_r_40px.png') 0 0 no-repeat; right:0px; }
			.slide-bnr .swiper-button-next:after {display:none;}
		</style>
		<!-- Swiper JS -->
		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<div class="event__wrap">
			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec01.jpg" /></div>
			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec02.jpg" /></div>
			<!--슬라이드영역-->

			<div id="slide-wrap">
				<img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec03.jpg" /> <!-- Swiper -->
				<div class="swiper-container slide-bnr slide-01">
					<div class="swiper-wrapper"><!-- 링크 있음 --><!--<div class="swiper-slide"><a href="https://www.getbarrel.com"><img src="https://stg.barrelmade.co.kr/assets/templet/enterprise/images/2021_br_outer_item_01_detail01_01_p.png" /></a></div>--><!-- 링크 없음 -->
						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2014.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2015.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2016.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2017.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2018.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2019.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2020.jpg" /></div>

						<div class="swiper-slide"><img src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/history/brand_history_pc_2021.jpg" /></div>
					</div>

					<div class="swiper-button-next btn-next1">&nbsp;</div>

					<div class="swiper-button-prev btn-prev1">&nbsp;</div>
					<!-- <div class="swiper-pagination"></div> -->
				</div>
			</div>
			<!-- Initialize Swiper -->
			<script>
				var swiper1 = new Swiper(".slide-01", {
					spaceBetween: 0,
					loop: true,
					effect: "fade",
					navigation: {
						nextEl: ".btn-next1",
						prevEl: ".btn-prev1",
					},
					pagination: {
					el: ".swiper-pagination",
					clickable: true,
					},
				});
			</script>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec04.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec05.jpg" /></div>

			<div><img class="bg" src="https://vgfuddygerym3822368.cdn.ntruss.com/landing/brand_story_kr/2022/barrel_brand_story_pc_sec06.jpg" /></div>
			<!-- Image Map -->
			<script src="https://image.getbarrel.com/barrel_data/js/imageMapResizer.min.js"></script>
			<script>
				window.load = function() { $('map').imageMapResize(); } window.resize= function() { $('map').imageMapResize(); }
			</script>
		</div>

<?php }else{?>
        <img src="//image2.getbarrel.com/landing/brand_story_en/brandstory_pc_en_20210908.jpg" alt="스포츠웨어">
		<a href="/brand/technology">자세히 보러가기</a>
<?php }?>
    </div>
</section>