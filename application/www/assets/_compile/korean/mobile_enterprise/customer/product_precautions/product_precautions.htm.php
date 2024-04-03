<?php /* Template_ 2.2.8 2024/03/21 15:55:32 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/product_precautions/product_precautions.htm 000005965 */ 
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);?>
<!-- 컨텐츠 S -->
<section class="br__wash">
	<section class="cs__menu">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide ">
					<a href="/customer">고객센터 홈</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/faq">자주 묻는 질문</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/notice">공지사항</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/memberBenefit">회원혜택</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/storeInformation">매장안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/bestReview">제품후기</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/benefitsGuide/">적립금 / 쿠폰 안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/cliamGuide">반품 / 환불 안내</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/shippingGuide">배송 안내</a>
				</li>
				<li class="swiper-slide active">
					<a href="/customer/productPrecautions">제품 주의사항</a>
				</li>
				<li class="swiper-slide">
					<a href="/customer/contactUs">제휴 문의</a>
				</li>
			</ul>
		</div>
	</section>
	<script>
		function checkTab(val){
			if (val == 0){
				$("#tab2").removeClass("active");
				$("#tab1").addClass("active");
				$("#content2").removeClass("active");
				$("#content1").addClass("active");
			}else{
				$("#tab1").removeClass("active");
				$("#tab2").addClass("active");
				$("#content1").removeClass("active");
				$("#content2").addClass("active");
			}
		}
	</script>
	<div class="br__wash-wrap">
		<div class="page-title">
			<div class="title-md">제품 주의사항</div>
		</div>
		<div class="wash" id="laundryInfo">
			<div class="wash__select">
				<div class="wash__select-item">
					<div class="br__form-item">
						<label for="" class="hidden">카테고리 선택</label>
						<select class="br__form-select" name="laundryOneDepth" id="laundryOneDepth" onchange="laundryChange(this.value)">
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
				<div class="wash__select-item">
					<div class="br__form-item">
						<label for="" class="hidden">상세 아이템 선택</label>
						<select name="laundryTwoDepth" id="laundryTwoDepth" id="laundryTwoDepth" onchange="laundryChange2(this.value)">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
									<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
									<option value="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
						</select>
						<!-- <select class="br__form-select wash__category">
							<option>래쉬가드</option>
						</select> -->
					</div>
				</div>
			</div>
			<div class="wash__contents">
				<!-- 카테고리 결과 값 S -->
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
				<section class="wash__contents__category wash__contents<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>__category--show wash__contents<?php }?>-<?php echo $TPL_V1["cid"]?>">
					<div class="br-tab__wrap">
						<div class="br-tab__nav">
							<ul>
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
										<li id="tab1" class="active"><a href="javascript:void(0);">
<?php }else{?>
										<li ><a href="javascript:void(0);">
<?php }?>
<?php if($TPL_VAR["langType"]=='english'){?>
										<?php echo $TPL_V2["title_en"]?></a></li>
<?php }else{?>
										<?php echo $TPL_V2["title"]?></a></li>
<?php }?>
<?php }}?>
							</ul>
						</div>
						<div class="br-tab__contents-wrap">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
								<div class="br-tab__contents active">
<?php }else{?>
								<div class="br-tab__contents">
<?php }?>
								<div class="contents__list">
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
									<dl class="contents__item">
										<dt class="contents__item-img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/img_product_precautions<?php echo $TPL_V3["cnt"]?>.png" alt="<?php echo $TPL_V3["title"]?>" />
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
						</div>
					</div>
				</section>
<?php }}?>
				<!-- 카테고리 결과 값 E -->
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->