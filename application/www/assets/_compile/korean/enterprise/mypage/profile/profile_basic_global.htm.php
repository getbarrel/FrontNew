<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/profile/profile_basic_global.htm 000028587 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<td class="fb__mypage profile-detail"> <!--wrap-mypage-->
    <form id="devMemberProfileForm" class="fb__mypage__profile">
        <td class="profile">
            <section>
                <h2 class="fb__mypage__title">개인회원정보 수정</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">이름</th>
                        <td>
                            <p class="table-txt" id="devFormatUserName"><?php echo $TPL_VAR["name"]?></p>
                        </td>
                    </tr>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col">아이디</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["id"]?></p>
                        </td>
                    </tr>
<?php }?>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col"><em>*</em>비밀번호</th>
                        <td>
                            <button type="button" class="btn-default btn-dark change-pw-btn" id="devChangePassword">비밀번호 변경</button>
                        </td>
                    </tr>
<?php }?>
                    <tr>
                        <th scope="col"><label for="devEmailId"><em>*</em>이메일</label></th>
                        <td>
                        <span class="pub-email">
                            <input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                        </span>
                            <!--<select id="devEmailHostSelect" style="width:160px; margin-left:5px;">-->
                                <!--<option value="">직접입력</option>-->
                                <!--<option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>-->
                                <!--<option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>-->
                                <!--<option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>-->
                                <!--<option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>-->
                                <!--<option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>-->
                                <!--<option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>-->
                                <!--<option value="direct" >직접입력</option>-->
                            <!--</select>-->
                            <button type="button" class="btn-default btn-dark" id="devEmailDoubleCheckButton">이메일 중복 확인</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>Country</th>
                        <td>
                            <select class="devNationArea" id="devCountry" name="country" style="min-width:340px;" title="Country">
                                <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>휴대폰 번호</th>
                        <td>
                            <div class="selectWrap">
                                <select class="devNationArea" name="national_phone"  title="Country">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                                </select>
                                <input type="number" name="pcs" id="devPcs" value="<?php echo $TPL_VAR["pcs"]?>" title="휴대폰 번호" >

                            </div>
                        </td>
                    </tr>
                    <!-- @TODO 글로벌 주소 영역 -->
                    <tr>
                        <th scope="col"><em>*</em>Zip/Postal Code</th>
                        <td>
                            <div class="form-info-wrap">
                                <input type="text" class="" name="zip" id="devZip" value="<?php echo $TPL_VAR["zip"]?>" class="inputs__content--zip"  style="width:160px" title="Zip/Postal Code">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>Address line 1</th>
                        <td>
                            <div class="form-info-wrap">
                                <input type="text" class="mat10" style="width:500px;" id="devAddress1" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" title="Address line 1" >
                            </div>
                        </td>
                    </li>
                    </tr>
                    <tr>
                        <th scope="col">Address line 2</th>
                        <td>
                            <div class="form-info-wrap">
                                <input type="text" class="mat10" style="width:500px;" id="devAddress2" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>" title="Address line 2" >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>City</th>
                        <td>
                            <div class="form-info-wrap">
                                <input type="text" class="mat10" style="width:340px" id="devCity"  name="city" value="<?php echo $TPL_VAR["city"]?>" title="City" >
                            </div>
                        </td>
                    </li>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>State/Province</th>
                        <td>
                            <div class="form-info-wrap">
<?php if($TPL_VAR["country"]=='US'){?>
                                <select style="width:340px;" id="devStateSelect">
                                    <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                                </select>
                                <input type="text" class="mat10" style="width:340px; display:none;" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" >
<?php }else{?>
                                <select style="width:340px;display: none;" id="devStateSelect">
                                    <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                                </select>
                                <input type="text" class="mat10" style="width:340px" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" >
<?php }?>
                            </div>
                        </td>
                    </tr>
                    <!--<tr>-->
                        <!--<th scope="col">주소</th>-->
                        <!--<td>-->
                            <!--<div class="form-info-wrap" style="width:500px">-->
                                <!--<input type="text" class="dim" name="zip" value="<?php echo $TPL_VAR["zip"]?>" id="devZip" style="width:140px;" readonly>-->
                                <!--<button type="button" class="btn-default btn-dark" id="devZipPopupButton">주소찾기</button>-->
                                <!--<input type="text" class="dim mat10" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" style="width:500px;" readonly>-->
                                <!--<input type="text" class="mat10" style="width:500px;" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>"id="devAddress2" title="상세주소">-->
                            <!--</div>-->
                        <!--</td>-->
                    <!--</tr>-->
                    <!--
                    <tr>
                        <th scope="col">생년월일</th>
                        <td>
                            <p class="table-txt" id="devFromatBirthday"><?php echo $TPL_VAR["birthday"]?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">성별</th>
                        <td>
                            <p class="table-txt" id="devFormatSexDiv"><?php if($TPL_VAR["sex_div"]=='M'){?>남성<?php }else{?>여성<?php }?></p>
                        </td>
                    </tr>
                    -->

                    <!--
                    <tr>
                        <th scope="col">전화번호</th>
                        <td>
                            <div class="selectWrap">
                                <select name="tel1">
                                    <option value="02" <?php if($TPL_VAR["tel"][ 0]=="02"){?>selected<?php }?>>02</option>
                                    <option value="031" <?php if($TPL_VAR["tel"][ 0]=="031"){?>selected<?php }?>>031</option>
                                    <option value="032" <?php if($TPL_VAR["tel"][ 0]=="032"){?>selected<?php }?>>032</option>
                                    <option value="041" <?php if($TPL_VAR["tel"][ 0]=="041"){?>selected<?php }?>>041</option>
                                    <option value="042" <?php if($TPL_VAR["tel"][ 0]=="042"){?>selected<?php }?>>042</option>
                                    <option value="043" <?php if($TPL_VAR["tel"][ 0]=="043"){?>selected<?php }?>>043</option>
                                    <option value="051" <?php if($TPL_VAR["tel"][ 0]=="051"){?>selected<?php }?>>051</option>
                                    <option value="052" <?php if($TPL_VAR["tel"][ 0]=="052"){?>selected<?php }?>>052</option>
                                    <option value="053" <?php if($TPL_VAR["tel"][ 0]=="053"){?>selected<?php }?>>053</option>
                                    <option value="054" <?php if($TPL_VAR["tel"][ 0]=="054"){?>selected<?php }?>>054</option>
                                    <option value="055" <?php if($TPL_VAR["tel"][ 0]=="055"){?>selected<?php }?>>055</option>
                                    <option value="061" <?php if($TPL_VAR["tel"][ 0]=="061"){?>selected<?php }?>>061</option>
                                    <option value="062" <?php if($TPL_VAR["tel"][ 0]=="062"){?>selected<?php }?>>062</option>
                                    <option value="063" <?php if($TPL_VAR["tel"][ 0]=="063"){?>selected<?php }?>>063</option>
                                    <option value="064" <?php if($TPL_VAR["tel"][ 0]=="064"){?>selected<?php }?>>064</option>
                                    <option value="070" <?php if($TPL_VAR["tel"][ 0]=="070"){?>selected<?php }?>>070</option>
                                    <option value="080" <?php if($TPL_VAR["tel"][ 0]=="080"){?>selected<?php }?>>080</option>
                                    <option value="090" <?php if($TPL_VAR["tel"][ 0]=="090"){?>selected<?php }?>>090</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="text" name="tel2" id="devTel2" value="<?php echo $TPL_VAR["tel"][ 1]?>" title="전화번호 가운데자리입력">
                                <span class="hyphen">-</span>
                                <input type="text" name="tel3" id="devTel3" value="<?php echo $TPL_VAR["tel"][ 2]?>" title="전화번호 끝자리 입력">
                            </div>
                        </td>
                    </tr>
                    -->

                    </tbody>
                </table>
            </section>
            <section class="fb__mypage__section fb__mypage__addsection">
                <h2 class="fb__mypage__title">추가정보</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <!--<tr>-->
                        <!--<th scope="col" class="ver-m">성별</th>-->
                        <!--<td>-->
                            <!--<div class="wrap-terms fb__mypage__agreement">-->
                                <!--<ul class="fb__mypage__addsection__gap">-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="gender" value="M" <?php if($TPL_VAR["sex_div"]=='M'){?> checked<?php }?>>-->
                                            <!--<span>남자</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="gender" value="W" <?php if($TPL_VAR["sex_div"]!='M'){?> checked<?php }?>>-->
                                            <!--<span>여자</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                <!--</ul>-->

                            <!--</div>-->
                        <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<th scope="col" class="ver-m">생일</th>-->
                        <!--<td>-->
                            <!--<div class="wrap-terms fb__mypage__agreement">-->
                                <!--<ul class="fb__mypage__addsection__gap">-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="birthdayDiv" value="1" <?php if($TPL_VAR["birthday_div"]=='1'){?>checked<?php }?> <?php if($TPL_VAR["birthday_div"]){?>disabled<?php }?> >-->
                                            <!--<span>양력</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="birthdayDiv" value="0" <?php if($TPL_VAR["birthday_div"]=='0'){?>checked<?php }?> <?php if($TPL_VAR["birthday_div"]){?>disabled<?php }?> >-->
                                            <!--<span>음력</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                <!--</ul>-->
                                <!--<div class="inputs&#45;&#45;birthday">-->
                                    <!--<select name="birthYear" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                                    <!--<option value="">생년</option>-->
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">년</span>-->
                                    <!--<select name="birthMonth" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                                    <!--<option value="">생월</option>-->
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--</select>-->
                                    <!--<span class="selecttext">월</span>-->

                                    <!--<select name="birthDay" <?php if($TPL_VAR["birthdayArr"]){?>disabled<?php }?>>-->
                                    <!--<option value="">생일</option>-->
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                    <!--<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>-->
<?php }}?>
                                    <!--<span class="selecttext">일</span>-->
                                <!--</div>-->
                                <!--<p>-->
                                    <!--회원등급별 생일할인 쿠폰이 증정됩니다. 생년월일 최초 1회 입력 이후 변경이 불가능합니다.-->
                                <!--</p>-->
<?php if(!$TPL_VAR["birthdayArr"]){?>
                                <!--<p>생년월일 최초 1회 입력 이후 변경이 불가능합니다.</p>-->
<?php }?>
                            <!--</div>-->
                        <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<th scope="col" class="ver-m">지역</th>-->
                        <!--<td>-->
                            <!--<div class="wrap-terms fb__mypage__agreement">-->
                                <!--<div class="area">-->
                                    <!--<select name="area">-->
                                        <!--<option value="">선택</option>-->
                                        <!--<option value="10" <?php if($TPL_VAR["area"]=='10'){?> selected <?php }?> >서울특별시</option>-->
                                        <!--<option value="20" <?php if($TPL_VAR["area"]=='20'){?> selected <?php }?> >경기도</option>-->
                                        <!--<option value="21" <?php if($TPL_VAR["area"]=='21'){?> selected <?php }?> >인천광역시</option>-->
                                        <!--<option value="30" <?php if($TPL_VAR["area"]=='30'){?> selected <?php }?> >강원도</option>-->
                                        <!--<option value="41" <?php if($TPL_VAR["area"]=='41'){?> selected <?php }?> >충청남도</option>-->
                                        <!--<option value="42" <?php if($TPL_VAR["area"]=='42'){?> selected <?php }?> >대전광역시</option>-->
                                        <!--<option value="43" <?php if($TPL_VAR["area"]=='43'){?> selected <?php }?> >세종특별자치시</option>-->
                                        <!--<option value="45" <?php if($TPL_VAR["area"]=='45'){?> selected <?php }?> >충청북도</option>-->
                                        <!--<option value="51" <?php if($TPL_VAR["area"]=='51'){?> selected <?php }?> >전라남도</option>-->
                                        <!--<option value="52" <?php if($TPL_VAR["area"]=='52'){?> selected <?php }?> >광주광역시</option>-->
                                        <!--<option value="55" <?php if($TPL_VAR["area"]=='55'){?> selected <?php }?> >전라북도</option>-->
                                        <!--<option value="61" <?php if($TPL_VAR["area"]=='61'){?> selected <?php }?> >경상남도</option>-->
                                        <!--<option value="62" <?php if($TPL_VAR["area"]=='62'){?> selected <?php }?> >부산광역시</option>-->
                                        <!--<option value="63" <?php if($TPL_VAR["area"]=='63'){?> selected <?php }?> >울산광역시</option>-->
                                        <!--<option value="65" <?php if($TPL_VAR["area"]=='65'){?> selected <?php }?> >경상북도</option>-->
                                        <!--<option value="66" <?php if($TPL_VAR["area"]=='66'){?> selected <?php }?> >대구광역시</option>-->
                                        <!--<option value="70" <?php if($TPL_VAR["area"]=='70'){?> selected <?php }?> >제주특별자치도</option>-->
                                        <!--<option value="90" <?php if($TPL_VAR["area"]=='90'){?> selected <?php }?> >기타</option>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<th scope="col" class="ver-m"><em>*</em>SMS 수신동의<?php echo $TPL_VAR["sms"]?></th>-->
                        <!--<td>-->
                            <!--<div class="wrap-terms fb__mypage__agreement">-->
                                <!--<ul class="fb__mypage__addsection__gap">-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="sms" value="1" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?>>-->
                                            <!--<span>동의함</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                        <!--<label class="select-box__layer__label">-->
                                            <!--<input type="radio" class="devSortTab" name="sms" value="0" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?>>-->
                                            <!--<span>동의안함</span>-->
                                        <!--</label>-->
                                    <!--</li>-->
                                <!--</ul>-->
                            <!--</div>-->
                        <!--</td>-->
                    <!--</tr>-->
                    <tr>
                        <th scope="col" class="ver-m"><em>*</em>메일 수신동의</th>
                        <td>
                            <div class="wrap-terms fb__mypage__agreement">
                                <ul class="fb__mypage__addsection__gap">
                                    <li>
                                        <label class="select-box__layer__label">
                                            <input type="radio" class="devSortTab" name="info" value="1" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>>
                                            <span>동의함</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="select-box__layer__label">
                                            <input type="radio" class="devSortTab" name="info" value="0" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>>
                                            <span>동의안함</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>
            <!--<section class="fb__mypage__section" style="display: none;">-->
            <!--<h2 class="fb__mypage__title">선택 동의 항목</h2>-->
            <!--<table class="profile__table join-table">-->
            <!--<colgroup>-->
            <!--<col width="210px">-->
            <!--<col width="*">-->
            <!--</colgroup>-->
            <!--<tbody>-->
            <!--<tr>-->
            <!--<th scope="col" class="ver-m">마케팅 활용 동의</th>-->
            <!--<td>-->
            <!--<div class="wrap-terms fb__mypage__agreement">-->
            <!--<div class="input-terms">-->
            <?php echo $TPL_VAR["policyData"]['marketing']['contents']?>

            <!--</div>-->
            <!--<div class="wrap-terms-check">-->
            <!--<input type="checkbox" id="devAgreeTerm" name="policy[]" value="<?php echo $TPL_VAR["policyData"]['marketing']['ix']?>" <?php if($TPL_VAR["sms"]=='1'||$TPL_VAR["info"]=='1'){?>checked<?php }?> />-->
            <!--<label for="agree-term5" class="mar10">동의</label>-->
            <!--<span class="fb__mypage__agreement__round-bracket&#45;&#45;left">(</span>-->
            <!--<input type="checkbox" id="devAgreeSms" name="sms" value="1" title="SMS" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?> />-->
            <!--<label for="agree-term6" class="mar10">SMS 수신</label>-->

            <!--<input type="checkbox" id="devAgreeEmail" name="email" value="1" title="E-Mail" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?> />-->
            <!--<label for="agree-term7" class="mar10">이메일 수신</label>-->
            <!--<span class="fb__mypage__agreement__round-bracket">)</span>-->
            <!--</div>-->

            <!--<p class="desc">-->
            <!--· 쇼핑몰에서 제공되는 다양한 이벤트/할인정보/공지사항 등의 내용을 받아 보실 수 있습니다.<br>-->
            <!--· 결제/교환/환불 등의 주문거래 관련 정보는 수신동의 여부와 상관없이 발송됩니다.-->
            <!--</p>-->
            <!--</div>-->
            <!--</td>-->
            <!--</tr>-->
            <!--</tbody>-->
            <!--</table>-->
            <!--</section>-->

            <div class="profile__btn">
                <button type="button" class="profile__btn--cancel" id="devProfileModifyCancel" >취소</button>
                <button class="profile__btn--save" >저장</button>
            </div>
        </div>
    </form>
</div>