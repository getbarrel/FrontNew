<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_complete.htm 000002051 */ ?>
<!-- 계정 활성화 -->
<section class="br__join br__sleep br__account">
    <p class="br__account__title">계정 활성화</p>
    <p class="br__account__title-info"><?php echo $TPL_VAR["userName"]?> 회원님의 계정이<br/>활성화 되었습니다.</p>
    <p class="br__account__title-sub">
        해당 계정으로 로그인하시면 <?php echo $TPL_VAR["mallName"]?>의<br/>모든 서비스를 이용하실 수 있습니다.<br/>앞으로도 많은 이용과 관심 부탁드립니다.
    </p>

    <div class="br__login__info">
        <div class="br__login br__login--show br__change">
            <div class="information__btn">
                <a href="/" class="information__btn__change">홈으로</a>
                <a href="/mypage/" class="information__btn__month" >로그인</a>
            </div>
        </div>
    </div>
</section>
<!-- EOD : 계정 활성화 -->

<?php if(false){?>
<h1 class="wrap-title">
    휴면 계정 전환 안내
    <button class="back"></button>
</h1>

<div class="wrap-step">
    <p>계정 활성화</p>
    <ul class="step">
        <li class="">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="on">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>

<div class="layout-padding wrap-join-end">
    <h1 class="join-title"><?php echo $TPL_VAR["userName"]?> 회원님의<br><span>계정이 활성화</span>되었습니다.</h1>

    <p class="desc">
        {=trans('해당 계정으로 로그인하시면 <?php echo $TPL_VAR["mallName"]?>의 <br>
        모든 서비스를 이용하실 수 있습니다.<br>
        앞으로도 많은 이용과 관심 부탁드립니다.')}
    </p>

    <div class="wrap-btn-area mat130">
        <button class="btn-lg btn-point" id="devSleepMemberReleaseComplete">쇼핑 시작하기</button>
    </div>
</div>
<?php }?>