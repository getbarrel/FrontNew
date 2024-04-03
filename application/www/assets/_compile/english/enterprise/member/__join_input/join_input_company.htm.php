<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/__join_input/join_input_company.htm 000015059 */ ?>
<section class="wrap-member fb__join-member">

    <h2 class="fb__join-member__title">회원가입</h2>

    <ul class="fb__join-member__top-area top-area">
        <li class="top-area__step top-area__step01">
            <div class="top-area__step__inner">
                <span class="top-area__step__subtit">STEP 01</span>
<?php if($TPL_VAR["joinType"]=='C'){?><!--사업자-->
                <p class="top-area__step__tit">사업자인증</p>
<?php }else{?><!--일반-->
                <p class="top-area__step__tit">본인인증</p>
<?php }?>
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

    <div class="wrap-joininput-layout">

        <form id="devCompanyForm" enctype="multipart/form-data">
            <div class="input-tit-area">
                <p>로그인 정보 입력</p>
                <span><em class="point-color">*</em>표시된 항목은 필수 입력사항 입니다.</span>
            </div>

            <table class="join-table">
                <colgroup>
                    <col width="210px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="col"><label for="devUserId"><em>*</em>아이디</label></th>
                    <td>
                        <div>
                            <input type="text" id="devUserId" name="userId" style="width:300px;" title="아이디">
                            <button class="btn-default btn-dark" id="devUserIdDoubleCheckButton">아이디 중복 확인</button>
                        </div>
                        <p class="txt-guide" devTailMsg="devUserId">영문, 숫자 조합하여 6~20자리로 입력해 주세요.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devUserPassword"><em>*</em>비밀번호</label></th>
                    <td>
                        <input type="password" id="devUserPassword" name="pw" style="width:300px;" title="비밀번호">

                        <p class="txt-guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 6~20자리로 입력해 주세요.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devCompareUserPassword"><em>*</em>비밀번호 확인</label></th>
                    <td>
                        <input type="password" id="devCompareUserPassword" name="comparePw" style="width:300px;" title="비밀번호 확인">

                        <p class="txt-guide" devTailMsg="devCompareUserPassword">비밀번호 확인을 위해 다시 한번 입력해 주세요.</p>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="input-tit-area">
                <p>사업자 정보 입력</p>
            </div>
            <table class="join-table">
                <colgroup>
                    <col width="210px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="col"><em>*</em>사업자명</th>
                    <td>
                        <p class="table-txt"><?php echo $TPL_VAR["comName"]?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><em>*</em>사업자등록번호</th>
                    <td>
                        <p class="table-txt"><?php echo $TPL_VAR["comNumber"]?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="comPhone1"><em>*</em>전화 번호</label></th>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devComZipPopupButton"><em>*</em>주소</label></th>
                    <td>
                        <div class="form-info-wrap" style="width:500px">
                            <input type="text" class="dim" name="comZip" id="devComZip" style="width:140px;" title="사업자 주소" readonly>
                            <button class="btn-default btn-dark" id="devComZipPopupButton">주소찾기</button>
                            <input type="text" class="dim mat10" name="comAddr1" id="devComAddress1" style="width:500px;" title="사업자 주소" readonly>
                            <input type="text" class="mat10" style="width:500px;" name="comAddr2" id="devComAddress2" title="사업자 주소">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="input-tit-area">
                <p>대표자 정보 입력</p>
            </div>

            <table class="join-table">
                <colgroup>
                    <col width="210px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="col"><label for="devComCeo"><em>*</em>대표자명</label></th>
                    <td>
                        <input type="text"  id="devComCeo" name="comCeo" style="width:300px;" title="대표자명">

                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devComEmailId"><em>*</em>이메일</label></th>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devComPcs1"><em>*</em>대표 휴대폰 번호</label></th>
                    <td>
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
                            <input type="text" name="comPcs2" id="devComPcs2" title="담당자 휴대폰번호">
                            <span class="hyphen">-</span>
                            <input type="text" name="comPcs3" id="devComPcs3" title="담당자 휴대폰번호">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="input-tit-area">
                <p>담당자 정보 입력</p>
            </div>
            <p class="title-guide"><span>실제 아이디를 이용할 담당자 정보를 입력해 주세요. 이메일 및 SMS안내는 해당 정보 토대로 발송됩니다.</span></p>


            <table class="join-table">
                <colgroup>
                    <col width="210px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="col"><label for="devUserName"><em>*</em>담당자명</label></th>
                    <td>
                        <input type="text" id="devUserName" name="userName" title="담당자명" style="width:300px;">
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label for="devEmailId"><em>*</em>담당자 이메일</label></th>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <th scope="col"><label><em>*</em>담당자 휴대폰번호</label></th>
                    <td>
                        <span class="table-txt certify-pcs-text" id="devCertifyPcsText"></span><span class="certify-complete">인증완료</span>
                        <a class="btn-default btn-dark" id="devCertifyButton">휴대폰 인증</a>
                    </td>
                </tr>
                </tbody>
            </table>



            <div class="input-tit-area">
                <p>증빙자료 서류 첨부</p>
            </div>

            <p class="title-guide">
                <span>파일 형식은 이미지 파일(jpg, jpeg, gif, png)로 제출 가능하며, 최대 30MB까지 가능합니다.</span><br>
                <span>서류는 별도 이메일 주소로 추가 전달 가능합니다. 담당자 이메일<em class="point-color">(forbiz@forbiz.co.kr)</em></span>
            </p>

            <table class="join-table" >
                <colgroup>
                    <col width="210px">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="col"><label><em>*</em>사업자등록증</label></th>
                    <td>
                        <div>
                            <input type="file" name="businessFile" id="devBusinessFile" style="display:none;" title="사업자등록증" accept="image/*"/>
                            <input type="text" class="pub-input-text" style="width:500px;" id="devBusinessFileText" readonly>
                            <button class="btn-default btn-dark" id="devBusinessFileButton">파일찾기</button>
                            <button class="btn-default btn-dark mal10" id="devBusinessFileDeleteButton"
                                    style="display:none;">파일삭제
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <div class="wrap-btn-area fb__join-member__btn-area">
            <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
            <button class="btn-lg btn-point" id="devCompanySubmitButton">사업자 확인</button>
        </div>
    </div>
</section>