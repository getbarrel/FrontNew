<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_guide.htm 000001223 */ ?>
<h1 class="wrap-title">
    Notification for switching to dormant account
    <button class="back"></button>
</h1>

<div class="layout-padding wrap-sleep-guide">
    <h1 class="join-title"><?php echo $TPL_VAR["userName"]?> Notice to member</h1>

    <p class="desc">
        {=trans('정보통신망 이용 촉진 및 정보보호 등에 관한 법률에 따라,<br>
        최근 <?php echo $TPL_VAR["sleepYear"]?>년간 로그인 기록이 없는 회원님의 개인정보 보호를 위해<br>
        회원님의 정보를 <span>휴면 계정으로 전환</span>하였음을 알려드립니다.<br>
        <?php echo $TPL_VAR["mallName"]?> 로그인 및 관련 서비스 이용을 위해서<br>
        고객님의 휴면 계정을 해제해주세요.')}
    </p>

    <div class="wrap-btn-area mat100">
        <button class="btn-lg btn-point" id="devNextSleepMemberReleaseAuth">Cancellation for a dormant account</button>
    </div>
</div>


<div class="pub-m-wrap">
    <div class="element-area">


    </div>
</div>