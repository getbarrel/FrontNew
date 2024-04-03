<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/brand/application_form_indivisual/application_form_indivisual.htm 000021729 */ 
$TPL_attendGroup_1=empty($TPL_VAR["attendGroup"])||!is_array($TPL_VAR["attendGroup"])?0:count($TPL_VAR["attendGroup"]);
$TPL_attendEvent_1=empty($TPL_VAR["attendEvent"])||!is_array($TPL_VAR["attendEvent"])?0:count($TPL_VAR["attendEvent"]);?>
<script src="/assets/templet/enterprise/js/brand/jquery.ui.widget.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.iframe-transport.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.fileupload.js"></script>
<section class="br__join br__group">
    <div class="group__header">
        <h2 class="group__header__title">2020 배럴 스프린트 챔피언십<br>온라인 참가 신청서</h2>
        <p class="group__header__type">[개인]</p>
        <p class="group__header__desc">본 신청서는 개인 참가 신청서입니다. <br>필수 기입사항을 정확하게 기입해 주시기 바랍니다.</p>
    </div>
    <!--[S] 개인 기본 정보 -->
    <form id="devBasicForm" enctype="multipart/form-data" method="post" autocomplete="off">
        <input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>"/>
        <input type="hidden" name="gp_ix" value="<?php echo $TPL_VAR["gp_ix"]?>"/>
        <input type="hidden" name="cm_ix" value="<?php echo $TPL_VAR["cm_ix"]?>"/>
        <section class="br__group-info br__group-info--team">
            <h3 class="br__group-info__title">참가자 기본 정보</h3>
            <div class="br__group-info__content">
                <p class="br__group-info__desc"><em class="star">*</em> 표시된 항목은 필수 입력사항 입니다.</p>
                <input type="hidden" name="attend_div" id="devAttendDiv" value="1">
                <dl class="br__join__list br__join__list--type">
                    <dt>참가구분</dt>
                    <dd>개인</dd>
                </dl>
                <dl class="br__join__list">
                    <dt>
                        이름(실명)<em class="star">*</em>
                        <span class="subdesc">(띄어쓰기 없이 입력해주세요.)</span>
                    </dt>
                    <dd>
                        <input type="text" class="js__joininput__name target-name" name="userName" id="devUserName" title="이름(실명)"  value="<?php echo $TPL_VAR["name"]?>">
                    </dd>
                </dl>
                <dl class="br__join__add">
                    <dt class="join-symbol">Gender<em class="star">*</em></dt>
                    <dd class="br__find-user__label">
                        <label><input type="radio" name="sex" value="M" <?php if($TPL_VAR["sex"]=='M'||$TPL_VAR["sex"]==''){?>checked<?php }?>><span>male</span></label>
                        <label><input type="radio" name="sex" value="F" <?php if($TPL_VAR["sex"]=='F'){?>checked<?php }?>><span>female</span></label>
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>생년월일<em class="star">*</em><span class="subdesc">(예:830724)</span></dt>
                    <dd>
                        <input type="text" name="birthday" id="devBirthday" title="생년월일" value="<?php echo $TPL_VAR["birthday"]?>" class="birthday__input js__joininput__number" maxlength="6">
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>휴대폰<em class="star">*</em></dt>
                    <dd>
                        <div class="join__phone">
                            <select class="join__phone-first" name="pcs1" id="devPcs1">
                                <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                            </select>
                            <span class="join__phone-hyphen"></span>
                            <input class="join__input join__phone-second" type="text" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="Tel" maxlength="4"/>
                            <span class="join__phone-hyphen"></span>
                            <input class="join__input join__phone-third" type="text" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="Tel" maxlength="4"/>
                        </div>
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>이메일 주소<em class="star">*</em></dt>
                    <dd>
                        <div class="join__eamil">
                            <input class="join__input email-id" type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["explodeEmail"][ 0]?>" title="Email"/>
                            <span>@</span>
                            <input class="join__input email-info" type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["explodeEmail"][ 1]?>" title="Email"/>
                        </div>
                        <select id="devEmailHostSelect">
                            <option value="">Direct input.</option>
                            <option value="naver.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                            <option value="gmail.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                            <option value="hotmail.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                            <option value="hanmail.net" <?php if($TPL_VAR["explodeEmail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                            <option value="daum.net" <?php if($TPL_VAR["explodeEmail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                            <option value="nate.com" <?php if($TPL_VAR["explodeEmail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                        </select>
                        <p class="txt-error mat10" devTailMsg="devEmailId devEmailHost"></p>
                    </dd>
                </dl>
                <dl class="br__join__list size-info">
                    <dt>참가기념 티셔츠 사이즈<em class="star">*</em></dt>
                    <dd>
                        <select name="size" id="devSize" class="size__select w160" title="사이즈">
                            <option value="">선택</option>
                            <option value="S" <?php if($TPL_VAR["size"]=="S"){?>selected<?php }?>>S</option>
                            <option value="M" <?php if($TPL_VAR["size"]=="M"){?>selected<?php }?>>M</option>
                            <option value="L" <?php if($TPL_VAR["size"]=="L"){?>selected<?php }?>>L</option>
                            <option value="XL" <?php if($TPL_VAR["size"]=="XL"){?>selected<?php }?>>XL</option>
                            <option value="XXL" <?php if($TPL_VAR["size"]=="XXL"){?>selected<?php }?>>XXL</option>
                        </select>
                        <p class="size-info__desc">· 사이즈 교환은 불가하오니 신중하게 선택 부탁드립니다.</p>
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>사전 참가기념품 수령주소<em class="star">*</em></dt>
                    <dd>
                        <div class="join__id">
                            <input class="join__input" type="text"  name="zip" id="devZip" readonly title="Address" value="<?php echo $TPL_VAR["postnum"]?>"/>
                            <button class="join__id__check" type="button" id="devZipPopupButton">Zip code search</button>
                        </div>
                        <input class="join__address" type="text" name="addr1" value="<?php echo $TPL_VAR["address1"]?>" id="devAddress1" readonly/>
                        <input class="join__address" type="text" name="addr2" value="<?php echo $TPL_VAR["address2"]?>" id="devAddress2" title="Detail address"/>
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>사진첨부<em class="star">*</em></dt>
                    <dd class="file-box">
                        <input type="text" class="find-file__name" id="devImageUrl"  name="image_url" title="(english)사진첨부" value="<?php echo $TPL_VAR["image_url"]?>" readonly>
                        <input type="hidden" class="find-file__name" id="devImageUrlPath"  name="image_url_path" title="(english)사진첨부" value="<?php echo $TPL_VAR["image_url_path"]?>">
                        <label class="detail-box__list-file__choose file__label">파일찾기</label>
                        <input class="file__upload" name="image_file" id="devFile" type="file" title="파일찾기" data-url="/controller/event/tmpFileUpload">
                    </dd>
                </dl>
                <div class="desc">
                    <p class="desc__list desc-color">AD카드 발급을 위한 사진 (증명사진과 같이 통상적으로<br>신분 확인이 가능한 얼굴이 명확하게 나온 사진)을<br> 첨부해 주시기바랍니다.</p>
                    <p class="desc__list desc-color">등록하실 이미지파일 이름을 ‘소속명_이름’ 으로 저장하여<br> 첨부해주시기 바랍니다.<br> (예: 배럴팀_홍길동) / 소속명이 없으신 경우 (예:개인_홍길동)</p>
                    <p class="desc__list">파일 형식은 이미지 파일(jpg, jpeg, png)로 제출 가능하며,<br> 파일당 최대 2MB까지 가능합니다.</p>
                </div>
            </div>
        </section>
        <!--[E] 개인 기본 정보 -->
        <!--[S] 대회 참가 정보 -->
        <section class="detail__info br__group-info--detail">
            <div class="br__group-info">
                <h3 class="br__group-info__title">대회 참가 정보</h3>
                <div class="br__group-info__content">
                    <p class="br__group-info__desc"><em class="star">*</em> 표시된 항목은 필수 입력사항 입니다.</p>
                    <dl class="br__join__list br__belong">
                        <dt>
                            소속명<em class="star">*</em>
                        </dt>
                        <dd>
                            <input type="text" class="part-name_input js__joininput__name" name="class_name" id="devClass" value="<?php echo $TPL_VAR["class_name"]?>" title="소속명">
                        </dd>
                        <div class="desc">
                            <p class="desc__list desc-color">소속이 없을 경우, ‘개인’이라고 가입</p>
                            <p class="desc__list">특수기호(!, @, #, $, %, ^, &, (), *등)는 사용이 불가합니다.</p>
                        </div>
                    </dl>
                    <dl class="br__join__list">
                        <dt>참가 그룹<em class="star">*</em></dt>
                        <dd>
                            <select name="attend_group" id="devAttendGroup" class="w200" <?php if(empty($TPL_VAR["attend_group"])){?>disabled<?php }?> title="참가그룹">
                                <option value="">선택</option>
<?php if($TPL_attendGroup_1){foreach($TPL_VAR["attendGroup"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_group"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                            </select>
                        </dd>
                        <p id="devAttendDesc" class="br__belong__desc" style="display:none">91년 01월 01일 ~ 00년 12월 31일</p>

                        <!-- 텍스트 노출 : class "br__belong__noti--show" 추가 -->
                        <p id="devAttendRedDesc" class="br__belong__noti">참가자 기본 정보에서 기입하신 생년월일과 맞지 않는 그룹입니다. </p>
                    </dl>
                    <dl class="br__join__list">
                        <dt>(english)참가종목1<em class="star">*</em><span class="subdesc">(참가 종목은 중복 선택 불가능)</span></dt>
                        <dd>
                            <select name="attend_event1" id="devAttendEvent1" class="w200" title="참가종목1">
                                <option value="">선택</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_event1"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                            </select>
                        </dd>
                    </dl>

                    <dl class="br__join__list">
                        <dt>(english)참가종목2</dt>
                        <dd>
                            <select name="attend_event2" id="devAttendEvent2" class="w200" title="참가종목2">
                                <option value="">선택</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["co_ix"]?>" <?php if($TPL_V1["co_ix"]==$TPL_VAR["attend_event2"]){?> selected <?php }?>><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                            </select>
                        </dd>
                    </dl>
                    <dl class="br__join__list deposit__info__number">
                        <dt>입금계좌</dt>
                        <dd>농협 <span class="desc-color">317-0010-3539-61</span></dd>
                        <dd>예금주: (주)배럴</dd>
                    </dl>
                    <dl class="br__join__list deposit__info__number">
                        <dt>참가비</dt>
                        <dd class="total-deposit">30,000<span>원</span></dd>
                    </dl>
                    <dl class="br__join__list deposit__info__name">
                        <dt>입금자명<em class="star">*</em></dt>
                        <dd>
                            <input type="text" name="depositor" id="devDepositor" class="w200 js__joininput__name" value="<?php echo $TPL_VAR["depositor"]?>" title="입금자명">
                        </dd>
                        <dd class="deposit__info__checkbox">
                            <label>
                                <input type="checkbox" <?php if($TPL_VAR["name"]==$TPL_VAR["depositor"]&&!empty($TPL_VAR["depositor"])){?>checked<?php }?>>
                                <span>선수명과 동일합니다.</span>
                            </label>
                        </dd>
                    </dl>
<?php if($TPL_VAR["type"]!='M'){?>
                    <dl class="br__join__list deposit__info__password">
                        <dt>신청서 비밀번호<em class="star">*</em><span class="subdesc">(숫자 4자리 예:1234)</span></dt>
                        <dd>
                            <input type="password" name="password" id="devPassword" class="w200" maxlength="4" value="<?php echo $TPL_VAR["password"]?>" title="신청서 비밀번호">
                        </dd>
                        <p class="desc__list desc-color">신청서 비밀번호는 신청서 등록 완료 후에 신청서 수정에 필요한 정보이므로 반드시 기억해 주시기 바랍니다.</p>
                    </dl>
<?php }?>
                </div>
            </div>
        </section>
        <!--[E] 대회 참가 정보 -->
        <!--[S] 이용약관 -->
        <div class="br__join__terms">
            <ul>
                <li class="br__find-user__label agree-content">
                    <label>
                        <input type="checkbox" data-name="terms01" name="policyUse" data-title="이용약관" id="devPolicyUse" title="(english)대회 이용약관" <?php if($TPL_VAR["use_yn"]=='Y'){?> checked <?php }?>>
                        <span>(english)대회 이용약관 (필수)</span>
                    </label>
                    <button class="join__all-view term-content" type="button">All</button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label>
                        <input type="checkbox" data-name="terms02" name="policyCollection"  data-title="Collection and utilization of personal information" id="devPolicyCollection"  title="Collection and utilization of personal information" <?php if($TPL_VAR["collection_yn"]=='Y'){?> checked <?php }?>>
                        <span>Privacy Policy (Required)</span>
                    </label>
                    <button class="join__all-view term-content" type="button">All</button>
                </li>
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="email" value="1" <?php if($TPL_VAR["email_yn"]=='Y'){?> checked <?php }?>><span>Receive Email (Optional)</span></label>-->
                <!--</li>-->
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="sms" value="1" <?php if($TPL_VAR["sms_yn"]=='Y'){?> checked <?php }?>><span>Accept SMS reception (optional)</span></label>-->
                <!--</li>-->
            </ul>
            <div class="join__terms-all">
                <label for="all_terms_check"><input type="checkbox" id="all_terms_check" <?php if($TPL_VAR["all_check"]=='Y'){?> checked <?php }?> class="join__terms__agree" name="" data-type=""><span>Agree all</span></label>
            </div>
        </div>
        <!--[E] 이용약관 -->
        <!--[S]버튼-->
        <div class="br__group__btn">
            <button class="group__btn group__btn--apply" id="devBasicSubmitButton">신청</button>
            <button class="group__btn group__btn--reset">초기화</button>
        </div>
    <!--[E]버튼-->
    </section>
</form>
<!-- 이용약관 팝업 -->
<div class="term__popup">
    <p class="term__popup-title">
        <span class="term__popup-name">이용약관</span>
        <span class="close"></span>
    </p>
    <div class="term__popup-content terms01">
        <div style="color:#666;line-height:1.4;white-space:pre-line;">본인 (혹은 본인이 대표자로 참가 신청을 하는 모든 팀원 포함)은 2020년 02월 22일 부터 2020년 02월 23일 까지 인천광역시 문학박태환수영장에서 개최되는 2020배럴스프린트챔피언십에 참가함에 있어, 대회 참가에 따른 제반 사항(경기규칙 및 대회 운영)을 준수할 것이며, 개인의 부주의로 인해 발생할 수 있는 우발적인 사고 및 기타 문제에 대해 본 주최측에 책임이 없으며, 모든 사항을 본인이 책임질 것에 동의합니다.

            또한 본 대회가 진행되는 동안 배럴 브랜드에서는 대회 기록 및 홍보 목적으로 사진 및 영상 촬영을 진행 예정이며, 해당 사진 및 영상 저작물의 활용과 관련하여 대중에게 공개 될 수 있음을 인지하며 이에 동의 합니다.</div>
    </div>
    <div class="term__popup-content terms02">
        <div style="color:#666;line-height:1.4;white-space:pre-line">■ 수집하는 개인정보 항목
            ο 수집하는 개인정보 항목
            성명, 생년월일, 성별, 증명사진, 주소, 연락처(휴대폰), 소속(단체의 경우 팀 내 대표자 성명, 연락처(휴대폰), e-mail, 주소), e-mail 등
            - 서비스 이용과정이나 사업처리 과정에서 아래와 같은 정보들이 자동으로 생성되어 수집될 수 있습니다
            IP Address, 쿠키, 방문 일시, 서비스 이용 기록, 불량 이용 기록

            ο 개인정보 수집방법 : 홈페이지(신청서가입)

            ■ 개인정보의 수집 및 이용목적
            [ 2020 배럴 스프린트 챔피언십 ] 수집한 개인정보를 다음의 목적을 위해 활용합니다.
            ο 본인확인, 선수등록, 대회참가신청에 이용 : 성명, 생년월일, 성별, 국적, 증명사진, 주소, 소속(단체의 경우 팀 내 대표자 성명, 연락처(휴대폰), e-mail, 주소), e-mail 등
            ο 의사소통 및 정보 전달 등에 이용 : 성명, 주소, 연락처(휴대폰), e-mail, 등


            ■ 개인정보의 보유 및 이용기간
            대회 종료 후 1년까지

            정보주체는 개인정보의 수집·이용목적에 대한 동의를 거부할 수 있으며, 동의 거부 시 업무 진행이 불가능할 수 있음을 알려드립니다.</div>
    </div>
<!-- EOD : 이용약관 팝업 -->