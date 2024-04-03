<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/password/password.htm 000006301 */ ?>
<?php if($TPL_VAR["changeType"]=='sleep'){?>
<!-- 휴면 회원 해제 처리 시 최종 비밀번호 변경 -->
<section class="br__join br__sleep">
    <p class="br__sleep__title">Please change your password.</p>
    <p class="br__sleep__sub-title">
        To release the dormant account, please change the password by referring to the input method below.
    </p>
    <form id="devForm">
        <div class="br__login__info br__sleep__info">
            <div class="information__input">
                <input type="password" name="pw"  placeholder="New Password" id="devUserPassword" title="새 비밀번호 확인">
            </div>

            <div class="information__input">
                <input type="password" name="comparePw"  placeholder="Confrim New Password" id="devUserComparePassword" title="새 비밀번호 확인">
                <p class="txt-error" devTailMsg="notMatched"></p>
                <p class="join_info-txt">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
                <p class="join_info-txt">(Please use only @#$%()_+~ for special characters.)</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="devSleepCancelButton">Cancel</button>
                <button class="information__btn__month" id="devSubmitButton">Accept</button>
            </div>
        </div>

        <!-- EOD : 이용약관 -->
    </form>
</section>
<!-- EOD : 휴면 회원 비밀번호 변경 -->

<?php }elseif($TPL_VAR["changeType"]=='regular'){?>
<!-- [S] 90일 이후 휴면계정 비밀번호 변경 안내 -->
<section class="br__login br__login--show br__change">
    <h2 class="br__change__title">Please change your password.</h2>
    <p class="change__sub">If the password has been changed 90 days, <br/>please change it by referring to the method below<br/></p>
    <p class="change__sub">Change password regulary can protect your privacy.</p>
    <form id="devForm">
        <div class="br__login__info">
            <div class="information__input">
                <input type="password" name="pw" id="devUserPassword" placeholder="New Password" >
            </div>

            <div class="information__input">
                <input type="password" name="comparePw" id="devUserComparePassword" placeholder="Confrim New Password">
                <p class="txt-error" devTailMsg="notMatched"></p>
                <p class="join_info-txt">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
                <p class="join_info-txt">(Please use only @#$%()_+~ for special characters.)</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="devContinueButton"><?php echo $TPL_VAR["changePasswordContinueDay"]?> days later.</button>
                <button class="information__btn__month" id="devSubmitButton">Change Password</button>
            </div>
        </div>
    </form>
</section>
<!-- [E] 90일 이후 휴면계정 비밀번호 변경 안내 -->


<?php }else{?>
<section class="br__find-user br__password">
<?php if($TPL_VAR["langType"]=='korean'){?>
    <h2 class="br__find-user__title">ID/PW 찾기</h2>
<?php }else{?>
    <h2 class="br__find-user__title">Forgot ID/PW</h2>
<?php }?>
    <form id="devForm">
        <div class="br__tabs">
            <ul class="br__tabs__list">
                <li class="br__tabs__box">
                    <a href="/member/searchId" class="br__tabs__btn">ID</a>
                </li>
                <li class="br__tabs__box">
                    <a href="/member/searchPw" class="br__tabs__btn br__tabs__btn--active">Password</a>
                </li>
            </ul>
            <div class="br__tabs__content">
                <h3 class="br__password__title">Reset password</h3>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <p class="br__password__desc">Please reset your password.</p>
<?php }else{?>
                <p class="br__password__desc">Please reset your password.</p>
<?php }?>
                <div class="find-user">
                    <div class="find-user__input">
                        <input type="password" name="pw" id="devUserPassword" title="Password" placeholder="Password">
                    </div>
                    <div class="find-user__input">
                        <input type="password" name="comparePw" id="devUserComparePassword" title="Confrim New Password" placeholder="Confrim New Password">
                        <p class="find-user__input__error" devTailMsg="devUserComparePassword"></p>
                    </div>
                    <p class="find-user__notice">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
                    <p class="find-user__notice">(Please use only @#$%()_+~ for special characters.)</p>
                    <div class="find-user__btn">
                        <button class="find-user__btn__submit" id="devSubmitButton">Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<!-- [S] 패스워드 변경 성공 -->
<section class="br__find-user br__password" style="display:none;">
    <div class="br__tabs">
        <div class="br__complate">
            <p class="br__complate-title"><?php echo $TPL_VAR["userName"]?> your password<br/>has been changed successfully .</p>
            <p class="br__complate-sub">You can access all services of BARREL <br/>by logging in to the account. Do not miss any updates of BARREL <br/>.</p>
            <div class="br__login__info">
                <div class="information__btn">
                    <a href="/" class="information__btn__change" id="">Home</a>
                    <a href="/mypage/" class="information__btn__month" id="">Sign in</a>
                </div>
            </div>
         </div>
    </div>
</section>
<!-- [E] 패스워드 변경 성공 -->

<?php }?>