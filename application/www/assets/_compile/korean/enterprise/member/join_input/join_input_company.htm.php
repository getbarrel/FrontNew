<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-qa/application/www.bak/assets/templet/enterprise/member/join_input/join_input_company.htm 000016722 */ ?>
<section class="fb__join-member fb__join-input">

    <h2 class="fb__join-member__title">회원가입</h2>

    <ul class="fb__join-member__top-area top-area">
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
        <li class="top-area__step top-area__step03 top-area__step--active">
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
    </ul>

    <section class="fb__join-input__form">
        <form id="devCompanyForm"  enctype="multipart/form-data">

            <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">로그인 정보 입력</p>
                    <span class="input-form__title-box__guide"><em class="star">*</em>표시된 항목은 필수 입력사항 입니다.</span>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserId">아이디</label></span>
                        <div class="inputs__content">
                            <input type="text" title="아이디" name="userId" id="devUserId" devmaxlength="10">
                            <button class="inputs__content__btn" type="button" id="devUserIdDoubleCheckButton" >아이디 중복 확인</button>
                            <p class="inputs__content__guide"  devTailMsg="devUserId">영문, 숫자 조합하여 6~20자리로 입력해 주세요.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserPassword">비밀번호</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devUserPassword" name="pw" style="width:300px;" title="비밀번호">
                            <p class="inputs__content__guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 6~20자리로 입력해 주세요.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devCompareUserPassword">비밀번호 확인</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" style="width:300px;" title="비밀번호 확인">
                            <p class="inputs__content__guide" devTailMsg="devCompareUserPassword">비밀번호 확인을 위해 다시 한번 입력해 주세요.</p>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">사업자 정보 입력</p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>사업자명</span>
                        <div class="inputs__content">
                            <input type="hidden" name="comCeo" value="<?php echo $TPL_VAR["comName"]?>">
                            <p class="inputs__content__text"><?php echo $TPL_VAR["comName"]?></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>사업자등록번호</span>
                        <div class="inputs__content">
                            <input type="hidden" name="comNumber" value="<?php echo $TPL_VAR["comNumber"]?>">
                            <p class="inputs__content__text"><?php echo $TPL_VAR["comNumber"]?></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><label for="comPhone1"><em class="star">*</em>전화번호</label></span>
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
                        <span class="inputs__title"><label for="devComZipPopupButton"><em class="star">*</em>주소</label></span>
                        <div class="inputs__content">
                            <div class="form-info-wrap" style="width:500px">
                                <input type="text" class="" name="comZip" id="devComZip" style="width:140px;" title="사업자 주소" readonly>
                                <button class="btn-default btn-dark" id="devComZipPopupButton">주소찾기</button>
                                <input type="text" class=" mat10" name="comAddr1" id="devComAddress1" style="width:500px;" title="사업자 주소" readonly>
                                <input type="text" class="mat10" style="width:500px;" name="comAddr2" id="devComAddress2" title="사업자 주소">
                            </div>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">대표자 정보 입력</p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devComCeo">대표자명</label></span>
                        <div class="inputs__content">
                            <input type="text"  id="devComCeo" name="comCeo" style="width:300px;" title="대표자명">
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devComEmailId">이메일</label></span>
                        <div class="inputs__content">
                            <span class="pub-email">
                                 <input type="text" name="comEmailId" id="devComEmailId" style="width:160px;" title="이메일">
                                 <span class="hyphen_2">@</span>
                                 <input type="text" name="comEmailHost" id="devComEmailHost" style="width:160px;" title="이메일">
                            </span>

                            <select id="devComEmailHostSelect" style="width:160px; margin-left:5px;">
                                <option value="">직접입력</option>
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
                        <span class="inputs__title"><em class="star">*</em><label for="devComPcs1">대표 휴대폰 번호</label></span>
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
                        담당자 정보 입력
                        <span class="input-form__title-box__text-sub">실제 아이디를 이용할 담당자 정보를 입력해 주세요. 이메일 및 SMS안내는 해당 정보 토대로 발송됩니다.</span>
                    </p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserName">담당자명</label></span>
                        <div class="inputs__content">
                            <input type="text"  id="devUserName" name="userName" style="width:300px;" title="담당자명">
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devEmailId">담당자 이메일</label></span>
                        <div class="inputs__content">
                            <span class="pub-email">
                               <input type="text" name="emailId" id="devEmailId" style="width:160px;" title="담당자 이메일">
                               <span class="hyphen_2">@</span>
                               <input type="text" name="emailHost" id="devEmailHost" style="width:160px;" title="담당자 이메일">
                            </span>
                            <select id="devEmailHostSelect" class="" style="width:160px; margin-left:5px;">
                                <option value="">직접입력</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                            </select>
                            <button class="btn-default btn-dark" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label>담당자 휴대폰 번호</label></span>
                        <div class="inputs__content">
                            <span class="table-txt certify-pcs-text" id="devCertifyPcsText"></span><span class="certify-complete">인증완료</span>
                            <a class="btn-default btn-dark" id="devCertifyButton">휴대폰 인증</a>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">
                        증빙자료 서류 첨부
                        <span class="input-form__title-box__text-sub">
                            파일 형식은 이미지 파일(jpg, jpeg, gif, png)로 제출 가능하며, 최대 30MB까지 가능합니다.<br>
                            서류는 별도 이메일 주소로 추가 전달 가능합니다. 담당자 이메일<em class="fb__point-color">(forbiz@forbiz.co.kr)</em>
                        </span>
                    </p>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserName">사업자등록증</label></span>
                        <div class="inputs__content pub-form-info-wrap">
                            <input type="file" name="businessFile" id="devBusinessFile" style="display:none;" title="사업자등록증" accept="image/*"/>
                            <input type="text" class="pub-input-text" style="width:500px;" id="devBusinessFileText" readonly>
                            <button class="btn-default btn-dark" id="devBusinessFileButton">파일찾기</button>
                            <button class="btn-default btn-dark mal10" id="devBusinessFileDeleteButton" style="display:none;">
                                파일삭제
                            </button>
                        </div>
                    </li>
                </ul>
            </section>
        </form>
    </section>
    <div class="wrap-btn-area member fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">사업자 확인</button>
    </div>

</section>