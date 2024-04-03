<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_input/join_input_global.htm 000016076 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!-- 2019.07.10 회원가입 -->
<section class="br__join">
    <input type="hidden" name="snsType" id="devSnsType" value="<?php echo $TPL_VAR["snsType"]?>" />
    <form id="devBasicForm">
        <h2 class="br__find-user__title">Join</h2>

        <!-- 아이디 -->
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
        <dl class="br__join__list">
            <dt>ID</dt>
            <dd>
                <div class="join__id">
                    <input class="join__input" type="text" id="devUserId" name="userId" title="ID" />
                    <button class="join__id__check" id="devUserIdDoubleCheckButton">Duplicate check</button>
                </div>
                <p class="txt-guide" devTailMsg="devUserId"></p>

                <div class="information__btn" id="devDupMember" style="display:none;">
                    <a href="/member/login" class="information__btn__login">Sign in</a>
                    <a href="/member/searchPw" class="information__btn__join">Find Password</a>
                    <p class="information__txt">Please login with the ID or find the password</p>
                </div>
            </dd>
        </dl>
<?php }?>
        <!-- EOD : 아이디 -->

        <!-- 비밀번호 -->
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
        <dl class="br__join__list">
            <dt>Password</dt>
            <dd>
                <input class="join__input" type="password" id="devUserPassword" name="pw" title="Password" />
                <p class="join_info-txt">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
            </dd>
        </dl>
        <!-- EOD : 비밀번호 -->

        <!-- 비밀번호 확인 -->
        <dl class="br__join__list">
            <dt>Confirm Password</dt>
            <dd>
                <input class="join__input" type="password" id="devCompareUserPassword" name="comparePw" title="Confirm Password" />
                <p class="txt-error" devTailMsg="devCompareUserPassword"></p>
            </dd>
        </dl>
        <!-- EOD : 비밀번호 확인 -->
<?php }?>

        <!-- 이메일 주소 -->
        <dl class="br__join__list">
            <dt>Email</dt>
            <dd>
                <!-- @TODO 바로 입력 가능하도록 개발 스크립트 수정 필요 -->
                <div class="join__eamil">
                    <input class="join__input email-id" type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["emailId"]?>" title="E-mail address"/>
                    <span>@</span>
                    <input class="join__input email-info" type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>" title="E-mail address"/>
                </div>
                <!--<select id="devEmailHostSelect">-->
                    <!--<option value="">Select</option>-->
                    <!--<option value="naver.com">naver.com</option>-->
                    <!--<option value="gmail.com">gmail.com</option>-->
                    <!--<option value="hotmail.com">hotmail.com</option>-->
                    <!--<option value="hanmail.net">hanmail.net</option>-->
                    <!--<option value="daum.net">daum.net</option>-->
                    <!--<option value="nate.com">nate.com</option>-->
                    <!--<option value="direct" >직접입력</option>-->
                <!--</select>-->
                <div class="join__email__check">
                    <button class="join__email__check-btn" id="devEmailDoubleCheckButton" type="button">Duplicate check</button>
                    <p class="txt-error" devTailMsg=""></p>
                </div>

                <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
            </dd>
        </dl>
        <!-- EOD : 이메일 주소 -->

        <!-- 이름 -->
        <dl class="br__join__list">
            <dt>Name</dt>
            <dd>
                <input class="js__joininput__name" type="text" name="userName" id="devUserName" value="<?php echo $TPL_VAR["userName"]?>" title="Name"/>            </dd>
        </dl>
        <!-- EOD : 이름 -->
        <dl class="br__join__list">
            <dt>Country</dt>
            <dd>
                <select class="devNationArea" name="country">
                    <option >Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                    <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                </select>
            </dd>
        </dl>
        <!-- 휴대폰 -->
        <dl class="br__join__list">
            <dt>Tel</dt>
            <dd>
                <div class="join__phone">
                    <select class="join__phone-first devNationArea" name="national_phone">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                    </select>
                    <!--<span class="join__phone-hyphen"></span>-->
                    <input class="join__input join__phone-second" type="text" name="pcs" id="devPcs" title="Phone Number" />
                    <!--<span class="join__phone-hyphen"></span>-->
                    <!--<input class="join__input join__phone-third" type="text" name="pcs3" id="devPcs3" title="Tel" maxlength="4"/>-->
                </div>
            </dd>
        </dl>
        <!-- EOD : 휴대폰 -->

        <!-- 주소 -->
        <dl class="br__join__list">
            <dt>Address line 1</dt>
            <dd>
                <input class="join__address" type="text"  name="addr1" id="devAddress1" title="Address line 1"/>
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>Address line 2</dt>
            <dd>
                <input class="join__address" type="text" name="addr2" id="devAddress2" title="Address line 2" />
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>City</dt>
            <dd>
                <input class="join__address" type="text" title="City" name="city" id="devCity" />
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>State/Province</dt>
            <dd>
                <select id="devStateSelect" title="State/Province">
                    <option >Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                    <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                </select>
                <input class="join__address" type="text" name="state" id="devStateText" title="State/Province" style="display:none;" />
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>Zip/Postal code</dt>
            <dd>
                <input class="join__address" type="text"  name="zip" id="devZip" title="Zip/Postal code"/>
            </dd>
        </dl>
        <!--<dl class="br__join__list">-->
            <!--<dt>Address</dt>-->
            <!--<dd>-->
                <!--<div class="join__id">-->
                    <!--<input class="join__input" type="text"  name="zip" id="devZip" readonly title="Address"/>-->
                    <!--<button class="join__id__check" id="devZipPopupButton">Zip code search</button>-->
                <!--</div>-->
                <!--<input class="join__address" type="text"  name="addr1" id="devAddress1" readonly/>-->
                <!--<input class="join__address" type="text" name="addr2" id="devAddress2" title="Address line 2" />-->
            <!--</dd>-->
        <!--</dl>-->
        <!-- EOD : 주소 -->

        <!-- 추가정보 -->
        <!--<h3 class="join-title">Optional</h3>-->
        <!-- 성별-->
        <!--<div class="br__join__add">-->
            <!--<p class="join-symbol">Gender</p>-->
            <!--<div class="br__find-user__label">-->
                <!--<label><input type="radio" name="gender" value="M" data-type="" ><span>Male</span></label>-->
                <!--<label><input type="radio" name="gender" value="W" data-type="" ><span>Female</span></label>-->
            <!--</div>-->
        <!--</div>-->
        <!-- EOD : 성별-->

        <!-- 생일 -->
        <!--<div class="br__join__add">-->
            <!--<p class="join-symbol">Birth</p>-->
            <!--<div class="br__find-user__label">-->
                <!--<label><input type="radio" name="join-day" name="birthdayDiv" value="1" data-type="" ><span>solar calendar</span></label>-->
                <!--<label><input type="radio" name="join-day" name="birthdayDiv" value="0" data-type=""><span>lunar calendar</span></label>-->
            <!--</div>-->
            <!--<div class="join__day-box">-->
                <!--&lt;!&ndash;<input class="join__input join__day-first" name="birthYear" type="text" maxlength="4"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-first" name="birthYear" >-->
                    <!--<option value="">생년</option>-->
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">Year</span>-->
                <!--&lt;!&ndash;<input class="join__input join__day-second" name="birthMonth" value="<?php echo $TPL_VAR["birthMonth"]?>" type="text" maxlength="2"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-second" name="birthMonth" >-->
                    <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">Month</span>-->
                <!--&lt;!&ndash;<input class="join__input join__day-third" name="birthDay" value="<?php echo $TPL_VAR["birthDay"]?>" type="text" maxlength="2"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-third" name="birthDay" >-->
                    <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">day</span>-->
            <!--</div>-->
            <!--<p class="join__day-info">영문몰해당없음</p>-->
        <!--</div>-->
        <!-- EOD : 생일 -->

        <!-- 지역 -->
        <!--<dl class="br__join__list">-->
            <!--<dt>Region</dt>-->
            <!--<dd>-->
                <!--<select name="area">-->
                    <!--<option value="">Select</option>-->
                    <!--<option value="10">Seoul</option>-->
                    <!--<option value="20">Gyeonggi</option>-->
                    <!--<option value="21">Incheon</option>-->
                    <!--<option value="30">Gangwon</option>-->
                    <!--<option value="41">Chungcheongnam-do</option>-->
                    <!--<option value="42">Daejeon</option>-->
                    <!--<option value="43">Sejong</option>-->
                    <!--<option value="45">Chungcheongbuk-do</option>-->
                    <!--<option value="51">Jeollanam-do</option>-->
                    <!--<option value="52">Gwangju</option>-->
                    <!--<option value="55">Jeollabuk-do</option>-->
                    <!--<option value="61">Gyeongsangnam-do</option>-->
                    <!--<option value="62">Busan</option>-->
                    <!--<option value="63">Ulsan</option>-->
                    <!--<option value="65">Gyeongsangbuk-do</option>-->
                    <!--<option value="66">Daegu</option>-->
                    <!--<option value="70">Jeju Island</option>-->
                    <!--<option value="90">ETC</option>-->
                <!--</select>-->
            <!--</dd>-->
        <!--</dl>-->
        <!-- EOD : 지역 -->

        <!-- 이용약관 -->
        <div class="br__join__terms">
            <ul>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" data-name="terms01" name="policyUse" data-title="Terms and Conditions" id="devPolicyUse" title="Terms and Conditions"><span>Terms and Conditions (Required)</span></label>
                    <button class="join__all-view term-content" type="button">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        All
<?php }else{?>
                        View all
<?php }?>
                    </button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" data-name="terms02" name="policyCollection"  data-title="Collection and utilization of personal information" id="devPolicyCollection"  title="Collection and utilization of personal information"><span>Privacy Policy (Required)</span></label>
                    <button class="join__all-view term-content" type="button">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        All
<?php }else{?>
                        View all
<?php }?>
                    </button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" name="email" value="1" data-type=""><span>Receive Email (Optional)</span></label>
                </li>
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="sms" value="1" data-type=""><span>Accept SMS reception (optional)</span></label>-->
                <!--</li>-->
            </ul>
            <div class="join__terms-all">
                <label for="all_terms_check"><input type="checkbox" id="all_terms_check" class="join__terms__agree" name="" data-type=""><span>Agree all</span></label>
            </div>
        </div>
        <!-- EOD : 이용약관 -->

        <div class="br__join__btn">
            <button class="join__btn" type="submit">Join</button>
        </div>
        <!-- EOD : 추가정보 -->
    </form>
</section>
<!-- EOD : 2019.07.10 회원가입 -->

<!-- 이용약관 팝업 -->
<div class="term__popup">
    <p class="term__popup-title">
        <span class="term__popup-name">이용약관</span>
        <span class="close"></span>
    </p>
    <div class="term__popup-content terms01">
        <?php echo $TPL_VAR["policyData"]['use_global']['contents']?>

    </div>
    <div class="term__popup-content terms02">
        <?php echo $TPL_VAR["policyData"]['collection_global']['contents']?>

    </div>
</div>
<!-- EOD : 이용약관 팝업 -->