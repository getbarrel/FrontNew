<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/addressbook_select/addressbook_no_member.htm 000005147 */ ?>
<script>var addressPopMode = 'guest';</script>
<div class="popup-content">
    <form id="devGuestAddressBookForm" method="post">
        <table class="join-table">
            <colgroup>
                <col width="140px">
                <col width="*">
            </colgroup>
            <tbody>
                <tr>
                    <th scope="col"><em>*</em>Name</th>
                    <td>
                        <input type="text" style="width:330px;" name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="받는 분">
                    </td>
                </tr>
                <tr>
                    <th scope="col"><em>*</em>Address</th>
                    <td>
                        <div class="form-info-wrap" style="width:330px">
                            <input type="text" class="dim" name="zip"  value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" style="width:120px;" readonly="" title="우편번호">
                            <button type="button" class="btn-default btn-dark" id="devZipPopupButton">Find Address</button>
                            <input type="text" class="dim mat10" name="addr1" id="devAddress1"  value="<?php echo $TPL_VAR["address1"]?>" style="width:330px;" readonly="" title="주소">
                            <input type="text" class="mat10" style="width:330px;" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="상세주소">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col"><em>*</em>Tel</th>
                    <td>
                        <div class="selectWrap">
                            <select name="pcs1" id="devPcs1" title="휴대폰번호">
                                <option value="">Select</option>
                                <option value="010">010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" title="휴대폰번호">
                            <span class="hyphen">-</span>
                            <input type="number" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" title="휴대폰번호">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="col">Tel</th>
                    <td>
                        <div class="selectWrap">
                            <select name="tel1" id="devTel1">
                                <option value="">Select</option>
                                <option value="02">02</option>
                                <option value="031">031</option>
                                <option value="032">032</option>
                                <option value="041">041</option>
                                <option value="042">042</option>
                                <option value="043">043</option>
                                <option value="051">051</option>
                                <option value="052">052</option>
                                <option value="053">053</option>
                                <option value="054">054</option>
                                <option value="055">055</option>
                                <option value="061">061</option>
                                <option value="062">062</option>
                                <option value="063">063</option>
                                <option value="064">064</option>
                                <option value="070">070</option>
                                <option value="080">080</option>
                                <option value="090">090</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input type="text" name="tel2" value="" id="devTel2" title="전화번호 가운데자리입력">
                            <span class="hyphen">-</span>
                            <input type="text" name="tel3" value="" id="devTel3" title="전화번호 끝자리 입력">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <div class="popup-btn-area">
        <button class="btn-default btn-dark-line" id="devAddressBookPopColseBtn">Cancel</button>
        <button class="btn-default btn-point" id="devAddressBookPopSaveBtn" data-oid="<?php echo $TPL_VAR["oid"]?>">Save</button>
    </div>
</div>