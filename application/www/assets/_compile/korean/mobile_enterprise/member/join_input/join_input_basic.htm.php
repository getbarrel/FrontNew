<?php /* Template_ 2.2.8 2024/02/27 16:14:44 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_input/join_input_basic.htm 000012928 */ 
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!-- 컨텐츠 S -->
<section class="br__join">
	<div class="br__join-form__wrap">
		<form id="devBasicForm">
			<div class="page-title">
				<div class="title-sm">필수 가입 정보</div>
			</div>
			<div class="br__join-form br__join-basic">
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
				<div class="br__join__item br__join__item-id">
					<div class="br__form-item">
						<label for="devUserId" class="br__form-label hidden">아이디</label>
						<input class="join__input" type="text" class="br__form-input" id="devUserId" name="userId" title="아이디" placeholder="아이디" value="" />
						<button class="bnt-md btn-dark-line join__id__check" id="devUserIdDoubleCheckButton">중복확인</button>
					</div>
					<!-- 안내(오류) 메시지 S -->
					<p class="txt-error" devTailMsg="devUserId"></p>
					<!-- 안내(오류) 메시지 E -->

					<div class="information__btn" id="devDupMember" style="display: none">
						<div class="btn-group">
							<a href="/member/login" class="btn-lg btn-dark-line information__btn__login">로그인</a>
							<a href="/member/searchPw" class="btn-lg btn-dark-line information__btn__join">비밀번호찾기</a>
						</div>
						<p class="information__txt">해당 아이디로 로그인을 하시거나 비밀번호 찾기를 해주세요.</p>
					</div>
				</div>
<?php }?>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
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
					<p class="join__info-txt" devTailMsg="devCompareUserPassword"></p>
				</div>
<?php }?>
				<div class="br__join__item">
					<div class="br__form-item">
						<label for="devUserName" class="br__form-label hidden">이름</label>
						<input class="join__input br__form-input js__joininput__name" type="text" name="userName" id="devUserName" value="<?php echo $TPL_VAR["userName"]?>" title="이름" placeholder="이름" />
					</div>
				</div>
				<div class="br__join__item br__join__item-emil">
					<div class="br__form-item join__eamil">
						<label for="devEmailId" class="br__form-label hidden">이메일</label>
						<input class="join__input email-id br__form-input" type="text" name="emailId" id="devEmailId" placeholder="이메일 아이디" value="<?php echo $TPL_VAR["emailId"]?>" title="이메일 아이디" />
						<input class="join__input email-info br__form-input" type="text" name="emailHost" id="devEmailHost" placeholder="메일 도메인 주소" value="<?php echo $TPL_VAR["emailHost"]?>" title="메일 도메인 주소" />
					</div>
					<select id="devEmailHostSelect" class="br__form-select">
						<option value="">선택</option>
						<option value="naver.com">naver.com</option>
						<option value="gmail.com">gmail.com</option>
						<option value="hotmail.com">hotmail.com</option>
						<option value="hanmail.net">hanmail.net</option>
						<option value="daum.net">daum.net</option>
						<option value="nate.com">nate.com</option>
						<option value="direct" >직접입력</option>
					</select>
					<div class="join__email__check">
						<button type="button" class="btn-lg join__email__check-btn" id="devEmailDoubleCheckButton">이메일 중복확인</button>
						<p class="txt-error" devTailMsg=""></p>
					</div>
					<p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
				</div>
				<div class="br__join__item br__join__item-phone">
					<div class="br__form-item join__phone">
						<label for="devPcs1" class="br__form-label hidden">휴대폰</label>
						<select class="join__phone-first br__form-select" name="pcs1" id="devPcs1">
							<option value="010" <?php if($TPL_VAR["pcs1"]=="010"){?>selected<?php }?>>010</option>
							<option value="011" <?php if($TPL_VAR["pcs1"]=="011"){?>selected<?php }?>>011</option>
							<option value="016" <?php if($TPL_VAR["pcs1"]=="016"){?>selected<?php }?>>016</option>
							<option value="017" <?php if($TPL_VAR["pcs1"]=="017"){?>selected<?php }?>>017</option>
							<option value="018" <?php if($TPL_VAR["pcs1"]=="018"){?>selected<?php }?>>018</option>
							<option value="019" <?php if($TPL_VAR["pcs1"]=="019"){?>selected<?php }?>>019</option>
						</select>
						<input class="join__input join__phone-second br__form-input" type="text" name="pcs2" placeholder="0000" value="<?php echo $TPL_VAR["pcs2"]?>" id="devPcs2" title="휴대폰" maxlength="4" />
						<input class="join__input join__phone-third br__form-input" type="text" name="pcs3" placeholder="0000" value="<?php echo $TPL_VAR["pcs3"]?>" id="devPcs3" title="휴대폰" maxlength="4" />
					</div>
				</div>
			</div>
			<div class="page-title">
				<div class="title-sm">추가 선택 정보</div>
			</div>
			<div class="br__join-form br__join-add">
				<div class="br__join__item br__join__item-addr">
					<div class="join__addr">
						<label for="devPcs1" class="br__form-label">주소</label>
						<div class="br__form-group">
							<input class="join__input br__form-input" type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" title="우편번호" placeholder="우편번호" />
							<button class="btn-md btn-dark-line join__id__check" id="devZipPopupButton">검색</button>
						</div>
						<input class="join__address" type="text" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" placeholder="" />
						<input class="join__address" type="text" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" id="devAddress2" title="상세 주소" placeholder="상세주소" />
					</div>
				</div>
				<div class="br__join__item br__join__add">
					<p class="join-symbol">성별</p>
					<div class="br__find-user__label">
						<label><input type="radio" name="gender" value="M" data-type="" <?php if($TPL_VAR["gender"]=="M"){?>checked<?php }?>><span>남자</span></label>
						<label><input type="radio" name="gender" value="W" data-type="" <?php if($TPL_VAR["gender"]=="W"){?>checked<?php }?>><span>여자</span></label>
					</div>
				</div>
				<div class="br__join__item br__join__birthday">
					<div class="br__join__add">
						<p class="join-symbol">생일</p>
						<div class="br__find-user__label">
							<label><input type="radio" name="join-day" name="birthdayDiv" value="1" data-type="" <?php if($TPL_VAR["birthdayDiv"]=="1"){?>checked<?php }?>><span>양력</span></label>
							<label><input type="radio" name="join-day" name="birthdayDiv" value="0" data-type="" <?php if($TPL_VAR["birthdayDiv"]=="0"){?>checked<?php }?>><span>음력</span></label>
						</div>
					</div>
					<div class="join__day-box add-info">
						<div class="br__form-group">
							<select class="join__input join__day-first br__form-select" name="birthYear" id="devbirthYear">
								<option value="">년도</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthYearText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
							</select>

							<select class="join__input join__day-second br__form-select" name="birthMonth" id="devbirthMonth">
								<option value="">월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthMonthText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
							</select>

							<select class="join__input join__day-third br__form-select" name="birthDay" id="devbirthDay">
								<option value="">일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthDayText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
							</select>
						</div>
						<p class="join__day-info">생일을 등록하시면 회원등급별 생일 쿠폰이 지급됩니다.</p>
					</div>
				</div>
			</div>
			<div class="page-title">
				<div class="title-md">회원 가입을 위한 약관 동의</div>
			</div>

			<!-- 이용약관 S -->
			<div class="br__join__terms">
				<div class="join__terms-all">
					<label for="all_terms_check">
						<input type="checkbox" id="all_terms_check" class="join__terms__agree" name="" data-type="" />
						<span>전체 동의</span>
					</label>
					<p class="txt-guide">전체 동의는 필수 및 선택 정보에 대한 동의가 포함되어 있으며, 개별적으로 동의를 선택할 수 있습니다. 선택 항목에 대한 동의를 체크하지 않아도 서비스를 정상적으로 이용하실 수 있습니다.</p>
				</div>
				<ul>
					<li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" data-name="terms00" name="underAge" data-title="미성년확인" id="devUnderAge" title="미성년확인" value="Y" />
							<span>만 14세 이상입니다. (필수)</span>
						</label>
					</li>
                    <li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" data-name="terms01" name="policyUse" data-title="이용약관 동의 (필수)" id="devPolicyUse" title="이용약관 동의 (필수)" />
							<span>이용약관 동의 (필수)</span>
						</label>
						<button class="join__all-view term-content" type="button">내용보기</button>
					</li>
					<li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" data-name="terms02" name="collection" data-title="개인정보 수집 및 이용 동의 (필수)" id="devPolicyUse" title="개인정보 수집 및 이용 동의 (필수)" />
							<span>개인정보 수집 및 이용 동의 (필수)</span>
						</label>
						<button class="join__all-view term-content" type="button">내용보기</button>
					</li>
					<li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" data-name="terms03" name="collection_select" data-title="개인정보 수집 및 이용 동의 (선택)" id="devPolicyUse" title="개인정보 수집 및 이용 동의 (선택)" />
							<span>개인정보 수집 및 이용 동의 (선택)</span>
						</label>
						<button class="join__all-view term-content" type="button">내용보기</button>
					</li>
					<li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" name="email" value="1" data-type="" />
							<span>이메일 수신 동의 (선택)</span>
						</label>
					</li>
					<li class="br__find-user__label agree-content">
						<label>
							<input type="checkbox" name="sms" value="1" data-type="" />
							<span>SMS 수신 동의 (선택)</span>
						</label>
					</li>
				</ul>
			</div>
			<!-- 이용약관 E -->

			<div class="br__join__btn">
				<button type="button" class="btn-lg btn-dark-line join__btn" id="devBasicSubmitButton">회원가입</button>
			</div>
		</form>
	</div>
	<div class="br__join-footer">
		<a href="#;" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<!-- 컨텐츠 E -->
<!-- 이용약관 팝업 -->
<div class="term__popup">
    <p class="term__popup-title">
        <span class="term__popup-name">이용약관</span>
        <span class="close"></span>
    </p>
    <div class="term__popup-content terms01">
        <?php echo $TPL_VAR["policyData"]['use']['contents']?>

    </div>
    <div class="term__popup-content terms02">
        <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

    </div>
	<div class="term__popup-content terms03">
		<?php echo $TPL_VAR["policyData"]['collection_select']['contents']?>

	</div>
</div>
<!-- EOD : 이용약관 팝업 -->