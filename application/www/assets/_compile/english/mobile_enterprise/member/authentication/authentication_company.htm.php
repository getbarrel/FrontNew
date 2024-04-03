<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/authentication/authentication_company.htm 000002020 */ ?>
<h1 class="wrap-title">
    회원가입
</h1>

<div class="wrap-step">
    <p>사업자인증</p>
    <ul class="step">
        <li class="on">1</li>
        <li class="">2</li>
        <li class="">3</li>
        <li class="">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>

<div class="layout-padding wrap-join-auth-com">
    <p class="join-title-desc">사업자인증 후<br>회원가입을 진행해 주시기 바랍니다.</p>

    <form id="devCompanyForm">
        <div class="wrap-input-form mat30">
            <dl>
                <dt>상호명 <em>*</em></dt>
                <dd>
                    <input type="text" id="devComName" name="comName"title="상호명">
                    <p class="txt-error" devTailMsg="devComName"></p>
                </dd>
            </dl>
            <dl>
                <dt>사업자등록 번호 <em>*</em></dt>
                <dd class="input-comnum wrap-multi-input">
                    <input type="text" name="comNumber1" id="devComNumber1"
                           title="사업자등록번호">
                    <span class="hyphen">-</span>
                    <input type="text" name="comNumber2" id="devComNumber2"
                           title="사업자등록번호">
                    <span class="hyphen">-</span>
                    <input type="text" name="comNumber3" id="devComNumber3"
                           title="사업자등록번호">
                    <p class="txt-error" devTailMsg="devComNumber1 devComNumber2 devComNumber3"></p>
                </dd>
            </dl>
        </div>
    </form>

    <div class="wrap-btn-area mat40">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">사업자 확인</button>
    </div>
</div>