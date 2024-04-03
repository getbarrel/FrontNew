<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_complete.htm 000002123 */ ?>
<section class="fb__sleep-complete">
    <header class="fb__sleep__top">
        <h2 class="fb__sleep__title">Notification for switching to dormant account</h2>
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
                    <span class="step-box__list__number">STEP 02</span>
                    <p class="step-box__list__title">
                        Change Password
                    </p>
                </div>
            </li>
            <li class="step-box__list step-box__list--end on">
                <div class="step-box__list__txt">
                    <span class="step-box__list__number">STEP 03</span>
                    <p class="step-box__list__title">
                        Activate Account
                    </p>
                </div>
            </li>
        </ul>
    </header>
    <div class="fb__sleep-complete__content">
        <p class="fb__sleep-complete__content--big"><?php echo $TPL_VAR["userName"]?> your account has been activated</p>

        <p class="fb__sleep-complete__content--small">
            If you login wth the account <?php echo $TPL_VAR["mallName"]?><?php echo trans('의 모든 서비스를 이용하실 수 있습니다.<br/>
            앞으로도 많은 이용과 관심 부탁드립니다.')?>

        </p>
    </div>

    <div class="fb__sleep__btn">
        <a class="fb__sleep__btn--black" href="/">Home</a>
        <button class="fb__sleep__btn--point" id="devSleepMemberReleaseComplete">Sign in</button>
    </div>

</section>