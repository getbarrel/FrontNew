<?php /* Template_ 2.2.8 2024/01/22 10:35:43 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/login/login.htm 000026157 */ ?>
<!-- 팝업 유형의 레이아웃 S -->
<?php if($TPL_VAR["wg_is_kakao_page"]=='F'){?>
		<section id="container" class="br__layout-popup">
			<header class="br__layout-popup__header">
				<div class="br__layout-popup__page-title">로그인</div>
				<!-- <button type="button" class="btn-link btn-close">닫기</button> -->
			</header>
			<div class="br__layout-popup__contents">
				<!-- 컨텐츠 S -->
				<section class="br__login br__login--member br__login--show">
					<div class="page-title">
						<div class="title-sm">카카오 간편 로그인</div>
					</div>
					<div class="br__login__info">
						<div class="information">
							<div class="login_kakao_1sec">
								<a href="<?php echo $TPL_VAR["kakao_login"]?>" class="btn_kakao_1sec">카카오로 시작하기</a>
								<p>카카오 로그인으로 빠르고 간편하게 로그인 하세요.</p>
							</div>

							<div class="contour_sec">
								<span>또는</span>
							</div>

							<h3 class="br__hidden">로그인 정보 입력 및 회원가입</h3>

							<div class="information__form">
								<div class="page-title">
									<div class="title-sm">일반 로그인</div>
								</div>
								<form id="devLoginForm">
									<input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
									<div class="information__input-group">
										<div class="information__input">
											<label for="devUserId" class="hidden">아이디</label>
											<input type="text" placeholder="아이디" name="userId" class="br__form-input" id="devUserId" title="아이디" value="<?php echo $TPL_VAR["userSaveLoginId"]?>" />
										</div>
										<p class="txt-error" devTailMsg="devUserId" ></p>
										<div class="information__input">
											<label for="devUserPassword" class="hidden">비밀번호</label>
											<input type="password" placeholder="비밀번호" name="userPw" class="br__form-input" id="devUserPassword" title="비밀번호" />
											<!-- <button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button> -->
										</div>
										<p class="txt-error" devTailMsg="devUserPassword"></p>
									</div>

									<div class="information__btn">
										<button class="information__btn__login" id="devLoginSubmitButton">로그인</button>
									</div>

									<div class="information__group">
										<div class="information__check">
<?php if($TPL_VAR["app_type"]){?>
											<label><input type="checkbox" name="autoLogin" value="Y" <?php echo $TPL_VAR["autoLoginChecked"]?> /><span>자동 로그인</span></label>
<?php }else{?>
											<label><input type="checkbox" id="c1" name="saveId" value="Y" <?php echo $TPL_VAR["saveIdChecked"]?>/><span>아이디저장</span></label>
<?php }?>
										</div>
<?php if($TPL_VAR["captcha_use"]=="Y"){?>
												<table style="width: 100%; height: 40px;">
													<col width='95' />
													<col width='*' />
													<tr>
														<td>
															<img src="../member/captcha/captcha.php?characters=6&width=110&height=30" style="padding:4px 0px 3px 4px; width:100%;height:100%;">
														</td>

														<td style="vertical-align: middle;">
															<input type='text' name="captcha_text" id="captcha_text_id" value='' tabindex=3 class="vm font_bold size_16" style="width:180px;padding:4px 0px 3px 4px;" placeholder="문자를 입력해주세요." title="보안문자"/>
														</td>
													</tr>

													<input type="hidden" id="captcha_use_id" value="<?php echo $TPL_VAR["captcha_use"]?>">
												</table>
<?php }?>
										<div class="information__find">
<?php if($TPL_VAR["langType"]=='korean'){?>
											<a href="/member/searchId">아이디 찾기</a>
											<a href="/member/searchPw">비밀번호 찾기</a>
<?php }else{?>
											<a href="/member/searchId">Forgot ID</a>
											<a href="/member/searchPw">Password</a>
<?php }?>
										</div>
									</div>

									<!-- 아이디 또는 패스워드가 틀릴 경우 노출되는 경고(오류) 메시지 S -- 
									<p class="txt-error">회원 아이디 또는 비밀번호가 일치하지 않습니다.</p>
									<!-- 아이디 또는 패스워드가 틀릴 경우 노출되는 경고(오류) 메시지 E -->
								</form>
							</div>
							<div class="information__no-member">
								<div class="page-title">
									<div class="title-sx">배럴 회원이 아직 아니신가요?</div>
								</div>
								<div class="information__btn">
									<a href="/member/joinInput" class="btn-lg btn-dark-line information__btn__join">회원가입</a>
								</div>
							</div>

							<div class="information__benefit">
								<h3 class="information__benefit__title">배럴 신규 회원 가입 혜택</h3>
								<ul class="information__benefit__box">
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img01.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>10,000원 할인 쿠폰</p>
											(10만원 구매 이상)
										</div>
									</li>
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img02.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>5,000원 할인 쿠폰</p>
											(5만원 구매 이상)
										</div>
									</li>
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img03.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>구매 금액의 1% 적립금</p>
										</div>
									</li>
								</ul>
							</div>

							<div class="contour_sec">
								<span>또는</span>
							</div>

							<ul class="information__sns">
								<li class="information__sns__list">
									<a href="<?php echo $TPL_VAR["naver_login"]?>" class="btn-lg btn-gray-line information__sns__link information__sns__link--naver">네이버 로그인</a>
								</li>
								<li class="information__sns__list">
									<a href="#google" class="btn-lg btn-gray-line information__sns__link information__sns__link--google" <?php if($TPL_VAR["appType"]){?>id="appLoginGoogle" data-type="<?php echo $TPL_VAR["appType"]?>"<?php }?>>구글 로그인 <?php if(!$TPL_VAR["appType"]){?><span class="g-signin2" data-onsuccess="onSignIn"></span><?php }?></a>
								</li>
								<li class="information__order-inquiry">
<?php if($TPL_VAR["isNonMemberBuy"]){?>
										<button type="button" class="btn-lg btn-gray-line information__btn__nomem devNonmemberOrder">비회원 구매하기</button>
<?php }else{?>
										<button type="button" class="btn-lg btn-gray-line information__btn__nomem" id="devLoginSubmitButton">비회원 주문조회</button>
<?php }?>
								</li>
							</ul>
						</div>
					</div>
				</section>
				<!-- 컨텐츠 E -->
			</div>
		</section>
<?php }else{?>
		<!-- 팝업 유형의 레이아웃 S -->
		<section id="container" class="br__layout-popup">
			<header class="br__layout-popup__header">
				<div class="br__layout-popup__page-title">로그인</div>
				<!-- <button type="button" class="btn-link btn-close">닫기</button> -->
			</header>
			<div class="br__layout-popup__contents">
				<!-- 컨텐츠 S -->
				<section class="br__login br__login--member br__login--show">
					<div class="page-title">
						<div class="title-sm">카카오 간편 로그인</div>
					</div>
					<div class="br__login__info">
						<div class="information">
							<div class="login_kakao_1sec">
								<a href="<?php echo $TPL_VAR["kakao_login"]?>" class="btn_kakao_1sec">카카오로 시작하기</a>
								<p>카카오 로그인으로 빠르고 간편하게 로그인 하세요.</p>
							</div>

							<div class="information__benefit">
								<h3 class="information__benefit__title">배럴 신규 회원 가입 혜택</h3>
								<ul class="information__benefit__box">
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img01.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>10,000원 할인 쿠폰</p>
											(10만원 구매 이상)
										</div>
									</li>
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img02.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>5,000원 할인 쿠폰</p>
											(5만원 구매 이상)
										</div>
									</li>
									<li class="information__benefit__list">
										<div class="information__benefit__img">
											<img src="/assets/mobile_templet/mobile_enterprise/assets/img/join_benefit_img03.png" alt="" />
										</div>
										<div class="information__benefit__desc">
											<p>구매 금액의 1% 적립금</p>
										</div>
									</li>
								</ul>
							</div>

							<div class="information__footer">
								<a href="/member/login" class="btn-link">로그인으로 돌아가기</a>
							</div>
						</div>
					</div>
				</section>
				<!-- 컨텐츠 E -->
			</div>
		</section>
		<!-- 팝업 유형의 레이아웃 E -->
<?php }?>
		<!-- 팝업 유형의 레이아웃 E -->

<!--
<style>
    .br__login__title {padding:3.5rem 0;}

    .login_kakao_1sec .btn_kakao_1sec {background:#fee500 url('/assets/mobile_templet/mobile_enterprise/images/common/icon_login_kakao.png') 11px 14px no-repeat; background-size:16px 15px; color:#000; display:block; font-size:1.3rem; font-weight:700; line-height:4rem; text-align:center;}
    .login_kakao_1sec p {color:#595757; font-size:13px; line-height:20px; padding:20px 0 10px; text-align:center;}
    .login_kakao_1sec p strong {color:#000;}

    .login__tit {color:#000; font-size:1.35rem; font-weight:700; line-height:2rem; padding-top:5px; text-align:center;}
    .login__tit2 {color:#000; font-size:1.4rem; font-weight:700; line-height:2rem; padding:10px 0 15px; text-align:center;}
    
    .br__login__info .information__input input[type=text], .br__login__info .information__input input[type=password] {border:#d7d7d7 1px solid;}

    .br__login__info .information__btn__login {width:100%; float:none; margin-bottom:10px;}
    .br__login__info .information__btn__join {width:100%; background-color:#fff; border:#d7d7d7 1px solid !important; color:#595757 !important; float:none; font-size:1.2rem !important; font-weight:400 !important;}

    .br__login__info .information__sns__list {border:#dcdddd 1px solid; margin-top:1rem;}
    .br__login__info .information__sns__link:after {background:#dcdddd !important;}

    .info-benefit {margin:20px 0 30px;}
    .info-benefit .info-benefit-desc {border:#dcdddd 1px solid; color:#595757; font-size:1.3rem; line-height:2.0rem; margin-bottom:10px; padding:14px 8px 14px 40px; position:relative;}
    .info-benefit .info-benefit-desc span {color:#000; display:inline-block; font-size:1.4rem; font-weight:700; left:10px; position:absolute; top:14px;}
    .info-benefit .info-benefit-desc strong {color:#000;}

    .br__login__info .information__input__hyphen {width:0.8rem; background:none; margin:0;}
    .br__login__info .information__input--half input[type=text] {width:calc(50% - 0.4rem);}

    .contour_sec {height:1px; background-color:#ebebeb; margin:20px 0 22px; position:relative;}
    .contour_sec span {background-color:#fff; color:#b5b5b6; display:inline-block; font-size:12px; padding:0 10px; left:50%; margin-left:-17px; position:absolute; top:-8px;}

    .marT1r {margin-top:1rem !important;}
</style>
<?php if($TPL_VAR["wg_is_kakao_page"]=='F'){?>
<section class="br__login br__login--member br__login--show">
    <h2 class="br__login__title">로그인</h2>
    <div class="br__login__info">
        <div class="information">
            <div class="login_kakao_1sec">
                <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="btn_kakao_1sec">카카오 1초 로그인/회원가입</a>
                <p>매번 아이디와 비밀번호 입력없이<br /><strong>카카오 1초 로그인</strong>으로 간편하게 로그인 하세요.</p>
            </div>

            <div class="contour_sec">
                <span>또는</span>
            </div>

            <h3 class="br__hidden">로그인 정보 입력 및 회원가입</h3>

            <form id="devLoginForm">
                <div class="login__tit">일반 로그인</div>
                <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
                <div class="information__input">
                    <input type="text" placeholder="아이디" name="userId" id="devUserId" title="아이디" value="<?php echo $TPL_VAR["userSaveLoginId"]?>">
                    <p class="txt-error" devTailMsg="devUserId" ></p>
                </div>
                <div class="information__input">
                    <input type="password" placeholder="비밀번호" name="userPw"  id="devUserPassword" title="비밀번호">
                    <p class="txt-error" devTailMsg="devUserPassword"></p>
                </div>

                <div class="information__check">
<?php if($TPL_VAR["app_type"]){?>
                    <label><input type="checkbox" name="autoLogin" value="Y" <?php echo $TPL_VAR["autoLoginChecked"]?>><span>자동 로그인</span></label>
<?php }else{?>
                    <label><input type="checkbox" id="c1" name="saveId" value="Y" <?php echo $TPL_VAR["saveIdChecked"]?>><span>아이디저장</span></label>
<?php }?>
                </div>



<?php if($TPL_VAR["captcha_use"]=="Y"){?>
                            <table style="width: 100%; height: 40px;">
                                <col width='95' />
                                <col width='*' />
                                <tr>
                                    <td>
                                        <img src="../member/captcha/captcha.php?characters=6&width=110&height=30" style="padding:4px 0px 3px 4px; width:100%;height:100%;">
                                    </td>

                                    <td style="vertical-align: middle;">
                                        <input type='text' name="captcha_text" id="captcha_text_id" value='' tabindex=3 class="vm font_bold size_16" style="width:180px;padding:4px 0px 3px 4px;" placeholder="문자를 입력해주세요." title="보안문자"/>
                                    </td>
                                </tr>

                                <input type="hidden" id="captcha_use_id" value="<?php echo $TPL_VAR["captcha_use"]?>">
                            </table>
<?php }?>



                <div class="information__btn">
                    <button class="information__btn__login" id="devLoginSubmitButton">로그인</button>
                    <a href="/member/joinInput" class="information__btn__join">일반 회원가입</a>
                </div>
            </form>

            <p class="information__find">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <a href="/member/searchId">아이디</a> / <a href="/member/searchPw">비밀번호 찾기</a>
<?php }else{?>
                <a href="/member/searchId">Forgot ID</a> / <a href="/member/searchPw">Password</a>
<?php }?>
            </p>

            <div class="contour_sec">
                <span>또는</span>
            </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
            <ul class="information__sns">
                <li class="information__sns__list">

                    <a href="<?php echo $TPL_VAR["naver_login"]?>" class="information__sns__link information__sns__link--naver">네이버로 시작하기</a>

                </li>
                <!-- <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="information__sns__link information__sns__link-kakaotalk">카카오톡으로 시작하기</a>
                </li> -->
                <!-- li class="information__sns__list marT1r">
                    <a href="<?php echo $TPL_VAR["facebook_login"]?>" class="information__sns__link information__sns__link--facebook">페이스북으로 시작하기</a>
                </li -- 
                <li class="information__sns__list marT1r">
                    <a href="#google" class="information__sns__link information__sns__link--google" <?php if($TPL_VAR["appType"]){?>id="appLoginGoogle" data-type="<?php echo $TPL_VAR["appType"]?>"<?php }?>>
                        구글로 시작하기
<?php if(!$TPL_VAR["appType"]){?>
                        <span class="g-signin2" data-onsuccess="onSignIn"></span>
<?php }?>
                    </a>
                </li>
            </ul>
<?php }?>

            <div class="information__btn marT1r">
<?php if($TPL_VAR["isNonMemberBuy"]){?>
                <button type="button" class="btn-nomember-buy devNonmemberOrder">비회원 구매하기</button>
<?php }else{?>
                <button type="button" class="information__btn__nomem" id="devLoginSubmitButton">비회원 주문조회</button>
<?php }?>
            </div>
            <div class="info-benefit">
                <h3 class="login__tit2">배럴 회원 혜택</h3>
                <p class="info-benefit-desc"><span>01</span>회원등급에 따른 <strong>쿠폰, 즉시할인 혜택</strong></p>
                <p class="info-benefit-desc"><span>02</span>회원등급에 따른 <strong>구매금액의 1%이상 적립금</strong></p>
                <p class="info-benefit-desc"><span>03</span>신규가입시 <br /><strong>5,000원 할인쿠폰</strong>(5만원 구매 이상)<br /><strong>10,000원 할인쿠폰</strong>(10만원 구매 이상)</p>
            </div>
        </div>
    </div>
</section>
<?php }else{?>
<!-- [S] 회원가입 새 페이지 -- 
<section class="br__login br__login--member br__login--show">
    <h2 class="br__login__title">회원가입</h2>
    <div class="br__login__info">
            <div class="login_kakao_1sec">
                <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="btn_kakao_1sec">카카오 1초 로그인/회원가입</a>
                <p>매번 아이디와 비밀번호 입력없이<br /><strong>카카오 1초 로그인</strong>으로 간편하게 로그인 하세요.</p>
            </div>
            
            <div class="info-benefit">
                <h3 class="login__tit2">배럴 회원 혜택</h3>
                <p class="info-benefit-desc"><span>01</span>회원등급에 따른 <strong>쿠폰, 즉시할인 혜택</strong></p>
                <p class="info-benefit-desc"><span>02</span>회원등급에 따른 <strong>구매금액의 1%이상 적립금</strong></p>
				<p class="info-benefit-desc"><span>03</span>신규가입시 <br /><strong>5,000원 할인쿠폰</strong>(5만원 구매 이상)<br /><strong>10,000원 할인쿠폰</strong>(10만원 구매 이상)</p>
            </div>

            <div class="contour_sec">
                <span>또는</span>
            </div>

            <div class="information__btn">
                <a href="/member/joinInput" class="information__btn__join">일반 회원가입</a>
            </div>
    </div>
</section>
<!-- [E] 회원가입 새 페이지 -- 
<?php }?>
<!-- 2019.07.11 비회원 주문조회 -- 
<section class="br__login br__login--nomember">
    <h2 class="br__login__title">비회원 주문조회</h2>
    <div class="br__login__info">
        <div class="information">
            <h3 class="br__hidden">주문/배송조회</h3>
            <form id="devNonMemberLoginForm">
                <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
                <div class="information__input">
                    <input type="text" placeholder="주문자명"  name="buyerName" id="devBuyerName" title="주문자명">
                    <p class="txt-error" devTailMsg="devBuyerName"></p>
                </div>
                <div class="information__input information__input--half">
                    <input type="text" placeholder="주문번호"  name="orderId" id="devOrderId" title="주문번호">
                    <span class="information__input__hyphen">-</span>
                    <input type="text" name="orderId2" id="devOrderId2" title="주문번호">
                    <p class="txt-error" devTailMsg="orderId devOrderId2"></p>
                </div>
                <div class="information__input">
                    <input type="password" placeholder="비회원 주문 패스워드"  name="orderPassword" id="devOrderPassword" title="주문 비밀번호">
                    <p class="txt-error" devTailMsg="devOrderPassword"></p>
                </div>

                <div class="information__btn">
                    <button class="information__btn__order" id="devNonMemberLoginSubmitButton">주문/배송조회</button>
                </div>
            </form>

            <div class="info-benefit">
                <h3 class="login__tit2">배럴 회원 혜택</h3>
                <p class="info-benefit-desc"><span>01</span>회원등급에 따른 <strong>쿠폰, 즉시할인 혜택</strong></p>
                <p class="info-benefit-desc"><span>02</span>회원등급에 따른 <strong>구매금액의 1%이상 적립금</strong></p>
                <p class="info-benefit-desc"><span>03</span>3만원 이상 구매시 <strong>즉시 사용가능한<br />3,000원 할인쿠폰</strong></p>
            </div>

            <div class="login_kakao_1sec">
                <a href="#" class="btn_kakao_1sec">카카오 1초 로그인/회원가입</a>
                <p>매번 아이디와 비밀번호 입력없이<br /><strong>카카오 1초 로그인</strong>으로 간편하게 로그인 하세요.</p>
            </div>

            <div class="contour_sec">
                <span>또는</span>
            </div>

            <div class="information__btn">
                <a href="/member/joinInput" class="information__btn__join">일반 회원가입</a>
            </div>

        </div>
    </div>
</section>
<!-- EOD : 2019.07.11 비회원 주문조회 -- 

<!-- 추후 삭제 예정 -- 
<?php if(false){?>
<div class="wrap-member">
    <h1 class="wrap-title">
        로그인
        <button class="back"></button>
    </h1>

    <div class="layout-padding wrap-login">
        <form id="devLoginForm">
            <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
            <input type="text" placeholder="아이디" name="userId"
                   id="devUserId" title="아이디" value="<?php echo $TPL_VAR["userSaveLoginId"]?>">
            <p class="txt-error" devTailMsg="devUserId" ></p>

            <input type="password" placeholder="비밀번호" class="mat20" name="userPw"
                   id="devUserPassword" title="비밀번호">

            <p class="txt-error" devTailMsg="devUserPassword"></p>

            <div class="mat20">
                <input type="checkbox" class="" id="c1" name="saveId" value="Y" <?php echo $TPL_VAR["saveIdChecked"]?>>
                <label for="c1">아이디 저장</label>
            </div>

            <div class="wrap-btn-area mat40">
                <button class="btn-lg btn-point" id="devLoginSubmitButton">로그인</button>
            </div>
        </form>


        <div class="login-find-info">
            <a href="/member/searchId">아이디 찾기</a>
            <a href="/member/searchPw">비밀번호 찾기</a>
            <a href="/member/joinSelect" class="join">회원가입</a>
        </div>


        <p class="desc">비회원으로 주문하셨나요?</p>

        <div class="wrap-btn-area mat20">
            <button class="btn-lg btn-point-line pub-nonmem-order-button">비회원으로 주문조회</button>
        </div>
    </div>
</div>

<div class="wrap-nonmember" style="display:none;">
    <h1 class="wrap-title">
        비회원 주문 조회
        <button class="back"></button>
    </h1>

    <div class="layout-padding wrap-nonmem-login">
        <form id="devNonMemberLoginForm">
            <input type="text" placeholder="주문자명을 입력해주세요."  name="buyerName"
                   id="devBuyerName" title="주문자명">
            <p class="txt-error" devTailMsg="devBuyerName"></p>

            <input type="text" placeholder="주문번호를 입력해주세요." class="mat20" name="orderId"
                   id="devOrderId" title="주문번호">
            <p class="txt-error" devTailMsg="devOrderId"></p>

            <input type="password" placeholder="주문 비밀번호를 입력해주세요." class="mat20"
                   name="orderPassword" id="devOrderPassword" title="주문 비밀번호">
            <p class="txt-error" devTailMsg="devOrderPassword"></p>

            <div class="wrap-btn-area mat30">
                <button class="btn-lg btn-point" id="devNonMemberLoginSubmitButton">확인</button>
            </div>
        </form>

        <p class="sub-desc">주문번호가 기억나지 않으시면 <span>고객센터 <em class="font-rb">02-3210-3210</em></span>로 문의해주세요.</p>

        <div class="join-area">
            <p class="title">아직 회원이 아니신가요? <br> 회원가입 하시고 다양한 혜택을 받으세요.</p>
            <div class="wrap-btn-area">
                <a href="/member/joinSelect" class="btn-lg btn-dark-line">회원가입</a>
            </div>
        </div>

    </div>

</div>
<?php }?>
<!-- 추후 삭제 예정 -->