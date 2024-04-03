<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/profile/profile_basic_global.htm 000029215 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<!--
<h1 class="wrap-title">
    회원정보 수정
    <button class="back"></button>
</h1>
-->

<section class="br__join br__mypage">
    <form id="devMemberProfileForm">
        <div class="br__mypage__pass">
            <p class="pass-title">내 정보 수정</p>

            <dl class="br__mypage__info">
                <dt>이름</dt>
                <dd><?php echo $TPL_VAR["name"]?></dd>
            </dl>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
            <dl class="br__mypage__info">
                <dt>아이디</dt>
                <dd><?php echo $TPL_VAR["id"]?></dd>
            </dl>
<?php }?>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
            <dl class="br__join__list">
                <dt>비밀번호</dt>
                <dd>
                    <button class="br__mypage__btn-s btn__change-pw" id="devChangePassword" type="button" data-title="비밀번호 변경">비밀번호 변경</button>
                </dd>
            </dl>
<?php }?>

            <!-- 이메일 주소 -->
            <dl class="br__join__list">
                <dt>이메일 주소</dt>
                <dd>
                    <div class="join__eamil">
                        <input class="join__input email-id" type="text" name="emailId" id="devEmailId" title="이메일" value="<?php echo $TPL_VAR["mail"][ 0]?>"/>
                        <span>@</span>
                        <input class="join__input email-info" type="text" name="emailHost" id="devEmailHost" title="이메일" value="<?php echo $TPL_VAR["mail"][ 1]?>"/>
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
                    <!-- email 중복 체크 -->
                    <div class="join__email__check">
                        <button class="join__email__check-btn" id="devEmailDoubleCheckButton" type="button">이메일 중복 확인</button>
                        <p class="txt-error" devTailMsg=""></p>
                    </div>
                    <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
                    <!-- EOD : email 중복 체크 -->
                </dd>
            </dl>
            <!-- EOD : 이메일 주소 -->
            <dl class="br__join__list">
                <dt>Country</dt>
                <dd>
                    <select class="devNationArea" id="devCountry" name="country" title="Country">
                        <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                    </select>
                </dd>
            </dl>
            <!-- 휴대폰 -->
            <dl class="br__join__list">
                <dt>휴대폰 번호</dt>
                <dd>
                    <div class="join__phone">
                        <select class="join__phone-first devNationArea" name="national_phone" title="Country">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                        </select>
                        <!--<span class="join__phone-hyphen"></span>-->
                        <input class="join__input join__phone-second" name="pcs" id="devPcs" value="<?php echo $TPL_VAR["pcs"]?>" type="text" title="휴대폰 번호" />
                        <!--<span class="join__phone-hyphen"></span>-->
                        <!--<input class="join__input join__phone-third" name="pcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" type="text" maxlength="4"/>-->
                    </div>
                </dd>
            </dl>
            <!-- EOD : 휴대폰 -->

            <!-- 주소 -->
            <dl class="br__join__list">
                <dt>Address line 1</dt>
                <dd>
                    <input class="join__address" type="text"  name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["addr1"]?>" title="Address line 1"/>
                </dd>
            </dl>
            <dl class="br__join__list">
                <dt>Address line 2</dt>
                <dd>
                    <input class="join__address" type="text" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["addr2"]?>" title="Address line 2" />
                </dd>
            </dl>
            <dl class="br__join__list">
                <dt>City</dt>
                <dd>
                    <input class="join__address" type="text" name="city" id="devCity" value="<?php echo $TPL_VAR["city"]?>" title="City" />
                </dd>
            </dl>
            <dl class="br__join__list">
                <dt>State/Province</dt>
                <dd>
<?php if($TPL_VAR["country"]=='US'){?>
                    <select id="devStateSelect">
                        <option >Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                    </select>
                    <input class="join__address" type="text" style="display:none;" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" />
<?php }else{?>
                    <select id="devStateSelect" style="display: none;">
                        <option >Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                    </select>
                    <input class="join__address" type="text" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" />
<?php }?>
                </dd>
            </dl>
            <dl class="br__join__list">
                <dt>Zip/Postal code</dt>
                <dd>
                    <input class="join__address" type="text"  name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" title="Zip/Postal code"/>
                </dd>
            </dl>
            <!--<dl class="br__join__list">-->
                <!--<dt>주소</dt>-->
                <!--<dd>-->
                    <!--<div class="join__id">-->
                        <!--<input class="join__input" type="text"  name="zip" value="<?php echo $TPL_VAR["zip"]?>" id="devZip" title="우편번호" readonly />-->
                        <!--<button class="join__id__check" id="devZipPopupButton">우편번호 검색</button>-->
                    <!--</div>-->
                    <!--<input class="join__address" type="text" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" title="주소"  readonly/>-->
                    <!--<input class="join__address" type="text" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" id="devAddress2" title="상세주소"  placeholder="상세주소를 입력해주세요."/>-->
                <!--</dd>-->
            <!--</dl>-->
            <!-- EOD : 주소 -->

            <!-- 추가정보 -->
            <h3 class="join-title">추가정보</h3>
            <!--&lt;!&ndash; 성별&ndash;&gt;-->
            <!--<div class="br__join__add">-->
                <!--<p class="join-symbol">성별</p>-->
                <!--<div class="br__find-user__label">-->
                    <!--<label><input type="radio" name="gender" value="M" <?php if($TPL_VAR["sex_div"]=='M'){?>checked<?php }?> ><span>남자</span></label>-->
                    <!--<label><input type="radio" name="gender" value="W" <?php if($TPL_VAR["sex_div"]=='W'){?>checked<?php }?>><span>여자</span></label>-->
                <!--</div>-->
            <!--</div>-->
            <!--&lt;!&ndash; EOD : 성별&ndash;&gt;-->

            <!--&lt;!&ndash; 생일 &ndash;&gt;-->
            <!--<div class="br__join__add">-->
                <!--<p class="join-symbol">생일</p>-->
                <!--<div class="br__find-user__label">-->
                    <!--<label><input type="radio" name="birthdayDiv" data-type="" value="1" <?php if($TPL_VAR["birthday_div"]=='1'){?>checked<?php }?>><span>양력</span></label>-->
                    <!--<label><input type="radio" name="birthdayDiv" data-type="" value="0" <?php if($TPL_VAR["birthday_div"]=='0'){?>checked<?php }?>><span>음력</span></label>-->
                <!--</div>-->
                <!--<div class="join__day-box">-->
                    <!--&lt;!&ndash;<input class="join__input join__day-first" type="number" name="birthYear" id="devBirthYear"  value="<?php echo $TPL_VAR["birthdayArr"][ 0]?>" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?> />&ndash;&gt;-->
                    <!--<select class="join__input join__day-first" name="birthYear" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                    <!--<option value="">생년</option>-->
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                    <!--</select>-->
                    <!--<span class="join__day-txt">년</span>-->
                    <!--&lt;!&ndash;<input class="join__input join__day-second" type="number" name="birthMonth" id="devBirthMonth"  value="<?php echo $TPL_VAR["birthdayArr"][ 1]?>" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>  />&ndash;&gt;-->
                    <!--<select class="join__input join__day-second" name="birthMonth" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                    <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                    <!--</select>-->
                    <!--<span class="join__day-txt">월</span>-->
                    <!--&lt;!&ndash;<input class="join__input join__day-third" type="number" name="birthDay" id="devBirthDay"  value="<?php echo $TPL_VAR["birthdayArr"][ 2]?>" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?> />&ndash;&gt;-->
                    <!--<select class="join__input join__day-third" name="birthDay" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                    <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                    <!--</select>-->
                    <!--<span class="join__day-txt">일</span>-->
                <!--</div>-->
                <!--<p class="join__day-info">회원등급별 생일 할인 쿠폰이 증정됩니다.</p>-->
<?php if(!$TPL_VAR["birthdayArr"]){?>
                <!--<p class="join__day-info">생년월일 최초 1회 입력 이후 변경이 불가능합니다.</p>-->
<?php }?>
            <!--</div>-->
            <!--&lt;!&ndash; EOD : 생일 &ndash;&gt;-->

            <!--&lt;!&ndash; 지역 &ndash;&gt;-->
            <!--<dl class="br__join__list">-->
                <!--<dt>지역</dt>-->
                <!--<dd>-->
                    <!--<select name="area">-->
                        <!--<option value="">선택</option>-->
                        <!--<option value="10" <?php if($TPL_VAR["area"]=='10'){?> selected <?php }?> >서울특별시</option>-->
                        <!--<option value="20" <?php if($TPL_VAR["area"]=='20'){?> selected <?php }?> >경기도</option>-->
                        <!--<option value="21" <?php if($TPL_VAR["area"]=='21'){?> selected <?php }?> >인천광역시</option>-->
                        <!--<option value="30" <?php if($TPL_VAR["area"]=='30'){?> selected <?php }?> >강원도</option>-->
                        <!--<option value="41" <?php if($TPL_VAR["area"]=='41'){?> selected <?php }?> >충청남도</option>-->
                        <!--<option value="42" <?php if($TPL_VAR["area"]=='42'){?> selected <?php }?> >대전광역시</option>-->
                        <!--<option value="43" <?php if($TPL_VAR["area"]=='43'){?> selected <?php }?> >세종특별자치시</option>-->
                        <!--<option value="45" <?php if($TPL_VAR["area"]=='45'){?> selected <?php }?> >충청북도</option>-->
                        <!--<option value="51" <?php if($TPL_VAR["area"]=='51'){?> selected <?php }?> >전라남도</option>-->
                        <!--<option value="52" <?php if($TPL_VAR["area"]=='52'){?> selected <?php }?> >광주광역시</option>-->
                        <!--<option value="55" <?php if($TPL_VAR["area"]=='55'){?> selected <?php }?> >전라북도</option>-->
                        <!--<option value="61" <?php if($TPL_VAR["area"]=='61'){?> selected <?php }?> >경상남도</option>-->
                        <!--<option value="62" <?php if($TPL_VAR["area"]=='62'){?> selected <?php }?> >부산광역시</option>-->
                        <!--<option value="63" <?php if($TPL_VAR["area"]=='63'){?> selected <?php }?> >울산광역시</option>-->
                        <!--<option value="65" <?php if($TPL_VAR["area"]=='65'){?> selected <?php }?> >경상북도</option>-->
                        <!--<option value="66" <?php if($TPL_VAR["area"]=='66'){?> selected <?php }?> >대구광역시</option>-->
                        <!--<option value="70" <?php if($TPL_VAR["area"]=='70'){?> selected <?php }?> >제주특별자치도</option>-->
                        <!--<option value="90" <?php if($TPL_VAR["area"]=='90'){?> selected <?php }?> >기타</option>-->
                    <!--</select>-->
                <!--</dd>-->
            <!--</dl>-->
            <!--&lt;!&ndash; EOD : 지역 &ndash;&gt;-->

            <!--&lt;!&ndash; SMS 수신동의 &ndash;&gt;-->
            <!--<dl class="br__join__list">-->
                <!--<dt>SMS 수신동의</dt>-->
                <!--<dd>-->
                    <!--<div class="br__join__add br__mypage__agree">-->
                        <!--<div class="br__find-user__label br__join__add">-->
                            <!--<label for="devAgreeSms">-->
                                <!--<input type="radio" name="sms" value="1" id="devAgreeSms" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?>><span>동의함</span>-->
                            <!--</label>-->
                            <!--<label>-->
                                <!--<input type="radio" name="sms" value="0"  data-type="" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?> ><span>동의안함</span>-->
                            <!--</label>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</dd>-->
            <!--</dl>-->
            <!--&lt;!&ndash; EOD : SMS 수신동의 &ndash;&gt;-->

            <!-- 메일 수신동의 -->
            <dl class="br__join__list">
                <dt>메일 수신동의</dt>
                <dd>
                    <div class="br__join__add br__mypage__agree">
                        <div class="br__find-user__label br__join__add">
                            <label for="devAgreeEmail">
                                <input type="radio" name="info" value="1" id="devAgreeEmail" data-type="" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>><span>동의함</span>
                            </label>
                            <label>
                                <input type="radio" name="info" value="0" data-type="" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>><span>동의안함</span>
                            </label>
                        </div>
                    </div>
                </dd>
            </dl>
            <!-- EOD : 메일 수신동의 -->

            <!--
            sns 연동
            <dl class="br__join__list">
                <dt>SNS 연동</dt>
                <dd>
                    <div class="br__login__info">
                        <ul class="information__sns">
                            <li class="information__sns__list">
                                <div class="information__sns__link information__sns__link&#45;&#45;naver">네이버</div>
                                <a class="information__sns__btn" href="#naver">연결</a>
                            </li>
                            <li class="information__sns__list">
                                <div class="information__sns__link information__sns__link&#45;&#45;kakaotalk">카카오톡</div>
                                <a class="information__sns__btn" href="#naver">연결</a>
                            </li>
                            <li class="information__sns__list">
                                <div class="information__sns__link information__sns__link&#45;&#45;facebook">페이스북</div>
                                <a class="information__sns__btn" href="#naver">연결</a>
                            </li>
                            <li class="information__sns__list">
                                <div class="information__sns__link information__sns__link&#45;&#45;google">구글</div>
                                <a class="information__sns__btn" href="#naver">연결</a>
                            </li>
                        </ul>
                    </div>
                </dd>
            </dl>
             EOD : sns 연동
            -->

            <div class="br__join__btn">
                <button class="join__btn btn-lg btn-point">저장</button>
            </div>

            <div class="profile__secession">
                <a href="/mypage/secede" class="profile__secession-link">회원탈퇴</a>
            </div>

        </div>
    </form>
</section>

<?php if(false){?>
<!--<div class="wrap-sect"></div>-->
<!--<div class="wrap-mypage profile-detail">-->
<!--<form id="devMemberProfileForm">-->
<!--<div class="wrap-input-form">-->
<!--<section>-->
<!--&lt;!&ndash;아이디&ndash;&gt;-->
<!--<dl>-->
<!--<dt>아이디</dt>-->
<!--<dd><input type="text" value="<?php echo $TPL_VAR["id"]?>" disabled></dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 비밀번호 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>비밀번호 <em>*</em></dt>-->
<!--<dd>-->
<!--<div class="wrap-btn-area">-->
<!--<button type="button" class="btn-default btn-dark change-pw-btn" id="devChangePassword">비밀번호 변경</button>-->
<!--</div>-->

<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 이름 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>이름</dt>-->
<!--<dd>-->
<!--<input type="text" value="<?php echo $TPL_VAR["name"]?>" disabled>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 생년월일 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>생년월일</dt>-->
<!--<dd>-->
<!--<input type="text" value="<?php echo $TPL_VAR["birthday"]?>" disabled>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 성별 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>성별</dt>-->
<!--<dd>-->
<!--<input type="text" value="<?php if($TPL_VAR["sex_div"]=='M'){?>남성<?php }else{?>여성<?php }?>" disabled>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 이메일 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>이메일 <em>*</em></dt>-->
<!--<dd>-->
<!--<div class="wrap-multi-input">-->
<!--<input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" title="이메일" style="width:280px;">-->
<!--<span class="hyphen_2">@</span>-->
<!--<input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" title="이메일" style="width:270px;" readonly>-->
<!--<select id="devEmailHostSelect"  style="width:270px;">-->
<!--<option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>-->
<!--<option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>-->
<!--<option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>-->
<!--<option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>-->
<!--<option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>-->
<!--<option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>-->
<!--</select>-->
<!--</div>-->
<!--<p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>-->
<!--<div class="mat20">-->
<!--<input type="checkbox" id="devDirectInputEmailCheckBox">-->
<!--<label for="devDirectInputEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>-->
<!--</div>-->
<!--<button type="button" class="btn-default btn-dark btn-full mat30" id="devEmailDoubleCheckButton">이메일 중복 확인</button>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 휴대폰 번호 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>휴대폰 번호 <em>*</em></dt>-->
<!--<dd>-->
<!--<div class="wrap-multi-input">-->
<!--<select name="pcs1" id="devPcs1" style="width:170px;" <?php if($TPL_VAR["pcs"][ 0]!=''){?>readonly<?php }?>>-->
<!--<option value="010" <?php if($TPL_VAR["pcs"][ 0]=="010"){?>selected<?php }?>>010</option>-->
<!--<option value="011" <?php if($TPL_VAR["pcs"][ 0]=="011"){?>selected<?php }?>>011</option>-->
<!--<option value="016" <?php if($TPL_VAR["pcs"][ 0]=="016"){?>selected<?php }?>>016</option>-->
<!--<option value="017" <?php if($TPL_VAR["pcs"][ 0]=="017"){?>selected<?php }?>>017</option>-->
<!--<option value="018" <?php if($TPL_VAR["pcs"][ 0]=="018"){?>selected<?php }?>>018</option>-->
<!--<option value="019" <?php if($TPL_VAR["pcs"][ 0]=="019"){?>selected<?php }?>>019</option>-->
<!--</select>-->
<!--<span class="hyphen">-</span>-->
<!--<input type="text" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" title="휴대폰번호" style="width:180px;" <?php if($TPL_VAR["pcs"][ 1]!=''){?>readonly<?php }?> />-->
<!--<span class="hyphen">-</span>-->
<!--<input type="text" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" title="휴대폰번호" style="width:180px;" <?php if($TPL_VAR["pcs"][ 2]!=''){?>readonly<?php }?> />-->
<!--</div>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 전화번호 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>전화번호</dt>-->
<!--<dd>-->
<!--<div class="wrap-multi-input">-->
<!--<select class="pub-form-set-3rd" name="tel1" style="width:170px;">-->
<!--<option value="02" <?php if($TPL_VAR["tel"][ 0]=="02"){?>selected<?php }?>>02</option>-->
<!--<option value="031" <?php if($TPL_VAR["tel"][ 0]=="031"){?>selected<?php }?>>031</option>-->
<!--<option value="032" <?php if($TPL_VAR["tel"][ 0]=="032"){?>selected<?php }?>>032</option>-->
<!--<option value="041" <?php if($TPL_VAR["tel"][ 0]=="041"){?>selected<?php }?>>041</option>-->
<!--<option value="042" <?php if($TPL_VAR["tel"][ 0]=="042"){?>selected<?php }?>>042</option>-->
<!--<option value="043" <?php if($TPL_VAR["tel"][ 0]=="043"){?>selected<?php }?>>043</option>-->
<!--<option value="051" <?php if($TPL_VAR["tel"][ 0]=="051"){?>selected<?php }?>>051</option>-->
<!--<option value="052" <?php if($TPL_VAR["tel"][ 0]=="052"){?>selected<?php }?>>052</option>-->
<!--<option value="053" <?php if($TPL_VAR["tel"][ 0]=="053"){?>selected<?php }?>>053</option>-->
<!--<option value="054" <?php if($TPL_VAR["tel"][ 0]=="054"){?>selected<?php }?>>054</option>-->
<!--<option value="055" <?php if($TPL_VAR["tel"][ 0]=="055"){?>selected<?php }?>>055</option>-->
<!--<option value="061" <?php if($TPL_VAR["tel"][ 0]=="061"){?>selected<?php }?>>061</option>-->
<!--<option value="062" <?php if($TPL_VAR["tel"][ 0]=="062"){?>selected<?php }?>>062</option>-->
<!--<option value="063" <?php if($TPL_VAR["tel"][ 0]=="063"){?>selected<?php }?>>063</option>-->
<!--<option value="064" <?php if($TPL_VAR["tel"][ 0]=="064"){?>selected<?php }?>>064</option>-->
<!--<option value="070" <?php if($TPL_VAR["tel"][ 0]=="070"){?>selected<?php }?>>070</option>-->
<!--<option value="080" <?php if($TPL_VAR["tel"][ 0]=="080"){?>selected<?php }?>>080</option>-->
<!--<option value="090" <?php if($TPL_VAR["tel"][ 0]=="090"){?>selected<?php }?>>090</option>-->
<!--</select>-->

<!--<span class="hyphen">-</span>-->

<!--<input type="text" name="tel2" id="devTel2" value="<?php echo $TPL_VAR["tel"][ 1]?>" title="전화번호 가운데자리" style="width:180px;">-->

<!--<span class="hyphen">-</span>-->

<!--<input type="text" name="tel3" id="devTel3" value="<?php echo $TPL_VAR["tel"][ 2]?>" title="전화번호 끝자리" style="width:180px;">-->
<!--</div>-->
<!--</dd>-->
<!--</dl>-->

<!--&lt;!&ndash; 주소 &ndash;&gt;-->
<!--<dl>-->
<!--<dt>주소</dt>-->
<!--<dd>-->
<!--<div class="wrap-multi-input">-->
<!--<input type="text" name="zip" value="<?php echo $TPL_VAR["zip"]?>" id="devZip" style="width:170px;" readonly>-->
<!--<button class="btn-default btn-dark mal10" id="devZipPopupButton">주소찾기</button>-->
<!--</div>-->

<!--<input type="text" class="mat10" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" readonly>-->
<!--<input type="text" class="mat10" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" id="devAddress2" placeholder="상세주소를 입력해 주세요.">-->
<!--</dd>-->
<!--</dl>-->
<!--</section>-->
<!--</div>-->

<!--<p class="subtitle">선택 동의 항목</p>-->

<!--<div class="term-list">-->
<!--<input type="checkbox"  id="devAgreeTerm" name="policy[]" value="<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>" <?php if($TPL_VAR["sms"]=='1'||$TPL_VAR["info"]=='1'){?>checked<?php }?> />-->
<!--<label for="agree-term5">마케팅 활용 동의(선택)</label>-->
<!--<span class="accord-btn"></span>-->
<!--</div>-->
<!--<div class="terms-content">-->
<?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

<!--</div>-->


<!--<div class="marketing-wrap">-->
<!--<p class="tit">마케팅 활용 동의 수신 여부</p>-->

<!--<input type="checkbox" id="devAgreeSms" name="sms" value="1" title="SMS" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?> />-->
<!--<label for="agree-term6">SMS 수신</label>-->

<!--<input type="checkbox" id="devAgreeEmail" name="email" value="1" title="E-Mail" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?> class="mal40" />-->
<!--<label for="agree-term7">이메일 수신</label>-->

<!--<p class="sub-txt mat20">· 쇼핑몰에서 제공되는 다양한 정보를 받아보실 수 있습니다.<br>-->

<!--<p class="sub-txt">· 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관 없이 발송됩니다.-->
<!--</p>-->
<!--</div>-->

<!--<div class="layout-padding">-->
<!--<div class="wrap-btn-area mat30">-->
<!--<button type="button" class="btn-lg btn-dark-line" id="devProfileModifyCancel" >취소</button>-->
<!--<button class="btn-lg btn-point" >저장</button>-->
<!--</div>-->

<!--<div class="desc">개명한 경우 <span class="point-color">고객센터 <?php echo $TPL_VAR["companyInfo"]["com_phone"]?></span>로 문의해 주세요.</div>-->
<!--</div>-->
<!--</form>-->
<!--</div>-->
<?php }?>