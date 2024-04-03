<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/search_id/search_id.htm 000009894 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>

<!-- 2019.07.11 아이디 찾기 -->
<section class="br__find-user">
    <h2 class="br__find-user__title">Forgot ID/PW</h2>

    <div class="br__tabs">
        <ul class="br__tabs__list">
            <li class="br__tabs__box">
                <a href="/member/searchId" class="br__tabs__btn br__tabs__btn--active">ID</a>
            </li>
            <li class="br__tabs__box">
                <a href="/member/searchPw" class="br__tabs__btn">Password</a>
            </li>
        </ul>
        <div class="br__tabs__content">
            <div class="br__find-user__label">
                <label><input type="radio" name="searchType" data-type="email" checked><span>Email</span></label>
                <label><input type="radio" name="searchType" data-type="phone"><span>Tel</span></label>
            </div>


            <!-- 이메일주소로 아이디 찾기 -->
            <div class="br__find-user__form br__find-user__form--email br__find-user__form--show">
                <form id="devSearchEmailForm">
                    <div class="find-user">
                        <div class="find-user__input">
                            <input type="text" name="devUserName" id="devUserName"  placeholder="Name" title="Name">
                        </div>
                        <div class="find-user__input find-user__input__email">
                            <input type="text" name="devUserEmail1" id="devUserEmail1" class="find-user__input__email--id" placeholder="" title="Email">
                            <span class="find-user__input__email--at">@</span>
                            <input type="text" name="devUserEmail2" id="devUserEmail2" class="find-user__input__email--adress" title="Email">
                        </div>
                        <div class="find-user__input">
                            <select id="devEmailHostSelect">
                                <option value="">Select E-mail</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                            </select>
                        </div>
                        <div class="find-user__btn">
                            <button class="find-user__btn__submit" id="devUserEmailSubmitButton">Accept</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- EOD : 이메일주소로 찾기 -->


            <!-- 휴대폰으로 아이디 찾기 -->
            <div class="br__find-user__form br__find-user__form--phone br__find-user__form--show">
                <form id="devSearchPhoneForm">
                    <div class="find-user">
                        <div class="find-user__input">
                            <input type="text" name="devUser" id="devUser" placeholder="Name" title="Name">
                        </div>
                        <div class="find-user__input find-user__input__phone">
                            <select name="devHp1" id="devHp1" title="Tel">
                                <option value="010">010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>
                            <span class="find-user__input__phone--hyphen">-</span>
                            <input type="text" name="devHp2" id="devHp2" title="Tel">
                            <span class="find-user__input__phone--hyphen">-</span>
                            <input type="text" name="devHp3" id="devHp3" title="Tel">
                        </div>
                        <div class="find-user__btn">
                            <button class="find-user__btn__submit" id="devUserPhoneSubmitButton">Accept</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 휴대폰으로 아이디 찾기 -->

        </div>
        <!-- EOD : br__tabs -->
    </div>
    <!-- EOD : br__find-user -->
</section>
<!-- EOD : 2019.07.11 아이디 찾기 -->

<?php }else{?>

<!-- @TODO 글로벌 수정영역 -->
<!-- 2019.07.11 아이디 찾기 -->
<section class="br__find-user">
    <h2 class="br__find-user__title">Forgot ID/PW</h2>

    <div class="br__tabs">
        <ul class="br__tabs__list">
            <li class="br__tabs__box">
                <a href="/member/searchId" class="br__tabs__btn br__tabs__btn--active">ID</a>
            </li>
            <li class="br__tabs__box">
                <a href="/member/searchPw" class="br__tabs__btn">Password</a>
            </li>
        </ul>
        <div class="br__tabs__content">
            <div class="br__find-user__label">
                <label><input type="radio" name="searchType" data-type="email" checked><span>Email</span></label>
                <!--<label><input type="radio" name="searchType" data-type="phone"><span>Tel</span></label>-->
            </div>


            <!-- 이메일주소로 아이디 찾기 -->
            <div class="br__find-user__form br__find-user__form--email br__find-user__form--show">
                <form id="devSearchEmailForm">
                    <div class="find-user">
                        <!--<div class="find-user__input">-->
                            <!--<input type="text" name="devUserName" id="devUserName"  placeholder="Name" title="Name">-->
                        <!--</div>-->
                        <div class="find-user__input find-user__input__email">
                            <input type="text" name="devUserEmail1" id="devUserEmail1" class="find-user__input__email--id" placeholder="" title="Email">
                            <span class="find-user__input__email--at">@</span>
                            <input type="text" name="devUserEmail2" id="devUserEmail2" class="find-user__input__email--adress" title="Email">
                        </div>
                        <!--<div class="find-user__input">-->
                            <!--<select id="devEmailHostSelect">-->
                                <!--<option value="">Select E-mail</option>-->
                                <!--<option value="naver.com">naver.com</option>-->
                                <!--<option value="gmail.com">gmail.com</option>-->
                                <!--<option value="hotmail.com">hotmail.com</option>-->
                                <!--<option value="hanmail.net">hanmail.net</option>-->
                                <!--<option value="daum.net">daum.net</option>-->
                                <!--<option value="nate.com">nate.com</option>-->
                            <!--</select>-->
                        <!--</div>-->
                        <div class="find-user__btn">
                            <button class="find-user__btn__submit" id="devUserEmailSubmitButton">Accept</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- EOD : 이메일주소로 찾기 -->


            <!-- 휴대폰으로 아이디 찾기 -->
            <!--<div class="br__find-user__form br__find-user__form&#45;&#45;phone br__find-user__form&#45;&#45;show">-->
                <!--<form id="devSearchPhoneForm">-->
                    <!--<div class="find-user">-->
                        <!--<div class="find-user__input">-->
                            <!--<input type="text" name="devUser" id="devUser" placeholder="Name" title="Name">-->
                        <!--</div>-->
                        <!--<div class="find-user__input find-user__input__phone">-->
                            <!--<select name="devHp1" id="devHp1" title="Tel">-->
                                <!--<option value="010">010</option>-->
                                <!--<option value="011">011</option>-->
                                <!--<option value="016">016</option>-->
                                <!--<option value="017">017</option>-->
                                <!--<option value="018">018</option>-->
                                <!--<option value="019">019</option>-->
                            <!--</select>-->
                            <!--<span class="find-user__input__phone&#45;&#45;hyphen">-</span>-->
                            <!--<input type="text" name="devHp2" id="devHp2" title="Tel">-->
                            <!--<span class="find-user__input__phone&#45;&#45;hyphen">-</span>-->
                            <!--<input type="text" name="devHp3" id="devHp3" title="Tel">-->
                        <!--</div>-->
                        <!--<div class="find-user__btn">-->
                            <!--<button class="find-user__btn__submit" id="devUserPhoneSubmitButton">Accept</button>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</form>-->
            <!--</div>-->
            <!-- 휴대폰으로 아이디 찾기 -->

        </div>
        <!-- EOD : br__tabs -->
    </div>
    <!-- EOD : br__find-user -->
</section>
<!-- EOD : 2019.07.11 아이디 찾기 -->

<?php }?>