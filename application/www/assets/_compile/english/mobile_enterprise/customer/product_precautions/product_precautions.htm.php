<?php /* Template_ 2.2.8 2021/10/05 15:38:50 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/product_precautions/product_precautions.htm 000004665 */ 
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);?>
<section class="br__wash">
    <h2 class="br__wash__title">Washing & Care</h2>
    <style>
		.wash_select {text-align:center;}
		.wash_select select {width:100%; height:40px !important; border:#222 1px solid; color:#000 !important; font-size:1.4rem !important; font-weight:700; text-align: center; text-align:-moz-center; text-align:-webkit-center; text-align-last: center; -ms-text-align-last: center; -moz-text-align-last: center;}
		.wash_sub_txt {color:#000; font-size:12px !important; padding:10px 0 25px; text-align:center;}

		.contents__box-detail--show li.contents__list:last-child {border-bottom:#000 1px solid !important;}

		.crema-type .br .wash__contents .contents__list {padding:1.9rem 0 1.9rem 1.313rem;}
		.crema-type .br .wash__contents .contents__subtitle {font-size:1.4rem !important; display:block !important;}
		.crema-type .br .wash__contents .contents__summary {padding:0.9rem 0.9rem 0 0 !important;}


	</style>

	<div class="wash"  id="laundryInfo">
		<div class="wash_select">
			<select name="laundryOneDepth" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
						<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
						<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
			</select>
			<p class="wash_sub_txt">카테고리를 선택해 주세요.</p>
		</div>

		<nav class="wash__category">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
				<a href="javascrip:void(0);" data-target="<?php echo $TPL_V1["cid"]?>" class="wash__category-link<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?> wash__category-link--active<?php }?>">
<?php if($TPL_VAR["langType"]=='english'){?>
						<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
						<?php echo $TPL_V1["title"]?>

<?php }?>
				</a>
<?php }}?>
		</nav>
		<div class="wash__contents">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
				<section class="wash__contents__category wash__contents<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>__category--show wash__contents<?php }?>-<?php echo $TPL_V1["cid"]?>">
					<div class="contents">
						<h3 class="contents__title">
<?php if($TPL_VAR["langType"]=='english'){?>
								<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
								<?php echo $TPL_V1["title"]?>

<?php }?>
						</h3>
						<nav class="contents__tab">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
									<a href="javascript:void(0);" data-target="wash" class="contents__tab-link contents__tab-link--active">
<?php }else{?>
									<a href="javascript:void(0);" data-target="precaution" class="contents__tab-link">
<?php }?>
<?php if($TPL_VAR["langType"]=='english'){?>
									<?php echo $TPL_V2["title_en"]?>

<?php }else{?>
									<?php echo $TPL_V2["title"]?>

<?php }?>
								</a>
<?php }}?>
						</nav>

						<div class="contents__box">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
									<ul class="contents__box-wash contents__box-detail contents__box-detail--show">
<?php }else{?>
									<ul class="contents__box-precaution contents__box-detail">
<?php }?>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
										<li class="contents__list">
											<h4 class="contents__subtitle">
<?php if($TPL_VAR["langType"]=='english'){?>
													<?php echo $TPL_V3["title_en"]?>

<?php }else{?>
													<?php echo $TPL_V3["title"]?>

<?php }?>
											</h4>
											<div class="contents__summary">
												<ul>
													<li>
<?php if($TPL_VAR["langType"]=='english'){?>
															<?php echo $TPL_V3["contents_en"]?>

<?php }else{?>
															<?php echo $TPL_V3["contents"]?>

<?php }?>
													</li>
												</ul>
											</div>
										</li>
<?php }}?>
								</ul>
<?php }}?>
						</div>
					</div>
				</section>
<?php }}?>
		</div>
	</div>
</section>