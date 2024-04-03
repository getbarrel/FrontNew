<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_agreement/join_agreement.htm 000006073 */ ?>
<section class="join-agreement-area fb__join-member fb__join-agreement">

    <h2 class="fb__join-member__title">회원가입</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
<?php if($TPL_VAR["joinType"]=='C'){?><!--사업자-->
                <p class="top-area__step__tit">사업자인증</p>
<?php }else{?><!--일반-->
                <p class="top-area__step__tit">본인인증</p>
<?php }?>
            </div>
        </li>
        <li class="top-area__step top-area__step02 top-area__step--active">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 02</span>
                <p class="top-area__step__tit">약관동의</p>
            </div>
        </li>
        <li class="top-area__step top-area__step03">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 03</span>
                <p class="top-area__step__tit">정보입력</p>
            </div>
        </li>
        <li class="top-area__step top-area__step04">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 04</span>
                <p class="top-area__step__tit">가입완료</p>
            </div>
        </li>
    </ul>

    <div class="wrap-joininput-layout">

        <p class="fb__join-agreement__subtitle">
            * <?php echo $TPL_VAR["mallName"]?> 이용을 위해 필수 약관에 동의하셔야 가입이 가능합니다.<br>
            * 선택 약관에 동의하지 않으셔도 회원가입이 가능합니다.
        </p>

        <form id="devForm">

            <div class="wrap-chk-all">
                <input type="checkbox" id="agree-all" >
                <label for="agree-all">약관 전체 동의</label>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">구매 이용 약관 <span>(필수)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['use']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term1" name="policyIx[<?php echo $TPL_VAR["policyData"]['use']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term1">동의</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">개인정보 수집 및 이용에 대한 안내 <span>(필수)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term2" name="policyIx[<?php echo $TPL_VAR["policyData"]['collection']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term2">동의</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">개인정보 취급 위탁 <span>(필수)</span></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['consign']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term3" name="policyIx[<?php echo $TPL_VAR["policyData"]['consign']['ix']?>]" value="Y" class="devRequired">
                    <label for="agree-term3">동의</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">제 3자 정보 제공 동의 <em>(선택)</em></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['third']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term4" name="policyIx[<?php echo $TPL_VAR["policyData"]['third']['ix']?>]" value="Y">
                    <label for="agree-term4">동의</label>
                </div>
            </div>

            <div class="wrap-terms">
                <p class="terms-tit">마케팅 활용 동의 <em>(선택)</em></p>
                <div class="input-terms">
                    <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

                </div>
                <div class="wrap-terms-check">
                    <input type="checkbox" id="agree-term5" name="policyIx[<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>]" value="Y">
                    <label for="agree-term5" class="mar10">동의</label>
                    (
                    <input type="checkbox" id="agree-term6" name="sms" value="1" class="mal10">
                    <label for="agree-term6" class="mar10">SMS 수신</label>

                    <input type="checkbox" id="agree-term7" name="email" value="1">
                    <label for="agree-term7" class="mar10">이메일 수신</label>
                    )
                </div>

                <p class="desc">
                    · 쇼핑몰에서 제공되는 다양한 정보를 받아보실 수 있습니다.<br>
                    · 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관 없이 발송됩니다.
                </p>
            </div>


        </form>
    </div>

    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button class="btn-lg fb__btn-point" id="devSubmitButton">다음</button>
    </div>

</section>
<input type="hidden" id="devMallName" value="<?php echo $TPL_VAR["mallName"]?>"/>