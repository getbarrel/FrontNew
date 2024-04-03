<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_input/join_input_company.htm 000016732 */ ?>
<section class="fb__join-member fb__join-input">

    <h2 class="fb__join-member__title">Join</h2>

    <ul class="fb__join-member__top-area top-area">
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
        <li class="top-area__step top-area__step03 top-area__step--active">
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
    </ul>

    <section class="fb__join-input__form">
        <form id="devCompanyForm"  enctype="multipart/form-data">

            <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">Enter login information</p>
                    <span class="input-form__title-box__guide"><em class="star">*</em>Checked area is required.</span>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserId">ID</label></span>
                        <div class="inputs__content">
                            <input type="text" title="아이디" name="userId" id="devUserId" devmaxlength="10">
                            <button class="inputs__content__btn" type="button" id="devUserIdDoubleCheckButton" >ID Check</button>
                            <p class="inputs__content__guide"  devTailMsg="devUserId">Please enter 6 to 20 digits in combination with English and numbers.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserPassword">Password</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devUserPassword" name="pw" style="width:300px;" title="비밀번호">
                            <p class="inputs__content__guide" devTailMsg="devUserPassword">Three or more combinations of upper and lowercase letters, numbers, and speical characters. Minimum 6, max 20 characters.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devCompareUserPassword">Confirm Password</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" style="width:300px;" title="비밀번호 확인">
                            <p class="inputs__content__guide" devTailMsg="devCompareUserPassword">Enter again to confirm your password.</p>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">Enter business information</p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>Name of business owner</span>
                        <div class="inputs__content">
                            <input type="hidden" name="comCeo" value="<?php echo $TPL_VAR["comName"]?>">
                            <p class="inputs__content__text"><?php echo $TPL_VAR["comName"]?></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>Business registration number</span>
                        <div class="inputs__content">
                            <input type="hidden" name="comNumber" value="<?php echo $TPL_VAR["comNumber"]?>">
                            <p class="inputs__content__text"><?php echo $TPL_VAR["comNumber"]?></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label for="comPhone1"><em class="star">*</em>Tel</label></span>
                        <div class="inputs__content">
                            <div class="selectWrap">
                                <select name="comPhone1" id="comPhone1">
                                    <option value="02">02</option>
                                    <option value="031">031</option>
                                    <option value="032">032</option>
                                    <option value="041">041</option>
                                    <option value="042">042</option>
                                    <option value="043">043</option>
                                    <option value="051">051</option>
                                    <option value="052">052</option>
                                    <option value="053">053</option>
                                    <option value="054">054</option>
                                    <option value="055">055</option>
                                    <option value="061">061</option>
                                    <option value="062">062</option>
                                    <option value="063">063</option>
                                    <option value="064">064</option>
                                    <option value="070">070</option>
                                    <option value="080">080</option>
                                    <option value="090">090</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="text" name="comPhone2" id="comPhone2" title="사업자 전화번호">
                                <span class="hyphen">-</span>
                                <input type="text" name="comPhone3" id="comPhone3" title="사업자 전화번호">
                            </div>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label for="devComZipPopupButton"><em class="star">*</em>Address</label></span>
                        <div class="inputs__content">
                            <div class="form-info-wrap" style="width:500px">
                                <input type="text" class="" name="comZip" id="devComZip" style="width:140px;" title="사업자 주소" readonly>
                                <button class="btn-default btn-dark" id="devComZipPopupButton">Find Address</button>
                                <input type="text" class=" mat10" name="comAddr1" id="devComAddress1" style="width:500px;" title="사업자 주소" readonly>
                                <input type="text" class="mat10" style="width:500px;" name="comAddr2" id="devComAddress2" title="사업자 주소">
                            </div>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">Enter CEO information</p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devComCeo">Representative</label></span>
                        <div class="inputs__content">
                            <input type="text"  id="devComCeo" name="comCeo" style="width:300px;" title="대표자명">
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devComEmailId">Email</label></span>
                        <div class="inputs__content">
                            <span class="pub-email">
                                 <input type="text" name="comEmailId" id="devComEmailId" style="width:160px;" title="이메일">
                                 <span class="hyphen_2">@</span>
                                 <input type="text" name="comEmailHost" id="devComEmailHost" style="width:160px;" title="이메일">
                            </span>

                            <select id="devComEmailHostSelect" style="width:160px; margin-left:5px;">
                                <option value="">Direct input.</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                            </select>
                            <p class="txt-error" devTailMsg="devComEmailId devComEmailHost"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devComPcs1">Representative cell phone number</label></span>
                        <div class="inputs__content">
                            <div class="selectWrap">
                                <select name="comPcs1" id="devComPcs1">
                                    <option value="010">010</option>
                                    <option value="011">011</option>
                                    <option value="016">016</option>
                                    <option value="017">017</option>
                                    <option value="018">018</option>
                                    <option value="019">019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="text" name="comPcs2" id="devComPcs2" title="대표 휴대폰번호">
                                <span class="hyphen">-</span>
                                <input type="text" name="comPcs3" id="devComPcs3" title="대표 휴대폰번호">
                            </div>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">
                        Enter information of the person in charge
                        <span class="input-form__title-box__text-sub">Please enter the information of the PIC who will use the actual ID. Email and SMS instructions are sent based on that information.</span>
                    </p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserName">Name of the person in charge</label></span>
                        <div class="inputs__content">
                            <input type="text"  id="devUserName" name="userName" style="width:300px;" title="담당자명">
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devEmailId">E-mail of the person in charge</label></span>
                        <div class="inputs__content">
                            <span class="pub-email">
                               <input type="text" name="emailId" id="devEmailId" style="width:160px;" title="담당자 이메일">
                               <span class="hyphen_2">@</span>
                               <input type="text" name="emailHost" id="devEmailHost" style="width:160px;" title="담당자 이메일">
                            </span>
                            <select id="devEmailHostSelect" class="" style="width:160px; margin-left:5px;">
                                <option value="">Direct input.</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                            </select>
                            <button class="btn-default btn-dark" id="devEmailDoubleCheckButton">Duplicate check</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label>Cell phone number of the person in charge</label></span>
                        <div class="inputs__content">
                            <span class="table-txt certify-pcs-text" id="devCertifyPcsText"></span><span class="certify-complete">Certification Completed</span>
                            <a class="btn-default btn-dark" id="devCertifyButton">Verify with mobile.</a>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">
                        Attachment of evidence material
                        <span class="input-form__title-box__text-sub">
                            The file format can be submitted as an image file(jpg, jpeg, gif, png), up to 30MB.<br>
                            Additional documents can be forwarded to a separate email address. E-mail of the person in charge<em class="fb__point-color">(forbiz@forbiz.co.kr)</em>
                        </span>
                    </p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserName">Business license Registration</label></span>
                        <div class="inputs__content pub-form-info-wrap">
                            <input type="file" name="businessFile" id="devBusinessFile" style="display:none;" title="사업자등록증" accept="image/*"/>
                            <input type="text" class="pub-input-text" style="width:500px;" id="devBusinessFileText" readonly>
                            <button class="btn-default btn-dark" id="devBusinessFileButton">Find Files</button>
                            <button class="btn-default btn-dark mal10" id="devBusinessFileDeleteButton" style="display:none;">
                                File delete
                            </button>
                        </div>
                    </li>
                </ul>
            </section>
        </form>
    </section>
    <div class="wrap-btn-area member fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">Cancel</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">Business license confirm</button>
    </div>

</section>