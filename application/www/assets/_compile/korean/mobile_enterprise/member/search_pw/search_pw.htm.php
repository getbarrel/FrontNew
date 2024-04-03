<?php /* Template_ 2.2.8 2024/02/06 15:23:20 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/search_pw/search_pw.htm 000008261 */ ?>
<!-- 컨텐츠 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__find-user">
	<div class="page-title">
		<div class="title-md">비밀번호 찾기</div>
		<div class="page-title__sub">
			회원가입 시 등록한 정보로<br />
			비밀번호 찾기를 하실 수 있습니다.
		</div>
	</div>
	<div class="br-tab__wrap br__tabs">
		<form id="devSearchPhoneForm">
		<div class="br-tab__nav-radio">
			<ul>
				<li>
					<label><input type="radio" name="searchType" data-type="phone" value="phone" checked /><span>휴대폰 번호</span></label>
				</li>
				<li>
					<label><input type="radio" name="searchType" data-type="email" value="email" /><span>이메일</span></label>
				</li>
			</ul>
		</div>
		<div class="br-tab__contents active">
			<div class="br__find-user__form br__find-user__form--show">
				<div class="find-user">
					<div class="find-user__input">
						<label for="devUserId" class="hidden">아이디</label>
						<input type="text" name="userId" id="devUserId" value="" placeholder="아이디" title="아이디">
					</div>
					<div class="find-user__input">
						<label for="devUserName" class="hidden">가입자 성함</label>
						<input type="text" name="userName" id="devUserName" value="" placeholder="가입자 성함" title="가입자 성함">
					</div>
					<div id="phone" class="find-user__input find-user__input__phone">
						<label for="devHp1" class="hidden">휴대폰번호</label>
						<select name="pcs1" id="devPcs1" title="휴대폰번호">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="018">018</option>
							<option value="019">019</option>
						</select>
						<input type="text" name="pcs2" id="devPcs2" title="휴대폰번호" value="" placeholder="0000" />
						<input type="text" name="pcs3" id="devPcs3" title="휴대폰번호" value="" placeholder="0000" />
					</div>


					<div id="email" class="find-user__input find-user__input__email"  style="display: none">
						<div class="br__form-group">
							<label for="devUserEmail1" class="hidden">이메일</label>
							<input type="text" name="userEmail1" id="devUserEmail1" class="find-user__input__email--id" title="이메일" value="" placeholder="이메일 아이디" />
							<input type="text" name="userEmail2" id="devUserEmail2" class="find-user__input__email--adress" title="이메일" value="" placeholder="이메일 도메인" />
						</div>
						<select id="devEmailHostSelect">
							<option value="">이메일선택</option>
							<option value="naver.com">naver.com</option>
							<option value="gmail.com">gmail.com</option>
							<option value="hotmail.com">hotmail.com</option>
							<option value="hanmail.net">hanmail.net</option>
							<option value="daum.net">daum.net</option>
							<option value="nate.com">nate.com</option>
						</select>
					</div>

					<div class="find-user__input find-user__input__certify">
						<button type="button" id="devCertRequestBtn" class="btn-lg btn-dark-line find-user__input__certify--btn">인증번호 요청</button>
						<div class="find-user__input__certify--box">
							<input type="text" name="certNo" id="devCertNo" class="find-user__input__certify--box--input" placeholder="인증번호" title="인증번호" />
							<button type="button" id="devCertiConfirmBtn" class="btn-lg btn-dark-line find-user__input__certify--box--btn">인증번호 확인</button>
						</div>
					</div>

					<!-- 안내(오류) 메시지 S -->
					<div class="txt-error">입력하신 정보가 올바르지 않습니다.</div>
					<!-- 안내(오류) 메시지 E -->
					<div class="find-user__btn">
						<button class="btn-lg btn-dark find-user__btn__submit" id="devUserPwdSearchSubmitButton">확인</button>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div class="br__find-user__footer">
		<a href="#;" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<?php }else{?>
<section class="br__find-user">
	<div class="page-title">
		<div class="title-md">비밀번호 찾기</div>
		<div class="page-title__sub">
			회원가입 시 등록한 정보로<br />
			비밀번호 찾기를 하실 수 있습니다.
		</div>
	</div>
	<div class="br-tab__wrap br__tabs">
		<div class="br-tab__nav-radio">
			<ul>
				<li>
					<label><input type="radio" name="searchType" data-type="phone" checked /><span>휴대폰 번호</span></label>
				</li>
				<li>
					<label><input type="radio" name="searchType" data-type="email" /><span>이메일</span></label>
				</li>
			</ul>
		</div>
		<div class="br-tab__contents active">
			<div class="br__find-user__form br__find-user__form--show">
				<form id="devSearchPhoneForm">
					<div class="find-user">
						<div class="find-user__input">
							<label for="devUserId" class="hidden">아이디</label>
							<input type="text" name="userId" id="devUserId" value="" placeholder="아이디" title="아이디">
						</div>
						<div class="find-user__input">
							<label for="devUserName" class="hidden">가입자 성함</label>
							<input type="text" name="userName" id="devUserName" value="" placeholder="가입자 성함" title="가입자 성함">
						</div>
						<div id="phone" class="find-user__input find-user__input__phone">
							<label for="devHp1" class="hidden">휴대폰번호</label>
							<select name="pcs1" id="devPcs1" title="휴대폰번호">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
							<input type="text" name="pcs2" id="devPcs2" title="휴대폰번호" value="" placeholder="0000" />
							<input type="text" name="pcs3" id="devPcs3" title="휴대폰번호" value="" placeholder="0000" />
						</div>

						<div id="email" class="find-user__input find-user__input__email">
							<div class="br__form-group">
								<label for="devUserEmail1" class="hidden">이메일</label>
								<input type="text" name="devUserEmail1" id="devUserEmail1" class="find-user__input__email--id" title="이메일" value="help" placeholder="이메일 아이디" />
								<input type="text" name="devUserEmail2" id="devUserEmail2" class="find-user__input__email--adress" title="이메일" value="getbarrel.com" placeholder="이메일 도메인" />
							</div>
							<select id="devEmailHostSelect">
								<option value="">이메일선택</option>
								<option value="naver.com">naver.com</option>
								<option value="gmail.com">gmail.com</option>
								<option value="hotmail.com">hotmail.com</option>
								<option value="hanmail.net">hanmail.net</option>
								<option value="daum.net">daum.net</option>
								<option value="nate.com">nate.com</option>
							</select>
						</div>
						<div class="find-user__input find-user__input__certify">
							<button type="button" id="devCertRequestBtn" class="btn-lg btn-dark-line find-user__input__certify--btn">인증번호 요청</button>
							<div class="find-user__input__certify--box">
								<input type="text" name="certNo" id="devCertNo" class="find-user__input__certify--box--input" placeholder="인증번호" title="인증번호" />
								<button type="button" id="devCertiConfirmBtn" class="btn-lg btn-dark-line find-user__input__certify--box--btn">인증번호 확인</button>
							</div>
						</div>

						<!-- 안내(오류) 메시지 S -->
						<div class="txt-error">입력하신 정보가 올바르지 않습니다.</div>
						<!-- 안내(오류) 메시지 E -->
						<div class="find-user__btn">
							<button class="btn-lg btn-dark find-user__btn__submit" id="devUserPwdSearchSubmitButton">확인</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="br__find-user__footer">
		<a href="#;" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 E -->