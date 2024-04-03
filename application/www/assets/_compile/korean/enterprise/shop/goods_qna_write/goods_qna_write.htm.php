<?php /* Template_ 2.2.8 2023/07/18 10:20:06 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_qna_write/goods_qna_write.htm 000007549 */ 
$TPL_qnaDivs_1=empty($TPL_VAR["qnaDivs"])||!is_array($TPL_VAR["qnaDivs"])?0:count($TPL_VAR["qnaDivs"]);?>
<div class="wrap-window-popup popup-qna-write">
    <p class="popup-title">
        <span>상품Q&A 작성</span>
        <span class="close" onclick="window.close();"></span>
    </p>

    <form id="devGoodsQnaFrom" class="textarea">
        <input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">
        <input type="hidden" name="bbs_ix" id="" value="<?php echo $TPL_VAR["bbs_ix"]?>">
        <div class="popup-content">
            <p class="desc">상품에 대한 내용을 판매자에게 문의할 수 있습니다.</p>
            <table class="">
                <colgroup>
                    <col width="140px">
                    <col width="*">
                </colgroup>
                <tr>
                    <th><p>문의유형 <em>*</em></p></th>
                    <td>
<?php if($TPL_qnaDivs_1){$TPL_I1=-1;foreach($TPL_VAR["qnaDivs"] as $TPL_V1){$TPL_I1++;?>
                        <span class="radio-area">
                            <input type="radio" name="div" value="<?php echo $TPL_V1["ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["ix"]){?> checked <?php }elseif($TPL_I1== 0){?> checked <?php }?>><label><?php echo $TPL_V1["div_name"]?></label>
                        </span>
<?php }}?>
                    </td>
                </tr>
                <tr>
                    <th><p>제목 <em>*</em></p></th>
                    <td>
                        <input type="text" name="subject" value="<?php echo $TPL_VAR["bbs_subject"]?>" id="devQnaSubject" title="제목" placeholder="문의 제목을 입력해 주세요.">
                    </td>
                </tr>
                <tr>
                    <th><p>이메일 주소 <em>*</em></p></th>
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
                            <span class="textarea__email__agree-confirm">답변여부를 메일로 받으시겠습니까?</span>
                            <input type="radio" name="bbs_email_return" value="1" <?php if($TPL_VAR["bbs_email_return"]== 1){?> checked <?php }?> >
                            <label class="textarea__email__agree-label">예</label>
                            <input type="radio" name="bbs_email_return" value="0" <?php if($TPL_VAR["bbs_email_return"]== 0||$TPL_VAR["bbs_email_return"]==''){?> checked <?php }?>>
                            <label class="textarea__email__agree-label">아니오</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><p>내용 <em>*</em></p></th>
                    <td class="textarea__content">
<?php if($TPL_VAR["bbs_contents"]==''){?>
                        <div class="textarea__placeholer">
                            <p class="textarea__placeholer__title">[문의 유의사항]</p>
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
                    <th><p>비밀글 설정 <em>*</em></p></th>
                    <td>
                        <span style="display:inline-block;margin-right:15px;">비밀글 설정을 하시겠습니까?</span>
                        <span class="radio-area">
                            <input type="radio" name="isHidden" value="1" checked><label>예</label>
                        </span>
                        <span class="radio-area">
                            <input type="radio" name="isHidden" value="0"><label>아니오</label>
                        </span>
                    </td>
                </tr>
            </table>

            <p class="tit">문의 시 유의해 주세요!</p>
            <p class="desc">· 전화번호, 이메일, 배송지 주소, 환불계좌 정보 등 개인정보가 포함된 게시글은 개인정보 도용의 <br>위험이 있으니 비밀글로 문의해 주시기 바랍니다.</p>
            <p class="desc">· 상품과 관계없는 내용, 비방, 욕설, 광고, 도배 등의 게시물은 예고 없이 삭제될 수 있습니다.</p>


            <div class="popup-btn-area">
                <button class="btn-default btn-dark-line" type="button" id="devCancelBtn">취소</button>
                <button class="btn-default btn-point" type="button" id="devSubmitBtn">등록</button>
            </div>
        </div>
    </form>
</div>