<?php /* Template_ 2.2.8 2024/02/29 16:22:10 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_pw/search_pw.htm 000009627 */ ?>
<!-- 컨텐츠 영역 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__member-search fb__memberpw">
	<div class="search">
		<div class="search__wrap">
			<div class="search__header">
				<h2 class="search__title title-md">비밀번호 찾기</h2>
				<p>회원가입 시 등록한 정보로 비밀번호 찾기를 하실 수 있습니다.</p>
			</div>
			<div class="search__content">
				<form id="devSearchEmailForm">
					<legend>비밀번호 찾기</legend>
					<nav class="search__nav">
						<div class="search__nav__btn">
							<label><input type="radio" name="searchType" value="phone" checked class="nav--phone" /><span>휴대폰 번호</span></label>
							<label><input type="radio" name="searchType" value="email" /><span>이메일</span></label>
						</div>
					</nav>
					<div id="search__password" class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
						<ul class="search__company input-form__content-box">
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserId" class="inputs__title hide">아이디</label>
									<input type="text" name="userId" id="devUserId" class="inputs__content__name fb__form-input" title="아이디" placeholder="아이디" value="" />
									<p class="inputs__content__text" name="devUserId"></p>
								</div>
							</li>
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="userName" id="devUserName" class="inputs__content__name" title="가입자 성함" placeholder="가입자 성함" value="" />
									<p class="inputs__content__text" name="devUserName"></p>
								</div>
							</li>
							<li class="inputs email_group" style="display: none">
								<div class="inputs__content fb__form-item">
									<label for="devUserEmail1" class="inputs__title hide">이메일</label>
									<span class="pub-email">
										<input type="text" name="userEmail1" id="devUserEmail1" class="input__email fb__form-input" title="이메일" placeholder="이메일" value="" />
										<span class="hyphen_2">@</span>
										<input type="text" name="userEmail2" id="devUserEmail2" class="input__email"  title="이메일 주소">
										<span class="inputs__content__email">
											<select id="devEmailHostSelect" class="input__select">
												<option value="">이메일 선택</option>
												<option value="naver.com">naver.com</option>
												<option value="gmail.com">gmail.com</option>
												<option value="hotmail.com">hotmail.com</option>
												<option value="hanmail.net">hanmail.net</option>
												<option value="daum.net">daum.net</option>
												<option value="nate.com">nate.com</option>
											</select>
										</span>
									</span>
								</div>
							</li>
							<li class="inputs inputs__cellphone phone_group">
								<div class="inputs__content fb__form-item">
									<label for="devPcs1" class="inputs__title hide">휴대폰</label>
									<div class="selectWrap">
										<select name="pcs1" id="devPcs1">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="number" name="pcs2" id="devPcs2" placeholder="0000" value="" title="휴대폰번호" />
										<input type="number" name="pcs3" id="devPcs3" placeholder="0000" value="" title="휴대폰번호" />
									</div>
								</div>
							</li>
							<li class="inputs noline">
								<div class="inputs__content">
									<button type="button" class="inputs-certi btn-lg btn-dark-line" id="devCertRequestBtn">인증요청</button>
								</div>
							</li>
							<li class="inputs noline inputs-certi__number">
								<div class="inputs__content fb__form-item">
									<label for="devEmailId" class="inputs__title hide">인증번호</label>
									<input type="text" name="certNo" id="devCertNo" class="inputs__content__number fb__form-input" title="인증번호" placeholder="인증번호" value="" />
									<button type="button" id="devCertiConfirmBtn" class="inputs-certi__check btn-lg btn-dark-line">인증번호 확인</button>
								</div>
								<input type="hidden" name="keyYN" id="keyYN" value="N" />
							</li>
						</ul>
					</div>
				</form>
			</div>
			<div class="search__footer">
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 S -->
				<!-- 오류시 노출 / 그 외에 숨김처리 -->
				<p class="txt-error">입력하신 정보가 올바르지 않습니다.</p>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 E -->
				<a href="" class="btn-lg btn-dark" id="">확인</a>
			</div>
		</div>
	</div>
</section>
<?php }else{?>
<section class="fb__member-search fb__memberpw">
	<div class="search">
		<div class="search__wrap">
			<div class="search__header">
				<h2 class="search__title title-md">비밀번호 찾기</h2>
				<p>회원가입 시 등록한 정보로 비밀번호 찾기를 하실 수 있습니다.</p>
			</div>
			<div class="search__content">
				<form id="devSearchEmailForm">
					<legend>비밀번호 찾기</legend>
					<nav class="search__nav">
						<div class="search__nav__btn">
							<label><input type="radio" name="searchType" value="phone" checked class="nav--phone" /><span>휴대폰 번호</span></label>
							<label><input type="radio" name="searchType" value="email" /><span>이메일</span></label>
						</div>
					</nav>
					<div id="search__password" class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
						<ul class="search__company input-form__content-box">
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserId" class="inputs__title hide">아이디</label>
									<input type="text" name="userId" id="devUserId" class="inputs__content__name fb__form-input" title="아이디" placeholder="아이디" value="Barrel123" />
									<p class="inputs__content__text" name="devUserId"></p>
								</div>
							</li>
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="userName" id="devUserName" class="inputs__content__name" title="가입자 성함" placeholder="가입자 성함" value="김배럴" />
									<p class="inputs__content__text" name="devUserName"></p>
								</div>
							</li>
							<li class="inputs email_group" style="display: none">
								<div class="inputs__content fb__form-item">
									<label for="devUserEmail1" class="inputs__title hide">이메일</label>
									<span class="pub-email">
										<input type="text" name="userEmail1" id="devUserEmail1" class="input__email fb__form-input" title="이메일" placeholder="이메일" value="help@getbarrel.com" />
									</span>
								</div>
							</li>
							<li class="inputs inputs__cellphone phone_group">
								<div class="inputs__content fb__form-item">
									<label for="devPcs1" class="inputs__title hide">휴대폰</label>
									<div class="selectWrap">
										<select name="pcs1" id="devPcs1">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="number" name="pcs2" id="devPcs2" placeholder="0000" value="1234" title="휴대폰번호" />
										<input type="number" name="pcs3" id="devPcs3" placeholder="0000" value="1234" title="휴대폰번호" />
									</div>
								</div>
							</li>
							<li class="inputs noline">
								<div class="inputs__content">
									<button type="button" class="inputs-certi btn-lg btn-dark-line" id="devCertRequestBtn">인증요청</button>
								</div>
							</li>
							<li class="inputs noline inputs-certi__number">
								<div class="inputs__content fb__form-item">
									<label for="devEmailId" class="inputs__title hide">인증번호</label>
									<input type="text" name="certNo" id="devCertNo" class="inputs__content__number fb__form-input" title="인증번호" placeholder="인증번호" value="12345678" />
									<button type="button" id="devCertiConfirmBtn" class="inputs-certi__check btn-lg btn-dark-line">인증번호 확인</button>
								</div>
								<input type="hidden" name="keyYN" id="keyYN" value="N" />
							</li>
						</ul>
					</div>
				</form>
			</div>
			<div class="search__footer">
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 S -->
				<!-- 오류시 노출 / 그 외에 숨김처리 -->
				<p class="txt-error">입력하신 정보가 올바르지 않습니다.</p>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 E -->
				<a href="" class="btn-lg btn-dark" id="">확인</a>
			</div>
		</div>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 영역 E -->