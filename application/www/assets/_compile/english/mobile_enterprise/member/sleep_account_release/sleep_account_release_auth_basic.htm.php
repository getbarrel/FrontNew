<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_auth_basic.htm 000002802 */ ?>
<h1 class="wrap-title">
    Notification for switching to dormant account
    <button class="back"></button>
</h1>

<div class="wrap-step">
    <p>Identity verification</p>
    <ul class="step">
        <li class="on">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>


<div class="layout-padding wrap-join-auth-basic">
    <p class="join-title-desc">Please proceed to verify your identity to unlock your dormant account.</p>
    <div class="wrap-box mat20">
<?php if($TPL_VAR["useCertify"]){?>
        <div class="inner-box" id="devCertifyButton">
            <p class="auth01">Verify with mobile.</p>
            <span>You can authenticate <br> with your mobile phone.</span>
        </div>
<?php }?>
<?php if($TPL_VAR["useIpin"]){?>
        <div class="inner-box" id="devIpinButton">
            <p class="auth02">Verify with i-pin.</p>
            <span>You can authenticate with iPIN ID and password.</span>
        </div>
<?php }?>
    </div>

    <div class="wrap-btn-area mat100">
        <button class="btn-lg btn-dark-line" id="devCancelButton">Cancel</button>
    </div>

</div>

<!-- 2019.07.11 90일 이후 비밀번호 변경 -->
<section class="br__login br__login--show br__change" style="display:none;">
    <h2 class="br__change__title">Please change your password.</h2>
    <p class="change__sub">비밀번호를 변경한지 90일이 지난 경우<br/>아래 입력 방법을 참고하여 비밀번호를<br/>변경해 주시기 바랍니다.</p>
    <p class="change__sub">정기적인 비밀번호 변경은 회원님의<br/>소중한 개인정보를 보호할 수 있습니다.</p>
    <form>
        <div class="br__login__info">
            <div class="information__input">
                <input type="password" placeholder="New Password">
            </div>

            <div class="information__input">
                <input type="password" placeholder="Confrim New Password">
                <p class="txt-error" devTailMsg="">Password doesn&#39;t match.</p>
                <p class="join_info-txt">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="">Resend after 30 days</button>
                <button class="information__btn__month" id="">Change Password</button>
            </div>
        </div>
    </form>
</section>
<!-- EOD : 2019.07.11 90일 이후 비밀번호 변경 -->