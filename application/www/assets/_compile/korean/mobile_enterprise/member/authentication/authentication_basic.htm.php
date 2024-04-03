<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/authentication/authentication_basic.htm 000001317 */ ?>
<h1 class="wrap-title">
    회원가입
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
    <p class="join-title-desc">본인인증 후 회원가입을 진행해 주시기 바랍니다.</p>
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