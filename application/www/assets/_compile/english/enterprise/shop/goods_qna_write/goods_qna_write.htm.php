<?php /* Template_ 2.2.8 2021/10/28 15:01:59 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_qna_write/goods_qna_write.htm 000007498 */ 
$TPL_qnaDivs_1=empty($TPL_VAR["qnaDivs"])||!is_array($TPL_VAR["qnaDivs"])?0:count($TPL_VAR["qnaDivs"]);?>
<div class="wrap-window-popup popup-qna-write">
    <p class="popup-title">
        <span>Write</span>
        <span class="close" onclick="window.close();"></span>
    </p>

    <form id="devGoodsQnaFrom" class="textarea">
        <input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">
        <input type="hidden" name="bbs_ix" id="" value="<?php echo $TPL_VAR["bbs_ix"]?>">
        <div class="popup-content">
            <p class="desc">You can contact the seller about the product.</p>
            <table class="">
                <colgroup>
                    <col width="140px">
                    <col width="*">
                </colgroup>
                <tr>
                    <th><p>Inquiry Type <em>*</em></p></th>
                    <td>
<?php if($TPL_qnaDivs_1){$TPL_I1=-1;foreach($TPL_VAR["qnaDivs"] as $TPL_V1){$TPL_I1++;?>
                        <span class="radio-area">
                            <input type="radio" name="div" value="<?php echo $TPL_V1["ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["ix"]){?> checked <?php }elseif($TPL_I1== 0){?> checked <?php }?>><label><?php echo $TPL_V1["div_name"]?></label>
                        </span>
<?php }}?>
                    </td>
                </tr>
                <tr>
                    <th><p>Title <em>*</em></p></th>
                    <td>
                        <input type="text" name="subject" value="<?php echo $TPL_VAR["bbs_subject"]?>" id="devQnaSubject" title="제목" placeholder="Please enter the title of the inquiry.">
                    </td>
                </tr>
                <tr>
                    <th><p>Email <em>*</em></p></th>
                    <td class="textarea__email">
                        <div class="textarea__email__input">
                            <input type="text" name="emailId" id="devEmailId" title="이메일" value="<?php echo $TPL_VAR["emailId"]?>">
                            <span class="textarea__email__between">@</span>
                            <input class="js__email__selected" type="text" name="emailHost" id="devEmailHost" title="이메일" value="<?php echo $TPL_VAR["emailHost"]?>">
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <select class="js__email__select" id="devEmailHostSelect">
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
                        <div class="textarea__email__agree">
                            <span class="textarea__email__agree-confirm">Would you like to receive an answer by email?</span>
                            <input type="radio" name="bbs_email_return" value="1" <?php if($TPL_VAR["bbs_email_return"]== 1){?> checked <?php }?> >
                            <label class="textarea__email__agree-label">Yes</label>
                            <input type="radio" name="bbs_email_return" value="0" <?php if($TPL_VAR["bbs_email_return"]== 0||$TPL_VAR["bbs_email_return"]==''){?> checked <?php }?>>
                            <label class="textarea__email__agree-label">No</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><p>Content <em>*</em></p></th>
                    <td class="textarea__content">
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
                        <textarea name="contents" id="devQnaContents" title="내용"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><p>Secret Mode <em>*</em></p></th>
                    <td>
                        <span style="display:inline-block;margin-right:15px;">Would you like to proceed as Secret Mode?</span>
                        <span class="radio-area">
                            <input type="radio" name="isHidden" value="1" checked><label>Yes</label>
                        </span>
                        <span class="radio-area">
                            <input type="radio" name="isHidden" value="0"><label>No</label>
                        </span>
                    </td>
                </tr>
            </table>

            <p class="tit">Please be careful when inquiring!</p>
            <p class="desc">· For postings containing personal information such as phone number, e-mail, shipping address, and refund account information, please contact us in secret because there is a risk of personal information theft.</p>
            <p class="desc">· Posts that are not related to the product, slander, abuse, advertising, and plagiarism may be deleted without notice.</p>


            <div class="popup-btn-area">
                <button class="btn-default btn-dark-line" type="button" id="devCancelBtn">Cancel</button>
                <button class="btn-default btn-point" type="button" id="devSubmitBtn">Submit</button>
            </div>
        </div>
    </form>
</div>