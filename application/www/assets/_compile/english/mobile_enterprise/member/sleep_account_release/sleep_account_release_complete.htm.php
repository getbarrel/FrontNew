<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_complete.htm 000001943 */ ?>
<!-- 계정 활성화 -->
<section class="br__join br__sleep br__account">
    <p class="br__account__title">Activate Account</p>
    <p class="br__account__title-info">Your account is <br/> activated.</p>
    <p class="br__account__title-sub">
        Sign in with your account to access all of <?php echo $TPL_VAR["mallName"]?> &#39;s services. <br/> Thank you for your continued use and interest.
    </p>

    <div class="br__login__info">
        <div class="br__login br__login--show br__change">
            <div class="information__btn">
                <a href="/" class="information__btn__change">Home</a>
                <a href="/mypage/" class="information__btn__month" >Sign in</a>
            </div>
        </div>
    </div>
</section>
<!-- EOD : 계정 활성화 -->

<?php if(false){?>
<h1 class="wrap-title">
    Notification for switching to dormant account
    <button class="back"></button>
</h1>

<div class="wrap-step">
    <p>Activate Account</p>
    <ul class="step">
        <li class="">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="on">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>

<div class="layout-padding wrap-join-end">
    <h1 class="join-title">Your <?php echo $TPL_VAR["userName"]?> <br> <span> account has been activated </ span>.</h1>

    <p class="desc">
        {=trans('해당 계정으로 로그인하시면 <?php echo $TPL_VAR["mallName"]?>의 <br>
        모든 서비스를 이용하실 수 있습니다.<br>
        앞으로도 많은 이용과 관심 부탁드립니다.')}
    </p>

    <div class="wrap-btn-area mat130">
        <button class="btn-lg btn-point" id="devSleepMemberReleaseComplete">Go Shopping</button>
    </div>
</div>
<?php }?>