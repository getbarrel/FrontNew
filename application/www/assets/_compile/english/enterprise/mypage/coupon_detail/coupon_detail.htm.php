<?php /* Template_ 2.2.8 2020/10/20 15:33:36 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/coupon_detail/coupon_detail.htm 000004108 */ 
$TPL_plist_1=empty($TPL_VAR["plist"])||!is_array($TPL_VAR["plist"])?0:count($TPL_VAR["plist"]);
$TPL_clist_1=empty($TPL_VAR["clist"])||!is_array($TPL_VAR["clist"])?0:count($TPL_VAR["clist"]);?>
<div class="wrap-coupon-apply mypage-coupon__detail">
	<h2 class="mypage-coupon__detail__title">Coupon Information</h2>
	<dl class="coupon-info">
		<dt class="<?php if($TPL_VAR["cupon_sale_type"]=='2'){?>won<?php }?>">
<?php if($TPL_VAR["cupon_sale_type"]=='1'){?>

<?php }elseif($TPL_VAR["cupon_sale_type"]=='2'){?>
				<?php echo $TPL_VAR["fbUnit"]["f"]?>

<?php }?>

<?php if($TPL_VAR["cupon_sale_type"]=='3'){?>
                전액
<?php }else{?>
    			<em><?php echo g_price($TPL_VAR["cupon_sale_value"])?></em>
<?php }?>

<?php if($TPL_VAR["cupon_sale_type"]=='1'){?>
				%
<?php }elseif($TPL_VAR["cupon_sale_type"]=='2'){?>
				<?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php }?>
		</dt>
		<dd>
			<p class="tit">
<?php if($TPL_VAR["cupon_use_div"]=='G'){?>
					web only
<?php }elseif($TPL_VAR["cupon_use_div"]=='M'){?>
					Mobile only
<?php }else{?>

<?php }?>
				<?php echo $TPL_VAR["publish_name"]?>

			</p>
			<p class="sub">
				<span>Coupon benefit</span>
<?php if($TPL_VAR["cupon_sale_type"]=='1'){?>

<?php }elseif($TPL_VAR["cupon_sale_type"]=='2'){?>
					<?php echo $TPL_VAR["fbUnit"]["f"]?>

<?php }?>


<?php if($TPL_VAR["cupon_sale_type"]=='3'){?>
                    전액
<?php }else{?>
                    <?php echo g_price($TPL_VAR["cupon_sale_value"])?>

<?php }?>


<?php if($TPL_VAR["cupon_sale_type"]=='1'){?>
					%
<?php }elseif($TPL_VAR["cupon_sale_type"]=='2'){?>
					<?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php }?>
				Sale

				(<?php echo $TPL_VAR["publish_condition_price_text"]?>)

			</p>
			<p class="sub">
				<span>Period of use:</span>
<?php if($TPL_VAR["use_date_limit"]>'3000-12-31 00:00:00'||$TPL_VAR["use_date_type"]=='9'){?>
					an indefinite period
<?php }elseif($TPL_VAR["use_date_type"]=='2'){?>
					<?php echo substr($TPL_VAR["regist_start"], 0, 10)?> ~ <?php echo substr($TPL_VAR["regist_end"], 0, 10)?>

<?php }elseif($TPL_VAR["use_date_type"]=='1'){?>
					<?php echo substr($TPL_VAR["regdate"], 0, 10)?> ~ <?php echo substr($TPL_VAR["publish_limit_date"], 0, 10)?>

<?php }else{?>
					<?php echo substr($TPL_VAR["use_sdate"], 0, 10)?> ~ <?php echo substr($TPL_VAR["use_edate"], 0, 10)?>

<?php }?>
			</p>
		</dd>
	</dl>
<?php if($TPL_VAR["use_product_type"]=='6'){?>
	<h2 class="mypage-coupon__detail__title">Exclusion target</h2>
<?php }elseif($TPL_VAR["use_product_type"]=='1'&&$TPL_VAR["is_except"]=='1'){?>
	<h2 class="mypage-coupon__detail__title">Exclusion target</h2>
<?php }else{?>
	<h2 class="mypage-coupon__detail__title">Apply to</h2>
<?php }?>
	<ul>
<?php if(($TPL_VAR["use_product_type"]=='3'||$TPL_VAR["use_product_type"]=='6')){?>
<?php if($TPL_plist_1){foreach($TPL_VAR["plist"] as $TPL_V1){?>
                <li><a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" target="_blank"><?php echo $TPL_V1["pname"]?></a></li>
<?php }}?>
<?php }elseif($TPL_VAR["use_product_type"]=='2'){?>
<?php if($TPL_clist_1){foreach($TPL_VAR["clist"] as $TPL_V1){?>
                <li><a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" target="_blank"><?php echo $TPL_V1["cPathName"]?></a></li>
<?php }}?>
<?php }elseif($TPL_VAR["use_product_type"]=='1'){?>
<?php if($TPL_VAR["is_except"]=='1'){?>
<?php if($TPL_plist_1){foreach($TPL_VAR["plist"] as $TPL_V1){?>
			<li><a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" target="_blank"><?php echo $TPL_V1["pname"]?></a></li>
<?php }}?>
<?php }else{?>
		    <li>It is available for the entire product</li>
<?php }?>
<?php }else{?>
		    <li>No Product information</li>
<?php }?>
	</ul>
	<div class="desc coupon-info__desc">Some products may be excluded from the coupon discount.</div>
	<div class="popup-btn-area coupon-info__btn">
		<button class="btn-default btn-dark-line" id="devCouponDetailColseBtn">Cancel</button>
	</div>
</div>