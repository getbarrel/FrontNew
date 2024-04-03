<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_agreement/join_agreement.htm 000006076 */ ?>
<section class="join-agreement-area fb__join-member fb__join-agreement">

    <h2 class="fb__join-member__title">Join</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
<?php if($TPL_VAR["joinType"]=='C'){?><!--사업자-->
                <p class="top-area__step__tit">Verification for Business holder</p>
<?php }else{?><!--일반-->
                <p class="top-area__step__tit">Identity verification</p>
<?php }?>
            </div>
        </li>
        <li class="top-area__step top-area__step02 top-area__step--active">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 02</span>
                <p class="top-area__step__tit">Agree</p>
            </div>
        </li>
        <li class="top-area__step top-area__step03">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 03</span>
                <p class="top-area__step__tit">Enter Information</p>
            </div>
        </li>
        <li class="top-area__step top-area__step04">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 04</span>
                <p class="top-area__step__tit">Welcome!</p>
            </div>
        </li>
    </ul>

    <div class="wrap-joininput-layout">

        <p class="fb__join-agreement__subtitle">
            * You must agree to the required terms in order to use <?php echo $TPL_VAR["mallName"]?>.<br>
            * You can register without agreeing to the optional terms and conditions.
        </p>

        <form id="devForm">

            <div class="wrap-chk-all">
                <input type="checkbox" id="agree-all" >
                <label for="agree-all">Agree all</label>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">Terms and Conditions of Purchase <span>(Required)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['use']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term1" name="policyIx[<?php echo $TPL_VAR["policyData"]['use']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term1">Agree</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">Privacy Policy <span>(Required)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term2" name="policyIx[<?php echo $TPL_VAR["policyData"]['collection']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term2">Agree</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">Consignment of personal information handling <span>(Required)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['consign']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term3" name="policyIx[<?php echo $TPL_VAR["policyData"]['consign']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term3">Agree</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">Consent to Providing Third Party Information <em>(Select)</em></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['third']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term4" name="policyIx[<?php echo $TPL_VAR["policyData"]['third']['ix']?>]" value="Y">
                    <label for="agree-term4">Agree</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">Agreement to using for marketing <em>(Select)</em></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term5" name="policyIx[<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>]" value="Y">
                    <label for="agree-term5" class="mar10">Agree</label>
                    (
                    <input type="checkbox" id="agree-term6" name="sms" value="1" class="mal10">
                    <label for="agree-term6" class="mar10">Recieve SMS</label>

                    <input type="checkbox" id="agree-term7" name="email" value="1">
                    <label for="agree-term7" class="mar10">Recieve Email</label>
                    )
                </div>

                <p class="desc">
                    · You can receive variety of information from the Barrel.<br>
                    · Information regarding order transactions, such as payment/exchange/refund, will be sent regardless of whether or not you accept the request or not
                </p>
            </div>


        </form>
    </div>

    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">Cancel</button>
        <button class="btn-lg fb__btn-point" id="devSubmitButton">Next</button>
    </div>

</section>
<input type="hidden" id="devMallName" value="<?php echo $TPL_VAR["mallName"]?>"/>