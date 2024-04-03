<?php /* Template_ 2.2.8 2023/11/21 13:34:28 /data/barrel_data/_message/ms_email_search_pw_certi.htm 000006037 */ ?>
<table align="center" cellpadding="0" cellspacing="0" style="border: 1px solid rgb(204, 204, 204); border-image: none; border-collapse: collapse;" width="720">
	<tbody>
		<tr>
			<td style="padding: 30px;">
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;" width="660">
				<thead>
					<tr>
						<td style="line-height: 0; padding-top: 8px; font-size: 0px; border-bottom-color: #000; border-bottom-width: 3px; border-bottom-style: solid;"><span style="font-size: 13px;"><img alt="shop logo" src="https://www.getbarrel.com/data/barrel_data/images/upfile//0001-0a29d0b5-6258ffef-1018-19f47db5.png" style="margin-top: 8px; margin-bottom: 27px; width: 81px; height: 18px;" /></span></td>
					</tr>
				</thead>
				<tbody><!-- contents-->
					<tr style="text-align: left;">
						<td style="color: #000; padding-top: 44px; font-size: 34px;"><span><?php echo $TPL_VAR["mallName"]?> 이메일 인증 안내입니다.</span></td>
					</tr>
					<tr>
						<td>
						<p style="margin: 0px; padding: 50px 0px 16px; font-size: 16px; font-weight: bold;"><span style="font-size: 13px; font-weight: 400;">안녕하세요. <?php echo $TPL_VAR["mallName"]?>입니다.<br />
						<br />
						요청하신 이메일 인증을 위한 인증번호가 발급되었습니다.<br />
						아래의 인증번호를 복사하여 이메일 인증을 완료해주세요.</span></p>

						<table align="center" cellpadding="0" cellspacing="0" style="border-top-color: rgb(225, 225, 225); border-top-width: 1px; border-top-style: solid; border-collapse: collapse;" width="100%">
							<tbody>
								<tr style="height: 47px; border-bottom-color: rgb(225, 225, 225); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="background: rgb(248, 248, 248); width: 160px; padding-left: 20px; font-size: 12px; font-weight: bold;"><span style="font-size: 13px; font-weight: 400;">이메일 인증번호</span></td>
									<td style="color: rgb(102, 102, 102); padding-left: 20px; font-size: 12px;"><span style="font-size: 13px;"><?php echo $TPL_VAR["cert_no"]?></span></td>
								</tr>
								<tr style="height: 47px; border-bottom-color: rgb(225, 225, 225); border-bottom-width: 1px; border-bottom-style: solid;">
									<td style="background: rgb(248, 248, 248); width: 160px; padding-left: 20px; font-size: 12px; font-weight: bold;"><span style="font-size: 13px; font-weight: 400;">인증번호 유효기간</span></td>
									<td style="color: rgb(102, 102, 102); padding-left: 20px; font-size: 12px;"><span style="font-size: 13px;"><?php echo $TPL_VAR["year"]?>년 <?php echo $TPL_VAR["month"]?>월 <?php echo $TPL_VAR["date"]?>일 <?php echo $TPL_VAR["hour"]?>시 <?php echo $TPL_VAR["minute"]?>분</span></td>
								</tr>
							</tbody>
						</table>

						<p style="margin: 0px; padding: 10px 0px 10px; font-size: 16px; font-weight: bold;">&nbsp;</p>

						<ul style="padding-left: 20px;">
							<li>인증번호를 드래그하여 복사하거나 직접 입력해주세요.</li>
							<li>개인정보 보호를 위해 이메일 인증번호는 60분간 유효합니다.</li>
							<li>60분 동안 위의 인증번호를 사용하지 않을 경우, 배럴 비밀번호 찾기 메뉴를 통해 인증코드를 재발급하여 주시기 바랍니다.</li>
						</ul>

						<p>&nbsp;</p>

						<p style="margin: 0px; padding: 20px 0px 16px; font-size: 16px; font-weight: bold;"><span style="font-size: 13px; font-weight: 400;">해당 메일은 발신전용 메일입니다. 궁금하신 사항은 <a href="<?php echo $TPL_VAR["mallDomain"]?>/customer?emacs=Y" target="_blank">배럴 고객센터</a>로 문의하시기 바랍니다</span></p>
						</td>
					</tr>
					<tr>
						<td style="margin: 0px auto;height: 50px;text-align: center;line-height: 50px;padding: 60px 0 0;"><a href="<?php echo $TPL_VAR["mallDomain"]?>/?emacs=Y" style="background: rgb(0, 188, 231);padding: 0 20px;display: inline-block;color: #fff;" target="_blank"><?php echo $TPL_VAR["mallName"]?> 바로가기 <span style="font-style: normal; font-weight: normal;">&gt;</span></a></td>
					</tr>
					<!--// contents<!--footer-->
					<tr>
						<td style="text-align: center; padding-top: 60px;">
						<p style="margin: 0px; padding: 12px 0px; color: rgb(153, 153, 153); font-size: 12px;"><font color="#333333"><span style="font-size: 13px;">본 메일은 발신전용이므로 회신 처리되지 않습니다.<br />
						문의사항은 <?php echo $TPL_VAR["mallName"]?> 1:1 문의 또는 고객센터(<?php echo $TPL_VAR["comCsPhone"]?>)를 이용해 주세요.</span></font></p>
						</td>
					</tr>
					<tr>
						<td style="background: rgb(247, 247, 247); padding: 20px 30px; text-align: center;">
						<p style="margin: 0px; color: rgb(102, 102, 102); line-height: 20px; font-size: 12px;"><font color="#333333"><span style="font-size: 13px;">주식회사 <?php echo $TPL_VAR["comName"]?> | <?php echo $TPL_VAR["comAddr1"]?> <?php echo $TPL_VAR["comAddr2"]?> | <?php echo $TPL_VAR["comEmail"]?></span></font></p>

						<p style="margin: 0px; color: rgb(102, 102, 102); line-height: 20px; font-size: 12px;"><font color="#333333"><span style="font-size: 13px;">사업자등록번호 : <?php echo $TPL_VAR["comNumber"]?> | 통신판매업신고번호 :<?php echo $TPL_VAR["comOnlineBusinessNumber"]?> | 개인정보관리책임 : <?php echo $TPL_VAR["comOfficerName"]?></span></font></p>

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