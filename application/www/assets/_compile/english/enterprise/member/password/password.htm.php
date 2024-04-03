<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/password/password.htm 000008915 */ ?>
<!-- 1. 정기, 휴먼회원 비밀번호 수정-->
<?php if($TPL_VAR["changeType"]=='regular'||$TPL_VAR["changeType"]=='sleep'){?>
<section class="fb__password <?php if($TPL_VAR["changeType"]=='sleep'){?>fb__sleep-pw<?php }?>">
    <div class="password <?php if($TPL_VAR["changeType"]=='regular'){?>password<?php }?>">

<?php if($TPL_VAR["changeType"]=='regular'){?>
        <!--정기 비밀번호 수정-->
        <header class="password__header">
            <h2 class="password__header-title">Please change your password.</h2>
            <p class="password__header-summary">
                <?php echo $TPL_VAR["changePasswordDay"]?> days after changing the password.<br/>
                Please refer to the input method below to change the password.<br/>
                Regular password change helps you to protect your valuable persnal information.
            </p>
        </header>

<?php }elseif($TPL_VAR["changeType"]=='sleep'){?>
        <!--휴먼회원 비밀번호 수정-->
        <header class="password__header">
            <h2 class="password__header-title">Notification for switching to dormant account</h2>
            <ul class="step-box">
                <li class="step-box__list step-box__list--agreement">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number">STEP 01</span>
                        <p class="step-box__list__title">
                            Agree
                        </p>
                    </div>
                </li>
                <li class="step-box__list step-box__list--password">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number on">STEP 02</span>
                        <p class="step-box__list__title">
                            Change Password
                        </p>
                    </div>
                </li>
                <li class="step-box__list step-box__list--end">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number">STEP 03</span>
                        <p class="step-box__list__title">
                            Activate Account
                        </p>
                    </div>
                </li>
            </ul>
        </header>
<?php }else{?>
        <header class="password__header">
            <h2 class="password__header-title">Please change your password.</h2>
            <p class="password__header-summary">
                <?php echo $TPL_VAR["changePasswordDay"]?> days after changing the password.<br/>
                Please refer to the input method below to change your password.<br/>
                Regular password change helps you to protect your valuable persnal information.
            </p>
        </header>
<?php }?>
    </div>


    <div class="wrap-password-layout <?php if($TPL_VAR["changeType"]=='regular'){?>type02 <?php }elseif($TPL_VAR["changeType"]=='sleep'){?>sleep-type<?php }?>">
<?php if($TPL_VAR["changeType"]=='sleep'){?>
        <div class="sleep-subtitle-area">
            <div class="fb__sleep-complete__content">
                <p class="fb__sleep-complete__content--big">Please change your password.</p>
                <p class="fb__sleep-complete__content--small">
                    To release the dormant account, please change the password by referring to the input method below.
                </p>
            </div>
        </div>
<?php }?>

        <form id="devForm" class="js__pw__form fb__password__form">
            <div class="fb__password__form-inner" style="width:450px;">
                <div class="fb__password__input" >
                    <label class="fb__password__label" for="devUserPassword">New Password</label>
                    <input class="js__pw" type="password" name="pw" id="devUserPassword" title="New Password">
                    <p class="txt-error" devTailMsg="devUserPassword" style="margin-left:140px;"></p>
                </div>
                <div class="fb__password__input">
                    <label for="devUserPassword">Confrim New Password</label>
                    <input class="js__check__pw" type="password" id="devUserComparePassword" name="comparePw" title="Confrim New Password">
                    <p class="txt-error" devTailMsg="devUserComparePassword" style="margin-left:140px;"></p>
                    <p class="fb__password__desc">Two or more combinations of upper and lowercase letters, numbers and special charactiers. Minimum 8, max 16 characters.</p>
                </div>
            </div>

<?php if($TPL_VAR["changeType"]=='regular'){?>
            <div class="fb__sleep__btn">
                <button class="fb__sleep__btn--black" id="devContinueButton"><?php echo $TPL_VAR["changePasswordContinueDay"]?> days later.</button>
                <button class="fb__sleep__btn--point" id="devSubmitButton">Change Password</button>
            </div>
<?php }elseif($TPL_VAR["changeType"]=='sleep'){?>
            <div class="fb__sleep__btn">
                <!--<button class="btn-lg btn-point" id="devSubmitButton">30 days later.</button>-->
                <button class="fb__sleep__btn--black" id="devSubmitButton">Cancel</button>
                <button class="fb__sleep__btn--point" id="devSubmitButton">Accept</button>
            </div>
<?php }else{?>
            <div class="fb__sleep__btn">
                <button class="fb__sleep__btn--black" id="devSubmitButton">30 days later.</button>
                <button class="fb__sleep__btn--point" id="">Change Password</button>
            </div>
<?php }?>
        </form>
    </div>
</section>
<?php }else{?>






<!-- 비밀번호 찾기 -->
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">Forgot ID/PW</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchIdResult" class="fb__tab-link">
                ID
            </a>
            <a href="/member/password" class="fb__tab-link fb__tab-link--active">
                Password
            </a>
        </nav>
        <!-- [S] 패스워드 변경 성공 -->
        <section class="fb__password-reset">

            <div id="search__id" class="search__content search__content">
                <strong><?php echo $TPL_VAR["userName"]?> your password has been changed successfully</strong>
                <p>Now all services of Barrel are available with your account.</p>
                <p>Please give a lot of support to us.</p>
                <div class="search__other-link">
                    <a href="/" class="button-black">Home</a>
                    <a href="/member/login">Sign in</a>
                </div>
            </div>
            <!-- [E] 패스워드 변경 성공 -->

            <div id="search__password" class="search__content search__content--show">
                <header class="fb__password-reset__header">
                    <h2 class="fb__password-reset__title">Reset password</h2>
                    <p class="fb__password-reset__summary">
                        Please reset your password,<br/>
                    </p>
                </header>
                <form id="devForm" class="fb__password__form">
                    <div class="fb__password__form-inner" style="width:450px;">
                        <div class="fb__password__input" >
                            <label class="fb__password__label" for="devUserPassword">New Password</label>
                            <input type="password" name="pw" id="devUserPassword" title="New Password">
                            <p class="txt-error" devTailMsg="devUserPassword" style="margin-left:140px;"></p>
                        </div>
                        <div class="fb__password__input">
                            <label for="devUserComparePassword">Confrim New Password</label>
                            <input class="js__check__pw" type="password" id="devUserComparePassword" name="comparePw" title="Confrim New Password">
                            <p class="fb__password__error txt-error" devTailMsg="devUserComparePassword"  style="margin-left:140px;"></p>
                            <p class="fb__password__desc">Two or more combinations of upper and lowercase letters, numbers and special charactiers. Minimum 8, max 16 characters.</p>
                        </div>
                    </div>

                    <div class="fb__sleep__btn">
                        <button class="fb__sleep__btn--point" id="devSubmitButton">Accept</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>


<?php }?>