<?php /* Template_ 2.2.8 2024/02/16 10:13:11 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/pass_reconfirm/pass_reconfirm.htm 000004400 */ ?>
<!-- 컨텐츠 S -->
<?php if($TPL_VAR["passReconfirmType"]=='profile'){?>
<section class="br__mypage">
	<div class="br__mypage__pass">
		<div class="page-title my-title">
			<div class="title-sm">회원정보 수정</div>
			<div class="page-title__sub">회원님의 개인정보 보호를 위해 비밀번호를<br />다시 한번 입력해 주시기 바랍니다.</div>
		</div>
		<form id="devRevalidatePasswordForm">
			<div class="pass-box">
				<div class="pass-box__input">
					<label for="devUserPassword" class="hidden">비밀번호</label>
					<input type="password" name="pass" id="devUserPassword" class="br__form-input" title="비밀번호" placeholder="비밀번호 입력" value="" />
					<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
				</div>
				<p class="txt-desc">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>
				<div class="pass-box__btn">
					<input type="submit" value="확인" title="확인" class="btn-lg btn-dark-line pass-box__btn__login" id="devPasswordSubmit" />
				</div>
			</div>
		</form>
	</div>
</section>
<?php }else{?>
<section class="br__mypage">
	<div class="br__mypage__pass">
		<div class="page-title my-title">
			<div class="title-sm">회원정보 수정</div>
			<div class="page-title__sub">회원님의 개인정보 보호를 위해 비밀번호를<br />다시 한번 입력해 주시기 바랍니다.</div>
		</div>
		<form>
			<div class="pass-box">
				<div class="pass-box__input">
					<label for="devUserPassword" class="hidden">비밀번호</label>
					<input type="password" name="pass" id="devUserPassword" class="br__form-input" title="비밀번호" placeholder="비밀번호 입력" value="" />
					<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
				</div>
				<p class="txt-desc">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>
				<div class="pass-box__btn">
					<input type="submit" value="확인" title="확인" class="btn-lg btn-dark-line pass-box__btn__login" id="devPasswordSubmit" />
				</div>
			</div>
		</form>
	</div>
</section>
<?php }?>
<!-- 컨텐츠 E -->


<!--<h1 class="wrap-title">
    회원정보 수정
    <button class="back"></button>
</h1>-->

<!-- 비밀번호 재확인 -- 
<section class="br__mypage">
    <div class="br__mypage__pass">
        <p class="pass-title">비밀번호 재확인</p>
        <p class="pass-subtitle">고객님의 개인정보보호를 위해 <br>비밀번호를 다시 입력해주시기 바랍니다.</p>
        <form id="devRevalidatePasswordForm">
            <div class="pass-box">
                <input type="password" class="pass-input" placeholder="비밀번호" name="pass" value="" title="비밀번호" id="devUserPassword"/>
            </div>
            <div class="br__login__info">
                <div class="information__btn">
                    <input class="information__btn__login" type="submit" value="확인" title="확인" class="btn-lg btn-point" id="devPasswordSubmit" />
                    <a href="/mypage/" class="information__btn__join" id="" >취소</a>
                </div>
            </div>
        </form>
    </div>
</section>
 


<!-- 회원탈퇴 -- 
<section class="br__mypage">
    <div class="br__mypage__pass">
        <p class="pass-title">비밀번호 재확인</p>
        <p class="pass-subtitle">고객님의 개인정보보호를 위해 <br>비밀번호를 다시 입력해주시기 바랍니다.</p>
        <form id="devRevalidatePasswordForm">
            <div class="pass-box">
                <input type="password" class="pass-input" placeholder="비밀번호" name="pass" value="" id="devUserPassword" title="=trans('비밀번호')}"/>
            </div>
            <div class="br__login__info">
                <div class="information__btn">
                    <input class="information__btn__nomem" type="submit" value="확인" title="확인" id="devPasswordSubmit" />
                    <p class="txt-error" devtailmsg=""></p>
                </div>
            </div>
        </form>
    </div>
</section>

-->