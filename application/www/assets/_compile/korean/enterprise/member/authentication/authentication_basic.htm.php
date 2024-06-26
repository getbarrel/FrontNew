<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/authentication/authentication_basic.htm 000002541 */ ?>
<section class="fb__join-member">

    <h2 class="fb__join-member__title">회원가입</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01 top-area__step--active">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
                <p class="top-area__step__tit">본인인증</p>
            </div>
        </li>
        <li class="top-area__step top-area__step02">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 02</span>
                <p class="top-area__step__tit">약관동의</p>
            </div>
        </li>
        <li class="top-area__step top-area__step03">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 03</span>
                <p class="top-area__step__tit">정보입력</p>
            </div>
        </li>
        <li class="top-area__step top-area__step04">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 04</span>
                <p class="top-area__step__tit">가입완료</p>
            </div>
        </li>
    </ul>

    <section class="fb__authentication__certify">
        <p class="fb__authentication__des">회원님의 개인정보 보호를 위해 본인확인이 필요합니다. <br/>원하시는 본인인증 방법을 선택해 주세요.</p>
<?php if($TPL_VAR["useCertify"]){?>
        <div class="certify-box">
            <p class="certify-box__title phone">휴대폰 인증</p>
            <p class="certify-box__des">본인 명의의 휴대폰으로 인증하실 수 있습니다.</p>
            <a href="#" class="certify-box__btn" id="devCertifyButton">인증하기</a>
        </div>
<?php }?>
<?php if($TPL_VAR["useIpin"]){?>
       <div class="certify-box">
           <p class="certify-box__title ipin">아이핀 인증</p>
           <p class="certify-box__des">아이핀 아이디와 비밀번호로 인증하실 수 있습니다.</p>
           <a href="#" class="certify-box__btn" id="devIpinButton">인증하기</a>
       </div>
<?php }?>
    </section>


    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
    </div>


</section>