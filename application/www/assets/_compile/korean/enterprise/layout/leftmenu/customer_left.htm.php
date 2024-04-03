<?php /* Template_ 2.2.8 2024/02/29 16:13:16 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/customer_left.htm 000002985 */ ?>
<section class="fb__left-basicList">
	<div class="basicNav">
		<div class="basicNav__header">
			<h2 class="basicNav__title">고객센터</h2>
		</div>
		<div class="basicNav__wrap">
			<div class="basicNav__item noline">
				<ul class="basicNav__list">
					<li class="basicNav__list-item"><a href="/customer/faq" title="자주 묻는 질문" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/faq')> 0){?>on<?php }?>">자주 묻는 질문</a></li>
					<li class="basicNav__list-item"><a href="/customer/notice" title="공지사항" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">공지사항</a></li>
					<li class="basicNav__list-item"><a href="/customer/memberBenefit" title="회원혜택" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/memberBenefit')> 0){?>on<?php }?>">회원혜택</a></li>
					<li class="basicNav__list-item"><a href="/customer/storeInformation" title=" 매장안내"  class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/storeInformation')> 0){?>on<?php }?>">매장안내</a></li>
<?php if($TPL_VAR["langType"]=='korean'){?>
					<li class="basicNav__list-item"><a href="/customer/bestReview" title="제품 후기"  class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/bestReview')> 0){?>on<?php }?>">제품 후기</a></li>
<?php }else{?>
<?php }?>
					<li class="basicNav__list-item"><a href="/customer/benefitsGuide" title="적립금 / 쿠폰 안내" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/benefitsGuide')> 0){?>on<?php }?>">적립금 / 쿠폰 안내</a></li>
					<li class="basicNav__list-item"><a href="/customer/shippingGuide" title="배송 및 취소 안내" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/shippingGuide')> 0){?>on<?php }?>">배송 안내</a></li>
					<li class="basicNav__list-item"><a href="/customer/cliamGuide" title="반품 / 환불 안내" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/cliamGuide')> 0){?>on<?php }?>">반품 / 환불 안내</a></li>
					<li class="basicNav__list-item"><a href="/customer/productPrecautions" title="제품 주의사항" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/productPrecautions')> 0){?>on<?php }?>">제품 주의사항</a></li>
					<li class="basicNav__list-item"><a href="/customer/cosmeticsCaution " title="코스메틱스 주의사항" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/cosmeticsCaution')> 0){?>on<?php }?>">코스메틱스 주의사항</a></li>
<?php if($TPL_VAR["langType"]=='korean'){?>
					<li class="basicNav__list-item"><a href="/customer/contactUs" title="제휴문의" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/contactUs')> 0){?>on<?php }?>">제휴문의</a></li>
<?php }?>
				</ul>
			</div>
		</div>
	</div>
</section>