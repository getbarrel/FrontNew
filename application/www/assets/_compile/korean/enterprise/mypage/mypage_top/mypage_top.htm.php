<?php /* Template_ 2.2.8 2023/12/21 09:12:20 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/mypage_top/mypage_top.htm 000002987 */ ?>
<?php if(!$TPL_VAR["nonMemberOid"]){?><div class="fb__mypage-top">
	<section class="fb__mypage-top__grade">
		<div class="fb__mypage-top__group">
			<div class="fb__mypage-top__item">
				<div class="fb__mypage-top__pic">
					<a href="/mypage/passReconfirm">
						<figure class="fb__mypage-top__pic">
<?php if($_SERVER['DOCUMENT_ROOT'].'/data/barrel_data/images/member_group/'.$TPL_VAR["currentGroup"]["organization_img"]){?>
							<img src="<?php echo IMAGE_SERVER_DOMAIN?>/data/barrel_data/images/member_group/<?php echo $TPL_VAR["currentGroup"]["organization_img"]?>" alt="<?php echo $TPL_VAR["currentGroup"]["gp_name"]?>">
<?php }?>
						</figure>
					</a>
				</div>
				<div class="fb__mypage-top__grade-text">
					<div class="title-md">안녕하세요! <strong><?php echo $TPL_VAR["mypage"]["userName"]?></strong>님</div>
					<div class="join-date">
						<span>가입일</span>
						<span class="day"><?php echo date("Y.m.d",strtotime($TPL_VAR["mypage"]["regDate"]))?></span>
					</div>
				</div>
			</div>
			<div class="fb__mypage-top__item col">
				<span>회원등급</span>
				<div class="title-md level-name"><?php echo $TPL_VAR["mypage"]["gpName"]?></div>
				<p class="level-text"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="fb__mypage-top__grade--font"><?php echo g_price($TPL_VAR["needPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>을 추가 결제하시면 <span><?php echo $TPL_VAR["nextGroup"]["gp_name"]?></span> 혜택을 받을 수 있어요!</p>
			</div>
		</div>
		<div class="fb__mypage-top__btn">
			<a href="/mypage/memberLevel" class="btn-link">등급별 혜택 보기</a>
		</div>
	</section>
	<section class="fb__mypage-top__section">
		<ul class="fb__mypage-top__list">
			<li class="fb__mypage-top__detail">
				<a href="/mypage/mileage">
					<dl class="fb__mypage-top__detail-item">
						<dt>적립금</dt>
						<dd>
							<span class="unit"><?php echo $TPL_VAR["fbUnit"]["f"]?></span>
							<span class="fb__mypage-top__num"><?php echo number_format($TPL_VAR["mypage"]["myMileAmount"])?></span>
							<span class="unit"><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
						</dd>
					</dl>
				</a>
			</li>
			<li class="fb__mypage-top__detail">
				<a href="/mypage/coupon">
					<dl class="fb__mypage-top__detail-item">
						<dt>쿠폰</dt>
						<dd>
							<span class="fb__mypage-top__num"><?php echo number_format($TPL_VAR["mypage"]["couponCnt"])?></span>
							<span class="unit">장</span>
						</dd>
					</dl>
				</a>
			</li>
			<li class="fb__mypage-top__detail">
				<a href="#;">
					<dl class="fb__mypage-top__detail-item">
						<dt>작성 가능한 리뷰</dt>
						<dd>
							<span class="fb__mypage-top__num">0</span>
							<span class="unit">건</span>
						</dd>
					</dl>
				</a>
			</li>
		</ul>
	</section>
</div>
<?php }?>