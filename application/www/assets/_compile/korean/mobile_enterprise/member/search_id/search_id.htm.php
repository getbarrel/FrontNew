<?php /* Template_ 2.2.8 2024/02/06 14:29:24 /home/barrel-qa/application/www.bak/assets/mobile_templet/mobile_enterprise/member/search_id/search_id.htm 000008834 */ ?>
<!-- 컨텐츠 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__find-user">
	<div class="page-title">
		<div class="title-md">아이디 찾기</div>
		<div class="page-title__sub">
			회원가입 시 등록한 정보로<br />
			아이디 찾기를 하실 수 있습니다.
		</div>
	</div>
	<div class="br-tab__wrap br__tabs">
		<div class="br-tab__nav-radio">
			<ul>
				<li>
					<label><input type="radio" name="searchType" data-type="phone" checked /><span>휴대폰 번호</span></label>
				</li>
				<li>
					<label><input type="radio" name="searchType" data-type="email" ><span>이메일</span></label>
				</li>
			</ul>
		</div>
		<div class="br-tab__contents-wrap">
			<!-- 휴대폰으로 아이디 찾기 -->
			<div class="br-tab__contents active">
				<div class="br__find-user__form br__find-user__form--phone br__find-user__form--show">
					<form id="devSearchPhoneForm">
						<div class="find-user">
							<div class="find-user__input">
								<label for="devUser" class="hidden">가입자 성함</label>
								<input type="text" name="devUser" id="devUser" placeholder="가입자 성함" title="가입자 성함">
							</div>
							<div class="find-user__input find-user__input__phone">
							<label for="devHp1" class="hidden">휴대폰번호</label>
								<select name="devHp1" id="devHp1" title="휴대폰번호">
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
								</select>
								<input type="text" name="devHp2" id="devHp2" title="휴대폰번호" value="" placeholder="0000" />
								<input type="text" name="devHp3" id="devHp3" title="휴대폰번호" value="" placeholder="0000" />
							</div>
							<div class="find-user__btn">
								<button class="btn-lg btn-dark-line find-user__btn__submit" id="devUserPhoneSubmitButton">아이디 찾기</button>
							</div>

							<!-- 안내(오류) 메시지 S -- 
							<div class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</div>
							<!-- 안내(오류) 메시지 E -->
						</div>
					</form>
				</div>
			</div>
			 <!-- EOD : 휴대폰으로 찾기 -->

			<!-- 이메일주소로 아이디 찾기 -->
			<div class="br-tab__contents">
				<div class="br__find-user__form br__find-user__form--email br__find-user__form--show">
					<form id="devSearchEmailForm">
						<div class="find-user">
							<div class="find-user__input">
								<label for="devUserName" class="hidden">가입자 성함</label>
								<input type="text" name="devUserName" id="devUserName" title="가입자 성함" value="" placeholder="가입자 성함" />
							</div>
							<div class="find-user__input find-user__input__email">
								<div class="br__form-group">
									<label for="devUserEmail1" class="hidden">이메일</label>
									<input type="text" name="devUserEmail1" id="devUserEmail1" class="find-user__input__email--id" title="이메일" value="" placeholder="이메일 아이디" />
									<input type="text" name="devUserEmail2" id="devUserEmail2" class="find-user__input__email--adress" title="이메일" value="" placeholder="이메일 도메인" />
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
							<div class="find-user__btn">
								<button class="btn-lg btn-dark-line find-user__btn__submit" id="devUserEmailSubmitButton">아이디 찾기</button>
							</div>

							<!-- 안내(오류) 메시지 S -- 
							<div class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</div>
							<!-- 안내(오류) 메시지 E -->
						</div>
					</form>
				</div>
			</div>
			 <!-- EOD : 이메일주소로 찾기 -->
		</div>
	</div>
	<div class="br__find-user__footer">
		<a href="/member/login" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<?php }else{?>
<section class="br__find-user">
	<div class="page-title">
		<div class="title-md">아이디 찾기</div>
		<div class="page-title__sub">
			회원가입 시 등록한 정보로<br />
			아이디 찾기를 하실 수 있습니다.
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
		<div class="br-tab__contents-wrap">
			<div class="br-tab__contents active">
				<div class="br__find-user__form br__find-user__form--phone br__find-user__form--show">
					<form id="devSearchPhoneForm">
						<div class="find-user">
							<div class="find-user__input">
								<label for="devUser" class="hidden">가입자 성함</label>
								<input type="text" name="devUser" id="devUser" title="가입자 성함" value="김배럴" placeholder="가입자 성함" />
							</div>
							<div class="find-user__input find-user__input__phone">
							<label for="devHp1" class="hidden">휴대폰번호</label>
							<select name="devHp1" id="devHp1" title="휴대폰번호">
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
								</select>
								<input type="text" name="devHp2" id="devHp2" title="휴대폰번호" value="1234" placeholder="0000" />
								<input type="text" name="devHp3" id="devHp3" title="휴대폰번호" value="1234" placeholder="0000" />
							</div>
							<div class="find-user__btn">
								<button class="btn-lg btn-dark-line find-user__btn__submit" id="devUserPhoneSubmitButton">아이디 찾기</button>
							</div>

							<!-- 안내(오류) 메시지 S -->
							<div class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</div>
							<!-- 안내(오류) 메시지 E -->
						</div>
					</form>
				</div>
			</div>
			<div class="br-tab__contents">
				<div class="br__find-user__form br__find-user__form--email br__find-user__form--show">
					<form>
						<div class="find-user">
							<div class="find-user__input">
								<label for="devUserName" class="hidden">가입자 성함</label>
								<input type="text" name="devUserName" id="devUserName" title="가입자 성함" value="김배럴" placeholder="가입자 성함" />
							</div>
							<div class="find-user__input find-user__input__email">
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
							<div class="find-user__btn">
								<button class="btn-lg btn-dark-line find-user__btn__submit" id="devUserEmailSubmitButton">아이디 찾기</button>
							</div>

							<!-- 안내(오류) 메시지 S -->
							<div class="txt-error">입력하신 정보에 해당하는 회원 정보를 찾을 수 없습니다.</div>
							<!-- 안내(오류) 메시지 E -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="br__find-user__footer">
		<a href="#;" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 E -->