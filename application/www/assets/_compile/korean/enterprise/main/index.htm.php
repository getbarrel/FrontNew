<?php /* Template_ 2.2.8 2024/04/02 16:07:19 /home/barrel-qa/application/www/assets/templet/enterprise/main/index.htm 000049847 */ 
$TPL_mainBannerInfo_1=empty($TPL_VAR["mainBannerInfo"])||!is_array($TPL_VAR["mainBannerInfo"])?0:count($TPL_VAR["mainBannerInfo"]);
$TPL_mainContentSpecialInfo_1=empty($TPL_VAR["mainContentSpecialInfo"])||!is_array($TPL_VAR["mainContentSpecialInfo"])?0:count($TPL_VAR["mainContentSpecialInfo"]);
$TPL_mainBastCateList_1=empty($TPL_VAR["mainBastCateList"])||!is_array($TPL_VAR["mainBastCateList"])?0:count($TPL_VAR["mainBastCateList"]);
$TPL_mainBastCateProductListAll_1=empty($TPL_VAR["mainBastCateProductListAll"])||!is_array($TPL_VAR["mainBastCateProductListAll"])?0:count($TPL_VAR["mainBastCateProductListAll"]);
$TPL_mainMovieBannerInfo_1=empty($TPL_VAR["mainMovieBannerInfo"])||!is_array($TPL_VAR["mainMovieBannerInfo"])?0:count($TPL_VAR["mainMovieBannerInfo"]);
$TPL_mainContentMainGroupRelationList_1=empty($TPL_VAR["mainContentMainGroupRelationList"])||!is_array($TPL_VAR["mainContentMainGroupRelationList"])?0:count($TPL_VAR["mainContentMainGroupRelationList"]);
$TPL_displayContentClassStyleList_1=empty($TPL_VAR["displayContentClassStyleList"])||!is_array($TPL_VAR["displayContentClassStyleList"])?0:count($TPL_VAR["displayContentClassStyleList"]);
$TPL_mainJournalInfo_1=empty($TPL_VAR["mainJournalInfo"])||!is_array($TPL_VAR["mainJournalInfo"])?0:count($TPL_VAR["mainJournalInfo"]);
$TPL_mainContentContentInfo_1=empty($TPL_VAR["mainContentContentInfo"])||!is_array($TPL_VAR["mainContentContentInfo"])?0:count($TPL_VAR["mainContentContentInfo"]);
$TPL_slideBannerPopUp_1=empty($TPL_VAR["slideBannerPopUp"])||!is_array($TPL_VAR["slideBannerPopUp"])?0:count($TPL_VAR["slideBannerPopUp"]);?>
<?php if(!empty($TPL_VAR["mainDisplayGroupData"])){?>

<script>var mainDisplayGroupData = <?php echo $TPL_VAR["mainDisplayGroupData"]?>;</script>
<?php }?>

<!-- Criteo 홈페이지 태그 23.06.29-->
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 104564},
        { event: "setEmail", email: "", hash_method: "" },
        { event: "setZipcode", zipcode: "" },

        { event: "setSiteType", type: deviceType},
        { event: "viewHome"});
</script>
<!-- END Criteo 홈페이지 태그 -->

<!-- 컨텐츠 영역 S -->
<section class="fb__main">
	<h2 class="fb__title--hidden">main</h2>

	<!-- 메인 비주얼 S -->
<?php if($TPL_VAR["mainBannerInfo"]){?>
	<section class="fb__main__slider fb__main__visual fb__main__slider__gap">
		<h3 class="fb__title--hidden">main slider</h3>
		<div class="mainSlider mainVisual">
			<div class="mainSlider__slider swiper-container">
				<div class="swiper-wrapper">
<?php if($TPL_mainBannerInfo_1){foreach($TPL_VAR["mainBannerInfo"] as $TPL_V1){?>
					<div class="swiper-slide mainSlider__item">
						<a href="<?php echo $TPL_V1["bannerLink"]?>">
							 <div class="mainSlider__item-group">
								<div class="mainSlider__item-title--sm" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["shot_title"]?></div>
								<div class="mainSlider__item-title" style="text-align:<?php if($TPL_V1["s_name"]=='L'){?>left<?php }elseif($TPL_V1["s_name"]=='C'){?>center<?php }elseif($TPL_V1["s_name"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_name"]?>;<?php if($TPL_V1["b_name"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_name"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_name"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo nl2br($TPL_V1["banner_name"])?>

								</div>
								<p style="text-align:<?php if($TPL_V1["s_desc"]=='L'){?>left<?php }elseif($TPL_V1["s_desc"]=='C'){?>center<?php }elseif($TPL_V1["s_desc"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_desc"]?>;<?php if($TPL_V1["b_desc"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_desc"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_desc"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo nl2br($TPL_V1["banner_desc"])?>

								</p>
							</div>
							<figure>
								<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" />
							</figure>
						</a>
					</div>
<?php }}?>
				</div>
				<div class="mainSlider__control">
					<div class="swiper-control-group">
						<div class="swiper-scrollbar"></div>
						<div class="swiper-pagination"></div>
						<button type="button" class="swiper-button swiper-button-prev"></button>
						<button type="button" class="swiper-button swiper-button-next"></button>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php }?>
	<!-- 메인 비주얼 E -->

	<!-- Hot Contents 영역 S -->
	<section class="fb-main__section fb-main__HotContents">
		<div class="fb-main__inner">
			<div class="fb-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_special"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_special"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_special"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_special"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_special"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_special"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_special"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["special_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_special_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_special_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_special_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_special_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["special_e"]?></span>
			</div>
			<div class="fb-main__slide">
				<div class="fb-main__card-slider swiper-container goods-slider1">
					<div class="swiper-wrapper">
<?php if($TPL_mainContentSpecialInfo_1){foreach($TPL_VAR["mainContentSpecialInfo"] as $TPL_V1){?>
						<div class="swiper-slide">
							<div class="fb-main__card-item">
								<div class="fb-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
								<dl class="fb-main__card-cont">
									<dt class="fb-main__card-img">
										<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
											<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
										</a>
									</dt>
									<dd class="fb-main__card-textBOX">
										<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
											<div class="fb-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
												<?php echo $TPL_V1["title"]?>

											</div>
											<p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
												<?php echo $TPL_V1["explanation"]?>

											</p>
<?php if($TPL_V1["display_date_use"]=="Y"){?>
											<p><?php echo $TPL_V1["startDate"]?> - <?php echo $TPL_V1["endDate"]?></p>
<?php }?>
										</a>
										<!-- <button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)"><i class="ico ico-wishlist"></i>좋아요</button> -->
										<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)"><i class="ico <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>ico-wishlist2<?php }else{?>ico-wishlist<?php }?>"></i>좋아요</button>

										<!--<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart&#45;&#45;active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)">좋아요</a>-->
									</dd>
								</dl>
							</div>
						</div>
<?php }}?>
					</div>
					<div class="fb-main__card-control">
						<div class="swiper-control-group">
							<div class="swiper-scrollbar"></div>
							<div class="swiper-pagination"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Hot Contents 영역 E -->

	<!-- Best Items 영역 S -->
<?php if($TPL_VAR["mainBastCateUse"]=="Y"){?>
	<section class="fb-main__section fb-main__BestItems">
		<div class="fb-main__inner">
			<div class="fb-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_best"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_best"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_best"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_best"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_best"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_best"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_best"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["best_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_best_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_best_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_best_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_best_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["best_e"]?></span>
				<a href="/shop/subGoodsList/<?php echo $TPL_VAR["mainBastCateCode"]?>">상품 전체보기</a>
			</div>
			<div class="fb-tab__wrap">
				<div class="fb-tab__nav">
					<ul>
<?php if($TPL_mainBastCateList_1){$TPL_I1=-1;foreach($TPL_VAR["mainBastCateList"] as $TPL_V1){$TPL_I1++;?>
							<!--li <?php if($TPL_I1== 0){?>class="active"<?php }?>><a href="/shop/subGoodsList/<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["cname"]?></a></li-->
							<li <?php if($TPL_I1== 0){?>class="active"<?php }?>><a href="javascript:void(0);"><?php echo $TPL_V1["cname"]?></a></li>
<?php }}?>
					</ul>
				</div>
				<div class="fb-tab__contents-wrap">
<?php if($TPL_mainBastCateProductListAll_1){$TPL_I1=-1;foreach($TPL_VAR["mainBastCateProductListAll"] as $TPL_V1){$TPL_I1++;?>
					<div class="fb-tab__contents<?php if($TPL_I1== 0){?> active<?php }?>" id="bestItemListDivNum_<?php echo $TPL_I1?>">
						<div class="fb-main__card-slider swiper-container goods-slider2">
							<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<div class="swiper-slide">
									<div class="fb__goods__list">
										<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="fb__goods__link">
											<figure class="fb__goods__img">
												<div>
													<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" onmouseover="this.src='<?php echo $TPL_V2["image_src2"]?>'" onmouseout="this.src='<?php echo $TPL_V2["image_src"]?>'">
												</div>
											</figure>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__etc" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></li>
													<li class="fb__goods__name"><?php echo $TPL_V2["pname"]?></li>
													<li class="fb__goods__option"><?php echo $TPL_V2["add_info"]?></li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<div class="fb__goods__sale" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>>
													<p class="per"><em><?php echo $TPL_V2["discount_rate"]?></em>%</p>
												</div>
												<span class="fb__goods__price"><?php echo $TPL_V2["dcprice"]?></span>
												<span class="fb__goods__noprice" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><?php echo $TPL_V2["sellprice"]?></span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<!--<a href="javascript:void(0);" class="product-box__heart">hart</a>-->
										<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V2["alreadyWish"]){?>product-box__heart--active<?php }?>" style="top:15px;" data-devWishBtn="<?php echo $TPL_V2["id"]?>">hart</a>
									</div>
								</div>
<?php }}?>
								<div class="swiper-slide">
									<a href="/shop/goodsList/<?php echo $TPL_VAR["mainBastCateList"][$TPL_I1]["cid"]?>" class="best_more">
										<img src="/assets/templet/enterprise/assets/img/best_more_bg.jpg">
										<div>
											<img src="/assets/templet/enterprise/assets/img/best_more.svg" class="best_more_btn">
											<p><?php echo $TPL_VAR["mainBastCateList"][$TPL_I1]["cname"]?> 전체보기</p>
										</div>
									</a>
								</div>

							</div>
							<div class="fb-main__card-control">
								<div class="swiper-control-group">
									<div class="swiper-scrollbar"></div>
									<div class="swiper-pagination"></div>
								</div>
							</div>
						</div>
					</div>
<?php }}?>
				</div>
			</div>
		</div>
	</section>
<?php }?>
	<!-- Best Items 영역 E -->

	<!-- 동영상 banner 영역 S -->
<?php if($TPL_VAR["mainMovieBannerInfo"]){?>
	<section class="fb-main__section fb-main__banner">
<?php if($TPL_mainMovieBannerInfo_1){foreach($TPL_VAR["mainMovieBannerInfo"] as $TPL_V1){?>
		<div class="fb-main__inner">
			<!--<img src="../assets/img/main_middle_banner.png" alt="" />-->
			<iframe width="100%" src="<?php echo $TPL_V1["banner_html"]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
<?php }}?>
	</section>
<?php }?>
	<!-- 동영상 banner 영역 E -->

<?php if($TPL_mainContentMainGroupRelationList_1){foreach($TPL_VAR["mainContentMainGroupRelationList"] as $TPL_V1){?>
<?php if($TPL_V1["group_con_gubun"]=="B"){?>
			<!-- banner 영역 S -->
<?php if($TPL_V1["displayCnt"]== 0){?>
				<section class="fb-main__section fb-main__FocusNow">
					<div class="fb-main__inner">
						<div class="fb-main__title" style="margin-bottom:0px;">
							<h3 style="text-align:<?php if($TPL_V1["s_main_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_main_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_main_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_main_group_title"]?>;<?php if($TPL_V1["b_main_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_title"]?></h3>
							<span style="color:<?php echo $TPL_V1["c_main_group_explanation"]?>;<?php if($TPL_V1["b_main_group_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_explanation"]?></span>
						</div>
					</div>
				</section>
<?php }?>
<?php if($TPL_V1["slider_group_con_gubun"]=="N"){?>
				<!--<section class="fb-main__section fb-main__banner">
					<div class="fb-main__inner">
						<a href="<?php echo $TPL_V1["banner_link"]?>">
							<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
						</a>
					</div>
				</section>-->
				<section class="fb-main__section fb-main__slider">
					<div class="fb__main__slider">
						<div class="mainSlider">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide mainSlider__item">
										<a href="<?php echo $TPL_V1["banner_link"]?>">
											<div class="mainSlider__item-group">
												<div class="mainSlider__item-title--sm" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["shot_title"]?></div>
												<div class="mainSlider__item-title--md" style="text-align:<?php if($TPL_V1["s_name"]=='L'){?>left<?php }elseif($TPL_V1["s_name"]=='C'){?>center<?php }elseif($TPL_V1["s_name"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_name"]?>;<?php if($TPL_V1["b_name"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_name"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_name"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["banner_name"]?>

												</div>
												<p style="text-align:<?php if($TPL_V1["s_desc"]=='L'){?>left<?php }elseif($TPL_V1["s_desc"]=='C'){?>center<?php }elseif($TPL_V1["s_desc"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_desc"]?>;<?php if($TPL_V1["b_desc"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_desc"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_desc"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["banner_desc"]?>

												</p>
											</div>
											<figure>
												<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
											</figure>
										</a>
									</div>
								</div>

							</div>
						</div>
					</div>
				</section>
<?php }else{?>
				<section class="fb-main__section fb-main__slider">
					<div class="fb__main__slider">
						<div class="mainSlider">
							<div class="mainSlider__sub_slider swiper-container">
								<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["slider_banner"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<div class="swiper-slide mainSlider__item">
										<a href="<?php echo $TPL_V2["banner_link"]?>">
											<div class="mainSlider__item-group">
												<div class="mainSlider__item-title--sm" style="text-align:<?php if($TPL_V2["s_title"]=='L'){?>left<?php }elseif($TPL_V2["s_title"]=='C'){?>center<?php }elseif($TPL_V2["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V2["c_title"]?>;<?php if($TPL_V2["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["shot_title"]?></div>
												<div class="mainSlider__item-title--md" style="text-align:<?php if($TPL_V2["s_name"]=='L'){?>left<?php }elseif($TPL_V2["s_name"]=='C'){?>center<?php }elseif($TPL_V2["s_name"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V2["c_name"]?>;<?php if($TPL_V2["b_name"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_name"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_name"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V2["banner_name"]?>

												</div>
												<p style="text-align:<?php if($TPL_V2["s_desc"]=='L'){?>left<?php }elseif($TPL_V2["s_desc"]=='C'){?>center<?php }elseif($TPL_V2["s_desc"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V2["c_desc"]?>;<?php if($TPL_V2["b_desc"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_desc"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_desc"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo nl2br($TPL_V2["banner_desc"])?>

												</p>
											</div>
											<figure>
												<img src="<?php echo $TPL_V2["contentImgSrc"]?>" alt="" />
											</figure>
										</a>
									</div>
<?php }}?>
								</div>
								<div class="mainSlider__control">
									<div class="swiper-control-group">
										<div class="swiper-scrollbar"></div>
										<div class="swiper-pagination"></div>
										<button type="button" class="swiper-button swiper-button-prev"></button>
										<button type="button" class="swiper-button swiper-button-next"></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
<?php }?>
<?php }?>
<?php if($TPL_V1["group_con_gubun"]=="S"){?>
<?php if($TPL_V1["displayCnt"]== 0){?>
				<section class="fb-main__section fb-main__FocusNow">
					<div class="fb-main__inner">
						<div class="fb-main__title">
							<h3 style="text-align:<?php if($TPL_V1["s_main_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_main_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_main_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_main_group_title"]?>;<?php if($TPL_V1["b_main_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_title"]?></h3>
							<span style="color:<?php echo $TPL_V1["c_main_group_explanation"]?>;<?php if($TPL_V1["b_main_group_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_explanation"]?></span>
						</div>
						<div class="fb-FocusNow__group">
							<dl class="fb-FocusNow__item">
								<dt class="fb-FocusNow__img">
									<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">
										<img src="<?php echo $TPL_V1["contentImgSrc"]?>" width="484" height="691" alt="" />
									</a>
								</dt>
								<dd class="fb-FocusNow__cont">
									<!--<div class="fb-main__title" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_group_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h3 style="color:<?php echo $TPL_V1["c_group_title"]?>;">
											<?php echo $TPL_V1["group_title"]?>

										</h3>
										<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
									</div>-->
									<div class="fb-main__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h3 style="color:<?php echo $TPL_V1["c_title"]?>;">
											<?php echo $TPL_V1["title"]?>

										</h3>
										<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
									</div>
									<div class="fb-main__goods">
										<div class="fb-main__goods-slider swiper-container">
											<div class="fb-main__goods-title">
												<h4>추천상품</h4>
											</div>
											<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												<div class="swiper-slide">
													<div class="fb__goods__list">
														<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="fb__goods__link">
															<figure class="fb__goods__img">
																<div>
																	<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" onmouseover="this.src='<?php echo $TPL_V2["image_src2"]?>'" onmouseout="this.src='<?php echo $TPL_V2["image_src"]?>'">
																</div>
															</figure>
															<div class="fb__goods__info">
																<ul class="fb__goods__infoBox">
																	<li class="fb__goods__etc" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></li>
																	<li class="fb__goods__name"><?php echo $TPL_V2["pname"]?></li>
																	<li class="fb__goods__option"><?php echo $TPL_V2["add_info"]?></li>
																	<li class="fb__goods__brand"></li>
																</ul>
															</div>
															<div class="fb__goods__important">
																<div class="fb__goods__sale" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>>
																	<p class="per"><em><?php echo $TPL_V2["discount_rate"]?></em>%</p>
																</div>
																<span class="fb__goods__price"><?php echo $TPL_V2["dcprice"]?></span>
																<span class="fb__goods__noprice" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><?php echo $TPL_V2["sellprice"]?></span>
																<!-- 품절일 경우 노출 S -->
																<span class="fb__goods__price__state" style="display: none">품절</span>
																<!-- 품절일 경우 노출 S -->
															</div>
															<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
														</a>
														<!--<a href="javascript:void(0);" class="product-box__heart product-box__heart&#45;&#45;active">hart</a>-->
														<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V2["alreadyWish"]){?>product-box__heart--active<?php }?>" style="top:15px;" data-devWishBtn="<?php echo $TPL_V2["id"]?>">hart</a>
													</div>
												</div>
<?php }}?>
											</div>
											<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
											<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
										</div>
									</div>
								</dd>
							</dl>
						</div>
					</div>
				</section>
<?php }else{?>
				<section class="fb-main__section fb-main__FocusNow">
					<div class="fb-main__inner">
						<div class="fb-FocusNow__group">
							<dl class="fb-FocusNow__item">
								<dt class="fb-FocusNow__img">
									<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">
										<img src="<?php echo $TPL_V1["contentImgSrc"]?>" width="484" height="691" alt="" />
									</a>
								</dt>
								<dd class="fb-FocusNow__cont">
									<!--<div class="fb-main__title" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_group_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h3 style="color:<?php echo $TPL_V1["c_group_title"]?>;">
											<?php echo $TPL_V1["group_title"]?>

										</h3>
										<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
									</div>-->
									<div class="fb-main__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h3 style="color:<?php echo $TPL_V1["c_title"]?>;">
											<?php echo $TPL_V1["title"]?>

										</h3>
										<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
									</div>
									<div class="fb-main__goods">
										<div class="fb-main__goods-slider swiper-container">
											<div class="fb-main__goods-title">
												<h4>추천상품</h4>
											</div>
											<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												<div class="swiper-slide">
													<div class="fb__goods__list">
														<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="fb__goods__link">
															<figure class="fb__goods__img">
																<div>
																	<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" onmouseover="this.src='<?php echo $TPL_V2["image_src2"]?>'" onmouseout="this.src='<?php echo $TPL_V2["image_src"]?>'">
																</div>
															</figure>
															<div class="fb__goods__info">
																<ul class="fb__goods__infoBox">
																	<li class="fb__goods__etc" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></li>
																	<li class="fb__goods__name"><?php echo $TPL_V2["pname"]?></li>
																	<li class="fb__goods__option"><?php echo $TPL_V2["add_info"]?></li>
																	<li class="fb__goods__brand"></li>
																</ul>
															</div>
															<div class="fb__goods__important">
																<div class="fb__goods__sale" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>>
																	<p class="per"><em><?php echo $TPL_V2["discount_rate"]?></em>%</p>
																</div>
																<span class="fb__goods__price"><?php echo $TPL_V2["dcprice"]?></span>
																<span class="fb__goods__noprice" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><?php echo $TPL_V2["sellprice"]?></span>
																<!-- 품절일 경우 노출 S -->
																<span class="fb__goods__price__state" style="display: none">품절</span>
																<!-- 품절일 경우 노출 S -->
															</div>
															<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
														</a>
														<!--<a href="javascript:void(0);" class="product-box__heart product-box__heart&#45;&#45;active">hart</a>-->
														<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V2["alreadyWish"]){?>product-box__heart--active<?php }?>" style="top:15px;" data-devWishBtn="<?php echo $TPL_V2["id"]?>">hart</a>
													</div>
												</div>
<?php }}?>
											</div>
											<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
											<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
										</div>
									</div>
								</dd>
							</dl>
						</div>
					</div>
				</section>
<?php }?>
<?php }?>
<?php }}?>

	<!-- Style Guide 영역 S -->
	<section class="fb-main__section fb-main__StyleGuide">
		<div class="fb-main__inner">
			<div class="fb-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_style"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_style"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_style"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_style"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_style"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_style"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_style"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["style_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_style_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_style_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_style_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_style_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["style_e"]?></span>
				<a href="/content/styleList">전체보기</a>
			</div>
			<div class="fb-tab__wrap">
				<div class="fb-tab__nav">
					<ul>
						<!--<li class="active"><a href="javascript:void(0);">ALL</a></li>-->
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?><!-- color:<?php echo $TPL_V1["c_preface"]?>; -->
							<li <?php if($TPL_I1== 0){?>class="active"<?php }?>><a href="javascript:void(0);" class="brandNav__sub-link" style="<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php if($TPL_I1== 0){?>전체<?php }else{?><?php echo $TPL_V1["cname"]?><?php }?></a></li>
<?php }}?>
					</ul>
				</div>
				<div class="fb-tab__contents-wrap">
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?>
					<div class="fb-tab__contents <?php if($TPL_I1== 0){?> active<?php }?>">
						<div class="fb-main__card-slider swiper-container goods-slider3">
							<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["styleGuide"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<div class="swiper-slide">
									<div class="fb-main__card-item">
										<div class="fb-main__card-title--sm" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></div>
										<dl class="fb-main__card-cont">
											<dt class="fb-main__card-img">
												<a href="/content/styleDetail/<?php echo $TPL_V2["con_ix"]?>/<?php echo $TPL_V2["cid"]?>">
													<img src="<?php echo $TPL_V2["contentImgSrc"]?>" alt="" />
												</a>
											</dt>
											<dd class="fb-main__card-textBOX">
												<a href="/content/styleDetail/<?php echo $TPL_V2["con_ix"]?>/<?php echo $TPL_V2["cid"]?>">
													<div class="fb-main__card-title" style="text-align:<?php if($TPL_V2["s_title"]=='L'){?>left<?php }elseif($TPL_V2["s_title"]=='C'){?>center<?php }elseif($TPL_V2["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V2["c_title"]?>;<?php if($TPL_V2["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
														<?php echo $TPL_V2["title"]?>

													</div>
													<p style="color:<?php echo $TPL_V2["c_explanation"]?>;<?php if($TPL_V2["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["explanation"]?></p>
												</a>
											</dd>
										</dl>
									</div>
								</div>
<?php }}?>
							</div>
							<div class="fb-main__card-control">
								<div class="swiper-control-group">
									<div class="swiper-scrollbar"></div>
									<div class="swiper-pagination"></div>
								</div>
							</div>
						</div>
					</div>
<?php }}?>
				</div>
			</div>
		</div>
	</section>
	<!-- Style Guide 영역 E -->

	<!-- Barrel Journal / Barrel Campaign 영역 S -->
	<section class="fb-main__section fb-main__barrel-group">
		<div class="fb-main__inner">
			<div class="fb-barrel__group">
<?php if($TPL_VAR["mainContentInfo"]["journal_use"]=='Y'){?>
				<div class="fb-barrel__item">
					<div class="fb-main__title">
						<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_journal"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_journal"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_journal"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_journal"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_journal"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_journal"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_journal"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["journal_title"]?></h3>
						<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_journal_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_journal_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_journal_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_journal_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["journal_e"]?></span>
						<a href="/content/specialList/001001003000000">전체보기</a>
					</div>
					<!--<div class="" style="background: url(/data/barrel_data/images/frame/0000000002/frameImg_0000000002.gif) no-repeat center 0;">
						<div class="" style="background: url(/data/barrel_data/images/frame/0000000002/frameImg_0000000002.gif) no-repeat center 0;"></div>-->
						<div class="fb-main__barrel-slider--group">
							<div class="fb-main__barrel-slider--bg"></div>
						<div class="fb-main__barrel-slider swiper-container">
							<div class="swiper-wrapper">
<?php if($TPL_mainJournalInfo_1){foreach($TPL_VAR["mainJournalInfo"] as $TPL_V1){?>
								<div class="swiper-slide">
									<a href="<?php echo $TPL_V1["banner_link"]?>">
										<div class="fb-barrel__img">
											<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="" />
										</div>
										<div class="fb-barrel__title">
											<?php echo $TPL_V1["banner_name"]?>

										</div>
									</a>
								</div>
<?php }}?>
								<!--<div class="swiper-slide">
									<a href="#;">
										<div class="fb-barrel__img">
											<img src="../assets/img/main_barrel_journal_img.png" alt="" />
										</div>
										<div class="fb-barrel__title">
											최고가 필요한 순간을<br />
											서포트하는 배럴 스윔 패브릭
										</div>
									</a>
								</div>-->
							</div>
						</div>
						<button type="button" class="swiper-button swiper-button-prev">이전</button>
						<button type="button" class="swiper-button swiper-button-next">다음</button>
					</div>
				</div>
<?php }?>
				<div class="fb-barrel__item">
					<div class="fb-main__title">
						<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_content"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_content"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_content"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_content"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_content"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_content"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_content"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["content_title"]?></h3>
						<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_content_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_content_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_content_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_content_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["content_e"]?></span>
						<a href="/content/specialList/001001002000000">전체보기</a>
					</div>
					<div class="fb-main__card-slider swiper-container goods-slider3">
						<div class="swiper-wrapper">
<?php if($TPL_mainContentContentInfo_1){foreach($TPL_VAR["mainContentContentInfo"] as $TPL_V1){?>
							<div class="swiper-slide">
								<div class="fb-main__card-item">
									<div class="fb-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
									<dl class="fb-main__card-cont">
										<dt class="fb-main__card-img">
											<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
												<img src="<?php echo $TPL_V1["contentRecomImgSrc"]?>" alt="" />
											</a>
										</dt>
										<dd class="fb-main__card-textBOX">
											<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
												<div class="fb-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["title"]?>

												</div>
												<p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["explanation"]?>

												</p>
											</a>
											<!--<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>-->
											<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)"><i class="ico <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>ico-wishlist2<?php }else{?>ico-wishlist<?php }?>"></i>좋아요</button>
											<!--a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)">좋아요</a-->
										</dd>
									</dl>
								</div>
							</div>
<?php }}?>
							<!--<div class="swiper-slide">
								<div class="fb-main__card-item">
									<div class="fb-main__card-title&#45;&#45;sm">Competition</div>
									<dl class="fb-main__card-cont">
										<dt class="fb-main__card-img">
											<a href="#;">
												<img src="../assets/img/main_barrel_campaign_img01.png" alt="" />
											</a>
										</dt>
										<dd class="fb-main__card-textBOX">
											<a href="#;">
												<div class="fb-main__card-title">
													우먼 리플렉션 아쿠아<br />
													브릿지백 스트랩 스윔슈트
												</div>
												<p>
													온/오프라인 배럴 전 제품 15만원 이상 구매 시 <br />
													스페셜 기프트 증정!
												</p>
											</a>
											<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
										</dd>
									</dl>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="fb-main__card-item">
									<div class="fb-main__card-title&#45;&#45;sm">Competition</div>
									<dl class="fb-main__card-cont">
										<dt class="fb-main__card-img">
											<a href="#;">
												<img src="../assets/img/main_barrel_campaign_img01.png" alt="" />
											</a>
										</dt>
										<dd class="fb-main__card-textBOX">
											<a href="#;">
												<div class="fb-main__card-title">
													우먼 리플렉션 아쿠아<br />
													브릿지백 스트랩 스윔슈트
												</div>
												<p>
													온/오프라인 배럴 전 제품 15만원 이상 구매 시 <br />
													스페셜 기프트 증정!
												</p>
											</a>
											<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
										</dd>
									</dl>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="fb-main__card-item">
									<div class="fb-main__card-title&#45;&#45;sm">Competition</div>
									<dl class="fb-main__card-cont">
										<dt class="fb-main__card-img">
											<a href="#;">
												<img src="../assets/img/main_barrel_campaign_img01.png" alt="" />
											</a>
										</dt>
										<dd class="fb-main__card-textBOX">
											<a href="#;">
												<div class="fb-main__card-title">
													우먼 리플렉션 아쿠아<br />
													브릿지백 스트랩 스윔슈트
												</div>
												<p>
													온/오프라인 배럴 전 제품 15만원 이상 구매 시 <br />
													스페셜 기프트 증정!
												</p>
											</a>
											<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
										</dd>
									</dl>
								</div>
							</div>-->
						</div>
						<div class="fb-main__card-control">
							<div class="swiper-control-group">
								<div class="swiper-scrollbar"></div>
								<div class="swiper-pagination"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Barrel Journal / Barrel Campaign 영역 E -->
</section>
<!-- 컨텐츠 영역 E -->

<!-- 팝업 S -- 
<div class="main_popupL" id="main_popup" style="display:none;z-index:9999;">
	<div class="main_popupL-inner">
		<div class="main_popupL-slide swiper-container popup-slide">
			<div class="swiper-wrapper">
<?php if($TPL_slideBannerPopUp_1){foreach($TPL_VAR["slideBannerPopUp"] as $TPL_V1){?>
				<div class="swiper-slide">
					<a href="<?php echo $TPL_V1["bannerLink"]?>"><img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" /></a>
				</div>
<?php }}?>
			</div>
		</div>
		<div class="main_popupL-slide--control">
			<div class="swiper-control-group">
				<div class="swiper-scrollbar"></div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
	<div class="noti__popup main_popupL-btn">
		<div class="noti__popup-checkbox main_popupL-checkbox">
			<!--오늘 하루보기 사용 체크박스 --
            <input type='checkbox' id="closeToday" class='devPopupToday' devPopupIx='<?php echo $TPL_VAR["popupIx"]?>' onClick="$(this).prop('checked', true);common.noti.popup.close('<?php echo $TPL_VAR["popupType"]?>', '<?php echo $TPL_VAR["popupIx"]?>');" />
            <label for="closeToday">오늘 하루 열지않기</label>
			<!--오늘 하루보기 사용 체크박스 -- 
			<input type="checkbox" id="closeToday" class='devPopupToday' onclick="" />
			<label for="closeToday">오늘 하루 열지않기</label>
		</div>
		<span class="noti__popup__closebtn main_popupL-closebtn" onclick="">닫기</span>
	</div>
</div>
<!-- 팝업 E -->