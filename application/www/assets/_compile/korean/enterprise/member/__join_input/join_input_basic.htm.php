<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/__join_input/join_input_basic.htm 000008742 */ ?>
<section class="fb__join-input fb__join-member">
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

    <section class="fb__join-input__form">
        <form id="devBasicForm">
            <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
            <section class="input-form">
                <div class="input-form__title-box">
                    <p class="input-form__title-box__text">회원정보입력</p>
                    <span class="input-form__title-box__guide"><em class="star">*</em>표시된 항목은 필수 입력사항 입니다.</span>
                </div>
                <ul class="input-form__content-box">
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devEmailId">이메일 아이디</label></span>
                        <div class="inputs__content">
                            <div class="email">
                                <input type="text" name="emailId" id="devEmailId" <?php if($TPL_VAR["isSnsJoin"]){?>value='<?php echo $TPL_VAR["emailId"]?>' readonly<?php }?> title="이메일">
                                <span class="input-between">@</span>
                                <input type="text" name="emailHost" id="devEmailHost" <?php if($TPL_VAR["isSnsJoin"]){?>value='<?php echo $TPL_VAR["emailHost"]?>' readonly<?php }?>  title="이메일">
                            </div>
                            <select id="devEmailHostSelect" style="width:160px; margin-left:5px;" <?php if($TPL_VAR["isSnsJoin"]){?>disabled<?php }?>>
                            <option value="">직접입력</option>
                            <option value="naver.com">naver.com</option>
                            <option value="gmail.com">gmail.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                            <option value="nate.com">nate.com</option>
                            </select>
                            <button type="button" class="inputs__content__btn" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                            <p class="inputs__content__boxes-error" devTailMsg="devEmailId devEmailHost"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devNickname">닉네임</label></span>
                        <div class="inputs__content">
                            <input type="text" title="닉네임" name="nickname" id="devNickname" devmaxlength="10">
                            <button class="inputs__content__btn" type="button" id="devNicknameDoubleCheckButton" >닉네임 중복 확인</button>
                            <p class="inputs__content__guide" devTailMsg="devNickname">국문, 영문, 숫자, 특수문자 모두 가능하며 10자 내외로 입력해 주세요.</p>
                        </div>
                    </li>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devUserPassword">비밀번호</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devUserPassword" name="pw" style="width:300px;" title="비밀번호">
                            <p class="inputs__content__guide" devTailMsg="devUserPassword">영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 8자리 이상 입력해 주세요.</p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em><label for="devCompareUserPassword">비밀번호 확인</label></span>
                        <div class="inputs__content">
                            <input type="password" class="pub-input-text" id="devCompareUserPassword" name="comparePw" style="width:300px;" title="비밀번호 확인">
                            <p class="inputs__content__guide" devTailMsg="devCompareUserPassword">비밀번호 확인을 위해 다시 한번 입력해 주세요.</p>
                        </div>
                    </li>
<?php }?>

                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>이름</span>
                        <div class="inputs__content">
                            <input type="hidden" name="userName" id="devUserName">
                            <p class="inputs__content__text" name="devUserName" id="devFormatUserName"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>생년월일</span>
                        <div class="inputs__content">
                            <input type="hidden" name="birthday" id="devBirthday">
                            <p class="inputs__content__text" name="changeFormatBirthday" id="devFromatBirthday"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>성별</span>
                        <div class="inputs__content">
                            <input type="hidden" name="sex" id="devSexDiv">
                            <p class="inputs__content__text" name="changeFormatSexDiv" id="devFormatSexDiv"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title"><em class="star">*</em>휴대폰 번호</span>
                        <div class="inputs__content">
                            <input type="hidden" name="pcs" id="devPcs">
                            <p class="inputs__content__text" name="formatPcs" id="devFormatPcs"></p>
                        </div>
                    </li>
                    <li class="inputs">
                        <span class="inputs__title">추천친구</span>
                        <div class="inputs__content">
                            <input type="hidden" name="confirmRecFriend" id ='devConfirmRecFriend'>
                            <input type="text" title="추천친구" name="recmFriend" id="devRecommandFriend">
                            <button class="inputs__content__btn" id="devNicknameChk">확인</button>
                            <p class="inputs__content__guide" id="devRecommandFriendText">추천할 친구의 닉네임을 입력해 주세요.</p>
                        </div>
                    </li>
                </ul>
            </section>
        </form>
    </section>

    <div class="wrap-btn-area fb__join-member__btn-area">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button type="submit" class="btn-lg btn-point" id="devBasicSubmitButton">회원가입</button>
    </div>

</section>