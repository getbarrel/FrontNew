<?php /* Template_ 2.2.8 2024/03/13 16:07:15 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/brand/application_form_indivisual/application_form_indivisual.htm 000021449 */ 
$TPL_attendGroup_1=empty($TPL_VAR["attendGroup"])||!is_array($TPL_VAR["attendGroup"])?0:count($TPL_VAR["attendGroup"]);
$TPL_attendEvent_1=empty($TPL_VAR["attendEvent"])||!is_array($TPL_VAR["attendEvent"])?0:count($TPL_VAR["attendEvent"]);?>
<script src="/assets/templet/enterprise/js/brand/jquery.ui.widget.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.iframe-transport.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.fileupload.js"></script>
<section class="br__join br__group">
    <div class="group__header">
        <h2 class="group__header__title"><?php echo $TPL_VAR["year"]?> 배럴 스프린트 챔피언십<br>온라인 참가 신청서</h2>
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
                    <dt class="join-symbol">성별<em class="star">*</em></dt>
                    <dd class="br__find-user__label">
                        <label><input type="radio" name="sex" value="M" <?php if($TPL_VAR["sex"]=='M'||$TPL_VAR["sex"]==''){?>checked<?php }?>><span>남성</span></label>
                        <label><input type="radio" name="sex" value="F" <?php if($TPL_VAR["sex"]=='F'){?>checked<?php }?>><span>여성</span></label>
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
                            <span class="join__phone-hyphen"></span><!-- join__input -->
                            <input class="join__phone-second" type="text" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰" maxlength="4"/>
                            <span class="join__phone-hyphen"></span><!-- join__input -->
                            <input class="join__phone-third" type="text" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰" maxlength="4"/>
                        </div>
                    </dd>
                </dl>
                <dl class="br__join__list">
                    <dt>이메일 주소<em class="star">*</em></dt>
                    <dd>
                        <div class="join__eamil"><!-- join__input -->
                            <input class="email-id" type="text" name="emailId" id="devEmailId" value="<?php echo $TPL_VAR["explodeEmail"][ 0]?>" title="이메일"/>
                            <span>@</span><!-- join__input -->
                            <input class="email-info" type="text" name="emailHost" id="devEmailHost" value="<?php echo $TPL_VAR["explodeEmail"][ 1]?>" title="이메일"/>
                        </div>
                        <select id="devEmailHostSelect">
                            <option value="">직접입력</option>
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
                <!--dl class="br__join__list">
                    <dt>사전 참가기념품 수령주소<em class="star">*</em></dt>
                    <dd>
                        <div class="join__id">
                            <input class="join__input" type="text"  name="zip" id="devZip" readonly title="주소" value="<?php echo $TPL_VAR["postnum"]?>"/>
                            <button class="join__id__check" type="button" id="devZipPopupButton">우편번호 검색</button>
                        </div>
                        <input class="join__address" type="text" name="addr1" value="<?php echo $TPL_VAR["address1"]?>" id="devAddress1" readonly/>
                        <input class="join__address" type="text" name="addr2" value="<?php echo $TPL_VAR["address2"]?>" id="devAddress2" title="상세주소"/>
                    </dd>
                </dl-->
                <dl class="br__join__list">
                    <dt>사진첨부<em class="star">*</em></dt>
                    <dd class="file-box">
                        <input type="text" class="find-file__name" id="devImageUrl"  name="image_url" title="사진첨부" value="<?php echo $TPL_VAR["image_url"]?>" readonly>
                        <input type="hidden" class="find-file__name" id="devImageUrlPath"  name="image_url_path" title="사진첨부" value="<?php echo $TPL_VAR["image_url_path"]?>">
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
                        <dt>참가종목1<em class="star">*</em><span class="subdesc">(참가 종목은 중복 선택 불가능)</span></dt>
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
                        <dt>참가종목2</dt>
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
                        <dd>신한 <span class="desc-color">140-010-165862</span></dd>
                        <dd>예금주: (주)배럴</dd>
                    </dl>
                    <dl class="br__join__list deposit__info__number">
                        <dt>참가비</dt>
                        <dd class="total-deposit">40,000<span>원</span></dd>
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
                        <input type="checkbox" data-name="terms01" name="policyUse" data-title="이용약관" id="devPolicyUse" title="대회 이용약관" <?php if($TPL_VAR["use_yn"]=='Y'){?> checked <?php }?>>
                        <span>대회 이용약관 (필수)</span>
                    </label>
                    <button class="join__all-view term-content" type="button">전체보기</button>
                </li>
                <li class="br__find-user__label agree-content">
                    <label>
                        <input type="checkbox" data-name="terms02" name="policyCollection"  data-title="개인정보 수집 및 이용" id="devPolicyCollection"  title="개인정보 수집 및 이용" <?php if($TPL_VAR["collection_yn"]=='Y'){?> checked <?php }?>>
                        <span>개인정보 수집 및 이용 (필수)</span>
                    </label>
                    <button class="join__all-view term-content" type="button">전체보기</button>
                </li>
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="email" value="1" <?php if($TPL_VAR["email_yn"]=='Y'){?> checked <?php }?>><span>이메일 수신동의 (선택)</span></label>-->
                <!--</li>-->
                <!--<li class="br__find-user__label agree-content">-->
                    <!--<label><input type="checkbox" name="sms" value="1" <?php if($TPL_VAR["sms_yn"]=='Y'){?> checked <?php }?>><span>SMS 수신동의 (선택)</span></label>-->
                <!--</li>-->
            </ul>
            <div class="join__terms-all">
                <label for="all_terms_check"><input type="checkbox" id="all_terms_check" <?php if($TPL_VAR["all_check"]=='Y'){?> checked <?php }?> class="join__terms__agree" name="" data-type=""><span>전체동의</span></label>
            </div>
        </div>
        <!--[E] 이용약관 -->
        <!--[S]버튼-->
        <div class="br__group__btn">
<?php if($TPL_VAR["chkButton"]=='T'){?>
            <button type="button" class="group__btn group__btn--apply" id="devBasicSubmitButton">신청</button>
<?php }else{?>
            <button type="button" class="group__btn group__btn--apply" onclick="noSubmit('<?php echo $TPL_VAR["year"]?>','<?php echo $TPL_VAR["sdate"]?>');">신청</button>
<?php }?>
            <button type="button" class="group__btn group__btn--reset">초기화</button>
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
        <div style="color:#666;line-height:1.4;white-space:pre-line;">본인은 2024년 5월 25일부터 5월 26일 동안 인천 문학 박태환 수영장에서 개최되는 [ 2024 배럴 스프린트 챔피언십 ]에 참가함에 있어, 대회 참가에 따른 제반 사항 (경기 규칙 및 대회 운영안) 을 준수함에 동의합니다.
 
개인의 부주의로 인해 발생할 수 있는 우발적인 사고 및 기타 문제에 대해서는 주최 측에 책임이 없으며, 모든 사항을 본인 책임질 것에 동의합니다.
 
대회가 진행되는 동안 주최 측에서 대회 기록 및 홍보를 목적으로 사진 및 영상 촬영이 진행되며, 해당 저작물의 활용과 불특정 대중에게 공개될 수 있음을 인지하며 이에 동의합니다.
</div>
    </div>
    <div class="term__popup-content terms02">
        <div style="color:#666;line-height:1.4;white-space:pre-line">■ 개인정보 수집 항목
- 성명, 생년월일, 성별, 증명사진, 연락처, 주소, 이메일, 소속팀
- 단체 신청 시, 팀 대표자의 개인 정보 항목이 추가로 수집될 수 있음
 
■ 개인정보 수집 방법
- 홈페이지 (신청서 기재)
 
■ 개인정보 수집 및 이용 목적
- [ 2024 배럴 스프린트 챔피언십 ] 대회 참가를 위한 본인 확인, 선수 등록에 활용
- 대회 정보 전달을 위한 소통 창구로 활용
 
■ 개인정보 보유 및 이용 기간
- 대회 종료 후 1년
 
서비스 이용 과정이나, 사업 처리 과정에서 아래 정보들이 자동으로 생성 및 수집될 수 있는 점 사전 안내드립니다. (IP주소, 쿠키, 방문 일시, 서비스 이용 기록, 불량 이용 기록)
 
정보 주체는 [ 개인정보 수집 및 이용에 대한 동의 ]를 거부할 수 있으며, 거부 시 대회 참가 신청이 불가함을 알려 드립니다.
</div>
    </div>
<!-- EOD : 이용약관 팝업 -->