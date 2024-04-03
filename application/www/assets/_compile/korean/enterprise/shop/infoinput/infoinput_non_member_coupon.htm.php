<?php /* Template_ 2.2.8 2024/02/12 01:12:23 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_non_member_coupon.htm 000000995 */ ?>
<section class="fb__infoinput__nonmember-agreement nonmember-agreement">
    <h2 class="nonmember-agreement__title">비회원 약관동의</h2>
    <div class="nonmember-agreement__cont">
        <p class="nonmember-agreement__cont-tit">비회원 구매 이용 약관 <span>(필수)</span></p>
        <div class="nonmember-agreement__cont-input">
            <?php echo $TPL_VAR["use"]['contents']?>

        </div>
        <div class="nonmember-agreement__agree">
            <input type="checkbox" id="wrap-terms-30" class="devTerms" name="term30" value="30" title="비회원 구매 이용 약관" devvalidation="{&quot;required&quot;:true,&quot;requiredMessageTag&quot;:&quot;infoinput.paymentRequest.validation.fail.terms&quot;}">
            <label for="wrap-terms-30">동의</label>
        </div>
    </div>
</section>