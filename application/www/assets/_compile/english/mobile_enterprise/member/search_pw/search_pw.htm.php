<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/search_pw/search_pw.htm 000007980 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__find-user">
    <h2 class="br__find-user__title">Forgot ID/PW</h2>
    <div class="br__tabs">
        <ul class="br__tabs__list">
            <li class="br__tabs__box">
                <a href="/member/searchId" class="br__tabs__btn">ID</a>
            </li>
            <li class="br__tabs__box">
                <a href="/member/searchPw" class="br__tabs__btn br__tabs__btn--active">Password</a>
            </li>
        </ul>
        <div class="br__tabs__content">
            <form id="devSearchEmailForm">
                <div class="br__find-user__label">
                    <label><input type="radio" name="searchType" value="email" checked><span>Email</span></label>
                    <label><input type="radio" name="searchType" value="phone"><span>Tel</span></label>
                </div>

                <!-- 2019.07.11 이메일로 비밀번호 찾기 -->
                <div class="br__find-user__form" style="display: block">
                    <div class="find-user">
                        <div class="find-user__input">
                            <input type="text" name="userId" id="devUserId" value="" placeholder="ID" title="ID">
                        </div>
                        <div class="find-user__input">
                            <input type="text" name="userName" id="devUserName" value="" placeholder="Name" title="Name">
                        </div>

                        <div class="find-user__input find-user__input__email email_group">
                            <input type="text" name="userEmail1" id="devUserEmail1" class="find-user__input__email--id" value="" placeholder="" title="Email">
                            <span class="find-user__input__email--at">@</span>
                            <input type="text" name="userEmail2" id="devUserEmail2" class="find-user__input__email--adress" value="" title="Email">
                        </div>
                        <div class="find-user__input email_group">
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

                        <div class="find-user__input find-user__input__phone phone_group" style="display: none">
                            <select name="pcs1" id="devPcs1" title="Tel">
                                <option value="010">010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>
                            <span class="find-user__input__phone--hyphen">-</span>
                            <input type="text" name="pcs2" id="devPcs2" value="" title="Tel">
                            <span class="find-user__input__phone--hyphen">-</span>
                            <input type="text" name="pcs3" id="devPcs3" value="" title="Tel">
                        </div>

                        <div class="find-user__input find-user__input__certify">
                            <button type="button" id="devCertRequestBtn" class="find-user__input__certify--btn">Request authentication number</button>
                            <div class="find-user__input__certify--box">
                                <input type="text" name="certNo" id="devCertNo" class="find-user__input__certify--box--input" placeholder="Authentication number" title="Authentication number">
                                <button type="button" id="devCertiConfirmBtn" class="find-user__input__certify--box--btn">Checking authentication number</button>
                            </div>
                        </div>
                        <div class="find-user__btn">
                            <button class="find-user__btn__submit" id="devUserPwdSearchSubmitButton">Accept</button>
                        </div>
                    </div>

                </div>
                <!-- EOD : 2019.07.11 이메일로 비밀번호 찾기 -->
            </form>
        </div>
    </div>
</section>

<?php }else{?>

<!-- @TODO 글로벌 수정영역 -->
<section class="br__find-user">
    <h2 class="br__find-user__title">Forgot ID/PW</h2>
    <div class="br__tabs">
        <ul class="br__tabs__list">
            <li class="br__tabs__box">
                <a href="/member/searchId" class="br__tabs__btn">ID</a>
            </li>
            <li class="br__tabs__box">
                <a href="/member/searchPw" class="br__tabs__btn br__tabs__btn--active">Password</a>
            </li>
        </ul>
        <div class="br__tabs__content">
            <form id="devSearchEmailForm">
            <div class="br__find-user__label">
                <label><input type="radio" name="searchType" value="email" checked><span>Email</span></label>
            </div>

            <!-- 2019.07.11 이메일로 비밀번호 찾기 -->
            <div class="br__find-user__form" style="display: block">
                    <div class="find-user">
                        <div class="find-user__input">
                            <input type="text" name="userId" id="devUserId" value="" placeholder="ID" title="ID">
                        </div>
                        <!--<div class="find-user__input">-->
                            <!--<input type="text" name="userName" id="devUserName" value="" placeholder="Name" title="Name">-->
                        <!--</div>-->

                        <div class="find-user__input find-user__input__email email_group">
                            <input type="text" name="userEmail1" id="devUserEmail1" class="find-user__input__email--id" value="" placeholder="" title="Email">
                            <span class="find-user__input__email--at">@</span>
                            <input type="text" name="userEmail2" id="devUserEmail2" class="find-user__input__email--adress" value="" title="Email">
                        </div>

                        <div class="find-user__input find-user__input__certify">
                            <button type="button" id="devCertRequestBtn" class="find-user__input__certify--btn">Request authentication number</button>
                            <div class="find-user__input__certify--box">
                                <input type="text" name="certNo" id="devCertNo" class="find-user__input__certify--box--input" placeholder="Authentication number" title="Authentication number">
                                <button type="button" id="devCertiConfirmBtn" class="find-user__input__certify--box--btn">Checking authentication number</button>
                            </div>
                        </div>
                        <div class="find-user__btn">
                            <button class="find-user__btn__submit" id="devUserPwdSearchSubmitButton">Accept</button>
                        </div>
                    </div>

            </div>
            <!-- EOD : 2019.07.11 이메일로 비밀번호 찾기 -->
            </form>
        </div>
    </div>
</section>
<?php }?>