<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/profile/profile_company.htm 000018318 */ ?>
<h1 class="wrap-title">
    회원정보 수정
    <button class="back"></button>
</h1>

<div class="wrap-sect"></div>

<div class="wrap-mypage profile-detail">
    <form id="devCompanyProfileForm">
        <div class="wrap-input-form">
            <!-- **로그인 정보 입력** -->
            <div class="input-cpn-tit">로그인 정보 입력</div>
            <section>
                <!-- 아이디 -->
                <dl>
                    <dt>아이디</dt>
                    <dd>
                        <input type="text" value="<?php echo $TPL_VAR["id"]?>" disabled>
                    </dd>
                </dl>

                <!-- 비밀번호 -->
                <dl>
                    <dt>비밀번호 <em>*</em></dt>
                    <dd>
                        <div class="wrap-btn-area">
                            <button type="button" class="btn-default btn-dark" id="devChangePassword">비밀번호 변경</button>
                        </div>
                    </dd>
                </dl>

            </section>

            <div class="wrap-sect"></div>

            <!-- **사업자 정보 입력** -->
            <div class="input-cpn-tit">사업자 정보 입력</div>
            <section>
                <!-- 상호명 -->
                <dl>
                    <dt>상호명</dt>
                    <dd>
                        <input type="text" value="<?php echo $TPL_VAR["com_name"]?>" disabled>
                    </dd>
                </dl>

                <!-- 사업자등록번호 -->
                <dl>
                    <dt>사업자등록번호</dt>
                    <dd>
                        <input type="text" value="<?php echo $TPL_VAR["com_number"]?>" disabled>
                    </dd>
                </dl>

                <!-- 전화번호 -->
                <dl>
                    <dt>전화번호 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <select class="pub-form-set-3rd" name="com_tel1" id="devComTel1" style="width:170px;">
                                <option value="02" <?php if($TPL_VAR["com_phone"][ 0]=="02"){?>selcted<?php }?>>02</option>
                                <option value="031" <?php if($TPL_VAR["com_phone"][ 0]=="031"){?>selcted<?php }?>>031</option>
                                <option value="032" <?php if($TPL_VAR["com_phone"][ 0]=="032"){?>selcted<?php }?>>032</option>
                                <option value="041" <?php if($TPL_VAR["com_phone"][ 0]=="041"){?>selcted<?php }?>>041</option>
                                <option value="042" <?php if($TPL_VAR["com_phone"][ 0]=="042"){?>selcted<?php }?>>042</option>
                                <option value="043" <?php if($TPL_VAR["com_phone"][ 0]=="043"){?>selcted<?php }?>>043</option>
                                <option value="051" <?php if($TPL_VAR["com_phone"][ 0]=="051"){?>selcted<?php }?>>051</option>
                                <option value="052" <?php if($TPL_VAR["com_phone"][ 0]=="052"){?>selcted<?php }?>>052</option>
                                <option value="053" <?php if($TPL_VAR["com_phone"][ 0]=="053"){?>selcted<?php }?>>053</option>
                                <option value="054" <?php if($TPL_VAR["com_phone"][ 0]=="054"){?>selcted<?php }?>>054</option>
                                <option value="055" <?php if($TPL_VAR["com_phone"][ 0]=="055"){?>selcted<?php }?>>055</option>
                                <option value="061" <?php if($TPL_VAR["com_phone"][ 0]=="061"){?>selcted<?php }?>>061</option>
                                <option value="062" <?php if($TPL_VAR["com_phone"][ 0]=="062"){?>selcted<?php }?>>062</option>
                                <option value="063" <?php if($TPL_VAR["com_phone"][ 0]=="063"){?>selcted<?php }?>>063</option>
                                <option value="064" <?php if($TPL_VAR["com_phone"][ 0]=="064"){?>selcted<?php }?>>064</option>
                                <option value="070" <?php if($TPL_VAR["com_phone"][ 0]=="070"){?>selcted<?php }?>>070</option>
                                <option value="080" <?php if($TPL_VAR["com_phone"][ 0]=="080"){?>selcted<?php }?>>080</option>
                                <option value="090" <?php if($TPL_VAR["com_phone"][ 0]=="090"){?>selcted<?php }?>>090</option>
                            </select>

                            <span class="hyphen">-</span>

                            <input type="text" name="com_tel2" value="<?php echo $TPL_VAR["com_phone"][ 1]?>" id="devComTel2" title="사업자 전화번호" style="width:180px;">

                            <span class="hyphen">-</span>

                            <input type="text" name="com_tel3" value="<?php echo $TPL_VAR["com_phone"][ 2]?>" id="devComTel3" title="사업자 전화번호" style="width:180px;">
                        </div>
                    </dd>
                </dl>

                <!-- 주소 -->
                <dl>
                    <dt>주소 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <input type="text" name="com_zip" value="<?php echo $TPL_VAR["com_zip"]?>" id="devComZip" style="width:170px;" title="사업자 주소" readonly>
                            <button type="button" class="btn-default btn-dark mal10" id="devComZipPopupButton">주소찾기</button>
                        </div>

                        <input type="text" class="mat10" name="com_addr1" value="<?php echo $TPL_VAR["com_addr1"]?>" id="devComAddress1" readonly>
                        <input type="text" class="mat10" name="com_addr2" value="<?php echo $TPL_VAR["com_addr2"]?>" id="devComAddress2" title="사업자 주소" placeholder="상세주소를 입력해 주세요.">
                    </dd>
                </dl>
            </section>

            <div class="wrap-sect"></div>

            <!-- **대표자 정보 입력** -->
            <div class="input-cpn-tit">대표자 정보 입력</div>
            <section>
                <!-- 대표자명 -->
                <dl>
                    <dt>대표자명</dt>
                    <dd>
                        <input type="text" value="<?php echo $TPL_VAR["com_ceo"]?>" title="대표자명" disabled>
                    </dd>
                </dl>

                <!-- 이메일 -->
                <dl>
                    <dt>이메일 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <input type="text" name="comEmailId" value="<?php echo $TPL_VAR["com_email"][ 0]?>" id="devComEmailId" title="이메일" style="width:280px;">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="comEmailHost" value="<?php echo $TPL_VAR["com_email"][ 1]?>" id="devComEmailHost" title="이메일" style="display:none;width:270px;">

                            <select id="devComEmailHostSelect" style="width:270px;">
                                <option value="naver.com" <?php if($TPL_VAR["com_email"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["com_email"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["com_email"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["com_email"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["com_email"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["com_email"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>
                        </div>

                        <p class="txt-error mat10" devTailMsg="devComEmailId devComEmailHost"></p>

                        <div class="mat20">
                            <input type="checkbox" id="devDirectInputComEmailCheckBox">
                            <label for="devDirectInputComEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>
                        </div>
                        <button type="button" class="btn-default btn-dark btn-full mat30" id="devComEmailDoubleCheckButton">이메일 중복 확인</button>
                    </dd>
                </dl>

                <!-- 휴대폰 번호 -->
                <dl>
                    <dt>대표 휴대폰 번호 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <select name="com_pcs1" id="devComPcs1" style="width:170px;">
                                <option value="010" <?php if($TPL_VAR["com_mobile"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["com_mobile"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["com_mobile"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["com_mobile"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["com_mobile"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["com_mobile"][ 0]=="019"){?>selcted<?php }?>>019</option>
                            </select>
                            <span class="hyphen">-</span>

                            <input type="text" name="com_pcs2" id="devComPcs2" value="<?php echo $TPL_VAR["com_mobile"][ 1]?>" title="대표 휴대폰 번호" style="width:180px;">

                            <span class="hyphen">-</span>

                            <input type="text" name="com_pcs3" id="devComPcs3" value="<?php echo $TPL_VAR["com_mobile"][ 2]?>" title="대표 휴대폰 번호" style="width:180px;">
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
                    <dt>담당자명</dt>
                    <dd>
                        <input type="text" name="name" value="<?php echo $TPL_VAR["name"]?>" id="devName" title="담당자명">
                    </dd>
                </dl>

                <!-- 이메일 -->
                <dl>
                    <dt>담당자 이메일 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" title="이메일" style="width:280px;">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" title="이메일" style="display:none; width:270px;">

                            <select id="devEmailHostSelect"  style="width:270px;">
                                <option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>

                        </div>

                        <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>

                        <div class="mat20">
                            <input type="checkbox" id="devDirectInputEmailCheckBox">
                            <label for="devDirectInputEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>
                        </div>
                        <button type="button" class="btn-default btn-dark btn-full mat30" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                    </dd>
                </dl>

                <!-- 담당자 휴대폰 번호 -->
                <dl>
                    <dt>담당자 휴대폰 번호 <em>*</em></dt>
                    <dd>
                        <div class="wrap-multi-input">
                            <select name="pcs1" id="devPcs1" style="width:170px;" readonly>
                                <option value="010" <?php if($TPL_VAR["pcs"][ 0]=='010'){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["pcs"][ 0]=='011'){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["pcs"][ 0]=='016'){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["pcs"][ 0]=='017'){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["pcs"][ 0]=='018'){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["pcs"][ 0]=='019'){?>selected<?php }?>>019</option>
                            </select>
                            <span class="hyphen">-</span>

                            <input type="text" name="pcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" id="devPcs2" title="담당자 휴대폰번호" style="width:180px;" readonly>

                            <span class="hyphen">-</span>

                            <input type="text" name="pcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" id="devPcs3" title="담당자 휴대폰번호" style="width:180px;" readonly>
                        </div>
                        <button type="button" class="btn-default btn-dark btn-full mat30" id="devCertifyButton">휴대폰번호 변경</button>

                    </dd>
                </dl>
            </section>

            <div class="wrap-sect"></div>

            <!-- **증빙자료 서류첨부** -->
            <div class="input-cpn-tit">증빙자료 서류첨부</div>
            <section>
                <dl>
                    <dt>사업자등록증</dt>
                    <dd class="wrap-license-upload">
                        <div id="devBusinessFileWrap">
                            <button type="button" class="file-upload-btn" id="devBusinessFileButton"></button>
                            <input type="file" class="file-upload" name="businessFile" id="devBusinessFile" title="사업자등록증" accept="image/*">
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

            <div class="wrap-sect"></div>

            <!--선택 동의 항목-->

            <p class="subtitle">선택 동의 항목</p>

            <div class="term-list">
                <input type="checkbox"  id="devAgreeTerm" name="policy[]" value="<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>" <?php if($TPL_VAR["sms"]=='1'||$TPL_VAR["info"]=='1'){?>checked<?php }?> />
                       <label for="agree-term5">마케팅 활용 동의(선택)</label>
                <span class="accord-btn"></span>
            </div>
            <div class="terms-content">
                <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

            </div>

            <div class="marketing-wrap">
                <p class="tit">마케팅 활용 동의 수신 여부</p>

                <input type="checkbox" id="devAgreeSms" name="sms" value="1" title="SMS" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?> />
                       <label for="agree-term6">SMS 수신</label>

                <input type="checkbox" id="devAgreeEmail" name="email" value="1" title="E-Mail" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?> class="mal40" />
                       <label for="agree-term7">이메일 수신</label>

                <p class="sub-txt mat20">· 쇼핑몰에서 제공되는 다양한 정보를 받아보실 수 있습니다.<br>

                <p class="sub-txt">· 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관 없이 발송됩니다.
                </p>
            </div>
        </div>

        <div class="layout-padding mab80">
            <div class="wrap-btn-area mat30">
                <button type="button" class="btn-lg btn-dark-line" id="devProfileModifyCancel" >취소</button>
                <button class="btn-lg btn-point" >저장</button>
            </div>
        </div>
    </form>
</div>