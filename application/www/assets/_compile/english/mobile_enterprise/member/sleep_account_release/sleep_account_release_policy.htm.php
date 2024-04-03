<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/sleep_account_release/sleep_account_release_policy.htm 000003722 */ ?>
<section class="br__join br__sleep">
    <p class="br__sleep__title"><?php echo $TPL_VAR["userName"]?>Notice</p>
    <p class="br__sleep__sub-title">
        <?php echo trans('정보통신망 이용 촉진 및 정보호호 등에 관한 법류에 따라,<br/>
        최근 1년간 로그인 기록이 없는 회원님의 개인 정보 보호를<br/>
        위해 회원님의 정보를 휴면 계정으로 전환하였음을<br/>
        알려드립니다.<br/><br/>
        배럴 로그인 및 관련 서비스 이용을 위해서<br/>
        고객님의 휴면 계정을 해제해주세요.')?>

    </p>
    <form id="devForm">

        <!-- 이용약관 -->
        <div class="br__join__terms">
            <ul>
                <li class="br__find-user__label agree-content">
                    <label for="agree-term1">
                        <input type="checkbox" id="agree-term1" name="policyIx[<?php echo $TPL_VAR["policyData"]['use']['ix']?>]" data-name="terms01" data-title="이용약관" title="이용약관"><span>Terms and Conditions (Required)</span></label>
                    <a href="javascript:void(0);" class="join__all-view term-content">All</a>
                </li>
                <li class="br__find-user__label agree-content">
                    <label for="agree-term2">
                        <input type="checkbox" id="agree-term2" name="policyIx[<?php echo $TPL_VAR["policyData"]['collection']['ix']?>]"  data-name="terms02" data-title="개인정보 수집 및 이용"  title="개인정보 수집 및 이용"><span>Terms and Conditions (Required) Privacy Policy Recieve Email (Optional)</span></label>
                    <a href="javascript:void(0);" class="join__all-view term-content">All</a>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" name="" data-type=""><span>Receive Email (Optional)</span></label>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" name="" data-type=""><span>Accept SMS reception (optional)</span></label>
                </li>
            </ul>
            <div class="join__terms-all">
                <label for="agree-all"><input type="checkbox" id="agree-all" class="join__terms__agree" name="" data-type=""><span>Agree all</span></label>
            </div>
        </div>
        <div class="br__login__info">
            <div class="br__login br__login--show br__change">
                <div class="information__btn">
                    <button class="information__btn__change"id="devCancelButton" type="button">Cancel</button>
                    <button class="information__btn__month" id="devSubmitButton" type="button">Cancellation for a dormant account</button>
                </div>
            </div>
        </div>
        <!-- EOD : 이용약관 -->
    </form>
</section>
<!-- 이용약관 팝업 -->
<div class="term__popup">
    <p class="term__popup-title">
        <span class="term__popup-name">이용약관</span>
        <span class="close"></span>
    </p>
    <div class="term__popup-content terms01">
            <!--이용약관 내용-->
            <?php echo $TPL_VAR["policyData"]['use']['contents']?>

    </div>
    <div class="term__popup-content terms02">
        <!--개인정보 수집 및 이용동의 내용-->
        <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

    </div>
</div>
<!-- EOD : 이용약관 팝업 -->