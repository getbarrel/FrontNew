<?php /* Template_ 2.2.8 2024/02/02 14:40:09 /home/barrel-stage/application/www/assets/templet/enterprise/member/login/login.htm 000010443 */ ?>
<!-- 컨텐츠 영역 S -->
	<section class="fb__login">
<?php if($TPL_VAR["wg_is_kakao_page"]=='F'){?>
		<!-- 일반 로그인 S -->
		<div class="fb__login__contents">
			<!-- 로그인 S-->
			<div class="fb__login__contents__member">
				<div class="fb__login-kakao">
					<div class="fb__login-title">
						<div class="title-md">카카오 로그인</div>
						<p class="fb__login-text">카카오 로그인으로 빠르고 간편하게 로그인 하세요.</p>
					</div>
					<a href="<?php echo $TPL_VAR["kakao_login"]?>" class="login-btn-kakao btn-lg" target="_blank"><i class="ico ico-KakaoTalk-BK"></i>카카오 간편 로그인</a>
				</div>
				<!-- 로그인 폼 S-->
				<div class="fb__login-form">
					<div class="fb__login-title">
						<div class="fb__login-text title-sub">또는</div>
						<div class="title-md">일반 로그인</div>
					</div>
					<form id="devLoginForm">
                    <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
						<div class="fb__form-item">
							<label class="hide" for="devUserId">아이디</label>
							<input type="text" placeholder="아이디" class="fb__form-input" name="userId" id="devUserId" title="아이디" value="<?php echo $TPL_VAR["userSaveLoginId"]?>">
						</div>
						<p class="txt-error" devTailMsg="devUserId"></p>
						
						<div class="fb__form-item">
							<label class="hide" for="devUserPassword">비밀번호</label>
							<input type="password" placeholder="비밀번호" class="fb__form-input" name="userPw" id="devUserPassword" autocomplete="on" title="비밀번호">
						</div>
						<p class="txt-error" devTailMsg="devUserPassword"></p>
						<div class="fb__login-error"></div>

						<button class="login__btn login__btn--left btn-lg" id="devLoginSubmitButton">로그인</button>
						<div class="login-option">
							<div class="login-option__checkbox fb__form-item">
								<input type="checkbox" id="c1" name="saveId" value="Y"  <?php echo $TPL_VAR["saveIdChecked"]?>/>
								<label for="c1">자동 로그인</label>
							</div>
							<div class="login-option__link">
								<a href="/member/searchId" class="fb__login__btn--link">아이디 찾기</a>
								<a href="/member/searchPw" class="fb__login__btn--link">비밀번호 찾기</a>
							</div>
						</div>
						<!-- 로그인 오류 메시지 S -->
						<!-- 오류시 노출 / 그 외에 숨김처리 -->
						
						<!-- 로그인 오류 메시지 E -->

<?php if($TPL_VAR["captcha_use"]=="Y"){?>
						<div class="login-option">
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
						</div>
<?php }?>
						<!-- 보안 문자 영역 S -->
						<!-- 숨김처리 해놓음 
						<div class="fb__login-captcha" style="display: none">
							<table>
								<col width="95" />
								<col width="*" />
								<tr>
									<td>
										<img src="" />
									</td>
									<td style="vertical-align: middle">
										<input type="text" name="captcha_text" id="captcha_text_id" value="" tabindex="3" class="vm font_bold size_16" placeholder="문자를 입력해주세요." title="보안문자" />
									</td>
								</tr>
								<input type="hidden" id="captcha_use_id" value="" />
							</table>
						</div>
						 보안 문자 영역 E -->
					</form>

					<!-- 비회원 주문 S -->
					<!-- 숨김처리 해놓음 -->
					<div class="fb__login-nomm--order" style="display: none">
						<button type="button" class="login__btn login__btn__join devNonmemberOrder btn-lg">비회원 구매하기</button>
					</div>
					<!-- 비회원 주문 E -->
				</div>
				<!-- 로그인 폼 E-->
				<div class="fb__login-basic">
					<div class="fb__login-title">
						<div class="title-sm">배럴 회원이 아직 아니신가요?</div>
					</div>
					<a href="/member/joinInput" class="fb__login__btn--link btn-lg">회원가입</a>
				</div>
				<!-- 혜택 S -->
				<div class="fb__login-benefits">
					<div class="fb__login-title">
						<div class="title-sm">배럴 신규 회원 가입 혜택</div>
					</div>
					<div class="join-benefit__list">
						<dl class="join-benefit__item">
							<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img01.png" alt="" /></dt>
							<dd>
								<p>10,000원 할인 쿠폰</p>
								(10만원 구매 이상)
							</dd>
						</dl>
						<dl class="join-benefit__item">
							<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img02.png" alt="" /></dt>
							<dd>
								<p>5,000원 할인 쿠폰</p>
								(5만원 구매 이상)
							</dd>
						</dl>
						<dl class="join-benefit__item">
							<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img03.png" alt="" /></dt>
							<dd>
								<p>구매 금액의 1% 적립금</p>
							</dd>
						</dl>
					</div>
				</div>
				<!-- 혜택 E -->
				<!-- etc S -->
				<div class="fb__login-etc">
					<div class="fb__login-title">
<?php if($TPL_VAR["langType"]=='korean'){?>
						<div class="fb__login-text title-sub">또는</div>
<?php }?>
					</div>
					<div class="fb__login__sns">
						<ul class="sns__login">
<?php if($TPL_VAR["langType"]=='korean'){?>
							<li>
								<a href="<?php echo $TPL_VAR["naver_login"]?>" target="_blank">네이버 로그인</a>
							</li>
							<li>
								<a href="#g-signin2">구글 로그인</a>
								<span class="g-signin2" id="g-signin2" data-onsuccess="onSignIn"></span>
							</li>
<?php }?>
							<li>
								<a href="javascript:void(0)" class="fb__login__nomember" data-target="nomember">비회원 주문조회</a>
							</li>
<?php if($TPL_VAR["isNonMemberBuy"]){?>
							<li>
								<a href="#;">비회원 구매하기</a>
							</li>
<?php }?>
						</ul>
					</div>

				</div>
				<!-- etc E -->
			</div>
			<!-- 로그인 E-->

			<!-- 비회원조회 S -->
			<!-- 숨김처리 해놓음 -->
			<div class="fb__login__contents__nomember" id="nonMemOrder">
				<!-- 로그인 폼 S-->
				<div class="fb__login-form">
					<div class="fb__login-title">
						<div class="title-md">비회원 주문조회</div>
					</div>
					<form id="devNonMemberLoginForm">
						<div class="fb__form-item fb__form-order">
							<label class="fb__form-label" for="devOrderId">주문번호</label>
							<input type="text" id="devOrderId" class="fb__form-input" name="orderId" title="주문번호" placeholder="주문번호" value="" />
						</div>
							<p class="txt-error" devTailMsg="devOrderId"></p>
						<div class="fb__form-item">
							<label class="hide" for="devBuyerName">주문자명</label>
							<input type="text" id="devBuyerName" class="fb__form-input" name="buyerName" title="주문자명" placeholder="주문자명" value="" />
						</div>
						<p class="txt-error" devTailMsg="devBuyerName"></p>
						<div class="fb__form-item">
							<label class="hide" for="devOrderPassword">비회원 주문 패스워드</label>
							<input type="password" id="devOrderPassword" class="fb__form-input" name="orderPassword" title="비회원 주문 패스워드" placeholder="비회원 주문 패스워드" value="" />
						</div>
						<p class="txt-error" devTailMsg="devOrderPassword"></p>
						<div class="fb__login-error"></div>
						<button class="login__btn login__btn--left btn-lg" id="devLoginSubmitButton">비회원 주문조회</button>
						<!-- 오류 메시지 S -->
					</form>
				</div>
				<!-- 로그인 폼 E-->
			</div>
			<!-- 비회원조회 E -->
		</div>
		<!-- 일반 로그인 E -->
<?php }else{?>
		<!-- 카카오 1초 회원가입 S -->
		<div class="fb__login__contents">
			<div class="fb__login-kakao">
				<div class="fb__login-title">
					<div class="title-md">카카오 간편 회원가입</div>
				</div>
				<a href="<?php echo $TPL_VAR["kakao_login"]?>" class="login-btn-kakao btn-lg" target="_blank"> <i class="ico ico-KakaoTalk-BK"></i>카카오로 시작하기</a>
				<p class="fb__login-text">카카오 로그인으로 빠르고 간편하게 로그인 하세요.</p>
			</div>
			<div class="fb__login-basic">
				<div class="fb__login-title">
					<div class="fb__login-text title-sub">또는</div>
					<div class="title-md">일반 회원가입</div>
				</div>
				<a href="/member/joinInput" class="fb__login__btn--link btn-lg">회원가입</a>
			</div>
			<!-- 혜택 S -->
			<div class="fb__login-benefits">
				<div class="fb__login-title">
					<div class="title-sm">배럴 신규 회원 가입 혜택</div>
				</div>
				<div class="join-benefit__list">
					<dl class="join-benefit__item">
						<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img01.png" alt="" /></dt>
						<dd>
							<p>10,000원 할인 쿠폰</p>
							(10만원 구매 이상)
						</dd>
					</dl>
					<dl class="join-benefit__item">
						<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img02.png" alt="" /></dt>
						<dd>
							<p>5,000원 할인 쿠폰</p>
							(5만원 구매 이상)
						</dd>
					</dl>
					<dl class="join-benefit__item">
						<dt><img src="/assets/templet/enterprise/assets/img/join_benefit_img03.png" alt="" /></dt>
						<dd>
							<p>구매 금액의 1% 적립금</p>
						</dd>
					</dl>
				</div>
			</div>
			<!-- 혜택 E -->
		</div>
<?php }?>
		<!-- 카카오 1초 회원가입 E -->
	</section>
	<!-- 컨텐츠 영역 E -->