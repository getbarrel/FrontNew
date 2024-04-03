<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook_select/addressbook_no_member.htm 000006067 */ ?>
<!--
    //////////////////
    안쓰는 페이지!!
    회원은 팝업이고, 비회원은 페이지라서 페이지 분리했습니다.
    addressbook_select_nomember.htm 입니다.
    //////////////////
-->
<script>var addressPopMode = 'guest';</script>
<section class="br__join br__add-manage">
    <h2 class="br__cs__title">Change shipping address</h2>
    <form id="devGuestAddressBookForm" method="post">
        <!-- 받는분 -->
        <dl class="br__join__list">
            <dt>Recipient <em class="add-manage-star">*</em></dt>
            <dd>
                <input class="join__input" type="text" name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="Name" />
            </dd>
        </dl>
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
                    <input class="join__input" type="text" name="zip" value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" title="Zip code search" readonly=""/>
                    <button type="button" class="join__id__check" id="devZipPopupButton">Zip code search</button>
                </div>
                <input class="join__address" type="text"  name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>"  readonly="" />
                <input class="join__address" type="text" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="Detail address" placeholder="Pleae enter detail address"/>
            </dd>
        </dl>
        <!-- EOD : 주소 -->
        <dl class="br__join__list">
            <dt>Tel</dt>
            <dd>
                <div class="join__phone ">
                    <select class="join__phone-first" name="tel1" id="devTel1">
                        <option value="">선택</option>
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
                    <span class="join__phone-hyphen"></span>
                    <input class="join__input  join__phone-second" type="text" name="tel2" value="" id="devTel2" title="전화번호 가운데자리입력">
                    <span class="join__phone-hyphen"></span>
                    <input class="join__input join__phone-third" type="text" name="tel3" value="" id="devTel3" title="전화번호 끝자리 입력">
                </div>
            </dd>
        </dl>
    </form>
    <div class="br__login__info add-manage">
        <div class="information__btn">
            <button class="information__btn__join" id="devAddressBookPopColseBtn">Cancel</button>
            <button class="information__btn__login" id="devAddressBookPopSaveBtn" data-oid="<?php echo $TPL_VAR["oid"]?>">Save</button>
        </div>
    </div>
    <div style="display:none;">
        <div id="devAddressBooKLoading"></div>
        <div id="devAddressBooKList"></div>
        <div id="devAddressBooKEmpty"></div>
    </div>
</section>