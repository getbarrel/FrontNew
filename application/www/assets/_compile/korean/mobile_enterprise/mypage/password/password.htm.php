<?php /* Template_ 2.2.8 2023/07/18 10:19:58 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/password/password.htm 000001478 */ ?>
<div class="br__password__pop">
    <form id="devPmComparePasswordForm">
        <div class="pw_tit">새로운 비밀번호를 입력해 주세요.</div>
        <dl class="password__change">
            <dd>
                <input class="" type="password" name="pw" id="devPmPassword" title="새 비밀번호" placeholder="새로운 비밀번호를 입력해 주세요.">
                <p class="txt-error" devTailMsg="devPmPassword"></p>
            </dd>
        </dl>

        <dl class="password__change">
            <dd>
                <input type="password" name="comparePw" id="devPmComparePassword" title="새 비밀번호 확인" placeholder="새로운 비밀번호를 다시 한번 입력해 주세요.">
                <p class="txt-error" devTailMsg="devPmComparePassword"></p>
            </dd>
        </dl>

        <div class="password__txt">영문 대소문자/숫자/특수문자 중 2가지 이상 조합,<br>최소 8자~최대 16자 입력</div>


        <div class="br__login__info">
            <div class="information__btn">
                <button type="button" class="information__btn__login" id="devPmSubmit">확인</button>
                <button type="button" class="information__btn__join" id="devPmCancel">취소</button>
            </div>
        </div>

    </form>
</div>