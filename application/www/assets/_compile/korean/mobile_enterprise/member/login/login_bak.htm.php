<?php /* Template_ 2.2.8 2021/09/17 11:23:12 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/login/login_bak.htm 000013774 */ ?>
<section class="br__login br__login--member br__login--show">
    <h2 class="br__login__title">로그인</h2>
    <div class="br__login__info">
        <div class="information">
            <h3 class="br__hidden">로그인 정보 입력 및 회원가입</h3>

            <form id="devLoginForm">
                <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>
                <div class="information__input">
                    <input type="text" placeholder="아이디" name="userId"
                           id="devUserId" title="아이디" value="<?php echo $TPL_VAR["userSaveLoginId"]?>">
                    <p class="txt-error" devTailMsg="devUserId" ></p>
                </div>
                <div class="information__input">
                    <input type="password" placeholder="비밀번호" name="userPw"
                           id="devUserPassword" title="비밀번호">
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
                    <a href="/member/joinInput" class="information__btn__join">회원가입</a>
                </div>
            </form>

            <p class="information__find">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <a href="/member/searchId">아이디</a> / <a href="/member/searchPw">비밀번호 찾기</a>
<?php }else{?>
                <a href="/member/searchId">Forgot ID</a> / <a href="/member/searchPw">Password</a>
<?php }?>
            </p>

<?php if($TPL_VAR["langType"]=='korean'){?>
            <ul class="information__sns">
                <li class="information__sns__list">

                    <a href="<?php echo $TPL_VAR["naver_login"]?>" class="information__sns__link information__sns__link--naver">네이버로 시작하기</a>

                </li>
                <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="information__sns__link information__sns__link--kakaotalk">카카오톡으로 시작하기</a>
                </li>
                <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["facebook_login"]?>" class="information__sns__link information__sns__link--facebook">페이스북으로 시작하기</a>
                </li>
                <li class="information__sns__list">
                    <a href="#google" class="information__sns__link information__sns__link--google" <?php if($TPL_VAR["appType"]){?>id="appLoginGoogle" data-type="<?php echo $TPL_VAR["appType"]?>"<?php }?>>
                        구글로 시작하기
<?php if(!$TPL_VAR["appType"]){?>
                        <span class="g-signin2" data-onsuccess="onSignIn"></span>
<?php }?>
                    </a>
                </li>
            </ul>
<?php }?>


            <div class="information__btn">
<?php if($TPL_VAR["isNonMemberBuy"]){?>
                <button type="button" class="btn-nomember-buy devNonmemberOrder">비회원 구매하기</button>
<?php }else{?>
                <button type="button" class="information__btn__nomem" id="devLoginSubmitButton">비회원 주문조회</button>
<?php }?>
            </div>
            <div class="information__benefit tatat">
                <h3 class="information__benefit__title">배럴 회원 혜택</h3>
                <ul class="information__benefit__box">
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">회원등급에 따른 <br><strong>쿠폰, 즉시할인 혜택</strong></p>
                    </li>
                    <!-- <li class="information__benefit__list">
                        <p class="information__benefit__desc">배럴 신규회원 <br><strong>즉시 사용가능한 <br>3,000원</strong> 적립금</p>
                    </li> -->
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">회원등급에 따른 <br><strong>구매금액의 <br>1%이상</strong> 적립금</p>
                    </li>
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">3만원 이상 구매시 <br><strong>즉시 사용가능한 <br>3,000원 할인쿠폰</strong></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 2019.07.11 비회원 주문조회 -->
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
            <div class="information__benefit">
                <h3 class="information__benefit__title">배럴 회원 혜택</h3>
                <ul class="information__benefit__box">
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">회원등급에 따른 <br><strong>다양한 적립금, <br>쿠폰, 즉시할인 혜택</strong></p>
                    </li>
                    <!-- <li class="information__benefit__list">
                        <p class="information__benefit__desc">배럴 신규회원 <br><strong>즉시 사용가능한 <br>3,000원</strong></p>
                    </li> -->
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">회원등급에 따라 <br><strong>구매금액의 <br>1%이상</strong> 적립금</p>
                    </li>
                    <li class="information__benefit__list">
                        <p class="information__benefit__desc">3만원 이상 구매시 <br><strong>사용가능한 <br>3000원 할인쿠폰</strong></p>
                    </li>
                </ul>
            </div>
            <div class="information__btn">
                <a href="/member/joinInput" class="information__btn__nomem">회원가입</a>
            </div>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <ul class="information__sns">
                <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["naver_login"]?>" class="information__sns__link information__sns__link--naver">네이버로 시작하기</a>
                </li>
                <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="information__sns__link information__sns__link--kakaotalk">카카오톡으로 시작하기</a>
                </li>
                <li class="information__sns__list">
                    <a href="<?php echo $TPL_VAR["facebook_login"]?>" class="information__sns__link information__sns__link--facebook">페이스북으로 시작하기</a>
                </li>
                <li class="information__sns__list">
                    <a href="#naver" class="information__sns__link information__sns__link--google">구글로 시작하기</a>
                </li>
            </ul>
<?php }?>
        </div>
    </div>
</section>
<!-- EOD : 2019.07.11 비회원 주문조회 -->

<!-- 추후 삭제 예정 -->
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