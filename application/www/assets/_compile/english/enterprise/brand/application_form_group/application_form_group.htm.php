<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/brand/application_form_group/application_form_group.htm 000044541 */ 
$TPL_attend_1=empty($TPL_VAR["attend"])||!is_array($TPL_VAR["attend"])?0:count($TPL_VAR["attend"]);
$TPL_member_1=empty($TPL_VAR["member"])||!is_array($TPL_VAR["member"])?0:count($TPL_VAR["member"]);
$TPL_attendGroup_1=empty($TPL_VAR["attendGroup"])||!is_array($TPL_VAR["attendGroup"])?0:count($TPL_VAR["attendGroup"]);
$TPL_attendEvent_1=empty($TPL_VAR["attendEvent"])||!is_array($TPL_VAR["attendEvent"])?0:count($TPL_VAR["attendEvent"]);?>
<script src="/assets/templet/enterprise/js/brand/jquery.ui.widget.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.iframe-transport.js"></script>
<script src="/assets/templet/enterprise/js/brand/jquery.fileupload.js"></script>
<section class="fb__content">
    <div class="fb__application-form fb__application-form--team">
        <div class="fb__application-form__head">
            <h2 class="fb__application-form__title">
                2020 배럴 스프린트 챔피언십<br>
                온라인 참가 신청서<br>
                <strong>[단체]</strong>
            </h2>
            <p class="fb__application-form__desc">(english)본 신청서는 단체 참가 신청서입니다. 필수 기입사항을 정확하게 기입해 주시기 바랍니다.</p>
        </div>

        <form id="devBasicForm" enctype="multipart/form-data" method="post" autocomplete="off">
            <input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>"/>
            <input type="hidden" name="gp_ix" value="<?php echo $TPL_VAR["gp_ix"]?>"/>
            <input type="hidden" name="group_attend" id="groupAttend" value="<?php echo implode(',',$TPL_VAR["attend_event"])?>"/>
            <input type="hidden" name="email" value="Y" />
            <input type="hidden" name="sms" value="Y" />
            <div class="fb__join-input__form fb__application-form__content">
                <section class="input-form form-box">
                    <div class="form-box__head">
                        <h3 class="input-form__title-box__text form-box__title">팀 기본 정보</h3>
                        <span class="input-form__title-box__guide form-box__guide"><em class="star">*</em>표시된 항목은 필수 입력사항 입니다.</span>
                    </div>

                    <ul class="input-form__content-box">
                        <li class="inputs">
                            <span class="inputs__title"><label for="devAttendDiv">참가구분</label></span>
                            <div class="inputs__content">
                                <input type="hidden" name="attend_div" id="devAttendDiv" value="2">
                                <p class="inputs__content__text" id="">단체</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">단체명 <em class="star">*</em></span>
                            <div class="inputs__content team-name">
                                <input type="text" name="groupName" id="devGroupName" title="단체명" class="w362 input__user-name" value="<?php echo $TPL_VAR["group_name"]?>">
                                <p class="inputs__desc">· 특수기호(!, @, #, $, %, ^, &, (), * 등)는 사용이 불가합니다.</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">감독자(대표자) <em class="star">*</em></span>
                            <div class="inputs__content">
                                <input type="text" name="groupMaster" id="devGroupMaster" title="감독자(대표자)" class="w236 input__user-name" value="<?php echo $TPL_VAR["group_master"]?>">
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">감독자 핸드폰 번호 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <div class="selectWrap phone-number">
                                    <select name="mpcs1"  id="devMasterPcs1" class="w110" title="감독자 핸드폰 번호">
                                        <option value="010" <?php if($TPL_VAR["explodeMPcs"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["explodeMPcs"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["explodeMPcs"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["explodeMPcs"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["explodeMPcs"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["explodeMPcs"][ 0]=="019"){?>selcted<?php }?>>019</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="mpcs2" id="devMasterPcs2" value="<?php echo $TPL_VAR["explodeMPcs"][ 1]?>" title="감독자 휴대폰번호" class="w110">
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="mpcs3" id="devMasterPcs3" value="<?php echo $TPL_VAR["explodeMPcs"][ 2]?>" title="감독자 휴대폰번호" class="w110">
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title"><label for="devMEmailId">감독자 이메일 주소 <em class="star">*</em></label></span>
                            <div class="inputs__content">
                                <div class="email">
                                    <input type="text" name="emailMId" id="devMEmailId" class="w160" value="<?php echo $TPL_VAR["explodeMEmail"][ 0]?>"  title="감독자 이메일">
                                    <span class="input-between">@</span>
                                    <input type="text" name="emailMHost" id="devMEmailHost" value="<?php echo $TPL_VAR["explodeMEmail"][ 1]?>" class="w190" title="감독자 이메일">
                                </div>
                                <select id="devEmailHostSelect" class="email__select w190">
                                    <option value="">직접입력</option>
                                    <option value="naver.com" <?php if($TPL_VAR["explodeMEmail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                    <option value="gmail.com" <?php if($TPL_VAR["explodeMEmail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                    <option value="hotmail.com" <?php if($TPL_VAR["explodeMEmail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                    <option value="hanmail.net" <?php if($TPL_VAR["explodeMEmail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                    <option value="daum.net" <?php if($TPL_VAR["explodeMEmail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                    <option value="nate.com" <?php if($TPL_VAR["explodeMEmail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                                </select>
                                <p class="inputs__content__boxes-error" devTailMsg="devEmailId devEmailHost"></p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">사전 참가기념품<br> 일괄수령 주소 <em class="star">*</em></span>
                            <div class="inputs__content">
                                <div class="form-info-wrap info__address">
                                    <input type="text" class="w160" name="zip" id="devZip" class="inputs__content--zip" value="<?php echo $TPL_VAR["postnum"]?>" readonly title="Zip code search">
                                    <button type="button" class="btn-dark inputs__content--zip-search" id="devZipPopupButton">Zip code search</button>
                                    <input type="text" class=" info__address__input w362" name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>" readonly>
                                    <input type="text" class="info__address__input w362" id="devAddress2" name="addr2" title="Detail address" value="<?php echo $TPL_VAR["address2"]?>">
                                </div>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">감독자 사진첨부 <em class="star">*</em></span>
                            <div class="inputs__content info__pic">
                                <div class="form-info-wrap file-box">
                                    <input type="text" id="devMasterFileUrl" class="info__pic__input w362" name="group_master_image_url" title="(english)사진첨부" value="<?php echo $TPL_VAR["group_master_image_url"]?>" >
                                    <input type="hidden" class="find-file__name" id="devMasterImageUrlPath" name="group_master_image_url_path" title="(english)사진첨부" value="<?php echo $TPL_VAR["group_master_image_url_path"]?>">
                                    <label class="detail-box__list-file__choose file__label">파일찾기</label>
                                    <input class="btn-dark" name="group_master_image_file" id="devMasterFile" type="file" title="파일찾기" data-url="/controller/event/tmpFileUpload">
<?php if($TPL_VAR["group_master_image_path"]){?>
                                    <img src="<?php echo $TPL_VAR["group_master_image_path"]?>"/>
<?php }?>
                                </div>
                                <p class="inputs__desc">
                                    <span class="inputs__desc--blue">
                                    · AD카드 발급을 위한 사진(증명사진과 같이 통상적으로 신분 확인이 가능한 얼굴이 명확하게 나온 사진)을  첨부해주시기 바랍니다.<br>
                                    · 등록하실 이미지파일 이름을 ‘소속명_감독자_이름’ 으로 저장하여 첨부해주시기 바랍니다. (예: 배럴팀_감독자_홍길동)<br>
                                    · 감독자용 AD카드를 제작하여 드립니다. 단, 경기에 참가하지 않는 감독자는 참가기념품키트를 제공드리지 않습니다.<br>
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
                            <span class="inputs__title">(english)단체전 참가여부<br>(중복선택 가능)</span>
                            <div class="inputs__content team-check">
<?php if($TPL_attend_1){foreach($TPL_VAR["attend"] as $TPL_V1){?>
                                <label for="part<?php echo $TPL_V1["co_ix"]?>">
                                    <input type="checkbox" name="attend[]" class="attendCheckbox" id="part<?php echo $TPL_V1["co_ix"]?>" value="<?php echo $TPL_V1["co_ix"]?>" <?php if(in_array($TPL_V1["co_ix"],$TPL_VAR["attend_event"])){?>checked<?php }?>>
                                    <span class="txt"><?php echo $TPL_V1["option_value"]?></span>
                                </label>
<?php }}?>
                                <p class="inputs__desc">· 실제 단체전에 참가하는 선수 명단은 대회 당일 현장에 비치 된 신청서에 기입하여 제출하시면 됩니다.</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)선수 인원수</span>
                            <div class="inputs__content team-number">
                                <input type="number" name="memberCnt" id="devMemberCnt" class="w110 input__user-number team-number__input" data-max="50" value="<?php echo $TPL_VAR["member_cnt"]?>" <?php if($TPL_VAR["type"]=='M'){?> readonly<?php }?>><!-- data-max : 최대 인원수 지정 -->
                                <span class="num-txt">명</span>
                                <p class="inputs__desc">
                                    · 인원수를 입력하시면 명단을 입력하실 수 있습니다.<br>
                                    <span class="inputs__desc--blue">
                                    · 1팀 당 구성 인원은 최대 50명입니다. (S그룹 참가자 포함)<br>
                                    · 경기에 참가하는 감독자는 반드시 정보 기입 바랍니다.
                                    </span>
                                </p>
                            </div>
                        </li>
                    </ul>
<?php if($TPL_VAR["type"]=='I'){?>
                        <div class="entry-form">
                            <!--입력하는 인원수에 따라 추가되는 폼영역-->
                            <div class="entry-form__list"></div>
                            <!--//입력하는 인원수에 따라 추가되는 폼영역-->
                            <a class="btn-add devAdd">선수 추가하기</a>
                        </div>
<?php }else{?>
<?php if($TPL_VAR["member_cnt"]> 0){?>
                        <div class="entry-form entry-form--show">
                            <div class="entry-form__list">
<?php if($TPL_member_1){$TPL_I1=-1;foreach($TPL_VAR["member"] as $TPL_V1){$TPL_I1++;?>
                            <div id="member<?php echo $TPL_V1["cm_ix"]?>" class="entry-form__sheet">
                                <input type="hidden" name="cm_ix[]" value="<?php echo $TPL_V1["cm_ix"]?>" />
                                <ul class="inner">

                                    <li class="inputs">
                                        <span class="inputs__title">이름(실명) <em class="star">*</em></span>
                                        <div class="inputs__content">
                                            <input type="text" name="name[]" class="input__user-name w110" value="<?php echo $TPL_V1["name"]?>">
                                        </div>
                                    </li>
                                    <li class="inputs ml40">
                                        <span class="inputs__title"><label>Gender</label> <em class="star">*</em></span>
                                        <div class="inputs__content inputs__content--sex">
                                            <label class="inputs__label"><input type="radio" title="성별" name="sex[<?php echo $TPL_I1?>]" value="M" <?php if($TPL_V1["sex"]=='M'||$TPL_V1["sex"]==''){?>checked<?php }?>><span style="vertical-align: middle">male</span></label>
                                            <label class="inputs__label"><input type="radio" title="성별" name="sex[<?php echo $TPL_I1?>]" value="F" <?php if($TPL_V1["sex"]=='F'){?>checked<?php }?>><span style="vertical-align: middle">female</span></label>
                                        </div>
                                    </li>
                                    <li class="inputs ml40">
                                                <span class="inputs__title">
                                                    생년월일 <em class="star">*</em>
                                                    <span class="inputs__desc">(예 : 830724)</span>
                                                </span>
                                        <div class="inputs__content">
                                            <input type="number" name="birthday[]" class="input__user-birth w110 devBirthday" value="<?php echo $TPL_V1["birthday"]?>" maxlength="6">
                                        </div>
                                    </li>
                                    <li class="inputs ml40">
                                        <span class="inputs__title">휴대폰번호 <em class="star">*</em></span>
                                        <div class="inputs__content">
                                            <div class="selectWrap phone-number">
                                                <select name="pcs1[]"  class="w110">
                                                    <option value="010" <?php if($TPL_V1["explodePcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                                    <option value="011" <?php if($TPL_V1["explodePcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                                    <option value="016" <?php if($TPL_V1["explodePcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                                    <option value="017" <?php if($TPL_V1["explodePcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                                    <option value="018" <?php if($TPL_V1["explodePcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                                    <option value="019" <?php if($TPL_V1["explodePcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                                                </select>
                                                <span class="hyphen">-</span>
                                                <input type="number" name="pcs2[]"  value="<?php echo $TPL_V1["explodePcs"][ 1]?>" title="휴대폰번호" class="w110" maxlength="4">
                                                <span class="hyphen">-</span>
                                                <input type="number"  name="pcs3[]" value="<?php echo $TPL_V1["explodePcs"][ 2]?>" title="휴대폰번호" class="w110" maxlength="4">
                                            </div>
                                        </div>
                                    </li>
                                    <!-- 191218 기획수정 - 선수입력폼 이메일 삭제
                                    <li class="inputs mt30">
                                        <span class="inputs__title"><label>이메일 주소 <em class="star">*</em></label></span>
                                        <div class="inputs__content">
                                            <div class="email">
                                                <input type="text" name="emailId[]" class="w140" title="이메일" value="<?php echo $TPL_V1["explodeEmail"][ 0]?>">
                                                <span class="input-between">@</span>

                                                <input type="text" name="emailHost[]" class="email__direct w140"   title="이메일" value="<?php echo $TPL_V1["explodeEmail"][ 1]?>">

                                                <select class="email__select w140">
                                                    <option value="">직접입력</option>
                                                    <option value="naver.com" <?php if($TPL_V1["explodeEmail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                                    <option value="gmail.com" <?php if($TPL_V1["explodeEmail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                                    <option value="hotmail.com" <?php if($TPL_V1["explodeEmail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                                    <option value="hanmail.net" <?php if($TPL_V1["explodeEmail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                                    <option value="daum.net" <?php if($TPL_V1["explodeEmail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                                    <option value="nate.com" <?php if($TPL_V1["explodeEmail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                                                </select>
                                            </div>
                                            <p class="inputs__content__boxes-error" devTailMsg="devEmailId devEmailHost"></p>
                                        </div>
                                    </li>
                                    -->
                                    <li class="inputs mt30 clear">
                                        <span class="inputs__title">그룹<em class="star">*</em></span>
                                        <div class="inputs__content">
                                            <select name="attend_group[]" class="w190 devAttendGroup devRequire" title="참가그룹">
                                            <option value="">선택해주세요</option>
<?php if(is_array($TPL_R2=($TPL_VAR["attendGroup"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                            <option value="<?php echo $TPL_V2["co_ix"]?>" <?php if($TPL_V2["co_ix"]==$TPL_V1["attend_group"]){?> selected <?php }?>><?php echo $TPL_V2["option_value"]?></option>
<?php }}?>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="inputs mt30 ml140">
                                        <div class="inputs__innerbox">
                                            <span class="inputs__title">
                                                (english)참가종목1 <em class="star">*</em>
                                                <span class="inputs__desc">(참가종목은 중복 선택 불가능)</span>
                                            </span>
                                            <div class="inputs__content">
                                                <select name="attend_event1[]" class="w200 firstPartEvent  devAttendEvent1">
                                                    <option value="">선택해주세요</option>
<?php if(is_array($TPL_R2=($TPL_VAR["attendEvent"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                                    <option value="<?php echo $TPL_V2["co_ix"]?>" <?php if($TPL_V2["co_ix"]==$TPL_V1["attend_event1"]){?> selected <?php }?>><?php echo $TPL_V2["option_value"]?></option>
<?php }}?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inputs__innerbox">
                                            <span class="inputs__title">
                                                (english)참가종목2
                                                <span class="inputs__desc">(선택사항)</span>
                                            </span>
                                            <div class="inputs__content">
                                                <select name="attend_event2[]" class="w200 secondPartEvent dim">
                                                    <option value="">선택해주세요</option>
<?php if(is_array($TPL_R2=($TPL_VAR["attendEvent"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                                    <option value="<?php echo $TPL_V2["co_ix"]?>" <?php if($TPL_V2["co_ix"]==$TPL_V1["attend_event2"]){?> selected <?php }?> style="<?php if($TPL_V1["attend_event1"]==$TPL_V2["co_ix"]){?>display:none;<?php }?>"><?php echo $TPL_V2["option_value"]?></option>
<?php }}?>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="inputs clear">
                                        <p class="inputs__desc inputs__desc--black devAttendDesc" style="display:none">00년 12월31일~91년01월01일</p>
                                        <p class="inputs__desc inputs__desc--red mt10 devAttendRedDesc" style="display:none">참가자 기본 정보에 기입하신 생년월일과 맞지 않는 그룹입니다.</p>
                                    </li>
                                    <li class="inputs mt30 clear">
                                        <span class="inputs__title">참가기념 티셔츠 사이즈 <em class="star">*</em></span>
                                        <div class="inputs__content">
                                            <select name="size[]" class="size__select w160">
                                                <option value="">선택</option>
                                                <option value="S" <?php if($TPL_V1["size"]=="S"){?> selected <?php }?>>S</option>
                                                <option value="M" <?php if($TPL_V1["size"]=="M"){?> selected <?php }?>>M</option>
                                                <option value="L" <?php if($TPL_V1["size"]=="L"){?> selected <?php }?>>L</option>
                                                <option value="XL" <?php if($TPL_V1["size"]=="XL"){?> selected <?php }?>>XL</option>
                                                <option value="XXL" <?php if($TPL_V1["size"]=="XXL"){?> selected <?php }?>>XXL</option>
                                            </select>
                                            <p class="inputs__desc inputs__desc--blue">· 사이즈 교환은 불가하오니 <br>신중하게 선택 부탁드립니다.</p>
                                        </div>
                                    </li>
                                    <li class="inputs mt30 ml170">
                                        <span class="inputs__title">사진첨부 <em class="star">*</em></span>
                                        <div class="inputs__content info__pic">
                                            <div class="form-info-wrap file-box">
                                                <input type="text" class="info__pic__input w362 find-file__name devFileUrl" name="image_url[]" title="(english)사진첨부" value="<?php echo $TPL_V1["image_url"]?>" readonly>
                                                <input type="hidden" class="find-file__name devImageUrlPath devRequire" name="image_url_path[]" title="(english)사진첨부" value="<?php echo $TPL_V1["image_url_path"]?>">
                                                <label class="detail-box__list-file__choose file__label">파일찾기</label>
                                                <input class="btn-dark file__upload devFile" name="image_file[]" type="file" title="파일찾기" data-url="/controller/event/tmpFileUpload">
                                            </div>
                                            <p class="inputs__desc">
                                                        <span class="inputs__desc--blue">
                                                        · 대회 당일, 본인 인증을 위한 AD카드 발급을 위하여 반드시 본인의 얼굴정면 사진을 첨부해주시기 바랍니다.<br>
                                                        · 등록하실 이미지파일 이름을 ‘소속명_이름’ 으로 저장하여 첨부해주시기 바랍니다. (예: 배럴팀_홍길동)<br>
                                                        </span>
                                                · 파일 형식은 이미지 파일(jpg, jpeg, png)로 제출 가능하며, 파일당 최대 2MB까지 가능합니다.
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            <a class="entry-form__sheet--delete devDelete" data-id="<?php echo $TPL_V1["cm_ix"]?>">삭제</a>
                            </div>
<?php }}?>
<?php }?>
                            </div>
                            <a class="btn-add devAdd">선수 추가하기</a>
                        </div>
<?php }?>

                    <ul class="input-form__content-box input-form__content-box2">
                        <li class="inputs">
                            <span class="inputs__title">(english)입금계좌</span>
                            <div class="inputs__content">
                                <p class="inputs__content__text" >농협  <span class="inputs__desc--blue"> 317-0010-3539-61  </span>    예금주 : (주)배럴</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)참가비</span>
                            <div class="inputs__content part-cost">
                                <p class="inputs__content__text inputs__desc--blue" id="devPrice"><?php echo g_price($TPL_VAR["joinPrice"])?>원</p>
                            </div>
                        </li>
                        <li class="inputs">
                            <span class="inputs__title">(english)입금자명 <em class="star">*</em></span>
                            <div class="inputs__content depositor">
                                <input type="text" name="depositor" id="devDepositor" class="w200 input__user-name" title="입금자명" value="<?php echo $TPL_VAR["depositor"]?>">
                                <p class="inputs__desc"></p>
                            </div>
                        </li>
<?php if($TPL_VAR["type"]!='M'){?>
                        <li class="inputs inputs__password">
                            <span class="inputs__title"><strong>(english)신청서 비밀번호</strong> <em class="star">*</em></span>
                            <div class="inputs__content">
                                <input type="password" name="password" id="devPassword" class="w200" maxlength="4" title="비밀번호" value="<?php echo $TPL_VAR["password"]?>">
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
                            <label class="input-form__title-box__text"><input type="checkbox" class="checkbox-margin" id="all_terms_check" <?php if($TPL_VAR["all_check"]=='Y'){?> checked <?php }?>style="vertical-align: bottom;">Agree all</label>
                        </div>
                    </div>

                    <ul class="input-form__content-box">
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyUse" name="policyUse" data-title="이용약관" title="Terms and Conditions" <?php if($TPL_VAR["use_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">Terms and conditions (Required)</label>
                            <a href="#" class="inputs__content inputs__content--use view-all">All</a>
                        </li>
                        <li class="inputs inputs__agree agree-content">
                            <label><input type="checkbox" id="devPolicyCollection" name="policyCollection"  title="Collection and utilization of personal information" <?php if($TPL_VAR["collection_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">Privacy Policy (Required)</label>
                            <a href="#" class="inputs__content inputs__content--private view-all">All</a>
                        </li>
                        <!--<li class="inputs inputs__agree agree-content">-->
                            <!--<label><input type="checkbox" name="email" value="1" <?php if($TPL_VAR["email_yn"]=='Y'){?> checked <?php }?>  style="vertical-align: text-top;">Receive Email (Optional)</label>-->
                        <!--</li>-->
                        <!--<li class="inputs inputs__agree agree-content">-->
                            <!--<label><input type="checkbox" name="sms" value="1" <?php if($TPL_VAR["sms_yn"]=='Y'){?> checked <?php }?> style="vertical-align: text-top;">Accept SMS reception (optional)</label>-->
                        <!--</li>-->
                    </ul>
                </section>
                <div class="wrap-btn-area member fb__join-member__btn-are fb__application-form__btn">
                    <button type="button" class="btn-lg btn-dark group__btn--reset" id="devCancelButton">Reset</button>
                    <button class="btn-lg btn-point" id="devBasicSubmitButton">Application</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!--선수인원수 입력시 노출 class "entry-form"에 "entry-form--show" 추가-->
<div class="entry-form">
    <!-- 선수정보 템플릿 -->
    <script id="entry-form__template" type="text/template">
        <div class="entry-form__sheet">
            <ul class="inner">
                <li class="inputs">
                    <span class="inputs__title">이름(실명) <em class="star">*</em></span>
                    <div class="inputs__content">
                        <input type="text" name="name[]" class="input__user-name w110 devRequire" title="(english)이름(실명)">
                    </div>
                </li>
                <li class="inputs ml40">
                    <span class="inputs__title">
                        생년월일 <em class="star">*</em>
                        <span class="inputs__desc">(예 : 830724)</span>
                    </span>
                    <div class="inputs__content">
                        <input type="number" name="birthday[]" class="input__user-birth w110 devBirthday devRequire" title="생년월일">
                    </div>
                </li>
                <li class="inputs ml40">
                    <span class="inputs__title"><label>Gender</label> <em class="star">*</em></span>
                    <div class="inputs__content inputs__content--sex">
                        <label class="inputs__label"><input type="radio" title="성별" name="sex[#num#]" value="M" checked><span style="vertical-align: middle">male</span></label>
                        <label class="inputs__label"><input type="radio" title="성별" name="sex[#num#]" value="F"><span style="vertical-align: middle">female</span></label>
                    </div>
                </li>

                <li class="inputs ml40">
                    <span class="inputs__title">핸드폰 번호 <em class="star">*</em></span>
                    <div class="inputs__content">
                        <div class="selectWrap phone-number">
                            <select name="pcs1[]"  class="w110 devPcs1 devRequire" title="핸드폰 번호" >
                                <option value="010">010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input type="number" name="pcs2[]" class="devPcs2 devRequire" value="" title="핸드폰 번호" class="w110">
                            <span class="hyphen">-</span>
                            <input type="number"  name="pcs3[]" class="devPcs3 devRequire" value="" title="핸드폰 번호" class="w110">
                        </div>
                    </div>
                </li>
                <!-- 191218 기획수정 - 선수입력폼 이메일 삭제
                <li class="inputs mt30">
                    <span class="inputs__title"><label>이메일 주소 <em class="star">*</em></label></span>
                    <div class="inputs__content">
                        <div class="email">
                            <input type="text" name="emailId[]" class="w140" title="이메일">
                            <span class="input-between">@</span>

                            <input type="text" name="emailHost[]" class="email__direct w140"   title="이메일">

                            <select class="email__select w140">
                                <option value="byself">직접입력</option>
                                <option value="naver.com">naver.com</option>
                                <option value="gmail.com">gmail.com</option>
                                <option value="hotmail.com">hotmail.com</option>
                                <option value="hanmail.net">hanmail.net</option>
                                <option value="daum.net">daum.net</option>
                                <option value="nate.com">nate.com</option>
                            </select>
                        </div>
                        <p class="inputs__content__boxes-error" devTailMsg="devEmailId devEmailHost"></p>
                    </div>
                </li>
                -->
                <li class="inputs mt30 clear">
                    <span class="inputs__title">참가그룹<em class="star">*</em></span>
                    <div class="inputs__content">
                        <select name="attend_group[]" class="w190 devAttendGroup devRequire" title="참가그룹" <?php if(empty($TPL_VAR["attend_group"])){?>disabled<?php }?>>
                            <option value="">선택해주세요</option>
<?php if($TPL_attendGroup_1){foreach($TPL_VAR["attendGroup"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["co_ix"]?>"><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                        </select>
                    </div>
                </li>
                <li class="inputs mt30 ml140">
                    <div class="inputs__innerbox">
                        <span class="inputs__title">
                            (english)참가종목1 <em class="star">*</em>
                            <span class="inputs__desc">(참가종목은 중복 선택 불가능)</span>
                        </span>
                        <div class="inputs__content">
                            <select name="attend_event1[]" class="w200 firstPartEvent devRequire" title="참가종목1">
                                <option value="">선택해주세요</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["co_ix"]?>"><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="inputs__innerbox">
                        <span class="inputs__title">
                            (english)참가종목2
                            <span class="inputs__desc">(선택사항)</span>
                        </span>
                        <div class="inputs__content">
                            <select name="attend_event2[]" class="w200 secondPartEvent" disabled>
                                <option value="">선택해주세요</option>
<?php if($TPL_attendEvent_1){foreach($TPL_VAR["attendEvent"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["co_ix"]?>"><?php echo $TPL_V1["option_value"]?></option>
<?php }}?>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="inputs clear">
                    <p class="inputs__desc inputs__desc--black devAttendDesc" style="display:none">00년 12월31일~91년01월01일</p>
                    <p class="inputs__desc inputs__desc--red mt10 devAttendRedDesc" style="display:none">참가자 기본 정보에 기입하신 생년월일과 맞지 않는 그룹입니다.</p>
                </li>
                <li class="inputs mt30 clear">
                    <span class="inputs__title">참가기념 티셔츠 사이즈 <em class="star">*</em></span>
                    <div class="inputs__content">
                        <select name="size[]" class="size__select w140 devSize devRequire" title="참가기념 티셔츠 사이즈">
                            <option value="">선택</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                        <p class="inputs__desc inputs__desc--blue">· 사이즈 교환은 불가하오니 <br>신중하게 선택 부탁드립니다.</p>
                    </div>
                </li>
                <li class="inputs mt30 ml170">
                    <span class="inputs__title">사진첨부 <em class="star">*</em></span>
                    <div class="inputs__content info__pic">
                        <div class="form-info-wrap file-box">
                            <input type="text" class="info__pic__input w362 find-file__name devFileUrl devRequire" name="image_url[]" title="(english)사진첨부" readonly>
                            <input type="hidden" class="find-file__name devImageUrlPath devRequire" name="image_url_path[]" title="(english)사진첨부" value="">
                            <label class="detail-box__list-file__choose file__label">파일찾기</label>
                            <input class="btn-dark file__upload devFile" name="image_file[]" type="file"  title="파일찾기" data-url="/controller/event/tmpFileUpload">
                        </div>
                        <p class="inputs__desc">
                            <span class="inputs__desc--blue">
                            · 대회 당일, 본인 인증을 위한 AD카드 발급을 위하여 반드시 본인의 얼굴정면 사진을 첨부해주시기 바랍니다.<br>
                            · 등록하실 이미지파일 이름을 ‘소속명_이름’ 으로 저장하여 첨부해주시기 바랍니다. (예: 배럴팀_홍길동)<br>
                            </span>
                            · 파일 형식은 이미지 파일(jpg, jpeg, png)로 제출 가능하며, 파일당 최대 2MB까지 가능합니다.
                        </p>
                    </div>
                </li>
            </ul>
            <a class="entry-form__sheet--delete devDelete" data-id="">삭제</a>
        </div>
    </script>
    <!-- //선수정보 템플릿 -->
</div>