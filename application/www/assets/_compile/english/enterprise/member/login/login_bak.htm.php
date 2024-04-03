<?php /* Template_ 2.2.8 2021/09/17 11:15:04 /home/barrel-stage/application/www/assets/templet/enterprise/member/login/login_bak.htm 000008647 */ ?>
<section class="fb__login">
    <!--<header  class="fb__login__header">
        <h2 class="fb__login__title">Sign in</h2>
        <p  class="fb__login__summary">Welcome. Sign in and enjoy a variety of benefits.</p>
    </header>-->
    <div class="fb__login__contents">
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
            <h3 class="fb__login__btn--title">Join</h3>
            <div class="fb__login__btn--desc">
                <p class="fb__login__btn--subtitle">Aren&#39;t you BARREL member yet? <br>After joining membership, get a variety of benefits and news!</p>
                <a href="/member/joinInput" class="fb__login__btn--link">Join</a>
            </div>
            <div class="fb__login__btn--desc">
                <p class="fb__login__btn--subtitle">Did you forget your ID or password? <br>You can find the lost information by entering simple information.</p>
                <a href="/member/searchId" class="fb__login__btn--link">Forgot ID/PW</a>
            </div>
        </div>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <div class="fb__login__sns">
            <h2 class="fb__login__subtitle">SNS 간편로그인</h2>
            <ul class="sns__login">
                <li>


                    <a href="<?php echo $TPL_VAR["naver_login"]?>" target="_blank"><span class="sns__login--naver"></span>Start with Naver</a>

                </li>
                <li>
                    <a href="<?php echo $TPL_VAR["kakao_login"]?>" target="_blank"><span class="sns__login--kakao"></span>start with Kakao Talk</a>
                </li>
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
        <h2 class="fb__login__subtitle">Membership Guide</h2>
        <div class="fb__login__benefit">
            <ul class="benefit__wrap">
                <li class="benefit__wrap__list" style="width:33.3%">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/login/br_login_icon_a.png" alt="로그인 혜택 아이콘">
                    <p class="number">01</p>
                    <p>회원등급에 따른 <br><strong>쿠폰, 즉시할인 혜택</strong></p>
                </li>
                <!-- <li class="benefit__wrap__list">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/login/icon_benefit_b.png" alt="로그인 혜택 아이콘">
                    <p class="number">02</p>
                    <p><strong>$3 reward</strong></p>
                </li> -->
                <li class="benefit__wrap__list" style="width:33.3%">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/login/icon_benefit_c.png" alt="로그인 혜택 아이콘">
                    <p class="number">02</p>
                    <p>회원등급에 따른 <br><strong>구매금액의 <br>1%이상</strong> 적립금</p>
                </li>
                <li class="benefit__wrap__list" style="width:33.3%">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/login/icon_benefit_d.png" alt="로그인 혜택 아이콘">
                    <p class="number">03</p>
                    <p>3만원 이상 구매시 <br><strong>즉시 사용가능한 <br>3,000원 할인쿠폰</strong></p>
                </li>
            </ul>
        </div>
    </div>
</section>