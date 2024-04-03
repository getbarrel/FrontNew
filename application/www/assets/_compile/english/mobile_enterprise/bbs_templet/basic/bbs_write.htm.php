<?php /* Template_ 2.2.8 2020/10/27 11:13:58 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_write.htm 000012276 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!--<script>
    $(function(){
     common.util.modal.open('ajax', '주문번호 조회', '/popup/orderList', '');
    });
</script>-->


<section class="br__mypage br__join br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">1:1 Inquiry</p>
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
                    <select name="bbsDiv" id="devBbsDiv" title="Sort" >
                        <option value="">Select</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
                    </select>
                    <p class="txt-error mat10" devTailMsg="devBbsDiv"></p>
                </div>

                <div class="br__join__list">
                    <div class="join__id">
                        <input class="join__input" type="text" id="devOid" value="<?php echo $TPL_VAR["oid"]?>" title="Order No." placeholder="Order No." readonly />
                        <button type="button" class="join__id__check whitebtn" id="devBtnOrderQuery">Search</button>
                    </div>
                </div>

                <div class="br__join__list">
                    <input class="join__input" type="text" id="devBbsSubject" name="bbsSubject" title="Title" placeholder="Please enter title" value="<?php echo $TPL_VAR["bbs_subject"]?>" />
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
                    <option value="">Select Email</option>
                    <option value="naver.com">naver.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="hotmail.com">hotmail.com</option>
                    <option value="hanmail.net">hanmail.net</option>
                    <option value="daum.net">daum.net</option>
                    <option value="nate.com">nate.com</option>
                    <option value="direct" >Direct input.</option>
                </select>
<?php }?>
            </div>
            <div class="myInquiry__write-confirm">
                <p class="write-confirm-tit">Would you like to receive an answer by email?</p>
                <div class="write-confirm-choice">
                    <label for="devNotifyEmail"><input type="radio" name="notifyEmail" value="1" id="devNotifyEmail" value="Y" <?php if($TPL_VAR["is_notice"]=='Y'||empty($TPL_VAR["is_notice"])){?> checked <?php }?>><span>Yes</span></label>
                    <label><input type="radio" name="notifyEmail" value="0" <?php if($TPL_VAR["is_notice"]=='N'){?> checked <?php }?>><span>No</span></label>
                </div>
            </div>



            <div class="myInquiry__write-area textarea">
                <textarea name="bbsContents" id="devBbsContents" title="Content" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
<?php if(empty($TPL_VAR["bbs_contents"])){?>
                <p class="txt-guide" devTailMsg="devBbsContents"></p>
                <div class="myInquiry__write-notice textarea__placeholer devBbsPlaceholder">
                    <p class="write-notice-title textarea__placeholer__title">[Notice]</p>
                    <ul class="write-notice-box textarea__placeholer__list">
                        <li>
                            <div class="write-notice-sub">1.</div>
                            <div class="write-notice-content">
                                When requesting a return due to a simple remorse,<br>please contact the customer center first and  send the product to our logistics center  for a refund.  (You need to send the products  by customer prepaid shipping)
                            </div>
                        </li>
                        <li>
                            <div class="write-notice-sub">2.</div>
                            <div class="write-notice-content">
                                After sending the product  to our logistics center,  please forward the tracking number  to the customer center  for fast process.
                            </div>
                        </li>
                        <li>
                            <div class="write-notice-sub">3.</div>
                            <div class="write-notice-content">
                                Barrel Logistics Center Address :<br/>103-40, Jungbu-daero 798beon-gil,<br/>  Hobeop-myeon, Icheon-si, Gyeonggi-do,  Republic of Korea
                            </div>
                        </li>
                    </ul>
                </div>
<?php }?>
            </div>
<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
            <div class="myInquiry__write-upload">
                <p class="write-upload-title">Attachment</p>
                <ul class="write-upload-list">
                    <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_1"]!=''){?>
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a></p><!--파일링크 추가 필요-->
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile1" id="devBbsFileText1" accept="image/*">
                            <span class="write-upload-btn">Select</span>
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
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a></p><!--파일링크 추가 필요-->
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile2" id="devBbsFileText2" accept="image/*">
                            <span class="write-upload-btn">Select</span>
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
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a></p><!--파일링크 추가 필요-->
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile3" id="devBbsFileText3" accept="image/*">
                            <span class="write-upload-btn">Select</span>
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
                        <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a></p><!--파일링크 추가 필요-->
<?php }else{?>
                        <label class="write-upload-file">
                            <input type="file" name="bbsFile4" id="devBbsFileText4" accept="image/*">
                            <span class="write-upload-btn">Select</span>
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
                    <!--<button class="btn-lg btn-dark-line" id="devBbsRegCancel">취소</button>-->
                    <button class="information__btn__nomem" id="devBbsRegSubmit">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        Write
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