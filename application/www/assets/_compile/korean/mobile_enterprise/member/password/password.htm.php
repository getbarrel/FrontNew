<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/password/password.htm 000006640 */ ?>
<?php if($TPL_VAR["changeType"]=='sleep'){?>
<!-- 휴면 회원 해제 처리 시 최종 비밀번호 변경 -->
<section class="br__join br__sleep">
    <p class="br__sleep__title">회원님의 비밀번호를 변경해 주세요.</p>
    <p class="br__sleep__sub-title">
        휴면계정 해제를 위해서는 아래 입력 방법을<br/>참고하여 비밀번호를 변경해 주시기 바랍니다.
    </p>
    <form id="devForm">
        <div class="br__login__info br__sleep__info">
            <div class="information__input">
                <input type="password" name="pw"  placeholder="새 비밀번호" id="devUserPassword" title="새 비밀번호 확인">
            </div>

            <div class="information__input">
                <input type="password" name="comparePw"  placeholder="새 비밀번호 확인" id="devUserComparePassword" title="새 비밀번호 확인">
                <p class="txt-error" devTailMsg="notMatched"></p>
                <p class="join_info-txt">영문 대소문자/숫자/특수문자 중 2가지 이상 조합,<br>최소 8자~최대 16자 입력.</p>
                <p class="join_info-txt">(특수문자는 @#$%^&*()_+~ 만 사용해 주세요.)</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="devSleepCancelButton">취소</button>
                <button class="information__btn__month" id="devSubmitButton">확인</button>
            </div>
        </div>

        <!-- EOD : 이용약관 -->
    </form>
</section>
<!-- EOD : 휴면 회원 비밀번호 변경 -->

<?php }elseif($TPL_VAR["changeType"]=='regular'){?>
<!-- [S] 90일 이후 휴면계정 비밀번호 변경 안내 -->
<section class="br__login br__login--show br__change">
    <h2 class="br__change__title">회원님의 비밀번호를 변경해 주세요.</h2>
    <p class="change__sub">비밀번호를 변경한지 <?php echo $TPL_VAR["changePasswordDay"]?>일이 지난 경우<br/>아래 입력 방법을 참고하여 비밀번호를<br/>변경해 주시기 바랍니다.</p>
    <p class="change__sub">정기적인 비밀번호 변경은 회원님의<br/>소중한 개인정보를 보호할 수 있습니다.</p>
    <form id="devForm">
        <div class="br__login__info">
            <div class="information__input">
                <input type="password" name="pw" id="devUserPassword" placeholder="새 비밀번호" >
            </div>

            <div class="information__input">
                <input type="password" name="comparePw" id="devUserComparePassword" placeholder="새 비밀번호 확인">
                <p class="txt-error" devTailMsg="notMatched"></p>
                <p class="join_info-txt">영문 대소문자/숫자/특수문자 중 2가지 이상 조합,<br/>최소 8자~최대 16자 입력.</p>
                <p class="join_info-txt">(특수문자는 @#$%^&*()_+~ 만 사용해 주세요.)</p>
            </div>

            <div class="information__btn">
                <button class="information__btn__change"id="devContinueButton"><?php echo $TPL_VAR["changePasswordContinueDay"]?>일 후 재알림</button>
                <button class="information__btn__month" id="devSubmitButton">비밀번호 변경</button>
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
                    <a href="/member/searchId" class="br__tabs__btn">아이디</a>
                </li>
                <li class="br__tabs__box">
                    <a href="/member/searchPw" class="br__tabs__btn br__tabs__btn--active">비밀번호</a>
                </li>
            </ul>
            <div class="br__tabs__content">
                <h3 class="br__password__title">비밀번호 재설정</h3>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <p class="br__password__desc">회원님의 계정 비밀번호를 재설정해주세요.</p>
<?php }else{?>
                <p class="br__password__desc">Please reset your password.</p>
<?php }?>
                <div class="find-user">
                    <div class="find-user__input">
                        <input type="password" name="pw" id="devUserPassword" title="비밀번호" placeholder="비밀번호">
                    </div>
                    <div class="find-user__input">
                        <input type="password" name="comparePw" id="devUserComparePassword" title="새 비밀번호 확인" placeholder="새 비밀번호 확인">
                        <p class="find-user__input__error" devTailMsg="devUserComparePassword"></p>
                    </div>
                    <p class="find-user__notice">영문 대소문자/숫자/특수문자 중 2가지 이상 조합, <br>최소 8자 ~ 최대 16자 입력</p>
                    <p class="find-user__notice">(특수문자는 @#$%^&*()_+~ 만 사용해 주세요.)</p>
                    <div class="find-user__btn">
                        <button class="find-user__btn__submit" id="devSubmitButton">확인</button>
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
            <p class="br__complate-title"><?php echo $TPL_VAR["userName"]?> 회원님의 비밀번호가<br/>성공적으로 변경되었습니다.</p>
            <p class="br__complate-sub">해당 계정으로 로그인하시면 배럴의<br/>모든 서비스를 이용하실 수 있습니다.<br/>앞으로도 많은 이용과 관심 부탁드립니다.</p>
            <div class="br__login__info">
                <div class="information__btn">
                    <a href="/" class="information__btn__change" id="">홈으로</a>
                    <a href="/mypage/" class="information__btn__month" id="">로그인</a>
                </div>
            </div>
         </div>
    </div>
</section>
<!-- [E] 패스워드 변경 성공 -->

<?php }?>