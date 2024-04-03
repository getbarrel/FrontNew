<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/authentication/authentication_company.htm 000003379 */ ?>
<section class="fb__join-member">

    <h2 class="fb__join-member__title">Join</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01 top-area__step--active">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
                <p class="top-area__step__tit">Verification for Business holder</p>
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

    <div class="wrap-joininput-layout fb__authentication__company">
        <div class="wrap-line-box">
            <form id="devCompanyForm">

                <ul class="authentication-company">
                    <li class="authentication-company__list">
                        <span class="authentication-company__title">
                            Business Name
                        </span>
                        <div class="authentication-company__cont">
                            <input type="text" id="devComName" name="comName" title="상호명">
                            <p class="txt-error" devTailMsg="devComName"></p>
                        </div>
                    </li>
                    <li class="authentication-company__list">
                        <span class="authentication-company__title">
                            Business registration number
                        </span>
                        <div class="authentication-company__cont authentication-company__cont-num">
                            <input type="number" name="comNumber1" id="devComNumber1" title="사업자등록번호">
                            <span>-</span>
                            <input type="number" name="comNumber2" id="devComNumber2" title="사업자등록번호">
                            <span>-</span>
                            <input type="number" name="comNumber3" id="devComNumber3" title="사업자등록번호">
                            <p class="txt-error" devTailMsg="devComNumber1 devComNumber2 devComNumber3"></p>
                        </div>
                    </li>
                </ul>

            </form>
        </div>
    </div>



    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">Cancel</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">Business license confirm</button>
    </div>
</section>