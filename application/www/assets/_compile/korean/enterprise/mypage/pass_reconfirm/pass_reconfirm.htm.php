<?php /* Template_ 2.2.8 2023/12/14 15:21:51 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/pass_reconfirm/pass_reconfirm.htm 000002785 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage">
    <form id="devRevalidatePasswordForm">
	<div class="fb__mypage-title">
<?php if($TPL_VAR["passReconfirmType"]=='profile'){?>
        <div class="title-md">회원정보 수정</div>
<?php }else{?>
        <div class="title-md">회원탈퇴</div>
<?php }?>
	</div>
	<section class="wrap-profile-intro fb__pass-reconfirm">
		<div class="fb__pass-reconfirm__tit">
			<div class="title-sm">
				회원님의 개인정보 보호를 위해 비밀번호를<br />
				다시 한번 입력해 주시기 바랍니다.
			</div>
		</div>
		<div class="password-area">
			<div class="password-area__input-area">
				<div class="fb__form-item">
					<label for="devUserPassword" class="hide">비밀번호</label>
					<input type="password" name="pass" id="devUserPassword" class="fb__form-input" title="비밀번호" placeholder="비밀번호 입력" value="" />
					<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
				</div>
				<p class="txt-desc">영문 + 숫자 + 특수문자 조합 8~16자리 입력 필수.</p>
			</div>
		</div>

		<div class="wrap-btn-area fb__pass-footer">
			<input type="submit" value="확인" alt="확인" title="확인" class="btn-lg btn-dark-line" id="devPasswordSubmit" />
		</div>
	</section>
	</form>
</section>
<!-- 컨텐츠 E -->


<!--회원 수정 인트로 시작

<section class="wrap-mypage fb__mypage" id='check_pass_form'>

    <form id="devRevalidatePasswordForm">
<?php if($TPL_VAR["passReconfirmType"]=='profile'){?>
        <h2 class="fb__mypage__title">회원정보 수정</h2>
<?php }else{?>
        <h2 class="fb__mypage__title">회원탈퇴</h2>
<?php }?>

        <section class="wrap-profile-intro fb__pass-reconfirm">
            <h3 class="fb__pass-reconfirm__tit">비밀번호 재확인</h3>
            <p class="fb__pass-reconfirm__subtit">고객님의 개인정보 보호를 위해 비밀번호를 다시 입력해주시기 바랍니다.</p>

            <dl class="password-area">
                <dt class="password-area__tit">
                    비밀번호
                </dt>
                <dd class="password-area__input-area">
                    <input type="password" name="pass" value='' id="devUserPassword" title="비밀번호">
                </dd>
            </dl>
        </section>

        <div class="wrap-btn-area mat30">
            <input type="submit" value="확인" alt="확인" title="확인" class="btn-default btn-dark" id="devPasswordSubmit">
        </div>
    </form>
</section>

<!--회원 수정 인트로 끝-->