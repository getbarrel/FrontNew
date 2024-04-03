<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_auth_basic.htm 000002857 */ ?>
<h1 class="wrap-title">
    휴면 계정 전환 안내
    <button class="back"></button>
</h1>

<div class="wrap-step">
    <p>본인인증</p>
    <ul class="step">
        <li class="on">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>


<div class="layout-padding wrap-join-auth-basic">
    <p class="join-title-desc">휴면 계정 해제를 위해<br> 본인인증을 진행해 주시기 바랍니다.</p>
    <div class="wrap-box mat20">
<?php if($TPL_VAR["useCertify"]){?>
        <div class="inner-box" id="devCertifyButton">
            <p class="auth01">휴대폰 인증</p>
            <span>본인 명의의 휴대폰으로<br> 인증하실 수 있습니다.</span>
        </div>
<?php }?>
<?php if($TPL_VAR["useIpin"]){?>
        <div class="inner-box" id="devIpinButton">
            <p class="auth02">아이핀 인증</p>
            <span>아이핀 아이디와 비밀번호로<br> 인증하실 수 있습니다.</span>
        </div>
<?php }?>
    </div>

    <div class="wrap-btn-area mat100">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
    </div>

</div>

<!-- 2019.07.11 90일 이후 비밀번호 변경 -->
<section class="br__login br__login--show br__change" style="display:none;">
    <h2 class="br__change__title">회원님의 비밀번호를 변경해 주세요.</h2>
    <p class="change__sub">비밀번호를 변경한지 90일이 지난 경우<br/>아래 입력 방법을 참고하여 비밀번호를<br/>변경해 주시기 바랍니다.</p>
    <p class="change__sub">정기적인 비밀번호 변경은 회원님의<br/>소중한 개인정보를 보호할 수 있습니다.</p>
    <form>
        <div class="br__login__info">
            <div class="information__input">
                <input type="password" placeholder="새 비밀번호">
            </div>

            <div class="information__input">
                <input type="password" placeholder="새 비밀번호 확인">
                <p class="txt-error" devTailMsg="">비밀번호가 일치하지 않습니다.</p>
                <p class="join_info-txt">영문 대소문자/숫자/특수문자 중 2가지 이상 조합,<br/>최소 8자~최대 16자 입력.</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="">30일 후 재알림</button>
                <button class="information__btn__month" id="">비밀번호 변경</button>
            </div>
        </div>
    </form>
</section>
<!-- EOD : 2019.07.11 90일 이후 비밀번호 변경 -->