<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/brand/application_form_Indivisual/application_form_Indivisual.htm 000023073 */ 
$TPL_attendGroup_1=empty($TPL_VAR["attendGroup"])||!is_array($TPL_VAR["attendGroup"])?0:count($TPL_VAR["attendGroup"]);
$TPL_attendEvent_1=empty($TPL_VAR["attendEvent"])||!is_array($TPL_VAR["attendEvent"])?0:count($TPL_VAR["attendEvent"]);?>
<script src="/assets/templet/enterprise/js/brand/jquery.ui.widget.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.iframe-transport.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.fileupload.js"></script>
<section class="fb__content">
    <div class="fb__application-form fb__application-form--indivisual">
        <div class="fb__application-form__head">
            <h2 class="fb__application-form__title">
                2020 배럴 스프린트 챔피언십<br>
                온라인 참가 신청서<br>
                <strong>[개인]</strong>
            </h2>
            <p class="fb__application-form__desc">(english)본 신청서는 개인 참가 신청서입니다. 필수 기입사항을 정확하게 기입해 주시기 바랍니다.</p>
        </div>

        <form id="devBasicForm" enctype="multipart/form-data" method="post" autocomplete="off">
            <input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>"/>
            <input type="hidden" name="gp_ix" value="<?php echo $TPL_VAR["gp_ix"]?>"/>
            <input type="hidden" name="cm_ix" value="<?php echo $TPL_VAR["cm_ix"]?>"/>
            <input type="hidden" name="email" value="Y" />
            <input type="hidden" name="sms" value="Y" />
            <div class="fb__join-input__form fb__application-form__content">
                <section class="input-form form-box">
                    <div class="form-box__head">
                        <h3 class="input-form__title-box__text form-box__title">참가자 기본 정보</h3>
                        <span class="input-form__title-box__guide form-box__guide"><em class="star">*</em>표시된 항목은 필수 입력사항 입니다.</span>
                    </div>

                    <ul class="input-form__content-box">
                        <li class="inputs">
                            <span class="inputs__title"><label for="devAttendDiv">참가구분</label></span>
                            <div class="inputs__content">
                                <input type="hidden" name="attend_div" id="devAttendDiv" value="1">
                                <p class="inputs__content__text">개인</p>
                            </div>
                        </li>

                        <li class="inputs">
                            <span class="inputs__title">이름(실명) <em class="star">*</em></span>
                            <div class="inputs__content">
                                <input type="text" name="userName" id="devUserName" title="이름(실명)" class="w236 input__user-name target-name" value="<?php echo $TPL_VAR["name"]?>">
                                <span class="inputs__desc pl12">(띄어쓰기 없이 입력해 주세요.)</span>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="">Gender</label></span>
                            <div class="inputs__content inputs__content--sex">
                                <label class="inputs__label"><input type="radio" title="성별" name="sex" value="M" <?php if($TPL_VAR["sex"]=='M'||$TPL_VAR["sex"]==''){?>checked<?php }?>><span style="vertical-align: middle">male</span></label>
                                <label class="inputs__label"><input type="radio" title="성별" name="sex" value="F" <?php if($TPL_VAR["sex"]=='F'){?>checked<?php }?>><span style="vertical-align: middle">female</span></label>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">생년월일 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <input type="number" name="birthday" id="devBirthday" title="생년월일"  class="w236 input__user-birth" value="<?php echo $TPL_VAR["birthday"]?>" maxlength="6">
                                <span class="inputs__desc pl12">(예 : 830724)</span>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">핸드폰 번호 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <div class="selectWrap phone-number">
                                    <select name="pcs1"  id="devPcs1" class="w110">
                                        <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰번호" class="w110" maxlength="4">
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰번호" class="w110" maxlength="4">
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devEmailId">이메일 주소 <em class="star">*</em></label></span>
                            <div class="inputs__content">
                                <div class="email">
                                    <input type="text" name="emailId" id="devEmailId" class="w160" title="이메일" value="<?php echo $TPL_VAR["explodeEmail"][ 0]?>">
                                    <span class="input-between">@</span>
                                    <input type="text" name="emailHost" id="devEmailHost" class="w190" title="이메일" value="<?php echo $TPL_VAR["explodeEmail"][ 1]?>">
                                </div>
                                <select id="devEmailHostSelect" class="email__select w190">
                                    <option value="">Direct input.</option>
                                    <option value="naver.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                    <option value="gmail.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                    <option value="hotmail.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                    <option value="hanmail.net" <?php if($TPL_VAR["explodeEmail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                    <option value="daum.net" <?php if($TPL_VAR["explodeEmail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                    <option value="nate.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                                </select>
                                <p class="inputs__content__boxes-error" devTailMsg="devEmailId devEmailHost"></p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">참가기념 티셔츠<br>사이즈 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <select name="size" id="devSize" class="size__select w160" title="사이즈">
                                    <option value="">선택</option>
                                    <option value="S" <?php if($TPL_VAR["size"]=="S"){?>selected<?php }?>>S</option>
                                    <option value="M" <?php if($TPL_VAR["size"]=="M"){?>selected<?php }?>>M</option>
                                    <option value="L" <?php if($TPL_VAR["size"]=="L"){?>selected<?php }?>>L</option>
                                    <option value="XL" <?php if($TPL_VAR["size"]=="XL"){?>selected<?php }?>>XL</option>
                                    <option value="XXL" <?php if($TPL_VAR["size"]=="XXL"){?>selected<?php }?>>XXL</option>
                                </select>
                                <p class="inputs__desc inputs__desc--blue">· 사이즈 교환은 불가하오니 신중하게 선택 부탁드립니다.</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">사전 참가기념품<br>수령 주소 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap info__address">
                                    <input type="text" class="w160" name="zip" id="devZip" class="inputs__content--zip" readonly title="Zip code search" value="<?php echo $TPL_VAR["postnum"]?>">
                                    <button type="button" class="btn-dark inputs__content--zip-search" id="devZipPopupButton">Zip code search</button>
                                    <input type="text" class=" info__address__input w362" name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>" readonly>
                                    <input type="text" class="info__address__input w362" id="devAddress2" name="addr2" title="Detail address" value="<?php echo $TPL_VAR["address2"]?>">
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">사진첨부 <em class="star">*</em></span>
                            <div class="inputs__content info__pic">
                                <div class="form-info-wrap file-box">
                                    <input type="text" class="info__pic__input w362 find-file__name" id="devImageUrl"  name="image_url" title="(english)사진첨부" value="<?php echo $TPL_VAR["image_url"]?>" >
                                    <input type="hidden" class="find-file__name" id="devImageUrlPath"  name="image_url_path" title="(english)사진첨부" value="<?php echo $TPL_VAR["image_url_path"]?>">
                                    <label class="detail-box__list-file__choose file__label">파일찾기</label>
                                    <input class="file__upload" name="image_file" id="devFile" type="file" title="파일찾기" data-url="/controller/event/tmpFileUpload">
<?php if($TPL_VAR["image_path"]){?>
                                    <img src="<?php echo $TPL_VAR["image_path"]?>"/>
<?php }?>
                                </div>
                                <p class="inputs__desc">
                                    <span class="inputs__desc--blue">
                                    · AD카드 발급을 위한 사진 (증명사진과 같이 통상적으로 신분 확인이 가능한 얼굴이 명확하게 나온 사진) 을  첨부해주시기 바랍니다.<br>
                                    · 등록하실 이미지파일 이름을 ‘소속명_이름’ 으로 저장하여 첨부해주시기 바랍니다. (예: 배럴팀_홍길동) / 소속명이 없으신 경우 (예:개인_홍길동)<br>
                                    </span>
                                    · 파일 형식은 이미지 파일(jpg, jpeg, png)로 제출 가능하며, 파일당 최대 2MB까지 가능합니다.
                                </p>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="input-form form-box">
                    <div class="form-box__head">
                        <h3 class="input-form__title-box__text form-box__title">(english)대회 참가 정보</h3>
                        <span class="input-form__title-box__guide form-box__guide"><em class="star">*</em>Checked area is required.</span>
                    </div>

                    <ul class="input-form__content-box">
                        <li class="inputs">
                            <span class="inputs__title"><label for="">(english)소속명</label><em class="star">*</em></span>
                            <div class="inputs__content part-name">
                                <input type="text" name="class_name" id="devClass" class="w362 part-name_input input__user-name" value="<?php echo $TPL_VAR["class_name"]?>" title="소속명">
                                <p class="inputs__desc">
                                    <span class="inputs__desc--blue">
                                    · (english)소속이 없을 경우, ‘개인’ 이라고 기입하시기 바랍니다.<br>
                                    </span>
                                    · (english)특수기호(!, @, #, $, %, ^, &, (), * 등)는 사용이 불가합니다.
                                </p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)참가 그룹 <em class="star">*</em></span>
                            <div class="inputs__content part-group">
                                <select name="attend_group" id="devAttendGroup" class="w200" <?php if(empty($TPL_VAR["attend_group"])){?>disabled<?php }?> title="참가그룹">
                                    <option value="">선택해주세요</option>
<?php if($TPL_attendGroup_1){foreach($TPL_VAR["attendGroup"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_group"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                                </select>
                                <p class="inputs__desc" >
                                    <strong id="devAttendDesc" class="inputs__desc--black" style="display:none">91년 01월 01일 ~ 00년 12월 31일</strong>

                                    <!-- 텍스트 노출 : class "txt-show" 추가 -->
                                    <span id="devAttendRedDesc" class="inputs__desc--red" style="display: none;">
                                    · (english)참가자 기본 정보에서 기입하신 생년월일과 맞지 않는 그룹입니다.
                                    </span>
                                </p>
                            </div>
                        </li>
                        <li class="inputs">
                            <div>
                                <span class="inputs__title">(english)참가종목1 <em class="star">*</em></span>
                                <div class="inputs__content">
                                    <select name="attend_event1" id="devAttendEvent1" class="w200" title="참가종목1">
                                        <option value="">선택해주세요</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_event1"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                                    </select>
                                    <span class="inputs__desc pl12">(참가종목은 중복 선택 불가능)</span>
                                </div>
                            </div>
                            <div style="margin-top: -20px;">
                                <span class="inputs__title">(english)참가종목2</span>
                                <div class="inputs__content">
                                    <select name="attend_event2" id="devAttendEvent2" class="w200" title="참가종목2">
                                        <option value="">선택해주세요</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_event2"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)입금계좌</span>
                            <div class="inputs__content">
                                <p class="inputs__content__text">농협  <span class="inputs__desc--blue"> 317-0010-3539-61 </span>    예금주 : (주)배럴</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)참가비</span>
                            <div class="inputs__content part-cost">
                                <p class="inputs__content__text inputs__desc--blue">30,000원</p>
                            </div>
                        </li>
                        <li class="inputs deposit__info__name">
                            <span class="inputs__title">(english)입금자명 <em class="star">*</em></span>
                            <div class="inputs__content depositor deposit__info__checkbox">
                                <input type="text" name="depositor" id="devDepositor" class="w200 input__user-name" value="<?php echo $TPL_VAR["depositor"]?>" title="입금자명">
                                <label class="w200">
                                    <input type="checkbox" name="" id="" <?php if($TPL_VAR["name"]==$TPL_VAR["depositor"]&&!empty($TPL_VAR["depositor"])){?>checked<?php }?>>
                                    <span class="txt">(english)선수명과 동일합니다.</span>
                                </label>
                                <p class="inputs__desc"></p>
                            </div>
                        </li>
<?php if($TPL_VAR["type"]!='M'){?>
                        <li class="inputs deposit__info__password">
                            <span class="inputs__title"><strong>(english)신청서 비밀번호</strong> <em class="star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" name="password" id="devPassword" class="w200" maxlength="4" value="<?php echo $TPL_VAR["password"]?>" title="신철서 비밀번호">
                                <span class="inputs__desc pl12">(숫자 4자리 예:1234)</span>
                                <p class="inputs__desc--blue">· 신청서 비밀번호는 신청서 등록 완료 후에 신청서 수정에 필요한 정보이므로 반드시 기억해 주시기 바랍니다.</p>
                            </div>
                        </li>
<?php }?>
                    </ul>
                </section>

                <section class="input-form agree-area">
                    <div class="form-box__head">
                        <div class="input-form__title-box agree-area__title">
                            <label for="all_terms_check" class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin" id="all_terms_check" <?php if($TPL_VAR["all_check"]=='Y'){?> checked <?php }?> style="vertical-align: bottom;">Agree all</label>
                        </div>
                    </div>

                    <ul class="input-form__content-box">
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="대회 이용약관" id="devPolicyUse" title="(english)대회 이용약관" <?php if($TPL_VAR["use_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">(english)대회 이용 약관 (필수)</label>
                            <a href="#" class="inputs__content inputs__content--use view-all">All</a>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyCollection" name="policyCollection"  title="Collection and utilization of personal information" <?php if($TPL_VAR["collection_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">Privacy Policy (Required)</label>
                            <a href="#" class="inputs__content inputs__content--private view-all">All</a>
                        </li>
                        <!--<li class="inputs inputs__agree agree-content">-->
                            <!--<label><input type="checkbox" name="email" value="1" <?php if($TPL_VAR["email_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">Receive Email (Optional)</label>-->
                        <!--</li>-->
                        <!--<li class="inputs inputs__agree agree-content">-->
                            <!--<label><input type="checkbox" name="sms" value="1" <?php if($TPL_VAR["sms_yn"]=='Y'){?> checked <?php }?>  style="vertical-align: text-top;">Accept SMS reception (optional)</label>-->
                        <!--</li>-->
                    </ul>
                </section>
                <div class="wrap-btn-area member fb__join-member__btn-are fb__application-form__btn">
                    <button type="button" class="btn-lg btn-dark group__btn--reset" id="devCancelButton">Reset</button>
                    <button type="button" class="btn-lg btn-point" id="devBasicSubmitButton">Application</button>
                </div>
            </div>
        </form>
    </div>
</section>