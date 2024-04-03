<?php /* Template_ 2.2.8 2021/10/05 14:28:01 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_input/join_input_global.htm 000020072 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<div class="fb__join-member fb__join-input">
    <h2 class="fb__join-member__title">Join</h2>
    <p class="fb__join-member__subtitle">If you become a Barrel member, you enjoy special benefits such as discount coupons and points.</p>
    <!--   <ul class="fb__join-member__top-area top-area">
           <li class="top-area__step top-area__step01">
               <div class="top-area__step__inner">
                   <p class="top-area__step__tit">Identity verification</p>
               </div>
           </li>
           <li class="top-area__step top-area__step02">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 02</span>
                   <p class="top-area__step__tit">Agree</p>
               </div>
           </li>
           <li class="top-area__step top-area__step03 top-area__step&#45;&#45;active">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 03</span>
                   <p class="top-area__step__tit">Enter Information</p>
               </div>
           </li>
           <li class="top-area__step top-area__step04">
               <div class="top-area__step__inner">
                   <span class="top-area__step__subtit">STEP 04</span>
                   <p class="top-area__step__tit">Welcome!</p>
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
                        <p class="input-form__title-box__text">Member Information input</p>
                        <span class="input-form__title-box__guide"><em class="star">*</em>Checked area is required.</span>
                    </div>
                    <ul class="input-form__content-box">
<?php if(empty($TPL_VAR["snsType"])){?>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devUserId">ID</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="text" title="ID" name="userId" id="devUserId" devmaxlength="10">
                                <button class="inputs__content__btn" type="button" id="devUserIdDoubleCheckButton" style="min-width:190px;">Duplicate check</button>
                                <p class="inputs__content__warning" devTailMsg="devUserId"></p>
                                <div class="link__box"  id="devDupMember" style="display:none;">
                                    <a href="/member/login" class="link__box--login">Sign in</a>
                                    <a href="/member/searchPw" class="link__box--search">Find Password</a>
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devUserPassword">Password</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" class="pub-input-text" id="devUserPassword" name="pw" title="Password">
                                <p class="inputs__content__guide" devTailMsg="devUserPassword">Two or more combinations of upper and lowercase letters, numbers and special charactiers. Minimum 8, max 16 characters.</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devCompareUserPassword">Confirm Password</label><em class="inputs__title--star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" title="Confirm Password">
                                <p class="inputs__content__warning" devTailMsg="devCompareUserPassword">Password doesn&#39;t match.</p>
                            </div>
                        </li>
<?php }?>
                        <!-- @TODO 위치변경 확인 -->
                        <li class="inputs">
                            <span class="inputs__title"><label for="devEmailId">Email<em class="inputs__title--star">*</em></label></span>
                            <div class="inputs__content">
                            <span class="pub-email">
                            <input type="text" name="emailId" id="devEmailId" style="width:157px;" title="E-mail address">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" id="devEmailHost" style="width:157px;" title="E-mail address">
                            <!--<select id="devEmailHostSelect" class="input__select">
                                <option value="">Select Email</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                                <option value="" selected="selected">Direct input.</option>
                            </select>-->

                            <button class="btn-default btn-dark" id="devEmailDoubleCheckButton" type="button"  style="min-width:190px;">Duplicate check</button>

                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>

                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">Name<em class="inputs__title--star">*</em></span>
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
                            <span class="inputs__title">Tel<em class="inputs__title--star">*</em></span>
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
                        <!--<p class="input-form__title-box__text">Optional <span>(select)</span></p>-->
                    <!--</div>-->
                    <!--<ul class="input-form__content-box">-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label for="devUserId">Gender</label></span>-->
                            <!--<div class="inputs__content">-->
                                <!--<label class="inputs__label"><input type="radio" title="성별" name="gender" id="M" checked>남자</label>-->
                                <!--<label class="inputs__label"><input type="radio" title="성별" name="gender" id="W">여자</label>-->
                            <!--</div>-->
                        <!--</li>-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label>Birth</label></span>-->
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
                                    <!--<span class="selecttext">Year</span>-->
                                    <!--<select name="birthMonth" >-->
                                        <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                        <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">Month</span>-->
                                    <!--<select name="birthDay" >-->
                                        <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                        <!--<option value="<?php echo $TPL_V1?>" ><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">day</span>-->
                                <!--</div>-->
                                <!--<p class="inputs__content__guide inputs__content__guide&#45;&#45;color">영문몰해당없음</p>-->
                            <!--</div>-->
                        <!--</li>-->
                        <!--<li class="inputs">-->
                            <!--<span class="inputs__title"><label>Region</label></span>-->
                            <!--<div class="inputs__content">-->
                                <!--<select name="area"  style="width: 300px">-->
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
                            <!--</div>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</section>-->
            <!--</section>-->
            <section class="fb__join-input__form">

                <section class="input-form">
                    <div class="input-form__title-box">
                        <label class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin" id="all_terms_check">Agree all</label>
                    </div>
                    <ul class="input-form__content-box">
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="이용약관" id="devPolicyUse" title="Terms and Conditions">Terms and conditions (Required)</label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <a href="#" class="inputs__content inputs__content--use dd">All</a>
<?php }else{?>
                            <a href="#" class="inputs__content inputs__content--use">View all</a>
<?php }?>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyCollection" name="policyCollection"  title="Collection and utilization of personal information">Privacy Policy (Required)</label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <a href="#" class="inputs__content inputs__content--private">All</a>
<?php }else{?>
                            <a href="#" class="inputs__content inputs__content--private">View all</a>
<?php }?>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" name="email" value="1" >Receive Email (Optional)</label>
                            <!--<label><input type="checkbox" name="sms" value="1" >Accept SMS reception (optional)</label>-->
                        </li>
                    </ul>
                </section>
            </section>
        </div>
        <div class="wrap-btn-area member fb__join-member__btn-area">
            <button type="button" class="btn-lg btn-dark" id="devCancelButton">Cancel</button>
            <button class="btn-lg btn-point" id="devBasicSubmitButton">Join</button>
        </div>
    </form>
</div>