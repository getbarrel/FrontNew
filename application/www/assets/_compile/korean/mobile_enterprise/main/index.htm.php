<?php /* Template_ 2.2.8 2024/04/02 16:08:19 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/main/index.htm 000046889 */ 
$TPL_mainBannerInfo_1=empty($TPL_VAR["mainBannerInfo"])||!is_array($TPL_VAR["mainBannerInfo"])?0:count($TPL_VAR["mainBannerInfo"]);
$TPL_mainContentSpecialInfo_1=empty($TPL_VAR["mainContentSpecialInfo"])||!is_array($TPL_VAR["mainContentSpecialInfo"])?0:count($TPL_VAR["mainContentSpecialInfo"]);
$TPL_mainBastCateList_1=empty($TPL_VAR["mainBastCateList"])||!is_array($TPL_VAR["mainBastCateList"])?0:count($TPL_VAR["mainBastCateList"]);
$TPL_mainBastCateProductListAll_1=empty($TPL_VAR["mainBastCateProductListAll"])||!is_array($TPL_VAR["mainBastCateProductListAll"])?0:count($TPL_VAR["mainBastCateProductListAll"]);
$TPL_mainMovieBannerInfo_1=empty($TPL_VAR["mainMovieBannerInfo"])||!is_array($TPL_VAR["mainMovieBannerInfo"])?0:count($TPL_VAR["mainMovieBannerInfo"]);
$TPL_mainContentMainGroupRelationList_1=empty($TPL_VAR["mainContentMainGroupRelationList"])||!is_array($TPL_VAR["mainContentMainGroupRelationList"])?0:count($TPL_VAR["mainContentMainGroupRelationList"]);
$TPL_displayContentClassStyleList_1=empty($TPL_VAR["displayContentClassStyleList"])||!is_array($TPL_VAR["displayContentClassStyleList"])?0:count($TPL_VAR["displayContentClassStyleList"]);
$TPL_mainJournalInfo_1=empty($TPL_VAR["mainJournalInfo"])||!is_array($TPL_VAR["mainJournalInfo"])?0:count($TPL_VAR["mainJournalInfo"]);
$TPL_mainContentContentInfo_1=empty($TPL_VAR["mainContentContentInfo"])||!is_array($TPL_VAR["mainContentContentInfo"])?0:count($TPL_VAR["mainContentContentInfo"]);?>
<?php if(!empty($TPL_VAR["mainDisplayGroupData"])){?>
<script>var mainDisplayGroupData = <?php echo $TPL_VAR["mainDisplayGroupData"]?>;</script> 
<?php }?>

<!-- Criteo 홈페이지 태그 23.06.29 -->
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
<section class="br-main">
	<h2 class="hidden">main</h2>

	<!-- 메인 비주얼 S -->
<?php if($TPL_VAR["mainBannerInfo"]){?>
	<section class="br-main__slider br-main__visual">
		<h3 class="hidden">main slider</h3>
		<div class="mainSlider mainVisual">
			<div class="mainSlider__slider swiper-container">
				<div class="swiper-wrapper">
<?php if($TPL_mainBannerInfo_1){foreach($TPL_VAR["mainBannerInfo"] as $TPL_V1){?>
					<div class="swiper-slide mainSlider__item">
						<a href="<?php echo $TPL_V1["bannerLink"]?>">
                            <div class="mainSlider__item-group">
                                <div class="mainSlider__item-title--sm" style="text-align:<?php if($TPL_V1["s_title_m"]=='L'){?>left<?php }elseif($TPL_V1["s_title_m"]=='C'){?>center<?php }elseif($TPL_V1["s_title_m"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title_m"]?>;<?php if($TPL_V1["b_title_m"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title_m"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title_m"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["shot_title_m"]?></div>
                                <div class="mainSlider__item-title" style="text-align:<?php if($TPL_V1["s_name_m"]=='L'){?>left<?php }elseif($TPL_V1["s_name_m"]=='C'){?>center<?php }elseif($TPL_V1["s_name_m"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_name_m"]?>;<?php if($TPL_V1["b_name_m"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_name_m"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_name_m"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo nl2br($TPL_V1["banner_name_m"])?>

                                </div>
                                <p style="text-align:<?php if($TPL_V1["s_desc_m"]=='L'){?>left<?php }elseif($TPL_V1["s_desc_m"]=='C'){?>center<?php }elseif($TPL_V1["s_desc_m"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_desc_m"]?>;<?php if($TPL_V1["b_desc_m"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_desc_m"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_desc_m"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo nl2br($TPL_V1["banner_desc_m"])?>

                                </p>
                            </div>
							<figure>
								<img src="<?php echo $TPL_V1["imgSrcOn"]?>" alt="<?php echo $TPL_V1["banner_name_m"]?>" />
							</figure>
						</a>
					</div>
<?php }}?>
				</div>
				<div class="mainSlider__control">
					<div class="swiper-control-group">
						<div class="swiper-scrollbar"></div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php }?>
	<!-- 메인 비주얼 E -->

	<!-- 1. 확인 완료 -->

	<!-- Hot Contents 영역 S -->
	<section class="br-main__section br-main__HotContents">
		<div class="br-main__inner">
			<div class="br-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_special"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_special"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_special"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_special"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_special"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_special"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_special"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["special_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_special_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_special_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_special_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_special_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["special_e"]?></span>
			</div>
			<div class="br-main__slide">
				<div class="br-main__card-slider swiper-container card-slider">
					<div class="swiper-wrapper">
<?php if($TPL_mainContentSpecialInfo_1){foreach($TPL_VAR["mainContentSpecialInfo"] as $TPL_V1){?>
						<div class="swiper-slide">
							<div class="br-main__card-item">
								<div class="br-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?>&nbsp;</div>
								<dl class="br-main__card-cont">
									<dt class="br-main__card-img">
										<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
											<img src="<?php echo $TPL_V1["contentRecomImgSrc"]?>" alt="" />
										</a>
									</dt>
									<dd class="br-main__card-textBOX">
										<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
											<div class="br-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
												<?php echo $TPL_V1["title"]?>

											</div>
											<p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
												<?php echo $TPL_V1["explanation"]?>

											</p>
<?php if($TPL_V1["display_date_use"]=="Y"){?>
											<p><?php echo $TPL_V1["startDate"]?> - <?php echo $TPL_V1["endDate"]?></p>
<?php }?>
										</a>
										<!-- 버튼으로 할 경우 S -->
										<!-- 숨김처리 -->
										<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)">
											<!-- 선택시 button class = active 추가-->
											<i class="ico ico-wishlist"></i>위시리스트
										</button>
										<!-- 버튼으로 할 경우 E -->

										<!-- 체크 박스로 할 경우 S -->
										<label class="br-main__card-wish" style="display: none">
											<input type="checkbox" class="br-main__card-wish--btn" />
										</label>
										<!-- 체크 박스로 할 경우 E -->
									</dd>
								</dl>
							</div>
						</div>
<?php }}?>
					</div>
					<div class="br-main__card-control">
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

	<!-- 2. 확인 완료 -->


	<!-- Best Items 영역 S -->
<?php if($TPL_VAR["mainBastCateUse"]=="Y"){?>
	<section class="br-main__section br-main__BestItems">
		<div class="br-main__inner">
			<div class="br-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_best"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_best"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_best"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_best"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_best"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_best"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_best"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["best_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_best_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_best_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_best_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_best_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["best_e"]?></span>
				<a href="/shop/goodsList/<?php echo $TPL_VAR["mainBastCateCode"]?>">전체보기</a>
			</div>
			<div class="br-tab__wrap">
				<div class="br-tab__nav br-tab__slide swiper-container" id="one">
					<ul class="swiper-wrapper">
<?php if($TPL_mainBastCateList_1){$TPL_I1=-1;foreach($TPL_VAR["mainBastCateList"] as $TPL_V1){$TPL_I1++;?>
						<li class="swiper-slide <?php if($TPL_I1== 0){?>active<?php }?>"><a href="javascript:void(0);"><?php echo $TPL_V1["cname"]?></a></li>
<?php }}?>
					</ul>
				</div>
				<div class="br-tab__contents-wrap">
<?php if($TPL_mainBastCateProductListAll_1){$TPL_I1=-1;foreach($TPL_VAR["mainBastCateProductListAll"] as $TPL_V1){$TPL_I1++;?>
					<div class="br-tab__contents <?php if($TPL_I1== 0){?> active<?php }?>" id="bestItemListDivNum_<?php echo $TPL_I1?>">
						<div class="br-main__card-slider swiper-container goods-slider">
							<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<div class="goods-list__box swiper-slide">
									<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
										<div class="goods-list__thumb">
											<div class="goods-list__thumb-slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
													</div>
												</div>
											</div>
											<!-- 버튼으로 할 경우 S -->
											<!-- 숨김처리 -->
											<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)" style="display: none">
												<!-- 선택시 button class = active 추가-->
												<i class="ico ico-wishlist"></i>위시리스트
											</button>
											<!-- 버튼으로 할 경우 E -->

											<!-- 체크 박스로 할 경우 S -->
											<label class="br-main__card-wish" style="display: none">
												<input type="checkbox" class="br-main__card-wish--btn" />
											</label>
											<label class="goods-list__wish">
												<input type="checkbox" class="goods-list__wish__btn" />
											</label>

											<label class="goods-list__wish" devwishbtn="<?php echo $TPL_V2["id"]?>">
<?php if($TPL_V2["alreadyWish"]){?>
												<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')" checked>
<?php }else{?>
												<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')">
<?php }?>
											</label>
											<!-- 체크 박스로 할 경우 E -->
										</div>
										<div class="goods-list__info">
<?php if($TPL_V2["preface"]){?><div class="goods-list__pre br__goods__pre"><?php echo $TPL_V2["preface"]?></div><?php }?>
											<div class="goods-list__title"><?php echo $TPL_V2["pname"]?></div>
											<div class="goods-list__color"><?php echo $TPL_V2["add_info"]?></div>
											<div class="goods-list__price">
												<div class="goods-list__price__percent"  <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><span><?php echo $TPL_V2["discount_rate"]?></span>%</div>
												<div class="goods-list__price__discount"><span><?php echo $TPL_V2["dcprice"]?></span></div>
												<div class="goods-list__price__cost" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><del><?php echo $TPL_V2["sellprice"]?></del></div>
												<!-- 품절일 경우 S -->
												<!-- 숨김 처리 -->
												<div class="goods-list__price__state" style="display: none">품절</div>
												<!-- 품절일 경우 E -->
											</div>
										</div>
									</a>
								</div>
<?php }}?>
								<div class="goods-list__box swiper-slide">
									<a href="/shop/goodsList/<?php echo $TPL_VAR["mainBastCateList"][$TPL_I1]["cid"]?>" class="best_more">
										<img src="/assets/mobile_templet/mobile_enterprise/assets/img/best_more_bg.jpg">
										<span>
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/best_more.svg" class="best_more_btn">
											<p><?php echo $TPL_VAR["mainBastCateList"][$TPL_I1]["cname"]?> 전체보기</p>
										</span>
									</a>
								</div>
							</div>
							<div class="br-main__card-control">
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
	<section class="br-main__section br-main__banner">
<?php if($TPL_mainMovieBannerInfo_1){foreach($TPL_VAR["mainMovieBannerInfo"] as $TPL_V1){?>
		<div class="br-main__inner">
			<!--<img src="/assets/mobile_templet/mobile_enterprise/assets/img/main_middle_banner.png" alt="" />-->
			<iframe width="100%" src="<?php echo $TPL_V1["banner_html_m"]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
<?php }}?>
	</section>
<?php }?>
	<!-- 동영상 banner 영역 E -->

<?php if($TPL_mainContentMainGroupRelationList_1){foreach($TPL_VAR["mainContentMainGroupRelationList"] as $TPL_V1){?>
<?php if($TPL_V1["group_con_gubun"]=="B"){?>
<?php if($TPL_V1["displayCnt"]== 0){?>
				<section class="br-main__section br-main__FocusNow">
					<div class="br-main__inner">
						<div class="br-main__title">
							<h3 style="text-align:<?php if($TPL_V1["s_main_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_main_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_main_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_main_group_title"]?>;<?php if($TPL_V1["b_main_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_title"]?></h3>
							<span style="color:<?php echo $TPL_V1["c_main_group_explanation"]?>;<?php if($TPL_V1["b_main_group_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_explanation"]?></span>
						</div>
					</div>
				</section>
<?php }?>
<?php if($TPL_V1["slider_group_con_gubun"]=="N"){?>
				<!-- banner 영역 S -->
				<!--<section class="br-main__section br-main__banner">
					<div class="br-main__inner">
						<a href="<?php echo $TPL_V1["banner_link"]?>">
							<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
						</a>
					</div>
				</section>-->
				<section class="br-main__section br-main__slider">
					<div class="mainSlider">
						<div class="mainSlider__slider swiper-container">
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
				</section>
				<!-- banner 영역 E -->
<?php }else{?>
				<section class="br-main__section br-main__slider">
					<div class="mainSlider">
						<div class="mainSlider__slider swiper-container">
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
								</div>
							</div>
						</div>
					</div>
				</section>
<?php }?>
<?php }?>
<?php if($TPL_V1["group_con_gubun"]=="S"){?>
<?php if($TPL_V1["displayCnt"]== 0){?>
				<!-- Focus Now 영역 S -->
				<section class="br-main__section br-main__FocusNow">
					<div class="br-main__inner">
						<div class="br-main__title">
							<h3 style="text-align:<?php if($TPL_V1["s_main_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_main_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_main_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_main_group_title"]?>;<?php if($TPL_V1["b_main_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_title"]?></h3>
							<span style="color:<?php echo $TPL_V1["c_main_group_explanation"]?>;<?php if($TPL_V1["b_main_group_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_main_group_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_main_group_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["main_group_explanation"]?></span>
						</div>
						<div class="focusNow-wrap">
							<dl class="focusNow-item">
								<dt class="focusNow-item__img">
									<!--<div class="br-main__title" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_group_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h4 style="color:<?php echo $TPL_V1["c_group_title"]?>;">
											<?php echo $TPL_V1["group_title"]?>

										</h4>
									</div>-->
									<div class="br-main__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h4 style="color:<?php echo $TPL_V1["c_title"]?>;">
											<?php echo $TPL_V1["title"]?>

										</h4>
									</div>
									<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">
										<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
									</a>
								</dt>
								<dd class="focusNow-item__cont">
									<div class="br-main__goods">
										<div class="br-main__goods-title">
											<h4>연관 상품</h4>
											<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
										</div>
										<div class="br-main__FocusNow-slider swiper-container goods-slider">
											<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
													<div class="goods-list__box swiper-slide">
														<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
															<div class="goods-list__thumb">
																<div class="goods-list__thumb-slide swiper-container">
																	<div class="swiper-wrapper">
																		<div class="swiper-slide">
																			<img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
																		</div>
																		<div class="swiper-slide">
																			<img src="<?php echo $TPL_V2["image_src2"]?>" alt="" />
																		</div>
																	</div>
																	<div class="swiper-control-group">
																		<div class="swiper-scrollbar"></div>
																	</div>
																</div>
																<!-- 버튼으로 할 경우 S -->
																<!-- 숨김처리 -->
																<button type="button" class="btn-wishlist <?php if($TPL_V2["alreadyWish"]){?>active<?php }?>" data-devWishBtn="<?php echo $TPL_V2["id"]?>" style="display: none">
																	<!-- 선택시 button class = active 추가-->
																	<i class="ico ico-wishlist"></i>위시리스트
																</button>
																<!-- 버튼으로 할 경우 E -->

																<!-- 체크 박스로 할 경우 S -->
																<label class="goods-list__wish" style="display: none">
																	<input type="checkbox" class="goods-list__wish__btn" />
																</label>
																<label class="goods-list__wish" devwishbtn="<?php echo $TPL_V2["id"]?>">
<?php if($TPL_V2["alreadyWish"]){?>
																	<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')" checked>
<?php }else{?>
																	<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')">
<?php }?>
																</label>
																<!-- 체크 박스로 할 경우 E -->
															</div>
															<div class="goods-list__info">
<?php if($TPL_V2["preface"]){?><div class="goods-list__pre br__goods__pre" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></div><?php }?>
																<div class="goods-list__title"><?php echo $TPL_V2["pname"]?></div>
																<div class="goods-list__color"><?php echo $TPL_V2["add_info"]?></div>
																<div class="goods-list__price">
																	<div class="goods-list__price__percent" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><span><?php echo $TPL_V2["discount_rate"]?></span>%</div>
																	<div class="goods-list__price__discount"><span><?php echo $TPL_V2["dcprice"]?></span></div>
																	<div class="goods-list__price__cost" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><del><?php echo $TPL_V2["sellprice"]?></del></div>
																	<!-- 품절일 경우 S -->
																	<!-- 숨김 처리 -->
																	<div class="goods-list__price__state" style="display: none">품절</div>
																	<!-- 품절일 경우 E -->
																</div>
															</div>
														</a>
													</div>
<?php }}?>
											</div>
										</div>
									</div>
								</dd>
							</dl>
						</div>
					</div>
				</section>
<?php }else{?>
				<section class="br-main__section br-main__FocusNow">
					<div class="br-main__inner">
						<div class="focusNow-wrap">
							<dl class="focusNow-item">
								<dt class="focusNow-item__img">
									<!--<div class="br-main__title" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_V1["s_group_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h4 style="color:<?php echo $TPL_V1["c_group_title"]?>;">
											<?php echo $TPL_V1["group_title"]?>

										</h4>
									</div>-->
									<div class="br-main__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
										<h4 style="color:<?php echo $TPL_V1["c_title"]?>;">
											<?php echo $TPL_V1["title"]?>

										</h4>
									</div>
									<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">
										<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
									</a>
								</dt>
								<dd class="focusNow-item__cont">
									<div class="br-main__goods">
										<div class="br-main__goods-title">
											<h4>연관 상품</h4>
											<a href="/content/focusNow1/<?php echo $TPL_V1["con_ix"]?>">더 많은 상품 보러가기</a>
										</div>
										<div class="br-main__FocusNow-slider swiper-container goods-slider">
											<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["bastProductList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												<div class="goods-list__box swiper-slide">
													<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
														<div class="goods-list__thumb">
															<div class="goods-list__thumb-slide swiper-container">
																<div class="swiper-wrapper">
																	<div class="swiper-slide">
																		<img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
																	</div>
																	<div class="swiper-slide">
																		<img src="<?php echo $TPL_V2["image_src2"]?>" alt="" />
																	</div>
																</div>
																<div class="swiper-control-group">
																	<div class="swiper-scrollbar"></div>
																</div>
															</div>
															<!-- 버튼으로 할 경우 S -->
															<!-- 숨김처리 -->
															<button type="button" class="btn-wishlist <?php if($TPL_V2["alreadyWish"]){?>active<?php }?>" data-devWishBtn="<?php echo $TPL_V2["id"]?>" style="display: none">
																<!-- 선택시 button class = active 추가-->
																<i class="ico ico-wishlist"></i>위시리스트
															</button>
															<!-- 버튼으로 할 경우 E -->

															<!-- 체크 박스로 할 경우 S -->
															<label class="goods-list__wish" style="display: none">
																<input type="checkbox" class="goods-list__wish__btn" />
															</label>
															<label class="goods-list__wish" devwishbtn="<?php echo $TPL_V2["id"]?>">
<?php if($TPL_V2["alreadyWish"]){?>
																<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')" checked>
<?php }else{?>
																<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V2["id"]?>" onclick="productWish('<?php echo $TPL_V2["id"]?>')">
<?php }?>
															</label>
														</div>
													</a>

														<!-- 체크 박스로 할 경우 E -->
													<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
														<div class="goods-list__info">
<?php if($TPL_V2["preface"]){?><div class="goods-list__pre br__goods__pre" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></div><?php }?>
															<div class="goods-list__title"><?php echo $TPL_V2["pname"]?></div>
															<div class="goods-list__color"><?php echo $TPL_V2["add_info"]?></div>
															<div class="goods-list__price">
																<div class="goods-list__price__percent" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><span><?php echo $TPL_V2["discount_rate"]?></span>%</div>
																<div class="goods-list__price__discount"><span><?php echo $TPL_V2["dcprice"]?></span></div>
																<div class="goods-list__price__cost" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><del><?php echo $TPL_V2["sellprice"]?></del></div>
																<!-- 품절일 경우 S -->
																<!-- 숨김 처리 -->
																<div class="goods-list__price__state" style="display: none">품절</div>
																<!-- 품절일 경우 E -->
															</div>
														</div>
													</a>
												</div>
<?php }}?>
											</div>
										</div>
									</div>
								</dd>
							</dl>
						</div>
					</div>
				</section>
				<!-- Focus Now 영역 E -->
<?php }?>
<?php }?>
<?php }}?>

	<!-- Style Guide 영역 S -->
	<section class="br-main__section br-main__StyleGuide">
		<div class="br-main__inner">
			<div class="br-main__title">
				<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_style"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_style"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_style"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_style"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_style"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_style"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_style"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["style_title"]?></h3>
				<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_style_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_style_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_style_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_style_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["style_e"]?></span>
				<a href="/content/styleList">전체보기</a>
			</div>
			<div class="br-tab__wrap">
				<div class="br-tab__nav br-tab__slide swiper-container" id="two">
					<ul class="swiper-wrapper">
						<!--<li class="swiper-slide active"><a href="/content/styleList">ALL</a></li>-->
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?>
							<li class="swiper-slide <?php if($TPL_I1== 0){?>active<?php }?>"><a href="javascript:void(0);"><?php if($TPL_I1== 0){?>ALL<?php }else{?><?php echo $TPL_V1["cname"]?><?php }?></a></li>
<?php }}?>
					</ul>
				</div>
				<div class="br-tab__contents-wrap">
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?>
					<div class="br-tab__contents <?php if($TPL_I1== 0){?> active<?php }?>">
						<div class="br-main__card-slider swiper-container card-slider">
							<div class="swiper-wrapper">
<?php if(is_array($TPL_R2=$TPL_V1["styleGuide"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<div class="swiper-slide">
									<div class="br-main__card-item">
										<div class="br-main__card-title--sm" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?>&nbsp;</div>
										<dl class="br-main__card-cont">
											<dt class="br-main__card-img">
												<a href="/content/styleDetail/<?php echo $TPL_V2["con_ix"]?>/<?php echo $TPL_V2["cid"]?>">
													<img src="<?php echo $TPL_V2["contentImgSrc"]?>" alt="" />
												</a>
											</dt>
											<dd class="br-main__card-textBOX">
												<a href="/content/styleDetail/<?php echo $TPL_V2["con_ix"]?>/<?php echo $TPL_V2["cid"]?>">
													<div class="br-main__card-title" style="text-align:<?php if($TPL_V2["s_title"]=='L'){?>left<?php }elseif($TPL_V2["s_title"]=='C'){?>center<?php }elseif($TPL_V2["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V2["c_title"]?>;<?php if($TPL_V2["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
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
							<div class="br-main__card-control">
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
	<section class="br-main__section br-main__barrel">
		<div class="br-main__inner">
			<div class="barrel-wrap">
<?php if($TPL_VAR["mainContentInfo"]["journal_use"]=='Y'){?>
				<div class="barrel-item">
					<div class="br-main__title">
						<h3 style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_journal"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_journal"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_journal"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_journal"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["journal_title"]?></h3>
						<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_journal_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_journal_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_journal_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_journal_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["journal_e"]?></span>
						<a href="/content/specialList/001001003000000">전체보기</a>
					</div>
					<div class="barrel-item__group">
						<div class="barrel-item__slider-bg"><span class="left"></span><span class="right"></span><img src="/assets/mobile_templet/mobile_enterprise/assets/img/main_barrel_journal_bg.png" alt="" /></div>
						<div class="barrel-item__slider swiper-container">
							<div class="swiper-wrapper">
<?php if($TPL_mainJournalInfo_1){foreach($TPL_VAR["mainJournalInfo"] as $TPL_V1){?>
								<div class="swiper-slide">
									<a href="<?php echo $TPL_V1["banner_link"]?>">
										<div class="barrel-item__img">
											<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="" />
										</div>
										<div class="barrel-item__title">
											<?php echo $TPL_V1["banner_name"]?>

										</div>
									</a>
								</div>
<?php }}?>
							</div>
						</div>
						<div class="br-main__card-control barrel-item__slider-control">
							<div class="swiper-control-group">
								<div class="swiper-scrollbar"></div>
								<div class="swiper-pagination"></div>
							</div>
						</div>
					</div>
				</div>
<?php }?>
				<div class="barrel-item">
					<div class="br-main__title">
						<h3 style="text-align:<?php if($TPL_VAR["mainContentInfo"]["s_content"]=='L'){?>left<?php }elseif($TPL_VAR["mainContentInfo"]["s_content"]=='C'){?>center<?php }elseif($TPL_VAR["mainContentInfo"]["s_content"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["mainContentInfo"]["c_content"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_content"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_content"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_content"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["content_title"]?></h3>
						<span style="color:<?php echo $TPL_VAR["mainContentInfo"]["c_content_e"]?>;<?php if($TPL_VAR["mainContentInfo"]["b_content_e"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["i_content_e"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["mainContentInfo"]["u_content_e"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["mainContentInfo"]["content_e"]?></span>
						<a href="/content/specialList/001001002000000">전체보기</a>
					</div>
					<div class="br-main__card-slider swiper-container card-slider">
						<div class="swiper-wrapper">
<?php if($TPL_mainContentContentInfo_1){foreach($TPL_VAR["mainContentContentInfo"] as $TPL_V1){?>
							<div class="swiper-slide">
								<div class="br-main__card-item">
<?php if($TPL_V1["preface"]){?><div class="br-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div><?php }?>
									<dl class="br-main__card-cont">
										<dt class="br-main__card-img">
											<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
												<img src="<?php echo $TPL_V1["contentRecomImgSrc"]?>" alt="" />
											</a>
										</dt>
										<dd class="br-main__card-textBOX">
											<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
												<div class="br-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["title"]?>

												</div>
												<p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
													<?php echo $TPL_V1["explanation"]?>

												</p>
											</a>
											<!-- 버튼으로 할 경우 S -->
											<!-- 숨김처리 -->
											<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)" >
												<!-- 선택시 button class = active 추가-->
												<i class="ico ico-wishlist"></i>위시리스트
											</button>
											<!-- 버튼으로 할 경우 E -->

											<!-- 체크 박스로 할 경우 S -->
											<label class="br-main__card-wish" style="display: none">
												<input type="checkbox" class="br-main__card-wish--btn" />
											</label>
											<!-- 체크 박스로 할 경우 E -->
										</dd>
									</dl>
								</div>
							</div>
<?php }}?>
						</div>
						<div class="br-main__card-control" style="min-height:5rem;">
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

<!-- cre.ma / 타겟 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-target-popup"></div>

<!-- cre.ma / 리뷰 작성 유도 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-popup"></div>

<!-- cre.ma / 공통 스크립트 (Mobile) / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<script>(function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})(window,document,'script','crema-jssdk','//widgets.cre.ma/getbarrel.com/mobile/init.js');</script>