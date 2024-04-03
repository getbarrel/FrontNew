<?php /* Template_ 2.2.8 2023/11/21 13:22:49 /data/barrel_data/_message/ms_email_member_exit.htm 000005056 */ ?>
<meta charset="UTF-8">
<title></title>
<table align="center" cellpadding="0" cellspacing="0" style="border: 1px solid rgb(204, 204, 204); border-image: none; border-collapse: collapse;" width="720">
	<tbody>
		<tr>
			<td style="padding: 30px;">
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;" width="660">
				<thead>
					<tr>
						<td style="line-height: 0;padding-top: 8px;font-size: 0px;border-bottom-color: #000;border-bottom-width: 3px;border-bottom-style: solid;"><img alt="shop logo" src="https://www.getbarrel.com/data/barrel_data/images/upfile//0001-0a29d0b5-6258ffef-1018-19f47db5.png" style="margin-top: 8px; margin-bottom: 27px; width: 81px; height: 18px;" /></td>
					</tr>
				</thead>
				<tbody><!--contents-->
					<tr>
						<td style="line-height: 0; padding-top: 30px; font-size: 0px;">&nbsp;</td>
					</tr>
					<tr style="border: 1px solid rgb(204, 204, 204); border-image: none; height: 240px; text-align: center;">
						<td style="line-height: 0; font-size: 0px;"><span style="color: #000;line-height: 36px;letter-spacing: -0.5px;font-size: 34px;">그동안 <?php echo $TPL_VAR["mallName"]?>을 이용해 주셔서 감사합니다.</span>
						<p style="margin: 0px; line-height: 18px; padding-top: 20px; font-size: 12px;"><?php echo $TPL_VAR["mem_name"]?>님께서 요청하신 <?php echo $TPL_VAR["mallName"]?>의 회원탈퇴가 완료되었습니다.<br />
						회원님과의 인연을 소중히 기억하겠습니다.</p>
						</td>
					</tr>
					<tr>
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;">탈퇴 정보</p>

						<table align="center" cellpadding="0" cellspacing="0" style="border-top-color: rgb(225, 225, 225); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 47px; border-bottom-color: rgb(225, 225, 225); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="background: rgb(248, 248, 248); width: 160px; padding-left: 20px; font-size: 12px; font-weight: bold;">아이디</td>
									<td style="color: rgb(102, 102, 102); padding-left: 20px; font-size: 12px;"><?php echo $TPL_VAR["mem_id"]?></td>
								</tr>
								<tr style="height: 47px; border-bottom-color: rgb(225, 225, 225); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="background: rgb(248, 248, 248); width: 160px; padding-left: 20px; font-size: 12px; font-weight: bold;">회원이름</td>
									<td style="color: rgb(102, 102, 102); padding-left: 20px; font-size: 12px;"><?php echo $TPL_VAR["mem_name"]?></td>
								</tr>
								<tr style="height: 47px; border-bottom-color: rgb(225, 225, 225); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="background: rgb(248, 248, 248); width: 160px; padding-left: 20px; font-size: 12px; font-weight: bold;">탈퇴일</td>
									<td style="color: rgb(102, 102, 102); padding-left: 20px; font-size: 12px;"><?php echo $TPL_VAR["exit_date"]?></td>
								</tr>
							</tbody>
						</table>
						</td>
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
						<p style="text-align: center; margin: 0px; color: rgb(0, 0, 0); line-height: 20px; font-size: 12px;">주식회사 <?php echo $TPL_VAR["comName"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;<?php echo $TPL_VAR["comAddr1"]?> <?php echo $TPL_VAR["comAddr2"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;<?php echo $TPL_VAR["comEmail"]?></p>

						<p style="text-align: center; margin: 0px; color: rgb(0, 0, 0); line-height: 20px; font-size: 12px;">사업자등록번호 : <?php echo $TPL_VAR["comNumber"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;통신판매업신고번호 :<?php echo $TPL_VAR["comOnlineBusinessNumber"]?>&nbsp;<span style="color: rgb(153, 153, 153);">|</span>&nbsp;개인정보관리책임 : <?php echo $TPL_VAR["comOfficerName"]?></p>

						<p style="text-align: center; margin: 0px; color: rgb(0, 0, 0); line-height: 20px; padding-top: 20px; font-size: 12px;">Copyright Barrel All rights reserved.</p>
						</td>
					</tr>
					<!--// footer-->
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>