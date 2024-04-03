<?php /* Template_ 2.2.8 2024/03/21 17:31:44 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_write.htm 000027096 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!--<script>
    $(function(){
     common.util.modal.open('ajax', '주문번호 조회', '/popup/orderList', '');
    });
</script>-->

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

			$("#devBbsFile1").change(function() {
				// 선택된 파일 정보 가져오기
				var fileName = $(this).val().split("\\").pop(); // 파일 이름만 추출
				$("#devBbsFileText1").val(fileName);
				$("#devBbs1").show();
				$("#devBbsFileDeleteButton1").show();
			});

			$("#devBbsFile2").change(function() {
				// 선택된 파일 정보 가져오기
				var fileName = $(this).val().split("\\").pop(); // 파일 이름만 추출
				$("#devBbsFileText2").val(fileName);
				$("#devBbs2").show();
				$("#devBbsFileDeleteButton2").show();
			});

			$("#devBbsFile3").change(function() {
				// 선택된 파일 정보 가져오기
				var fileName = $(this).val().split("\\").pop(); // 파일 이름만 추출
				$("#devBbsFileText3").val(fileName);
				$("#devBbs3").show();
				$("#devBbsFileDeleteButton3").show();
			});

			$("#devBbsFile4").change(function() {
				// 선택된 파일 정보 가져오기
				var fileName = $(this).val().split("\\").pop(); // 파일 이름만 추출
				$("#devBbsFileText4").val(fileName);
				$("#devBbs4").show();
				$("#devBbsFileDeleteButton4").show();
			});
			// 삭제 버튼 클릭 시 실행되는 함수
			$("#devBbsFileDeleteButton1").click(function() {
				$("#devBbs1").hide();
				$("#devBbsFileDeleteButton1").hide();
				$("#devBbsFile1").val("");
				$("#devBbsFileText1").val("");
			});
			$("#devBbsFileDeleteButton2").click(function() {
				$("#devBbs2").hide();
				$("#devBbsFileDeleteButton2").hide();
				$("#devBbsFile2").val("");
				$("#devBbsFileText2").val("");
			});
			$("#devBbsFileDeleteButton3").click(function() {
				$("#devBbs3").hide();
				$("#devBbsFileDeleteButton3").hide();
				$("#devBbsFile3").val("");
				$("#devBbsFileText3").val("");
			});
			$("#devBbsFileDeleteButton4").click(function() {
				$("#devBbs4").hide();
				$("#devBbsFileDeleteButton4").hide();
				$("#devBbsFile4").val("");
				$("#devBbsFileText4").val("");
			});
		});
	});
</script>
<!-- 컨텐츠 S -->
<section class="br__mypage br__myInquiry">
	<div class="page-title my-title">
		<div class="title-sm">1:1 문의</div>
	</div>
	<section class="board-write">
		<form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >
			<input type="hidden" name="url" value="/customer/"/>
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
				<div class="write-form__item">
					<div class="br__form-item">
						<label for="" class="hidden">문의 유형 선택</label>
						<select class="br__form-select inquiry-type__select" name="bbsDiv" id="devBbsDiv" title="분류">
							<option value="">문의 유형 선택 (필수)</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
						</select>
						<p class="txt-error mat10" devTailMsg="devBbsDiv"></p>
					</div>
				</div>

				<!-- 주문 상품 조회 리스트 S -->
				<div class="write-form__product">

					<div class="write-form__item">
                        <input class="br__form-input" type="text" id="devOid" value="<?php echo $TPL_VAR["oid"]?>" title="주문번호" placeholder="주문번호" readonly />
						<button type="button" class="btn-lg btn-dark-line btn-order--view" id="devBtnOrderQuery">주문 조회</button>
						<p class="txt-desc">문의가 필요한 주문건이 있는 경우 조회하여 선택해 주세요.</p>
					</div>
				</div>
				<!-- 주문 상품 조회 리스트 E -->

				<div class="write-form__item">
					<div class="br__form-email">
						<div class="br__form-group">
							<label for="" class="hidden">이메일</label>
							<input type="text" class="br__form-input" placeholder="이메일 아이디" name="bbsEmailId" id="bbsEmailId" title="이메일" value="<?php echo $TPL_VAR["emailId"]?>" />
							<input type="text" class="br__form-input" placeholder="이메일 도메인" name="bbsEmailHost" id="bbsEmailHost" title="이메일" value="<?php echo $TPL_VAR["emailHost"]?>" />
						</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
						<select id="devBbsEmailHostSelect">
							<option value="">이메일 선택</option>
							<option value="naver.com">naver.com</option>
							<option value="gmail.com">gmail.com</option>
							<option value="hotmail.com">hotmail.com</option>
							<option value="hanmail.net">hanmail.net</option>
							<option value="daum.net">daum.net</option>
							<option value="nate.com">nate.com</option>
							<option value="direct" >직접입력</option>
						</select>
<?php }?>
						<div class="br__form-checkbox--item">
							<input type="checkbox" name="notifyEmail" id="devNotifyEmail" checked="true">
							<label for="email-chk">답변 메일 수신</label>
						</div>
					</div>
				</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<div class="write-form__item">
					<div class="br__form-phone">
						<div class="br__form-group">
							<label for="" class="hidden">핸드폰</label>
							<select class="br__form-select" name="bbsHp1" id="devBbsHp1">
								<option value="010" <?php if($TPL_VAR["phone1"]=='010'){?> selected <?php }?> >010</option>
								<option value="011" <?php if($TPL_VAR["phone1"]=='011'){?> selected <?php }?> >011</option>
								<option value="016" <?php if($TPL_VAR["phone1"]=='016'){?> selected <?php }?> >016</option>
								<option value="018" <?php if($TPL_VAR["phone1"]=='018'){?> selected <?php }?> >018</option>
								<option value="019" <?php if($TPL_VAR["phone1"]=='019'){?> selected <?php }?> >019</option>
							</select>
							<input type="text" name="bbsHp2" id="devBbsHp2"class="br__form-input" placeholder="핸드폰번호" value="<?php echo $TPL_VAR["phone2"]?>" />
							<input type="text" name="bbsHp3" id="devBbsHp3" class="br__form-input" placeholder="핸드폰번호" value="<?php echo $TPL_VAR["phone3"]?>" />
						</div>
						<div class="br__form-checkbox--item">
							<input type="checkbox" name="notifyHp" id="devNotifyHp" value="1" checked="true">
							<label for="phone-chk">답변 문자 수신</label>
						</div>
					</div>
				</div>
<?php }?>

				<!-- 반품 / 환불 일 경우 S -->
				<div class="write-form__item write-form__cancel" style="display: none">
					<div class="title-sm">환불 정보</div>
					<div class="br__form-group">
						<label for="" class="hidden">환불 정보</label>
						<input type="text" class="br__form-input" placeholder="예금주" value="" />
						<input type="text" class="br__form-input" placeholder="은행명" value="" />
						<input type="text" class="br__form-input w100" placeholder="계좌번호" value="" />
					</div>
					<div class="txt-list">
						<p class="txt-error">카드로 결제하신 고객님은 카드 승인 취소를 해드리며, 영업일 기준 3일 이내 승인 취소가 확정됩니다.</p>
						<p class="txt-error">카드 승인 취소와 관련하여 자세한 내용을 알고 싶으신 경우 카드사에 직접 연락하시기 바랍니다.</p>
					</div>
				</div>
				<!-- 반품 / 환불 일 경우 E -->

				<!-- 수선 신청 일 경우 S -->
				<div class="write-form__item write-form__repair" style="display: none">
					<div class="title-sm">수선 신청인</div>
					<div class="br__form-item">
						<label for="" class="hidden">신청인</label>
						<input type="text" class="br__form-input" placeholder="이름" value="" />
					</div>
				</div>
				<div class="write-form__item write-form__repair" style="display: none">
					<div class="title-sm">수선 완료 후 받으실 주소</div>
					<div class="br__form-address">
						<div class="br__form-item">
							<label for="devZip" class="inputs__title hide">우편번호</label>
							<input type="text" name="zip" id="devZip" class="inputs__content--zip br__form-input" title="우편번호" placeholder="우편번호" value="04366" readonly />
							<button type="button" class="btn-md btn-dark-line inputs__content--zip-search" id="devZipPopupButton">검색</button>
						</div>
						<div class="br__form-item">
							<label for="devAddress1" class="inputs__title hide">주소</label>
							<input type="text" name="addr1" id="devAddress1" class="br__form-input" title="주소" placeholder="주소" value="서울 용산구 원효로 138" readonly />
						</div>
						<div class="br__form-item">
							<label for="devAddress2" class="inputs__title hide">상세주소</label>
							<input type="text" id="devAddress2" class="br__form-input" name="addr2" title="상세주소" placeholder="상세주소" value="청진빌딩 2층" />
						</div>
					</div>
				</div>
				<!-- 수선 신청 일 경우 E -->

				<div class="write-form__item">
					<div class="br__form-item">
						<label for="" class="hidden">문의 제목</label>
						<input type="text" name="bbsSubject" id="devBbsSubject" class="br__form-input" title="제목" placeholder="제목을 입력해 주세요." value="<?php echo $TPL_VAR["bbs_subject"]?>" />
					</div>
					<div style="margin-top: 8px;" devTailMsg="devBbsSubject"></div>
				</div>
				<div class="write-form__item">
					<div class="title-sm">문의 내용입력</div>
					<div class="br__form-write">
						<textarea class="br__form-textarea" name="bbsContents" id="devBbsContents" title="내용"  onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
						<div class="br__form-textarea--placeholder">
							<div class="title-md">[문의 전 유의사항]</div>
							<div class="txt-list">
								<p>
									상품문의하기에서는 상품 단순 문의만 작성 부탁드립니다.<br />
									급한 배송, 반품 문의는 [마이페이지] 1:1 맞춤 상담 게시판을 이용해 주시면 좀 더 빠른 답변을 받으실 수 있습니다.
								</p>
								<p>주문처리 상태가 ‘배송 대기 / 배송 중’ 상태인 경우 택배 발송된 상태이므로 반품 및 취소를 원하시면 왕복 택배비를 납부 후 반품 및 취소를 받으실 수 있습니다.</p>
								<p>반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="write-form__item">
					<div class="write-form__file">
						<div class="br__form-group">
							<div class="br__form-item">
								<input type="hidden" class="fb__form-file" title="첨부파일">
								<label for="devBbsFile"  id="devBbsFile"  class="btn-lg btn-gray-line">이미지 첨부</label>
							</div>
							<p class="txt-desc">이미지는 최대 4개까지 첨부 가능하며, 이미지당 10MB내로 첨부할 수 있습니다. (JPG, JPEG, PNG만 가능.)</p>
						</div>

						<ul class="br__form-file--list">
							<li class="br__form-file--item" id="devBbs1" style="display:none;">
								<input type="file" name="bbsFile1" id="devBbsFile1" title="첨부파일" style="display:none;">
								<input type="text" class="pub-input-text" id="devBbsFileText1" style="width:500px; border:1px" readonly>
								<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton1" style="display:none;">파일변경</button>
								<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton1" style="display:none;">삭제</button>
							</li>
							<li class="br__form-file--item" id="devBbs2" style="display:none;">
								<input type="file" name="bbsFile2" id="devBbsFile2" title="첨부파일" style="display:none;">
								<input type="text" class="pub-input-text" id="devBbsFileText2" style="width:500px; border:0px" readonly>
								<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton2" style="display:none;">파일변경</button>
								<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton2" style="display:none;">삭제</button>
							</li>
							<li class="br__form-file--item" id="devBbs3" style="display:none;">
								<input type="file" name="bbsFile3" id="devBbsFile3" title="첨부파일" style="display:none;">
								<input type="text" class="pub-input-text" id="devBbsFileText3" style="width:500px; border:0px" readonly>
								<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton3" style="display:none;">파일변경</button>
								<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton3" style="display:none;">삭제</button>
							</li>
							<li class="br__form-file--item" id="devBbs4" style="display:none;">
								<input type="file" name="bbsFile4" id="devBbsFile4" title="첨부파일" style="display:none;">
								<input type="text" class="pub-input-text" id="devBbsFileText4" style="width:500px; border:0px" readonly>
								<button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton4" style="display:none;">파일변경</button>
								<button type="button" class="btn-link btn-del" id="devBbsFileDeleteButton4" style="display:none;">삭제</button>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="write-form__footer">
				<button class="btn-lg btn-dark-line">문의하기</button>
			</div>
		</form>
	</section>
</section>
<!-- 컨텐츠 E -->

<!--
<section class="br__mypage br__join br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">1:1 문의</p>
    </div>

    <form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >
        <input type="hidden" name="url" value="/customer/"/>
        <input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
        <input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
        <input type="hidden" name="focusInfo">
        <input type="hidden" name="isHtml" value='N'>
        <input type='hidden' name='antispamYn' value='N'>
        <input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
<?php if($TPL_VAR["bbsIx"]){?>
        <input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbsIx"]?>'>
<?php }?>

        <div class="br__myInquiry__write">
            <div class="myInquiry__write-lockup">
                <div class="br__join__list">
                    <select name="bbsDiv" id="devBbsDiv" title="분류" >
                        <option value="">선택</option>
                        --<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>--
                        <option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
                        --<?php }}?>--
                    </select>
                    <p class="txt-error mat10" devTailMsg="devBbsDiv"></p>
                </div>

                <div class="br__join__list">
                    <div class="join__id">
                        <input class="join__input" type="text" id="devOid" value="<?php echo $TPL_VAR["oid"]?>" title="주문번호" placeholder="주문번호" readonly />
                        <button type="button" class="join__id__check whitebtn" id="devBtnOrderQuery">조회</button>
                    </div>
                </div>

                <div class="br__join__list">
                    <input class="join__input" type="text" id="devBbsSubject" name="bbsSubject" title="제목" placeholder="제목을 입력해 주세요." value="<?php echo $TPL_VAR["bbs_subject"]?>" />
                    <p class="txt-guide" devTailMsg="devBbsSubject"></p>
                </div>
            </div>

            <div class="br__join__list">
                <div class="join__eamil">
                    <input class="join__input email-id" type="text" name="bbsEmailId" id="bbsEmailId" title="이메일" value="<?php echo $TPL_VAR["emailId"]?>">
                    <span>@</span>
                    <input class="join__input email-info" type="text" name="bbsEmailHost" id="bbsEmailHost" title="이메일" value="<?php echo $TPL_VAR["emailHost"]?>">
                </div>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <select id="devBbsEmailHostSelect">
                    <option value="">이메일 선택</option>
                    <option value="naver.com">naver.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="hotmail.com">hotmail.com</option>
                    <option value="hanmail.net">hanmail.net</option>
                    <option value="daum.net">daum.net</option>
                    <option value="nate.com">nate.com</option>
                    <option value="direct" >직접입력</option>
                </select>
<?php }?>
            </div>
            <div class="myInquiry__write-confirm">
                <p class="write-confirm-tit">답변여부를 메일로 받으시겠습니까?</p>
                <div class="write-confirm-choice">
                    <label for="devNotifyEmail"><input type="radio" name="notifyEmail" value="1" id="devNotifyEmail" value="Y" <?php if($TPL_VAR["is_notice"]=='Y'||empty($TPL_VAR["is_notice"])){?> checked <?php }?>><span>예</span></label>
                    <label><input type="radio" name="notifyEmail" value="0" <?php if($TPL_VAR["is_notice"]=='N'){?> checked <?php }?>><span>아니오</span></label>
                </div>
            </div>



            <div class="myInquiry__write-area textarea">
                <textarea name="bbsContents" id="devBbsContents" title="내용" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
<?php if(empty($TPL_VAR["bbs_contents"])){?>
                <p class="txt-guide" devTailMsg="devBbsContents"></p>
                <div class="myInquiry__write-notice textarea__placeholer devBbsPlaceholder">
                    <p class="write-notice-title textarea__placeholer__title">[문의 전 유의사항]</p>
                    <ul class="write-notice-box textarea__placeholer__list">
                        <li>
                            <div class="write-notice-sub">1.</div>
                            <div class="write-notice-content">
                                주문처리상태가 <strong>""배송준비/배송중”</strong>인 경우 <strong>택배가<br/>발송된 상태</strong>이므로 반품을 원하시면 <strong>왕복 택배비를<br/>배럴 지정 계좌로 입금 또는 환불 금액에서 차감 후 반품이 진행되니 참고부탁드립니다.</strong>
                            </div>
                        </li>
                        <li>
                            <div class="write-notice-sub">2.</div>
                            <div class="write-notice-content">
                                반품 시 배럴 물류센터로 상품을 보내신 후 택배 송장번호를 남겨주시면 더욱 정확하고 빠른 처리를 받으실 수 있습니다.
                            </div>
                        </li>
                        <li>
                            <div class="write-notice-sub">3.</div>
                            <div class="write-notice-content">
                                반품안내<br/><strong>CJ대한통운</strong> (1588-1255) 1번 반품예약 ><br/>운송장 번호 12자리 입력<br/><strong>반품 주소</strong>: 경기도 이천시 호법면 중부대로 798번길 103-40 [배럴물류센터]
                            </div>
                        </li>
                    </ul>
                </div>
<?php }?>
            </div>
<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
            <div class="myInquiry__write-upload">
                <p class="write-upload-title">첨부파일</p>
                <ul class="write-upload-list">
                    <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_1"]!=''){?>
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a></p><!--파일링크 추가 필요-- 
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile1" id="devBbsFileText1" accept="image/*">
                            <span class="write-upload-btn">선택</span>
                        </label>
                        <input type="text" class="write-upload-name" readonly data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>">
                        <button class="write-upload-close" id="devBusinessFileDeleteButton1">파일삭제</button>
                        <div class="upload-img-area" id="devBusinessFileImageWrap1" style="display:none;">
                            <img id="devBusinessFileImage1">
                            <span class="upload-cancel-btn" id="devBusinessFileDeleteButton1"></span>
                        </div>
<?php }?>
                    </li>
                    <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_2"]!=''){?>
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a></p><!--파일링크 추가 필요-- 
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile2" id="devBbsFileText2" accept="image/*">
                            <span class="write-upload-btn">선택</span>
                        </label>
                        <input type="text" class="write-upload-name" data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>">
                        <button class="write-upload-close" id="devBusinessFileDeleteButton2">파일삭제</button>
                        <div class="upload-img-area" id="devBusinessFileImageWrap2" style="display:none;">
                            <img id="devBusinessFileImage2">
                            <span class="upload-cancel-btn" id="devBusinessFileDeleteButton2"></span>
                        </div>
<?php }?>
                    </li>
                    <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_3"]!=''){?>
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a></p><!--파일링크 추가 필요-- 
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile3" id="devBbsFileText3" accept="image/*">
                            <span class="write-upload-btn">선택</span>
                        </label>
                        <input type="text" class="write-upload-name" data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>">
                        <button class="write-upload-close" id="devBusinessFileDeleteButton3">파일삭제</button>
                        <div class="upload-img-area" id="devBusinessFileImageWrap3" style="display:none;">
                            <img id="devBusinessFileImage3">
                            <span class="upload-cancel-btn" id="devBusinessFileDeleteButton3"></span>
                        </div>
<?php }?>
                    </li>
                    <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_4"]!=''){?>
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a></p><!--파일링크 추가 필요-- 
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile4" id="devBbsFileText4" accept="image/*">
                            <span class="write-upload-btn">선택</span>
                        </label>
                        <input type="text" class="write-upload-name" data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>">
                        <button class="write-upload-close" id="devBusinessFileDeleteButton4">파일삭제</button>
                        <div class="upload-img-area" id="devBusinessFileImageWrap4" style="display:none;">
                            <img id="devBusinessFileImage4">
                            <span class="upload-cancel-btn" id="devBusinessFileDeleteButton4"></span>
                        </div>
<?php }?>
                    </li>
                </ul>
            </div>
<?php }?>

            <div class="br__login__info">
                <div class="information__btn">
                    <!--<button class="btn-lg btn-dark-line" id="devBbsRegCancel">취소</button>-- 
                    <button class="information__btn__nomem" id="devBbsRegSubmit">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        1:1 문의하기
<?php }else{?>
                        Submit
<?php }?>
                    </button>
                </div>
            </div>
        </div>

    </form>
</section>

<script>
    var devAppType = '<?php echo $TPL_VAR["layoutCommon"]["appType"]?>';
</script>
-->