<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/pass_reconfirm/pass_reconfirm.htm 000002194 */ ?>
<!--<h1 class="wrap-title">
    회원정보 수정
    <button class="back"></button>
</h1>-->
<?php if($TPL_VAR["passReconfirmType"]=='profile'){?>
<!-- 비밀번호 재확인 -->
<section class="br__mypage">
    <div class="br__mypage__pass">
        <p class="pass-title">Confirm Password</p>
        <p class="pass-subtitle">Please enter your <br>password again to protect your personal information.</p>
        <form id="devRevalidatePasswordForm">
            <div class="pass-box">
                <input type="password" class="pass-input" placeholder="Password" name="pass" value="" title="Password" id="devUserPassword"/>
            </div>
            <div class="br__login__info">
                <div class="information__btn">
                    <input class="information__btn__login" type="submit" value="Accept" title="Accept" class="btn-lg btn-point" id="devPasswordSubmit" />
                    <a href="/mypage/" class="information__btn__join" id="" >Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- EOD : 비밀번호 재확인 -->
<?php }else{?>

<!-- 회원탈퇴 -->
<section class="br__mypage">
    <div class="br__mypage__pass">
        <p class="pass-title">Confirm Password</p>
        <p class="pass-subtitle">Please enter your <br>password again to protect your personal information.</p>
        <form id="devRevalidatePasswordForm">
            <div class="pass-box">
                <input type="password" class="pass-input" placeholder="Password" name="pass" value="" id="devUserPassword" title="=trans('비밀번호')}"/>
            </div>
            <div class="br__login__info">
                <div class="information__btn">
                    <input class="information__btn__nomem" type="submit" value="Accept" title="Accept" id="devPasswordSubmit" />
                    <p class="txt-error" devtailmsg=""></p>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- EOD : 회원탈퇴 -->
<?php }?>