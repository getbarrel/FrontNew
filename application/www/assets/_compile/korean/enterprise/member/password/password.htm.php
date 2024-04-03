<?php /* Template_ 2.2.8 2024/02/06 13:25:19 /home/barrel-stage/application/www/assets/templet/enterprise/member/password/password.htm 000016921 */ ?>
<!-- 컨텐츠 영역 S -->
<!-- 정기 비밀번호 수정 S -->
<?php if($TPL_VAR["changeType"]=='regular'){?>
<section class="fb__password">
	<div class="fb__password-wrap">
		<div class="password__header">
			<h2 class="password__title title-md">비밀번호 변경</h2>
			<p class="password__summary">
				비밀번호 사용기간이 <?php echo $TPL_VAR["changePasswordDay"]?>일이 지나 개인정보 보호를 위해 비밀번호를<br />
				변경해주세요.
			</p>
		</div>
		<div class="password__content">
			<form id="devForm" class="password__form">
				<ul class="password__group">
					<li class="password__item fb__form-item">
						<label for="devUserPassword" class="hide">새로운 비밀번호</label>
						<input type="password" id="devUserPassword" class="fb__form-input" name="pw" title="새로운 비밀번호" placeholder="새로운 비밀번호" value="" />
						<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
					</li>
					<li class="password__item fb__form-item">
						<label for="devUserPassword" class="hide">새로운 비밀번호 확인</label>
						<input type="password" id="devUserComparePassword" class="fb__form-input" name="comparePw" title="새로운 비밀번호 확인" placeholder="새로운 비밀번호 확인" value="" />
						<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
					</li>
				</ul>
				<div class="password__info">
					<p>영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>

					<!-- 패스워드 오류 메시지 S -->
					<!-- 오류시 노출 / 그 외에 숨김처리 -->
					<p class="txt-error" devTailMsg="devUserPassword"></p>
					<p class="txt-error" devTailMsg="devUserComparePassword"></p>
					<!-- 패스워드 오류 메시지 E -->
				</div>
			</form>
		</div>
		<div class="password__footer">
			<button type="button" class="btn-lg btn-dark-line" id="devSubmitButton">비밀번호 변경하기</button>
			<button type="button" class="btn-lg btn-gray-line" id="devContinueButton"><?php echo $TPL_VAR["changePasswordContinueDay"]?>일 후에 변경하기</button>
			<p>배럴 공식 홈페이지에서 <?php echo $TPL_VAR["changePasswordDay"]?>일 이상 비밀번호를 변경하지 않고 동일한 비밀번호를 사용하시는 경우, 개인정보 보호를 위해 비밀번호 변경 안내를 하고 있습니다.</p>
		</div>
	</div>
</section>
<?php }?>
<!-- 정기 비밀번호 수정 E -->


<!-- 휴먼 회원 S -->
<?php if($TPL_VAR["changeType"]=='sleep'){?>
<section class="fb__password fb__sleep-pw">
	<div class="fb__password-wrap">
		<div class="password__header">
			<h2 class="password__title title-md">휴면 회원 안내</h2>
			<p class="password__summary">회원님의 비밀번호를 변경해 주세요.</p>
			<p class="password__summary">휴면계정 해제를 위해서는 아래 입력 방법을 참고하여 비밀번호를 변경해 주시기 바랍니다.</p>
		</div>
		<div class="password__content">
			<form id="devForm" class="password__form">
				<ul class="password__group">
					<li class="password__item fb__form-item">
						<label for="devUserPassword" class="hide">새로운 비밀번호</label>
						<input type="password" id="devUserPassword" class="fb__form-input" name="pw" title="새로운 비밀번호" placeholder="새로운 비밀번호" value="" />
						<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
					</li>
					<li class="password__item fb__form-item">
						<label for="devUserPassword" class="hide">새로운 비밀번호 확인</label>
						<input type="password" id="devUserComparePassword" class="fb__form-input" name="comparePw" title="새로운 비밀번호 확인" placeholder="새로운 비밀번호 확인" value="" />
						<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
					</li>
				</ul>
				<div class="password__info">
					<p>영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>

					<!-- 패스워드 오류 메시지 S -->
					<!-- 오류시 노출 / 그 외에 숨김처리 -->
					<p class="txt-error" devTailMsg="devUserPassword"></p>
					<p class="txt-error" devTailMsg="devUserComparePassword"></p>
					<!-- 패스워드 오류 메시지 E -->
				</div>
			</form>
		</div>
		<div class="password__footer">
			<button type="button" class="btn-lg btn-dark-line" id="devSubmitButton">비밀번호 변경하기</button>
		</div>
	</div>
</section>
<?php }?>
<!-- 휴먼 회원 E -->

<?php if($TPL_VAR["changeType"]==''){?>
<section class="fb__member-search fb__search-result fb__password-reset">
	<div class="search">
		<!-- 패스워드 변경 S -->
		<div class="search__wrap search__wrap-show">
			<div class="search__header">
				<h2 class="search__title title-md">비밀번호 재설정</h2>
				<p>
					입력하신 정보가 정상적으로 확인되어<br />
					비밀번호 재설정을 요청드립니다.
				</p>
			</div>
			<div id="search__password" class="search__content">
				<form id="devForm" class="fb__password-form">
					<div class="fb__password-group">
						<div class="fb__password-item fb__form-item">
							<label class="fb__password__label hide" for="devUserPassword">새로운 비밀번호</label>
							<input type="password" id="devUserPassword" class="fb__form-input" name="pw" title="새로운 비밀번호" placeholder="새로운 비밀번호" value="qwert12345" />
							<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
						</div>
						<div class="fb__password-item fb__form-item">
							<label class="fb__password__label hide" for="devUserComparePassword">새로운 비밀번호 확인</label>
							<input type="password" id="devUserComparePassword" class="js__check__pw fb__form-input" name="comparePw" title="새로운 비밀번호 확인" placeholder="새로운 비밀번호 확인" value="qwert12345" />
							<button type="button" class="btn-pw--visibility"><i class="ico ico-eye-hide"></i>비밀번호 확인 버튼</button>
						</div>
						<div class="fb__password-desc">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</div>

						<!-- 패스워드 오류 메시지 S -->
						<!-- 오류시 노출 / 그 외에 숨김처리 -->
						<div class="fb__password-error txt-error txt-red" devTailMsg="devUserPassword"></div>
						<div class="fb__password-error txt-error txt-red" devTailMsg="devUserComparePassword"></div>
						<!-- 패스워드 오류 메시지 E -->
					</div>
					<div class="fb__password-footer">
						<button type="button" class="btn-lg btn-dark-line" id="devSubmitButton">비밀번호 재설정</button>
					</div>
				</form>
			</div>
		</div>
		<!-- 패스워드 변경 E -->
		<!-- 패스워드 변경 성공 S -->
		<div id="search__id" class="search__wrap search__content">
			<div class="search__header">
				<h2 class="search__title title-md">비밀번호 변경 완료</h2>
				<p><?php echo $TPL_VAR["userName"]?> 회원님의 비밀번호가 정상적으로 변경되었습니다.</p>
			</div>
			<div class="search__content">
				<div class="search__footer">
					<a href="/member/login" class="btn-lg btn-dark-line">로그인</a>
				</div>
			</div>
		</div>
		<!-- 패스워드 변경 성공 E -->
	</div>
</section>
<?php }?>
<!-- 컨텐츠 영역 E -->


<!-- 1. 정기, 휴먼회원 비밀번호 수정-- 
<?php if($TPL_VAR["changeType"]=='regular'||$TPL_VAR["changeType"]=='sleep'){?>-- 
<section class="fb__password <?php if($TPL_VAR["changeType"]=='sleep'){?>fb__sleep-pw<?php }?>">
    <div class="password <?php if($TPL_VAR["changeType"]=='regular'){?>password<?php }?>">

<?php if($TPL_VAR["changeType"]=='regular'){?>
        <!--정기 비밀번호 수정-- 
        <header class="password__header">
            <h2 class="password__header-title">회원님의 비밀번호를 변경해 주세요.</h2>
            <p class="password__header-summary">
                비밀번호를 변경하지 <?php echo $TPL_VAR["changePasswordDay"]?>일이 지난 경우<br/>
                아래 입력 방법을 참고하여 비밀번호를 변경해주시기 바랍니다.<br/>
                정기적인 비밀번호 변경은 회원님의 소중한 개인 정보를 보호할 수 있습니다.
            </p>
        </header>

<?php }elseif($TPL_VAR["changeType"]=='sleep'){?>
        <!--휴먼회원 비밀번호 수정-- 
        <header class="password__header">
            <h2 class="password__header-title">휴면 계정 전환 안내</h2>
            <ul class="step-box">
                <li class="step-box__list step-box__list--agreement">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number">STEP 01</span>
                        <p class="step-box__list__title">
                            약관동의
                        </p>
                    </div>
                </li>
                <li class="step-box__list step-box__list--password">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number on">STEP 02</span>
                        <p class="step-box__list__title">
                            비밀번호 변경
                        </p>
                    </div>
                </li>
                <li class="step-box__list step-box__list--end">
                    <div class="step-box__list__txt">
                        <span class="step-box__list__number">STEP 03</span>
                        <p class="step-box__list__title">
                            계정 활성화
                        </p>
                    </div>
                </li>
            </ul>
        </header>
<?php }else{?>-- 
        <header class="password__header">
            <h2 class="password__header-title">회원님의 비밀번호를 변경해주세요.</h2>
            <p class="password__header-summary">
                비밀번호를 변경한지 <?php echo $TPL_VAR["changePasswordDay"]?>일이 지난 경우<br/>
                아래 입력 방법을 참고하여 비밀번호를 변경해 주세요.<br/>
                정기적인 비밀번호 변경은 회원님의 소중한 개인 정보를 보호할 수 있습니다.
            </p>
        </header>
<?php }?>-- 
    </div>


    <div class="wrap-password-layout <?php if($TPL_VAR["changeType"]=='regular'){?>type02 <?php }elseif($TPL_VAR["changeType"]=='sleep'){?>sleep-type<?php }?>">
<?php if($TPL_VAR["changeType"]=='sleep'){?>-- 
        <div class="sleep-subtitle-area">
            <div class="fb__sleep-complete__content">
                <p class="fb__sleep-complete__content--big">회원님의 비밀번호를 변경해 주세요.</p>
                <p class="fb__sleep-complete__content--small">
                    휴면계정 해제를 위해서는 아래 입력 방법을 참고하여 비밀번호를 변경해 주시기 바랍니다.
                </p>
            </div>
        </div>
<?php }?>-- 

        <form id="devForm" class="js__pw__form fb__password__form">
            <div class="fb__password__form-inner" style="width:450px;">
                <div class="fb__password__input" >
                    <label class="fb__password__label" for="devUserPassword">새 비밀번호</label>
                    <input class="js__pw" type="password" name="pw" id="devUserPassword" title="새 비밀번호">
                    <p class="txt-error" devTailMsg="devUserPassword" style="margin-left:140px;"></p>
                </div>
                <div class="fb__password__input">
                    <label for="devUserPassword">새 비밀번호 확인</label>
                    <input class="js__check__pw" type="password" id="devUserComparePassword" name="comparePw" title="새 비밀번호 확인">
                    <p class="txt-error" devTailMsg="devUserComparePassword" style="margin-left:140px;"></p>
                    <p class="fb__password__desc">영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력</p>
                </div>
            </div>

<?php if($TPL_VAR["changeType"]=='regular'){?>-- 
            <div class="fb__sleep__btn">
                <button class="fb__sleep__btn--black" id="devContinueButton"><?php echo $TPL_VAR["changePasswordContinueDay"]?>일 후 재알림</button>
                <button class="fb__sleep__btn--point" id="devSubmitButton">비밀번호 변경</button>
            </div>
<?php }elseif($TPL_VAR["changeType"]=='sleep'){?>-- 
            <div class="fb__sleep__btn">
                <!--<button class="btn-lg btn-point" id="devSubmitButton">30일후 재알림</button>-- 
                <button class="fb__sleep__btn--black" id="devSubmitButton">취소</button>
                <button class="fb__sleep__btn--point" id="devSubmitButton">확인</button>
            </div>
<?php }else{?>-- 
            <div class="fb__sleep__btn">
                <button class="fb__sleep__btn--black" id="devSubmitButton">30일후 재알림</button>
                <button class="fb__sleep__btn--point" id="">비밀번호 변경</button>
            </div>
<?php }?>-- 
        </form>
    </div>
</section>
<?php }else{?>






<!-- 비밀번호 찾기 -- 
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">아이디/비밀번호 찾기</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchIdResult" class="fb__tab-link">
                아이디
            </a>
            <a href="/member/password" class="fb__tab-link fb__tab-link--active">
                비밀번호
            </a>
        </nav>
        <!-- [S] 패스워드 변경 성공 -- 
        <section class="fb__password-reset">

            <div id="search__id" class="search__content search__content">
                <strong><?php echo $TPL_VAR["userName"]?> 회원님의 비밀번호가 성공적으로 변경되었습니다.</strong>
                <p>해당 계정으로 로그인하시면 배럴의 모든 서비스를 이용하실 수 있습니다.</p>
                <p>앞으로도 많은 이용과 관심 부탁드립니다.</p>
                <div class="search__other-link">
                    <a href="/" class="button-black">홈으로</a>
                    <a href="/member/login">로그인</a>
                </div>
            </div>
            <!-- [E] 패스워드 변경 성공 -- 

            <div id="search__password" class="search__content search__content--show">
                <header class="fb__password-reset__header">
                    <h2 class="fb__password-reset__title">비밀번호 재설정</h2>
                    <p class="fb__password-reset__summary">
                        회원님의 계정 비밀번호를 재설정 해주세요.<br/>
                    </p>
                </header>
                <form id="devForm" class="fb__password__form">
                    <div class="fb__password__form-inner" style="width:450px;">
                        <div class="fb__password__input" >
                            <label class="fb__password__label" for="devUserPassword">새 비밀번호</label>
                            <input type="password" name="pw" id="devUserPassword" title="새 비밀번호">
                            <p class="txt-error" devTailMsg="devUserPassword" style="margin-left:140px;"></p>
                        </div>
                        <div class="fb__password__input">
                            <label for="devUserComparePassword">새 비밀번호 확인</label>
                            <input class="js__check__pw" type="password" id="devUserComparePassword" name="comparePw" title="새 비밀번호 확인">
                            <p class="fb__password__error txt-error" devTailMsg="devUserComparePassword"  style="margin-left:140px;"></p>
                            <p class="fb__password__desc">영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력</p>
                        </div>
                    </div>

                    <div class="fb__sleep__btn">
                        <button class="fb__sleep__btn--point" id="devSubmitButton">확인</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</section>


<?php }?>