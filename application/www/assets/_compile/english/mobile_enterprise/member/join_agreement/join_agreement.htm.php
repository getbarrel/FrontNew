<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_agreement/join_agreement.htm 000003920 */ ?>
<h1 class="wrap-title">
    회원가입
</h1>

<div class="wrap-step">
    <p>약관동의</p>
    <ul class="step">
        <li class="">1</li>
        <li class="on">2</li>
        <li class="">3</li>
        <li class="">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>

<div class="wrap-agree-sec">
    <p class="join-agree-desc">
        · <?php echo $TPL_VAR["mallName"]?> 이용을 위해 필수 약관에 동의하셔야 가입이 가능합니다.<br>
        · 선택 약관에 동의하지 않으셔도 회원가입이 가능합니다.
    </p>
</div>


<form id="devForm">
    <div class="term-list">
        <input type="checkbox" id="agree-all" class="agree-all">
        <label for="agree-all">약관 전체동의</label>
    </div>

    <div class="term-list">
        <input type="checkbox" id="agree-term1" name="policyIx[<?php echo $TPL_VAR["policyData"]['use']['ix']?>]" value="Y" class="devRequired">
        <label for="agree-term1">구매 이용약관<em>(필수)</em></label>
        <span class="accord-btn"></span>
    </div>
    <div class="terms-content">
        <?php echo $TPL_VAR["policyData"]['use']['contents']?>

    </div>


    <div class="term-list">
        <input type="checkbox"  id="agree-term2" name="policyIx[<?php echo $TPL_VAR["policyData"]['collection']['ix']?>]" class="devRequired">
        <label for="agree-term2">개인정보 수집 및 이용약관<em>(필수)</em></label>
        <span class="accord-btn"></span>
    </div>
    <div class="terms-content">
        <?php echo $TPL_VAR["policyData"]['collection']['contents']?>

    </div>


    <div class="term-list">
        <input type="checkbox"  id="agree-term3" name="policyIx[<?php echo $TPL_VAR["policyData"]['consign']['ix']?>]" class="devRequired">
        <label for="agree-term2">개인정보 취급 위탁<em>(필수)</em></label>
        <span class="accord-btn"></span>
    </div>
    <div class="terms-content">
        <?php echo $TPL_VAR["policyData"]['consign']['contents']?>

    </div>

    <div class="term-list">
        <input type="checkbox"  id="agree-term4" name="policyIx[<?php echo $TPL_VAR["policyData"]['third']['ix']?>]" >
        <label for="agree-term4">제 3자 정보 제공 동의(선택)</label>
        <span class="accord-btn"></span>
    </div>
    <div class="terms-content">
        <?php echo $TPL_VAR["policyData"]['third']['contents']?>

    </div>

    <div class="term-list">
        <input type="checkbox"  id="agree-term5" name="policyIx[<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>]" >
        <label for="agree-term5">마케팅 활용 동의(선택)</label>
        <span class="accord-btn"></span>
    </div>
    <div class="terms-content">
        <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

    </div>


    <div class="marketing-wrap">
        <p class="tit">마케팅 활용 동의 수신 여부</p>

        <input type="checkbox" id="agree-term6" name="sms" value="1" devSms>
        <label for="agree-term6">SMS 수신</label>

        <input type="checkbox" id="agree-term7" name="email" value="1" class="mal40">
        <label for="agree-term7">이메일 수신</label>

        <p class="sub-txt mat20">· 쇼핑몰에서 제공되는 다양한 정보를 받아보실 수 있습니다.<br>

        <p class="sub-txt">· 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관 없이 발송됩니다.
        </p>
    </div>
</form>


<div class="wrap-btn-area agree">
    <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
    <button class="btn-lg btn-point" id="devSubmitButton">다음</button>
</div>
<input type="hidden" id="devMallName" value="<?php echo $TPL_VAR["mallName"]?>"/>