<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_input/join_input_global.htm 000016233 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!-- 2019.07.10 회원가입 -->
<section class="br__join">
    <input type="hidden" name="snsType" id="devSnsType" value="<?php echo $TPL_VAR["snsType"]?>" />
    <form id="devBasicForm">
        <h2 class="br__find-user__title">회원가입</h2>

        <!-- 아이디 -->
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
        <dl class="br__join__list">
            <dt>아이디</dt>
            <dd>
                <div class="join__id">
                    <input class="join__input" type="text" id="devUserId" name="userId" title="ID" />
                    <button class="join__id__check" id="devUserIdDoubleCheckButton">중복확인</button>
                </div>
                <p class="txt-guide" devTailMsg="devUserId"></p>

                <div class="information__btn" id="devDupMember" style="display:none;">
                    <a href="/member/login" class="information__btn__login">로그인</a>
                    <a href="/member/searchPw" class="information__btn__join">비밀번호찾기</a>
                    <p class="information__txt">해당 아이디로 로그인을 하시거나 비밀번호 찾기를 해주세요.</p>
                </div>
            </dd>
        </dl>
<?php }?>
        <!-- EOD : 아이디 -->

        <!-- 비밀번호 -->
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
        <dl class="br__join__list">
            <dt>비밀번호</dt>
            <dd>
                <input class="join__input" type="password" id="devUserPassword" name="pw" title="Password" />
                <p class="join_info-txt">영문 대소문자/숫자/특수문자 중 2가지 이상 조합,<br/>최소 8자~최대 16자 입력.</p>
            </dd>
        </dl>
        <!-- EOD : 비밀번호 -->

        <!-- 비밀번호 확인 -->
        <dl class="br__join__list">
            <dt>비밀번호 확인</dt>
            <dd>
                <input class="join__input" type="password" id="devCompareUserPassword" name="comparePw" title="Confirm Password" />
                <p class="txt-error" devTailMsg="devCompareUserPassword"></p>
            </dd>
        </dl>
        <!-- EOD : 비밀번호 확인 -->
<?php }?>

        <!-- 이메일 주소 -->
        <dl class="br__join__list">
            <dt>이메일 주소</dt>
            <dd>
                <!-- @TODO 바로 입력 가능하도록 개발 스크립트 수정 필요 -->
                <div class="join__eamil">
                    <input class="join__input email-id" type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["emailId"]?>" title="E-mail address"/>
                    <span>@</span>
                    <input class="join__input email-info" type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>" title="E-mail address"/>
                </div>
                <!--<select id="devEmailHostSelect">-->
                    <!--<option value="">선택</option>-->
                    <!--<option value="naver.com">naver.com</option>-->
                    <!--<option value="gmail.com">gmail.com</option>-->
                    <!--<option value="hotmail.com">hotmail.com</option>-->
                    <!--<option value="hanmail.net">hanmail.net</option>-->
                    <!--<option value="daum.net">daum.net</option>-->
                    <!--<option value="nate.com">nate.com</option>-->
                    <!--<option value="direct" >직접입력</option>-->
                <!--</select>-->
                <div class="join__email__check">
                    <button class="join__email__check-btn" id="devEmailDoubleCheckButton" type="button">이메일 중복 확인</button>
                    <p class="txt-error" devTailMsg=""></p>
                </div>

                <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
            </dd>
        </dl>
        <!-- EOD : 이메일 주소 -->

        <!-- 이름 -->
        <dl class="br__join__list">
            <dt>이름</dt>
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
            <dt>휴대폰</dt>
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
                    <!--<input class="join__input join__phone-third" type="text" name="pcs3" id="devPcs3" title="휴대폰" maxlength="4"/>-->
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
            <!--<dt>주소</dt>-->
            <!--<dd>-->
                <!--<div class="join__id">-->
                    <!--<input class="join__input" type="text"  name="zip" id="devZip" readonly title="주소"/>-->
                    <!--<button class="join__id__check" id="devZipPopupButton">우편번호 검색</button>-->
                <!--</div>-->
                <!--<input class="join__address" type="text"  name="addr1" id="devAddress1" readonly/>-->
                <!--<input class="join__address" type="text" name="addr2" id="devAddress2" title="Address line 2" />-->
            <!--</dd>-->
        <!--</dl>-->
        <!-- EOD : 주소 -->

        <!-- 추가정보 -->
        <!--<h3 class="join-title">추가정보</h3>-->
        <!-- 성별-->
        <!--<div class="br__join__add">-->
            <!--<p class="join-symbol">성별</p>-->
            <!--<div class="br__find-user__label">-->
                <!--<label><input type="radio" name="gender" value="M" data-type="" ><span>남자</span></label>-->
                <!--<label><input type="radio" name="gender" value="W" data-type="" ><span>여자</span></label>-->
            <!--</div>-->
        <!--</div>-->
        <!-- EOD : 성별-->

        <!-- 생일 -->
        <!--<div class="br__join__add">-->
            <!--<p class="join-symbol">생일</p>-->
            <!--<div class="br__find-user__label">-->
                <!--<label><input type="radio" name="join-day" name="birthdayDiv" value="1" data-type="" ><span>양력</span></label>-->
                <!--<label><input type="radio" name="join-day" name="birthdayDiv" value="0" data-type=""><span>음력</span></label>-->
            <!--</div>-->
            <!--<div class="join__day-box">-->
                <!--&lt;!&ndash;<input class="join__input join__day-first" name="birthYear" type="text" maxlength="4"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-first" name="birthYear" >-->
                    <!--<option value="">생년</option>-->
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">년</span>-->
                <!--&lt;!&ndash;<input class="join__input join__day-second" name="birthMonth" value="<?php echo $TPL_VAR["birthMonth"]?>" type="text" maxlength="2"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-second" name="birthMonth" >-->
                    <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">월</span>-->
                <!--&lt;!&ndash;<input class="join__input join__day-third" name="birthDay" value="<?php echo $TPL_VAR["birthDay"]?>" type="text" maxlength="2"/>&ndash;&gt;-->
                <!--<select class="join__input join__day-third" name="birthDay" >-->
                    <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                <!--</select>-->
                <!--<span class="join__day-txt">일</span>-->
            <!--</div>-->
            <!--<p class="join__day-info">회원등급별 생일 할인 쿠폰이 증정됩니다.</p>-->
        <!--</div>-->
        <!-- EOD : 생일 -->

        <!-- 지역 -->
        <!--<dl class="br__join__list">-->
            <!--<dt>지역</dt>-->
            <!--<dd>-->
                <!--<select name="area">-->
                    <!--<option value="">선택</option>-->
                    <!--<option value="10">서울특별시</option>-->
                    <!--<option value="20">경기도</option>-->
                    <!--<option value="21">인천광역시</option>-->
                    <!--<option value="30">강원도</option>-->
                    <!--<option value="41">충청남도</option>-->
                    <!--<option value="42">대전광역시</option>-->
                    <!--<option value="43">세종특별자치시</option>-->
                    <!--<option value="45">충청북도</option>-->
                    <!--<option value="51">전라남도</option>-->
                    <!--<option value="52">광주광역시</option>-->
                    <!--<option value="55">전라북도</option>-->
                    <!--<option value="61">경상남도</option>-->
                    <!--<option value="62">부산광역시</option>-->
                    <!--<option value="63">울산광역시</option>-->
                    <!--<option value="65">경상북도</option>-->
                    <!--<option value="66">대구광역시</option>-->
                    <!--<option value="70">제주특별자치도</option>-->
                    <!--<option value="90">기타</option>-->
                <!--</select>-->
            <!--</dd>-->
        <!--</dl>-->
        <!-- EOD : 지역 -->

        <!-- 이용약관 -->
        <div class="br__join__terms">
            <ul>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" data-name="terms01" name="policyUse" data-title="이용약관" id="devPolicyUse" title="이용약관"><span>이용약관(필수)</span></label>
                    <button class="join__all-view term-content" type="button">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        전체보기
<?php }else{?>
                        View all
<?php }?>
                    </button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" data-name="terms02" name="policyCollection"  data-title="개인정보 수집 및 이용" id="devPolicyCollection"  title="개인정보 수집 및 이용"><span>개인정보 수집 및 이용 (필수)</span></label>
                    <button class="join__all-view term-content" type="button">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        전체보기
<?php }else{?>
                        View all
<?php }?>
                    </button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label><input type="checkbox" name="email" value="1" data-type=""><span>이메일 수신동의 (선택)</span></label>
                </li>
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="sms" value="1" data-type=""><span>SMS 수신동의(선택)</span></label>-->
                <!--</li>-->
            </ul>
            <div class="join__terms-all">
                <label for="all_terms_check"><input type="checkbox" id="all_terms_check" class="join__terms__agree" name="" data-type=""><span>전체동의</span></label>
            </div>
        </div>
        <!-- EOD : 이용약관 -->

        <div class="br__join__btn">
            <button class="join__btn" type="submit">가입하기</button>
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