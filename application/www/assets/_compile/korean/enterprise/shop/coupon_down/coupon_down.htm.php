<?php /* Template_ 2.2.8 2020/11/23 11:20:26 /home/barrel-stage/application/www/assets/templet/enterprise/shop/coupon_down/coupon_down.htm 000002920 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="popup-coupon-down">
	<p class="tit">해당 상품에서 사용 가능한 쿠폰 리스트입니다.</p>

	<table class="table-default devCouponContents">
		<colgroup>
			<col width="228px">
			<col width="160px">
			<col width="110px">
			<col width="150px">
			<col width="*">
		</colgroup>
		<thead>
			<tr>
				<th>쿠폰명</th>
				<th>할인액/할인율</th>
				<th>사용기간</th>
				<th>사용조건</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php if($TPL_V1["cupon_use_div"]=='G'){?>[웹전용]<?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>[모바일전용]<?php }?> <?php echo $TPL_V1["publish_name"]?></td>
				<td class="coupon__box"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?> <?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }else{?>원<?php }?></span></td>
				<td><?php if($TPL_V1["use_date_type"]=='9'){?>무기한
<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
                                        <?php echo $TPL_V1["regdate"]?><br/>~<?php echo $TPL_V1["publish_limit_date"]?>

<?php }elseif($TPL_V1["use_date_type"]=='2'){?>발급 후 <?php echo $TPL_V1["regist_date_differ"]?>

<?php if($TPL_V1["regist_date_type"]=='3'){?>
                                        일
<?php }elseif($TPL_V1["regist_date_type"]=='2'){?>
                                        개월
<?php }elseif($TPL_V1["regist_date_type"]=='1'){?>
                                        년
<?php }?> 이내 사용 가능
<?php }elseif($TPL_V1["use_date_type"]=='3'){?><?php echo $TPL_V1["use_sdate"]?><br/>~<?php echo $TPL_V1["use_edate"]?>

<?php }?></td>
				<td>
<?php if($TPL_V1["publish_min"]=='N'){?>
                                    제한조건없음
<?php }else{?>
                                    <?php echo number_format($TPL_V1["publish_condition_price"])?> 원 이상 구매시
<?php }?>
                                </td>
<?php if($TPL_V1["isPublished"]){?>
				<td><button class="btn-xs btn-dark" disabled>다운로드 완료</button></td>
<?php }else{?>
				<td><button class="btn-xs btn-dark" devPublishIx="<?php echo $TPL_V1["publish_ix"]?>">쿠폰 다운로드</button></td>                                
<?php }?>
                        </tr>
<?php }}?>
		</tbody>
	</table>

	<div class="desc">다운로드 된 쿠폰은 <a href="/mypage/coupon" style="color:#00bce7;">마이페이지 > 나의 쿠폰</a> 및 주문/결제 시 쿠폰 적용 단계에서 확인하실 수 있습니다.</div>

	<div class="popup-btn-area">
		<button class="btn-default btn-dark-line" onclick="layerClose();">닫기</button>
	</div>

</div>