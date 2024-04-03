<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_policy.htm 000004814 */ ?>
<section class="fb__sleep fb__sleep-policy ">
    <header class="fb__sleep__top">
        <h2 class="fb__sleep__title">Notification for switching to dormant account</h2>
        <ul class="step-box">
            <li class="step-box__list step-box__list--agreement on">
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
            <li class="step-box__list step-box__list--end">
                <div class="step-box__list__txt">
                    <span class="step-box__list__number">STEP 03</span>
                    <p class="step-box__list__title">
                        Activate Account
                    </p>
                </div>
            </li>
        </ul>
        <p class="fb__sleep__desc">
            <?php echo trans('정보통신망 이용 촉진 및 정보보호 등에 관한 법률에 따라,<br>
            최근 1년간 로그인 기록이 없는 회원님의 개인 정보 보호를 위해 회원님의 정보를 휴면 계정으로 전환하였음을 알려드립니다.<br>
            배럴 로그인 및 관련 서비스 이용을 위해서 회원님의 휴면 계정을 해제해주세요.')?>

        </p>
    </header>
    <div class="fb__sleep__content">
        <form id="devForm" class="term js__check-wrap">
            <div class="term__each">
                <p class="term__title">Terms and Conditions of Purchase <span>Required</span></p>
                <div class="term__input-terms">
                    <?php echo $TPL_VAR["policyData"]['use']['contents']?>

                </div>
                <div class="term__check">
                    <input type="checkbox" id="agree-term1" name="policyIx[<?php echo $TPL_VAR["policyData"]['use']['ix']?>]" value="Y" class="devRequired js__check-porsonal">
                    <label for="agree-term1">Accept</label>
                </div>
            </div>

            <div class="term__each">
                <p class="term__title">Privacy Policy <span>Required</span></p>
                <div class="term__input-terms">
                    <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

                </div>
                <div class="term__check">
                    <input type="checkbox" id="agree-term2" name="policyIx[<?php echo $TPL_VAR["policyData"]['collection']['ix']?>]" value="Y" class="devRequired js__check-porsonal">
                    <label for="agree-term2">Accept</label>
                </div>
            </div>

<?php if(false){?>
            <div class="term__each">
                <p class="term__title">Consignment of personal information handling<span>Required</span></p>
                <div class="term__input-terms">
                    <?php echo $TPL_VAR["policyData"]['consign']['contents']?>

                </div>
                <div class="term__check">
                    <input type="checkbox" id="agree-term3" name="policyIx[<?php echo $TPL_VAR["policyData"]['consign']['ix']?>]" value="Y" class="devRequired js__check-porsonal">
                    <label for="agree-term3">Accept</label>
                </div>
                <div class="term__check term__check--optional">
                    <label>
                        <input type="checkbox" class="js__check-porsonal">
                        <span>Receive Email (Optional)</span>
                    </label>
                    <label>
                        <input type="checkbox" class="js__check-porsonal">
                        <span>Accept SMS reception (optional)</span>
                    </label>
                </div>
            </div>
<?php }?>
            <div class="term__check--all">
                <input type="checkbox" id="agree-all" class="js__check-all ">
                <label for="agree-all">Agree all</label>
            </div>
        </form>
    </div>
    <div class="fb__sleep__btn">
        <button class="fb__sleep__btn--black" id="devCancelButton">Cancel</button>
        <button class="fb__sleep__btn--point" id="devSubmitButton">Cancellation for a dormant account</button>
    </div>
</section>