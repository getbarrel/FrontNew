<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/mypage_top/mypage_top.htm 000002097 */ ?>
<?php if(!$TPL_VAR["nonMemberOid"]){?><div class="fb__mypage-top">	<!--wrap-mypage-top-->
	<section class="fb__mypage-top__grade grade">
		<a href="/mypage/passReconfirm">
			<figure class="fb__mypage-top__pic">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
				<img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
			</figure>
		</a>
		<h2 class="fb__mypage-top__grade-text">
			Your membership level is <br>[<?php echo $TPL_VAR["mypage"]["gpName"]?>]
		</h2>
<?php if($TPL_VAR["currentGroup"]["gp_level"]> 3){?>
		<span class="fb__mypage-top__grade--color"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class=""fb__mypage-top__grade--font""><?php echo g_price($TPL_VAR["needPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?> left until the next level</span>
<?php }?>
		<!--<a href="#" class="fb__mypage-top__grade-benefit">회원등급혜택</a>-->
		<a href="/mypage/memberLevel" class="fb__mypage-top__btn"></a>
	</section>
	<section class="fb__mypage-top__section ">
		<h2 class="fb__mypage-top__title-mileage">Valid Reward</h2>
		<p class="fb__mypage-top__detail">
			<a href="/mypage/mileage">
				<span class="unit"><?php echo $TPL_VAR["fbUnit"]["f"]?></span>
				<span class="fb__mypage-top__num"><?php echo number_format($TPL_VAR["mypage"]["myMileAmount"])?></span>
				<span class="unit"><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
			</a>
		</p>
	</section>
	<section class="fb__mypage-top__section">
		<h2 class="fb__mypage-top__title-coupon">Coupons</h2>
		<p class="fb__mypage-top__detail">
			<a href="/mypage/coupon">
				<span class="fb__mypage-top__num"><?php echo number_format($TPL_VAR["mypage"]["couponCnt"])?></span>
				<span class="unit"> </span>
			</a>
		</p>
	</section>
</div>
<?php }?>