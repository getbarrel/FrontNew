<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_sns/join_sns.htm 000011374 */ ?>
<div class="fb__join-member fb__join-input fb__join-sns">
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

    <div class="wrap-joininput-layout">
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
                            <span class="inputs__title"><label for="devEmailId"><em class="star">*</em>이메일 주소</label></span>
                            <div class="inputs__content">
                                <span class="pub-email">
                                <input type="text" name="emailId" id="devEmailId" style="width:160px;" title="이메일 주소">
                                <span class="hyphen_2">@</span>
                                <input type="text" name="emailHost" id="devEmailHost" style="width:160px;" title="이메일 주소">
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><em class="star">*</em>이름</span>
                            <div class="inputs__content">
                                <input type="text" name="userName" id="devUserName">
                                <p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><em class="star">*</em>휴대폰</span>
                            <div class="inputs__content">
                                <div class="selectWrap">
<?php if($TPL_VAR["explodePcs"][ 0]!=''){?>
                                    <input type="number" name="pcs1" id="devPcs1" value="<?php echo $TPL_VAR["explodePcs"][ 0]?>" title="휴대폰" readonly>
<?php }else{?>
                                    <select name="pcs1"  id="devPcs1">
                                        <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selcted<?php }?>>019</option>
                                    </select>
<?php }?>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?>>
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>>
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><em class="star">*</em>주소</span>
                            <div class="inputs__content">
                                <div class="form-info-wrap">
                                    <input type="text" class="dim" name="zip" id="devZip" style="width:140px;" readonly>
                                    <button class="btn-default btn-dark" id="devZipPopupButton">우편번호 검색</button>
                                    <input type="text" class="dim mat10" name="addr1" id="devAddress1" style="width:500px;" readonly>
                                    <input type="text" class="mat10" style="width:500px;" name="addr2">
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>
            </form>
        </section>
        <section class="fb__join-input__form">
            <form id="devBasicForm">
                <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
                <section class="input-form">
                    <div class="input-form__title-box">
                        <p class="input-form__title-box__text">추가 정보 입력 <span>(선택)</span></p>
                    </div>
                    <ul class="input-form__content-box">
                        <li class="inputs">
                            <span class="inputs__title"><label for="devUserId">성별</label></span>
                            <div class="inputs__content">
                                <label class="inputs__label"><input type="radio" title="성별" name="sex" id="male" checked>남자</label>
                                <label class="inputs__label"><input type="radio" title="성별" name="sex" id="female">여자</label>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label>생일</label></span>
                            <div class="inputs__content">
                                <label class="inputs__label"><input type="radio" title="양력" name="birth" checked>양력</label>
                                <label class="inputs__label"><input type="radio" title="음력" name="birth">음력</label>
                                <div class="inputs--birthday">
                                    <select name="year" id="">
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                    </select>
                                    <span class="selecttext">년</span>
                                    <select name="month" id="">
                                        <option value="2019">01</option>
                                        <option value="2018">02</option>
                                    </select>
                                    <span class="selecttext">월</span>
                                    <input type="text" class="day" maxlength="2"><label class="selecttext">일</label>
                                </div>
                                <p class="inputs__content__guide">회원등급별 생일할인 쿠폰이 증정됩니다. 생년월일 최초 1회 입력 이후 변경이 불가능합니다.</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label>지역</label></span>
                            <div class="inputs__content">
                                <select name="area" id="" style="width: 300px">
                                    <option value="서울"></option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </section>
            </form>
        </section>
        <section class="fb__join-input__form">
            <form id="devBasicForm">
                <input type="hidden" name="memType" id="devMemType" value="<?php echo $TPL_VAR["joinType"]?>">
                <section class="input-form">
                    <div class="input-form__title-box">
                        <label class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin">전체 동의</label>
                    </div>
                    <ul class="input-form__content-box">
                        <li class="inputs inputs__agree">
                            <input type="checkbox" id="terms"><label for="terms">이용 약관 (필수)</label>
                            <a href="#" class="inputs__content">전체보기</a>
                        </li>
                        <li class="inputs inputs__agree">
                            <input type="checkbox" id="personal"><label for="personal">개인정보 수집 및 이용 (필수)</label>
                            <a href="#" class="inputs__content">전체보기</a>
                        </li>
                        <li class="inputs inputs__agree">
                            <input type="checkbox" id="email"><label for="email">이메일 수신 동의 (선택)</label>
                            <input type="checkbox" id="sms"><label for="sms">SMS 수신 동의 (선택)</label>
                        </li>
                    </ul>
                </section>
            </form>
        </section>
    </div>
    <div class="wrap-btn-area member fb__join-member__btn-area">
        <button class="btn-lg btn-dark" id="devCancelButton">취소</button>
        <button class="btn-lg btn-point" id="devBasicSubmitButton">가입하기</button>
    </div>
</div>