<?php /* Template_ 2.2.8 2024/02/16 10:50:22 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/profile/profile_basic.htm 000016032 */ 
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__join">
	<div class="br__mypage__pass">
		<div class="page-title my-title">
			<div class="title-sm">회원정보 수정</div>
		</div>

		<div class="br__join-form__wrap">
			<form>
				<div class="br__join-form br__join-basic">
					<div class="br__join__item">
						<div class="br__form-item">
							<label for="devUserName" class="br__form-label">이름</label>
							<input class="join__input br__form-input js__joininput__name" type="text" name="userName" id="devUserName" value="<?php echo $TPL_VAR["name"]?>" title="이름" placeholder="이름" disabled />
						</div>
					</div>
					<div class="br__join__item br__join__item-id">
						<div class="br__form-item">
							<label for="devUserId" class="br__form-label">아이디</label>
							<input class="join__input" type="text" class="br__form-input" id="devUserId" name="userId" title="아이디" placeholder="아이디" value="<?php echo $TPL_VAR["id"]?>" disabled />
						</div>
					</div>
					<div class="br__join__item br__join__item-password">
						<span class="br__form-label">비밀번호</span>
						<button type="button" class="btn-lg btn-dark-line" id="devChangePassword">비밀번호 변경</button>
					</div>
					<div class="br__join__item br__join__item-emil">
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
						<div class="br__form-item join__eamil">
							<label for="devEmailId" class="br__form-label">이메일</label>
							<input class="join__input email-id br__form-input" type="text" name="emailId" id="devEmailId" placeholder="이메일 아이디" value="<?php echo $TPL_VAR["mail"][ 0]?>" title="이메일 아이디" <?php if($TPL_VAR["isSnsJoin"]){?> disabled <?php }?> />
							<input class="join__input email-info br__form-input" type="text" name="emailHost" id="devEmailHost" placeholder="메일 도메인 주소" value="<?php echo $TPL_VAR["mail"][ 1]?>" title="메일 도메인 주소" <?php if($TPL_VAR["isSnsJoin"]){?> disabled <?php }?> />
						</div>
						<select id="devEmailHostSelect" class="br__form-select">
							<option value="">이메일 선택</option>
							<option value="naver.com">naver.com</option>
							<option value="gmail.com">gmail.com</option>
							<option value="hotmail.com">hotmail.com</option>
							<option value="hanmail.net">hanmail.net</option>
							<option value="daum.net">daum.net</option>
							<option value="nate.com">nate.com</option>
							<option value="direct">직접입력</option>
						</select>
						<div class="join__email__check">
							<button type="button" class="btn-lg join__email__check-btn" id="devEmailDoubleCheckButton">이메일 중복확인</button>
							<!-- 안내(오류) 메시지 S -->
							<!-- 숨김 처리 -->
							<p class="txt-error" devTailMsg=""></p>
							<!-- 안내(오류) 메시지 E -->
						</div>
<?php }else{?>
						<div class="join__eamil">
							<span style="width:80px;"><?php echo $TPL_VAR["mail"][ 0]?></span>
							<input class="join__input email-id" type="hidden" name="emailId" id="devEmailId" title="이메일 아이디" value="<?php echo $TPL_VAR["mail"][ 0]?>"/>
							<span>@</span>
							<span style="width:60px;"><?php echo $TPL_VAR["mail"][ 1]?></span>
							<input class="join__input email-info" type="hidden" name="emailHost" id="devEmailHost" title="메일 도메인 주소" value="<?php echo $TPL_VAR["mail"][ 1]?>"/>
						</div>
<?php }?>
						<p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
					</div>
					<div class="br__join__item br__join__item-phone">
						<div class="br__form-item join__phone">
							<label for="devPcs1" class="br__form-label">휴대폰 번호</label>
							<select class="join__phone-first br__form-select" name="pcs1" id="devPcs1">
								<option value="010" <?php if($TPL_VAR["pcs"][ 0]=="010"){?>selected<?php }?>>010</option>
								<option value="011" <?php if($TPL_VAR["pcs"][ 0]=="011"){?>selected<?php }?>>011</option>
								<option value="016" <?php if($TPL_VAR["pcs"][ 0]=="016"){?>selected<?php }?>>016</option>
								<option value="017" <?php if($TPL_VAR["pcs"][ 0]=="017"){?>selected<?php }?>>017</option>
								<option value="018" <?php if($TPL_VAR["pcs"][ 0]=="018"){?>selected<?php }?>>018</option>
								<option value="019" <?php if($TPL_VAR["pcs"][ 0]=="019"){?>selected<?php }?>>019</option>
							</select>
							<input class="join__input join__phone-second br__form-input" type="text" name="pcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" id="devPcs2" title="휴대폰" maxlength="4" />
							<input class="join__input join__phone-third br__form-input" type="text" name="pcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" id="devPcs3" title="휴대폰" maxlength="4" />
						</div>
					</div>
					<div class="br__join__item br__join__item-addr">
						<div class="join__addr">
							<label for="devPcs1" class="br__form-label">주소</label>
							<div class="br__form-group">
								<input class="join__input br__form-input" type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" title="우편번호" placeholder="우편번호" readonly/>
								<button class="btn-md btn-dark-line join__id__check" id="devZipPopupButton">검색</button>

							</div>
							<input class="join__address" type="text" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" title="주소"  readonly />
							<input class="join__address" type="text" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" id="devAddress2" title="상세주소"  placeholder="상세주소" />
						</div>
					</div>
				</div>
				<div class="br__join-form br__join-add">
					<div class="page-title">
						<div class="title-sm">추가 선택 정보</div>
					</div>
					<div class="br__join__item br__join__add">
						<p class="join-symbol">성별</p>
						<div class="br__find-user__label">
							<label><input type="radio" name="gender" value="M" <?php if($TPL_VAR["sex_div"]=='M'){?>checked<?php }?>/><span>남자</span></label>
							<label><input type="radio" name="gender" value="W" <?php if($TPL_VAR["sex_div"]=='W'){?>checked<?php }?>/><span>여자</span></label>
						</div>
					</div>
					<div class="br__join__item br__join__birthday">
						<div class="br__join__add">
							<p class="join-symbol">생일</p>
							<div class="br__find-user__label">
								<label><input type="radio" data-type="" name="birthdayDiv" value="1" checked /><span>양력</span></label>
								<label><input type="radio" data-type="" name="birthdayDiv" value="0" /><span>음력</span></label>
							</div>
						</div>
						<div class="join__day-box add-info">
<?php if(empty($TPL_VAR["birthdayArr"])){?>
							<div class="br__form-group">
								<select class="join__input join__day-first br__form-select" name="birthYear">
									<option value="">년도</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>

								<select class="join__input join__day-second br__form-select" name="birthMonth">
									<option value="">월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>
								<select class="join__input join__day-third br__form-select" name="birthDay">
									<option value="">일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>
							</div>
<?php }else{?>
							<div class="br__join__add">
								<input type="text" value="<?php echo $TPL_VAR["birthdayArr"][ 0]?>" class="join__input join__day-first" disabled />
								<span class="join__day-txt">년</span>
								<input type="text" value="<?php echo $TPL_VAR["birthdayArr"][ 1]?>" class="join__input join__day-second" disabled />
								<span class="join__day-txt">월</span>
								<input type="text" value="<?php echo $TPL_VAR["birthdayArr"][ 2]?>" class="join__input join__day-third" disabled />
								<span class="join__day-txt">일</span>
							</div>
<?php }?>
						</div>
					</div>
					<div class="br__join__item br__join-map">
						<div class="br__form-item">
							<label class="br__form-label">지역</label>
							<select name="area">
								<option value="">지역 선택</option>
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

					<!-- SMS 수신동의 S -->
					<dl class="br__join__list sms-agree__wrap">
						<dt class="br__form-label">SMS 수신동의</dt>
						<dd>
							<div class="br__join__add br__mypage__agree">
								<input type="hidden" name="oldSms" value="<?php echo $TPL_VAR["sms"]?>">
								<input type="hidden" name="smsdate" value="<?php echo $TPL_VAR["smsdate"]?>">
								<div class="br__find-user__label br__join__add">
									<label for="devAgreeSms"> <input type="radio" name="sms" value="1" id="devAgreeSms" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?> /><span>동의</span> </label>
									<label for="devAgreeSms-NO"> <input type="radio" name="sms" value="0" data-type="" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?> /><span>비동의</span> </label>
								</div>
							</div>
<?php if($TPL_VAR["viewSmsdate"]!=''){?>
							<div class="br__join__add-data">
<?php if($TPL_VAR["sms"]=='1'){?>
									<span class="day"><?php echo $TPL_VAR["viewSmsdate"]?></span>
									<span class="agree">동의함</span>
<?php }else{?>
									<span class="day"><?php echo $TPL_VAR["viewSmsdate"]?></span>
									<span class="agree">철회함</span>
<?php }?>
							</div>
<?php }?>
						</dd>
					</dl>

					<!-- 메일 수신동의 S -->
					<dl class="br__join__list sms-agree__wrap">
						<dt class="br__form-label">메일 수신 동의</dt>
						<dd>
							<div class="br__join__add br__mypage__agree">
								<input type="hidden" name="oldInfo" value="<?php echo $TPL_VAR["info"]?>">
								<input type="hidden" name="agree_infodate" value="<?php echo $TPL_VAR["agree_infodate"]?>">
								<div class="br__find-user__label br__join__add">
									<label for="devAgreeEmail"> <input type="radio" name="info" value="1" id="devAgreeEmail" data-type="" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>/><span>동의</span> </label>
									<label for="devAgreeEmail-NO"> <input type="radio" name="info" value="0" data-type="" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>/><span>비동의</span> </label>
								</div>
							</div>
<?php if($TPL_VAR["viewInfodate"]!=''){?>
							<div class="br__join__add-data">
<?php if($TPL_VAR["info"]=='1'){?>
									<span class="day"><?php echo $TPL_VAR["viewInfodate"]?></span>
									<span class="agree">동의함</span>
<?php }else{?>
									<span class="day"><?php echo $TPL_VAR["viewInfodate"]?></span>
									<span class="agree">철회함</span>
<?php }?>
							</div>
<?php }?>
						</dd>
					</dl>
				</div>

				<div class="br__join__btn">
					<button type="button" class="btn-lg btn-dark join__btn btn-point">회원정보 저장</button>
				</div>
			</form>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->

<!-- modal S -->
<div class="popup-mask"></div>
<div class="popup-layout popup-layout__password" id="layer-pw">
	<div class="popup-layout__wrap">
		<div class="popup-title">
			<div class="title-lg">비밀번호 변경</div>
			<a href="#;" class="btn-close">닫기</a>
		</div>
		<div class="popup-content__wrap">
			<div class="popup-content">
				<div class="br__join">
					<form>
						<div class="br__join-form">
							<div class="br__join__item br__join__item-password">
								<div class="br__form-item">
									<label for="devUserPassword" class="br__form-label hidden">비밀번호</label>
									<input class="join__input br__form-input" type="password" id="devUserPassword" name="pw" title="비밀번호" value="" placeholder="비밀번호" />
									<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
								</div>
								<div class="br__form-item">
									<label for="devCompareUserPassword" class="br__form-label hidden">비밀번호 확인</label>
									<input class="join__input br__form-input" type="password" id="devCompareUserPassword" name="comparePw" title="비밀번호 확인" value="" placeholder="비밀번호 확인" />
									<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
								</div>
								<p class="join__info-txt">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>
								<!-- 입력한 비밀번호가 동일하지 않을 경우 / 안내(오류) 메시지 S -->
								<!-- 숨김 처리 -->
								<p class="txt-error" style="display: none">입력하신 비밀번호가 서로 일치하지 않습니다.</p>
								<!-- 입력한 비밀번호가 동일하지 않을 경우 / 안내(오류) 메시지 E -->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="popup-layout__footer">
			<div class="btn-group col">
				<button type="button" class="btn-lg btn-dark-line">비밀번호 변경하기</button>
				<button type="button" class="btn-lg btn-gray-line">취소</button>
			</div>
		</div>
	</div>
</div>
<!-- modal E -->