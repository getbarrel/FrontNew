<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook_manage/addressbook_manage.htm 000014616 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__mypage br__join br__add-manage">
    <form id="devAddressBookAddForm">
        <input type="hidden" name="tel1" value="" />
        <input type="hidden" name="tel2" value="" />
        <input type="hidden" name="tel3" value="" />
<?php if($TPL_VAR["ix"]){?>
        <input type="hidden" name="ix" value="<?php echo $TPL_VAR["ix"]?>" />
        <input type="hidden" name="mode" value="update" id="devMode" />
<?php }else{?>
        <input type="hidden" name="mode" value="insert" id="devMode" />
<?php }?>
        <div class="br__mypage__pass">
            <p class="pass-title"><?php if($TPL_VAR["ix"]){?>Address correction<?php }else{?>Add shipping address <?php }?></p>
        </div>

        <!-- 주소별칭 -->
        <dl class="br__join__list">
            <dt>Address Nickname <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" name="shipping_name" value="<?php echo $TPL_VAR["shipping_name"]?>" id="devShippingName" title="Address nickname" />
            </dd>
        </dl>
        <!-- EOD : 주소별칭 -->

        <!-- 받는분 -->
        <dl class="br__join__list">
            <dt>Recipient <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="Name" />
            </dd>
        </dl>
        <!-- EOD : 받는분 -->

        <!-- 휴대폰 -->
        <dl class="br__join__list">
            <dt>Tel <em class="add-manage-star">*</em></dt>
            <dd>
                <div class="join__phone">
                    <select class="join__phone-first" name="pcs1" id="devPcs1" title="Tel">
                        <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selcted<?php }?>>010</option>
                        <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selcted<?php }?>>011</option>
                        <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selcted<?php }?>>016</option>
                        <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selcted<?php }?>>017</option>
                        <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selcted<?php }?>>018</option>
                        <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selcted<?php }?>>019</option>
                    </select>
<?php if($TPL_VAR["pcs1"]){?>
                    <script>
                        $(function () {
                            $('#devPcs1').val('<?php echo $TPL_VAR["pcs1"]?>');
                        });
                    </script>
<?php }?>
                    <span class="join__phone-hyphen"></span>
                    <input class="join__input join__phone-second" type="text" value="<?php echo $TPL_VAR["pcs2"]?>" name="pcs2" id="devPcs2" title="Tel" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?> />
                    <span class="join__phone-hyphen"></span>
                    <input class="join__input join__phone-third" type="text" value="<?php echo $TPL_VAR["pcs3"]?>" name="pcs3" id="devPcs3" title="Tel"  <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>/>
                </div>
            </dd>
        </dl>
        <!-- EOD : 휴대폰 -->

        <!-- 주소 -->
        <dl class="br__join__list">
            <dt>주소 <em class="add-manage-star">*</em></dt>
            <dd>
                <div class="join__id">
                    <input class="join__input" type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zipcode"]?>" title="Zip code search" readonly/>
                    <button class="join__id__check" id="devZipPopupButton">Zip code search</button>
                </div>
                <input class="join__address" type="text"  name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>" readonly/>
                <input class="join__address" type="text" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="Detail address" placeholder="Pleae enter detail address"/>
            </dd>
        </dl>
        <!-- EOD : 주소 -->

        <div class="br__join__terms br__add-manage-terms">
            <div class="join__terms-all">
                <label for="devDefaultYn">
                    <input type="checkbox" id="devDefaultYn" name="default_yn" value="Y" class="join__terms__agree" data-force_default_yn="<?php echo $TPL_VAR["force_default_yn"]?>"  <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?>  title="Save as default shipping destination">
                    <span>Save as default shipping destination</span>
                </label>
            </div>
        </div>

        <div class="br__login__info add-manage">
            <div class="information__btn">
                <button class="information__btn__join" id="devAddressBookAddCancelBtn">Cancel</button>
                <button class="information__btn__login" id="devAddressBookAddBtn"><?php if($TPL_VAR["ix"]){?>Correction<?php }else{?>Register<?php }?></button>
            </div>
        </div>

        <ul class="br__address__manage">
            <li>
                <div class="br__address__manage-box active">
                    Address list management
                </div>
                <div class="br__address__manage-info">
                    <p class="manage-info-txt">You can manage the address information you want to use when purchasing the product.</p>
                    <p class="manage-info-txt">Up to 10 shipping address can be registered. If not registered, it will automatically be updated by your recent address book.</p>
                </div>
            </li>
        </ul>
    </form>
</section>

<?php }else{?>
<section class="br__mypage br__join br__add-manage">
    <form id="devAddressBookAddForm">
        <input type="hidden" name="tel1" value="" />
        <input type="hidden" name="tel2" value="" />
        <input type="hidden" name="tel3" value="" />
<?php if($TPL_VAR["ix"]){?>
        <input type="hidden" name="ix" value="<?php echo $TPL_VAR["ix"]?>" />
        <input type="hidden" name="mode" value="update" id="devMode" />
<?php }else{?>
        <input type="hidden" name="mode" value="insert" id="devMode" />
<?php }?>
        <div class="br__mypage__pass">
            <p class="pass-title"><?php if($TPL_VAR["ix"]){?>Address correction<?php }else{?>Add shipping address <?php }?></p>
        </div>

        <!-- 받는분 -->
        <dl class="br__join__list">
            <dt>Recipient <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="Name" />
            </dd>
        </dl>
        <!-- EOD : 받는분 -->
        <dl class="br__join__list">
            <dt>Country <em class="add-manage-star">*</em></dt>
            <dd>
                <select name="country" class="devNationArea" id="devCountry" title="Country">
                    <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
<?php if($TPL_VAR["mode"]=='insert'){?>
                            <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }else{?>
                            <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }?>
<?php }}?>
                </select>
            </dd>
        </dl>
        <!-- 휴대폰 -->
        <!-- @TODO 글로벌 휴대폰 입력타입 변경 -->
        <dl class="br__join__list">
            <dt>Tel <em class="add-manage-star">*</em></dt>
            <dd>
                <div class="join__phone">
                    <select class="join__phone-first devNationArea" name="national_phone" title="Tel">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
<?php if($TPL_VAR["mode"]=='insert'){?>
                                <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }else{?>
                                <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }?>
<?php }}?>
                    </select>
                    <input class="join__input join__phone-second" type="text" value="<?php echo $TPL_VAR["pcs"]?>" name="pcs" id="devPcs" title="Tel" />
                </div>
            </dd>
        </dl>
        <!-- EOD : 휴대폰 -->

        <!-- 주소 -->
        <!-- @TODO 글로벌 주소입력타입 변경 -->

        <dl class="br__join__list">
            <dt>Zip/Postal code <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" name="zip" id="devZip" value="<?php echo $TPL_VAR["zipcode"]?>" title="Zip/Postal code"/>
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>Address line 1 <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__address" type="text"  name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>" title="Address line 1"/>
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>Address line 2</dt>
            <dd>
                <input class="join__address" type="text" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="Address line 2"/>
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>City <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" id="devCity" name="city" value="<?php echo $TPL_VAR["city"]?>"  title="City" />
            </dd>
        </dl>
        <dl class="br__join__list">
            <dt>State/Province <em class="add-manage-star">*</em></dt>
            <dd>
<?php if($TPL_VAR["mode"]=='insert'){?>
                    <select id="devStateSelect" title="State/Province">
                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                    </select>
                    <input class="join__input" type="text" name="state" id="devStateText" title="State/Province" style="display:none;"/>
<?php }else{?>
<?php if($TPL_VAR["country"]=='US'){?>
                    <select id="devStateSelect" title="State/Province">
                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                    </select>
                    <input type="text" class="join__input" style="display:none;" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" style="display:none;">
<?php }else{?>
                    <select style="display: none;" id="devStateSelect">
                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                    </select>
                    <input type="text" class="join__input" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" >
<?php }?>
<?php }?>


            </dd>
        </dl>
        <!-- EOD : 주소 -->

        <div class="br__join__terms br__add-manage-terms">
            <div class="join__terms-all">
                <label for="devDefaultYn">
                    <input type="checkbox" id="devDefaultYn" name="default_yn" value="Y" class="join__terms__agree"  <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?> <?php if($TPL_VAR["force_default_yn"]=='Y'){?>readonly<?php }?> title="Save as default shipping destination">
                    <span>Save as default shipping destination</span>
                </label>
            </div>
        </div>

        <div class="br__login__info add-manage">
            <div class="information__btn">
                <button class="information__btn__join" id="devAddressBookAddCancelBtn">Cancel</button>
                <button class="information__btn__login" id="devAddressBookAddBtn"><?php if($TPL_VAR["ix"]){?>Correction<?php }else{?>Register<?php }?></button>
            </div>
        </div>

        <ul class="br__address__manage">
            <li>
                <div class="br__address__manage-box active">
                    Address list management
                </div>
                <div class="br__address__manage-info">
                    <p class="manage-info-txt">You can manage the address information you want to use when purchasing the product.</p>
                    <p class="manage-info-txt">Up to 10 shipping address can be registered. If not registered, it will automatically be updated by your recent address book.</p>
                </div>
            </li>
        </ul>
    </form>
</section>

<?php }?>