<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/profile/profile_basic.htm 000020227 */ 
$TPL_birthYear_1=empty($TPL_VAR["birthYear"])||!is_array($TPL_VAR["birthYear"])?0:count($TPL_VAR["birthYear"]);
$TPL_birthMonth_1=empty($TPL_VAR["birthMonth"])||!is_array($TPL_VAR["birthMonth"])?0:count($TPL_VAR["birthMonth"]);
$TPL_birthDay_1=empty($TPL_VAR["birthDay"])||!is_array($TPL_VAR["birthDay"])?0:count($TPL_VAR["birthDay"]);?>
<div class="fb__mypage profile-detail"> <!--wrap-mypage-->
    <form id="devMemberProfileForm" class="fb__mypage__profile">
        <div class="profile">
            <section>
                <h2 class="fb__mypage__title">Edit Account</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">Name</th>
                        <td>
                            <p class="table-txt" id="devFormatUserName"><?php echo $TPL_VAR["name"]?></p>
                        </td>
                    </tr>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col">ID</th>
                        <td>
                            <p class="table-txt"><?php echo $TPL_VAR["id"]?></p>
                        </td>
                    </tr>
<?php }?>
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                    <tr>
                        <th scope="col"><em>*</em>Password</th>
                        <td>
                            <button type="button" class="btn-default btn-dark change-pw-btn" id="devChangePassword">Change Password</button>
                        </td>
                    </tr>
<?php }?>
                    <tr>
                        <th scope="col"><label for="devEmailId"><em>*</em>Email</label></th>
                        <td style="padding-bottom: 0; vertical-align: top;">
<?php if($TPL_VAR["isSnsJoin"]!=true){?>
                            <span class="pub-email">
                            <input type="text" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일">
                            <span class="hyphen_2">@</span>
                            <input type="text" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                            </span>
                            <select id="devEmailHostSelect" style="width:160px; margin-left:10px; vertical-align: middle;">
                                <option value="direct">Direct input.</option>
                                <option value="naver.com" <?php if($TPL_VAR["mail"][ 1]=="naver.com"){?>selected<?php }?>>naver.com</option>
                                <option value="gmail.com" <?php if($TPL_VAR["mail"][ 1]=="gmail.com"){?>selected<?php }?>>gmail.com</option>
                                <option value="hotmail.com" <?php if($TPL_VAR["mail"][ 1]=="hotmail.com"){?>selected<?php }?>>hotmail.com</option>
                                <option value="hanmail.net" <?php if($TPL_VAR["mail"][ 1]=="hanmail.net"){?>selected<?php }?>>hanmail.net</option>
                                <option value="daum.net" <?php if($TPL_VAR["mail"][ 1]=="daum.net"){?>selected<?php }?>>daum.net</option>
                                <option value="nate.com" <?php if($TPL_VAR["mail"][ 1]=="nate.com"){?>selected<?php }?>>nate.com</option>
                            </select>

                            <button type="button" class="btn-default btn-dark" id="devEmailDoubleCheckButton" style="vertical-align: middle;">Duplicate check</button>
                            <p class="txt-error" devTailMsg="devEmailId devEmailHost"></p>
<?php }else{?>
                            <span class="pub-email">
                                <span style="width:160px;"><?php echo $TPL_VAR["mail"][ 0]?></span>
                                <input type="hidden" name="emailId" value="<?php echo $TPL_VAR["mail"][ 0]?>" id="devEmailId" style="width:160px;" title="이메일" >
                            <span class="hyphen_2">@</span>
                                <span style="width:160px;"><?php echo $TPL_VAR["mail"][ 1]?></span>
                                <input type="hidden" name="emailHost" value="<?php echo $TPL_VAR["mail"][ 1]?>" id="devEmailHost" style="width:160px;" title="이메일">
                            </span>
<?php }?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em>*</em>Tel</th>
                        <td>
                            <div class="selectWrap">
                                <select name="pcs1"  id="devPcs1">
                                <option value="010" <?php if($TPL_VAR["pcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["pcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["pcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["pcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["pcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["pcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs"][ 1]?>" title="휴대폰번호">
                                <span class="hyphen">-</span>
                                <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs"][ 2]?>" title="휴대폰번호">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Address</th>
                        <td>
                            <div class="form-info-wrap" style="width:500px">
                                <input type="text" class="" name="zip" value="<?php echo $TPL_VAR["zip"]?>" id="devZip" style="width:140px;" readonly>
                                <button type="button" style="margin-left: 10px; vertical-align: middle" class="btn-default btn-dark" id="devZipPopupButton">Zip code search</button>
                                <input type="text" class=" mat10" name="addr1" value="<?php echo $TPL_VAR["addr1"]?>" id="devAddress1" style="width:500px;" readonly>
                                <input type="text" class="mat10" style="width:500px;" name="addr2" value="<?php echo $TPL_VAR["addr2"]?>"id="devAddress2" title="Detail address">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>
            <section class="fb__mypage__section fb__mypage__addsection">
                <h2 class="fb__mypage__title">Optional</h2>
                <table class="profile__table join-table">
                    <colgroup>
                        <col width="210px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="col" class="ver-m">Gender</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="gender" value="M" <?php if($TPL_VAR["sex_div"]=='M'){?> checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Male</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="gender" value="W" <?php if($TPL_VAR["sex_div"]!='M'){?> checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Female</span>
                                            </label>
                                        </li>
                                    </ul>

                                </div>
                            </td>
                        </tr>
<?php if(empty($TPL_VAR["birthdayArr"])){?>
                        <tr class="fb__mypage__addsection--birth">
                            <th scope="col" class="ver-m">Birth</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="birthdayDiv" value="1" checked>
                                                <span>solar calendar</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="birthdayDiv" value="0">
                                                <span>lunar calendar</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="inputs--birthday">
                                        <select name="birthYear">
                                            <option value="">생년</option>
<?php if($TPL_birthYear_1){foreach($TPL_VAR["birthYear"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 0]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">Year</span>
                                        <select name="birthMonth">
                                            <option value="">생월</option>
<?php if($TPL_birthMonth_1){foreach($TPL_VAR["birthMonth"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 1]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">Month</span>

                                        <select name="birthDay">
                                            <option value="">생일</option>
<?php if($TPL_birthDay_1){foreach($TPL_VAR["birthDay"] as $TPL_V1){?>
                                            <option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["birthdayArr"][ 2]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
                                        </select>
                                        <span class="selecttext">day</span>
                                    </div>
                                    <p class="birthday__coupon-info">
                                        We present birthday counpon by membership tier. </br>Unable to change after inputting the first 1 year of birth.
                                    </p>
                                </div>
                            </td>
                        </tr>
<?php }else{?>
                        <tr class="fb__mypage__addsection--birth">
                            <th scope="col" class="ver-m">Birth</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <div class="inputs--birthday">
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 0]?>" readonly />
                                        <span class="selecttext">Year</span>
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 1]?>" readonly />
                                        <span class="selecttext">Month</span>
                                        <input type="text" class="" value="<?php echo $TPL_VAR["birthdayArr"][ 2]?>" readonly />
                                        <span class="selecttext">day</span>
                                    </div>
                                    <p class="birthday__coupon-info">
                                        We present birthday counpon by membership tier. </br>Unable to change after inputting the first 1 year of birth.
                                    </p>
                                </div>
                            </td>
                        </tr>
<?php }?>
                        <tr>
                            <th scope="col" class="ver-m">Region</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <div class="area">
                                        <select name="area">
                                            <option value="">Select</option>
                                            <option value="10" <?php if($TPL_VAR["area"]=='10'){?> selected <?php }?> >Seoul</option>
                                            <option value="20" <?php if($TPL_VAR["area"]=='20'){?> selected <?php }?> >Gyeonggi</option>
                                            <option value="21" <?php if($TPL_VAR["area"]=='21'){?> selected <?php }?> >Incheon</option>
                                            <option value="30" <?php if($TPL_VAR["area"]=='30'){?> selected <?php }?> >Gangwon</option>
                                            <option value="41" <?php if($TPL_VAR["area"]=='41'){?> selected <?php }?> >Chungcheongnam-do</option>
                                            <option value="42" <?php if($TPL_VAR["area"]=='42'){?> selected <?php }?> >Daejeon</option>
                                            <option value="43" <?php if($TPL_VAR["area"]=='43'){?> selected <?php }?> >Sejong</option>
                                            <option value="45" <?php if($TPL_VAR["area"]=='45'){?> selected <?php }?> >Chungcheongbuk-do</option>
                                            <option value="51" <?php if($TPL_VAR["area"]=='51'){?> selected <?php }?> >Jeollanam-do</option>
                                            <option value="52" <?php if($TPL_VAR["area"]=='52'){?> selected <?php }?> >Gwangju</option>
                                            <option value="55" <?php if($TPL_VAR["area"]=='55'){?> selected <?php }?> >Jeollabuk-do</option>
                                            <option value="61" <?php if($TPL_VAR["area"]=='61'){?> selected <?php }?> >Gyeongsangnam-do</option>
                                            <option value="62" <?php if($TPL_VAR["area"]=='62'){?> selected <?php }?> >Busan</option>
                                            <option value="63" <?php if($TPL_VAR["area"]=='63'){?> selected <?php }?> >Ulsan</option>
                                            <option value="65" <?php if($TPL_VAR["area"]=='65'){?> selected <?php }?> >Gyeongsangbuk-do</option>
                                            <option value="66" <?php if($TPL_VAR["area"]=='66'){?> selected <?php }?> >Daegu</option>
                                            <option value="70" <?php if($TPL_VAR["area"]=='70'){?> selected <?php }?> >Jeju Island</option>
                                            <option value="90" <?php if($TPL_VAR["area"]=='90'){?> selected <?php }?> >ETC</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="ver-m"><em>*</em>Recieve SMS</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="sms" value="1" <?php if($TPL_VAR["sms"]=='1'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Agree</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="sms" value="0" <?php if($TPL_VAR["sms"]=='0'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Disagree</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="ver-m"><em>*</em>Recieve Email</th>
                            <td>
                                <div class="wrap-terms fb__mypage__agreement">
                                    <ul class="fb__mypage__addsection__gap">
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="info" value="1" <?php if($TPL_VAR["info"]=='1'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Agree</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="select-box__layer__label">
                                                <input type="radio" class="devSortTab" name="info" value="0" <?php if($TPL_VAR["info"]=='0'){?>checked<?php }?>>
                                                <span style="margin-left:6px; vertical-align: middle;">Disagree</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <div class="profile__btn">
                <button type="button" class="profile__btn--cancel" id="devProfileModifyCancel" >Cancel</button>
                <button class="profile__btn--save" >Save</button>
                <a class="profile__btn--secede" href="/mypage/secede">회원탈퇴</a>
            </div>
        </div>
    </form>
</div>