<?php /* Template_ 2.2.8 2024/03/22 02:37:30 /data/barrel_data/_message/ms_email_order_cancel_new.htm 000025981 */ 
$TPL_orderDetail_1=empty($TPL_VAR["orderDetail"])||!is_array($TPL_VAR["orderDetail"])?0:count($TPL_VAR["orderDetail"]);
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<!-- 이메일 영역 S -->
<div style="max-width: 660px; margin: 0 auto; padding: 60px 40px">
<div style="padding: 0 0 40px"><a href="#;" style="border: none; background: transparent; font-size: 0"><img alt="BRRREL" src="https://www.getbarrel.com/assets/templet/enterprise/images/common/shop_logo2.png" style="width: 120px" /></a></div>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 40px; border-bottom: 1px solid #000">
<p style="margin: 0; padding: 0"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #000; font-family: sans-serif">주문취소가 정상적으로 처리되었습니다.</span></p>

<p style="margin: 0; padding: 16px 0 0 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["mallName"]?>을 이용해 주셔서 감사합니다.</span></p>

<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">주문 취소 정보는 마이페이지 &gt; 취소/반품 조회 메뉴에서 확인하실 수 있습니다. </span></p>
</div>

<div style="margin: 0; padding: 35px 0; border-bottom: 1px solid #ededed">
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
	<tbody>
		<tr>
			<td style="padding: 5px 0; text-align: left; width: 55%"><span style="line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">주문번호</span></td>
			<td style="padding: 5px 0; text-align: left; width: 45%"><span style="line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">주문일자</span></td>
		</tr>
		<tr>
			<td style="padding: 5px 0; text-align: left; width: 50%"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["oid"]?></span></td>
			<td style="padding: 5px 0; text-align: left; width: 50%"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["bdatetime"]?></span></td>
		</tr>
	</tbody>
</table>
</div>
</div>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 20px 0; border-bottom: 1px solid #000"><span style="line-height: 24px; font-size: 16px; font-weight: 600; color: #000; font-family: sans-serif">주문 상품</span></div>
<?php if($TPL_orderDetail_1){foreach($TPL_VAR["orderDetail"] as $TPL_V1){?><?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>

<div style="border-bottom: 1px solid #ededed; padding: 30px 0">
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
	<tbody>
		<tr>
			<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box"><img alt="" src="<?php echo $TPL_V2["pimg"]?>" style="width: 80px; display: block" /></td>
			<td style="padding: 0; vertical-align: top; position: relative">
			<p style="margin: 0; padding: 0 0 9px 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></span></p>

			<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php if($TPL_V2["add_info"]){?><?php echo $TPL_V2["add_info"]?> / <?php }?><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?> / <?php echo $TPL_V2["pcnt"]?>개</span></p>
			</td>
		</tr>
		<tr>
			<td style="padding: 0; vertical-align: bottom; text-align: right; clear: both">
			<p style="margin: 0; padding: 0; display: flex; justify-content: flex-end; align-items: center; float: right"><span style="padding-right: 5px; line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif"><?php echo g_price($TPL_V2["pt_dcprice"])?>원</span></p>
			</td>
		</tr>
<?php if($TPL_V2["product_gift"]){?>
		<tr>
			<td colspan="3" style="padding: 0; margin: 0">
			<p style="margin: 0; padding: 20px 0 10px"><span style="line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">구매 사은품</span></p>

			<div style="border: 1px solid #ededed; padding: 20px 22px">
			<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
				<tbody><?php if(is_array($TPL_R3=$TPL_V2["product_gift"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<tr>
						<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box"><img alt="<?php echo $TPL_V3["pname"]?>" src="<?php echo $TPL_V3["image_src"]?>" style="width: 80px; display: block" /></td>
						<td style="padding: 0; vertical-align: top; position: relative">
						<p style="margin: 0; padding: 0 0 9px 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_V3["pname"]?></span></p>

						<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_V3["pcnt"]?>개</span></p>
						</td>
					</tr>
<?php }}?>
					<tr>
						<td style="padding: 0; vertical-align: bottom; text-align: right">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			</div>
			</td>
		</tr>
<?php }?>
	</tbody>
</table>
</div>
<?php }}?><?php }}?><!--<div style="border-bottom: 1px solid #ededed; padding: 30px 0">
			<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
				<tr>
					<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box">
						<img src="https://mfhaoswulcnn3822236.cdn.ntruss.com/data/barrel_data/images/product/00/00/05/43/05/ms_0000054305.gif" alt="" style="width: 80px; display: block" />
					</td>
					<td style="padding: 0; vertical-align: top; position: relative">
						<p style="margin: 0; padding: 0 0 9px 0">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">우먼 피쉬백 스트랩 스윔 브라탑</span>
						</p>
						<p style="margin: 0; padding: 0 0 4px">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">유니섹스 트랙 셋업 자켓:블랙+M / 1개</span>
						</p>
						<p style="margin: 0; padding: 0 0 4px">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">유니섹스 트랙 셋업 자켓:블랙+M / 1개</span>
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 0; vertical-align: bottom; text-align: right; clear: both">
						<p style="margin: 0; padding: 0; display: flex; justify-content: flex-end; align-items: center; float: right">
							<span style="padding-right: 10px; line-height: 18px; font-size: 12px; font-weight: bold; color: #ff4e00; font-family: sans-serif">30%</span>
							<span style="padding-right: 5px; line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">1,265,550원</span>
							<del style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">1,405,550원</del>
						</p>
					</td>
				</tr>
			</table>
		</div>
		<div style="border-bottom: 1px solid #ededed; padding: 30px 0">
			<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
				<tr>
					<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box">
						<img src="https://mfhaoswulcnn3822236.cdn.ntruss.com/data/barrel_data/images/product/00/00/05/43/05/ms_0000054305.gif" alt="" style="width: 80px; display: block" />
					</td>
					<td style="padding: 0; vertical-align: top; position: relative">
						<p style="margin: 0; padding: 0 0 9px 0">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">우먼 피쉬백 스트랩 스윔 브라탑</span>
						</p>
						<p style="margin: 0; padding: 0 0 4px">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">미드나잇 / 95 / 1개</span>
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 0; vertical-align: bottom; text-align: right; clear: both">
						<p style="margin: 0; padding: 0; display: flex; justify-content: flex-end; align-items: center; float: right">
							<span style="padding-right: 5px; line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">1,265,550원</span>
						</p>
					</td>
				</tr>
			</table>
		</div>
		<div style="border-bottom: 1px solid #ededed; padding: 30px 0">
			<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
				<tr>
					<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box">
						<img src="https://mfhaoswulcnn3822236.cdn.ntruss.com/data/barrel_data/images/product/00/00/05/43/05/ms_0000054305.gif" alt="" style="width: 80px; display: block" />
					</td>
					<td style="padding: 0; vertical-align: top">
						<p style="margin: 0; padding: 0 0 9px 0">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">우먼 피쉬백 스트랩 스윔 브라탑</span>
						</p>
						<p style="margin: 0; padding: 0 0 4px">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">미드나잇 / 95 / 1개</span>
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 0; vertical-align: bottom; text-align: right; clear: both">
						<p style="margin: 0; padding: 0; display: flex; justify-content: flex-end; align-items: center; float: right">
							<span style="padding-right: 10px; line-height: 18px; font-size: 12px; font-weight: bold; color: #ff4e00; font-family: sans-serif">30%</span>
							<span style="padding-right: 5px; line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">1,265,550원</span>
							<del style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">1,405,550원</del>
						</p>
					</td>
				</tr>
			</table>
		</div>--></div>
<?php if($TPL_VAR["freeGift"]){?>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 20px 0; border-bottom: 1px solid #000"><span style="line-height: 24px; font-size: 16px; font-weight: 600; color: #000; font-family: sans-serif">구매금액별 사은품</span></div>

<div style="border-bottom: 1px solid #ededed; padding: 30px 0"><?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){
$TPL_gift_products_2=empty($TPL_V1["gift_products"])||!is_array($TPL_V1["gift_products"])?0:count($TPL_V1["gift_products"]);?><?php if($TPL_gift_products_2){foreach($TPL_V1["gift_products"] as $TPL_V2){?><?php if($TPL_V2["pname"]){?>
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0">
	<tbody>
		<tr>
			<td rowspan="2" style="padding: 0 20px 0 0; width: 100px; vertical-align: top; box-sizing: border-box"><img alt="<?php echo $TPL_V2["pname"]?>" src="<?php echo $TPL_V2["image_src"]?>" style="width: 80px; display: block" /></td>
			<td style="padding: 0; vertical-align: top; position: relative">
			<p style="margin: 0; padding: 0 0 9px 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_V2["pname"]?></span></p>

			<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_V2["pcnt"]?>개</span></p>
			</td>
		</tr>
		<tr>
			<td style="padding: 0; vertical-align: bottom; text-align: right">&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php }?><?php }}?><?php }}?></div>
</div>
<?php }?>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 20px 0; border-bottom: 1px solid #000"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #000; font-family: sans-serif">결제 정보</span></div>

<div style="padding: 30px 0 20px; border-bottom: 1px solid #ededed">
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0 0 0 0">
	<tbody>
		<tr>
			<td style="padding: 9px 0; text-align: left"><span style="line-height: 20px; font-size: 14px; font-weight: bold; color: #000; font-family: sans-serif">총 결제 예정 금액</span></td>
			<td style="padding: 9px 0; text-align: right"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #ff4e00; font-family: sans-serif"><?php echo g_price($TPL_VAR["payment_price"])?>원</span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">결제방법</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["memo"]?> <?php echo $TPL_VAR["method_text"]?></span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">총 상품금액</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?>원</span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">총 상품 할인</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">- <?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?>원</span></td>
		</tr>
		<!--<tr>
						<td style="padding: 4.5px 0; text-align: left">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">상품 할인</span>
						</td>
						<td style="padding: 4.5px 0; text-align: right">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">- 405,550원</span>
						</td>
					</tr>
					<tr>
						<td style="padding: 4.5px 0; text-align: left">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">등급 할인</span>
						</td>
						<td style="padding: 4.5px 0; text-align: right">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">- 405,550원</span>
						</td>
					</tr>
					<tr>
						<td style="padding: 4.5px 0; text-align: left">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">쿠폰 할인</span>
						</td>
						<td style="padding: 4.5px 0; text-align: right">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">- 405,550원</span>
						</td>
					</tr>-->
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">적립금 사용</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">- <?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?>원</span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">총 배송비</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo g_price($TPL_VAR["delivery_price"])?></span></td>
		</tr>
	</tbody>
	<!--<tfoot>
					<tr>
						<td style="padding: 25.5px 0 30px 0; text-align: left">
							<span style="line-height: 18px; font-size: 12px; font-weight: bold; color: #000; font-family: sans-serif">적립 혜택</span>
						</td>
						<td style="padding: 25.5px 0; text-align: right">
							<span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">123,000원 적립</span>
						</td>
					</tr>
				</tfoot>-->
</table>
</div>
</div>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 20px 0; border-bottom: 1px solid #000"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #000; font-family: sans-serif">주문 취소 정보</span></div>

<div style="padding: 30px 0 20px; border-bottom: 1px solid #ededed">
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0 0 0 0">
	<tbody>
		<tr>
			<td style="padding: 4.5px 0; width:35%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">주문취소일시</span></td>
			<td style="padding: 4.5px 0; width:65%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["cancel_date"]?></span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; width:35%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">환불완료일시</span></td>
			<td style="padding: 4.5px 0; width:65%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["refund_date"]?></span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; width:35%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif">취소사유</span></td>
			<td style="padding: 4.5px 0; width:65%; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #000; font-family: sans-serif"><?php echo $TPL_VAR["cancel_reason"]?></span></td>
		</tr>
	</tbody>
</table>
</div>
</div>

<div style="padding: 0 0 40px">
<div style="padding: 0 0 20px 0; border-bottom: 1px solid #000"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #000; font-family: sans-serif">결제 정보</span></div>

<div style="padding: 30px 0 20px; border-bottom: 1px solid #ededed">
<table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0; margin: 0 0 0 0">
	<tbody>
		<tr>
			<td style="padding: 9px 0; text-align: left"><span style="line-height: 20px; font-size: 14px; font-weight: bold; color: #000; font-family: sans-serif">환불 예정 금액</span></td>
			<td style="padding: 9px 0; text-align: right"><span style="line-height: 24px; font-size: 16px; font-weight: bold; color: #ff4e00; font-family: sans-serif"><?php echo number_format($TPL_VAR["total_refund_amount"])?>원</span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">취종 결제금액(배송비포함)</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo number_format($TPL_VAR["payment_price"])?></span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">취소 시 추가 배송비</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo number_format($TPL_VAR["refund_delivery_price"])?>원</span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">결제수단</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["payment_type"]?></span></td>
		</tr>
		<tr>
			<td style="padding: 4.5px 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">환불수단</span></td>
			<td style="padding: 4.5px 0; text-align: right"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["refund_type"]?></span></td>
		</tr>
	</tbody>
</table>
</div>

<div style="border-top: 1px solid #ededed; border-bottom: 1px solid #ededed; padding: 40px 0 40px; text-align: center">
<p style="margin: 0; padding: 0 0 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은</span></p>

<p style="margin: 0; padding: 0 0 18px; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">환불수단에 입력된 환불계좌로 송금 처리 됩니다.</span></p>

<p style="margin: 0; padding: 0 0 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">결제 시 사용한 쿠폰 및 적립금은 내부정책에 따라 취소신청 완료 후 환불됩니다.</span></p>
<button onclick="location.href='<?php echo $TPL_VAR["mallDomain"]?>/?utm_source=admin&amp;utm_medium=email_notify&amp;utm_campaign=main&amp;utm_content=link_email51'" style="display: block; width: 339px !important; min-width: auto; max-width: none; height: 40px; margin: 60px auto; background: #fff; border: 1px solid #000; box-sizing: border-box; line-height: 38px; font-size: 14px; font-weight: normal; color: #000000; font-family: sans-serif; text-decoration: none" type="button"><?php echo $TPL_VAR["mallName"]?> 바로가기</button>

<p style="margin: 0; padding: 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">본 메일은 발신 전용이므로 회신되지 않습니다.</span></p>

<p style="margin: 0; padding: 0; text-align: left"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">문의는 마이페이지 &gt; 1:1문의 또는 고객센터 1899-8751를 이용해 주세요</span></p>
</div>
</div>

<div style="padding: 20px 0">
<p style="margin: 0; padding: 0 0 18px"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">주식회사 <?php echo $TPL_VAR["comName"]?> | </span> <span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["comAddr1"]?> <?php echo $TPL_VAR["comAddr2"]?> | </span> <span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["comEmail"]?> </span></p>

<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">사업자등록번호 : </span> <span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["comNumber"]?></span></p>

<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">통신판매업신고번호 : </span> <span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["comOnlineBusinessNumber"]?></span></p>

<p style="margin: 0; padding: 0 0 18px"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">개인정보관리책임 : </span> <span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif"><?php echo $TPL_VAR["comOfficerName"]?></span></p>

<p style="margin: 0; padding: 0"><span style="line-height: 18px; font-size: 12px; font-weight: normal; color: #a5a5a5; font-family: sans-serif">COPYRIGHT(C) 2024 barrel. ALL RIGHTS RESERVED.</span></p>
</div>
</div>
<!-- 이메일 영역 E -->