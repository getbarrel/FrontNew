<?php /* Template_ 2.2.8 2024/01/03 16:38:03 /home/barrel-stage/application/www/assets/templet/enterprise/customer/index/customer_top.htm 000001192 */ ?>
<!-- 고객센터 상단 S -->
<div class="fb__customer__top fb__customer-faq__top">
	<div class="fb__customer__info">
		<div class="fb__customer__inner">
			<div class="fb__customer__info-number">
<?php if($TPL_VAR["langType"]=='english'){?>
				en_help@getbarrel.com
<?php }else{?>
				<?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>

<?php }?>				
			<!-- 1899 - 8751<span>(유료)</span> -->
			</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?>

<?php }?>
			<!-- <div class="fb__customer__info-sub txt-dark">운영시간 : 월 ~ 금 10:00 ~ 17:00</div>
			<p class="txt-gray">[점심시간 13:00 ~ 14:00]</p> -->
		</div>
	</div>
	<div class="fb__customer__info">
		<div class="fb__customer__inner">
			<div class="fb__customer__info-greeting">안녕하세요! <?php echo $TPL_VAR["mypage"]["userName"]?> 고객님!</div>
			<p class="txt-gray"> 빠르고 친정한 답변이 되도록 노력하겠습니다.</p>
		</div>
	</div>
</div>
<!-- 고객센터 상단 E -->