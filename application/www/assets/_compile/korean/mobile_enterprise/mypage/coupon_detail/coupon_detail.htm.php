<?php /* Template_ 2.2.8 2020/10/20 15:34:36 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/coupon_detail/coupon_detail.htm 000003307 */ 
$TPL_plist_1=empty($TPL_VAR["plist"])||!is_array($TPL_VAR["plist"])?0:count($TPL_VAR["plist"]);
$TPL_clist_1=empty($TPL_VAR["clist"])||!is_array($TPL_VAR["clist"])?0:count($TPL_VAR["clist"]);?>
<div class="wrap-pop-coupon">
	<h1>쿠폰정보</h1>
	<div class="coupon-info">
		<p class="tit">
<?php if($TPL_VAR["cupon_use_div"]=='G'){?>
				[웹전용]
<?php }elseif($TPL_VAR["cupon_use_div"]=='M'){?>
				[모바일전용]
<?php }else{?>

<?php }?>
			<?php echo $TPL_VAR["publish_name"]?>

		</p>
		<p class="sub">
			<span class="sub-title">쿠폰혜택</span>
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
			할인
			(<?php echo $TPL_VAR["publish_condition_price_text"]?>)
		</p>
		<p class="sub">
			<span class="sub-title">사용기간</span>
<?php if($TPL_VAR["use_date_limit"]>'3000-12-31 00:00:00'||$TPL_VAR["use_date_type"]=='9'){?>
			무기한
<?php }elseif($TPL_VAR["use_date_type"]=='2'){?>
			<span class="font-mb"><?php echo substr($TPL_VAR["regist_start"], 0, 10)?> ~ <?php echo substr($TPL_VAR["regist_end"], 0, 10)?></span>
<?php }elseif($TPL_VAR["use_date_type"]=='1'){?>
			<span class="font-mb"><?php echo substr($TPL_VAR["regdate"], 0, 10)?> ~ <?php echo substr($TPL_VAR["publish_limit_date"], 0, 10)?></span>
<?php }else{?>
			<span class="font-mb"><?php echo substr($TPL_VAR["use_sdate"], 0, 10)?> ~ <?php echo substr($TPL_VAR["use_edate"], 0, 10)?></span>
<?php }?>
			</p>
	</div>
<?php if($TPL_VAR["use_product_type"]=='6'){?>
	<h1>제외대상</h1>
<?php }elseif($TPL_VAR["use_product_type"]=='1'&&$TPL_VAR["is_except"]=='1'){?>
	<h1>제외대상</h1>
<?php }else{?>
	<h1>적용대상</h1>
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
			<li>전체 상품에 사용 가능합니다.</li>
<?php }?>
<?php }else{?>
		<li>상품 정보가 없습니다.</li>
<?php }?>


	</ul>
	<div class="desc">·&nbsp;일부 상품의 경우 쿠폰 할인 적용대상에서 제외될 수 있습니다.</div>
</div>