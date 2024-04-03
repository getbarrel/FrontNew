<?php /* Template_ 2.2.8 2021/10/06 16:56:42 /home/barrel-stage/application/www/assets/templet/enterprise/member/login/login.htm 000012562 */ ?>
<style>
    .box_sec1 {overflow:hidden;}
    .login_kakao_1sec {width:50%; float:left; padding-right:60px;}
    .login_kakao_1sec .login-btn-kakao {width:100%; background:#fee500 url('/assets/templet/enterprise/images/common/icon_login_kakao.png') 20px 19px no-repeat; color:#000; display:block; font-size:16px; margin-top:29px; padding:19px 0; text-align:center;}

    .fb__login__subtitle2 {clear: both; padding: 0 0 20px 0; color: #000; font-size: 24px; font-weight: 600; text-align: left;}
    .fb__login__btn--subtitle {color:#666;}
    .fb__login__btn--subtitle strong {color:#000;}

    .join_benefit {width:50%; float:right; padding-left:60px;}
    .join_benefit .join_benefit_txt {margin-top:19px;}
    .join_benefit .join_benefit_txt li {width:33%; border-left:#e8e8e8 1px solid; color:#666; display:inline-block; float:left; line-height:22px; padding-left:19px;}
    .join_benefit .join_benefit_txt li:first-child {border-left:none; padding-left:0;}
    .join_benefit .join_benefit_txt li p {color:#000; font-size:16px; padding-bottom:30px;}
    .join_benefit .join_benefit_txt li strong {color:#000; font-size:14px; font-weight:700;}

    .contour_sec {height:1px; background-color:#ebebeb; margin:40px 0 44px; position:relative;}
    .contour_sec span {background-color:#fff; color:#999; display:inline-block; padding:0 20px; left:50%; margin-left:-34px; position:absolute; top:-8px;}
    
    .fb__login__btn--title {padding-bottom:5px;}
    .fb__login__btn--link {margin:15px 0 20px;}

    .fb__login__sns .sns__login {padding-top:5px;}
    .fb__login__sns .sns__login li {width:360px; margin-right:calc((100% - 1020px) / 3);}



    /* 카카오 1초 회원가입 */
    .box_sec2 {width:510px; margin:0 auto; overflow:hidden;}
    .login_kakao_1sec2 {width:100%;}
    .login_kakao_1sec2 .login-btn-kakao {width:100%; background:#fee500 url('/assets/templet/enterprise/images/common/icon_login_kakao.png') 20px 19px no-repeat; color:#000; display:block; font-size:16px; margin-top:29px; padding:19px 0; text-align:center;}

    .join_benefit2 {margin-top:50px; overflow:hidden;}
    .join_benefit2 .join_benefit_txt2 {margin-top:19px;}
    .join_benefit2 .join_benefit_txt2 li {width:33%; border-left:#e8e8e8 1px solid; color:#666; display:inline-block; float:left; line-height:22px; padding-left:19px;}
    .join_benefit2 .join_benefit_txt2 li:first-child {border-left:none; padding-left:0;}
    .join_benefit2 .join_benefit_txt2 li p {color:#000; font-size:16px; padding-bottom:30px;}
    .join_benefit2 .join_benefit_txt2 li strong {color:#000; font-size:14px; font-weight:700;}

    .btn-link2 {border:#cfcfcf 1px solid; color:#666;}
</style>

<section class="fb__login">
    <!--<header  class="fb__login__header">
        <h2 class="fb__login__title">Sign in</h2>
        <p  class="fb__login__summary">Welcome. Sign in and enjoy a variety of benefits.</p>
    </header>-->
<?php if($TPL_VAR["wg_is_kakao_page"]=='F'){?>
    <div class="fb__login__contents">
        <div class="box_sec1">
            <div class="login_kakao_1sec">
                <h2 class="fb__login__subtitle2">로그인</h2>
                <p class="fb__login__btn--subtitle">매번 아이디와 비밀번호 입력없이<br /><strong>카카오 1초 로그인</strong>으로 간편하게 로그인 하세요.</p>
                <!-- <a href="/member/login?url=<?php echo $TPL_VAR["url"]?>&kakao=one" class="login-btn-kakao">카카오 1초 로그인 / 회원가입</a> -->
				<a href="<?php echo $TPL_VAR["kakao_login"]?>" class="login-btn-kakao" target="_blank">카카오 1초 로그인 / 회원가입</a>
				
            </div>
            <div class="join_benefit">
                <h2 class="fb__login__subtitle2">배럴 회원 혜택</h2>
                <ul class="join_benefit_txt">
                    <li><p>01</p>회원등급에 따른<br /><strong>쿠폰, 즉시할인<br />혜택</strong></li>
                    <li><p>02</p>회원등급에 따른<br /><strong>구매금액의 1%이상<br />적립금</strong></li>
                    <li><p>03</p>3만원 이상 구매 시<br /><strong>즉시 사용가능한 3000원<br />할인쿠폰</strong></li>
                </ul>
            </div>
        </div>
        <div class="contour_sec">
            <span>또는</span>
        </div>
        <div class="login__left">
            <nav class="login__left__nav">
            <a href="#" class="fb__login__member fb__login--active" data-target="member">
                Sign in
            </a>
            <a href="#" class="fb__login__nomember" data-target="nomember">
                Guest Checkout
            </a>
			</nav>
            <div class="login__left__box">
            <div class="fb__login__contents__member fb__login__contents--show">
                <form id="devLoginForm">
                    <input type="hidden" name="url" value="<?php echo $TPL_VAR["url"]?>"/>

                    <input type="text" placeholder="ID" class="" name="userId"
                           id="devUserId" title="ID" value="<?php echo $TPL_VAR["userSaveLoginId"]?>">
                    <p class="txt-error" devTailMsg="devUserId"></p>

                    <input type="password" placeholder="Password" class="mat10" name="userPw"
                           id="devUserPassword" title="Password">
                    <p class="txt-error" devTailMsg="devUserPassword"></p>

                    <button class="login__btn login__btn--left" id="devLoginSubmitButton">Sign in</button>
                   <!-- <a href="" class="login__btn login__btn&#45;&#45;right">Join</a>-->
                    <div class="login-option">
                        <input type="checkbox" id="c1" name="saveId" value="Y" <?php echo $TPL_VAR["saveIdChecked"]?>>
                        <label for="c1">Keep me logged in </label>
                        <!--<ul class="login-option__wrap">
                            <li class="login-option__sch login-option__sch-id">
                                <a href="/member/searchId">Forgot ID</a>
                            </li>
                            <li class="login-option__sch login-option__sch-pw">
                                <a href="/member/searchPw">Find Password</a>
                            </li>
                            &lt;!&ndash;<li class="login-option__sch login-option__sch-join">
                                <a href="/member/joinSelect">Join</a>
                            </li>&ndash;&gt;
                        </ul>-->
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



                </form>
<?php if($TPL_VAR["isNonMemberBuy"]){?>
                    <button type="button" class="login__btn login__btn__join devNonmemberOrder">비회원 구매하기</button>
<?php }?>
            </div>
            <div class="fb__login__contents__nomember">
                <form id="devNonMemberLoginForm">
                    <input type="text" placeholder="Name" class="" name="buyerName"
                           id="devBuyerName" title="Name">
                    <p class="txt-error" devTailMsg="devBuyerName"></p>

                    <input type="text" placeholder="Order No." class="mat10" name="orderId"
                           id="devOrderId" title="Order No.">
                    <p class="txt-error" devTailMsg="devOrderId"></p>

                    <input type="password" placeholder="Guest Password" class="mat10"
                           name="orderPassword" id="devOrderPassword" title="Guest Password">
                    <p class="txt-error" devTailMsg="devOrderPassword"></p>

                    <button class="btn-lg btn-full mat10" id="devNonMemberLoginSubmitButton">Your Orders
                    </button>
                </form>
                <!--<p class="fb__login__contents__annc">
                    If you forgot your order No., <span>please contact us(help_en@getbarrel.com). </span>
                </p>-->
            </div>
        </div>
        </div>
        <div class="fb__login__btn">
            <h3 class="fb__login__btn--title">일반 회원가입</h3>
            <div class="fb__login__btn--desc">
                <p class="fb__login__btn--subtitle">아직 BARREL 회원이 아니신가요? <br>회원가입 후 다양한 혜택과 소식을 받아보세요!</p>
                <a href="/member/joinInput" class="fb__login__btn--link">일반 회원가입</a>
            </div>
            <div class="fb__login__btn--desc">
                <p class="fb__login__btn--subtitle">Did you forget your ID or password? <br>You can find the lost information by entering simple information.</p>
                <a href="/member/searchId" class="fb__login__btn--link">Forgot ID/PW</a>
            </div>
        </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
        <div class="fb__login__sns">
            <div class="contour_sec">
                <span>또는</span>
            </div>

            <!-- <h2 class="fb__login__subtitle">SNS 간편로그인</h2> -->
            <ul class="sns__login">
                <li>
                    <a href="<?php echo $TPL_VAR["naver_login"]?>" target="_blank"><span class="sns__login--naver"></span>Start with Naver</a>
                </li>
                <!-- <li>
                    <a href="<?php echo $TPL_VAR["kakao_login"]?>" target="_blank"><span class="sns__login--kakao"></span>start with Kakao Talk</a>
                </li> -->
                <li>
                    <a href="<?php echo $TPL_VAR["facebook_login"]?>" target="_blank"><span class="sns__login--facebook"></span>Start with Facebook</a>
                </li>
                <li>
                    <a href="#g-signin2"><span class="sns__login--google"></span>start with Google</a>
                    <span class="g-signin2" id="g-signin2" data-onsuccess="onSignIn"></span>
                </li>
            </ul>
        </div>
<?php }?>
    </div>
<?php }else{?>
    <!-- [s] 카카오 1초 회원가입 -->
    <div class="fb__login__contents">
        <div class="box_sec2">
            <div class="login_kakao_1sec2">
                <h2 class="fb__login__subtitle2">회원가입</h2>
                <p class="fb__login__btn--subtitle">매번 아이디와 비밀번호 입력없이<br /><strong>카카오 1초 로그인</strong>으로 간편하게 로그인 하세요.</p>
                <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="login-btn-kakao" target="_blank">카카오 1초 회원가입</a>
            </div>
            <div class="join_benefit2">
                <h2 class="fb__login__subtitle2">배럴 회원 혜택</h2>
                <ul class="join_benefit_txt2">
                    <li><p>01</p>회원등급에 따른<br /><strong>쿠폰, 즉시할인<br />혜택</strong></li>
                    <li><p>02</p>회원등급에 따른<br /><strong>구매금액의 1%이상<br />적립금</strong></li>
                    <li><p>03</p>3만원 이상 구매 시<br /><strong>즉시 사용가능한 3000원<br />할인쿠폰</strong></li>
                </ul>
            </div>
            <div class="contour_sec">
                <span>또는</span>
            </div>
            <a href="/member/joinInput" class="fb__login__btn--link btn-link2">일반 회원가입</a>
        </div>
    </div>
<?php }?>
    <!-- [e] 카카오 1초 회원가입 -->
</section>