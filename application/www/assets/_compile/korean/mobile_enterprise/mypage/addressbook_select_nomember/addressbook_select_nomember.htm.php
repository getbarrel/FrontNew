<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook_select_nomember/addressbook_select_nomember.htm 000007272 */ ?>
<script>var addressPopMode = 'guest';</script>
<!--안쓰는 페이지-->
<section class="br__join br__add-manage">
      <h2 class="br__cs__title">배송지 변경</h2>
      <form id="devGuestAddressBookForm" method="post">
            <input type="hidden" name="oId" value="<?php echo $TPL_VAR["oid"]?>" />
            <input type="hidden" name="type" value="update" />
            <input type="hidden" name="deliveryIx" value="false" />
            <input type="hidden" name="deliveryInfo" value="" id="devDeliveryInfo"/>
            <!-- 받는분 -->
            <dl class="br__join__list">
                  <dt>받는분 <em class=""add-manage-star"">*</em></dt>
                  <dd>
                        <input class="join__input" type="text" name="recipient" value="<?php echo $TPL_VAR["recipient"]?>" id="devRecipient" title="받는 분" />
                  </dd>
            </dl>
            <!-- 휴대폰 -->
            <dl class="br__join__list">
                  <dt>휴대폰 <em class=""add-manage-star"">*</em></dt>
                  <dd>
                        <div class="join__phone">
                              <select class="join__phone-first" name="pcs1" id="devPcs1" title="휴대폰번호">
                                    <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selected<?php }?>>010</option>
                                    <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selected<?php }?>>011</option>
                                    <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selected<?php }?>>016</option>
                                    <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selected<?php }?>>017</option>
                                    <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selected<?php }?>>018</option>
                                    <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selected<?php }?>>019</option>
                              </select>
<?php if($TPL_VAR["pcs1"]){?>
                              <script>
                                  $(function () {
                                      $('#devPcs1').val('<?php echo $TPL_VAR["pcs1"]?>');
                                  });
                              </script>
<?php }?>
                              <span class="join__phone-hyphen"></span>
                              <input class="join__input join__phone-second" type="text" value="<?php echo $TPL_VAR["pcs2"]?>" name="pcs2" id="devPcs2" title="휴대폰 번호" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?> />
                              <span class="join__phone-hyphen"></span>
                              <input class="join__input join__phone-third" type="text" value="<?php echo $TPL_VAR["pcs3"]?>" name="pcs3" id="devPcs3" title="휴대폰 번호"  <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>/>
                        </div>
                  </dd>
            </dl>
            <!-- EOD : 휴대폰 -->
            <!-- 주소 -->
            <dl class="br__join__list">
                  <dt>주소 <em class=""add-manage-star"">*</em></dt>
                  <dd>
                        <div class="join__id">
                              <input class="join__input" type="text" name="zip" value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" title="우편번호 검색" readonly=""/>
                              <button type="button" class="join__id__check" id="devZipPopupButton">우편번호 검색</button>
                        </div>
                        <input class="join__address" type="text"  name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>"  readonly="" />
                        <input class="join__address" type="text" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="상세주소" placeholder="상세주소를 입력해주세요."/>
                  </dd>
            </dl>
            <!-- EOD : 주소 -->
            <!--<dl class="br__join__list">-->
                  <!--<dt>전화 번호</dt>-->
                  <!--<dd>-->
                        <!--<div class="join__phone ">-->
                              <!--<select class="join__phone-first" name="tel1" id="devTel1">-->
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
                              <!--<span class="join__phone-hyphen"></span>-->
                              <!--<input class="join__input  join__phone-second" type="text" name="tel2" value="" id="devTel2" title="전화번호 가운데자리입력">-->
                              <!--<span class="join__phone-hyphen"></span>-->
                              <!--<input class="join__input join__phone-third" type="text" name="tel3" value="" id="devTel3" title="전화번호 끝자리 입력">-->
                        <!--</div>-->
                  <!--</dd>-->
            <!--</dl>-->
      </form>
      <div class="br__login__info add-manage">
            <div class="information__btn">
                  <button class="information__btn__join" id="devAddressBookPopColseBtn" data-oid="<?php echo $TPL_VAR["oid"]?>">취소</button>
                  <button class="information__btn__login" id="devAddressBookPopSaveBtn" data-oid="<?php echo $TPL_VAR["oid"]?>">저장</button>
            </div>
      </div>
      <div style="display:none;">
            <div id="devAddressBooKLoading"></div>
            <div id="devAddressBooKList"></div>
            <div id="devAddressBooKEmpty"></div>
      </div>
</section>