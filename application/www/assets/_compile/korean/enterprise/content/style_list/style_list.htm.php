<?php /* Template_ 2.2.8 2024/04/02 09:51:31 /home/barrel-stage/application/www/assets/templet/enterprise/content/style_list/style_list.htm 000005720 */ 
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);?>
<!-- 컨텐츠 영역 S -->
<section class="fb-StyleCuration__bbs">
	<section class="gallery-bbs">
		<div class="gallery-bbs__header">
			<h2 class="fb__main__title--hidden">Style Curation 게시판</h2>
		</div>
		<ul class="gallery-bbs__box col-4">
<?php if($TPL_VAR["displayContentList"]){?>
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
					<li class="gallery-bbs__list">
						<div class="gallery-bbs__category" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
						<div class="gallery-bbs__img-box">
							<a href="/content/styleDetail/<?php echo $TPL_V1["con_ix"]?>/<?php echo $TPL_V1["cid"]?>">
								<figure class="gallery-bbs__img">
									<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
								</figure>
							</a>
						</div>
						<div class="gallery-bbs__info">
							<!-- <a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" style="width:21px;" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)">좋아요</a> -->
							<a href="/content/styleDetail/<?php echo $TPL_V1["con_ix"]?>/<?php echo $TPL_V1["cid"]?>">
								<div class="gallery-bbs__title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo $TPL_V1["title"]?>

								</div>
							</a>
							<div class="gallery-bbs__title-sub" style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
								<?php echo $TPL_V1["explanation"]?>

							</div>
						</div>
					</li>
<?php }}?>
<?php }else{?>
			<!-- 등록된 게시글이 없을 경우 S -->
				<li class="gallery-bbs__list no-data" style="display:">
					<p class="empty-content">등록된 글이 없습니다.</p>
				</li>
			<!-- 등록된 게시글이 없을 경우 E -->
<?php }?>
		</ul>

		<!-- 페이지네이션 S -->
		<div id="devPageWrap">
<?php if($TPL_VAR["displayContentPaging"]){?>
				<div class="wrap-pagination">
					<button type="button" class="prev btn-pagination-prev prev devPageBtnCls" onClick="location.href='/content/styleList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["prevPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["prevPage"]){?>disabled<?php }?>><i class="ico ico-arrow-left" ></i>이전</button>

<?php if($TPL_VAR["lastPage"]> 10){?>
<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/styleList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["firstPage"]?>" class="devPageBtnCls on"><?php echo $TPL_VAR["firstPage"]?></a><?php }?>
					<div class="fb__bubble" <?php if($TPL_VAR["firstPage"]==$TPL_VAR["lastPage"]){?>style="display:none"<?php }?>>
						<a href="/content/styleList/<?php echo $TPL_VAR["firstPage"]?>">...</a>
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
						<a href="/content/styleList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["lastPage"]?>">...</a>
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
					

<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/styleList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["lastPage"]?>" class="devPageBtnCls"><?php echo $TPL_VAR["lastPage"]?></a><?php }?>
<?php }?>
					<button type="button" class="next btn-pagination-next" onClick="location.href='/content/styleList/<?php echo $TPL_VAR["paramCid"]?>/<?php echo $TPL_VAR["nextPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["nextPage"]){?>disabled<?php }?>><i class="ico ico-arrow-right"></i>다음</button>
				</div>
<?php }?>
		</div>
		</form>
		<!-- 페이지네이션 E -->
	</section>
</section>
<!-- 컨텐츠 영역 E -->