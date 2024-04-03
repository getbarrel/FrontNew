<?php /* Template_ 2.2.8 2020/10/27 11:47:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/teacher/bbs_write.htm 000009979 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!--<script>
    $(function(){
     common.util.modal.open('ajax', '주문번호 조회', '/popup/orderList', '');
    });
</script>-->


<section class="br__mypage br__join br__myInquiry br__teacher">
    <div class="apply">
        <div class="br__mypage__pass">
            <p class="pass-title">티처멤버 모집</p>
        </div>

        <form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >
            <input type='hidden' name='isAjaxList'  value ='N' id='isAjaxList'/>
            <input type="hidden" name="url" value="/customer/"/>
            <input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
            <input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
            <input type="hidden" name="focusInfo">
            <input type="hidden" name="isHtml" value='N'>
            <input type='hidden' name='antispamYn' value='N'>
            <input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
<?php if($TPL_VAR["bbs_ix"]){?>
            <input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbs_ix"]?>'>
<?php }?>

            <div class="br__myInquiry__write">
                <div class="myInquiry__write-lockup">
                    <div class="br__join__list">
                        <label class="apply__label">분류</label>
                        <select name="bbsDiv" id="devBbsDiv" title="분류" >
                            <option value="">선택해주세요</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
                        </select>
                        <p class="txt-error mat10" devTailMsg="devBbsDiv"></p>
                    </div>
                    <div class="br__join__list">
                        <label class="apply__label">제목</label>
                        <input class="join__input" type="text" id="devBbsSubject" name="bbsSubject" title="제목" placeholder="제목을 입력해 주세요." value="<?php echo $TPL_VAR["bbs_subject"]?>" />
                        <p class="txt-guide" devTailMsg="devBbsSubject"></p>
                    </div>
                </div>

                <div class="myInquiry__write-area textarea">
                    <textarea name="bbsContents" id="devBbsContents" title="내용" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
<?php if(empty($TPL_VAR["bbs_contents"])){?>
                    <p class="txt-guide" devTailMsg="devBbsContents"></p>
<?php }?>
                </div>
                <div class="br__join__list">
                    <label class="apply__label">UCC</label>
                    <input class="join__input" type="text" id="" name="bbs_etc1" title="UCC" value="<?php echo $TPL_VAR["bbs_etc1"]?>" />
                    <p class="txt-guide" devTailMsg=""></p>
                </div>
<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
                <div class="myInquiry__write-upload">
                    <p class="apply__label">첨부파일</p>
                    <ul class="write-upload-list">
                        <li class="write-upload-box">

                            <label class="write-upload-file">
                                <input type="file" name="bbsFile1" id="devBbsFileText1" accept="image/*">
                                <span class="write-upload-btn">파일선택</span>
                            </label>
                            <input type="text" class="write-upload-name" value="<?php echo $TPL_VAR["bbs_file_1"]?>" data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>" readonly>
                            <button class="write-upload-close" type="button" id="devBbsFileDeleteButton1">파일삭제</button>
                            <div class="upload-img-area" id="devBusinessFileImageWrap1" style="display:none;">
                                <img id="devBusinessFileImage1">
                                <span class="upload-cancel-btn" id="devBbsFileDeleteButton1"></span>
                            </div>

                        </li>
                        <li class="write-upload-box">

                            <label class="write-upload-file">
                                <input type="file" name="bbsFile2" id="devBbsFileText2" accept="image/*">
                                <span class="write-upload-btn">파일선택</span>
                            </label>
                            <input type="text" class="write-upload-name" value="<?php echo $TPL_VAR["bbs_file_2"]?>"  data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>" readonly>
                            <button class="write-upload-close" type="button" id="devBbsFileDeleteButton2">파일삭제</button>
                            <div class="upload-img-area" id="devBusinessFileImageWrap2" style="display:none;">
                                <img id="devBusinessFileImage2">
                                <span class="upload-cancel-btn" id="devBbsFileDeleteButton2"></span>
                            </div>

                        </li>
                        <li class="write-upload-box">

                            <label class="write-upload-file">
                                <input type="file" name="bbsFile3" id="devBbsFileText3" accept="image/*">
                                <span class="write-upload-btn">파일선택</span>
                            </label>
                            <input type="text" class="write-upload-name" value="<?php echo $TPL_VAR["bbs_file_3"]?>"  data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>" readonly>
                            <button class="write-upload-close" type="button" id="devBbsFileDeleteButton3">파일삭제</button>
                            <div class="upload-img-area" id="devBusinessFileImageWrap3" style="display:none;">
                                <img id="devBusinessFileImage3">
                                <span class="upload-cancel-btn" id="devBbsFileDeleteButton3"></span>
                            </div>

                        </li>
<?php if(false){?>
                        <li class="write-upload-box">
<?php if($TPL_VAR["bbs_file_4"]!=''){?>
                            <p class="file">첨부이미지 : <a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a></p><!--파일링크 추가 필요-->
<?php }else{?>
                            <label class="write-upload-file">
                                <input type="file" name="bbsFile4" id="devBbsFileText4" accept="image/*">
                                <span class="write-upload-btn">파일선택</span>
                            </label>
                            <input type="text" class="write-upload-name" data-default="<?php if($TPL_VAR["langType"]=='korean'){?>선택된 파일 없음<?php }else{?>No file selected<?php }?>" readonly>
                            <button class="write-upload-close" type="button" id="devBbsFileDeleteButton4">파일삭제</button>
                            <div class="upload-img-area" id="devBusinessFileImageWrap4" style="display:none;">
                                <img id="devBusinessFileImage4">
                                <span class="upload-cancel-btn" id="devBbsFileDeleteButton4"></span>
                            </div>
<?php }?>
                        </li>
<?php }?>
                    </ul>
                </div>
<?php }?>
                <div class="apply__secret">
                    <p class="apply__label">비밀글 설정</p>
                    <div>
                        <span class="apply__secret__ask">비밀글 설정을 하시겠습니까?</span>
                        <label>
                            <input type="radio" name="isHidden" value="1" checked>
                            <span>예</span>
                        </label>
                        <label>
                            <input type="radio" name="isHidden" value="0" disabled>
                            <span>아니오</span>
                        </label>
                        <p class="apply__secret__desc">
                            - 전화번호, 이메일, 배송지 주소, 환불계좌 정보 등 개인정보가 포함된 게시글은 개인정보 도용의
                            위험이 있으니 비밀글로 문의해 주시기 바랍니다.
                        </p>
                        <p class="apply__secret__desc">
                            - 상품과 관계없는 내용, 비방, 욕설, 광고, 도배 등의 게시물은 예고없이 삭제될 수 있습니다.
                        </p>
                    </div>
                </div>
                <div class="apply__btn">
                    <div class="information__btn">
                        <button type="button" class="apply__btn__cancel btn-lg btn-dark-line" id="devBbsRegCancel">취소</button>
                        <button type="button" class="apply__btn__submit" id="devBbsRegSubmit">등록</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

<script>
    var devAppType = '<?php echo $TPL_VAR["layoutCommon"]["appType"]?>';
</script>