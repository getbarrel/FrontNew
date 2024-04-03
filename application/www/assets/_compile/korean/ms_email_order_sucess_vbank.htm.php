<?php /* Template_ 2.2.8 2023/11/21 13:24:19 /data/barrel_data/_message/ms_email_order_sucess_vbank.htm 000013409 */ 
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
						<td style="line-height: 0; padding-top: 8px; font-size: 0px; border-bottom-color: rgb(0, 0, 0); border-bottom-width: 3px; border-bottom-style: solid;"><img alt="shop logo" src="https://www.getbarrel.com/data/barrel_data/images/upfile//0001-0a29d0b5-6258ffef-1018-19f47db5.png" style="margin-top: 8px; margin-bottom: 27px; width: 81px; height: 18px;" /></td>
					</tr>
				</thead>
				<tbody><!--contents-->
					<tr style="text-align: center;">
						<td style="color: rgb(0, 0, 0); font-size: 34px;">&nbsp;</td>
					</tr>
					<tr style="text-align: center;">
						<td style="line-height: 18px; padding-top: 20px; padding-bottom: 30px; font-size: 12px;">
						<p><span style="text-align: center; color: rgb(0, 0, 0); font-size: 34px;">주문이&nbsp;정상적으로 접수되었습니다.</span></p>

						<p><?php echo $TPL_VAR["mallName"]?>을 이용해 주셔서 감사합니다.<br />
						만족할 수 있는 쇼핑이 되도록 최선을 다하겠습니다.</p>
						</td>
					</tr>
					<tr>
						<td style="height: 30px; text-align: center; font-size: 13px;"><span style="font-weight: bold;"><?php echo $TPL_VAR["bank_input_date"]?>까지 결제 예정금액 <?php echo g_price($TPL_VAR["payment_price"])?>원</span>을 입금해 주시기 바랍니다.<br />
						<span style="font-weight: bold;">가상 계좌[에스크로] 주문 시 부분 취소가 불가하여 전체 취소만 가능합니다. 입금 전 구매하실 제품을 다시 한번 확인해 주시기 바랍니다. </span></td>
					</tr>
					<tr>
						<td style="padding-top: 20px;"><?php if($TPL_orderDetail_1){foreach($TPL_VAR["orderDetail"] as $TPL_V1){?>
						<table cellpadding="0" cellspacing="0" style="text-align: center; padding-top: 30px; font-size: 12px; border-collapse: collapse;" width="100%">
							<thead>
								<tr style="background: rgb(238, 238, 238); height: 30px; border-right-color: rgb(238, 238, 238); border-left-color: rgb(238, 238, 238); border-right-width: 1px; border-left-width: 1px; border-right-style: solid; border-left-style: solid;">
									<td colspan="2" style="text-align: left; padding-left: 50px;" width="40%">상품명/옵션</td>
									<td style="text-align: center;" width="10%">주문수량</td>
									<td style="text-align: center;" width="10%">상품금액</td>
									<td style="text-align: center;" width="10%">할인금액</td>
									<td style="text-align: center;" width="20%">결제 예정금액</td>
								</tr>
							</thead>
							<tbody><?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<tr style="border: 1px solid rgb(204, 204, 204); border-image: none;">
									<td style="padding: 0px 15px; text-align: left;" width="10%"><img alt="<?php echo $TPL_V2["pname"]?>" border="0" height="66" src="<?php echo $TPL_V2["pimg"]?>" style="display: inline-block;" width="66" /></td>
									<td style="text-align: left;" width="30%"><span style="vertical-align: top;"><?php echo $TPL_V2["pname"]?><br />
									<?php echo $TPL_V2["option_text"]?></span></td>
									<td width="10%"><?php echo $TPL_V2["pcnt"]?></td>
									<td style="-ms-word-break: break-all;" width="10%"><?php echo g_price($TPL_V2["pt_listprice"])?>원</td>
									<td width="10%"><?php echo g_price($TPL_V2["pt_calc_dcprice"]* - 1)?>원</td>
									<td width="20%"><?php echo g_price($TPL_V2["pt_dcprice"])?>원</td>
								</tr>
<?php }}?>
								<tr style="background: rgb(221, 221, 221); border: 1px solid rgb(204, 204, 204); border-image: none; height: 30px; text-align: right; font-size: 12px;">
									<td colspan="6" style="padding-right: 15px;"><span>배송비 <em><?php echo g_price($TPL_VAR["delivery_price"])?>원</em></span></td>
								</tr>
							</tbody>
						</table>
<?php }}?></td>
					</tr>
					<tr>
						<td style="padding-top: 20px;"><!--total payment-->
						<table cellpadding="0" cellspacing="0" style="border-collapse: collapse;" width="100%">
							<thead>
								<tr style="background: rgb(238, 238, 238); border: 1px solid rgb(204, 204, 204); border-image: none; height: 30px; text-align: center; font-size: 12px;">
									<td width="16%">총 상품 금액</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">&nbsp;</td>
									<td width="16%">총 할인 금액</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">&nbsp;</td>
									<td width="16%">적립금 사용</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">&nbsp;</td>
									<td width="16%">총 배송비</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">&nbsp;</td>
									<td style="font-size: 16px; font-weight: bold;" width="24%">총 결제 예정 금액</td>
								</tr>
							</thead>
							<tbody>
								<tr style="border: 1px solid rgb(204, 204, 204); border-image: none; height: 55px; text-align: center; font-size: 12px;">
									<td width="16%"><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?> 원</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">-</td>
									<td width="16%"><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?> 원</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">-</td>
									<td width="16%"><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?> 원</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">+</td>
									<td style="-ms-word-break: break-all;" width="16%"><?php echo g_price($TPL_VAR["delivery_price"])?> 원</td>
									<td style="width: 3%; line-height: 0; font-size: 0px;">=</td>
									<td style="font-size: 16px; font-weight: bold;"><?php echo g_price($TPL_VAR["payment_price"])?> 원</td>
								</tr>
							</tbody>
						</table>
						<!--// total payment--></td>
					</tr>
					<tr><!--payment_info-->
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">결제 정보</p>

						<table cellpadding="0" cellspacing="0" style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">주문번호</td>
									<td width="80%"><?php echo $TPL_VAR["oid"]?></td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">주문일시</td>
									<td width="80%"><?php echo $TPL_VAR["bdatetime"]?></td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">결제수단</td>
									<td width="80%">가상계좌</td>
								</tr>
								<tr style="height: 100px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">계좌정보</td>
									<td width="80%">은행명 : <?php echo $TPL_VAR["bank_name"]?><br />
									계좌번호 : <?php echo $TPL_VAR["bank_account_num"]?><br />
									예금주 : <?php echo $TPL_VAR["bank_input_name"]?><br />
									<br />
									<span style="color: red; font-size: 14px; font-weight: bold;">입금 마감 기한 : <?php echo $TPL_VAR["bank_input_date"]?> </span></td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">주문상태</td>
									<td width="80%">입금예정</td>
								</tr>
							</tbody>
						</table>
						</td>
						<!--// payment_info-->
					</tr>
					<tr><!--delivery_info-->
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">배송지 정보</p>

						<table cellpadding="0" cellspacing="0" style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding-left: 20px;" width="20%">받는분</td>
									<td width="80%"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></td>
								</tr>
								<tr style="height: 100px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">주소</td>
									<td width="80%"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?><br />
									<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></td>
								</tr>
								<tr style="height: 40px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding: 0px 20px;" width="20%">휴대폰번호</td>
									<td width="80%"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></td>
								</tr>
							</tbody>
						</table>
						</td>
						<!--// delivery_info-->
					</tr>
					<tr><!--delivery_request-->
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">배송요청사항</p>

						<table cellpadding="0" cellspacing="0" style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody><?php if(count($TPL_VAR["deliveryInfo"]["msg"])> 0){?><?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php if($TPL_V1["msg"]!=''){?>
								<tr style="height: 60px; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="padding-left: 20px;"><span style="font-weight: bold;"><?php echo $TPL_V1["pname"]?></span><br />
									<?php echo $TPL_V1["msg"]?></td>
								</tr>
<?php }?><?php }}?><?php }?>
							</tbody>
						</table>
						</td>
						<!--// delivery_request-->
					</tr>
					<tr>
						<td style="margin: 0px auto; height: 50px; text-align: center; line-height: 50px; padding-top: 60px;"><a href="<?php echo $TPL_VAR["mallDomain"]?>/?utm_source=admin&amp;utm_medium=email_notify&amp;utm_campaign=main&amp;utm_content=link_email51" style="background: rgb(0, 188, 231); width: 240px; color: rgb(255, 255, 255); font-size: 14px; font-weight: bold; text-decoration: none; display: inline-block;"><?php echo $TPL_VAR["mallName"]?> 바로가기 <i style="font-style: normal; font-weight: normal;">&gt;</i></a></td>
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
						<p style="margin: 0px; text-align: center; color: rgb(0, 0, 0); line-height: 20px; font-size: 12px;">주식회사 <?php echo $TPL_VAR["comName"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;<?php echo $TPL_VAR["comAddr1"]?> <?php echo $TPL_VAR["comAddr2"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;<?php echo $TPL_VAR["comEmail"]?></p>

						<p style="margin: 0px; text-align: center; color: rgb(0, 0, 0); line-height: 20px; font-size: 12px;">사업자등록번호 : <?php echo $TPL_VAR["comNumber"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;통신판매업신고번호 :<?php echo $TPL_VAR["comOnlineBusinessNumber"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;개인정보관리책임 : <?php echo $TPL_VAR["comOfficerName"]?></p>

						<p style="margin: 0px; text-align: center; color: rgb(0, 0, 0); line-height: 20px; padding-top: 20px; font-size: 12px;">Copyright Barrel All rights reserved.</p>
						</td>
					</tr>
					<!--// footer-->
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>