<?php /* Template_ 2.2.8 2024/03/19 14:38:44 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_write.htm 000029724 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__mypage-board">
	<div class="fb__mypage-title">
		<div class="title-md">1:1 문의</div>
	</div>
	<section class="fb__bbs__write">
		<form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >

			<input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
			<input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
			<input type="hidden" name="focusInfo">
			<input type="hidden" name="isHtml" value='N'>
			<input type='hidden' name='antispamYn' value='N'>
			<input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
<?php if($TPL_VAR["bbsIx"]){?>
			<input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbsIx"]?>'>
<?php }?>
			<div class="write-form">
				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">문의 유형</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-item">
							<label for="" class="hide">문의 유형 선택</label>
							<select name="bbsDiv" id="devBbsDiv" title="분류" style="width:260px;">
								<option value="">선택</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?> 
								<option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?> 
							</select>
						</div>
						<div style="margin-top: 8px;" devTailMsg="devBbsDiv"></div>
					</dd>
				</dl>
				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">문의 주문건</span>
					</dt>
					<dd class="write-form__cont">
						<div class="write-form__btn-group">
							<button type="button" id="devBtnOrderQuery" class="btn-lg btn-dark-line btn-order--view">주문 조회</button>
							<p class="txt-desc">문의가 필요한 주문건이 있는 경우 조회하여 선택해 주세요.</p>
						</div>
					</dd>
				</dl>

				<!-- 주문 상품 조회 리스트 S -->
				<div class="write-form__product" id="devOrderCheckList" style="display: none">
					<ul class="product-item__wrap">
						<li class="product-item__list">
							<!-- 주문 내역 - 상품 레이아웃 커스텀 S -->
							<a href="#;" class="product-item__link">
								<dl class="product-item">
									<dt class="product-item__thumbnail-box">
										<div class="product-item__thumb">
											<img  id="orderimg" src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
										</div>
									</dt>
									<dd class="product-item__infobox">
										<div class="product-item__info">
											<div class="order-day" id="orderDay"></div>
											<div class="product-item__title c-pointer">
												<div class="title-sm" id="orderTitle"></div>
											</div>
											<input type="hidden" name="oid" id="devOid" value="<?php echo $TPL_VAR["oid"]?>">
											<div class="order-number" id="orderOid"></div>
										</div>
										<div class="product-item__btn-area">
											<button type="button" id="devBtnOrderdel" class="btn-xs btn-white btn-line-no devDeleteButton cart-item__btn-area-del">삭제</button>
											<div class="order-price"  id="orderPrice"></div>
										</div>
									</dd>
								</dl>
							</a>
							<!-- 주문 내역 - 상품 레이아웃 커스텀 E -->
						</li>
					</ul>
				</div>
				<!-- 주문 상품 조회 리스트 E -->

				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">이메일</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-group">
							<div class="fb__form-email">
								<label for="" class="hide">이메일</label>
								<input type="text" name="bbsEmailId" id="devBbsEmailId" class="fb__form-input" placeholder="이메일 아이디" value="<?php echo $TPL_VAR["emailId"]?>" />
								<input type="text" name="bbsEmailHost" id="devBbsEmailHost" class="fb__form-input" placeholder="이메일 도메인" value="<?php echo $TPL_VAR["emailHost"]?>" />
<?php if($TPL_VAR["langType"]=='korean'){?>
								<select id="devBbsEmailHostSelect" style="width:160px; margin-left:5px;">
									<option value="">직접입력</option>
									<option value="naver.com">naver.com</option>
									<option value="gmail.com">gmail.com</option>
									<option value="hotmail.com">hotmail.com</option>
									<option value="hanmail.net">hanmail.net</option>
									<option value="daum.net">daum.net</option>
									<option value="nate.com">nate.com</option>
								</select>
<?php }?>
							</div>
							<div class="fb__form-checkbox--item">
								<span class="txt-guide"></span>
								<input type="checkbox" name="notifyEmail" id="devNotifyEmail" checked="true">
								<label for="email-chk">답변 메일 수신</label>
							</div>
						</div>
						<div style="margin-top: 8px;" devTailMsg="devBbsEmailId devBbsEmailHost"></div>
					</dd>
				</dl>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">연락처</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-group">
							<div class="fb__form-phone">
								<label for="" class="hide">핸드폰</label>
								<select name="bbsHp1" id="devBbsHp1">
									<option value="010" <?php if($TPL_VAR["phone1"]=='010'){?> selected <?php }?> >010</option>
									<option value="011" <?php if($TPL_VAR["phone1"]=='011'){?> selected <?php }?> >011</option>
									<option value="016" <?php if($TPL_VAR["phone1"]=='016'){?> selected <?php }?> >016</option>
									<option value="018" <?php if($TPL_VAR["phone1"]=='018'){?> selected <?php }?> >018</option>
									<option value="019" <?php if($TPL_VAR["phone1"]=='019'){?> selected <?php }?> >019</option>
								</select>
								<input type="text" name="bbsHp2" id="devBbsHp2" class="fb__form-input" placeholder="핸드폰번호" value="<?php echo $TPL_VAR["phone2"]?>" />
								<input type="text" name="bbsHp3" id="devBbsHp3" class="fb__form-input" placeholder="핸드폰번호" value="<?php echo $TPL_VAR["phone3"]?>" />
							</div>
							<div class="fb__form-checkbox--item">
								<input type="checkbox" name="notifyHp" id="devNotifyHp" value="1" checked="true">
								<label for="phone-chk">답변 문자 수신</label>
							</div>
						</div>
						<div style="margin-top: 8px;" devTailMsg="devBbsHp1 devBbsHp2 devBbsHp3"></div>
					</dd>
				</dl>
<?php }?>
				<!-- 반품 / 환불 일 경우 S -->
				<dl class="write-form__item write-form__cancel" style="display: none">
					<dt class="write-form__title">
						<span class="title-sm">환불 정보</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-group">
							<label for="" class="hide">환불 정보</label>
							<input type="text" class="fb__form-input" placeholder="예금주" value="" />
							<input type="text" class="fb__form-input" placeholder="은행명" value="" />
							<input type="text" class="fb__form-input w100" placeholder="계좌번호" value="" />
						</div>
						<div class="txt-list txt-warning">
							<p>카드로 결제하신 고객님은 카드 승인 취소를 해드리며, 영업일 기준 3일 이내 승인 취소가 확정됩니다.</p>
							<p>카드 승인 취소와 관련하여 자세한 내용을 알고 싶으신 경우 카드사에 직접 연락하시기 바랍니다.</p>
						</div>
					</dd>
				</dl>
				<!-- 반품 / 환불 일 경우 E -->

				<!-- 수선 신청 일 경우 S -->
				<dl class="write-form__item write-form__repair" style="display: none">
					<dt class="write-form__title">
						<span class="title-sm">수선 신청인</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-item">
							<label class="hide">신청인</label>
							<input type="text" class="fb__form-input small" placeholder="이름" value="" />
						</div>
					</dd>
				</dl>
				<dl class="write-form__item write-form__repair" style="display: none">
					<dt class="write-form__title">
						<span class="title-sm">수선 완료 후 받으실 주소</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-address">
							<div class="fb__form-item">
								<label for="devZip" class="inputs__title hide">우편번호</label>
								<input type="text" name="zip" id="devZip" class="inputs__content--zip fb__form-input" title="우편번호" placeholder="우편번호" value="04366" readonly />
								<button type="button" class="btn-lg btn-dark-line inputs__content--zip-search" id="devZipPopupButton">검색</button>
							</div>
							<div class="fb__form-item">
								<label for="devAddress1" class="inputs__title hide">주소</label>
								<input type="text" name="addr1" id="devAddress1" class="fb__form-input" title="주소" placeholder="주소" value="서울 용산구 원효로 138" readonly />
							</div>
							<div class="fb__form-item">
								<label for="devAddress2" class="inputs__title hide">상세주소</label>
								<input type="text" id="devAddress2" class="fb__form-input" name="addr2" title="상세주소" placeholder="상세주소" value="청진빌딩 2층" />
							</div>
						</div>
					</dd>
				</dl>
				<!-- 수선 신청 일 경우 E -->

				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">문의 제목</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-item">
							<label for="" class="hide">문의 제목</label>
							<input type="text" name="bbsSubject" id="devBbsSubject" class="fb__form-input" title="제목" placeholder="제목을 입력해 주세요." value="<?php echo $TPL_VAR["bbs_subject"]?>" style="width:545px;"/>
						</div>
						<div style="margin-top: 8px;" devTailMsg="devBbsSubject"></div>
					</dd>
				</dl>
				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">문의 내용</span>
					</dt>
					<dd class="write-form__cont">
						<div class="fb__form-write">
							<textarea class="fb__form-textarea" name="bbsContents" id="devBbsContents" title="내용" placeholder="문의 내용을 입력해 주세요." onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
							<!-- <div class="fb__form-textarea--placeholder">
								<div class="title-md">[문의 전 유의사항]</div>
								<div class="txt-list">
									<p>
										상품문의하기에서는 상품 단순 문의만 작성 부탁드립니다.<br />
										급한 배송, 반품 문의는 [마이페이지] 1:1 맞춤 상담 게시판을 이용해 주시면 좀 더 빠른 답변을 받으실 수 있습니다.
									</p>
									<p>주문처리 상태가 ‘배송 대기 / 배송 중’ 상태인 경우 택배 발송된 상태이므로 반품 및 취소를 원하시면 왕복 택배비를 납부 후 반품 및 취소를 받으실 수 있습니다.</p>
									<p>반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</p>
								</div>
							</div> -->
							 <p class="txt-guide" devTailMsg="devBbsContents"></p>
						</div>
					</dd>
				</dl>
				<script>
					$(document).ready(function() {
						// 이미지 첨부 버튼을 클릭했을 때
						$('#devBbsFile').click(function() {
							if ($('#devBbsFile1').val() ==""){
								$('[id^=devBbsFile1]').click();
							}else if ($('#devBbsFile2').val() ==""){
								$('[id^=devBbsFile2]').click();
							}else if ($('#devBbsFile3').val() ==""){
								$('[id^=devBbsFile3]').click();
							}else if ($('#devBbsFile4').val() ==""){
								$('[id^=devBbsFile4]').click();
							}else{
								alert("이미지는 최대 4개까지 첨부할 수 있습니다.");
							}
						});
					});
				</script>
				<dl class="write-form__item">
					<dt class="write-form__title">
						<span class="title-sm">첨부파일</span>
					</dt>
					<dd class="write-form__cont">
						<div class="write-form__file">
							<div class="fb__form-group">
								<div class="fb__form-item">
									<input type="hidden" class="fb__form-file" title="첨부파일"  style="display:none;">
									<label for="devBbsFile"  id="devBbsFile"  class="btn-lg btn-dark-line">이미지 첨부</label>
								</div>
								<p class="txt-desc">이미지는 최대 4개까지 첨부 가능하며, 이미지당 10MB내로 첨부할 수 있습니다. (JPG, JPEG, PNG만 가능.)</p>

							</div>
							<ul class="fb__form-file--list">
								<li class="fb__form-file--item">
									<input type="file" name="bbsFile1" id="devBbsFile1" class="fb__form-file" title="첨부파일" >
									<input type="text" class="pub-input-text" id="devBbsFileText1" style="width:500px; border:0px" readonly>
									<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton1" style="display:none;">파일변경</button>
									<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton1" style="display:none;">삭제</button>
								</li>
								<li class="fb__form-file--item">
									<input type="file" name="bbsFile2" id="devBbsFile2" style="display:none;" title="첨부파일" >
									<input type="text" class="pub-input-text" id="devBbsFileText2" style="width:500px; border:0px" readonly>
									<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton2" style="display:none;">파일변경</button>
									<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton2" style="display:none;">삭제</button>
								</li>
								<li class="fb__form-file--item">
									<input type="file" name="bbsFile3" id="devBbsFile3" style="display:none;" title="첨부파일" >
									<input type="text" class="pub-input-text" id="devBbsFileText3" style="width:500px; border:0px" readonly>
									<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton3" style="display:none;">파일변경</button>
									<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton3" style="display:none;">삭제</button>
								</li>
								<li class="fb__form-file--item">
									<input type="file" name="bbsFile4" id="devBbsFile4" style="display:none;" title="첨부파일" >
									<input type="text" class="pub-input-text" id="devBbsFileText4" style="width:500px; border:0px" readonly>
									<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton4" style="display:none;">파일변경</button>
									<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton4" style="display:none;">삭제</button>
								</li>
							</ul>
						</div>
					</dd>
				</dl>
			</div>
			<div class="write-form__footer">
				<button type="button" id="devBbsRegSubmit" class="btn-lg btn-dark"><?php echo $TPL_VAR["btnName"]?></button>
			</div>
		</form>
	</section>
</section>
<!-- 컨텐츠 E -->

<!-- 팝업 S -- 
<div class="popup-mask"></div>
<div class="popup-layout">
	<div class="popup-title">
		<span id="devModalTitle">주문 조회</span>
		<button type="button" class="btn-close close">닫기</button>
	</div>
	<div id="devModalContent" class="popup-content">
		<section class="popup-content__wrap">
			<section class="popup-search">
				<form>
					<div class="search">
						<div class="search__row">
							<div class="search__col">
								<div class="fb__form-item">
									<label for="devSdate" class="hide">조회기간</label>
									<input type="text" id="devSdate" name="sDate" value="2023.01.01" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
									<span>-</span>
									<input type="text" id="devEdate" name="eDate" value="2023.02.01" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
									<button type="button" title="조회" class="btn-lg btn-dark-line">조회</button>
								</div>
							</div>
							<div class="search__col">
								<div class="search__day">
									<div class="day-radio">
										<a href="#;" class="day-radio__btn day-radio--active">최근 <em>1</em>개월</a>
										<a href="#;" class="day-radio__btn">최근 <em>3</em>개월</a>
										<a href="#;" class="day-radio__btn">최근 <em>6</em>개월</a>
										<a href="#;" class="day-radio__btn">최근 <em>12</em>개월</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="search__result">
						<ul class="product-item__wrap">
							<!-- 최근 주문 내역이 없을 시 S -->
							<!-- 숨김처리 -- 
							<li class="product-item__list no-data" style="display: none">
								<p class="empty-content">주문 내역이 없습니다.</p>
							</li>
							<!-- 최근 주문 내역이 없을 시 E -- 
							<li class="product-item__list">
								<!-- 주문 내역 - 상품 레이아웃 커스텀 S -- 
								<dl class="product-item">
									<dt class="product-item__thumbnail-box">
										<div class="product-item__checkbox">
											<input type="checkbox" class="cart_product_check" />
										</div>
										<div class="product-item__thumb">
											<a href="">
												<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
											</a>
										</div>
									</dt>
									<dd class="product-item__infobox">
										<div class="product-item__info">
											<div class="order-day">2024.12.31</div>
											<div class="product-item__title c-pointer">
												<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
											</div>
											<div class="order-number">202412312359-0000001</div>
										</div>
										<div class="product-item__btn-area">
											<div class="order-price"><em>1,265,550</em>원</div>
										</div>
									</dd>
								</dl>
								<!-- 주문 내역 - 상품 레이아웃 커스텀 E -- 
							</li>
							<li class="product-item__list">
								<!-- 주문 내역 - 상품 레이아웃 커스텀 S -- 
								<dl class="product-item">
									<dt class="product-item__thumbnail-box">
										<div class="product-item__checkbox">
											<input type="checkbox" class="cart_product_check" />
										</div>
										<div class="product-item__thumb">
											<a href="">
												<img src="/assets/templet/enterprise2/assets/img/product/sample.png" alt="" />
											</a>
										</div>
									</dt>
									<dd class="product-item__infobox">
										<div class="product-item__info">
											<div class="order-day">2024.12.31</div>
											<div class="product-item__title c-pointer">
												<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
											</div>
											<div class="order-number">202412312359-0000001</div>
										</div>
										<div class="product-item__btn-area">
											<div class="order-price"><em>1,265,550</em>원</div>
										</div>
									</dd>
								</dl>
								<!-- 주문 내역 - 상품 레이아웃 커스텀 E -- 
							</li>
						</ul>
						<div class="search__result-btn">
							<button type="button" class="btn-lg btn-dark-line">확인</button>
						</div>
					</div>
				</form>
			</section>
		</section>
	</div>
</div>
<!-- 팝업 E -->
<!--
<div class="wrap-inquiry fb__bbs__write">
    <div class="weite">
        <header class="bbs-title-area weite__header">
            <h1 class="weite__header__title">1:1문의하기</h1>
            <p class="weite__header__summary">
                문의하신 내용의 답변은 마이페이지 > 나의 커뮤니티 > 1:1문의내역을 통해 확인 하실 수 있습니다.
            </p>
        </header>
    </div>
    <form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >

        <input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
        <input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
        <input type="hidden" name="focusInfo">
        <input type="hidden" name="isHtml" value='N'>
        <input type='hidden' name='antispamYn' value='N'>
        <input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
<?php if($TPL_VAR["bbsIx"]){?>
        <input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbsIx"]?>'>
<?php }?>

        <table class="join-table type02">
            <colgroup>
                <col width="160px">
                <col width="*">
            </colgroup>
            <tr>
                <th><em>*</em>분류</th>
                <td>
                    <select name="bbsDiv" id="devBbsDiv" title="분류" style="width:260px;">
                        <option value="">선택</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>-- 
                        <option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>-- 
                    </select>
                    <p class="txt-guide" devTailMsg="devBbsDiv"></p>
                </td>
            </tr>
            <tr>
                <th>주문번호</th>
                <td>
                    <input type="text" name="oid" id="devOid" style="width:260px;" title="주문번호" value="<?php echo $TPL_VAR["oid"]?>" readOnly>
                    <button type="button" id="devBtnOrderQuery" class="btn-default btn-dark">조회</button>
                    <button type="button" id="devBtnOrderdel" class="btn-default btn-dark">삭제</button>
                    <p class="txt-guide">관련된 주문건이 있는 경우 조회하여 선택해 주세요.</p>
                </td>
            </tr>
            <tr>
                <th><em>*</em>이메일</th>
                <td>
                    <span class="pub-email">
                        <input type="text" name="bbsEmailId" id="devBbsEmailId" style="width:160px;" title="이메일" value="<?php echo $TPL_VAR["emailId"]?>">
                        <span class="hyphen_2">@</span>
                        <input type="text" name="bbsEmailHost" id="devBbsEmailHost" style="width:160px;" title="이메일" value="<?php echo $TPL_VAR["emailHost"]?>">
                    </span>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <select id="devBbsEmailHostSelect" style="width:160px; margin-left:5px;">
                        <option value="">직접입력</option>
                        <option value="naver.com">naver.com</option>
                        <option value="gmail.com">gmail.com</option>
                        <option value="hotmail.com">hotmail.com</option>
                        <option value="hanmail.net">hanmail.net</option>
                        <option value="daum.net">daum.net</option>
                        <option value="nate.com">nate.com</option>
                    </select>
<?php }?>
                    <span class="txt-guide"></span>
                    <input type="checkbox" name="notifyEmail" id="devNotifyEmail" checked="true" value="1" class="mal10"><label>답변 알림 수신</label>
                    <div style="margin-top: 8px;" devTailMsg="devBbsEmailId devBbsEmailHost"></div>
                </td>
            </tr>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <tr>
                <th><em>*</em>휴대폰번호</th>
                <td>
                    <div class="selectWrap">
                        <select name="bbsHp1" id="devBbsHp1">
                            <option value="010" <?php if($TPL_VAR["phone1"]=='010'){?> selected <?php }?> >010</option>
                            <option value="011" <?php if($TPL_VAR["phone1"]=='011'){?> selected <?php }?> >011</option>
                            <option value="016" <?php if($TPL_VAR["phone1"]=='016'){?> selected <?php }?> >016</option>
                            <option value="018" <?php if($TPL_VAR["phone1"]=='018'){?> selected <?php }?> >018</option>
                            <option value="019" <?php if($TPL_VAR["phone1"]=='019'){?> selected <?php }?> >019</option>
                        </select>
                        <span class="hyphen">-</span>
                        <input type="number" name="bbsHp2" value="<?php echo $TPL_VAR["phone2"]?>" id="devBbsHp2" title="휴대폰">
                        <span class="hyphen">-</span>
                        <input type="number" name="bbsHp3" value="<?php echo $TPL_VAR["phone3"]?>" id="devBbsHp3" title="휴대폰">
                        <input type="checkbox" name="notifyHp" id="devNotifyHp" value="1" checked="true" style="width:20px;" class="mal10"><label>답변 알림 수신</label>
                        <p class="txt-guide" devTailMsg="devBbsHp1 devBbsHp2 devBbsHp3"></span>
                    </div>
                </td>
            </tr>
<?php }?>
            <tr>
                <th><em>*</em>제목</th>
                <td><input type="text" name="bbsSubject" id="devBbsSubject" value="<?php echo $TPL_VAR["bbs_subject"]?>" title="제목" style="width: 100%;">
                    <p class="txt-guide" devTailMsg="devBbsSubject"></p>
                </td>
            </tr>
            <tr>
                <th><em>*</em>내용</th>
                <td><textarea name="bbsContents" id="devBbsContents" title="내용" style="width: 100%; height: 300px;" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
                    <p class="txt-guide" devTailMsg="devBbsContents"></p>
                </td>
            </tr>


<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
            <tr>
                <th>첨부파일</th>
                <td>
                    <div>
                        <input type="file" name="bbsFile1" id="devBbsFile1" style="display:none;" title="첨부파일" >
                        <input type="text" class="pub-input-text" id="devBbsFileText1" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton1">파일찾기</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton1" style="display:none;">파일변경</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton1" style="display:none;">파일삭제</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile2" id="devBbsFile2" style="display:none;" title="첨부파일" >
                        <input type="text" class="pub-input-text" id="devBbsFileText2" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton2">파일찾기</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton2" style="display:none;">파일변경</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton2" style="display:none;">파일삭제</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile3" id="devBbsFile3" style="display:none;" title="첨부파일" >
                        <input type="text" class="pub-input-text" id="devBbsFileText3" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton3">파일찾기</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton3" style="display:none;">파일변경</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton3" style="display:none;">파일삭제</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile4" id="devBbsFile4" style="display:none;" title="첨부파일" >
                        <input type="text" class="pub-input-text" id="devBbsFileText4" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton4">파일찾기</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton4" style="display:none;">파일변경</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton4" style="display:none;">파일삭제</button>
                    </div>
                    <p class="txt-guide">파일 형식은 이미지 파일(jpg, jepg, png)로 제출 가능하며, 파일당 최대 30MB까지 가능합니다.</p>
                </td>
            </tr>
<?php }?>

        </table>


        <div class="wrap-btn-area mat40">
            <button type="button" id="devBbsRegCancel" class="btn-lg btn-dark-line">취소</button>
            <button type="button" id="devBbsRegSubmit" class="btn-lg fb__btn-black">등록</button>
        </div>

    </form>

</div>
-->