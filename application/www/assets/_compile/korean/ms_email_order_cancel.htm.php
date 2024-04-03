<?php /* Template_ 2.2.8 2022/09/23 06:02:24 /data/barrel_data/_message/ms_email_order_cancel.htm 000010234 */ 
$TPL_orderDetail_1=empty($TPL_VAR["orderDetail"])||!is_array($TPL_VAR["orderDetail"])?0:count($TPL_VAR["orderDetail"]);?>
<meta charset="UTF-8">
<title></title>
<table align="center" cellpadding="0" cellspacing="0" style="border: 1px solid rgb(204, 204, 204); border-image: none; border-collapse: collapse;" width="720">
	<tbody>
		<tr>
			<td style="padding: 30px;">
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;" width="660">
				<thead>
					<tr>
						<td style="line-height: 0;padding-top: 8px;font-size: 0px;border-bottom-color: #000;border-bottom-width: 3px;border-bottom-style: solid;"><img alt="shop logo" src="/data/barrel_data/images/upfile//0001-0a29d0b5-6258ff77-5d50-42c3c0dd.png" style="margin-top: 8px; margin-bottom: 27px;" /></td>
					</tr>
				</thead>
				<tbody><!--contents-->
					<tr style="text-align: center;">
						<td style="color: #000;padding-top: 44px;font-size: 34px;">주문취소가 정상적으로 처리되었습니다.</td>
					</tr>
					<tr style="text-align: center;">
						<td style="line-height: 18px; padding-top: 20px; padding-bottom: 30px; font-size: 12px;"><?php echo $TPL_VAR["mallName"]?>을 이용해 주셔서 감사합니다.<br />
						주문 취소 정보는 마이페이지 &gt; 취소/교환/반품 조회 메뉴에서 확인하실 수 있습니다.</td>
					</tr>
					<tr>
						<td style="padding-top: 20px;">
						<p style="margin: 0px; padding: 0px 0px 16px; font-size: 16px; font-weight: bold;">주문취소 상품정보</p>
<?php if($TPL_VAR["orderDetail"]){?>

						<table cellpadding="0" cellspacing="0" style="text-align: center; padding-top: 30px; font-size: 12px; border-collapse: collapse;" width="100%">
							<thead>
								<tr style="background: rgb(238, 238, 238); height: 30px; border-right-color: rgb(238, 238, 238); border-left-color: rgb(238, 238, 238); border-right-width: 1px; border-left-width: 1px; border-right-style: solid; border-left-style: solid;">
									<td colspan="2" style="text-align: left; padding-left: 50px;" width="60%">상품명/옵션</td>
									<td style="text-align: center;" width="10%">주문수량</td>
									<td style="text-align: center;" width="10%">취소수량</td>
									<td style="text-align: center;" width="20%">결제금액</td>
								</tr>
							</thead>
							<tbody><?php if($TPL_orderDetail_1){foreach($TPL_VAR["orderDetail"] as $TPL_V1){?><?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<tr style="border: 1px solid rgb(204, 204, 204); border-image: none;">
									<td style="padding: 0px 15px; text-align: left;" width="10%"><img alt="<?php echo $TPL_V2["pname"]?>" border="0" height="66" src="<?php echo $TPL_V2["pimg"]?>" style="display: inline-block;" width="66" /></td>
									<td style="text-align: left;" width="40%"><span style="vertical-align: top;"><?php echo $TPL_V2["pname"]?><br />
									<?php echo $TPL_V2["option_text"]?> </span></td>
									<td width="10%"><?php echo $TPL_V2["pcnt"]?></td>
									<td width="10%"><?php echo $TPL_V2["pcnt"]?></td>
									<td width="20%"><?php echo g_price($TPL_V2["pt_dcprice"])?>원</td>
								</tr>
<?php }}?><?php }}?>
							</tbody>
						</table>
<?php }?></td>
					</tr>
					<tr style="background: rgb(221, 221, 221); border: 1px solid rgb(204, 204, 204); border-image: none; height: 30px; text-align: right; font-size: 12px;">
						<td colspan="6" style="padding-right: 15px;"><span>배송비</span> <?php echo g_price($TPL_VAR["delivery_price"])?>원</td>
					</tr>
					<!--order_cancel_info-->
					<tr>
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">주문 취소정보</p>

						<table cellpadding="0" cellspacing="0" style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">주문취소 일시</td>
									<td width="80%"><?php echo $TPL_VAR["cancel_date"]?></td>
								</tr>
<?php if($TPL_VAR["refund_date"]!=''){?>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">환불 완료일시</td>
									<td width="80%"><?php echo $TPL_VAR["refund_date"]?></td>
								</tr>
<?php }?>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">취소사유</td>
									<td width="80%"><?php echo $TPL_VAR["cancel_reason"]?></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<!--// order_cancel_info-->
					<tr><!--payback_info-->
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">환불정보</p>

						<table cellpadding="0" cellspacing="0" style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">최종 결제금액 (배송비 포함)</td>
									<td width="80%"><?php echo number_format($TPL_VAR["payment_price"])?>원</td>
								</tr>
								<tr style="height: 100px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">취소 시<br />
									추가 배송비</td>
									<td width="80%"><?php echo number_format($TPL_VAR["refund_delivery_price"])?>원</td>
								</tr>
								<tr style="background: rgb(238, 238, 238); height: 40px; font-weight: bold; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">환불 예정 금액</td>
									<td width="80%"><?php echo number_format($TPL_VAR["total_refund_amount"])?>원</td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">결제수단</td>
									<td width="80%"><?php echo $TPL_VAR["payment_type"]?></td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">환불수단</td>
									<td width="80%"><?php echo $TPL_VAR["refund_type"]?></td>
								</tr>
							</tbody>
						</table>
						</td>
						<!--// payback_info-->
					</tr>
					<tr>
						<td style="padding: 10px 0px 0px; font-size: 11px;"><!--회원일 경우-->결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리됩니다.<br />
						결제 시 사용한 쿠폰 및 적립금은 내부정책에 따라 취소신청 완료 후 환불됩니다. <!-- 비회원일 경우--> 결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리됩니다.</td>
					</tr>
					<tr>
						<td style="margin: 0px auto; height: 50px; text-align: center; line-height: 50px; padding-top: 60px;"><a href="<?php echo $TPL_VAR["mallDomain"]?>/?utm_source=admin&amp;utm_medium=email_notify&amp;utm_campaign=main&amp;utm_content=link_email10" style="background: #00bce7;width: 240px;color: rgb(255, 255, 255);font-size: 14px;font-weight: bold;text-decoration: none;display: inline-block;"><?php echo $TPL_VAR["mallName"]?> 바로가기 <i style="font-style: normal; font-weight: normal;">&gt;</i></a></td>
					</tr>
					<!--// contents--><!--footer-->
					<tr>
						<td style="text-align: center; padding-top: 60px;">
						<p style="margin: 0px; padding: 12px 0px; color: rgb(153, 153, 153); font-size: 12px;">본 메일은 발신전용이므로 회신 처리되지 않습니다.<br />
						문의사항은 <?php echo $TPL_VAR["mallName"]?> <span style="color: rgb(0, 0, 0);">1:1 문의</span> 또는 <span style="color: rgb(0, 0, 0);">고객센터(<?php echo $TPL_VAR["comCsPhone"]?>)</span>를 이용해 주세요.</p>
						</td>
					</tr>
					<tr>
						<td style="background: rgb(247, 247, 247); padding: 20px 30px; text-align: center;">
						<p style="margin: 0px; color: rgb(102, 102, 102); line-height: 20px; font-size: 12px;">주식회사 <?php echo $TPL_VAR["comName"]?> <span style="color: rgb(153, 153, 153);">|</span> <?php echo $TPL_VAR["comAddr1"]?> <?php echo $TPL_VAR["comAddr2"]?> <span style="color: rgb(153, 153, 153);">|</span> <?php echo $TPL_VAR["comEmail"]?></p>

						<p style="margin: 0px; color: rgb(102, 102, 102); line-height: 20px; font-size: 12px;">사업자등록번호 : <?php echo $TPL_VAR["comNumber"]?> <span style="color: rgb(153, 153, 153);">|</span> 통신판매업신고번호 :<?php echo $TPL_VAR["comOnlineBusinessNumber"]?> <span style="color: rgb(153, 153, 153);">|</span> 개인정보관리책임 : <?php echo $TPL_VAR["comOfficerName"]?></p>

						<p style="margin: 0px; color: rgb(102, 102, 102); line-height: 20px; padding-top: 20px; font-size: 12px;"><span style="color: rgb(102, 102, 102); font-size: 12px; text-align: center; background-color: rgb(247, 247, 247);">COPYRIGHT(C) 2019 barrel. ALL RIGHTS RESERVED.</span></p>
						</td>
					</tr>
					<!--// footer-->
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>