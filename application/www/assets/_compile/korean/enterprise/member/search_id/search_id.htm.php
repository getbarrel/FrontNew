<?php /* Template_ 2.2.8 2024/02/06 10:54:01 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_id/search_id.htm 000008774 */ ?>
<!-- 컨텐츠 영역 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__member-search fb__memberpw">
	<div class="search">
		<div class="search__wrap">
			<div class="search__header">
				<h2 class="search__title title-md">아이디 찾기</h2>
				<p>회원가입 시 등록한 정보로 아이디 찾기를 하실 수 있습니다.</p>
			</div>
			<fieldset class="search__content">
				<legend>아이디 찾기</legend>
				<nav class="search__nav">
					<div class="search__nav__btn">
						<label><input type="radio" name="idsearch" value="phone" class="nav--phone" checked /><span>휴대폰 번호</span></label>
						<label><input type="radio" name="idsearch" value="email" /><span>이메일</span></label>
					</div>
				</nav>
				<form id="devSearchPhoneForm">
					<div class="search__inner search__inner--show fb__join-input__form fb__member-search__phone">
						<ul class="search__company input-form__content-box">
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="devUser" id="devUser" class="inputs__content__name fb__form-input" title="가입자 성함" placeholder="가입자 성함" value="<?php echo $TPL_VAR["userName"]?>" />
								</div>
							</li>
							<li class="inputs inputs__cellphone">
								<div class="inputs__content fb__form-item">
									<label for="devHp1" class="inputs__title hide">휴대폰</label>
									<div class="selectWrap">
										<select name="devHp1" id="devHp1">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="number" name="devHp2" id="devHp2" placeholder="0000" value="" title="휴대폰번호" />
										<input type="number" name="devHp3" id="devHp3" placeholder="0000" value="" title="휴대폰번호" />
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
				<form id="devSearchEmailForm">
					<div class="search__inner fb__join-input__form fb__member-search__email">
						<ul class="search__company input-form__content-box">
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="devUserName" id="devUserName" class="inputs__content__name fb__form-input" title="가입자 성함" placeholder="가입자 성함" value="<?php echo $TPL_VAR["userName"]?>" />
								</div>
							</li>
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devEmailId" class="inputs__title hide">이메일 주소</label>
									<div class="pub-email">
										<input type="text" name="devUserEmail1" id="devUserEmail1" class="input__email fb__form-input" title="이메일" placeholder="이메일" value="" />
										<span class="hyphen_2">@</span>
										<input type="text" name="devUserEmail2" id="devUserEmail2" class="input__email title="이메일">
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
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
			</fieldset>

			<div class="search__footer">
				<a href="javascript:void(0)" id="devUserSubmitButton" class="btn-lg btn-dark-line" id="">아이디 찾기</a>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 S -->
				<!-- 오류시 노출 / 그 외에 숨김처리 --
				<p class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</p>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 E -->
			</div>
		</div>
	</div>
</section>
<?php }else{?>
<section class="fb__member-search fb__memberpw">
	<div class="search">
		<div class="search__wrap">
			<div class="search__header">
				<h2 class="search__title title-md">아이디 찾기</h2>
				<p>회원가입 시 등록한 정보로 아이디 찾기를 하실 수 있습니다.</p>
			</div>
			<fieldset class="search__content">
				<legend>아이디 찾기</legend>
				<nav class="search__nav">
					<div class="search__nav__btn">
						<!-- <label><input type="radio" name="idsearch" value="phone" class="nav--phone" checked /><span>휴대폰 번호</span></label> -->
						<label><input type="radio" name="idsearch" value="email" checked/><span>이메일</span></label>
					</div>
				</nav>
				<!--
				<form id="devSearchPhoneForm">
					<div class="search__inner search__inner--show fb__join-input__form fb__member-search__phone">
						<ul class="search__company input-form__content-box">
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="devUserName" id="devUserName" class="inputs__content__name fb__form-input" title="가입자 성함" placeholder="가입자 성함" value="<?php echo $TPL_VAR["userName"]?>" />
								</div>
							</li>
							<li class="inputs inputs__cellphone">
								<div class="inputs__content fb__form-item">
									<label for="devHp1" class="inputs__title hide">휴대폰</label>
									<div class="selectWrap">
										<select name="devHp1" id="devHp1">
											<option value="010">010</option>
											<option value="011">011</option>
											<option value="016">016</option>
											<option value="017">017</option>
											<option value="018">018</option>
											<option value="019">019</option>
										</select>
										<input type="number" name="devHp2" id="devHp2" placeholder="0000" value="" title="휴대폰번호" />
										<input type="number" name="devHp3" id="devHp3" placeholder="0000" value="" title="휴대폰번호" />
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
				-->
				<form id="devSearchEmailForm">
					<div class="search__inner fb__join-input__form fb__member-search__email">
						<ul class="search__company input-form__content-box">
							<!-- <li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devUserName" class="inputs__title hide">가입자 성함</label>
									<input type="text" name="devUserName" id="devUserName" class="inputs__content__name fb__form-input" title="가입자 성함" placeholder="가입자 성함" value="<?php echo $TPL_VAR["userName"]?>" />
								</div>
							</li> -->
							<li class="inputs">
								<div class="inputs__content fb__form-item">
									<label for="devEmailId" class="inputs__title hide">이메일 주소</label>
									<div class="pub-email">
										<input type="text" name="devUserEmail1" id="devUserEmail1" class="input__email fb__form-input" title="이메일" placeholder="이메일" value="" />
									</div>
								</div>
							</li>
						</ul>
					</div>
				</form>
			</fieldset>

			<div class="search__footer">
				<a href="javascript:void(0)" id="devUserSubmitButton" class="btn-lg btn-dark-line" id="">아이디 찾기</a>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 S -->
				<!-- 오류시 노출 / 그 외에 숨김처리 -->
				<p class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</p>
				<!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 - 오류 메시지 E -->
			</div>
		</div>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 영역 E -->