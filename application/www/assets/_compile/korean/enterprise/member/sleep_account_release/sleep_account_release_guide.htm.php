<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_guide.htm 000001559 */ ?>
<section class="wrap-member fb__sleep-account-area">
    <h2 class="fb__sleep-account-area__title">휴면 계정 전환 안내</h2>
    <p class="fb__sleep-account-area__annc"><?php echo $TPL_VAR["mallName"]?> 로그인 및 관련 서비스 이용을 위해서 회원님의 휴면 계정을 해제해주세요.</p>

    <div class="sleep-guide-layout">
        <p><?php echo $TPL_VAR["userName"]?> 회원님께 알려드립니다.</p>
        <p>
            <?php echo trans('정보통신망 이용 촉진 및 정보보호 등에 관한 법률에 따라,<br>
            최근')?> <?php echo $TPL_VAR["sleepYear"]?><?php echo trans('년간 로그인 기록이 없는 회원님의 개인 정보 보호를 위해 회원님의 정보를<br>
            <span class="fb__point-color">휴면 계정으로 전환</span>하였음을 알려드립니다.')?><br>
        </p>

        <div class="wrap-btn-area member">
            <button class="btn-lg fb__btn-point" id="devNextSleepMemberReleaseAuth">휴면 계정 해제</button>
        </div>


        <div class="wrap-guide-box">
            <p>
                문의 사항은 <?php echo $TPL_VAR["mallName"]?> 고객센터로 문의 바랍니다.<br>
                메일 : <?php echo $TPL_VAR["mallEmail"]?> <i></i> 고객센터 : <?php echo $TPL_VAR["csPhone"]?>

            </p>
        </div>
    </div>

</section>