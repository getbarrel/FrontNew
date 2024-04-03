<?php /* Template_ 2.2.8 2024/01/25 16:34:47 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/profile/profile_basic.htm 000038866 */ 
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!-- 컨텐츠 S -->
<section class="fb__mypage profile-detail">
	<div class="fb__mypage-title">
		<div class="title-md">회원정보 수정</div>
	</div>
	<form id="devMemberProfileForm" class="fb__mypage__profile">
		<div class="profile">
			<div class="fb__join-form">
				<div class="input-form">
					<ul class="input-form__list">
						<li class="inputs">
							<div class="fb__form-group">
								<div class="fb__form-item">
									<label for="devUserName" class="inputs__title">이름</label>
									<input type="text" id="devFormatUserName" class="input__user-name fb__form-input" name="Nm" title="이름" placeholder="이름" value="<?php echo $TPL_VAR["name"]?>" disabled />
								</div>
								<div class="fb__form-item">
									<label for="devUserId" class="inputs__title">아이디</label>
									<input type="text" title="아이디" name="userId" id="devUserId" class="fb__form-input" devmaxlength="10" placeholder="아이디" value="<?php echo $TPL_VAR["id"]?>" disabled />
								</div>
							</div>
						</li>
						<li class="inputs">
							<div class="fb__form-pw">
								<span class="inputs__title">비밀번호</span>
								<button type="button" class="btn-lg btn-dark-line change-pw-btn" id="devChangePassword">비밀번호 변경</button>
							</div>
						</li>
						<li class="inputs">
							<div class="fb__form-item fb__form-email">
								<div class="inputs__title">이메일</div>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
								<div class="fb__form-group">
									<label for="devEmailId" class="inputs__title hide">이메일</label>
									<input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" class="fb__form-input" placeholder="메일 아이디"  />
									<input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" class="fb__form-input" placeholder="메일 도메인 주소" title="메일 도메인 주소" />
								</div>
								<div class="fb__form-group">
									<select id="devEmailHostSelect" class="input__select">
										<option value="direct">직접입력</option>
										<option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
										<option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
										<option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
										<option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
										<option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
										<option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
									</select>

									<button type="button" class="btn-lg btn-default btn-dark-line" id="devEmailDoubleCheckButton">이메일 중복확인</button>
									<p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
								</div>
<?php }else{?>
								<span class="pub-email">
									<span style="width:160px;"><?php echo $TPL_VAR["mail"][ 0]?></span>
									<input type="hidden" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일" >
								<span class="hyphen_2">@</span>
									<span style="width:160px;"><?php echo $TPL_VAR["mail"][ 1]?></span>
									<input type="hidden" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
								</span>
<?php }?>
							</div>
							<!-- 오류 메세지 S -->
						</li>
						<li class="inputs">
							<div class="inputs__content inputs__content-phone">
								<label for="devPcs1" class="inputs__title">휴대폰</label>
								<div class="selectWrap">
									<select name="pcs1" id="devPcs1" class="input__select">
										<option value="010" <?php if($TPL_VAR["pcs"][ 0]=="010"){?>selected<?php }?>>010</option>
										<option value="011" <?php if($TPL_VAR["pcs"][ 0]=="011"){?>selected<?php }?>>011</option>
										<option value="016" <?php if($TPL_VAR["pcs"][ 0]=="016"){?>selected<?php }?>>016</option>
										<option value="017" <?php if($TPL_VAR["pcs"][ 0]=="017"){?>selected<?php }?>>017</option>
										<option value="018" <?php if($TPL_VAR["pcs"][ 0]=="018"){?>selected<?php }?>>018</option>
										<option value="019" <?php if($TPL_VAR["pcs"][ 0]=="019"){?>selected<?php }?>>019</option>
									</select>
									<input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" class="fb__form-input" placeholder="0000" title="휴대폰번호" />
									<input type="number" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" class="fb__form-input" placeholder="0000" title="휴대폰번호" />
								</div>
							</div>
						</li>
						<li class="inputs">
							<div class="inputs__content inputs__content-addr">
								<span class="inputs__title">주소</span>
								<div class="fb__form-item">
									<label for="devZip" class="inputs__title hide">우편번호</label>
									<input type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" class="inputs__content--zip fb__form-input" title="우편번호" placeholder="우편번호" readonly />
									<button type="button" class="btn-lg btn-dark-line inputs__content--zip-search" id="devZipPopupButton">검색</button>
								</div>
								<div class="fb__form-item">
									<label for="devAddress1" class="inputs__title hide">주소</label>
									<input type="text" name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["addr1"]?>" class="fb__form-input" title="주소" placeholder="주소" readonly />
								</div>
								<div class="fb__form-item">
									<label for="devAddress2" class="inputs__title hide">상세주소</label>
									<input type="text" id="devAddress2" class="fb__form-input" name="addr2" title="상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["addr2"]?>" />
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="input-form">
					<div class="input-form__title">
						<div class="title-sm">추가 선택 정보</div>
					</div>
					<ul class="input-form__list">
						<li class="inputs">
							<div class="fb__form-item fb__form-radio">
								<label for="devGender" class="inputs__title">성별</label>
								<div class="inputs__content inputs__content--sex">
									<label class="inputs__item"><input type="radio" title="성별" name="gender" id="W" <?php if($TPL_VAR["sex_div"]!='M'){?> checked<?php }?>/><span>여자</span></label>
									<label class="inputs__item"><input type="radio" title="성별" name="gender" id="M" <?php if($TPL_VAR["sex_div"]=='M'){?> checked<?php }?>/><span>남자</span></label>
								</div>
							</div>
						</li>
<?php if(empty($TPL_VAR["birthdayArr"])){?>
						<li class="inputs">
							<div class="fb__form-item fb__form-radio">
								<label for="devBirthdayDiv" class="inputs__title">생일</label>
								<div class="inputs__content inputs__content--birth">
									<label class="inputs__item"><input type="radio" title="양력" name="birthdayDiv" value="1" checked /><span>양력</span></label>
									<label class="inputs__item"><input type="radio" title="음력" name="birthdayDiv" value="0" /><span>음력</span></label>
								</div>
							</div>
							<div class="fb__form-item fb__form-birthday">
								<div class="inputs--birthday">
									<select name="birthYear" id="devbirthYear" class="input__select" >
										<option value="">생년</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
									</select>

									<select name="birthMonth" id="devbirthMonth" class="input__select" >
										<option value="">생월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
									</select>
									<select name="birthDay" id="devbirthDay" class="input__select" >
										<option value="">생일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
									</select>
								</div>
							</div>
						</li>
<?php }else{?>
						<!-- <li class="inputs">
							<div class="fb__form-item fb__form-radio">
								<label for="devBirthdayDiv" class="inputs__title">생일</label>
								<div class="inputs__content inputs__content--birth">
									<label class="inputs__item"><input type="radio" title="양력" name="birthdayDiv" value="1" checked /><span>양력</span></label>
									<label class="inputs__item"><input type="radio" title="음력" name="birthdayDiv" value="0" /><span>음력</span></label>
								</div>
							</div>
							<div class="fb__form-item fb__form-birthday">
								<div class="inputs--birthday">
									<select name="birthYear" id="devbirthYear" class="input__select" disabled>
										<option value="">년도</option>
										<option value="2014" selected>2014</option>
									</select>
									<select name="birthMonth" id="devbirthMonth" class="input__select" disabled>
										<option value="">월</option>
										<option value="12" selected>12</option>
									</select>
									<select name="birthDay" id="devbirthDay" class="input__select" disabled>
										<option value="">일</option>
										<option value="31" selected>31</option>
									</select>
								</div>
							</div>
						</li> -->
						<li class="inputs">
							<div class="fb__form-item fb__form-radio">
								<label for="devBirthdayDiv" class="inputs__title">생일</label>
								<div class="inputs__content inputs__content--birth">
									<input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 0]?>" readonly />
									<input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 1]?>" readonly />
									<input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 2]?>" readonly />
								</div>
							</div>
						</li>
<?php }?>
						<li class="inputs">
							<div class="fb__form-item fb__form-area">
								<label for="devUserArea" class="inputs__title">지역</label>
								<select name="area">
									<option value="">선택</option>
									<option value="10" <?php if($TPL_VAR["area"]=='10'){?> selected <?php }?> >서울특별시</option>
									<option value="20" <?php if($TPL_VAR["area"]=='20'){?> selected <?php }?> >경기도</option>
									<option value="21" <?php if($TPL_VAR["area"]=='21'){?> selected <?php }?> >인천광역시</option>
									<option value="30" <?php if($TPL_VAR["area"]=='30'){?> selected <?php }?> >강원도</option>
									<option value="41" <?php if($TPL_VAR["area"]=='41'){?> selected <?php }?> >충청남도</option>
									<option value="42" <?php if($TPL_VAR["area"]=='42'){?> selected <?php }?> >대전광역시</option>
									<option value="43" <?php if($TPL_VAR["area"]=='43'){?> selected <?php }?> >세종특별자치시</option>
									<option value="45" <?php if($TPL_VAR["area"]=='45'){?> selected <?php }?> >충청북도</option>
									<option value="51" <?php if($TPL_VAR["area"]=='51'){?> selected <?php }?> >전라남도</option>
									<option value="52" <?php if($TPL_VAR["area"]=='52'){?> selected <?php }?> >광주광역시</option>
									<option value="55" <?php if($TPL_VAR["area"]=='55'){?> selected <?php }?> >전라북도</option>
									<option value="61" <?php if($TPL_VAR["area"]=='61'){?> selected <?php }?> >경상남도</option>
									<option value="62" <?php if($TPL_VAR["area"]=='62'){?> selected <?php }?> >부산광역시</option>
									<option value="63" <?php if($TPL_VAR["area"]=='63'){?> selected <?php }?> >울산광역시</option>
									<option value="65" <?php if($TPL_VAR["area"]=='65'){?> selected <?php }?> >경상북도</option>
									<option value="66" <?php if($TPL_VAR["area"]=='66'){?> selected <?php }?> >대구광역시</option>
									<option value="70" <?php if($TPL_VAR["area"]=='70'){?> selected <?php }?> >제주특별자치도</option>
									<option value="90" <?php if($TPL_VAR["area"]=='90'){?> selected <?php }?> >기타</option>
								</select>
							</div>
						</li>
						<li class="inputs">
							<div class="inputs__title">SMS 수신 동의</div>
							<div class="input-terms">
								<div class="fb__form-item fb__form-radio">
									<input type="hidden" name="oldSms" value="<?php echo $TPL_VAR["sms"]?>">
									<input type="hidden" name="smsdate" value="<?php echo $TPL_VAR["smsdate"]?>">
									<div class="inputs__content inputs__content--sex">
										<label class="inputs__item"><input type="radio" title="SMS 수신 동의" name="sms" value="1" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?>/><span>동의</span></label>
										<label class="inputs__item"><input type="radio" title="SMS 수신 동의" name="sms" value="0" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?>/><span>비동의</span></label>
									</div>
								</div>
<?php if($TPL_VAR["viewSmsdate"]!=''){?>
								<div class="input-terms__text">
<?php if($TPL_VAR["sms"]=='1'){?>
										<?php echo $TPL_VAR["viewSmsdate"]?> / 동의함
<?php }else{?>
										<?php echo $TPL_VAR["viewSmsdate"]?> / 철회함
<?php }?>
								</div>
<?php }?>
							</div>
						</li>
						<li class="inputs">
							<div class="inputs__title">메일 수신 동의</div>
							<div class="input-terms">
								<div class="fb__form-item fb__form-radio">
									<input type="hidden" name="oldInfo" value="<?php echo $TPL_VAR["info"]?>">
									<input type="hidden" name="agree_infodate" value="<?php echo $TPL_VAR["agree_infodate"]?>">
									<div class="inputs__content inputs__content--sex">
										<label class="inputs__item"><input type="radio" title="SMS 수신 동의" name="info" value="1" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>/><span>동의</span></label>
										<label class="inputs__item"><input type="radio" title="SMS 수신 동의" name="info" value="0" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>/><span>비동의</span></label>
									</div>
								</div>
<?php if($TPL_VAR["viewInfodate"]!=''){?>
								<div class="input-terms__text">
<?php if($TPL_VAR["info"]=='1'){?>
										<?php echo $TPL_VAR["viewInfodate"]?> / 동의함
<?php }else{?>
										<?php echo $TPL_VAR["viewInfodate"]?> / 철회함
<?php }?>
								</div>
<?php }?>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="profile__footer">
				<a class="profile__btn--secede" href="/mypage/secede">회원탈퇴</a>
				<div class="profile__footer-btn">
					<button type="button" class="btn-lg btn-dark profile__btn--cancel" id="devProfileModifyCancel">취소</button>
					<button type="button" class="btn-lg btn-dark profile__btn--save">회원정보 저장</button>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- 컨텐츠 E -->
		<!-- 팝업 S -->
		<div class="popup-mask"></div>
		<div class="popup-layout">
			<div class="popup-title">
				<span id="devModalTitle">비밀번호 변경</span>
				<button type="button" class="btn-close close">닫기</button>
			</div>
			<div id="devModalContent" class="popup-content">
				<section class="popup-content__wrap">
					<div class="fb__password">
						<form class="fb__password-form">
							<div class="fb__password-group">
								<div class="fb__password-item fb__form-item">
									<label class="fb__password__label hide" for="devUserPassword">새로운 비밀번호</label>
									<input type="password" id="devUserPassword" class="fb__form-input" name="pw" title="새로운 비밀번호" placeholder="새로운 비밀번호" value="" />
									<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
								</div>
								<div class="fb__password-item fb__form-item">
									<label class="fb__password__label hide" for="devUserComparePassword">새로운 비밀번호 확인</label>
									<input type="password" id="devUserComparePassword" class="js__check__pw fb__form-input" name="comparePw" title="새로운 비밀번호 확인" placeholder="새로운 비밀번호 확인" value="" />
									<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
								</div>
								<div class="fb__password-desc">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</div>

								<!-- 패스워드 오류 메시지 S -->
								<!-- 오류시 노출 / 그 외에 숨김처리 -->
								<div class="fb__password-error txt-error txt-red" devTailMsg="devUserComparePassword">입력하신 비밀번호가 서로 일치하지 않습니다.</div>
								<!-- 패스워드 오류 메시지 E -->
							</div>
							<div class="fb__password-footer">
								<button type="button" class="btn-lg btn-dark-line" id="devSubmitButton">비밀번호 변경하기</button>
							</div>
						</form>
					</div>
				</section>
			</div>
		</div>
		<!-- 팝업 E -->
<!--
<div class="fb__mypage profile-detail">
    <form id="devMemberProfileForm" class="fb__mypage__profile">
        <div class="profile">
            <section>
                <h2 class="fb__mypage__title">개인회원정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">이름</th>
                        <td>
                            <p class="table-txt" id="devFormatUserName"><?php echo $TPL_VAR["name"]?></p>
                        </td>
                    </tr>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col">아이디</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["id"]?></p>
                        </td>
                    </tr>
<?php }?>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col"><em>*</em>비밀번호</th>
                        <td>
                            <button type="button" class="btn-default btn-dark change-pw-btn" id="devChangePassword">비밀번호 변경</button>
                        </td>
                    </tr>
<?php }?>
                    <tr>
                        <th scope="col"><label for="devEmailId"><em>*</em>이메일</label></th>
                        <td style="padding-bottom: 0; vertical-align: top;">
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                            <span class="pub-email">
                            <input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                            </span>
                            <select id="devEmailHostSelect" style="width:160px; margin-left:10px; vertical-align: middle;">
                                <option value="direct">직접입력</option>
                                <option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>

                            <button type="button" class="btn-default btn-dark" id="devEmailDoubleCheckButton" style="vertical-align: middle;">이메일 중복 확인</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
<?php }else{?>
                            <span class="pub-email">
                                <span style="width:160px;"><?php echo $TPL_VAR["mail"][ 0]?></span>
                                <input type="hidden" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일" >
                            <span class="hyphen_2">@</span>
                                <span style="width:160px;"><?php echo $TPL_VAR["mail"][ 1]?></span>
                                <input type="hidden" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                            </span>
<?php }?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>휴대폰 번호</th>
                        <td>
                            <div class="selectWrap">
                                <select name="pcs1"  id="devPcs1">
                                <option value="010" <?php if($TPL_VAR["pcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["pcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["pcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["pcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["pcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["pcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" title="휴대폰번호">
                                <span class="hyphen">-</span>
                                <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" title="휴대폰번호">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">주소</th>
                        <td>
                            <div class="form-info-wrap" style="width:500px">
                                <input type="text" class="" name="zip" value="<?php echo $TPL_VAR["zip"]?>" id="devZip" style="width:140px;" readonly>
                                <button type="button" style="margin-left: 10px; vertical-align: middle" class="btn-default btn-dark" id="devZipPopupButton">우편번호 검색</button>
                                <input type="text" class=" mat10" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" style="width:500px;" readonly>
                                <input type="text" class="mat10" style="width:500px;" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>"id="devAddress2" title="상세주소">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>
            <section class="fb__mypage__section fb__mypage__addsection">
                <h2 class="fb__mypage__title">추가정보</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="col" class="ver-m">성별</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="gender" value="M" <?php if($TPL_VAR["sex_div"]=='M'){?> checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">남자</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="gender" value="W" <?php if($TPL_VAR["sex_div"]!='M'){?> checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">여자</span>
                                            </label>
                                        </li>
                                    </ul>

                                </div>
                            </td>
                        </tr>
<?php if(empty($TPL_VAR["birthdayArr"])){?>--
                        <tr class="fb__mypage__addsection--birth">
                            <th scope="col" class="ver-m">생일</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="birthdayDiv" value="1" checked>
                                                <span>양력</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="birthdayDiv" value="0">
                                                <span>음력</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="inputs--birthday">
                                        <select name="birthYear">
                                            <option value="">생년</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">년</span>
                                        <select name="birthMonth">
                                            <option value="">생월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">월</span>

                                        <select name="birthDay">
                                            <option value="">생일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">일</span>
                                    </div>
                                    <p class="birthday__coupon-info">
                                        회원등급별 생일할인 쿠폰이 증정됩니다.</br>생년월일 최초 1회 입력 이후 변경이 불가능합니다.
                                    </p>
                                </div>
                            </td>
                        </tr>
<?php }else{?>--
                        <tr class="fb__mypage__addsection--birth">
                            <th scope="col" class="ver-m">생일</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <div class="inputs--birthday">
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 0]?>" readonly />
                                        <span class="selecttext">년</span>
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 1]?>" readonly />
                                        <span class="selecttext">월</span>
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 2]?>" readonly />
                                        <span class="selecttext">일</span>
                                    </div>
                                    <p class="birthday__coupon-info">
                                        회원등급별 생일할인 쿠폰이 증정됩니다.</br>생년월일 최초 1회 입력 이후 변경이 불가능합니다.
                                    </p>
                                </div>
                            </td>
                        </tr>
<?php }?>--
                        <tr>
                            <th scope="col" class="ver-m">지역</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <div class="area">
                                        <select name="area">
                                            <option value="">선택</option>
                                            <option value="10" <?php if($TPL_VAR["area"]=='10'){?> selected <?php }?> >서울특별시</option>
                                            <option value="20" <?php if($TPL_VAR["area"]=='20'){?> selected <?php }?> >경기도</option>
                                            <option value="21" <?php if($TPL_VAR["area"]=='21'){?> selected <?php }?> >인천광역시</option>
                                            <option value="30" <?php if($TPL_VAR["area"]=='30'){?> selected <?php }?> >강원도</option>
                                            <option value="41" <?php if($TPL_VAR["area"]=='41'){?> selected <?php }?> >충청남도</option>
                                            <option value="42" <?php if($TPL_VAR["area"]=='42'){?> selected <?php }?> >대전광역시</option>
                                            <option value="43" <?php if($TPL_VAR["area"]=='43'){?> selected <?php }?> >세종특별자치시</option>
                                            <option value="45" <?php if($TPL_VAR["area"]=='45'){?> selected <?php }?> >충청북도</option>
                                            <option value="51" <?php if($TPL_VAR["area"]=='51'){?> selected <?php }?> >전라남도</option>
                                            <option value="52" <?php if($TPL_VAR["area"]=='52'){?> selected <?php }?> >광주광역시</option>
                                            <option value="55" <?php if($TPL_VAR["area"]=='55'){?> selected <?php }?> >전라북도</option>
                                            <option value="61" <?php if($TPL_VAR["area"]=='61'){?> selected <?php }?> >경상남도</option>
                                            <option value="62" <?php if($TPL_VAR["area"]=='62'){?> selected <?php }?> >부산광역시</option>
                                            <option value="63" <?php if($TPL_VAR["area"]=='63'){?> selected <?php }?> >울산광역시</option>
                                            <option value="65" <?php if($TPL_VAR["area"]=='65'){?> selected <?php }?> >경상북도</option>
                                            <option value="66" <?php if($TPL_VAR["area"]=='66'){?> selected <?php }?> >대구광역시</option>
                                            <option value="70" <?php if($TPL_VAR["area"]=='70'){?> selected <?php }?> >제주특별자치도</option>
                                            <option value="90" <?php if($TPL_VAR["area"]=='90'){?> selected <?php }?> >기타</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="ver-m"><em>*</em>SMS 수신동의</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
								<input type="hidden" name="oldSms" value="<?php echo $TPL_VAR["sms"]?>">
								<input type="hidden" name="smsdate" value="<?php echo $TPL_VAR["smsdate"]?>">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="sms" value="1" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">동의함</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="sms" value="0" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">동의안함</span>
                                            </label>
                                        </li>
<?php if($TPL_VAR["viewSmsdate"]!=''){?>
										<li>
<?php if($TPL_VAR["sms"]=='1'){?>
												동의함 : <?php echo $TPL_VAR["viewSmsdate"]?>

<?php }else{?>
												철회함 : <?php echo $TPL_VAR["viewSmsdate"]?>

<?php }?>
										</li>
<?php }?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="ver-m"><em>*</em>메일 수신동의</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
								<input type="hidden" name="oldInfo" value="<?php echo $TPL_VAR["info"]?>">
								<input type="hidden" name="agree_infodate" value="<?php echo $TPL_VAR["agree_infodate"]?>">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="info" value="1" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">동의함</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="info" value="0" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">동의안함</span>
                                            </label>
                                        </li>
<?php if($TPL_VAR["viewInfodate"]!=''){?>
										<li>
<?php if($TPL_VAR["info"]=='1'){?>
												동의함 : <?php echo $TPL_VAR["viewInfodate"]?>

<?php }else{?>
												철회함 : <?php echo $TPL_VAR["viewInfodate"]?>

<?php }?>
										</li>
<?php }?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <div class="profile__btn">
                <button type="button" class="profile__btn--cancel" id="devProfileModifyCancel" >취소</button>
                <button class="profile__btn--save" >저장</button>
                <a class="profile__btn--secede" href="/mypage/secede">회원탈퇴</a>
            </div>
        </div>
    </form>
</div>
-->