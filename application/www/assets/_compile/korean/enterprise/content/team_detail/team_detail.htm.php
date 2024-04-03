<?php /* Template_ 2.2.8 2024/02/14 15:53:45 /home/barrel-qa/application/www.bak/assets/templet/enterprise/content/team_detail/team_detail.htm 000014367 */ 
$TPL_displayContentGroupList_1=empty($TPL_VAR["displayContentGroupList"])||!is_array($TPL_VAR["displayContentGroupList"])?0:count($TPL_VAR["displayContentGroupList"]);?>
<!-- 컨텐츠 영역 S -->
<section class="fb-teamBARREL__detail">
	<div class="detail-layout">
		<div class="detail-layout__lnb">
			<div class="detail-slide swiper-container">
				<div class="swiper-wrapper">
<?php if(is_array($TPL_R1=$TPL_VAR["displayContentList"]["imgSrc"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<div class="swiper-slide"><img src="<?php echo $TPL_V1["imgSrcUrl"]?>" alt="" /></div>
<?php }}?>
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
		<div class="detail-layout__content">
			<div class="fb-scroll">
				<div class="fb-teamBARREL__profile">
					<div class="fb-teamBARREL__profile-header">
						<div class="title-md" style="color:<?php echo $TPL_VAR["displayContentList"]["c_preface"]?>;<?php if($TPL_VAR["displayContentList"]["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["preface"]?></div>
						<p style="color:<?php echo $TPL_VAR["displayContentList"]["c_comment"]?>;<?php if($TPL_VAR["displayContentList"]["b_comment"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_comment"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_comment"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["player_comment"]?></p>
					</div>
					<div class="fb-teamBARREL__profile-content">
						<div class="fb-teamBARREL__profile-group">
							<div class="fb-teamBARREL__profile-img">
								<img src="<?php echo $TPL_VAR["displayContentList"]["contentImgSrc"]?>" alt="" />
							</div>
							<div class="fb-teamBARREL__profile-name">
								<div class="title-lg layout-flex" style="text-align:<?php if($TPL_VAR["displayContentList"]["s_title"]=='L'){?>left<?php }elseif($TPL_VAR["displayContentList"]["s_title"]=='C'){?>center<?php }elseif($TPL_VAR["displayContentList"]["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_VAR["displayContentList"]["c_title"]?>;<?php if($TPL_VAR["displayContentList"]["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["title"]?>

									<span style="color:<?php echo $TPL_VAR["displayContentList"]["c_title_b"]?>;<?php if($TPL_VAR["displayContentList"]["b_title_b"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_title_b"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_title_b"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["title_en"]?></span>
								</div>
								<p style="color:<?php echo $TPL_VAR["displayContentList"]["c_explanation"]?>;<?php if($TPL_VAR["displayContentList"]["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["explanation"]?></p>
								<div class="fb-teamBARREL__profile-footer">
<?php if(is_array($TPL_R1=$TPL_VAR["displayContentList"]["instar"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
										<a href="<?php echo $TPL_V1["Url"]?>"><i class="ico ico-instagram"></i></a>
<?php }}?>
<?php if(is_array($TPL_R1=$TPL_VAR["displayContentList"]["youtube"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
										<a href="<?php echo $TPL_V1["Url"]?>"><i class="ico ico-youtube"></i></a>
<?php }}?>
								</div>
							</div>
						</div>
						<div class="fb-teamBARREL__profile-record">
							<div class="title-sm">Profile</div>
							<p style="color:<?php echo $TPL_VAR["displayContentList"]["c_profile"]?>;<?php if($TPL_VAR["displayContentList"]["b_profile"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_profile"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_profile"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["player_profile"]?></p>
							<!--<p>· 2015 서프엑스 롱보드 앤 비기너 챔피언십 남자 롱보드 오픈부 1위</p>
							<p>· 2015 양양 서핑 페스티벌 남자 롱보드 스페셜부 3위</p>
							<p>· 2015 부산시장배 국제서핑대회 남자 롱보드 오픈부 2위</p>
							<p>· 2014 제주오픈 중문비치 국제서핑대회 남자 롱보드 오픈부 2위</p>-->
						</div>
					</div>
				</div>
<?php if($TPL_displayContentGroupList_1){foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){?>
					<section class="detail-goods__wrap">
						<div class="title-sm" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_VAR["s_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_group_title"]?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["group_title"]?></div>
						<div class="gallery-bbs">
							<ul class="gallery-bbs__box col-2">
<?php if(is_array($TPL_R2=$TPL_V1["groupList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<li class="gallery-bbs__list">
										<a href="<?php if($TPL_V2["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V2["con_ix"]?>">
											<div class="gallery-bbs__category"><?php echo $TPL_V2["preface"]?></div>
											<div class="gallery-bbs__img-box">
												<figure class="gallery-bbs__img">
													<img src="<?php echo $TPL_V2["contentImgSrc"]?>" alt="" />
												</figure>
											</div>
											<div class="gallery-bbs__info">
												<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
												<div class="gallery-bbs__title"><?php echo $TPL_V2["title"]?></div>
												<div class="gallery-bbs__title-sub"><?php echo $TPL_V2["explanation"]?></div>
											</div>
										</a>
									</li>
<?php }}else{?>
								<!-- 등록된 게시글이 없을 경우 S -->
									<li class="gallery-bbs__list no-data" style="display: none">
										<p class="empty-content">등록된 이벤트가 없습니다.</p>
									</li>
								<!-- 등록된 게시글이 없을 경우 E -->
<?php }?>
							</ul>
							<ul class="fb__goods col-3">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
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
<?php }}else{?>
								<!--등록된 상품이 없을 시 S -->
									<li class="gallery-bbs__list no-data" style="display: none">
										<p class="empty-content">등록된 상품이 없습니다.</p>
									</li>
								<!--등록된 상품이 없을 시 E -->
<?php }?>
							</ul>
						</div>
					</section>
<?php }}?>
				<!--<section class="detail-goods__wrap">
					<div class="title-sm">Related Contents</div>
					<div class="gallery-bbs">
						<ul class="gallery-bbs__box col-2">

							&lt;!&ndash; 등록된 게시글이 없을 경우 S &ndash;&gt;
							<li class="gallery-bbs__list no-data" style="display: none">
								<p class="empty-content">등록된 이벤트가 없습니다.</p>
							</li>
							&lt;!&ndash; 등록된 게시글이 없을 경우 E &ndash;&gt;


							<li class="gallery-bbs__list">
                                <a href="#;">
                                    <div class="gallery-bbs__category">EPISODE</div>
                                    <div class="gallery-bbs__img-box">
                                        <figure class="gallery-bbs__img">
                                            <img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample19.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="gallery-bbs__info">
                                        <button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
                                        <div class="gallery-bbs__title">2017 하와이 서프 트립</div>
                                        <div class="gallery-bbs__title-sub">배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요. 배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요.</div>
                                    </div>
                                </a>
                            </li>
                            <li class="gallery-bbs__list">
                                <a href="#;">
                                    <div class="gallery-bbs__category">EPISODE</div>
                                    <div class="gallery-bbs__img-box">
                                        <figure class="gallery-bbs__img">
                                            <img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample20.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="gallery-bbs__info">
                                        <button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
                                        <div class="gallery-bbs__title">BALI SURFING TRIP</div>
                                        <div class="gallery-bbs__title-sub">배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요. 배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요.배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요. 배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요.배럴의 다양한 활동</div>
                                    </div>
                                </a>
                            </li>
                            <li class="gallery-bbs__list">
                                <a href="#;">
                                    <div class="gallery-bbs__category">COLLECTION</div>
                                    <div class="gallery-bbs__img-box">
                                        <figure class="gallery-bbs__img">
                                            <img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample21.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="gallery-bbs__info">
                                        <button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>
                                        <div class="gallery-bbs__title">SEA TO LAND KONA BOARDSHORT</div>
                                        <div class="gallery-bbs__title-sub">배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요. 배럴의 다양한 활동 및 컬렉션 쇼케이스를 만나보세요.</div>
                                    </div>
                                </a>
                            </li>
						</ul>
					</div>
				</section>-->
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 영역 E -->