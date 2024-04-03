<?php /* Template_ 2.2.8 2024/03/27 13:57:14 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/password/password.htm 000002926 */ ?>
<!-- <div class="wrap-change-password">
    <form id="devPmComparePasswordForm">
        <div class="desc">새로운 비밀번호를 입력해 주세요.</div>

        <dl>
            <dt>새 비밀번호</dt>
            <dd>
                <input type="password" name="pw" id="devPmPassword" title="새 비밀번호">
                <p class="txt-guide" devTailMsg="devPmPassword"></p>
            </dd>
        </dl>

        <dl>
            <dt>새 비밀번호 확인</dt>
            <dd>
                <input type="password" name="comparePw" id="devPmComparePassword" title="새 비밀번호 확인">
                <p class="txt-guide" devTailMsg="devPmComparePassword"></p>
            </dd>
        </dl>

        <div class="desc02">영문 대소문자/숫자/특수문자 2가지 이상 조합, 최소 8자~최대 16자 입력</div>

        <div class="popup-btn-area">
            <button type="button" class="btn-default btn-dark-line" id="devPmCancel">취소</button>
            <button type="button" class="btn-default btn-dark" id="devPmSubmit">확인</button>
        </div>
    </form>
</div>  -->

<section class="popup-content__wrap">
	<div class="desc" style="margin-bottom:20px; font-size:12px"">새로운 비밀번호를 입력해 주세요.</div>
    <form id="devPmComparePasswordForm">
	<div class="fb__change-option devProductContents">
		<div class="fb__change-option__cont">
			<ul class="fb__change-option__list">
				<li class="fb__change-option__item" id="devSildeMinicartArea">

					<dl class="popup-product__quantity product-quantity">
						<dt class="product-quantity__title">새 비밀번호</dt>
						<dd>
							<input type="password" name="pw" id="devPmPassword" title="새 비밀번호" style="width:220px;">
							<p class="txt-guide" devTailMsg="devPmPassword" style="height;20px;"></p>
						</dd>
					</dl>
					<dl class="popup-product__quantity product-quantity">
						<dt class="product-quantity__title">새 비밀번호 확인</dt>
						<dd>
							<input type="password" name="comparePw" id="devPmComparePassword" title="새 비밀번호 확인" style="width:220px;">
							<p class="txt-guide" devTailMsg="devPmComparePassword"></p>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
		<div class="desc" style="margin-top:20px; margin-bottom:20px; font-size:12px">영문 대소문자/숫자/특수문자 2가지 이상 조합, 최소 8자~최대 16자 입력</div>
		<div class="fb__change-option__btn">
			<button type="button" class="btn-lg btn-dark-line fb__change-option__btn--submit " id="devPmCancel" style="margin-right:5px">취소</button>
			<button type="button" class="btn-lg btn-dark-line fb__change-option__btn--submit " id="devPmSubmit">확인</button>
		</div>
	</div>
    </form>
</section>