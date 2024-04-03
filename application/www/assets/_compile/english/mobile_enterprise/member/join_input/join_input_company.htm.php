<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_input/join_input_company.htm 000012559 */ ?>
<h1 class="wrap-title">
    회원가입
</h1>

<div class="wrap-step">
    <p>정보입력</p>
    <ul class="step">
        <li class="">1</li>
        <li class="">2</li>
        <li class="on">3</li>
        <li class="">4</li>
    </ul>
</div>
<div class="wrap-sect"></div>

<form id="devCompanyForm" enctype="multipart/form-data">

    <div class="wrap-input-form">
        <!-- **로그인 정보 입력** -->
        <div class="input-cpn-tit">로그인 정보 입력</div>
        <section>
            <!-- 아이디 -->
            <dl>
                <dt>아이디 <em>*</em></dt>
                <dd>
                    <input type="text" id="devUserId" name="userId" title="아이디">
                    <p class="txt-guide" devTailMsg="devUserId">영문, 숫자 조합하여 6~20자리로 입력해 주세요.</p>
                    <button class="btn-default btn-dark btn-full mat10" id="devUserIdDoubleCheckButton">아이디 중복 확인</button>
                </dd>
            </dl>

            <!-- 비밀번호 -->
            <dl>
                <dt>비밀번호 <em>*</em></dt>
                <dd>
                    <input type="password" id="devUserPassword" name="pw" title="비밀번호">
                    <p class="txt-guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 6~20자리로 입력해 주세요.</p>
                </dd>
            </dl>

            <!-- 비밀번호 확인 -->
            <dl>
                <dt>비밀번호 확인 <em>*</em></dt>
                <dd>
                    <input type="password" id="devCompareUserPassword" name="comparePw" title="비밀번호 확인">
                    <p class="txt-error" devTailMsg="devCompareUserPassword"></p>
                </dd>
            </dl>
        </section>

        <div class="wrap-sect"></div>

        <!-- **사업자 정보 입력** -->
        <div class="input-cpn-tit">사업자 정보 입력</div>
        <section>
            <!-- 이름 -->
            <dl>
                <dt>상호명 <em>*</em></dt>
                <dd>
                    <input type="text" value="<?php echo $TPL_VAR["comName"]?>" disabled>
                </dd>
            </dl>

            <!-- 생년월일 -->
            <dl>
                <dt>사업자등록번호 <em>*</em></dt>
                <dd>
                    <input type="text" value="<?php echo $TPL_VAR["comNumber"]?>" disabled>
                </dd>
            </dl>

            <!-- 전화번호 -->
            <dl>
                <dt>전화번호 <em>*</em></dt>
                <dd>
                    <div class="wrap-multi-input">
                        <select class="pub-form-set-3rd" name="comPhone1" style="width:170px;">
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

                        <input type="text" name="comPhone2" id="comPhone2" title="사업자 전화번호" style="width:180px;">

                        <span class="hyphen">-</span>

                        <input type="text" name="comPhone3" id="comPhone3" title="사업자 전화번호" style="width:180px;">
                    </div>
                </dd>
            </dl>

            <!-- 주소 -->
            <dl>
                <dt>주소 <em>*</em></dt>
                <dd>
                    <div class="wrap-multi-input">
                        <input type="text" name="comZip" id="devComZip" style="width:170px;" title="사업자 주소" readonly>
                        <button class="btn-default btn-dark mal10" id="devComZipPopupButton">주소찾기</button>
                    </div>

                    <input type="text" class="mat10" name="comAddr1" id="devComAddress1" readonly>
                    <input type="text" class="mat10" name="comAddr2" id="devComAddress2" title="사업자 주소" placeholder="상세주소를 입력해 주세요.">
                </dd>
            </dl>
        </section>

        <div class="wrap-sect"></div>

        <!-- **대표자 정보 입력** -->
        <div class="input-cpn-tit">대표자 정보 입력</div>
        <section>
            <!-- 대표자명 -->
            <dl>
                <dt>대표자명 <em>*</em></dt>
                <dd>
                    <input type="text" id="devComCeo" name="comCeo" title="대표자명">
                </dd>
            </dl>

            <!-- 이메일 -->
            <dl>
                <dt>이메일 <em>*</em></dt>
                <dd>
                    <div class="wrap-multi-input">
                        <input type="text" name="comEmailId" id="devComEmailId" title="이메일" style="width:280px;">
                        <span class="hyphen_2">@</span>
                        <input type="text" name="comEmailHost" id="devComEmailHost" title="이메일" style="display:none; width:270px;">

                        <select id="devComEmailHostSelect" style="width:270px;">
                            <option value="naver.com">naver.com</option>
                            <option value="gmail.com">gmail.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                            <option value="nate.com">nate.com</option>
                        </select>
                    </div>

                    <p class="txt-error mat10" devTailMsg="devComEmailId devComEmailHost"></p>

                    <div class="mat20">
                        <input type="checkbox" id="devDirectInputComEmailCheckBox">
                        <label for="devDirectInputComEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>
                    </div>
                </dd>
            </dl>

            <!-- 휴대폰 번호 -->
            <dl>
                <dt>휴대폰 번호 <em>*</em></dt>
                <dd>
                    <div class="wrap-multi-input">
                        <select name="comPcs1" id="devComPcs1" style="width:170px;">
                            <option value="010">010</option>
                            <option value="011">011</option>
                            <option value="016">016</option>
                            <option value="017">017</option>
                            <option value="018">018</option>
                            <option value="019">019</option>
                        </select>
                        <span class="hyphen">-</span>

                        <input type="text" name="comPcs2" id="devComPcs2" title="담당자 휴대폰번호" style="width:180px;">

                        <span class="hyphen">-</span>

                        <input type="text" name="comPcs3" id="devComPcs3" title="담당자 휴대폰번호" style="width:180px;">
                    </div>
                </dd>
            </dl>
        </section>


        <div class="wrap-sect"></div>

        <!-- **담당자 정보 입력** -->
        <div class="input-cpn-tit">담당자 정보 입력</div>
        <section>
            <!-- 담당자명 -->
            <dl>
                <dt>담당자명 <em>*</em></dt>
                <dd>
                    <input type="text" id="devUserName" name="userName" title="담당자명">
                </dd>
            </dl>

            <!-- 이메일 -->
            <dl>
                <dt>이메일 <em>*</em></dt>
                <dd>
                    <div class="wrap-multi-input">
                        <input type="text" name="emailId" id="devEmailId" title="이메일" style="width:280px;">
                        <span class="hyphen_2">@</span>
                        <input type="text" name="emailHost" id="devEmailHost" title="이메일"
                               style="display:none; width:270px;">

                        <select id="devEmailHostSelect"  style="width:270px;">
                            <option value="naver.com">naver.com</option>
                            <option value="gmail.com">gmail.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                            <option value="nate.com">nate.com</option>
                        </select>

                    </div>

                    <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>

                    <div class="mat20">
                        <input type="checkbox" id="devDirectInputEmailCheckBox">
                        <label for="devDirectInputEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>
                    </div>
                    <button class="btn-default btn-dark btn-full mat30" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                </dd>
            </dl>

            <!-- 담당자 휴대폰 번호 -->
            <dl>
                <dt>담당자 휴대폰 번호 <em>*</em></dt>
                <dd>
                    <button class="btn-default btn-dark btn-full" id="devCertifyButton">휴대폰 인증</button>

                    <div class="wrap-phone-auth" style="display:none;" id="devCertifyCompleteAreaWrap">
                        <span class="certify-pcs-text" id="devCertifyPcsText"></span><span class="certify-complete">인증완료</span>
                    </div>
                </dd>
            </dl>
        </section>

        <div class="wrap-sect"></div>

        <!-- **증빙자료 서류첨부** -->
        <div class="input-cpn-tit">증빙자료 서류첨부</div>
        <section>
            <dl>
                <dt>사업자등록증 <em>*</em></dt>
                <dd class="wrap-license-upload">
                    <div id="devBusinessFileWrap">
                        <button class="file-upload-btn"></button>
                        <input type="file" class="file-upload" name="businessFile" id="devBusinessFile" title="사업자등록증"
                               accept="image/*">
                    </div>

                    <div class="upload-img-area" id="devBusinessFileImageWrap" style="display:none;">
                        <img id="devBusinessFileImage">
                        <span class="upload-cancel-btn" id="devBusinessFileDeleteButton"></span>
                    </div>

                    <p class="desc">· 파일 형식은 이미지 파일(jpg, jpeg, gif, png)로 제출 가능합니다.</p>
                    <p class="desc">· 파일 용량은 최대 30MB까지 가능합니다.</p>
                    <p class="desc">· 서류는 별도 이메일 주소로 추가 제출 가능합니다.<br> &nbsp&nbsp담당자 이메일 : forbiz@forbiz.co.kr</p>

                </dd>
            </dl>
        </section>

    </div>

    <!-- 버튼 -->
    <div class="wrap-btn-area input-cpn">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">회원가입</button>
    </div>

</form>