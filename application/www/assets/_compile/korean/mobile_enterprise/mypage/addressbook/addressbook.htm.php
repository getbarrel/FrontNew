<?php /* Template_ 2.2.8 2024/02/20 12:00:50 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook/addressbook.htm 000008156 */ ?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__address">
	<div class="page-title my-title">
		<div class="title-sm">배송지 관리</div>
	</div>
	<div class="br__address__wrap">
		<div class="br__infoinput">
			<div class="br-tab__wrap">
				<div class="br-tab__nav">
					<ul>
						<li id="menu1" class="active"><a href="#;">기본 배송지</a></li>
						<li id="menu2"><a href="#;">신규 배송지</a></li>
					</ul>
				</div>
				<div class="br-tab__contents-wrap">
					<!-- 기본 배송지 -->
					<div class="br-tab__contents fb-tab__contents active">
					<form id="devAddressBookForm">
						<input type="hidden" name="page" value="1" id="devPage"/>
						<input type="hidden" name="max" value="100" />
						<div class="info-addr">
							<div class="info-addr__recent">
								<ul id="devAddressBooKContent" class="info-addr__recent__list">
									<li class="info-addr__recent__box selected devForbizTpl" id="devAddressBooKList">
										<!-- 선택 된 주소는 class= "selected" 추가 -->
										<div class="info-addr__recent__info">
											<!-- 주소 선택해야 할 경우(체크박스&라디오 박스 있을 경우) div class= "info-addr__recent__top" 로 감쌀 것. -->
											<div class="info-addr__recent__top">
												<div class="info-addr__recent__name br__form-item">
													<label class="br__form-radio__label">
														<input type="radio" name="selectAddress" class="br__form-radio" checked />
														<span class="name">{[recipient]} {[#if default_yn]}<span>&#40;기본&#41;</span>{[/if]}</span>
													</label>
												</div>
												<div class="btn-group">
													<button type="button" class="btn-link btn-modify devAddressBookModify" data-ix="{[ix]}" data-shipping_name="{[shipping_name]}" data-recipient="{[recipient]}" data-default_yn="{[default_yn]}" data-mobile="{[mobile]}" data-zipcode="{[zipcode]}" data-addr1="{[address1]}" data-addr2="{[address2]}">수정</button>
													{[#if default_yn]}
													{[else]}
													<button type="button" class="btn-link address__btn-del devAddressBookDelete" data-ix="{[ix]}">삭제</button>
													{[/if]}
												</div>
											</div>
											<div class="info-addr__recent__addr">{[zipcode]} / {[address1]} {[address2]}</div>
											<div class="info-addr__recent__phone">{[mobile]}</div>
										</div>
									</li>
									<li class="br-loading devForbizTpl" id="devAddressBooKLoading">
										<div class="info">
											<p class="name"><strong>Loading ...</strong></p>
										</div>
									</li>
							
									<li class="info-addr__recent__box no-data devForbizTpl" id="devAddressBooKEmpty">
										<p class="empty-content">등록된 배송지가 없습니다.</p>
									</li>
								</ul>
							</div>
						</div>
						<div class="br__address-footer">
							<div class="btn-group">
								<button type="button" class="btn-lg btn-dark-line">기본 배송지로 등록</button>
							</div>
						</div>
					</form>
					</div>
					<!-- // 기본 배송지 -->
					<!-- 산규 배송지 -->
					<div class="br-tab__contents fb-tab__contents">
					<form id="devAddressBookAddForm">
						<input type="hidden" name="ix"  id="devIx" value="" />
						<input type="hidden" name="mode" value="insert" id="devMode" />
						<div class="info-buyer">
							<div class="info-buyer__form">
								<label for="devShippingName" class="info-buyer__form__label">주소 별칭</label>
								<input type="text" id="devShippingName" name="shipping_name" class="join__input" title="주소 별칭" placeholder="주소 별칭" value="<?php echo $TPL_VAR["shipping_name"]?>" />
							</div>
							<div class="info-buyer__form">
								<label for="devRecipient" class="info-buyer__form__label">이름</label>
								<input type="text" id="devRecipient" name="recipient" class="devRecipientName" title="받는 분 이름" placeholder="이름" value="<?php echo $TPL_VAR["recipient"]?>" />
							</div>
							<div class="info-buyer__form info-buyer__form--phone">
								<label for="devRecipientMobile1" class="info-buyer__form__label">휴대폰</label>
								<div class="flexWrap">
									<select id="devPcs1" name="pcs1" class="info-buyer__form__select devRecipientMobile1" title="휴대폰번호">
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
									<input type="text" name="pcs2" id="devPcs2" class="info-buyer__form__input devRecipientMobile2" title="받는 분 휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["pcs2"]?>"  <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?> />
									<input type="text" name="pcs3" id="devPcs3" class="info-buyer__form__input devRecipientMobile3" title="받는 분 휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["pcs3"]?>" <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?> />
								</div>
							</div>
							<div class="info-buyer__form info-buyer__form--addr">
								<label class="info-buyer__form__label">주소</label>
								<div class="info-buyer__form__find-addr">
									<input type="text" class="info-buyer__form__input devRecipientZip" name="zip" id="devZip" title="받는 분 주소" placeholder="우편번호" value="<?php echo $TPL_VAR["zipcode"]?>" />
									<button class="info-buyer__form__btn devRecipientZipPopupButton" id="devZipPopupButton">검색</button>
								</div>
								<input type="text" class="info-buyer__form__input devRecipientAddr1" name="addr1" id="devAddress1" value="<?php echo $TPL_VAR["address1"]?>" readonly/>
								<input type="text" class="info-buyer__form__input devRecipientAddr2" name="addr2" id="devAddress2" value="<?php echo $TPL_VAR["address2"]?>" title="받는 분 상세주소" placeholder="상세주소" />
							</div>
							<div class="info-buyer__form info-buyer__form--check">
								<div class="flexWrap">
									<input type="checkbox" id="devDefaultYn" name="default_yn" value="Y" class="info-buyer__form__check" data-force_default_yn="<?php echo $TPL_VAR["force_default_yn"]?>"  <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?>  title="기본 배송지로 저장"/>
									<label for="devDefaultYn" class="txt-gray">기본 배송지로 지정</label>
								</div>
							</div>
						</div>
						<div class="use-notice">
							<h3 class="use-notice__title">배송지 등록 안내</h3>
							<ul class="use-notice__list">
								<li class="use-notice__desc">배송지 등록 시 입력사항은 모두 필수 항목 입니다.</li>
								<li class="use-notice__desc">배송지 등록은 최대 10개까지 등록 가능하며, 배송지 등록이 없는 경우에는 최근 배송지 기준으로 자동 등록 됩니다.</li>
							</ul>
						</div>
						<div class="br__address-footer">
							<div class="btn-group">
								<button type="button" class="btn-lg btn-dark-line" id="devAddressBookAddCancelBtn">취소</button>
								<button type="button" class="btn-lg btn-dark" id="devAddressBookAddBtn">등록하기</button>
							</div>
						</div>
					</form>
					</div>
					<!-- // 산규 배송지 -->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->