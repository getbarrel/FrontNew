<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_guide.htm 000001537 */ ?>
<section class="wrap-member fb__sleep-account-area">
    <h2 class="fb__sleep-account-area__title">Notification for switching to dormant account</h2>
    <p class="fb__sleep-account-area__annc"><?php echo $TPL_VAR["mallName"]?> Please release your dormant account to log in and use related services.</p>

    <div class="sleep-guide-layout">
        <p><?php echo $TPL_VAR["userName"]?> Notice to member</p>
        <p>
            <?php echo trans('정보통신망 이용 촉진 및 정보보호 등에 관한 법률에 따라,<br>
            최근')?> <?php echo $TPL_VAR["sleepYear"]?><?php echo trans('년간 로그인 기록이 없는 회원님의 개인 정보 보호를 위해 회원님의 정보를<br>
            <span class="fb__point-color">휴면 계정으로 전환</span>하였음을 알려드립니다.')?><br>
        </p>

        <div class="wrap-btn-area member">
            <button class="btn-lg fb__btn-point" id="devNextSleepMemberReleaseAuth">Cancellation for a dormant account</button>
        </div>


        <div class="wrap-guide-box">
            <p>
                Please contact customer service team for <?php echo $TPL_VAR["mallName"]?> Inquiry<br>
                Email : <?php echo $TPL_VAR["mallEmail"]?> <i></i> CS Center : <?php echo $TPL_VAR["csPhone"]?>

            </p>
        </div>
    </div>

</section>