<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/profile/profile_company.htm 000018205 */ ?>
<div class="fb__mypage profile-detail">
    <form id="devCompanyProfileForm" class="fb__mypage__profile">
        <input type="hidden" name="pcs" value="<?php echo $TPL_VAR["pcs"][ 0]?>-<?php echo $TPL_VAR["pcs"][ 1]?>-<?php echo $TPL_VAR["pcs"][ 2]?>" id="devPcs"/>
        <div class="profile">
            <section>
                <h2 class="fb__mypage__title">로그인 정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">아이디</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["id"]?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>비밀번호</th>
                        <td>
                            <button type="button" class="btn-default btn-dark change-pw-btn" id="devChangePassword">비밀번호 변경</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="fb__mypage__section">
                <h2 class="fb__mypage__title">사업자 정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">상호명</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["com_name"]?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">사업자등록번호</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["com_number"]?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>전화번호</th>
                        <td>
                            <div class="selectWrap">
                                <select name="com_tel1" id="devComTel1">
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
                                <input type="text" name="com_tel2" value="<?php echo $TPL_VAR["com_phone"][ 1]?>" id="devComTel2" title="사업자 전화번호">
                                <span class="hyphen">-</span>
                                <input type="text" name="com_tel3" value="<?php echo $TPL_VAR["com_phone"][ 2]?>" id="devComTel3" title="사업자 전화번호">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>주소</th>
                        <td>
                            <div class="form-info-wrap" style="width:500px">
                                <input type="text" class="" name="com_zip" value="<?php echo $TPL_VAR["com_zip"]?>" id="devComZip" style="width:140px;" readonly>
                                <button class="btn-default btn-dark" id="devComZipPopupButton">우편번호 검색</button>
                                <input type="text" class=" mat10" name="com_addr1" value="<?php echo $TPL_VAR["com_addr1"]?>" id="devComAddress1" style="width:500px;" readonly>
                                <input type="text" class="mat10" style="width:500px;" name="com_addr2" value="<?php echo $TPL_VAR["com_addr2"]?>" id="devComAddress2">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="fb__mypage__section">
                <h2 class="fb__mypage__title">대표자 정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">대표자명</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["com_ceo"]?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>이메일</th>
                        <td>
                            <span class="pub-email">
                                <input type="text" name="comEmailId" value="<?php echo $TPL_VAR["com_email"][ 0]?>" id="devComEmailId" style="width:160px;" title="이메일">
                                <span class="hyphen_2">@</span>
                                <input type="text" name="comEmailHost" value="<?php echo $TPL_VAR["com_email"][ 1]?>" id="devComEmailHost" style="width:160px;" title="이메일">
                            </span>
                            <select id="devComEmailHostSelect" style="width:160px; margin-left:5px;">
                                <option value="">직접입력</option>
                                <option value="naver.com" <?php if($TPL_VAR["com_email"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["com_email"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["com_email"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["com_email"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["com_email"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["com_email"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>
                            <button type="button" class="btn-default btn-dark" id="devComEmailDoubleCheckButton">이메일 중복 확인</button>
                            <p class="txt-error" devTailMsg="devComEmailId devComEmailHost"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>대표 휴대폰 번호</th>
                        <td>
                            <div class="selectWrap">
                                <select name="com_pcs1"  id="devComPcs1">
                                    <option value="010" <?php if($TPL_VAR["com_mobile"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                    <option value="011" <?php if($TPL_VAR["com_mobile"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                    <option value="016" <?php if($TPL_VAR["com_mobile"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                    <option value="017" <?php if($TPL_VAR["com_mobile"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                    <option value="018" <?php if($TPL_VAR["com_mobile"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                    <option value="019" <?php if($TPL_VAR["com_mobile"][ 0]=="019"){?>selcted<?php }?>>019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="number" name="com_pcs2" id="devComPcs2" value="<?php echo $TPL_VAR["com_mobile"][ 1]?>" title="대표 휴대폰 번호">
                                <span class="hyphen">-</span>
                                <input type="number"  name="com_pcs3" id="devComPcs3" value="<?php echo $TPL_VAR["com_mobile"][ 2]?>" title="대표 휴대폰 번호">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="fb__mypage__section">
                <h2 class="fb__mypage__title">담당자 정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">담당자명</th>
                        <td>
                            <input type="text" name="name" value="<?php echo $TPL_VAR["name"]?>" id="devName" title="담당자명" style="width:300px;">
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>담당자 이메일</th>
                        <td>
                            <span class="pub-email">
                            <input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                        </span>
                            <select id="devEmailHostSelect" style="width:160px; margin-left:5px;">
                                <option value="">직접입력</option>
                                <option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>
                            <button type="button" class="btn-default btn-dark" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>담당자 휴대폰번호</th>
                        <td>
                            <span class="font-rb" id="devCertifyPcsText"><?php echo $TPL_VAR["pcs"][ 0]?>-<?php echo $TPL_VAR["pcs"][ 1]?>-<?php echo $TPL_VAR["pcs"][ 2]?></span>
                            <a class="btn-default btn-dark mal30" id="devCertifyButton">휴대폰번호 변경</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="fb__mypage__section">
                <h2 class="fb__mypage__title">증빙자료 서류 첨부</h2>

                <p class="title-guide">
                    <span>파일 형식은 이미지 파일(jpg, jpeg, gif, png)로 제출 가능하며, 최대 30MB까지 가능합니다.</span><br>
                    <span>서류는 별도 이메일 주소로 추가 전달 가능합니다. 담당자 이메일<em class="fb__point-color">(forbiz@forbiz.co.kr)</em></span>
                </p>

                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col" class="ver-m">사업자등록증</th>
                        <td>
                            <div>
                                <input type="file" name="businessFile" id="devBusinessFile" style="display:none;" title="사업자등록증" accept="image/*"/>
                                <input type="text" class="pub-input-text" style="width:500px;" id="devBusinessFileText" readonly>
                                <button type="button" class="btn-default btn-dark" id="devBusinessFileButton">파일찾기</button>
                                <button type="button" class="btn-default btn-dark mal10" id="devBusinessFileDeleteButton" style="display:none;">파일삭제</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>

            <section class="fb__mypage__section">
                <h2 class="fb__mypage__title">선택 동의 항목</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col" class="ver-m">마케팅 활용 동의</th>
                        <td>
                            <div class="wrap-terms">
                                <div class="input-terms">
                                    <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

                                </div>
                                <div class="wrap-terms-check">
                                    <input type="checkbox" id="devAgreeTerm" name="policy[]" value="<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>" <?php if($TPL_VAR["sms"]=='1'||$TPL_VAR["info"]=='1'){?>checked<?php }?> />
                                    <label for="agree-term5" class="mar10">동의</label>
                                    (
                                    <input type="checkbox" id="devAgreeSms" name="sms" value="1" title="SMS" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?> />
                                    <label for="agree-term6" class="mar10">SMS 수신</label>
                                    <input type="checkbox" id="devAgreeEmail" name="email" value="1" title="E-Mail" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?> />
                                    <label for="agree-term7" class="mar10">이메일 수신</label>
                                    )
                                </div>

                                <p class="desc">
                                    · 쇼핑몰에서 제공되는 다양한 정보를 받아보실 수 있습니다.<br>
                                    · 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관 없이 발송됩니다.
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>


            <div class="profile__btn">
                <button type="button" class="profile__btn--cancel" id="devProfileModifyCancel">취소</button>
                <button class="profile__btn--save" >저장</button>
            </div>
        </div>
    </form>
</div>