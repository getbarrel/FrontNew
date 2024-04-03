<?php /* Template_ 2.2.8 2024/03/21 15:09:51 /home/barrel-stage/application/www/assets/templet/enterprise/customer/product_precautions/product_precautions.htm 000003866 */ 
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);?>
<!-- 컨텐츠 S -->
<section class="fb__customer fb__wash">
	<div class="fb__customer__header">
		<div class="title-md">제품 주의사항</div>
	</div>
	<div class="wash" id="laundryInfo">
		<div class="wash__category">
			<div class="wash__category-item">
				<div class="wash__category-title">카테고리 선택</div>
				<div class="wash__category-select">
					<label for="" class="hide">카테고리 선택</label>
					<select name="laundryOneDepth" id="laundryOneDepth" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
								<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
								<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
					</select>
				</div>
			</div>
			<div class="wash__category-item">
				<div class="wash__category-title">상세 아이템 선택</div>
				<div class="wash__category-select">
					<label for="" class="hide">상세 아이템 선택</label>

					<select name="laundryTwoDepth" id="laundryTwoDepth" onchange="laundryChange2(this.value)">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
								<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
								<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
					</select>
				</div>
			</div>
		</div>
		<div class="wash__contents">
			<!-- 카테고리 결과 값 S -->
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
			<section class="wash__contents__category wash__contents<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>__category--show wash__contents<?php }?>-<?php echo $TPL_V1["cid"]?>">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<div class="contents__box">
<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V2["cid"]){?>
					<div class="contents__box-title  contents__box-detail--show">
<?php }else{?>
					<div class="contents__box-title">
<?php }?>
						<div class="title-sm">
<?php if($TPL_VAR["langType"]=='english'){?>
							<?php echo $TPL_V2["title_en"]?>

<?php }else{?>
							<?php echo $TPL_V2["title"]?>

<?php }?>						
						</div>
					</div>
					<div class="contents__list">
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
						<dl class="contents__item">
							<dt class="contents__item-img">
								<img src="/assets/templet/enterprise/assets/img/img_product_precautions<?php echo $TPL_V3["cnt"]?>.png" alt="<?php echo $TPL_V3["title"]?>" />
							</dt>
							<dd class="contents__item-cont">
								<div class="contents__subtitle">
<?php if($TPL_VAR["langType"]=='english'){?>
									<?php echo $TPL_V3["title_en"]?>

<?php }else{?>
									<?php echo $TPL_V3["title"]?>

<?php }?>								
								</div>
								<div class="contents__summary">
<?php if($TPL_VAR["langType"]=='english'){?>
										<?php echo $TPL_V3["contents_en"]?>

<?php }else{?>
										<?php echo $TPL_V3["contents"]?>

<?php }?>
								</div>
							</dd>
						</dl>
<?php }}?>
					</div>
				</div>
<?php }}?>
			</section>
<?php }}?>
			<!-- 카테고리 결과 값 E -->
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->