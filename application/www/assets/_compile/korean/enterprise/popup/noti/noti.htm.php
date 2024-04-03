<?php /* Template_ 2.2.8 2024/03/05 17:12:09 /home/barrel-stage/application/www/assets/templet/enterprise/popup/noti/noti.htm 000001846 */ 
$TPL_slideBannerPopUp_1=empty($TPL_VAR["slideBannerPopUp"])||!is_array($TPL_VAR["slideBannerPopUp"])?0:count($TPL_VAR["slideBannerPopUp"]);?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="/assets/templet/enterprise/assets/js/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="/assets/templet/enterprise/assets/js/common.js"></script>
<!--팝업일때는 스크립트로 높이, 위드값 정해짐-->
<div class="main_popupL-inner">
	<div class="main_popupL-slide swiper-container popup-slide2">
		<div class="swiper-wrapper">
<?php if($TPL_slideBannerPopUp_1){foreach($TPL_VAR["slideBannerPopUp"] as $TPL_V1){?>
			<div class="swiper-slide">
				<a href="<?php echo $TPL_V1["bannerLink"]?>"><img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" /></a>
			</div>
<?php }}?>
		</div>
	</div>
	<div class="main_popupL-slide--control">
		<div class="swiper-control-group">
			<div class="swiper-scrollbar"></div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<div class="noti__popup">
            <!--오늘 하루보기 사용 체크박스 -->
	<input type='checkbox' id="closeToday" class='devPopupToday' devPopupIx='<?php echo $TPL_VAR["popupIx"]?>' onClick="$(this).prop('checked', true);common.noti.popup.close('<?php echo $TPL_VAR["popupType"]?>', '<?php echo $TPL_VAR["popupIx"]?>');" />
	<span for="closeToday">오늘 하루 열지않기</span>

    <span class="noti__popup__closebtn" onClick="$(this).prop('checked', true);common.noti.popup.close('<?php echo $TPL_VAR["popupType"]?>', '<?php echo $TPL_VAR["popupIx"]?>');">[닫기]</span>
</div>