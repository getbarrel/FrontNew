<?php /* Template_ 2.2.8 2021/10/05 16:08:59 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_input/join_input_basic.htm 000020063 */ 
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
                            <input type="text" title="아이디" name="userId" id="devUserId" devmaxlength="10">
                            <button class="inputs__content__btn" type="button" id="devUserIdDoubleCheckButton" style="vertical-align: middle">Duplicate check</button>
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
                            <input type="password" class="pub-input-text" id="devUserPassword" name="pw" title="비밀번호">
                            <p class="inputs__content__guide" devTailMsg="devUserPassword">Two or more combinations of upper and lowercase letters, numbers and special charactiers. Minimum 8, max 16 characters.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label for="devCompareUserPassword">Confirm Password</label><em class="inputs__title--star">*</em></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" title="비밀번호 확인">
                            <p class="inputs__content__warning" devTailMsg="devCompareUserPassword"></p>
                        </div>
                    </li>
<?php }?>
                    <li class="inputs">
                        <span class="inputs__title">Name<em class="inputs__title--star">*</em></span>
                        <div class="inputs__content">
                            <input type="text" name="userName" id="devUserName" value="<?php echo $TPL_VAR["userName"]?>" class="input__user-name" title="Name">
                            <p class="inputs__content__text" name="devUserName" id="devFormatUserName"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title">Tel<em class="inputs__title--star">*</em></span>
                        <div class="inputs__content">
                            <div class="selectWrap">
                                <select name="pcs1"  id="devPcs1">
                                    <option value="010" <?php if($TPL_VAR["pcs1"]=="010"){?>selcted<?php }?>>010</option>
                                    <option value="011" <?php if($TPL_VAR["pcs1"]=="011"){?>selcted<?php }?>>011</option>
                                    <option value="016" <?php if($TPL_VAR["pcs1"]=="016"){?>selcted<?php }?>>016</option>
                                    <option value="017" <?php if($TPL_VAR["pcs1"]=="017"){?>selcted<?php }?>>017</option>
                                    <option value="018" <?php if($TPL_VAR["pcs1"]=="018"){?>selcted<?php }?>>018</option>
                                    <option value="019" <?php if($TPL_VAR["pcs1"]=="019"){?>selcted<?php }?>>019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" title="휴대폰번호" >
                                <span class="hyphen">-</span>
                                <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" title="휴대폰번호" >
                            </div>
                        </div>
                    </li>
                    <!--<li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>Birth</span>
                        <div class="inputs__content">
                            <input type="text" name="birthday" id="devBirthday">
                            <p class="inputs__content__text" name="changeFormatBirthday" id="devFromatBirthday"><?php echo $TPL_VAR["changeFormatBirthday"]?></p>
                        </div>
                    </li>-->
                    <!--<li class="inputs">
                        <span class="inputs__title">Gender</span>
                        <div class="inputs__content">
                            <input type="hidden" name="sex" id="devSexDiv">
                            <p class="inputs__content__text" name="changeFormatSexDiv" id="devFormatSexDiv"><?php echo $TPL_VAR["changeFormatSexDiv"]?></p>
                        </div>
                    </li>-->
                    <li class="inputs">
                        <span class="inputs__title"><label for="devEmailId">Email<em class="inputs__title--star">*</em></label></span>
                        <div class="inputs__content">
                            <span class="pub-email">
                            <input type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["emailId"]?>" style="width:160px;" title="이메일 주소">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>" style="width:160px; " title="이메일 주소">
                            <select id="devEmailHostSelect" class="input__select" style="width: 160px; vertical-align: middle;">
                                <option value="">Select Email</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                                <option value="" selected="selected">Direct input.</option>
                            </select>

                            <button class="btn-default btn-dark" id="devEmailDoubleCheckButton" type="button" style="margin-left: 0; vertical-align: middle;">Duplicate check</button>

                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>

                        </div>
                    </li>
                    <!-- <li class="inputs">
                        <span class="inputs__title">Address<em class="inputs__title--star">*</em></span>
                        <div class="inputs__content">
                            <div class="form-info-wrap info__address">
                                <input type="text" class="" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>"  class="inputs__content--zip"  style="width:160px"readonly title="Zip code search">
                                <button type="button" class="btn-dark inputs__content--zip-search" id="devZipPopupButton">Zip code search</button>
                                <input type="text" class=" mat10" name="addr1" id="devAddress1" style="width:500px;" value="<?php echo $TPL_VAR["addr1"]?>" readonly>
                                <input type="text" class="mat10" style="width:500px;" id="devAddress2" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" title="Detail address" >
                            </div>
                        </div>
                    </li> -->
                    <li class="inputs">
                        <span class="inputs__title">미성년확인<em class="inputs__title--star">*</em><br>(만14세이상입니까?)</span>
                        <div class="inputs__content">
                            <label class="inputs__label"><input type="radio" title="미성년확인" name="underAge" id="devUnderAge" value="Y"><span style="vertical-align: middle">Yes</span></label>
                            <label class="inputs__label"><input type="radio" title="미성년확인" name="underAge" id="devUnderAge" value="N"><span style="vertical-align: middle">No</span></label>
                        </div>
                    </li>
                </ul>
            </section>
        </section>
        <section class="fb__join-input__form">
            <section class="input-form">
                <div class="input-form__title-box">
                     <p class="input-form__title-box__text">Optional <span>(select)</span></p>
                </div>
                <ul class="input-form__content-box">
					<li class="inputs">
                        <span class="inputs__title">Address</span>
                        <div class="inputs__content">
                            <div class="form-info-wrap info__address">
                                <input type="text" class="" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" class="inputs__content--zip" style="width:160px" readonly title="Zip code search">
                                <button type="button" class="btn-dark inputs__content--zip-search" id="devZipPopupButton">Zip code search</button>
                                <input type="text" class="mat10" name="addr1" id="devAddress1" style="width:500px;" value="<?php echo $TPL_VAR["addr1"]?>" readonly>
                                <input type="text" class="mat10" style="width:500px;" id="devAddress2" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" title="Detail address">
                            </div>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label for="devUserId">Gender</label></span>
                        <div class="inputs__content inputs__content--sex">
                            <label class="inputs__label"><input type="radio" title="성별" name="gender" id="M" <?php if($TPL_VAR["gender"]=="M"){?>checked<?php }?>><span style="vertical-align: middle">Male</span></label>
                            <label class="inputs__label"><input type="radio" title="성별" name="gender" id="W" <?php if($TPL_VAR["gender"]=="W"){?>checked<?php }?>><span style="vertical-align: middle">Female</span></label>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label>Birth</label></span>
                        <div class="inputs__content inputs__content--birth">
                            <label class="inputs__label"><input type="radio" title="양력" name="birthdayDiv" value="1" <?php if($TPL_VAR["birthdayDiv"]=="1"){?>checked<?php }?>><span style="vertical-align: middle">solar calendar</span></label>
                            <label class="inputs__label"><input type="radio" title="음력" name="birthdayDiv" value="0" <?php if($TPL_VAR["birthdayDiv"]=="0"){?>checked<?php }?>><span style="vertical-align: middle">lunar calendar</span></label>
                            <div class="inputs--birthday">
                                <select name="birthYear" id="devbirthYear">
                                    <option value=""></option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthYearText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                </select>
                                <span class="selecttext">Year</span>
                                <select name="birthMonth" id="devbirthMonth">
                                    <option value=""></option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthMonthText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                </select>
                                <span class="selecttext">Month</span>
                                <select name="birthDay" id="devbirthDay">
                                    <option value="" ></option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthDayText"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                </select>
                                <span class="selecttext">day</span>
                            </div>
                            <p class="inputs__content__guide inputs__content__guide--color">영문몰해당없음</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label>Region</label></span>
                        <div class="inputs__content">
                            <select name="area"  style="width: 300px">
                                <option value="">Select</option>
                                <option value="10">Seoul</option>
                                <option value="20">Gyeonggi</option>
                                <option value="21">Incheon</option>
                                <option value="30">Gangwon</option>
                                <option value="41">Chungcheongnam-do</option>
                                <option value="42">Daejeon</option>
                                <option value="43">Sejong</option>
                                <option value="45">Chungcheongbuk-do</option>
                                <option value="51">Jeollanam-do</option>
                                <option value="52">Gwangju</option>
                                <option value="55">Jeollabuk-do</option>
                                <option value="61">Gyeongsangnam-do</option>
                                <option value="62">Busan</option>
                                <option value="63">Ulsan</option>
                                <option value="65">Gyeongsangbuk-do</option>
                                <option value="66">Daegu</option>
                                <option value="70">Jeju Island</option>
                                <option value="90">ETC</option>
                            </select>
                        </div>
                    </li>
                </ul>
            </section>
        </section>
        <section class="fb__join-input__form">

            <section class="input-form">
                <div class="input-form__title-box">
                    <label class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin" id="all_terms_check" style="vertical-align: bottom;">Agree all</label>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs inputs__agree agree-content">
                        <label><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="이용약관" id="devPolicyUse" title="Terms and Conditions" style="vertical-align: text-top;">Terms and conditions (Required)</label>
                        <a href="#" class="inputs__content inputs__content--use">All</a>
                    </li>
                    <li class="inputs inputs__agree agree-content">
                        <label><input type="checkbox" id="devPolicyCollection" name="policyCollection"  title="Collection and utilization of personal information" style="vertical-align: text-top;">Privacy Policy (Required)</label>
                        <a href="#" class="inputs__content inputs__content--private">All</a>
                    </li>
					<li class="inputs inputs__agree agree-content">
                        <label><input type="checkbox" name="collection" value="1"  style="vertical-align: text-top;">개인정보 수집 및 이용 (선택)</label>
                        <a href="#" class="inputs__content inputs__content--private">All</a>
                    </li>
                    <li class="inputs inputs__agree agree-content">
                        <label><input type="checkbox" name="email" value="1"  style="vertical-align: text-top;">Receive Email (Optional)</label>
                    </li>
                    <li class="inputs inputs__agree agree-content">
                        <label><input type="checkbox" name="sms" value="1"  style="vertical-align: text-top;">Accept SMS reception (optional)</label>
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