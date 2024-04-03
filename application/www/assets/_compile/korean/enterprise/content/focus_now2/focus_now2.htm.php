<?php /* Template_ 2.2.8 2024/03/22 08:46:55 /home/barrel-stage/application/www/assets/templet/enterprise/content/focus_now2/focus_now2.htm 000006510 */ 
$TPL_displayContentGroupList_1=empty($TPL_VAR["displayContentGroupList"])||!is_array($TPL_VAR["displayContentGroupList"])?0:count($TPL_VAR["displayContentGroupList"]);?>
<!-- 컨텐츠 영역 S -->
<section class="fb-FocusNow__detail">
	<div class="detail-layout__full">
		<div class="detail-layout__content">
<?php if($TPL_VAR["displayContentList"]["content_text_pc"]){?>
			<div class="detail-layout__section">
				<div class="fb-FocusNow__banner">
					<?php echo $TPL_VAR["displayContentList"]["content_text_pc"]?>

					<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> <!-- JQuery -->
					<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>
					<script type="text/javascript">
						// rwdImageMaps로 이미지맵 동적 할당하도록 설정
						$('img[usemap]').rwdImageMaps();
					</script>
				</div>
			</div>
<?php }?>
<?php if($TPL_VAR["displayContentList"]["category_use"]=='Y'){?>
			<div class="detail-layout__footer">
				<div class="detail-layout__inner">
					<ul class="fb-FocusNow__nav">
<?php if($TPL_displayContentGroupList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){$TPL_I1++;?>
							<li class="<?php if($TPL_I1== 0){?>active<?php }?>" style="<?php if($TPL_VAR["displayContentList"]["r_category"]=='R'){?>border-radius:10px;<?php }?>background-color:<?php echo $TPL_VAR["displayContentList"]["ba_category"]?>;border-color:<?php echo $TPL_VAR["displayContentList"]["bo_category"]?>;">
								<a href="javascript:void(0);" title="specia<?php echo $TPL_V1["group_code"]?>"><?php echo $TPL_V1["group_title"]?></a>
							</li>
<?php }}?>
					</ul>
				</div>
			</div>
<?php }?>
<?php if($TPL_displayContentGroupList_1){foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){?>
			<div class="detail-layout__section" id="specia<?php echo $TPL_V1["group_code"]?>">
				<div class="fb-FocusNow__banner">
					<!--<img src="/assets/templet/enterprise/assets/img/FocusNow_banner_img02.png" alt="" />-->
					<?php echo $TPL_V1["group_text_pc"]?>

				</div>
				<div class="detail-layout__inner">
					<section class="detail-goods__wrap">
						<span style="color:<?php echo $TPL_V1["c_group_preface"]?>;<?php if($TPL_V1["b_group_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["group_preface"]?></span>
						<div class="title-md" style="margin-top:40px;position: relative;display: flex;-webkit-box-align: end;align-items: flex-end;gap: 0 100px;width: 100%;text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_VAR["s_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_group_title"]?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
							<?php echo $TPL_V1["group_title"]?>

							<span style="line-height:24px;font-size:16px;font-weight:600;color:#a5a5a5;color:<?php echo $TPL_V1["c_group_explanation"]?>;<?php if($TPL_V1["b_group_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["group_explanation"]?></span>
						</div>
						<ul class="fb__goods col-5">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["productList"]){?>
									<li class="fb__goods__list">
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
				</div>
			</div>
<?php }}?>
		</div>
	</div>
</section>
<!-- 컨텐츠 영역 E -->