<?php /* Template_ 2.2.8 2024/02/20 11:43:41 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/addressbook/addressbook.htm 000007703 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__addressbook">
	<div class="fb__mypage-title">
		<div class="title-md">배송지 관리</div>
	</div>
	<section class="fb__addressbook-warp">
		<div class="fb-tab__wrap fb-tab__col">
			<div class="fb-tab__nav">
				<ul>
					<li id="menu1" class="active">
						<a href="#;">배송지 목록</a>
					</li>
					<li id="menu2" >
						<a href="#;">신규 배송지</a>
					</li>
				</ul>
			</div>
			<div class="fb-tab__contents-wrap">
				<div class="fb-tab__contents active">
				<form id="devAddressBookForm">
					<input type="hidden" name="page" value="1" id="devPage"/>
					<input type="hidden" name="max" value="10" />
					<ul id="devAddressBooKContent" class="address-list">
						<li id="devAddressBooKLoading" class="devForbizTpl">
							<div class="devForbizTpl">
								<div class="wrap-loading">
									<div class="loading"></div>
								</div>
							</div>
						</li>
						<li id="devAddressBooKEmpty" class="address-list__item no-data">
							<div class="list-info">
								<p class="txt-guide">등록된 기본 배송지가 없습니다.</p>
							</div>
						</li>

						<li id="devAddressBooKList" class="address-list__item basic">
							<!-- 해당 주소가 기본일 경우엔 class = basic 추가-->
							<div class="list-info">
								<div class="list-info__name">
									<label class="list-info__select">
										<input type="radio" name="addressCheck" />
										{[recipient]} {[#if default_yn]}<span>기본</span>{[/if]}
									</label>
								</div>
								<div class="list-info__address">
									{[zipcode]}<br>{[address1]}{[address2]}
								</div>
								<div class="list-info__number">{[mobile]} {[tel]}</div>
							</div>
							<div class="list-info__btn">
								<button type="button" class="btn-link btn-modify devAddressBookModify" data-ix="{[ix]}" data-shipping_name="{[shipping_name]}" data-recipient="{[recipient]}" data-default_yn="{[default_yn]}" data-mobile="{[mobile]}" data-zipcode="{[zipcode]}" data-addr1="{[address1]}" data-addr2="{[address2]}">변경</button>
								<button type="button" class="btn-link btn-del devAddressBookDelete" data-ix="{[ix]}" data-default_yn="{[default_yn]}">삭제</button>
							</div>
						</li>
					</ul>
					<div id="devPageWrap"></div>
					<div class="fb__addressbook-footer">
						<button type="button" class="btn-lg btn-dark-line">기본 배송지로 등록</button>
					</div>
					</form>
				</div>
				<div class="fb-tab__contents">
				<form id="devAddressBookAddForm">
					<input type="hidden" name="ix"  id="devIx" value="" />
					<input type="hidden" name="mode" value="insert" id="devMode" />
					<div class="delivery-info">
						<ul class="delivery-info__box">
							<li class="delivery-info__item delivery-info__list-name">
								<div class="title-sm">기본 정보</div>
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientNickname" class="delivery-info__label hide">주소 별칭</label>
										<input type="text" class="fb__form-input" name="shipping_name" id="devShippingName" title="주소 별칭" placeholder="주소 별칭" value="<?php echo $TPL_VAR["shipping_name"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="fb__form-item">
										<label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
										<input type="text" class="fb__form-input devRecipientName" name="recipient" id="devRecipient" title="받는 분 이름" placeholder="받는 분 이름" value="<?php echo $TPL_VAR["recipient"]?>" />
									</div>
								</div>
								<div class="delivery-info__list">
									<div class="selectWrap delivery-info__list-phone">
										<div class="fb__form-item">
											<label for="devRecipientMobile1" class="delivery-info__label hide">휴대폰</label>
											<select class="fb__form-select devRecipientMobile1" name="pcs1" id="devPcs1" title="받는 분 휴대폰 번호" >
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
											<input type="text" name="pcs2" id="devPcs2" class="fb__form-input devRecipientMobile2" title="받는 분 휴대폰 번호2" placeholder="0000" value="<?php echo $TPL_VAR["pcs2"]?>" />
											<input type="text" name="pcs3" id="devPcs3" class="fb__form-input devRecipientMobile3" title="받는 분 휴대폰 번호3" placeholder="0000" value="<?php echo $TPL_VAR["pcs3"]?>" />
										</div>
									</div>
								</div>
								<div class="check-area delivery-info__check-area">
									<div class="check-area__item fb__form-item">
										<input type="checkbox" name="default_yn" value="Y" id="devDefaultYn" data-force_default_yn="<?php echo $TPL_VAR["force_default_yn"]?>" <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?> title="기본배송지로설정"/>
										<label for="devDefaultYn">기본 배송지로 지정</label>
									</div>
								</div>
							</li>


							<li class="delivery-info__item">
								<div class="title-sm">주소</div>
								<div class="delivery-info__list delivery-info__list-address">
									<div class="form-info-wrap delivery-info__list-group">
										<div class="fb__form-item">
											<label for="devRecipientZip" class="delivery-info__label hide">주소</label>
											<input type="text" class="table__input--short dim" name="zip"  value="<?php echo $TPL_VAR["zipcode"]?>" id="devZip" readonly="" title="우편번호" readonly="">
											
											<button type="button" class="btn-s btn-dark-line" id="devZipPopupButton">검색</button>
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-address devRecipientAddr1" name="addr1" id="devAddress1"  title="받는 분 주소" placeholder="주소" value="<?php echo $TPL_VAR["address1"]?>" readonly="" />
										</div>
										<div class="fb__form-item">
											<input type="text" class="fb__form-input input-add-detail devRecipientAddr2" name="addr2" id="devAddress2" title="받는 분 상세주소" placeholder="상세주소" value="<?php echo $TPL_VAR["address2"]?>" />
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="use-notice">
						<h3 class="use-notice__title">배송지 등록 안내</h3>
						<ul class="use-notice__list">
							<li class="use-notice__desc">배송지 등록 시 입력사항은 모두 필수 항목 입니다.</li>
							<li class="use-notice__desc">배송지 등록은 최대 10개까지 등록 가능하며, 배송지 등록이 없는 경우에는 최근 배송지 기준으로 자동 등록 됩니다.</li>
						</ul>
					</div>
					<div class="fb__addressbook-footer">
						<button type="button" class="btn-lg btn-dark-line" id="devAddressBookAddBtn">등록</button>
					</div>
				</form>
				</div>
			</div>
		</div>


	</section>
</section>
<script src="/assets/templet/enterprise/js/mypage/addressbookManage.js?version=1701322947"></script>
<!-- 컨텐츠 E -->