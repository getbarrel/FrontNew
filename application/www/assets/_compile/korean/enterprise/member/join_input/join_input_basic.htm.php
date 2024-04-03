<?php /* Template_ 2.2.8 2024/02/27 15:11:51 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_input/join_input_basic.htm 000014271 */ 
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<style>
 .txt-success {
	margin:0;
	padding: 10px 0 0;
	line-height:18px;
    font-size: 12px;
	font-weight: 400;
    color: #3793fb;
}
</style>
	<section id="container" class="fb__content">
		<!-- 컨텐츠 영역 S -->
		<section class="fb__join-member">
			<div class="fb__join-wrap">
				<div class="fb__join-header">
					<div class="title-md">회원가입</div>
				</div>
				<div class="fb__join-content">
					<input type="hidden" name="snsType" id="devSnsType" value="<?php echo $TPL_VAR["snsType"]?>" />
					<form id="devBasicForm">
					<input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
						<div class="fb__join-form">
							<div class="input-form">
								<div class="input-form__title">
									<div class="title-sm">필수 가입 정보</div>
								</div>
								<ul class="input-form__content-box">
<?php if(empty($TPL_VAR["snsType"])){?>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devUserId" class="inputs__title hide">아이디</label>
											<input type="text" title="아이디" name="userId" id="devUserId" class="fb__form-input" devmaxlength="10" placeholder="아이디" value="" />
											<button type="button" class="btn-lg btn-dark-line" id="devUserIdDoubleCheckButton">중복확인</button>
										</div>
										<!-- 오류 메세지 S -->
										<!-- 미사용시 숨김처리 -->
										<p class="inputs__content__warning" devTailMsg="devUserId"></p>
										<!-- 오류 메세지 E -->
										<div class="link__box" id="devDupMember" style="display: none">
											<div class="btn-list">
												<a href="/member/login" class="btn-lg btn-dark-line">로그인</a>
												<a href="/member/searchPw" class="btn-lg btn-dark">비밀번호 찾기</a>
											</div>
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devUserPassword" class="inputs__title hide">비밀번호</label>
											<input type="password" id="devUserPassword" class="pub-input-text fb__form-input" name="pw" title="비밀번호" placeholder="비밀번호" value="" />
											<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devCompareUserPassword" class="inputs__title hide">비밀번호 확인</label>
											<input type="password" id="devCompareUserPassword" class="pub-input-text fb__form-input" name="comparePw" title="비밀번호 확인" placeholder="비밀번호 확인" value="" />
											<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
										</div>
										<p class="inputs__content__guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력</p>
										<!-- 오류 메세지 S -->
										<!-- 미사용시 숨김처리 -->
										<p class="inputs__content__warning" devTailMsg="devCompareUserPassword"></p>
										<!-- 오류 메세지 E -->
									</li>
<?php }?>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devUserName" class="inputs__title hide">이름</label>
											<input type="text" name="userName" id="devUserName" value="<?php echo $TPL_VAR["userName"]?>" class="input__user-name fb__form-input" title="이름" placeholder="이름"/>
										</div>
										 <p class="inputs__content__text" name="devUserName" id="devFormatUserName"></p>
									</li>
									<li class="inputs">
										<div class="fb__form-item fb__form-email">
											<label for="devEmailId" class="inputs__title hide">이메일 주소</label>
											<div class="fb__form-group">
												<input type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["emailId"]?>" class="fb__form-input" placeholder="메일 아이디" title="이메일 주소" /> 
												<span class="hyphen_2">@</span>
												<input type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>" class="fb__form-input" placeholder="메일 도메인 주소" title="이메일 주소" />
											</div>
											<div class="fb__form-group">
												<select id="devEmailHostSelect" class="input__select">
													<option value="">이메일 선택</option>
													<option value="naver.com">naver.com</option>
													<option value="gmail.com">gmail.com</option>
													<option value="hotmail.com">hotmail.com</option>
													<option value="hanmail.net">hanmail.net</option>
													<option value="daum.net">daum.net</option>
													<option value="nate.com">nate.com</option>
													<option value="" selected="selected">직접입력</option>
												</select>
												<button type="button" class="btn-lg btn-default btn-dark-line" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
											</div>
										</div>
										<!-- 오류 메세지 S -->
										<!-- 미사용시 숨김처리 -->
										<p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
										<!-- 오류 메세지 E -->
									</li>
									<li class="inputs">
										<div class="inputs__content">
											<label for="devPcs1" class="inputs__title hide">휴대폰</label>
											<div class="selectWrap">
												<select name="pcs1" id="devPcs1" class="input__select">
													<option value="010" <?php if($TPL_VAR["pcs1"]=="010"){?>selcted<?php }?>>010</option>
													<option value="011" <?php if($TPL_VAR["pcs1"]=="011"){?>selcted<?php }?>>011</option>
													<option value="016" <?php if($TPL_VAR["pcs1"]=="016"){?>selcted<?php }?>>016</option>
													<option value="017" <?php if($TPL_VAR["pcs1"]=="017"){?>selcted<?php }?>>017</option>
													<option value="018" <?php if($TPL_VAR["pcs1"]=="018"){?>selcted<?php }?>>018</option>
													<option value="019" <?php if($TPL_VAR["pcs1"]=="019"){?>selcted<?php }?>>019</option>
												</select>
												<input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" class="fb__form-input" placeholder="0000" title="휴대폰번호" />
												<input type="number" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" class="fb__form-input" placeholder="0000" title="휴대폰번호" />
											</div>
										</div>
									</li>
								</ul>
							</div>

							<div class="input-form">
								<div class="input-form__title">
									<div class="title-sm">추가 선택 정보</div>
									<div class="title-sx">주소</div>
								</div>
								<ul class="input-form__content-box">
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devZip" class="inputs__title hide">우편번호</label>
											<input type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" class="inputs__content--zip fb__form-input" title="우편번호 검색" placeholder="우편번호" readonly />
											<button type="button" class="btn-lg btn-dark-line inputs__content--zip-search" id="devZipPopupButton">검색</button>
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devAddress1" class="inputs__title hide">주소</label>
											<input type="text" name="addr1" id="devAddress1" class="fb__form-input" title="주소" placeholder="주소" value="<?php echo $TPL_VAR["addr1"]?>" readonly />
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item">
											<label for="devAddress2" class="inputs__title hide">상세주소</label>
											<input type="text" id="devAddress2" class="fb__form-input" name="addr2" title="상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["addr2"]?>" />
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item fb__form-radio">
											<label for="devGender" class="inputs__title">성별</label>
											<div class="inputs__content inputs__content--sex">
												<label class="inputs__item"><input type="radio" title="성별" name="gender" id="W" <?php if($TPL_VAR["gender"]=="W"){?>checked<?php }?>/><span>여자</span></label>
												<label class="inputs__item"><input type="radio" title="성별" name="gender" id="M" <?php if($TPL_VAR["gender"]=="M"){?>checked<?php }?>/><span>남자</span></label>
											</div>
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item fb__form-radio">
											<label for="devBirthdayDiv" class="inputs__title">생일</label>
											<div class="inputs__content inputs__content--birth">
												<label class="inputs__item"><input type="radio" title="양력" name="birthdayDiv" value="1" <?php if($TPL_VAR["birthdayDiv"]=="1"){?>checked<?php }?> /><span>양력</span></label>
												<label class="inputs__item"><input type="radio" title="음력" name="birthdayDiv" value="0" <?php if($TPL_VAR["birthdayDiv"]=="0"){?>checked<?php }?>/><span>음력</span></label>
											</div>
										</div>
									</li>
									<li class="inputs">
										<div class="fb__form-item fb__form-birthday">
											<div class="inputs--birthday">
												<select name="birthYear" id="devbirthYear" class="input__select">
													<option value="">년</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthYearText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
												</select>
												<select name="birthMonth" id="devbirthMonth" class="input__select">
													<option value="">월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthMonthText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
												</select>
												<select name="birthDay" id="devbirthDay" class="input__select">
													<option value="">일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthDayText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
												</select>
											</div>
										</div>
										<p class="inputs__content__guide txt-red">생일을 등록하시면 회원등급별 생일 쿠폰이 지급됩니다.</p>
									</li>
								</ul>
							</div>
							<div class="input-form input-terms">
								<div class="input-form__title">
									<div class="title-sm">회원 가입을 위한 약관 동의</div>
								</div>
								<div class="input-form__agree-all">
									<label class="fb__form-agree"><input type="checkbox" id="all_terms_check" title="전체 체크"  />전체 동의</label>
									<p>전체 동의는 필수 및 선택 정보에 대한 동의가 포함되어 있으며, 개별적으로 동의를 선택할 수 있습니다. 선택 항목에 대한 동의를 체크하지 않아도 서비스를 정상적으로 이용하실 수 있습니다.</p>
								</div>
								<ul class="input-form__content-box">
									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" id="devUnderAge" name="underAge" value="Y" data-title="만 14세 이상" title="만 14세 이상"  />만 14세 이상입니다. (필수)</label>
									</li>

									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="이용약관" title="이용약관"  />이용약관 동의 (필수)</label>
										<a href="#" class="btn-sm inputs__content inputs__content--use">내용보기</a>
									</li>
									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" id="devPolicyCollection" name="policyCollection" title="개인정보 수집 및 이용"  />개인정보 수집 및 이용 동의 (필수)</label>
										<a href="#" class="btn-sm inputs__content inputs__content--private">내용보기</a>
									</li>
									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" name="collection" value="1"  />개인정보 수집 및 이용 동의 (선택)</label>
										<a href="#" class="btn-sm inputs__content inputs__content--select">내용보기</a>
									</li>
									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" name="email" value="1"  />이메일 수신 동의 (선택)</label>
										<!-- <a href="#" class="btn-sm inputs__content inputs__content--email">내용보기</a> -->
									</li>


									<li class="inputs inputs__agree agree-content">
										<label class="fb__form-agree"><input type="checkbox" name="sms" value="1"  />SMS 수신 동의 (선택)</label>
										<!-- <a href="#" class="btn-sm inputs__content inputs__content--sms">내용보기</a> -->
									</li>
								</ul>

							</div>
						</div>
						<div class="fb__join-footer">
							<button type="button" class="btn-lg btn-gray-line" id="devCancelButton">취소</button>
							<button class="btn-lg btn-dark-line" id="devBasicSubmitButton">회원가입</button>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- 컨텐츠 영역 E -->
	</section>