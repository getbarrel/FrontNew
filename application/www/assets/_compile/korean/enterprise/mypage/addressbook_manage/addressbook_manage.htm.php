<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-qa/application/www.bak/assets/templet/enterprise/mypage/addressbook_manage/addressbook_manage.htm 000017814 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<div class="fb__mypage-addressAdd wrap-window-popup address-add-popup">
    <p class="popup-title">
        <span>
<?php if($TPL_VAR["ix"]){?>
            배송지 수정
<?php }else{?>
            새 배송지 추가
<?php }?>
        </span>
        <span class="close" onclick="window.close();"></span>
    </p>

    <div class="popup-content">
        <form id="devAddressBookAddForm">
<?php if($TPL_VAR["ix"]){?>
            <input type="hidden" name="ix" value="<?php echo $TPL_VAR["ix"]?>" />
            <input type="hidden" name="mode" value="update" id="devMode" />
<?php }else{?>
            <input type="hidden" name="mode" value="insert" id="devMode" />
<?php }?>

            <table class="fb__mypage-addressAdd__table">
                <colgroup>
                    <col width="140px">
                    <col width="*">
                </colgroup>
                <tbody class="table">
                <tr class="eng-hidden">
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        주소 별칭
                    </th>
                    <td>
                        <input class="table__input--long" type="text" name="shipping_name" value="<?php echo $TPL_VAR["shipping_name"]?>" id="devShippingName" title="배송지 별칭">
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        받는 분
                    </th>
                    <td class="wrap-checkbox">
                        <input  class="table__input--long"  type="text"  name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="받는 분">
                        <label>
                            <input type="checkbox" name="default_yn" value="Y" id="devDefaultYn" data-force_default_yn="<?php echo $TPL_VAR["force_default_yn"]?>" <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?> title="기본배송지로설정">
                            <span>기본 배송지로 설정</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        주소
                    </th>
                    <td>
                        <div class="form-info-wrap">
                            <input type="text" class="table__input--short dim" name="zip"  value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" readonly="" title="우편번호">
                            <button type="button" class="table__btn--find" id="devZipPopupButton">주소찾기</button>
                            <input type="text" class="table__input--long dim mat10" name="addr1" id="devAddress1"  value="<?php echo $TPL_VAR["address1"]?>" readonly="" title="주소">
                            <input type="text" class="table__input--long mat10" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="상세주소" placeholder="상세주소를 입력해 주세요.">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><em class="fb__mypage-addressAdd__table--must">*</em>휴대폰 번호</th>
                    <td>
                        <div class="selectWrap">
                            <select class="table__input--short" name="pcs1" id="devPcs1" title="휴대폰번호">
                                <option value="">선택</option>
                                <option value="010">010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>
<?php if($TPL_VAR["pcs1"]){?>
                            <script>
                                $(function () {
                                    $('#devPcs1').val('<?php echo $TPL_VAR["pcs1"]?>');
                                });
                            </script>
<?php }?>
                            <span class="hyphen">-</span>
                            <input class="table__input--short" type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" title="휴대폰번호">
                            <span class="hyphen">-</span>
                            <input class="table__input--short" type="number" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" title="휴대폰번호">
                        </div>
                    </td>
                </tr>
                <!--<tr>-->
                    <!--<th scope="col">전화 번호</th>-->
                    <!--<td>-->
                        <!--<div class="selectWrap">-->
                            <!--<select class="table__input&#45;&#45;short" name="tel1" id="devTel1">-->
                                <!--<option value="">선택</option>-->
                                <!--<option value="02">02</option>-->
                                <!--<option value="031">031</option>-->
                                <!--<option value="032">032</option>-->
                                <!--<option value="041">041</option>-->
                                <!--<option value="042">042</option>-->
                                <!--<option value="043">043</option>-->
                                <!--<option value="051">051</option>-->
                                <!--<option value="052">052</option>-->
                                <!--<option value="053">053</option>-->
                                <!--<option value="054">054</option>-->
                                <!--<option value="055">055</option>-->
                                <!--<option value="061">061</option>-->
                                <!--<option value="062">062</option>-->
                                <!--<option value="063">063</option>-->
                                <!--<option value="064">064</option>-->
                                <!--<option value="070">070</option>-->
                                <!--<option value="080">080</option>-->
                                <!--<option value="090">090</option>-->
                            <!--</select>-->
<?php if($TPL_VAR["tel1"]){?>
                            <!--<script>-->
                                <!--$(function () {-->
                                    <!--$('#devTel1').val('<?php echo $TPL_VAR["tel1"]?>');-->
                                <!--});-->
                            <!--</script>-->
<?php }?>
                            <!--<span class="hyphen">-</span>-->
                            <!--<input class="table__input&#45;&#45;short" type="text" name="tel2" value="<?php echo $TPL_VAR["tel2"]?>" id="devTel2" title="전화번호 가운데자리입력">-->
                            <!--<span class="hyphen">-</span>-->
                            <!--<input class="table__input&#45;&#45;short" type="text" name="tel3" value="<?php echo $TPL_VAR["tel3"]?>" id="devTel3" title="전화번호 끝자리 입력">-->
                        <!--</div>-->
                    <!--</td>-->
                <!--</tr>-->
                </tbody>
            </table>
        </form>
        <div class="fb__mypage-addressAdd__info">
            <p>상품 구매 시 사용하실 주소 정보를 관리하실 수 있습니다.</p>
            <p>배송주소록은 최대 10개까지 등록할 수 있으며, 별도로 등록하지 않을 경우 최근 배송 주소록 기준으로 자동 업데이트 됩니다.</p>
        </div>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" id="devAddressBookAddCancelBtn">취소</button>
            <button class="btn-default btn-dark" id="devAddressBookAddBtn">저장</button>
        </div>
    </div>

</div>
<?php }else{?>
<div class="fb__mypage-addressAdd wrap-window-popup address-add-popup">
    <p class="popup-title">
        <span>
<?php if($TPL_VAR["ix"]){?>배송지 수정<?php }else{?>배송지 추가<?php }?>
        </span>
        <span class="close" onclick="window.close();"></span>
    </p>

    <div class="popup-content">
        <form id="devAddressBookAddForm">
<?php if($TPL_VAR["ix"]){?>
            <input type="hidden" name="ix" value="<?php echo $TPL_VAR["ix"]?>" />
            <input type="hidden" name="mode" value="update" id="devMode" />
<?php }else{?>
            <input type="hidden" name="mode" value="insert" id="devMode" />
<?php }?>

            <table class="fb__mypage-addressAdd__table">
                <colgroup>
                    <col width="140px">
                    <col width="*">
                </colgroup>
                <tbody class="table">
                <tr class="eng-hidden">
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        주소 별칭
                    </th>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        받는 분
                    </th>
                    <td class="wrap-checkbox">
                        <input  class="table__input--long"  type="text"  name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="받는 분">
                        <label>
                            <input type="checkbox" name="default_yn" value="Y" id="devDefaultYn" <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?> title="기본배송지로설정">
                            <span>기본 배송지로 설정</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        Country
                    </th>
                    <td>
                        <select name="country" class="table__input--long devNationArea" id="devCountry" title="Country">
                            <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
<?php if($TPL_VAR["mode"]=='insert'){?>
                                    <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }else{?>
                                    <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }?>
<?php }}?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        Zip/Postal Code
                    </th>
                    <td>
                        <input type="text" class="table__input--short" name="zip"  value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" title="Zip/Postal Code">
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        Address line 1
                    </th>
                    <td>
                        <input type="text" class="table__input--long" name="addr1" id="devAddress1"  value="<?php echo $TPL_VAR["address1"]?>" title="Address line 1">

                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        Address line 2
                    </th>
                    <td>
                        <input type="text" class="table__input--long" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="Address line 2">
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        City
                    </th>
                    <td>
                        <input type="text" class="table__input--middle" name="city" id="devCity" value="<?php echo $TPL_VAR["city"]?>" title="City">
                    </td>
                </tr>
                <tr>
                    <th scope="col">
                        <em class="fb__mypage-addressAdd__table--must">*</em>
                        State/Province
                    </th>
                    <td>
<?php if($TPL_VAR["mode"]=='insert'){?>
                            <select id="devStateSelect" class="table__input--long" title="State/Province">
                                <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                            </select>
                            <input type="text" style="display:none;" id="devStateText"  name="state"  class="table__input--long" title="State/Province">
<?php }else{?>
<?php if($TPL_VAR["country"]=='US'){?>
                            <select style="width:340px;" id="devStateSelect" title="State/Province">
                                <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                            </select>
                            <input type="text" class="mat10" style="width:340px; display:none;" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" >
<?php }else{?>
                            <select style="width:340px;display: none;">
                                <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                            </select>
                            <input type="text" class="mat10" style="width:340px" id="devStateText" name="state" value="<?php echo $TPL_VAR["state"]?>" title="State/Province" >
<?php }?>
<?php }?>

                    </td>
                </tr>

                <tr>
                    <th scope="col"><em class="fb__mypage-addressAdd__table--must">*</em>휴대폰 번호</th>
                    <td>
                        <div class="selectWrap">
                            <select class="table__input--short devNationArea" name="national_phone"  title="휴대폰 번호">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
<?php if($TPL_VAR["mode"]=='insert'){?>
                                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }else{?>
                                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }?>
<?php }}?>
                            </select>
                            <input class="table__input--short" type="number" name="pcs" id="devPcs" value="<?php echo $TPL_VAR["pcs"]?>" title="휴대폰 번호" style="width:226px;">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <div class="fb__mypage-addressAdd__info">
            <p>상품 구매 시 사용하실 주소 정보를 관리하실 수 있습니다.</p>
            <p>배송주소록은 최대 10개까지 등록할 수 있으며, 별도로 등록하지 않을 경우 최근 배송 주소록 기준으로 자동 업데이트 됩니다.</p>
        </div>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" id="devAddressBookAddCancelBtn">취소</button>
            <button class="btn-default btn-dark" id="devAddressBookAddBtn">저장</button>
        </div>
    </div>

</div>
<?php }?>