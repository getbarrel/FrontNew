<?php /* Template_ 2.2.8 2024/03/27 09:28:34 /home/barrel-stage/application/www/assets/templet/enterprise/content/special_list/special_list.htm 000007173 */ 
$TPL_displayContentClassDepthList_1=empty($TPL_VAR["displayContentClassDepthList"])||!is_array($TPL_VAR["displayContentClassDepthList"])?0:count($TPL_VAR["displayContentClassDepthList"]);
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);?>
<!-- 컨텐츠 영역 S -->
<section class="fb-inside__bbs">
	<section class="gallery-bbs">
    <form id="devSpecialForm" name="devSpecialForm">
		<input type="hidden" name="page" value="1" id="devPage"/>
		<input type="hidden" name="max" value="9" id="devMax"/>
		<div class="gallery-bbs__header">
			<h2 class="fb__main__title">
<?php if($TPL_displayContentClassDepthList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassDepthList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_VAR["paramCid"]=="001001"){?>
<?php if($TPL_I1== 0){?>
						전체
<?php }?>
<?php }?>
<?php if($TPL_VAR["paramCid"]==$TPL_V1["cid"]){?>
						<?php echo $TPL_V1["cname"]?>

<?php }?>
<?php }}?>
			</h2>
		</div>
		<ul class="gallery-bbs__box">
<?php if($TPL_VAR["displayContentList"]){?>
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
					<li class="gallery-bbs__list">
						<!-- 이벤트 종료시 class = event-end-->
						<div class="gallery-bbs__category" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
						<div class="gallery-bbs__img-box">
							<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
								<figure class="gallery-bbs__img">
									<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
								</figure>
							</a>
						</div>
						<div class="gallery-bbs__info">
							<!--<button type="button" class="btn-wishlist active"><i class="ico ico-wishlist"></i>좋아요</button>-->
							<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)"><i class="ico <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>ico-wishlist2<?php }else{?>ico-wishlist<?php }?>"></i>좋아요</button>
							<!--a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" style="width:21px;" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)">좋아요</a-->
							<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
								<div class="gallery-bbs__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo $TPL_V1["title"]?>

								</div>
							</a>
							<div class="gallery-bbs__title-sub" style="margin-top:19px;color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
								<?php echo $TPL_V1["explanation"]?>

							</div>
<?php if($TPL_V1["display_date_use"]=="Y"){?>
							<div class="gallery-bbs__date"><?php echo $TPL_V1["display_start"]?> ~ <?php echo $TPL_V1["display_end"]?></div>
<?php }?>
						</div>
					</li>
<?php }}?>
<?php }else{?>
				<!-- 등록된 게시글이 없을 경우 S -->
				<li class="gallery-bbs__list no-data">
					<p class="empty-content">등록된 기획전이 없습니다.</p>
				</li>
				<!-- 등록된 게시글이 없을 경우 E -->
<?php }?>
		</ul>

		<!-- 페이지네이션 S -->
		<div id="devPageWrap">
<?php if($TPL_VAR["displayContentPaging"]){?>
				<div class="wrap-pagination">
					<button type="button" class="prev btn-pagination-prev prev devPageBtnCls" onClick="location.href='/content/specialList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["prevPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["prevPage"]){?>disabled<?php }?>><i class="ico ico-arrow-left" ></i>이전</button>

<?php if($TPL_VAR["lastPage"]> 10){?>
<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/specialList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["firstPage"]?>" class="devPageBtnCls on"><?php echo $TPL_VAR["firstPage"]?></a><?php }?>

					<div class="fb__bubble" <?php if($TPL_VAR["firstPage"]==$TPL_VAR["lastPage"]){?>style="display:none"<?php }?>>
						<a href="/content/specialList/<?php echo $TPL_VAR["firstPage"]?>">...</a>
						<div class="fb__go-page">
							<div class="fb__go-form">
								<div class="fb__form-item">
									<label for="" class="fb__form-label--hidden">페이지넘버</label>
									<input type="text" class="fb__form-input" />
								</div>
								<div class="fb__go-last"><?php echo $TPL_VAR["lastPage"]?></div>
								<button type="button" class="btn-sx">GO</button>
							</div>
						</div>
					</div>
<?php }?>

					<?php echo $TPL_VAR["pageNumTpl"]?>


<?php if($TPL_VAR["lastPage"]> 10){?>
					<div class="fb__bubble" <?php if($TPL_VAR["firstPage"]==$TPL_VAR["lastPage"]){?>style="display:none"<?php }?>>
						<a href="/content/specialList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["lastPage"]?>">...</a>
						<div class="fb__go-page">
							<div class="fb__go-form">
								<div class="fb__form-item">
									<label for="" class="fb__form-label--hidden">페이지넘버</label>
									<input type="text" class="fb__form-input" value="<?php echo $TPL_VAR["lastPage"]?>" />
								</div>
								<div class="fb__go-last"><?php echo $TPL_VAR["lastPage"]?></div>
								<button type="button" class="btn-sx">GO</button>
							</div>
						</div>
					</div>

<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/specialList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["lastPage"]?>" class="devPageBtnCls"><?php echo $TPL_VAR["lastPage"]?></a><?php }?>
<?php }?>
					<button type="button" class="next btn-pagination-next" onClick="location.href='/content/specialList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["nextPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["nextPage"]){?>disabled<?php }?>><i class="ico ico-arrow-right"></i>다음</button>
				</div>
<?php }?>
		</div>
		</form>
		<!-- 페이지네이션 E -->
	</section>
</section>
<!-- 컨텐츠 영역 E -->