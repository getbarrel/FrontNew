<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/authentication/authentication_basic.htm 000002485 */ ?>
<section class="fb__join-member">

    <h2 class="fb__join-member__title">Join</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01 top-area__step--active">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
                <p class="top-area__step__tit">Identity verification</p>
            </div>
        </li>
        <li class="top-area__step top-area__step02">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 02</span>
                <p class="top-area__step__tit">Agree</p>
            </div>
        </li>
        <li class="top-area__step top-area__step03">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 03</span>
                <p class="top-area__step__tit">Enter Information</p>
            </div>
        </li>
        <li class="top-area__step top-area__step04">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 04</span>
                <p class="top-area__step__tit">Welcome!</p>
            </div>
        </li>
    </ul>

    <section class="fb__authentication__certify">
        <p class="fb__authentication__des">You need to confirm your identity to protect your personal information. <br/>Select the authentication method you want.</p>
<?php if($TPL_VAR["useCertify"]){?>
        <div class="certify-box">
            <p class="certify-box__title phone">Verify with mobile.</p>
            <p class="certify-box__des">Authenticate with your own mobile phone.</p>
            <a href="#" class="certify-box__btn" id="devCertifyButton">Certification</a>
        </div>
<?php }?>
<?php if($TPL_VAR["useIpin"]){?>
       <div class="certify-box">
           <p class="certify-box__title ipin">Verify with i-pin.</p>
           <p class="certify-box__des">You can authenticate with your ipin ID and password.</p>
           <a href="#" class="certify-box__btn" id="devIpinButton">Certification</a>
       </div>
<?php }?>
    </section>


    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">Cancel</button>
    </div>


</section>