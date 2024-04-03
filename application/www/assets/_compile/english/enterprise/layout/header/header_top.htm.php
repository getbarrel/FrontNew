<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/header/header_top.htm 000001583 */ 
$TPL_topBeltBanner_1=empty($TPL_VAR["topBeltBanner"])||!is_array($TPL_VAR["topBeltBanner"])?0:count($TPL_VAR["topBeltBanner"]);?>
<div class="fb__headerTop">
	<div class="header">

<?php if($TPL_VAR["topBeltBanner"]){?>
		<div class="header__top-banner header__top-banner--hidden">
			<div class="banner-slide">
				<div class="swiper-wrapper">
<?php if($TPL_topBeltBanner_1){foreach($TPL_VAR["topBeltBanner"] as $TPL_V1){?>
					<figure class="swiper-slide">
						<a href="<?php echo $TPL_V1["bannerLink"]?>">

							<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">

						</a>
					</figure>
<?php }}?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<p class="header__top-banner__txt">
				<label><input type="checkbox" name="today__close"><span>Do not open today</span></label>
			</p>
			<span class="header__top-banner__close">
				<a href="#">
					닫기
				</a>
			</span>
		</div>
<?php }?>


</div>
</div>
<?php if($TPL_VAR["headerTop"]["randomCoupon"]){?>
<div id="devRandomCouponArea" class="randomCoupon"  data-percent="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["percentage"]?>">
	<img src="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gift_file_path"]?>" alt="쿠폰이미지">
	<input type="button" value="쿠폰발행" id="devRandomCouponIssue" data-gcix="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gc_ix"]?>" />
</div>
<?php }?>