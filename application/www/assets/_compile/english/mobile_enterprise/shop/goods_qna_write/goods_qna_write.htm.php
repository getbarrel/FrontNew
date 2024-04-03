<?php /* Template_ 2.2.8 2021/10/28 15:02:32 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_qna_write/goods_qna_write.htm 000013303 */ 
$TPL_qnaDivs_1=empty($TPL_VAR["qnaDivs"])||!is_array($TPL_VAR["qnaDivs"])?0:count($TPL_VAR["qnaDivs"]);?>
<section class="br__qna-write">
    <div class="br__qna-write__goods">
        <div class="qna-goods">
            <figure class="qna-goods__thumb">
                <img src="<?php echo $TPL_VAR["thumb_src"]?>" alt="<?php echo $TPL_VAR["pname"]?>">
            </figure>
            <div class="qna-goods__info">
                <p class="qna-goods__title"><?php echo $TPL_VAR["pname"]?></p>
                <p class="qna-goods__option"><?php echo $TPL_VAR["add_info"]?></p>
            </div>
        </div>
    </div>
    <form id="devGoodsQnaFrom">
        <input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">
        <input type="hidden" name="bbs_ix" id="" value="<?php echo $TPL_VAR["bbs_ix"]?>">
        <div class="br__qna-write__detail">
            <div class="write-form">
                <div class="write-form__select">
                    <select name="div" id="devQnaDiv" title="문의유형">
                        <option value="">Select</option>
<?php if($TPL_qnaDivs_1){foreach($TPL_VAR["qnaDivs"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["ix"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
                    </select>
                </div>
                <div class="write-form__title">
                    <input type="text" name="subject" value="<?php echo $TPL_VAR["bbs_subject"]?>" id="devQnaSubject" title="Inquiry title" placeholder="Please enter the title of the inquiry.">
                </div>
                <div class="write-form__email">
                    <input type="text" name="emailId" id="devEmailId" title="Email" value="<?php echo $TPL_VAR["emailId"]?>" class="write-form__email--id">
                    <span class="hyphen_2">@</span>
                    <input type="text" name="emailHost" id="devEmailHost" title="email host" value="<?php echo $TPL_VAR["emailHost"]?>" class="write-form__email--host">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <select id="devEmailHostSelect" class="write-form__email--select">
                        <option value="">선택해주세요.</option>
                        <option value="naver.com" <?php if($TPL_VAR["emailHost"]=='naver.com'){?>selected<?php }?>>naver.com</option>
                        <option value="gmail.com" <?php if($TPL_VAR["emailHost"]=='gmail.com'){?>selected<?php }?>>gmail.com</option>
                        <option value="hotmail.com" <?php if($TPL_VAR["emailHost"]=='hotmail.com'){?>selected<?php }?>>hotmail.com</option>
                        <option value="hanmail.net" <?php if($TPL_VAR["emailHost"]=='hanmail.net'){?>selected<?php }?>>hanmail.net</option>
                        <option value="daum.net" <?php if($TPL_VAR["emailHost"]=='daum.net'){?>selected<?php }?>>daum.net</option>
                        <option value="nate.com" <?php if($TPL_VAR["emailHost"]=='nate.com'){?>selected<?php }?>>nate.com</option>
                    </select>
<?php }?>
                </div>
                <div class="write-form__send-email">
                    <p class="write-form__send-email__desc">Would you like to receive an answer by email?</p>
                    <div class="write-form__send-email__radio">
                        <label><input type="radio" name="bbs_email_return" value="1" <?php if($TPL_VAR["bbs_email_return"]== 1){?> checked <?php }?> ><span>Yes</span></label>
                        <label><input type="radio" name="bbs_email_return" value="0" <?php if($TPL_VAR["bbs_email_return"]== 0||$TPL_VAR["bbs_email_return"]==''){?> checked <?php }?>><span>No</span></label>
                    </div>
                </div>
                <div class="write-form__content">
<?php if($TPL_VAR["bbs_contents"]==''){?>
                    <div class="textarea__placeholer">
                        <p class="textarea__placeholer__title">[ Precautions prior to Inquiry ]</p>
                        <ul class="textarea__placeholer__list">
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <li><span>상품 Q&A 게시판은 상품 단순 문의만 해주세요.</span> 급한 배송, 반품 문의는 1:1 맞춤 상담 게시판을 이용해주시면 좀 더 빠른 답변을 받으실 수 있습니다.</li>
                            <li>주문처리 상태가 <span>"배송 대기/배송 중"인 경우 택배 발송된 상태</span>이므로 반품 및 취소를 원하시면 왕복 택배비를 납부 후 반품, 취소 받으실 수 있습니다.</li>
                            <li>반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행 됩니다.<br>고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</li>
<?php }else{?>
                            <li><span>Please, use the product QnA bulletin board only if you would like to simple inquiry about product.</span> If you have any questions about urgent shipping or return, Please use the 1:1 inquiry board.</li>
                            <li><span>If your order status is in "Preparing/Shipped"</span>, your parcel has already been sent, so if you want to return, you need to request return after receiving the product(s).</li>
                            <li>Please send details with the number of shipping invoice to en_help@getbarrel.com for further details on the return process.</li>
<?php }?>
                        </ul>
                    </div>
<?php }?>
                    <textarea name="contents" id="devQnaContents" title="Inquiry"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
                    <!--<div>문의전유의사항</div>-->
                </div>
                <div class="write-form__secret">
                    <p class="write-form__secret__desc">Would you like to proceed as Secret Mode?</p>
                    <div class="write-form__secret__radio">
                        <label><input type="radio" name="isHidden" value="1" checked><span>Yes</span></label>
                        <label><input type="radio" name="isHidden" value="0"><span>No</span></label>
                    </div>
                </div>
                <ul class="write-form__notice">
                    <li class="write-form__notice__desc">- For postings containing personal information such as phone number, e-mail, shipping address, and refund account information, please contact us in secret because there is a risk of personal information theft.</li>

                    <li class="write-form__notice__desc">- Posts that are not related to the product, slander, abuse, advertising, and plagiarism may be deleted without notice.</li>
                </ul>
                <div class="write-form__submit">
                    <button class="write-form__submit__btn" id="devSubmitBtn">Submit</button>
                </div>
            </div>
        </div>
    </form>
</section>
<script>

//    const $placeholder = $('.textarea__placeholer');
////    console.log($placeholder)
////    if($placeholder < 1) return ;
//
//    $placeholder.siblings('textarea')
//        .on('focusin', function() {
//            $placeholder.hide();
//        })
//        .on('focusout', function() {
//            if($(this).val().length < 1) {
//                $placeholder.show();
//            }
//        });

//    (function(w, d) {
//        const placeholerEle = d.querySelector('.br__qna-write__detail .textarea__placeholer');
//        const placeholerStyle = placeholerEle.style;
//        const qnaTextAreaEle = d.querySelector('.br__qna-write__detail #devQnaContents');
//
//        console.log('qnaTextAreaEle: ', qnaTextAreaEle);
//
//        qnaTextAreaEle.addEventListener('focus', function() {
//            placeholerStyle.display = 'none';
//        });
//
//        qnaTextAreaEle.addEventListener('blur', function() {
//            if(!this.value.length) placeholerStyle.display = 'block';
//        });
//
//        console.log('placeholerEle: ', placeholerEle);
//    }(window, document))
</script>

<!--<div class="wrap-goods-qna" style="display:none;">-->
    <!--<form id="devGoodsQnaFrom">-->
        <!--<input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">-->
        <!--<div class="wrap-input-form">-->
            <!--<section>-->
                <!--<dl>-->
                    <!--<dt>문의유형 <em>*</em></dt>-->
                    <!--<dd>-->
                        <!--<select name="div" id="devQnaDiv" title="문의유형">-->
                            <!--<option value="">선택</option>-->
<?php if($TPL_qnaDivs_1){foreach($TPL_VAR["qnaDivs"] as $TPL_V1){?>
                            <!--<option value="<?php echo $TPL_V1["ix"]?>"><?php echo $TPL_V1["div_name"]?></option>-->
<?php }}?>
                        <!--</select>-->
                    <!--</dd>-->
                <!--</dl>-->
                <!--<dl>-->
                    <!--<dt>문의 작성 <em>*</em></dt>-->
                    <!--<dd>-->
                        <!--<input type="text" name="subject" id="devQnaSubject" title="문의 제목" placeholder="문의 제목을 입력해 주세요.">-->
                        <!--<textarea name="contents" id="devQnaContents" title="문의 내용" placeholder="문의 내용을 입력해 주세요."></textarea>-->
                    <!--</dd>-->
                <!--</dl>-->
                <!--<dl>-->
                    <!--<dt>답변수신 이메일</dt>-->
                    <!--<dd>-->
                        <!--<div class="wrap-multi-input">-->
                            <!--<input type="text" name="emailId" id="devEmailId" title="이메일" style="width:280px;" value="<?php echo $TPL_VAR["emailId"]?>">-->
                            <!--<span class="hyphen_2">@</span>-->
                            <!--<input type="text" name="emailHost" id="devEmailHost" title="이메일호스트" style="display:none; width:270px;" value="<?php echo $TPL_VAR["emailHost"]?>">-->
                            <!--<select id="devEmailHostSelect" style="width:270px;">-->
                                <!--<option value="">선택해주세요.</option>-->
                                <!--<option value="naver.com" <?php if($TPL_VAR["emailHost"]=='naver.com'){?>selected<?php }?>>naver.com</option>-->
                                <!--<option value="gmail.com" <?php if($TPL_VAR["emailHost"]=='gmail.com'){?>selected<?php }?>>gmail.com</option>-->
                                <!--<option value="hotmail.com" <?php if($TPL_VAR["emailHost"]=='hotmail.com'){?>selected<?php }?>>hotmail.com</option>-->
                                <!--<option value="hanmail.net" <?php if($TPL_VAR["emailHost"]=='hanmail.net'){?>selected<?php }?>>hanmail.net</option>-->
                                <!--<option value="daum.net" <?php if($TPL_VAR["emailHost"]=='daum.net'){?>selected<?php }?>>daum.net</option>-->
                                <!--<option value="nate.com" <?php if($TPL_VAR["emailHost"]=='nate.com'){?>selected<?php }?>>nate.com</option>-->
                            <!--</select>-->
                        <!--</div>-->
                        <!--<div class="mat20">-->
                            <!--<input type="checkbox" id="devDirectInputEmailCheckBox">-->
                            <!--<label for="devDirectInputEmailCheckBox">메일 도메인을 직접 입력하겠습니다.</label>-->
                        <!--</div>-->
                        <!--<p class="mat10">상품문의 답변 완료 시 등록된 이메일 주소로 알려드립니다.</p>-->
                    <!--</dd>-->
                <!--</dl>-->
            <!--</section>-->

            <!--<section class="wrap-desc">-->
                <!--<h2>문의 시 유의해 주세요!</h2>-->
                <!--<p>전화번호, 이메일, 배송지 주소, 환불계좌 정보 등 개인정보가 포함된 게시글은 개인정보 도용의 위험이 있으니 비밀글로 문의해 주시기 바랍니다.</p>-->
                <!--<p>상품과 관계없는 내용, 비방, 욕설, 광고, 도배 등의 게시물은 예고없이	삭제될 수 있습니다.</p>-->
                <!--<input type="checkbox" name="isHidden" value="1"><label>비공개 문의</label>-->

                <!--<div class="wrap-btn-area mat60">-->
                    <!--<button class="btn-lg btn-dark-line" type="button" id="devCancelBtn">취소</button>-->
                    <!--<button class="btn-lg btn-point" type="button" id="devSubmitBtn">등록</button>-->
                <!--</div>-->
            <!--</section>-->
        <!--</div>-->
    <!--</form>-->
<!--</div>-->

<!-- 페이지 -> layer 변경시 로드 -->

<!--<strong>Delivery preparation/transportation of orders is in progress<br/>, </strong>Delivery has been sent], so if you want to cancel/change the cost of the queen's clothes after payment/exchange<br/>-->