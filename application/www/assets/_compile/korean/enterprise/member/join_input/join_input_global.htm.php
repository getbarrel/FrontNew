<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-qa/application/www.bak/assets/templet/enterprise/member/join_input/join_input_global.htm 000020373 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<div class="fb__join-member fb__join-input">
    <h2 class="fb__join-member__title">회원가입</h2>
    <p class="fb__join-member__subtitle">Barrel의 회원이 되시면 할인쿠폰과 포인트 적립 등의 특별한 혜택을 누리실 수 있습니다.</p>
    <!--   <ul class="fb__join-member__top-area top-area">
           <li class="top-area__step top-area__step01">
               <div class="top-area__step__inner">
                   <p class="top-area__step__tit">본인인증</p>
               </div>
           </li>
           <li class="top-area__step top-area__step02">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 02</span>
                   <p class="top-area__step__tit">약관동의</p>
               </div>
           </li>
           <li class="top-area__step top-area__step03 top-area__step&#45;&#45;active">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 03</span>
                   <p class="top-area__step__tit">정보입력</p>
               </div>
           </li>
           <li class="top-area__step top-area__step04">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 04</span>
                   <p class="top-area__step__tit">가입완료</p>
               </div>
           </li>
       </ul>-->
    <input type="hidden" name="snsType" id="devSnsType" value="<?php echo $TPL_VAR["snsType"]?>" />
    <form id="devBasicForm">
        <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
        <div class="wrap-joininput-layout">
            <section class="fb__join-input__form">
                <section class="input-form">
                    <div class="input-form__title-box">
                        <p class="input-form__title-box__text">회원정보입력</p>
                        <span class="input-form__title-box__guide"><em class="star">*</em>표시된 항목은 필수 입력사항 입니다.</span>
                    </div>
                    <ul class="input-form__content-box">
<?php if(empty($TPL_VAR["snsType"])){?>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devUserId">아이디</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="text" title="ID" name="userId" id="devUserId" devmaxlength="10">
                                <button class="inputs__content__btn" type="button" id="devUserIdDoubleCheckButton" style="min-width:190px;">중복확인</button>
                                <p class="inputs__content__warning" devTailMsg="devUserId"></p>
                                <div class="link__box"  id="devDupMember" style="display:none;">
                                    <a href="/member/login" class="link__box--login">로그인</a>
                                    <a href="/member/searchPw" class="link__box--search">비밀번호 찾기</a>
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devUserPassword">비밀번호</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" class="pub-input-text" id="devUserPassword" name="pw" title="Password">
                                <p class="inputs__content__guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devCompareUserPassword">비밀번호 확인</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" title="Confirm Password">
                                <p class="inputs__content__warning" devTailMsg="devCompareUserPassword">비밀번호가 일치하지 않습니다.</p>
                            </div>
                        </li>
<?php }?>
                        <!-- @TODO 위치변경 확인 -->
                        <li class="inputs">
                            <span class="inputs__title"><label for="devEmailId">이메일 주소<em class="inputs__title--star">*</em></label></span>
                            <div class="inputs__content">
                            <span class="pub-email">
                            <input type="text" name="emailId" id="devEmailId" style="width:157px;" title="E-mail address">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" id="devEmailHost" style="width:157px;" title="E-mail address">
                            <!--<select id="devEmailHostSelect" class="input__select">
                                <option value="">이메일 선택</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                                <option value="" selected="selected">직접입력</option>
                            </select>-->

                            <button class="btn-default btn-dark" id="devEmailDoubleCheckButton" type="button"  style="min-width:190px;">이메일 중복 확인</button>

                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>

                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">이름<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="text" name="userName" id="devUserName" class="input__user-name" title="Name">
                                <p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">Country<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <select class="devNationArea"  name="country" style="min-width:340px;">
                                    <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                                </select>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">휴대폰<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <div class="selectWrap">
                                    <select class="devNationArea" name="national_phone" >
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                                    </select>
                                    <input type="number" style="margin-left:10px;width:228px;" name="pcs" id="devPcs" value="" title="Phone Number">

                                </div>
                            </div>
                        </li>

                        <!-- @TODO 글로벌 주소 영역 -->

                        <li class="inputs">
                            <span class="inputs__title">Zip/Postal Code<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">
                                    <input type="text" class="" name="zip" id="devZip" class="inputs__content--zip"  style="width:160px" title="Zip/Postal Code">
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">Address line 1<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">
                                    <input type="text" style="width:500px;" id="devAddress1" name="addr1" title="Address line 1" >
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">Address line 2</span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">
                                    <input type="text" style="width:500px;" id="devAddress2" name="addr2" title="Address line 2" >
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">City<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">
                                    <input type="text" style="width:340px"  name="city" id="devCity" title="City" >
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">State/Province<em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">

                                    <select style="width:340px;" id="devStateSelect" title="State/Province">
                                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                                    </select>

                                    <input type="text" style="width:340px;display:none;" id="devStateText"  name="state" title="State/Province" >

                                </div>
                            </div>
                        </li>
                    </ul>
                </section>
            </section>
            <!--<section class="fb__join-input__form">-->
                <!--<section class="input-form">-->
                    <!--<div class="input-form__title-box">-->
                        <!--<p class="input-form__title-box__text">추가 정보 입력 <span>(선택)</span></p>-->
                    <!--</div>-->
                    <!--<ul class="input-form__content-box">-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label for="devUserId">성별</label></span>-->
                            <!--<div class="inputs__content">-->
                                <!--<label class="inputs__label"><input type="radio" title="성별" name="gender" id="M" checked>남자</label>-->
                                <!--<label class="inputs__label"><input type="radio" title="성별" name="gender" id="W">여자</label>-->
                            <!--</div>-->
                        <!--</li>-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label>생일</label></span>-->
                            <!--<div class="inputs__content">-->
                                <!--<label class="inputs__label"><input type="radio" title="양력" name="birthdayDiv" value="1" checked>양력</label>-->
                                <!--<label class="inputs__label"><input type="radio" title="음력" name="birthdayDiv" value="0">음력</label>-->
                                <!--<div class="inputs&#45;&#45;birthday">-->
                                    <!--<select name="birthYear" >-->
                                        <!--<option value="">생년</option>-->
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                                        <!--<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">년</span>-->
                                    <!--<select name="birthMonth" >-->
                                        <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                        <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">월</span>-->
                                    <!--<select name="birthDay" >-->
                                        <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                        <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">일</span>-->
                                <!--</div>-->
                                <!--<p class="inputs__content__guide inputs__content__guide&#45;&#45;color">회원등급별 생일할인 쿠폰이 증정됩니다. 생년월일 최초 1회 입력 이후 변경이 불가능합니다.</p>-->
                            <!--</div>-->
                        <!--</li>-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label>지역</label></span>-->
                            <!--<div class="inputs__content">-->
                                <!--<select name="area"  style="width: 300px">-->
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
                            <!--</div>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</section>-->
            <!--</section>-->
            <section class="fb__join-input__form">

                <section class="input-form">
                    <div class="input-form__title-box">
                        <label class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin" id="all_terms_check">전체 동의</label>
                    </div>
                    <ul class="input-form__content-box">
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="이용약관" id="devPolicyUse" title="이용약관">이용 약관 (필수)</label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <a href="#" class="inputs__content inputs__content--use dd">전체보기</a>
<?php }else{?>
                            <a href="#" class="inputs__content inputs__content--use">View all</a>
<?php }?>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyCollection" name="policyCollection"  title="개인정보 수집 및 이용">개인정보 수집 및 이용 (필수)</label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <a href="#" class="inputs__content inputs__content--private">전체보기</a>
<?php }else{?>
                            <a href="#" class="inputs__content inputs__content--private">View all</a>
<?php }?>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" name="email" value="1" >이메일 수신 동의 (선택)</label>
                            <!--<label><input type="checkbox" name="sms" value="1" >SMS 수신 동의 (선택)</label>-->
                        </li>
                    </ul>
                </section>
            </section>
        </div>
        <div class="wrap-btn-area member fb__join-member__btn-area">
            <button type="button" class="btn-lg btn-dark" id="devCancelButton">취소</button>
            <button class="btn-lg btn-point" id="devBasicSubmitButton">가입하기</button>
        </div>
    </form>
</div>