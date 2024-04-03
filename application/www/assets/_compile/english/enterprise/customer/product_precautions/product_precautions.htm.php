<?php /* Template_ 2.2.8 2021/10/05 15:16:26 /home/barrel-stage/application/www/assets/templet/enterprise/customer/product_precautions/product_precautions.htm 000004678 */ 
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);?>
<?php $this->print_("customerTop",$TPL_SCP,1);?>

<section class="fb__wash">
	<h2 class="fb__wash__title">Washing & Care</h2>
	<style>
		.wash_sub_txt {color:#666; font-size:14px; margin:14px 0;}
		.wash__category {padding-left:265px; position:relative;}
		.wash__category .wash_select {left:0; position:absolute; top:0;}
		.wash__category .wash_select select {width:223px; height:50px; border:#222 1px solid; color:#222; font-size:18px;}
		.wash__category ul {padding-top:1px;}
		.wash__category ul li {width:167px !important; height:50px; margin-top:-1px;}

		.fb__wash .wash__category-link {line-height:48px;}
		.fb__wash .wash__category-link--active:after {width:165px; height:48px; left:-1px; top:-1px; z-index:1;}
		.fb__wash .wash .contents__list {width:100%; display:table; padding:30px 0 30px 30px;}
		.fb__wash .wash .contents__subtitle {width:235px; display:table-cell; float:none; line-height:27px; vertical-align:middle;}
		.fb__wash .wash .contents__summary {width:650px; height:auto; display:table-cell; float:none;}
		.fb__wash .wash .contents__summary ul li {margin-bottom:0 !important;}
		.fb__wash .wash .contents__summary ul li:before {display:none;}
	</style>

	<div class="wash" id="laundryInfo">
		<div class="wash_sub_txt">카테고리를 선택해 주세요.</div>
		<nav class="wash__category">
			<span class="wash_select">
				<select name="laundryOneDepth" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
							<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
							<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
				</select>
			</span>
			<ul>
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
				<li>
					<a href="#" data-target="<?php echo $TPL_V1["cid"]?>" class="wash__category-link <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>wash__category-link--active<?php }?>">
<?php if($TPL_VAR["langType"]=='english'){?>
							<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
							<?php echo $TPL_V1["title"]?>

<?php }?>
					</a>
				</li>
<?php }}?>
			</ul>
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
				</div>
				<div class="contents__box">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V2["cid"]){?>
						<ul class="contents__box-wash contents__box-detail contents__box-detail--show">
<?php }else{?>
						<ul class="contents__box-precaution contents__box-detail">
<?php }?>
							<li>
								<h3 class="contents__box__subtitle">
<?php if($TPL_VAR["langType"]=='english'){?>
										<?php echo $TPL_V2["title_en"]?>

<?php }else{?>
										<?php echo $TPL_V2["title"]?>

<?php }?>
								</h3>
							</li>
						</ul>
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
<?php }}?>
				</div>
			</section>
<?php }}?>
		</div>
	</div>
</section>