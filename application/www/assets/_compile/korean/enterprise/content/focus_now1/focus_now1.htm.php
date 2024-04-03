<?php /* Template_ 2.2.8 2024/02/14 15:54:50 /home/barrel-stage/application/www/assets/templet/enterprise/content/focus_now1/focus_now1.htm 000005632 */ 
$TPL_displayContentGroupList_1=empty($TPL_VAR["displayContentGroupList"])||!is_array($TPL_VAR["displayContentGroupList"])?0:count($TPL_VAR["displayContentGroupList"]);?>
<!-- 컨텐츠 영역 S -->
			<section class="fb-FocusNow__detail">
				<div class="detail-layout">
					<div class="detail-layout__lnb">
						<div class="detail-slide swiper-container">
							<div class="swiper-wrapper">
<?php if(is_array($TPL_R1=$TPL_VAR["displayContentList"]["imgSrc"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<div class="swiper-slide"><img src="<?php echo $TPL_V1["imgSrcUrl"]?>" alt="" /></div>
<?php }}?>
								<!--<div class="swiper-slide"><img src="/assets/templet/enterprise/assets/img/FocusNow_slide_img.png" alt="" /></div>
								<div class="swiper-slide"><img src="/assets/templet/enterprise/assets/img/FocusNow_slide_img.png" alt="" /></div>
								<div class="swiper-slide"><img src="/assets/templet/enterprise/assets/img/FocusNow_slide_img.png" alt="" /></div>
								<div class="swiper-slide"><img src="/assets/templet/enterprise/assets/img/FocusNow_slide_img.png" alt="" /></div>-->
							</div>
							<div class="detail-slide__control">
								<div class="swiper-control-group">
									<div class="swiper-scrollbar"></div>
									<div class="swiper-pagination"></div>
									<button type="button" class="swiper-button swiper-button-prev"></button>
									<button type="button" class="swiper-button swiper-button-next"></button>
								</div>
							</div>
						</div>
					</div>
					<div class="detail-layout__content" style="padding-right:10px;">
						<div class="fb-scroll">
<?php if($TPL_displayContentGroupList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){$TPL_I1++;?>
							<div class="detail-layout__header">
<?php if($TPL_I1== 0){?>
									<span style="color:<?php echo $TPL_VAR["displayContentList"]["c_preface"]?>;<?php if($TPL_VAR["displayContentList"]["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["preface"]?></span>
<?php }?>
								<div class="title-md" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_VAR["s_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_group_title"]?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo $TPL_V1["group_title"]?>

								</div>
							</div>
							<section class="detail-goods__wrap">
								<ul class="fb__goods">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["productList"]){?>
											<li class="fb__goods__list">
												<a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="fb__goods__link">
													<figure class="fb__goods__img">
														<div>
															<img src="<?php echo $TPL_V2["image_src"]?>" alt="상품이미지" />
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
												<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V2["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V2["id"]?>">hart</a>
											</li>
<?php }else{?>
										<!--등록된 상품이 없을 시 S -->
											<li class="empty-content" style="display: none">등록된 상품이 없습니다.</li>
										<!--등록된 상품이 없을 시 E -->
<?php }?>
<?php }}?>
								</ul>
							</section>
<?php }}?>
						</div>
					</div>
				</div>
			</section>
			<!-- 컨텐츠 영역 E -->